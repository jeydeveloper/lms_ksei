<?php
include_once "base.php"; 

class ILDPForm extends Base{
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPForm()
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
		$this->load->model("ildpregmodel");
		$this->load->model("generalsettingmodel");
		
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

		if (isset($this->sess->asadmin) && $this->sess->asadmin)
		{
			redirect('user');
			exit;
		} 		
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		
		$this->langmodel->init();
	}
	
	function isvalidapproval($formid)
	{
		$this->db->where("ildp_id", $formid);
		$this->db->join("user", "user_id = ildp_user_id");
		$q = $this->db->get("ildp_form");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row_array();
		
		if ($this->sess['asadmin'])
		{
			return $row;
		}
		
		if ($row['user_id'] == $this->sess['user_id'])
		{
			return $row;
		}
		
		$bawahan = $this->ildpregmodel->getAllBawahan();
		$userhrrms = $this->ildpregmodel->getUserHRRM();
		
		$bawahan = array_unique(array_merge($bawahan, $userhrrms));

		if (! in_array($row['user_id'], $bawahan))
		{
			redirect(base_url());
		}
				
		return $row;
	}
		
	function index($formid=0)
	{		
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
				
		if ($formid)
		{
			// ini adalah proses approve
			
			$rowuser = $this->isvalidapproval($formid);
			$this->mysmarty->assign("trainee", $rowuser);
			$this->mysmarty->assign("formid", $formid);
		}
		else
		{
			$rowuser = $this->sess;
			$this->mysmarty->assign("trainee", $rowuser);
		}
		
		$this->db->where("grade_code", $rowuser["user_grade_code"]);
		$q = $this->db->get("grade");
		
		if ($q->num_rows() > 0)
		{
			$rowgrade = $q->row();
			$this->mysmarty->assign("grade", $rowgrade);		
		}
				
		$this->db->where("jabatan_id", $rowuser["user_jabatan"]);
		$q = $this->db->get("jabatan");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$rowjabatan = $q->row();
		$groups = array();
		$this->levelmodel->getparentlevelgroups($rowjabatan->jabatan_level_group, $groups);
		
		$this->mysmarty->assign("groups", array_reverse($groups));
		$this->mysmarty->assign("job", $rowjabatan);
		
		if ($formid)
		{
			$this->mysmarty->assign("ildpperiod", $rowuser['ildp_form_ildp_period']);
		}
		else
		{
			$ildpperiod = $this->ildpregmodel->IsPeriod();
			
			if ($ildpperiod === FALSE)
			{
				$this->mysmarty->assign("ildpperiod", "-");
			}
			else	
			{
				$this->mysmarty->assign("ildpperiod", $ildpperiod->ildp_registration_period_ildp);
			}
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("lildp_form_title", $this->config->item("lildp_form_title"));
		
		//-- get first and second level label		
		$rs_level = $this->levelmodel->getLevel();
		
		$this->mysmarty->assign("ldirectorat", ucfirst($rs_level[0]->level_name));
		$this->mysmarty->assign("lgroup", ucfirst($rs_level[1]->level_name));
		
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("ljob_title", $this->config->item("ljob_title"));
		$this->mysmarty->assign("ldepartment", $this->config->item("department"));
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
		$this->mysmarty->assign("lunit", $this->config->item("unit"));
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));

		if (isset($this->sess['asadmin']) && $this->sess['asadmin'])
		{
			$this->mysmarty->assign("left_content", "ildp/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}
		
		$this->mysmarty->assign("main_content", "ildpform/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search($act="", $formid=0)
	{
		if ($formid)
		{
			$rowuser = $this->isvalidapproval($formid);
			$year = $rowuser['ildp_form_ildp_period'];
			$userid = $rowuser['ildp_user_id'];
		}
		else
		{
			$ildpperiod = $this->ildpregmodel->IsPeriod();
			
			if ($ildpperiod === FALSE)
			{
				$callback['html'] = $this->config->item("lnot_regperiod");
				echo json_encode($callback);
				
				return;
			}

			$year = $ildpperiod->ildp_registration_period_ildp;
			$userid = $this->sess['user_id'];
		}
		
		$this->db->where("ildp_user_id", $userid);
		$this->db->where("ildp_form_ildp_period", $year);
		$q = $this->db->get("ildp_form");
		//echo $this->db->last_query();
		if ($q->num_rows() == 0)
		{		
			if ($act == "edit")
			{
				$this->form($year, $userid);
				return;
			}
			
			$this->draftform($year, $userid, $formid);
			return;			
		}
		
		$row = $q->row();
		
		if (($row->ildp_status == 0) || ($row->ildp_status == 2))
		{
			if ($act == "edit")
			{
				$this->form($year, $userid);
				return;
			}
			
			$this->draftform($year, $userid, $formid);
			return;
		}
		
		$this->draftform($year, $userid, $formid);
	}
	
	function draftform($year, $userid, $formid)
	{
		/// ildp form data

		$this->db->select("ildp_form.*, owner.*
			, approver.user_first_name approver_first_name, approver.user_last_name approver_last_name, approver.user_npk approver_user_npk
			, rejector.user_first_name rejector_first_name, rejector.user_last_name rejector_last_name, rejector.user_npk rejector_user_npk
		");
		$this->db->where("ildp_user_id", $userid);
		$this->db->where("ildp_form_ildp_period", $year);		
		$this->db->join("user approver", "ildp_approved_by = approver.user_id", "left outer");	
		$this->db->join("user rejector", "ildp_form_rejector = rejector.user_id", "left outer");		
		$this->db->join("user owner", "ildp_user_id = owner.user_id");
		$q = $this->db->get("ildp_form");
		
		$this->mysmarty->assign("formid", 0);
			
		if ($q->num_rows())
		{
			$rowform = $q->row();
			
			$t = dbmaketime($rowform->ildp_period_start);
			
			$this->mysmarty->assign("submitted_date", date("d-m-Y", $t));
			$this->mysmarty->assign("formid", $rowform->ildp_id);
			
			//if ($this->sess['user_id'] == $rowform->ildp_user_id)
			if (true)
			{				
				switch($rowform->ildp_status)
				{
					case 1:
						$grade = $this->ildpregmodel->getEligableGrade();
						$managerids = $this->ildpregmodel->getAllManager(true, $rowform->user_npk);
						
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
						
						$this->mysmarty->assign("laststatus", sprintf($this->config->item("lwaiting_approve_by"), $manager));
					break;
					case 2:
						$this->mysmarty->assign("laststatus", $this->config->item("lapproved_by")." ".$rowform->approver_first_name." ".$rowform->approver_last_name." (".$rowform->approver_user_npk.")");
						$this->mysmarty->assign("ildp_comments", $rowform->ildp_comments);
					break;
					case 0:
						if ($rowform->rejector_user_npk)
						{
							$this->mysmarty->assign("laststatus", sprintf($this->config->item("lrejected_by"), $rowform->rejector_first_name." ".$rowform->rejector_last_name, $rowform->rejector_user_npk));
							$this->mysmarty->assign("rejectreason", $rowform->ildp_form_rejected_reason);
						}
					break;
				}				
			}			
		}
				
		// non others
		
		$this->db->order_by("ildp_category_order", "asc");
		$this->db->order_by("ildp_detail_timeline", "asc");
		$this->db->order_by("dev_area_title", "asc");
		$this->db->order_by("ildp_detail_id", "asc");
		
		$this->db->where("ildp_user_id", $userid);
		$this->db->where("ildp_form_ildp_period", $year);
		$this->db->join("ildp_detail", "ildp_id = ildp_detail_ildp_id",'left outer');
		//$this->db->join("ildp_catalog", "ildp_catalog_id = ildp_detail_category_id");
		$this->db->join("ildp_category", "ildp_category_id = ildp_detail_category_id",'left outer');
		$this->db->where("ildp_detail_category_id <>", 0);
		$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id",'left outer');
		$this->db->join("ildp_development_area", "dev_area_id = ildp_detail_devarea and ildp_category_areadev_type = 1", "left outer");
		$q = $this->db->get("ildp_form");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_detail_budget_fmt = number_format($rows[$i]->ildp_detail_budget, 0, "", ".");
			$ildpcatalogs[$rows[$i]->ildp_category_name][] = $rows[$i];
		}

		// others
		
		//check if others category is enable/not
		$this->db->where("ildp_category_id", 4);
		$this->db->where("ildp_category_status", 1);		
		$q = $this->db->get("ildp_category");
		$rowsothers = $q->result();
		
		if(count($rowsothers)){
			$this->db->order_by("ildp_detail_id", "asc");
			$this->db->select("*, ildp_detail_others ildp_catalog_training");
			$this->db->where("ildp_detail_category_id", 0);
			$this->db->where("ildp_user_id", $userid);
			$this->db->where("ildp_form_ildp_period", $year);		
			$this->db->join("ildp_detail", "ildp_id = ildp_detail_ildp_id",'left outer');
			$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id",'left outer');		
			$q = $this->db->get("ildp_form");
			
			$rowothers = $q->result();
			
			for($i=0; $i < count($rowothers); $i++)
			{
				$rowothers[$i]->ildp_detail_budget_fmt = number_format($rowothers[$i]->ildp_detail_budget, 0, "", ".");
				
				$ildpcatalogs["Others"][] = $rowothers[$i];
			}
		}

		$this->mysmarty->assign("isdraft", isset($rowform) && (($rowform->ildp_status == 0) || ($rowform->ildp_status == 2)));
		$this->mysmarty->assign("rowform", isset($rowform)?$rowform:false);
		
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lildp_form_header", $this->config->item("lildp_form_header"));
		$this->mysmarty->assign("lrealization", $this->config->item("lrealization"));
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
		$this->mysmarty->assign("lbudget", $this->config->item("lbudget"));		
		$this->mysmarty->assign("ildpcatalogs", isset($ildpcatalogs) ? $ildpcatalogs : false);
		$this->mysmarty->assign("rows", isset($rows) ? $rows: false);
		
		$this->mysmarty->assign("lapprove", $this->config->item("lapprove"));
		$this->mysmarty->assign("lreject", $this->config->item("lreject"));
		$this->mysmarty->assign("lreject_reason", $this->config->item("lreject_reason"));
		$this->mysmarty->assign("lcancel", $this->config->item("lcancel"));
		$this->mysmarty->assign("lempty_reason", $this->config->item("lempty_reason"));
		$this->mysmarty->assign("lconfirm_ildp_reject", $this->config->item("lconfirm_ildp_reject"));
		$this->mysmarty->assign("lconfirm_ildp_approve", $this->config->item("lconfirm_ildp_approve"));
		$this->mysmarty->assign("lapprove_desc", $this->config->item("lapprove_desc"));
		$this->mysmarty->assign("lstart_approval", $this->config->item("lstart_approval"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lreject_reason", $this->config->item("lreject_reason"));
		$this->mysmarty->assign("ldone", $this->config->item("ldone"));
		$this->mysmarty->assign("lnot_oone", $this->config->item("lnot_oone"));
		$this->mysmarty->assign("lsubmitted_ildp_form", $this->config->item("lsubmitted_ildp_form"));
		$this->mysmarty->assign("llast_edited", $this->config->item("llast_edited"));
		$this->mysmarty->assign("lnew", $this->config->item("lnew"));
		$this->mysmarty->assign("lcomments",$this->config->item('lcomment'));
		$this->mysmarty->assign("ledit",$this->config->item('ledit'));
		$this->mysmarty->assign("ltimeline",$this->config->item('ltimeline'));
		
		
		$bawahan = $this->ildpregmodel->getAllBawahan();
		
		$isperiod = $this->ildpregmodel->IsPeriod() ;
		$ildp_period_start = dbmaketime($rowform->ildp_period_start);
		
		//$iscanapprove = $formid && $this->ildpregmodel->isEligableGrade() && isset($rowform) && ($this->sess['user_grade_code'] > $rowform->user_grade_code) && in_array($rowform->user_id, $bawahan) && ($rowform->ildp_status == 1);
		$iscanapprove = $formid && $this->ildpregmodel->isEligableGrade() && isset($rowform) && in_array($rowform->user_id, $bawahan) && ($rowform->ildp_status == 1);
		$iscanapprove = $iscanapprove && ($isperiod!== FALSE);
		$iscanapprove = $iscanapprove && ($rowform->ildp_status >= 1);

		/* check if this form is submitted in this period */ 
		$isInPeriod = $iscanapprove && ($ildp_period_start >= $ildpperiod->ildp_registration_period_start_t && $ildp_period_start <= $ildpperiod->ildp_registration_period_end_t);
		
		$this->mysmarty->assign("isInPeriod", $isInPeriod);
		$this->mysmarty->assign("lout_of_ildp_period", $this->config->item('lout_of_ildp_period'));
		
		$this->mysmarty->assign("isperiod", $isperiod);
		$this->mysmarty->assign("iscanapprove", $iscanapprove);
		$this->mysmarty->assign("isowner", isset($rowform) && ($this->sess['user_id'] == $rowform->ildp_user_id));
		
		$html = $this->mysmarty->fetch("ildpform/view.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);		
	}
	
	function lastform($year)
	{			
		$this->db->where("ildp_user_id", $this->sess['user_id']);
		$this->db->where("ildp_status <>", 0);
		$this->db->where("ildp_form_ildp_period", $year);
		$q = $this->db->get("ildp_form");
		
		if ($q->num_rows() == 0)
		{
			$callback['html'] = sprintf("<font color='#ffffff'>%s</font>", $this->config->item("lerr_ildp_period"));
			echo json_encode($callback);
			return;			
		}
		
		return;
	}
	
	function form($year, $userid)
	{	
		// drafts
		
		$this->db->order_by("ildp_detail_id", "asc");			
		$this->db->where("ildp_user_id", $userid);
		$this->db->where("ildp_form_ildp_period", $year);
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id","left outer join");
		//$this->db->join("ildp_catalog", "ildp_catalog_id = ildp_detail_category_id");
		//$this->db->join("ildp_category", "ildp_catalog_category = ildp_category_id");
		$this->db->join("ildp_category", "ildp_category_id = ildp_detail_category_id","left outer join");
		$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id","left outer join");
		$q = $this->db->get("ildp_form");
		
		$rows = $q->result();
		$drafts = array();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->ildp_detail_budget_fmt = number_format($rows[$i]->ildp_detail_budget, 0, "", ".");
			$drafts[$rows[$i]->ildp_category_name][] = $rows[$i];
			//$this->mysmarty->assign("ishasapprove", $rows[$i]->ildp_status == 2);
		}
		$this->mysmarty->assign("rows", $rows);
		
		// others

		// others drafts

		$this->db->order_by("ildp_detail_id", "asc");
		$this->db->select("*, ildp_detail_others ildp_catalog_training");
		$this->db->where("ildp_detail_category_id", 0);
		$this->db->where("ildp_user_id", $userid);
		$this->db->where("ildp_form_ildp_period", $year);		
		$this->db->join("ildp_detail", "ildp_id = ildp_detail_ildp_id","left outer join");
		$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id","left outer join");
		$q = $this->db->get("ildp_form");
		
		$rowothers = $q->result();
		$draftothers = array();
		for($i=0; $i < count($rowothers); $i++)
		{
			$rowothers[$i]->ildp_detail_budget_fmt = number_format($rowothers[$i]->ildp_detail_budget, 0, "", ".");
			$draftothers[] = $rowothers[$i];
			//$this->mysmarty->assign("ishasapprove", $rowothers[$i]->ildp_status == 2);
		}
		
		$this->db->where("ildp_category_status", 1);		
		$this->db->where("ildp_category_name", "Others");
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows())
		{
			$rowother = $q->row();
			for($i=0; $i < $rowother->ildp_category_maxline; $i++)
			{
				$otherlines[$i]['no'] = $i;
				$otherlines[$i]['draft'] = isset($draftothers[$i]) ? $draftothers[$i] : "";
			}
			
			$this->mysmarty->assign("others", $rowother);
			$this->mysmarty->assign("otherlines", $otherlines);
		}
		
		// all catalog
		
		$this->db->order_by("ildp_category_order", "asc");
		$this->db->order_by("ildp_catalog_training", "asc");
		$this->db->where("ildp_catalog_grade LIKE '%,".$this->sess['user_grade_code'].",%'", null); 
		$this->db->where("ildp_catalog_status", 1);
		$this->db->where("ildp_category_status", 1); // active category
		$this->db->join("ildp_category", "ildp_category_id = ildp_catalog_category");
		$q = $this->db->get("ildp_catalog");
		//echo $this->db->last_query();
		$rows = $q->result();
		
		$ildpcatalogs = array();
		$nildpcatalogs = array();
		$maxlines = array();
		$max = 0;
		$areadevs = array();
		$devact = array();
		for($i=0; $i < count($rows); $i++)
		{
			// area development
			$this->db->where("ildp_catalog_grade LIKE '%,".$this->sess['user_grade_code'].",%'", null); 
			$this->db->where("dev_area_catalog_id", $rows[$i]->ildp_catalog_id);
			$this->db->join("ildp_catalog", "ildp_catalog_id = dev_area_catalog_id");
			$q = $this->db->get("ildp_development_area");
			$rowareadevs = $q->result();
			
			for($j=0; $j < count($rowareadevs); $j++)
			{
				$areadevs[$rowareadevs[$j]->ildp_catalog_category][] = $rowareadevs[$j];
			}
			
			//development activities
			$this->db->select("ildp_method_id,ildp_method_name,ildp_catalog_category");
			$this->db->join("ildp_catalog_method", "ildp_catalog_method_method = ildp_method.ildp_method_id");
			$this->db->join("ildp_catalog", "ildp_catalog_id = 	ildp_catalog_method_catalog");
			$this->db->where("ildp_catalog_grade LIKE '%,".$this->sess['user_grade_code'].",%'", null); 
			$this->db->where("ildp_catalog_id", $rows[$i]->ildp_catalog_id);
			$this->db->where("ildp_method_status", 1);
			$this->db->group_by("ildp_method_id,ildp_method_name,ildp_catalog_category");
			$this->db->order_by("ildp_method_name", "asc");
			$q = $this->db->get("ildp_method");
			//echo $this->db->last_query();
			$rowmethods = $q->result();
			for($j=0; $j < count($rowmethods); $j++)
			{
				$devact[$rowmethods[$j]->ildp_catalog_category][$rowmethods[$j]->ildp_method_id] = $rowmethods[$j];
			}
			
			
			if (! isset($nildpcatalogs[$rows[$i]->ildp_category_name]))
			{
				$nildpcatalogs[$rows[$i]->ildp_category_name] = 0;
			}
			
			$nildpcatalogs[$rows[$i]->ildp_category_name]++;
			
			$ildpcatalogs[$rows[$i]->ildp_category_name]['data'][] = $rows[$i];
			$ildpcatalogs[$rows[$i]->ildp_category_name]['maxline'] = $rows[$i]->ildp_category_maxline;
			
			if (isset($drafts[$rows[$i]->ildp_category_name]))
			{
				$ildpcatalogs[$rows[$i]->ildp_category_name]['drafts'] = $drafts[$rows[$i]->ildp_category_name];
				$ildpcatalogs[$rows[$i]->ildp_category_name]['ndrafts'] = count($drafts[$rows[$i]->ildp_category_name]);
			}
			
			$maxlines[$rows[$i]->ildp_category_name] = $rows[$i]->ildp_category_maxline;
			
			if ($max > $rows[$i]->ildp_category_maxline) continue;
			$max = $rows[$i]->ildp_category_maxline;
		}
		
		if (count($rows))
		{
			foreach($nildpcatalogs as $key=>$val)
			{
					$ildpcatalogs[$key]['total'] = $val;
			}
		}		
		
		$allmaxline = array();
		for($i=0; $i < $max; $i++)
		{
			$allmaxline[] = $i;
		}
				
		$this->mysmarty->assign("ildpcatalogs", $ildpcatalogs);
		$this->mysmarty->assign("maxlines", $maxlines);
		$this->mysmarty->assign("allmaxlines", $allmaxline);
		$this->mysmarty->assign("areadevs", $areadevs);	
		
		//print_r($devact);
		//development activities for others
		$this->db->select("ildp_method_id,ildp_method_name");
		$this->db->where("ildp_method_status", 1);
		$this->db->order_by("ildp_method_name", "asc");
		$q = $this->db->get("ildp_method");
		//echo $this->db->last_query();
		$rowmethodsother = $q->result();
		$this->mysmarty->assign("methodsothers", $rowmethodsother);
		$this->mysmarty->assign("methods", $devact);
		
		//-- get development area for others
		$this->db->order_by("dev_area_title", "asc");
		$q = $this->db->get("ildp_development_area");
		$rowareas = $q->result();
		$this->mysmarty->assign("devareas", $rowareas);
		
		$ildpsettings = $this->ildpmodel->getSetting();
		
		$this->mysmarty->assign("shortterm", $ildpsettings['shortterm']);
		$this->mysmarty->assign("longterm", $ildpsettings['longterm']);
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lrealization", $this->config->item("lrealization"));
		$this->mysmarty->assign("lildp_form_header", $this->config->item("lildp_form_header"));
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
		$this->mysmarty->assign("lbudget", $this->config->item("lbudget"));
		$this->mysmarty->assign("lstart_approval", $this->config->item("lstart_approval"));
		$this->mysmarty->assign("lsave_form", $this->config->item("lsave_form"));		
		$this->mysmarty->assign("lcancel", $this->config->item("lcancel"));
		$this->mysmarty->assign("ldone", $this->config->item("ldone"));
		$this->mysmarty->assign("ltimeline", $this->config->item("ltimeline"));
		
		$this->mysmarty->assign("timeline_config", $this->config->item("timeline"));
		
		$html = $this->mysmarty->fetch("ildpform/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
	
	function approvedraft()
	{
		$ildpperiod = $this->ildpregmodel->IsPeriod();
		if ($ildpperiod == FALSE)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lnot_regperiod");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->order_by("ildp_detail_id", "asc");
		$this->db->where("ildp_status <>", 1);
		$this->db->where("ildp_user_id", $this->sess['user_id']);		
		$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
		$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id");
		$q = $this->db->get("ildp_form");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = "Draft is not found";
			
			echo json_encode($callback);
			return;			
		}
		
		$rows = $q->result();
		$j = 0;
		$k = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$_POST['method'][] = $rows[$i]->ildp_detail_method_id;
			$_POST['budget'][] = $rows[$i]->ildp_detail_budget;
			
			if ($rows[$i]->ildp_detail_category_id)
			{
				$_POST['training'][] = $rows[$i]->ildp_detail_category_id;
				$_POST['isothers'][] = 0;
				$_POST['status'.$j] = $rows[$i]->ildp_detail_status;
				$j++;
			}
			else
			{
				$_POST['training'][] = $rows[$i]->ildp_detail_others;
				$_POST['isothers'][] = 1;
				$_POST['statusothers'.$k] = $rows[$i]->ildp_detail_status;
				$k++;

			}
		}
		
		$this->save(1);
	}
		
	function save($status)
	{
		$training = isset($_POST['training']) ? $_POST['training'] : array();	
		$method = isset($_POST['method']) ? $_POST['method'] : array();
		$devarea = isset($_POST['devarea']) ? $_POST['devarea'] : array();
		
		$budget = isset($_POST['budget']) ? $_POST['budget'] : array();
		$categoryid = isset($_POST['categoryid']) ? $_POST['categoryid'] : array();
		$isothers = isset($_POST['isothers']) ? $_POST['isothers'] : array();
		
		$timelines = isset($_POST['status']) ? $_POST['status'] : array();
		$timelineothers = isset($_POST['statusothers']) ? $_POST['statusothers'] : array();
		
		$ildp_form_long_term = isset($_POST['long_term']) ? $_POST['long_term'] : "";
		$ildp_form_short_term = isset($_POST['short_term']) ? $_POST['short_term'] : "";
		
		/*if (count($training) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lerr_select_ildp_training_type");
			
			echo json_encode($callback);
			return;
		}*/
		
		if (count($devarea) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_dev_area");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->limit(1, 0);
		$this->db->order_by("ildpsetting_lastmodified ", "desc");
		$this->db->where("ildpsetting_key", "ildpmailnotify");
		$q = $this->db->get("ildpsetting");
		
		if ($q->num_rows() == 0)
		{
			$mail_notif = false;
		}
		else
		{
			$rowsetting = $q->row();
			
			$mail_notif = $rowsetting->ildpsetting_val == 1;
		}
		
		$double = false;
		$found = false;
		$i = 0;
		/*foreach($training as $val)
		{
			if (! $val) 
			{
				$i++;
				continue;
			}
			
			if (isset($selecttraining[$isothers[$i].$val]))
			{
				$idouble = $i;
				$double = true;
				break;
			}

			$found = true;
			$selecttraining[$isothers[$i].$val] = true;
			$i++;
		}
		
		if (! $found)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lerr_select_ildp_training_type");
			
			echo json_encode($callback);
			return;
		}
		
		if ($double)
		{
			$callback['cell'] = "#tdtraining".$idouble;
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lerr_invalid_ildp_training_type");
			
			echo json_encode($callback);
			return;
		}*/
		
		$i = 0;
		$empty = 0;
		foreach($devarea as $val)
		{
			if (! $val) 
			{
				$i++;
				$empty++;
				continue;
			}
			
			/*if (! $devarea[$i])
			{
					$callback['error'] = true;
					$callback['message'] = $this->config->item("lempty_dev_area");
					$callback['cell'] = "#tddevarea".$i;
					
					echo json_encode($callback);
					return;				
			}*/
			
			if (! $method[$i])
			{
					$callback['error'] = true;
					$callback['message'] = $this->config->item("lempty_learning_method");
					$callback['cell'] = "#tdmethod".$i;
					
					echo json_encode($callback);
					return;				
			}
			
			if (! $isothers[$i]){
				if (! $timelines[$i])
				{
						$callback['error'] = true;
						$callback['message'] = $this->config->item("lempty_timelines");
						$callback['cell'] = "#tdtimelines".$i;
						
						echo json_encode($callback);
						return;				
				}
			}else{
				if (! $timelines[$i])
				{
						$callback['error'] = true;
						$callback['message'] = $this->config->item("lempty_timelines");
						$callback['cell'] = "#tdtimelines_other".$i;
						
						echo json_encode($callback);
						return;				
				}
			}
			
			
			$vbudget = trim($budget[$i]);
			$vbudget = str_replace(".", "", $vbudget);
			$vbudget = str_replace(",", ".", $vbudget);
			if ($vbudget)
			{
				if (! is_numeric($vbudget))
				{
					$callback['cell'] = "#tdbudget".$i;
					$callback['error'] = true;
					$callback['message'] = $this->config->item("linvalid_budget");
					
					echo json_encode($callback);
					return;
				}
			}
			
			$i++;
		}

		if($empty == count($devarea)){
			$callback['cell'] = "#tddevarea0";
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_dev_area");
			
			echo json_encode($callback);
			return;
		}
		
		$ildpperiod = $this->ildpregmodel->IsPeriod();
		if ($ildpperiod == FALSE)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lnot_regperiod");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->where("ildp_user_id", $this->sess['user_id']);	
		$this->db->where("ildp_form_ildp_period",$ildpperiod->ildp_registration_period_ildp);
		//$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $ildpperiod->ildp_registration_period_start_t));
		//$this->db->where("ildp_period_end <=", date("Y-m-d 23:23:59", $ildpperiod->ildp_registration_period_end_t));
		$q = $this->db->get("ildp_form");
		
		if ($q->num_rows())
		{
			$row = $q->row();
			$this->db->where("ildp_detail_ildp_id", $row->ildp_id);
			$this->db->delete("ildp_detail");
			
			$this->db->where("ildp_id", $row->ildp_id);
			$this->db->delete("ildp_form");			
		}
		
		unset($insert);
		
		$this->db->where("jabatan_id", $this->sess['user_jabatan']);
		$q = $this->db->get("jabatan");
		
		if ($q->num_rows() == 0)
		{
			$dir = 0;
			$group = 0;
			$dept = 0;
			$unit = 0;
		}
		else
		{
			$row = $q->row();
			
			$groups = array();
			$this->levelmodel->getparentlevelgroups($row->jabatan_level_group, $groups);
			
			$groups = array_reverse($groups);

			$dir = count($groups) ? $groups[0]->level_group_id : 0;
			$group = (count($groups) > 1) ? $groups[1]->level_group_id : 0;
			$dept = (count($groups) > 2) ? $groups[2]->level_group_id : 0;
			$unit = (count($groups) > 3) ? $groups[3]->level_group_id : 0;

		}
		
		$insert['ildp_period_start'] = date("Y-m-d H:i:s");
		$insert['ildp_period_end'] = date("Y-m-d H:i:s");
		$insert['ildp_user_id'] = $this->sess['user_id'];
		$insert['ildp_user_npk'] = $this->sess['user_npk'];
		$insert['ildp_user_jabatan_id'] = $this->sess['user_jabatan'];				
		$insert['ildp_user_direktorat'] = $dir;
		$insert['ildp_user_group'] = $group;
		$insert['ildp_user_dept'] = $dept;
		$insert['ildp_user_unit'] = $unit;
		$insert['ildp_user_grade_code'] = $this->sess['user_grade_code'];
		$insert['ildp_comments'] = '';
		$insert['ildp_status'] = $status;
		$insert['ildp_approval_id'] = 0;
		$insert['ildp_created_by'] = $this->sess['user_id'];
		$insert['ildp_created_time'] = date("Y-m-d H:i:s");
		$insert['ildp_modified_by'] = $this->sess['user_id'];
		$insert['ildp_modified_time'] = date("Y-m-d H:i:s");
		$insert['ildp_approved_by'] = 0;
		$insert['ildp_approved_time'] = date("Y-m-d H:i:s");
		$insert['ildp_form_ildp_period'] = $ildpperiod->ildp_registration_period_ildp;
		$insert['ildp_form_long_term'] = $ildp_form_long_term;
		$insert['ildp_form_short_term'] = $ildp_form_short_term;
		
		$this->db->insert("ildp_form", $insert);
		$ildpformid = $this->db->insert_id();
		
		unset($insert1);
		
		$insert1['ildp_trail_user'] = $this->sess['user_id'];
		$insert1['ildp_trail_ildp_id'] = $ildpformid;
		$insert1['ildp_trail_status'] = 1;
		$insert1['ildp_trail_created_time'] = date("Y-m-d H:i:s");
		
		$json = $insert1;
		$managers = $this->ildpregmodel->getAllManager();
		
		$json['managers'] = $managers;
		
		$insert1['ildp_trail_comments'] = json_encode($json);
		
		$this->db->insert("ildp_form_trail", $insert1);
		$ildptrailid = $this->db->insert_id();
		
		$i = 0;
		foreach($devarea as $val)
		{
			if (! $val) 
			{
				$i++;
				continue;
			}
			
			unset($insert);
			
			$vbudget = trim($budget[$i]);
			$vbudget = str_replace(".", "", $vbudget);
			$vbudget = str_replace(",", ".", $vbudget);
			
			$insert['ildp_detail_ildp_id'] = $ildpformid;
			if (! $isothers[$i])
			{
				$insert['ildp_detail_category_id'] = $categoryid[$i];
				$insert['ildp_detail_others'] = "";
				$insert['ildp_detail_timeline'] = $timelines[$i];
			}
			else
			{
				$insert['ildp_detail_category_id'] = 0;
				//$insert['ildp_detail_others'] = $val;
				$insert['ildp_detail_others'] = "";
				//$insert['ildp_detail_timeline'] = $timelineothers[$i];				
				$insert['ildp_detail_timeline'] = $timelines[$i];				
			}
			
			$insert['ildp_detail_devarea'] = $devarea[$i];
			$insert['ildp_detail_method_id'] = $method[$i];
			$insert['ildp_detail_budget'] = $vbudget;
			$insert['ildp_detail_created_by'] = $this->sess['user_id'];
			$insert['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert("ildp_detail", $insert);			
			
			unset($insert1);
			
			$insert1['ildp_detail_trail_ildp_id'] = $ildptrailid;
			$insert1['ildp_detail_trail_method_id'] = $method[$i];
			$insert1['ildp_detail_trail_budget'] = $vbudget;
			$insert1['ildp_detail_devarea'] = $devarea[$i];
			
			if (! $isothers[$i])
			{
				//$insert['ildp_detail_trail_category_id'] = $val;
				$insert['ildp_detail_trail_category_id'] = $categoryid[$i];
				$insert1['ildp_detail_others'] = "";
				$insert['ildp_detail_timeline'] = $timelines[$i];
			}
			else
			{
				$insert['ildp_detail_trail_category_id'] = 0;
				//$insert1['ildp_detail_others'] = $val;
				$insert1['ildp_detail_others'] = "";
				$insert['ildp_detail_timeline'] = $timelines[$i];
			}
			
			$insert1['ildp_detail_trail_created_by'] = $this->sess['user_id'];
			$insert1['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert("ildp_detail_trail", $insert1);
			//echo $this->db->last_query();
			$i++;
		}

		$callback['error'] = false;
		
		if ($status == 0)
		{
			$callback['message'] = $this->config->item("lsave_draft");
		}
		else
		{
			// send email to approver
			
			$grade = $this->ildpregmodel->getEligableGrade();
			$managerids = $this->ildpregmodel->getAllManager();
			
			$this->db->where_in("user_npk", $managerids);
			$this->db->order_by("user_grade_code","asc");
			$q = $this->db->get("user");
			
			$rows = $q->result();
			
			$userInfo = $this->usermodel->getUserInfo($this->sess['user_id']);
			$employee_name = $userInfo[0]->user_first_name." ".$userInfo[0]->user_last_name." (".$userInfo[0]->user_npk.")";
			for($i=0; $i < count($rows); $i++)
			{
				if (! valid_email($rows[$i]->user_email)) continue;

				$this->mysmarty->assign("user", $rows[$i]);
				
				//-- email cc
				if ($rows[$i]->user_grade_code < $grade)
				{
			//		echo "cc : ".$grade.";".$rows[$i]->user_grade_code.";".$rows[$i]->user_npk.";".$rows[$i]->user_id."<BR>";
					$message = $this->mysmarty->fetch("ildpform/startapprovalmail.html");
					$subject = sprintf($this->config->item("lsubject_submitted"), $employee_name);
					
					if ($mail_notif)
					{
						$this->commonmodel->sendmail($rows[$i]->user_email, $subject, $message);
					}
				}
				//-- email for eligible
				else
				{
			//		echo "eligible : ".$grade.";".$rows[$i]->user_grade_code.";".$rows[$i]->user_npk.";".$rows[$i]->user_id."<BR>";
					
					if($rows[$i]->user_grade_code >= $grade) 
					{
						$message = $this->mysmarty->fetch("ildpform/approvalrequestmail.html");
						$subject = sprintf($this->config->item("lsubject_for_approval"), $employee_name);
						
						if ($mail_notif)
						{
							$this->commonmodel->sendmail($rows[$i]->user_email, $subject, $message);
						}
						break;
					}
				}

				
			
			}
			
			$callback['message'] = $this->config->item("lcheckout_success");
		}
		
		$callback['ildpformid'] = $ildpformid;	
		echo json_encode($callback);
	}
	
	function approval($id)
	{
		$this->index($id);
	}

	function approvalhist($id)
	{
		$this->index($id);
	}
	
	function hist($id)
	{
		$this->index($id);
	}	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
