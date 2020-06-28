<?php
include_once "base.php";

class Training extends Base {
	var $sess;
	var $langue;
	var $modules;
	var $delegetions;
	var $training_type;

	function Training()
	{
		parent::Base();

		$this->training_type = "training";

		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');

		$this->load->helper('url');
		$this->load->helper('common');
		$this->load->helper('email');

		$this->load->model("usermodel");
		$this->load->model("langmodel");
		$this->load->model("topicmodel");
		$this->load->model("trainingmodel");
		$this->load->model("certificatemodel");
		$this->load->model("commonmodel");
		$this->load->model("logmodel");
		$this->load->model("GeneralsettingModel");

		$this->load->database();

		$this->langue = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->langue ? $this->langue : $this->langmodel->getDefaultLang()));

		$this->mysmarty->assign("lang", $this->langue);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());

		$this->mysmarty->assign("lnpk", $this->config->item('lnpk'));

		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));

		$this->session->set_userdata(array("referrer"=>current_url()));
		$usess = $this->session->userdata('lms_sess');
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));

			$sess = unserialize($usess);
			$this->sess = $sess;
			$this->modules = $this->commonmodel->getRight($sess['user_type'], $this->delegetions);
		}
		$this->langmodel->init();
	}

	function convert()
	{
		$path = "E:/dedy/kerjaan/netpolitan/lms2/trunk/temp";
		$in = $path."/14-kyc-and-aml.csv";
		$out = $path."/14-kyc-and-aml-result.csv";
		$sep = ";";


		$q = $this->db->get("user");
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$users[$rows[$i]->user_npk] = $rows[$i]->user_id;
		}

		$fin = fopen($in, "r");
		$fout = fopen($out, "w");

		while(! feof($fin))
		{
			$line = trim(fgets($fin));
			$lines = explode($sep, $line);

			$npk = trim($lines[0]);

			if (! isset($users[$npk])) continue;

			$lines[0] = $users[$npk];

			$line = implode($sep, $lines);
			fputs($fout, $line."\r\n");
		}

		fclose($fout);
		fclose($fin);
	}

	function type()
	{
		return 1;
	}

	function pageid()
	{
		return "training";
	}

	function showmateri($id){
		$usess = $this->session->userdata('lms_sess');
		if (! $usess || !$id)
		{
			redirect(base_url());
		}

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		if ($row->training_material_type == 1)
		{
			$url = base_url()."material/".$row->training_material."/";
		}

		$this->mysmarty->assign("url", $url);
		$this->mysmarty->assign("id", $id);
		//$this->mysmarty->assign("left_content", "topic/menu.html");
		//$this->mysmarty->assign("main_content", "training/showmateri.html");
		$this->mysmarty->display("training/showmateri.html");


	}

	function showlist($catid = 0)
	{
		//get general setting for show materi ,show all not not
		$showmaterihist = $this->GeneralsettingModel->GetInfo("personalreportmateri");

		//$showmaterihist = 1;

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$recordperpage = $this->commonmodel->getRecordPerPage();

		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";

		/* training */
		if( $this->type() == 1 )
			$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "training_code";
		else
			$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "training_name";

		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";

		$sess = unserialize($usess);


		if (! isset($this->modules['trainee']))
		{
			if (isset($this->modules['training']) || isset($this->modules['certificate']) || isset($this->modules['delegetion']))
			{
				if (! isset($this->modules['delegetion']))
				{
					if (isset($this->modules['certificate']) && ($this->pageid() != 'certificate'))
					{
						redirect(site_url(array("certificate", "showlist")));
					}
				}
			}
			else
			{
				redirect(base_url());
			}
		}

		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{
			$arrtopicids = array();
			$arrtopictrainingids = array();
			$arrtopiccertificateids = array();
			$this->topicmodel->getTopicsUser($sess, $arrtopicids, $arrtopictrainingids, $arrtopiccertificateids);
			$topicids = count($arrtopicids) ? array_keys($arrtopicids) : array(0);
			$topictrainingids = count($arrtopictrainingids) ? array_keys($arrtopictrainingids) : array(0);
			$topiccertificateids = count($arrtopiccertificateids) ? array_keys($arrtopiccertificateids) : array(0);

			if ($this->type() == 1)
			{
				if (count($topictrainingids) == 0)
				{
					redirect(base_url());
				}
				if (! in_array($catid, $topictrainingids))
				{
					redirect(base_url());
				}
			}
			else
			{
				if (count($topiccertificateids) == 0)
				{
					redirect(base_url());
				}
				if (! in_array($catid, $topiccertificateids))
				{
					redirect(base_url());
				}
			}
		}

		if ($catid)
		{
			$this->db->where("category_id", $catid);
			$q = $this->db->get("category");
			$this->db->flush_cache();

			$topiccurr = $q->row();

			$this->mysmarty->assign("topiccurr", $topiccurr);
		}

		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{
			$privileges = $this->trainingmodel->GetPrivileges($sess, false);

			if (count($privileges) > 0)
			{
				$privileges = array_keys($privileges);
			}
			else
			{
				$privileges= array(0);
			}

			if ($this->type() == 1)
			{
				$this->db->where_in("training_topic", $topictrainingids);
			}
			else
			{
				$this->db->where_in("training_topic", $topiccertificateids);
			}

			$this->db->where_in("training_id", $privileges);
		}

		$this->db->order_by($sortby, $orderby);
		$this->db->where("training_type", $this->type());
		$this->db->select("*, CASE training_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END training_status_desc ", false);

		if ($catid)
		{
			$this->db->where("training_topic", $catid);
		}
		if (! isset($sess['asadmin']))
		{
			$this->db->where("training_status", 1);
		}
		if ($keyword && $searchby)
		{
			$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
		}

		if ($limit)
		{

			$this->db->join("category", "training_topic = category_id");
			$q = $this->db->get("training", $limit, $offset);
			$this->db->flush_cache();
		}
		else
		{
			$this->db->join("category", "training_topic = category_id");
			$q = $this->db->get("training");
			$this->db->flush_cache();
		}

		$list = $q->result();

		$trainingids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$trainingids[] = $list[$i]->training_id;
		}

		$used = $this->trainingmodel->GetUsed($trainingids);
		$hist = $this->trainingmodel->taketimes($sess, $trainingids);

		if (isset($trainingids))
		{
			$this->db->order_by("training_time_date1", "asc");
			$this->db->where_in("training_time_training", $trainingids);
			$this->db->where("training_time_date2 >=", date("Ymd"));
			$q = $this->db->get("training_time");
			$this->db->flush_cache();

			$rowtimes = $q->result();
			for($i=0; $i < count($rowtimes); $i++)
			{
				if (isset($times[$rowtimes[$i]->training_time_training])) continue;

				$t1 = dbintmaketime($rowtimes[$i]->training_time_date1, 0);
				$rowtimes[$i]->training_time_date1_str = date("d/m/Y", $t1);
				$rowtimes[$i]->training_time_date1_timestamp = $t1;

				$t2 = dbintmaketime($rowtimes[$i]->training_time_date2, 235555);
				$rowtimes[$i]->training_time_date2_str = date("d/m/Y", $t2);
				$rowtimes[$i]->training_time_date2_timestamp = $t2;

				$times[$rowtimes[$i]->training_time_training] = $rowtimes[$i];
			}
		}

		for($i=0; $i < count($list); $i++)
		{
			if (isset($times[$list[$i]->training_id]))
			{
				$list[$i]->period = $times[$list[$i]->training_id];

				$t3 = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
				$list[$i]->inperiod = ($t3 >= $times[$list[$i]->training_id]->training_time_date1_timestamp) && ($t3 <= $times[$list[$i]->training_id]->training_time_date2_timestamp);

				$list[$i]->npraexam = isset($hist[1][$list[$i]->training_id]) ? $hist[1][$list[$i]->training_id] : 0;
				$list[$i]->nexam = isset($hist[2][$list[$i]->training_id]) ? $hist[2][$list[$i]->training_id] : 0;
			}
			else
			{

				$this->db->where("training_time_training", $list[$i]->training_id);
				$tottimes = $this->db->count_all_results("training_time");
				$this->db->flush_cache();

				$list[$i]->allperiod = $tottimes == 0;
			}

			$list[$i]->used = isset($used[$list[$i]->training_id]);
			$list[$i]->delegetion = isset($this->delegetions[$list[$i]->training_id]);
		}

		// pra exam / exam
		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{
			if ($this->type() == 1)
			{
				if ($catid)
				{
					$this->db->where("training_topic", $catid);
					$this->db->join("training", "training_id = training_exam_training");
					$q = $this->db->get("training_exam");
					$this->db->flush_cache();
				}
				else
				{
					$this->db->join("training", "training_id = training_exam_training");
					$q = $this->db->get("training_exam");
					$this->db->flush_cache();
				}

				$rowexam = $q->result();
				for($i=0; $i < count($rowexam); $i++)
				{
					if ($rowexam[$i]->training_exam_type == 1)
					{
						$praexam[$rowexam[$i]->training_exam_training] = true;
					}
					else
					{
						$exam[$rowexam[$i]->training_exam_training] = true;
					}
				}

				for($i=0; $i < count($list); $i++)
				{
					$list[$i]->hasPraExam = isset($praexam[$list[$i]->training_id]);
					$list[$i]->hasExam = isset($exam[$list[$i]->training_id]);
				}
			}
		}

		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{
			if ($this->type() == 1)
			{
				$this->db->where_in("training_topic", $topictrainingids);
			}
			else
			{
				$this->db->where_in("training_topic", $topiccertificateids);
			}

			$this->db->where_in("training_id", $privileges);
		}

		if ($catid)
		{
			$this->db->where("training_topic", $catid);
		}

		if (! isset($sess['asadmin']))
		{
			$this->db->where("training_status", 1);
		}

		if ($keyword && $searchby)
		{
			$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
		}

		$this->db->where("training_type", $this->type());
		$this->db->join("category", "training_topic = category_id");
		$total = $this->db->count_all_results("training");
		$this->db->flush_cache();

		$this->db->where("history_exam_reset", 0);
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);

		if ($this->type() == 3)
		{
			$this->db->where("history_exam_type", 4);
		}
		else
		if ($this->type() == 2)
		{
			$this->db->where("history_exam_type", 3);
			if(!$showmaterihist)
				$this->db->where("history_exam_status", 1);
		}
		else
		if ($showmaterihist)
		{

			$this->db->where("((history_exam_type = 2) OR (history_exam_type = 1) OR (history_exam_type = 0))", null);
		}
		else
		{
			$this->db->where("history_exam_type", 2);
		}

		$this->db->group_by("history_exam_training, history_exam_user");
		$this->db->select("history_exam_training, history_exam_user");
		$this->db->join("user", "user_id = history_exam_user");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		$resreset = $q->result();
		for($i=0; $i < count($resreset); $i++)
		{
			if (! isset($reset[$resreset[$i]->history_exam_training]))
			{
				$reset[$resreset[$i]->history_exam_training] = 0;
			}

			$reset[$resreset[$i]->history_exam_training]++;
		}

		for($i=0; $i < count($list); $i++)
		{
			$ids[] = $list[$i]->training_id;
		}

		if (isset($ids))
		{
			$candidates = $this->trainingmodel->GetCandidateNPK($ids);
		}

		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->peserta = isset($candidates[$list[$i]->training_id]) ? $candidates[$list[$i]->training_id] : 0;
			$list[$i]->taked = isset($reset[$list[$i]->training_id]) && ($reset[$list[$i]->training_id] > 0) ? $reset[$list[$i]->training_id] : 0;

			if ($list[$i]->peserta == 0)
			{
				$list[$i]->percentpeserta = 0;
			}
			else
			{
				$list[$i]->percentpeserta = round(($list[$i]->taked/$list[$i]->peserta)*100);
			}
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

		$this->mysmarty->assign("lpostrequisite", $this->config->item('lpostrequisite'));
		$this->mysmarty->assign("lprequisite", $this->config->item('lprequisite'));
		$this->mysmarty->assign("lparticipant", $this->config->item('lparticipant'));
		$this->mysmarty->assign("ltraining", $this->config->item('training_name'));
		$this->mysmarty->assign("lcertificate", $this->config->item('lexam'));
		$this->mysmarty->assign("lall_period", $this->config->item('lall_period'));

		$this->mysmarty->assign("lcertificate_name_column", ucfirst($this->config->item('certificate_name')));
		$this->mysmarty->assign("ltraining_column", ucfirst($this->config->item('training_name')));
		$this->mysmarty->assign("ldelete", $this->config->item('ldelete'));
		$this->mysmarty->assign("luntil", $this->config->item('luntil'));

		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("pageid", $this->pageid());

		$lsort_by_name = "";
		$lsort_by_code = "";
		$lname_column = "";
		switch($this->pageid()){
			case "training" :
				$lsort_by_name = $this->config->item('lsort_by_training_name');
				$lsort_by_code = $this->config->item('lsort_by_training_code');
				$lname_column =  ucfirst(strtoupper($this->config->item('training_name')));
			break;
			case "classroom" :
				$lsort_by_name = $this->config->item('lsort_by_training_name');
				$lname_column =  ucfirst($this->config->item('training_name'));
			break;
			case "certificate":
				$lsort_by_name = $this->config->item('lsort_by_certification_name');
				$lsort_by_code = $this->config->item('lsort_by_certification_code');
				$lname_column =  ucfirst(strtoupper($this->config->item('certificate_name')));
			break;
		}

		$this->mysmarty->assign("lsort_by_name", $lsort_by_name);
		$this->mysmarty->assign("lsort_by_code", $lsort_by_code);
		$this->mysmarty->assign("lname_column", $lname_column);
		$this->mysmarty->assign("lsort_by_name_column", $lsort_by_name);

		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("ltopic", ucfirst($this->config->item('topic')));
		$this->mysmarty->assign("topic_column", ucfirst($this->config->item('topic')));

		$this->mysmarty->assign("header_list_topic", $this->config->item('header_list_topic'));
		$this->mysmarty->assign("category", ucfirst($this->config->item('category')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("learning_topics_list", ucfirst($this->config->item('learning_topics_list')));
		$this->mysmarty->assign("topic_code", strtoupper($this->config->item('topic_code')));
		$this->mysmarty->assign("lreset", $this->config->item('lreset'));
		$this->mysmarty->assign("lhistory", $this->config->item('lhistory'));

		$this->mysmarty->assign("topicid", $this->uri->segment(3));
		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("lcode", $this->config->item('lcode'));
		$this->mysmarty->assign("lcertificate_name", $this->config->item('certificate_name'));
		$this->mysmarty->assign("lpraexam", $this->config->item('lpraexam'));
		$this->mysmarty->assign("lmateri", $this->config->item('lmateri'));
		$this->mysmarty->assign("lexam", $this->config->item('lexam'));
		$this->mysmarty->assign("lperiod", $this->config->item('lperiod'));
		$this->mysmarty->assign("lconfirm_reset_all_npk", $this->config->item('lconfirm_reset_all_npk'));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lexport_history", ucfirst($this->config->item('lexport_history')));
		$this->mysmarty->assign("lshow_all", $this->config->item("lshow_all"));
		$this->mysmarty->assign("lclassroom_name", $this->config->item("lclassroom_name"));
		$this->mysmarty->assign("lclassroom_name_column", $this->config->item("lclassroom_name"));

		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lclassroom_name_upper", strtoupper($this->config->item("lclassroom_name")));
		$this->mysmarty->assign("ldelegetion", $this->config->item("ldelegetion"));
		$this->mysmarty->assign("lexport_history", $this->config->item("lexport_history"));
		$this->mysmarty->assign("lexport_type", $this->config->item("lexport_type"));
		$this->mysmarty->assign("lmax_score", $this->config->item("lmax_score"));
		$this->mysmarty->assign("llast_score", $this->config->item("llast_score"));
		$this->mysmarty->assign("llast_lulus", $this->config->item("llast_lulus"));
		$this->mysmarty->assign("controller", $this->uri->segment(1));

		$this->mysmarty->assign("left_content", "topic/menu.html");

		if ($this->pageid() == "classroom")
		{
			$this->mysmarty->assign("main_content", "classroom/list.html");
		}
		else
		{
			$this->mysmarty->assign("main_content", "training/list.html");
		}

		$this->mysmarty->display("sess_template.html");
	}

	function participant()
	{
		$this->checkadmin(true);

		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);
		$training_npk_time_id = $this->uri->segment(5);

		$training_npk_time_id = !empty($training_npk_time_id) ? $training_npk_time_id : 0;

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row();
			//print_r($row);


			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$topicid = $row->training_topic;

			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;
			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("trainingid", $trainingid);
		$this->mysmarty->assign("training_npk_time_id", $training_npk_time_id);
		$this->mysmarty->assign("participant", 1);
		$this->mysmarty->assign("ledit_header", $this->config->item("lupdateparticipant"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("url", site_url(array("training", "getparticipant")));
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("pageid", $this->pageid());

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function delegetion()
	{
		$this->checkadmin();

		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row();


			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);
			$this->mysmarty->assign("training_delegationx", 1);

			$topicid = $row->training_topic;

			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;
			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("delegetion", 1);
		$this->mysmarty->assign("ledit_header", $this->config->item("ldelegetion"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("url", site_url(array("training", "getdelegetion")));
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("date_added", $this->config->item("date_added"));
		$this->mysmarty->assign("pageid", $this->pageid());

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}


	function material($topicid=0, $trainingid=0)
	{
		$this->checkadmin();

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row();


			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$topicid = $row->training_topic;

			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;
			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("material", 1);
		$this->mysmarty->assign("ledit_header", $this->config->item("lmaterial_import"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("lmaterial_file", $this->config->item("lmaterial_file"));
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function postrequisite()
	{
		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");
			$row = $q->row();

			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$this->mysmarty->assign("trainingid", $trainingid);

			$topicid = $row->training_topic;
			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;

			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("url", site_url(array("training", "getprequisite", "post")));
		$this->mysmarty->assign("ledit_header", $this->config->item("lpostrequisite"));
		$this->mysmarty->assign("postrequisite", 1);

		$this->_prequisite();
	}

	function prequisite()
	{
		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");
			$row = $q->row();

			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$this->mysmarty->assign("trainingid", $trainingid);

			$topicid = $row->training_topic;
			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);

			$this->mysmarty->assign("category_name", $mycategory->category_name);

			$def = $mycategory->category_id;
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("url", site_url(array("training", "getprequisite", "pre")));
		$this->mysmarty->assign("ledit_header", $this->config->item("lprequisite"));
		$this->mysmarty->assign("prequisite", 1);
		$this->_prequisite();
	}

	function _prequisite()
	{
		$this->checkadmin();

		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function getprequisite()
	{
		$this->checkadmin();

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$this->db->where("training_name", $name);
		$this->db->where("training_topic", $topic);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			return;
		}

		$training = $q->row();

		$id = $this->uri->segment(3);

		if ($id == "post")
		{
			$this->db->where("training_postrequisite_training", $training->training_id);
			$q = $this->db->get("training_postrequisite");
			$this->db->flush_cache();
			$pre = $q->result();
			$arrpre = array();
			for($i=0; $i < count($pre); $i++)
			{
				$arrpre[] = $pre[$i]->training_postrequisite_postrequisite;
			}

			$this->mysmarty->assign("ok_update_prequisite_training", $this->config->item("ok_update_postrequisite_training"));
		}
		else
		{
			$this->db->where("training_prequisite_training", $training->training_id);
			$q = $this->db->get("training_prequisite");
			$this->db->flush_cache();
			$pre = $q->result();
			$arrpre = array();
			for($i=0; $i < count($pre); $i++)
			{
				$arrpre[] = $pre[$i]->training_prequisite_prequisite;
			}

			$this->mysmarty->assign("ok_update_prequisite_training", $this->config->item("ok_update_prequisite_training"));
		}

		$this->db->where("training_status", 1);
		$this->db->where("training_id <>", $training->training_id);
		$this->db->orderby("training_type","asc");
		$this->db->orderby("training_name","asc");

		$q = $this->db->get("training");
		$this->db->flush_cache();

		$trainings = $q->result();
		$arrtrainings = array();

		for($i=0; $i < count($trainings); $i++)
		{
			$trainings[$i]->checked = in_array($trainings[$i]->training_id, $arrpre);
			$arrtrainings[$trainings[$i]->training_topic][] = $trainings[$i];
		}


		$tree = "";
		$this->topicmodel->getAllTopicsTree($tree, 0, $arrtrainings);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("id", $id);
		$this->mysmarty->assign("lprerequisite_info",$this->config->item("lprerequisite_info"));

		$this->mysmarty->display("training/prequisite.html");
	}

	function getdelegetion()
	{

		$this->checkadmin();

		$recordperpage = $this->commonmodel->getRecordPerPage();

		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;

		$this->db->order_by("user_npk", "asc");

		if ($this->sess['user_type'] != 0)
		{
			$this->db->where("training_creator", $this->sess['user_id']);
		}

		$this->db->where("training_name", $_POST['_name']);
		$this->db->where("training_topic", $_POST['_topic']);
		$this->db->join("training", "training_id = delegetion_training");
		$this->db->join("user", "user_id = delegetion_user");
		$q = $this->db->get("delegetion", $limit, $offset);
		$list = $q->result();

		for($i=0; $i < count($list); $i++)
		{
			$t = dbintmaketime($list[$i]->delegetion_created, 0);

			$list[$i]->delegetion_created_fmt = date("d/m/Y", $t);
		}

		$this->db->flush_cache();

		if ($this->sess['user_type'] != 0)
		{
			$this->db->where("training_creator", $this->sess['user_id']);
		}
		$this->db->where("training_name", $_POST['_name']);
		$this->db->where("training_topic", $_POST['_topic']);
		$this->db->join("training", "training_id = delegetion_training");
		$this->db->join("user", "user_id = delegetion_user");
		$total = $this->db->count_all_results("delegetion");

		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

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
		$this->pagination1->lang_title = $this->config->item('lright');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());

		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);

		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("ldelegtion", $this->config->item('ldelegtion'));
		$this->mysmarty->assign("luser", $this->config->item('user'));
		$this->mysmarty->assign("ldate", $this->config->item('ldate'));
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("date_added", $this->config->item("date_added"));
		$this->mysmarty->assign("lplease_select_user", $this->config->item("lplease_select_user"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("pageid", $this->pageid());

		$this->mysmarty->display("training/delegetion.html");
	}

	function adddelegetion()
	{
		$this->checkadmin();

		if (! isset($this->sess))
		{
			echo json_encode(array("error"=>true));
			return;
		}

		$topic = isset($_POST['_topic']) ? $_POST['_topic'] : 0;
		$name = isset($_POST['_name']) ? $_POST['_name'] : "";
		$userids = isset($_POST['userids']) ? $_POST['userids'] : 0;

		if (! $userids)
		{
			echo json_encode(array("error"=>true));
			return;
		}


		$this->db->where("training_topic", $topic);
		$this->db->where("training_name", $name);

		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			echo json_encode(array("error"=>true));
			return;
		}

		$row = $q->row();

		unset($data);

		$data['delegetion_training'] = $row->training_id;
		$data['delegetion_creator'] = $this->sess['user_id'];
		$data['delegetion_created'] = date("Ymd");

		foreach($userids as $userid)
		{
			$data['delegetion_user'] = $userid;
			$this->db->insert("delegetion", $data);
		}

		echo json_encode(array("error"=>false, "trainingid"=>$row->training_id));
	}

	function removedelegetion()
	{
		$this->db->where("delegetion_id", $_POST['id']);
		$this->db->delete("delegetion");
	}

	function getparticipant()
	{
		$this->checkadmin();

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$training_npk_time_id = !empty($_REQUEST['training_periode']) ? $_REQUEST['training_periode'] : 0;

		if (! $topic)
		{

			$errs[]= $this->config->item("err_select_topic");

			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		$this->db->where("training_name", $name);
		$this->db->where("training_topic", $topic);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			$errs[]= $this->config->item("err_not_exist_training_name");

			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		$rowtraining = $q->row();

		if(empty($training_npk_time_id)) {
			$this->db->where("training_time_training", $rowtraining->training_id);
			$q = $this->db->get("training_time");
			$rowtimetraining = $q->result();

			$data_time = array();
			foreach ($rowtimetraining as $value) {
				$data_time[] = $value->training_time_id;
			}

			if(!empty($data_time)) {
				//$this->db->where_in('training_npk_time_id', $data_time);
				$this->db->where('training_npk_time_id', 0);
			}
		} else {
			$this->db->where('training_npk_time_id', $training_npk_time_id);
		}

		$this->db->where("training_npk_training", $rowtraining->training_id);
		$q = $this->db->get("training_npk");
		$this->db->flush_cache();

		$npks = $q->result();

		$this->db->where("training_levelgroup_training", $rowtraining->training_id);
		$totallevelgroup = $this->db->count_all_results("training_levelgroup");

		if ($totallevelgroup == 0)
		{
			$this->db->where("training_jabatan_training", $rowtraining->training_id);
			$totallevelgroup = $this->db->count_all_results("training_jabatan");

		}

		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);

		$this->mysmarty->assign("levels", $arrlevel);
		$this->mysmarty->assign("isopenroot", $totallevelgroup > 0);
		$this->mysmarty->assign("training", $rowtraining);
		$this->mysmarty->assign("training_npk_time_id", $training_npk_time_id);
		$this->mysmarty->assign("npks", $npks);
		$this->mysmarty->assign("totalnpk", count($npks));
		$this->mysmarty->assign("ljabatan", $this->config->item("ljabatan"));
		$this->mysmarty->assign("lall_staff", $this->config->item("all_staff"));
		$this->mysmarty->assign("ok_update_participant_training", $this->config->item("ok_update_participant_training"));
		$this->mysmarty->assign("lerr_choose_npk", $this->config->item("lerr_choose_npk"));
		$this->mysmarty->assign("limport_npk", $this->config->item("limport_npk"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("ljabatan", $this->config->item("ljabatan"));
		$this->mysmarty->assign("lgroup_list", $this->config->item("group_list"));
		$this->mysmarty->assign("lcatjabatan", $this->config->item("lcatjabatan"));

		$this->mysmarty->display("training/participant.html");
	}

	function prefix()
	{
		return "TRN";
	}

	function form()
	{
		$this->checkadmin();

		if (! isset($this->modules[$this->pageid()]))
		{
			$id = $this->uri->segment(3);
			if ($id)
			{
				if (! isset($this->delegetions[$id]))
				{
					redirect(base_url());
				}
			}
			else
			{
				redirect(base_url());
			}
		}

		$id = $this->uri->segment(3);
		$topicid = $this->uri->segment(4);

		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);

			$_POST['cat'] = $mycategory->category_name;
			$_POST['topic'] = $topicid;

			$this->mysmarty->assign("topicid", $topicid);

			$def = $mycategory->category_id;
		}

		if ($id)
		{
			$this->db->where("training_id", $id);
			$this->db->join("category", "category_id = training_topic");
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$training = $q->row();

			if ($training->training_data)
			{
				$this->mysmarty->assign("extdata", json_decode($training->training_data));
			}

			$training->category = $this->topicmodel->getCategory($training->training_topic);
			$training->training_duration_hour = floor($training->training_duration/3600);
			$training->training_duration_minute = floor(($training->training_duration%3600)/60);

			$this->db->order_by("training_time_date1", "asc");
			$this->db->where("training_time_training", $id);
			$q = $this->db->get("training_time");
			$this->db->flush_cache();

			$training->time = $q->result();
			for($i=0; $i < count($training->time); $i++)
			{
				$t1 = dbintmaketime($training->time[$i]->training_time_date1, 0);
				$training->time[$i]->training_time_date1_fmt = date("d/m/Y", $t1);

				$t1 = dbintmaketime($training->time[$i]->training_time_date2, 0);
				$training->time[$i]->training_time_date2_fmt = date("d/m/Y", $t1);
			}

			$this->mysmarty->assign("training", $training);

			$def = $training->category->category_id;
		}
		else
		if (! isset($def))
		{
			$def = 0;
		}

		$this->db->where("user_id", $this->sess['user_id']);
		$q = $this->db->get("user");
		$this->db->flush_cache();

		if ($id == 0)
		{
			$this->db->order_by("training_id", "desc");
			$q = $this->db->get("training", 1, 0);

			if ($q->num_rows() == 0)
			{
				$_POST['code'] = sprintf("%s-%06d", $this->prefix(), 1);
			}
			else
			{
				$rowseq = $q->row();
				$_POST['code'] = sprintf("%s-%06d", $this->prefix(), $rowseq->training_id+1);
			}

			$this->db->flush_cache();
		}


		if ($id && ($this->pageid() == "classroom"))
		{
			$this->db->where("training_lokasi_training", $id);
			$this->db->join("training_lokasi", "lokasi_id = training_lokasi_lokasi");
			$q = $this->db->get("lokasi");
			$this->db->flush_cache();

			$lokasitrainings = $q->result();

			$this->db->order_by("lokasi_kota", "asc");
			$this->db->distinct();
			$this->db->select("lokasi_kota");
			$q = $this->db->get("lokasi");
			$this->db->flush_cache();
			$rowlokasies = $q->result();

			$this->mysmarty->assign("rowlokasies", $rowlokasies);
			$this->mysmarty->assign("lokasitrainings", $lokasitrainings);
		}

		if ($this->pageid() == "training")
		{
			$ladd_training_time = $this->config->item('ladd_training_time');
		}
		else
		if ($this->pageid() == "certificate")
		{
			$ladd_training_time = $this->config->item('ladd_certificate_time');
		}
		else
		if ($this->pageid() == "classroom")
		{
			$ladd_training_time = $this->config->item('ladd_classroom_time');
		}

		$this->mysmarty->assign("user", $q->row_array());
		$this->mysmarty->assign("lcertificate_time", $this->config->item("certificate_time"));
		$this->mysmarty->assign("ltraining_code", ($this->pageid() == "training")?$this->config->item("ltraining_code"):$this->config->item("lcertification_code"));
		$this->mysmarty->assign("category", $this->config->item("category"));
		$this->mysmarty->assign("topic", $this->config->item("topic"));
		$this->mysmarty->assign("description", $this->config->item("description"));
		$this->mysmarty->assign("materi_location", $this->config->item("materi_location"));
		$this->mysmarty->assign("training_time", $this->config->item("training_time"));
		$this->mysmarty->assign("until", $this->config->item("until"));
		$this->mysmarty->assign("period", $this->config->item("period"));
		$this->mysmarty->assign("per_month", $this->config->item("per_month"));
		$this->mysmarty->assign("per_year", $this->config->item("per_year"));
		$this->mysmarty->assign("author", $this->config->item("author"));
		$this->mysmarty->assign("first_name", $this->config->item("first_name"));
		$this->mysmarty->assign("last_name", $this->config->item("last_name"));
		$this->mysmarty->assign("initial", $this->config->item("initial"));
		$this->mysmarty->assign("email", $this->config->item("email"));
		$this->mysmarty->assign("training_name", $this->config->item("training_name"));
		$this->mysmarty->assign("ok_save_training", $this->config->item("ok_add_training"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));
		$this->mysmarty->assign("lcreate_course", $this->config->item("lcreate_course"));
		$this->mysmarty->assign("ladd_training_time", $ladd_training_time);
		$this->mysmarty->assign("certificate_name", $this->config->item('certificate_name'));
		$this->mysmarty->assign("lcreate_certificate", $this->config->item('lcreate_certificate'));
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("lcost",getconfig('lcost'));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lduration", $this->config->item("lduration"));
		$this->mysmarty->assign("lhour", $this->config->item("lhour"));
		$this->mysmarty->assign("lminute", $this->config->item("lminute"));
		$this->mysmarty->assign("lclassroom", $this->config->item("lclassroom_name"));
		$this->mysmarty->assign("lclassroom_update", $this->config->item("lclassroom_update"));
		$this->mysmarty->assign("lvendor_name", $this->config->item("lvendor_name"));
		$this->mysmarty->assign("lbatch", $this->config->item("lbatch"));
		$this->mysmarty->assign("llokasi", $this->config->item("llokasi"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("lrefreshment", $this->config->item("lrefreshment"));
		$this->mysmarty->assign("lmonth", $this->config->item("lmonth"));
		$this->mysmarty->assign("lcertificate_template", $this->config->item("lcertificate_template"));
		$this->mysmarty->assign("llast_date", $this->config->item("llast_date"));
		$this->mysmarty->assign("unique", md5(uniqid('')));

		for($i=1; $i <= 31; $i++)
		{
			$dates[] = $i;
		}
		$this->mysmarty->assign("dates", $dates);

		$tree = "";

		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("lroot", $this->config->item('lroot'));
		$this->mysmarty->assign("tree", $tree);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/form.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formdate()
	{
		$this->mysmarty->assign("lrefreshment", $this->config->item("lrefreshment"));
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("lastid", $_POST['lastid']);
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));
		$this->mysmarty->assign("period", $this->config->item("period"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));
		$this->mysmarty->assign("lper_month", $this->config->item("lper_month"));

		$this->mysmarty->display("training/formdate.html");
	}


	function checkadmin($redirect=true)
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			if ($redirect)
			{
				redirect(base_url());
				return false;
			}
		}

		$this->sess = unserialize($usess);

		return true;
	}

	function saveprequisite()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$errs = array();
		if (strlen($topic) == 0)
		{
			$errs[] = $this->config->item("err_select_topic");
		}

		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_emtpy_training_name");
		}
		else
		{
			$this->db->where("training_name", addslashes($name));
			$this->db->where("training_topic", $topic);

			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_training_name");
			}
			else
			{
				$rowtraining = $q->row();
			}
		}

		$id = $this->uri->segment(3);
		/*
		if (! isset($_POST['pre']))
		{
			if ($id == "post")
			{
				$errs[] = $this->config->item("err_empty_postrequisite");
			}
			else
			{
				$errs[] = $this->config->item("err_empty_prequisite");
			}
		}
		*/

		echo count($errs);
		echo "\1";

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		if ($id == "post")
		{
			$this->db->where("training_postrequisite_training", $rowtraining->training_id);
			$this->db->delete("training_postrequisite");
			$this->db->flush_cache();

			foreach($_POST['pre'] as $pre)
			{
				unset($data);

				$data['training_postrequisite_training'] = $rowtraining->training_id;
				$data['training_postrequisite_postrequisite'] = $pre;

				$this->db->insert("training_postrequisite", $data);
				$this->db->flush_cache();
			}

			return;
		}

		$this->db->where("training_prequisite_training", $rowtraining->training_id);
		$this->db->delete("training_prequisite");
		$this->db->flush_cache();

		foreach($_POST['pre'] as $pre)
		{
			unset($data);

			$data['training_prequisite_training'] = $rowtraining->training_id;
			$data['training_prequisite_prequisite'] = $pre;

			$this->db->insert("training_prequisite", $data);
			$this->db->flush_cache();
		}
	}

	//dalam satu training, tidak boleh diikuti oleh lebih dari satu peserta yang sama
	function saveparticipant()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo json_encode(array("err"=>1, "message"=>$this->config->item("err_exipred_session")));
			return;
		}

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$training_npk_time_id = !empty($_REQUEST['training_periode']) ? $_REQUEST['training_periode'] : 0;

		$errs = array();
		if (strlen($topic) == 0)
		{
			$errs[] = $this->config->item("err_select_topic");
		}

		if (strlen($name) == 0)
		{
			redirect(base_url()."index.php/user/logout");exit;
			$errs[] = $this->config->item("err_emtpy_training_name");
		}
		else
		{
			$this->db->where("training_name", addslashes($name));
			$this->db->where("training_topic", $topic);

			$q = $this->db->get("training");
			$this->db->flush_cache();
			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_training_name");
			}
			else
			{
				$rowtraining = $q->row();
			}
		}

		$allemp = isset($_POST['allemp']) ? $_POST['allemp'] : "";
		$jabatans = isset($_POST['jabatan']) ? $_POST['jabatan'] : array();
		$levelgroups = isset($_POST['levelgroup']) ? $_POST['levelgroup'] : array();
		$functions = isset($_POST['function']) ? $_POST['function'] : array();
		$npks = isset($_POST['npk']) ? $_POST['npk'] : array();

		$found = true;
		if ((! $allemp) && (! $jabatans) && (! $levelgroups) && (! $functions) && (! $npks))
		{
			$found = false;
		}

		foreach($_POST as $key=>$val)
		{
			$pos = strpos($key, "allnpk");
			if ($pos === FALSE) continue;

			$val = substr($key, $pos);
			if ($val <= 0) continue;

			$allnpk[] = $val;
			$found =  true;
		}

		if (! $found)
		{
			$errs[] = $this->config->item("err_empty_participant");
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");

			echo json_encode(array("err"=>1, "message"=>$html));
			return;
		}

		/*
        if(!empty($training_npk_time_id)) {
        	$this->db->where("training_npk_training", $rowtraining->training_id);
        	$this->db->where("training_npk_time_id", 0);
			$this->db->delete("training_npk");
        }
        */

		unset($data);
		$data['training_all_staff'] = $allemp;
		$data['training_modified'] = date("Y-m-d H:i:s");
		$data['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;

		$this->db->where("training_id", $rowtraining->training_id);
		$this->db->update("training", $data);

		if ($allemp)
		{
			$this->db->where("training_npk_training", $rowtraining->training_id);
			$this->db->delete("training_npk");

			$q = $this->db->get("user");
			$rows = $q->result();

			for($i=0; $i < count($rows); $i++)
			{
				unset($insert);

				$insert["training_npk_npk"] = $rows[$i]->user_id;
				$insert["training_npk_training"] = $rowtraining->training_id;
				$insert["training_npk_time_id"] = $training_npk_time_id;

				$this->db->insert("training_npk", $insert);
			}

			echo json_encode(array("err"=>0, "message"=>$this->config->item("ok_update_participant_training")));
			return;
		}

		// level group

		$this->db->where("training_levelgroup_training", $rowtraining->training_id);
		$this->db->delete("training_levelgroup");
		$this->db->flush_cache();


		if ($levelgroups)
		{
			$arrlevelgroups = array();
			foreach($levelgroups as $val)
			{
				$arrlevelgroups[] = $val;
				$this->levelmodel->getGroupChildIds($arrlevelgroups, $val);

			}

			$arrlevelgroups = array_unique($arrlevelgroups);

			foreach($arrlevelgroups as $val)
			{
				unset($data);

				$data['training_levelgroup_training'] = $rowtraining->training_id;
				$data['training_levelgroup_levelgroup'] = $val;

				$this->db->insert("training_levelgroup", $data);
			}

			// get npk by group

			/*$this->db->distinct();
			$this->db->select("user_id");
			$this->db->where_in("jabatan_level_group", $arrlevelgroups);
			$this->db->join("jabatan", "user_jabatan = jabatan_id");
			$q = $this->db->get("user");

			$rows = $q->result();

			for($i=0; $i < count($rows); $i++)
			{
				$userids[$rows[$i]->user_id] = true;
			}*/
		}

		// jabatan

		$this->db->where("training_jabatan_training", $rowtraining->training_id);
		$this->db->delete("training_jabatan");
		$this->db->flush_cache();

		if ($jabatans)
		{
			foreach($jabatans as $val)
			{
				unset($data);

				$data['training_jabatan_training'] = $rowtraining->training_id;
				$data['training_jabatan_jabatan'] = $val;

				$this->db->insert("training_jabatan", $data);
				$this->db->flush_cache();
			}


			/*
			$this->db->distinct();
			$this->db->select("user_id");
			$this->db->where_in("user_jabatan", $jabatans);
			$q = $this->db->get("user");

			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				$userids[$rows[$i]->user_id] = true;
			}*/

		}

		// npks
		/*
		$this->db->where("training_npk_training", $rowtraining->training_id);
		$this->db->where("training_npk_time_id", $training_npk_time_id);
		$this->db->delete("training_npk");
		*/
		$this->db->flush_cache();

		if ($npks)
		{
			foreach($npks as $val)
			{
                unset($data);
                $data = array();
                $q = $this->db->select("training_npk_npk")->where("training_npk_npk", $val)->where("training_npk_training", $rowtraining->training_id)->get("training_npk");
                //$q = $this->db->select("training_npk_npk")->where("training_npk_npk", $val)->where("training_npk_training", $rowtraining->training_id)->where("training_npk_time_id", $training_npk_time_id)->get("training_npk");
                if ($q->num_rows() == 0) {
                    $data['training_npk_training'] = $rowtraining->training_id;
                    $data['training_npk_npk'] = $val;
                    $data["training_npk_time_id"] = $training_npk_time_id;
                    $this->db->insert("training_npk", $data);
                } else {
                    $data["training_npk_time_id"] = $training_npk_time_id;
                    $this->db->where("training_npk_training", $rowtraining->training_id);
                    $this->db->where("training_npk_npk", $val);
                    $this->db->update("training_npk", $data);
                }
			}
		}

		/*
		if (isset($userids))
		{
			$npks1 = array_keys($userids);
			foreach($npks1 as $val)
			{
				unset($data);

				$data['training_npk_training'] = $rowtraining->training_id;
				$data['training_npk_npk'] = $val;

				$this->db->insert("training_npk", $data);
			}
		}*/
/*
		// function

		$this->db->where("training_function_training", $rowtraining->training_id);
		$this->db->delete("training_function");
		$this->db->flush_cache();

		if ($functions)
		{
			foreach($functions as $val)
			{
				unset($data);

				$data['training_function_training'] = $rowtraining->training_id;
				$data['training_function_function'] = $val;

				$this->db->insert("training_function", $data);
				$this->db->flush_cache();
			}
		}
*/
		echo json_encode(array("err"=>0, "message"=>$this->config->item("ok_update_participant_training")));
		return;
	}

	function savebanksoal()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$praexam = isset($_POST['praexam']) ? trim($_POST['praexam']) : "";
		$_praexam = isset($_POST['_praexam']) ? trim($_POST['_praexam']) : "";
		$exam = isset($_POST['exam']) ? trim($_POST['exam']) : "";
		$_exam = isset($_POST['_exam']) ? trim($_POST['_exam']) : "";
		$_pramax = isset($_POST['_pramax']) ? trim($_POST['_pramax']) : "1";
		$_max = isset($_POST['_max']) ? trim($_POST['_max']) : "1";
		$_prapass = isset($_POST['_prapass']) ? trim($_POST['_prapass']) : "0";
		$_pass = isset($_POST['_pass']) ? trim($_POST['_pass']) : "0";

		//-----extra pra-----------
		$_praAllDurationHour = isset($_POST['_praAllDurationHour']) ? trim($_POST['_praAllDurationHour']) : "0";
		$_praAllDurationMinute = isset($_POST['_praAllDurationMinute']) ? trim($_POST['_praAllDurationMinute']) : "0";
		$_praEachDuration = isset($_POST['_praEachDuration']) ? trim($_POST['_praEachDuration']) : "0";

		//------extra exam---------
		$_allDurationHour = isset($_POST['_allDurationHour']) ? trim($_POST['_allDurationHour']) : "0";
		$_allDurationMinute = isset($_POST['_allDurationMinute']) ? trim($_POST['_allDurationMinute']) : "0";
		$_eachDuration = isset($_POST['_eachDuration']) ? trim($_POST['_eachDuration']) : "0";

		$_prajmlsoal = isset($_POST['_prajmlsoal']) ? trim($_POST['_prajmlsoal']) : "";
		$_jmlsoal = isset($_POST['_jmlsoal']) ? trim($_POST['_jmlsoal']) : "";

		$errs = array();
		if (strlen($topic) == 0)
		{
			$errs[] = $this->config->item("err_select_topic");
		}

		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_emtpy_training_name");
		}
		else
		{
			$this->db->where("training_name", addslashes($name));
			$this->db->where("training_topic", $topic);

			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_training_name");
			}
			else
			{
				$rowtraining = $q->row();
			}
		}

		if ($praexam)
		{
			if (! $_praexam)
			{
				$errs[] = $this->config->item("err_emtpy_banksoal_praexam");
			}
			else
			{
				$this->db->where("banksoal_name", $_praexam);
				$q = $this->db->get("banksoal");
				$this->db->flush_cache();

				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("err_emtpy_banksoal_praexam");
				}
				else
				{
					$rowpraexam = $q->row();

					$this->db->where("banksoal_question_banksoal", $rowpraexam->banksoal_id);
					$this->db->where("banksoal_type", 1);
					$this->db->join("banksoal", "banksoal_id = banksoal_question_banksoal");

					$q = $this->db->get("banksoal_question");
					$totaljmlsoal = $q->num_rows();
				}
			}

			if (strlen($_prajmlsoal) == 0)
			{
				$errs[] = $this->config->item("err_empty_prajmlsoal");
			}
			else
			if ((! is_numeric($_prajmlsoal)) || ($_prajmlsoal <= 0))
			{
				$errs[] = $this->config->item("err_invalid_prajmlsoal");
			}
			else
			if ($totaljmlsoal < $_prajmlsoal)
			{
				$errs[] = sprintf($this->config->item("err_max_prajmlsoal"), $totaljmlsoal);
			}

			if (! is_numeric($_pramax))
			{
				$errs[] = $this->config->item("err_invalid_pramax");
			}

			if ($_prapass && (! is_numeric($_prapass)))
			{
				$errs[] = $this->config->item("err_invalid_prapass");
			}
		}

		if ($exam)
		{
			if (! $_exam)
			{
				$errs[] = $this->config->item("err_emtpy_banksoal_exam");
			}
			else
			{
				$this->db->where("banksoal_name", $_exam);
				$q = $this->db->get("banksoal");
				$this->db->flush_cache();

				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("err_emtpy_banksoal_exam");
				}
				else
				{
					$rowexam = $q->row();

					$this->db->where("banksoal_question_banksoal", $rowexam->banksoal_id);
					$this->db->where("banksoal_type", 1);
					$this->db->join("banksoal", "banksoal_id = banksoal_question_banksoal");

					$q = $this->db->get("banksoal_question");
					$totaljmlsoal = $q->num_rows();
				}
			}

			if (strlen($_jmlsoal) == 0)
			{
				$errs[] = $this->config->item("err_empty_jmlsoal");
			}
			else
			if ((! is_numeric($_jmlsoal)) || ($_jmlsoal <= 0))
			{
				$errs[] = $this->config->item("err_invalid_jmlsoal");
			}
			else
			if ($totaljmlsoal < $_jmlsoal)
			{
				$errs[] = sprintf($this->config->item("err_max_jmlsoal"), $totaljmlsoal);
			}

			if (! is_numeric($_max))
			{
				$errs[] = $this->config->item("err_invalid_max");
			}

			if ($_pass && (! is_numeric($_pass)))
			{
				$errs[] = $this->config->item("err_invalid_prapass");
			}
		}

		echo count($errs);
		echo "\1";

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		$this->db->where("training_exam_training", $rowtraining->training_id);
		$this->db->delete("training_exam");
		$this->db->flush_cache();

		if ($praexam)
		{
			unset($data);

			$data['training_exam_training'] = $rowtraining->training_id;
			$data['training_exam_banksoal'] = $rowpraexam->banksoal_id;
			$data['training_exam_type'] = 1;
			$data['training_exam_max'] = $_pramax;
			$data['training_exam_pass'] = $_prapass;
			$data['training_exam_jmlsoal'] = $_prajmlsoal;
			$data['training_exam_duration'] = $_praAllDurationHour*3600+$_praAllDurationMinute*60;
			$data['training_exam_durationperquestion'] = $_praEachDuration;

			$this->db->insert("training_exam", $data);
		}

		if ($exam)
		{
			unset($data);

			$data['training_exam_training'] = $rowtraining->training_id;
			$data['training_exam_banksoal'] = $rowexam->banksoal_id;
			$data['training_exam_type'] = 2;
			$data['training_exam_max'] = $_max;
			$data['training_exam_pass'] = $_pass;
			$data['training_exam_jmlsoal'] = $_jmlsoal;
			$data['training_exam_duration'] = $_allDurationHour*3600+$_allDurationMinute*60;
			$data['training_exam_durationperquestion'] = $_eachDuration;

			$this->db->insert("training_exam", $data);
		}
	}

	function save($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$cat = isset($_POST['cat']) ? trim($_POST['cat']) : "";
		$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$cost = isset($_POST['cost']) ? trim($_POST['cost']) : "";

		$refreshment = isset($_POST['refreshment']) ? trim($_POST['refreshment']) : 0;
		$refreshment = $refreshment ? $refreshment : 0;

		$materi_type = isset($_POST['materi_type']) ? trim($_POST['materi_type']) : "";
		$materioffline = isset($_POST['materioffline']) ? trim($_POST['materioffline']) : "";

		$authorname1 = isset($_POST['authorname1']) ? trim($_POST['authorname1']) : "";
		$authorname2 = isset($_POST['authorname2']) ? trim($_POST['authorname2']) : "";
		$initial = isset($_POST['initial']) ? trim($_POST['initial']) : "";
		$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		$code = isset($_POST['code']) ? trim($_POST['code']) : "";

		$dhour = isset($_POST['dhour']) ? trim($_POST['dhour']) : 0;
		$dminute = isset($_POST['dminute']) ? trim($_POST['dminute']) : 0;
		$batch = isset($_POST['batch']) ? trim($_POST['batch']) : 0;

		$errs = array();
		if (strlen($cat) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("category_id", addslashes($cat));
			$q = $this->db->get("category");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_category_name");
			}
			else
			{
				$rowcat = $q->row();
			}
		}

		if (! $topic)
		{
			$errs[] = $this->config->item("err_select_topic");
		}

		if (strlen($name) == 0)
		{
			if ($this->pageid() == "training")
			{
				$errs[] = $this->config->item("err_emtpy_training_name");
			}
			else
			if ($this->pageid() == "certificate")
			{
				$errs[] = $this->config->item("err_emtpy_certificate_name");
			}
			else
			{
				$errs[] = $this->config->item("err_emtpy_classroom_name");
			}
		}
		else
		{
			$this->db->where("training_name", addslashes($name));
			$this->db->where("training_topic", $topic);
			$q = $this->db->get("training");
			$this->db->flush_cache();

		}

		if ($edit == 0)
		{
			if ($this->pageid() != "classroom")
			{
				if (strlen($code) == 0)
				{
					$errs[] = $this->config->item("err_emtpy_training_code");
				}
				else
				{
					$this->db->where("training_code", addslashes($code));
					$q = $this->db->get("training");
					$this->db->flush_cache();
					if ($q->num_rows() > 0)
					{
						$rowcode = $q->row();
						if ($rowcode->training_id != $edit)
						{
							$errs[] = $this->config->item("err_exist_training_code");
						}
					}
				}
			}
		}

		if ($this->pageid() == "training")
		{
			if ($materi_type == 2)
			{
				if (strlen($materioffline) == 0)
				{
					$errs[] = $this->config->item("err_emtpy_material_location");
				}
			}
			else
			{
				if ($edit)
				{
					$this->db->where("training_id", $edit);
					$q = $this->db->get('training');
					$this->db->flush_cache();

					$rowedit = $q->row();
				}

				if (! $_FILES['materionline']['name'])
				{
					if ((! $edit) || ($rowedit->training_material_type == 2))
					{
						$errs[] = $this->config->item("err_emtpy_material_online");
					}
				}
				else
				if ($_FILES['materionline']['size'] <= 0)
				{
					$errs[] = $this->config->item("err_invalid_material_online");
				}
			}
		}

		if ($_FILES['certtpl']['tmp_name'])
		{
			$dirtpl = BASEPATH."../uploads/tmpl";
			if (! is_dir($dirtpl))
			{
				mkdir($dirtpl);
				chmod($dirtpl, 0777);
			}

			if ($_FILES['certtpl']['type'] != "text/html")
			{
				$errs[] = $this->config->item("lerr_certificate_template");
			}
		}

		if ($this->pageid() != "certificate")
		{
			if ($dhour && (! is_numeric($dhour)))
			{
				$errs[] = $this->config->item("linvalid_duration");
			}

			if ($dminute && (! is_numeric($dminute)))
			{
				$errs[] = $this->config->item("linvalid_duration");
			}
		}

		if ($this->pageid() == "classroom")
		{
			if ($batch && (! is_numeric($batch)))
			{
				$errs[] = $this->config->item("linvalid_batch");
			}
		}

		$i = 0;
		while(true)
		{
			$varname1 = "trainingdate".$i."_1";
			$varname2 = "trainingdate".$i."_2";
			$varname3 = "trainingrefresment".$i;

			if (! isset($_POST[$varname1]))
			{
				break;
			}

			if (! isset($_POST[$varname2]))
			{
				break;
			}

			$trainingdate1 = trim($_POST[$varname1]);
			$trainingdate2 = trim($_POST[$varname2]);
			$isrefreshment = isset($_POST[$varname3]);
			$period = $_POST['period'][$i];

			if ((! $trainingdate1) && (! $trainingdate2))
			{
				$i++;
				continue;
			}

			if (strlen($trainingdate1) == 0)
			{
				$errs[] = $this->config->item("err_emtpy_".$this->pageid()."date1");
				break;
			}

			$t1 = formmaketime($trainingdate1." 00:00:00");
			if (date('d/m/Y', $t1) != $trainingdate1)
			{
				$errs[] = $this->config->item("err_invalid_".$this->pageid()."date1");
				break;
			}

			if (strlen($trainingdate2) == 0)
			{
				$errs[] = $this->config->item("err_emtpy_".$this->pageid()."date2");
				break;
			}

			$t2 = formmaketime($trainingdate2." 00:00:00");
			if (date('d/m/Y', $t2) != $trainingdate2)
			{
				$errs[] = $this->config->item("err_invalid_".$this->pageid()."date2");
				break;
			}

			if ($t1 > $t2)
			{
				$errs[] = $this->config->item("err_invalid_".$this->pageid()."date");
				break;
			}

			if ($period && (! is_numeric($period)))
			{
				$errs[] = $this->config->item("err_invalid_".$this->pageid()."_period");
				break;
			}


			$trainingtime[] = array($t1, $t2, $period, $isrefreshment);
			$i++;
		}

		if (! isset($trainingtime))
		{
			if ($this->pageid() == "certificate")
			{
				if (count($errs) == 0)
				{
					$errs[] = $this->config->item("err_emtpy_".$this->pageid()."_period");
				}
			}
		}

		if (! is_numeric($refreshment))
		{
			$errs[] = $this->config->item("err_invalid_refreshment");
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";

			return;
		}

		if ($this->pageid() == "classroom")
		{
			$data['training_banksoal'] = $batch;
		}

		$data['training_data'] = "";
		$data['training_topic'] = $topic;
		$data['training_name'] = addslashes($name);
		$data['training_desc'] = addslashes($desc);
		$data['training_author_firstname'] = addslashes($authorname1);
		$data['training_author_lastname'] = addslashes($authorname2);
		$data['training_author_inital'] = addslashes($initial);
		$data['training_author_email'] = addslashes($email);
		$data['training_status'] = 1;
		$data['training_material_type'] = $materi_type;
		$data['training_cost'] = $cost;
		$data['training_refreshment'] = $refreshment;
		$data['training_modified'] = date("Y-m-d H:i:s");
		$data['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;

		if ($this->pageid() == "training")
		{
			$data['training_duration'] = $dhour*3600+$dminute*60;

			if ($_POST['materi_type'] == 2)
			{
				$data['training_material'] = $_POST['materioffline'];
			}
		}
		else
		{
			$data['training_material'] = "";
		}

		if ($edit)
		{
			if (($this->pageid() == "training") && ($_POST['materi_type'] == 1) && $_FILES['materionline']['name'])
			{
				$this->extracttraining($edit);

				$trainingidmaterial = sprintf("TRN-%06d", $edit);
				$data['training_material'] = $trainingidmaterial;
			}

			$this->db->where("training_id", $edit);
			$this->db->update("training", $data);
			$this->db->flush_cache();

			$lastid = $edit;

			if ($this->pageid() == "training")
			{
				$ltraining_save = $this->config->item("ok_update_training");
			}
			else
			if ($this->pageid() == "certificate")
			{
				$ltraining_save = $this->config->item("ok_update_certificate");
			}
			else
			if ($this->pageid() == "classroom")
			{
				$ltraining_save = $this->config->item("ok_update_classroom");
			}

			$redirect = site_url(array($this->pageid(), "showlist"));
		}
		else
		{
			$data['training_code'] = $code;
			$data['training_author_id'] = $this->sess['user_id'];
			$data['training_created_date'] = date('Ymd');
			$data['training_creator'] = $this->sess['user_id'];
			$data['training_type'] = $this->type();
			$data['training_created_date'] = date("Ymd");

			$this->db->insert("training", $data);

			$lastid = $this->db->insert_id();

			$redirect = site_url(array($this->pageid(), "participant", 0, $lastid));

			if ($this->pageid() == "training")
			{
				$ltraining_save = $this->config->item("ok_add_training");
			}
			else
			if ($this->pageid() == "certificate")
			{
				$ltraining_save = $this->config->item("ok_add_certificate");
			}
			else
			if ($this->pageid() == "classroom")
			{
				$ltraining_save = $this->config->item("ok_add_classroom");
			}

			if (($this->pageid() == "training") && ($_POST['materi_type'] == 1) && $_FILES['materionline']['name'])
			{
				$this->extracttraining($lastid);

				$trainingidmaterial = sprintf("TRN-%06d", $lastid);

				unset($data);

				$data['training_material'] = $trainingidmaterial;
				$data['training_modified'] = date("Y-m-d H:i:s");
				$data['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;

				$this->db->where("training_id", $lastid);
				$this->db->update("training", $data);
				$this->db->flush_cache();
			}
		}

		if ($lastid)
		{
			if ($_FILES['certtpl']['tmp_name'])
			{
				$dirtpl .= "/".$lastid;

				mkdir($dirtpl);
				chmod($dirtpl, 0777);

				$name = uniqid().".html";
				move_uploaded_file($_FILES['certtpl']['tmp_name'], $dirtpl."/".$name);

				unset($update);

				$update['training_cert_tpl'] = $name;
				$this->db->where("training_id", $lastid);
				$this->db->update("training", $update);
			}
			else
			{
				unset($update);

				$update['training_cert_tpl'] = "";
				$this->db->where("training_id", $lastid);
				$this->db->update("training", $update);
			}

			$this->db->where("training_time_training", $lastid);
			$this->db->delete("training_time");

			if (isset($trainingtime))
			{
				foreach($trainingtime as $val)
				{
					unset($data);

					$data['training_time_date1'] = date("Ymd", $val[0]);
					$data['training_time_date2'] = date("Ymd", $val[1]);
					$data['training_time_period'] = $refreshment;
					$data['training_time_training'] = $lastid;
					if ($val[3])
					{
						$data['training_time_parent'] = $lasttrainingtimeid;
					}
					else
					{
						$data['training_time_parent'] = 0;
					}


					$this->db->insert("training_time", $data);
					$lasttrainingtimeid = $this->db->insert_id();
				}
			}

			// lokasi training

			if ($this->pageid() == "classroom")
			{
				$this->db->where("training_lokasi_training", $lastid);
				$this->db->delete("training_lokasi");
				$this->db->flush_cache();

				if (isset($_POST['city']))
				{

					$q = $this->db->get("lokasi");
					$this->db->flush_cache();

					$rowlokasies = $q->result();
					for($i=0; $i < count($rowlokasies); $i++)
					{
						$lokasies[strtoupper($rowlokasies[$i]->lokasi_kota)][strtoupper($rowlokasies[$i]->lokasi_alamat)] = $rowlokasies[$i]->lokasi_id;
					}

					for($i=0; $i < count($_POST['city']); $i++)
					{
						$kota = strtoupper($_POST['city'][$i]);
						$alamat = strtoupper($_POST['address'][$i]);

						if (isset($lokasies[$kota][$alamat]))
						{
							$lokasiid = $lokasies[$kota][$alamat];
						}
						else
						{
							unset($data);

							$data['lokasi_kota'] = $_POST['city'][$i];
							$data['lokasi_alamat'] = $_POST['address'][$i];
							$data['lokasi_creator'] = $this->sess['user_id'];
							$data['lokasi_created'] = date("Ymd");
							$data['lokasi_status'] = 1;

							$this->db->insert("lokasi", $data);
							$lokasiid = $this->db->insert_id();
						}

						unset($data);

						$data['training_lokasi_lokasi'] = $lokasiid;
						$data['training_lokasi_training'] = $lastid;

						$this->db->insert("training_lokasi", $data);
					}
				}
			}
		}

		echo "<script>parent.setSuccess('".$ltraining_save."', '".$redirect."')</script>";
	}

	function extracttraining($id)
	{
		$trainingnameid = sprintf("TRN-%06d", $id);

		@mkdir(BASEPATH.'../material/'.$trainingnameid);

		$this->load->library('unzip');

		$config['fileName']  = $_FILES['materionline']['tmp_name'];
		$config['targetDir'] = BASEPATH.'../material/'.$trainingnameid;
		$this->unzip->initialize($config);
		$this->unzip->unzipAll();
	}

	function getlist()
	{
		$category = isset($_POST['category']) ? trim($_POST['category']) : "";
		$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		$pageid = isset($_POST['pageid']) ? trim($_POST['pageid']) : "";

		if ($topic)
		{
			$this->db->where("training_topic", $topic);
		}
		else
		if ($category)
		{
			$this->db->where("training_status", 1);
			$this->db->where("training_parent", 0);
			$this->db->where("training_name", $category);
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows())
			{
				$cat = $q->row();

				$topics = array();
				$this->topicmodel->getAllTopics($topics, $cat->category_id);

				$this->db->where_in("training_topic", $topics);
			}
		}

		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if (isset($_POST['checkcreator']) && ($sess['user_type'] != 0))
		{
			$this->db->where("training_creator", $sess['user_id']);
		}

		$this->db->order_by("training_name", "asc");
		$this->db->where("training_status", 1);
		if ($pageid == "training")
		{
			$this->db->where("training_type", 1);
		}
		else
		if ($pageid == "certificate")
		{
			$this->db->where("training_type", 2);
		}

		$q = $this->db->get("training");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}
			echo $list[$i]->training_name;
		}
	}

	function getselectbox()
	{
		$category = isset($_POST['category']) ? trim($_POST['category']) : "";
		$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		$pageid = isset($_POST['pageid']) ? trim($_POST['pageid']) : "";

		if ($topic)
		{
			$this->db->where("training_topic", $topic);
		}
		else
		if ($category)
		{
			$this->db->where("training_status", 1);
			$this->db->where("training_parent", 0);
			$this->db->where("training_name", $category);
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows())
			{
				$cat = $q->row();

				$topics = array();
				$this->topicmodel->getAllTopics($topics, $cat->category_id);

				$this->db->where_in("training_topic", $topics);
			}
		}

		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if (isset($_POST['checkcreator']) && ($sess['user_type'] != 0))
		{
			$this->db->where("training_creator", $sess['user_id']);
		}

		$this->db->order_by("training_name", "asc");
		//$this->db->where("training_status", 1);

		if (isset($_POST['ismaterial']))
		{
			$this->db->where("training_material_type", 1);
		}

		if ($pageid == "training")
		{
			$this->db->where("training_type", 1);
		}
		else
		if ($pageid == "certificate")
		{
			$this->db->where("training_type", 2);
		}

		$q = $this->db->get("training");
		$list = $q->result();
		//echo $this->db->last_query(); exit();

		$delegate_training = $this->check_delegate_training($sess['user_id'], $topic);
		if(!empty($delegate_training)) {
			$tmp = array();
			if(!empty($list)) {
				foreach ($list as $value) {
					$tmp[$value->training_id] = 1;
				}
			}

			foreach ($delegate_training as $value) {
				if(!empty($tmp[$value->training_id])) continue;
				$list[] = $value;
			}
		}

		$this->mysmarty->assign("def", isset($_POST['def']) ? $_POST['def'] : "");
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("trainings", $list);
		$this->mysmarty->display("training/selectbox.html");
	}

	function getperiode()
	{
		$topic_id = isset($_POST['topic_id']) ? trim($_POST['topic_id']) : "";
		$training_name = isset($_POST['training_name']) ? trim($_POST['training_name']) : "";
		$training_npk_time_id = isset($_POST['training_npk_time_id']) ? trim($_POST['training_npk_time_id']) : "";

		$this->db->select("training_time_id, DATE_FORMAT(training_time_date1, '%d-%m-%Y') as date_1, DATE_FORMAT(training_time_date2, '%d-%m-%Y') as date_2 ", false);

		$this->db->where("training_topic", $topic_id);
		$this->db->where("training_name", $training_name);
		$this->db->where("training_status", 1);

		$this->db->join("training", "training_time_training = training_id");
		$q = $this->db->get("training_time");
		$list = $q->result();

		$this->mysmarty->assign("trainingperiodes", $list);
		$this->mysmarty->assign("training_npk_time_id", $training_npk_time_id);
		$this->mysmarty->display("training/selecttrainingperiode.html");
	}

	function remove()
	{
		$this->checkadmin();

		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}

		$this->db->where("training_id", $id);
		$this->db->delete("training");

		redirect(site_url(array($this->pageid(), "showlist")));
	}

	function praexam()
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");
			$row = $q->row();

			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$this->mysmarty->assign("trainingid", $trainingid);

			$topicid = $row->training_topic;
			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;

			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("ledit_header", $this->config->item("lpraexam_lexam"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("lselect_training", $this->config->item("lselect_training"));
		$this->mysmarty->assign("url", site_url(array("training", "getpraexam")));
		$this->mysmarty->assign("praexam", 1);
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function getpraexam()
	{

		if (isset($_POST['_name']))
		{
			$name = isset($_POST['_name']) ? trim($_POST['_name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['_topic']))
		{
			$topic = isset($_POST['_topic']) ? trim($_POST['_topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		if (! $topic)
		{

			$errs[]= $this->config->item("err_select_topic");

			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		$this->db->where("training_topic", $topic);
		$this->db->where("training_name", $name);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			$errs[]= $this->config->item("err_not_exist_training_name");

			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		$rowtraining = $q->row();

		$this->db->join("banksoal", "banksoal_id = training_exam_banksoal");
		$this->db->where("training_exam_training", $rowtraining->training_id);
		$q = $this->db->get("training_exam");

		$this->mysmarty->assign("exam_pramax", 1);
		$this->mysmarty->assign("exam_max", 1);

		$this->mysmarty->assign("exam_prapass", "");
		$this->mysmarty->assign("exam_pass", "");

		if ($q->num_rows())
		{
			$exam = $q->result();
			for($i=0; $i <  count($exam); $i++)
			{
				if ($exam[$i]->training_exam_type == 1)
				{
					$this->mysmarty->assign("praexam_banksoal_name", $exam[$i]->banksoal_name);
					$this->mysmarty->assign("exam_pramax", $exam[$i]->training_exam_max ? $exam[$i]->training_exam_max : 0);
					$this->mysmarty->assign("exam_prapass", $exam[$i]->training_exam_pass);
					$this->mysmarty->assign("exam_prajmlsoal", $exam[$i]->training_exam_jmlsoal);

					$this->mysmarty->assign("praexam_banksoal_checked", 1);

					$tmp = $exam[$i]->training_exam_duration;
					$hour = !empty($tmp) ? floor($tmp / 3600) : 0;
					$minute = !empty($tmp) ? (($tmp % 3600) / 60) : 0;

					$this->mysmarty->assign("exam_praalldurationhour", $hour);
					$this->mysmarty->assign("exam_praalldurationminute", $minute);
					$this->mysmarty->assign("exam_praeachduration", $exam[$i]->training_exam_durationperquestion);

				}
				else
				if ($exam[$i]->training_exam_type == 2)
				{
					$this->mysmarty->assign("exam_banksoal_name", $exam[$i]->banksoal_name);
					$this->mysmarty->assign("exam_max", $exam[$i]->training_exam_max ? $exam[$i]->training_exam_max : 0);
					$this->mysmarty->assign("exam_pass", $exam[$i]->training_exam_pass);
					$this->mysmarty->assign("exam_jmlsoal", $exam[$i]->training_exam_jmlsoal);

					$this->mysmarty->assign("exam_banksoal_checked", 1);

					$tmp = $exam[$i]->training_exam_duration;
					$hour = !empty($tmp) ? floor($tmp / 3600) : 0;
					$minute = !empty($tmp) ? (($tmp % 3600) / 60) : 0;

					$this->mysmarty->assign("exam_alldurationhour", $hour);
					$this->mysmarty->assign("exam_alldurationminute", $minute);
					$this->mysmarty->assign("exam_eachduration", $exam[$i]->training_exam_durationperquestion);
				}
			}

		}

		$this->checkadmin();

		$this->mysmarty->assign("ok_update_banksoal", $this->config->item("ok_update_banksoal"));
		$this->mysmarty->assign("lpraexam", $this->config->item("lpraexam"));
		$this->mysmarty->assign("lexam", $this->config->item("lexam"));
		$this->mysmarty->assign("ltraining_max", $this->config->item("ltraining_max"));
		$this->mysmarty->assign("lbank_soal", $this->config->item("lbank_soal"));
		$this->mysmarty->assign("ltraining_pass", $this->config->item("ltraining_pass"));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));

		$this->mysmarty->display("training/praexam.html");
	}

	function materi($id)
	{

		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if ($this->trainingmodel->IsMaximumTaken($sess['user_id'], $id))
		{
			echo json_encode(array("err"=>1, "url"=>site_url(array("generalsetting", "errmessage", "errmaxtaken"))));

			return;
		}

		if (! $this->trainingmodel->IsGotPraexam($sess, $id))
		{
			echo json_encode(array("err"=>1, "url"=>site_url(array("generalsetting", "errmessage", "needpraexam"))));
			return;
		}


		$arrtopicids = array();
		$arrtopictrainingids = array();
		$arrtopiccertificateids = array();

		$this->topicmodel->getTopicsUser($sess, $arrtopicids, $arrtopictrainingids, $arrtopiccertificateids);

		$topicids = count($arrtopicids) ? array_keys($arrtopicids) : array(0);
		$topictrainingids = count($arrtopictrainingids) ? array_keys($arrtopictrainingids) : array(0);
		$topiccertificateids = count($arrtopiccertificateids) ? array_keys($arrtopiccertificateids) : array(0);


		if (count($topictrainingids) == 0)
		{
			echo json_encode(array("err"=>1, "url"=>base_url()));
			return;
		}

		if (! $this->trainingmodel->IsGotPrerequisite($sess, $id))
		{
			echo json_encode(array("err"=>1, "url"=>site_url(array("training", "errprequisite", $id))));
			return;
		}

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		if ($row->training_material_type == 1)
		{
			$url = base_url()."material/".$row->training_material."/";
			$message = "";
		}
		else
		{
			$url = $row->training_material;

			$message = sprintf($this->config->item("lopen_offline_material"), $row->training_material);
		}

                unset($data);

                $data['history_exam_training'] = $id;
                $data['history_exam_date'] = date("Ymd");
                $data['history_exam_time'] = date("Gis");
                $data['history_exam_score'] = 0;
                $data['history_exam_user'] = $sess['user_id'];
                $data['history_exam_ip'] = $_SERVER['REMOTE_ADDR'];
                $data['history_exam_status'] = 0;
                $data['history_exam_minscore'] = 0;
                $data['history_exam_type'] = 0;
                $data['history_exam_startdate'] = date("Ymd");
                $data['history_exam_starttime'] = date("Gis");
                $data['history_exam_no'] = 0;

                $this->db->insert("history_exam", $data);

		echo json_encode(array("err"=>0, "tipe"=>$row->training_material_type, "url"=>$url, "message"=>$message,"id"=>$id));

		return;
	}

	function materioffline($id=''){

		if($_POST['id'])
			$id = $_POST['id'];

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		$row = $q->row();


		$message = sprintf($this->config->item("lopen_offline_material"), $row->training_material);
		//$this->mysmarty->assign("main_content", "training/soal.html");

		$drive_letter = array();
		for($i=67;$i<91;$i++){
			$drive_letter[] = chr($i);
		};


		$this->mysmarty->assign("lmateri_offline_message", $this->config->item("lmateri_offline_message"));
		$this->mysmarty->assign("lcopy_paste", $this->config->item("lcopy_paste"));
		$this->mysmarty->assign("materi_path", $row->training_material);
		$this->mysmarty->assign("drive_letter", $drive_letter);
		$this->mysmarty->assign("drive_trn", $_POST['drive_trn']);
		$this->mysmarty->assign("id", $id);
		$this->mysmarty->display("training/materioffline.html");
	}

	function exam($id, $tipe=1, $win="self")
	{
		$this->_preexam($id, 2, $win);
	}

	function preexam($id, $win="self")
	{
		$this->_preexam($id, 1, "self");
	}

	function _preexam($id, $tipe=1, $win="self")
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if (! $sess)
		{
			redirect(base_url());
			return;
		}

		$privileges = $this->trainingmodel->GetPrivileges($sess, array($id));
		if (! isset($privileges[$id]))
		{
			//redirect(base_url());
			if($this->training_type == "certification")
				redirect(site_url(array("generalsetting", "errmessage", "errprivillege_certification",$id)));
			else
			if($this->training_type == "training")
				redirect(site_url(array("generalsetting", "errmessage", "errprivillege_training",$id)));
			else
				redirect(site_url(array("generalsetting", "errmessage", "errprivillege",$id)));

			return;
		}

		if (! $this->trainingmodel->IsGotPrerequisite($sess, $id))
		{
			redirect(site_url(array("training", "errprequisite", $id)));
			return;
		}

		if (! $this->trainingmodel->IsInPeriod($sess, $id))
		{
			//redirect(base_url());
			if($this->training_type == "certification")
				redirect(site_url(array("generalsetting", "errmessage", "errinperiod_certification",$id)));
			else
			if($this->training_type == "training")
				redirect(site_url(array("generalsetting", "errmessage", "errinperiod_training",$id)));
			else
				redirect(site_url(array("generalsetting", "errmessage", "errinperiod",$id)));
			return;
		}

		if ($this->trainingmodel->IsMaximumTaken($sess['user_id'], $id))
		{
			redirect(site_url(array("generalsetting", "errmessage", "errmaxtaken")));
			return;
		}

		if ($tipe == 2) //exam
		{
			if (! $this->trainingmodel->IsGotPraexam($sess, $id))
			{
				redirect(site_url(array("generalsetting", "errmessage", "needpraexam")));
				return;
			}

			if ($this->config->item("materi_mandatory"))
			{
				$res = $this->trainingmodel->GetHistoryExamByType($sess['user_id'],$id,0);
				if (($res === FALSE) || (count($res) == 0))
				{
					redirect(site_url(array("generalsetting", "errmessage", "needmateri")));
					return;
				}
			}
		}

		// cek apakah masih ada session

		$this->db->where("history_exam_training", 0);
		$this->db->where("history_exam_training", $id);
		$this->db->where("history_exam_date", 0);
		$this->db->where("history_exam_time", 0);
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("history_exam_type", $tipe);
		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		if ($q->num_rows() > 0)
		{
			$rowexam = $q->row();

			$this->db->where("history_exam_id", $rowexam->history_exam_id);
			$this->db->delete("history_exam");
			$this->db->flush_cache();

			$this->db->where("history_answer_history_exam", $rowexam->history_exam_id);
			$this->db->delete("history_answer");
			$this->db->flush_cache();
		}

		if ($this->trainingmodel->IsMaximum($sess, $id, $tipe))
		{
			redirect(site_url(array("training", "errmaxexam", $id, $tipe)));
			return;
		}

		// bank soal

		$this->db->where("training_id", $id);
		$this->db->where("training_exam_type", $tipe);
		$this->db->where("banksoal_question_status", 1);
		$this->db->where("banksoal_question_packet is NULL "); //not to get question of the certification
		$this->db->join("banksoal", "banksoal_id = banksoal_question_banksoal");
		$this->db->join("training_exam", "training_exam_banksoal = banksoal_id");
		$this->db->join("training", "training_exam_training = training_id");

		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(site_url(array("generalsetting", "errmessage", "lnot_enough_soal")));
			return;
		}

		$rowtraining = $q->row();
		$rowsoal = $q->result();

		$soalpilihan = $this->trainingmodel->acak(array($rowtraining->training_exam_jmlsoal, 1000, 1000, 1000), $rowsoal);
		$max = $this->trainingmodel->GetCertificateNo($tipe, $sess['user_id'], $id, date("Ymd"));

		if ($rowtraining->training_exam_jmlsoal > count($soalpilihan))
		{
			redirect(site_url(array("generalsetting", "errmessage", "lnot_enough_soal")));
			return;
		}

		// simpan session ke db

		unset($data);

		$data['history_exam_training'] = $id;
		$data['history_exam_date'] = date("Ymd");
		$data['history_exam_time'] = 0;
		$data['history_exam_score'] = 0;
		$data['history_exam_user'] = $sess['user_id'];
		$data['history_exam_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['history_exam_status'] = 0;
		$data['history_exam_minscore'] = $rowtraining->training_exam_pass;
		$data['history_exam_type'] = $tipe;
		$data['history_exam_startdate'] = date("Ymd");
		$data['history_exam_starttime'] = date("Gis");
		$data['history_exam_no'] = $max;
		$data['history_exam_duration'] = $rowtraining->training_exam_duration;
		$data['history_exam_durationperquestion'] = $rowtraining->training_exam_durationperquestion;

		$this->db->insert("history_exam", $data);
		$lastid = $this->db->insert_id();

		$i = 0;
		foreach($soalpilihan as $val)
		{
			unset($data);

			$data['history_answer_question'] = $rowsoal[$val]->banksoal_question_id;
			$data['history_answer_history_exam'] = $lastid;
			$data['history_answer_answer'] = -1;
			$data['history_answer_order'] = ++$i;

			$this->db->insert("history_answer", $data);
		}

		for($i=0; $i < count($soalpilihan); $i++)
		{
			$ids[] = $rowsoal[$soalpilihan[$i]]->banksoal_question_id;
		}

		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where_in("banksoal_answer_question", $ids);
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();

		$rowchoices = $q->result();
		for($i=0; $i < count($rowchoices); $i++)
		{
			$choices[$rowchoices[$i]->banksoal_answer_question][] = $rowchoices[$i];
		}

		for($i=0; $i < count($soalpilihan); $i++)
		{
			$rowsoal[$soalpilihan[$i]]->choices = $choices[$rowsoal[$soalpilihan[$i]]->banksoal_question_id];
			$mysoals[] = $rowsoal[$soalpilihan[$i]];
		}

		$showEach = $this->generalsettingmodel->GetInfo("showtrainingquestionall");
		$totallooptraining = $this->generalsettingmodel->GetInfo("totallooptraining");
		$showAllloop = $this->generalsettingmodel->GetInfo("typelooptraining");

		$this->getTimeExam($rowtraining);

		$this->mysmarty->assign("showEach", $showEach);
		$this->mysmarty->assign("totallooptraining", $totallooptraining);
		$this->mysmarty->assign("showAllloop", $showAllloop);

		$this->mysmarty->assign("lastid", $lastid);
		$this->mysmarty->assign("tipe", $tipe);
		$this->mysmarty->assign("win", $win);
		$this->mysmarty->assign("mysoals", $mysoals);
		$this->mysmarty->assign("rowtraining", $rowtraining);
		$this->mysmarty->assign("lexam", ($tipe==1) ? $this->config->item("lpraexam") : $this->config->item("lexam"));
		$this->mysmarty->assign("lselesai", $this->config->item("lselesai"));

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/soal.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function getTimeExam($rowtraining) {
		$duration = $rowtraining->training_exam_duration; // exam duration
		$durationperquestion = $rowtraining->training_exam_durationperquestion; // exam duration per question

		$d = date("Ymd"); // exam start date
    	$t = date("Gis"); // exam start time

		$starttime = dbintmaketime($d, $t);
		$nowtime = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));

		$delta = $nowtime - $starttime;
		$sisa = $duration - $delta;

		$h = floor($sisa/3600);
		$d = floor(($sisa%3600)/60);
		$s = ($sisa%3600)%60;

		$this->mysmarty->assign("watch", sprintf("%02d:%02d:%02d", $h, $d, $s));
		$this->mysmarty->assign("watch_hour", $h);
		$this->mysmarty->assign("watch_minute", $d);
		$this->mysmarty->assign("watch_second", $s);
		$this->mysmarty->assign("duration", $duration);
		$this->mysmarty->assign("durationperquestion", $durationperquestion);
	}

	function errmaxexam($id, $tipe)
	{
		switch ($tipe)
		{
			case 1:
				$this->mysmarty->assign("lmessage_error", $this->config->item("lmaxtaken_praexam"));
			break;
			case 2:
				$this->mysmarty->assign("lmessage_error", $this->config->item("lmaxtaken_exam"));
			break;
			case 3:
				$this->mysmarty->assign("lmessage_error", $this->config->item("lmaxtaken_certificate"));
			break;
		}

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/errmaxexam.html");
		$this->mysmarty->display("sess_template.html");
	}

	function errprequisite($id)
	{
		$this->db->where("training_prequisite_training", $id);
		$this->db->join("training", "training_prequisite_prequisite = training_id");
		$q = $this->db->get("training_prequisite");
		$this->db->flush_cache();

		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->training_id;
		}

		$this->db->where_in("training_exam_training", $ids);
		$q = $this->db->get("training_exam");
		$rowsexamtype = $q->result();
		for($i=0; $i < count($rowsexamtype); $i++)
		{
			$examtypes[$rowsexamtype[$i]->training_exam_training][] = $rowsexamtype[$i]->training_exam_type;
		}

		$this->db->where_in("history_exam_training", $ids);
		$this->db->where("((history_exam_type = 0) || ((history_exam_type = 2) && (history_exam_status = 1)))", null, false);
		$this->db->where("history_exam_user", $this->sess['user_id']);
		$q = $this->db->get("history_exam");
		$rowsexam = $q->result();

		// untuk praexam diproses lebih lanjut
		for($i=0; $i < count($rowsexam); $i++)
		{
			switch ($rowsexam[$i]->history_exam_type)
			{
				case 0:
					if (! isset($examtypes[$rowsexam[$i]->history_exam_training]))
					{
						$exams[$rowsexam[$i]->history_exam_training] = true;
					}
					else
					if (! in_array(2, $examtypes[$rowsexam[$i]->history_exam_training]))
					{
						$exams[$rowsexam[$i]->history_exam_training] = true;
					}
				break;
				case 2:
					$exams[$rowsexam[$i]->history_exam_training] = true;
			}
		}

		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->lulus = isset($exams[$rows[$i]->training_id]) ? $this->config->item("lsudah") : $this->config->item("lbelum");
			if ($rows[$i]->training_type == 1)
			{
				$trainings[] = $rows[$i];
			}
			else
			{
				$certificates[] = $rows[$i];
			}

		}


		$this->mysmarty->assign("trainings", isset($trainings) ? $trainings : false);
		$this->mysmarty->assign("certificates", isset($certificates) ? $certificates : false);

		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lonline_training", $this->config->item("online_training"));
		$this->mysmarty->assign("lerr_message", $this->config->item("lerrprequisite_message"));

		$this->mysmarty->assign("lcertification", $this->config->item("certification"));

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/errprequisite.html");
		$this->mysmarty->display("sess_template.html");
	}

	function savepraexam($trainingid, $type)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if (! $sess)
		{
			redirect(base_url());
			return;
		}

		foreach($_POST as $key=>$val)
		{
			$pos = strpos($key, "answer");
			if ($pos === FALSE) continue;

			$id = substr($key, strlen("answer"));
			$ids = explode("_", $id);

			unset($data);

			$data['history_answer_answer'] = $val;
			$this->db->where("history_answer_question", $ids[1]);
			$this->db->where("history_answer_history_exam", $ids[0]);
			$this->db->update("history_answer", $data);
			$this->db->flush_cache();
		}

		redirect(site_url(array("training", "score", $trainingid, $type, $_POST['examid'])));

	}

	function score($trainingid, $type=3, $examid=0){
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);
		if (! $sess)
		{
			redirect(base_url());
		}

		$rightanswered = 0;
		$wronganswered = 0;

		$res = $this->certificatemodel->GetSoal($sess, $trainingid, "asc", $type, $examid);
		if (count($res) == 0)
		{
			redirect(base_url());
		}

		for($i=0; $i < count($res); $i++)
		{
			if ($res[$i]->banksoal_question_answer == $res[$i]->history_answer_answer)
			{
				$rightanswered++;
			}
			else
			{
				$wronganswered++;
			}
		}

		if ($type == 3)
		{
			$pass = $res[0]->training_pass;
		}
		else
		{
			$this->db->where("training_exam_training", $trainingid);
			$this->db->where("training_exam_type", $type);
			$q = $this->db->get("training_exam");

			if ($q->num_rows() == 0)
			{
				$pass = 0;
			}
			else
			{
				$rowpass = $q->row();
				$pass = $rowpass->training_exam_pass;
			}

			$this->db->flush_cache();
		}

		$score = ($rightanswered*100)/count($res);
		if ($type == 1)
		{
			$statusstr = $this->config->item("lcompeted");
			$status = 0;
		}
		else
		{
			if ($score >= $pass)
			{
				$statusstr = $this->config->item("llulus");
				$status = 1;
			}
			else
			{
				$statusstr = $this->config->item("lnolulus");
				$status = 0;
			}
		}

		$t = dbintmaketime($res[0]->history_exam_startdate, $res[0]->history_exam_starttime);
 		//$t1 = dbintmaketime($res[0]->history_exam_date, $res[0]->history_exam_time);


 		if($res[0]->history_exam_time > 0) {
 			$t1 = dbintmaketime($res[0]->history_exam_date, $res[0]->history_exam_time);
			$now = $t1;
		}else {
			$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date('Y'));
		}

		/*if ($t == $t1)
		{
			$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date('Y'));
		}
		else
		{
			$now = $t1;
		}*/

		$len = $now-$t;

		$jam = floor($len/3600);
		$minute = floor(($len%3600)/60);
		$second = ($len%3600)%60;
		$length = sprintf("%02d:%02d:%02d", $jam, $minute, $second);

		unset($data);

		$data['history_exam_date'] = date("Ymd", $now);
		$data['history_exam_time'] = date("Gis", $now);
		$data['history_exam_score'] = $score;
		$data['history_exam_status'] = $status;

		$this->db->where("history_exam_id", $res[0]->history_exam_id);
		$this->db->update("history_exam", $data);
		$this->db->flush_cache();

		$this->session->unset_userdata("lmsv2_certificate_index");

		$this->mysmarty->assign("certificate_name", $res[0]->training_name);

		//get show min lulus dan print cert dari general settings
		$show_min_lulus = 0;
		$show_print = 0;
		if($this->training_type == "training" && $type <> "1"){ //not pra exam
			$show_min_lulus = $this->generalsettingmodel->GetInfo("showtrainingminlulus");
			$show_print = $this->generalsettingmodel->GetInfo("showtrainingprint");
		}else
		if($this->training_type == "certification"){
			$show_min_lulus = $this->generalsettingmodel->GetInfo("showcertificationminlulus");
			$show_print = $this->generalsettingmodel->GetInfo("showcertificationprint");
		}

		$min_score = $pass ;
		$this->mysmarty->assign("lrightanswered", $this->config->item("lrightanswered"));
		$this->mysmarty->assign("lwronganswered", $this->config->item("lwronganswered"));
		$this->mysmarty->assign("lscore", $this->config->item("lscore"));

		$this->mysmarty->assign("min_score", $min_score);
		$this->mysmarty->assign("show_min_lulus", $show_min_lulus);
		$this->mysmarty->assign("show_print", $show_print);

		$this->mysmarty->assign("training_type", $this->training_type);

		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ltraining_pass", $this->config->item("ltraining_pass"));
		$this->mysmarty->assign("llength", $this->config->item("llength"));
		$this->mysmarty->assign("ltraining_intro", $this->config->item("ltraining_intro"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));

		$this->mysmarty->assign("tgl", date("d-m-Y"));
		$this->mysmarty->assign("trainingid", $trainingid);
		$this->mysmarty->assign("rightanswered", $rightanswered);
		$this->mysmarty->assign("wronganswered", $wronganswered);
		$this->mysmarty->assign("score", number_format($score, 2, ",", ""));
		$this->mysmarty->assign("status", $statusstr);
		$this->mysmarty->assign("length", $length);
		$this->mysmarty->assign("statuscode", $status);
		$this->mysmarty->assign("examid", $res[0]->history_exam_id);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/summary.html");
		$this->mysmarty->display("sess_template.html");

	}
	function examthanks($id)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		$this->db->where("history_exam_id", $id);
		$this->db->where("history_exam_user", $sess['user_id']);

		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam");

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		if ($row->training_type == 1)
		{
			if ($row->history_exam_type == 1)
			{
				$this->mysmarty->assign("jenis_exam", "Pre-exam");
			}
			else
			{
				$this->mysmarty->assign("jenis_exam", "Exam");
			}
		}

		$this->mysmarty->assign("row", $row);
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/score-message.html");
		$this->mysmarty->display("sess_template.html");
	}

	function history($id=0, $tipe=2)
	{

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
			return;
		}

		$sess = unserialize($usess);

		$userid = isset($_POST["userid"]) ? $_POST["userid"] : 0;

		if (isset($sess['asadmin']) && ($sess['user_type'] == 0))
		{
			$this->db->order_by("user_npk", "asc");
			$q = $this->db->get("user");
			$this->db->flush_cache();

			$rowusers = $q->result();

			if (! $userid)
			{
				$userid = $rowusers[0]->user_id;
			}
		}

		$this->db->where("general_setting_code", "personalreportmateri");
		$q = $this->db->get("general_setting");

		if ($q->num_rows() == 0)
		{
			$showmaterihist = 0;
		}
		else
		{
			$rowsetting = $q->row();
			$showmaterihist = $rowsetting->general_setting_value == 1;
		}

		$recordperpage = $this->commonmodel->getRecordPerPage();

		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = (isset($_POST["sortby"]) && $_POST["sortby"]) ? $_POST["sortby"] : "training_code";
		$orderby = (isset($_POST["orderby"]) && $_POST["orderby"]) ? $_POST["orderby"] : "asc";
