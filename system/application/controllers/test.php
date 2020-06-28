<?php

class test extends Controller {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function test()
	{
		parent::Controller();	
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->helper('email');
		
		
	}
	
	function encrypt(){
		$newpass = $_POST['newpass'];
		
		if($_POST['do']){
			$encrypted = substr(md5($newpass), 0, 100);	
		}
		
		$this->mysmarty->assign("encrypted", "Encrypted : ".$encrypted);
		$this->mysmarty->display("encrypt.html");
	}
	
	function sendmail(){
		if($_POST['sendmail'] == "send") {
			// send email
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
	
			if (isset($settings['mailtype']) && ($settings['mailtype'] == "smtp"))	
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
			
			$config['mailtype'] = (isset($settings['mailcontenttype']) && $settings['mailcontenttype']) ? $settings['mailcontenttype'] : "html";
			
			$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
			$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";
	
			$subject = "test send mail";
			//$message = "test email ";
			$message = $this->mysmarty->fetch("reminder/message.html");
	
			$this->email->initialize($config);
			$this->email->from($mailsender, $sendername);
			$this->email->to($_POST['recipient']); 
			$this->email->subject($subject);
			$this->email->message($message);	
			$this->email->send();
		}
		$this->mysmarty->display("test_send_mail.html");
	}
	
	function sendmail_cl(){
		
		$email_to = "arahadi@permatabank.co.id";
		
		// send email
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

		$subject = "test send mail";
		$message = "test email ";
		$this->email->initialize($config);
		$this->email->from($mailsender, $sendername);
		$this->email->to($email_to); 
		$this->email->subject($subject);
		$this->email->message($message);	
		if($this->email->send())
			echo "sukses";
		else
			echo "gagal";
	
	}
	
	function sendmailhtml(){
		if($_POST['sendmail'] == "send") {
			// send email
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
	
			if (isset($settings['mailtype']) && ($settings['mailtype'] == "smtp"))	
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
			
			$config['mailtype'] = (isset($settings['mailcontenttype']) && $settings['mailcontenttype']) ? $settings['mailcontenttype'] : "html";
			
			$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
			$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";
	
			$subject = "test send mail";
			$message = $this->mysmarty->fetch("reminder/test_message.html");
		
			$this->email->initialize($config);
			$this->email->from($mailsender, $sendername);
			$this->email->to($_POST['recipient']); 
			$this->email->subject($subject);
			$this->email->message($message);	
			$this->email->send();
		}
		$this->mysmarty->display("test_send_mail.html");
	}
}
?>