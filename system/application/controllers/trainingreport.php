<?php
include_once "base.php"; 

class TrainingReport extends Base{
	var $sess;
	var $lang;
	var $modules;
	var $participants;
	var $accessed;

	function TrainingReport()
	{
		//parent::Controller();	
		parent::Base();	
			
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("usermodel");
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
		$this->load->model("trainingmodel");
		$this->load->model("levelmodel");
		
		$this->load->model("logmodel");
		
		$this->load->database();	
		$this->lang = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->lang ? $this->lang : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->lang);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));	

			$sess = unserialize($usess);			
			$this->modules = $this->commonmodel->getRight($sess['user_type']);					
			
			if ($sess['asadmin'] != 1)
			{
				redirect(base_url());
			}
		}	
		else
		{
			redirect(base_url());
		}	
		$this->langmodel->init();
		
	}
	
	function index($pageid)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "training_code";
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$isexport = isset($_POST['isexport']) ? $_POST['isexport'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : -1;
		
		//language
		$ltraining_code		= $this->config->item("ltraining_code");
		$lcertificate_code	= $this->config->item("lcertificate_code");
		$ltraining_name		= $this->config->item("ltraining_name");
		$lcertificate_name	= $this->config->item("lcertificate_name");
		
		$lpraexam_participant_accessed				= $this->config->item("lpraexam_participant_accessed");
		$lpraexam_participant_accessed_percent		= $this->config->item("lpraexam_participant_accessed_percent");
		$lpraexam_participant_not_accessed_percent	= $this->config->item("lpraexam_participant_not_accessed_percent");
		
		$lmaterial_participant_accessed				= $this->config->item("lmaterial_participant_accessed");
		$lmaterial_participant_accessed_percent		= $this->config->item("lmaterial_participant_accessed_percent");
		$lmaterial_participant_not_accessed_percent	= $this->config->item("lmaterial_participant_not_accessed_percent");
		
		$lexam_participant_accessed					= $this->config->item("lexam_participant_accessed");
		$lexam_participant_accessed_percent			= $this->config->item("lexam_participant_accessed_percent");
		$lexam_participant_not_accessed_percent		= $this->config->item("lexam_participant_not_accessed_percent");
		
		$lcertification_participant_accessed		= $this->config->item("lcertification_participant_accessed");
		$lcertification_participant_accessed_percent= $this->config->item("lcertification_participant_accessed_percent");
		$lcertification_participant_not_accessed	= $this->config->item("lcertification_participant_not_accessed");
		$lcertification_participant_not_accessed_percent = $this->config->item("lcertification_participant_not_accessed_percent");
		

		switch($pageid)
		{
			case "certificate":
				$type = 2;
			break;
			default:
				$type = 1;
		}
				
		if ($limit && (! $isexport))
		{
			$this->db->limit($limit, $offset);
		}
			
		if ($searchby)
		{
			$where = sprintf("%s LIKE '%%%s%%'", $searchby, addslashes($keyword));
			$this->db->where($where, null);
		}

		$this->db->where("training_type", $type);
		$this->db->join("category", "training_topic = category_id");
		$this->db->order_by($sortby, $orderby);		
		$q = $this->db->get("training");
		
		$rows = $q->result();
		$trainingids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$trainingids[] = $rows[$i]->training_id;
		}
		
		$candidates = $this->trainingmodel->GetCandidateNPK($trainingids);
		$arrparticipants = $this->trainingmodel->GetCandidateUserIds($trainingids);
		
		$this->db->distinct();
		$this->db->select("history_exam_training, history_exam_type, history_exam_user, history_exam_status");		
		$this->db->where_in("history_exam_training", $trainingids);
		$this->db->where("history_exam_reset", 0);		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);		
		$this->db->where("user_status", 1);	//user active only
		$this->db->join("user", "user_id = history_exam_user");
		
		$q = $this->db->get("history_exam");
		
		$rowsexam = $q->result();
		for($i=0; $i < count($rowsexam); $i++)
		{
			if (! isset($arrparticipants[$rowsexam[$i]->history_exam_training])) continue;
			
			$participants = array_keys($arrparticipants[$rowsexam[$i]->history_exam_training]);
			if (! in_array($rowsexam[$i]->history_exam_user, $participants)) continue;
			
			if ($rowsexam[$i]->history_exam_type == 1)
			{
				if ($rowsexam[$i]->history_exam_status == 1)
				{
					$praexamslulus[$rowsexam[$i]->history_exam_training][] = $rowsexam[$i]->history_exam_user;
				}
				
				$praexamsall[$rowsexam[$i]->history_exam_training][] = $rowsexam[$i]->history_exam_user;
				continue;
			}
			
			if ($rowsexam[$i]->history_exam_type == 0)
			{
				$materials[$rowsexam[$i]->history_exam_training][] = $rowsexam[$i]->history_exam_user;
				continue;
			}			

			if (($rowsexam[$i]->history_exam_type == 3) || ($rowsexam[$i]->history_exam_type == 2))
			{
				
				if ($rowsexam[$i]->history_exam_status == 1)
				{
					$examslulus[$rowsexam[$i]->history_exam_training][] = $rowsexam[$i]->history_exam_user;
				}
				$examsall[$rowsexam[$i]->history_exam_training][] = $rowsexam[$i]->history_exam_user;
				
				continue;
			}
		}
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->npraexamall = isset($praexamsall[$rows[$i]->training_id]) ? count(array_unique($praexamsall[$rows[$i]->training_id])) : 0;
			$rows[$i]->npraexamlulus = isset($praexamslulus[$rows[$i]->training_id]) ? count(array_unique($praexamslulus[$rows[$i]->training_id])) : 0;
			$rows[$i]->npraexamnolulus = $rows[$i]->npraexamall - $rows[$i]->npraexamlulus;			

			switch($status)
			{
				case "-1":
					$rows[$i]->npraexam = $rows[$i]->npraexamall;
				break;
				case "1":
					$rows[$i]->npraexam = $rows[$i]->npraexamlulus;
				break;
				case "0":
					$rows[$i]->npraexam = $rows[$i]->npraexamnolulus;
				break;
			}
			
			$rows[$i]->pctpraexam = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format($rows[$i]->npraexam*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
			$rows[$i]->pctnopraexam = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format(($candidates[$rows[$i]->training_id]-$rows[$i]->npraexam)*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
			
			$rows[$i]->nmaterial = isset($materials[$rows[$i]->training_id]) ? count(array_unique($materials[$rows[$i]->training_id])) : 0;
			$rows[$i]->pctmaterial = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format($rows[$i]->nmaterial*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
			$rows[$i]->pctnomaterial = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format(($candidates[$rows[$i]->training_id]-$rows[$i]->nmaterial)*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
			//echo $rows[$i]->training_id.";".$rows[$i]->training_name."=>".$candidates[$rows[$i]->training_id]."<BR>";	
			$rows[$i]->nexamall = isset($examsall[$rows[$i]->training_id]) ? count(array_unique($examsall[$rows[$i]->training_id])) : 0;
			$rows[$i]->nexamlulus = isset($examslulus[$rows[$i]->training_id]) ? count(array_unique($examslulus[$rows[$i]->training_id])) : 0;
			$rows[$i]->nexamnolulus = $rows[$i]->nexamall - $rows[$i]->nexamlulus;			
			
			switch($status)
			{
				case "-1":
					$rows[$i]->nexam = $rows[$i]->nexamall;
				break;
				case "1":
					$rows[$i]->nexam = $rows[$i]->nexamlulus;
				break;
				case "0":
					$rows[$i]->nexam = $rows[$i]->nexamnolulus;
				break;
			}
			
			$rows[$i]->nnoexam = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format($candidates[$rows[$i]->training_id]-$rows[$i]->nexam, 0) : "0";
			$rows[$i]->pctexam = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format($rows[$i]->nexam*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
			$rows[$i]->pctnoexam = (isset($candidates[$rows[$i]->training_id]) && ($candidates[$rows[$i]->training_id] > 0)) ? number_format($rows[$i]->nnoexam*100/$candidates[$rows[$i]->training_id], 2) : "0.00";
		}
		
		if ($isexport)
		{
		    /*
			$this->load->library("xlswriter");
			if ($pageid == "training")
			{
				$this->xlswriter->send("trainingreport.xls");
			}
			else
			{
				$this->xlswriter->send("certificationreport.xls");
			}			
			
			$worksheet =& $this->xlswriter->addWorksheet("participants");

			$worksheet->write(0, 0, ($pageid == "training") ? $ltraining_code : $lcertificate_code);
			$worksheet->write(0, 1, ($pageid == "training") ? $ltraining_name : $lcertificate_name);
			
			if ($pageid == "training")
			{
				$worksheet->write(0, 2, $lpraexam_participant_accessed);
				$worksheet->write(0, 3, $lpraexam_participant_accessed_percent);
				$worksheet->write(0, 4, $lpraexam_participant_not_accessed_percent);
				$worksheet->write(0, 5, $lmaterial_participant_accessed);
				$worksheet->write(0, 6, $lmaterial_participant_accessed_percent);
				$worksheet->write(0, 7, $lmaterial_participant_not_accessed_percent);
				$worksheet->write(0, 8, $lexam_participant_accessed);
				$worksheet->write(0, 9, $lexam_participant_accessed_percent);
				$worksheet->write(0, 10, $lexam_participant_not_accessed_percent);
			}
			else
			{
				$worksheet->write(0, 2, $lcertification_participant_accessed);
				$worksheet->write(0, 3, $lcertification_participant_accessed_percent);
				$worksheet->write(0, 4, $lcertification_participant_not_accessed);
				$worksheet->write(0, 5, $lcertification_participant_not_accessed_percent);
			}
			
			for($i=0; $i < count($rows); $i++)
			{
				$worksheet->write($i+1, 0, $rows[$i]->training_code);
				$worksheet->write($i+1, 1, $rows[$i]->training_name);
				
				if ($pageid == "training")
				{
					$worksheet->write($i+1, 2, $rows[$i]->npraexam);
					$worksheet->write($i+1, 3, $rows[$i]->pctpraexam);
					$worksheet->write($i+1, 4, $rows[$i]->pctnopraexam);
					$worksheet->write($i+1, 5, $rows[$i]->nmaterial);
					$worksheet->write($i+1, 6, $rows[$i]->pctmaterial);
					$worksheet->write($i+1, 7, $rows[$i]->pctnomaterial);
					$worksheet->write($i+1, 8, $rows[$i]->nexam);
					$worksheet->write($i+1, 9, $rows[$i]->pctexam);
					$worksheet->write($i+1, 10, $rows[$i]->pctnoexam);				
				}
				else
				{
					$worksheet->write($i+1, 2, $rows[$i]->nexam);
					$worksheet->write($i+1, 3, $rows[$i]->pctexam);
					$worksheet->write($i+1, 4, $rows[$i]->nnoexam);
					$worksheet->write($i+1, 5, $rows[$i]->pctnoexam);				
				}
			}
			
			$this->xlswriter->close();
			
			return;
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,  ($pageid == "training") ? $ltraining_code : $lcertificate_code);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, ($pageid == "training") ? $ltraining_name : $lcertificate_name);

            if ($pageid == "training")
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, $lpraexam_participant_accessed);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, $lpraexam_participant_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, $lpraexam_participant_not_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, $lmaterial_participant_accessed);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, $lmaterial_participant_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, $lmaterial_participant_not_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, $lexam_participant_accessed);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, $lexam_participant_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, $lexam_participant_not_accessed_percent);
            }
            else
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, $lcertification_participant_accessed);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, $lcertification_participant_accessed_percent);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, $lcertification_participant_not_accessed);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, $lcertification_participant_not_accessed_percent);
            }

            for($i=0; $i < count($rows); $i++)
            {
                $row = $i + 2;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $rows[$i]->training_code);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $rows[$i]->training_name);

                if ($pageid == "training")
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $rows[$i]->npraexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $rows[$i]->pctpraexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rows[$i]->pctnopraexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rows[$i]->nmaterial);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $rows[$i]->pctmaterial);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $rows[$i]->pctnomaterial);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $rows[$i]->nexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $rows[$i]->pctexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $rows[$i]->pctnoexam);
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $rows[$i]->nexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $rows[$i]->pctexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rows[$i]->nnoexam);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rows[$i]->pctnoexam);
                }
            }

            $objPHPExcel->setActiveSheetIndex(0);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            // Sending headers to force the user to download the file
            if ($pageid == "training")
            {
                $fileName = "trainingreport.xls";
            }
            else
            {
                $fileName = "certificationreport.xls";
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');

            $objWriter->save('php://output');
		}
		
		$this->mysmarty->assign("rows", $rows);
		
		if ($searchby)
		{
			$where = sprintf("%s LIKE '%%%s%%'", $searchby, addslashes($keyword));
			$this->db->where($where, null);
		}		
		$this->db->where("training_type", $type);
		$total = $this->db->count_all_results("training");
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
		$config['next_link'] = '<img src="'.base_url().'/images/16/blue_next.gif" alt="next" width="16" height="16" border="0" />';
		$config['next_tag_open'] = "<td>";
		$config['next_tag_close'] = "</td>";

		$config['prev_link'] = '<img src="'.base_url().'/images/16/blue_back.gif" alt="prev" width="16" height="16" border="0" />';
		$config['prev_tag_open'] = "<td>";
		$config['prev_tag_close'] = "</td>";

		$config['first_link'] = '<img src="'.base_url().'/images/16/blue_first.gif" alt="prev" width="16" height="16" border="0" />';		
		$config['last_link'] = '<img src="'.base_url().'/images/16/blue_last.gif" alt="prev" width="16" height="16" border="0" />';

		$limits = array(10=>10, 20=>20, 50=>50);
		if (! in_array($recordperpage, $limits)) 
		{
			$limits[$recordperpage] = $recordperpage;
			ksort($limits);
		} 
		$limits[0] = 'all';
		
		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('unit');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = !empty($list) ? count($list) : 0;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("ltraining", $this->config->item("ltraining"));
		$this->mysmarty->assign("lcertificate", $this->config->item("lcertificate"));
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("header_list_topic", $this->config->item("header_list_topic"));
		$this->mysmarty->assign("learning_topics_list", $this->config->item("learning_topics_list"));
		$this->mysmarty->assign("pageid", $pageid);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("searchby", $searchby);
		$this->mysmarty->assign("keyword", $keyword);
		$this->mysmarty->assign("status", $status);
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lall", $this->config->item("lall"));
		$this->mysmarty->assign("llulus", $this->config->item("llulus"));
		$this->mysmarty->assign("lnolulus", $this->config->item("lnolulus"));
		
		$this->mysmarty->assign("ltraining_code", $this->config->item("ltraining_code"));
		$this->mysmarty->assign("lcertificate_code", $this->config->item("lcertificate_code"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("ltraining_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("lcertificate_name"));
		
		$this->mysmarty->assign("lpraexam_participant_accessed", $this->config->item("lpraexam_participant_accessed"));
		$this->mysmarty->assign("lpraexam_participant_accessed_percent", $this->config->item("lpraexam_participant_accessed_percent"));
		$this->mysmarty->assign("lpraexam_participant_not_accessed_percent", $this->config->item("lpraexam_participant_not_accessed_percent"));
		$this->mysmarty->assign("lmaterial_participant_accessed", $this->config->item("lmaterial_participant_accessed"));
		$this->mysmarty->assign("lmaterial_participant_accessed_percent", $this->config->item("lmaterial_participant_accessed_percent"));
		$this->mysmarty->assign("lmaterial_participant_not_accessed_percent", $this->config->item("lmaterial_participant_not_accessed_percent"));
		$this->mysmarty->assign("lexam_participant_accessed",$this->config->item("lexam_participant_accessed"));
		$this->mysmarty->assign("lexam_participant_accessed_percent",$this->config->item("lexam_participant_accessed_percent"));
		$this->mysmarty->assign("lexam_participant_not_accessed_percent",$this->config->item("lexam_participant_not_accessed_percent"));
		
		$this->mysmarty->assign("lcertification_participant_accessed",$this->config->item("lcertification_participant_accessed"));
		$this->mysmarty->assign("lcertification_participant_accessed_percent",$this->config->item("lcertification_participant_accessed_percent"));
		$this->mysmarty->assign("lcertification_participant_not_accessed",$this->config->item("lcertification_participant_not_accessed"));
		$this->mysmarty->assign("lcertification_participant_not_accessed_percent",$this->config->item("lcertification_participant_not_accessed_percent"));
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "trainingreport/list.html");
		$this->mysmarty->display("sess_template.html");
		
	}
	
	function material($id, $pageid)
	{
		$this->mysmarty->assign("subpageex", "material");
		
		$this->detail($id, $pageid, array(0), -1);
	}

	function praexam($id, $pageid, $status=-1)
	{
		$this->mysmarty->assign("subpageex", "praexam");
		
		$this->detail($id, $pageid, array(1), $status);
	}

	function exam($id, $pageid, $status=-1)
	{
		$this->mysmarty->assign("subpageex", "exam");
		
		$this->detail($id, $pageid, array(2,3), $status);
	}
	
	function detail($id, $pageid, $type, $status)
	{		
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$isexport = isset($_POST['isexport']) ? $_POST['isexport'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : -1;
		$status1 = isset($_POST['status1']) ? $_POST['status1'] : 0;
		
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$arrparticipants = $this->trainingmodel->GetCandidateUserIds(array($id));

		if (isset($arrparticipants[$id]))
		{
			$participants = array_keys($arrparticipants[$id]);
		}
		
		if ($status == 0)
		{
			$this->db->distinct();
			
			$this->db->select("history_exam_user");
			$this->db->where("history_exam_reset", 0);		
			$this->db->where("history_exam_date >", 0);
			$this->db->where("history_exam_time >", 0);		
			$this->db->where("history_exam_training", $row->training_id);
			$this->db->where("history_exam_status", 1);
			$this->db->where_in("history_exam_type", $type);
			
			$this->db->join("user", "user_id = history_exam_user");	
			$this->db->where("user_status", 1);	//user active only	
	
			$q = $this->db->get("history_exam");
			
			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				$userids[] = $rows[$i]->history_exam_user;
			}
		}

		/*if ($limit && (! $isexport))
		{
			$this->db->limit($limit, $offset);
		}*/
		
		if ($sortby == "user_name")
		{
			$this->db->order_by(sprintf("user_first_name %s, user_last_name %s", $orderby, $orderby));
		}
		else
		{			
			$this->db->order_by($sortby, $orderby);
		}
		
		if ($searchby)
		{
			switch($searchby)
			{
				case "user_name":
				$where = sprintf("(user_first_name LIKE '%%%s%%' OR user_last_name LIKE '%%%s%%')", addslashes($keyword), addslashes($keyword));
				break;
				default:
					$where = sprintf("%s LIKE '%%%s%%'", $searchby, addslashes($keyword));

			}
			$this->db->where($where, null);
		}
		
		if ($status != -1)
		{
			$this->db->where("history_exam_status", $status);
		}		
		if (isset($userids))
		{
			$this->db->where_not_in("history_exam_user", $userids);
		}

		if (isset($participants))
		{
			$this->db->where_in("user_id", $participants);
		}
		if ($status != -1)
		{
			$this->db->where("history_exam_status", $status);		
		}
		$this->db->where("history_exam_reset", 0);		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);		
		$this->db->where_in("history_exam_type", $type);
		$this->db->where("history_exam_training", $row->training_id);
		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("user", "user_id = history_exam_user");
		$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$this->db->join("level_group", "level_group_id = jabatan_level_group", "left outer");
		$this->db->where("user_status", 1);	//user active only
		$q = $this->db->get("history_exam");
		
		$rows1 = $q->result();
		$rows = array();
		for($i=0; $i < count($rows1); $i++)
		{
			switch($status1)
			{
				case 1:
					if (! isset($maxscores[$rows1[$i]->user_id]))
					{
						$filters[$rows1[$i]->user_id] = array($rows1[$i]->history_exam_score, $i);
					}
					else
					if ($filters[$rows1[$i]->user_id][0] > $rows1[$i]->history_exam_score)
					{
						$filters[$rows1[$i]->user_id] = array($rows1[$i]->history_exam_score, $i);
					}
				break;
				case 2:
					if (! isset($maxscores[$rows1[$i]->user_id]))
					{
						$filters[$rows1[$i]->user_id] = array($rows1[$i]->history_exam_date, $i);
					}
					else
					if ($filters[$rows1[$i]->user_id][0] > $rows1[$i]->history_exam_date)
					{
						$filters[$rows1[$i]->user_id] = array($rows1[$i]->history_exam_date, $i);
					}
				break;
				default:
					$rows[] = $rows1[$i];				
			}
		}
		
		if (isset($filters))
		{
			foreach($filters as $val)
			{
				$rows[] = $rows1[$val[1]];
			}
		}
		
		$total = count($rows);		
		
		if(!$isexport)
			$rows = array_splice($rows, $offset, $limit);
		
		for($i=0; $i < count($rows); $i++)
		{
			$t1 = dbintmaketime($rows[$i]->history_exam_startdate, $rows[$i]->history_exam_starttime);
			$t2 = dbintmaketime($rows[$i]->history_exam_date, $rows[$i]->history_exam_time);
			
			$dt = $t2-$t1;
			
			$rows[$i]->history_exam_date_fmt = inttodate($rows[$i]->history_exam_date);
			$rows[$i]->duration = formattime($dt);
			
			switch($rows[$i]->history_exam_type)
			{
				case 0:
					$rows[$i]->history_exam_status_str = $this->config->item("ltaken");
				break;
				case 1:
					$rows[$i]->history_exam_status_str = $this->config->item("lcompeted");
				break;
				default:
					$rows[$i]->history_exam_status_str = $rows[$i]->history_exam_status ? $this->config->item("llulus") : $this->config->item("lnolulus");
				break;
			}
		}
		
		$levels = array();
		$this->levelmodel->getalllevels(0, $levels);
		$nlevel = count($levels);
		
		if ($isexport)
		{			
			$this->load->library("xlswriter");
			if ($pageid == "training")
			{
					$this->xlswriter->send("trainingreport_".$row->training_code.".xls");
			}
			else
			{
				$this->xlswriter->send("certificationreport_".$row->training_code.".xls");
			}
			
			
			$worksheet =& $this->xlswriter->addWorksheet("participants");
			
			if ($pageid == "training"){
				$worksheet->write(0, 0, $this->config->item("ltraining_code"));
				$worksheet->write(0, 1, $this->config->item("ltraining_name"));
			}
			else{
				$worksheet->write(0, 0, $this->config->item("lcertificate_code"));
				$worksheet->write(0, 1, $this->config->item("certificate_name"));
			}
				
			
			$worksheet->write(0, 2, $this->config->item("lnpk"));
			$worksheet->write(0, 3, $this->config->item("name"));
			for($i=0; $i < $nlevel; $i++)
			{
				$worksheet->write(0, 4+$i, $levels[$i]->level_name);
			}
			
			$worksheet->write(0, 4+$nlevel, $this->config->item("location"));
			$worksheet->write(0, 5+$nlevel, $this->config->item("city"));
			          
			if (in_array(0, $type))
			{
					$worksheet->write(0, 6+$nlevel, "Material Value");
					$worksheet->write(0, 7+$nlevel, "Material Status");
					$worksheet->write(0, 8+$nlevel, "Material Date");
					$worksheet->write(0, 9+$nlevel, "Duration");
			}
			else
			if (in_array(1, $type))
			{
					$worksheet->write(0, 6+$nlevel, "Preexam Value");
					$worksheet->write(0, 7+$nlevel, "Preexam Status");
					$worksheet->write(0, 8+$nlevel, "Preexam Date");
					$worksheet->write(0, 9+$nlevel, "Duration");
			}
			else
			if ($pageid == "certificate")
			{
				$worksheet->write(0, 6+$nlevel, "Certification Value");
				$worksheet->write(0, 7+$nlevel, "Certification Status");
				$worksheet->write(0, 8+$nlevel, "Certification Date");
				$worksheet->write(0, 9+$nlevel, "Duration");
			}
			else
			{
				$worksheet->write(0, 6+$nlevel, "Exam Value");
				$worksheet->write(0, 7+$nlevel, "Exam Status");
				$worksheet->write(0, 8+$nlevel, "Exam Date");
				$worksheet->write(0, 9+$nlevel, "Duration");
			}

			for($i=0; $i < count($rows); $i++)
			{

				$arrgroups = array();
				$this->levelmodel->getparentlevelgroups($rows[$i]->level_group_id, $arrgroups);
				$arrgroups = array_reverse($arrgroups);

				$worksheet->write($i+1, 0, $rows[$i]->training_code);
				$worksheet->write($i+1, 1, $rows[$i]->training_name);
				$worksheet->write($i+1, 2, $rows[$i]->user_npk);
				$worksheet->write($i+1, 3, $rows[$i]->user_first_name." ".$rows[$i]->user_last_name);
				
				for($j=0; $j < $nlevel; $j++)
				{
					if (isset($arrgroups[$j]))
					{
						$worksheet->write($i+1, 4+$j, $arrgroups[$j]->level_group_name);
					}
					else					
					{
						$worksheet->write($i+1, 4+$j, '');
					}					
				}

				$worksheet->write($i+1, 4+$nlevel, $rows[$i]->lokasi_alamat);
				$worksheet->write($i+1, 5+$nlevel, $rows[$i]->lokasi_kota);
				$worksheet->write($i+1, 6+$nlevel, $rows[$i]->history_exam_score);
				$worksheet->write($i+1, 7+$nlevel, $rows[$i]->history_exam_status_str);
				$worksheet->write($i+1, 8+$nlevel, $rows[$i]->history_exam_date_fmt);
				$worksheet->write($i+1, 9+$nlevel, $rows[$i]->duration);
			}
			
			$this->xlswriter->close();
			
			exit;
		}

		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
		$config['next_link'] = '<img src="'.base_url().'/images/16/blue_next.gif" alt="next" width="16" height="16" border="0" />';
		$config['next_tag_open'] = "<td>";
		$config['next_tag_close'] = "</td>";

		$config['prev_link'] = '<img src="'.base_url().'/images/16/blue_back.gif" alt="prev" width="16" height="16" border="0" />';
		$config['prev_tag_open'] = "<td>";
		$config['prev_tag_close'] = "</td>";

		$config['first_link'] = '<img src="'.base_url().'/images/16/blue_first.gif" alt="prev" width="16" height="16" border="0" />';		
		$config['last_link'] = '<img src="'.base_url().'/images/16/blue_last.gif" alt="prev" width="16" height="16" border="0" />';

		$limits = array(10=>10, 20=>20, 50=>50);
		if (! in_array($recordperpage, $limits)) 
		{
			$limits[$recordperpage] = $recordperpage;
			ksort($limits);
		} 
		$limits[0] = 'all';
		
		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('unit');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);		
		$this->mysmarty->assign("id", $id);
		
		if ($pageid == "training")    
			$this->mysmarty->assign("lcode", $this->config->item("ltraining_code"));		
		else
			$this->mysmarty->assign("lcode", $this->config->item("lcertification_code"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("learning_topics_list", "Participant Summary: ".$row->training_code." ".$row->training_name);
		$this->mysmarty->assign("pageid", $pageid);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("searchby", $searchby);
		$this->mysmarty->assign("keyword", $keyword);
		$this->mysmarty->assign("type", $type);
		$this->mysmarty->assign("status", $status);
		$this->mysmarty->assign("status1", $status1);
		$this->mysmarty->assign("llulus", $this->config->item("llulus"));
		$this->mysmarty->assign("lnolulus", $this->config->item("lnolulus"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lall", $this->config->item("lall"));
		$this->mysmarty->assign("llulus", $this->config->item("llulus"));
		$this->mysmarty->assign("lnolulus", $this->config->item("lnolulus"));
		$this->mysmarty->assign("lmax_score", $this->config->item("lmax_score"));
		$this->mysmarty->assign("llast_score", $this->config->item("llast_score"));		
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "trainingreport/detail.html");
		$this->mysmarty->display("sess_template.html");		
	}

	function nomaterial($id, $pageid)
	{
		$this->mysmarty->assign("subpageex", "material");
		
		$this->detailnoparticipant($id, $pageid, array(0));
	}

	function nopraexam($id, $pageid)
	{
		$this->mysmarty->assign("subpageex", "praexam");
		
		$this->detailnoparticipant($id, $pageid, array(1));
	}

	function noexam($id, $pageid)
	{
		$this->mysmarty->assign("subpageex", "exam");
		
		$this->detailnoparticipant($id, $pageid, array(2, 3));
	}

	function detailnoparticipant($id, $pageid, $type)
	{		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$isexport = isset($_POST['isexport']) ? $_POST['isexport'] : 0;
		
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$trainings = $this->trainingmodel->GetCandidateUserIds(array($id));
		
		$this->participants = array();
		if (isset($trainings[$id]))
		{
			$this->participants = array_keys($trainings[$id]);
		}
		
		$this->db->distinct();
		$this->db->select("history_exam_user");
		$this->db->where_in("history_exam_type", $type);
		$this->db->where("history_exam_reset", 0);		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);				
		$this->db->where("history_exam_training", $row->training_id);
		
		$this->db->join("user", "user_id = history_exam_user");	
		$this->db->where("user_status", 1);	//user active only	
	
		$q = $this->db->get("history_exam");
		$rows = $q->result();
		
		$this->accessed = array();
		for($i=0; $i < count($rows); $i++)
		{
			$this->accessed[] = $rows[$i]->history_exam_user;
		}
				
		if ($sortby == "user_name")
		{
			$this->db->order_by(sprintf("user_first_name %s, user_last_name %s", $orderby, $orderby));
		}
		else
		{			
			$this->db->order_by($sortby, $orderby);
		}
		
		if ($searchby)
		{
			switch($searchby)
			{
				case "user_name":
				$where = sprintf("(user_first_name LIKE '%%%s%%' OR user_last_name LIKE '%%%s%%')", addslashes($keyword), addslashes($keyword));
				break;
				default:
					$where = sprintf("%s LIKE '%%%s%%'", $searchby, addslashes($keyword));

			}
			$this->db->where($where, null);
		}
			
		$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$this->db->join("level_group", "level_group_id = jabatan_level_group", "left outer");
	
		$this->db->where("user_status", 1);	//user active only	
	
		$q = $this->db->get("user");
		
		//debug 
		//echo $this->db->last_query();
		
		$rows = $q->result();
		//echo "helo : ".count($rows);
		$rows = array_filter($rows, "noparticipant");
		
		
		/*$CI =& get_instance();
		print_r($CI->accessed);
		echo "<BR><BR>";
		print_r($CI->participants);*/
		
	
	
		$rows_temp = array();
		$counter  = 0;
		foreach($rows as $value){
			if($value->user_npk){
				$rows_temp[$counter] = $value;
				$counter++;
			}
		}
		$rows = $rows_temp;
		
		$total = count($rows);		
		//echo $total;
		$levels = array();
		$this->levelmodel->getalllevels(0, $levels);
		$nlevel = count($levels);
		
		if ($isexport)
		{		
			$this->load->library("xlswriter");
			$this->xlswriter->send("trainingreport_".$row->training_code.".xls");
			
			$worksheet =& $this->xlswriter->addWorksheet("participants");
			
			if ($pageid == "training"){
				$worksheet->write(0, 0, $this->config->item("ltraining_code"));
				$worksheet->write(0, 1, $this->config->item("ltraining_name"));
			}
			else{
				$worksheet->write(0, 0, $this->config->item("lcertificate_code"));
				$worksheet->write(0, 1, $this->config->item("certificate_name"));
			}
				
			$worksheet->write(0, 2, $this->config->item("lnpk"));
			$worksheet->write(0, 3, $this->config->item("name"));
			for($i=0; $i < $nlevel; $i++)
			{
				$worksheet->write(0, 4+$i, $levels[$i]->level_name);
			}
			
			$worksheet->write(0, 4+$nlevel, "Location");
			$worksheet->write(0, 5+$nlevel, "City");
			for($i=0; $i < count($rows); $i++)
			{

				$arrgroups = array();
				$this->levelmodel->getparentlevelgroups($rows[$i]->level_group_id, $arrgroups);
				$arrgroups = array_reverse($arrgroups);
				$worksheet->write($i+1, 0, $row->training_code);
				$worksheet->write($i+1, 1, $row->training_name);
				$worksheet->write($i+1, 2, $rows[$i]->user_npk);
				$worksheet->write($i+1, 3, $rows[$i]->user_first_name." ".$rows[$i]->user_last_name);
				
				for($j=0; $j < $nlevel; $j++)
				{
					if (isset($arrgroups[$j]))
					{
						$worksheet->write($i+1, 4+$j, $arrgroups[$j]->level_group_name);
					}
					else					
					{
						$worksheet->write($i+1, 4+$j, '');
					}					
				}

				$worksheet->write($i+1, 4+$nlevel, $rows[$i]->lokasi_alamat);
				$worksheet->write($i+1, 5+$nlevel, $rows[$i]->lokasi_kota);
			}
			
			$this->xlswriter->close();
			
			exit;
		}
		
		if($limit > 0)
			$rows = array_splice($rows, $offset, $limit);

		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
		$config['next_link'] = '<img src="'.base_url().'/images/16/blue_next.gif" alt="next" width="16" height="16" border="0" />';
		$config['next_tag_open'] = "<td>";
		$config['next_tag_close'] = "</td>";

		$config['prev_link'] = '<img src="'.base_url().'/images/16/blue_back.gif" alt="prev" width="16" height="16" border="0" />';
		$config['prev_tag_open'] = "<td>";
		$config['prev_tag_close'] = "</td>";

		$config['first_link'] = '<img src="'.base_url().'/images/16/blue_first.gif" alt="prev" width="16" height="16" border="0" />';		
		$config['last_link'] = '<img src="'.base_url().'/images/16/blue_last.gif" alt="prev" width="16" height="16" border="0" />';

		$limits = array(10=>10, 20=>20, 50=>50);
		if (! in_array($recordperpage, $limits)) 
		{
			$limits[$recordperpage] = $recordperpage;
			ksort($limits);
		} 
		$limits[0] = 'all';
		
		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('unit');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);		
		$this->mysmarty->assign("id", $id);
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("learning_topics_list", "No Participant Summary: ".$row->training_code." ".$row->training_name);
		$this->mysmarty->assign("pageid", $pageid);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("searchby", $searchby);
		$this->mysmarty->assign("keyword", $keyword);
		$this->mysmarty->assign("type", $type);
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "trainingreport/detail-noparticipant.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
}

function noparticipant($var)
{
	$CI =& get_instance();
	
	return (! in_array($var->user_id, $CI->accessed)) && (in_array($var->user_id, $CI->participants));
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
