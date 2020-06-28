<?php
include_once "base.php"; 

class ILDPMethod extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPMethod()
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
		$this->load->model("topicmodel");		
		$this->load->model("ildpmodel");
		$this->load->model("ildpcategorymodel");
		
		$this->load->database();	
		
		$this->language = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->language ? $this->language : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->language);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
				
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));
			
			$this->sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($this->sess['user_type']);
		}				
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		
		$this->langmodel->init();
	}
		
	function index($topicid=0, $referer="", $userid=0)
	{				
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
		
		if(!$this->modules['ildpadmin'])
		{
			redirect('user');
			exit;
		} 			
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("llearning_method", $this->config->item("llearning_method"));
		$this->mysmarty->assign("lildp_catalog", $this->config->item("lildp_catalog"));
		$this->mysmarty->assign("lheader_ildp_method_list", $this->config->item("lheader_ildp_method_list"));
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpmethod/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search($offset=0)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
				
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "ildp_method_name";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
				
		$this->mysmarty->assign("lapproved_by", $this->config->item("lapproved_by"));		
		
		// 

		$this->db->distinct();
		$this->db->select("ildp_catalog_method_method");
		$q = $this->db->get("ildp_catalog_method");
		$rowmethods = $q->result();
		for($i=0; $i < count($rowmethods); $i++)
		{
			$methodused[$rowmethods[$i]->ildp_catalog_method_method] = true;
		}
			
		// list

		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by($sortby, $orderby);
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$q = $this->db->get("ildp_method");
		
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_method_status_desc = ($rows[$i]->ildp_method_status != 1) ? $this->config->item("inactive") : $this->config->item("active");
			$rows[$i]->ildp_method_status_image = '<img src="'.base_url().'images/16/'.(($rows[$i]->ildp_method_status != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($rows[$i]->ildp_method_status != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($rows[$i]->ildp_method_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
			$rows[$i]->isused = isset($methodused[$rows[$i]->ildp_method_id]);
		}
						
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$total = $this->db->count_all_results("ildp_method");	
		
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
		$this->pagination1->lang_title = $this->config->item('llearning_method');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($rows);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("catalogs", $rows);
		$this->mysmarty->assign("ncatalogs", count($rows));
		
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
						
		$html = $this->mysmarty->fetch("ildpmethod/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
		
	function form($id=0)
	{				
		if ($this->sess['user_type'] != 0)
		{
			redirect(base_url());
		}
		
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		if ($id)
		{
			$this->db->where("ildp_method_id", $id);
			$q = $this->db->get("ildp_method");
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowedit = $q->row();			
			$this->mysmarty->assign("rowedit", $rowedit);
			
			$this->mysmarty->assign("ltitle", $this->config->item("ledit_learning_method"));
		}
		else
		{
			$this->mysmarty->assign("ltitle", $this->config->item("ladd_learning_method"));
		}
				
		$this->mysmarty->assign("llearning_method", $this->config->item("llearning_method"));
		$this->mysmarty->assign("lsave", $this->config->item("lsave"));
		$this->mysmarty->assign("lsubmit", $this->config->item("lsubmit"));
		
		$this->mysmarty->assign("lconfirm_ildp_catalog_save", $this->config->item("lconfirm_ildp_catalog_save"));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpmethod/form.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function save($id=0)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}

		$nama = isset($_POST['nama']) ? $_POST['nama'] : "";

		if (strlen($nama) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("llearning_method_name");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->where("ildp_method_name", $nama);
		$q = $this->db->get("ildp_method");

		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			if ($row->ildp_method_id != $id) 
			{
				$callback['error'] = true;
				$callback['message'] = $this->config->item("llearning_method_alreadyexist");
			
				echo json_encode($callback);
				return;
			}
		}

		unset($insert);
		
		$insert['ildp_method_name'] = $nama;
		$insert['ildp_method_modified'] = date("Y-m-d H:i:s");
		$insert['ildp_method_modifier'] = $this->sess['user_id'];
				
		if ($id)
		{
			$this->db->where("ildp_method_id", $id);
			$this->db->update("ildp_method", $insert);
	
			$callback['error'] = false;
			$callback['message'] = $this->config->item("lsuccess_update_ildp_method");
				
			echo json_encode($callback);			
			return;
		}

		$insert['ildp_method_status'] = 1;
		$insert['ildp_method_creator'] = $this->sess['user_id'];
		$insert['ildp_method_created'] = date("Y-m-d H:i:s");
		
		$this->db->insert("ildp_method", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lsuccess_add_ildp_method");
			
		echo json_encode($callback);
	}
	
	function changestatus($id, $status)
	{
		if (! isset($this->modules['ildpadmin']))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_exipred_session");
			
			echo json_encode($callback);
			exit;
		}
		
		if (! $id)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_exipred_session");
			
			echo json_encode($callback);
			exit;
		}				
		
		$data['ildp_method_modified'] = date("Y-m-d H:i:s");
		$data['ildp_method_modifier'] = $this->sess['user_id'];				
		$data['ildp_method_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("ildp_method_id", $id);
		$this->db->update("ildp_method", $data);				
		
		$callback['error'] = false;
		
		$statusdesc = ($data['ildp_method_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active");
		$statusimage = '<img src="'.base_url().'images/16/'.(($data['ildp_method_status'] != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($data['ildp_method_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($data['ildp_method_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
		
		$callback['newstatus'] = sprintf("<a href='#' onclick='javascript: chagestatus(%d, %d)'>%s</a>", $id, $data['ildp_method_status'], $statusimage);
		
		echo json_encode($callback);
	}
	
	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("ildp_catalog_method_method", $id);
		$q = $this->db->get("ildp_catalog_method");
		if ($q->num_rows() > 0)
		{
			redirect(base_url());
		}
				
		$this->db->where("ildp_method_id", $id);
		$this->db->delete("ildp_method");
		
		redirect(site_url()."/ildpmethod");
	}
	
	function bytraining()
	{
		$catalog = isset($_POST['catalog']) ? $_POST['catalog'] : 0;
		$default = isset($_POST['def']) ? $_POST['def'] : 0;
		$detail_id = isset($_POST['detail_id']) ? $_POST['detail_id'] : 0;
		
		$this->db->where("ildp_catalog_method_catalog", $catalog);
		$this->db->join("ildp_method", "ildp_method_id = ildp_catalog_method_method");
		$q = $this->db->get("ildp_catalog_method");
		
		$rows = $q->result();

		$this->mysmarty->assign("default", $default);
		$this->mysmarty->assign("rows", $rows);
		
		//get detail info
		$this->db->limit(1);
		$this->db->select("ildp_detail_devarea");
		$this->db->where("ildp_detail_id", $detail_id);
		$q = $this->db->get("ildp_detail");
		$rows = $q->result_array();

		$callback['html'] = $this->mysmarty->fetch("ildpmethod/options.html");		
		$callback['devarea_default'] = $rows[0]['ildp_detail_devarea'];
				
		echo json_encode($callback);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
