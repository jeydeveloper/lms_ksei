<?php
include_once "base.php"; 

class ILDPApprovalHist extends Base{
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPApprovalHist()
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
		$this->load->model("ildpmodel");
		$this->load->model("ildpregmodel");
		
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
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("lapprovalhist_list", $this->config->item("lapprovalhist_list"));
		$this->mysmarty->assign("lheader_approvalhist_list", $this->config->item("lheader_approvalhist_list"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildpapprovalhist/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
		
	function search($offset=0)
	{			
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		
		$userids = $this->ildpregmodel->getAllBawahan();
		$userhrrms = $this->ildpregmodel->getUserHRRM();

		$userids = array_unique(array_merge($userids, $userhrrms));
		
		$this->db->limit($limit, $offset);
		//$this->db->order_by($sortby, $orderby);
		$this->db->order_by("user_npk", "asc");
		$this->db->order_by("ildp_trail_created_time", "desc");
		$this->db->where("user_npk LIKE", '%'.$keyword.'%');
		$this->db->where_in("ildp_trail_status", array(-1, 2));
		$this->db->where_in("ildp_trail_user", $userids);
		$this->db->join("user", "ildp_trail_user = user_id");	
		$q = $this->db->get("ildp_form_trail");	
		
		$rows = $q->result();
		
		$userids[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$json = json_decode($rows[$i]->ildp_trail_comments);
			switch($rows[$i]->ildp_trail_status)
			{
				case -1:
					$userids[] = $json->update->ildp_form_rejector;
				break;
				case 2:
					$userids[] = $json->update->ildp_approved_by;
				break;
			}
		}

		$this->db->where_in("user_id", $userids);
		$q = $this->db->get("user");
		$rowusers = $q->result();
		
		for($i=0; $i < count($rowusers); $i++)
		{
			$users[$rowusers[$i]->user_id] = $rowusers[$i];
		}
		
		for($i=0; $i < count($rows); $i++)
		{
			$json = json_decode($rows[$i]->ildp_trail_comments);

			$rows[$i]->data = $json;
			$rows[$i]->ildp_trail_created_time_t = date("d/m/Y H:i:s", dbmaketime($rows[$i]->ildp_trail_created_time));
						
			switch($rows[$i]->ildp_trail_status)
			{
				case -1:
					$rows[$i]->laststatus = sprintf($this->config->item("lrejected_by"), $users[$json->update->ildp_form_rejector]->user_first_name." ".$users[$json->update->ildp_form_rejector]->user_last_name, $users[$json->update->ildp_form_rejector]->user_npk);
				break;
				case 2:
					$rows[$i]->laststatus = $this->config->item("lapproved_by")." ".$users[$json->update->ildp_approved_by]->user_first_name." ".$users[$json->update->ildp_approved_by]->user_last_name." (".$users[$json->update->ildp_approved_by]->user_npk.") ";
				break;
			}
		}
		
		$this->db->where("user_npk LIKE", '%'.$keyword.'%');
		$this->db->where_in("ildp_trail_status", array(-1, 2));
		$this->db->where_in("ildp_trail_user", $userids);
		$this->db->join("user", "ildp_trail_user = user_id");
		$total = $this->db->count_all_results("ildp_form_trail");	
		
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
		$this->pagination1->lang_title = $this->config->item('llist');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);
		
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		$this->mysmarty->assign("iseligablegrade", $this->ildpregmodel->isEligableGrade());
						
		$html = $this->mysmarty->fetch("ildpapprovalhist/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
	
	function view($id)
	{		
		$userids = $this->ildpregmodel->getAllBawahan();
		$userhrrms = $this->ildpregmodel->getUserHRRM();

		$userids = array_unique(array_merge($userids, $userhrrms));
		
		$this->db->where("ildp_trail_id", $id);
		$this->db->where_in("ildp_trail_status", array(-1, 2));
		$this->db->where_in("ildp_trail_user", $userids);
		$this->db->join("user", "ildp_trail_user = user_id");	
		$q = $this->db->get("ildp_form_trail");	
		
		if ($q->num_rows() == 0) 
		{
			redirect(base_url());
		}
		
		$row = $q->row();		
		$json = json_decode($row->ildp_trail_comments);
		
		$this->mysmarty->assign("ildpperiod", $json->ildp_form_ildp_period);
		
		$rowuser = $q->row_array();
		$this->mysmarty->assign("trainee", $rowuser);
		
		$this->db->where("jabatan_id", $rowuser["user_jabatan"]);
		$q = $this->db->get("jabatan");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$rowjabatan = $q->row();
		$groups = array();
		$this->levelmodel->getparentlevelgroups($rowjabatan->jabatan_level_group, &$groups);
		
		// detail
		
		$this->mysmarty->assign("groups", array_reverse($groups));
		$this->mysmarty->assign("job", $rowjabatan);
		
		$this->mysmarty->assign("lildp_form_title", $this->config->item("lildp_form_title"));
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("ljob_title", $this->config->item("ljob_title"));
		$this->mysmarty->assign("ldepartment", $this->config->item("department"));
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
		$this->mysmarty->assign("lunit", $this->config->item("unit"));
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		$this->mysmarty->assign("searchurl", site_url()."/ildpapprovalhist/catalog/".$id);
		
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildpform/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
		
	}
	
	function catalog($id)
	{
		$this->db->where("ildp_trail_id", $id);
		$this->db->join("user", "ildp_trail_user = user_id");
		$q = $this->db->get("ildp_form_trail");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		$row->data = json_decode($row->ildp_trail_comments);
		
		// non others
		
		$this->db->order_by("ildp_category_order", "asc");
		$this->db->order_by("ildp_detail_timeline", "asc");
		$this->db->order_by("dev_area_title", "asc");
		
		$this->db->order_by("ildp_detail_trail_id", "asc");
		
		$this->db->where("ildp_detail_trail_ildp_id", $id);
		$this->db->where("ildp_detail_trail_category_id <>", 0);
		$this->db->join("ildp_detail_trail", "ildp_trail_id = ildp_detail_trail_ildp_id");
		//$this->db->join("ildp_catalog", "ildp_catalog_id = ildp_detail_trail_category_id",'left outer');
		$this->db->join("ildp_category", "ildp_category_id = ildp_detail_trail_category_id",'left outer');
		$this->db->join("ildp_method", "ildp_detail_trail_method_id = ildp_method_id");
		$this->db->join("ildp_development_area", "dev_area_id = ildp_detail_devarea and ildp_category_areadev_type = 1", "left outer");
	
	
		$q = $this->db->get("ildp_form_trail");
		//echo $this->db->last_query();
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_detail_budget_fmt = number_format($rows[$i]->ildp_detail_trail_budget, 0, "", ".");
			$ildpcatalogs[$rows[$i]->ildp_category_name][] = $rows[$i];
		}	
		
		// others

		$this->db->order_by("ildp_detail_trail_id", "asc");
		$this->db->select("*, ildp_detail_others ildp_catalog_training");
		$this->db->where("ildp_detail_trail_category_id", 0);
		$this->db->where("ildp_trail_id", $id);
		$this->db->join("ildp_detail_trail", "ildp_trail_id = ildp_detail_trail_ildp_id");
		$this->db->join("ildp_method", "ildp_detail_trail_method_id = ildp_method_id");
		$q = $this->db->get("ildp_form_trail");
		
		$rowothers = $q->result();
		for($i=0; $i < count($rowothers); $i++)
		{
			$rowothers[$i]->ildp_detail_budget_fmt = number_format($rowothers[$i]->ildp_detail_trail_budget, 0, "", ".");
			
			$ildpcatalogs["Others"][] = $rowothers[$i];
		}

		$this->mysmarty->assign("ildpcatalogs", $ildpcatalogs);
		$this->mysmarty->assign("isperiod", false);
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lildp_form_header", $this->config->item("lildp_form_header"));
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
		$this->mysmarty->assign("lrealization", $this->config->item("lrealization"));
		$this->mysmarty->assign("lbudget", $this->config->item("lbudget"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));				
		$this->mysmarty->assign("lreject_reason", $this->config->item("lreject_reason"));				
		
		$laststatus = "";
		$rejectreason = "";
		switch($row->ildp_trail_status)
		{
			case -1:
				$this->db->where("user_id", $row->data->update->ildp_form_rejector);
				$q = $this->db->get("user");
				$rejector = $q->row();
				
				$laststatus = sprintf($this->config->item("lrejected_by"), $rejector->user_first_name." ".$rejector->user_last_name, $rejector->user_npk);
				$rejectreason = $row->data->update->ildp_form_rejected_reason;
			break;
			case 2:
				$this->db->where("user_id", $row->data->update->ildp_approved_by);
				$q = $this->db->get("user");
				$approver = $q->row();

				$laststatus = $this->config->item("lapproved_by")." ".$approver->user_first_name." ".$approver->user_last_name." (".$approver->user_npk.") ";
			break;
		}
		
		$this->mysmarty->assign("laststatus", $laststatus);
		$this->mysmarty->assign("rejectreason", $rejectreason);
		
		
		if($row->data){
				$rowform->ildp_form_short_term = $row->data->ildp_form_short_term;
				$rowform->ildp_form_long_term = $row->data->ildp_form_long_term;
		}	
		
		$this->mysmarty->assign("rowform", isset($rowform)?$rowform:false);
			
		$html = $this->mysmarty->fetch("ildpform/view.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
