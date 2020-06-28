<?php
$CI =& get_instance();            
$company = $CI->config->item('company');

	$config['ldays'] 					= "day(s)";
	$config['err_empty_npk'] 			= "Please enter the User ID!";
	$config['err_already_exist_npk'] 		= "This User ID already registered. Please create another one.";	
	$config['err_not_already_exist_npk'] 	= "Your ID does not exist in the system. Please check and try again";
	$config['err_empty_pass'] 			= "Please enter the Password!";
	$config['err_invalid_login'] 			= "The User ID or Password you entered is incorrect.";	
	$config['err_empty_oldpass'] 			= "Please fill in the current password!";
	$config['err_invalid_oldpass'] 		= "The password you gave is incorrect";	
	$config['err_empty_newpass'] 			= "Please fill in the new password!";
	$config['err_invalid_confirmpass'] 	= "Passwords do not match";
	$config['err_empty_firstname'] 		= "Please fill in the First Name!";
	$config['err_empty_lastname'] 		= "Please fill in the Family Name!";
	$config['err_empty_joindate'] 		= "Please fill in the Join Date!";
	$config['err_invalid_joindate'] 		= "The Join Date you gave is incorrect";
	$config['err_empty_phone'] 			= "Please fill in the Phone Number!";	
	$config['err_empty_phoneext'] 		= "Please fill in the Phone Extension!";	
	$config['err_empty_mobile'] 			= "Please fill in the Mobile Phone!";	
	$config['err_empty_birthdate'] 		= "Please fill in the Birthday!";
	$config['err_invalid_birthdate'] 		= "The Birthday you gave is incorrect";
	$config['err_empty_location'] 		= "Please fill in the Location!";
	$config['err_empty_city'] 			= "Please fill in the City!";	
	$config['err_empty_email'] 			= "Please fill in the Email Address!";	
	$config['err_invalid_email'] 			= "Please use a valid email address format";
	$config['err_exist_email'] 			= "This email address is alreadry registered. Please use another email address or contact your administrator.";	
	
	$config['first_name'] 				= "User Name";	
	$config['last_name'] 				= "Family Name";	
	$config['confirm_new_password'] 		= "Confirm New Password";
	$config['new_password'] 				= "New password";
	$config['old_password'] 				= "Current password";
	$config['edit_profile'] 				= "Edit Profile";
	$config['change_pass'] 				= "Change Password";
	$config['profile'] 					= "Profile";
	$config['city'] 					= "City";
	$config['location'] 				= "Location";
	$config['birthdate'] 				= "Birthdate";
	$config['email'] 					= "Email Address";
	$config['account_header'] 			= "Account";
	$config['user_list'] 				= "Users List";
	$config['user'] 					= "User";
	$config['lall_user'] 				= "All User";    
	$config['logout'] 					= "Logout";
	$config['header_list_user'] 			= "This is the list of users in ".$company." :";
	
	$config['ok_change_pass'] 			= "The Password is now changed.";
	$config['ok_update_user'] 			= "The Profile is now updated.";	
	$config['ok_add_user'] 				= "The User is now registered";	
	
	$config['err_exipred_session'] 		= "For your security, your session is terminated. Please re-login!";	
	
	$config['directorat'] 				= "Directorate"; 
	$config['name'] 					= "Name";
	$config['directorat_name'] 			= "Directorate Name";
	$config['status'] 					= "Status";
	$config['lconfirm_change_status'] 		= "Are you sure to change the status?";
	$config['lconfirm_ildp_catalog_save'] 	= "Save changes?";
	$config['lcheck_all'] 				= "Check all";
	$config['lilpd_catalog_import'] 		= "ILDP Catalog Import";
	$config['sort_list_by'] 				= "Sort list by";
	$config['date_added'] 				= "Add Data";
	$config['directorat_list'] 			= "Directorate List";
	$config['header_list_directorat'] 		= "These are directorate that available in ".$company.":";
	
	$config['group_name'] 				= "Group Name";
	$config['group'] 					= "Group";
	$config['group_list'] 				= "Group List";	
	$config['header_list_group'] 			= "Berikut adalah group yang ada dalam ".$company." On-line Learning System:";
	
	$config['jabatan'] 					= "Position";
	$config['jabatan_list'] 				= "List of Positions";
	$config['jabatan_name'] 				= "Position Name";	
	$config['header_list_jabatan'] 		= "Below is the list of Positions:";	
	$config['err_jabatan_name'] 			= "Please fill in the Position!";
	$config['err_exist_jabatan'] 			= "The Position is already registered.";
	$config['err_not_exist_jabatan'] 		= "The Position is not registered";
	$config['lconfirm_change_order'] 		= "Are You sure You want to re-arrange the data?";
	$config['lconfirm_reset_data'] 		= "Are You sure You want reset the data?";
	
	$config['unit'] 					= "Unit";
	$config['unit_name'] 				= "Unit Name";	
	$config['unit_list'] 				= "Unit List";	
	$config['header_list_unit'] 			= "Berikut adalah unit yang ada dalam Learning Management System ".$company." ini:";
	$config['err_not_exist_unit'] 		= "Unit is already registered";		
	
	$config['last_login'] 				= "Last Login";
	$config['user_type'] 				= "User Type";
	$config['work_status'] 				= "Work Status";
	$config['department'] 				= "Department";
	$config['department_list'] 			= "Department List";
	$config['department_name'] 			= "Department Name";	
	$config['header_list_department'] 		= "Berikut adalah department yang ada dalam Learning Management System ".$company." ini:";
	
	$config['function'] 				= "Function";
	$config['function_list'] 			= "Function List";
	$config['function_desc'] 			= "Function Description";
	$config['header_list_function'] 		= "Berikut adalah function yang ada dalam Learning Management System ".$company." ini:";	
	$config['description'] 				= "Description";
	$config['err_function_desc'] 			= "Please fill in the function description!";	
	$config['err_exist_func'] 			= "Function is already registered.";
	$config['err_not_exist_func'] 		= "Function is not registered.";
	
	$config['active'] 					= "Active";
	$config['inactive'] 				= "InActive";
	
	$config['err_directorat_name'] 		= "Please fill in the directorate name!";
	$config['err_exist_directorat_name'] 	= "Directorate is already registered!";
	$config['err_not_exist_directory'] 	= "Directorate is not registered!";	
	
	$config['err_group_name'] 			= "Please fill in the group name!";
	$config['err_exist_group'] 			= "Group is already registered!";	
	
	$config['err_department_name'] 		= "Please fill in the department name!";	
	$config['err_exist_department'] 		= "Department is already registered!";	
	$config['err_not_exist_group'] 		= "Group is not registered!";	
	
	$config['err_unit_name'] 			= "Please fill in the unit name!";	
	$config['err_exist_unit'] 			= "Unit is already registered!";
	$config['err_not_exist_department'] 	= "Department is not registered!";	
	$config['err_not_exist_unit'] 		= "Unit is not registered!";	

	$config['ok_add_directorat'] 			= "Directorate has been added";
	$config['ok_update_directorat'] 		= "Directorate has been updated.";	
	
	$config['ok_add_group'] 				= "Group has been added";
	$config['ok_update_group'] 			= "Group has been updated.";	

	$config['ok_add_department'] 			= "Department has been added";
	$config['ok_update_department'] 		= "Department has been updated.";	

	$config['ok_add_unit'] 				= "Unit has been added";
	$config['ok_update_unit'] 			= "Unit has been updated.";	

	$config['ok_add_func'] 				= "Function has been added";
	$config['ok_update_func'] 			= "Function has been updated.";	
	
	$config['ok_add_category'] 			= "The new Category is now saved";
	$config['ok_update_category'] 		= "The Category is now updated.";		

	$config['ok_add_topic'] 				= "The new Topic is now saved";
	$config['ok_update_topic'] 			= "The Topic is now updated.";		
	
	$config['ok_add_training']			= "The new Online Training is now saved.";
	$config['ok_add_certificate']			= "The new Certificate program is now created.";
	$config['ok_add_classroom']			= "The new Classroom Training is now saved.";
	
	$config['ok_update_training']			= "The Online Training is now updated.";
	$config['ok_update_certificate']		= "The Certificate program is now updated.";
	$config['ok_update_classroom']		= "The Classroom Training is now updated.";
		
	$config['per_page'] 				= "per page";
	$config['of'] 						= "of";
	$config['confirm_delete'] 			= "Are you sure you want to delete the data? Please confirm!";
	
	$config['category'] 				= "Category";
	$config['category_list'] 			= "List of Categories";
	
	// ILDP
	
	$config['ildp_category_list'] 		= "ILDP Category List";
	$config['ildp_header_list_category'] 	= "Below are the list of category available for ILDP:";
	
	$config['category_name'] 			= "Category Name";	
	$config['category_desc'] 			= "Description";
	$config['err_category_name'] 			= "Please fill in the category name!";	
	$config['err_exist_category_name'] 	= "Category name already registered!";		
	$config['err_not_exist_category_name'] 	= "Category name is not registered!";
	$config['err_category_code'] 			= "Please fill in the topic code!";
	$config['err_exist_category_code'] 	= "Category code is already registered!";		
	$config['err_topic_name'] 			= "Please fill in the topic name!";	
	$config['err_exist_topic_name'] 		= "Topic name is already registered!";	
	
	$config['header_list_category'] 		= "Below are the list of the categories:";
	
	$config['master_data'] 				= "Master Data";
	$config['your_profile'] 				= "Profile";
	$config['luser_rights'] 				= "User Rights";
	$config['home'] 					= "Home";
	$config['topic'] 					= "Topic";
	$config['topic_parent'] 				= "Topic Parent";
	$config['topic_name'] 				= "Topic Name";
	$config['topic_code'] 				= "Code";
	$config['learning_topics_list'] 		= "Learning Topics List";
	$config['llearning_topics'] 			= "Topic";
	
	// Topics, Online Training, Classroom Training, Certification
	
	$config['header_list_topic'] 		= "Below are the list of available learning topics and activities:";
	
	$config['password'] 			= "Password";
	$config['forgot_password'] 		= "Forgot Password";
	$config['email_not_in_db'] 		= "Your Email address does not exist in the system. Please check and try again!";
	$config['send_mail_failed'] 		= "send mail failed. please contact your administrator!";
	$config['password_resetter_mail_subject'] = "[".$company."] LMS Password resetter";
	$config['confirm_password'] 		= "Confirm password";
	$config['online_training'] 		= "Online Training";
	$config['classroom_training'] 	= "Classroom Training";	
	$config['certification'] 		= "Certification";
	$config['resources'] 			= "Resources";	
	$config['lcertification_list'] 	= "Certification List";
	
	$config['workstatuses'] 					= array(1=>"Staff", 2=>"Outsource",3=>"Contract");
	$config['materi_location'] 				= "Material location";	
	$config['training_time'] 				= "Training Date";
	$config['certificate_time'] 				= "Certification Period(s)";
	$config['ldate'] 						= "Date";
	$config['until'] 						= "until";
	$config['period'] 						= "Period";
	$config['per_month'] 					= "per month";
	$config['per_year'] 					= "per year";
	$config['author'] 						= "Author";
	$config['initial'] 						= "Initial";	
	$config['training_name'] 				= "Training Name";
	$config['lparticipant'] 					= "Participant";	
	$config['lupdateparticipant'] 			= "Participant Setting Update";
	$config['err_select_topic'] 				= "Please select a topic!";
	$config['err_emtpy_training_name'] 		= "Please fill in the Online Training name!";
	$config['err_emtpy_certificate_name'] 		= "Please fill in the Certificate program name!";
	$config['err_emtpy_classroom_name'] 		= "Please fill in the Classroom Training name!";	
	$config['err_not_exist_training_name'] 		= "Training name is not registered!";
	$config['err_emtpy_material_location'] 		= "Please choose material location!";
	
	$config['err_emtpy_training_period'] 		= "Please fill in the online training periode !";
	$config['err_emtpy_certificate_period'] 	= "Please fill in the certificate program periode !";
	$config['err_emtpy_classroom_period'] 		= "PPlease fill in the classroom training periode !";
	
	$config['err_emtpy_trainingdate1'] 		= "Please fill in the online training start date !";	
	$config['err_emtpy_certificatedate1'] 		= "Please fill in the certificate program start date !";	
	$config['err_emtpy_classroomdate1'] 		= "Please fill in the classroom training start date !";	
	
	$config['err_invalid_trainingdate1'] 		= "Invalid online training start date!";
	$config['err_invalid_certificatedate1'] 	= "Invalid certificate program start date!";
	$config['err_invalid_classroomdate1'] 		= "Invalid classroom training start date!";
	
	$config['err_emtpy_trainingdate2'] 		= "Please fill in the online training end date !";
	$config['err_emtpy_certificatedate2'] 		= "Please fill in the certificate program end date !";
	$config['err_emtpy_classroomdate2'] 		= "Please fill in the classroom training end date !";
	
	$config['err_invalid_trainingdate2'] 		= "Invalid online training end date !";
	$config['err_invalid_certificatedate2'] 	= "Invalid certificate program date end date !";
	$config['err_invalid_classroomdate2'] 		= "Invalid classroom training date end date !";
	
	$config['err_invalid_trainingdate'] 		= "Invalid online training date !";	
	$config['err_invalid_certificatedate'] 		= "Invalid certificate program date date !";
	$config['err_invalid_classroomdate'] 		= "Invalid classroom training date !";
	
	$config['err_invalid_training_period'] 		= "Invalid online training period!";
	$config['err_invalid_certificate_period'] 	= "Invalid certificate program period!";
	$config['err_invalid_classroom_period'] 	= "Invalid classroom training period!";
		
	$config['all_directorat'] = "All directorate";
	$config['all_staff'] = "All staff";
	$config['all_group'] = "All Group";
	$config['all_department'] = "All department";	
	$config['all_unit'] = "All unit";
	$config['all_jabatan'] = "All jabatan";	
	$config['all_function'] = "All function";
	$config['all_status_emp'] = "All status karyawan";
	$config['lprequisite'] = "Prerequisites";	
	$config['lpostrequisite'] = "Postrequisites";		
	$config['lcreate_course'] = "Create Course";	
	$config['ladd_training_time'] = "Add Training Periode";
	$config['ladd_certificate_time'] = "Add Certificate Periode";
	$config['ladd_classroom_time'] = "Add Classroom Periode";
	$config['err_emtpy_material_online'] = "Please choose material file!";
	$config['err_invalid_material_online'] = "Invalid material file!";
	$config['ok_update_participant_training'] = "Participant has been updated!";	
	$config['err_empty_prequisite'] = "Please select a prequisite training!";
	$config['ok_update_prequisite_training'] = "Prequisite training has been updated";
	$config['lpostrequisite'] = "Postrequisite";	
	$config['ok_update_postrequisite_training'] = "Postrequisite training has been updated";	
	$config['err_empty_postrequisite'] = "Please select a postrequisite training!";
	$config['lsetting'] = "Setting";
	$config['lbank_soal'] 					= "Question Bank";
	$config['lbanksoal_list_training'] 		= "Online Training Question Bank";	
	$config['lbanksoal_list_certification'] 	= "Certification Question Bank";	
	$config['ljumlah_soal'] 					= "Number of Question";
	$config['lbanksoal_name'] 				= "Question Bank Name";	
	$config['lfile'] 						= "File";
	$config['err_banksoal_name'] 				= "Please fill in the Question Bank name!";
	$config['err_exist_banksoal_name'] 		= "Question Bank is already registered!";
	$config['lbank_soal_training'] 			= "Online Training Question Bank";
	$config['lbanksoal_form_training'] 		= "Online Training Question Bank Form";	
	$config['lbanksoal_form_certificate'] 		= "Certification Question Bank";	
	$config['err_emtpy_banksoal_file'] 		= "Please choose question bank file!";
	$config['err_invalid_banksoal_file'] 		= "Invalid question bank file!";
	$config['lno'] 						= "No";
	$config['lquestion'] 					= "Question";
	$config['lanswer'] 						= "Answer";
	$config['ok_save_banksoal'] 				= "The new Question Bank is now saved";	
	$config['ok_update_banksoal'] 			= "The Question Bank is now updated";
	$config['ledit_soal'] 					= "Edit Question";		
	$config['lerr_empty_question'] 			= "Please type in the question!";
	$config['lerr_empty_answer'] 				= "Please type in the answer(s)!";
	$config['ok_update_soal'] 				= "The question is now updated!";	
	$config['lsoal_not_exist'] 				= "The Question Number is unavailable!";
	$config['ok_add_soal'] 					= "The new question is now saved and added!";	
	$config['lerr_empty_chooice'] 			= "Please fill in the choices!";	
	$config['lpraexam_lexam'] 				= "Pre-exam / Exam";
	$config['lpraexam'] 					= "Pre-exam";
	$config['lexam'] 						= "Exam";
	$config['ok_update_banksoal'] 			= "The Question Bank is now updated";	
	$config['err_emtpy_banksoal_praexam'] 		= "Please select question bank for the Pre-exam!";
	$config['err_emtpy_banksoal_exam'] 		= "Please select question bank for the Exam!";
	$config['lcertificate'] 					= "Certification";
	$config['llist'] 						= "List";
	$config['ltraining_max'] 				= "Maximum Attempt Number";	
	$config['linvalid_training_max'] 			= "Invalid Maximum Attempt Number!";	
	$config['ltraining'] 					= "Training";	
	$config['err_invalid_pramax'] 			= "Invalid Max Pre-exam";	
	$config['err_invalid_max'] 				= "Invalid Max Exam";	
	$config['ltraining_pass'] 				= "Minimum Passing Grade";
	$config['err_invalid_prapass'] 			= "Invalid Minimum Passing Grade!";	
	$config['certificate_name'] 				= "Certification Name";
	$config['lcreate_certificate'] 			= "Create Certification";
	$config['lupdate_setting'] 				= "Update Setting";
	$config['lduration'] 					= "Duration";
	$config['lhour'] 						= "Hour";
	$config['lminute'] 						= "Minute";	
	$config['lduration_per_soal'] 			= "Duration of each question";
	$config['lsecond'] 						= "second";	
	$config['ok_update_setting'] 				= "Setting has been updated!";		
	$config['linvalid_duration'] 				= "Invalid Duration setting!";
	$config['lerr_empty_duration'] 			= "Please set up the Duration!";
	$config['lerr_empty_durationperquest'] 		= "Please fill in the Duration of each question!";
	$config['lerr_invalid_durationperquest'] 	= "Invalid Duration of each question!";
	$config['lerr_empty_minpass'] 			= "Please fill in the Minimum Passing Grade!";
	$config['lerr_invalid_minpass'] 			= "Invalid Minimum Passing Grade value!";
	$config['err_emtpy_banksoal'] 			= "Please select the Question Bank!";
	$config['err_not_exist_banksoal'] 			= "The Question Bank is not available!";
	$config['llearning_admin'] 				= "Learning Admin";
	$config['llearning_admin_certification'] 	= "Learning Admin & Certification";
	
	$config['lsettings'] 					= "Settings";
	$config['luser_admin'] 					= "User Admin";	
	$config['lright_list'] 					= "List of User Groups";
	$config['lright_name'] 					= "User Group Name";	
	$config['lheader_list_right'] 			= "Below is the list of user groups. To set up user group access right, click on the user group name!";
	$config['lright'] 						= "User Group";	
	$config['lcreate_right'] 				= "Create User Group";	
	$config['lok_save_right'] 				= "User Group is now saved";
	$config['lerr_empty_right'] 				= "Please fill in the User Group name.";
	$config['lerr_exist_group_name'] 			= "The User Group is already registered.";
	$config['lright_module'] 				= "Module";
	$config['lok_add_module'] 				= "The Module is now saved and added";	
	$config['lerr_empty_module'] 				= "Please choose the Module.";
	$config['lerr_module_not_exist'] 			= "Module is not registered.";
	$config['lerr_module_already_exist'] 		= "Module is already registered.";
	
	$config['join_date'] 					= "Join Date";
	$config['employee_type'] 				= 'Employee Type';
	$config['ljumlah_soal'] 					= "Total Question";
	$config['lerr_empty_jmsoal'] 				= "Please fill in the Total Question number!";	
	$config['lerr_invalid_jmsoal'] 			= "Invalid Total Question number!";
	$config['lerr_empty_certificate'] 			= "Please fill in the Certificate program name!";
	$config['err_not_exist_certificate_name'] 	= "Certificate name is not registered!";
	
	$config['lunit_soal'] 					= "Question Unit";
	$config['lunit_soal_name'] 				= "Question Unit Name";
	$config['ladd_unitsoal'] 				= "Add Question Unit";
	$config['lerr_empty_unitsoal'] 			= "Please fill in the Question Unit name!";
	$config['lerr_exist_unitsoal'] 			= "The Question Unit name is already registered. Please create a new one!";
	$config['lerr_empty_file_unitsoal'] 		= "Please choose Question Unit file!";	
	$config['lerr_invalid_file_unitsoal'] 		= "Invalid Question Unit file!";
	$config['lerr_invalid_file_unitsoal_jabatan'] = "The Position Name ( %s ) is not available in this Question Unit file!";	
	$config['lunit_soal_question'] 			= "Question Unit Questions";
	$config['lpacket'] 						= "Package";	
	$config['lsoal'] 						= "Question";
	$config['lkey_answer'] 					= "Answer Key";
	$config['lchoose_answer'] 				= "Answers";
	$config['lbobot'] 						= "Question Level";
	$config['ladd_soal'] 					= "Add Question";
	$config['lerr_empty_packet'] 				= "Please fill in the package name!";
	$config['ltrainee'] 					= "Trainee";
	$config['lpercent_bobot'] 				= "Level Percentage";
	$config['lmudah'] 						= "Easy";
	$config['lsedang'] 						= "Average";
	$config['lsulit'] 						= "Difficult";
	$config['ldefault_setting'] 				= "Default Setting";
	$config['lempty_bobot_mudah'] 			= "Please fill in the Easy question percentage!";
	$config['lempty_bobot_sedang'] 			= "Please fill in the Average question percentage!";
	$config['lempty_bobot_sulit'] 			= "Please fill in the Difficult question percentage!";
	$config['lempty_chooice'] 				= "Please fill in all the form!";

	$config['linvalid_bobot_mudah'] 			= "Invalid Easy question percentage!";
	$config['linvalid_bobot_sedang'] 			= "Invalid Average question percentage!";
	$config['linvalid_bobot_sulit'] 			= "Invalid Difficult question percentage!";
	
	$config['linvalid_bobot_percent'] 			= "Invalid Level Percentage";
	$config['lok_update_defsetting']			= "The Default Setting is now updated!";	
	
	$config['lerr_invalid_duration'] 			= "Invalid duration!";
	$config['lerr_empty_jmsoal_defsetting'] 	= "Please fill in the default setting for total question number.";
	$config['lerr_invalid_jmsoal_defsetting'] 	= "Invalid default setting for total question number!";
	
	$config['lerr_empty_bobotmudah_defsetting'] 	= "Please fill in the default value for Easy question.";
	$config['lerr_invalid_bobotmudah_defsetting'] = "Invalid your  default value for Easy question!";
	
	$config['lerr_empty_bobotsedang_defsetting'] = "Please fill in the default value for Average question.";
	$config['lerr_invalid_bobotsedang_defsetting'] = "Invalid default value for Average question!";

	$config['lerr_empty_bobotsulit_defsetting'] = "Please fill in the default value for Difficult question.";
	$config['lerr_invalid_bobotsulit_defsetting'] = "Invalid default value for Difficult question!";
	$config['lerr_invalid_total_bobot'] 		= "Invalid total level!";
	$config['ljabatan_setting'] 				= "Position Setting";
	$config['lparent'] 						= "Parent";
	$config['lroot'] 						= "Root";
	
	// General Settings
	
	$config['lgeneralsetting'] 				= "General Settings";
	
	$config['linactive_period'] 				= "Inactive Period";
	$config['lsetting_expiredpassword'] 		= "Password Expired after";
	$config['lsetting_errorlogin'] 			= "Maximum allowed login error";
	$config['err_invalid_inactiveperiod'] 		= "Invalid Inactive Period value!";
	$config['err_invalid_expiredpassword'] 		= "Invalid Password Expired after value!";
	$config['err_invalid_errorlogin'] 			= "Invalid Maximum allowed login error value!";
	$config['ok_save_general_setting'] 		= "The General Settings is now updated!";
	
	$config['lmateri'] 						= "Material";
	$config['linactive_period_description'] 	= "Maximum time allowed for user not logging into the system (in days) ";
	$config['lexpired_password_description'] 	= "Password expired time (in days)";
	$config['lerror_login_description'] 		= "Maximum allowed login error attempts.";
	$config['lerrprequisite_message'] 			= "You still have to take the required activity before You can take this learning activity!";
	$config['lerror_login_description']		= "Maximum allowed login error attempts.";
	$config['lprerequisite_info'] 			= "T = Online Training  , C = Certification  , Ca = Classroom Training ";
	$config['lsudah'] 						= "Done";
	$config['lbelum'] 						= "Not Yet";
	$config['err_invalid_prajmlsoal'] 			= "Invalid question number value for the Pre-exam";
	$config['err_empty_prajmlsoal'] 			= "Please fill in the question number for the Pre-exam";
	
	$config['err_invalid_jmlsoal'] 			= "Invalid question number value for the Exam";
	$config['err_empty_jmlsoal'] 				= "Please fill in the question number for the Exam";

	$config['err_max_prajmlsoal'] 			= "The maximum question number for the Pre-exam is %d";
	$config['err_max_jmlsoal'] 				= "The maximum question number for the Exam is %d";
	$config['lconcurent_user'] 				= "Concurrent User";
	$config['lconcurent_user_description'] 		= "Maximum number of concurrent user";	
	$config['err_invalid_concurrentuser'] 		= "Invalid Concurrent User value!";	
	
	$config['lrecordperpage'] 				= "Record per page";	
	$config['lrecordperpage_description'] 		= "Total record per page";		
	$config['err_invalid_recordperpage'] 		= "Invalid total record per page value!";	
	
	$config['lmax_err_login'] 				= "You have reached the maximum login error attemps number. Please contact your Administrator!";
	$config['lexpired_password'] 				= "Your password is expired. Please change your password!";
	$config['lmax_user_login']				= "Too many users are logging in right now. Please try later or contact your Administrator!";
	
	$config['lsession_idle_time'] 			= "Session idle time";
	$config['lsession_idle_time_description'] 	= "Session timeout (seconds)";
	$config['lerr_session_idle_time'] 			= "Invalid session idle time";	
	
	$config['llevel'] 						= "Level";		
	$config['lheader_list_level']				= "Below is the setup for ".$company."'s company structure available throughout this system.";
	$config['llevel_name'] 					= "Organization Name";	
	$config['llevel_description'] 			= "Organization Description";	
	$config['lok_save_level'] 				= "Level has saved";
	$config['err_level_name'] 				= "Please fill in the organization name";
	$config['err_exist_level_name'] 			= "The organization name already exists in the database. Please create another name.";	

	$config['lerror_permission']				= "You do not have the access rights to this page, please contact your administrator!";	
	
	$config['err_please_type'] 				= "Please fill in the %s.";	
	$config['invalid_name'] 					= "The %s name you gave is invalid or incorrect.";
	$config['already_exist']					= "%s already exists in the database.";
	
	$config['ldelete']						= "Delete";
	$config['lerr_empty_levelgroup'] 			= "Please choose group!";
	$config['lall_npk'] 					= "All ID";	
	$config['err_empty_participant'] 			= "Participant is empty";
	$config['ldelete']						= "Delete";
	$config['lerr_empty_levelgroup'] 			= "Please choose group!";
	$config['lhierarchy']					= "Structure";
	$config['lorganisational_structure']		= "Company Structure";
	
	$config['lhierarchy_modify']				= "Modify Company Structure";
	$config['lhierarchy_add']				= "Add Company Structure";
	$config['lname']						= "Name";
	
	$config['lmodify_level'] 				= "Modify %s";
	$config['ladd_level']					= "Add %s";
	
	$config['ljabatan']						= "Position";
	$config['lerr_choose_npk'] 				= "Please choose User ID!";
	$config['lcost']						= "Cost";
	$config['ltraining_code'] 				= "Training Code";	
	$config['err_emtpy_training_code'] 		= "Please fill in the Training Code!";
	$config['err_exist_training_code'] 		= "The Training Code is already registered!";	
	$config['lcode'] 						= "Code";
	$config['lwebsitetitle'] 				= "Learning Platform Title";
	$config['lwebsitetitle_description'] 		= "The learning platform title";	
	$config['lerr_empty_websitetitle'] 		= "Please fill in the Learning Platform title";
	
	$config['lwebsitelogo'] 					= "Website Logo";
	$config['lwebsitelogo_description'] 		= "Company logo or Learning Platform logo.";
		
	$config['err_emtpy_certificatedate1'] 		= "Please fill in the certificate program start date!";	
	$config['err_invalid_certificatedate1'] 	= "Invalid certificate program start date!";
	$config['err_emtpy_certificatedate2'] 		= "Please fill in the certificate program end date!";
	$config['err_invalid_certificatedate2'] 	= "Invalid certificate program end date!";
	$config['err_invalid_certificatedate'] 		= "Invalid certificate program date!";	
	$config['err_invalid_certificate_period'] 	= "Invalid certificate period!";
	$config['lok_save_levelgroup'] 			= "Group level is now saved.";
	$config['lok_jabatan_saved'] 				= "The Position is now saved";
	$config['lchange_code'] 					= "Editing the code might effecting the export-import processes between the LMS and other system. \r\n Are You sure You want to change the code? ";
	//$config['lchange_code_confirm'] = "Apakah Anda yakin ingin mengganti kode ?";
	
	$config['ldefaultlanguange'] 				= "Default language";
	$config['ldefaultlanguange_description'] 	= "Default language";	
	$config['lndonesia'] 					= "Bahasa Indonesia";
	$config['lenglish'] 					= "English";	
	$config['llearning_trainee'] 				= "Learning Profile";	
	$config['lperiod'] 						= "Period";
	$config['luntil'] 						= "until";
	$config['needpraexam'] 					= "You shall take the Pre-exam before You can take the Online Training and the Exam.";
	$config['needmateri'] 					= "You shall take the materi before You can take the Exam.";
	
	$config['lmypersonal_report'] 			= "My Personal Report";
	$config['ltimetakes'] 					= "Times takes";
	$config['ltimetakes'] 					= "Times takes";
	$config['llasttake'] 					= "Last takes";
	$config['llastscore'] 					= "Last score/Best Score";	
	$config['lhistory'] 					= "History";
	$config['lscore'] 						= "Score";
	$config['llulus'] 						= "Passed";
	$config['lnolulus'] 					= "Failed";
	$config['lcetak'] 						= "Print Certificate";
	$config['lcompeted'] 					= "Completed";
	
	$config['lerr_jml_soal'] 				= "The Total Question numbers setting is invalid!";
	$config['lrightanswered'] 				= "Right Answers";	
	$config['lwronganswered'] 				= "Wrong Answers";
	$config['llength'] 						= "Duration";
	
	$config['needpracertificate'] 			= "You have to finish the pre-requirements, before You can take this Certification Program.";
	$config['ltaken']						= "Taken";
	
	$config['lerr_empty_resource_name'] 		= "Please fill in the resource name!";
	$config['lerr_empty_resource_file'] 		= "Please choose the resource file!";
	$config['lresource_setting'] 				= "Resource setting.";	

	$config['lmaximum_size'] 				= "Maximum Filesize";	
	$config['lmaximum_size_description'] 		= "Maximum filesize for the imports (in kB)";	
	$config['lerr_invalid_resource_filesize'] 	= "The file is too large. Maximum file size allowed is %s kB!";
	$config['ladd_recourcetype'] 				= "Add File Type";		
	$config['lresource_type'] 				= "File Type";	
	$config['err_invalid_resourcemaxsize'] 		= "Invalid resource max size value!";
	$config['lresource_type_description']		= "fill *, for all files";
	$config['err_empty_resourcetype']			= "Please type your resource type";	
	$config['lerr_invalid_resource_filetype'] 	= "Invalid resource type. Allowed type: %s";	
	$config['ok_add_resource'] 				= "The new resource is now added and saved";	
	$config['ok_update_resource'] 			= "The resource is now updated";
	$config['lresources'] 					= "Resources";	
	$config['lsize'] 						= "Size";
	$config['lresources_participant'] 			= "Resource participant";
	
	$config['ladmin'] 						= "Administrator";
	$config['lunlimit']						= "If 0 , unlimit ";
	$config['lall_period'] 					= "All Period";	
	$config['lnot_enough_soal'] 				= "Insufficient question numbers. Please contact your Administrator.";
	$config['lfileresource_not_found'] 		= "The Resource can not be found. Please contact your Administrator";	
	
	$config['lshown'] 						= "Shown";
	$config['lright_answered'] 				= "Right Answered";
	$config['lwrong_answered'] 				= "Wrong Answered";
	$config['lexam_rule'] 					= "Rule";
	$config['lcourse_taken']					= "You have taken this course <b>%d </b>times";
	$config['lcourse_taken']					= "You have taken this course <b>%d </b>times";
	$config['lcertification_prepared'] 		= "This Certification is prepared by : ";
	$config['lstart'] 						= "Start";
	$config['lstart_period'] 				= "Start Period";
	$config['lend_period'] 					= "End Period";
	$config['lcertificate_sign'] 				= "Certificate sign";
	$config['lcertificate_sign_description'] 	= "Certificate sign";	
	$config['ltrainee_menu']					= "Trainee Menu";
	$config['ladmin_menu']					= "Admin Menu";
	
	$config['lsmtp_host']					= "SMTP Host";
	$config['lsmtp_host_description']			= "SMTP Host";

	$config['lsmtp_user']					= "SMTP User";
	$config['lsmtp_user_description']			= "SMTP User";

	$config['lsmtp_password']				= "SMTP Password";
	$config['lsmtp_password_description']		= "SMTP Password";
	$config['lcertification_code']			= "Certification Code";
	$config['llokasi_fisik']					= "Location";
	$config['llokasi_list']					= "List of Locations";
	$config['lheader_list_lokasi'] 			= "Below is the list of locations:";
	$config['ladd_lokasi_list']				= "Add Location";
	$config['lupdate_lokasi_list']			= "Edit Location";
	$config['lok_save_lokasi']				= "The new Location is now saved";
	$config['lerr_exist_lokasi']				= "The Location is now updated.";
	
	$config['lreset']						= "Reset";
	$config['lnoanswer']					= "No Answer";
	$config['lsearch_by']					= "Search by";
	$config['lsearch']						= "Search";
	$config['limport_npk']					= "Import ID";
	$config['lempty_filenpk']				= "Choose ID File";
	$config['lempty_npk']					= "User ID is empty.";
	$config['limportnpk_save']				= "Import succeded";
	$config['limportnpk_save']				= "User ID import succeeded. <br />Total data: %d<br />Total ID: %d";
	$config['lexport']						= "Export";
	$config['limport']						= "Import";
	$config['limport_user']					= "User Import";
	$config['limport_user_new_sap']			= "User Import (new system)";
	$config['luser_file']					= "User File (xls)";
	$config['limport_user_old_system']			= "User Import (old system)";
	$config['lempty_user_file']				= "Please choose user file (xls)";
	$config['lempty_user_file1']				= "Please choose user file (xls)";
	$config['lempty_user_file_data']			= "Data is empty";
	$config['linvalid_user_file_tgl_masuk']		= "Invalid user file (the field TGL MASUK is unavailable)";
	$config['lempty_user_file_data1']			= "Invalid user file (the field level group is unavailable)";
	$config['limportuser_ok']				= "Import user succeeded";
	$config['lreset_errorlogin']				= "Reset error login";
	$config['lexport_history'] 				= "Export History";
	$config['limport_category_topic'] 			= "Import Category / Topic";
	$config['lcategory_topic_file'] 			= "Category / Topic File";
	$config['limport_training'] 				= "Import Training";
	$config['ltraining_file'] 				= "Training File";	
	$config['lempty_category_topic_file'] 		= "Please choose category/topic file (xls).";	
	$config['lempty_category_topic_file_data'] 	= "Data is empty";
	$config['limportcategory_topic_ok'] 		= "Import category/topic berhasil.";
	$config['lempty_training_file'] 			= "Please choose training file (xls).";
	$config['lempty_training_file_data'] 		= "Data is empty";
	$config['limporttraining_ok'] 			= "Training import succeeded.";
	
	$config['limport_historyexam'] 			= "Import Exam History";
	$config['lempty_historyexam_file'] 		= "Please choose history exam file (xls)";
	$config['lempty_historyexam_file_data'] 	= "Data is empty";
	$config['limporthistoryexamok'] 			= "Exam History Import succeeded.";	
	$config['lhistoryexam_file'] 				= "Exam History File";

	$config['limport_org'] 					= "Import Company Structure";
	$config['lorg_file'] 					= "Company Structure File";
	$config['lempty_org_file']				= "Please choose Company Structure file (xls)";
	$config['lempty_org_file_data'] 			= "Data is empty";
	$config['limportorg_ok'] 				= "The Company Structure is succesfully imported.";		

	$config['limport_hirarchy_group'] 			= "Import hirarchy group";
	$config['lhirarchy_group_file'] 			= "Hirarchy group File";
	$config['lempty_hirarchy_group_file'] 		= "Please choose hirarchy group file (xls)";
	$config['lempty_hirarchy_group_file_data'] 	= "Data is empty";
	$config['limporthirarchy_group_ok'] 		= "Import hirarchy group succeeded.";		

	$config['limport_jabatan'] 				= "Import jabatan";
	$config['ljabatan_file'] 				= "Jabatan File";
	$config['lempty_jabatan_file'] 			= "Please choose jabatan file (xls)";
	$config['lempty_jabatan_file_data'] 		= "Data is empty";
	$config['limportjabatan_ok'] 				= "Import Position succeeded.";		

	$config['limport_lokasi'] 				= "Location import";
	$config['llokasi_file'] 					= "Location File";
	$config['lempty_lokasi_file'] 			= "Please choose lokasi file (xls)";
	$config['lempty_lokasi_file_data'] 		= "Data is empty";
	$config['limportlokasi_ok'] 				= "Import Location succeeded.";	
	$config['lconfirm_reset_all_npk'] 			= "Are You sure You want to reset all ID for this training/certificate?";
	$config['lconfirm_reset_periode'] 			= "Are You sure You want to reset all ID for this periode?";
	$config['lreset_npk_per_jabatan'] 			= "Are You sure You want reset all ID for this title?";
	$config['lreset_per_npk'] 				= "Are You sure You want to reset all ID for this ID?";
	$config['lshow_all'] 					= "Show all";	
	$config['lbackup'] 						= "Backup";
	$config['lexport_all_data'] 				= "Export All Data";
	
	$config['limport_alldata'] 				= "Import All Data";
	$config['ldump_file'] 					= "Dump File";
	$config['lempty_dump_file'] 				= "Please choose a dump file";
	$config['limport_dump_file_ok'] 			= "Dump file imported";	
	
	$config['limport_classroom'] 				= "Import Classroom";
	$config['lclassroom_file'] 				= "Classroom file (xls)";
	$config['lemplty_classroom_file'] 			= "Please choose classroom file (xls)";
	$config['lempty_classroom_file_data'] 		= "Data is empty.";
	$config['limportclassroom_ok'] 			= "Classroom information imported";
	$config['lnpk_classroom_not_exist'] 		= "ID %s is not registered.";
	$config['lnpk_classroom_empty_level_group'] = "Invalid data. Level group is empty";
	$config['lclassroom_code'] 				= "Classroom Code";
	$config['lclassroom_name'] 				= "Training Name";
	$config['lclassroom_update'] 				= "Update Classroom Training";
	$config['llokasi']	= "Lokasi";
	$config['lopen_offline_material'] 			= "To begin training, please plug in the USB disk / CD and open the file index.html in the folder %s in your internet browser!";
	$config['lvendor_name'] 					= "Vendor Name";
	$config['lbatch'] 						= "Batch";
	$config['linvalid_batch'] 				= "Invalid batch";
	$config['ltraining_materi_notfound'] 		= "Training material not found. Please contact your administrator";
	$config['lselect_training'] 				= "Training List";
	$config['lmaterial_file'] 				= "Material File (zip)";	
	$config['lmaterial_import'] 				= "Import Material";
	$config['limpor_material_ok'] 			= "Import Material successfully";	
	$config['lsave'] = "Save";	
	$config['lempty_choose_jabatan'] 			= "Please choose a position!";
	$config['lempty_choose_group'] 			= "Please choose a user group!";
	$config['lper_month'] 					= "per month";
	$config['lday_interval'] 				= "Day interval";
	$config['lday_interval_description'] 		= "Interval day for Refreshment Notification";
	$config['err_invalid_day_interval'] 		= "Invalid interval day";	
	$config['lremindermailsubject'] 			= "Reminder Subject";
	$config['lremindermailsubjectdescription'] 	= "Reminder Subject";
	$config['lremindermailsender'] 			= "Reminder email sender";
	$config['lremindermailsenderdescription'] 	= "Reminder email sender";	
	$config['lremindermailsender'] 			= "Reminder email sender";
	$config['lremindermailsendername'] 		= "Reminder sender name";
	$config['lremindermailsendernamedescription'] = "Reminder sender name";		
	$config['ltraining_type'] 				= "Training Type";	
	$config['ltotal'] 						= "Total";	
	
	
	//Position Category in MENU Settings
	
	$config['lcatjabatan'] 					= "Position Category";	
	$config['lcategory_jabatan_list'] 			= "List of Position Category";
	$config['lheader_list_category_jabatan'] 	= "Below is the list of Position Category:";
	$config['ladd_category_jabatan'] 			= "Add New Position Category";	
	$config['lmodify_category_jabatan'] 		= "Modify Position Category";	
	$config['ok_add_category_jabatan'] 		= "The new Position Category is now saved";
	$config['ok_update_category_jabatan'] 		= "The Position Category is now updated.";				
	
	$config['lrefresh'] 					= "Refresh";
	$config['laddcategory'] 					= "Add category";	
	$config['lgeneral_report'] 				= "General Report";
	
	$config['lprevyear'] 					= "Year(s)<br />Before";
	$config['lcurrentyear'] 					= "Current Year";
	$config['lpercent_staff_trained'] 			= "% Employee Trained";
	$config['ltotal_staff'] 					= "Total number of Employees";
	$config['ltotal_uniq_leaners'] 			= "Total unique Learners/employee trained";	
	$config['ltotal_untrained_emp'] 			= "Total Untrained Employees";	
	$config['ltotal_number_trainers'] 			= "Total number of learners";	
	$config['ltotal_learner_days'] 			= "Total Learner Days";
	$config['lbudget_realization'] 			= "Budget Realization";
	$config['lcent_mandatory_programmer'] 		= "Completion % of mandatory program";
	$config['laverage_program_attend'] 		= "Average Number of program attended per employee";
	$config['lratio_number'] 				= "Ratio number of program per learner ";
	$config['ljumlah_trainee'] 				= "Total number of Trainers";
	$config['ltraining_delivered'] 			= "Training Delivered";
	$config['laverage_training_mandays'] 		= "Average Training Mandays / Trainer";
	
	$config['lreport'] 						= "Report";
	$config['lrefreshment'] 					= "Refreshment";
	$config['lmonth'] 						= "month";
	$config['err_invalid_refreshment'] 		= "Invalid refreshment value!";
	
	$config['ldate'] 						= "Date";
	$config['lcertificate_no'] 				= "Certificate No";	
	$config['ltopic_code'] 					= "Topic Code";
	$config['lallcategory'] 					= "All Category";
	$config['lalltopic'] 					= "All Topic";	
		
	$config['linvalid_period'] 				= "Invalid period!";
	$config['lexport'] 						= "Export";
	$config['lresources_history'] 			= "History Resources";
	$config['laverage_learners'] 				= "Average Learner Days/Staff";
	$config['lcancelled_participant'] 			= "Canceled partisipants compare to invitee (classroom)";
	$config['ldelegetion'] 					= "Delegation";
	$config['lplease_select_user'] 			= "Please select user!";
	$config['ltraining_intro']				= "Training Page";
	$config['lnotice_per']					= "Notification periodic";
	$config['lnotice_per_description']			= "Notification periodic (in days) refer to Day Interval";
	$config['lerr_invalid_notice_per']			= "Invalid noticfication periodic value!";	
	
	$config['lcopy_paste']					= "Please copy and paste the address below to your browser";
	
	$config['lmateri_offline_message']	 		= "* This Training is done by offline using CD.<Br>";
	$config['lmateri_offline_message']			.= "* Please insert The CD into your computer.<BR>";
	$config['lmateri_offline_message']			.= "* After that, please choose the 'Drive' of the CD Drive<BR><BR>";
	
	$config['ltopic']						= "Topic";
	$config['lreport_type']					= "Report Type";
	$config['lgeneral_report_download_link']	= "You can download report on <a href='%s'>%s</a>";
	
	$config['lreminder'] 					= "Reminder";
	$config['lreminder_shedule_setting'] 		= "Reminder New Joiner Setting";
	$config['lnpk'] 						= "ID";
	$config['lcourse'] 						= "Course";
	
	
	$config['lclassroom'] 					= "Classroom";
	$config['lclassroom_list'] 				= "Classroom List";	
	$config['lheader_classroom_list']			= "Below are the list of the Classroom trainings:";
	$config['ltype'] 						= "Type";
	$config['limport_reminder'] 				= "Import Participant For Reminder New Joiner";
	$config['lcourse_type'] 					= "Course Type";
	$config['lempty_file'] 					= "File is empty";
	$config['lselect_corse'] 				= "Please select a corse!";
	$config['lempty_reminder_schedule_long'] 	= "Please type a schedule reminder in days!";	
	$config['linvalid_reminder_schedule_long'] 	= "Invalid schedule reminder in days!";		
	$config['lreminder_schedule'] 			= "Reminder schedule (in days)";
	$config['lnever'] 						= "Never";
	$config['lonce'] 						= "All History";	
	$config['lndays'] 						= "N days";		
	$config['lempty_reminder_schedule_condition'] = "Please type n day history!";
	$config['linvalid_reminder_schedule_condition'] = "Invalid n day history!";	
	$config['limport_reminder_successfully'] 	= "Import reminder is successfully!";
	$config['l_confirm_import_reminder'] 		= "Last imported schedule will be disabled. Are You sure You want to import new reminder schedule?";	
	$config['lreminder_info'] 				= "Reminder Info";		
	$config['lupdate_reminder_successfully'] 	= "Update reminder info is successfully";		
	$config['lremove_reminder_successfully'] 	= "Remove reminder info is successfully";		
	$config['lreminder_shedule_history'] 		= "Reminder New Joiner History";
	$config['lmail_sent'] 					= "Mail Sent";
	$config['lmail_failed'] 					= "Mail Failed";
	$config['lsmtp_port'] 					= "SMTP Port";
	$config['lmail_type'] 					= "Mail Server";
	$config['lmail_setting'] 				= "Mail Setting";
	$config['lmail_contenttype'] 				= "Mail Content Type";	
	$config['lerr_smtp_port'] 				= "Invalid SMTP Port";
	$config['limport_refreshment'] 			= "ID Import For Refreshment";
	$config['limport_refreshment_successfully'] 	= "Import User ID for refreshment is successful!";
	$config['l_confirm_import_refreshment'] 	= "Last imported participant list will be disabled. Are You sure You want to import new refreshment participant?";	
	$config['lrefreshment_shedule_setting'] 	= "Refreshment Participant";
	$config['lrefreshment_shedule_history'] 	= "Refreshment History";
	$config['lrefreshment_info'] 				= "Refreshment Status";
	$config['lupdate_refreshment_successfully'] 	= "Update refreshment successfully";
	
	
	$config['lildp_admin'] = "ILDP Admin";
	$config['lgrade'] = "Grade";
	$config['lprovider'] = "Training Provider";
	$config['lmethod'] = "Learning Method";
	$config['ldurations'] = "Durations";
	$config['ldays'] = "Days";
	
	$config['lselect_catalog_category'] = "Please select a catalog category";
	$config['lselect_catalog_topic'] = "Please select a catalog topic";	
	$config['lselect_catalog_code'] = "Please type a catalog code";
	$config['lduplicate_catalog_code'] = "Duplicate catalog code!";
	$config['lempty_catalog_days'] = "Please type a total days of classroom";
	$config['linvalid_catalog_days'] = "Invalid total days of classroom";	
	$config['linvalid_catalog_hour'] = "Invalid total hour of classroom";	
	$config['linvalid_catalog_minute'] = "Invalid total minute of classroom";	
	$config['lempty_catalog_name'] = "Please type a catalog name";
	$config['lempty_catalog_cost'] = "Please type a catalog cost";
	$config['linvalid_catalog_cost'] = "Invalid a catalog cost";
	$config['lsuccess_create_catalog'] = "Create catalog is successfully";
	$config['lsuccess_update_catalog'] = "Update catalog is successfully";	
	$config['lclassroom_catalog_list'] = "Catalog List";	
	$config['lheader_catalog_list']= "Below is the list of the catalogs:";
	$config['lheader_ildp_catalog_list']= "Below are ILDP Catalogs available in ".$company." On-line Learning System:";
	$config['lheader_ildp_method_list']= "Below are the learning methods in ".$company." On-line Learning System:";
	$config['lcatalog'] = "Catalog";
	$config['lildp_catalog'] = "ILDP Catalog";
	$config['ladd_ildp_catalog'] = "Add ILDP Catalog";
	$config['ledit_ildp_catalog'] = "Edit ILDP Catalog";
	
	$config['lregistration_period'] = "Registration Period";
	$config['lmonths'] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$config['lsuccess_update_setting'] = "Update setting is successfully";
	$config['lcart_already_exist'] = "Training already exist in your ILDP Form";
	$config['ladd_cart_successfully'] = "Training added successfully";
	$config['lildp_form'] = "ILDP Form";
	$config['lpart1_cart'] = "PART 1 - EMPLOYEE INFORMATION";
	$config['lemployee'] = "Employee";
	$config['ljob_title'] = "Position";
	$config['lempty_catalog_duration'] = "Please type training duration";
	$config['lempty_empty_grade'] = "Please type training grade";
	$config['lexternal_catalog_title'] = "External Catalog Title";
	$config['lexternal_catalog_tag'] = "External Catalog Tag";
	$config['lexternal_catalog_objective'] = "External Catalog Objective";
	$config['lmax_ambil_info'] = "If empty or 0(zero) then unlimitted";
	$config['lhrrm_setting'] = "HR RM Setting";
	$config['lhrld_setting'] = "HR L&D Setting";
	$config['lheader_lhrrm_setting_list']= "Below are the HR RM Setting available in ".$company." On-line Learning System:";
	$config['lheader_lhrld_setting_list']= "Berikut adalah HR L&D setting yang ada dalam ".$company." On-line Learning System:";	
	$config['lhrld_setting_already_exist'] = "HRRM setting is already exist";
	$config['lhrld_setting_added'] = "HRRM setting has beeen added";

	$config['lhrrm_setting_already_exist'] = "HR RM setting is already exist";
	$config['lhrrm_setting_added'] = "HR RM setting has beeen added";
	$config['lhrrm_setting_added'] = "HR RM setting has beeen added";

	$config['lheader_lhrld_setting_list']= "Berikut adalah HR L&D setting yang ada dalam ".$company." On-line Learning System:";	
	$config['lildp_period'] = "ILDP Period";
	$config['ltopic_not_found'] = "Topic is not found on row %d!";
	$config['lildp_import_success'] = "Import has successfully (%d)";
	$config['lcart'] = "Cart";
	$config['llevel_report'] = "Approval Level By Grade";	
	$config['ltraining_type'] = "Training Type";
	$config['ltraining_type_empty'] = "Please type training type";
	$config['ltraining_type_alreadyexist'] = "Training type already exist!";
	$config['lsuccess_update_ildp_catalog'] = "ILDP Catalog has been updated!";
	$config['lsuccess_create_ildp_catalog'] = "ILDP Catalog has been added!";

	$config['ltraining_type'] = "Training Type";
	$config['ltraining_type_a'] = "A : Training Wajib dari Bank";
	$config['ltraining_type_b'] = "B : Program Wajib yang disyaratkan oleh Regulator sesuai jabatan karyawan (jika ada) ";
	$config['ltraining_type_c'] = "C : Program Teknikal (sesuai kebutuhan karyawan)";
	$config['ltraining_type_d'] = "D : Program Leardership (sesuai kebutuhan karyawan)";
	$config['lactions'] = "Actions";
	$config['ldelete_from_ildp'] = "Delete Selected from ILDP Form";
	$config['lexternal_training'] = "Add External Training";
	$config['lempty_cart_selected'] = "Please select training(s)!";
	$config['ldelete_cart_success'] = "Delete training is successful!";
	$config['lempty_cart'] = "ILDP Form is empty";
	$config['lcheckout_success'] = "ILDP Form is successfully submitted";
	$config['lsubmit_ildp_form_message'] = "You ILDP Form has been submitted";
	
	$config['lobjective'] = "Learning Objective";
	$config['ltag'] = "Tag";
	$config['ltag_info'] = "Multiple tag, separated by ';' , ex : tag1;tag2;tag3";
	$config['ladd_to_ildp_form'] = "Add to ILDP Form";
	$config['lildp_form'] 	= "ILDP Form";
	
	$config['lempty_external_catalog_title'] = "Please type external catalog title!";
	$config['lempty_external_catalog_tag'] = "Please type external xatalog tag!";
	$config['lildp_approval'] = "ILDP Approval";
	$config['lpending_approval'] = "Pending Approval";
	$config['lapproval'] = "Approval";
	$config['lapprovalhist_list'] = "Approval History";
	$config['lreporter'] = "Reporter";
	$config['lmy_form'] = "My Form";	
	$config['lapproval_list'] = "Approval List";
	$config['lheader_approval_list'] = "Below are ILDP Form waiting for your approval";
	$config['lheader_approvalhist_list'] = "Below are the list of ILDP Form(s) you have decided";	
	$config['lsubmitdate'] = "Submittion date";
	$config['lapproval_form'] = "Approval Form";
	$config['lorder_approved'] = "ILDP Form approved!";
	$config['lmy_ildp_form'] = "My ILDP Form";
	
	$config['lheader_my_ildp_form']= "Below are ILDP Form on ".$company." On-line Learning System:";
	
	$config['lthen'] = "Then";
	$config['llevel_approval'] = "Approval Level";
	$config['lphone'] = "Phone";
	$config['lmobile'] = "Mobile";
	$config['lsave_draft'] = "ILDP Form saved";
	
	$config['lildp_subtitle'] = "Individual Learning &amp; Development Plan Form (ILDP Form)";
	$config['lpart2_cart'] = "PART 2 - TRAINING LIST";
	$config['lpart3_cart'] = "EXTERNAL DATA";
	
	$config['lreport_to'] = "Report To";
	$config['lapproved_by'] = "Approved by:";
	$config['lorder_rejected'] = "ILDP Form rejected!";
	$config['lstart_approval'] = "Start Approval Process";
	$config['lsave_form'] = "Save Form";
	$config['lrejected_by'] = "Rejected by %s ( %s )";
	$config['lsubmitted_ildp_form'] = "Submitted ILDP Form";
	$config['llast_edited'] = "Last Edited";
	$config['ldraft'] = "Draft";
	$config['lsubmitted'] = "Submitted";
	$config['ltrail'] = "ILDP Form Trail";
	$config['lactivity'] = "Activity";	
	$config['startapprovalprocess_by'] = "Submmited by";
	$config['approved_by'] = "Approved by";
	$config['rejected_by'] = "Rejected by";
	$config['savetodraft_by'] = "Drafted by";
	$config['lreject_reason'] = "Reject Reason";
	$config['lapprove_desc'] = "Approval Note";
	$config['lempty_reason'] = "Please type a reason!";
	$config['lrejected'] = "Rejected";
	$config['lreject'] = "Reject";
	$config['lcatalog_rejected'] = "Catalog has been rejected";
	$config['lrejected_date'] = "Rejected date";
	$config['ltba'] = "TBA";
	$config['lchange_this'] = "change this";
	$config['lildp_delegetion'] = "ILDP Delegetion";
	$config['lildp_add_delegetion'] = "ILDP Add Delegetion";
	$config['lildpdelegetion_added'] = "Delegator has been added";
	$config['lildpdelegetion_already_exist'] = "Delegator is already exist";
	
	$config['lsubject_approved_complete'] = "[ILDP] ILDP Form is approved";
	$config['lsubject_approved_complete_for_hrrm'] = "[ILDP] ILDP Form of %s is approved";
	$config['lsubject_rejected'] = "[ILDP] ILDP Form is rejected ";
	$config['lsubject_rejectedcatalog'] = "[ILDP] ILDP Catalog is rejected ";	
	$config['lsubject_approved'] = "[ILDP] ILDP Form is approved";	
	$config['lsubject_submitted'] = "[ILDP] %s has submitted ILDP Form";	
	$config['lsubject_for_approval'] = "[ILDP] %s needs your approval";	
	
	$config['lreminder_new_joiner'] = "Reminder New Joiner";
	$config['lreminder_refreshment'] = "Reminder Refreshment";
	$config['lconfirm_ildp_checkout'] = "Are you sure You want to submit this ILDP Form?";
	$config['lconfirm_ildp_approve'] = "Approve ILDP Form?";
	$config['lconfirm_ildp_reject'] = "Reject ILDP Form?";
	$config['lconfirm_ildp_content_reject'] = "Are You sure You want to reject this ILDP Item?";
	$config['lheader_ildpform_list']= "Below is the list of ILDP Forms:";
	$config['lconfirm_ildp_reset'] = "Are You sure You want to reset this ILDP Form?";
	$config['lildp_resetform_successfully'] = "The ILDP Form reset is done.";
	$config['lildp_form_reset_empty'] = "Please select a user!";
	$config['reset_by'] = "Reset by ";
	$config['lreset_by'] = "Reset by %s ";
	$config['lconfirm_ildp_draft'] = "Are You sure You want to save this ILDP Form?";
	$config['lcancel'] = "Cancel";
	$config['lreject'] = "Reject";
	$config['lapproval_history'] = "Approval History";
	$config['lapprove_hrld'] = "The last HRLD Approval date";
	$config['lapproved'] = "Approved";
	$config['lall'] = "All";
	$config['lconfirm_extdata_reject'] = "Are You sure You want to reject this external data?";
	$config['lorder_exdata_rejected'] = "The External data is rejected!";
	$config['lexternaldata_rejected'] = "The External data has been rejected";
	$config['lsubject_rejectedextdata'] = "Rejected External Data";
	$config['laddtocart'] = "Add to ILDP Form";
	$config['lcomment'] = "Comment";
	$config['lrepropose'] = "Repropose";
	$config['lrepropose_success'] = "Repropose is succes!";
	$config['lextdata_repropose_success'] = "Repropose external data is finished.";	
	$config['lsubject_resetform'] = "[ILDP] Reset ILDP Form";

	$config['ltraining_method']		= "Training Method";
	$config['leligible_grade']		= "Eligible Grade for Approval";
	$config['ladd_ildp_category'] = "Add ILDP Category";
	$config['ledit_ildp_category'] = "Edit ILDP Category";
	
	$config['lmax_line'] = "Max line";
	$config['linvalid_max_line'] = "Invalid max line!";
	$config['leligable_grade'] = "Eligible Grade";
	$config['linvalid_eligable_grade'] = "Invalid eligible grade!";
	$config['llearning_method'] = "Learning Method";
	
	$config['ledit_learning_method'] = "Edit Learning Method";
	$config['ladd_learning_method'] = "Add Learning Method";
	$config['llearning_method_name' ] = "Please type learning method";
	$config['llearning_method_alreadyexist'] = "Learning method already exist!";
	$config['lsuccess_update_ildp_method'] = "Learning method has been updated";
	$config['lsuccess_add_ildp_method'] = "Learning method has been added";
	
	$config['lmax_grade'] = "Max grade";
	$config['lildp_form_title'] = "INDIVIDUAL  LEARNING &  DEVELOPMENT  PLAN  FORM (ILDP FORM)";
	$config['lildp_form_header'] = "Program Title";
	$config['llearning_method_dev'] = "Method";
	$config['lbudget'] = "Budget (Rp.)";
	
	$config['lerr_ildp_period'] = "Not ildp registration period!";
	$config['lerr_select_ildp_training_type'] = "Please select training type!";
	$config['lerr_invalid_ildp_training_type'] = "Each Program Title can only be requested once";
	$config['linvalid_budget'] = "Invalid budget!";
	
	$config['lildp_registration_period'] = "Registration Period";
	$config['lheader_ildp_registration_period']= "Below are the ILDP Registration Period available in ".$company." On-line Learning System:";
	$config['ladd_ildp_reg_period'] = "Add ILDP Registration Period";
	$config['linvalid_ildp_regperiod'] = "Invalid registration period!";
	$config['lsuccess_create_ildp_regperiod'] = "ILDP registration period has been added!";
	$config['lnot_regperiod'] = "Not registration period!";
	$config['lempty_learning_method'] = "Please select a learning method";
	$config['limport_confirm']	= "Are You sure You want to import data?";
	$config['lapprove'] = "Approve";
	
	$config['lwaiting_approve_by'] = "Waiting for %s approval";
	$config['lildp_report'] = "ILDP Report";
	$config['lrekap_per_dir'] = "Recap by Directorate";
	$config['lrekap_per_group'] = "Recap by Group";
	$config['lrekap_per_dept'] = "Recap by Departement";
	$config['lrekap_per_unit'] = "Recap by Unit";
	$config['lrekap'] = "Recap ";
	$config['lrekap'] = "Recap ";
	$config['lby_dir'] = "By Directorate";
	$config['lby_group'] = "By Group";
	$config['lby_dept'] = "By Departement";	
	$config['lby_unit'] = "By Unit";
	$config['ldetail'] = "Detail";
	$config['lsubmit']	= "Submit";
	$config['ldone'] = "Done";
	$config['lnot_done'] = "Not Done";
	$config['lempty_select_ildp_form'] = "Please select a ILDP Form";
	
	$config['lexport_ildp_report_confirm'] = "Are You sure You want to export data?";	
	$config['lexport_type'] = "Export type";
	$config['lmax_score'] = "Max score";
	$config['llast_score'] = "Last score";
	$config['llast_lulus'] = "Last lulus";

	$config['lview_options']	= "View Options";
	$config['lup']	= "Up";
	$config['ldown'] = "Down";
	$config['lshow']	= "Show";
	$config['leligible_grade_for_approval'] = "Eligible Grade for Approval";
	$config['lrealization'] = "Realization";
	$config['lnew']  = "New";
	$config['llist']	= "List";
	$config['ledit']	= "Edit";
	$config['lildp_form_import'] = "ILDP Form Import";
	
	$config['llast_lulus']	= "Last Passed";


