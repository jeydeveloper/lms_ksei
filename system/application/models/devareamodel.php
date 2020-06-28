<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class DevareaModel extends Model {
	function DevareaModel () 
	{				
		parent::Model();		
	}	


	
	function save($id, $datas,$user_id){
		$this->db->where("dev_area_catalog_id", $id);
		$this->db->delete("ildp_development_area");
		
		for($i=0; $i < count($datas); $i++)
		{
			$datas[$i] = trim($datas[$i]);
			unset($insert);
			if($datas[$i]) {
				$insert['dev_area_catalog_id']  = $id;
				$insert['dev_area_title']  		= $datas[$i];
				$insert['dev_area_created'] 	= date("Y-m-d H:i:s");
				$insert['dev_area_creator'] 	= $user_id;
				
				$this->db->insert("ildp_development_area", $insert);
			}
		}
	}
	
}
