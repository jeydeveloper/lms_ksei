<?php
include_once "base.php"; 

class ILDPApproval extends Base{
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPApproval()
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
				
		$this->mysmarty->assign("lildp_approval", $this->config->item("lildp_approval"));
		$this->mysmarty->assign("lheader_approval_list", $this->config->item("lheader_approval_list"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildpapproval/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
		
	function search()
	{			
		$ildpperiod = $this->ildpregmodel->IsPeriod();
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "owner.user_npk";
		
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "owner.user_npk";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		
		$userids = $this->ildpregmodel->getAllBawahan();
		
		/*if ($ildpperiod == FALSE)
		{
			//$this->db->where_in("ildp_id", 0);
		}
		else
		{
			$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
			$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		}
		*/
		$this->db->select("ildp_form.*, owner.*
			, approver.user_first_name approver_first_name, approver.user_last_name approver_last_name
			, rejector.user_first_name rejector_first_name, rejector.user_last_name rejector_last_name, rejector.user_npk rejector_user_npk
		");			
		$this->db->limit($limit, $offset);
		$this->db->where_in("ildp_user_id", $userids);
		$this->db->where("ildp_status", 1);
		$this->db->join("user owner", "ildp_user_id = owner.user_id");
		$this->db->join("user approver", "ildp_approved_by = approver.user_id", "left outer");	
		$this->db->join("user rejector", "ildp_form_rejector = rejector.user_id", "left outer");		
		$this->db->order_by($sortby, $orderby);
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$q = $this->db->get("ildp_form");
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_period_start_t = date("d/m/Y H:i:s", dbmaketime($rows[$i]->ildp_period_start));
			
			switch($rows[$i]->ildp_status)
			{
				case 0:
					if ($rows[$i]->ildp_form_rejector)
					{
						$rows[$i]->laststatus = sprintf($this->config->item("lrejected_by"), $rows[$i]->rejector_first_name." ".$rows[$i]->rejector_last_name, $rows[$i]->rejector_user_npk);
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
				break;
			}
		}

		if ($ildpperiod == FALSE)
		{
			//$this->db->where_in("ildp_id", 0);
		}
		else
		{
			$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
			$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		}

		$this->db->where("ildp_status", 1);
		$this->db->where_in("user_npk", $userids);
		$this->db->join("ildp_form", "ildp_user_id = user_id");		
		$this->db->from("user owner");
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$total = $this->db->count_all_results();	
		
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
		
		$this->mysmarty->assign("lsubmitdate", $this->config->item("lsubmitdate"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("iseligablegrade", $this->ildpregmodel->isEligableGrade());
						
		$html = $this->mysmarty->fetch("ildpapproval/list.html");
		
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

		$this->mysmarty->assign("ladd_ildp_reg_period", $this->config->item("ladd_ildp_reg_period"));
				
		$this->mysmarty->assign("lstart_period", $this->config->item("lstart_period"));
		$this->mysmarty->assign("lconfirm_ildp_catalog_save", $this->config->item("lconfirm_ildp_catalog_save"));
		$this->mysmarty->assign("lsave", $this->config->item("lsave"));
		$this->mysmarty->assign("lend_period", $this->config->item("lend_period"));
		$this->mysmarty->assign("lconfirm_reset_data", $this->config->item("lconfirm_reset_data"));
		$this->mysmarty->assign("months", $this->config->item("lmonths"));
		$this->mysmarty->assign("monthnow", date("n"));
		$this->mysmarty->assign("yearnow", date("Y"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpregperiod/form.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function save()
	{

		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$reason = isset($_POST['reason']) ? $_POST['reason'] : "";
		$status = isset($_POST['status']) ? $_POST['status'] : "";
		
		if (! $this->ildpregmodel->isEligableGrade())
		{
			$callback['error'] = true;
			$callback['message'] = "Access denied";
			
			echo json_encode($callback);
			return;			
		}
		
		if (strlen($id) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = "Form ID is empty.";
			
			echo json_encode($callback);
			return;
		}

		if (strlen($status) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = "Invalid status";
			
			echo json_encode($callback);
			return;
		}

		if (strlen($reason) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_reason");
			
			echo json_encode($callback);
			return;
		}
		
		$bawahan = $this->ildpregmodel->getAllBawahan();
		
		$this->db->where("ildp_id", $id);
		$this->db->where("ildp_status", 1);
		$this->db->where_in("user_id", $bawahan);
		$this->db->join("user", "user_id = ildp_user_id");
		$q = $this->db->get("ildp_form");
		
		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = "Invalid data";
			
			echo json_encode($callback);
			return;
		}
		
		$row = $q->row();

		/*if ($this->sess['user_grade_code'] <= $row->user_grade_code)
		{
			$callback['error'] = true;
			$callback['message'] = "Access denied";
			
			echo json_encode($callback);
			return;			
		}		*/

		$callback['error'] = false;
		
		unset($update);
		
		$update['ildp_status'] = $status;
				
		if ($status == 0)
		{
			$update['ildp_form_rejector'] = $this->sess['user_id'];
			$update['ildp_form_rejected'] = date("Y-m-d H:i:s");
			$update['ildp_form_rejected_reason'] = $reason;
			$update['ildp_modified_by'] = $this->sess['user_id'];
			$update['ildp_modified_time'] = date("Y-m-d H:i:s");
			
			$callback['message'] = $this->config->item("lorder_rejected");			
		}
		else
		{
			$update['ildp_approved_by'] = $this->sess['user_id'];
			$update['ildp_approved_time'] = date("Y-m-d H:i:s");
			$update['ildp_comments'] = $reason;
			$update['ildp_modified_by'] = $this->sess['user_id'];
			$update['ildp_modified_time'] = date("Y-m-d H:i:s");
			
			$callback['message'] = $this->config->item("lorder_approved");			
		}
		
		$this->db->where("ildp_id", $id);
		$this->db->update("ildp_form", $update);
			
		unset($insert);
		
		$row->update = $update;
		
		$insert['ildp_trail_user'] = $row->user_id;
		$insert['ildp_trail_ildp_id'] = $id;
		$insert['ildp_trail_status'] = ($status == 0) ? -1 : $status;
		$insert['ildp_trail_created_time'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_comments'] = json_encode($row);
		
		$this->db->insert("ildp_form_trail", $insert);
		$ildptrailid = $this->db->insert_id();
		
		$this->db->where("ildp_detail_ildp_id", $id);
		$q = $this->db->get("ildp_detail");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			unset($insert);
			
			$insert['ildp_detail_trail_ildp_id'] = $ildptrailid;
			$insert['ildp_detail_trail_method_id'] = $rows[$i]->ildp_detail_method_id;
			$insert['ildp_detail_trail_budget'] = $rows[$i]->ildp_detail_budget;
			$insert['ildp_detail_timeline'] = $rows[$i]->ildp_detail_timeline;
			$insert['ildp_detail_devarea'] = $rows[$i]->ildp_detail_devarea;
			
			if ($rows[$i]->ildp_detail_category_id)
			{
				$insert['ildp_detail_trail_category_id'] = $rows[$i]->ildp_detail_category_id;
				$insert['ildp_detail_others'] = "";
			}
			else
			{
				$insert['ildp_detail_trail_category_id'] = 0;
				$insert['ildp_detail_others'] = $rows[$i]->ildp_detail_others;
			}
			
			$insert['ildp_detail_trail_created_by'] = $this->sess['user_id'];
			$insert['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert("ildp_detail_trail", $insert);			
		}
		
		if ($status == 0)
		{
			$subject = $this->config->item("lsubject_rejected");
			$this->mysmarty->assign("reason", nl2br($reason));
			$this->mysmarty->assign("row", $row);
			
			$message = $this->mysmarty->fetch("ildpapproval/rejectedemail.html");			

			if (valid_email($row->user_email))
			{
				//$this->commonmodel->sendmail($row->user_email, $subject, $message);
			}
			
			echo json_encode($callback);
			
			return;
		}

		// cari hrrm
		
		$this->db->where("jabatan_id", $row->user_jabatan);
		$this->db->join("level_group", "level_group_id = jabatan_level_group");
		$q = $this->db->get("jabatan");
		if ($q->num_rows() > 0)
		{
			$rowjabatan = $q->row();
			$groups = array(0);
			$this->levelmodel->getparentlevelgroupids($rowjabatan->level_group_id, &$groups);
			
			$this->db->where("hrrm_npk <>", $this->sess['user_id']);
			$this->db->where("hrrm_npk <>", $row->user_id);
			$this->db->where("hrrm_status", 1);
			$this->db->where_in("hrrm_group", $groups);
			$this->db->join("user", "user_id = hrrm_npk");
			$q = $this->db->get("hrrm");
			
			$rowhrrms = $q->result();
		}
		
		// email ke trainee
		
		$subject = $this->config->item("lsubject_approved_complete");
		$this->mysmarty->assign("reason", $reason);
		$this->mysmarty->assign("row", $row);
		
		$message = $this->mysmarty->fetch("ildpapproval/completemail.html");
			
		if (valid_email($row->user_email))
		{
			//$this->commonmodel->sendmail($row->user_email, $subject, $message);
		}
		
		// email ke hrrm
		
		if (isset($rowhrrms))
		{
			$userInfo = $this->usermodel->getUserInfo($this->sess['user_id']);
			$employee_name = $row->user_first_name." ".$row->user_last_name." (".$row->user_npk.")";
			
			for ($i=0; $i < count($rowhrrms); $i++)
			{			
				if (! valid_email($rowhrrms[$i]->user_email))
				{
					continue;
				}
				
				//-- get subject
				$subject = sprintf($this->config->item("lsubject_approved_complete_for_hrrm"), $employee_name);
				$this->mysmarty->assign("row", $row);
				$this->mysmarty->assign("hrrm", $rowhrrms[$i]);
				$message = $this->mysmarty->fetch("ildpapproval/completemail_for_hrrm.html");
				
				//$this->commonmodel->sendmail($rowhrrms[$i]->user_email, $subject, $message);
			}
		}
		
		echo json_encode($callback);
	}	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
