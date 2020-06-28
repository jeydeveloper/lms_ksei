<?php
include_once "base.php"; 

class ILDPQueue extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPQueue()
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
		$this->langmodel->init();
		
		if(!$this->modules['ildpadmin']){
			redirect('user');
			exit;
		} 		
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		
	}
		
	function index($topicid=0, $referer="", $userid=0)
	{				
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("limit", $recordperpage);
				
		$this->mysmarty->assign("lildp_form", $this->config->item("lildp_form"));
		$this->mysmarty->assign("lheader_my_ildp_form", $this->config->item("lheader_my_ildp_form"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpqueue/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
		
	function search($offset=0)
	{			
		$ildpperiod = $this->ildpregmodel->IsPeriod();
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "owner.user_npk";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "owner.user_npk";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		
		/*if ($ildpperiod == FALSE)
		{
			//$this->db->where_in("ildp_id", 0);
		}
		else
		{*/
		//	$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
		//	$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		//}
		
		$this->db->select("ildp_form.*, owner.*
			, approver.user_first_name approver_first_name, approver.user_last_name approver_last_name
			, rejector.user_first_name rejector_first_name, rejector.user_last_name rejector_last_name, rejector.user_npk rejector_npk
		");			
		
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where("ildp_status >=", 1);
		$this->db->join("user owner", "ildp_user_id = owner.user_id");
		$this->db->join("user approver", "ildp_approved_by = approver.user_id", "left outer");	
		$this->db->join("user rejector", "ildp_form_rejector = rejector.user_id", "left outer");		
		$this->db->from("ildp_form");
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->get();
		
		$rows = $q->result();
		//echo $this->db->last_query();
		//echo "<BR><BR>";
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_period_start_t = date("d/m/Y", dbmaketime($rows[$i]->ildp_period_start));
			
			switch($rows[$i]->ildp_status)
			{
				case 0:
					if ($rows[$i]->ildp_form_rejector)
					{
						$rows[$i]->laststatus = sprintf($this->config->item("lrejected_by"), $rows[$i]->rejector_first_name." ".$rows[$i]->rejector_last_name, $rows[$i]->rejector_npk);
					}
					else
					{
						$rows[$i]->laststatus = $this->config->item("ldraft");
					}
				break;
				case 1:
					$grade = $this->ildpregmodel->getEligableGrade();
					$managerids = $this->ildpregmodel->getAllManager(true, $rows[$i]->user_npk);
					
					$manager = "";
					
					$this->db->where_in("user_npk", $managerids);
					$this->db->where("user_grade_code >=", $grade);
					$q = $this->db->get("user");
									
					$rowmanagers = $q->result();
					for($j=0; $j < count($rowmanagers); $j++)
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
				break;
			}
		}

		/*if ($ildpperiod == FALSE)
		{
			//$this->db->where_in("ildp_id", 0);
		}
		else
		{
			$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
			$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		}*/

		$this->db->from("user owner");		
		$this->db->where("ildp_status >=", 1);
		$this->db->join("ildp_form", "ildp_user_id = owner.user_id");
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$total = $this->db->count_all_results();	
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
		$this->pagination1->lang_title = $this->config->item('lildp_form');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);
		
		$this->mysmarty->assign("lempty_select_ildp_form", $this->config->item("lempty_select_ildp_form"));
		$this->mysmarty->assign("lconfirm_ildp_reset", $this->config->item("lconfirm_ildp_reset"));
		$this->mysmarty->assign("lreset", $this->config->item("lreset"));
		$this->mysmarty->assign("lsubmitdate", $this->config->item("lsubmitdate"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("iseligablegrade", $this->ildpregmodel->isEligableGrade());
						
		$html = $this->mysmarty->fetch("ildpqueue/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
		
	function doreset()
	{
		$users = isset($_POST['user']) ? $_POST['user'] : "";
		
		if (! is_array($users))
		{
			$callback['error'] = true;
			$callback['message'] = "ILDP Form is empty";
			
			echo json_encode($callback);
			return;
		}

		if (count($users) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = "ILDP Form is empty";
			
			echo json_encode($callback);
			return;
		}

		$update['ildp_status'] = 0;

		$this->db->where_in("ildp_id", $users);
		$this->db->update("ildp_form", $update);
		
		for($i=0; $i < count($users); $i++)
		{
			unset($insert);
			
			$insert['ildp_trail_user'] = $this->sess['user_id'];
			$insert['ildp_trail_ildp_id'] = $users[$i];
			$insert['ildp_trail_status'] = 0;
			$insert['ildp_trail_created_time'] = date("Y-m-d H:i:s");
			$insert['ildp_trail_comments'] = "reset";
		}

		$this->db->where_in("ildp_detail_ildp_id", $users);
		$q = $this->db->get("ildp_detail");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			unset($insert);
			
			$insert['ildp_detail_trail_ildp_id'] = $rows[$i]->ildp_detail_ildp_id;
			$insert['ildp_detail_trail_method_id'] = $rows[$i]->ildp_detail_method_id;
			$insert['ildp_detail_trail_budget'] = $rows[$i]->ildp_detail_budget;
			$insert['ildp_detail_timeline'] = $rows[$i]->ildp_detail_timeline;
			$insert['ildp_detail_devarea'] = $rows[$i]->ildp_detail_devarea;
			
			if ($rows[$i]->ildp_detail_category_id)
			{
				$insert['ildp_detail_trail_category_id'] = $rows[$i]->ildp_detail_category_id;
				$insert1['ildp_detail_others'] = "";
			}
			else
			{
				$insert['ildp_detail_trail_category_id'] = 0;
				$insert1['ildp_detail_others'] = $rows[$i]->ildp_detail_category_id;
			}
			
			$insert['ildp_detail_trail_created_by'] = $this->sess['user_id'];
			$insert['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert("ildp_detail_trail", $insert);			
		}

		$this->db->where_in("ildp_id", $users);
		$this->db->join("user", "user_id = ildp_user_id");
		$q = $this->db->get("ildp_form");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if (! valid_email($rows[$i]->user_email)) continue;
			
			$subject = $this->config->item("lsubject_resetform");
			
			$this->mysmarty->assign("user", $rows[$i]);
			$message = $this->mysmarty->fetch("ildpqueue/resetformemail.html");
		}

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lildp_resetform_successfully");
		
		echo json_encode($callback);
		return;
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
