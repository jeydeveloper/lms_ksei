<?php
include_once "base.php"; 

class BankSoal extends Base{
	var $sess;
	var $lang;
	var $modules;
	var $m_jabatans;

	function BankSoal()
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
		$this->load->model("banksoalmodel");
		
		$this->load->model("logmodel");
		
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
	}
	
	function index(){
		$this->session->set_flashdata('message',$this->config->item("lerror_permission") );
		redirect(base_url());
	}
	
	function CheckRight($type){
		if (! $this->modules[$type])
		{
			$this->session->set_flashdata('message',$this->config->item("lerror_permission") );
			redirect(base_url());
			return false;
		}
			
		return true;	
	}
	
	function training()
	{
		$this->CheckRight('training');
				
		$this->showlist(1);
	}

	function certificate()
	{
		$this->CheckRight('certificate');
		
		$this->showlist(2);
	}
	
	function showlist($type=1)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}else {
			if($type == 1)
				$this->CheckRight('training');
			else
				$this->CheckRight('certificate');
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "banksoal_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		
		$sess = unserialize($usess);
						
		$this->db->where("banksoal_type", $type);
		/* type 1 = training */	
		if ($type == 1)
		{	
			$this->db->select("banksoal_question_banksoal,  count(banksoal_question_quest) as total");
			$this->db->join("banksoal", "banksoal_id = banksoal_question_banksoal");
			$this->db->group_by("banksoal_question_banksoal");
		}
		else
		{
			$this->db->select("banksoal_id,  count(banksoal_question_quest) as total");
			$this->db->join("banksoal_unit", "banksoal_unit_id = banksoal_question_banksoal");
			$this->db->join("banksoal", "banksoal_id = banksoal_unit_banksoal");
			$this->db->group_by("banksoal_id");
		}
				
		$q = $this->db->get("banksoal_question");				
		$this->db->flush_cache();
		
		$jmlsoal = $q->result();
		$arrjmlsoal = array();
		for($i=0; $i < count($jmlsoal); $i++)
		{
			if ($type == 1)
			{
				$arrjmlsoal[$jmlsoal[$i]->banksoal_question_banksoal] = $jmlsoal[$i]->total;
			}
			else
			{
				$arrjmlsoal[$jmlsoal[$i]->banksoal_id] = $jmlsoal[$i]->total;
			}
		}
		
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE banksoal_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END banksoal_status_desc ", false);
		if ($limit)
		{
			$this->db->where("banksoal_type", $type);
			$q = $this->db->get("banksoal", $limit, $offset);
		}
		else
		{
			$this->db->where("banksoal_type", $type);
			$q = $this->db->get("banksoal");
		}
				
		$list = $q->result();
		$ids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->jumlahsoal = isset($arrjmlsoal[$list[$i]->banksoal_id]) ? $arrjmlsoal[$list[$i]->banksoal_id] : 0;
			$ids[] = $list[$i]->banksoal_id;
		}
		
		$used = $this->banksoalmodel->GetUsed($ids);
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->used = isset($used[$list[$i]->banksoal_id]);
		}
		
		$this->db->where("banksoal_type", $type);
		$total = $this->db->count_all_results("banksoal");
		
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
		$this->pagination1->lang_title = $this->config->item('lbank_soal');
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
		$this->mysmarty->assign("lhistory", $this->config->item('lhistory'));
		
		if ($type == 1)
		{
			$this->mysmarty->assign("lbanksoal_list_training", $this->config->item('lbanksoal_list_training'));
			$this->mysmarty->assign("banksoal_type", "training");			
		}
		else
		{
			$this->mysmarty->assign("lbanksoal_list_training", $this->config->item('lbanksoal_list_certification'));
			$this->mysmarty->assign("banksoal_type", "certificate");			
		}
		
		$this->mysmarty->assign("lbank_soal1", strtoupper($this->config->item('lbank_soal')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item('ljumlah_soal'));		
		$this->mysmarty->assign("pageid", ($type == 1) ? "training" : "certificate");		
		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/list.html");
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
	
	function changestatussoal()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($_POST['id']))
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$this->db->where("banksoal_question_id", $_POST['id']);
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$row = $q->row();
		
		unset($data);
		$data['banksoal_question_status'] = ($row->banksoal_question_status == 2) ? 1 : 2;
		
		$this->db->where("banksoal_question_id", $_POST['id']);
		$this->db->update("banksoal_question", $data);
		
		echo ($data['banksoal_question_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active");
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
		
		if ($this->sess['user_type'])
		{
			if(!$this->CheckRight('training') && !$this->CheckRight('certificate')) {
				echo "1\1";
				echo $this->config->item("err_exipred_session");
				exit;
			}
		}		
		
		$id = $this->uri->segment(3);	
		$status = $this->uri->segment(4);
		$pageid = $this->uri->segment(5);
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}				
		
		$data['banksoal_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("banksoal_id", $id);
		$this->db->update("banksoal", $data);				
		
		unset($insert);

		if ($pageid == "certificate")
		{
			switch($data['banksoal_status'])
			{
				case 1:
					$insert['cron_action'] = 31;
				break;
				case 2:
					$insert['cron_action'] = 32;
				break;
			}
		}
		else
		{
			switch($data['banksoal_status'])
			{
				case 1:
					$insert['cron_action'] = 21;
				break;
				case 2:
					$insert['cron_action'] = 22;
				break;
			}
		}
		
		$insert['cron_status'] = 1;
		$insert['cron_created'] = date("Y-m-d H:i:s");
		$insert['cron_started'] = "0000-00-00 00:00:00";
		$insert['cron_data'] = $id;
		
		$this->db->insert("cron", $insert);
	}
	
	function update($id)
	{
		$errs = array();
		if (! $id)
		{			
			$errs[] = $this->config->item("err_exipred_session");
		}
		else
		{
			$name = isset($_POST['name']) ? $_POST['name'] :  "";		
			$status = isset($_POST["_status"]) ? $_POST["_status"] : 1;
			
			if (strlen($name) == 0)
			{
				$errs[] = $this->config->item("err_banksoal_name");
			}
			else
			{
				$this->db->where("banksoal_name", $name);
				$q = $this->db->get("banksoal");
				$this->db->flush_cache();
				
				if ($q->num_rows() > 0)
				{
					$rowedit = $q->row();
					
					if ($rowedit->banksoal_id != $id)
					{
						$errs[] = $this->config->item("err_exist_banksoal_name");
					}
				}
			}
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "message"=>$html));
			
			return;
		}
		
		unset($data);
		
		$data['banksoal_name'] = $name;
		$data['banksoal_status'] = $status;
		
		$this->db->where("banksoal_id", $id);	
		$this->db->update("banksoal", $data);
		
		echo json_encode(array("err"=>0, "message"=>$this->config->item('ok_update_banksoal')));
		
	}
	
	function remove()
	{
		$this->checkadmin();
		
		$id = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("banksoal_id", $id);
		$this->db->delete("banksoal");
		
		$insert['cron_action'] = 23;
		$insert['cron_status'] = 1;
		$insert['cron_created'] = date("Y-m-d H:i:s");
		$insert['cron_started'] = "0000-00-00 00:00:00";
		$insert['cron_data'] = $id;
		
		$this->db->insert("cron", $insert);
		
		
		redirect(site_url(array("banksoal", $type)));
	}
	
	function formcertificate()
	{
		$id = $this->uri->segment(4);
		$unitid = $this->uri->segment(5);
		
		if ($id)
		{
			$this->db->where("banksoal_id", $id);
			$q = $this->db->get("banksoal");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowbanksoal = $q->row();
			$this->mysmarty->assign("banksoal", $rowbanksoal);
		}
		
		if ($unitid)
		{
			$this->db->where("banksoal_unit_id", $unitid);
			$q = $this->db->get("banksoal_unit");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowbanksoalunit = $q->row();
			$this->mysmarty->assign("banksoal_unit", $rowbanksoalunit);
			
		}
												
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->assign("lunit_soal_name", $this->config->item("lunit_soal_name"));
		$this->mysmarty->assign("ladd_unitsoal", $this->config->item("ladd_unitsoal"));
		$this->mysmarty->assign("lbanksoal_form_training", $this->config->item("lbanksoal_form_certificate"));
		$this->mysmarty->assign("lbanksoal_name", $this->config->item("lbanksoal_name"));
		$this->mysmarty->assign("type", "certificate");
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));		
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("ok_save_banksoal", $this->config->item("ok_save_banksoal"));
		$this->mysmarty->assign("pageid", "certificate");
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/formcertificate.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function unitsoal()
	{
		// check apakah pernah diambil
				
		$this->db->where("banksoal_unit_banksoal", $_POST['id']);
		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("banksoal_unit", "training_banksoal = banksoal_unit_banksoal");
		$totexam = $this->db->count_all_results("history_exam");
		$this->db->flush_cache();
		
		$this->db->where("banksoal_unit_banksoal", $_POST['id']);
		$this->db->where("banksoal_unit_status", 1);
		
		$this->db->join("banksoal", "banksoal_id = banksoal_unit_banksoal");
		$q = $this->db->get("banksoal_unit");
		$this->db->flush_cache();
		
		$rows = $q->result();
		
		$this->db->where("banksoal_type", 2);
		$this->db->where("banksoal_unit_status", 1);
		
		$this->db->group_by(array("banksoal_question_banksoal"));
		$this->db->select("banksoal_question_banksoal, count(*) as total");
				
		$this->db->join("banksoal_unit", "banksoal_unit_id = banksoal_question_banksoal");
		$this->db->join("banksoal", "banksoal_id = banksoal_unit_banksoal");		
		$q = $this->db->get("banksoal_question");
		
		$rowstot = $q->result();
		
		$totals = array();
		for($i=0; $i < count($rowstot); $i++)
		{
			$totals[$rowstot[$i]->banksoal_question_banksoal] = $rowstot[$i]->total;
		}
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->banksoal_unit_totalsoal = $totals[$rows[$i]->banksoal_unit_id];
		}		
				
		$this->mysmarty->assign("totexam", $totexam);
		$this->mysmarty->assign("list", $rows);
		$this->mysmarty->assign("lunit_soal", $this->config->item("lunit_soal"));
		$this->mysmarty->assign("ladd_soal", $this->config->item("ladd_soal"));
		
		$this->mysmarty->assign("lunit_soal_name", $this->config->item("lunit_soal_name"));		
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));
		$this->mysmarty->assign("confirm_delete", $this->config->item("confirm_delete"));		
		$this->mysmarty->assign("ladd_unit_soal", $this->config->item("ladd_unit_soal"));		
		
		$this->mysmarty->display("banksoal/unitsoal/list.html");	
	}

	function unitsoaldetail()
	{		
		$unitid = isset($_POST['id']) ? $_POST['id'] : "";
		if (! $unitid)
		{
			return;
		}
		
		// check apakah all jabatan
		
		$this->db->where("banksoal_question_alljabatan", 1);
		$this->db->where("banksoal_question_banksoal", $unitid);
		$this->db->where("banksoal_type", 2);
		
		$this->db->join("banksoal_unit", "banksoal_question_banksoal = banksoal_unit_id");
		$this->db->join("banksoal", "banksoal_unit_banksoal = banksoal_id");
		
		$total = $this->db->count_all_results("banksoal_question");
		if ($total > 0)
		{
			$this->db->distinct();
			$this->db->order_by("jabatan_name", "asc");
			$this->db->select("jabatan_name");
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				return;
			}
		}
		else
		{
			$this->db->distinct();
			$this->db->order_by("jabatan_name", "asc");
			$this->db->select("jabatan_name");
			$this->db->where("banksoal_question_banksoal", $unitid);
			$this->db->join("jabatan", "jabatan_id = banksoal_question_jabatan");
			$q = $this->db->get("banksoal_question");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				return;
			}
		}
		
		$jabatans = $q->result();

		$this->mysmarty->assign("unitid", $unitid);
		$this->mysmarty->assign("jabatans", $jabatans);
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));
		
		$this->mysmarty->display("banksoal/unitsoal/detail.html");	
	}
	
	function form()
	{
		$this->checkadmin();
				
		$type = $this->uri->segment(3);
		
		if ($type == "certificate")
		{
			if ($this->sess['user_type'])
				$this->CheckRight('certificate');
			$this->formcertificate();
			return;
		}else{
			/* training */
			
			if ($this->sess['user_type'])
			{
				 $this->CheckRight('certificate') ;
			}
			
		}
				
		$this->mysmarty->assign("lbanksoal_form_training", $this->config->item("lbanksoal_form_training"));
		$this->mysmarty->assign("lbanksoal_name", $this->config->item("lbanksoal_name"));
		$this->mysmarty->assign("type", $type);
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));		
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("ok_save_banksoal", $this->config->item("ok_save_banksoal"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		
		$this->mysmarty->assign("pageid", "training");
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/form.html");
		$this->mysmarty->display("sess_template.html");
		
	}

	function formedit()
	{
		$this->checkadmin();
		
		$edit = $this->uri->segment(3);
				
		if (! $edit)
		{
			redirect(base_url());
		}
		
		$this->db->where("banksoal_type", 1);
		$this->db->where("banksoal_id", $edit);
		$this->db->select("*, CASE banksoal_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END banksoal_status_desc", false);
		$q = $this->db->get("banksoal");

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$this->mysmarty->assign("banksoal", $row);
				
		$this->mysmarty->assign("lbanksoal_form_training", $this->config->item("lbanksoal_form_training"));
		$this->mysmarty->assign("lbanksoal_name", $this->config->item("lbanksoal_name"));
		$this->mysmarty->assign("type", ($row->banksoal_type == 1) ? "training" : "certificate");
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));		
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("ok_save_banksoal", $this->config->item("ok_save_banksoal"));
		$this->mysmarty->assign("pageid", "training");
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/formedit.html");
		$this->mysmarty->display("sess_template.html");
		
	}
	
	function savecertificate()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";

		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_banksoal_name");
		}
		else
		{							
			$this->db->where("banksoal_type", 2);
			$this->db->where("banksoal_name", addslashes($name));
			$q = $this->db->get("banksoal");
			$this->db->flush_cache();
						
			if ($q->num_rows() > 0)
			{
				$banksoal = $q->row();
				
				if ($banksoal->banksoal_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_banksoal_name");
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
		
		$data['banksoal_name'] = $name;
		$data['banksoal_created'] = date("Ymd");
		$data['banksoal_creator'] = $this->sess['user_id'];;
		$data['banksoal_type'] = 2;
		$data['banksoal_status'] = 1;
		
		$this->db->insert("banksoal", $data);
		
		echo $this->db->insert_id();		
	}

	function addsoalbyimport()
	{
	        if (isset($_FILES['userfile']) && $_FILES['userfile'])
                {
                        if (! $_FILES['userfile']['name'])
                        {
                                $errs[] = $this->config->item("err_emtpy_banksoal_file");
                        }
                        else
                        if ($_FILES['userfile']['size'] <= 0)
                        {
                                $errs[] = $this->config->item("err_invalid_banksoal_file");
                        }
                }
		
		if (isset($errs))
		{
                        $this->mysmarty->assign("errs", $errs);
                        $err = $this->mysmarty->fetch("errmessage.html");
                        $err = str_replace("\"", "'", $err);
                        $err = str_replace("\r", "", $err);
                        $err = str_replace("\n", "", $err);

                        echo "<script>parent.setErrorMessage(\"".$err."\")</script>";

                        return;
		}

		// cari last no

		$this->db->order_by("banksoal_question_order", "desc");
		$this->db->where("banksoal_question_packet IS NULL");
		$this->db->where("banksoal_question_banksoal", $_POST['banksoalid']);
		$q = $this->db->get("banksoal_question", 1, 0);
		$this->db->flush_cache();
	
		if ($q->num_rows() == 0)
		{
			$lastno = 0;
		}
		else
		{
			$rowlastno = $q->row();
			$lastno = $rowlastno->banksoal_question_order;
		}

		$soals = $this->importexam($_FILES['userfile']['tmp_name']);
   
		for($i=0; $i < count($soals); $i++)
		{
            unset($data);
                                
			$data['banksoal_question_quest'] = $soals[$i]['soal'];
            $data['banksoal_question_banksoal'] = $_POST['banksoalid'];
            $data['banksoal_question_order'] = $lastno+$i+1;
            $data['banksoal_question_status'] = 1;

            $this->db->insert("banksoal_question", $data);
            $this->db->flush_cache();

            $lastquest_id = $this->db->insert_id();

            for($j=0; $j < count($soals[$i]['pilihan']); $j++)
            {
                unset($data);

                $data['banksoal_answer_text'] = $soals[$i]['pilihan'][$j];
                $data['banksoal_answer_question'] = $lastquest_id;
                $data['banksoal_answer_order'] = $j;

                $this->db->insert("banksoal_answer", $data);
				$this->db->flush_cache();

				$lastanswerid = $this->db->insert_id(); 
				if ($j == (ord($soals[$i]['jawaban'])-ord('A')))
				{
					$answer_id = $lastanswerid;
				}
            }

			unset($data);

			$data['banksoal_question_answer'] = isset($answer_id) ? $answer_id : 0;

			$this->db->where("banksoal_question_id", $lastquest_id);
			$this->db->update("banksoal_question", $data);
			$this->db->flush_cache();

		}

		echo "<script>parent.setSuccess()</script>";
	}

	function unitsoalimport()
	{		
		$id = $this->uri->segment(3);
		$edit = $this->uri->segment(4);
		
		$errs = array();
		
		$name = isset($_POST['unitsoalname']) ? trim($_POST['unitsoalname']) : "";
		$unitsoalid = isset($_POST['unitsoalid']) ? trim($_POST['unitsoalid']) : "";	
		
		if (! $unitsoalid)
		{
			if (strlen($name) == 0)
			{
				$errs[] = $this->config->item("lerr_empty_unitsoal");
			}
			else
			{
				$this->db->where("banksoal_unit_name", $name);
				$this->db->where("banksoal_unit_banksoal", $id);
			
				$q = $this->db->get("banksoal_unit");
				if ($q->num_rows() > 0)
				{
					$rowunitsoal = $q->row();
					if ($rowunitsoal->banksoal_unit_id != $edit)
					{
						$errs[] = $this->config->item("lerr_exist_unitsoal");
					}				
				}
			}
		}
		else
		{
			$this->db->where("banksoal_unit_id", $unitsoalid);
			$this->db->where("banksoal_unit_banksoal", $id);

			$q = $this->db->get("banksoal_unit");
			if ($q->num_rows() == 0)
			{
				$errs[] = "Invalid unit soal id";
			}
		}
		
		if ($_FILES['file']['error'])
		{
			$errs[] = $this->config->item("lerr_empty_file_unitsoal");
		}
		else
		{
			$data = array();
			$err = $this->importcertificate($_FILES['file']['tmp_name'], $id, $name, $data, $unitsoalid);
			switch($err)
			{
				case 1:
					$errs[] = $this->config->item("lerr_invalid_file_unitsoal");
				break;
				case 2:
					$errs[] = sprintf($this->config->item("lerr_invalid_file_unitsoal_jabatan"), implode(", ", $this->m_jabatans));
				break;				
			}
			
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";
			
			return;
		}	
		
		echo "<script>parent.setSuccess()</script>";
	}
	

	function importcertificate($filename, $id, $unitname, &$data, $unitsoalid=0)
	{
		$this->m_jabatans = false;
		set_time_limit (0);

		/*
		$this->load->library("xlsreader");
		$this->xlsreader->read($filename);

		$data = array();
		
		$nsheet = count($this->xlsreader->sheets);
		if ($nsheet < 2)
		{
			return 1;
		}
				
		// check nama sheet, apakah ada jabatan
		
		$this->logmodel->init("import_certificate_question");
		$this->logmodel->append("start import ");		
		$jabatans = array();	
		for ($i=1; $i < $nsheet; $i++)
		{			
			unset($name);
			
			$sname = strtoupper(trim($this->xlsreader->boundsheets[$i]['name']));
			
			if ($sname != "ALL JABATAN")
			{
				$name[] = $sname;
				$name[] = str_replace("-", " ", $sname);
				
				if (strpos($sname, " ATAU ") != FALSE)
				{
					$names = explode(" ATAU ", $sname);				
					$name = array_merge($name, $names);
				}
				
				$name = array_unique($name);

				// cari apakah jabatan telah ada atau belum
				
				$this->db->where_in("UPPER(jabatan_name)", $name);
				$q = $this->db->get("jabatan");			
				if ($q->num_rows() == 0)
				{
					foreach($name as $value)
					{
						$this->m_jabatans[] = $value;
						$this->logmodel->append("jabatan ".$value." is not exist ");						
					}
					return 2;
				}
			}
			
			// proses soal			
			
			unset($soal);
			
			$row = 6;		
			while (true)
			{	
				// test apakah satu row, data semua ada
				for($j=1; $j < 100; $j++)
				{
					if  (! isset($this->xlsreader->sheets[$i]['cells'][$row][$j])) 
					{						
						break;	
					}
				}
				
				if ($j < 5) break;
				
				$soal[$row-6]['no'] = $this->xlsreader->sheets[$i]['cells'][$row][1];
				$soal[$row-6]['paket'] = $this->xlsreader->sheets[$i]['cells'][$row][2];
				$soal[$row-6]['tanya'] = $this->xlsreader->sheets[$i]['cells'][$row][3];
				$soal[$row-6]['jawaban'] = ord($this->xlsreader->sheets[$i]['cells'][$row][4])-ord("A");
				
				unset($pilihan);
				for($k=5; $k < $j-1; $k++)
				{
					$pilihan[] = $this->xlsreader->sheets[$i]['cells'][$row][$k];
				}	
				
				$soal[$row-6]['pilihan'] = $pilihan;	
				$soal[$row-6]['bobot'] = $this->xlsreader->sheets[$i]['cells'][$row][$j-1];
				
				$row++;
			}				
			
			// not valid
			
			if (! isset($soal)) continue;
			
			// jabatan
			
			if ($sname != "ALL JABATAN")
			{			
				$rows = $q->result();
				for($j=0; $j < count($rows); $j++)
				{
					$unitsoal[$rows[$j]->jabatan_id] = $soal;
				}
			}
			else
			{
				$unitsoal[0] = $soal;
			}
		}
		*/

        require_once BASEPATH . "application/libraries/PHPExcel.php";
        require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $data = array();

        // check nama sheet, apakah ada jabatan

        $this->logmodel->init("import_certificate_question");
        $this->logmodel->append("start import ");
        $jabatans = array();
        $cnt = 0;
        $arr = [];
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            /*
            $worksheetTitle     = $worksheet->getTitle();
            $arr[] = $worksheetTitle;
            */

            if(empty($cnt)) {
                $cnt++;
                continue;
            }

            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            unset($name);

            $sname = strtoupper($worksheetTitle);

            if ($sname != "ALL JABATAN")
            {
                $name[] = $sname;
                $name[] = str_replace("-", " ", $sname);

                if (strpos($sname, " ATAU ") != FALSE)
                {
                    $names = explode(" ATAU ", $sname);
                    $name = array_merge($name, $names);
                }

                $name = array_unique($name);

                // cari apakah jabatan telah ada atau belum

                $this->db->where_in("UPPER(jabatan_name)", $name);
                $q = $this->db->get("jabatan");
                if ($q->num_rows() == 0)
                {
                    foreach($name as $value)
                    {
                        $this->m_jabatans[] = $value;
                        $this->logmodel->append("jabatan ".$value." is not exist ");
                    }
                    return 2;
                }
            }

            // proses soal

            unset($soal);

            $rows = 6;

            for($j=0; $j < 100; $j++)
            {
                $tmp = $worksheet->getCellByColumnAndRow($j, $rows)->getValue();
                if  (! isset($tmp))
                {
                    break;
                }
            }

            if ($j < 4) break;

            for ($row = $rows; $row <= $highestRow; ++$row) {
                $soal[$row-6]['no'] = (string)$worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $soal[$row-6]['paket'] = (string)$worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $soal[$row-6]['tanya'] = (string)$worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $tmp = (string)$worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $soal[$row-6]['jawaban'] = ord($tmp)-ord("A");

                unset($pilihan);
                for($k=4; $k < $j-1; $k++)
                {
                    $pilihan[] = (string)$worksheet->getCellByColumnAndRow($k, $row)->getValue();
                }

                $soal[$row-6]['pilihan'] = $pilihan;
                $soal[$row-6]['bobot'] = (string)$worksheet->getCellByColumnAndRow(($j-1), $row)->getValue();
            }

            //print_r($soal); exit();

            // not valid

            if (! isset($soal)) continue;

            // jabatan

            if ($sname != "ALL JABATAN")
            {
                $rows = $q->result();
                for($j=0; $j < count($rows); $j++)
                {
                    $unitsoal[$rows[$j]->jabatan_id] = $soal;
                }
            }
            else
            {
                $unitsoal[0] = $soal;
            }

            $cnt++;
        }

        //print_r($arr);exit();

		// simpan ke db
		
		if (! isset($unitsoal)) return 3;	
		
		// simpan informasi unit
	
		if ($unitsoalid)
		{
			$unitid = $unitsoalid;
		}
		else
		{	
			unset($data);
		
			$data['banksoal_unit_name'] = $unitname;
			$data['banksoal_unit_banksoal'] = $id;			
			$data['banksoal_unit_status'] = 1;
		
			$this->db->insert("banksoal_unit", $data);
			$unitid = $this->db->insert_id();
		}		
		
		// cari no terakhir untuk antisipasi tambah soal

		$this->db->select("banksoal_question_order");
		$this->db->order_by("banksoal_question_order", "desc");
		$this->db->where("banksoal_question_packet IS NOT NULL");
		$this->db->where("banksoal_question_banksoal", $unitid);
		$q = $this->db->get("banksoal_question", 1, 0);
		$this->db->flush_cache();
	
		if ($q->num_rows() == 0)
		{
			$lastno = 0;
		}
		else
		{
			$rowlastno = $q->row();
			$lastno = $rowlastno->banksoal_question_order;
		}
		
		$no = $lastno+1;		
		foreach($unitsoal as $jabatan=>$soals)
		{
			// soal
			foreach($soals as $soal)
			{			
				unset($data);
				
				$data['banksoal_question_alljabatan'] = $jabatan ? 0 : 1;
				$data['banksoal_question_jabatan'] = $jabatan;
				$data['banksoal_question_packet'] = $soal['paket'];
				$data['banksoal_question_status'] = 1;
				$data['banksoal_question_order'] = $no++;
				$data['banksoal_question_banksoal'] = $unitid;
				$data['banksoal_question_answer'] = $soal['jawaban'];
				$data['banksoal_question_quest'] = $soal['tanya'];
				
				if (strcasecmp($soal['bobot'], $this->config->item("lmudah")) == 0)
				{
					$data['banksoal_question_bobot'] = "Mudah";
				}
				else
				if (strcasecmp($soal['bobot'], $this->config->item("lsulit")) == 0)
				{
					$data['banksoal_question_bobot'] = "Sulit";
				}
				else
				if (strcasecmp($soal['bobot'], $this->config->item("lsedang")) == 0)
				{
					$data['banksoal_question_bobot'] = "Sedang";
				}
				else
				{				
					$data['banksoal_question_bobot'] = $soal['bobot'];
				}
				
				$this->db->insert("banksoal_question", $data);
				
				$tanyaid = $this->db->insert_id();
				$nopilihan = 1;
				
				$jawaban_id = 0;
				foreach($soal['pilihan'] as $pilihan)
				{
					unset($data);
					
					$data['banksoal_answer_text'] = $pilihan;
					$data['banksoal_answer_question'] = $tanyaid;
					$data['banksoal_answer_order'] = $nopilihan;
					
					$this->db->insert("banksoal_answer", $data);					
					
					if (($nopilihan-1) == $soal['jawaban'])
					{
						$jawaban_id = $this->db->insert_id();
					}
					
					$this->db->flush_cache();
					
					$nopilihan++;
				}
				
				unset($data);
				$data['banksoal_question_answer'] = $jawaban_id;
				
				$this->db->where("banksoal_question_id", $tanyaid);
				$this->db->update("banksoal_question", $data);								
				
				$this->db->flush_cache();
			}
		}
				
		return 0;		
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
		
		$type = $this->uri->segment(3);
		$edit = $this->uri->segment(4);
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_banksoal_name");
		}
		else
		{							
			$this->db->where("banksoal_type", ($type == "training") ? 1 : 2);
			$this->db->where("banksoal_name", addslashes($name));
			$q = $this->db->get("banksoal");
			$this->db->flush_cache();
						
			if ($q->num_rows() > 0)
			{
				$banksoal = $q->row();
				
				if ($banksoal->banksoal_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_banksoal_name");
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
		
		if ($edit) return;		
		
		$data['banksoal_name'] = $name;
		$data['banksoal_created'] = date("Ymd");
		$data['banksoal_creator'] = $this->sess['user_id'];;
		$data['banksoal_type'] = ($type == "training") ? 1 : 2;
		$data['banksoal_status'] = 1;
		
		$this->db->insert("banksoal", $data);
		$this->db->flush_cache();
		
		$banksoal_id = $this->db->insert_id();
		
		$lastno = -1;		
		$questorder = 0;
		for($i=0; $i < count($_POST['no']); $i++)
		{
			if ($lastno != $_POST['no'][$i])
			{				
				// soal baru
				
				$choiceorder = 0;
				
				unset($data);
				$data['banksoal_question_quest'] = $_POST['soal'][$i];
				$data['banksoal_question_banksoal'] = $banksoal_id;
				$data['banksoal_question_order'] = $questorder++;
				$data['banksoal_question_status'] = 1;
				
				$this->db->insert("banksoal_question", $data);
				$this->db->flush_cache();
				
				$lastquest_id = $this->db->insert_id();
				$lastanswer = $_POST['jawaban'][$i];
				$lastno = $_POST['no'][$i];
			}
			
			unset($data);
			
			$data['banksoal_answer_text'] = $_POST['pilihan'][$i];
			$data['banksoal_answer_question'] = $lastquest_id;
			$data['banksoal_answer_order'] = $choiceorder;
			
			$this->db->insert("banksoal_answer", $data);
			$this->db->flush_cache();
			$chooice_id = $this->db->insert_id();
			
			if (chr(ord('A')+$choiceorder) == $lastanswer)
			{
				
				unset($data);
				
				$data['banksoal_question_answer'] = $chooice_id;
				
				$this->db->where("banksoal_question_id", $lastquest_id);
				$this->db->update("banksoal_question", $data);
				$this->db->flush_cache();
			}
			
			$choiceorder++;
		}
		
		// disini gak usah dicek lagi karena gak mungkin hanya ada satu pilihan
				
	}
	
	
	function preview()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$type = $this->uri->segment(3);
		$edit = $this->uri->segment(4);
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_banksoal_name");
		}
		else
		{							
			$this->db->where("banksoal_type", ($type == "training") ? 1 : 2);
			$this->db->where("banksoal_name", addslashes($name));
			$q = $this->db->get("banksoal");
			$this->db->flush_cache();
						
			if ($q->num_rows() > 0)
			{
				$banksoal = $q->row();
				
				if ($banksoal->banksoal_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_banksoal_name");
				}
			}
		}
		
		if (isset($_FILES['userfile']) && $_FILES['userfile'])
		{	
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("err_emtpy_banksoal_file");
			}
			else
			if ($_FILES['userfile']['size'] <= 0)
			{
				$errs[] = $this->config->item("err_invalid_banksoal_file");
			}
		}
		
		if (count($errs) == 0)
		{
			if ($type == "certificate")
			{
				//
			}
			else
			{
				$data = $this->importexam($_FILES['userfile']['tmp_name']);
			}
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";
			
			return;
		}				
		
		$id = md5(uniqid());
        
		$this->savepreview($data, $id);
		
		echo "<script>parent.showPreview('".$id."')</script>";
	}
	
	function showpreview()
	{
		$id = $this->uri->segment(3);		
		readfile(BASEPATH . "application/uploads/" . $id . ".html");
		@unlink(BASEPATH . "application/uploads/" . $id . ".html");
	}
	
	function loadsoal()
	{
		
		$id = $this->uri->segment(3);
		
		$this->db->order_by("banksoal_question_order", "ASC");
		$this->db->order_by("banksoal_answer_order", "ASC");
		
		$this->db->where("banksoal_question_banksoal", $id);	
		$this->db->where("banksoal_question_packet is NULL");
		
		$this->db->join("banksoal_question", "banksoal_answer_question = banksoal_question_id");
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();
		
		$rows = $q->result();
		
		// cek apakah sudah pernah diambil
		
		$this->db->where("training_exam_banksoal", $id);
		$this->db->join("training_exam", "training_exam_training = history_exam_training");		
		$totexam = $this->db->count_all_results("history_exam");
		$this->db->flush_cache();

		
		$data = array();
		$questorder = -1;
		$choices = array();
		for($i=0; $i < count($rows); $i++)
		{
			if ($questorder != $rows[$i]->banksoal_question_order)
			{
				if ($questorder != -1)
				{
					$data[] = array(
						 "no"=>$questorder+1
						,"soal"=>$soal
						,"soalid"=>$soalid
						,"jawaban"=>$jawaban
						,"pilihan"=>$choices
						,"status_desc"=>$status_desc	
						,"totexam"=>$totexam					
					);
				}				
			
				$choices = array();
				$questorder = $rows[$i]->banksoal_question_order;	
				$soal = $rows[$i]->banksoal_question_quest;			
				$soalid = $rows[$i]->banksoal_question_id;			
				$jawaban = chr(ord('A') + $this->getanswer($rows, $rows[$i]->banksoal_question_answer));
				$status_desc = ($rows[$i]->banksoal_question_status == 2) ? $this->config->item("inactive") : $this->config->item("active");
			}						
			
			$choices[] = $rows[$i]->banksoal_answer_text;
		}
		
		// pasti selalu kelebihan satu
		
		if (count($rows)) 
		{
			$data[] = array(
				 "no"=>$questorder+1
				,"soal"=>$soal
				,"soalid"=>$soalid
				,"jawaban"=>$jawaban
				,"pilihan"=>$choices
				,"status_desc"=>$status_desc
				,"totexam"=>$totexam
			);
		}
		
		$this->mysmarty->assign("banksoal_id", $id);
		echo $this->savepreview($data);
		
	}
	
	function removeunitsoal()
	{
		$errs = array();

		$id = isset($_POST["id"]) ? $_POST["id"] : 0;
		if (! $id)
		{
			return;
		}				
						
		$this->db->where("banksoal_jabatan_unit", $id);
		$this->db->delete("banksoal_jabatan");
		$this->db->flush_cache();		
		
		$this->db->where("banksoal_question_packet is NOT NULL");
		$this->db->where("banksoal_question_banksoal", $id);
		$this->db->where("banksoal_question_jabatan >", 0);
		$this->db->delete("banksoal_question");
		$this->db->flush_cache();
		
		$this->db->where("banksoal_unit_id", $id);		
		$this->db->delete("banksoal_unit");
	}
	
	function removesoal()
	{
		$errs = array();
		
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$arg = $this->uri->segment(3);
		list($banksoal_id, $no) = split("_", $arg);
				
		if (! $banksoal_id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;			
		}

		$this->db->limit(1, $no-1);
		$this->db->order_by("banksoal_question_order", "asc");
		$this->db->where("banksoal_question_banksoal", $banksoal_id);		
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$errs[] = $this->config->item("lsoal_not_exist");
		}
		else
		{
			$rowsoal = $q->row();						
		}
		
		echo count($errs);
		echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}
		
		$this->db->where("banksoal_question_id", $rowsoal->banksoal_question_id);
		$this->db->delete("banksoal_question");

	}
	
	function addsoal()
	{
		$errs = array();
		
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		$banksoal_id = $this->uri->segment(3);
		if (! $banksoal_id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;			
		}
		
		$this->db->where("banksoal_question_banksoal", $banksoal_id);
		$this->db->select_max("banksoal_question_order");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$order = 1;
		}
		else
		{
			$roworder = $q->row();			
			$order = $roworder->banksoal_question_order+1;
		}		
		
		echo count($errs);
		echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}
		
		$jaw = ord($_POST['_jawaban'])-ord('A');
				
		$data['banksoal_question_quest'] = $_POST['_pertanyaan'];
		$data['banksoal_question_banksoal'] = $banksoal_id;
		$data['banksoal_question_order'] = $order;
		$data['banksoal_question_status'] = 1;
		
		$this->db->insert("banksoal_question", $data);		
		$quest_id = $this->db->insert_id();
		
		$this->db->where("banksoal_answer_question", $quest_id);
		$this->db->select_max("banksoal_answer_order");
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$order = 1;
		}
		else
		{
			$roworder = $q->row();			
			$order = $roworder->banksoal_answer_order+1;
		}

		
		$i = 0;
		foreach($_POST['_pilihan'] as $val)
		{			
			unset($data);
			
			$data['banksoal_answer_text'] = $val;
			$data['banksoal_answer_question'] = $quest_id;
			$data['banksoal_answer_order'] = $order;
			
			$this->db->insert("banksoal_answer", $data);
			
			$ans_id = $this->db->insert_id();
			
			if ($i == $jaw)
			{
				unset($data);
				
				$data['banksoal_question_answer'] = $ans_id;
				
				$this->db->where("banksoal_question_quest", $quest_id);
				$this->db->update("banksoal_question", $data);
				$this->db->flush_cache();
			}
			
			
			$i++;
		}
		
	}
	
	function updatesoal()
	{
		$errs = array();
		
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$arg = $this->uri->segment(3);
		list($banksoal_id, $no) = split("_", $arg);
				
		if (! $banksoal_id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;			
		}
		
		$this->db->limit(1, $no-1);
		$this->db->order_by("banksoal_question_order", "asc");
		$this->db->where("banksoal_question_banksoal", $banksoal_id);		
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$errs[] = $this->config->item("lsoal_not_exist");
		}
		else
		{
			$rowsoal = $q->row();
			
			$this->db->order_by("banksoal_answer_order", "asc");
			$this->db->where("banksoal_answer_question", $rowsoal->banksoal_question_id);
			$q = $this->db->get("banksoal_answer");
			$this->db->flush_cache();
			
			$realno = ($no-1)*$q->num_rows();
			$soal = $_POST['soal'][$realno];
			$jawaban  = ord($_POST['jawaban'][$realno])-ord('A');
			
			$respilihan = $q->result();
			for($i=0; $i < count($respilihan); $i++)
			{
				if ($i == $jawaban)
				{
					unset($data);
					$data['banksoal_question_answer'] = $respilihan[$i]->banksoal_answer_id;
					$data['banksoal_question_quest'] = $soal;
										
						
					$this->db->where("banksoal_question_id", $rowsoal->banksoal_question_id);
					$this->db->update("banksoal_question", $data);					
					$this->db->flush_cache();
				}
				
				unset($data);
				$data['banksoal_answer_text'] = $_POST['pilihan'][$realno+$i];
				
				$this->db->where("banksoal_answer_id", $respilihan[$i]->banksoal_answer_id);
				$this->db->update("banksoal_answer", $data);
				$this->db->flush_cache();
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
	}
	
	function getanswer($arr, $id)
	{
		for($i=0; $i < count($arr); $i++)
		{
			if ($arr[$i]->banksoal_answer_id == $id)
			{
				return $arr[$i]->banksoal_answer_order;
			}
		}
		
		return 0;
	}
	
	function savepreview($data, $id="")
	{
		$questcodes = array();
		for($i=0; $i < count($data[0]['pilihan']); $i++)
		{
			$questcodes[] = chr(ord('A')+$i);
		}
		
		$this->mysmarty->assign("questcodes", $questcodes);
		$this->mysmarty->assign("list", $data);
		$this->mysmarty->assign("ncol", 3+count($questcodes));		
		
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lanswer", $this->config->item("lanswer"));
		$this->mysmarty->assign("lquestion", $this->config->item("lquestion"));		
		$this->mysmarty->assign("ledit_soal", $this->config->item("ledit_soal"));	
		$this->mysmarty->assign("lerr_empty_question", $this->config->item("lerr_empty_question"));		
		$this->mysmarty->assign("lerr_empty_answer", $this->config->item("lerr_empty_answer"));		
		$this->mysmarty->assign("ok_update_soal", $this->config->item("ok_update_soal"));
		$this->mysmarty->assign("ok_add_soal", $this->config->item("ok_add_soal"));
		$this->mysmarty->assign("lerr_empty_chooice", $this->config->item("lerr_empty_chooice"));		
		$this->mysmarty->assign("confirm_delete", $this->config->item("confirm_delete"));	
		$this->mysmarty->assign("ladd_soal", $this->config->item("ladd_soal"));		
		
		$content = $this->mysmarty->fetch("banksoal/previewexam.html");
		
		if (strlen($id) == 0) return $content;

		$fout = fopen(BASEPATH . "application/uploads/" . $id . ".html", "w");
		fwrite($fout, $content);
		fclose($fout);		
	}
	
	
	
	function importexam($filename)
	{
	    /*
		$this->load->library("xlsreader");
		
		$this->xlsreader->read($filename);
		
		$data = array();
		
		// header
		
		
		$row = 2;
		while(true)
		{
			
			if  (! isset($this->xlsreader->sheets[0]['cells'][$row][1])) break;
			if  (! isset($this->xlsreader->sheets[0]['cells'][$row][2])) break;
			if  (! isset($this->xlsreader->sheets[0]['cells'][$row][3])) break;
			
			$no = trim($this->xlsreader->sheets[0]['cells'][$row][1]);
			$soal = trim($this->xlsreader->sheets[0]['cells'][$row][2]);
			$jawaban = trim($this->xlsreader->sheets[0]['cells'][$row][3]);

			$soal = preg_replace('/[\x00\x08\x0B\x0C\x0E-\x1F]/', '', $soal);

			
			if ((! $no) || (! $soal) || (! $jawaban))
			{
				break;
			}
			
			$col = 4;
			$chooses = array();
			while (true)
			{
				if (! isset($this->xlsreader->sheets[0]['cells'][$row][$col])) break;
				
				$choose = trim($this->xlsreader->sheets[0]['cells'][$row][$col]);
				if (! $choose) break;
				
				$choose = preg_replace('/[\x00\x08\x0B\x0C\x0E-\x1F]/', '', $choose);
				$chooses[] = htmlentities($choose);
				$col++;
			}	
			
			// tidak ada data soal
			if ($col == 4) break;							
			
			$data[] = array(
				 "no" => $no
				,"soal" => $soal
				,"jawaban" => $jawaban
				,"pilihan"=>$chooses
			);
			
			$row++;	
		}
		*/

        require_once BASEPATH . "application/libraries/PHPExcel.php";
        require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $data = array();

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            for ($row = 2; $row <= $highestRow; ++ $row) {

                $no = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $soal = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $jawaban = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());

                $soal = preg_replace('/[\x00\x08\x0B\x0C\x0E-\x1F]/', '', $soal);


                if ((! $no) || (! $soal) || (! $jawaban))
                {
                    break;
                }

                $col = 4;
                $chooses = array();
                while (true)
                {
                    $choose = trim($worksheet->getCellByColumnAndRow($col, $row)->getValue());
                    if (! $choose) break;

                    $choose = preg_replace('/[\x00\x08\x0B\x0C\x0E-\x1F]/', '', $choose);
                    $chooses[] = htmlentities($choose);
                    $col++;
                }

                // tidak ada data soal
                if ($col == 4) break;

                $data[] = array(
                    "no" => $no
                ,"soal" => $soal
                ,"jawaban" => $jawaban
                ,"pilihan"=>$chooses
                );
            }
        }
		
		return $data;		
	}
	
	function unitsoaldetailquest()
	{						
		// ambil jabatan id
		$this->db->where("jabatan_name", $_POST['jabatan']);
		$q = $this->db->get("jabatan");
		
		$row = $q->row();
		$_POST['jabatan'] = $row->jabatan_id;
		
		// check apakah pernah diambil
				
		$this->db->where("banksoal_unit_id", $_POST['unitsoal']);
		$this->db->join("training", "history_exam_training = training_id");
		$this->db->join("banksoal_unit", "training_banksoal = banksoal_unit_banksoal");
		$totexam = $this->db->count_all_results("history_exam");
		$this->db->flush_cache();		
				
		$this->db->order_by("banksoal_question_alljabatan", "asc");
		$this->db->order_by("banksoal_question_order", "asc");
		
		$this->db->where("banksoal_question_jabatan", $_POST['jabatan']);		
		$this->db->where("banksoal_question_banksoal", $_POST['unitsoal']);		
		$this->db->or_where("banksoal_question_alljabatan", 1);
		$this->db->where("banksoal_question_banksoal", $_POST['unitsoal']);		
		$this->db->join("banksoal_answer", "banksoal_answer_id = banksoal_question_answer");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		$rows = $q->result();
				
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->banksoal_question_bobot_fmt = $this->config->item("l".strtolower($rows[$i]->banksoal_question_bobot));
			$rows[$i]->banksoal_question_answer_chr = chr($rows[$i]->banksoal_answer_order+ord('A')-1);			
			$rows[$i]->banksoal_question_status_desc = ($rows[$i]->banksoal_question_status == 1) ? $this->config->item("active") : $this->config->item("inactive");
			
			$questid[] = $rows[$i]->banksoal_question_id;
		}
		
		// pilihan
		
		if (isset($questid))
		{			
			$this->db->order_by("banksoal_answer_order", "asc");
			$this->db->where_in("banksoal_answer_question", $questid);
			$q = $this->db->get("banksoal_answer");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				$this->mysmarty->assign("ncol_choose_answer", 0);
			}
			else
			{			
				$rowspilihan = $q->result();
				for($i=0; $i < count($rowspilihan); $i++)
				{
					//dedy 20130320 , pake preg_replace soalnya char \u00000 null bermasalah di ie
					$pilihans[$rowspilihan[$i]->banksoal_answer_question][] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '',  $rowspilihan[$i]->banksoal_answer_text);

				}		
				
				$keys = array_keys($pilihans);								
				for($i=0; $i < count($pilihans[$keys[0]]); $i++)
				{
					$codes[] = chr($i + ord('A'));
				}
				
				$this->mysmarty->assign("ncol_choose_answer", count($pilihans[$keys[0]]));
				$this->mysmarty->assign("choose_answer", $codes);
				$this->mysmarty->assign("questcodes", $codes);				
				
				for($i=0; $i < count($rows); $i++)
				{
					$rows[$i]->pilihans = $pilihans[$rows[$i]->banksoal_question_id];
				}
			}
		}
		else
		{
			$this->mysmarty->assign("ncol_choose_answer", 0);
		}
		$this->mysmarty->assign("totexam", $totexam);	
		$this->mysmarty->assign("list", $rows);	
		$this->mysmarty->assign("jmlsoal", count($rows));	
		
		$this->mysmarty->assign("ladd_soal", $this->config->item("ladd_soal"));		
		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));
		$this->mysmarty->assign("lpacket", $this->config->item("lpacket"));
		$this->mysmarty->assign("ledit_soal", $this->config->item("ledit_soal"));
		$this->mysmarty->assign("lquestion", $this->config->item("lquestion"));		
		$this->mysmarty->assign("lchoose_answer", $this->config->item("lchoose_answer"));
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lunit_soal_question", $this->config->item("lunit_soal_question"));
		$this->mysmarty->assign("lpacket", $this->config->item("lpacket"));		
		$this->mysmarty->assign("lsoal", $this->config->item("lsoal"));
		$this->mysmarty->assign("lkey_answer", $this->config->item("lkey_answer"));		
		$this->mysmarty->assign("confirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));		
		
		$this->mysmarty->display("banksoal/unitsoal/detailquest.html");
	}
	
	function removeunitsoalquest()
	{
		$this->db->where("banksoal_answer_question", $_POST['id']);	
		$this->db->delete("banksoal_answer");		
		$this->db->flush_cache();
		
		$this->db->where("banksoal_question_id", $_POST['id']);	
		$this->db->delete("banksoal_question");		
		$this->db->flush_cache();		
	}
	
	function addunitsoalquest()
	{
		$errs = array();
		
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		
		$pertanyaan = isset($_POST["pertanyaan"]) ? $_POST["pertanyaan"] : "";
		$paket = isset($_POST["paket"]) ? $_POST["paket"] : "";
		$jawaban = isset($_POST["jawaban"]) ? $_POST["jawaban"] : "";
		$bobot = isset($_POST["bobot"]) ? $_POST["bobot"] : "";
		$edit = isset($_POST["edit"]) ? $_POST["edit"] : -1;
		
		if (strlen($pertanyaan) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_question");
		}

		if (strlen($paket) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_packet");
		}
		
		if (strlen($jawaban) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_answer");
		}
		else
		{
			$jawaban = ord($jawaban)-ord('A');
		}
		
		$found = false;
		foreach($_POST['pilihan'] as $pil)
		{
			if (strlen(trim($pil)) == 0)
			{
				$found = true;
				break;
			}
		}
		
		if ($found)
		{
			$errs[] = $this->config->item("lerr_empty_chooice");
		}
				
		echo count($errs);
		echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}

		if ($edit > 0)
		{
			$this->db->where("banksoal_answer_order", $jawaban+1);
			$this->db->where("banksoal_answer_question", $edit);
			$q = $this->db->get("banksoal_answer");	
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				$jawabanid = 0;
			}
			else
			{
				$rowanswer = $q->row();
				$jawabanid = $rowanswer->banksoal_answer_id;
			}
												
			unset($data);
			
			$data['banksoal_question_quest'] = $pertanyaan;
			$data['banksoal_question_packet'] = $paket;
			$data['banksoal_question_bobot'] = $bobot;
			$data['banksoal_question_answer'] = $jawabanid;
			
			$this->db->where("banksoal_question_id", $edit);
			$this->db->update("banksoal_question", $data);
			
			return;
		}
		
		$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
		$this->db->where("banksoal_question_jabatan", $_POST['jabatan']);		
		$this->db->select_max("banksoal_question_order");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			$order = 1;
		}
		else
		{
			$roworder = $q->row();			
			$order = $roworder->banksoal_question_order+1;
		}		
		
		unset($data);
		
		$data['banksoal_question_quest'] = $pertanyaan;
		$data['banksoal_question_banksoal'] = $_POST['unitid'];
		$data['banksoal_question_order'] = $order;
		$data['banksoal_question_status'] = 1;
		$data['banksoal_question_packet'] = $paket;
		$data['banksoal_question_jabatan'] = $_POST['jabatan'];
		$data['banksoal_question_bobot'] = $bobot;
		
		$this->db->insert("banksoal_question", $data);
		$this->db->flush_cache();
		
		$id = $this->db->insert_id();
		
		$oderpil = 1;
		foreach($_POST['pilihan'] as $pil)
		{
			unset($data);		
			
			$data['banksoal_answer_text'] = $pil;
			$data['banksoal_answer_question'] = $id;
			$data['banksoal_answer_order'] = $oderpil;
			
			$this->db->insert("banksoal_answer", $data);
			
			if ($jawaban == ($oderpil-1))
			{
				$jawabanid = $this->db->insert_id();
			}
			
			$this->db->flush_cache();
			
			$oderpil++;
		}
		
		unset($data);
		$data['banksoal_question_answer'] = $jawabanid;
		
		$this->db->where("banksoal_question_id", $id);
		$this->db->update("banksoal_question", $data);
				
	}
	
	/*function getlist()
	{
		$type = isset($_POST['type']) ? $_POST['type'] : "";
		
		$this->db->order_by("banksoal_name", "asc");		
		if ($type)
		{
			$this->db->where("banksoal_type", $type);
		}
		
		$this->db->where("banksoal_status", 1);
		$q = $this->db->get("banksoal");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}
			echo $list[$i]->banksoal_name;			
		}
	}*/

    function getlist()
    {
        $type = isset($_POST['type']) ? $_POST['type'] : "";

        $this->db->order_by("banksoal_name", "asc");
        if ($type)
        {
            $this->db->where("banksoal_type", $type);
        }

        $this->db->where("banksoal_status", 1);
        $q = $this->db->get("banksoal");
        $list = $q->result();
        $data = [];
        for($i=0; $i < count($list); $i++)
        {
            $data[$i] = [
                'name' => $list[$i]->banksoal_name
            ];
        }
        echo json_encode($data);
    }
		
	function showdlgaddsoalbyimport()
	{		
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->display("banksoal/unitsoal/dlgsoalbyimport.html");
	}
		
	function showdlgaddsoal()
	{
						
		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));
		$this->mysmarty->assign("lmudah", $this->config->item("lmudah"));
		$this->mysmarty->assign("lsedang", $this->config->item("lsedang"));
		$this->mysmarty->assign("lsulit", $this->config->item("lsulit"));
		$this->mysmarty->assign("lquestion", $this->config->item("lquestion"));
		$this->mysmarty->assign("lpacket", $this->config->item("lpacket"));
		
		
		for($i=0; $i < 4; $i++)
		{
			$rows[$i]->code = chr(ord('A')+$i);
			$rows[$i]->banksoal_answer_id = $i;
		}
		
		$this->mysmarty->assign("rows", $rows);				
		$this->mysmarty->display("banksoal/unitsoal/dlgsoal1.html");
	}
	
	function showdlgsoal()
	{
		
		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where("banksoal_question_id", $_POST['banksoalid']);		
		$this->db->join("banksoal_question", "banksoal_question_id = banksoal_answer_question");
		$q = $this->db->get("banksoal_answer");
		
		if ($q->num_rows() == 0)
		{
			echo $this->config->item("err_exipred_session");
			return;
		}
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->banksoal_question_quest = htmlspecialchars($rows[$i]->banksoal_question_quest, ENT_QUOTES);
			$rows[$i]->banksoal_answer_text = htmlspecialchars($rows[$i]->banksoal_answer_text, ENT_QUOTES);
			
			$rows[$i]->code = chr(ord('A')+$i);
			$show_bobot = ($rows[$i]->banksoal_question_packet <> "")?1:0;
		}
       
		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));
		$this->mysmarty->assign("lquestion", $this->config->item("lquestion"));
		$this->mysmarty->assign("lpacket", $this->config->item("lpacket"));
		
		$this->mysmarty->assign("lmudah", $this->config->item("lmudah"));
		$this->mysmarty->assign("lsedang", $this->config->item("lsedang"));
		$this->mysmarty->assign("lsulit", $this->config->item("lsulit"));
		
		$this->mysmarty->assign("show_bobot", $show_bobot);
		
		$this->mysmarty->assign("rows", $rows);		
		
		$this->mysmarty->display("banksoal/unitsoal/dlgsoal1.html");
	}
	
	function savesoal($id=0)
	{
		
		$pertanyaan = isset($_POST['inpertanyaan']) ? $_POST['inpertanyaan'] :  "";		
		$packet = isset($_POST['inpacket']) ? $_POST['inpacket'] :  "";		
		$jawaban = isset($_POST['injawaban']) ? $_POST['injawaban'] :  "";
		$pilihan = isset($_POST['inpilihan']) ? $_POST['inpilihan'] :  false;
		$bobot = isset($_POST['inbobot']) ? $_POST['inbobot'] :  false;

		$errs = array();
		if (strlen($pertanyaan) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_question");
		}

		if (! $_POST['istraining'])
		{
			if (strlen($packet) == 0)
			{
				$errs[] = $this->config->item("lerr_empty_packet");
			}
		}

		if (strlen($jawaban) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_answer");
		}
		
		foreach($pilihan as $pil)
		{
			$pil = trim($pil);
						
			if (strlen($pil) == 0)
			{
					$errs[] = $this->config->item("lempty_chooice");
					break;
			}
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			$err = str_replace("\"", "'", $html);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";
						
			//echo json_encode(array("err"=>1, "message"=>$html));			
			return;
		}		
		
		unset($data);
		
		$data['banksoal_question_quest'] = $pertanyaan;
		$data['banksoal_question_answer'] = $jawaban;
		$data['banksoal_question_packet'] = (! $_POST['istraining']) ? $packet : NULL;
		$data['banksoal_question_bobot'] = $bobot;
	
		if ($id)
		{
			$this->db->where("banksoal_question_id", $id);			
			$this->db->update("banksoal_question", $data);
			$this->db->flush_cache();
			
			$i = (! $_POST['istraining']) ? 1 : 0;
			foreach ($pilihan as $pil)
			{
				unset($data);
				
				$data['banksoal_answer_text'] = $pil;
				
				$this->db->where("banksoal_answer_question", $id);
				$this->db->where("banksoal_answer_order", $i++);				
				$this->db->update("banksoal_answer", $data);				
				$this->db->flush_cache();
			}			
			
			echo "<script>parent.setSuccess(\"".$this->config->item("ok_update_banksoal")."\")</script>";
			return;
		}	
		
		// pastikan apakah all jabatan ato bukan
		
		$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
		$this->db->distinct();		
		$this->db->select("banksoal_question_alljabatan");				
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if (! $_POST['istraining'])
		{
			$isalljabatan = false;
			
			if ($q->num_rows() > 0)
			{
				$rowalljabatan = $q->row();
				$isalljabatan = $rowalljabatan->banksoal_question_alljabatan = 1;
			}
		}
				
		$this->db->select("MAX(banksoal_question_order) _max");
		if (! $_POST['istraining'])
		{
			if (! $isalljabatan)
			{
				$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
				$this->db->where("banksoal_question_jabatan", $_POST['jabatanid']);
				$this->db->where("banksoal_question_alljabatan", 0);
			}
			else
			{
				$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
				$this->db->where("banksoal_question_alljabatan", 1);
			}
		}
		else
		{
			$this->db->where("banksoal_question_banksoal", $_POST['banksoalid']);
		}
		
		$q = $this->db->get("banksoal_question");
		
		if ($q->num_rows() == 0)
		{
			$order = 1;
		}
		else
		{
			$roworder = $q->row();
			$order = $roworder->_max+1;
		}
	
		unset($data);
		
		$data['banksoal_question_quest'] = $pertanyaan;
		$data['banksoal_question_answer'] = $jawaban;
		if (! $_POST['istraining'])
		{
			$data['banksoal_question_packet'] = $packet;
			$data['banksoal_question_bobot'] = $bobot;		
			$data['banksoal_question_banksoal'] = $_POST['unitid'];
			
			if (! $isalljabatan)
			{
				$data['banksoal_question_jabatan'] = $_POST['jabatanid'];
				$data['banksoal_question_alljabatan'] = 0;
			}
			else
			{
				$data['banksoal_question_jabatan'] = 0;
				$data['banksoal_question_alljabatan'] = 1;
			}
		}
		else
		{
			//$data['banksoal_question_packet'] = "";
			//$data['banksoal_question_bobot'] = 0;	
			$data['banksoal_question_banksoal'] = $_POST['banksoalid'];	
			//$data['banksoal_question_jabatan'] = 0;
		}
		
		$data['banksoal_question_answer'] = 0;
		$data['banksoal_question_order'] = $order;				
		$data['banksoal_question_status'] = 1;		
				
		$this->db->insert("banksoal_question", $data);		
		$lastid = $this->db->insert_id();
				
		$i = (! $_POST['istraining']) ? 1 : 0;
		foreach ($pilihan as $pil)
		{
			unset($data);
			
			$data['banksoal_answer_text'] = $pil;
			$data['banksoal_answer_question'] = $lastid;
			$data['banksoal_answer_order'] = $i;
			
			$this->db->insert("banksoal_answer", $data);
			$this->db->flush_cache();
			
			if (! $_POST['istraining'])
			{
				if (($i-1) == $jawaban)
				{
					$answerid = $this->db->insert_id();
				}
			}
			else
			{
				if ($i == $jawaban)
				{
					$answerid = $this->db->insert_id();
				}
			}
			
			$i++;
		}
		
		unset($data);
		$data['banksoal_question_answer'] = $answerid;
		
		$this->db->where("banksoal_question_id", $lastid);
		$this->db->update("banksoal_question", $data);
		
		echo "<script>parent.setSuccess(\"".$this->config->item("ok_add_soal")."\")</script>";
	}
	
	function changesoalstatus()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($_POST['id']))
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		
		$this->db->where("banksoal_question_id", $_POST['id']);
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$row = $q->row();
		
		unset($data);
		
		$data['banksoal_question_status'] = ($row->banksoal_question_status == 1) ? 2 : 1;
		
		$this->db->where("banksoal_question_id", $_POST['id']);
		$this->db->update("banksoal_question", $data);
		
		echo '<img src="'.base_url().'images/16/'.(($data['banksoal_question_status'] == 2) ? "inactive.png" : "active.png").'" border="0" title="'.(($data['banksoal_question_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($data['banksoal_question_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
	}	
	
	function history($id)
	{
		$this->db->where("banksoal_id", $id);
		$q = $this->db->get("banksoal");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();

		$this->db->where("banksoal_unit_banksoal", $id);
		$q = $this->db->get("banksoal_unit");
		$this->db->flush_cache();

		/*
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		*/
		
		$units = $q->result();
		
		$this->mysmarty->assign("banksoal", $row);
		$this->mysmarty->assign("units", $units);
		$this->mysmarty->assign("pageid", "certificate");

		$this->mysmarty->assign("lhistory", $this->config->item('lhistory'));
		$this->mysmarty->assign("lunit", $this->config->item('unit'));		
		$this->mysmarty->assign("ljabatan", $this->config->item('jabatan'));
		$this->mysmarty->assign("lwrong_answered", $this->config->item('lwrong_answered'));
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/history.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function historytraining($id, $action="")
	{
		$this->db->where("banksoal_id", $id);
		$q = $this->db->get("banksoal");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();

		$this->db->order_by("banksoal_question_order", "asc");
		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where("banksoal_question_banksoal", $id);
		
		$this->db->join("banksoal_question", "banksoal_question_id = banksoal_answer_question");
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();
		
		$rows = $q->result();

		$this->db->where("training_exam_banksoal", $id);			
		$this->db->where("training_exam_type", 2);
		$this->db->where("history_exam_type", 2);
		
		$this->db->join("history_exam", "history_exam_id = history_answer_history_exam");
		$this->db->join("training", "training_id = history_exam_training");		
		$this->db->join("training_exam", "training_id = training_exam_training");
		
		$q = $this->db->get("history_answer");
		$this->db->flush_cache();
		
		$rowexams = $q->result();						
		
		for($i=0; $i < count($rowexams); $i++)
		{
			$exams[$rowexams[$i]->history_answer_question][] = $rowexams[$i];
		}

		$hist = array();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->banksoal_answer_order_alpha = chr(ord('A') + $rows[$i]->banksoal_answer_order);
			
			if ($rows[$i]->banksoal_question_answer == $rows[$i]->banksoal_answer_id)
			{
				$rows[$i]->banksoal_question_answer_alpha = chr(ord('A') + $rows[$i]->banksoal_answer_order);
				
				if (! isset($hist[$rows[$i]->banksoal_question_id]['right']))
				{
					$hist[$rows[$i]->banksoal_question_id]['right'] = 0;
				}
				
				if (isset($exams[$rows[$i]->banksoal_question_id]))
				{
					for($j=0; $j < count($exams[$rows[$i]->banksoal_question_id]); $j++)
					{
						if ($exams[$rows[$i]->banksoal_question_id][$j]->history_answer_answer == $rows[$i]->banksoal_answer_id)
						{
							$hist[$rows[$i]->banksoal_question_id]['right']++;
						}
					}
				}				
			}
			
			$hist[$rows[$i]->banksoal_question_id]['data'][] = $rows[$i];
			$hist[$rows[$i]->banksoal_question_id]['shown'] = isset($exams[$rows[$i]->banksoal_question_id]) ? count($exams[$rows[$i]->banksoal_question_id]) : 0;
		}
		
		if (count($hist))
		{
			foreach($hist as $key=>$val)
			{
				if (isset($hist[$key]['right']))
				{
					$hist[$key]['wrong'] = $hist[$key]['shown'] - $hist[$key]['right'];
				}
				else
				{
					$hist[$key]['right'] = 0;
					$hist[$key]['wrong'] = $hist[$key]['shown'];
				}
			}
		}		
		
		if ($action == "export")
		{
			$this->load->library("xlswriter");			
			$this->xlswriter->send(date("Ymd-His")."-training-".slug($row->banksoal_name).".xls");
			//$worksheet =& $this->xlswriter->addWorksheet("history ".$row->banksoal_name);
			$worksheet =& $this->xlswriter->addWorksheet("history");
			
			$worksheet->write(0, 0, 'Question');
			$worksheet->write(0, 1, 'Chooice A');
			$worksheet->write(0, 2, 'Chooice B');
			$worksheet->write(0, 3, 'Chooice C');
			$worksheet->write(0, 4, 'Chooice D');
			$worksheet->write(0, 5, 'Answer');
			$worksheet->write(0, 6, 'Shown');
			$worksheet->write(0, 7, 'Right Answered');
			$worksheet->write(0, 8, 'Wrong Answered');
			
			if (count($hist))
			{
				$irow = 1;
				foreach($hist as $val)
				{
					$worksheet->write($irow, 0, $val['data'][0]->banksoal_question_quest);
					
					for($i=0; $i < 4; $i++)
					{
						if (! isset($val['data'][$i]->banksoal_answer_text)) break;
						$worksheet->write($irow, 1+$i, $val['data'][$i]->banksoal_answer_text);
					}
					
					$jawaban = "";
					for($i=0; $i < 4; $i++)
					{
						if (! isset($val['data'][$i]->banksoal_question_answer_alpha)) continue;
						
						$jawaban = $val['data'][$i]->banksoal_question_answer_alpha;
					}
					
					$worksheet->write($irow, 5, $jawaban);
					$worksheet->write($irow, 6, $val['shown']);
					$worksheet->write($irow, 7, $val['right']);
					$worksheet->write($irow, 8, $val['wrong']);
					
					$irow++;
				}
			}
			
			$this->xlswriter->close();
			
			return;
		}
						
		$this->mysmarty->assign("banksoal", $row);
		$this->mysmarty->assign("hist", $hist);
				
		$this->mysmarty->assign("pageid", "training");
		$this->mysmarty->assign("lhistory", $this->config->item('lhistory'));
		$this->mysmarty->assign("lno", $this->config->item('lno'));		
		$this->mysmarty->assign("lquestion", $this->config->item('lquestion'));
		$this->mysmarty->assign("lanswer", $this->config->item('lanswer'));
		$this->mysmarty->assign("lshown", $this->config->item('lshown'));
		$this->mysmarty->assign("lright_answered", $this->config->item('lright_answered'));
		$this->mysmarty->assign("lwrong_answered", $this->config->item('lwrong_answered'));
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "banksoal/historytraining.html");
		$this->mysmarty->display("sess_template.html");			
	}
	
	function historydetail($id, $action="")
	{
		$unitid = isset($_POST['unitid']) ? $_POST['unitid'] : 0;		
		$jabatanid = isset($_POST['jabatanid']) ? $_POST['jabatanid'] : 0;		
		
		$this->db->distinct();
		$this->db->select("jabatan_id");
		$this->db->where("jabatan_name", $jabatanid);
		$q = $this->db->get("jabatan");
		$this->db->flush_cache();
		
		$rows = $q->result();
		$jabatanids[] = 0;
		$jabatanids1[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			if ($i == 0)
			{
				$jabatanids[] = $rows[$i]->jabatan_id;
			}			
			$jabatanids1[] = $rows[$i]->jabatan_id;
		}
		
		$this->db->where("banksoal_id", $id);
		$q = $this->db->get("banksoal");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$postfix = "";
		if ($row->banksoal_status == 2)
		{
			$postfix = "_archive";
		}
				
		$this->db->order_by("banksoal_question_order", "asc");
		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where("banksoal_unit_banksoal", $id);
		$this->db->where("banksoal_question_packet <>", "NULL");		
		$this->db->where_in("banksoal_question_jabatan", $jabatanids1);
		
		if ($unitid)
		{
			$this->db->where("banksoal_unit_id", $unitid);
		}
				
		$this->db->join("banksoal_question".$postfix, "banksoal_question_id = banksoal_answer_question");
		$this->db->join("banksoal_unit", "banksoal_unit_id = banksoal_question_banksoal");		
		$q = $this->db->get("banksoal_answer".$postfix);
		$this->db->flush_cache();
		
		$rows = $q->result();						
		
		$this->db->order_by("banksoal_question_order", "asc");
		$this->db->where("banksoal_id", $id);			
		$this->db->where_in("banksoal_question_jabatan", $jabatanids1);
		$this->db->join("banksoal_question".$postfix, "history_answer_question = banksoal_question_id");
		$this->db->join("banksoal_answer".$postfix, "banksoal_answer_id = history_answer_answer", "left outer");
		$this->db->join("history_exam", "history_exam_id = history_answer_history_exam", "left outer");
		$this->db->join("training", "training_id = history_exam_training");
		$this->db->join("banksoal", "banksoal_id = training_banksoal");
		$q = $this->db->get("history_answer");
		$this->db->flush_cache();
		
		$rowexams = $q->result();		
		for($i=0; $i < count($rowexams); $i++)
		{
			$exams[$rowexams[$i]->banksoal_question_packet][$rowexams[$i]->banksoal_question_quest][] = $rowexams[$i];
		}

		$hist = array();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->banksoal_answer_order_alpha = chr(ord('A') + $rows[$i]->banksoal_answer_order - 1);
			$rows[$i]->banksoal_answer_text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '',  $rows[$i]->banksoal_answer_text);
			$rows[$i]->banksoal_question_quest = preg_replace('/[\x00-\x1F\x80-\xFF]/', '',  $rows[$i]->banksoal_question_quest);
			
			if ($rows[$i]->banksoal_question_answer == $rows[$i]->banksoal_answer_id)
			{
				$rows[$i]->banksoal_question_answer_alpha = chr(ord('A') + $rows[$i]->banksoal_answer_order - 1);
	
				if (! isset($hist[$rows[$i]->banksoal_question_id]['right']))
				{
					$hist[$rows[$i]->banksoal_question_id]['right'] = 0;
				}
				
				if (isset($exams[$rows[$i]->banksoal_question_packet][$rows[$i]->banksoal_question_quest]))
				{
					for($j=0; $j < count($exams[$rows[$i]->banksoal_question_packet][$rows[$i]->banksoal_question_quest]); $j++)
					{
						if ($exams[$rows[$i]->banksoal_question_packet][$rows[$i]->banksoal_question_quest][$j]->banksoal_answer_order == $rows[$i]->banksoal_answer_order)
						{
							$hist[$rows[$i]->banksoal_question_id]['right']++;
						}
					}
				}				
			}
			
			$hist[$rows[$i]->banksoal_question_id]['data'][] = $rows[$i];
			$hist[$rows[$i]->banksoal_question_id]['shown'] = isset($exams[$rows[$i]->banksoal_question_packet][$rows[$i]->banksoal_question_quest]) ? count($exams[$rows[$i]->banksoal_question_packet][$rows[$i]->banksoal_question_quest]) : 0;
		}
		
		if (count($hist))
		{
			foreach($hist as $key=>$val)
			{
				if (isset($hist[$key]['right']))
				{
					$hist[$key]['wrong'] = $hist[$key]['shown'] - $hist[$key]['right'];
				}
				else
				{
					$hist[$key]['right'] = 0;
					$hist[$key]['wrong'] = $hist[$key]['shown'];
				}
			}
		}
		
		$lrightanswered = $this->config->item('lrightanswered');
		$lwronganswered = $this->config->item('lwronganswered');
		
		$this->mysmarty->assign("lsedang", $this->config->item('lsedang'));		
		$this->mysmarty->assign("lmudah", $this->config->item('lmudah'));		
		$this->mysmarty->assign("lsulit", $this->config->item('lsulit'));		
		
		
		if ($action == "export")
		{
			$this->load->library("xlswriter");			
			$this->xlswriter->send(date("Ymd-His")."-certificate-".slug($row->banksoal_name).".xls");
			$worksheet =& $this->xlswriter->addWorksheet("history");
			
			$worksheet->write(0, 0, $this->config->item('lpacket'));
			$worksheet->write(0, 1, $this->config->item('lquestion'));
			$worksheet->write(0, 2, 'Chooice A');
			$worksheet->write(0, 3, 'Chooice B');
			$worksheet->write(0, 4, 'Chooice C');
			$worksheet->write(0, 5, 'Chooice D');
			$worksheet->write(0, 6, $this->config->item('lanswer'));
			$worksheet->write(0, 7, $this->config->item('lbobot'));
			$worksheet->write(0, 8, $this->config->item('lshown'));
			$worksheet->write(0, 9, $lrightanswered);
			$worksheet->write(0, 10, $lwronganswered);
			
			if (count($hist))
			{
				$irow = 1;
				foreach($hist as $val)
				{
					$worksheet->write($irow, 0, $val['data'][0]->banksoal_question_packet);
					$worksheet->write($irow, 1, $val['data'][0]->banksoal_question_quest);
					
					for($i=0; $i < 4; $i++)
					{
						if (! isset($val['data'][$i]->banksoal_answer_text)) break;
						$worksheet->write($irow, 2+$i, $val['data'][$i]->banksoal_answer_text);
					}
					
					$jawaban = "";
					for($i=0; $i < 4; $i++)
					{
						if (! isset($val['data'][$i]->banksoal_question_answer_alpha)) continue;
						
						$jawaban = $val['data'][$i]->banksoal_question_answer_alpha;
					}
					
					$lbobots = "";
					switch(strtoupper($val['data'][0]->banksoal_question_bobot)){
						case "MUDAH" :
							$lbobots = $this->config->item('lmudah');
						break;
						case "SEDANG" :
							$lbobots = $this->config->item('lsedang');
						break;
						case "SULIT" :
							$lbobots = $this->config->item('lsulit');
						break;
						
					}
					
					$worksheet->write($irow, 6, $jawaban);
					//$worksheet->write($irow, 7, $val['data'][0]->banksoal_question_bobot);
					$worksheet->write($irow, 7, $lbobots);
					
					$worksheet->write($irow, 8, $val['shown']);
					$worksheet->write($irow, 9, $val['right']);
					$worksheet->write($irow, 10, $val['wrong']);
					
					$irow++;
				}
			}
			
			$this->xlswriter->close();
			
			return;
		}
		
						
		$this->mysmarty->assign("hist", $hist);		
				
		$this->mysmarty->assign("lpacket", $this->config->item('lpacket'));		
		$this->mysmarty->assign("lno", $this->config->item('lno'));		
		$this->mysmarty->assign("lquestion", $this->config->item('lquestion'));
		$this->mysmarty->assign("lanswer", $this->config->item('lanswer'));
		$this->mysmarty->assign("lbobot", $this->config->item('lbobot'));		
		$this->mysmarty->assign("lshown", $this->config->item('lshown'));
		$this->mysmarty->assign("lright_answered", $this->config->item('lright_answered'));
		$this->mysmarty->assign("lwrong_answered", $this->config->item('lwrong_answered'));
		
		$this->mysmarty->display("banksoal/historydetail.html");		
	}
	
	function wronganswertraining()
	{
		$this->db->where("banksoal_answer_id", $_POST['aid']);
		$q = $this->db->get("banksoal_answer");
		$this->db->flush_cache();
		
		$rowanswer = $q->row();
		
		$this->db->where("banksoal_question_id", $_POST['qid']);
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();
		
		$row = $q->row();
		
		$this->db->where("banksoal_question_packet", $row->banksoal_question_packet);
		$this->db->where("banksoal_question_quest", $row->banksoal_question_quest);
		$this->db->where("banksoal_question_banksoal", $row->banksoal_question_banksoal);
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		$rows = $q->result();
		$qids[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$qids[] = $rows[$i]->banksoal_question_id;
		}
				
		$this->db->where_in("history_answer_question", $qids);
		$this->db->where("history_exam_type", $_POST['t']);		
		$this->db->join("banksoal_answer", "history_answer_answer = banksoal_answer_id", "left outer");
		$this->db->join("history_exam", "history_exam_id = history_answer_history_exam");
		$q = $this->db->get("history_answer");
		$this->db->flush_cache();

		$rowexams = $q->result();
				
		$exams = array();
		for($i=0; $i < count($rowexams); $i++)
		{
			if ($rowexams[$i]->banksoal_answer_order == $rowanswer->banksoal_answer_order) 
				continue;
			
			if ($_POST['t'] == 3)
			{
				if (strlen($rowexams[$i]->banksoal_answer_order)) 
				{
					$idx = chr($rowexams[$i]->banksoal_answer_order+ord('A')-1);
				}
				else
				{
					$idx = $this->config->item("lnoanswer");
				}
			}
			else
			{
				if (strlen($rowexams[$i]->banksoal_answer_order)) 				
				{
					$idx = chr($rowexams[$i]->banksoal_answer_order+ord('A'));
				}
				else
				{
					$idx = $this->config->item("lnoanswer");
				}
			}
			
			if (! isset($exams[$idx]))
			{
				$exams[$idx] = 0;
			}
			
			$exams[$idx]++;
		}
		
		uksort($exams, 'sorta');
		
		$this->mysmarty->assign("exams", $exams);
		$this->mysmarty->display("banksoal/wronganswered.html");
	}
	
	function jabatanperunit($banksoal)
	{
		$unitid = isset($_POST['unitid']) ? $_POST['unitid'] : 0;
		
		$this->db->distinct();
		$this->db->select("jabatan_name");
		$this->db->join("jabatan", "jabatan_id = banksoal_question_jabatan");
		$this->db->where("banksoal_question_banksoal", $unitid);
		$q = $this->db->get("banksoal_question");		
		$rows = $q->result();
		
		$this->mysmarty->assign("rows", $rows);
		$html = $this->mysmarty->fetch("banksoal/jabatanselectbox.html");
		
		echo json_encode(array("html"=>$html));
	}
}

function sorta($a, $b)
{
	if (! in_array($a, array('A', 'B', 'C', 'D'))) return 1;
	if (! in_array($b, array('A', 'B', 'C', 'D'))) return -1;
	
	return strcasecmp($a, $b);
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
