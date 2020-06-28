<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class JabatanModel extends Model {
	function JabatanModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}	
	
	function GetCategoryUsed($ids=false)
	{
		$used = array();
		
		
		// apakah punya anak
		
		if (is_array($ids))
		{
			$this->db->where_in("catjabatan_parent", $ids);
	
			$q = $this->db->get("catjabatan");
			$this->db->flush_cache();	
			
			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				$used[$rows[$i]->catjabatan_parent] = true;			
				$ids = array_diff($ids, array($rows[$i]->catjabatan_parent));
			}
		}
		
		if (count($ids) == 0) return $used;
		
		// apakah digunakan oleh jabatan
		
		if (is_array($ids))
		{
			$this->db->where_in("jabatan_category", $ids);
		}
		
		$q = $this->db->get("jabatan");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->jabatan_category] = true;	
			if (is_array($ids))
			{		
				$ids = array_diff($ids, array($rows[$i]->jabatan_category));
			}
		}
		
		if (is_array($ids))
		{
			if (count($ids) == 0) return $used;
		}
		
		// apakah digunakan oleh training/certificate/classroom

		if (is_array($ids))
		{
			$this->db->where_in("training_catjabatan_category", $ids);
		}
				
		$q = $this->db->get("training_catjabatan");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_catjabatan_category] = true;			
			if (is_array($ids))
			{
				$ids = array_diff($ids, array($rows[$i]->training_catjabatan_category));
			}
		}	
		
		return $used;	
	}

	function GetUsed($ids)
	{
		$used = array();
		
		// apakah dipakai user
		
		$this->db->where_in("user_jabatan", $ids);
		$q = $this->db->get("user");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->user_jabatan] = true;			
			$ids = array_diff($ids, array($rows[$i]->user_jabatan));
		}	
		
		if (count($ids) == 0) return $used;
		
		// cek apakah dipakai bank soal
		
		$this->db->where_in("banksoal_question_jabatan", $ids);
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->banksoal_question_jabatan] = true;			
			$ids = array_diff($ids, array($rows[$i]->banksoal_question_jabatan));
		}
		
		if (count($ids) == 0) return $used;
		
		// cek apakah dipakai training
		
		$this->db->where_in("training_jabatan_jabatan", $ids);
		$q = $this->db->get("training_jabatan");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_jabatan_jabatan] = true;			
			$ids = array_diff($ids, array($rows[$i]->training_jabatan_jabatan));
		}		
		
		return $used;
	}		
	
	function getParents($ids, &$category)
	{
		$this->db->where_in("catjabatan_id", $ids);
		$q = $this->db->get("catjabatan");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if (in_array($list[$i]->catjabatan_parent, $category)) continue;
			
			array_push($category, $list[$i]->catjabatan_parent);
			$this->getParents(array($list[$i]->catjabatan_parent), $category);
		}
	}	

	function getArrayTree(&$tree, $parent, $status=-1, $sortby="catjabatan_name", $orderby="asc", $ids=false)
	{		
		$this->db->order_by($sortby, $orderby);
		$this->db->where("catjabatan_parent", $parent);
		
		if ($status >= 0)
		{
			$this->db->where("catjabatan_status", 1);
		}
		
		if (is_array($ids))
		{
			$this->db->where_in("catjabatan_id", $ids);
		}

		$q = $this->db->get("catjabatan");
		
		if ($q->num_rows() == 0) return;

		$list = $q->result();	
		for($i=0; $i < count($list); $i++)
		{
			if (! is_array($tree)) $tree = array();
			
			array_push($tree, $list[$i]);
			$this->getArrayTree($tree[$i]->child, $list[$i]->catjabatan_id, $status, $sortby, $orderby);
		}		
	}
	
	function getChildIds($parent, &$childs)
	{		
		$this->db->where("catjabatan_parent", $parent);
		$q = $this->db->get("catjabatan");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			array_push($childs, $res[$i]->catjabatan_id);						
			$this->getChildIds($res[$i]->catjabatan_id, $childs);
		}		
	}
	
	function getParentTreeOptions(&$s, $parent, $def=0, $level=0, $type=0)
	{
		$this->db->order_by("catjabatan_name", "asc");
		$this->db->where("catjabatan_parent", $parent);
		$q = $this->db->get("catjabatan");
		
		if ($q->result() == 0) return;
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			$s .= "<option value='".$res[$i]->catjabatan_id."'".(($def == $res[$i]->catjabatan_id) ? " selected" : "").">";
			for($j=0; $j <= $level; $j++)
			{
				$s .= "---";
			}		
			
			$s .= " ".$res[$i]->catjabatan_name;
			$s .= "</option>";
			
			$this->getParentTreeOptions($s, $res[$i]->catjabatan_id, $def, $level+1, $type);			
		}
	}		
}
