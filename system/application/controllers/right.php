<?php
include_once "base.php"; 

class Right extends Base {
	var $sess;
	var $lang;
	var $modules;

	function Right()
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
		
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu());	
	}
	
	function index()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		// user right
		
		$this->db->distinct();
		$this->db->select("user_type");
		$q = $this->db->get("user");
		$this->db->flush_cache();
		
		$rowtypes = $q->result();
		for($i=0; $i < count($rowtypes); $i++)
		{
			$usertypes[$rowtypes[$i]->user_type] = true;
		}
		
		// end of user right
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "right_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		
		$sess = unserialize($usess);
		
		if (! isset($this->modules['right']))
		{
			redirect(base_url());
		}
				
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE right_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END right_status_desc ", false);
		if ($limit)
		{
			$q = $this->db->get("right", $limit, $offset);
		}
		else
		{
			$q = $this->db->get("right");
		}
		
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->used = isset($usertypes[$list[$i]->right_id]);
		}
		
		$total = $this->db->count_all("right");
		
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
		$this->pagination1->lang_title = $this->config->item('lright');
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
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_right", $this->config->item('lheader_list_right'));
		$this->mysmarty->assign("lright_name", strtoupper($this->config->item('lright_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lright_list", ucfirst($this->config->item('lright_list')));		
		
		$this->mysmarty->assign("lsort_list_by_usergroupname", $this->config->item('lsort_list_by_usergroupname'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));
		
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "right/list.html");
		$this->mysmarty->display("sess_template.html");
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
		
		if (! isset($this->modules['right']))
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
		
		$data['right_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("right_id", $id);
		$this->db->update("right", $data);				
	}
	
	function remove()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['right']))
		{
			redirect(base_url());
		}
		
		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("user_type", $id);
		$total = $this->db->count_all_results("user");
		$this->db->flush_cache();
		
		if ($total > 0)
		{
			redirect(base_url());
		}
		
		$this->db->where("right_id", $id);
		$this->db->delete("right");
		
		redirect(site_url("right"));
	}
	
	function form()
	{
		$this->checkadmin();

		if (! isset($this->modules['right']))
		{
			redirect(base_url());				
		}
		
		$edit = $this->uri->segment(3);
		if ($edit)
		{
			$this->db->where("right_module_right", $edit);
			$this->db->join("right", "right_id = right_module_right");
			$q = $this->db->get('right_module');
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
			
				$rowsmodule = $q->result();				
				$this->mysmarty->assign("right", $rowsmodule[0]);
							
				for($i=0; $i < count($rowsmodule); $i++)
				{
					$modules[$rowsmodule[$i]->right_module_module] = 1;
				}
			}
			else
			{
				$this->db->where("right_id", $edit);
				$q = $this->db->get('right');
				$this->db->flush_cache();			

				$rowsmodule = $q->result();				
				$this->mysmarty->assign("right", $rowsmodule[0]);
							
				$modules = array();
			}
			
			$ltitle_form = sprintf(getconfig("lmodify_level"), getconfig("luser_rights"));
			 
		}else{
			$ltitle_form = sprintf(getconfig("ladd_level"), getconfig("luser_rights"));
		}
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		
		$this->db->where("module_status", 1);
		$this->db->order_by("module_order", "asc");
		$this->db->order_by("module_desc", "asc");
		
		$q = $this->db->get("module");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->checked = isset($modules[$rows[$i]->module_id]);
		}
				
		$this->mysmarty->assign("modules", $rows);					
		$this->mysmarty->assign("lcreate_right", $this->config->item("lcreate_right"));
		$this->mysmarty->assign("lright", $this->config->item("lright"));
		$this->mysmarty->assign("lok_save_right", $this->config->item("lok_save_right"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));		
		$this->mysmarty->assign("lok_add_module", $this->config->item("lok_add_module"));	
		$this->mysmarty->assign("ok_save_directorat", $edit ? $this->config->item("ok_update_directorat") : $this->config->item("ok_add_directorat"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("lright_module", $this->config->item("lright_module"));	
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "right/form.html");
		$this->mysmarty->display("sess_template.html");
		
	}
	
	function removemodule()
	{
		if (! isset($this->modules['right']))
		{
			redirect(base_url());
			exit;
		}
				
		$this->db->where("right_module_id", $_POST['id']);
		$this->db->delete("right_module");		
	}
	
	function getmodule()
	{
		if (! isset($this->modules['right']))
		{
			exit;
		}
		
		$this->db->from('right');
		$this->db->join("right_module", "right_id = right_module_right", "left outer");
		$this->db->join("module", "module_id = right_module_module");
		$q = $this->db->get();
		$rows = $q->result();
		
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("list", $rows);			
		$this->mysmarty->assign("lright_module", $this->config->item("lright_module"));	
		
		$this->mysmarty->display("right/module.html");
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

		if (! isset($this->modules['right']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$edit = $this->uri->segment(3);
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_right");
		}
		else
		{							
			$this->db->where("right_name", addslashes($name));
			$q = $this->db->get("right");
			$this->db->flush_cache();
						
			if ($q->num_rows() > 0)
			{
				$right = $q->row();
				
				if (! $edit)
				{
					$errs[] = $this->config->item("lerr_exist_group_name");
				}
				else
				if ($right->right_id != $edit)
				{
					$errs[] = $this->config->item("lerr_exist_group_name");
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
		$data['right_name'] = addslashes($name);
		$data['right_status'] = addslashes($status);

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("right_id", $edit);
			
			$this->db->update("right", $data);
		}
		else
		{
			$data['right_created'] = date("Ymd");
			$data['right_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("right", $data);
			
			$edit = $this->db->insert_id();			
		}
		
		$this->db->where("right_module_right", $edit);
		$this->db->delete("right_module");
		$this->db->flush_cache();
		
		if (! isset($_POST['module'])) return;
		
		foreach($_POST['module'] as $val)
		{
			unset($data);
			
			$data['right_module_module'] = $val;
			$data['right_module_right'] = $edit;
			
			$this->db->insert("right_module", $data);
		}
	}
	
	function addmodule()
	{

		if (! isset($this->modules['right']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
				
		$right_id = $this->uri->segment(3);
		
		$errs = array();

		$module = isset($_POST['module']) ? trim($_POST['module']) : "";
		if (! $module)
		{
			$errs[] = $this->config->item("lerr_empty_module");
		}
		else
		{
			$this->db->where("module_name", $module);
			$q = $this->db->get("module");
			$this->db->flush_cache();
			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("lerr_module_not_exist");
			}
			else
			{
				$rowmodule = $q->row();
			}
		}
		
		if (count($errs) == 0)
		{
			$this->db->where("right_module_module", $rowmodule->module_id);
			$this->db->where("right_module_right", $right_id);
			$q = $this->db->get("right_module");
			
			if ($q->num_rows() > 0)
			{
				$errs[] = $this->config->item("lerr_module_already_exist");	
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
		
		$data['right_module_module'] = $rowmodule->module_id;
		$data['right_module_right'] = $right_id;
		
		$this->db->insert("right_module", $data);
	}
	
	function getlist()
	{
		$this->db->where("right_module_right", $_POST['right_id']);
		$q = $this->db->get("right_module");
		$rows = $q->result();
		$this->db->flush_cache();
		
		$ids = array();
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->right_module_module;
		}
		
		$this->db->order_by("module_name", "asc");
		$this->db->where("module_status", 1);
		if (count($ids))
		{
			$this->db->where_not_in("module_id", $ids);
		}
		$q = $this->db->get("module");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}
			echo $list[$i]->module_name;			
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
