<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class UserModel extends Model {
	function UserModel () 
	{				
		parent::Model();		
	}	

	function getTypeDesc($stat)
	{
		switch($stat)
		{
			case 'trainee':
				return $this->config->item("ltrainee");
			default:
				return "Administrator";
		}
	}	
	
	function getEmployementDesc($type)
	{
		switch($type)
		{
			case 2:
				return "Outsource";
			default:
			return "Staff";
		}
	}
	
	function getEmployement($s)
	{
		switch($s)
		{
			case "PERMANENT":
				return 1;
			case "CONTRACT":
				return 2;
			case "BODC":
				return 3;
			case "EXP":
				return 4;
			case "TRAIN":
				return 5;
			default:
				return 1;
		}
	}	
	
	function gettotalempperperiod($p1, $p2)
	{
		$this->db->order_by("import_date", "desc");
		$this->db->order_by("import_time", "desc");
		$this->db->where("import_date >=", $p1);
		$this->db->where("import_date <=", $p2);
		$q = $this->db->get("import", 1, 0);
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0) return 0;
		
		$row = $q->row();			
		return $row->import_nrecords;
	}

	function gettotalexamperperiod($p1, $p2)
	{				
		
		$sql = "SELECT COUNT(*) total 
				FROM	(
					SELECT DISTINCT history_exam_user
					FROM			".$this->db->dbprefix."history_exam
									INNER JOIN ".$this->db->dbprefix."user ON user_id = history_exam_user
					WHERE			1
									AND (history_exam_date >= '".$p1."')
									AND (history_exam_date <= '".$p2."')
						) as t1
				WHERE 1
		";		
		
		$q = $this->db->query($sql);
		$row = $q->row();
		
		return $row->total;
	}	
	
	function gettotalexamperperiod1($p1, $p2)
	{				
		
		$sql = "	SELECT count(*) total
				FROM		".$this->db->dbprefix."history_exam
						INNER JOIN ".$this->db->dbprefix."user ON user_id = history_exam_user
				WHERE		1
						AND (history_exam_date >= '".$p1."')
						AND (history_exam_date <= '".$p2."')
		";		
		
		$q = $this->db->query($sql);
		$row = $q->row();
		
		return $row->total;
	}		
	
	function gettotaldurationperperiod($p1, $p2)
	{
		$sql = "	SELECT 		SUM(training_duration) total
				FROM		".$this->db->dbprefix."history_exam
						INNER JOIN ".$this->db->dbprefix."user ON user_id = history_exam_user
						INNER JOIN ".$this->db->dbprefix."training ON training_id = history_exam_training
				WHERE		1
						AND (history_exam_date >= '".$p1."')
						AND (history_exam_date <= '".$p2."')
		";		
		
		$q = $this->db->query($sql);
		$row = $q->row();
		
		return $row->total;		
	}

	function gettotalcostperperiod($p1, $p2)
	{
		$sql = "	SELECT 		SUM(training_cost) total
				FROM		".$this->db->dbprefix."history_exam
						INNER JOIN ".$this->db->dbprefix."user ON user_id = history_exam_user
						INNER JOIN ".$this->db->dbprefix."training ON training_id = history_exam_training
				WHERE		1
						AND (history_exam_date >= '".$p1."')
						AND (history_exam_date <= '".$p2."')
		";		
		
		$q = $this->db->query($sql);
		$row = $q->row();
		
		return $row->total;		
	}

    function getUserInfo($userid){
    	$this->db->where("user_id",$userid);		
		$q = $this->db->get("user");
		return $q->result();
    }
    
    function getUserUsed($uids){
    	$this->db->where_in("history_exam_user", $uids);
    	$q = $this->db->get("history_exam");
		$rows = $q->result();	
		
		$used = array();
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->history_exam_user] = true;			
		}	
		
		return $used;
    	
    }
}
