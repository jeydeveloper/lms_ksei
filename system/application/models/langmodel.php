<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class LangModel extends Model {
	function LangModel () 
	{				
		parent::Model();		
		
		$this->load->model("ildpregmodel");
	}	

	function init()
	{
		$CI =& get_instance();

		$CI->load->library('session');

		$base_path = $CI->config->item('base_path');

		//-- language
		$lang = $CI->langue ? $CI->langue : $CI->langmodel->getDefaultLang();
		$company = $CI->config->item('theme');
		$company_language =  sprintf("%s/theme/%s/language/%s.php", $base_path,$company, $lang);
			
		if ($company && file_exists($company_language))
		{
			$file = sprintf("../../../theme/%s/language/%s.php", $company, $lang);
			$this->config->load($file, $lang);
		}
		else
		{
			$this->config->load('config.'.($this->langue ? $this->langue : $this->langmodel->getDefaultLang()));
		}
		
		$this->mysmarty->assign("lnpk", $this->config->item('lnpk'));
		$this->mysmarty->assign("home", $this->config->item("home"));	
		$this->mysmarty->assign("your_profile", $this->config->item("your_profile"));
		$this->mysmarty->assign("lsettings", $this->config->item("lsettings"));
		$this->mysmarty->assign("luser_admin", $this->config->item("luser_admin"));
		$this->mysmarty->assign("topic", $this->config->item("topic"));
		$this->mysmarty->assign("logout", $this->config->item("logout"));		
		$this->mysmarty->assign("llearning_topics", $this->config->item("llearning_topics"));	
		$this->mysmarty->assign("lcategory1", $this->config->item("category"));
		$this->mysmarty->assign("ladmin", $this->config->item("ladmin"));
		$this->mysmarty->assign("ltrainee", $this->config->item("ltrainee"));		
		$this->mysmarty->assign("lreminder", $this->config->item("lreminder"));	
		$this->mysmarty->assign("lrefreshment", $this->config->item("lrefreshment"));	
		$this->mysmarty->assign("lildp_admin", $this->config->item("lildp_admin"));
		$this->mysmarty->assign("lildp_approval", $this->config->item("lildp_approval"));		
		$this->mysmarty->assign("lmy_ildp_form", $this->config->item("lmy_ildp_form"));		
		$this->mysmarty->assign("lapproval", $this->config->item("lapproval"));		
		$this->mysmarty->assign("lmy_form", $this->config->item("lmy_form"));		
		$this->mysmarty->assign("lildp_form", $this->config->item("lildp_form"));	
		$this->mysmarty->assign("llearning_method", $this->config->item("llearning_method"));	
		$this->mysmarty->assign("lildp_registration_period", $this->config->item("lildp_registration_period"));
		$this->mysmarty->assign("lpending_approval", $this->config->item("lpending_approval"));
		$this->mysmarty->assign("lildp_form_import", $this->config->item("lildp_form_import"));		
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
		$this->mysmarty->assign("ldevelopment_area", $this->config->item("ldevelopment_area"));

		//topic		
		$this->mysmarty->assign("category", $this->config->item("category"));
		$this->mysmarty->assign("topic", $this->config->item("topic"));	
		$this->mysmarty->assign("online_training", ucfirst($this->config->item("online_training")));		
		$this->mysmarty->assign("classroom_training", $this->config->item("classroom_training"));
		$this->mysmarty->assign("certification", $this->config->item("certification"));
		$this->mysmarty->assign("resources", $this->config->item("resources"));
		$this->mysmarty->assign("llist", $this->config->item("llist"));	
		$this->mysmarty->assign("llearning_admin", $this->config->item("llearning_admin"));
		$this->mysmarty->assign("llearning_admin_certification", $this->config->item("llearning_admin_certification"));
		$this->mysmarty->assign("luser_activities", ucfirst($this->config->item('luser_activities')));
		
		//user
		$this->mysmarty->assign("profile", $this->config->item("profile"));
		$this->mysmarty->assign("change_pass", $this->config->item("change_pass"));
		$this->mysmarty->assign("edit_profile", $this->config->item("edit_profile"));
		$this->mysmarty->assign("user_list", $this->config->item("user_list"));		
		$this->mysmarty->assign("llearning_trainee", $this->config->item("llearning_trainee"));
		$this->mysmarty->assign("lonline_training", $this->config->item("lonline_training"));		
		$this->mysmarty->assign("lcertification", $this->config->item("certification"));
		$this->mysmarty->assign("lresources", $this->config->item("lresources"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));		
		$this->mysmarty->assign("ldelegetion", $this->config->item("ldelegetion"));		
		$this->mysmarty->assign("lapproval_history", $this->config->item("lapproval_history"));		

		//masterdata
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("group", $this->config->item("group"));
		$this->mysmarty->assign("department", $this->config->item("department"));
		$this->mysmarty->assign("unit", $this->config->item("unit"));
		$this->mysmarty->assign("jabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("function", $this->config->item("function"));		
		$this->mysmarty->assign("lbank_soal_training", $this->config->item("lbank_soal"));
		$this->mysmarty->assign("luser_rights", $this->config->item("luser_rights"));		
		$this->mysmarty->assign("lgeneralsetting", $this->config->item("lgeneralsetting"));	
		$this->mysmarty->assign("llevel", $this->config->item("llevel"));
		$this->mysmarty->assign("lorganisational_structure",getconfig('lorganisational_structure'));
		$this->mysmarty->assign("llokasi_fisik",getconfig('llokasi_fisik'));	
		$this->mysmarty->assign("lbackup", $this->config->item("lbackup"));	
		$this->mysmarty->assign("lcatjabatan", $this->config->item("lcatjabatan"));				
		$this->mysmarty->assign("lreminder_new_joiner", $this->config->item("lreminder_new_joiner"));		
		$this->mysmarty->assign("lreminder_refreshment", $this->config->item("lreminder_refreshment"));		
				
		// training
		
		$this->mysmarty->assign("lonline_training", $this->config->item("online_training"));
		$this->mysmarty->assign("lparticipant", $this->config->item("lparticipant"));	
		$this->mysmarty->assign("lprequisite", $this->config->item("lprequisite"));
		$this->mysmarty->assign("lpostrequisite", $this->config->item("lpostrequisite"));	
		$this->mysmarty->assign("lsetting", $this->config->item("lsetting"));
		$this->mysmarty->assign("lpraexam_lexam", $this->config->item("lpraexam_lexam"));	
		$this->mysmarty->assign("lunlimit",getconfig('lunlimit'));
		$this->mysmarty->assign("lhistory", $this->config->item("lhistory"));		
		
		$this->mysmarty->assign("ltrainee_menu",getconfig('ltrainee_menu'));	
		$this->mysmarty->assign("ladmin_menu",getconfig('ladmin_menu'));
		$this->mysmarty->assign("lmateri",getconfig('lmateri'));		
		
		// report
		
		$this->mysmarty->assign("lreport",getconfig('lreport'));				
		$this->mysmarty->assign("lgeneral_report", $this->config->item("lgeneral_report"));
		$this->mysmarty->assign("lcertification_list", $this->config->item("lcertification_list"));		
		
		// ildp
				
		$this->mysmarty->assign("llist", $this->config->item("llist"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));
		$this->mysmarty->assign("lsetting", $this->config->item("lsetting"));	
		$this->mysmarty->assign("lhrrm_setting", $this->config->item("lhrrm_setting"));		
		$this->mysmarty->assign("lhrld_setting", $this->config->item("lhrld_setting"));	
		$this->mysmarty->assign("lcart", $this->config->item("lcart"));
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		$this->mysmarty->assign("lcatalog", $this->config->item("lcatalog"));
		$this->mysmarty->assign("lcareer_aspiration", $this->config->item("lcareer_aspiration"));
		$this->mysmarty->assign("lshort_term", $this->config->item("lshort_term"));
		$this->mysmarty->assign("llong_term", $this->config->item("llong_term"));

		//-----lang admin news---------
		$this->mysmarty->assign("ladmin_news", $this->config->item("ladmin_news"));
		$this->mysmarty->assign("list_news", $this->config->item("list_news"));
		$this->mysmarty->assign("archive_news", $this->config->item("archive_news"));

		$this->mysmarty->assign("ladmin_news_list", $this->config->item("ladmin_news_list"));
		$this->mysmarty->assign("lheader_list_news_list", $this->config->item("lheader_list_news_list"));
		$this->mysmarty->assign("news_title", $this->config->item("news_title"));
		$this->mysmarty->assign("news_desc", $this->config->item("news_desc"));
		$this->mysmarty->assign("news_image", $this->config->item("news_image"));
		$this->mysmarty->assign("lsort_by_news_title", $this->config->item("lsort_by_news_title"));		

		$this->mysmarty->assign("lsetting_cms_admin", $this->config->item("lsetting_cms_admin"));
		$this->mysmarty->assign("lcms_admin_activity_periodic", $this->config->item("lcms_admin_activity_periodic"));
		$this->mysmarty->assign("lcms_admin_activity_periodic_description", $this->config->item("lcms_admin_activity_periodic_description"));
		$this->mysmarty->assign("lnews_per_page", $this->config->item("lnews_per_page"));
		$this->mysmarty->assign("lnews_per_page_description", $this->config->item("lnews_per_page_description"));
		$this->mysmarty->assign("lshow_admin_news", $this->config->item("lshow_admin_news"));
		$this->mysmarty->assign("lshow_admin_news_description", $this->config->item("lshow_admin_news_description"));

		$this->mysmarty->assign("ladd_reminder", $this->config->item("ladd_reminder"));
		$this->mysmarty->assign("ladd_refreshment", $this->config->item("ladd_refreshment"));

		$this->mysmarty->assign("llogin_by_email", $this->config->item('llogin_by_email'));

		$this->mysmarty->assign("lemail", $this->config->item('lemail'));

		$this->mysmarty->assign("lsort_by_news_entrydate", $this->config->item('lsort_by_news_entrydate'));
		$this->mysmarty->assign("news_entrydate", $this->config->item('news_entrydate'));

		//model lang setting approval
		$this->mysmarty->assign("lproposal_training", $this->config->item('lproposal_training'));
		$this->mysmarty->assign("lproposal_admin_approval", $this->config->item('lproposal_admin_approval'));
		$this->mysmarty->assign("lproposal_admin_approval_description", $this->config->item('lproposal_admin_approval_description'));
		$this->mysmarty->assign("lproposal_max_approval", $this->config->item('lproposal_max_approval'));
		$this->mysmarty->assign("lproposal_max_approval_description", $this->config->item('lproposal_max_approval_description'));

		//model lang request module
		$this->mysmarty->assign("request_viewoptions", $this->config->item('request_viewoptions'));
		$this->mysmarty->assign("request_list", $this->config->item('request_list'));
		$this->mysmarty->assign("request_approval", $this->config->item('request_approval'));
		$this->mysmarty->assign("request_training", $this->config->item('request_training'));
		$this->mysmarty->assign("request_description", $this->config->item('request_description'));
		$this->mysmarty->assign("request_sortlist", $this->config->item('request_sortlist'));
		$this->mysmarty->assign("request_sortlistname", $this->config->item('request_sortlistname'));
		$this->mysmarty->assign("request_add", $this->config->item('request_add'));
		$this->mysmarty->assign("request_export", $this->config->item('request_export'));
		$this->mysmarty->assign("request_no", $this->config->item('request_no'));
		$this->mysmarty->assign("request_namatraining", $this->config->item('request_namatraining'));
		$this->mysmarty->assign("request_namapemohon", $this->config->item('request_namapemohon'));
		$this->mysmarty->assign("request_typetraining", $this->config->item('request_typetraining'));
		$this->mysmarty->assign("request_statusapproval", $this->config->item('request_statusapproval'));
		$this->mysmarty->assign("request_newproposaltraining", $this->config->item('request_newproposaltraining'));
		$this->mysmarty->assign("request_trainingtype", $this->config->item('request_trainingtype'));
		$this->mysmarty->assign("request_pelatihaninhouse", $this->config->item('request_pelatihaninhouse'));
		$this->mysmarty->assign("request_pelatihaneksternal", $this->config->item('request_pelatihaneksternal'));
		$this->mysmarty->assign("request_onthejobtraining", $this->config->item('request_onthejobtraining'));
		$this->mysmarty->assign("request_penyelenggara", $this->config->item('request_penyelenggara'));
		$this->mysmarty->assign("request_tema", $this->config->item('request_tema'));
		$this->mysmarty->assign("request_judul", $this->config->item('request_judul'));
		$this->mysmarty->assign("request_tanggal", $this->config->item('request_tanggal'));
		$this->mysmarty->assign("request_waktu", $this->config->item('request_waktu'));
		$this->mysmarty->assign("request_tempat", $this->config->item('request_tempat'));
		$this->mysmarty->assign("request_pembicara", $this->config->item('request_pembicara'));
		$this->mysmarty->assign("request_datapeserta", $this->config->item('request_datapeserta'));
		$this->mysmarty->assign("request_divisi", $this->config->item('request_divisi'));
		$this->mysmarty->assign("request_nohandphone", $this->config->item('request_nohandphone'));
		$this->mysmarty->assign("request_tujuanpelatihan", $this->config->item('request_tujuanpelatihan'));
		$this->mysmarty->assign("request_rekomendasidirectsupervisor", $this->config->item('request_rekomendasidirectsupervisor'));
		$this->mysmarty->assign("request_biayaprogram", $this->config->item('request_biayaprogram'));
		$this->mysmarty->assign("request_akomodasi", $this->config->item('request_akomodasi'));
		$this->mysmarty->assign("request_transportasi", $this->config->item('request_transportasi'));
		$this->mysmarty->assign("request_uangmakan", $this->config->item('request_uangmakan'));
		$this->mysmarty->assign("request_rekomendasiprogramdevelopment", $this->config->item('request_rekomendasiprogramdevelopment'));
		$this->mysmarty->assign("request_jenispendidikan", $this->config->item('request_jenispendidikan'));
		$this->mysmarty->assign("request_technicalsoftskill", $this->config->item('request_technicalsoftskill'));
		$this->mysmarty->assign("request_bicategory", $this->config->item('request_bicategory'));
		$this->mysmarty->assign("request_inputerror", $this->config->item('request_inputerror'));

        //login base Lang
        $this->mysmarty->assign("login_welcome_back", (!empty($this->config->item('login_welcome_back')) ? $this->config->item('login_welcome_back') : 'Welcome Back!'));
        $this->mysmarty->assign("login_please_login", (!empty($this->config->item('login_please_login')) ? $this->config->item('login_please_login') : 'Please Login'));
        $this->mysmarty->assign("login_nik", (!empty($this->config->item('login_nik')) ? $this->config->item('login_nik') : 'NIK'));
        $this->mysmarty->assign("login_email", (!empty($this->config->item('login_email')) ? $this->config->item('login_email') : 'Email'));
        $this->mysmarty->assign("login_password", (!empty($this->config->item('login_password')) ? $this->config->item('login_password') : 'Password'));
        $this->mysmarty->assign("login_forgot_password", (!empty($this->config->item('login_forgot_password')) ? $this->config->item('login_forgot_password') : 'Forgot Password'));
        $this->mysmarty->assign("login_button_login", (!empty($this->config->item('login_button_login')) ? $this->config->item('login_button_login') : 'Login'));
        $this->mysmarty->assign("login_choose_language", (!empty($this->config->item('login_choose_language')) ? $this->config->item('login_choose_language') : 'Choose Language'));

		$usess = $CI->session->userdata('lms_sess');
		if ($usess) {
			$sess = unserialize($usess);

			$res = $CI->db->select('general_setting_value')->where('general_setting_code = "show_running_text_approval"')->get('general_setting')->row_array();

			if(!empty($res['general_setting_value'])) {

				$res = $CI->db->join('request_training', 'rqtr_id = trap_rqtr_id')->select('rqtr_judul, trap_rqtr_id')->where('trap_user_id = "'.$sess['user_id'].'" AND trap_status_approval = 0')->get('request_training_approval')->result_array();

				if(!empty($res)) {
					$this->mysmarty->assign("list_running_text_approval", $res);
					$this->mysmarty->assign("show_running_text_approval", 1);
				}
				
			}
		}
		
		/* footer yeart */
		$initYear = 2010;
		$strYear =($initYear == date("Y"))?$initYear:$initYear." - ".date("Y");
		
		$this->mysmarty->assign("strYear",$strYear);	
		$this->mysmarty->assign("isapprovaluser", $this->ildpregmodel->IsManager());
		
		$usess = $CI->session->userdata('lms_sess');	
		$sess = unserialize($usess);
        $CI->db->setUserId($sess['user_id']);
	}	
	
	function getDefaultLang()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "defaultlang");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return $this->config->item('lang');
		}
		
		$row = $q->row();
		return $row->general_setting_value;
	}	
}
