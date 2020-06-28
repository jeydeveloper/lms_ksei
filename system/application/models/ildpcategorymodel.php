<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ILDPCategoryModel extends Model {
	function ILDPCategoryModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->model("levelmodel");
		$this->load->model("ildpmodel");		
	}	

	function getParentIds($id, &$parents)
	{		
		$this->db->where("ildp_category_id", $id);
		$q = $this->db->get("ildp_category");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$row = $q->row();
		
		if ($row->category_parent == 0)
		{
			return;
		}
		
		array_push($parents, $row->ildp_category_parent);						
		$this->ildp_category($row->ildp_category_parent, $parents);
	}

	function getArrayTree(&$tree, $parent, $sortby="ildp_category_name", $orderby="asc", $searchs=false)
	{		
		$this->db->order_by($sortby, $orderby);
		$this->db->where("ildp_category_parent", $parent);
		
		if (is_array($searchs))
		{
			$this->db->where_in("ildp_category_id", $searchs);
		}
		
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0) return;

		$list = $q->result();	
		for($i=0; $i < count($list); $i++)
		{
			if (! is_array($tree)) $tree = array();
			
			array_push($tree, $list[$i]);
			$this->getArrayTree($tree[$i]->child, $list[$i]->ildp_category_id, $sortby, $orderby, $searchs);
		}		
	}

	function getUsed()
	{
		$used = array();
		
		// apakah punya anak
		
		$q = $this->db->get("ildp_category");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->ildp_category_parent] = true;						
		}	
		
		$ids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			if (isset($used[$rows[$i]->ildp_category_id])) continue;
			
			$ids[] = $rows[$i]->ildp_category_id;
		}		
				
		// cek apakah dipakai ildp form
		$this->db->where_in("ildp_catalog_category", $ids);
		$q = $this->db->get("ildp_catalog");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->ildp_catalog_category] = true;			
		}		

		return $used;
	}	

	function getParentTreeOptions(&$s, $parent, $def=0, $level=0, $type=0)
	{
		$this->db->order_by("ildp_category_name", "asc");
		$this->db->where("ildp_category_parent", $parent);
		$q = $this->db->get("ildp_category");
		
		if ($q->result() == 0) return;
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			$s .= "<option value='".$res[$i]->ildp_category_id."'".(($def == $res[$i]->ildp_category_id) ? " selected" : "").">";
			for($j=0; $j <= $level; $j++)
			{
				$s .= "---";
			}		
			
			$s .= " ".$res[$i]->ildp_category_name;
			$s .= "</option>";
			
			$this->getParentTreeOptions($s, $res[$i]->ildp_category_id, $def, $level+1, $type);			
		}
	}	

	function getChildIds($parent, &$childs)
	{		
		$this->db->where("ildp_category_parent", $parent);
		$q = $this->db->get("ildp_category");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			array_push($childs, $res[$i]->ildp_category_id);						
			$this->getChildIds($res[$i]->ildp_category_id, $childs);
		}		
	}		

}
