<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ResourcesModel extends Model {
	function ResourcesModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->helper("common");
		$this->load->model("levelmodel");
	}	
	
	function taketimes($sess, $referenceids)
	{
		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}

		$this->db->group_by(array("history_reference_reference")); 
		$this->db->where_in("history_reference_reference", $referenceids);
		$this->db->select("history_reference_reference, count(*) total");
		$q = $this->db->get("history_reference");		
		$this->db->flush_cache();
		
		$rowhists = $q->result();		
		
		$hist = array();
		for($i=0; $i < count($rowhists); $i++)
		{
			$hist[$rowhists[$i]->history_reference_reference] = $rowhists[$i]->total;
		}		
		
		return $hist;
	}
	
	function takelast($sess, $referenceids)
	{
		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}

		$this->db->order_by("history_reference_date", "desc");
		$this->db->order_by("history_reference_time", "desc");
		$this->db->where_in("history_reference_reference", $referenceids);
		$q = $this->db->get("history_reference");		
		$this->db->flush_cache();
		
		$rowhists = $q->result();		

		$hist = array();
		for($i=0; $i < count($rowhists); $i++)
		{
			if (isset($hist[$rowhists[$i]->history_reference_reference])) continue;
			
			$t = dbintmaketime($rowhists[$i]->history_reference_date, $rowhists[$i]->history_reference_time);				
			$hist[$rowhists[$i]->history_reference_reference] = date("d/m/Y H:i", $t);
		}		
		
		return $hist;
	}
	
	function getResourcesIds($sess, $topics=0)
	{
		// all staff
		$ids=array();	
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}			
		$this->db->where("reference_allstaff", 1);
		$this->db->join("category", "reference_topic = category_id");
		if($topics)
			$this->db->where("category_id", $topics);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->reference_id;
		}
		
		// per jabatan
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}		
		$this->db->where("reference_jabatan_jabatan", $sess['user_jabatan']);
		$this->db->join("reference", "reference_id = reference_jabatan_reference");
		$this->db->join("category", "category_id = reference_topic");
		if($topics)
			$this->db->where("category_id", $topics);
	
		$q = $this->db->get("reference_jabatan");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->reference_id;
		}						
		
		
		// per function
		$this->db->where("reference_function_function", $sess['user_function']);
		$this->db->join("reference", "reference_id = reference_function_reference");
		$this->db->join("category", "category_id = reference_topic");
		if($topics)
			$this->db->where("category_id", $topics);
	
		$q = $this->db->get("reference_function");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->reference_id;
		}		
		
		// per level group		
		
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();		
		$row = $q->row();
		
		$arr = array();			
		$this->levelmodel->getparentlevelgroups($row->jabatan_level_group, $arr);
		
		$arrids = array(0);
		for($i=0; $i < count($arr); $i++)
		{
			$arrids[] = $arr[$i]->level_group_id;
		}		
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}		
		$this->db->where_in("reference_levelgroup_levelgroup", $arrids);
		$this->db->join("reference", "reference_id = reference_levelgroup_reference");
		$this->db->join("category", "category_id = reference_topic");
		if($topics)
			$this->db->where("category_id", $topics);
	
		$q = $this->db->get("reference_levelgroup");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->reference_id;
		}		
		
		// per npk
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}		
		$this->db->where("reference_npk_npk", $sess['user_id']);
		$this->db->join("reference", "reference_id = reference_npk_reference");
		$this->db->join("category", "category_id = reference_topic");
		if($topics)
			$this->db->where("category_id", $topics);
	
		$q = $this->db->get("reference_npk");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->reference_id;
		}	
		
		return $ids;	
	}
}
