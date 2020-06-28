<?php
include_once "base.php"; 

class Reminder extends Base {
	var $sess;
	var $lang;
	var $modules;
	var $settings;
	var $lmonths_en; 
	var $lmonths_id;
	var $lang_en,$lang_id;

	function Reminder()
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
		
		$this->logmodel->init("reminder_mandatory");
		
		$this->load->database();	
		$lang = $this->session->userdata('lms_lang');
		$this->lang = $lang;
		$this->config->load('config.'.($lang ? $lang : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $lang);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));

			$sess = unserialize($usess);
			$this->sess = $sess;
		}		
		
		$this->langmodel->init();
		
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu($this->uri->segment(2), $this->uri->segment(3)));
		$this->mysmarty->assign("lreminder", $this->config->item("lreminder"));
	}		
	
	function checkLoggedIn(){
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));			
			$sess = unserialize($usess);
			
			$this->modules = $this->commonmodel->getRight($sess['user_type']);
			if (! isset($this->modules["master"]))
			{
				redirect(base_url());
			}
			
			$this->sess = $sess;
			$this->modules = $this->commonmodel->getRight($sess['user_type']);					
		}
		else
		if (! isset($_SERVER['SESSIONNAME']))
		{
			redirect(base_url());
		}	
		
	}
	function GetReminderType()
	{
		return "reminder";
	}
	
	function GetLogType()
	{
		return "reminderschedule";
	}	
	
	function GetImportTitle()
	{
		return $this->config->item("limport_reminder");
	}
	
	function GetImportMessageSuccess()
	{
		return $this->config->item("limport_reminder_successfully");
	}
	
	function GetConfirmImportMessage()
	{
		return $this->config->item("l_confirm_import_reminder");
	}
	
	function GetListTitle()
	{
		return $this->config->item("lreminder_shedule_setting");
	}
	
	function GetHistoryTitle()
	{
		return $this->config->item('lreminder_shedule_history');
	}
	
	function GetReminderInfoTitle()
	{
		return $this->config->item("lreminder_info");
	}
	
	function GetReminderSuccessInfo()
	{
		 return $this->config->item('lupdate_reminder_successfully');
	}
	
	function index()
	{
		$this->checkLoggedIn();
		
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$this->mysmarty->assign("type", $this->GetReminderType());
		$this->mysmarty->assign("lreminder_shedule_setting", $this->GetListTitle());
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lemail", $this->config->item("email"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));		
		$this->mysmarty->assign("lcourse", $this->config->item("lcourse"));	
		$this->mysmarty->assign("ltraining", $this->config->item("ltraining"));
		$this->mysmarty->assign("lcertificate", $this->config->item("lcertificate"));
		$this->mysmarty->assign("lclassroom", $this->config->item("lclassroom"));
		$this->mysmarty->assign("ltype", $this->config->item("ltype"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));			
		$this->mysmarty->assign("lcourse_type", $this->config->item("lcourse_type"));			
		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "reminder/search.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search()
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$courseid = isset($_POST["courseid"]) ? $_POST["courseid"] : "";
		$limit = (isset($_POST['limit']) && $_POST['limit'])  ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "";
		
		switch($searchby)
		{
			case "user_npk":
				$this->db->where("user_npk LIKE", '%'.$keyword.'%');
			break;
			case "user_email":
				$this->db->where("user_email LIKE '%".$keyword."%' OR reminderuser_email LIKE '%".$keyword."%'");
			break;			
		}
		
		$this->db->where("reminder_type", $this->GetReminderType());		
		$this->db->where("reminder_training_id", $courseid);					
		$this->db->where_in("reminder_status", array(1, 2));
		$this->db->join("reminderext", "reminderuser_reminder = reminder_id");
		$this->db->join("user", "reminderuser_user = user_id");
		$this->db->from("reminderuser");
		
		$sql = $this->db->_compile_select();
		
		if ($sortby && $orderby)
		{
			$this->db->order_by($sortby, $orderby);
		}
		
		$this->db->limit($limit, $offset);
		
		$q = $this->db->get();						
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (valid_email($rows[$i]->reminderuser_email))
			{
				$rows[$i]->email = $rows[$i]->reminderuser_email;
			}
			else
			{
				$rows[$i]->email = $rows[$i]->user_email;
			}
			
			$rows[$i]->status = ($rows[$i]->reminderuser_status == 1) ? $this->config->item("active") : $this->config->item("inactive");
		}
		
		$sql = str_replace("SELECT *", "SELECT COUNT(*) total", $sql);
		$q = $this->db->query($sql);
		$row = $q->row();
		
		$total = $row->total;

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
		$this->pagination1->lang_title = $this->config->item('lparticipant');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;		
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("paging", $this->pagination1->create_links());
		$this->mysmarty->assign("rows", $rows);	
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lemail", $this->config->item("email"));

		$html = $this->mysmarty->fetch("reminder/list.html");		
		
		echo json_encode(array("result"=>$html));
	}
	
	function import()
	{		
		$this->checkLoggedIn();
		
		foreach($this->config->item("prefix_deadline") as $prefix)
		{
			$prefixes[$prefix] = $this->config->item($prefix);
		}
		
		for($i=date("Y"); $i <= date("Y")+2; $i++)
		{
			$years[] = $i;
		}
		
		$this->mysmarty->assign("years", $years);
		$this->mysmarty->assign("prefixes", $prefixes);
		$this->mysmarty->assign("months", $this->config->item("months"));
		
		$this->mysmarty->assign("limport", $this->config->item("limport"));
		$this->mysmarty->assign("limport_reminder", $this->GetImportTitle());
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->assign("lcourse_type", $this->config->item("lcourse_type"));
		$this->mysmarty->assign("ltraining", $this->config->item("ltraining"));		
		$this->mysmarty->assign("lcertificate", $this->config->item("lcertificate"));
		$this->mysmarty->assign("lclassroom", $this->config->item("lclassroom"));		
		$this->mysmarty->assign("lreminder_schedule", $this->config->item("lreminder_schedule"));
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));	
		$this->mysmarty->assign("lnever", $this->config->item("lnever"));
		$this->mysmarty->assign("lonce", $this->config->item("lonce"));
		$this->mysmarty->assign("lndays", $this->config->item("lndays"));	
		$this->mysmarty->assign("ldeadline", $this->config->item("ldeadline"));	
		$this->mysmarty->assign("l_confirm_import_reminder", $this->GetConfirmImportMessage());
		$this->mysmarty->assign("type", $this->GetReminderType());		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "reminder/import.html");
		$this->mysmarty->display("sess_template.html");						
	}
	
	function getcourselist($filter=0)
	{
		$coursetype = isset($_POST["coursetype"]) ? $_POST["coursetype"] : "training";
		
		switch($coursetype)
		{
			case "training":
				$coursetitle = $this->config->item("training_name");
				$type = 1;
			break;
			case "certificate":
				$coursetitle = $this->config->item("certificate_name");
				$type = 2;
			break;
			case "classroom":
				$coursetitle = $this->config->item("lclassroom_name");
				$type = 3;
			break;					
		}
		
		if ($filter)
		{
			$trainingids[] = 0;
						
			$this->db->select("reminder_training_id, COUNT(*) total");
			$this->db->group_by("reminder_training_id");			
			$this->db->where_in("reminder_status", array(1, 2));
			$this->db->where("training_type", $type);
			$this->db->where("reminder_type", $this->GetReminderType());
			$this->db->join("training", "reminder_training_id = training_id");
			$q = $this->db->get("reminderext");
			//echo "halo : ".$this->db->last_query();
			$rowtotals = $q->result();

			for($i=0; $i < count($rowtotals); $i++)
			{
				if (! $rowtotals[$i]->total) continue;
				
				$trainingids[] = $rowtotals[$i]->reminder_training_id;
			}
		}
		
		
		if (isset($trainingids))
		{
			$this->db->where_in("training_id", $trainingids);
		}
		
		$this->db->order_by("training_name", "asc");
		$this->db->where("training_status", 1);
		$this->db->where("training_type", $type);
		$q = $this->db->get("training");
		$rows = $q->result();
		
		$this->mysmarty->assign("courses", $rows);		
		
		$callback['coursetitle'] = $coursetitle;
		$callback['courselist'] = $this->mysmarty->fetch("reminder/options.html");
		
		echo json_encode($callback);
	}
	
	function doimport()
	{
		
		$courseid = isset($_POST['courseid']) ? $_POST['courseid'] : "";
		$schedule = isset($_POST['schedule']) ? trim($_POST['schedule']) : "";
		$condition = isset($_POST['condition']) ? trim($_POST['condition']) : "";		
		$ncondition = isset($_POST['ncondition']) ? trim($_POST['ncondition']) : "";
		
		if (! $courseid)
		{
			echo "<script>parent.setErrorMessage('".$this->config->item('lselect_corse')."');</script>";
			return;
		}
		
		if (! $schedule)
		{
			echo "<script>parent.setErrorMessage('".$this->config->item('lempty_reminder_schedule_long')."');</script>";
			return;
		}
		
		if (! is_numeric($schedule))
		{
			echo "<script>parent.setErrorMessage('".$this->config->item('linvalid_reminder_schedule_long')."');</script>";
			return;
		}
		
		if ($condition == 1)
		{
			if (! $ncondition)
			{
				echo "<script>parent.setErrorMessage('".$this->config->item('lempty_reminder_schedule_condition')."');</script>";
				return;
			}

			if (! is_numeric($ncondition))
			{
				echo "<script>parent.setErrorMessage('".$this->config->item('linvalid_reminder_schedule_condition')."');</script>";
				return;
			}
			
			$condition = $ncondition;
		}
		
		/*
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv|xls';			
		
		$this->load->library('upload', $config);	
		
		if ( ! $this->upload->do_upload())
		{
			$err = $this->upload->display_errors();
			$err = str_replace("'", " ", $err);
			
			echo "<script>parent.setErrorMessage('".$err."');</script>";
			return;
		}
		
		$upload = $this->upload->data();
		
		$this->load->library("xlsreader");
		$this->xlsreader->read($upload['full_path']);	
		//echo $upload['full_path'];
		$worksheet = $this->xlsreader->sheets[0];
		$cells = $worksheet['cells'];
		
		if (! count($cells))
		{
			echo "<script>parent.setErrorMessage('".$this->config->item('lempty_file')."');</script>";
			return;
		}
		
		$q = $this->db->get("user");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$users[$rows[$i]->user_npk] = $rows[$i]->user_id;
		}				

		//print_r($cells); exit();
		for($i=2; $i <= count($cells); $i++)
		{
			$npk = $cells[$i][2];
			
			if (! isset($users[$npk]))
			{
				//$err = sprintf($this->config->item('lempty_npk').": %s", $npk);
				$err = $this->config->item('lempty_npk').": [".$cells[$i][1]."] ".$npk;
				echo "<script>parent.setErrorMessage('".$err."');</script>";
				return;
			}
		}
		*/

		$this->db->select("user_id, user_email");
		$this->db->where("training_npk_training", $courseid);
		$this->db->join("user", "training_npk_npk = user_id");
		$q = $this->db->get("training_npk");
		$data_user = $q->result();

		if(empty($data_user)) {
			echo "<script>parent.setErrorMessage('User participant empty!');</script>";
			return;
		}

		//------- get reminder id before update status--------
		$this->db->where("reminder_status !=", 0);
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->where("reminder_training_id", $courseid);
		$q = $this->db->get("reminderext");
		$tmp = $q->row_array();
		$reminderext_id = !empty($tmp['reminder_id']) ? $tmp['reminder_id'] : 0;
				
		unset($update);
		
		$update["reminder_status"] = 0;		
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->where("reminder_training_id", $courseid);
		$this->db->update("reminderext", $update);
		
		unset($insert);
		
		$insert['reminder_training_id'] = $courseid;
		$insert['reminder_schedule'] = $schedule;
		$insert['reminder_condition'] = $condition;
		$insert['reminder_status'] = 1;
		$insert['reminder_created'] = date("Y-m-d H:i:s");
		$insert['reminder_creator'] = $this->sess['user_id'];
		$insert['reminder_type'] = $this->GetReminderType();
		
		if($insert['reminder_type'] == "reminder") {
			$insert['reminder_deadline_date'] = ($_POST['deadlineprefix'])?$_POST['deadlineprefix']:"";
			$insert['reminder_deadline_month'] = $_POST['deadlinemonth'];
			$insert['reminder_deadline_year'] = $_POST['deadlineyear'];
		}

		$this->db->insert("reminderext", $insert);
		$lastid = $this->db->insert_id();
		
		$this->db->where("general_setting_code", "reminderschedulefor".$courseid);
		$this->db->delete("general_setting");

		$this->db->where("general_setting_code", "reminderschedule_counter_for".$courseid);
		$this->db->delete("general_setting");

		$this->db->flush_cache();
		
		// hapus last run time karena schedule akan dijalankan begitu setelah upload
		
		//$this->db->where("general_setting_code", "reminderschedulefor".$courseid);
		//$q = $this->db->get("general_setting");
		
		//if ($q->num_rows() == 0)
		//{
			//unset($insert);	
			
			//$insert['general_setting_code'] = "reminderschedulefor".$courseid;
			//$insert['general_setting_value'] = mktime();
			
			//$this->db->insert("general_setting", $insert);
		//}
			
		/*	
		for($i=2; $i <= count($cells); $i++)
		{
			$npk = $cells[$i][2];
			$mail = $cells[$i][3];
			
			unset($insert);	
			
			$insert['reminderuser_user'] = $users[$npk];
			$insert['reminderuser_email'] = $mail;
			$insert['reminderuser_status'] = 1;
			$insert['reminderuser_reminder'] = $lastid;
			
			$this->db->insert("reminderuser", $insert);
		}
		*/

		$this->db->where("reminderuser_reminder", $reminderext_id);
		$total = $this->db->count_all_results("reminderuser");

		if(!empty($total)) {
			unset($update);
		
			$update["reminderuser_reminder"] = $lastid;		
			$this->db->where("reminderuser_reminder", $reminderext_id);
			$this->db->update("reminderuser", $update);
		} else {
			foreach ($data_user as $value) {
				unset($insert);	
			
				$insert['reminderuser_user'] = $value->user_id;
				$insert['reminderuser_email'] = $value->user_email;
				$insert['reminderuser_status'] = 1;
				$insert['reminderuser_reminder'] = $lastid;
				
				$this->db->insert("reminderuser", $insert);
			}
		}
		
		echo "<script>parent.setSuccess('".$this->GetImportMessageSuccess()."', '".site_url(array($this->GetReminderType(), "import", uniqid()))."');</script>";
	}
	
	function remove()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		
		$update['reminderuser_status'] = 2;
		
		$this->db->where("reminderuser_id", $id);
		$this->db->update("reminderuser", $update);
	}
	
	function restore()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		
		$update['reminderuser_status'] = 1;
		
		$this->db->where("reminderuser_id", $id);
		$this->db->update("reminderuser", $update);
	}	
	
	function info()
	{
		$courseid = isset($_POST["courseid"]) ? $_POST["courseid"] : "";
		
		$this->db->where("reminder_training_id", $courseid);
		$this->db->where_in("reminder_status", array(1, 2));
		$this->db->where_in("reminder_type", "reminder");
		$q = $this->db->get("reminderext");
		
		if ($q->num_rows() == 0)
		{
			echo json_encode(array("info"=>""));
			return;
		}
		
		$row = $q->row();		

		$this->mysmarty->assign("confirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("lreminder_info", $this->GetReminderInfoTitle());
		$this->mysmarty->assign("lnever", $this->config->item("lnever"));
		$this->mysmarty->assign("lonce", $this->config->item("lonce"));
		$this->mysmarty->assign("lndays", $this->config->item("lndays"));
		$this->mysmarty->assign("lreminder_schedule", $this->config->item("lreminder_schedule"));
		$this->mysmarty->assign("ldays", $this->config->item("ldays"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lactive", $this->config->item("active"));
		$this->mysmarty->assign("linactive", $this->config->item("inactive"));
		$this->mysmarty->assign("type", $this->GetReminderType());
		
		$this->mysmarty->assign("row", $row);
		$html = $this->mysmarty->fetch("reminder/info.html");
		
		echo json_encode(array("info"=>$html));
	}
	
	function removeinfo()
	{
		$id = isset($_POST["id"]) ? $_POST["id"] : "";
		
		unset($update);
		
		$update['reminder_status'] = 3;

		$this->db->where("reminder_id", $id);
		$this->db->update("reminderext", $update);
		
		$callback['message'] = $this->config->item('lremove_reminder_successfully');
		echo json_encode($callback);				
		return;		
		
	}
	
	function updateinfo()
	{
		$id = isset($_POST["id"]) ? $_POST["id"] : "";
		$schedule = isset($_POST['schedule']) ? trim($_POST['schedule']) : "";
		$condition = isset($_POST['condition']) ? trim($_POST['condition']) : "";		
		$ncondition = isset($_POST['ncondition']) ? trim($_POST['ncondition']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		if (! $schedule)
		{
			$callback['message'] = $this->config->item('lempty_reminder_schedule_long');
			echo json_encode($callback);
			return;
		}
		
		if (! is_numeric($schedule))
		{
			$callback['message'] = $this->config->item('linvalid_reminder_schedule_long');
			echo json_encode($callback);
			return;			
		}

		if ($condition == 1)
		{
			if (! $ncondition)
			{
				$callback['message'] = $this->config->item('lempty_reminder_schedule_condition');
				echo json_encode($callback);
				return;
			}

			if (! is_numeric($ncondition))
			{
				$callback['message'] = $this->config->item('linvalid_reminder_schedule_condition');
				echo json_encode($callback);				
				return;
			}
			
			$condition = $ncondition;
		}
		
		unset($update);
		
		$update['reminder_schedule'] = $schedule;
		$update['reminder_condition'] = $condition;
		$update['reminder_status'] = $status;

		$this->db->where("reminder_id", $id);
		$this->db->update("reminderext", $update);
		
		$callback['message'] = $this->GetReminderSuccessInfo();
		echo json_encode($callback);				
		return;		
	}
	
	function schedule()
	{
		global $data_x;

		$this->config->load('config.en');
		$lmonths_en = $this->config->item("months");
		$this->lmonths_en = $lmonths_en;
		$this->lang_en['lend_of'] = $this->config->item("lend_of");
			
		$this->config->load('config.id');
		$lmonths_id = $this->config->item("months");
		$this->lmonths_id= $lmonths_id;
		$this->lang_id['lend_of'] = $this->config->item("lend_of");
		
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();
		
		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$this->settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		}
		
		$this->logmodel->append("run reminder schedule");
		
		/* Get active reminder with training status active also */
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->where("reminder_status", 1);
		$this->db->join("training", "training_id = reminder_training_id AND training_status = '1' ");
		
		$q = $this->db->get("reminderext");
		//echo "halo : ".$this->db->last_query();
		$this->db->flush_cache();
		
		$rows = $q->result();

		//print_r($rows); //exit();
		for($i=0; $i < count($rows); $i++)
		{
			$this->logmodel->append("processing [".$rows[$i]->training_code."] ".$rows[$i]->training_name);
			
			// cek apakah waktunya reminder
			if (! $this->isschedule($rows[$i]))
			{
				//echo "#string 1";
				continue;
			}
						
			// send mail 			
			$key = "reminderschedule_counter_for".$rows[$i]->training_id;
			$this->db->where("general_setting_code", $key);
			$q = $this->db->get("general_setting");
			$res = $q->row_array();

			$counter_now = !empty($res['general_setting_value']) ? $res['general_setting_value'] : 0;

			//echo $counter_now; exit();

			$this->reminderusers($rows[$i], $counter_now);
			//print_r($rows);		
			
			//
			
			$key = "reminderschedulefor".$rows[$i]->training_id;
			$this->db->where("general_setting_code", $key);
			$total = $this->db->count_all_results("general_setting");
			
			if (! $total)
			{
				unset($insert);	
				
				$insert['general_setting_code'] = "reminderschedulefor".$rows[$i]->training_id;
				$insert['general_setting_value'] = mktime();

				$this->db->insert("general_setting", $insert);				

				//echo "#string 2";
			}
			else
			{
				unset($update);
				
				$update['general_setting_value'] = mktime();
				$this->db->where("general_setting_code", "reminderschedulefor".$rows[$i]->training_id);

				$this->db->update("general_setting", $update);

				//echo "#string 3";
			}

			$key = "reminderschedule_counter_for".$rows[$i]->training_id;
			$this->db->where("general_setting_code", $key);
			$total = $this->db->count_all_results("general_setting");

			if (! $total)
			{
				unset($insert);

				//----counter reminder bertingkat-------
				$insert['general_setting_code'] = "reminderschedule_counter_for".$rows[$i]->training_id;
				$insert['general_setting_value'] = 1;
				
				$this->db->insert("general_setting", $insert);				

				//echo "#string 2";
			}
			else
			{
				unset($update);

				//----counter reminder bertingkat-------
				$this->db->set('general_setting_value', 'general_setting_value+1', FALSE);
				$this->db->where("general_setting_code", "reminderschedule_counter_for".$rows[$i]->training_id);

				$this->db->update("general_setting");

				//echo "#string 3";
			}

			//$reminder_id = $rows[$i]->reminder_id;
			//print_r($data_x[$reminder_id]);
			//exit();
		}		
	}
	
	function reminderusers($reminder, $counter_now = 0)
	{				
		global $data_x;

		$this->db->where("reminderuser_status", 1);
		$this->db->where("reminderuser_reminder", $reminder->reminder_id);
		$this->db->join("user", "reminderuser_user = user_id");
		
		$q = $this->db->get("reminderuser");		
		$rows = $q->result();
		
		$users = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$users[] = $rows[$i]->user_id;
		}		

		if(!empty($counter_now)) $cc_user_email = $this->cc_user_email($reminder->reminder_id, $rows, $counter_now);
		
		$history = $this->history($reminder, $users);
		
		for($i=0; $i < count($rows); $i++)
		{
			if ($history[$rows[$i]->user_id]) 
			{
				$this->logmodel->append("(".$rows[$i]->user_npk.") ".$rows[$i]->user_first_name." ".$rows[$i]->user_last_name." has taken, so don't remind");
				continue;
			}
			
			if (valid_email($rows[$i]->reminderuser_email))
			{
				$rows[$i]->email = $rows[$i]->reminderuser_email;				
			}
			else
			{
				$rows[$i]->email = $rows[$i]->user_email;
			}		
			echo $rows[$i]->user_npk.";".$rows[$i]->user_first_name." ".$rows[$i]->user_last_name.";".$rows[$i]->email.";\r\n";
			
			//------ disable email dulu sementara-------
			$this->sendmail($rows[$i], $reminder);	
		}
	}

	private function cc_user_email($reminder_id, $rows, $limit = 3, $prt = '') {
		global $data_x;

		if(empty($limit) OR empty($reminder_id)) return false;

		foreach ($rows as $value) {
			if(!empty($value->user_npk_atasan)) {
				$this->db->where("user_npk", $value->user_npk_atasan );
				$q = $this->db->get("user");

				$res = $q->result();

				$value->user_id = !empty($prt) ? $prt : $value->user_id;

				if(!empty($res[0]->user_email)) $data_x[$reminder_id][$value->user_id][] = $res[0]->user_email;

				//cek looping atasan
				$npk_atasan = $res[0]->user_npk_atasan;
				if(!empty($npk_atasan)) $this->cc_user_email($reminder_id, $res, ($limit-1), $value->user_id);
			}
		}

		return true;
	}
	
	function history($reminder, $users)
	{
		// true, jika dia pernah ngambil jadi jgn direminder
		
		if ($reminder->reminder_condition == 0) 
		{			
			$result = array();
			for($i=0; $i < count($users); $i++)
			{
				$result[$users[$i]] = false;
			}
			
			return $result;
		}
		
		$this->db->select("history_exam_user, history_exam_date");
		$this->db->order_by("history_exam_date", "desc");
		$this->db->where("history_exam_training", $reminder->reminder_training_id);
		//$this->db->where("history_exam_status", 1);
		$this->db->where_in("history_exam_user", $users);
		$this->db->from("history_exam");
		$q = $this->db->get();
		
		if ($q->num_rows() == 0) 
		{
			$result = array();
			for($i=0; $i < count($users); $i++)
			{
				$result[$users[$i]] = false;
			}
			
			return $result;
		}
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (isset($history[$rows[$i]->history_exam_user])) continue;
			$history[$rows[$i]->history_exam_user] = dbintmaketime($rows[$i]->history_exam_date, 0);
		}
		
		if ($reminder->reminder_condition == -1) 
		{
			$result = array();
			for($i=0; $i < count($users); $i++)
			{
				$result[$users[$i]] = isset($history[$users[$i]]);
			}
			
			return $result;
		}				

		$result = array();
		$dayinseconds = 3600*24*$reminder->reminder_condition;
		$key = "reminderschedulefor".$reminder->training_id;		
			
		if (! isset($this->settings[$key]))
		{
			$result = array();
			for($i=0; $i < count($users); $i++)
			{
				$result[$users[$i]] = false;
			}
			
			return $result;
		}
			
		$delta = mktime() - $this->settings[$key];
		
		$this->logmodel->append("last schedule: ".date("d/m/Y", $this->settings[$key])." ndays: ".$reminder->reminder_condition);		
		
		for($i=0; $i < count($users); $i++)
		{
			if (! isset($history[$users[$i]]))
			{
				$result[$users[$i]] = false;
				continue;
			}			
																						
			$result[$users[$i]] = $delta <= $dayinseconds;
		}						
		
		return $result;
		
	}
	
	function isschedule($reminder)
	{
		$key = "reminderschedulefor".$reminder->training_id;
		if (! isset($this->settings[$key]))
		{						
			return true;		
		}
		
		$delta = round((mktime() - $this->settings[$key])/(3600*24));		
		
		$isschedule = (($delta%$reminder->reminder_schedule) == 0);
		if (! $isschedule)
		{
			$this->logmodel->append("not schedule time delta:".$delta." schedule: ".$reminder->reminder_schedule);
			return false;		
		}
		
		return true;
	}
	
	function sendmail($user, $reminder)
	{
		global $data_x;

		$lmonths_en = $this->lmonths_en;
		$lmonths_id = $this->lmonths_id;
		$lang_id = $this->lang_id;
		$lang_en = $this->lang_en;
						
		if (! valid_email($user->email))
		{
			$this->logmodel->append("invalid email format ".$user->user_npk." ".$user->email);
			return true;
		}
		//$lmonths = $this->config->item('lmonths');
		//$this->mysmarty->assign("month_name_en", $lmonths[date("n")-1]);

		if (isset($reminder->training_data) && $reminder->training_data)
		{
			$exdata = json_decode($reminder->training_data);
			
			$lastdate = $exdata->lastdate;
			$lastdateenglish("%d%s", $lastdate, postfixdate($lastdate));
			
			$this->mysmarty->assign("lastdate", $lastdate);
			$this->mysmarty->assign("lastdateenglish", $lastdateenglish);
		}
		
		$this->mysmarty->assign("month_name_en", $lmonths_en[$reminder->reminder_deadline_month]);	
		$this->mysmarty->assign("lastdateenglish", $lang_en[$reminder->reminder_deadline_date]);
		
		$this->mysmarty->assign("month_name_id", $lmonths_id[$reminder->reminder_deadline_month]);		
		$this->mysmarty->assign("lastdateindonesia", $lang_id[$reminder->reminder_deadline_date]);
		
		$this->config->load('config.'.($this->lang ? $this->lang : $this->langmodel->getDefaultLang()));
		
		$this->mysmarty->assign("year", $reminder->reminder_deadline_year);
		$this->mysmarty->assign("user", $user);
		$this->mysmarty->assign("reminder", $reminder);
		$message = $this->mysmarty->fetch("reminder/message.html");
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();

		$rowsettings = $q->result();
		for($j=0; $j < count($rowsettings); $j++)
		{
			$settings[$rowsettings[$j]->general_setting_code] = $rowsettings[$j]->general_setting_value;
		}
				
		$this->load->library('email');
		
		if (isset($this->settings['mailtype']) && ($this->settings['mailtype'] == "smtp"))
		{
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $this->settings['smtphost'];
			$config['smtp_user'] = isset($this->settings['smtpuser']) ? $this->settings['smtpuser'] : "";
			$config['smtp_pass'] = 	isset($this->settings['smtppass']) ? $this->settings['smtppass'] : "";		
		}
		else
		{
			$config['protocol'] = 'mail';
		}	
		
		$config['mailtype'] = (isset($this->settings['mailcontenttype']) && $this->settings['mailcontenttype']) ? $this->settings['mailcontenttype'] : "html";
		
		$mailsender = isset($this->settings['remindermailsender']) ? $this->settings['remindermailsender'] : $this->config->item("admin_mail");
		$sendername = isset($this->settings['remindermailsendername']) ? $this->settings['remindermailsendername'] : "";
		
		$subject = isset($this->settings['remindermailsubject']) ? $this->settings['remindermailsubject'] : "[lmsv2] reminder";
		
		$this->email->initialize($config);
		$this->email->from($mailsender, $sendername);
		$this->email->to($user->email); 

		if(!empty($data_x[$reminder->reminder_id][$user->user_id])) {
			$tmp_cc = join(',', $data_x[$reminder->reminder_id][$user->user_id]);
			if(!empty($tmp_cc)) {
				$this->email->cc($tmp_cc);
				echo "#cc-" . $tmp_cc;
			}
		}
		echo "#to-" . $user->email;

		$this->email->subject($subject);
		$this->email->message($message);
		
		unset($insert);
					
		$desc["subject"] = $subject;
		$desc["message"] = $message;
		$desc["to"] = $user->email;
		$desc["npk"] = $user->user_npk;
		
		$insert['log_type'] = "reminderschedule";
		$insert['log_user'] = $user->user_id;		
		$insert['log_created'] = date("Y-m-d H:i:s");
		$insert['log_desc'] = json_encode($desc);
		$insert['log_param1'] = $reminder->reminder_id;

		//echo "#" . $user->email . "-" . $user->user_id;
		
		if ($this->email->send())
		{
			$insert['log_status'] = 1;
			
			$this->logmodel->append("mail sent ".$user->user_npk." ".$user->email);						
			$this->db->insert("log", $insert);

			if(!empty($data_x[$reminder->reminder_id][$user->user_id])) {
				foreach ($data_x[$reminder->reminder_id][$user->user_id] as $value) {
					$this->logmodel->append("mail sent cc ".$value);
					$this->db->insert("log", $insert);
				}
			}
		}
		else
		{
			$insert['log_status'] = 2;
			
			$this->logmodel->append("mail failed ".$user->user_npk." ".$user->email);
			$this->db->insert("log", $insert);

			if(!empty($data_x[$reminder->reminder_id][$user->user_id])) {
				foreach ($data_x[$reminder->reminder_id][$user->user_id] as $value) {
					$this->logmodel->append("mail failed cc ".$value);
					$this->db->insert("log", $insert);
				}
			}
		}
		
		$this->email->clear(TRUE);		
	}	
	
	
	function phistory()
	{	
		$this->checkLoggedIn();
		$this->mysmarty->assign("ltraining", $this->config->item('ltraining'));
		$this->mysmarty->assign("lcertificate", $this->config->item('lcertificate'));
		$this->mysmarty->assign("lclassroom", $this->config->item('lclassroom'));
		$this->mysmarty->assign("lsearch", $this->config->item('lsearch'));		
		
		$this->mysmarty->assign("lcourse_type", $this->config->item('lcourse_type'));
		$this->mysmarty->assign("lreminder_shedule_history", $this->GetHistoryTitle());
		$this->mysmarty->assign("remindertype", $this->GetReminderType());
		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "reminder/searchhistory.html");
		$this->mysmarty->display("sess_template.html");		
		
	}

	function qsearchhist($trainingid)
	{
		$this->db->select("DATE_FORMAT(log_created, '%d/%m/%Y') log_created_fmt",false);
		$this->db->where("reminder_training_id", $trainingid);
		$this->db->where("log_type", $this->GetLogType());
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->order_by("log_created", "desc");
		$this->db->group_by("DATE_FORMAT(log_created, '%d/%m/%Y')");
		$this->db->join("reminderext", "reminder_id = log_param1", "left outer");
		$this->db->from("log");
		$q = $this->db->get();

		return $q;
	}

	function qsearchhistsent($t1, $t2, $courseid, $status)
	{
		$this->db->select("DATE_FORMAT(log_created, '%d/%m/%Y') log_created_fmt",false);
		$this->db->select("COUNT(*) total ");		
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->where("log_created <=", $t1);
		$this->db->where("log_created >=", $t2);
		$this->db->where("reminder_training_id", $courseid);
		$this->db->where("log_type", $this->GetLogType());
		$this->db->where("log_status", $status);		
		$this->db->order_by("log_created", "desc");
		$this->db->group_by("DATE_FORMAT(log_created, '%d/%m/%Y')");
		$this->db->join("reminderext", "reminder_id = log_param1");
		$this->db->from("log");
		$q = $this->db->get();
		
		return $q;
	}
	
	function qhistdetail($t, $status, $courseid)
	{
		$this->db->select("DATE_FORMAT(log_created, '%d/%m/%Y %H:%i:%s') log_created_fmt",false);
		$this->db->select("user.*");
		$this->db->select("log.*");
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->where("DATEDIFF(log_created, '".date("Y-m-d H:i:s", $t)."') = 0", null);
		$this->db->where("reminder_training_id", $courseid);
		$this->db->where("log_type", $this->GetLogType());
		$this->db->where("log_status", $status);		
		$this->db->join("reminderext", "reminder_id = log_param1");
		$this->db->join("user", "log_user = user_id");
		$this->db->from("log");
		$q = $this->db->get();
		
		return $q;		
	}
	
	
	function searchhistory()
	{
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$courseid = isset($_POST["courseid"]) ? $_POST["courseid"] : "";
		$limit = (isset($_POST['limit']) && $_POST['limit'])  ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		
		$q = $this->qsearchhist($courseid);
		
		$total = $q->num_rows();
		$rows = $q->result();			

		$rows = array_slice($rows, $offset, $limit);

		if ($total > 0)
		{	
			$t1 = date("Y-m-d H:i:s", formmaketime($rows[0]->log_created_fmt." 23:23:59"));
			$t2 = date("Y-m-d H:i:s", formmaketime($rows[count($rows)-1]->log_created_fmt." 00:00:00"));	

			$q = $this->qsearchhistsent($t1, $t2, $courseid, 1);
			$rowsent = $q->result();
			
			for($i=0; $i < count($rowsent); $i++)
			{
				$sent[$rowsent[$i]->log_created_fmt] = $rowsent[$i]->total;
			}	

			$q = $this->qsearchhistsent($t1, $t2, $courseid, 2);
			$rowfailed = $q->result();
                        for($i=0; $i < count($rowfailed); $i++)
                        {
                                $failed[$rowfailed[$i]->log_created_fmt] = $rowfailed[$i]->total;
                        }
			
			for($i=0; $i < count($rows); $i++)
			{
				$rows[$i]->sent = isset($sent[$rows[$i]->log_created_fmt]) ? $sent[$rows[$i]->log_created_fmt] : 0;
				$rows[$i]->failed = isset($failed[$rows[$i]->log_created_fmt]) ? $failed[$rows[$i]->log_created_fmt] : 0;
			}	
		}

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
		$this->pagination1->lang_title = $this->config->item('lhistory');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;		
		
		$this->mysmarty->assign("lperiod", $this->config->item('period'));
		$this->mysmarty->assign("lmail_sent", $this->config->item('lmail_sent'));
		$this->mysmarty->assign("lmail_failed", $this->config->item('lmail_failed'));
		
		$this->mysmarty->assign("trainingid", $courseid);
		$this->mysmarty->assign("remindertype", $this->GetReminderType());
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("paging", $this->pagination1->create_links());
		$this->mysmarty->assign("rows", $rows);	

		$html = $this->mysmarty->fetch("reminder/listhistory.html");		
		
		echo json_encode(array("result"=>$html));
	}
	
	function histdetail()
	{
		$date = isset($_POST['date']) ? $_POST['date'] : "";
		$status = isset($_POST['status']) ? $_POST['status'] : 1;
		$training = isset($_POST['training']) ? $_POST['training'] : 1;
		
		if (! $date)
		{
			$callback['error'] = true;
			$callback['message'] = "Access denied";
			
			echo json_encode($callback);
			return;
		}
		
		$t = formmaketime($date." 00:00:00");
		
		$q  = $this->qhistdetail($t, $status, $training);
		$rows = $q->result();
				
		$this->mysmarty->assign("date", $date);
		
		$this->mysmarty->assign("status", $status ? $this->config->item("lmail_sent") : $this->config->item("lmail_failed"));
		
		$this->mysmarty->assign("lperiod", $this->config->item("period"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));		
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		
		$this->mysmarty->assign("rows", $rows);
		$html = $this->mysmarty->fetch("reminder/listhistorydetail.html");
		echo json_encode(array("result"=>$html));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
