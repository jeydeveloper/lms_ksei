<?php
class Base extends Controller {

	var $langue;
	var $showildp;
	
	function encrypt(){
		$_POST['do'] = true;
		$_POST['newpass'] = "adminbtn2013";
		$newpass = $_POST['newpass'];
		
		if($_POST['do']){
			$encrypted = substr(md5($newpass), 0, 100);	
		}
		echo $encrypted;
	}
	
	function Base(){
		
		parent::Controller();	
		
		$this->load->database();
		
		header("Cache-Control: no-cache, no-store, must-revalidate");
    	header("Pragma: no-cache"); 
   // $this->encrypt();
		$this->db->where("general_setting_code", "sessiontimeout");
		$this->db->where("general_setting_value >=", 0);
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();
		
		if ($q->num_rows() > 0)
		{
			$sessiontimeout = $q->row();
			
			if ($sessiontimeout->general_setting_value > 0)
			{						
				$this->config->set_item('sess_expiration', $sessiontimeout->general_setting_value);
			}
			else
			{
				$this->config->set_item('sess_expire_on_close', true);
			}
		}
				
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->model('langmodel');
		$this->load->model('generalsettingmodel');
		$this->load->helper("url");
		
		$this->langue = $this->session->userdata('lms_lang');			
		
		$base_path = $this->config->item('base_path');
		$theme = $this->config->item('theme');
		$theme_css = sprintf("%s/theme/%s/css/default.css", $base_path, $theme);
		
		//-- css 
		if ($theme && file_exists($theme_css))
		{
			$theme_url = sprintf("%stheme/%s/css/default.css", base_url(), $this->config->item("theme"));
		}
		else
		{
			$theme_url = sprintf("%scss/default.css", base_url());
		}
				
		//-- config
		$theme_config =  sprintf("%s/theme/%s/config/config.php", $base_path,$theme);
		if ($theme && file_exists($theme_config)){
			$cfile = sprintf("../../../theme/%s/config/config.php", $theme);
			$this->config->load($cfile);
		}
		
		//-- language
		/*$CI =& get_instance();
		$base_path = $CI->config->item('base_path');
		$lang = $CI->langue ? $CI->langue : $CI->langmodel->getDefaultLang();
		$company = $CI->config->item('company');
		$company_language =  sprintf("%s/theme/%s/language/%s", $base_path,$company, $lang);
			
		if ($company && file_exists($company_language))
		{
			$file = sprintf("../../../theme/%s/language/%s.php", $company, $lang);
			if(is_file($file))
				$this->config->load($file, $lang);
		}
		else
		{
			$this->config->load('config.'.($this->langue ? $this->langue : $this->langmodel->getDefaultLang()));
		}*/
		
		$strCompany = $this->config->item('company');
		$this->mysmarty->assign("strCompany", $strCompany);
		$this->mysmarty->assign("theme_url", $theme_url);
		
		//get general setting
		$isChangeLang = $this->generalsettingmodel->GetInfo("changelang");
		$this->showildp = $this->generalsettingmodel->GetInfo("showildp");
		
		$this->mysmarty->assign("show_changelang",$isChangeLang);
		$this->mysmarty->assign("showildp",$this->showildp);
		
		
	}
}
