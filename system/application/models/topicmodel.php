<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class TopicModel extends Model {
	function TopicModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->model("levelmodel");
		$this->load->model("ildpmodel");
	}	

	function getParentTreeOptions(&$s, $parent, $def=0, $level=0, $type=0)
	{
		$this->db->order_by("category_name", "asc");
		$this->db->where("category_parent", $parent);
		$this->db->where("category_type", $type);
		$q = $this->db->get("category");
		
		if ($q->result() == 0) return;
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			$s .= "<option value='".$res[$i]->category_id."'".(($def == $res[$i]->category_id) ? " selected" : "").">";
			for($j=0; $j <= $level; $j++)
			{
				$s .= "---";
			}		
			
			$s .= " ".$res[$i]->category_name;
			$s .= "</option>";
			
			$this->getParentTreeOptions($s, $res[$i]->category_id, $def, $level+1, $type);			
		}
	}	
	
	function getCategory($topic)
	{
		$this->db->where("category_id", $topic);
		$q = $this->db->get("category");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0) return;
		
		while (1)
		{
			$row = $q->row();
			if ($row->category_type == 0) return $row;
			
			$this->db->where("category_id", $row->category_parent);
			$q = $this->db->get("category");
			$this->db->flush_cache();	
			
			if ($q->num_rows() == 0) return;
		}
		
		return;
	}
	
	function getAllTopics(&$topics, $category)
	{
		$this->db->where("category_parent", $category);
		$this->db->where("category_status", 1);
		$q = $this->db->get("category");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			array_push($topics, $list[$i]->category_id);
			$this->getAllTopics($topics, $list[$i]->category_id);
		}
	}
	
	function hasChild($parent)
	{
		$this->db->where("category_parent", $parent);
		$this->db->where("category_status", 1);
		$q = $this->db->get("category");

		return $q->num_rows();
	}

	function getArrayTree(&$tree, $parent, $type=-1, $status=-1, $sortby="category_name", $orderby="asc", $ids=false, $searchs=false)
	{		
		$this->db->order_by($sortby, $orderby);
		$this->db->where("category_parent", $parent);
		
		if (is_array($searchs))
		{
			$this->db->where_in("category_id", $searchs);
		}
		
		if ($ids)
		{
			$this->db->where_in("category_id", $ids);
		}
		
		if ($status >= 0)
		{
			$this->db->where("category_status", 1);
		}
		if ($type >= 0)
		{
			$this->db->where("category_type", $type);
		}
		$q = $this->db->get("category");
		
		if ($q->num_rows() == 0) return;

		$list = $q->result();	
		for($i=0; $i < count($list); $i++)
		{
			if (! is_array($tree)) $tree = array();
			
			array_push($tree, $list[$i]);
			$this->getArrayTree($tree[$i]->child, $list[$i]->category_id, $type, $status, $sortby, $orderby, $ids, $searchs);
		}		
	}

	function getAllTopicsTree(&$tree, $parent, $trainings)
	{
		$this->db->where("category_parent", $parent);
		$this->db->where("category_status", 1);
		$q = $this->db->get("category");
		
		if ($q->num_rows() == 0) return;
		
		$list = $q->result();		
		
		$tree .= "<ul id='child".$parent."'>";
		for($i=0; $i < count($list); $i++)
		{
			$haschild = $this->hasChild($list[$i]->category_id);
			
			$tree .= "<li>";			
			if ($haschild)
			{
				$tree .= "<a href='javascript:showhide(\"#child".$list[$i]->category_id."\")'>".$list[$i]->category_name."</a>";
			}
			else
			{
				$tree .= $list[$i]->category_name;
			}
			$tree .= "<div id='module".$list[$i]->category_id."'>";
			
			if (isset($trainings[$list[$i]->category_id]))
			{				
				foreach($trainings[$list[$i]->category_id] as $val)
				{					
					$c = "";
					if($val->training_type == "1") $c = "(T)"; //Training
					else 
					if($val->training_type == "2") $c = "(C)"; //Certification
					
					$tree .= "<input type='checkbox' value='".$val->training_id."' name='pre[]' ".($val->checked ? "checked" : "").">".$c."&nbsp;".$val->training_name."<br />";	
				}
			}
		
			$tree .= "</div>";					
			
			if ($haschild)
			{
				$this->getAllTopicsTree($tree, $list[$i]->category_id, $trainings);
			}
			
			$tree .= "</li>";
		}
		$tree .= "</ul>";
	}
	
	function getResourcesTopicsUser($sess, &$topicids)
	{
		// all staff
			
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}			
		$this->db->where("reference_allstaff", 1);
		$this->db->join("category", "reference_topic = category_id");
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->reference_topic] = $rows[$i];			
		}
		
		// per jabatan
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}		
		$this->db->where("reference_jabatan_jabatan", $sess['user_jabatan']);
		$this->db->join("reference", "reference_id = reference_jabatan_reference");
		$this->db->join("category", "category_id = reference_topic");
		
		$q = $this->db->get("reference_jabatan");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->reference_topic] = $rows[$i];
		}						
		
		// per function
		
		$this->db->where("reference_function_function", $sess['user_function']);
		$this->db->join("reference", "reference_id = reference_function_reference");
		$this->db->join("category", "category_id = reference_topic");
		
		$q = $this->db->get("reference_function");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->reference_topic] = $rows[$i];
		}		
		
		// per level group		
		
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();		
		
		if ($q->num_rows() == 0) return;
		
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
		$q = $this->db->get("reference_levelgroup");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->reference_topic] = $rows[$i];
		}		
		
		// per npk
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("reference_status", 1);
		}		
		$this->db->where("reference_npk_npk", $sess['user_id']);
		$this->db->join("reference", "reference_id = reference_npk_reference");
		$this->db->join("category", "category_id = reference_topic");
		$q = $this->db->get("reference_npk");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->reference_topic] = $rows[$i];
		}		
	}
	
	function getTopicsUser($sess, &$topicids, &$trainingids, &$certificateids, $trainingtype=-1)
	{	
		// all staff
			
		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}
			
		$this->db->where("training_all_staff", 1);
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}
		
		$this->db->join("category", "training_topic = category_id");
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rows = $q->result();		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->training_topic] = $rows[$i];
			
			if ($rows[$i]->training_type == 1)
			{
				$trainingids[$rows[$i]->training_topic] = $rows[$i];
				continue;
			}
			
			$certificateids[$rows[$i]->training_topic] = $rows[$i];
		}

		// per category jabatan

		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}
		
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		$this->db->join("training", "training_id = training_catjabatan_training");		
		$this->db->join("jabatan", "jabatan_category = training_catjabatan_category");
		$this->db->join("category", "training_topic = category_id");
		
		$q = $this->db->get("training_catjabatan");
		$this->db->flush_cache();
		$rowscatjabs = $q->result();

		for($i=0; $i < count($rowscatjabs); $i++)
		{
			$topicids[$rowscatjabs[$i]->training_topic] = $rowscatjabs[$i];
			
			if ($rowscatjabs[$i]->training_type == 1)
			{
				$trainingids[$rowscatjabs[$i]->training_topic] = $rowscatjabs[$i];
				continue;
			}
			
			$certificateids[$rowscatjabs[$i]->training_topic] = $rowscatjabs[$i];			
		}				
		
		// per jabatan
		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}

		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}		
		$this->db->where("training_jabatan_jabatan", $sess['user_jabatan']);
		$this->db->join("training", "training_id = training_jabatan_training");
		$this->db->join("category", "category_id = training_topic");
		
		$q = $this->db->get("training_jabatan");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->training_topic] = $rows[$i];
			
			if ($rows[$i]->training_type == 1)
			{
				$trainingids[$rows[$i]->training_topic] = $rows[$i];
				continue;
			}
			
			$certificateids[$rows[$i]->training_topic] = $rows[$i];
		}						
		
		// per function

		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}		
		$this->db->where("training_function_function", $sess['user_function']);
		$this->db->join("training", "training_id = training_function_training");
		$this->db->join("category", "category_id = training_topic");
		$q = $this->db->get("training_function");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->training_topic] = $rows[$i];
			
			if ($rows[$i]->training_type == 1)
			{
				$trainingids[$rows[$i]->training_topic] = $rows[$i];
				continue;
			}
			
			$certificateids[$rows[$i]->training_topic] = $rows[$i];
		}		
		
		// per level group		
		
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();		
		
		if ($q->num_rows() == 0) return;
		
		$row = $q->row();
		
		$arr = array();			
		$this->levelmodel->getparentlevelgroups($row->jabatan_level_group, $arr);

		$arrids = array(0);
		for($i=0; $i < count($arr); $i++)
		{
			$arrids[] = $arr[$i]->level_group_id;
		}

		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}		
		$this->db->where_in("training_levelgroup_levelgroup", $arrids);
		$this->db->join("training", "training_id = training_levelgroup_training");
		$this->db->join("category", "category_id = training_topic");
		$q = $this->db->get("training_levelgroup");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->training_topic] = $rows[$i];
			
			if ($rows[$i]->training_type == 1)
			{
				$trainingids[$rows[$i]->training_topic] = $rows[$i];
				continue;
			}
			
			$certificateids[$rows[$i]->training_topic] = $rows[$i];
		}		
		
		// per npk

		if ($trainingtype != -1)
		{
			$this->db->where("training_type", $trainingtype);	
		}
		
		if (! isset($sess['asadmin']))
		{			
			$this->db->where("training_status", 1);
		}		
		$this->db->where("training_npk_npk", $sess['user_id']);
		$this->db->join("training", "training_id = training_npk_training");
		$this->db->join("category", "category_id = training_topic");
		$q = $this->db->get("training_npk");
		$rows = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->training_topic] = $rows[$i];
			
			if ($rows[$i]->training_type == 1)
			{
				$trainingids[$rows[$i]->training_topic] = $rows[$i];
				continue;
			}
			
			$certificateids[$rows[$i]->training_topic] = $rows[$i];

		}			
				
	}
	
	function getCategoryIds($topics, &$categories)
	{		
		$this->db->where_in("category_id", $topics);
		$q = $this->db->get("category");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			array_push($categories, $res[$i]->category_parent);						
			$this->getCategoryIds(array($res[$i]->category_parent), $categories);
		}		
	}
	
	function getCategoryRows($topics, &$categories)
	{		
		$this->db->where_in("category_id", $topics);
		$q = $this->db->get("category");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			array_push($categories, $res[$i]);						
			$this->getCategoryRows(array($res[$i]->category_parent), $categories);
		}		
	}
	
	function getChildIds($parent, &$childs)
	{		
		$this->db->where("category_parent", $parent);
		$q = $this->db->get("category");
		$this->db->flush_cache();		

		if ($q->num_rows() == 0) 
		{
			return;
		}
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			array_push($childs, $res[$i]->category_id);						
			$this->getChildIds($res[$i]->category_id, $childs);
		}		
	}		
	
	function GetParentIds($id, &$parents)
	{		
		$this->db->where("category_id", $id);
		$q = $this->db->get("category");
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
		
		array_push($parents, $row->category_parent);						
		$this->GetParentIds($row->category_parent, $parents);
	}
		
	function GetUsed()
	{
		$used = array();
		
		// apakah punya anak
		
		$q = $this->db->get("category");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->category_parent] = true;						
		}	
		
		$ids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			if (isset($used[$rows[$i]->category_id])) continue;
			
			$ids[] = $rows[$i]->category_id;
		}		
				
		// cek apakah dipakai training
		
		$this->db->where_in("training_topic", $ids);
		$q = $this->db->get("training");
		$this->db->flush_cache();	
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->training_topic] = true;			
		}		
		
		return $used;
	}	
	
	function getCatalogsTopicsUser($sess, &$topicids)
	{		
		$regtime = $this->ildpmodel->isRegistrationTime($sess['user_id']);
		
		if (! $regtime) return;
		
		if (strlen($sess['user_grade_code']) == 0)
		{
			$this->db->where("training_grade", "");
		}
		else
		if (! is_numeric($sess['user_grade_code']))
		{
			$this->db->where("training_grade", $sess['user_grade_code']);
		}
		else
		{
			$this->db->where("training_grade <= ".$sess['user_grade_code'], null);
		}
		
		$this->db->where("training_catalog_status", 1);
		$this->db->where("training_type", 3);
		$this->db->where("training_status", 0);
		$this->db->join("category", "training_topic = category_id");
		$q = $this->db->get("training");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$topicids[$rows[$i]->category_id] = true;
		}
	}
}
