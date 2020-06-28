<?php
include_once "base.php"; 

class Report extends Base {
	var $sess;
	var $lang;
	var $modules;

	function Report()
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
		$this->load->model("topicmodel");
		
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
		}		
		$this->langmodel->init();
		
	}
	
	function index()
	{		
		$this->checkadmin();
					
		if (! isset($this->modules['report']))
		{
			redirect(base_url());
		}										
		
		$this->mysmarty->assign("lgeneral_report", $this->config->item("lgeneral_report"));
		$this->mysmarty->assign("lreport_type", $this->config->item("lreport_type"));
		$this->mysmarty->assign("lperiod", $this->config->item("lperiod"));
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));		
		
		$this->mysmarty->assign("left_content", "report/menu.html");
		$this->mysmarty->assign("main_content", "report/general.html");
		$this->mysmarty->display("sess_template.html");
		
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
	
	function certification()
	{	
		$this->checkadmin();
						
		if ((! isset($this->sess['asadmin'])) && (! isset($this->modules['report'])))
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		
		$category = isset($_POST['category']) ? $_POST['category'] : 0;	
		$topic = isset($_POST['topic']) ? $_POST['topic'] : 0;	

		$period1 = isset($_POST['period1']) ? trim($_POST['period1']) : '';
		$period2 = isset($_POST['period2']) ? trim($_POST['period2']) : '';
		
		$isexport = isset($_POST['isexport']) ? trim($_POST['isexport']) : 0;
		
		if ($category)
		{
			$topics = array(0);
			$this->topicmodel->getAllTopics($topics, $category);
		}

		if (! isset($_POST['category']))
		{
			$this->db->where("training_id", 0);
		}
		
		if (isset($topics))
		{
			$this->db->where_in("training_topic", $topics);
		}

		if ($topic)
		{
			$this->db->where("training_topic", $topic);
		}

		if ($period1)
		{
			$t1 = formmaketime($period1." 00:00:00");
			$this->db->where("history_exam_date >=", date("Ymd", $t1));
			
		}

		if ($period2)
		{
			$t2 = formmaketime($period2." 00:00:00");
			$this->db->where("history_exam_date <=", date("Ymd", $t2));
		}

		$this->db->where("history_exam_type >", 1);		
		$this->db->order_by("history_exam_date", "asc");
		$this->db->order_by("history_exam_time", "asc");		
		$this->db->group_by("history_exam_no, user_id, training_id");
						
		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("category", "category_id = training_topic");
		$this->db->join("user", "history_exam_user = user_id");	
		if ($isexport)
		{			
			$q = $this->db->get("history_exam");				
		}
		else
		{
			$q = $this->db->get("history_exam", $limit, $offset);
		}
		$rows = $q->result();
		
		$this->db->flush_cache();
		
		// total
		if (! $isexport)
		{
			if (! isset($_POST['category']))
			{
				$this->db->where("training_id", 0);
			}
			
			if (isset($topics))
			{
				$this->db->where_in("training_topic", $topics);
			}
	
			if ($topic)
			{
				$this->db->where("training_topic", $topic);
			}
	
			if ($period1)
			{
				$t1 = formmaketime($period1." 00:00:00");
				$this->db->where("history_exam_date >=", date("Ymd", $t1));
				
			}
	
			if ($period2)
			{
				$t2 = formmaketime($period2." 00:00:00");
				$this->db->where("history_exam_date <=", date("Ymd", $t2));
			}
	
			$this->db->where("history_exam_type >", 1);
			$this->db->order_by("history_exam_date", "asc");
			$this->db->order_by("history_exam_time", "asc");		
			$this->db->group_by("history_exam_no, user_id, training_id");
			$this->db->join("training", "history_exam_training = training_id");
			$this->db->join("category", "category_id = training_topic");
			$this->db->join("user", "history_exam_user = user_id");						
			$this->db->select("history_exam_no, user_id, training_id");
			$q = $this->db->get("history_exam");
			$total_rows = $q->num_rows();
		}
				
		for($i=0; $i < count($rows); $i++)
		{
			$t = dbintmaketime($rows[$i]->history_exam_date, $rows[$i]->history_exam_time);
			
			switch($rows[$i]->history_exam_type)
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
			
			$rows[$i]->history_exam_date_fmt = date("d/m/Y", $t);
			$rows[$i]->history_exam_no_fmt = date("mY", $t)."-".$codeactivated."-".sprintf("%08d", $rows[$i]->history_exam_no);
		}
				
		$category_tree = "";
		$this->topicmodel->getParentTreeOptions($category_tree, 0, $category, 0, 0);
		
		$this->mysmarty->assign("category_tree", $category_tree);
		$this->mysmarty->assign("rows", $rows);
		
		if ($isexport)
		{
			$this->load->library("xlswriter");
			
			$this->xlswriter->send(date("Ymd")."-certification-list.xls");
			
			$worksheet =& $this->xlswriter->addWorksheet("cerfication list per ".date("Ymd"));
			
			$worksheet->write(0, 0, 'No');
			$worksheet->write(0, 1, $this->config->item('ldate'));
			$worksheet->write(0, 2, $this->config->item('lcertificate_no'));
			$worksheet->write(0, 3, 'NPK');
			$worksheet->write(0, 4, $this->config->item('name'));
			$worksheet->write(0, 5, $this->config->item('ltopic_code'));
			$worksheet->write(0, 6, $this->config->item('topic'));
			$worksheet->write(0, 7, $this->config->item('training_name')."/".$this->config->item('certificate_name'));
			
			for($i=0; $i < count($rows); $i++)
			{
				$worksheet->write($i+1, 0, $i+1);
				$worksheet->write($i+1, 1, $rows[$i]->history_exam_date_fmt);
				$worksheet->write($i+1, 2, $rows[$i]->history_exam_no_fmt);
				$worksheet->write($i+1, 3, $rows[$i]->user_npk);
				$worksheet->write($i+1, 4, $rows[$i]->user_first_name." ".$rows[$i]->user_last_name);
				$worksheet->write($i+1, 5, $rows[$i]->category_code);
				$worksheet->write($i+1, 6, $rows[$i]->category_name);
				$worksheet->write($i+1, 7, $rows[$i]->training_name);
			}			
			
			$this->xlswriter->close();			
			
			return;
		}
		
		$this->mysmarty->assign("lcertification_list", $this->config->item('lcertification_list'));
		$this->mysmarty->assign("ldate", $this->config->item('ldate'));
		$this->mysmarty->assign("lcertificate_no", $this->config->item('lcertificate_no'));
		$this->mysmarty->assign("lname", $this->config->item('name'));
		$this->mysmarty->assign("ltopic_code", $this->config->item('ltopic_code'));
		$this->mysmarty->assign("ltopic", $this->config->item('topic'));
		$this->mysmarty->assign("lcertificate_name", $this->config->item('certificate_name'));
		$this->mysmarty->assign("ltraining_name", $this->config->item('training_name'));
		$this->mysmarty->assign("lsearch_by", $this->config->item('lsearch_by'));
		$this->mysmarty->assign("lsearch", $this->config->item('lsearch'));
		$this->mysmarty->assign("lcategory", $this->config->item('category'));
		$this->mysmarty->assign("lallcategory", $this->config->item('lallcategory'));
		$this->mysmarty->assign("lalltopic", $this->config->item('lalltopic'));
		$this->mysmarty->assign("lperiod", $this->config->item('period'));
		$this->mysmarty->assign("luntil", $this->config->item('luntil'));
		$this->mysmarty->assign("lexport", $this->config->item('lexport'));	
		
		$config['total_rows'] = $total_rows;
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
		$this->pagination1->lang_title = $this->config->item('user');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total_rows;
		$this->pagination1->cur_page = $offset;		
		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());	
		
		$this->mysmarty->assign("category", $category);
		$this->mysmarty->assign("topic", $topic);
		$this->mysmarty->assign("period1", $period1);
		$this->mysmarty->assign("period2", $period2);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		
		$this->mysmarty->assign("left_content", "report/menu.html");
		$this->mysmarty->assign("main_content", "report/certification.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function reportcertificationvalidation()
	{
		$period1 = isset($_POST['period1']) ? trim($_POST['period1']) : '';
		$period2 = isset($_POST['period2']) ? trim($_POST['period2']) : '';
		
		if ($period1)
		{
			$t1 = formmaketime($period1." 00:00:00");
			
			if (date("d/m/Y", $t1) != $period1)
			{
				echo json_encode(array("message"=>$this->config->item('linvalid_period'), "error"=>true));
				return;
			}
		}
		
		if ($period2)
		{
			$t2 = formmaketime($period2." 00:00:00");
			
			if (date("d/m/Y", $t2) != $period2)
			{
				echo json_encode(array("message"=>$this->config->item('linvalid_period'), "error"=>true));
				return;
			}
		}
		
		if (isset($t1) && isset($t2) && ($t1 > $t2))
		{
			echo json_encode(array("message"=>$this->config->item('linvalid_period'), "error"=>true));
			return;
		}				
		
		echo json_encode(array("error"=>false));
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */