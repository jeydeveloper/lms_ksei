<?php
include_once "base.php"; 

class Jabatan extends Base {
	var $sess;
	var $lang;
	var $modules;

	function Jabatan()
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
		$this->load->model("jabatanmodel");
		
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
	}
	
	function index()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "jabatan_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$dialog = isset($_POST["dialog"]) ? $_POST["dialog"] : 0;
		$keyword = isset($_POST["_keyword"]) ? $_POST["_keyword"] : "";
		$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
		
		if (! isset($_POST["_keyword"]))
		{
			$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		}

		if (! isset($_POST["_searchby"]))
		{
			$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";
		}
		
		$sess = unserialize($usess);
		
		if (! isset($this->modules["master"]))
		{
			if (! $dialog)
			{				
				redirect(base_url());
			}
		}
		
		if ($keyword && $searchby)
		{
			if ($searchby == "jabatan_name")
			{
				$this->db->where("UPPER(jabatan_name) LIKE ", '%'.strtoupper($keyword).'%');
			}
			else
			{
				$level = substr($searchby, strlen("level"));
				
				$this->db->where("UPPER(level_group_name) LIKE ", '%'.strtoupper($keyword).'%');
				$this->db->where("level_group_nth", $level);
			}
		}
				
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE jabatan_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END jabatan_status_desc ", false);
		if ($limit)
		{	
			$this->db->join("level_group", "jabatan_level_group = level_group_id");
			$this->db->join("catjabatan", "jabatan_category = catjabatan_id", "left outer");
			$q = $this->db->get("jabatan", $limit, $offset);
		}
		else
		{	
			$this->db->join("level_group", "jabatan_level_group = level_group_id");
			$this->db->join("catjabatan", "jabatan_category = catjabatan_id", "left outer");
			$q = $this->db->get("jabatan");
		}
				
		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);				
		for($i=0; $i < count($arrlevel); $i++)
		{
			$level[$arrlevel[$i]->level_nth] = $arrlevel[$i]->level_id;
		}
				
		$list = $q->result();
		
		$jabatanids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$jabatanids[] = $list[$i]->jabatan_id; 
		}				
		
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
						$list[$i]->jabatan_checked = true;
					}
				}
				else
				{
					$groupids = array(0);
					for($i=0; $i < count($list); $i++)
					{
						$this->levelmodel->getparentlevelgroupids($list[$i]->jabatan_level_group, $groupids);
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
						if (isset($levelgroup[$list[$i]->jabatan_level_group]))
						{
							$list[$i]->jabatan_checked = true;
						}
					}
					
					// jabatan

					$this->db->where_in("training_jabatan_jabatan", $jabatanids);
					$this->db->where("training_jabatan_training", $_POST['training']);					
					$q = $this->db->get("training_jabatan");
					$this->db->flush_cache();
					
					$rowstrainingjabatan = $q->result();
					for($i=0; $i < count($rowstrainingjabatan); $i++)
					{
						$trainingjabatan[$rowstrainingjabatan[$i]->training_jabatan_jabatan] = 1;
					}
					
					for($i=0; $i < count($list); $i++)
					{
						if (isset($trainingjabatan[$list[$i]->jabatan_id]))
						{
							$list[$i]->jabatan_checked = true;
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
				$rowreference= $q->row();
				if ($rowreference->reference_allstaff)
				{
					for($i=0; $i < count($list); $i++)
					{
						$list[$i]->jabatan_checked = true;
					}
				}
				else
				{
					$groupids = array(0);
					for($i=0; $i < count($list); $i++)
					{
						$this->levelmodel->getparentlevelgroupids($list[$i]->jabatan_level_group, $groupids);
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
						if (isset($levelgroup[$list[$i]->jabatan_level_group]))
						{
							$list[$i]->jabatan_checked = true;
						}
					}
					
					// jabatan

					$this->db->where_in("reference_jabatan_jabatan", $jabatanids);
					$this->db->where("reference_jabatan_reference", $_POST['reference']);					
					$q = $this->db->get("reference_jabatan");
					$this->db->flush_cache();
					
					$rowsrefjabatan = $q->result();
					for($i=0; $i < count($rowsrefjabatan); $i++)
					{
						$refjabatan[$rowsrefjabatan[$i]->reference_jabatan_jabatan] = 1;
					}
					
					for($i=0; $i < count($list); $i++)
					{
						if (isset($refjabatan[$list[$i]->jabatan_id]))
						{
							$list[$i]->jabatan_checked = true;
						}
					}					
					
				}
			}
		}		
				
		$jabatanused = $this->jabatanmodel->GetUsed($jabatanids);
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->level = $level[$list[$i]->level_group_nth];
			$list[$i]->used = isset($jabatanused[$list[$i]->jabatan_id]);
		}

		if ($keyword && $searchby)
		{
			if ($searchby == "jabatan_name")
			{
				$this->db->where("UPPER(jabatan_name) LIKE ", '%'.strtoupper($keyword).'%');
			}
			else
			{
				$level = substr($searchby, strlen("level"));
				
				$this->db->where("UPPER(level_group_name) LIKE ", '%'.strtoupper($keyword).'%');
				$this->db->where("level_group_nth", $level);
			}			
		}
		
		$this->db->join("level_group", "jabatan_level_group = level_group_id");		
		$total = $this->db->count_all_results("jabatan");
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit; 
				
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
		$this->pagination1->lang_title = $this->config->item('jabatan');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);
				
		$this->mysmarty->assign("levels", $arrlevel);
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
				
		$this->mysmarty->assign("department", strtoupper($this->config->item('department'))); 
		$this->mysmarty->assign("lhierarchy", $this->config->item('lhierarchy')); 
		
		$this->mysmarty->assign("group", strtoupper($this->config->item('group'))); 		
		$this->mysmarty->assign("unit_title", $this->config->item('group')); 
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("unit", strtoupper($this->config->item('unit')));		
		$this->mysmarty->assign("header_list_jabatan", $this->config->item('header_list_jabatan'));
		$this->mysmarty->assign("jabatan_name", strtoupper($this->config->item('jabatan_name')));
		$this->mysmarty->assign("directorat_name", strtoupper($this->config->item('directorat')));		
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("jabatan_list", ucfirst($this->config->item('jabatan_list')));		
		$this->mysmarty->assign("lgroup", $this->config->item('group'));
		$this->mysmarty->assign("lexport", $this->config->item('lexport'));
		$this->mysmarty->assign("lsearch_by", $this->config->item('lsearch_by'));
		$this->mysmarty->assign("lsearch", $this->config->item('lsearch'));
		$this->mysmarty->assign("lname", $this->config->item('lname'));
		$this->mysmarty->assign("lsave", $this->config->item('lsave'));
		$this->mysmarty->assign("lcategory", $this->config->item('category'));
		
		$this->mysmarty->assign("lsort_by_position_name", $this->config->item('lsort_by_position_name'));
		$this->mysmarty->assign("lsort_by_category_name", $this->config->item('lsort_by_category_name'));
		$this->mysmarty->assign("lsort_by_hierarchy", $this->config->item('lsort_by_hierarchy'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));
		
		$this->mysmarty->assign("list", $list);
		
		if ($dialog)
		{
			$this->mysmarty->display("jabatan/list.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu_admin.html");
			$this->mysmarty->assign("main_content", "jabatan/list.html");
			$this->mysmarty->display("sess_template.html");
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
		
		if (! isset($this->modules["master"]))
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
		
		$data['jabatan_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("jabatan_id", $id);
		$this->db->update("jabatan", $data);				
	}
	
	function remove()
	{
		$this->checkadmin();
		
		if (! isset($this->modules["master"]))
		{
			redirect(base_url());
		}
				
		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$jabatanused = $this->jabatanmodel->GetUsed(array($id));
		if (isset($jabatanused[$id]))
		{
			redirect(base_url());
		}		
		
		$this->db->where("jabatan_id", $id);
		$this->db->delete("jabatan");
		
		redirect(site_url("jabatan"));
	}
	
	function form()
	{
		$this->checkadmin();

		if (! isset($this->modules["master"]))
		{
			redirect(base_url());
		}
		
		$edit = $this->uri->segment(3);
		if ($edit)
		{
			$this->db->where("jabatan_id", $edit);
			$this->db->join("level_group", "level_group_id = jabatan_level_group");		
			$q = $this->db->get("jabatan");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row();
			
			$groups = array();						
			$this->levelmodel->getparentlevelgroups($row->jabatan_level_group, $groups);
			
			for($i=0; $i < count($groups); $i++)
			{
				$mygroup[] = sprintf("%s (%d)", $groups[$i]->level_group_name, $groups[$i]->level_group_id);		
			}
			
			
			$this->mysmarty->assign("mygroup", array_reverse($mygroup));
			$this->mysmarty->assign("jabatanedit", $row);
			$ltitle_jabatan = sprintf(getconfig("lmodify_level"), getconfig("ljabatan"));
			
			$def = $row->jabatan_category;
		
		}else{
			$ltitle_jabatan = sprintf(getconfig("ladd_level"), getconfig("ljabatan"));
			$def = 0;
		}

		$this->mysmarty->assign("ltitle_jabatan",$ltitle_jabatan);
		
		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);
		
		$tree = "";
		$this->jabatanmodel->getParentTreeOptions($tree, 0, $def, 0, 0);		
		
		$this->mysmarty->assign("levels", $arrlevel);
		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("unit_name", $this->config->item("unit_name"));
		$this->mysmarty->assign("unit", $this->config->item("unit"));
		$this->mysmarty->assign("jabatan_name", $this->config->item("jabatan_name"));
		$this->mysmarty->assign("department", $this->config->item("department"));		
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("directorat", $this->config->item("directorat"));	
		$this->mysmarty->assign("group", $this->config->item("group"));
		$this->mysmarty->assign("ok_save_jabatan", $edit ? $this->config->item("ok_update_jabatan") : $this->config->item("ok_add_jabatan"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lcategory", $this->config->item("category"));		
		$this->mysmarty->assign("lrefresh", $this->config->item("lrefresh"));
		$this->mysmarty->assign("laddcategory", $this->config->item("laddcategory"));		
		
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "jabatan/form.html");
		$this->mysmarty->display("sess_template.html");
		
	}
	
	function categoryselectbox()
	{
		
		$def = isset($_POST['def']) ? $_POST['def'] : 0;
		$tree = "";
		$this->jabatanmodel->getParentTreeOptions($tree, 0, $def, 0, 0);		
		
		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->display("jabatan/catselectbox.html");
	}
	
	function save($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules["master"]))
		{
			echo json_encode(array("err"=>1, "message"=>$this->config->item("err_exipred_session")));
			exit;
		}
						
		$category = isset($_POST['category']) ? trim($_POST['category']) : 0;
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$levelgroup = isset($_POST['levelgroup']) ? $_POST['levelgroup'] : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_jabatan_name");
		}

		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);				
		for($i=0; $i < count($arrlevel); $i++)
		{
			$level[$arrlevel[$i]->level_nth] = $arrlevel[$i]->level_name;
		}
		
		$isempty = true;
		$parentid = 0;
		for($i=0; $i < count($levelgroup); $i++)
		{
			$n = trim($levelgroup[$i]);
			if (strlen($n) > 0)
			{
				$isempty = false;
				
				$ns = explode(" ", $n);
				if (! preg_match("/\(([0-9]*)\)$/", $ns[count($ns)-1], $matches))
				{
					$errs[] = sprintf($this->config->item("invalid_name"), $level[$i+1]);
					break;
				}

				$this->db->where("level_group_parent", $parentid);
				$this->db->where("level_group_id", $matches[1]);
				$q = $this->db->get("level_group");
				$this->db->flush_cache();
				
				if ($q->num_rows() == 0)
				{
					$errs[] = sprintf($this->config->item("invalid_name"), $level[$i+1]);
					break;
				}
								
				$rowgroup = $q->row();
				$parentid =  $rowgroup->level_group_id;
			}
		}
		
		if ($isempty)
		{
			$errs[] = $this->config->item("lerr_empty_levelgroup");
		}
		
		if (count($errs) > 0)
		{			
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "message"=>$html));
			return;
		}		

		unset($data);
		$data['jabatan_name'] = addslashes($name);
		$data['jabatan_level_group'] = $rowgroup->level_group_id;
		$data['jabatan_status'] = $status;		
		$data['jabatan_category'] = $category;

		if ($edit)
		{			
			$this->db->where("jabatan_id", $edit);			
			$this->db->update("jabatan", $data);
			$this->db->flush_cache();
			
			$succesmessage = $this->config->item("lok_jabatan_saved");
		}
		else
		{
			$data['jabatan_created'] = date("Ymd");
			$data['jabatan_creator'] = $this->sess['user_id'];
							
			$this->db->insert("jabatan", $data);
			$this->db->flush_cache();
			
			$succesmessage = $this->config->item("lok_jabatan_saved");
		}
		
		echo json_encode(array("err"=>0, "message"=>$succesmessage, "redirect"=>site_url(array("jabatan"))));
	}
	
	function getlist()
	{
		$levelgroup = isset($_POST['levelgroup']) ? trim($_POST['levelgroup']) : "";
		$nth = isset($_POST['nth']) ? trim($_POST['nth']) : "";

		$this->db->where("level_group_name", $levelgroup);
		$this->db->where("level_group_nth", $nth);
		
		$this->db->join("jabatan", "level_group_id = jabatan_level_group");
		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}
			echo $list[$i]->jabatan_name;			
		}		
		
	}
	
	/*function getalllist()
	{		
		$this->db->order_by("jabatan_name", "asc");
		$this->db->where("jabatan_status", 1);
		
		$q = $this->db->get("jabatan");
		$list = $q->result();		
		
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}			
			echo $list[$i]->jabatan_name;
		}
				
		$this->db->flush_cache();
	}*/

    function getalllist()
    {
        $this->db->order_by("jabatan_name", "asc");
        $this->db->where("jabatan_status", 1);

        $q = $this->db->get("jabatan");
        $list = $q->result();
        $data = [];
        for($i=0; $i < count($list); $i++)
        {
            $data[$i] = [
                'name' => $list[$i]->jabatan_name
            ];
        }

        $this->db->flush_cache();

        echo json_encode($data);
    }
	
	function _show()
	{
		$this->db->where("reference_function_reference", $_POST['referenceid']);
		$q = $this->db->get("reference_function");		
		$this->db->flush_cache();
		
		$rowfunctions = $q->result();
		for($i=0; $i < count($rowfunctions); $i++)
		{
			$functions[$rowfunctions[$i]->reference_function_function] = $rowfunctions[$i];
		}
		
		// all npk yang disimpan
		
		$this->db->where("reference_jabatan_reference", $_POST['referenceid']);
		$q = $this->db->get("reference_jabatan");		
		$this->db->flush_cache();
		if ($q->num_rows() > 0)
		{
			$rowallnpks = $q->row();
		}		
		
		$this->db->where("user_jabatan", $_POST['id']);
		$hasnpk = $this->db->count_all_results("user");				
		$this->db->flush_cache();
		
		
		$this->db->order_by("function_desc", "asc");
		$this->db->where("function_jabatan", $_POST['id']);
		$q = $this->db->get("function");		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->checked = isset($functions[$rows[$i]->function_id]);			
		}		
				
		$this->mysmarty->assign("lall_npk", $this->config->item("lall_npk"));
		$this->mysmarty->assign("lfunction", $this->config->item("function"));
		
		$this->mysmarty->assign("rowallnpks", isset($rowallnpks) ? $rowallnpks : false);
		$this->mysmarty->assign("hasnpk", $hasnpk);
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("jabatan/show.html");

	}

	function show()
	{
		// yang disimpan
		
		if (isset($_POST['referenceid']))
		{
			$this->_show();
			return;
		}
		
		$this->db->where("training_function_training", $_POST['trainingid']);
		$q = $this->db->get("training_function");		
		$this->db->flush_cache();
		
		$rowfunctions = $q->result();
		for($i=0; $i < count($rowfunctions); $i++)
		{
			$functions[$rowfunctions[$i]->training_function_function] = $rowfunctions[$i];
		}
		
		// all npk yang disimpan
		
		$this->db->where("training_jabatan_training", $_POST['trainingid']);
		$q = $this->db->get("training_jabatan");		
		$this->db->flush_cache();
		if ($q->num_rows() > 0)
		{
			$rowallnpks = $q->row();
		}		
		
		$this->db->where("user_jabatan", $_POST['id']);
		$hasnpk = $this->db->count_all_results("user");				
		$this->db->flush_cache();
		
		
		$this->db->order_by("function_desc", "asc");
		$this->db->where("function_jabatan", $_POST['id']);
		$q = $this->db->get("function");		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->checked = isset($functions[$rows[$i]->function_id]);			
		}		
				
		$this->mysmarty->assign("lall_npk", $this->config->item("lall_npk"));
		$this->mysmarty->assign("lfunction", $this->config->item("function"));
		
		$this->mysmarty->assign("rowallnpks", isset($rowallnpks) ? $rowallnpks : false);
		$this->mysmarty->assign("hasnpk", $hasnpk);
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("jabatan/show.html");		
	}	
	
	function getfunctions()
	{
		$this->db->where("function_jabatan", $_POST['id']);
		$q = $this->db->get("function");		
		$rows = $q->result();

		$arr = array();
		for($i=0; $i < count($rows); $i++)
		{
			$arr[] = $rows[$i]->function_id;
		}
		
		echo json_encode($arr);
	}
	
	function showoptions($grp)
	{
		$this->db->where("jabatan_level_group", $grp);
		$q = $this->db->get("jabatan");		
		$rows = $q->result();
		
		$this->mysmarty->assign("def", isset($_POST['def']) ? $_POST['def'] : 0);
		$this->mysmarty->assign("ljabatan", $this->config->item('jabatan')); 
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("jabatan/showoptions.html");		
	}
	
	function export()
	{
		$this->db->order_by("jabatan_id", "asc");
		$q = $this->db->select("*
			, CASE jabatan_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END jabatan_status_desc "
			, false
		);
		
		$this->db->join("level_group", "level_group_id = jabatan_level_group");
		$q = $this->db->get("jabatan");
		
		$rows = $q->result();
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-jabatan.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("jabatan");
			
		
		$this->mysmarty->assign("lhierarchy", $this->config->item('lhierarchy')); 
		
		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, $this->config->item('jabatan_name'));
		$worksheet->write(0, 2, $this->config->item('lstatus_code'));
		$worksheet->write(0, 3, $this->config->item('lstatus_description'));
		$worksheet->write(0, 4, $this->config->item('hierarchy_id'));
		$worksheet->write(0, 5, $this->config->item('hierarchy_name'));
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->jabatan_id);	
			$worksheet->write($i+1, 1, $rows[$i]->jabatan_name);	
			$worksheet->write($i+1, 2, $rows[$i]->jabatan_status);	
			$worksheet->write($i+1, 3, $rows[$i]->jabatan_status_desc);	
			$worksheet->write($i+1, 4, $rows[$i]->jabatan_level_group);	
			$worksheet->write($i+1, 5, $rows[$i]->level_group_name);	
		}

		$this->xlswriter->close();
	}
	
	function catjabatan()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "catjabatan_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";
		
		$sess = unserialize($usess);

		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
		
		if ($searchby)
		{
			if ($searchby == "category_name")
			{
				$this->db->where("UPPER(catjabatan_name) LIKE", '%'.strtoupper($keyword).'%');
				$q = $this->db->get("catjabatan");
				$this->db->flush_cache();
				
				$rowsearch = $q->result();
				
				for($i=0; $i < count($rowsearch); $i++)
				{
					$ids[] = $rowsearch[$i]->catjabatan_id;
				}
				
				if (isset($ids))
				{					
					$categoryids = $ids;
					$this->jabatanmodel->getParents($ids, $categoryids);					
				}				
			}
		}
		
		if (isset($categoryids))
		{
			$this->db->where_in("catjabatan_id", $categoryids);
		}
			
		$this->db->order_by($sortby, $orderby);
		
		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}
		
		$q = $this->db->get("catjabatan");
		$list = $q->result();
		
		$trees = array();				
		for($i=0; $i < count($list); $i++)
		{
			$trees[] = $list[$i];
		}
		
		if (isset($categoryids))
		{
			$this->db->where_in("catjabatan_id", $categoryids);
		}
		
		$total = $this->db->count_all_results("catjabatan");						
		
		$categoryused = $this->jabatanmodel->GetCategoryUsed();
		$categorytraining = false;
		
		if (isset($_POST['training']))
		{
			$this->db->where("training_catjabatan_training", $_POST['training']);
			$q = $this->db->get("training_catjabatan");
			
			$rowtrainings = $q->result();
			for($i=0; $i < count($rowtrainings); $i++)
			{
				$categorytraining[$rowtrainings[$i]->training_catjabatan_category] = 1;
			}
		}		
		
		$s = "";
		$this->itot = 0;
		$this->showListCategory($s, $trees, 0, $categoryused, $categorytraining);
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit; 
				
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
		$this->pagination1->lang_title = $this->config->item('lcatjabatan');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;
				
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_category_jabatan", $this->config->item('lheader_list_category_jabatan'));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lcategory_jabatan_list", ucfirst($this->config->item('lcategory_jabatan_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		
		$this->mysmarty->assign("lsort_by_category_name", $this->config->item('lsort_by_category_name'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));
						
		$this->mysmarty->assign("tree_html", $s);				
		
		if (isset($_POST['dialog']) && $_POST['dialog'])
		{			
			$this->mysmarty->display("jabatan/category.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu_admin.html");		
			$this->mysmarty->assign("main_content", "jabatan/category.html");
			$this->mysmarty->display("sess_template.html");
		}		
	}
	
	function showListCategory(&$s, $tree, $level, $used=false, $training=false)
	{							
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		$sess = unserialize($usess);
					
		for($i=0; $i < count($tree); $i++)
		{			
			$tree[$i]->istraining = isset($training[$tree[$i]->catjabatan_id]);
			
			$s .= '<tr'. 	(($this->itot%2) ? 'class="odd"' : '').'>';
			
			if (isset($_POST['dialog']) && $_POST['dialog'])
			{
				$s .= '<td class="odd"><input type="checkbox" name="catjab[]" id="catjab[]" value="'.$tree[$i]->catjabatan_id.'" onclick="javascript:catjab_onclick(this)"'.($tree[$i]->istraining ? ' checked': '').' /></td>';
			}
			
			$s .= '<td class="odd">';
			
			for($j=0; $j < $level; $j++)
			{
				$s .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			if (isset($this->modules['master']) && (! isset($sess['asadmin'])))
			{
				$s .= $tree[$i]->catjabatan_name;
			}
			else
			{
				if (isset($_POST['dialog']) && $_POST['dialog'])
				{
					$s .= $tree[$i]->catjabatan_name;
				}
				else
				{
					$s .= '	<a href="'.site_url().'/jabatan/formcategory/'.$tree[$i]->catjabatan_id.'">'.$tree[$i]->catjabatan_name.'</a>';
				}
			}
			
			$s .= '</td>';
			
			if ((! isset($_POST['dialog'])) || (! $_POST['dialog']))
			{
				if (isset($this->modules['master']) && isset($sess['asadmin']))
				{
					$imgstat = '<img src="'.base_url().'images/16/'.(($tree[$i]->catjabatan_status == 2) ? "inactive.png" : "active.png").'" border="0" title="'.(($tree[$i]->catjabatan_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($tree[$i]->catjabatan_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
					
					$s .= '<td class="odd"><div id="status'.$tree[$i]->catjabatan_id.'"><a href="#" onclick="javascript:chagestatus('.$tree[$i]->catjabatan_id.','.$tree[$i]->catjabatan_status.')">'.$imgstat.'</a></div></td>';
					if (isset($tree[$i]->child))
					{
						$s .= '<td>&nbsp;</td>';
					}
					else
					if (is_array($used) && isset($used[$tree[$i]->catjabatan_id]))
					{
						$s .= '<td>&nbsp;</td>';
					}
					else
					{
						$s .= '<td><a href="'.site_url().'/jabatan/removecategory/'.$tree[$i]->catjabatan_id.'" onclick="javascript: return confirm(\''.$this->config->item('confirm_delete').'\');"><img src="'.base_url().'images/b_del.gif" width="12" height="12" border="0" /></a></td>';
					}
				}
			}
			
			$s .= '</tr>';			
			
			$this->itot++;
			if (isset($tree[$i]->child))
			{
				$this->showListCategory($s, $tree[$i]->child, $level+1, $used, $training);
			}
		}		
	}
	
	function changestatuscategory($id, $status)
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
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$childs = array($id);
		$this->jabatanmodel->getChildIds($id, $childs);
		
		$data['catjabatan_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where_in("catjabatan_id", $childs);
		$this->db->update("catjabatan", $data);
	}
	
	function formcategory($edit=0, $act="")
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		if ($edit)
		{
			$this->db->where("catjabatan_id", $edit);
			$q = $this->db->get("catjabatan");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("catedit", $row);	
			
			$def = $row['catjabatan_parent'];
			$ltitle_form = $this->config->item("lmodify_category_jabatan");
		
		}
		else
		{
			$ltitle_form = $this->config->item("ladd_category_jabatan");
			$def = 0;
		}
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		
		$tree = "";
		$this->jabatanmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
		$this->mysmarty->assign("category_desc", $this->config->item("category_desc"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("category_name", $this->config->item("category_name"));		
		$this->mysmarty->assign("ok_save_category_jabatan", $edit ? $this->config->item("ok_update_category_jabatan") : $this->config->item("ok_add_category_jabatan"));		
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("act", $act);
		$this->mysmarty->assign("lparent", $this->config->item("lparent"));
		$this->mysmarty->assign("lroot", $this->config->item("lroot"));	
		$this->mysmarty->assign("tree", $tree);		
		$this->mysmarty->assign("type", 0);	
		
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "jabatan/formcategory.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function savecategory($edit=0)
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
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";		
		$status = isset($_POST['status']) ? trim($_POST['status']) : 1;
		$parent = isset($_POST['parent']) ? trim($_POST['parent']) : 0;		
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("catjabatan_name", addslashes($name));
			$this->db->where("catjabatan_parent", $parent);
			$q = $this->db->get("catjabatan");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->catjabatan_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
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
						
		unset($data);
		$data['catjabatan_name'] = addslashes($name);
		$data['catjabatan_status'] = $status;				
		$data['catjabatan_parent'] = $parent;

		if ($edit)
		{						
			$this->db->flush_cache();
			$this->db->where("catjabatan_id", $edit);
			
			$this->db->update("catjabatan", $data);
		}
		else
		{			
			$data['catjabatan_created'] = date("Ymd");
			$data['catjabatan_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("catjabatan", $data);
		}
	}		
	
	function removecategory($id=0)
	{
		$this->checkadmin();
		
		if (! isset($this->modules["master"]))
		{
			redirect(base_url());
		}
				
		if (! $id)
		{
			redirect(base_url());
		}
		
		$categoryused = $this->jabatanmodel->GetCategoryUsed(array($id));
		if (isset($categoryused[$id]))
		{
			redirect(base_url());
		}		
		
		$this->db->where("catjabatan_id", $id);
		$this->db->delete("catjabatan");
		
		redirect(site_url(array("jabatan", "catjabatan")));
	}
	
	function addparticipanttrainingbycategoryjabatan()
	{
		$this->db->where("training_catjabatan_training", $_POST['training']);
		$this->db->delete("training_catjabatan");
		
		if (isset($_POST['catjab']))
		{
			foreach($_POST['catjab'] as $val)
			{
				unset($data);
				
				$data['training_catjabatan_training'] = $_POST['training'];
				$data['training_catjabatan_category'] = $val;
				
				$this->db->insert("training_catjabatan", $data);
			}
		}
		
		echo json_encode(array("message"=>$this->config->item("lupdateparticipant")));
	}
	
	function getallchild($id)
	{
		$childs = array();
		$this->jabatanmodel->getChildIds($id, $childs);
		
		echo json_encode(array("childs"=>$childs));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
