<?php

include "reminder.php";

class Refreshment extends Reminder {
	var $sess;
	var $lang;
	var $modules;
	var $settings;

	function GetReminderType()
	{
		return "refreshment";
	}
	
	function GetImportTitle()
	{
		return $this->config->item("limport_refreshment");
	}
	
	function GetImportMessageSuccess()
	{
		return $this->config->item("limport_refreshment_successfully");
	}
	
	function GetConfirmImportMessage()
	{
		return $this->config->item("l_confirm_import_refreshment");
	}	
	
	function GetListTitle()
	{
		return $this->config->item("lrefreshment_shedule_setting");
	}
	
	function GetHistoryTitle()
	{
		return $this->config->item('lrefreshment_shedule_history');
	}
	
	function GetReminderInfoTitle()
	{
		return $this->config->item("lrefreshment_info");
	}
	
	function GetReminderSuccessInfo()
	{
		 return $this->config->item('lupdate_refreshment_successfully');
	}
	
	function GetLogType()
	{
		return "reminder";
	}

	function qsearchhist($trainingid)
	{
		$this->db->select("DATE_FORMAT(log_created, '%d/%m/%Y') log_created_fmt",false);
		$this->db->select("log.*");
		$this->db->where("reminder_training_id", $trainingid);
		$this->db->where("log_type", $this->GetLogType());
		$this->db->where("reminder_type", $this->GetReminderType());
		$this->db->order_by("log_created", "desc");
		$this->db->group_by("DATE_FORMAT(log_created, '%d/%m/%Y')");
		$this->db->join("reminderext", "reminder_training_id = log_param1", "left outer");
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
		$this->db->join("reminderext", "reminder_training_id = log_param1");
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
		$this->db->order_by("log_created", "desc");
		$this->db->join("reminderext", "reminder_training_id = log_param1");
		$this->db->join("user", "log_user = user_id");
		$this->db->from("log");
		$q = $this->db->get();
		
		return $q;				
	}	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
