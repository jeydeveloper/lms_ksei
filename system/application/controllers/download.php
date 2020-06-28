<?php

class Download extends Controller {
	var $m_fout;
	var $m_levelgroups;
	var $m_levelparents;
	var $m_trainings;
	var $m_level;
	
	function Download()
	{
		parent::Controller();	

		$this->load->library('session');
		$this->load->helper('url');	
			
		$this->session->set_userdata(array("referrer"=>current_url()));
		$this->load->helper('common');	
		$this->load->helper('url');	
		
	}
	
	function sap($filename){
		/*
		only able to download OD(on demand file)
		*/
		
		$CI =& get_instance();
		
		$file_array = array(
			$this->config->item('sap_od_bankwide')
			,$this->config->item('sap_od_bydir')
			,$this->config->item('sap_od_bygroup')
			,$this->config->item('sap_od_bydept')
			,$this->config->item('sap_od_byunit')
			,$this->config->item('sap_od_coursecode')
		);
		
		
		/* download it if it's in the array */
		if (in_array($filename, $file_array)) {
			//$file_path = BASEPATH."../".$this->config->item("outbox")."/".$filename;
			$file_path = $this->config->item("base_path").$this->config->item("outbox")."/".$filename.'.CSV';
			
			if (file_exists($file_path)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file_path));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file_path));
			    ob_clean();
			    flush();
			    readfile($file_path);
			    exit;
			}				    
		}

	}
}