<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class BankSoalModel extends Model {
	function BankSoalModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}	

	function GetUsed($ids)
	{
		$used = array();
		
		// apakah dipakai user
		
		$this->db->where_in("training_banksoal", $ids);
		$q = $this->db->get("training");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_banksoal] = true;			
			$ids = array_diff($ids, array($rows[$i]->training_banksoal));
		}			

		if (count($ids) == 0) return $used;		
		
		// cek di praexam  exam
		
		$this->db->where_in("training_exam_banksoal", $ids);
		$q = $this->db->get("training_exam");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_exam_banksoal] = true;			
			$ids = array_diff($ids, array($rows[$i]->training_exam_banksoal));
		}		
		
		return $used;
	}		
	
}
