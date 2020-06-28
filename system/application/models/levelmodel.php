<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class LevelModel extends Model {
	function LevelModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}	

	function getGroupChildIds(&$arr, $parent)
	{
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_parent", $parent);
		$q = $this->db->get("level_group");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			array_push($arr, $rows[$i]->level_group_id);
			$this->getGroupChildIds($arr, $rows[$i]->level_group_id);
		}
	}

	function getGroupChilds(&$arr, $parent, $once=false)
	{
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_parent", $parent);
		$q = $this->db->get("level_group");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			array_push($arr, $rows[$i]);
			if ($once) continue;
			$this->getGroupChilds($arr, $rows[$i]->level_group_id);
		}
	}
	
	function getChilds(&$arr, $parent)
	{
		$this->db->order_by("level_name", "asc");
		$this->db->where("level_parent", $parent);
		$q = $this->db->get("level");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			array_push($arr, $rows[$i]);
			$this->getChilds($arr, $rows[$i]->level_id);
		}
	}

	function getArrayTree(&$tree, $parent, $status=-1, $sortby="level_name", $orderby="asc")
	{
		$this->db->order_by($sortby, $orderby);
		$this->db->where("level_parent", $parent);
		if ($status >= 0)
		{
			$this->db->where("level_status", 1);
		}
		$q = $this->db->get("level");
		
		if ($q->num_rows() == 0) return;

		$list = $q->result();	
		for($i=0; $i < count($list); $i++)
		{
			if (! is_array($tree)) $tree = array();
			
			$list[$i]->used = $this->IsUsed($list[$i]->level_id);
			
			array_push($tree, $list[$i]);
			$this->getArrayTree($tree[$i]->child, $list[$i]->level_id, $status, $sortby, $orderby);
		}		
	}
	
	function getParentTreeOptions(&$s, $parent, $def=0, $level=0)
	{
		$this->db->order_by("level_name", "asc");
		$this->db->where("level_parent", $parent);
		$q = $this->db->get("level");
		
		if ($q->result() == 0) return;
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			$s .= "<option value='".$res[$i]->level_id."'".(($def == $res[$i]->level_id) ? " selected" : "").">";
			for($j=0; $j <= $level; $j++)
			{
				$s .= "---";
			}		
			
			$s .= " ".$res[$i]->level_name;
			$s .= "</option>";
			
			$this->getParentTreeOptions($s, $res[$i]->level_id, $def, $level+1);
		}
	}
	
	function getnth($id, &$nth)
	{
		$this->db->where("level_id", $id);
		$q = $this->db->get("level");
		
		if ($q->num_rows() == 0)
		{
			return;
		}
		
		$row = $q->row();
		
		$nth++;
		$this->getnth($row->level_parent, $nth);
	}

	function getalllevels($id, &$arr)
	{
		$this->db->where("level_parent", $id);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			return;
		}
		
		$row = $q->row();
		array_push($arr, $row);
		
		$this->getalllevels($row->level_id, $arr);
	}
		
	function getparentlevels($id, &$arr, $field="level_id")
	{
		$this->db->where($field, $id);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			return;
		}
		
		$row = $q->row();
		array_push($arr, $row);
		
		$this->getparentlevels($row->level_parent, $arr);
	}	
	
	function getparentlevelgroups($id, &$arr)
	{
		if (is_array($id))
		{
			$this->db->where_in("level_group_id", $id);
		}
		else
		{
			$this->db->where("level_group_id", $id);
		}
		$this->db->order_by("level_group_nth", "asc");
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			return;
		}
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{			
			array_push($arr, $rows[$i]);
			$this->getparentlevelgroups($rows[$i]->level_group_parent, $arr);
		}							
	}	

	function getparentlevelgroupids($id, &$arr)
	{
		if (is_array($id))
		{
			$this->db->where_in("level_group_id", $id);
		}
		else
		{
			$this->db->where("level_group_id", $id);
		}
		$this->db->order_by("level_group_nth", "asc");
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			return;
		}
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{			
			array_push($arr, $rows[$i]->level_group_id);
			$this->getparentlevelgroupids($rows[$i]->level_group_parent, $arr);
		}							
	}	

	function levelmenu($page="", $groupid=0)
	{
		$trees = array();				
		$this->getArrayTree($trees, 0, -1, "level_name", "asc");
		
		$s = "";
		$this->showMenu($s, $trees, 0, $page, $groupid);
		
		return $s;
	}
	
	function showMenu(&$s, $tree, $level, $page="", $groupid=0)
	{
        $this->itot = 0;
		for($i=0; $i < count($tree); $i++)
		{			
			if (($page == "group") || ($page == "groupform"))
			{
				if ($tree[$i]->level_id == $groupid)
				{
					$class = 'class="active"';
				}
				else
				{
					$class = '';
				}
			}
			else
			{
				$class = '';
			}
			
			$s .= '<li '.$class.' >';
			$s .= '<a href="'.site_url().'/level/group/'.$tree[$i]->level_id.'">';
			for($j=0; $j < $level; $j++)
			{
				//$s .= "&nbsp;&nbsp;";
			}			
			$s .= '<i class="fa fa-sitemap"></i> <span>'.$tree[$i]->level_name.'</span></a>';
			$s .= '</li>';
			
			$this->itot++;
			if (isset($tree[$i]->child))
			{
				$this->showMenu($s, $tree[$i]->child, $level+1, $page, $groupid);
			}			
		}		
	}	
	
	function IsUsed($id)
	{
		// cek apakah punya anak

		$this->db->where("level_parent", $id);
		$total = $this->db->count_all_results("level");
		$this->db->flush_cache();
		
		if ($total > 0) return true;
		
		// cek apakah ada group yang pakai		

		$this->db->where("level_id", $id);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0) return false;
		
		$row = $q->row();

		$this->db->where("level_group_nth", $row->level_nth);
		$total = $this->db->count_all_results("level_group");
		$this->db->flush_cache();

		return ($total > 0);
	}
	
	function GetGroupUsed($ids)
	{
		$used = array();
		
		// apakah ada hirarki dibawahnya
		
		$this->db->where_in("level_group_parent", $ids);
		$q = $this->db->get("level_group");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->level_group_parent] = true;			
			$ids = array_diff($ids, array($rows[$i]->level_group_parent));
		}	
		
		if (count($ids) == 0) return $used;
		
		// cek apakah ada jabatan yang memakai group
		
		$this->db->where_in("jabatan_level_group", $ids);
		$q = $this->db->get("jabatan");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->jabatan_level_group] = true;			
			$ids = array_diff($ids, array($rows[$i]->jabatan_level_group));
		}
		
		if (count($ids) == 0) return $used;
		
		// cek apakah dipakai training
		
		$this->db->where_in("training_levelgroup_levelgroup", $ids);
		$q = $this->db->get("training_levelgroup");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_levelgroup_levelgroup] = true;			
			$ids = array_diff($ids, array($rows[$i]->training_levelgroup_levelgroup));
		}		
		
		return $used;
	}
	
	function getnlevel()
	{
		return $this->db->count_all_results("level");
	}		
	
	function getLevel(){
		$this->db->order_by('level_nth');
		$q = $this->db->get("level");
		$rows = $q->result();
		return $rows;
	}
	
}
