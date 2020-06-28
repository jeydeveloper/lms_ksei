<?php

$CI =& get_instance();            
$company = $CI->config->item('company');

	$config['ldays'] = "day(s)";
	$config['err_empty_npk'] = "Please type a your ID!";
	$config['err_already_exist_npk'] = "ID is already exist!";	
	$config['err_not_already_exist_npk'] = "ID is not already exist!";
	$config['err_empty_pass'] = "Please type a your password!";
	$config['err_invalid_login'] = "Invalid NPK or password!";	
	$config['err_empty_oldpass'] = "Please type a your old password!";
	$config['err_invalid_oldpass'] = "Invalid old password!";	
	$config['err_empty_newpass'] = "Please type a your new password!";
	$config['err_invalid_confirmpass'] = "Invalid confirm password!";
	$config['err_empty_firstname'] = "Please type a your first name!";
	$config['err_empty_lastname'] = "Please type a your last name!";
	$config['err_empty_joindate'] = "Please type a your join date!";
	$config['err_invalid_joindate'] = "Invalid your join date!";
	$config['err_empty_phone'] = "Please type a your phone!";	
	$config['err_empty_phoneext'] = "Please type a your phone extension!";	
	$config['err_empty_mobile'] = "Please type a your mobile!";	
	$config['err_empty_birthdate'] = "Please type a your birth date!";
	$config['err_invalid_birthdate'] = "Invalid your birth date!";
	$config['err_empty_location'] = "Please type a your location!";
	$config['err_empty_city'] = "Please type a your city!";	
	$config['err_empty_email'] = "Please type a your email!";	
	$config['err_invalid_email'] = "Invalid email!";
	$config['err_exist_email'] = "Email is already exist!";	
	
	$config['first_name'] = "First Name";	
	$config['last_name'] = "Last Name";	
	$config['confirm_new_password'] = "Confirm New password";
	$config['new_password'] = "New password";
	$config['old_password'] = "Old password";
	$config['edit_profile'] = "Edit Profile";
	$config['change_pass'] = "Change Password";
	$config['profile'] = "Profile";
	$config['city'] = "City";
	$config['location'] = "Location";
	$config['birthdate'] = "Birthdate";
	$config['email'] = "Email";
	$config['account_header'] = "Account";
	$config['user_list'] = "User List";
	$config['user'] = "User";
	$config['lall_user'] = "All user";    
	$config['logout'] = "Logout";
	$config['header_list_user'] = "These are the users of ".$company." :";
	
	$config['ok_change_pass'] 	= "Password has been changed.";
	$config['ok_update_user'] 	= "Profile has been changed.";	
	$config['ok_add_user'] 		= "User has been added.";	
	
	$config['err_exipred_session'] = "Session expired. Please restart page!";	
	
	$config['directorat'] 		= "Directorate";
	$config['name'] 			= "Name";
	$config['directorat_name'] 	= "Directorate Name";
	$config['status'] 			= "Status";
	$config['lconfirm_change_status'] = "Are you sure to change the status?";
	$config['lconfirm_ildp_catalog_save'] = "Save changes?";
	$config['lcheck_all'] = "Check all";
	$config['lilpd_catalog_import'] = "ILDP Catalog Import";
	$config['sort_list_by'] 	= "Sort list by";
	$config['date_added'] 		= "Add Data";
	$config['directorat_list'] 	= "Directorate List";
	$config['header_list_directorat'] = "These are directorate that available in ".$company." On-line Learning System:";
	
	$config['group_name'] 			= "Group Name";
	$config['group'] 				= "Group";
	$config['group_list'] 			= "Group List";	
	$config['header_list_group'] 	= "Berikut adalah group yang ada dalam ".$company." On-line Learning System:";
	
	$config['jabatan'] 				= "Position";
	$config['jabatan_list'] 		= "Position List";
	$config['jabatan_name'] 		= "Position Name";	
	$config['header_list_jabatan'] 	= "Berikut adalah jabatan yang ada dalam Learning Management System ".$company." ini:";	
	$config['err_jabatan_name'] 	= "Please type your jabatan!";
	$config['err_exist_jabatan'] 	= "Jabatan is already exist!";
	$config['err_not_exist_jabatan'] = "Jabatan is not exist!";
	$config['lconfirm_change_order'] = "Are you sure to re-order data?";
	$config['lconfirm_reset_data'] = "Reset data?";
	
	$config['unit'] = "Unit";
	$config['unit_name'] = "Unit Name";	
	$config['unit_list'] = "Unit List";	
	$config['header_list_unit'] = "Berikut adalah unit yang ada dalam Learning Management System ".$company." ini:";
	$config['err_not_exist_unit'] = "Unit is already exist!";		
	
	$config['last_login'] = "Last Login";
	$config['user_type'] = "User Type";
	$config['work_status'] = "Work Status";
	$config['department'] = "Department";
	$config['department_list'] = "Department List";
	$config['department_name'] = "Department Name";	
	$config['header_list_department'] = "Berikut adalah department yang ada dalam Learning Management System ".$company." ini:";
	
	$config['function'] = "Function";
	$config['function_list'] = "Function List";
	$config['function_desc'] = "Function Description";
	$config['header_list_function'] = "Berikut adalah function yang ada dalam Learning Management System ".$company." ini:";	
	$config['description'] = "Description";
	$config['err_function_desc'] = "Please type a your function description!";	
	$config['err_exist_func'] = "Function is already exist!";
	$config['err_not_exist_func'] = "Function is not exist!";
	
	$config['active'] = "Aktif";
	$config['inactive'] = "Tidak Aktif";
	
	$config['err_directorat_name'] = "Please type a your directorate name!";
	$config['err_exist_directorat_name'] = "Directorate is already exist!";
	$config['err_not_exist_directory'] = "Directorate is not exist!";	
	
	$config['err_group_name'] = "Please type a your group name!";
	$config['err_exist_group'] = "Group is already exist!";	
	
	$config['err_department_name'] = "Please type a your department name!";	
	$config['err_exist_department'] = "Department is already exist!";	
	$config['err_not_exist_group'] = "Group is not exist!";	
	
	$config['err_unit_name'] = "Please type a your unit name!";	
	$config['err_exist_unit'] = "Unit is already exist!";
	$config['err_not_exist_department'] = "Department is not exist!";	
	$config['err_not_exist_unit'] = "Unit is not exist!";	

	$config['ok_add_directorat'] = "Directorate has been added";
	$config['ok_update_directorat'] = "Directorate has been updated.";	
	
	$config['ok_add_group'] = "Group has been added";
	$config['ok_update_group'] = "Group has been updated.";	

	$config['ok_add_department'] = "Department has been added";
	$config['ok_update_department'] = "Department has been updated.";	

	$config['ok_add_unit'] = "Unit has been added";
	$config['ok_update_unit'] = "Unit has been updated.";	

	$config['ok_add_func'] = "Function has been added";
	$config['ok_update_func'] = "Function has been updated.";	
	
	$config['ok_add_category'] = "Category has been added";
	$config['ok_update_category'] = "Category has been updated.";		

	$config['ok_add_topic'] = "Topic has been added";
	$config['ok_update_topic'] = "Topic has been updated.";		
	
	$config['ok_add_training']= "Training has been created";
	$config['ok_add_certificate']= "Certificate has been created";
	$config['ok_add_classroom']= "Classroom has been created";
	
	$config['ok_update_training']= "Training telah terupdated";
	$config['ok_update_certificate']= "Certificate telah terupdated";
	$config['ok_update_classroom']= "Classroom telah terupdated";
		
	$config['per_page'] = "per page";
	$config['of'] = "of";
	$config['confirm_delete'] = "Are you sure to delete the data?";
	
	$config['category'] = "Category";
	$config['category_list'] = "Category List";
	
	$config['ildp_category_list'] = "ILDP Category List";
	$config['ildp_header_list_category'] = "Below are ILDP Categories available in ".$company." On-line Learning System:";
	
	$config['category_name'] = "Category Name";	
	$config['category_desc'] = "Description";
	$config['err_category_name'] = "Please type category name!";	
	$config['err_exist_category_name'] = "Category name is already exist!";		
	$config['err_not_exist_category_name'] = "Category name is not exist!";
	$config['err_category_code'] = "Please type topic code!";
	$config['err_exist_category_code'] = "Category code is already exist!";		
	$config['err_topic_name'] = "Please type topic name!";	
	$config['err_exist_topic_name'] = "Topic name is already exist!";	
	
	$config['header_list_category'] = "Berikut adalah kategori dari topik yang tersedia dalam ".$company." Learning Management System:";
	
	$config['master_data'] = "Master Data";
	$config['your_profile'] = "Profile";
	$config['luser_rights'] = "User Rights";
	$config['home'] = "Home";
	$config['topic'] = "Topic";
	$config['topic_parent'] = "Topic Parent";
	$config['topic_name'] = "Topic Name";
	$config['topic_code'] = "Code";
	$config['learning_topics_list'] = "Learning Topics List";
	$config['llearning_topics'] = "Catalog";
	
	$config['header_list_topic'] = "Berikut adalah topik-topik pembelajaran yang tersedia dalam Learning Management System ".$company." ini:";
	
	$config['password'] = "Password";
	$config['forgot_password'] = "Forgot Password";
	$config['email_not_in_db'] = "id: your e-mail address is not exist in my database!";
	$config['send_mail_failed'] = "send mail failed. please contact your administrator!";
	$config['password_resetter_mail_subject'] = "[".$company."] Learning Management System] Passwor resetter";
	$config['confirm_password'] = "Confirm password";
	$config['online_training'] = "Online Training";
	$config['classroom_training'] = "Classroom Training";	
	$config['certification'] = "Certification";
	$config['resources'] = "Resources";	
	$config['lcertification_list'] = "Certification List";
	
	$config['workstatuses'] = array(1=>"Staff", 2=>"Outsource",3=>"Contract");
	$config['materi_location'] = "Material location";	
	$config['training_time'] = "Training Date";
	$config['certificate_time'] = "Waktu Sertifikasi";
	$config['ldate'] = "Date";
	$config['until'] = "until";
	$config['period'] = "Period";
	$config['per_month'] = "per month";
	$config['per_year'] = "per year";
	$config['author'] = "Author";
	$config['initial'] = "Initial";	
	$config['training_name'] = "Training Name";
	$config['lparticipant'] = "Participant";	
	$config['lupdateparticipant'] = "Participant Update";
	$config['err_select_topic'] = "Please select a topic!";
	$config['err_emtpy_training_name'] = "Please type a training name!";
	$config['err_emtpy_certificate_name'] = "Please type a certificate name!";
	$config['err_emtpy_classroom_name'] = "Please type a classroom name!";	
	$config['err_not_exist_training_name'] = "Training name is not exist!";
	$config['err_emtpy_material_location'] = "Please type a material location!";
	
	$config['err_emtpy_training_period'] = "Please type a training periode !";
	$config['err_emtpy_certificate_period'] = "Please type a certificate periode !";
	$config['err_emtpy_classroom_period'] = "Please type a classroom periode !";
	
	$config['err_emtpy_trainingdate1'] = "Please type a training start date !";	
	$config['err_emtpy_certificatedate1'] = "Please type a certificate start date !";	
	$config['err_emtpy_classroomdate1'] = "Please type a classroom start date !";	
	
	$config['err_invalid_trainingdate1'] = "Invalid training start date !";
	$config['err_invalid_certificatedate1'] = "Invalid certificate start date !";
	$config['err_invalid_classroomdate1'] = "Invalid classroom start date !";
	
	$config['err_emtpy_trainingdate2'] = "Please type a training end date !";
	$config['err_emtpy_certificatedate2'] = "Please type a certificate end date !";
	$config['err_emtpy_classroomdate2'] = "Please type a classroom end date !";
	
	$config['err_invalid_trainingdate2'] = "Invalid training end date !";
	$config['err_invalid_certificatedate2'] = "Invalid certificatedate end date !";
	$config['err_invalid_classroomdate2'] = "Invalid classroomdate end date !";
	
	$config['err_invalid_trainingdate'] = "Invalid training date !";	
	$config['err_invalid_certificatedate'] = "Invalid certificatedate date !";
	$config['err_invalid_classroomdate'] = "Invalid classroomdate date !";
	
	$config['err_invalid_training_period'] = "Invalid training period !";
	$config['err_invalid_certificate_period'] = "Invalid certificate period !";
	$config['err_invalid_classroom_period'] = "Invalid classroom period !";
		
	$config['all_directorat'] = "All directorate";
	$config['all_staff'] = "All staff";
	$config['all_group'] = "All Group";
	$config['all_department'] = "All department";	
	$config['all_unit'] = "All unit";
	$config['all_jabatan'] = "All jabatan";	
	$config['all_function'] = "All function";
	$config['all_status_emp'] = "All status karyawan";
	$config['lprequisite'] = "Prequisites";	
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
	$config['lbank_soal'] = "Bank Soal";
	$config['lbanksoal_list_training'] = "Pra/Exam Bank Soal";	
	$config['lbanksoal_list_certification'] = "Certfiication Bank Soal";	
	$config['ljumlah_soal'] = "Jumlah Soal";
	$config['lbanksoal_name'] = "Nama Bank Soal";	
	$config['lfile'] = "File";
	$config['err_banksoal_name'] = "Please type bank soal name!";
	$config['err_exist_banksoal_name'] = "Banksoal is already exist!";
	$config['lbank_soal_training'] = "Pra/Exam Banksoal";
	$config['lbanksoal_form_training'] = "Pra/Exam Banksoal Form";	
	$config['lbanksoal_form_certificate'] = "Certificate Banksoal Form";	
	$config['err_emtpy_banksoal_file'] = "Please choose bank soal file!";
	$config['err_invalid_banksoal_file'] = "Invalid bank soal file!";
	$config['lno'] = "No";
	$config['lquestion'] = "Question";
	$config['lanswer'] = "Answer";
	$config['ok_save_banksoal'] = "Bank soal has saved";	
	$config['ok_update_banksoal'] = "Bank soal has updated";
	$config['ledit_soal'] = "Edit Soal";		
	$config['lerr_empty_question'] = "Please type your question!";
	$config['lerr_empty_answer'] = "Please type your answer!";
	$config['ok_update_soal'] = "Soal has been updated!";	
	$config['lsoal_not_exist'] = "No soal tidak ada!";
	$config['ok_add_soal'] = "Soal has been added!";	
	$config['lerr_empty_chooice'] = "Please type your chooice!";	
	$config['lpraexam_lexam'] = "Praexam / Exam";
	$config['lpraexam'] = "Praexam";
	$config['lexam'] = "Exam";
	$config['ok_update_banksoal'] = "Bank soal has been updated";	
	$config['err_emtpy_banksoal_praexam'] = "Please select bank soal for pra exam!";
	$config['err_emtpy_banksoal_exam'] = "Please select bank soal for exam!";
	$config['lcertificate'] = "Certification";
	$config['llist'] = "List";
	$config['ltraining_max'] = "Maximum tobe taken";	
	$config['linvalid_training_max'] = "Invalid Maximum tobe taken";	
	$config['ltraining'] = "Training";	
	$config['err_invalid_pramax'] = "Invalid max praexam";	
	$config['err_invalid_max'] = "Invalid Max exam";	
	$config['ltraining_pass'] = "Minimal Nilai Lulus";
	$config['err_invalid_prapass'] = "Invalid Nilai kelulusan";	
	$config['certificate_name'] = "Certification Name";
	$config['lcreate_certificate'] = "Create Certification";
	$config['lupdate_setting'] = "Update Setting";
	$config['lduration'] = "Duration";
	$config['lhour'] = "Hour";
	$config['lminute'] = "Minute";	
	$config['lduration_per_soal'] = "Durasi per soal";
	$config['lsecond'] = "second";	
	$config['ok_update_setting'] = "Setting has been updated!";		
	$config['linvalid_duration'] = "Durasi salah";
	$config['lerr_empty_duration'] = "Please type duration!";
	$config['lerr_empty_durationperquest'] = "Please type duration per question!";
	$config['lerr_invalid_durationperquest'] = "Invalid duration per question!";
	$config['lerr_empty_minpass'] = "Please type minimal pass value!";
	$config['lerr_invalid_minpass'] = "Invalid minimal pass value!";
	$config['err_emtpy_banksoal'] = "Please select bank soal!";
	$config['err_not_exist_banksoal'] = "Bank soal tidak ada!";
	$config['llearning_admin'] = "Learning Admin";
	$config['llearning_admin_certification'] = "Learning Admin & Certification";
	
	$config['lsettings'] = "Settings";
	$config['luser_admin'] = "User Admin";	
	$config['lright_list'] = "Group User List";
	$config['lright_name'] = "Group Name";	
	$config['lheader_list_right'] = "Berikut adalah nama user group yang tersedia dalam Learning Management System ".$company." ini:";
	$config['lright'] = "Group User";	
	$config['lcreate_right'] = "Create Group User";	
	$config['lok_save_right'] = "User group has been saved";
	$config['lerr_empty_right'] = "Please type your user group name.";
	$config['lerr_exist_group_name'] = "User group is already exist";
	$config['lright_module'] = "Module";
	$config['lok_add_module'] = "Module has been added";	
	$config['lerr_empty_module'] = "Please type your module.";
	$config['lerr_module_not_exist'] = "Module is not exist.";
	$config['lerr_module_already_exist'] = "Module is already exist.";
	
	$config['join_date'] = "Join date";
	$config['employee_type'] = 'Employee Type';
	$config['ljumlah_soal'] = "Jumlah soal";
	$config['lerr_empty_jmsoal'] = "Please type jumlah soal!";	
	$config['lerr_invalid_jmsoal'] = "Invalid jumlah soal!";
	$config['lerr_empty_certificate'] = "Please type certificate name!";
	$config['err_not_exist_certificate_name'] = "Certificate name is not exist!";
	
	$config['lunit_soal'] = "Unit Soal";
	$config['lunit_soal_name'] = "Unit Soal Name";
	$config['ladd_unitsoal'] = "Add Unit Soal";
	$config['lerr_empty_unitsoal'] = "Please type unit soal name!";
	$config['lerr_exist_unitsoal'] = "Unit soal name is already exist!";
	$config['lerr_empty_file_unitsoal'] = "Please choose unit soal file!";	
	$config['lerr_invalid_file_unitsoal'] = "Invalid unit soal file!";
	$config['lerr_invalid_file_unitsoal_jabatan'] = "Nama jabatan ( %s ) dalam unit soal file belum dibuat!";	
	$config['lunit_soal_question'] = "Pertanyaan Unit Soal";
	$config['lpacket'] = "Packet";	
	$config['lsoal'] = "Soal";
	$config['lkey_answer'] = "Kunci Jawaban";
	$config['lchoose_answer'] = "Pilihan Jawaban";
	$config['lbobot'] = "Bobot";
	$config['ladd_soal'] = "Add Soal";
	$config['lerr_empty_packet'] = "Please type packet name!";
	$config['ltrainee'] = "Trainee";
	$config['lpercent_bobot'] = "Persentasi Bobot";
	$config['lmudah'] = "Mudah";
	$config['lsedang'] = "Sedang";
	$config['lsulit'] = "Sulit";
	$config['ldefault_setting'] = "Default Setting";
	$config['lempty_bobot_mudah'] = "Please type persentasi bobot mudah";
	$config['lempty_bobot_sedang'] = "Please type persentasi bobot sedang";
	$config['lempty_bobot_sulit'] = "Please type persentasi bobot sulit";
	$config['lempty_chooice'] = "Pilihan tidak boleh kosong";

	$config['linvalid_bobot_mudah'] = "Invalid persentasi bobot mudah";
	$config['linvalid_bobot_sedang'] = "Invalid persentasi bobot sedang";
	$config['linvalid_bobot_sulit'] = "Invalid persentasi bobot sulit";
	
	$config['linvalid_bobot_percent'] = "Invalid persentasi bobot";
	$config['lok_update_defsetting'] = "Default setting has been updated!";	
	
	$config['lerr_invalid_duration'] = "Invalid duration!";
	$config['lerr_empty_jmsoal_defsetting'] = "Please type your default setting for jumlah soal";
	$config['lerr_invalid_jmsoal_defsetting'] = "Invalid your default setting for jumlah soal";
	
	$config['lerr_empty_bobotmudah_defsetting'] = "Please type your default bobot mudah for jumlah soal";
	$config['lerr_invalid_bobotmudah_defsetting'] = "Invalid your default bobot mudah for jumlah soal";
	
	$config['lerr_empty_bobotsedang_defsetting'] = "Please type your default bobot sedang for jumlah soal";
	$config['lerr_invalid_bobotsedang_defsetting'] = "Invalid your default bobot sedang for jumlah soal";

	$config['lerr_empty_bobotsulit_defsetting'] = "Please type your default bobot sulit for jumlah soal";
	$config['lerr_invalid_bobotsulit_defsetting'] = "Invalid your default bobot sulit for jumlah soal";
	$config['lerr_invalid_total_bobot'] = "Invalid total bobot!";
	$config['ljabatan_setting'] = "Jabatan Setting";
	$config['lparent'] = "Parent";
	$config['lroot'] = "Root";
	$config['lgeneralsetting'] = "General Settings";
	
	$config['linactive_period'] = "Inactive Period";
	$config['lsetting_expiredpassword'] = "Password Expired";
	$config['lsetting_errorlogin'] = "Maximum error login";
	$config['err_invalid_inactiveperiod'] = "Invalid inactive period!";
	$config['err_invalid_expiredpassword'] = "Invalid exipred password!";
	$config['err_invalid_errorlogin'] = "Invalid error login times!";
	$config['ok_save_general_setting'] = "General setting has been updated!";
	
	$config['lmateri'] = "Material";
	$config['linactive_period_description'] = "Maximum time for user for not login into the system (in days) ";
	$config['lexpired_password_description'] = "Password expired time (in days)";
	$config['lerror_login_description'] = "Maximum login error trial";
	$config['lerrprequisite_message'] = "Ada prequisite yang belum diambil";
	$config['lerror_login_description']	= "Maximum login error trial";
	$config['lprerequisite_info'] = "T = Training  , C=Certification  , Ca = Classroom ";
	$config['lsudah'] = "Sudah";
	$config['lbelum'] = "Belum";
	$config['err_invalid_prajmlsoal'] = "Invalid jumlah soal for praexam";
	$config['err_empty_prajmlsoal'] = "Please type jumlah soal for praexam";
	
	$config['err_invalid_jmlsoal'] = "Invalid jumlah soal for exam";
	$config['err_empty_jmlsoal'] = "Please type jumlah soal for exam";

	$config['err_max_prajmlsoal'] = "Maksimum jumlah soal for pra exam adalah %d";
	$config['err_max_jmlsoal'] = "Maksimum jumlah soal for exam adalah %d";
	$config['lconcurent_user'] = "Concurrent User";
	$config['lconcurent_user_description'] = "Maximum user yang login";	
	$config['err_invalid_concurrentuser'] = "Invalid concurren user!";	
	
	$config['lrecordperpage'] = "Record per page";	
	$config['lrecordperpage_description'] = "Total record per page";		
	$config['err_invalid_recordperpage'] = "Invalid total record per page";	
	
	$config['lmax_err_login'] = "Anda telah mencapai maksimum error login. Please contact your administrator!";
	$config['lexpired_password'] = "Your password expired. Please change your password!";
	$config['lmax_user_login'] = "Too many user login. Please contact your administrator!";
	
	$config['lsession_idle_time'] = "Session idle time";
	$config['lsession_idle_time_description'] = "Session timeout (seconds)";
	$config['lerr_session_idle_time'] = "Invalid session idle time";	
	
	$config['llevel'] = "Level";		
	$config['lheader_list_level']= "These are the available hierarchy in ".$company." Learning Management System:";
	$config['llevel_name'] = "Level Name";	
	$config['llevel_description'] = "Description";	
	$config['lok_save_level'] = "Level has saved";
	$config['err_level_name'] = "Please type level name";
	$config['err_exist_level_name'] = "Level is already exist";	

	$config['lerror_permission']	= "You don't have the access to this page, please contact your administrator!";	
	
	$config['err_please_type'] = "Please type %s";	
	$config['invalid_name'] = "Invalid %s name";
	$config['already_exist'] = "%s is already exist";
	
	$config['ldelete']		= "Delete";
	$config['lerr_empty_levelgroup'] = "Please choose group!";
	$config['lall_npk'] = "All ID";	
	$config['err_empty_participant'] = "Participant is empty";
	$config['ldelete']					= "Delete";
	$config['lerr_empty_levelgroup'] 	= "Please choose group!";
	$config['lhierarchy']				= "Hierarchy";
	$config['lorganisational_structure']= "Organizational Structure";
	
	$config['lhierarchy_modify']	= "Modify Hierarchy";
	$config['lhierarchy_add']		= "Add Hierarchy";
	$config['lname']				= "Name";
	
	$config['lmodify_level'] 	= "Modify %s";
	$config['ladd_level']		= "Add %s";
	
	$config['ljabatan']			= "Position";
	$config['lerr_choose_npk'] = "Please choose ID!";
	$config['lcost']			= "Cost";
	$config['ltraining_code'] = "Training Code";	
	$config['err_emtpy_training_code'] = "Please type training code!";
	$config['err_exist_training_code'] = "Training code is already exist!";	
	$config['lcode'] = "Code";
	$config['lwebsitetitle'] = "Website title";
	$config['lwebsitetitle_description'] = "Website title";	
	$config['lerr_empty_websitetitle'] = "Please type website title";
	
	$config['lwebsitelogo'] = "Website Logo";
	$config['lwebsitelogo_description'] = "Website Logo";
		
	$config['err_emtpy_certificatedate1'] = "Please type a certificate start date !";	
	$config['err_invalid_certificatedate1'] = "Invalid certificate start date !";
	$config['err_emtpy_certificatedate2'] = "Please type a certificate end date !";
	$config['err_invalid_certificatedate2'] = "Invalid certificate end date !";
	$config['err_invalid_certificatedate'] = "Invalid certificate date !";	
	$config['err_invalid_certificate_period'] = "Invalid certificate period !";
	$config['lok_save_levelgroup'] 		= "Level group telah berhasil di simpan";
	$config['lok_jabatan_saved'] = "Jabatan telah disimpan";
	$config['lchange_code'] = "Mengganti kode bisa mempengaruhi proses export-import antara LMS dan sistem lainnya. \r\nApakah Anda yakin ingin mengganti kode ? ";
	//$config['lchange_code_confirm'] = "Apakah Anda yakin ingin mengganti kode ?";
	
	$config['ldefaultlanguange'] = "Default language";
	$config['ldefaultlanguange_description'] = "Default language";	
	$config['lndonesia'] = "Indonesia";
	$config['lenglish'] = "English";	
	$config['llearning_trainee'] = "Learning Profile";	
	$config['lperiod'] = "Period";
	$config['luntil'] = "s.d";
	$config['needpraexam'] = "Sebelum melakukan exam atau membaca materi harus mengambil praexam terlebih dahulu.";
	
	$config['lmypersonal_report'] = "My Personal Report";
	$config['ltimetakes'] = "Times takes";
	$config['ltimetakes'] = "Times takes";
	$config['llasttake'] = "Last takes";
	$config['llastscore'] = "Last score/Best Score";	
	$config['lhistory'] = "History";
	$config['lscore'] = "Score";
	$config['llulus'] = "Lulus";
	$config['lnolulus'] = "Tidak Lulus";
	$config['lcetak'] = "Cetak";
	$config['lcompeted'] = "Completed";
	
	$config['lerr_jml_soal'] = "Total setting jumlah soal salah!";
	$config['lrightanswered'] = "Jawaban benar";	
	$config['lwronganswered'] = "Jawaban salah";
	$config['llength'] = "Length";
	
	$config['needpracertificate'] = "Sebelum melakukan ujian sertifikasi, Anda harus menyelesaikan prerequisite dari sertifikasi ini.";
	$config['ltaken']		= "Taken";
	
	$config['lerr_empty_resource_name'] = "Please type a resource name!";
	$config['lerr_empty_resource_file'] = "Please choose a resource file!";
	$config['lresource_setting'] = "Resource setting!";	

	$config['lmaximum_size'] = "Maximum size";	
	$config['lmaximum_size_description'] = "Maximum size (in kB)";	
	$config['lerr_invalid_resource_filesize'] = "File is too large. Maximu file is %s kB!";
	$config['ladd_recourcetype'] = "Add File Type";		
	$config['lresource_type'] = "File Type";	
	$config['err_invalid_resourcemaxsize'] = "Invalid resource max size!";
	$config['lresource_type_description'] = "fill *, for all files";
	$config['err_empty_resourcetype'] = "Please type your resource type";	
	$config['lerr_invalid_resource_filetype'] = "Invalid resource type. Allowed type: %s";	
	$config['ok_add_resource'] = "Resource has been added";	
	$config['ok_update_resource'] = "Resource has been updated";
	$config['lresources'] = "Resources";	
	$config['lsize'] = "Size";
	$config['lresources_participant'] = "Resource participant";
	
	$config['ladmin'] = "Administrator";
	$config['lunlimit']	= "If 0 , unlimit ";
	$config['lall_period'] = "All Period";	
	$config['lnot_enough_soal'] = "Jumlah soal tidak mencukupi. Silahkan hubungi administrator";
	$config['lfileresource_not_found'] = "Can't found resource. Please contact your administrator";	
	
	$config['lshown'] = "Shown";
	$config['lright_answered'] = "Right Answered";
	$config['lwrong_answered'] = "Wrong Answered";
	$config['lexam_rule'] = "Rule";
	$config['lcourse_taken']	= "You have took this course for <b>%d </b>times";
	$config['lcourse_taken']	= "You have took this course for <b>%d </b>times";
	$config['lcertification_prepared'] = "This Certification is prepared by : ";
	$config['lstart'] 			= "Start";
	$config['lstart_period'] 			= "Start Period";
	$config['lend_period'] 			= "End Period";
	$config['lcertificate_sign'] = "Certificate sign";
	$config['lcertificate_sign_description'] = "Certificate sign";	
	$config['ltrainee_menu']	= "Trainee Menu";
	$config['ladmin_menu']		= "Admin Menu";
	
	$config['lsmtp_host']		= "SMTP Host";
	$config['lsmtp_host_description']		= "SMTP Host";

	$config['lsmtp_user']		= "SMTP User";
	$config['lsmtp_user_description']		= "SMTP User";

	$config['lsmtp_password']		= "SMTP Password";
	$config['lsmtp_password_description']		= "SMTP Password";
	$config['lcertification_code']	= "Certification Code";
	$config['llokasi_fisik']	= "Lokasi Fisik";
	$config['llokasi_list']	= "Daftar Lokasi Fisik";
	$config['lheader_list_lokasi'] = "Berikut adalah daftar lokasi fisik yang tersedia dalam Learning Management System ".$company." ini:";
	$config['ladd_lokasi_list']	= "Tambah Lokasi Fisik";
	$config['lupdate_lokasi_list']	= "Edit Lokasi Fisik";
	$config['lok_save_lokasi']	= "Lokasi Fisik telah disimpan";
	$config['lerr_exist_lokasi']	= "Lokasi Fisik telah ada";
	$config['lreset']	= "Reset";
	$config['lnoanswer']	= "No answer";
	$config['lsearch_by']	= "Search by";
	$config['lsearch']	= "Search";
	$config['limport_npk']	= "Import ID";
	$config['lempty_filenpk']	= "Choose ID file";
	$config['lempty_npk']	= "Tidak ada data ID";
	$config['limportnpk_save']	= "Import berhasil";
	$config['limportnpk_save']	= "Import ID berhasil.<br />Total data: %d<br />Total ID: %d";
	$config['lexport']	= "Export";
	$config['limport']	= "Import";
	$config['limport_user']	= "User Import";
	$config['limport_user_new_sap']	= "User Import (new system)";
	$config['luser_file']	= "User File (xls)";
	$config['limport_user_old_system']	= "User Import (old system)";
	$config['lempty_user_file']	= "Please choose user file (xls)";
	$config['lempty_user_file1']	= "Please choose user file (xls)";
	$config['lempty_user_file_data']	= "Data is empty";
	$config['linvalid_user_file_tgl_masuk']	= "Invalid user file (tidak ada field TGL MASUK)";
	$config['lempty_user_file_data1']	= "Invalid user file (tidak ada field level group)";
	$config['limportuser_ok']	= "Import user telah berhasil";
	$config['lreset_errorlogin'] = "Reset error login";
	$config['lexport_history'] = "Export History";
	$config['limport_category_topic'] = "Import Category / Topic";
	$config['lcategory_topic_file'] = "Category / Topic File";
	$config['limport_training'] = "Import Training";
	$config['ltraining_file'] = "Training File";	
	$config['lempty_category_topic_file'] = "Please choose category/topic file (xls)";	
	$config['lempty_category_topic_file_data'] = "Data is empty";
	$config['limportcategory_topic_ok'] = "Import category/topic berhasil";
	$config['lempty_training_file'] = "Please choose training file (xls)";
	$config['lempty_training_file_data'] = "Data is empty";
	$config['limporttraining_ok'] = "Import training berhasil";
	
	$config['limport_historyexam'] = "Import History Exam";
	$config['lempty_historyexam_file'] = "Please choose history exam file (xls)";
	$config['lempty_historyexam_file_data'] = "Data is empty";
	$config['limporthistoryexamok'] = "Import history exam berhasil";	
	$config['lhistoryexam_file'] = "History Exam File";

	$config['limport_org'] = "Import Organizational Structure";
	$config['lorg_file'] = "Organizational Structure File";
	$config['lempty_org_file'] = "Please choose Organizational Structure file (xls)";
	$config['lempty_org_file_data'] = "Data is empty";
	$config['limportorg_ok'] = "Import Organizational Structure berhasil";		

	$config['limport_hirarchy_group'] = "Import hirarchy group";
	$config['lhirarchy_group_file'] = "Hirarchy group File";
	$config['lempty_hirarchy_group_file'] = "Please choose hirarchy group file (xls)";
	$config['lempty_hirarchy_group_file_data'] = "Data is empty";
	$config['limporthirarchy_group_ok'] = "Import hirarchy group berhasil";		

	$config['limport_jabatan'] = "Import jabatan";
	$config['ljabatan_file'] = "Jabatan File";
	$config['lempty_jabatan_file'] = "Please choose jabatan file (xls)";
	$config['lempty_jabatan_file_data'] = "Data is empty";
	$config['limportjabatan_ok'] = "Import jabatan berhasil";		

	$config['limport_lokasi'] = "Import lokasi";
	$config['llokasi_file'] = "Lokasi File";
	$config['lempty_lokasi_file'] = "Please choose lokasi file (xls)";
	$config['lempty_lokasi_file_data'] = "Data is empty";
	$config['limportlokasi_ok'] = "Import lokasi berhasil";	
	$config['lconfirm_reset_all_npk'] = "Are you sure to reset all ID for this training/certificate?";
	$config['lconfirm_reset_periode'] = "Are you sure to reset all ID for this periode?";
	$config['lreset_npk_per_jabatan'] = "Are you sure to reset all ID for this title?";
	$config['lreset_per_npk'] = "Are you sure to reset all ID for this ID?";
	$config['lshow_all'] = "Show all";	
	$config['lbackup'] = "Backup";
	$config['lexport_all_data'] = "Export All Data";
	
	$config['limport_alldata'] = "Import All Data";
	$config['ldump_file'] = "Dump File";
	$config['lempty_dump_file'] = "Please choose a dump file";
	$config['limport_dump_file_ok'] = "Dump file imported";	
	
	$config['limport_classroom'] = "Import Classroom";
	$config['lclassroom_file'] = "Classroom file (xls)";
	$config['lemplty_classroom_file'] = "Please choose classroom file (xls)";
	$config['lempty_classroom_file_data'] = "Data is empty.";
	$config['limportclassroom_ok'] = "Classroom imported";
	$config['lnpk_classroom_not_exist'] = "ID %s belum ada.";
	$config['lnpk_classroom_empty_level_group'] = "Invalid data. Level group is empty";
	$config['lclassroom_code'] = "Classroom Code";
	$config['lclassroom_name'] = "Training Title";
	$config['lclassroom_update'] = "Update Classroom Training";
	$config['llokasi']	= "Lokasi";
	$config['lopen_offline_material'] = "Untuk memulai pelatihan ini, harap masukkan flashdisk anda dan buka index.html di folder %s di browser anda";
	$config['lvendor_name'] = "Vendor Name";
	$config['lbatch'] = "Batch";
	$config['linvalid_batch'] = "Invalid batch";
	$config['ltraining_materi_notfound'] = "Training material not found. Please contact your administrator";
	$config['lselect_training'] = "Training List";
	$config['lmaterial_file'] = "Material File (zip)";	
	$config['lmaterial_import'] = "Import Material";
	$config['limpor_material_ok'] = "Import Material successfully";	
	$config['lsave'] = "Save";	
	$config['lempty_choose_jabatan'] = "Please choose a jabatan!";
	$config['lempty_choose_group'] = "Please choose a group!";
	$config['lper_month'] = "per month";
	$config['lday_interval'] = "Day interval";
	$config['lday_interval_description'] = "Interval day untuk notice";
	$config['err_invalid_day_interval'] = "Invalid interval day";	
	$config['lremindermailsubject'] = "Reminder Subject";
	$config['lremindermailsubjectdescription'] = "Reminder Subject";
	$config['lremindermailsender'] = "Reminder email sender";
	$config['lremindermailsenderdescription'] = "Reminder email sender";	
	$config['lremindermailsender'] = "Reminder email sender";
	$config['lremindermailsendername'] = "Reminder sender name";
	$config['lremindermailsendernamedescription'] = "Reminder sender name";		
	$config['ltraining_type'] = "Training Type";	
	$config['ltotal'] = "Total";	
	
	$config['lcatjabatan'] = "Kategori Jabatan";	
	$config['lcategory_jabatan_list'] = "Kategori Jabatan List";
	$config['lheader_list_category_jabatan'] = "Berikut adalah kategori dari jabatan yang tersedia dalam ".$company." Learning Management System:";
	$config['ladd_category_jabatan'] = "Add Kategori Jabatan";	
	$config['lmodify_category_jabatan'] = "Modify Kategori Jabatan";	
	$config['ok_add_category_jabatan'] = "Category Jabatan has been added";
	$config['ok_update_category_jabatan'] = "Category Jabatan has been updated.";				
	
	$config['lrefresh'] = "Refresh";
	$config['laddcategory'] = "Add category";	
	$config['lgeneral_report'] = "General Report";
	
	$config['lprevyear'] = "Tahun<br />Sebelumnya";
	$config['lcurrentyear'] = "Tahun Berjalan";
	$config['lpercent_staff_trained'] = "% Staff Trained";
	$config['ltotal_staff'] = "Total number of Staff";
	$config['ltotal_uniq_leaners'] = "Total unique Learners/employee trained";	
	$config['ltotal_untrained_emp'] = "Total Untrained Employees";	
	$config['ltotal_number_trainers'] = "Total number of learners";	
	$config['ltotal_learner_days'] = "Total Learner Days";
	$config['lbudget_realization'] = "Budget Realization";
	$config['lcent_mandatory_programmer'] = "Completion % of mandatory program";
	$config['laverage_program_attend'] = "Average Number of program attended per employee";
	$config['lratio_number'] = "Ratio number of program per learner ";
	$config['ljumlah_trainee'] = "Jumlah Trainers";
	$config['ltraining_delivered'] = "Training Delivered";
	$config['laverage_training_mandays'] = "Average Training Mandays / Trainer";
	
	$config['lreport'] = "Report";
	$config['lrefreshment'] = "Refreshment";
	$config['lmonth'] = "month";
	$config['err_invalid_refreshment'] = "Invalid refreshment value!";
	
	$config['ldate'] = "Date";
	$config['lcertificate_no'] = "Certificate No";	
	$config['ltopic_code'] = "Topic Code";
	$config['lallcategory'] = "All Category";
	$config['lalltopic'] = "All Topic";	
		
	$config['linvalid_period'] = "Invalid period!";
	$config['lexport'] = "Export";
	$config['lresources_history'] = "History Resources";
	$config['laverage_learners'] = "Average Learner Days/Staff";
	$config['lcancelled_participant'] = "Canceled partisiant compare to invitee (classroom)";
	$config['ldelegetion'] = "Delegation";
	$config['lplease_select_user'] = "Please select user!";
	$config['ltraining_intro']		= "Training Intro";
	$config['lnotice_per']		= "Notice periodic";
	$config['lnotice_per_description']		= "Notice periodic in days";
	$config['lerr_invalid_notice_per']		= "Invalid notice periodic";	
	
	$config['lcopy_paste']	= "Please Copy and Paste the address below to your browser";
	
	$config['lmateri_offline_message']	 = "* This Training is done by offline using usb.<Br>";
	$config['lmateri_offline_message']	.= "* Please plug your usb into your computer.<BR>";
	$config['lmateri_offline_message']	.= "* After that, please choose the 'Drive' of the usb<BR><BR>";
	
	$config['ltopic']	= "Topic";
	$config['lreport_type']	= "Report Type";
	$config['lgeneral_report_download_link']	= "You can download report on <a href='%s'>%s</a>";
	
	$config['lreminder'] = "Reminder";
	$config['lreminder_shedule_setting'] = "Reminder New Joiner Setting";
	$config['lnpk'] = "ID";
	$config['lcourse'] = "Course";
	$config['lclassroom'] = "Classroom";
	$config['lclassroom_list'] = "Classroom List";	
	$config['lheader_classroom_list']= "Berikut adalah classroom yang ada dalam Learning Management System ".$company." ini:";
	$config['ltype'] = "Type";
	$config['limport_reminder'] = "Import Participant For Reminder New Joiner";
	$config['lcourse_type'] = "Course Type";
	$config['lempty_file'] = "File is empty";
	$config['lselect_corse'] = "Please select a corse!";
	$config['lempty_reminder_schedule_long'] = "Please type a schedule reminder in days!";	
	$config['linvalid_reminder_schedule_long'] = "Invalid schedule reminder in days!";		
	$config['lreminder_schedule'] = "Reminder schedule (in days)";
	$config['lnever'] = "Never";
	$config['lonce'] = "All History";	
	$config['lndays'] = "N days";		
	$config['lempty_reminder_schedule_condition'] = "Please type n day history!";
	$config['linvalid_reminder_schedule_condition'] = "Invalid n day history!";	
	$config['limport_reminder_successfully'] = "Import reminder is successfully!";
	$config['l_confirm_import_reminder'] = "Last imported will be disable. Are you sure to import new reminder schedule?";	
	$config['lreminder_info'] = "Reminder Info";		
	$config['lupdate_reminder_successfully'] = "Update reminder info is successfully";		
	$config['lremove_reminder_successfully'] = "Remove reminder info is successfully";		
	$config['lreminder_shedule_history'] = "Reminder New Joiner History";
	$config['lmail_sent'] = "Mail Sent";
	$config['lmail_failed'] = "Mail Failed";
	$config['lsmtp_port'] = "SMTP Port";
	$config['lmail_type'] = "Mail Server";
	$config['lmail_setting'] = "Mail Setting";
	$config['lmail_contenttype'] = "Mail Content Type";	
	$config['lerr_smtp_port'] = "Invalid SMTP Port";
	$config['limport_refreshment'] = "ID Import For Refreshment";
	$config['limport_refreshment_successfully'] = "Import refreshment is successfully!";
	$config['l_confirm_import_refreshment'] = "Last imported will be disable. Are you sure to import new refreshment participant?";	
	$config['lrefreshment_shedule_setting'] = "Refreshment Participant";
	$config['lrefreshment_shedule_history'] = "Refreshment History";
	$config['lrefreshment_info'] = "Refreshment Status";
	$config['lupdate_refreshment_successfully'] = "Update refreshment successfully";
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
	$config['lheader_catalog_list']= "Berikut adalah catalog yang ada dalam Learning Management System ".$company." ini:";
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
	
	$config['lheader_my_ildp_form']= "Berikut adalah ILDP Form dalam ".$company." On-line Learning System:";
	
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
	$config['lconfirm_ildp_checkout'] = "Apakah anda yakin ingin men-submit ILDP Form ini ?";
	$config['lconfirm_ildp_approve'] = "Approve ILDP Form?";
	$config['lconfirm_ildp_reject'] = "Reject ILDP Form?";
	$config['lconfirm_ildp_content_reject'] = "Apakah anda yakin ingin menolak ILDP Catalog ini ?";
	$config['lheader_ildpform_list']= "Berikut adalah ILDP Form yang ada dalam ".$company." On-line Learning System:";
	$config['lconfirm_ildp_reset'] = "Apakah anda yakin ingin mereset ILDP Form ini ?";
	$config['lildp_resetform_successfully'] = "ILDP Form telah direset";
	$config['lildp_form_reset_empty'] = "Please select a user!";
	$config['reset_by'] = "Reset by ";
	$config['lreset_by'] = "Reset by %s ";
	$config['lconfirm_ildp_draft'] = "Apakah anda yakin ingin menyimpan ILDP Form ini ?";
	$config['lcancel'] = "Cancel";
	$config['lreject'] = "Reject";
	$config['lapproval_history'] = "Approval History";
	$config['lapprove_hrld'] = "TANGGAL AKHIR PERSETUJUAN HRLD";
	$config['lapproved'] = "Approved";
	$config['lall'] = "All";
	$config['lconfirm_extdata_reject'] = "Apakah Anda yakin ingin menolak external data ini?";
	$config['lorder_exdata_rejected'] = "External data ini telah di tolak!";
	$config['lexternaldata_rejected'] = "External data has been rejected";
	$config['lsubject_rejectedextdata'] = "Rejected External Data";
	$config['laddtocart'] = "Add to ILDP Form";
	$config['lcomment'] = "Comment";
	$config['lrepropose'] = "Repropose";
	$config['lrepropose_success'] = "Repropose is succes!";
	$config['lextdata_repropose_success'] = "Repropose external data is successfully";	
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
	$config['limport_confirm']	= "Are you sure to import data?";
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
	
	$config['lexport_ildp_report_confirm'] = "Are you sure to export data?";	
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
	
	$config['llast_lulus']	= "Last Lulus";


//-- brp
	$config['lnpk']	= "ID";
	$config['lgrade']	= "Pangkat";
	$config['lmaxchangepassword'] = "Maksimum ubah password";
	$config['lmaxchangepassword'] = "Number of Unique Password";
	$config['lmaxchangepassworddescription'] = "Maksimum ubah password";
	$config['lerr_maxchangepassword']  = "Nilai maksimum ubah password salah!";
	$config['lerr_invalid_hist_password'] = "Password is already use before";
	$config['lshow_materi_history'] = "Show materi history";
	$config['lyes'] = "Yes";
	$config['lmaximumtaken'] = "Maximum taken/day for Training";
	$config['lerr_maxtaken'] = "Invalid Maximum taken/day for Training";
	$config['errmaxtaken'] = "Error: Maximum taken/day for Training";
	$config['lpasschange1st'] = "Password expired when first login";



