<?php
include_once "base.php"; 

class ILDPHist extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPHist()
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
				
		$this->mysmarty->assign("lmy_ildp_form", $this->config->item("lmy_ildp_form"));
		$this->mysmarty->assign("lheader_my_ildp_form", $this->config->item("lheader_my_ildp_form"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildphist/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
		
	function search()
	{			
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		
		$this->db->select("ildp_form.*, owner.*
			, approver.user_first_name approver_first_name, approver.user_last_name approver_last_name
			, rejector.user_first_name rejector_first_name, rejector.user_last_name rejector_last_name, rejector.user_npk rejector_user_npk
		");		
		$this->db->limit($limit, $offset);
		$this->db->order_by($sortby, $orderby);
		$this->db->where("ildp_user_id", $this->sess['user_id']);
		$this->db->join("user approver", "ildp_approved_by = approver.user_id", "left outer");	
		$this->db->join("user owner", "ildp_user_id = owner.user_id", "left outer");	
		$this->db->join("user rejector", "ildp_form_rejector = rejector.user_id", "left outer");
		$q = $this->db->get("ildp_form");	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_period_start_t = date("d/m/Y", dbmaketime($rows[$i]->ildp_period_start));
			$rows[$i]->ildp_form_rejected_reason = nl2br(stripslashes($rows[$i]->ildp_form_rejected_reason));
			$rows[$i]->ildp_comments = nl2br(stripslashes($rows[$i]->ildp_comments));
			
			switch($rows[$i]->ildp_status)
			{
				case 0:
					if ($rows[$i]->ildp_form_rejector)
					{
						$rows[$i]->laststatus = sprintf($this->config->item("lrejected_by"), $rows[$i]->rejector_first_name." ".$rows[$i]->rejector_last_name, $rows[$i]->rejector_user_npk);
						$rows[$i]->lastcomment = $rows[$i]->ildp_form_rejected_reason;
					}
					else
					{
						$rows[$i]->laststatus = $this->config->item("ldraft");
					}
				break;
				case 1:
					$grade = $this->ildpregmodel->getEligableGrade();
					$managerids = $this->ildpregmodel->getAllManager(true);
					
					$manager = "";
					
					$this->db->where_in("user_npk", $managerids);
					$this->db->where("user_grade_code >=", $grade);
					$q = $this->db->get("user");
									
					$rowmanagers = $q->result();
					for($j=0; $j < count($managerids); $j++)
					{
						if ($j > 0 && $rowmanagers[$j]->user_npk)
						{
							$manager .= ", ";
						}
						
						if($rowmanagers[$j]->user_npk)
							$manager .= $rowmanagers[$j]->user_first_name." ".$rowmanagers[$j]->user_last_name." (".$rowmanagers[$j]->user_npk.")";
					}					
					
					$rows[$i]->laststatus = sprintf($this->config->item("lwaiting_approve_by"), $manager);
				break;
				case 2:
					$rows[$i]->laststatus = $this->config->item("lapproved_by")." ".$rows[$i]->approver_first_name." ".$rows[$i]->approver_last_name;
					$rows[$i]->lastcomment = $rows[$i]->ildp_comments;
				break;
			}
		}

		$this->db->where("ildp_user_id", $this->sess['user_id']);
		$total = $this->db->count_all_results("ildp_form");	
		
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
		$this->pagination1->lang_title = $this->config->item('period');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;
		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);
		
		$this->mysmarty->assign("lcomment", $this->config->item("lcomment"));
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("iseligablegrade", $this->ildpregmodel->isEligableGrade());
						
		$html = $this->mysmarty->fetch("ildphist/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
	
	function devareapatch()
	{
		$this->db->where("ildp_detail_devarea", "");
		$this->db->join("ildp_form_trail", "ildp_trail_id = ildp_detail_trail_ildp_id");
		$q = $this->db->get("ildp_detail_trail");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trails[$rows[$i]->ildp_trail_ildp_id][$rows[$i]->ildp_detail_trail_category_id][$rows[$i]->ildp_detail_trail_method_id][$rows[$i]->ildp_detail_others] = $rows[$i];						
		}
		
		if (! isset($trails)) 
		{
			exit("no trails data witdh dev area empt");
		}

		$this->db->distinct();
		$this->db->where("ildp_detail_devarea <>", "");
		$this->db->select("ildp_detail_ildp_id, ildp_detail_category_id, ildp_detail_method_id, ildp_detail_others, ildp_detail_devarea");
		$q = $this->db->get("ildp_detail");
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (! isset($trails[$rows[$i]->ildp_detail_ildp_id][$rows[$i]->ildp_detail_category_id][$rows[$i]->ildp_detail_method_id][$rows[$i]->ildp_detail_others])) continue;
			
			$trail = $trails[$rows[$i]->ildp_detail_ildp_id][$rows[$i]->ildp_detail_category_id][$rows[$i]->ildp_detail_method_id][$rows[$i]->ildp_detail_others];
			
			unset($values); 
			
			printf("update: %d %s\n", $trail->ildp_detail_trail_id, $rows[$i]->ildp_detail_devarea);
			
			$values['ildp_detail_devarea'] = $rows[$i]->ildp_detail_devarea;
			
			$this->db->where("ildp_detail_trail_id",  $trail->ildp_detail_trail_id);
			$this->db->update("ildp_detail_trail", $values);
		}

	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
