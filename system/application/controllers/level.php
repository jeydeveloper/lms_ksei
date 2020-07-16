<?php

include_once "base.php"; 

class Level extends Base{
	var $sess;
	var $lang;
	var $modules;

	function Level()
	{
		//parent::Controller();	
		parent::Base();	
	
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("usermodel");
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
		$this->load->model("levelmodel");

		$this->load->model("logmodel");
		
		$this->load->database();	
		$this->lang = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->lang ? $this->lang : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->lang);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));	
			
			$sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($sess['user_type']);					
		}		
		$this->langmodel->init();
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu($this->uri->segment(2), $this->uri->segment(3)));
		$this->mysmarty->assign("lreminder", $this->config->item('lreminder'));
	}		
	
	function index()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $this->config->item('data_per_page');
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "level_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		
		$sess = unserialize($usess);
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
		
		$trees = array();				
		$this->levelmodel->getArrayTree($trees, 0, -1, $sortby, $orderby);
		
		$s = "";
		$this->itot = 0;
		$this->showList($s, $trees, 0);				
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_level", $this->config->item('lheader_list_level'));
		$this->mysmarty->assign("llevel_name", strtoupper($this->config->item('llevel_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lexport", $this->config->item('lexport'));		
						
		$this->mysmarty->assign("tree_html", $s);
		$this->mysmarty->assign("lhierarchy",getconfig('lhierarchy'));
		$this->mysmarty->assign("lorganisational_structure",getconfig('lorganisational_structure'));
		
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "level/list.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function showList(&$s, $tree, $level)
	{						
		for($i=0; $i < count($tree); $i++)
		{			
			$s .= '<tr'. 	(($this->itot%2) ? 'class="odd"' : '').'>';
			$s .= '<td class="odd">';
			
			for($j=0; $j < $level; $j++)
			{
				$s .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			$s .= '	<a href="'.site_url().'/level/form/'.$tree[$i]->level_id.'">'.$tree[$i]->level_name.'</a>';
			$s .= '</td>';
			//$s .= '<td class="odd"><div id="status'.$tree[$i]->level_id.'"><a href="#" onclick="javascript:chagestatus('.$tree[$i]->level_id.','.$tree[$i]->level_status.')">'.(($tree[$i]->level_status == 1) ? $this->config->item('active') : $this->config->item('inactive')).'</a></div></td>';
			if (isset($tree[$i]->child) || $tree[$i]->used)
			{
				$s .= '<td>&nbsp;</td>';
			}			
			else
			{				
				$s .= '<td><a href="'.site_url().'/level/remove/'.$tree[$i]->level_id.'" onclick="javascript: return confirm(\''.$this->config->item('confirm_delete').'\');"><img src="'.base_url().'images/b_del.gif" width="12" height="12" border="0" /></a></td>';
			}	
			$s .= '</tr>';			
			
			$this->itot++;
			if (isset($tree[$i]->child))
			{
				$this->showList($s, $tree[$i]->child, $level+1);
			}
		}		
	}	
	
	function checkadmin($redirect=true)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			if ($redirect)
			{
				redirect(base_url());
				return false;
			}
		}
		
		$this->sess = unserialize($usess);
		return true;
	}
	
	function changestatus()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$id = $this->uri->segment(3);	
		$status = $this->uri->segment(4);
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}				
		
		$data['level_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("level_id", $id);
		$this->db->update("level", $data);				
	}
	
	function form()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		$edit = $this->uri->segment(3);
		if ($edit)
		{
			$this->db->where("level_id", $edit);
			$q = $this->db->get("level");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("mylevel", $row);	
			
			$def = $row['level_parent'];
			$this->mysmarty->assign("lhierarchy", getconfig("lhierarchy_modify"));
		}
		else
		{
			$def = 0;
			$this->mysmarty->assign("lhierarchy", getconfig("lhierarchy_add"));
		}
		
		$tree = "";
		$this->levelmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
		$this->mysmarty->assign("llevel_description", $this->config->item("llevel_description"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("llevel_name", $this->config->item("llevel_name"));		
		$this->mysmarty->assign("lok_save_level", $this->config->item("lok_save_level"));
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("lparent", $this->config->item("lparent"));
		$this->mysmarty->assign("lroot", $this->config->item("lroot"));	
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("tree", $tree);		
		$this->mysmarty->assign("type", 0);	
		$this->mysmarty->assign(array(
			"lname"	=> getconfig('lname')
		));
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "level/form.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function save()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";		
		$status = isset($_POST['status']) ? trim($_POST['status']) : 1;
		$parent = isset($_POST['parent']) ? trim($_POST['parent']) : 0;		
		
		$edit = $this->uri->segment(3);
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_level_name");
		}
		else
		{
			$this->db->where("level_name", addslashes($name));
			$this->db->where("level_parent", $parent);
			$q = $this->db->get("level");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->level_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_level_name");
				}				
			}
			
		}
		
		echo count($errs);
		echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}		
		
		$n = 0;
		$this->levelmodel->getnth($parent, $n);
		
						
		unset($data);
		$data['level_name'] = addslashes($name);
		$data['level_description'] = addslashes($desc);
		$data['level_status'] = $status;								

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("level_id", $edit);
			
			$this->db->update("level", $data);
		}
		else
		{
			$data['level_parent'] = $parent;
			$data['level_created'] = date("Ymd");
			$data['level_creator'] = $this->sess['user_id'];
			$data['level_nth'] = $n+1;
				
			$this->db->flush_cache();		
			$this->db->insert("level", $data);
		}
	}
	
	function remove()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		if ($this->levelmodel->IsUsed($id))
		{
			redirect(base_url());
		}
		
		$this->db->where("level_id", $id);
		$q = $this->db->get("level");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$this->db->where("level_id", $id);
		$this->db->delete("level");
		
		redirect(site_url(array("level")));
	}		
		
	function group($id="")
	{
		$this->checkadmin();
		
		$dialog = isset($_POST['dialog']) ? $_POST['dialog'] : 0;
		$level = isset($_POST['level']) ? $_POST['level'] : "";
		
		if (! isset($this->modules['master']))
		{
			if (! $dialog)
			{
				redirect(base_url());
			}
		}
				
		if (! $id)
		{
			if (! $dialog)
			{
				redirect(base_url());
			}
			else
			{
				$level = substr($level, strlen("level"));
				
				$this->db->where("level_nth", $level);
				$q = $this->db->get("level");
				$this->db->flush_cache();
				
				$rowlevel = $q->row();
				$id = $rowlevel->level_id;
			}
		}
		
		// level
		
		$this->db->where("level_id", $id);
		$q  = $this->db->get("level");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$rowlevel = $q->row();
		
		$arrlevel = array();
		$this->levelmodel->getparentlevels($rowlevel->level_parent, $arrlevel);				
		
		// groups 

		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "level_group_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";		
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
				
		$this->db->order_by($sortby, $orderby);				
		
		if ($keyword)
		{
			$this->db->where("UPPER(level_group_name) LIKE ", '%'.strtoupper($keyword).'%');
		}
		$this->db->where("level_group_nth", $rowlevel->level_nth);
		$this->db->select("*, CASE level_group_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END level_group_status_desc ", false);
		if ($limit)
		{
			$q  = $this->db->get("level_group", $limit, $offset);
		}
		else
		{
			$q  = $this->db->get("level_group");
		}
		
		$this->db->flush_cache();
		$list = $q->result();
		
		if (isset($_POST['training']))
		{
			$this->db->where("training_id", $_POST['training']);
			$q = $this->db->get("training");
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
				$rowtraining = $q->row();
				if ($rowtraining->training_all_staff)
				{
					for($i=0; $i < count($list); $i++)
					{
						$list[$i]->level_group_checked = true;
					}					
				}
				else
				{
					$groupids = array(0);
					for($i=0; $i < count($list); $i++)
					{
						$this->levelmodel->getparentlevelgroupids($list[$i]->level_group_id, $groupids);
					}					
					
					$this->db->where_in("training_levelgroup_levelgroup", $groupids);
					$this->db->where("training_levelgroup_training", $_POST['training']);					
					$q = $this->db->get("training_levelgroup");
					$this->db->flush_cache();
					
					$rowslevelgroup = $q->result();
					
					for($i=0; $i < count($rowslevelgroup); $i++)
					{						
						$temp = array($rowslevelgroup[$i]->training_levelgroup_levelgroup);
						$this->levelmodel->getGroupChildIds($temp, $rowslevelgroup[$i]->training_levelgroup_levelgroup);
						
						for($j=0; $j < count($temp); $j++)
						{
							$levelgroup[$temp[$j]] = 1;
						}
					}

					for($i=0; $i < count($list); $i++)
					{
						if (isset($levelgroup[$list[$i]->level_group_id]))
						{
							$list[$i]->level_group_checked = true;
						}
					}					
				}
			}			
		}

		if (isset($_POST['reference']))
		{
			$this->db->where("reference_id", $_POST['reference']);
			$q = $this->db->get("reference");
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
				$rowref = $q->row();
				if ($rowref->reference_allstaff)
				{
					for($i=0; $i < count($list); $i++)
					{
						$list[$i]->level_group_checked = true;
					}					
				}
				else
				{
					$groupids = array(0);
					for($i=0; $i < count($list); $i++)
					{
						$this->levelmodel->getparentlevelgroupids($list[$i]->level_group_id, $groupids);						
					}					

					$this->db->where_in("reference_levelgroup_levelgroup", $groupids);
					$this->db->where("reference_levelgroup_reference", $_POST['reference']);					
					$q = $this->db->get("reference_levelgroup");
					$this->db->flush_cache();
					
					$rowslevelgroup = $q->result();
					for($i=0; $i < count($rowslevelgroup); $i++)
					{
						$temp = array($rowslevelgroup[$i]->reference_levelgroup_levelgroup);
						$this->levelmodel->getGroupChildIds($temp, $rowslevelgroup[$i]->reference_levelgroup_levelgroup);
						
						for($j=0; $j < count($temp); $j++)
						{
							$levelgroup[$temp[$j]] = 1;
						}						
					}

					for($i=0; $i < count($list); $i++)
					{
						if (isset($levelgroup[$list[$i]->level_group_id]))
						{
							$list[$i]->level_group_checked = true;
						}
					}					
				}
			}			
		}
		
		$groupids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$arr = array();
			$this->levelmodel->getparentlevelgroups($list[$i]->level_group_parent, $arr);
			
			if (count($arr))
			{
				$list[$i]->parents = $arr;
			}
			
			$groupids[] = $list[$i]->level_group_id;						
		}				
		
		
		$groupused = $this->levelmodel->GetGroupUsed($groupids);
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->used = isset($groupused[$list[$i]->level_group_id]);
		}

		if ($keyword)
		{
			$this->db->where("UPPER(level_group_name) LIKE ", '%'.strtoupper($keyword).'%');
		}		
		$this->db->where("level_group_nth", $rowlevel->level_nth);
		$total = $this->db->count_all_results("level_group");
		$this->db->flush_cache();				
		
		$this->mysmarty->assign("parentlevels", $arrlevel);
		$this->mysmarty->assign("mylevel", $rowlevel);		
		$this->mysmarty->assign("list", $list);
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
		$config['next_link'] = '<img src="'.base_url().'/images/16/blue_next.gif" alt="next" width="16" height="16" border="0" />';
		$config['next_tag_open'] = "<td>";
		$config['next_tag_close'] = "</td>";

		$config['prev_link'] = '<img src="'.base_url().'/images/16/blue_back.gif" alt="prev" width="16" height="16" border="0" />';
		$config['prev_tag_open'] = "<td>";
		$config['prev_tag_close'] = "</td>";

		$config['first_link'] = '<img src="'.base_url().'/images/16/blue_first.gif" alt="prev" width="16" height="16" border="0" />';		
		$config['last_link'] = '<img src="'.base_url().'/images/16/blue_last.gif" alt="prev" width="16" height="16" border="0" />';

		$limits = array(10=>10, 20=>20, 50=>50);
		if (! in_array($recordperpage, $limits)) 
		{
			$limits[$recordperpage] = $recordperpage;
			ksort($limits);
		} 
		
		$limits[0] = 'all';

		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('directorat');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
						
		$this->mysmarty->assign("luser", $this->config->item("user"));
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("date_added", $this->config->item("date_added"));		
		$this->mysmarty->assign("confirm_delete", $this->config->item("confirm_delete"));		
		$this->mysmarty->assign("lexport", $this->config->item('lexport'));
		$this->mysmarty->assign("lsearch", $this->config->item('lsearch'));
		$this->mysmarty->assign("lsave", $this->config->item('lsave'));
		
		if ($dialog)
		{
			$this->mysmarty->display("level/listgroup.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu_admin.html");
			$this->mysmarty->assign("main_content", "level/listgroup.html");
			$this->mysmarty->display("sess_template.html");			
		}
	}
	
	function groupform($id="", $edit=0)
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		if (! $id)
		{
			redirect(base_url());
		}else {
		
			// level
			
			$this->db->where("level_id", $id);
			$q  = $this->db->get("level");
			$this->db->flush_cache();
	
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowlevel = $q->row();
		}
		
		if ($edit)
		{
			$this->db->where("level_group_id", $edit);
			$q = $this->db->get("level_group");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowgroup = $q->row();
			
			$arr = array();
			$this->levelmodel->getparentlevelgroups($rowgroup->level_group_id, $arr);
			
			$lgroup_title = sprintf(getconfig("lmodify_level"), $rowlevel->level_name);
			
			
			$this->mysmarty->assign("mygroup", $rowgroup);
			$this->mysmarty->assign("mygroupparents", $arr);
		}else {
			$lgroup_title = sprintf(getconfig("ladd_level"), $rowlevel->level_name);
		}
		
		
		$arrlevel = array();
		$this->levelmodel->getparentlevels($rowlevel->level_id, $arrlevel);
		
		$arrlevel = array_reverse($arrlevel);
		
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lactive", $this->config->item("active"));
		$this->mysmarty->assign("linactive", $this->config->item("inactive"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lgroup_title",$lgroup_title);

		$this->mysmarty->assign("levels", $arrlevel);
		$this->mysmarty->assign("mylevel", $rowlevel);
		
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "level/groupform.html");
		$this->mysmarty->display("sess_template.html");			
	}
	
	/*function grouplist($nth=0)
	{
		$cond = "";
		if (isset($_POST['parent']))
		{
			if (preg_match("/\((\d*)\)/", $_POST['parent'], $search))
			{
				$id = $search[1];				
				$cond .= " AND t2.level_group_id = '".$id."'";
			}
			else
			{
				$cond .= " AND t2.level_group_name = '".$_POST['parent']."'";
			}
		}
		if (isset($_POST['nth']))
		{
			$cond .= " AND t2.level_group_nth = ".$_POST['nth'];
		}
		
		$sql = "SELECT 	t1.* 
			FROM 	lmsv2_level_group t1 
				"
				.(($nth > 1) ? "INNER JOIN lmsv2_level_group t2 ON t1.level_group_parent = t2.level_group_id" : "")
				."
			WHERE	1
				AND t1.level_group_nth = ".$nth."
				".$cond." 
			ORDER BY t1.level_group_name ASC				
			 ";						
		
		$q = $this->db->query($sql);
		
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}
			echo $list[$i]->level_group_name." (".$list[$i]->level_group_id.")";			
		}
	}*/

    function grouplist($nth=0)
    {
        $cond = "";
        if (isset($_POST['parent']))
        {
            if (preg_match("/\((\d*)\)/", $_POST['parent'], $search))
            {
                $id = $search[1];
                $cond .= " AND t2.level_group_id = '".$id."'";
            }
            else
            {
                $cond .= " AND t2.level_group_name = '".$_POST['parent']."'";
            }
        }
        if (isset($_POST['nth']))
        {
            $cond .= " AND t2.level_group_nth = ".$_POST['nth'];
        }

        $sql = "SELECT 	t1.* 
			FROM 	lmsv2_level_group t1 
				"
            .(($nth > 1) ? "INNER JOIN lmsv2_level_group t2 ON t1.level_group_parent = t2.level_group_id" : "")
            ."
			WHERE	1
				AND t1.level_group_nth = ".$nth."
				".$cond." 
			ORDER BY t1.level_group_name ASC				
			 ";

        $q = $this->db->query($sql);

        $list = $q->result();
        $data = [];
        for($i=0; $i < count($list); $i++)
        {
            $data[$i] = [
                'name' => ($list[$i]->level_group_name." (".$list[$i]->level_group_id.")")
            ];
        }
        echo json_encode($data);
    }
	
	function savegrouplist($nth)
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			echo json_encode(array("err"=>1, "message"=>$this->config->item("err_exipred_session")));
			return;
		}
				
		$arrlevel = array();
		$this->levelmodel->getparentlevels($nth, $arrlevel, "level_nth");
		$arrlevel = array_reverse($arrlevel);

		// check nama
		
		$levelgroupid = isset($_POST['levelgroupid']) ? trim($_POST['levelgroupid']) : 0;
		$status = isset($_POST['status']) ? trim($_POST['status']) : 1;
		$nama = $_POST['nama'];
				
		$errs = array();
		$parentid = 0;
		for($i=0; $i < count($nama); $i++)
		{
			$n = trim($nama[$i]);
			if (strlen($n) == 0)
			{
				
				$errs[] = sprintf($this->config->item("err_please_type"), $arrlevel[$i]->level_name);				
				break;
			}
			
			if (($i+1) < count($nama))
			{
				if (preg_match("/\((\d*)\)/", $n, $search))
				{
					$id = $search[1];
					$this->db->where("level_group_id", $id);
				}
				else
				{
					$this->db->where("level_group_name", $n);
				}
				$this->db->where("level_group_parent", $parentid);
				$q = $this->db->get("level_group");						
				$this->db->flush_cache();
							
				if ($q->num_rows() == 0)
				{
					$errs[] = sprintf($this->config->item("invalid_name"), $arrlevel[$i]->level_name);
					break;
				}
				
				$rowparent = $q->row();
				$parentid = $rowparent->level_group_id;
			}
			else
			{
				if (preg_match("/\((\d*)\)/", $n, $search))
				{
					$id = $search[1];
					$this->db->where("level_group_id", $id);
				}
				else
				{
					$this->db->where("level_group_name", $n);
				}
				$this->db->where("level_group_parent", $parentid);
				$q = $this->db->get("level_group");
				
				if ($q->num_rows() > 0)
				{
					$rowgroup = $q->row();
					
					if ($levelgroupid != $rowgroup->level_group_id)
					{
						$errs[] = sprintf($this->config->item("already_exist"), $arrlevel[$i]->level_name);
						break;					
					}
				}
				
			}
		}
		
		if (count($errs))
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "message"=>$html));
			return;
		}
		
		unset($data);
		
		$data['level_group_name'] = $n;		
		$data['level_group_parent'] = $parentid;
		$data['level_group_status'] = $status;
		
		if ($levelgroupid)
		{
			$this->db->where("level_group_id", $levelgroupid);
			$this->db->update("level_group", $data);
			$this->db->flush_cache();
			
			$lmessage = $this->config->item("lok_save_levelgroup");
		}
		else
		{			
			$data['level_group_nth'] = $i;
			$data['level_group_created'] = date("Ymd");
			$data['level_group_creator'] = $this->sess['user_id'];
		
			$this->db->insert("level_group", $data);
			$this->db->flush_cache();
			
			$lmessage = $this->config->item("lok_save_levelgroup");
		}
		
		$this->db->where("level_nth", $nth);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		$row = $q->row();
		
		echo json_encode(array("err"=>0, "message"=>$lmessage, "redirect"=>site_url(array("level", "group", $row->level_id))));		
	}
	
	function groupchangestatus()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		$id = $this->uri->segment(3);	
		$status = $this->uri->segment(4);
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}				
		
		$data['level_group_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("level_group_id", $id);
		$this->db->update("level_group", $data);				
	}
	
	function groupremove()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("level_group_id", $id);
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$groupused = $this->levelmodel->GetGroupUsed(array($id));
		
		if (isset($groupused[$id]))
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$this->db->where("level_group_id", $id);
		$this->db->delete("level_group");
		$this->db->flush_cache();
		
		$this->db->where("level_nth", $row->level_group_nth);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		$row = $q->row();
		
		redirect(site_url(array("level", "group", $row->level_id)));
	}	
	
	function _showgroup()
	{
		// level group yang disimpan
		
		$this->db->where("reference_levelgroup_reference", $_POST['referenceid']);
		$q = $this->db->get("reference_levelgroup");		
		$this->db->flush_cache();
		
		$rowlevelgroup = $q->result();
		$levelgroupids = array(0);
		for($i=0; $i < count($rowlevelgroup); $i++)
		{
			$levelgroups[$rowlevelgroup[$i]->reference_levelgroup_levelgroup] = $rowlevelgroup[$i];			
			$levelgroupids[] = $rowlevelgroup[$i]->reference_levelgroup_levelgroup;
		}		
		
		// jabatan yang disimpan
		
		$this->db->where("reference_jabatan_reference", $_POST['referenceid']);
		$this->db->join("reference_jabatan", "jabatan_id = reference_jabatan_jabatan");
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();
		
		$rowjabatan = $q->result();
		for($i=0; $i < count($rowjabatan); $i++)
		{
			$jabatans[$rowjabatan[$i]->jabatan_id] = $rowjabatan[$i];			
			$levelgroupids[] = $rowjabatan[$i]->jabatan_level_group;
		}
		
		// ambil parent dari group yang disimpan
		
		$rowparents = array();
		$this->levelmodel->getparentlevelgroups($levelgroupids, $rowparents);		
		
		for($i=0; $i < count($rowparents); $i++)
		{
			$parents[] = $rowparents[$i]->level_group_id;
		}				
				
		// anak
		
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_parent", $_POST['parent']);
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		$rows = $q->result();
		$ids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->level_group_id;
		}
				
		// jabatan
		
		$this->db->order_by("jabatan_name", "asc");
		$this->db->where("jabatan_level_group", $_POST['parent']);
		$q = $this->db->get("jabatan");
		$rowjabatans = $q->result();	
		
		$jabids = array(0);
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$rowjabatans[$i]->checked = isset($jabatans[$rowjabatans[$i]->jabatan_id]);
			$jabids[] = $rowjabatans[$i]->jabatan_id;
		}
					
		$this->db->flush_cache();		
		
		// count npk for jabatan
		

		$this->db->where_in("user_jabatan", $jabids);
		$this->db->select("user_jabatan, COUNT(*) total");
		$this->db->group_by("user_jabatan");
		$q = $this->db->get("user");
		$this->db->flush_cache();
		
		$rownpks = $q->result();
		for($i=0; $i < count($rownpks); $i++)
		{
			$npks[$rownpks[$i]->user_jabatan] = $rownpks[$i]->total;
		}
		
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$rowjabatans[$i]->hasnpkfunct = isset($npks[$rowjabatans[$i]->jabatan_id]) && ($npks[$rowjabatans[$i]->jabatan_id] > 0);
		}
		
		// count function for jabatan
		

		$this->db->where_in("function_jabatan", $jabids);
		$this->db->select("function_jabatan, COUNT(*) total");
		$this->db->group_by("function_jabatan");
		$q = $this->db->get("function");
		$this->db->flush_cache();
		
		$rowfuncs = $q->result();
		for($i=0; $i < count($rowfuncs); $i++)
		{
			$funcs[$rowfuncs[$i]->function_jabatan] = $rowfuncs[$i]->total;
		}
		
		for($i=0; $i < count($rowjabatans); $i++)
		{
			if (isset($rowjabatans[$i]->hasnpkfunct) && $rowjabatans[$i]->hasnpkfunct) continue;
			
			$rowjabatans[$i]->hasnpkfunct2 = isset($funcs[$rowjabatans[$i]->jabatan_id]) && ($funcs[$rowjabatans[$i]->jabatan_id] > 0);			
			$rowjabatans[$i]->hasnpkfunct = $rowjabatans[$i]->hasnpkfunct2;
		}		
		
		// has jabatan
		
		$this->db->where_in("jabatan_level_group", $ids);
		$q = $this->db->get("jabatan");
		$rowhasjabatans = $q->result();
		$this->db->flush_cache();	
		
		for($i=0; $i < count($rowhasjabatans); $i++)
		{
			$hasjabatan[$rowhasjabatans[$i]->jabatan_level_group][] = $rowhasjabatans[$i];
		}			
		
		// end of jabatan
		
		// check child
		
		$this->db->where_in("level_group_parent", $ids);
		$q = $this->db->get("level_group");		
		$rowlevel = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rowlevel); $i++)
		{
			$haschild[$rowlevel[$i]->level_group_parent][] = $rowlevel[$i];
		}		

		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->haschild1 = isset($haschild[$rows[$i]->level_group_id]) ? $haschild[$rows[$i]->level_group_id] : false;
			$rows[$i]->haschild2 = isset($hasjabatan[$rows[$i]->level_group_id]) ? $hasjabatan[$rows[$i]->level_group_id] : false;
			
			$rows[$i]->haschild = $rows[$i]->haschild1 || $rows[$i]->haschild2;
			$rows[$i]->checked = isset($levelgroups[$rows[$i]->level_group_id]);
			
			$rows[$i]->isopen = isset($parents) && in_array($rows[$i]->level_group_id, $parents);
		}
		
		// end of check child
		
		// levelname
		
		$this->db->where_in("level_nth", isset($rows[0]->level_group_nth) ? $rows[0]->level_group_nth :  1);
		$q = $this->db->get("level");		
		$rowlevel = $q->row();
		$this->db->flush_cache();
				
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));		
		
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->assign("jabatans", $rowjabatans);
		$this->mysmarty->assign("level", $rowlevel);
		$this->mysmarty->display("level/show.html");		
	}	
	
	function showgroup()
	{
		
		if (isset($_POST['isreference']))
		{
			$this->_showgroup();
			return;
		}
		
		// level group yang disimpan
		
		$this->db->where("training_levelgroup_training", $_POST['trainingid']);
		$q = $this->db->get("training_levelgroup");		
		$this->db->flush_cache();
		
		$rowlevelgroup = $q->result();
		$levelgroupids = array(0);
		for($i=0; $i < count($rowlevelgroup); $i++)
		{
			$levelgroups[$rowlevelgroup[$i]->training_levelgroup_levelgroup] = $rowlevelgroup[$i];
			
			$levelgroupids[] = $rowlevelgroup[$i]->training_levelgroup_levelgroup;
		}		
		
		// jabatan yang disimpan
		
		$this->db->where("training_jabatan_training", $_POST['trainingid']);
		$this->db->join("training_jabatan", "jabatan_id = training_jabatan_jabatan");
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();
		
		$rowjabatan = $q->result();
		for($i=0; $i < count($rowjabatan); $i++)
		{
			$jabatans[$rowjabatan[$i]->jabatan_id] = $rowjabatan[$i];
			
			$levelgroupids[] = $rowjabatan[$i]->jabatan_level_group;
		}
		
		// ambil parent dari group yang disimpan
		
		$rowparents = array();
		$this->levelmodel->getparentlevelgroups($levelgroupids, $rowparents);		
		
		for($i=0; $i < count($rowparents); $i++)
		{
			$parents[] = $rowparents[$i]->level_group_id;
		}				
				
		// anak
		
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_parent", $_POST['parent']);
		$this->db->where("level_group_nth >", 0);
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		$rows = $q->result();

		$ids = array(0);
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->level_group_id;
		}
				
		// jabatan
		
		$this->db->order_by("jabatan_name", "asc");
		$this->db->where("jabatan_level_group", $_POST['parent']);
		$q = $this->db->get("jabatan");
		$rowjabatans = $q->result();	
		
		$jabids = array(0);
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$rowjabatans[$i]->checked = isset($jabatans[$rowjabatans[$i]->jabatan_id]);
			$jabids[] = $rowjabatans[$i]->jabatan_id;
		}
					
		$this->db->flush_cache();		
		
		// count npk for jabatan
		

		$this->db->where_in("user_jabatan", $jabids);
		$this->db->select("user_jabatan, COUNT(*) total");
		$this->db->group_by("user_jabatan");
		$q = $this->db->get("user");
		$this->db->flush_cache();
		
		$rownpks = $q->result();
		for($i=0; $i < count($rownpks); $i++)
		{
			$npks[$rownpks[$i]->user_jabatan] = $rownpks[$i]->total;
		}
		
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$rowjabatans[$i]->hasnpkfunct = isset($npks[$rowjabatans[$i]->jabatan_id]) && ($npks[$rowjabatans[$i]->jabatan_id] > 0);
		}
		
		// count function for jabatan
		

		$this->db->where_in("function_jabatan", $jabids);
		$this->db->select("function_jabatan, COUNT(*) total");
		$this->db->group_by("function_jabatan");
		$q = $this->db->get("function");
		$this->db->flush_cache();
		
		$rowfuncs = $q->result();
		for($i=0; $i < count($rowfuncs); $i++)
		{
			$funcs[$rowfuncs[$i]->function_jabatan] = $rowfuncs[$i]->total;
		}
		
		for($i=0; $i < count($rowjabatans); $i++)
		{
			if (isset($rowjabatans[$i]->hasnpkfunct) && $rowjabatans[$i]->hasnpkfunct) continue;
			
			$rowjabatans[$i]->hasnpkfunct2 = isset($funcs[$rowjabatans[$i]->jabatan_id]) && ($funcs[$rowjabatans[$i]->jabatan_id] > 0);			
			$rowjabatans[$i]->hasnpkfunct = $rowjabatans[$i]->hasnpkfunct2;
		}		
		
		// has jabatan
		
		$this->db->where_in("jabatan_level_group", $ids);
		$q = $this->db->get("jabatan");
		$rowhasjabatans = $q->result();
		$this->db->flush_cache();	
		
		for($i=0; $i < count($rowhasjabatans); $i++)
		{
			$hasjabatan[$rowhasjabatans[$i]->jabatan_level_group][] = $rowhasjabatans[$i];
		}			
		
		// end of jabatan
		
		// check child
		
		$this->db->where_in("level_group_parent", $ids);
		$q = $this->db->get("level_group");		
		$rowlevel = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rowlevel); $i++)
		{
			$haschild[$rowlevel[$i]->level_group_parent][] = $rowlevel[$i];
		}		

		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->haschild1 = isset($haschild[$rows[$i]->level_group_id]) ? $haschild[$rows[$i]->level_group_id] : false;
			$rows[$i]->haschild2 = isset($hasjabatan[$rows[$i]->level_group_id]) ? $hasjabatan[$rows[$i]->level_group_id] : false;
			
			$rows[$i]->haschild = $rows[$i]->haschild1 || $rows[$i]->haschild2;
			$rows[$i]->checked = isset($levelgroups[$rows[$i]->level_group_id]);
			
			$rows[$i]->isopen = isset($parents) && in_array($rows[$i]->level_group_id, $parents);
		}
		
		// end of check child
		
		// levelname
		
		$this->db->where_in("level_nth", isset($rows[0]->level_group_nth) ? $rows[0]->level_group_nth :  1);
		$q = $this->db->get("level");		
		$rowlevel = $q->row();
		$this->db->flush_cache();
				
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));		
		
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->assign("jabatans", $rowjabatans);
		$this->mysmarty->assign("level", $rowlevel);
		$this->mysmarty->display("level/show.html");
	}
	
	function getgroups()
	{
		$arr = array();
		$this->levelmodel->getGroupChildIds($arr, $_POST['id']);
		
		// get all jabatan
		
		$q = $this->db->get("jabatan");
		$this->db->flush_cache();
		
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			$jabatans[$list[$i]->jabatan_level_group][] = $list[$i]->jabatan_id;
		}
		
		$groups = array();
		for($i=0; $i < count($arr); $i++)
		{
			$data['id'] = $arr[$i];
			$data['ishavejabatan'] = isset($jabatans[$arr[$i]]);
			if (isset($jabatans[$arr[$i]]))
			{
				$data['jabatan'] = $jabatans[$arr[$i]];
			}
			
			$groups[] = $data;
		}
		
		echo json_encode($groups);
	}
	
	function getjabatans()
	{
		$this->db->where("jabatan_level_group", $_POST['id']);
		$q = $this->db->get("jabatan");
		$rows = $q->result();
		
		$arr = array();
		for($i=0; $i < count($rows); $i++)
		{
			$arr[] = $rows[$i]->jabatan_id;
		}
		
		echo json_encode($arr);
	}
	
	function getparents()
	{
		$arr = array();
		$this->levelmodel->getparentlevelgroupids($_POST['id'], $arr);
		
		echo json_encode($arr);
	}
	
	function getjabatanparents()
	{
		$this->db->where("jabatan_id", $_POST['id']);
		$q = $this->db->get("jabatan");
		$row = $q->row();
		
		$arr = array();
		$this->levelmodel->getparentlevelgroupids($row->jabatan_level_group, $arr);
		
		echo json_encode($arr);		
	}
	
	function levelgroupoptions($nth)
	{
		$this->db->where("level_nth", $nth);
		$q = $this->db->get("level");
		$this->db->flush_cache();
		
		$rowlevel = $q->row();
		
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_nth", $nth);
		$this->db->where("level_group_parent", $_POST['parent']);
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
				
		$rows = $q->result();
		
		$this->mysmarty->assign("def", isset($_POST['def']) ? $_POST['def'] : 0);
		$this->mysmarty->assign("nth", $nth);
		$this->mysmarty->assign("rowlevel", $rowlevel);
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("level/levelgroupselect.html");
	}
	
	function export()
	{
		$this->db->order_by("level_nth", "asc");
		$q = $this->db->get("level");
		
		$rows = $q->result();
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-level.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("level");
			
		
		$worksheet->write(0, 0, 'hierarchy id');
		$worksheet->write(0, 1, 'Name');
		$worksheet->write(0, 2, 'parent id');
		$worksheet->write(0, 3, 'level_th');
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->level_id);	
			$worksheet->write($i+1, 1, $rows[$i]->level_name);	
			$worksheet->write($i+1, 2, $rows[$i]->level_parent);	
			$worksheet->write($i+1, 3, $rows[$i]->level_nth);	
		}

		$this->xlswriter->close();
	}	
	
	function exportgroup()
	{
		$sql = "SELECT 		t1.*, t2.level_group_name parent_name
				,	CASE t1.level_group_status 
						WHEN 1 THEN '".$this->config->item('active')."' 
						ELSE '".$this->config->item('inactive')."' 
					END level_group_status_desc
			FROM	lmsv2_level_group t1 LEFT OUTER JOIN lmsv2_level_group t2 ON	t1.level_group_parent = t2.level_group_id
			ORDER BY t1.level_group_nth ASC, t1.level_group_name ASC
		";
		
		$q = $this->db->query($sql);
		
		$rows = $q->result();
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-group.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("group");
			
		
		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, 'Name');
		$worksheet->write(0, 2, 'parent id');
		$worksheet->write(0, 3, 'parent name');
		$worksheet->write(0, 4, 'status code');
		$worksheet->write(0, 5, 'status desc');
		$worksheet->write(0, 6, 'group level nth');
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->level_group_id);	
			$worksheet->write($i+1, 1, $rows[$i]->level_group_name);	
			$worksheet->write($i+1, 2, $rows[$i]->level_group_parent);	
			$worksheet->write($i+1, 3, $rows[$i]->parent_name);	
			$worksheet->write($i+1, 4, $rows[$i]->level_group_status);	
			$worksheet->write($i+1, 5, $rows[$i]->level_group_status_desc);	
			$worksheet->write($i+1, 6, $rows[$i]->level_group_nth);	
		}

		$this->xlswriter->close();
	}	

	function importunit()
	{
		$this->checkadmin();

		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}

		$this->mysmarty->assign("luser_file", $this->config->item("luser_file"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));

		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "level/import_unit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function saveimport($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		$errs = array();

		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_file");
			}
		}

		if (count($errs) == 0)
		{
			if ($_FILES['userfile']['type'] != 'application/vnd.ms-excel' && $_FILES['userfile']['type'] != "application/octet-stream")
			{
				$errs[] = $this->config->item("lempty_file");
			}
			else
			{
				$paths = pathinfo($_FILES['userfile']['name']);
				if (strcasecmp($paths['extension'], "xls") != 0)
				{
					$errs[] = $this->config->item("lempty_file");
				}

			}
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			$s_error = join(",", $errs);
			echo "<script>parent.setErrorMessage('messageimportnew', \"".$err."\")</script>";

			return;
		}

		$filename = $_FILES['userfile']['tmp_name'];


		$errs = $this->doImport("xls", $filename);

		if (is_array($errs))
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			$s_error = join(",", $errs);
			echo "<script>parent.setErrorMessage('messageimportnew', \"".$err."\")</script>";
			return;
		}

		printf("<script>parent.setSuccess('messageimportnew', '%s')</script>", $this->config->item("limport").' done');
	}

	function doImport($type="csv", $filename="") 
	{
		set_time_limit(0);

		if ($filename)
		{
			$file = $filename;
		}
		else
		{
			$file = $this->config->item("root_path")."/".$this->config->item("inbox")."/".$this->config->item("importfilename");
		}

		if (! is_file($file))
		{
			$s_echo = "can't open ".$file;
			$this->logmodel->append($s_echo);

			if ($filename) return array($s_echo);

			echo $s_echo."\r\n";
			return;
		}

		$nlevel = $this->levelmodel->getnlevel();
		$startrow = 2;
		$TotalColumn = $nlevel;

		if ($type == "xls")
		{

			require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = PHPExcel_IOFactory::load($filename);

			if (empty($objPHPExcel))
			{
				$s_echo = $this->config->item("lempty_file");

				$this->logmodel->append($s_echo);

				if ($filename) return array($s_echo);

				echo $s_echo."\r\n";

				return;
			}

			$this->logmodel->append("start reading excel file");

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = $startrow; $irow <= $highestRow; $irow++) {
                    for($j=0;$j<$TotalColumn;$j++)
					{
						$nilai = $worksheet->getCellByColumnAndRow($j, $irow)->getValue();
						$rows[$irow-2][$j] = trim($nilai);
					}
                }
            }

			$this->logmodel->append("end reading excel file");
		}
		else
		{

			$fin = fopen($file, "rb");
			if (! $fin)
			{
				echo "can't open file ".$file;
				$this->logmodel->append("can't open file ".$file);

				return;
			}

			$this->logmodel->append("start reading csv file");
			$i = 0;
			while(! feof($fin))
			{
				$line = trim(fgets($fin));
				if ($i == 0)
				{
					$i++;
					continue;
				}

				if (strlen($line) == 0) break;
				$lines = explode(";",  $line);

				for($j=1;$j<=$TotalColumn;$j++)
				{
					$rows[$i-1][$j-1] = isset($lines[$j-1]) ? trim($lines[$j-1]) : "";
				}

				$i++;
			}

			fclose($fin);
			$this->logmodel->append("end reading csv file");

		}

		if (! isset($rows))
		{
			unset($data);

			$data['import_date'] = date("Ymd");
			$data['import_time'] = date("Gis");
			$data['import_nrecords'] = 0;
			$data['import_nactive'] = 0;
			$data['import_nnoactive'] = 0;
			$data['import_creator'] = 0;

			$this->db->insert("import", $data);

			$s_echo = "file is empty";

			$this->logmodel->append($s_echo);

			if ($filename) return array($s_echo);

			echo $s_echo."\r\n";
			return;
		}

		$this->logmodel->append("start updating database");

		$jend = $nlevel;

		for($i=0; $i < count($rows); $i++)
		{
			unset($data);
			$parent = 0;
			$k = 1;
			for($j=0; $j < $jend; $j++)
			{
				unset($data);
				$data['level_group_parent'] = $parent;
				$data['level_group_name'] = trim($rows[$i][$j]);
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = $k++;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;
				if (($parent > 0) && (! $data['level_group_name']))
				{
					break;
				}
				$data['level_group_name'] = iconv("utf-8", "ascii//TRANSLIT//IGNORE", $data['level_group_name']);
				$data['level_group_name'] =  preg_replace("/^'|[^A-Za-z0-9\s-]|'$/", '', $data['level_group_name']);
				$this->db->where("level_group_name", $data['level_group_name']);
				$this->db->where("level_group_parent", $data['level_group_parent']);
				$q = $this->db->get("level_group");
				$this->db->flush_cache();
				if ($q->num_rows() > 0)
				{
					$row = $q->row();
					$parent = $row->level_group_id;
				}
				else
				{
					$this->db->insert("level_group", $data);
					$parent = $this->db->insert_id();
				}
			}
		}
		unset($data);
		$data['import_date'] = date("Ymd");
		$data['import_time'] = date("Gis");
		$data['import_nrecords'] = count($rows);
		$data['import_nactive'] = $total_nactive;
		$data['import_nnoactive'] = $total_nnoactive;
		$data['import_creator'] = 0;
		$this->db->insert("import", $data);
		$this->logmodel->append("end updating database");
		if ($filename == "")
		{
			$oldFile =$this->config->item("root_path")."/".$this->config->item("inbox")."/".$this->config->item("importfilename");
			$newFile = $this->config->item("root_path")."/".$this->config->item("inbox")."/".date("Ymd_His")."_".$this->config->item("importfilename");
			rename($oldFile,$newFile);
		}
		return 0;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