//-- brp
	$config['lnpk']						= "User ID";
	$config['lgrade']						= "Grade";
	$config['lmaxchangepassword'] 			= "Changed Password Maximum";
	$config['lmaxchangepassword'] 			= "Number of Unique Password saved";
	$config['lmaxchangepassworddescription'] 	= "Previous Password stored that can't be used";
	$config['lerr_maxchangepassword']  		= "The changes password save maximum numbers you gave is incorrect.";
	$config['lerr_invalid_hist_password'] 		= "The Password you gave was already used before. Please create a new one.";
	$config['lshow_materi_history'] 			= "Show All Activities History";
	$config['lyes'] 						= "Yes";
	$config['lmaximumtaken'] 				= "Maximum Training to be taken / day";
	$config['lerr_maxtaken'] 				= "The number of Maximum activity taken/day allowed for Training is incorrect";
	$config['errmaxtaken'] 					= "Error: Maximum activity taken/day allowed for Training";
	$config['lpasschange1st'] 				= "Password is expired with first login";
	
	$config['lstatus_code']					= "Status Code";
	$config['lstatus_description']			= "Status Description";
	$config['hierarchy_id']					= "Structure ID";
	$config['hierarchy_name']				= "Organization Name";
	

	$config['linvalid_atasan'] 				= "The Supervisor's ID you gave is incorrect";
	$config['latasan'] = "Supervisor";

	$config['lsort_by_npk'] = "Sort by User ID";
	$config['lsort_by_hierarchy']	= "Sort by structure name";