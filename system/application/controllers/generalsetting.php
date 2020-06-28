<?php
include_once "base.php"; 

class GeneralSetting extends Base{
	var $sess;
	var $lang;
	var $modules;

	function GeneralSetting()
	{
		//parent::Controller();	
		parent::Base();	
	
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		$this->load->helper('file');
		
		$this->load->model("usermodel");
		$this->load->model("langmodel");
		$this->load->model("levelmodel");
		$this->load->model("commonmodel");
		$this->load->model("trainingmodel");
		
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
			if (! isset($this->modules['master']))
			{
				if ($this->uri->segment(2) != "errmessage")
				{
					redirect(base_url());
				}
			}
		}
		else 
		{
			redirect(base_url());
		}

		$this->langmodel->init();
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu());		
	}
	
	function index()
	{

		$extra_option_approval = $this->db->select('jabatan_id,jabatan_name')->group_by('jabatan_name')->order_by('jabatan_name')->get("jabatan")->result_array();
		$this->mysmarty->assign("extra_option_approval", $extra_option_approval);
				
		$q = $this->db->get("general_setting");
		$rows = $q->result();
		
		$settings = array();
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->general_setting_code] = $rows[$i]->general_setting_value;
		}
		
		if (isset($settings['websitelogo']))
		{
			$websitelogo = "<img src='".base_url()."uploads/logo/".$settings['websitelogo']."' border='0' />";
		}
		else
		{
			$websitelogo = "<img src='".base_url()."images/web-pole.gif' border='0' />";
		}

		if (isset($settings['pageloginimage']))
		{
			$pageloginimage = "<img width='400' src='".base_url()."uploads/".$settings['pageloginimage']."' border='0' />";
		}
		else
		{
			$pageloginimage = "";
		}
		
		for($i=0; $i < 10; $i++)
		{
			$maxresourcetypes[]['no'] = $i+1;
		}
		
		if (isset($settings['resourcetype']))
		{
			$resourcetype = unserialize($settings['resourcetype']);
			$resourcetype = array_values(array_filter($resourcetype));
			
			$i = 0;
			$nresourcetype = 0;
			while(true)
			{
				if (! isset($resourcetype[$i+1])) break;				
				
				if (strlen($resourcetype[$i+1]) == 0)
				{
					$i++;
					continue;
				}
				
				$maxresourcetypes[$i]['value'] = $resourcetype[$i+1];
				$nresourcetype++;
				$i++;
			}
			
			$nresourcetype++;
		}
		else
		{
			$resourcetype = false;
			$nresourcetype = 0;
		}

		$settings['total_step_approval'] = !empty($settings['total_step_approval']) ? $settings['total_step_approval'] : 1;
		$settings['user_approval_request_training'] = !empty($settings['user_approval_request_training']) ? unserialize($settings['user_approval_request_training']) : array();

		foreach($settings['user_approval_request_training'] as $kMain => $vMain) {
			$arr_detail = array();
			if(!empty($vMain)) {
				$tmp = join(',', $vMain);
				$res = $this->db->select('user_id, user_npk, user_first_name, jabatan_name', false)->join('jabatan', 'user_jabatan=jabatan_id', 'LEFT')->join('level_group', 'jabatan_level_group=level_group_id', 'LEFT')->where('user_id IN ('.$tmp.') AND user_status = 1')->get('user')->result_array();
				foreach ($res as $key => $value) {
					$arr_detail[$value['user_id']] = array(
						'id' => $value['user_id'],
						'name' => ($value['user_first_name'] . ' (NPK: ' . $value['user_npk'] . ', Jabatan: ' . $value['jabatan_name'] . ')')
					);
				}
			}
			$settings['hd_step_approval'][$kMain]['detail'] = $arr_detail;
		}

		if(empty($settings['hd_step_approval'])) {
			$settings['hd_step_approval'][1]['detail'] = array();
		}
		
		$defaultlang = (isset($settings['defaultlang'])) ? $settings['defaultlang'] :  $this->config->item("lang");				
				
		$this->mysmarty->assign("websitelogo", $websitelogo);						
		$this->mysmarty->assign("pageloginimage", $pageloginimage);						
		$this->mysmarty->assign("linactive_period", $this->config->item("linactive_period"));
		$this->mysmarty->assign("lsetting_expiredpassword", $this->config->item("lsetting_expiredpassword"));
		$this->mysmarty->assign("lsetting_errorlogin", $this->config->item("lsetting_errorlogin"));
		$this->mysmarty->assign("ok_save_general_setting", $this->config->item("ok_save_general_setting"));		
		
		$this->mysmarty->assign("nresourcetype", $nresourcetype);		
		$this->mysmarty->assign("resourcetype", $resourcetype);
		$this->mysmarty->assign("maxresourcetypes", $maxresourcetypes);
		$this->mysmarty->assign("setting", $settings);
		$this->mysmarty->assign("general_settings", $this->config->item("lgeneralsetting"));
		$this->mysmarty->assign("lerror_login_description", $this->config->item("lerror_login_description"));
		
		$this->mysmarty->assign("linactive_period_description", $this->config->item("linactive_period_description"));
		$this->mysmarty->assign("lexpired_password_description", $this->config->item("lexpired_password_description"));
		$this->mysmarty->assign("lconcurent_user", $this->config->item("lconcurent_user"));
		$this->mysmarty->assign("lconcurent_user_description", $this->config->item("lconcurent_user_description"));
		$this->mysmarty->assign("lrecordperpage", $this->config->item("lrecordperpage"));
		$this->mysmarty->assign("lrecordperpage_description", $this->config->item("lrecordperpage_description"));
		$this->mysmarty->assign("recordperpage", $this->config->item("data_per_page"));	
		$this->mysmarty->assign("lwebsitetitle", $this->config->item("lwebsitetitle"));
		$this->mysmarty->assign("lwebsitetitle_description", $this->config->item("lwebsitetitle_description"));		
		$this->mysmarty->assign("lwebsitelogo", $this->config->item("lwebsitelogo"));
		$this->mysmarty->assign("lwebsitelogo_description", $this->config->item("lwebsitelogo_description"));
		$this->mysmarty->assign("ldefaultlanguange", $this->config->item("ldefaultlanguange"));		
		$this->mysmarty->assign("ldefaultlanguange_description", $this->config->item("ldefaultlanguange_description"));	
		$this->mysmarty->assign("lndonesia", $this->config->item("lndonesia"));	
		$this->mysmarty->assign("lenglish", $this->config->item("lenglish"));	
		$this->mysmarty->assign("defaultlang", $defaultlang);	
		$this->mysmarty->assign("lmultiple_login", $this->config->item("lmultiple_login"));			
		$this->mysmarty->assign("lmultiple_login_description", $this->config->item("lmultiple_login_description"));					

		$this->mysmarty->assign("sessiontimeout", $this->config->item("sess_expiration"));
		$this->mysmarty->assign("lsession_idle_time", $this->config->item("lsession_idle_time"));
		$this->mysmarty->assign("lsession_idle_time_description", $this->config->item("lsession_idle_time_description"));
		$this->mysmarty->assign("websitetitle", $this->config->item("websitetitle"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lresource_setting", $this->config->item("lresource_setting"));
		$this->mysmarty->assign("lmaximum_size", $this->config->item("lmaximum_size"));		
		$this->mysmarty->assign("lmaximum_size_description", $this->config->item("lmaximum_size_description"));	
		$this->mysmarty->assign("ladd_recourcetype", $this->config->item("ladd_recourcetype"));
		$this->mysmarty->assign("lresource_type", $this->config->item("lresource_type"));	
		$this->mysmarty->assign("lresource_type_description", $this->config->item("lresource_type_description"));	
		$this->mysmarty->assign("lcertificate_sign", $this->config->item("lcertificate_sign"));
		$this->mysmarty->assign("lcertificate_sign_description", $this->config->item("lcertificate_sign_description"));
		$this->mysmarty->assign("lsmtp_host", $this->config->item("lsmtp_host"));
		$this->mysmarty->assign("lsmtp_host_description", $this->config->item("lsmtp_host_description"));
		$this->mysmarty->assign("lsmtp_user", $this->config->item("lsmtp_user"));
		$this->mysmarty->assign("lsmtp_user_description", $this->config->item("lsmtp_user_description"));
		$this->mysmarty->assign("lsmtp_password", $this->config->item("lsmtp_password"));
		$this->mysmarty->assign("lsmtp_password_description", $this->config->item("lsmtp_password_description"));
		$this->mysmarty->assign("lday_interval", $this->config->item("lday_interval"));
		$this->mysmarty->assign("lday_interval_description", $this->config->item("lday_interval_description"));		
		$this->mysmarty->assign("lnotice_per", $this->config->item("lnotice_per"));
		$this->mysmarty->assign("lnotice_per_description", $this->config->item("lnotice_per_description"));		

		$this->mysmarty->assign("lremindermailsubject", $this->config->item("lremindermailsubject"));
		$this->mysmarty->assign("lremindermailsubjectdescription", $this->config->item("lremindermailsubjectdescription"));		
		$this->mysmarty->assign("lremindermailsender", $this->config->item("lremindermailsender"));
		$this->mysmarty->assign("lremindermailsenderdescription", $this->config->item("lremindermailsenderdescription"));	
		$this->mysmarty->assign("lremindermailsendername", $this->config->item("lremindermailsendername"));
		$this->mysmarty->assign("lremindermailsendernamedescription", $this->config->item("lremindermailsendernamedescription"));
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));
		$this->mysmarty->assign("lsmtp_port", $this->config->item("lsmtp_port"));		
		$this->mysmarty->assign("lmail_type", $this->config->item("lmail_type"));	
		$this->mysmarty->assign("lmail_setting", $this->config->item("lmail_setting"));		
		$this->mysmarty->assign("lmail_contenttype", $this->config->item("lmail_contenttype"));		
		$this->mysmarty->assign("lmaxchangepassword", $this->config->item("lmaxchangepassword"));
		$this->mysmarty->assign("lshow_materi_history", $this->config->item("lshow_materi_history"));
		$this->mysmarty->assign("lyes", $this->config->item("lyes"));
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		$this->mysmarty->assign("lmaximumtaken", $this->config->item("lmaximumtaken"));		
		$this->mysmarty->assign("lpasschange1st", $this->config->item("lpasschange1st"));		
		$this->mysmarty->assign("lcertificate_template", $this->config->item("lcertificate_template"));		
		$this->mysmarty->assign("lcertificate_template_desc", $this->config->item("lcertificate_template_desc"));		
		
		$this->mysmarty->assign("lsetting_minpasswordlength", $this->config->item("lsetting_minpasswordlength"));
		$this->mysmarty->assign("lsetting_minpasswordlength_description", $this->config->item("lsetting_minpasswordlength_description"));
		$this->mysmarty->assign("lsetting_maxpasswordlength", $this->config->item("lsetting_maxpasswordlength"));
		$this->mysmarty->assign("lsetting_maxpasswordlength_description", $this->config->item("lsetting_maxpasswordlength_description"));

		$this->mysmarty->assign("lsetting_passwordchar", $this->config->item("lsetting_passwordchar"));
		$this->mysmarty->assign("lsetting_passwordchar_description", $this->config->item("lsetting_passwordchar_description"));
		$this->mysmarty->assign("lsetting_passchar_alphanumeric", $this->config->item("lsetting_passchar_alphanumeric"));
		$this->mysmarty->assign("lsetting_passchar_free", $this->config->item("lsetting_passchar_free"));

		$this->mysmarty->assign("ltraining_template_print", $this->config->item("ltraining_template_print"));
		$this->mysmarty->assign("ltraining_template_print_desc", $this->config->item("ltraining_template_print_desc"));
		$this->mysmarty->assign("lsession",$this->config->item("lsession"));
		$this->mysmarty->assign("lpassword_setting",$this->config->item("lpassword_setting"));
		$this->mysmarty->assign("lelearning",$this->config->item("lelearning"));
		$this->mysmarty->assign("lelearning_setting",$this->config->item("lelearning_setting"));
		
		$this->mysmarty->assign("ltraining",$this->config->item("ltraining"));
		$this->mysmarty->assign("lcertificate",$this->config->item("lcertificate"));
		
		$this->mysmarty->assign("ltraining_setting",$this->config->item("ltraining_setting"));
		$this->mysmarty->assign("lcertification_setting",$this->config->item("lcertification_setting"));
		
		$this->mysmarty->assign("lshow_print_certificate",$this->config->item("lshow_print_certificate"));
		$this->mysmarty->assign("lshow_min_lulus",$this->config->item("lshow_min_lulus"));
		
		$this->mysmarty->assign("lshow_print_certificate_training_desc",$this->config->item("lshow_print_certificate_training_desc"));
		$this->mysmarty->assign("lshow_min_lulus_training_desc",$this->config->item("lshow_min_lulus_training_desc"));
		
		$this->mysmarty->assign("lshow_print_certificate_desc",$this->config->item("lshow_print_certificate_desc"));
		$this->mysmarty->assign("lshow_min_lulus_certificate_desc",$this->config->item("lshow_min_lulus_certificate_desc"));
		
		$this->mysmarty->assign("lenablechangelanguange",$this->config->item("lenablechangelanguange"));
		$this->mysmarty->assign("lshowildp",$this->config->item("lshowildp"));
		
		$this->mysmarty->assign("lpasschange1stdescription",$this->config->item("lpasschange1stdescription"));
		$this->mysmarty->assign("lmaxchangepassworddescription",$this->config->item("lmaxchangepassworddescription"));
		$this->mysmarty->assign("lmaximumtakendescription",$this->config->item("lmaximumtakendescription"));
		$this->mysmarty->assign("lshow_materi_history_description",$this->config->item("lshow_materi_history_description"));
		$this->mysmarty->assign("lcareer_aspiration",$this->config->item("lcareer_aspiration"));		
		$this->mysmarty->assign("lshort_term",$this->config->item("lshort_term"));		
		$this->mysmarty->assign("llong_term",$this->config->item("llong_term"));		
		$this->mysmarty->assign("lshort_term_description",$this->config->item("lshort_term_description"));		
		$this->mysmarty->assign("llong_term_description",$this->config->item("llong_term_description"));		
		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "generalsetting/form.html");
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
		
		$websitetitle = isset($_POST['websitetitle']) ? trim($_POST['websitetitle']) : "";
		$inactiveperiod = isset($_POST['inactiveperiod']) ? trim($_POST['inactiveperiod']) : 0;
		$expiredpassword = isset($_POST['expiredpassword']) ? trim($_POST['expiredpassword']) : 0;
		$errorlogin = isset($_POST['errorlogin']) ? trim($_POST['errorlogin']) : 0;
		$concurrentuser = isset($_POST['concurrentuser']) ? trim($_POST['concurrentuser']) : 0;		
		$recordperpage = isset($_POST['recordperpage']) ? trim($_POST['recordperpage']) : 0;
		$sessiontimeout = isset($_POST['sessiontimeout']) ? trim($_POST['sessiontimeout']) : 0;	
		$resourcetype = isset($_POST['resourcetype']) ? $_POST['resourcetype'] : "";	
		$resourcemaxsize = isset($_POST['resourcemaxsize']) ? trim($_POST['resourcemaxsize']) : 0;
		$day_interval = isset($_POST['day_interval']) ? trim($_POST['day_interval']) : 0;
		$notice_per = isset($_POST['notice_per']) ? trim($_POST['notice_per']) : 0;
		$smtpport = isset($_POST['smtpport']) ? trim($_POST['smtpport']) : 0;
		$maxchangepassword = isset($_POST['maxchangepassword']) ? trim($_POST['maxchangepassword']) : 0;
		$maxtaken =  isset($_POST['maxtaken']) ? trim($_POST['maxtaken']) : 0;
		$minpasslen =  isset($_POST['minpasslen']) ? trim($_POST['minpasslen']) : 0;
		$maxpasslen =  isset($_POST['maxpasslen']) ? trim($_POST['maxpasslen']) : 0;
		$passchar =  isset($_POST['passchar']) ? trim($_POST['passchar']) : "";
		
		$errs = array();
		
		/*if (! $websitetitle)
		{
			$errs[] = $this->config->item("lerr_empty_websitetitle");
		}*/
		
		if ((! is_numeric($sessiontimeout)) || ($sessiontimeout < 0))
		{
			$errs[] = $this->config->item("lerr_session_idle_time");
		}
				
		if (! is_numeric($inactiveperiod))
		{
			$errs[] = $this->config->item("err_invalid_inactiveperiod");
		}

		if (! is_numeric($expiredpassword))
		{
			$errs[] = $this->config->item("err_invalid_expiredpassword");
		}
		
		if ($minpasslen)
		{
			if (! is_numeric($minpasslen))
			{
				$errs[] = $this->config->item("lerr_invalid_minpasslen");
				unset($minpasslen);
			}
		}

		if ($maxpasslen)
		{
			if (! is_numeric($maxpasslen))
			{
				$errs[] = $this->config->item("lerr_invalid_maxpasslen");
				unset($maxpasslen);
			}
		}
		
		if (isset($minpasslen) && isset($maxpasslen))
		{
			if ($minpasslen > $maxpasslen)
			{
				$errs[] = $this->config->item("lerr_invalid_minpasslen_greater_maxpasslen");
			}
		}

		if (! is_numeric($errorlogin))
		{
			$errs[] = $this->config->item("err_invalid_errorlogin");
		}
		
		if ((! is_numeric($concurrentuser)) || ($concurrentuser < 0))
		{
			$errs[] = $this->config->item("err_invalid_concurrentuser");
		}
		
		if ((! is_numeric($recordperpage)) || ($recordperpage <= 0))
		{
			$errs[] = $this->config->item("err_invalid_recordperpage");
		}		
		
		if (isset($_FILES['websitelogo']) && $_FILES['websitelogo']['name'] && $_FILES['websitelogo']['size'])
		{
			move_uploaded_file($_FILES['websitelogo']['tmp_name'], BASEPATH."/../uploads/logo/".$_FILES['websitelogo']['name']);
			$_POST['websitelogo'] = $_FILES['websitelogo']['name'];
		}

		if (isset($_FILES['pageloginimage']) && $_FILES['pageloginimage']['name'] && $_FILES['pageloginimage']['size'])
		{
			move_uploaded_file($_FILES['pageloginimage']['tmp_name'], BASEPATH."/../uploads/".$_FILES['pageloginimage']['name']);
			$_POST['pageloginimage'] = $_FILES['pageloginimage']['name'];
		}

		if (isset($_FILES['file_learning_catalog']) && $_FILES['file_learning_catalog']['name'] && $_FILES['file_learning_catalog']['size'])
		{
			move_uploaded_file($_FILES['file_learning_catalog']['tmp_name'], BASEPATH."/../uploads/learning_catalog/".$_FILES['file_learning_catalog']['name']);
			$_POST['file_learning_catalog'] = $_FILES['file_learning_catalog']['name'];
		}

		if (isset($_FILES['fileimportapproval']) && $_FILES['fileimportapproval']['name'] && $_FILES['fileimportapproval']['size'])
		{
			$_POST['fileimportapproval'] = $_FILES['fileimportapproval']['name'];
		}
		
		if ((! is_numeric($resourcemaxsize)) || ($resourcemaxsize < 0))
		{
			$errs[] = $this->config->item("err_invalid_resourcemaxsize");
		}
		
		if (isset($_FILES['certtpl']) && $_FILES['certtpl']['name'])
		{
			$dirtpl = BASEPATH."../uploads/tmpl";
			if (! is_dir($dirtpl))
			{
				mkdir($dirtpl);
				chmod($dirtpl, 777);
			}
			
			if ($_FILES['certtpl']['type'] != "text/html")
			{
				$errs[] = $this->config->item("lerr_certificate_template");
			}
			else
			{
				$name = uniqid().".html";
				move_uploaded_file($_FILES['certtpl']['tmp_name'], $dirtpl."/".$name);
				
				$_POST['certtpl'] = $name;
			}
		}
		else
		{
			unset($_POST['certtpl']);
		}

		if (isset($_FILES['trainingtpl']) && $_FILES['trainingtpl']['name'])
		{
			$dirtpl = BASEPATH."../uploads/tmpl";
			if (! is_dir($dirtpl))
			{
				mkdir($dirtpl);
				chmod($dirtpl, 777);
			}
			
			if ($_FILES['trainingtpl']['type'] != "text/html")
			{
				$errs[] = $this->config->item("lerr_training_template");
			}
			else
			{
				$name = uniqid().".html";
				move_uploaded_file($_FILES['trainingtpl']['tmp_name'], $dirtpl."/".$name);
				
				$_POST['trainingtpl'] = $name;
			}
		}
		else
		{
			unset($_POST['trainingtpl']);
		}
		
		if (! is_array($resourcetype))
		{
			$errs[] = $this->config->item("err_empty_resourcetype");
		}
		else
		{
			$found = false;
			foreach($resourcetype as $val)
			{
				$val = trim($val);
				if (strlen($val) > 0) 
				{
					$found = true;
					break;
				}
			}
			
			if (! $found)
			{
				$errs[] = $this->config->item("err_empty_resourcetype");
			}
		}
		
		if ($day_interval && ! (is_numeric($day_interval)))
		{
			$errs[] = $this->config->item("err_invalid_day_interval");
		}

		if ($smtpport && ! (is_numeric($smtpport)))
		{
			$errs[] = $this->config->item("lerr_smtp_port");
		}
		
		if ($notice_per && ! (is_numeric($notice_per)))
		{
			$errs[] = $this->config->item("lerr_invalid_notice_per");
		}
		
		if ((! is_numeric($maxchangepassword)) || ($maxchangepassword < 0))
		{
			$errs[] = $this->config->item("lerr_maxchangepassword");
		}		

		if ((! is_numeric($maxtaken)) || ($maxtaken < 0))
		{
			$errs[] = $this->config->item("lerr_maxtaken");
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$msg = $this->mysmarty->fetch("errmessage.html");
			
			$msg = str_replace("\r", "", $msg);
			$msg = str_replace("\n", "", $msg);
			$msg = str_replace("\"", "", $msg);
			
			echo '<script>parent.setErrorMessage("'.$msg.'");</script>';
			
			return;
		}	
		
		$q = $this->db->get("general_setting");
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->general_setting_code] = $rows[$i]->general_setting_value;
		}

		$_POST['user_minimal_approval_request_training'] = !empty($_POST['user_minimal_approval_request_training']) ? $_POST['user_minimal_approval_request_training'] : 0;
		$_POST['total_step_approval'] = !empty($_POST['hd_step_approval']) ? count($_POST['hd_step_approval']) : 1;

		if(!empty($_POST['hd_step_approval'])) {
			foreach ($_POST['hd_step_approval'] as $key => $value) {
				$no_urut = $key+1;
				$lbl = 'user_approval_request_training_'.$no_urut;
				$_POST['user_approval_request_training'][$no_urut] = !empty($_POST[$lbl]) ? $_POST[$lbl] : array();
				unset($_POST[$lbl]);
			}
		}
				
		foreach($_POST as $key=>$val)
		{
			if($key == 'user_search') continue;
			if($key == 'hd_step_approval') continue;
			if($key == 'user_keyword') continue;

			if (is_array($val)) 
			{
				$this->commonmodel->updateSetting(trim($key), serialize($val));
				continue;
			}
			
			$this->commonmodel->updateSetting(trim($key), trim($val));
		}

		if(!empty($_FILES['fileimportapproval']['name'])) {
			$data_excel = array();

			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['fileimportapproval']['tmp_name']);

			$i = 2;
			$ii = 0;
			while(1)
			{
				$j = 1;
				$jj = 0;
				while(1) {
					if (! isset($this->xlsreader->sheets[0]['cells'][$i][$j])) break;
				
					$data_excel[$ii][$jj] = $this->xlsreader->sheets[0]['cells'][$i][$j];				
					
					$j++;
					$jj++;
				}

				if (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

				$i++;
				$ii++;
			}

			if(!empty($data_excel)) {
				$this->db->where('trdf_jabatan_request != ""')->delete('request_training_default');

				$datenow = date('Y-m-d H:i:s');

				$usess = $this->session->userdata('lms_sess');
				$usess = unserialize($usess);
				$detail_user = $this->db->select('user_first_name')->where('user_id = "'.$usess['user_id'].'"')->get('user')->row_array();

				$row_limit = 100;
				$cnt = 1;
				foreach ($data_excel as $key => $value) {
					if($cnt > $row_limit) break;

					$jabatan_request = array();
					$jabatan_approval = array();
					$first = true;

					$row_limit2 = 10;
					$cnt2 = 1;
					foreach ($value as $key2 => $value2) {
						if($cnt2 > $row_limit2) break;

						if($first) {
							$jabatan_request = $value2;
							$first = false;
							continue;
						}

						$jabatan_approval[$key2] = $value2;

						$cnt2++;
					}

					$data_db = array(
						'trdf_jabatan_request' => $jabatan_request,
						'trdf_jabatan_approval' => serialize($jabatan_approval),
						'trdf_entryuser' => (!empty($detail_user['user_first_name']) ? $detail_user['user_first_name'] : ''),
						'trdf_entrydate' => $datenow,
					);
					$this->db->insert('request_training_default', $data_db);

					$cnt++;
				}
			}
		}

		if (isset($_FILES['fileimportapproval']) && $_FILES['fileimportapproval']['name'] && $_FILES['fileimportapproval']['size'])
		{
			move_uploaded_file($_FILES['fileimportapproval']['tmp_name'], BASEPATH."/../uploads/general_setting/".$_FILES['fileimportapproval']['name']);
		}

		$notif_email_body =  isset($_POST['notif_email_body']) ? trim($_POST['notif_email_body']) : "";
		$notif_email_body = str_replace("-&gt;", "->", $notif_email_body);
		$this->_write_file("views/generalsetting/notif_approval_email_body.html", $notif_email_body);
		
		echo '<script>parent.setSuccess("'.$this->config->item('ok_update_setting').'");</script>';
	}

	function errmessage($errtype,$id=0)
	{
		$errs[] = $this->config->item($errtype);
		
		if($id <> 0){
			//get training/certificate name 
			$training = $this->trainingmodel->GetInfo($id);
			if($training->training_type == "1")
				$type = "Training";
			else
			if($training->training_type == "2")
				$type = "Certification";
			$errs[] = " * " .$type. " : <a href='".base_url()."index.php/".strtolower($type)."/showlist/".$training->training_topic."'><font colour='red'>".$training->training_name."</font></a>";
		}
		
		$this->mysmarty->assign("errs", $errs);
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "errmessage.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function backup()
	{
		$this->mysmarty->assign("lexport_all_data", $this->config->item("lexport_all_data"));
		$this->mysmarty->assign("limport_alldata", $this->config->item("limport_alldata"));
		$this->mysmarty->assign("ldump_file", $this->config->item("ldump_file"));		
				
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "generalsetting/backup.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function exportalldata()
	{
		header("Content-Disposition: attachment; filename=alldata_".date("Ymd").".sql");
		header("Content-type: application/download");
		
		$token = md5(uniqid());
		$file = BASEPATH."../uploads/".$token;
		shell_exec ($this->config->item("mysqldumpshell")." --add-drop-table  -u".$this->db->username." --password=".$this->db->password." ".$this->db->database."  > ".$file);
		
		readfile ($file);
		@unlink($file);
		
	}
	
	function importalldata()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);
		
		$errs = array();
		
		if (! isset($_FILES['userfile']))
		{
			$errs[] = $this->config->item("lempty_dump_file");
		}
		else
		if (! $_FILES['userfile']['name'])
		{
			$errs[] = $this->config->item("lempty_dump_file");
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			echo "<script>parent.setErrorMessage('messageimportdump', \"".$err."\")</script>";
			
			return;
		}
		
		$output = shell_exec ($this->config->item("mysqlimportshell")." -u".$this->db->username." --password=".$this->db->password." ".$this->db->database." < ".$_FILES['userfile']['tmp_name']);
		echo "<script>parent.setSuccess('messageimportdump', \"".$this->config->item("limport_dump_file_ok")."\")</script>";
	}
	
	function compact()
	{
		$q = $this->db->get("general_setting");
		$rows = $q->result();
		
		$this->db->delete("general_setting");
		
		for($i=0; $i < count($rows); $i++)
		{			
			$this->commonmodel->updateSetting($rows[$i]->general_setting_code, $rows[$i]->general_setting_value);
		}
		
		echo "DONE";
	}

	function _write_file($path, $content)
	{		
		if (is_file(BASEPATH."../theme/".$this->config->item('theme')."/".$path))
		{
			return write_file(BASEPATH."../theme/".$this->config->item('theme')."/".$path, $content);		
		}
	
		return write_file(APPPATH.$path, $content);		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */