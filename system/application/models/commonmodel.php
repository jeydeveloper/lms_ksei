<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CommonModel extends Model {
	function CommonModel () 
	{				
		parent::Model();		
		
		$this->load->database();
	}	
	
	function getRight($id, &$delegetions=false)
	{
		if ($id > 0)
		{
			$this->db->where("right_id", $id);
		}
		$this->db->join("right_module", "right_module_module = module_id");
		$this->db->join("right", "right_module_right = right_id");
		$q = $this->db->get("module");
		$this->db->flush_cache();
		$rows = $q->result();
		
		$modules = array();
		$modulesadmin = false;
		for($i=0; $i < count($rows); $i++)
		{
			$modules[$rows[$i]->module_name] = 1;
			
			if ($rows[$i]->module_name != "trainee")
			{
				$modulesadmin = true;
			}
		}
		
		// cek apakah dia punya delegasi
		
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);
		if ($sess['user_type'] != 0)
		{
			$this->db->where("delegetion_user", $sess['user_id']);				
			$q = $this->db->get("delegetion");
			$this->db->flush_cache();
			
			$ishavedelegetion = $q->num_rows() > 0;								
			$modulesadmin = $modulesadmin || $ishavedelegetion;

			$this->mysmarty->assign("ishavedelegetion", $ishavedelegetion);
			if ($ishavedelegetion)
			{
				$modules['delegetion'] = 1;
				$rowdelegetion = $q->result();
				for($i=0; $i < count($rowdelegetion); $i++)
				{
					$delegetions[$rowdelegetion[$i]->delegetion_training] = 1;
				}
			   
				$this->mysmarty->assign("delegetions", $delegetions);
			}
		}
		
		$this->mysmarty->assign("sessmodulesadmin", $modulesadmin);		
		$this->mysmarty->assign("sessmodules", $modules);
		$this->mysmarty->assign("website_title", $this->getWebsiteTitle());
		$this->mysmarty->assign("website_logo", $this->getWebsiteLogo());
		
		return $modules;
	}

	function getWebsiteLogo()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "websitelogo");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			
			$filename = sprintf("%s../uploads/logo/%s", BASEPATH, $row->general_setting_value);
			if (is_file($filename))
			{
				return base_url()."uploads/logo/".$row->general_setting_value;				
			}
		}
		
		$filename = sprintf("%s../theme/%s/images/logo-header.gif", BASEPATH, $this->config->item("theme"));
		if (is_file($filename))
		{
			return base_url()."theme/".$this->config->item("theme")."/images/logo-header.gif";
		}
				
		return base_url()."images/web-pole.gif";
	}
	
	function getWebsiteTitle()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "websitetitle");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return $this->config->item("websitetitle");		
		}
		
		$row = $q->row();
		return $row->general_setting_value;
	}
	
	function getRecordPerPage()
	{
		$this->db->where("general_setting_code", "recordperpage");
		
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return $this->config->item("data_per_page");
		}
		
		$row = $q->row();
		if ($row->general_setting_value <= 0)
		{
			return $this->config->item("data_per_page");
		}
		
		return $row->general_setting_value;
	}
	
	function GetSetting()
	{
		$this->db->flush_cache();
		$q = $this->db->get("general_setting");
		$rows = $q->result();
		
		$setting = array();
		for($i=0; $i < count($rows); $i++)
		{
			$setting[$rows[$i]->general_setting_code] = $rows[$i]->general_setting_value;
		}
		
		return $setting;
	}
	
	function updateSetting($code, $value)
	{
		$this->db->where("general_setting_code", $code);
		$total = $this->db->count_all_results("general_setting");
		
		unset($insert);
		
		$insert["general_setting_code"] = $code;
		$insert["general_setting_value"] = $value;
		$insert["general_setting_updatedby"] = _user_id();
		$insert["general_setting_lastupdated"] = date("Y-m-d H:i:s");
		
		if ($total == 0)
		{		
			$this->db->insert("general_setting", $insert);	
			return;
		}
		
		$this->db->where("general_setting_code", $code);
		$this->db->update("general_setting", $insert);
	}
	
	function sendmail($dest, $subject, $message, $ccs=array())
	{
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();
	
		$rowsettings = $q->result();
		for($j=0; $j < count($rowsettings); $j++)
		{
			$settings[$rowsettings[$j]->general_setting_code] = $rowsettings[$j]->general_setting_value;
		}
			
		$this->load->library('email');
			
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype']	= "html";

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

		$this->email->initialize($config);
		$this->email->from($mailsender, $sendername);
		$this->email->to($dest); 
		$this->email->subject($subject);
		$this->email->message($message);	
		
		for ($i=0; $i < count($ccs); $i++)
		{
			$this->email->cc($ccs[$i]);	
		}
		
		$this->email->send();
		
	}
	
}
