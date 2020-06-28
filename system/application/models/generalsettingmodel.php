<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GeneralsettingModel extends Model {
	
	function GeneralsettingModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->helper("common");
	}
	
	function GetInfo($code){
		$this->db->where("general_setting_code", $code);
		$q = $this->db->get("general_setting");
		$rowsetting = $q->row();
		if($rowsetting->general_setting_value)
			return $rowsetting->general_setting_value;
		else
			return 0;
	}
}	
	