//echo $sortby.";".$orderby;
		$this->db->order_by($sortby, $orderby);

		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);

		if($tipe==2)
		{
			if ($showmaterihist)
			{
				$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' OR history_exam_type = '0')");
			}
			else
			{
				$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' )");
			}
		}
		else
		{
			$this->db->where("history_exam_type", $tipe);
		}

		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}
		else
		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}

		$this->db->distinct();
		$this->db->select("training.*, category.* ");
		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("category", "training_topic = category_id");
		if ($limit)
		{
			$q = $this->db->get("history_exam", $limit, $offset);
		}
		else
		{
			$q = $this->db->get("history_exam");
		}

		$this->db->flush_cache();
		$list = $q->result();

		$this->db->distinct();
		$this->db->select("history_exam_training");
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);

		if($tipe==2)
		{
			if ($showmaterihist)
			{
				$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' OR history_exam_type = '0' )");
			}
			else
			{
				$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' )");
			}
		}
		else
			$this->db->where("history_exam_type", $tipe);

		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}
		else
		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}

		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("category", "training_topic = category_id");
		$q = $this->db->get("history_exam");
		$total = $q->num_rows();

		$this->db->flush_cache();

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
		$this->pagination1->lang_title = $this->config->item('lhistory');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());

		$trainingids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$trainingids[] = $list[$i]->training_id;
		}

		$taketimes = $this->trainingmodel->taketimes($sess, $trainingids, $userid);
		$takelast = $this->trainingmodel->takelast($sess, $trainingids, $userid);
		$bestscore = $this->trainingmodel->bestscore($sess, $trainingids, $userid);

		for($i=0; $i < count($list); $i++)
		{
			unset($lasttakens);

			$list[$i]->nmaterial = isset($taketimes[0][$list[$i]->training_id]) ? $taketimes[0][$list[$i]->training_id] : 0;
			$list[$i]->npraexam = isset($taketimes[1][$list[$i]->training_id]) ? $taketimes[1][$list[$i]->training_id] : 0;
			$list[$i]->nexam = isset($taketimes[$tipe][$list[$i]->training_id]) ? $taketimes[$tipe][$list[$i]->training_id] : 0;

			$list[$i]->nexam_praexam = $list[$i]->npraexam + $list[$i]->nexam;
			if ($showmaterihist)
			{
				$list[$i]->nexam_praexam += $list[$i]->nmaterial;
				$list[$i]->lastmaterial = isset($takelast[0][$list[$i]->training_id]) ? $takelast[0][$list[$i]->training_id][0] : 0;

				$lasttakens[] = formmaketime($list[$i]->lastmaterial.":00");
			}

			$list[$i]->lastpraexam = isset($takelast[1][$list[$i]->training_id]) ? $takelast[1][$list[$i]->training_id][0] : 0;
			$list[$i]->lastexam = isset($takelast[$tipe][$list[$i]->training_id]) ? $takelast[$tipe][$list[$i]->training_id][0] : 0;

			$lasttakens[] = formmaketime($list[$i]->lastpraexam.":00");
			$lasttakens[] = formmaketime($list[$i]->lastexam.":00");

			sort($lasttakens, SORT_NUMERIC);

			$list[$i]->lasttaken = date("d/m/Y H:i", $lasttakens[count($lasttakens)-1]);

			$list[$i]->lastscorepraexam = isset($takelast[1][$list[$i]->training_id]) ? $takelast[1][$list[$i]->training_id][1] : "";
			$list[$i]->lastscoreexam = isset($takelast[$tipe][$list[$i]->training_id]) ? $takelast[$tipe][$list[$i]->training_id][1] : "";

			$list[$i]->bestscorepraexam = isset($bestscore[1][$list[$i]->training_id]) ? $bestscore[1][$list[$i]->training_id] : "";
			$list[$i]->bestscoreexam = isset($bestscore[$tipe][$list[$i]->training_id]) ? $bestscore[$tipe][$list[$i]->training_id] : "";

		}

		// terakhir diambil
		$ltraining_column = "";
		$lsort_by_code = $lsort_by_name = "";
		switch($this->pageid()){
			case "classroom":
			case "training" :
				$ltraining_column = ucfirst($this->config->item('training_name'));
				$lsort_by_code = ucfirst($this->config->item('lsort_by_training_code'));
				$lsort_by_name = ucfirst($this->config->item('lsort_by_training_name'));
			break;
			case "certificate":
				$ltraining_column = ucfirst($this->config->item('certificate_name'));
				$lsort_by_code = ucfirst($this->config->item('lsort_by_certification_code'));
				$lsort_by_name = ucfirst($this->config->item('lsort_by_certification_name'));
			break;
		}

		$this->mysmarty->assign("lsort_by_code",$lsort_by_code);
		$this->mysmarty->assign("lsort_by_name",$lsort_by_name);
		$this->mysmarty->assign("userid", $userid);
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));

		$this->mysmarty->assign("lcode", $this->config->item("lcode"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lmypersonal_report", strtoupper($this->config->item("lmypersonal_report")));
		$this->mysmarty->assign("ltraining_column",$ltraining_column);
		$this->mysmarty->assign("ltimetakes", ucfirst($this->config->item('ltimetakes')));
		$this->mysmarty->assign("llasttake", ucfirst($this->config->item('llasttake')));
		$this->mysmarty->assign("llastscore", ucfirst($this->config->item('llastscore')));
		$this->mysmarty->assign("luser", ucfirst($this->config->item('user')));
		$this->mysmarty->assign("lall_user", ucfirst($this->config->item('lall_user')));

		if (isset($sess['asadmin']) && ($sess['user_type'] == 0))
		{
			$this->mysmarty->assign("users", $rowusers);
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}

		$this->mysmarty->assign("main_content", "training/history.html");
		$this->mysmarty->display("sess_template.html");
	}

	function historydetail($id=0, $userid=0)
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		if (! $id)
		{
			redirect(base_url());
		}

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$rowtraining = $q->row();
		$this->mysmarty->assign("mytraining", $rowtraining);

		//$this->db->where("general_setting_code", "showmaterihist");
		$this->db->where("general_setting_code", "personalreportmateri");

		$q = $this->db->get("general_setting");

		if ($q->num_rows() == 0)
		{
			$showmaterihist = 0;
		}
		else
		{
			$rowsetting = $q->row();
			$showmaterihist = $rowsetting->general_setting_value == 1;
		}

		// list periode

		$this->db->where("training_time_parent >", 0);
		$this->db->where("training_time_training", $rowtraining->training_id);
		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		$rowtimes = $q->result();
		for($i=0; $i < count($rowtimes); $i++)
		{
			$trainingperiods[] = array($rowtimes[$i]->training_time_date1, $rowtimes[$i]->training_time_date2);
		}


		// list

		$this->db->order_by("history_exam_date", "desc");
		$this->db->order_by("history_exam_time", "desc");

		$this->db->where("history_exam_training", $rowtraining->training_id);

		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
			//$this->db->where("history_exam_reset", 0);
		}
		else
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}

		$this->db->where("history_exam_date >", 0);
		//$this->db->where("history_exam_time >", 0);	// 2013/03/20 dedy exam time yg lom di finish jg sdh di hitung

		//$this->db->where("history_exam_reset", 0);
		if (! $showmaterihist)
		{
			$this->db->where("history_exam_type <>", 0);
		}

		if ($this->pageid() == "classroom")
		{
			$this->db->join("lokasi", "history_exam_lokasi = lokasi_id");
		}

		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();
		$list = $q->result();

		$lastlulus = 0;
		for($i=count($list)-1; $i >= 0; $i--)
		{
			$list[$i]->datetime = dbintmaketime($list[$i]->history_exam_date, $list[$i]->history_exam_time);

			if ($list[$i]->training_refreshment <= 0) break;

			if ($i >= (count($list)-1)) continue;
			if ($list[$i]->history_exam_type == "1") continue;
			if ($list[$i]->history_exam_status != 1) continue;

			/*
			if ($list[$i+1]->refreshment)
			{
				$list[$i]->refreshment = true;
				continue;
			}
			* */

			if ($lastlulus == 0)
			{
				$lastlulus = $list[$i]->datetime;
				continue;
			}

			$nextt = mktime(date('G', $lastlulus), date('i', $lastlulus), date('s', $lastlulus), date('n', $lastlulus)+$list[$i]->training_refreshment, date('j', $lastlulus), date('Y', $lastlulus));
			$list[$i]->isrefreshment = $list[$i]->datetime > $nextt;
			if ($list[$i]->isrefreshment)
			{
				$hasrefreshment = true;
			}

			$lastlulus = $list[$i]->datetime;
		}

		for($i=0; $i < count($list); $i++)
		{
			$t = dbintmaketime($list[$i]->history_exam_date, $list[$i]->history_exam_time);;
			if ($this->pageid() == "classroom")
			{
				$list[$i]->datetime = date("d/m/Y", $t);
			}
			else
			{
				$list[$i]->datetime = date("d/m/Y H:i:s", $t);
			}

			$list[$i]->score = number_format($list[$i]->history_exam_score, 2, ".", "");

			if($list[$i]->history_exam_type == "0")  // materi
			{
				$list[$i]->status = $this->config->item('ltaken');
				$list[$i]->score = "";
				$list[$i]->activity = $this->config->item("lmateri");
			}
			else
			if($list[$i]->history_exam_type == "1")  // pre exam
			{
				$list[$i]->status = $this->config->item('lcompeted');
				if($list[$i]->history_exam_reset == "1")
				{
					$list[$i]->status .= " / ".$this->config->item('lreset');
				}
				$list[$i]->activity = $this->config->item("lpraexam");
			}
			else
			if ($list[$i]->history_exam_status == 1)
			{
				$list[$i]->activity = $this->config->item("lexam");
				if ($list[$i]->isrefreshment)
				{
					$list[$i]->status = $this->config->item('lrefreshment');
				}
				else
				{
					$list[$i]->status = $this->config->item('llulus');
				}

				if($list[$i]->history_exam_reset == "1")
				{
					$list[$i]->status .= " / ".$this->config->item('lreset');
				}

			}
			else
			{
				$list[$i]->activity = $this->config->item("lexam");
				$list[$i]->status = $this->config->item('lnolulus');

				if($list[$i]->history_exam_reset == "1")
				{
					$list[$i]->status .= " / ".$this->config->item('lreset');
				}

			}
		}

		if ($userid)
		{
			$this->db->where("user_id", $userid);
			$q = $this->db->get("user");
			$rowuser = $q->row();

			$this->mysmarty->assign("rowuser", $rowuser);
		}

		$this->mysmarty->assign("hasrefreshment", isset($hasrefreshment) ? $hasrefreshment : false);
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("lmypersonal_report", strtoupper($this->config->item("lmypersonal_report")));
		$this->mysmarty->assign("ltraining_column", ucfirst($this->config->item('training_name')));
		$this->mysmarty->assign("ldate", ucfirst($this->config->item('ldate')));
		$this->mysmarty->assign("lscore", ucfirst($this->config->item('lscore')));
		$this->mysmarty->assign("lstatus", ucfirst($this->config->item('status')));
		$this->mysmarty->assign("lcetak", $this->config->item('lcetak'));
		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("llokasi", $this->config->item('llokasi'));
		$this->mysmarty->assign("ltaken", $this->config->item('ltaken'));
		$this->mysmarty->assign("lactivity", $this->config->item('lactivity'));

		if (isset($sess['asadmin']))
		{
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}

		$show_print = 0;
		if($this->training_type == "training" ){ //not pra exam
			$show_print = $this->generalsettingmodel->GetInfo("showtrainingprint");
		}else
		if($this->training_type == "certification"){
			$show_print = $this->generalsettingmodel->GetInfo("showcertificationprint");
		}
		if ((! isset($sess['asadmin'])) || $sess['user_type'])
			$this->mysmarty->assign("show_print", $show_print);
		else
			$this->mysmarty->assign("show_print", true); //if admin, show print

		$this->mysmarty->assign("main_content", "training/historydetail.html");
		$this->mysmarty->display("sess_template.html");
	}

	function printcertificate($do="", $id1="")
	{
		$id = isset($_POST['id']) ? $_POST['id'] :  "";
		$isajax = isset($_POST['isajax']) ? $_POST['isajax'] :  0;

		if (($do == "print") && $id1)
		{
			$id = $id1;
		}

		if (! $id)
		{
			if (! $isajax)
			{
				redirect(base_url());
				return;
			}

			echo json_encode(array("err"=>1, "redirect"=>base_url()));
			return;
		}

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			if (! $isajax)
			{
				redirect(base_url());
				return;
			}

			echo json_encode(array("err"=>1, "redirect"=>base_url()));
			return;
		}
		$sess = unserialize($usess);

		$this->db->where("history_exam_id", $id);
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$rowhist = $q->row();

		// check periode time

		$this->db->where("training_time_date1 <=", $rowhist->history_exam_date);
		$this->db->where("training_time_date2 >=", $rowhist->history_exam_date);
		$this->db->where("training_time_training", $rowhist->history_exam_training);

		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			// all period, berarti ambil npk dan training yg sama

			$this->db->order_by("history_exam_date", "asc");
			$this->db->where("history_exam_status", 1);
			$this->db->where("history_exam_type", $rowhist->history_exam_type);
			$this->db->where("history_exam_training", $rowhist->history_exam_training);
			$this->db->where("history_exam_user", $rowhist->history_exam_user);
			$this->db->join("user", "user_id = history_exam_user");
			$this->db->join("training", "training_id = history_exam_training");
			$this->db->join("category", "category_id = training_topic");
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				echo json_encode(array("err"=>1, "redirect"=>base_url()));
				return;
			}

			$rowexam = $q->row();
		}
		else
		{
			//  ambil npk dan training dan periode yg sama

			$rowperiod = $q->row();

			$this->db->order_by("history_exam_date", "asc");
			$this->db->where("history_exam_status", 1);
			$this->db->where("history_exam_type", $rowhist->history_exam_type);
			$this->db->where("history_exam_training", $rowhist->history_exam_training);
			$this->db->where("history_exam_user", $rowhist->history_exam_user);
			$this->db->where("history_exam_date >=", $rowperiod->training_time_date1);
			$this->db->where("history_exam_date <=", $rowperiod->training_time_date2);
			$this->db->join("user", "user_id = history_exam_user");
			$this->db->join("training", "training_id = history_exam_training");
			$this->db->join("category", "category_id = training_topic");
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				echo json_encode(array("err"=>1, "redirect"=>base_url()));
				return;
			}

			$rowexam = $q->row();
		}

		$t = dbintmaketime($rowexam->history_exam_date, $rowexam->history_exam_time);

		if ($do == "print")
		{
			$this->db->where("general_setting_code", "certificatesign");
			$q = $this->db->get("general_setting");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$sign = "Head, Organization Learning";
			}
			else
			{
				$rowsign = $q->row();
				$sign = $rowsign->general_setting_value;
			}

			switch($rowexam->history_exam_type)
			{
				case 2:
					$codeactivated = "OTR";
				break;
				case 3:
					$codeactivated = "CER";
				break;
				case 4:
					$codeactivated = "TRN";
				break;
			}

			$this->mysmarty->assign("codeactivated", $codeactivated);
			$this->mysmarty->assign("nocertificate", sprintf("%08d", $rowexam->history_exam_no));

			$this->mysmarty->assign("sign", $sign);
			$this->mysmarty->assign("YYYY", date("Y", $t));
			$this->mysmarty->assign("MM", date("m", $t));
			$this->mysmarty->assign("DD", date("d", $t));
			$this->mysmarty->assign("FF", date("F", $t));
			$this->mysmarty->assign("SS", date("S", $t));
			$this->mysmarty->assign("exam", $rowexam);
			//var_dump($rowexam);

			$this->db->where_in("general_setting_code", array("certtpl", "trainingtpl"));
			$q = $this->db->get("general_setting");

			$rowsettings = $q->result();
			for($i=0; $i < count($rowsettings); $i++)
			{
				$gensetting[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
			}

			$certtpl = isset($gensetting['certtpl']) ? $gensetting['certtpl'] : "";
			$trainingtpl = isset($gensetting['trainingtpl']) ? $gensetting['trainingtpl'] : "";

			$background = "images/sertifikat/bgpermata.gif";

			if ($rowexam->training_cert_tpl)
			{
				$file = sprintf("%s../uploads/tmpl/%d/%s", BASEPATH, $rowexam->training_id, $rowexam->training_cert_tpl);
				if (! is_file($file))
				{
					die("can't found template: ".$file);
				}
				else
				{
					$this->mysmarty->assign("background", $background);
					$this->mysmarty->display($file);
				}
			}
			else
			if (($rowexam->history_exam_type == 2) && $trainingtpl)
			{
				$file = sprintf("%s../uploads/tmpl/%s", BASEPATH, $trainingtpl);
				if (! is_file($file))
				{
					die("can't found template: ".$file);
				}
				else
				{
					$this->mysmarty->assign("background", $background);
					$this->mysmarty->display($file);
				}
			}
			else
			if (($rowexam->history_exam_type == 3) && $certtpl)
			{
				$file = sprintf("%s../uploads/tmpl/%s", BASEPATH, $certtpl);
				if (! is_file($file))
				{
					die("can't found template: ".$file);
				}
				else
				{
					$this->mysmarty->assign("background", $background);
					$this->mysmarty->display($file);
				}
			}
			else
			if (($rowexam->history_exam_type == 3) && $rowexam->training_cert_tpl)
			{
				$file = sprintf("%s../uploads/tmpl/%d/%s", BASEPATH, $rowexam->training_id, $rowexam->training_cert_tpl);
				if (! is_file($file))
				{
					die("can't found template: ".$file);
				}
				else
				{
					$this->mysmarty->assign("background", $background);
					$this->mysmarty->display($file);
				}
			}
			else
			if (($rowexam->history_exam_type == 3) && $certtpl)
			{
				$file = sprintf("%s../uploads/tmpl/%s", BASEPATH, $certtpl);
				if (! is_file($file))
				{
					die("can't found template: ".$file);
				}
				else
				{
					$this->mysmarty->assign("background", $background);
					$this->mysmarty->display($file);
				}
			}
			else
			{

				/*
				$filename = sprintf("%s../theme/%s/images/bg-certificate.gif", BASEPATH, $this->config->item("theme"));
				if (is_file($filename))
				{
					$background = sprintf("theme/%s/images/bg-certificate.gif", $this->config->item("theme"));
				}
				else
				{
					$background = "images/sertifikat/bgpermata.gif";
				}
				*/

				$background = "images/sertifikat/bgpermata.gif";

				$this->mysmarty->assign("background", $background);
				$this->mysmarty->display("training/print_certificate.html");
			}
			return;
		}

		echo json_encode(array("err"=>0, "url"=>site_url(array("training", "printcertificate", "print", $id))));
	}

	function examintro($id)
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		if (! $id)
		{
			redirect(base_url());
		}


		/*if ($this->trainingmodel->IsMaximumTaken($sess['user_id'], $id))
		{
			redirect(site_url(array("generalsetting", "errmessage", "errmaxtaken")));
			return;
		}*/


		$this->db->where("user_id", $sess['user_id']);
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left_outer");
		$q = $this->db->get("user");
		$this->db->flush_cache();

		$rowuser = $q->row();

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();

		// check privilege

		$ids = $this->trainingmodel->GetPrivileges($sess, array($id));
		if (! isset($ids[$id]))
		{
			redirect(base_url());
		}

		$arrtopicids = array();
		$arrtopictrainingids = array();
		$arrtopiccertificateids = array();

		$this->topicmodel->getTopicsUser($sess, $arrtopicids, $arrtopictrainingids, $arrtopiccertificateids);


		$this->db->where("training_id", $row->training_id);
		$this->db->join("training", "training_id = training_exam_training");
		$q = $this->db->get("training_exam");
		$this->db->flush_cache();

		$rowexam = $q->result();
		for($i=0; $i < count($rowexam); $i++)
		{
			if ($rowexam[$i]->training_exam_type == 1)
			{
				$praexam[$rowexam[$i]->training_exam_training] = true;
			}
			else
			{
				$exam[$rowexam[$i]->training_exam_training] = true;
			}
		}

		$row->hasPraExam = isset($praexam[$row->training_id]);
		$row->hasExam = isset($exam[$row->training_id]);

		$hist = $this->trainingmodel->taketimes($sess, array($id));

		$ntake = isset($hist[2][$id]) ? $hist[2][$id] : 0;

		$this->mysmarty->assign("ltraining", ($this->pageid() == "training") ? $this->config->item("ltraining") : $this->config->item("lcertificate"));
		$this->mysmarty->assign("lpraexam", $this->config->item("lpraexam"));
		$this->mysmarty->assign("lexam", $this->config->item("lexam"));
		$this->mysmarty->assign("lmateri", $this->config->item("lmateri"));

		$this->mysmarty->assign("row", $row);

		//---- xxxxxx bug fixing certification examintro tidak ada button start (script aslinya di atas)-------
		$this->mysmarty->assign("rowxyz", $row);

		$this->mysmarty->assign("ntake", $ntake);
		$this->mysmarty->assign("lcourse_taken", sprintf(getconfig('lcourse_taken'),$ntake));

		$Author = "";
		if ($row->training_author_firstname || $row->training_author_lastname ) {
			$Author = $row->training_author_firstname ;
			$Author .= ($row->training_author_lastname)?" ".$row->training_author_lastname:"";
		}
		$this->mysmarty->assign("Author", $Author);

		$this->mysmarty->assign("lcertification_prepared", getconfig('lcertification_prepared'));
		$this->mysmarty->assign("lstart", getconfig('lstart'));
		$this->mysmarty->assign("ltopic", getconfig('ltopic'));
		$this->mysmarty->assign("rowuser", $rowuser);


		$this->db->where("category_id", $row->training_topic);
		$q = $this->db->get("category");
		$this->db->flush_cache();

		$rowtopic = $q->result();
		$this->mysmarty->assign("rowtopic", $rowtopic[0]);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/examintro.html");
		$this->mysmarty->display("sess_template.html");
	}

	function historyjawaban($id)
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		$this->db->order_by("history_answer_order", "asc");
		$this->db->where("history_exam_id", $id);

		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}

		$this->db->join("history_exam", "history_exam_id = history_answer_history_exam");
		$this->db->join("training", "training_id = history_exam_training");
		$this->db->join("banksoal_question", "banksoal_question_id = history_answer_question");
		$q = $this->db->get("history_answer");

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		$res = $q->result();

		for($i=0; $i < count($res); $i++)
		{
			$t = dbintmaketime($res[$i]->history_exam_date, $res[$i]->history_exam_time);
			$res[$i]->history_exam_datetime = date("d/m/Y H:i", $t);

			$res[$i]->history_exam_score_fmt = number_format($res[$i]->history_exam_score, 2, ".", "");

			$quests[$res[$i]->banksoal_question_id] = $res[$i];

			$ids[] = $res[$i]->banksoal_question_id;
		}

		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where_in("banksoal_answer_question", $ids);
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();

		$rowchoices = $q->result();
		for($i=0; $i < count($rowchoices); $i++)
		{
			$choices[$rowchoices[$i]->banksoal_answer_question][] = $rowchoices[$i];
		}

		for($i=0; $i < count($res); $i++)
		{
			$res[$i]->choices = $choices[$res[$i]->banksoal_question_id];
		}


		$this->mysmarty->assign("quests", $quests);
		$this->mysmarty->assign("row", $row);
		$this->mysmarty->assign("ltraining", ($this->pageid() == "training") ? $this->config->item("ltraining") : $this->config->item("ltraining"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));
		$this->mysmarty->assign("lscore", $this->config->item("lscore"));
		$this->mysmarty->assign("lclose", $this->config->item("lclose"));

		$this->mysmarty->assign("win", "popup");
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "training/historyjawaban.html");
		$this->mysmarty->display("sess_template.html");

	}

	function importnpk($id, $training_npk_time_id = 0)
	{
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		$errs = array();
		if ($q->num_rows() == 0)
		{
			$errs[] = $this->config->item("err_exipred_session");
		}

		if (! isset($_FILES['filenpk']))
		{
			$errs[] = $this->config->item("lempty_filenpk");
		}
		else
		if (! $_FILES['filenpk']['name'])
		{
			$errs[] = $this->config->item("lempty_filenpk");
		}
		else
		{
			/*
				//-------alternatif untuk PHP 5.2.17-----------
				$this->load->library("PhpExcelReader");
				$excel = new PhpExcelReader;
				$excel->read($_FILES['filenpk']['tmp_name']);

				$i = 2;
				while(1)
				{
					if (! isset($excel->sheets[0]['cells'][$i][1])) break;

					$npks[] = $excel->sheets[0]['cells'][$i][1];

					$i++;
				}
			*/

			/*
			//-------PHP 5.2.17 script ini tidak jalan-----------
			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['filenpk']['tmp_name']);

			$i = 2;
			while(1)
			{
				if (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

				$npks[] = $this->xlsreader->sheets[0]['cells'][$i][1];

				$i++;
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['filenpk']['tmp_name']);

            $npks = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($row = 2; $row <= $highestRow; ++ $row) {
                    for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val = $cell->getValue();
                        if(empty($val)) continue;
                        $npks[] = $val;
                    }
                }
            }

			if (! isset($npks))
			{
				$errs[] = $this->config->item("lempty_npk");
			}
			else
			{
				if(empty($training_npk_time_id)) {
					$this->db->where("training_time_training", $id);
					$q = $this->db->get("training_time");
					$rowtimetraining = $q->result();

					$data_time = array();
					foreach ($rowtimetraining as $value) {
						$data_time[] = $value->training_time_id;
					}

					if(!empty($data_time)) {
						//$this->db->where_in('training_npk_time_id', $data_time);
						$this->db->where('training_npk_time_id', 0);
					}
				} else {
					$this->db->where('training_npk_time_id', $training_npk_time_id);
				}

				//-- delete the list first
				$this->db->where("training_npk_training", $id);
				$this->db->delete("training_npk");
				$this->db->flush_cache();

				$this->db->where_in("user_npk", $npks);
				$q = $this->db->get("user");
				$this->db->flush_cache();

				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("lempty_npk");
				}
				else
				{
					$rows = $q->result();
					for($i=0; $i < count($rows); $i++)
					{
						$rownpks[$rows[$i]->user_id] = $rows[$i];
					}

					foreach($rownpks as $npk)
					{
						if(!empty($data_time)) {
							//foreach ($data_time as $value) {
								//unset($data);

								$data['training_npk_npk'] = $npk->user_id;
								//$data['training_npk_time_id'] = $value;
								$data['training_npk_training'] = $id;

								@$this->db->insert("training_npk", $data);
							//}
						} else {
							unset($data);

							$data['training_npk_npk'] = $npk->user_id;
							$data['training_npk_time_id'] = $training_npk_time_id;
							$data['training_npk_training'] = $id;

							@$this->db->insert("training_npk", $data);
						}
					}
				}
			}
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";

			return;
		}

		$limportnpk_save = sprintf($this->config->item("limportnpk_save"), count($npks), count($rows));

		echo "<script>parent.setSuccess('".$limportnpk_save."')</script>";
	}

	function export()
	{
		$this->db->order_by("training_type", "asc");
		$this->db->order_by("training_name", "asc");
		$q = $this->db->select("*
			, CASE training_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END training_status_desc
			, CASE training_type WHEN 1 THEN 'training' WHEN 2 THEN 'certificate' ELSE 'classroom' END training_type_desc "
			, false
		);

		$this->db->where("training_type", $this->type());
		$this->db->join("category", "category_id = training_topic");
		$q = $this->db->get("training");
		$this->db->flush_cache();

		$rows = $q->result();

		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-".$this->pageid().".xls");

		$worksheet =& $this->xlswriter->addWorksheet("training");


		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, 'topic id');
		$worksheet->write(0, 2, 'topic name');
		$worksheet->write(0, 3, 'code');
		$worksheet->write(0, 4, 'training name');
		$worksheet->write(0, 5, 'created date');
		$worksheet->write(0, 6, 'status code');
		$worksheet->write(0, 7, 'status');
		$worksheet->write(0, 8, 'type code');
		$worksheet->write(0, 9, 'type desc');

		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->training_id);
			$worksheet->write($i+1, 1, $rows[$i]->training_topic);
			$worksheet->write($i+1, 2, $rows[$i]->category_name);
			$worksheet->write($i+1, 3, $rows[$i]->training_code);
			$worksheet->write($i+1, 4, $rows[$i]->training_name);
			$worksheet->write($i+1, 5, $rows[$i]->training_created_date);
			$worksheet->write($i+1, 6, $rows[$i]->training_status);
			$worksheet->write($i+1, 7, $rows[$i]->training_status_desc);
			$worksheet->write($i+1, 8, $rows[$i]->training_type);
			$worksheet->write($i+1, 9, $rows[$i]->training_type_desc);
		}

		$this->xlswriter->close();
	}

	function exporthistoryparticipantheadercsv(&$fout)
	{
		$str = "";
		$str .= "Personnel Number";
		$str .= ";Name";
		$str .= ";Start";
		$str .= ";To";
		$str .= ";Education Establishment Code";
		$str .= ";Education establishment";
		$str .= ";Education/Training Code";
		$str .= ";Education/Training Desc.";
		$str .= ";Institution";
		$str .= ";Country Key";
		$str .= ";Status Code";
		$str .= ";Status Description";
		$str .= ";Final Grade";
		$str .= ";Lokasi";
		$str .= ";Course Name";
		$str .= ";Topic Code";

		/* 2011/01/2011  add start and end period training */
		$str .= ";start period";
		$str .= ";end period";
		$str .= "\r\n";

		fwrite($fout, $str);
	}

	function exporthistoryparticipantheader(&$worksheet)
	{
		$worksheet->write(0, 0, 'Personnel Number');
		$worksheet->write(0, 1, 'Name');
		$worksheet->write(0, 2, 'Start');
		$worksheet->write(0, 3, 'To');
		$worksheet->write(0, 4, 'Education Establishment Code');
		$worksheet->write(0, 5, 'Education establishment');
		$worksheet->write(0, 6, 'Education/Training Code');
		$worksheet->write(0, 7, 'Education/Training Desc.');
		$worksheet->write(0, 8, 'Institution');
		$worksheet->write(0, 9, 'Country Key');
		$worksheet->write(0, 10, 'Status Code');
		$worksheet->write(0, 11, 'Status Description');
		$worksheet->write(0, 12, 'Final Grade');
		$worksheet->write(0, 13, 'Lokasi');
		$worksheet->write(0, 14, 'Course Name');
		$worksheet->write(0, 15, 'Topic Code');
	}

	function exporthistoryheader(&$worksheet)
	{
		$worksheet->write(0, 0, 'id');
		if($this->training_type== "training"){
			$worksheet->write(0, 1, $this->config->item('ltraining_code'));
			$worksheet->write(0, 2, $this->config->item('training_name'));
		}else
		if($this->training_type== "certification"){
			$worksheet->write(0, 1, $this->config->item('lcertificate_code'));
			$worksheet->write(0, 2, $this->config->item('certificate_name'));
		}
		$worksheet->write(0, 3, 'date');
		$worksheet->write(0, 4, 'time');
		$worksheet->write(0, 5, 'score');
		$worksheet->write(0, 6, 'user id');
		$worksheet->write(0, 7, 'status code');
		$worksheet->write(0, 8, 'status desc');
		$worksheet->write(0, 9, 'type code');
		$worksheet->write(0, 10, 'type desc');
		$worksheet->write(0, 11, 'cert number');
		$worksheet->write(0, 12, 'user name');
	}

	function exporthistoryparticipantcontent(&$worksheet, $i, $row)
	{
		$types = array("training", "certificate", "classroom");

		$worksheet->write($i+1, 0, $row->user_npk);
		$worksheet->write($i+1, 1, $row->user_first_name." ".$row->user_last_name);
		$worksheet->write($i+1, 2, $row->history_exam_startdate);
		$worksheet->write($i+1, 3, $row->history_exam_date);
		$worksheet->write($i+1, 4, $row->training_type);
		$worksheet->write($i+1, 5, $types[$row->training_type-1]);
		$worksheet->write($i+1, 6, "IL");
		$worksheet->write($i+1, 7, "internal local");
		$worksheet->write($i+1, 8, ($row->training_type == 3) ? $row->training_author_firstname : "");
		$worksheet->write($i+1, 9, "Indonesia");

		//-- If praexam, set status = 1, and desc = completed
		if ($row->history_exam_type == 1)
		{
			$worksheet->write($i+1, 10, "1");
			$worksheet->write($i+1, 11, $this->config->item("lcompeted"));
		}else
		if ($row->history_exam_type == 0){
			$worksheet->write($i+1, 10, "0");
			$worksheet->write($i+1, 11, $this->config->item("ltaken"));
		}
		else
		{
			$worksheet->write($i+1, 10, $row->history_exam_status);
			$worksheet->write($i+1, 11, $row->history_exam_status_desc);
		}


		//$worksheet->write($i+1, 11, $row->history_exam_status_desc);
		$worksheet->write($i+1, 12, $row->history_exam_score);
		$worksheet->write($i+1, 13, $row->lokasi_kota." ".$row->lokasi_alamat);
		$worksheet->write($i+1, 14, $row->training_name);
		$worksheet->write($i+1, 15, $row->category_code);
	}

	function exporthistoryparticipantcontentcsv(&$fout, $i, $row)
	{
		$types = array("training", "certificate", "classroom");

		$str = "";
		$str .= $row->user_npk;
		$str .= ";".$row->user_first_name." ".$row->user_last_name;
		$str .= ";".$row->history_exam_startdate;
		$str .= ";".$row->history_exam_date;
		$str .= ";".$row->training_type;
		$str .= ";".$types[$row->training_type-1];
		$str .= ";"."IL";
		$str .= ";"."internal local";
		$str .= ";".(($row->training_type == 3) ? $row->training_author_firstname : "");
		$str .= ";"."Indonesia";

		//-- If praexam, set status = 1, and desc = completed
		if ($row->history_exam_type == 1)
		{
			$str .= ";"."1";
			$str .= ";".$this->config->item("lcompeted");
		}
		else
		{
			$str .= ";".$row->history_exam_status;
			$str .= ";".$row->history_exam_status_desc;
		}

		$str .= ";".$row->history_exam_score;
		$str .= ";".$row->lokasi_kota." ".$row->lokasi_alamat;
		$str .= ";".$row->training_name;
		$str .= ";".$row->category_code;
		$str .= ";".$row->training_period[2];
		$str .= ";".$row->training_period[3];
		$str .= "\r\n";

		fwrite($fout, $str);
	}


	function exporthistorycontent(&$worksheet, $i, $row)
	{
		$worksheet->write($i+1, 0, $row->history_exam_id);
		$worksheet->write($i+1, 1, $row->training_code);
		$worksheet->write($i+1, 2, $row->training_name);
		$worksheet->write($i+1, 3, $row->history_exam_date);
		$worksheet->write($i+1, 4, $row->history_exam_time);
		$worksheet->write($i+1, 5, $row->history_exam_score);
		$worksheet->write($i+1, 6, $row->user_npk);
		$worksheet->write($i+1, 7, $row->history_exam_status);

		if ($row->history_exam_type == 1) // praexam
		{
			$worksheet->write($i+1, 8, $this->config->item("lcompeted"));
		}
		else
		if ($row->history_exam_type == 0){ //materi
			$worksheet->write($i+1, 8, $this->config->item("ltaken"));
		}
		else
		{
			$worksheet->write($i+1, 8, $row->history_exam_status_desc);
		}

		$worksheet->write($i+1, 9, $row->history_exam_type);
		$worksheet->write($i+1, 10, $row->history_exam_type_desc);
		$worksheet->write($i+1, 11, $row->history_exam_no);
		$worksheet->write($i+1, 12, $row->user_first_name." ".$row->user_last_name);
	}

	function exporthistory($type=0, $filetype="xls")
	{
		$this->db->where("general_setting_code", "personalreportmateri");
		$q = $this->db->get("general_setting");

		if ($q->num_rows() == 0)
		{
			$showmaterihist = 0;
		}
		else
		{
			$rowsetting = $q->row();
			$showmaterihist = $rowsetting->general_setting_value == 1;
		}

		if ($type == 1)
		{
			/* 20100721
			only export that passed
			*/

			$this->db->where("history_exam_isexport <>", 1);
			//$this->db->where('(history_exam_type = 1 or history_exam_type = 2 or history_exam_type = 3)');
			$this->db->where('(history_exam_type = 2 or history_exam_type = 3)'); //exam or certification
			$this->db->where("history_exam_status", 1);  //lulus
			$this->db->where("history_exam_time >", 0);	 //sdh kelar
		}

		if ($type == 0)
		{
			$this->db->where("training_type", $this->type());
		}

		switch($this->pageid())
		{
			case "certificate":
				$this->db->where("history_exam_type", 3);
			break;
			case "classroom":
				$this->db->where("history_exam_type", 4);
			break;
			default:
				if ($showmaterihist)
				{
					$this->db->where("((history_exam_type = 2) OR (history_exam_type = 1) OR (history_exam_type = 0))", null);
				}
				else
				{
					$this->db->where("history_exam_type", 2);
				}
		}

		$this->db->order_by("history_exam_date", "asc");
		$this->db->order_by("history_exam_time", "asc");

		$q = $this->db->select("*
			, CASE history_exam_status WHEN 1 THEN '".$this->config->item('llulus')."' ELSE '".$this->config->item('lnolulus')."' END history_exam_status_desc
			, history_exam_status as history_exam_stats
			, CASE history_exam_type WHEN 1 THEN '".$this->config->item('lpraexam')."' WHEN 2 THEN '".$this->config->item('lexam')."' WHEN 3 THEN '".$this->config->item('certification')."' WHEN 0 THEN '".$this->config->item("lmateri")."' WHEN 4 THEN '".$this->config->item('lclassroom')."' END history_exam_type_desc "
			, false
		);

		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("category", "category_id = training_topic");
		$this->db->join("user", "user_id = history_exam_user");
		$this->db->join("lokasi", "user_location = lokasi_id", "left outer");

		$q = $this->db->get("history_exam");
		//print_r($this->db->queries);exit;
		$this->db->flush_cache();

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (isset($trainingids) && (in_array($rows[$i]->training_id,  $trainingids))) continue;
			$trainingids[] = $rows[$i]->training_id;

		}

		if (isset($trainingids))
		{
			$this->db->where_in("training_lokasi_training", $trainingids);
			$this->db->join("training_lokasi", "training_lokasi_id = lokasi_id");
			$q = $this->db->get("lokasi");
			$rowtrainings = $q->result();
			$this->db->flush_cache();

			for($i=0; $i < count($rowtrainings); $i++)
			{
				$lokasies[$rowtrainings[$i]->training_lokasi_training] = $rowtrainings[$i];
			}

			for($i=0; $i < count($rows); $i++)
			{
				$rows[$i]->lokasi = isset($lokasies[$rows[$i]->training_id]) ? ($lokasies[$rows[$i]->training_id]->lokasi_alamat." ".$lokasies[$rows[$i]->training_id]->lokasi_kota) : "";
			}
		}

		// ambil semua training period

		if (isset($trainingids))
		{
			$this->db->where_in("training_time_training", $trainingids);
		}

		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		$rowperiods = $q->result();

		for($i=0; $i < count($rowperiods); $i++)
		{
			$t1 = dbintmaketime($rowperiods[$i]->training_time_date1, 0);
			$t2 = dbintmaketime($rowperiods[$i]->training_time_date2, 0);

			$periods[$rowperiods[$i]->training_time_training][] = array($t1, $t2,$rowperiods[$i]->training_time_date1,$rowperiods[$i]->training_time_date2);
		}

		if ($filetype == "csv")
		{
			$type = 1;

			switch($type)
			{
				case 1:
					$filename 	= $this->config->item('root_path')."/".$this->config->item("outbox")."/".$this->config->item("exporthistoryfilename");
					$filename1 	= $this->config->item('root_path')."/".$this->config->item("outbox")."/".date("Ymd_His")."_".$this->config->item("exporthistoryfilename");

					@rename($filename, $filename1);

					$fout = fopen($filename, "w");

				break;
			}

			switch($type)
			{
				case 1:
					$this->exporthistoryparticipantheadercsv($fout);
				break;
			}

		}
		else
		{
			$this->load->library("xlswriter");

			switch($type)
			{
				case 1:
					$filename = BASEPATH."../".$this->config->item("outbox")."/".$this->config->item("exporthistoryfilename");
					$filename1 = BASEPATH."../".$this->config->item("outbox")."/".date("Ymd_His")."_".$this->config->item("exporthistoryfilename");

					@rename($filename, $filename1);
					$this->xlswriter->_filename = $filename;
				break;
				default:
					$this->xlswriter->send(date("Ymd-His")."-exam.xls");
			}

			$worksheet =& $this->xlswriter->addWorksheet("exam");

			switch($type)
			{
				case 1:
					$this->exporthistoryparticipantheader($worksheet);
				break;
				default:
					$this->exporthistoryheader($worksheet);
			}
		}

		for($i=0; $i < count($rows); $i++)
		{
			$examids[] = $rows[$i]->history_exam_id;

			$t = dbintmaketime($rows[$i]->history_exam_date, 0);

			if (isset($periods[$rows[$i]->history_exam_training]))
			{
				foreach($periods[$rows[$i]->history_exam_training] as $val)
				{
					if ($t < $val[0]) continue;
					if ($t > $val[1]) continue;

					$rows[$i]->training_period = array($val[0], $val[1],$val[2],$val[3]);
					break;
				}
			}

			if ($filetype == "csv")
			{
				switch($type)
				{
					case 1:
						$this->exporthistoryparticipantcontentcsv($fout, $i, $rows[$i]);
						break;
				}
			}
			else
			{

				switch($type)
				{
					case 1:
						$this->exporthistoryparticipantcontent($worksheet, $i, $rows[$i]);
						break;
					default:
						$this->exporthistorycontent($worksheet, $i, $rows[$i]);
				}
			}

		}

		if ($filetype != "csv")
		{
			$this->xlswriter->close();
		}

		//-- close the file csv
		if ($filetype == "csv")
			fclose($fout);

		if (($type == 1) && isset($examids))
		{
			unset($data);
			$data['history_exam_isexport'] = 1;

			$this->db->where_in("history_exam_id", $examids);
			$this->db->update("history_exam", $data);
		}
	}

	function historyexam($id)
	{
		if (! $id)
		{
			redirect(base_url());
		}

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		if ($this->sess['user_type'])
		{
			if (! isset($this->modules['certificate']))
			{
				redirect(base_url());
			}
		}

		//get general setting for show materi ,show all not not
		$showmaterihist = $this->GeneralsettingModel->GetInfo("personalreportmateri");

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();

		switch($this->pageid())
		{
			case "certificate":
				$this->db->where("history_exam_type", 3);
				if(!$showmaterihist)
					$this->db->where("history_exam_status", 1);
				$this->mysmarty->assign("examtype", 2);
			break;
			case "classroom":
				$this->db->where("history_exam_type", 4);
				$this->mysmarty->assign("examtype", 0);
			break;
			default:
				if ($showmaterihist)
				{
					$this->db->where("((history_exam_type = 2) OR (history_exam_type = 1) OR (history_exam_type = 0))", null);
					$this->mysmarty->assign("examtype", 0);
				}
				else
				{
					$this->db->where("history_exam_type", 2);
					$this->mysmarty->assign("examtype", 2);
				}
		}

		$this->db->where("history_exam_training", $id);
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);
		$this->db->where("history_exam_reset", 0);
		$this->db->select("history_exam_startdate, history_exam_user");
		$this->db->group_by("history_exam_startdate, history_exam_user");
		$this->db->join("user", "user_id = history_exam_user");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		$rowexams = $q->result();

		$this->db->where("training_time_training", $id);
		$q = $this->db->get("training_time");

		$rowperiods = $q->result();

		$exams = array();
		for($i=0; $i < count($rowexams); $i++)
		{
			if (count($rowperiods))
			{
				$t = dbintmaketime($rowexams[$i]->history_exam_startdate, 0);
			}
			else
			{
				$t = 0;
			}
			if (isset($exams[$t]) && in_array($rowexams[$i]->history_exam_user, $exams[$t])) continue;

			$exams[$t][] = $rowexams[$i]->history_exam_user;
		}

		$candidates = $this->trainingmodel->GetCandidateNPK(array($id));

		$this->db->where("training_time_training", $id);
		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		if ($q->num_rows() > 0)
		{
			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				$t1 = dbintmaketime($rows[$i]->training_time_date1, 0);
				$t2 = dbintmaketime($rows[$i]->training_time_date2, 0);

				$rows[$i]->training_time_date1_fmt = date("d/m/Y",  $t1);
				$rows[$i]->training_time_date2_fmt = date("d/m/Y",  $t2);
				$rows[$i]->participant = $this->totalparticipant($exams, $t1, $t2);
				$rows[$i]->totparticipant = isset($candidates[$id]) ? $candidates[$id] : 0;
			}
		}
		else
		{

			unset($rows);
			foreach($exams as $t=>$users)
			{
				unset($row1);

				$row1->training_id = $row->training_id;
				$row1->training_time_id = 0;
				$row1->training_time_training = 0;
				$row1->training_time_date1_fmt = "All Period";
				$row1->training_time_date2_fmt = "";
				$row1->participant = count($users); //$myexams[$t];
				$row1->totparticipant = isset($candidates[$id]) ? $candidates[$id] : 0;

				$rows[] = $row1;

			}
		}

		$this->mysmarty->assign("edit", $id);
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));
		$this->mysmarty->assign("lperiod", $this->config->item("period"));
		$this->mysmarty->assign("lparticipant", $this->config->item("lparticipant"));
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));
		$this->mysmarty->assign("lreset", $this->config->item("lreset"));
		$this->mysmarty->assign("lconfirm_reset_periode", $this->config->item("lconfirm_reset_periode"));
		$this->mysmarty->assign("ltotal", $this->config->item("ltotal"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("lmax_score", $this->config->item("lmax_score"));
		$this->mysmarty->assign("llast_score", $this->config->item("llast_score"));
		$this->mysmarty->assign("llast_lulus", $this->config->item("llast_lulus"));

		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("row", $row);
		$this->mysmarty->assign("rows", $rows);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/history.html");
		$this->mysmarty->display("sess_template.html");
	}

	function totalparticipant($exams, $t1, $t2)
	{
		if (! isset($exams)) return 0;

		$arr = array();
		foreach($exams as $key=>$val)
		{
			if ($key < $t1) continue;
			if ($key > $t2) continue;

			$arr = array_merge($val, $arr);
		}

		return count(array_unique($arr));
	}

	function historyparticipant($id)
	{
		if (! $id)
		{
			redirect(base_url());
		}

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		if ($this->sess['user_type'])
		{
			if (! isset($this->modules['certificate']))
			{
				redirect(base_url());
			}
		}

		$this->db->where("training_time_id", $id);
		$this->db->join("training", "training_time_training = training_id");
		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();

		$t1 = dbintmaketime($row->training_time_date1, 0);
		$t2 = dbintmaketime($row->training_time_date2, 0);

		$row->training_time_date1_fmt = date("d/m/Y",  $t1);
		$row->training_time_date2_fmt = date("d/m/Y",  $t2);

		// all staff

		if ($row->training_all_staff)
		{
			$this->db->order_by("jabatan_name", "asc");
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();

			$rowsjabatan = $q->result();
		}
		else
		{
			// per level

			$this->db->where("training_levelgroup_training", $row->training_id);
			$q = $this->db->get("training_levelgroup");
			$this->db->flush_cache();

			$rowlevels = $q->result();
			$levels = array(0);
			for($i=0; $i < count($rowlevels); $i++)
			{
				$levels[] = $rowlevels[$i]->training_levelgroup_levelgroup;
			}

			// per jabatan

			$this->db->where("training_jabatan_training", $row->training_id);
			$q = $this->db->get("training_jabatan");
			$this->db->flush_cache();

			$rowjabatan = $q->result();
			$jabatans = array(0);
			for($i=0; $i < count($rowjabatan); $i++)
			{
				$jabatans[] = $rowjabatan[$i]->training_jabatan_jabatan;
			}

			$this->db->where("training_npk_training", $row->training_id);
			$this->db->join("user", "user_id = training_npk_npk");
			$q = $this->db->get("training_npk");
			$this->db->flush_cache();

			$rowjabatan = $q->result();
			for($i=0; $i < count($rowjabatan); $i++)
			{
				$jabatans[] = $rowjabatan[$i]->user_jabatan;
			}

			$this->db->where_in("jabatan_id", $jabatans);
			$this->db->or_where_in("jabatan_level_group", $levels);
			$this->db->order_by("jabatan_name", "asc");
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();

			$rowsjabatan = $q->result();

		}

		// jumlah peserta

		switch($this->pageid())
		{
			case "certificate":
				$this->db->where("history_exam_type", 3);
			break;
			case "classroom":
				$this->db->where("history_exam_type", 4);
			break;
			default:
				$this->db->where("history_exam_type", 2);
		}

		$this->db->where("history_exam_training", $row->training_id);
		$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
		$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);
		$this->db->where("history_exam_reset", 0);
		$this->db->select("user_jabatan, history_exam_user");
		$this->db->group_by("user_jabatan, history_exam_user");
		$this->db->join("user", "user_id = history_exam_user");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		$rowexams = $q->result();

		$exams = array();
		for($i=0; $i < count($rowexams); $i++)
		{
			$exams[$rowexams[$i]->user_jabatan][] = $rowexams[$i]->history_exam_user;
		}

		$candidates = $this->trainingmodel->GetCandidateNPKPerjabatan(array($row->training_id));

		for($i=0; $i < count($rowsjabatan); $i++)
		{
			$rowsjabatan[$i]->participant = isset($exams[$rowsjabatan[$i]->jabatan_id]) ? count(array_unique($exams[$rowsjabatan[$i]->jabatan_id])) : 0;
			$rowsjabatan[$i]->totparticipant = isset($candidates[$row->training_id][$rowsjabatan[$i]->jabatan_id]) ? $candidates[$row->training_id][$rowsjabatan[$i]->jabatan_id] : 0;

		}

		$this->mysmarty->assign("lreset_npk_per_jabatan", $this->config->item("lreset_npk_per_jabatan"));
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));
		$this->mysmarty->assign("lperiod", $this->config->item("period"));
		$this->mysmarty->assign("lparticipant", $this->config->item("lparticipant"));
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));
		$this->mysmarty->assign("lreset", $this->config->item("lreset"));
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("ltotal", $this->config->item("ltotal"));

		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("hist", $row);
		$this->mysmarty->assign("rows", $rowsjabatan);
		$this->mysmarty->assign("periodid", $id);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/historyjabatan.html");
		$this->mysmarty->display("sess_template.html");
	}

	function historyexamexport($trainingid, $periode, $type)
	{
		$this->historynpk($periode, 0, $trainingid, "export", 0,0,$type);
	}

	/*
	$type : 1 = Max score
			2 = Last Passed
			3 = Last score
	*/
	function historynpk($id=0, $jabatanid=0, $trainingid=0, $show="", $allperiod=1, $includepreexam=1, $type=2)
	{
		//$type = 2;
		$recordperpage = $this->commonmodel->getRecordPerPage();

		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] :  "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		if (! $id)
		{
			if ((! isset($sess['asadmin'])) || $sess['user_type'])
			{
				redirect(base_url());
			}
		}

		if ($sess['user_type'])
		{
			if (! isset($this->modules['certificate']))
			{
				redirect(base_url());
			}
		}

		//get general setting for show materi ,show all not not
		$showmaterihist = $this->GeneralsettingModel->GetInfo("personalreportmateri");
		/*$this->db->where("general_setting_code", "showmaterihist");
		$q = $this->db->get("general_setting");

		if ($q->num_rows() == 0)
		{
			$showmaterihist = 0;
		}
		else
		{
			$rowsetting = $q->row();
			$showmaterihist = $rowsetting->general_setting_value == 1;
		}*/

		// training time

		if ($id)
		{
			$this->db->where("training_time_id", $id);
			$this->db->join("training", "training_time_training = training_id");
			$q = $this->db->get("training_time");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row();

			$t1 = dbintmaketime($row->training_time_date1, 0);
			$t2 = dbintmaketime($row->training_time_date2, 0);

			$row->training_time_date1_fmt = date("d/m/Y",  $t1);
			$row->training_time_date2_fmt = date("d/m/Y",  $t2);
		}
		else
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row();

			$row->training_time_training = $row->training_id;
		}

		// jabatan

		if ($jabatanid)
		{
			$this->db->where("jabatan_id", $jabatanid);
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$rowjabatan = $q->row();
		}
		else
		{
			$rowjabatan = array();
		}

		// jumlah peserta

		if ($trainingid)
		{
			$this->db->where("history_exam_training", $trainingid);

			$_trainingid = $trainingid;
		}
		else
		{
			$_trainingid = $row->training_id;

			$this->db->where("history_exam_training", $row->training_id);
			if ($jabatanid)
			{
				$this->db->where("user_jabatan", $jabatanid);
			}
		}

		if (isset($t1) && isset($t2))
		{
			$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
			$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		}

		$lname = $lcode = "";
		switch($row->training_type)
		{
			case 2:
				$this->db->where("history_exam_type", 3); //certificate
				$lname = $this->config->item("certificate_name");
				$lcode  = $this->config->item("lcertificate_code");

				//kl setting show all, display juga yg ga lulus
				if(!$showmaterihist)
					$this->db->where("history_exam_status", 1);

			break;
			case 3:
				$this->db->where("history_exam_type", 4); //classroom
				$lname = $this->config->item("lclassroom_name");
				$lcode  = $this->config->item("lclassroom_code");

			break;
			default:
				$lname = $this->config->item("ltraining_name");
				$lcode  = $this->config->item("ltraining_code");
				if ($showmaterihist && ($show <> "export"))
				{
					$type = 0;
					$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' OR history_exam_type = '0')");
				}
				else
				{
					$this->db->where("history_exam_type", 2); //training
				}
			break;
		}

		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);
		$this->db->where("history_exam_reset", 0);

		if ($searchby && $keyword)
		{
				switch($searchby)
				{
					case "user_npk":
						$this->db->where("user_npk LIKE", '%'.$keyword.'%');
					break;
					case "user_name":
						$this->db->where("UPPER(user_first_name) LIKE '%".strtoupper($keyword)."%' OR UPPER(user_last_name) LIKE '%".strtoupper($keyword)."%'");
					break;
				}
		}

		if ($trainingid)
		{
			$this->db->select("training_code,training_name, user_id, user_npk, count(*) total ");
			$this->db->group_by("training_code, training_name,user_id, user_npk");
		}
		else
		{
			$this->db->select("training_code, training_name,user_id, user_npk, user_jabatan, count(*) total ");
			$this->db->group_by("training_code, training_name,user_id, user_npk, user_jabatan");
		}

		if (isset($t1) && isset($t2))
		{
			$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
			$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		}



		$this->db->join("training", "training_id = history_exam_training");
		$this->db->join("user", "user_id = history_exam_user");
		$q = $this->db->get("history_exam");
