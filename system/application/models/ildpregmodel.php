<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ILDPRegModel extends Model {
	var $m_grade;
	
	function ILDPRegModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->helper("common");
		$this->load->model("levelmodel");
	}	

	function IsPeriod()
	{
		$this->db->where("ildp_registration_period_status", 1);
		$this->db->where("ildp_registration_period_start <=", date("Y-m-d 00:00:00"));
		$this->db->where("ildp_registration_period_end >=", date("Y-m-d 00:00:00"));
		$q = $this->db->get("ildp_registration_period");
	
		if ($q->num_rows() == 0) return FALSE;
		
		$row = $q->row();
		
		$row-> ildp_registration_period_start_t = dbmaketime($row->ildp_registration_period_start);
		$row-> ildp_registration_period_end_t = dbmaketime($row->ildp_registration_period_end);
		
		return $row;
	}
	
	function getManager($userid, $manager, $eligable)
	{
		$sql = sprintf("	SELECT self.*, atasan.user_grade_code atasan_grade_code 
						FROM %suser self INNER JOIN %suser atasan ON self.user_npk_atasan = atasan.user_npk
						WHERE self.user_npk = %d ", $this->db->dbprefix, $this->db->dbprefix, $userid);

		$q = $this->db->query($sql);

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$row = $q->row();
		
		if ($eligable)				
		{
			if ($row->atasan_grade_code < $this->m_grade)
			{
				$this->getManager($row->user_npk_atasan, $manager, $eligable);
				return;
			}
		}
		
		if (in_array($row->user_npk_atasan, $manager)) 
		{
			return;
		}
		$manager[] = $row->user_npk_atasan;
		
		if ($row->atasan_grade_code >= $this->m_grade)
		{
			return;
		}
		
		$this->getManager($row->user_npk_atasan, $manager, $eligable);
	}
	
	// eligable=1, atasan yg eligable
	function getAllManager($eligable=0, $userid=0)
	{
		if (! $userid) $userid = $this->sess['user_npk'];
		$this->m_grade = $this->getEligableGrade();
		
		$manager = array(0);

		$this->getManager($userid, $manager, $eligable);
		
		return $manager;
	}
	
	function IsManager()
	{
		if (! isset($this->sess))
		{
			return 0;
		}
		
		if (! isset($this->sess['user_npk']))
		{
			return 0;
		}
		
		$this->db->where("user_npk_atasan", $this->sess['user_npk']);
		return $this->db->count_all_results("user");
	}
	
	function getBawahan($usernpk, $bawahan)
	{
		$this->db->where("user_npk_atasan", $usernpk);
		$q = $this->db->get("user");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (in_array($rows[$i]->user_id, $bawahan)) continue;
			
			$bawahan[] = $rows[$i]->user_id;
			if ($rows[$i]->user_grade_code >= $this->m_grade) continue;
			$this->getBawahan($rows[$i]->user_npk, $bawahan);
		}
	}
	
	function getAllBawahan()
	{
		$this->m_grade = $this->getEligableGrade();
		
		$bawahan = array(0);
		$this->getBawahan($this->sess['user_npk'], $bawahan);
		
		return $bawahan;
	}	
	
	function getUserHRRM()
	{
		$this->db->where("hrrm_npk", $this->sess['user_id']);
		$q = $this->db->get("hrrm");
		
		if ($q->num_rows() == 0) return array(0);
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$arr[] = $rows[$i]->hrrm_group;
			$this->levelmodel->getGroupChildIds($arr, $rows[$i]->hrrm_group);
		}
		
		$this->db->where_in("jabatan_level_group", $arr);
		$this->db->join("jabatan", "jabatan_id = user_jabatan");
		$q = $this->db->get("user");
		
		$rows = $q->result();
		$userids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$userids[] = $rows[$i]->user_id;
		}
		
		return $userids;
	}
	
	function isEligableGrade()
	{
		$this->db->where("ildpsetting_key", "reportlevelcond1");
		$q = $this->db->get("ildpsetting");
		
		if ($q->num_rows() == 0)
		{
			$grade = $this->config->item("eligable_grade_for_approval");
		}
		else
		{
			$row = $q->row();
			$grade = $row->ildpsetting_val;
		}
		
		return $this->sess['user_grade_code'] >= $grade;
	}
	
	function getEligableGrade()
	{
		$this->db->where("ildpsetting_key", "reportlevelcond1");
		$q = $this->db->get("ildpsetting");
		
		if ($q->num_rows() == 0)
		{
			$grade = $this->config->item("eligable_grade_for_approval");
		}
		else
		{
			$row = $q->row();
			$grade = $row->ildpsetting_val;
		}
		
		return $grade;
	}	
}
