<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class FunctionModel extends Model {
	function FunctionModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}	

	function GetUsed($ids)
	{
		$used = array();
		
		// apakah dipakai user
		
		$this->db->where_in("user_function", $ids);
		$q = $this->db->get("user");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->user_function] = true;			
			$ids = array_diff($ids, array($rows[$i]->user_function));
		}	
		
		if (count($ids) == 0) return $used;
				
		// cek apakah dipakai training
		
		$this->db->where_in("training_function_function", $ids);
		$q = $this->db->get("training_function");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_function_function] = true;			
			$ids = array_diff($ids, array($rows[$i]->training_function_function));
		}		
		
		return $used;
	}		
	
}