//echo $this->db->last_query();
		$this->db->flush_cache();

		$total_rows = $q->num_rows();
//echo $total_rows;
		$rows = $q->result();

		if ($show != "export")
		{
			if ($limit)
			{
				$rows = array_slice($rows, $offset, $limit);
			}
		}

		$userids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$userids[] = $rows[$i]->user_id;
		}

		$this->db->where_in("user_id", array_unique($userids));
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
		$q = $this->db->get("user");
		$this->db->flush_cache();
		$rowusers = $q->result();

		for($i=0; $i < count($rowusers); $i++)
		{
			$users[$rowusers[$i]->user_id] = $rowusers[$i];
		}

		// history exam

		if (! $allperiod)
		{
			$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
			$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		}

		if (! $includepreexam)
		{
			$this->db->where("history_exam_type >", 1);
		}

		switch($row->training_type)
		{
			case 2:
				$this->db->where("history_exam_type", 3); //certificate
			break;
			case 3:
				$this->db->where("history_exam_type", 4); //classroom
			break;
			default:
				if ($showmaterihist && ($show <> "export")){
					$type = 0;
					$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' OR history_exam_type = '0')");
				}
				else
				{
					$this->db->where("history_exam_type", 2); //training
				}

				//$this->db->where("history_exam_type", 2); //training exam
			break;
		}

		$this->db->where("history_exam_training", $_trainingid);
		$this->db->where_in("history_exam_user", $userids);
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);

		/*
		2011/06/17 last lulus ==> last score
		2011/06/21 ganti jadi last lulus lagi
		 		   tambah type bary ==> last score : $type = 3
		*/
		if (($type == 2) || ($type == 3))
		{
			if ($type == 2)
			{
				$this->db->where("history_exam_status", 1);
			}
			$this->db->order_by("history_exam_date", "desc");
			$this->db->order_by("history_exam_time", "desc");
			$this->db->order_by("history_exam_user", "asc");
			$this->db->select("training_refreshment, history_exam_date, history_exam_type, history_exam_user, history_exam_status, history_exam_no, history_exam_score maxscore, history_exam_training");
			$this->db->join("training", "training_id = history_exam_training");
		}
		else
		{
			$this->db->group_by("history_exam_type, history_exam_user, history_exam_status, history_exam_no");
			$this->db->select("history_exam_type, history_exam_user, history_exam_status, history_exam_no, MAX(history_exam_score) maxscore");
		}

		$q = $this->db->get("history_exam");

		$rowscore = $q->result();

		// paksa untuk last score berkelakuan seperti maxscore

		if (($type == 2) || ($type == 3))
		{
			$temp = array();

			for($i=count($rowscore)-1; $i >= 0; $i--)
			{
				$rowscore[$i]->datetime = dbintmaketime($rowscore[$i]->history_exam_date, 0);

				if ($rowscore[$i]->training_refreshment <= 0)
				{
					$temp[$rowscore[$i]->history_exam_user] = $rowscore[$i];
					continue;
				}

				if ($i >= (count($rowscore)-1))
				{
					$temp[$rowscore[$i]->history_exam_user] = $rowscore[$i];
					continue;
				}

				if (! isset($lastlulus[$rowscore[$i]->history_exam_user]))
				{
					$temp[$rowscore[$i]->history_exam_user] = $rowscore[$i];
					$lastlulus[$rowscore[$i]->history_exam_user] = $rowscore[$i]->datetime;

					continue;
				}

				if ($this->config->item("refreshment_today") == 1)
				{
					$nextt = mktime(date('G'), date('i'), date('s'), date('n')-$rowscore[$i]->training_refreshment, date('j'), date('Y'));
					$rowscore[$i]->isrefreshment = $nextt >= $rowscore[$i]->datetime;
				}
				else
				{
					$nextt = mktime(date('G', $lastlulus[$rowscore[$i]->history_exam_user]), date('i', $lastlulus[$rowscore[$i]->history_exam_user]), date('s', $lastlulus[$rowscore[$i]->history_exam_user]), date('n', $lastlulus[$rowscore[$i]->history_exam_user])+$rowscore[$i]->training_refreshment, date('j', $lastlulus[$rowscore[$i]->history_exam_user]), date('Y', $lastlulus[$rowscore[$i]->history_exam_user]));
					$rowscore[$i]->isrefreshment = $rowscore[$i]->datetime > $nextt;
				}

				$temp[$rowscore[$i]->history_exam_user] = $rowscore[$i];
				$lastlulus[$rowscore[$i]->history_exam_user] = $rowscore[$i]->datetime;
			}

			$rowscore = array();

			if (count($temp))
			{
				foreach($temp as $val)
				{
					$rowscore[] = $val;
				}
			}
		}

		// tanggal

		if (! $allperiod)
		{
			$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
			$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		}

		if (! $includepreexam)
		{
			$this->db->where("history_exam_type >", 1);
		}

		switch($row->training_type)
		{
			case 2:
				$this->db->where("history_exam_type", 3);
			break;
			case 3:
				$this->db->where("history_exam_type", 4);
			break;
			default:
				if ($showmaterihist && ($show <> "export")){
					$type = 0;
					$this->db->where("( history_exam_type = '2' OR history_exam_type = '1' OR history_exam_type = '0')");
				}
				else
				{
					$this->db->where("history_exam_type", 2); //training
				}

				//$this->db->where("history_exam_type", 2);
			break;
		}

		if ($type == 2) // last lulus
			$this->db->where("history_exam_status", 1);

		$this->db->select("history_exam_user, history_exam_no, history_exam_score, history_exam_date");
		$this->db->select("history_exam_time, history_exam_startdate,history_exam_starttime");
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);
		$this->db->where("history_exam_training", $_trainingid);
		$this->db->where_in("history_exam_user", $userids);
		$q = $this->db->get("history_exam");

		$rowtanggal = $q->result();
		for($i=0; $i < count($rowtanggal); $i++)
		{
			$tanggals[$rowtanggal[$i]->history_exam_user][$rowtanggal[$i]->history_exam_no][$rowtanggal[$i]->history_exam_score] = $rowtanggal[$i];
		}

		for($i=0; $i < count($rowscore); $i++)
		{
			$t = dbintmaketime($tanggals[$rowscore[$i]->history_exam_user][$rowscore[$i]->history_exam_no][$rowscore[$i]->maxscore]->history_exam_date, 0);

			$rowscore[$i]->tanggalujian = date("d/m/Y", $t);
			 /*
			 1 = praexam;
			 2 = exam
			 3 = certificate
			 */

			$d1 = $tanggals[$rowscore[$i]->history_exam_user][$rowscore[$i]->history_exam_no][$rowscore[$i]->maxscore]->history_exam_date;
			$t1 = $tanggals[$rowscore[$i]->history_exam_user][$rowscore[$i]->history_exam_no][$rowscore[$i]->maxscore]->history_exam_time;
			$d2 = $tanggals[$rowscore[$i]->history_exam_user][$rowscore[$i]->history_exam_no][$rowscore[$i]->maxscore]->history_exam_startdate;
			$t2 = $tanggals[$rowscore[$i]->history_exam_user][$rowscore[$i]->history_exam_no][$rowscore[$i]->maxscore]->history_exam_starttime;
			$rowscore[$i]->examTimeDiff = timediff($d2,$t2,$d1,$t1);

			if ($rowscore[$i]->history_exam_type == 1)
			{
				$rowscore[$i]->status = $this->config->item("lcompeted");
			}
			else
			{
				if ($this->config->item("refreshment_today") == 1){
					$nextt = mktime(date('G'), date('i'), date('s'), date('n')-$rowscore[$i]->training_refreshment, date('j'), date('Y'));
					if($nextt >= $t)
						$rowscore[$i]->status = $this->config->item("lrefreshment");
					else
						$rowscore[$i]->status = ($rowscore[$i]->history_exam_status == 1) ? $this->config->item("llulus") : $this->config->item("lnolulus");
				}else {
					if (isset($rowscore[$i]->isrefreshment))
					{
						$rowscore[$i]->status = $this->config->item("lrefreshment");
					}
					else
					{
						$rowscore[$i]->status = ($rowscore[$i]->history_exam_status == 1) ? $this->config->item("llulus") : $this->config->item("lnolulus");
					}
				}

				if ($rowscore[$i]->history_exam_status == 1)
				{
					$codeactivated = "";
					switch($rowscore[$i]->history_exam_type)
					{
						case 2:
							$codeactivated = "OTR";
						break;
						case 3:
							$codeactivated = "CER";
						break;
						case 4:
							$codeactivated = "TRN";
						break;
					}

					$rowscore[$i]->certno = date("mY", $t)."-".$codeactivated."-".sprintf("%08d", $rowscore[$i]->history_exam_no);
				}
				else
				{
					$rowscore[$i]->certno = "";
				}


			}

			$scores[$rowscore[$i]->history_exam_user] = $rowscore[$i];
		}

		unset($histarr);
		for($i=0; $i < count($rows); $i++)
		{
			if (isset($users[$rows[$i]->user_id]))
			{

				if (isset($histarr[$users[$rows[$i]->user_id]->jabatan_level_group]))
				{
					$arr = 	$histarr[$users[$rows[$i]->user_id]->jabatan_level_group];
				}
				else
				{
					$arr = array();
					$this->levelmodel->getparentlevelgroups($users[$rows[$i]->user_id]->jabatan_level_group, $arr);
					$arr = array_reverse($arr);

					$histarr[$users[$rows[$i]->user_id]->jabatan_level_group] = $arr;
				}

				$rows[$i]->user = $users[$rows[$i]->user_id];
				$rows[$i]->group = $arr;
			}
			else
			{
				$rows[$i]->user = false;
			}

			$rows[$i]->score = isset($scores[$rows[$i]->user_id]) ? $scores[$rows[$i]->user_id] : false;
		}

		if ($show == "export")
		{
			switch($type){
				case "1"  :
					$sufix = "max_score";
				break;
				case "2"  :
					$sufix = "last_lulus";
				break;
				case "3"  :
					$sufix = "last_score";
				break;
			}

			$this->load->library("xlswriter");
			$this->xlswriter->send("participants_training_".$row->training_code."-".$sufix.".xls");

			$worksheet =& $this->xlswriter->addWorksheet("participants");

			$worksheet->write(0, 0, $lcode);
			$worksheet->write(0, 1, $lname);
			$worksheet->write(0, 2, $this->config->item("lnpk"));
			$worksheet->write(0, 3, $this->config->item("luser_name"));
			$worksheet->write(0, 4, $this->config->item("jabatan"));

			$col = 4;

			$levels = array();
			$this->levelmodel->getalllevels(0, $levels);
			for($i=0; $i < count($levels); $i++)
			{
				$worksheet->write(0, ++$col, strtoupper($levels[$i]->level_name));
			}

			$worksheet->write(0, ++$col, $this->config->item("location"));
			$worksheet->write(0, ++$col, $this->config->item("ltown"));
			$worksheet->write(0, ++$col, $this->config->item("lnilai"));
			$worksheet->write(0, ++$col, $this->config->item("llulus_tidak"));
			$worksheet->write(0, ++$col, $this->config->item("ldate"));
			$worksheet->write(0, ++$col, $this->config->item("lcertificate_no"));
			$worksheet->write(0, ++$col, $this->config->item("lduration_second"));


			//only export user yg ada score
			$counter = 0;
			for($k=0; $k < count($rows); $k++)
			{
				if($rows[$k]->score) {
					$i=$counter;
					$worksheet->write($i+1, 0, $rows[$k]->training_code);
					$worksheet->write($i+1, 1, $rows[$k]->training_name);

					$worksheet->write($i+1, 2, $rows[$k]->user_npk);
					$worksheet->write($i+1, 3, $rows[$k]->user->user_first_name." ".$rows[$k]->user->user_last_name);
					$worksheet->write($i+1, 4, $rows[$k]->user->jabatan_name);

					$col = 4;
					for($j=0; $j < count($levels); $j++)
					{
						$worksheet->write($i+1, ++$col, isset($rows[$k]->group[$j]->level_group_name) ? $rows[$k]->group[$j]->level_group_name : "");
					}

					$worksheet->write($i+1, ++$col, $rows[$k]->user->lokasi_alamat);
					$worksheet->write($i+1, ++$col, $rows[$k]->user->lokasi_kota);
					$worksheet->write($i+1, ++$col, ($rows[$k]->score) ? $rows[$k]->score->maxscore : "");
					$worksheet->write($i+1, ++$col,($rows[$k]->score) ? $rows[$k]->score->status : "");
					$worksheet->write($i+1, ++$col, ($rows[$k]->score) ? $rows[$k]->score->tanggalujian : "");
					$worksheet->write($i+1, ++$col, isset($rows[$k]->score->certno) ? $rows[$k]->score->certno : "");
					$worksheet->write($i+1, ++$col, isset($rows[$k]->score->examTimeDiff) ? $rows[$k]->score->examTimeDiff : "");

					$counter++;
				}
			}

			$this->xlswriter->close();

			return;
		}

		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit ? $limit : $total_rows;

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
		$this->pagination1->lang_title = $this->config->item('user');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total_rows;
		$this->pagination1->cur_page = $offset;

	    if($this->pageid() == "certificate")
	    	$arr = array("certificate");
		else
			$arr = array("training");

		$iuri = 2;
		while(1)
		{
			$elmt = $this->uri->segment($iuri);
			if (strlen(trim($elmt)) == 0) break;

			array_push($arr, $elmt);
			$iuri++;
		}

		$url = site_url($arr);

		$this->mysmarty->assign("url", $url);
		$this->mysmarty->assign("paging", $this->pagination1->create_links());

		$this->mysmarty->assign("total_rows", $total_rows);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lreset_per_npk", $this->config->item("lreset_per_npk"));
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));
		$this->mysmarty->assign("lperiod", $this->config->item("period"));
		$this->mysmarty->assign("lparticipant", $this->config->item("lparticipant"));
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));
		$this->mysmarty->assign("lreset", $this->config->item("lreset"));
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("ltimetakes", $this->config->item("ltimetakes"));
		$this->mysmarty->assign("ltotal", $this->config->item("ltotal"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));

		$this->mysmarty->assign("pageid", $this->pageid());
		$this->mysmarty->assign("hist", $row);
		$this->mysmarty->assign("jabatan", $rowjabatan);
		$this->mysmarty->assign("rows", $rows);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/historynpk.html");
		$this->mysmarty->display("sess_template.html");
	}

	function test()
	{
		$this->db->limit(1);
		$q = $this->db->get("user");

		$row = $q->row();
		$this->mysmarty->assign("user", $row);

		$this->db->limit(1);
		$q = $this->db->get("training");

		$row = $q->row();
		$this->mysmarty->assign("training", $row);

		$this->config->load('config.en');

		$months = $this->config->item("months");

		$this->mysmarty->assign("lend_of_en", $this->config->item("lend_of"));
		$this->mysmarty->assign("deadline_month_en", $months[0]);
		$this->mysmarty->assign("deadline_year_en", "2012");


		$this->config->load('config.id');
		$months = $this->config->item("months");

		$this->mysmarty->assign("lend_of_id", $this->config->item("lend_of"));
		$this->mysmarty->assign("deadline_month_id", $months[0]);
		$this->mysmarty->assign("deadline_year_id", "2012");

		$this->config->load('config.en');
		$this->mysmarty->display("training/reminder-message.html");

	}

	function changestatus()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if 	(
				TRUE
				&& (! isset($this->modules['training']))
				&& (! isset($this->modules['certificate']))
				&& (! isset($this->modules['classroorm']))
		)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if (! isset($this->modules[$this->pageid()]))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		unset($data);
		$data['training_status'] = ($status == 2) ? 1 : 2;
		$data['training_modified'] = date("Y-m-d H:i:s");
		$data['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;

		$this->db->where("training_id", $id);
		$this->db->update("training", $data);
	}

	function download($id)
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		if ($row->training_material_type == 2)
		{
			redirect(base_url());
		}

		if (! is_dir(BASEPATH.'../material/'.$row->training_material))
		{
			redirect(site_url(array("generalsetting", "errmessage", "ltraining_materi_notfound")));
		}

		$this->load->library('zip');

		$this->read_dir($this->zip, BASEPATH.'../material/'.$row->training_material."/", BASEPATH.'../material/'.$row->training_material."/");
		$this->zip->download('material_'.$row->training_code."_".date("Ymd").'.zip');

	}

	function read_dir(&$zip, $path, $basepath)
	{
		if ($fp = @opendir($path))
		{
			while (FALSE !== ($file = readdir($fp)))
			{
				if (@is_dir($path.$file) && substr($file, 0, 1) != '.')
				{
					$this->read_dir($zip, $path.$file."/", $basepath);
				}
				elseif (substr($file, 0, 1) != ".")
				{
					if (FALSE !== ($data = file_get_contents($path.$file)))
					{
						$s = str_replace("\\", "/", $path).$file;
						$basename = substr($s, strlen($basepath));
						$zip->add_data($basename, $data);
					}
				}
			}
			return TRUE;
		}
	}


	function importmaterial()
	{
		$errs = array();

		$cat = isset($_POST['cat']) ? $_POST['cat'] :  0;
		$topic = isset($_POST['topic']) ? $_POST['topic'] :  0;
		$name = isset($_POST['name']) ? $_POST['name'] :  "";

		if (! $cat)
		{
			$errs[] = $this->config->item("err_category_name");
		}

		if (! $topic)
		{
			$errs[]= $this->config->item("err_select_topic");
		}

		if (! $name)
		{
			$errs[] = $this->config->item("err_emtpy_training_name");
		}
		else
		if ($topic)
		{
			$this->db->where("training_topic", $topic);
			$this->db->where("training_name", $name);
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[]= $this->config->item("err_not_exist_training_name");
			}
			else
			{
				$row = $q->row();

			}
		}

		if (! isset($_FILES['materionline']))
		{
			$errs[] = $this->config->item("err_emtpy_material_online");
		}
		else
		if (! $_FILES['materionline']['name'])
		{
			$errs[] = $this->config->item("err_emtpy_material_online");
		}
		else
		if ($_FILES['materionline']['size'] <= 0)
		{
			$errs[] = $this->config->item("err_invalid_material_online");
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";

			return;
		}

		$this->load->helper('file');

		delete_files(BASEPATH.'../material/'.$row->training_id);
		@rmdir(BASEPATH.'../material/'.$row->training_id);

		$this->extracttraining($row->training_id);
		echo "<script>parent.setSuccess(\"".$this->config->item("limpor_material_ok")."\", '".site_url(array("training", "showlist"))."')</script>";
	}

	function addparticipantbyjabatan()
	{
		$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : false;
		$training = isset($_POST['training']) ? $_POST['training'] : 0;

		$errs = array();

		if (! $jabatan)
		{
			$errs[]= $this->config->item("lempty_choose_jabatan");
		}


		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");

			echo json_encode(array("err"=>1, "errmsg"=>$html));

			return;
		}

		foreach($jabatan as $val)
		{
			$this->db->where("training_jabatan_training", $training);
			$this->db->where("training_jabatan_jabatan", $val);
			$total = $this->db->count_all_results("training_jabatan");

			if ($total > 0) continue;

			unset($data);

			$data['training_jabatan_training'] = $training;
			$data['training_jabatan_jabatan'] = $val;

			$this->db->insert('training_jabatan', $data);
		}

		echo json_encode(array("err"=>0, "message"=>$this->config->item("lupdateparticipant")));
	}

	function addparticipantbygroup()
	{
		$group = isset($_POST['group']) ? $_POST['group'] : false;
		$training = isset($_POST['training']) ? $_POST['training'] : 0;

		$errs = array();

		if (! $group)
		{
			$errs[]= $this->config->item("lempty_choose_group");
		}


		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");

			echo json_encode(array("err"=>1, "errmsg"=>$html));

			return;
		}

		foreach($group as $val)
		{
			$this->db->where("training_levelgroup_training", $training);
			$this->db->where("training_levelgroup_levelgroup", $val);
			$total = $this->db->count_all_results("training_levelgroup");

			if ($total > 0) continue;

			unset($data);

			$data['training_levelgroup_training'] = $training;
			$data['training_levelgroup_levelgroup'] = $val;

			$this->db->insert('training_levelgroup', $data);
		}

		echo json_encode(array("err"=>0, "message"=>$this->config->item("lupdateparticipant")));
	}

	function refreshment($participant="")
	{
		$this->logmodel->init("refreshment");

		// cari training yang sudah expired

		$this->db->where("training_time_refreshed", 0);
		$this->db->where("training_time_period >", 0);
		$this->db->where("training_refreshment >", 0);
		//$this->db->where("training_time_date2 <", date("Ymd"));
		$this->db->join("training", "training_time_training = training_id");
		$q = $this->db->get("training_time");
		$this->db->flush_cache();

		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			// cek apakah parentnya udah lewat ato belum

			$t1 = dbintmaketime($list[$i]->training_time_date1, 0);
			$t2 = dbintmaketime($list[$i]->training_time_date2, 0);
			$t3 = dbintmaketime(date("Ymd"), 0);

			if ($t1 > $t3)
			{
				$s = "training time out of period ".$list[$i]->training_code." ".$list[$i]->training_name." ".date("Ymd", $t1)."-".date("Ymd", $t2);
				$this->logmodel->append($s);

				continue;
			}

			echo "Processing.... ".$list[$i]->training_id." -> ".$list[$i]->training_name." ".date("Ymd", $t1)."-".date("Ymd", $t2)." ".$list[$i]->training_time_period."\r\n";

			// increment n month sampai > tanggal sekarang

			$period = $list[$i]->training_time_period;

			// tandai bahwa periode ini telah direfresh

			unset($data);
			$data['training_time_refreshed'] = 1;

			$this->db->where("training_time_id", $list[$i]->training_time_id);
			$this->db->update("training_time", $data);
			$this->db->flush_cache();

			$t1_1 = mktime(0, 0, 0, date('n', $t1)+$period, date('j', $t1), date('Y', $t2));
			$t2_1 = mktime(0, 0, 0, date('n', $t2)+$period, date('j', $t2), date('Y', $t2));

			// cek apakah training dengan waktu baru sudah ada

			$this->db->where("training_time_training", $list[$i]->training_time_training);
			$this->db->where("(((training_time_date1 >= ".date("Ymd", $t1_1).") AND (training_time_date1 <= ".date("Ymd", $t2_1).")) OR ((training_time_date2 >= ".date("Ymd", $t1_1).") AND (training_time_date2 <= ".date("Ymd", $t2_1).")))", null);
			$qtrainingtime = $this->db->get("training_time");
			$this->db->flush_cache();

			if ($qtrainingtime->num_rows() > 0)
			{
				$rowtrainingtime = $qtrainingtime->row();

				unset($data);
				$data['training_time_parent'] = $list[$i]->training_time_id;

				$this->db->where("training_time_id", $rowtrainingtime->training_time_id);
				$this->db->update("training_time", $data);
				$this->db->flush_cache();

				$s = "training sudah ada";
				$this->logmodel->append($s);
				continue;
			}

			// periode baru (refreshment

			//$t2 = $pt2 + ($t2-$t1); // rentang wakut period, tetap sama
			//$t1 = $pt2;

			unset($data);
			$data['training_time_date1'] = date("Ymd", $t1_1);
			$data['training_time_date2'] = date("Ymd", $t2_1);
			$data['training_time_period'] = $period;
			$data['training_time_training'] = $list[$i]->training_time_training;
			$data['training_time_parent'] = $list[$i]->training_time_id;
			$data['training_time_refreshed'] = 0;

			$this->db->insert("training_time", $data);

			$s = "insert training id=".$list[$i]->training_time_training." :: refreshment per ".$list[$i]->training_time_period." month(s), t1=".$data['training_time_date1'].", t2=".$data['training_time_date2'];
			$this->logmodel->append($s);
		}

		// ambil setting untuk interval day reminder

		$q = $this->db->get("general_setting");
		$this->db->flush_cache();

		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		}

		$intervalday = isset($settings['day_interval']) ? $settings['day_interval'] : 0;
		$noticeperiodic = isset($settings['notice_per']) ? $settings['notice_per'] : 0;

		if ($intervalday == 0)
		{
			$s = "training/certificate reminder disabled";
			$this->logmodel->append($s);
			return;
		}

		// training yang all period harus ditangani secara khusus, karena reminder bukan berdasarkan period tetap ambil kapan

		$this->reminderforallperiod($intervalday, $settings, $participant);
		return;

		// ambil yang interval day kemudian, training akan aktif

		$nextperiod = mktime(0, 0, 0, date('n'), date('j')+$intervalday, date('Y'));

		$this->db->where("training_time_date1 >", date("Ymd"));
		$this->db->where("training_time_date1 <=", date("Ymd", $nextperiod));
		$this->db->where("training_time_date2 >=", date("Ymd", $nextperiod));
		$this->db->where("training_status", 1);
		$this->db->join("training_time", "training_time_training = training_id");
		$q = $this->db->get("training");
		$this->db->flush_cache();

		$rowtrainings = $q->result();

		if (count($rowtrainings) == 0)
		{
			$s = "tidak ada training yang harus direminder";
			$this->logmodel->append($s);
			return;
		}

		// training yang sudah direminder jangan diremind lagi

		$q = " AND ( 0 ";


		//get unique training id
		$total_rowtrainings = count($rowtrainings);
		$unique_training = array();
		if($total_rowtrainings > 0){
			foreach($rowtrainings as $value)
				$unique_training[$value->training_id] = true;
		}

		/*for($i=0; $i < $total_rowtrainings; $i++)
		{
			$q .= " OR (reminder_training = '".$rowtrainings[$i]->training_id."') ";
		}*/
		$total_unique_training = count($unique_training);
		if($total_unique_training){
			foreach($unique_training as $key=>$val)
			{
				$q .= " OR (reminder_training = '".$key."') ";
			}
		}


		/*for($i=0; $i < count($rowtrainings); $i++)
		{
			$q .= " OR (reminder_training = '".$rowtrainings[$i]->training_id."') ";
		}	*/


		$q .= " ) ";

		$sql = "SELECT *
			FROM
			(
				SELECT 	*
				FROM	".$this->db->dbprefix."reminder
				WHERE	1 ".$q."
				ORDER BY reminder_date DESC
			) t1
			GROUP BY reminder_training, reminder_user
		";

		$q = $this->db->query($sql);
		$this->db->flush_cache();

		$rowreminders = $q->result();

		$reminders = array();
		for($i=0; $i < count($rowreminders); $i++)
		{
			$reminders[$rowreminders[$i]->reminder_training][$rowreminders[$i]->reminder_user] = dbintmaketime($rowreminders[$i]->reminder_date, 0);
		}

		// get all participant on remiderext table

		if ($participant == "participantisdefined")
		{
			for($i=0; $i < count($rowtrainings); $i++)
			{
				$participanttrainingids[] = $rowtrainings[$i]->training_id;
			}

			if (isset($participanttrainingids))
			{
				$this->db->where_in("reminder_training_id", $participanttrainingids);
				$this->db->where("reminder_type", "refreshment");
				$this->db->where("reminder_status", 1);
				$this->db->where("reminderuser_status", 1);
				$this->db->join("reminderext", "reminder_id = reminderuser_reminder");
				$this->db->join("user", "user_id = reminderuser_user");
				$q = $this->db->get("reminderuser");
				$this->db->flush_cache();
				$rowsparticipantdefined = $q->result();
				for($i=0; $i < count($rowsparticipantdefined); $i++)
				{
					$participantdefined[$rowsparticipantdefined[$i]->reminder_training_id][] = $rowsparticipantdefined[$i];
				}
			}

		}

		// loop untuk training yang akan direminder

		for($i=0; $i < count($rowtrainings); $i++)
		{
			$reminderusers = isset($reminders[$rowtrainings[$i]->training_id]) ? $reminders[$rowtrainings[$i]->training_id] : array(0);
			$hasuserids = array();

			if ($participant == "participantisdefined")
			{
				if 	(! isset($participantdefined[$rowtrainings[$i]->training_id])) continue;

				$this->reminder($participantdefined[$rowtrainings[$i]->training_id], $hasuserids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);
				continue;
			}

			// all staff
			if ($rowtrainings[$i]->training_all_staff)
			{

				// ambil seluruh user

				$q = $this->db->get("user");
				$this->db->flush_cache();

				$rowusers = $q->result();

				if (count($rowusers) == 0)
				{
					$s = "tidak ada data user";
					$this->logmodel->append($s);
					return;
				}

				$this->reminder($rowusers, $hasuserids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);
				continue;
			}

			// groups

			$this->db->where("training_levelgroup_training", $rowtrainings[$i]->training_id);
			$q = $this->db->get('training_levelgroup');
			$this->db->flush_cache();

			$rowgroups = $q->result();

			$groupids = array(0);
			for($j=0; $j < count($rowgroups); $j++)
			{
				$groupids[] = $rowgroups[$j]->training_levelgroup_levelgroup;
				$this->levelmodel->getGroupChildIds($groupids, $rowgroups[$j]->training_levelgroup_levelgroup);
			}

			$this->db->where_in("jabatan_level_group", $groupids);
			$this->db->join("jabatan", "jabatan_id = user_jabatan");
			$q = $this->db->get('user');

			$rowusers = $q->result();

			$userids = $this->reminder($rowusers, $hasuserids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);
			$hasuserids = array_merge($hasuserids, $userids);

			// jabatan

			$this->db->where("training_jabatan_training", $rowtrainings[$i]->training_id);
			$this->db->join("training_jabatan", "training_jabatan_jabatan = user_jabatan");
			$q = $this->db->get('user');
			$this->db->flush_cache();

			$rowusers = $q->result();
			$userids = $this->reminder($rowusers, $hasuserids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);
			$hasuserids = array_merge($hasuserids, $userids);

			// by npk

			$this->db->where("training_npk_training", $rowtrainings[$i]->training_id);
			$this->db->join("training_npk", "training_npk_npk = user_id");
			$q = $this->db->get('user');
			$this->db->flush_cache();

			$rowusers = $q->result();

			$userids = $this->reminder($rowusers, $reminderids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);
			$hasuserids = array_merge($hasuserids, $userids);

			// category jabatan

			$this->db->where("training_catjabatan_training", $rowtrainings[$i]->training_id);
			$this->db->join("jabatan", "jabatan_id = user_jabatan");
			$this->db->join("training_catjabatan", "training_catjabatan_id = jabatan_category");
			$q = $this->db->get('user');
			$this->db->flush_cache();

			$rowusers = $q->result();

			$userids = $this->reminder($rowusers, $hasuserids, $intervalday, $settings, $rowtrainings[$i], $reminderusers);

		}


	}

	function reminderforallperiod($intervalday, $settings, $participant="")
	{
		$noticeperiodic = isset($settings['notice_per']) ? $settings['notice_per'] : 0;
/*
		$sql = "SELECT *
			FROM
			(
				SELECT *
				FROM		".$this->db->dbprefix."user
				INNER JOIN 	".$this->db->dbprefix."history_exam ON user_id =history_exam_user
				INNER JOIN	".$this->db->dbprefix."training ON training_id = history_exam_training
				LEFT OUTER JOIN	".$this->db->dbprefix."training_time ON training_id = training_time_training
				WHERE		1
						AND (training_status = 1)
						AND (training_time_id IS NULL)
						AND ((training_type = 1) OR (training_type = 2))
						AND (training_refreshment > 0)
				ORDER BY history_exam_date DESC, history_exam_time DESC
			) t1
			GROUP BY training_id, user_id
			";
*/
		$sql = "SELECT *
			FROM
			(
				SELECT *
				FROM		".$this->db->dbprefix."user
				INNER JOIN 	".$this->db->dbprefix."history_exam ON user_id =history_exam_user
				INNER JOIN	".$this->db->dbprefix."training ON training_id = history_exam_training
				WHERE		1
						AND (training_status = 1)
						AND ((training_type = 1) OR (training_type = 2))
						AND (training_refreshment > 0)
						AND history_exam_status = '1'
				ORDER BY history_exam_date DESC, history_exam_time DESC
			) t1
			GROUP BY training_id, user_id
			";

		$q = $this->db->query($sql);
		$this->db->flush_cache();
		//echo $sql;

		$rowtrainings = $q->result();

		// get all participant on remiderext table

		if ($participant == "participantisdefined")
		{
			for($i=0; $i < count($rowtrainings); $i++)
			{
				$participanttrainingids[] = $rowtrainings[$i]->training_id;
			}


			if (! isset($participanttrainingids))
			{
				echo "tidak ada training yang harus direfreshment\r\n";
				return;
			}

			$participanttrainingids = array_unique($participanttrainingids);
			$this->db->distinct();
			$this->db->select("reminderuser_user");
			$this->db->select("reminder_training_id");
			$this->db->select("reminderuser_email");
			$this->db->where_in("reminder_training_id", $participanttrainingids);
			$this->db->where("reminder_type", "refreshment");
			$this->db->where("reminder_status", 1);
			$this->db->where("reminderuser_status", 1);
			$this->db->join("reminderext", "reminder_id = reminderuser_reminder");
			$this->db->join("user", "user_id = reminderuser_user");
			$q = $this->db->get("reminderuser");
			$this->db->flush_cache();
			//echo $this->db->last_query()."/r/n";

			if ($q->num_rows() == 0)
			{
				echo "tidak ada user yang terdifinisi\r\n";
				return;
			}

			$rowsparticipantdefined = $q->result();
			for($i=0; $i < count($rowsparticipantdefined); $i++)
			{
				//$participantdefinedusers[$rowsparticipantdefined[$i]->reminder_training_id][$rowsparticipantdefined[$i]->reminderuser_user] = 1;
				$participantdefinedusers[$rowsparticipantdefined[$i]->reminder_training_id][$rowsparticipantdefined[$i]->reminderuser_user] = $rowsparticipantdefined[$i];
			}

		}
		//print_r($participantdefinedusers);
		// training yang sudah direminder jangan diremind lagi

		$q = " AND ( 0 ";

		//get unique training id
		$total_rowtrainings = count($rowtrainings);
		$unique_training = array();
		if($total_rowtrainings > 0){
			foreach($rowtrainings as $value)
				$unique_training[$value->training_id] = true;
		}

		/*for($i=0; $i < $total_rowtrainings; $i++)
		{
			$q .= " OR (reminder_training = '".$rowtrainings[$i]->training_id."') ";
		}*/
		$total_unique_training = count($unique_training);
		if($total_unique_training){
			foreach($unique_training as $key=>$val)
			{
				$q .= " OR (reminder_training = '".$key."') ";
			}
		}

		$q .= " ) ";

		$sql = "SELECT *
			FROM
			(
				SELECT 	*
				FROM	".$this->db->dbprefix."reminder
				WHERE	1 ".$q."
				ORDER BY reminder_date DESC
			) t1
			GROUP BY reminder_training, reminder_user
		";

		$q = $this->db->query($sql);
		$this->db->flush_cache();

		$rowreminders = $q->result();

		$reminders = array();
		for($i=0; $i < count($rowreminders); $i++)
		{
			$reminders[$rowreminders[$i]->reminder_training][$rowreminders[$i]->reminder_user] = dbintmaketime($rowreminders[$i]->reminder_date, 0);
		}

		$reminderdate = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		//print_r($rowtrainings);
		for($i=0; $i < count($rowtrainings); $i++)
		{
			if ($participant == "participantisdefined")
			{
				if (! isset($participantdefinedusers[$rowtrainings[$i]->training_id])) continue;
				if (! isset($participantdefinedusers[$rowtrainings[$i]->training_id][$rowtrainings[$i]->user_id])) continue;

				$rowtrainings[$i]->reminderuser_email = $participantdefinedusers[$rowtrainings[$i]->training_id][$rowtrainings[$i]->user_id]->reminderuser_email;
				$rowtrainings[$i]->reminder_deadline_date = $participantdefinedusers[$rowtrainings[$i]->training_id][$rowtrainings[$i]->user_id]->reminder_deadline_date;
				$rowtrainings[$i]->reminder_deadline_month = $participantdefinedusers[$rowtrainings[$i]->training_id][$rowtrainings[$i]->user_id]->reminder_deadline_month;
				$rowtrainings[$i]->reminder_deadline_year = $participantdefinedusers[$rowtrainings[$i]->training_id][$rowtrainings[$i]->user_id]->reminder_deadline_year;
			}

			$lastreminderdate = isset($reminders[$rowtrainings[$i]->training_id][$rowtrainings[$i]->history_exam_user]) ? $reminders[$rowtrainings[$i]->training_id][$rowtrainings[$i]->history_exam_user] : 0;

			$t = dbintmaketime($rowtrainings[$i]->history_exam_date, $rowtrainings[$i]->history_exam_time);

			$reminderstart = mktime(0, 0, 0, date('n', $t)+$rowtrainings[$i]->training_refreshment, date('j', $t)-$intervalday, date('Y', $t));
			$nextperiod = mktime(0, 0, 0, date('n', $t)+$rowtrainings[$i]->training_refreshment, date('j', $t), date('Y', $t));

			// sekarang < tanggal lulus terakhir - interval day
			if ($reminderdate < $reminderstart)
			{
				// tanggal belum sampe

				echo "0x001: (".$rowtrainings[$i]->training_id.") ; user(".$rowtrainings[$i]->history_exam_user.")".$rowtrainings[$i]->history_exam_date." :: ".date("Y-m-d H:i:s", $reminderdate)." :: ".date("Y-m-d", $nextperiod)."\r\n";
				continue;
			}

			if ($reminderdate > $nextperiod)
			{
				// tanggal sudah lewat

                                echo "0x002: (".$rowtrainings[$i]->training_id.") ; user(".$rowtrainings[$i]->history_exam_user.")".$rowtrainings[$i]->history_exam_date." :: ".date("Y-m-d H:i:s", $reminderdate)." :: ".date("Y-m-d", $nextperiod)."\r\n";
                                continue;
			}

			// jika notice period = 0, hanya 1 x direminder
			if ($noticeperiodic == 0)
			{
				if ($lastreminderdate > 0)
				{
                               		echo "0x003: (".$rowtrainings[$i]->training_id.") ; user(".$rowtrainings[$i]->history_exam_user.")".$rowtrainings[$i]->history_exam_date." :: ".date("Y-m-d H:i:s", $reminderdate)." :: ".date("Y-m-d", $nextperiod)."\r\n";
					continue;
				}

				if ($reminderdate != $reminderstart)
                        	{
                                	// belum saatnya direminder atau tanggal sudah lewat

                                	echo "0x004: (".$rowtrainings[$i]->training_id.") ; user(".$rowtrainings[$i]->history_exam_user.")".$rowtrainings[$i]->history_exam_date." :: ".date("Y-m-d H:i:s", $reminderdate)." :: ".date("Y-m-d", $nextperiod)."\r\n";
                                	continue;
                        	}
			}

			$lastreminderdate = mktime(0, 0, 0, date('n', $lastreminderdate), date('j', $lastreminderdate), date('Y', $lastreminderdate));
			if ($lastreminderdate == $reminderdate)
			{
				// hari ini sudah direminder
				continue;
			}

			$t1 = $reminderstart;
			while(1)
			{
				if ($t1 > $reminderdate)
				{
                                	// bukan kelipatan notice periodic
                                	echo "0x005: (".$rowtrainings[$i]->training_id.") ; user(".$rowtrainings[$i]->history_exam_user.")".$rowtrainings[$i]->history_exam_date." :: ".date("Y-m-d H:i:s", $reminderdate)." :: ".date("Y-m-d", $nextperiod)." :: ".date("Y-m-d", $reminderstart)." :: ".date("Y-m-d", $lastreminderdate)." \r\n";
					break;
				}

				if (date("Ymd", $reminderdate) != date("Ymd", $t1))
				{
					$t1 = mktime(0, 0, 0, date('n', $t1), date('j', $t1)+$noticeperiodic, date('Y', $t1));
					continue;
				}

                       		$this->sendmail($intervalday, $settings, $rowtrainings[$i], $rowtrainings[$i]);
                        	$reminders[$rowtrainings[$i]->training_id][$rowtrainings[$i]->reminder_user] = mktime();

				break;
			}
		}
	}

	function reminder($users, $hasuserids, $intervalday, $settings, $training, $reminders)
	{

		$noticeperiodic = isset($settings['notice_per']) ? $settings['notice_per'] : 0;

		$issentall = true;
		$userids = array(0);
		for($i=0; $i < count($users); $i++)
		{
			$userids[] = $users[$i]->user_id;

			if (in_array($users[$i]->user_id, $hasuserids))
			{
				continue;
			}

			$t = dbintmaketime($training->training_time_date1, 0);

			if (isset($reminders[$users[$i]->user_id]))
			{
				$lastreminderdate = $reminders[$users[$i]->user_id]; // terakhir direminder

				// cek apakah sudah pernah sebelumnya
				$lastreminderdate1 = mktime(0, 0, 0, date('n', $lastreminderdate), date('j', $lastreminderdate)+$intervalday, date('Y', $lastreminderdate));
				if ($lastreminderdate1 >= $t)
				{
					// sudah pernah sebelumnya
					if ($noticeperiodic == 0) continue;

					$lastreminderdate1 = mktime(0, 0, 0, date('n', $lastreminderdate), date('j', $lastreminderdate)+$noticeperiodic, date('Y', $lastreminderdate));
					if ($lastreminderdate1 > $t) continue;

					$sekarang = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
					if ($lastreminderdate1 != $sekarang) continue;

				}
			}

			//if (isset($reminders[$users[$i]->user_id]) && ($reminders[$users[$i]->user_id] >= $t))
			//{
			//	continue;
			//}

			$sent = $this->sendmail($intervalday, $settings, $users[$i], $training);
			$issentall = false;

			sleep(1);
		}

		if ($issentall)
		{
			$this->logmodel->append("All reminder sent before");
		}

		return $userids;
	}

	function sendmail($intervalday, $settings, $user, $training)
	{

		if (isset($user->reminderuser_email) && valid_email($user->reminderuser_email))
		{
			$user->user_email = $user->reminderuser_email;
		}

		$t = dbintmaketime($training->training_time_date1, 0);
		$training->training_time_date1_fmt = date("d/m/Y", $t);

		$t = dbintmaketime($training->training_time_date2, 0);
		$training->training_time_date2_fmt = date("d/m/Y", $t);

		if (isset($training->training_data) && $training->training_data)
		{
			$exdata = json_decode($training->training_data);

		}

		if (! $user->user_email)
		{
			$s = "NOK [mail address empty] send mail to ".$user->user_npk." ".$user->user_first_name." ".$user->user_last_name." ".$user->user_email."\r\n";

			echo $s;
			$this->logmodel->append($s);
			return true;
		}

		$s = date("Y-m-d H:i:s")." : sending email to ".$user->user_npk." <".$user->user_email.">\r\n";
		echo $s;
		$this->logmodel->append($s);

		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("intervalday", $intervalday);
		$this->mysmarty->assign("user", $user);
		$this->mysmarty->assign("training", $training);
		$this->mysmarty->assign("training_typedesc",($training->training_type=="1")?"Training":"Certification");


		$this->config->load('config.en');

		$months = $this->config->item("months");

		$training->reminder_deadline_month = ($training->reminder_deadline_month)?$training->reminder_deadline_month:date('n')-1;
		$training->reminder_deadline_year = ($training->reminder_deadline_year)?$training->reminder_deadline_year:date('Y');
		$training->reminder_deadline_date = ($training->reminder_deadline_date)?$training->reminder_deadline_date:'lend_of';

		$this->mysmarty->assign("lend_of_en", $this->config->item($training->reminder_deadline_date));
		$this->mysmarty->assign("deadline_month_en", $months[$training->reminder_deadline_month]);
		$this->mysmarty->assign("deadline_year_en", $training->reminder_deadline_year);


		$this->config->load('config.id');

		$months = $this->config->item("months");

		$this->mysmarty->assign("lend_of_id", $this->config->item($training->reminder_deadline_date));
		$this->mysmarty->assign("deadline_month_id", $months[$training->reminder_deadline_month]);
		$this->mysmarty->assign("deadline_year_id", $training->reminder_deadline_year);

		$this->config->load('config.'.($this->langue ? $this->langue : $this->langmodel->getDefaultLang()));

		$message = $this->mysmarty->fetch("training/reminder-message.html");

		$this->load->library('email');

		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype']	    	= "html";

		if (isset($this->settings['mailtype']) && ($this->settings['mailtype'] == "smtp"))
		{
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $settings['smtphost'];
			$config['smtp_user'] = isset($settings['smtpuser']) ? 	$settings['smtpuser'] : "";
			$config['smtp_pass'] = 	isset($settings['smtppass']) ? 	$settings['smtppass'] : "";
		}
		else
		{
			$config['protocol'] = 'mail';
		}

		$config['mailtype'] = (isset($this->settings['mailcontenttype']) && $this->settings['mailcontenttype']) ? $this->settings['mailcontenttype'] : "html";

		$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
		$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";

		$subject = isset($settings['remindermailsubject']) ? $settings['remindermailsubject'] : "[lmsv2] reminder";

		$this->email->initialize($config);
		$this->email->from($mailsender, $sendername);
		$this->email->to($user->user_email);
		$this->email->subject($subject);
		$this->email->message($message);

		if ($this->email->send())
		{
			$s_echo = "OK send mail to ".$user->user_npk." ".$user->user_first_name." ".$user->user_last_name." ".$user->user_email." ".$training->training_name."(".$training->training_id.")\r\n";
			$message1 = $s_echo." ".$message;

			unset($data);

			$data['reminder_date'] = date("Ymd");
			$data['reminder_from'] = $sendername."<".$mailsender.">";
			$data['reminder_user'] = $user->user_id;
			$data['reminder_message'] = $message;
			$data['reminder_training'] = $training->training_id;

			$this->db->insert("reminder", $data);

			unset($insert);

			$desc["subject"] = $subject;
			$desc["message"] = $message;
			$desc["npk"] = $user->user_npk;

			$insert['log_type'] = "reminder";
			$insert['log_user'] = $user->user_id;
			$insert['log_status'] = 1;
			$insert['log_created'] = date("Y-m-d H:i:s");
			$insert['log_desc'] = json_encode($desc);
			$insert['log_param1'] = $training->training_id;

			$this->db->insert("log", $insert);

			$sent = 1;
		}
		else
		{
			$s_echo = "NOK send mail to ".$user->user_npk." ".$user->user_first_name." ".$user->user_last_name." ".$user->user_email;
			$message1 = $s_echo." ".$message;
			$sent = 0;

			unset($insert);

			$desc["subject"] = $subject;
			$desc["message"] = $message;
			$desc["npk"] = $user->user_npk;

			$insert['log_type'] = "reminder";
			$insert['log_user'] = $user->user_id;
			$insert['log_status'] = 2;
			$insert['log_created'] = date("Y-m-d H:i:s");
			$insert['log_desc'] = json_encode($desc);
			$insert['log_param1'] = $training->training_id;

			$this->db->insert("log", $insert);

		}

		$this->email->clear(TRUE);

		echo $s_echo;
		$this->logmodel->append($message1);

		return $sent;
	}

	function getavailparticipant($id, $training_npk_time_id=0)
	{
		$recordperpage = 5; //$this->commonmodel->getRecordPerPage();

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");

		if ($q->num_rows() == 0)
		{
			return;
		}

		$row = $q->row();

		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;

		$this->db->limit($recordperpage, $offset);

		if (false)
		{
			$this->db->where("user_type >", 0);
			$q = $this->db->get("user");
			$this->db->flush_cache();

			$npks = $q->result();

			$this->db->where("user_type >", 0);
			$total = $this->db->count_all_results("user");
		}
		else
		{
			if(empty($training_npk_time_id)) {
				$this->db->where("training_time_training", $id);
				$q = $this->db->get("training_time");
				$rowtimetraining = $q->result();

				$data_time = array();
				foreach ($rowtimetraining as $value) {
					$data_time[] = $value->training_time_id;
				}

				if(!empty($data_time)) {
					//$this->db->where_in('training_npk_time_id', $data_time);
					$this->db->where('training_npk_time_id', 0);
				}
			} else {
				$this->db->where('training_npk_time_id', $training_npk_time_id);
			}

			$this->db->where("training_npk_training", $id);
			$this->db->join("user", "training_npk_npk = user_id");
			$this->db->limit($recordperpage, $offset);
			$q = $this->db->get("training_npk");
			$this->db->flush_cache();
			$npks = $q->result();
			//echo $this->db->last_query();

			if(empty($training_npk_time_id)) {
				$this->db->where("training_time_training", $rowtraining->training_id);
				$q = $this->db->get("training_time");
				$rowtimetraining = $q->result();

				$data_time = array();
				foreach ($rowtimetraining as $value) {
					$data_time[] = $value->training_time_id;
				}

				if(!empty($data_time)) {
					//$this->db->where_in('training_npk_time_id', $data_time);
					$this->db->where('training_npk_time_id', 0);
				}
			} else {
				$this->db->where('training_npk_time_id', $training_npk_time_id);
			}

			$this->db->where("training_npk_training", $id);
			$this->db->join("user", "training_npk_npk = user_id");
			$total = $this->db->count_all_results("training_npk");

		}
		$this->load->library('pagination');

		$config['cur_page'] = $offset;
		//$config['base_url'] = 'pageavail';
		$config['base_url'] = base_url()."index.php/training/getavailparticipant/".$id."/".$training_npk_time_id."/?pageavail";
		$config['total_rows'] = $total;
		$config['per_page'] = $recordperpage;

		$this->pagination->initialize($config);

		$this->mysmarty->assign("paging", $this->pagination->create_links());

		$this->mysmarty->assign("trainingid", $id);
		$this->mysmarty->assign("training_npk_time_id", $training_npk_time_id);
		$this->mysmarty->assign("npks", $npks);
		$this->mysmarty->assign("lsave", $this->config->item("lsave"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lavailable_participant", $this->config->item("lavailable_participant"));
		$this->mysmarty->assign("lremove_confirmation", $this->config->item("lremove_all_confirmation"));

		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lremove_all", $this->config->item("lremove_all"));

		$this->mysmarty->display("training/participant-avail.html");
	}

	function updateavailparticipant($id, $training_npk_time_id = 0)
	{
		//$this->db->where("training_npk_training", $id);
		//$this->db->where_in("training_npk_npk", $_POST['hidecheckavail']);
		//$this->db->delete("training_npk");

        if ($checkallavail = $this->input->post('checkallavail')) {
            return;
        } else {

        }

        $checkavail = $this->input->post('checkavail') ? $this->input->post('checkavail') : array();
        $hidecheckavail = $this->input->post('hidecheckavail') ? $this->input->post('hidecheckavail') : array();

        $npks_to_delete = array_diff($hidecheckavail, $checkavail);

		foreach($npks_to_delete as $npk_to_delete)
		{
			unset($delete);

			$delete["training_npk_npk"] = $npk_to_delete;
			$delete["training_npk_training"] = $id;
			$delete["training_npk_time_id"] = $training_npk_time_id;

			$this->db->delete("training_npk", $delete);
		}


		$totaluser = $this->db->count_all_results("user");


		$update['training_all_staff'] = count($checkavail) > $totaluser;


		$this->db->where("training_id", $id);
		$this->db->update("training", $update);

	}

	function removeallavailparticipant($id, $training_npk_time_id = 0)
	{
		$this->db->where("training_npk_training", $id);
		$this->db->where("training_npk_time_id", $training_npk_time_id);
		$this->db->delete("training_npk");

		$update['training_all_staff'] = false;
		$this->db->where("training_id", $id);
		$this->db->update("training", $update);

	}

	function importhistory()
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
			return;
		}

		$this->mysmarty->assign("limport_training_history", $this->config->item("limport_training_history"));
		$this->mysmarty->assign("lbrowse_file_csv", $this->config->item("lbrowse_file_csv"));


		if (isset($sess['asadmin']) && ($sess['user_type'] == 0))
		{
			$this->mysmarty->assign("users", $rowusers);
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}

		$this->mysmarty->assign("main_content", "training/importhistory.html");
		$this->mysmarty->display("sess_template.html");
	}

	function savehistory()	{
		$this->logmodel->init("history_training");
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		$errs = array();

		if (! isset($_FILES['userfile']))
		{
			$errs[] = $this->config->item("lempty_user_file");
		}
		else
		if (! $_FILES['userfile']['name'])
		{
			$errs[] = $this->config->item("lempty_user_file");
		}
		else{

			$this->load->library('getcsv');
			$this->load->library('enkrip');

           	$filePath = $_FILES['userfile']['tmp_name'];
      		$data = array("training_code","exam_date","start_time","end_time","exam_score","user_npk","status","min_score","type");

			//read the file
           	$csvdata = $this->getcsv->get_csv_assoc_array($filePath,$data);

           	//check if the file contain data
           	$totalCVSdata = count($csvdata);

 			if (! $totalCVSdata)
			{
				$errs[] = $this->config->item("lempty_user_file_data");
			}

 			//check user , check if all data is 1 user, and match with user npk
 			$training = array();
 			foreach($csvdata as $value){
 				if($this->sess['user_npk'] != $value['user_npk']){
 					$errs[] = $this->config->item("linvalid_npk")." ".$value['user_npk'];
 					break;
 				}

 				array_push($training,$value['training_code']);
 			}

 			if(count($training))
 				$training = array_unique($training);

 			if(count($errs) == 0) {
	 			//get training id
				$this->db->select("training_id,training_code,training_name");
				$this->db->where_in("training_code",$training);
				$q = $this->db->get("training");
				$rowstraining = $q->result();
				$this->db->flush_cache();

				//all training is not found
				if(count($rowstraining) == 0){
					$errs[] = $this->config->item("ltraining_not_found")." : ".implode($training,",");
				}else{
					$training_ids = array();
					foreach($training as $value){
						$found = false;
						foreach($rowstraining as $key2=>$value2){
							if($value == $value2->training_code){
								$training_ids[$value] = $value2;
								$found = true;
							}
						}

						if(!$found){
							$errs[] = $this->config->item("ltraining_not_found")." : ".$value;
						}
					}

				}
			}
		}

		if (count($errs) == 0){
				//training_code;exam_date;exam_time;exam_score;user_npk;status;min_score;type;
				$message = "";
				$line = $timport = $tskip = 0;
				foreach($csvdata as $key=>$value){
					$line++;
					//if exists same date time, then skipp insert
					$this->db->select("count(history_exam_id) as total");
					$this->db->where("history_exam_training",$training_ids[$value['training_code']]->training_id);
					$this->db->where("history_exam_user",$this->sess['user_id']);
					$this->db->where("history_exam_date",$value['exam_date']);
					$this->db->where("history_exam_time",$value['end_time']);
					$q = $this->db->get("history_exam");
					$rowsdatas = $q->result();

					//echo $this->db->last_query()  ." : ".$rowsdatas[0]->total;
					//echo "<BR>";
					$to_log = "";
					foreach($data as $v){
						$to_log .= $value[$v].";";
					}

					if($rowsdatas[0]->total == 0){
						$timport++;

						//insert each row
						//Key Enkripsi : NT120100 + tanggal training + kode training + user_npk
						//example : NT120100201313TRN-00000100215
						$key_decrypt = "NT120100".$value['exam_date'].$value['training_code'].$value['user_npk'];
						$decrypt_score = $this->enkrip->decrypt($value['exam_score'],$key_decrypt);
						$insert['history_exam_training'] = $training_ids[$value['training_code']]->training_id;
						$insert['history_exam_date'] 	= $value['exam_date'];//start_time;end_time;
						$insert['history_exam_startdate'] 	= $value['exam_date'];
						$insert['history_exam_time'] 	= $value['end_time'];
						$insert['history_exam_starttime'] 	= $value['start_time'];
						$insert['history_exam_score'] 	= ($decrypt_score)?$decrypt_score:0;
						$insert['history_exam_user'] 	= $this->sess['user_id'];
						$insert['history_exam_status'] 	= $value['status'];
						$insert['history_exam_minscore'] 	= $value['min_score'];
						$insert['history_exam_type'] 		= $value['type'];
						//$insert['history_exam_startdate'] 	= $value['exam_date'];
						//$insert['history_exam_starttime'] 	= $value['start_time'];

						//echo " <BR> insert ".$value['start_time'].";".$line;
						$this->logmodel->append("insert : ".$to_log);

						$this->db->insert("history_exam", $insert);
						//echo "<BR>".$this->db->last_query();
						//echo "<BR>";
					}else{
						$tskip++;
						$this->logmodel->append("skip insert :".$to_log);
					}
				}

				$message = $this->config->item('limporthistory_save');
				$message = sprintf($message, $totalCVSdata,$timport,$tskip);
				echo "<script>parent.setSuccess('messageimportnew', \"".$message."\")</script>";

			}else {
				$this->mysmarty->assign("errs", $errs);
				$err = $this->mysmarty->fetch("errmessage.html");
				$err = str_replace("\"", "'", $err);
				$err = str_replace("\r", "", $err);
				$err = str_replace("\n", "", $err);

				echo "<script>parent.setErrorMessage('messageimportnew', \"".$err."\")</script>";

				return;
			}
	}

	private function check_delegate_training($my_id, $topic) {
		$this->db->select("training_id, training_name");
		$this->db->where('training_topic = "' . $topic . '" AND delegetion_user = "' . $my_id . '"');
		$this->db->join('training', 'delegetion_training = training_id');
		$res = $this->db->get("delegetion")->result();
		//print_r($res);
		return $res;
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
