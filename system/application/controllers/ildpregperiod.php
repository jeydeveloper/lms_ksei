<?php
include_once "base.php"; 

class ILDPRegPeriod extends Base{
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPRegPeriod()
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
				
		$this->mysmarty->assign("lildp_registration_period", $this->config->item("lildp_registration_period"));
		$this->mysmarty->assign("lheader_ildp_registration_period", $this->config->item("lheader_ildp_registration_period"));
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpregperiod/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
		
	function search($offset=0, $act="", $worksheet=null)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
						
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "ildp_registration_period_start";
				
		$this->db->limit($limit, $offset);
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->get("ildp_registration_period");
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_registration_period_status_image = '<img src="'.base_url().'images/16/'.(($rows[$i]->ildp_registration_period_status != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($rows[$i]->ildp_registration_period_status != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($rows[$i]->ildp_registration_period_status != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
			$rows[$i]->ildp_registration_period_start_t = date("M Y", dbmaketime($rows[$i]->ildp_registration_period_start));
			$rows[$i]->ildp_registration_period_end_t = date("M Y", dbmaketime($rows[$i]->ildp_registration_period_end));
		}
		
		$total = $this->db->count_all_results("ildp_registration_period");	
		
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
		
		$this->mysmarty->assign("lstart_period", $this->config->item("lstart_period"));
		$this->mysmarty->assign("lend_period", $this->config->item("lend_period"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
						
		$html = $this->mysmarty->fetch("ildpregperiod/list.html");
		
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
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));		
		$this->mysmarty->assign("monthnow", date("n"));
		$this->mysmarty->assign("yearnow", date("Y"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpregperiod/form.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function save($id=0)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}

		$month1 = isset($_POST['month1']) ? $_POST['month1'] : "";
		$year1 = isset($_POST['year1']) ? $_POST['year1'] : "";
		$month2 = isset($_POST['month2']) ? $_POST['month2'] : "";
		$year2 = isset($_POST['year2']) ? $_POST['year2'] : "";
		$year3 = isset($_POST['year2']) ? $_POST['year3'] : "";
		
		if (strlen($year1) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}

		if (! is_numeric($year1))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($year2) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}

		if (! is_numeric($year2))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($year3) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}

		if (! is_numeric($year3))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}
		
		$t1 = mktime(0, 0, 0, $month1, 1, $year1);
		
		//get end date of the month
		$t2_1 = mktime(0, 0, 0, $month2, 1, $year2);
		$t2 = mktime(23, 59, 59, $month2, date('t',$t2_1), $year2);
		if ($t1 > $t2)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
			
			echo json_encode($callback);
			return;
		}
		
		$sql = sprintf("SELECT COUNT(*) tot
				FROM %sildp_registration_period
				WHERE (
							(
									(ildp_registration_period_start >= '%s')
								AND (ildp_registration_period_start <= '%s')
							)
							OR
							(
									(ildp_registration_period_end >= '%s')
								AND (ildp_registration_period_end <= '%s')
							)
						AND ildp_registration_period_status = '1'
			)

		", $this->db->dbprefix, date("Y-m-d H:i:s", $t1), date("Y-m-d H:i:s", $t2), date("Y-m-d H:i:s", $t1), date("Y-m-d H:i:s", $t2));
		
		$q = $this->db->query($sql);
		$rowtotal = $q->row();
		
		if($rowtotal->tot > 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_ildp_regperiod");
				
			echo json_encode($callback);
			return;
		}

		unset($insert);
		
		$insert['ildp_registration_period_start'] = date("Y-m-d H:i:s", $t1);
		$insert['ildp_registration_period_end'] = date("Y-m-d H:i:s", $t2);
		$insert['ildp_registration_period_creator'] = $this->sess['user_id'];
		$insert['ildp_registration_period_created'] = date("Y-m-d H:i:s");
		$insert['ildp_registration_period_modifier'] = $this->sess['user_id'];
		$insert['ildp_registration_period_modified'] = date("Y-m-d H:i:s");
		$insert['ildp_registration_period_status'] = 1;
		$insert['ildp_registration_period_ildp'] = $year3;

		$this->db->insert("ildp_registration_period", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lsuccess_create_ildp_regperiod");
			
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
				
		$data['ildp_registration_period_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("ildp_registration_period_id", $id);
		$this->db->update("ildp_registration_period", $data);				
		
		$callback['error'] = false;
		
		$statusdesc = ($data['ildp_registration_period_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active");
		$statusimage = '<img src="'.base_url().'images/16/'.(($data['ildp_registration_period_status'] != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($data['ildp_registration_period_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($data['ildp_registration_period_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
		
		$callback['newstatus'] = sprintf("<a href='#' onclick='javascript: chagestatus(%d, %d)'>%s</a>", $id, $data['ildp_registration_period_status'], $statusimage);
		
		echo json_encode($callback);
	}
	
	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("ildp_registration_period_id", $id);
		$this->db->delete("ildp_registration_period");
		
		redirect(site_url()."/ildpregperiod");
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
