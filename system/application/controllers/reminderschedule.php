<?php
include_once "base.php"; 

class reminderschedule extends Base {
	var $sess;
	var $lang;
	var $modules;
	var $settings;

	function reminderschedule()
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
		$this->config->load('config.'.($lang ? $lang : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $lang);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		
		$this->langmodel->init();
		
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu($this->uri->segment(2), $this->uri->segment(3)));
		$this->mysmarty->assign("lreminder", $this->config->item("lreminder"));
	}		
	
	function GetReminderType()
	{
		return "reminder";
	}

	
	function schedule()
	{
		global $data_x;

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
		for($i=0; $i < count($rows); $i++)
		{
			$this->logmodel->append("processing [".$rows[$i]->training_code."] ".$rows[$i]->training_name);
			
			// cek apakah waktunya reminder
			if (! $this->isschedule($rows[$i]))
			{
				continue;
			}
						
			// send mail
			$key = "reminderschedule_counter_for".$rows[$i]->training_id;
			$this->db->where("general_setting_code", $key);
			$q = $this->db->get("general_setting");
			$res = $q->row_array();

			$counter_now = !empty($res['general_setting_value']) ? $res['general_setting_value'] : 0;

			$this->reminderusers($rows[$i], $counter_now);		
			
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

				//----counter reminder bertingkat-------
				$insert['general_setting_code'] = "reminderschedule_counter_for".$rows[$i]->training_id;
				$insert['general_setting_value'] = 1;
				
				$this->db->insert("general_setting", $insert);
			}
			else
			{
				unset($update);
				
				$update['general_setting_value'] = mktime();
				
				$this->db->where("general_setting_code", "reminderschedulefor".$rows[$i]->training_id);
				$this->db->update("general_setting", $update);				

				//----counter reminder bertingkat-------
				$this->db->set('general_setting_value', 'general_setting_value+1', FALSE);
				$this->db->where("general_setting_code", "reminderschedule_counter_for".$rows[$i]->training_id);

				$this->db->update("general_setting");
			}
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

				$data_x[$reminder_id][$value->user_id][] = $res[0]->user_email;

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

		if (! valid_email($user->email))
		{
			$this->logmodel->append("invalid email format ".$user->user_npk." ".$user->email);
			return true;
		}
		//$lmonths = $this->config->item('lmonths');
		//$this->mysmarty->assign("month_name_en", $lmonths[date("n")-1]);
		
		$lmonths_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$lmonths_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	
		$this->mysmarty->assign("month_name_en", $lmonths_en[date("n")-1]);
		$this->mysmarty->assign("month_name_id", $lmonths_id[date("n")-1]);
		
	
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
			$this->email->cc($tmp_cc);
			echo "#cc-" . $tmp_cc;
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
