<?php

class Func extends Controller {
	var $sess;
	var $lang;
	var $modules;

	function Func()
	{
		parent::Controller();	
		
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
		$this->load->model("functionmodel");
		
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
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "function_desc";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		
		$sess = unserialize($usess);
		if (! isset($this->modules["master"]))
		{
			redirect(base_url());
		}
				
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE function_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END function_status_desc ", false);
		if ($limit)
		{
			$q = $this->db->join("jabatan", "jabatan_id = function_jabatan", "left outer");
			$q = $this->db->get("function", $limit, $offset);
		}
		else
		{
			$q = $this->db->join("jabatan", "jabatan_id = function_jabatan", "left outer");
			$q = $this->db->get("function");
		}
		
		$list = $q->result();
		
		$funcids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$funcids[] = $list[$i]->function_id; 
		}		
		
		$functionused = $this->functionmodel->GetUsed($funcids);
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->used = isset($functionused[$list[$i]->function_id]);
		}
				
		$total = $this->db->count_all("function");
		
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
		$this->pagination1->lang_title = $this->config->item('group');
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
		
		$this->mysmarty->assign("group_title", $this->config->item('group')); 
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("description", strtoupper($this->config->item('description')));
		$this->mysmarty->assign("header_list_function", $this->config->item('header_list_function'));
		$this->mysmarty->assign("jabatan", ucfirst($this->config->item('jabatan')));
		$this->mysmarty->assign("function_desc", strtoupper($this->config->item('function_desc')));		
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("function_list", ucfirst($this->config->item('function_list')));		
		
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "function/list.html");
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
		
		$data['function_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("function_id", $id);
		$this->db->update("function", $data);				
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
		
		$functionused = $this->functionmodel->GetUsed(array($id));
		if (isset($functionused[$id]))
		{
			redirect(base_url());
		}
				
		$this->db->where("function_id", $id);
		$this->db->delete("function");
		
		redirect(site_url("func"));
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
			$this->db->where("function_id", $edit);
			$this->db->join("jabatan", "function_jabatan = jabatan_id", "left outer");
			$q = $this->db->get("function");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("funcedit", $row);	
			$ltitle_form = sprintf(getconfig("lmodify_level"), getconfig("function"));
	
		}else{
			$ltitle_form = sprintf(getconfig("ladd_level"), getconfig("function"));
		}
		
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		$this->mysmarty->assign("function_desc", $this->config->item("function_desc"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("jabatan", $this->config->item("jabatan"));		
		$this->mysmarty->assign("ok_save_func", $edit ? $this->config->item("ok_update_func") : $this->config->item("ok_add_func"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "function/form.html");
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
		
		if (! isset($this->modules["master"]))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$jabatan = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : "";		
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$edit = $this->uri->segment(3);
		
		$errs = array();
		
		if (strlen($jabatan) > 0)
		{
			$this->db->where("jabatan_name", addslashes($jabatan));
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_jabatan");
			}
			else
			{
				$rowjabatan = $q->row();
			}
		}
		else 
		{
			$errs[] = $this->config->item("err_jabatan_name");
		}		
		
		if (strlen($desc) == 0)
		{
			$errs[] = $this->config->item("err_function_desc");
		}

		if (count($errs) == 0)
		{
			$this->db->where("function_desc", addslashes($desc));
			$this->db->where("function_jabatan", $jabatan ? $rowjabatan->jabatan_id : 0);
			$q = $this->db->get("function");
			if ($q->num_rows() > 0)
			{
				$row = $q->row();
				if ($row->function_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_func");
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
		$data['function_desc'] = addslashes($desc);
		$data['function_status'] = addslashes($status);
		$data['function_jabatan'] = $jabatan ? $rowjabatan->jabatan_id : 0;		

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("function_id", $edit);
			
			$this->db->update("function", $data);
		}
		else
		{
			$data['function_created'] = date("Ymd");
			$data['function_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("function", $data);
		}
	}
	
	function getlist()
	{
		$jabatan = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : "";
		
		$this->db->where('jabatan_name', $jabatan);
		$q = $this->db->get("jabatan");
		$rows = $q->result();
		
		$this->db->flush_cache();
		
		$this->db->order_by("function_desc", "asc");
		$this->db->where("function_jabatan", count($rows) ? $rows[0]->jabatan_id : 0);
		$this->db->where("function_status", 1);

		$q = $this->db->get("function");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			echo $list[$i]->function_desc;
			echo "\1";
		}
	}
	
	function showoptions($jab)
	{
		$this->db->where("function_jabatan", $jab);
		$q = $this->db->get("function");		
		$rows = $q->result();
		
		$this->mysmarty->assign("lfunction", $this->config->item('function')); 
		
		$this->mysmarty->assign("def", isset($_POST['def']) ? $_POST['def'] : 0);
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("function/showoptions.html");		
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */