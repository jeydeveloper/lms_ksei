<?php

include_once "base.php"; 
class Activities extends Base{
	var $lang;
	var $modules;
	var $sess;

	function Activities()
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
		$this->load->model("levelmodel");
		$this->load->model("logmodel");
		$this->load->model("ildpmodel");
		
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

            $this->sess = $sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($sess['user_type']);
		}		
		$this->langmodel->init();
	}
	
	function index()
	{
		redirect(base_url()."user/activities");
	}
		
	function detail($id)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
			return;
		}
		
		$sess = unserialize($usess);
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST['offset']) ? $_POST['offset'] :  0;
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] :  "history_exam_date|history_exam_time";
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] :  "desc";
		$isexport = isset($_POST['isexport']) ? $_POST['isexport'] :  0;
		
		$this->db->where("user_id", $id);
		$q = $this->db->get("user");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
			return;
		}
		
		$row = $q->row();
		
		$this->mysmarty->assign("user", $row);
		
		// history
		
		$sortbyes = explode("|", $sortby);
		for($i=0; $i < count($sortbyes); $i++)
		{
			if (! $sortbyes[$i]) continue;
			
			$this->db->order_by($sortbyes[$i], $orderby);
		}
		
		if(!$isexport && ($limit > 0))
			$this->db->limit($limit, $offset);	
			
		$this->db->where("history_exam_user", $row->user_id);	
		$this->db->join("training", "training_id = history_exam_training");	
		$q = $this->db->get("history_exam");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->history_exam_startdatetime = dbintmaketime($rows[$i]->history_exam_startdate, $rows[$i]->history_exam_starttime);
			$rows[$i]->history_exam_startdatetime_str = date("d/m/Y H:i:s", $rows[$i]->history_exam_startdatetime);
			$rows[$i]->history_exam_startdate_str = date("d/m/Y", $rows[$i]->history_exam_startdatetime);
			
			if($rows[$i]->history_exam_date && $rows[$i]->history_exam_time) {
				$rows[$i]->history_exam_datetime = dbintmaketime($rows[$i]->history_exam_date, $rows[$i]->history_exam_time);
				$rows[$i]->history_exam_date_str = date("d/m/Y", $rows[$i]->history_exam_datetime);
				$rows[$i]->history_exam_time_str = date("H:i:s", $rows[$i]->history_exam_datetime);
				$rows[$i]->history_exam_datetime_str = date("d/m/Y H:i:s", $rows[$i]->history_exam_datetime);
				if($rows[$i]->history_exam_date_str == $rows[$i]->history_exam_startdate_str) { //same date 
					$rows[$i]->enddate = $rows[$i]->history_exam_time_str;
				}else
					$rows[$i]->enddate = $rows[$i]->history_exam_datetime_str;
			}else {
				$rows[$i]->enddate = "";
			}
			
			
			
			$rows[$i]->exam_date = ($rows[$i]->enddate)?$rows[$i]->history_exam_startdatetime_str." ".$this->config->item('until')." ".$rows[$i]->enddate:$rows[$i]->history_exam_startdatetime_str;
			
			$rows[$i]->history_exam_time_str = date("H:i:s", $rows[$i]->history_exam_datetime);
			$rows[$i]->history_exam_date_str = date("d/m/Y", $rows[$i]->history_exam_datetime);
			$rows[$i]->history_exam_score_fmt = number_format($rows[$i]->history_exam_score, 2, ".", ",");
			
			if (($rows[$i]->history_exam_type == 2) || ($rows[$i]->history_exam_type == 3))
			{
				$rows[$i]->history_exam_status_str = ($rows[$i]->history_exam_status == 1) ? $this->config->item("llulus") : $this->config->item("lnolulus");
			}
			else
			{
				$rows[$i]->history_exam_status_str = $this->config->item("lcompeted");
			}
						
			switch($rows[$i]->training_type)
			{
				case 0:
				case 1:
					$rows[$i]->history_exam_type_desc = $this->config->item("lonline_training");
					switch($rows[$i]->history_exam_type)
					{
						case 0:
							$rows[$i]->activity = $this->config->item("lmateri");	
						break;
						case 1:
							$rows[$i]->activity = $this->config->item("lpraexam");	
						break;
						case 2:
							$rows[$i]->activity = $this->config->item("lexam");	
					}
				break;
				case 2:
					$rows[$i]->history_exam_type_desc = $this->config->item("lcertificate");
					$rows[$i]->activity = $this->config->item("lexam");
				break;
				case 3:
					$rows[$i]->history_exam_type_desc = $this->config->item("lclassroom");
				break;								
								
			}
			
		}
		
		if ($isexport)
		{
			
			$this->export($row, $rows);			
			return;
		}
		
		$this->mysmarty->assign("histories", $rows);
		
		// paging

		$this->db->order_by("history_exam_date", "desc");
		$this->db->where("history_exam_user", $row->user_id);	
		$this->db->join("training", "training_id = history_exam_training");	
		$total = $this->db->count_all_results("history_exam");

		$config['total_rows'] = $total;
		$config['per_page'] = ($limit > 0) ? $limit : $total; 
				
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
		
		$levels = array();
		$this->levelmodel->getalllevels(0, $levels);
		
		$this->pagination1->ref = 'page';
		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('luser_activities');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = !empty($list) ? count($list) : 0;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("ltraingname", $this->config->item("training_name")."/".$this->config->item("certificate_name"));
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));
		$this->mysmarty->assign("lactivity", $this->config->item("lactivity"));
		$this->mysmarty->assign("ltype", $this->config->item("ltype"));
		$this->mysmarty->assign("lscore", $this->config->item("lscore"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lactivity", $this->config->item("lactivity"));
		$this->mysmarty->assign("lcetak", $this->config->item('lcetak'));
		
		$this->mysmarty->assign("lsort_by_score", $this->config->item("lsort_by_score"));
		$this->mysmarty->assign("lsort_by_training_name", $this->config->item("lsort_by_training_cert_name"));
		$this->mysmarty->assign("lsort_by_date", $this->config->item("lsort_by_date"));
		
		if($this->sess['asadmin'] == 1) {
			$this->mysmarty->assign("left_content", "topic/menu.html");	
		} else {
			$this->mysmarty->assign("left_content", "user/menu.html");
		}
		
		$this->mysmarty->assign("main_content", "activities/list.html");
		$this->mysmarty->display("sess_template.html");

	}
	
	function export($user, $rows)
	{
	    /*
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-activies-".$user->user_npk.".xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("category_topic");
			
		
		$worksheet->write(0, 0, $this->config->item("lnpk"));
		$worksheet->write(0, 1, $this->config->item("luser_name"));
		$worksheet->write(0, 2, $this->config->item("ldate"));
		$worksheet->write(0, 3, $this->config->item("ltime"));
		$worksheet->write(0, 4, $this->config->item("ltraining_code"));
		$worksheet->write(0, 5, $this->config->item("training_name"));
		$worksheet->write(0, 6, $this->config->item("ltype"));
		$worksheet->write(0, 7, $this->config->item("lactivity"));
		$worksheet->write(0, 8, $this->config->item("lscore"));
		$worksheet->write(0, 9, $this->config->item("status"));
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $user->user_npk);	
			$worksheet->write($i+1, 1, $user->user_first_name." ".$user->user_last_name);	
			$worksheet->write($i+1, 2, $rows[$i]->history_exam_date_str);	
			$worksheet->write($i+1, 3, $rows[$i]->history_exam_time_str);	
			$worksheet->write($i+1, 4, $rows[$i]->training_code);	
			$worksheet->write($i+1, 5, $rows[$i]->training_name);	
			$worksheet->write($i+1, 6, $rows[$i]->history_exam_type_desc);
			$worksheet->write($i+1, 7, $rows[$i]->activity);	
			$worksheet->write($i+1, 8, $rows[$i]->history_exam_score_fmt);	
			$worksheet->write($i+1, 9, $rows[$i]->history_exam_status_str);	
		}

		$this->xlswriter->close();
		*/

        require_once BASEPATH . "application/libraries/PHPExcel.php";
        require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, $this->config->item("lnpk"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 0, $this->config->item("luser_name"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 0, $this->config->item("ldate"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 0, $this->config->item("ltime"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 0, $this->config->item("ltraining_code"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 0, $this->config->item("training_name"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 0, $this->config->item("ltype"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 0, $this->config->item("lactivity"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 0, $this->config->item("lscore"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 0, $this->config->item("status"));

        for($i=0; $i < count($rows); $i++)
        {
            $row = $i + 1;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $user->user_npk);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ($user->user_first_name." ".$user->user_last_name));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $rows[$i]->history_exam_date_str);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $rows[$i]->history_exam_time_str);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rows[$i]->training_code);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rows[$i]->training_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $rows[$i]->history_exam_type_desc);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $rows[$i]->activity);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $rows[$i]->history_exam_score_fmt);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $rows[$i]->history_exam_status_str);
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        $fileName = date("Ymd-His")."-activies-".$user->user_npk.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
