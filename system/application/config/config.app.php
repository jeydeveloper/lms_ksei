<?php
	$config['root_path'] = str_replace("\\", "/", realpath(dirname(FCPATH)));;	

	// jumlah maximum row data yang ditampilkan
	$config['data_per_page'] = 10;	
	
	// admin email setting
	$config['admin_mail'] = "alearning@qnbkesawan.co.id";
	$config['admin_name'] = "admin";	
	
	// default setting
	$config['lang'] = "id";
	
	$config['default_jumlah_soal'] = 80;	
	$config['default_bobot_mudah'] = 20;
	$config['default_bobot_sedang'] = 20;
	$config['default_bobot_sulit'] = 60;
	
	$config['websitetitle'] = "LKPP LMS 2.0";
	$config['flashtime'] = 1000;	
	
	// session
	$config['sess_table_name'] = 'lmsv2_sessions';
	$config['sess_use_database']	= TRUE;
	
	//logs
	$config['history_logs'] = true;
	
	$config['table_notto_log'] = array(
		"log",
		"logs",
		"cron",
		"banksoal_answer_archive",
		"banksoal_question_archive",
		"history_answer",
		"history_exam",
		"history_reference",
		"ildp_detail_trail",
		"ildp_form_trail",
		"ildp_trail_old",
		"import",
		"password_hist",
		"lmsv2_sessions",
		"sessions"
	);
	
	/*$config['table_to_log'] = array(
		"banksoal",
		"banksoal_answer",
		"banksoal_jabatan",
		"banksoal_question",
		"banksoal_unit",
		"banksoal_unit_setting",
		"catalog_grade",
		"category" , 
		"training",
		"general_setting" , 
		"right",
		"reminderext",
		"reminderuser",
		"user",
		"hrld",
		"hrrm",
		"order",
		"order_catalog",
		"order_catalog_report",
		"order_externaldata",
		"reference",
		"ildp_catalog",
		"ildp_category",
		"ildp_detail",
		"ildp_form",
		"ildp_method",
		"registration_period",
		"ildpsetting"
		
		//"lmsv2_function" , 
		//"lmsv2_jabatan" , 
		//"lmsv2_level" , 
		//"lmsv2_level_group" , 
	);*/
	
	// besar log split
	
	$config['maxlogsize'] = 100*1024; // dalam kB
	
	// export / import
	
	$config['outbox'] = 'SAP-HR/OUT';	
	$config['exporthistoryfilename'] = "HRLMSOUT.CSV";
	
	$config['sap_bankwide'] = "ELLD_bankwide";
	$config['sap_bydir'] = "ELLD_direktorat";
	$config['sap_bygroup'] = "ELLD_group";
	$config['sap_bydept'] = "ELLD_dept";
	$config['sap_byunit'] = "ELLD_unit";
	$config['sap_coursecode'] = "ELLD_coursecode";
	
	$config['sap_od_bankwide'] = "ELLD_OD_bankwide";
	$config['sap_od_bydir'] = "ELLD_OD_direktorat";
	$config['sap_od_bygroup'] = "ELLD_OD_group";
	$config['sap_od_bydept'] = "ELLD_OD_dept";
	$config['sap_od_byunit'] = "ELLD_OD_unit";
	$config['sap_od_coursecode'] = "ELLD_OD_coursecode";

	$config['sap_extension'] = "CSV";
	
	$config['inbox'] = 'SAP-HR/IN';
	$config['importfilename'] = "HRLMSIN.CSV";	
	
	$config['max_grade'] = 10;
	$config['eligable_grade_for_approval'] = 13;
	
	$config['refreshment_today'] = 0;
	$config['prefix_deadline'] = array("lend_of");
	$config['materi_mandatory'] = true;
	
	$config['sess_expire_on_close'] = TRUE;
	$config['enable_query_strings'] = TRUE;
	$config['hide_family_field'] = TRUE;
	
	$config['IS_DEBUG'] = FALSE;

	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

	$config['timeline'] = array(
		"Q1"	=> "Q1",
		"Q2"	=> "Q2",
		"Q3"	=> "Q3",
		"Q4"	=> "Q4"
		);
?>
