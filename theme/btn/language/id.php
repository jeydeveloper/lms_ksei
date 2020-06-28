<?php
$CI =& get_instance();            
$company = $CI->config->item('company');

$lnpk = "NIP";

	$config['ldays'] = "day(s)";
	
	$config['err_empty_npk']= $lnpk." harap diisi!";
	$config['err_already_exist_npk']= $lnpk." sudah ada!";	
	$config['err_not_already_exist_npk']= $lnpk." Anda tidak ditemukan dalam sistem. Silahkan periksa dan mencoba kembali!";
	$config['err_empty_pass']= "Password harap diisi!";
	$config['err_invalid_login']= $lnpk." atau password salah!";	
	$config['err_empty_oldpass']= "Password lama harap diisi!";
	$config['err_invalid_oldpass']= "Password lama salah!";	
	$config['err_empty_newpass']= "Harap isi password baru!";
	$config['err_invalid_confirmpass']= "Konfirm password salah!";
	$config['err_empty_firstname']= "Nama depan harap diisi!";
	$config['err_empty_lastname']= "Nama belakang harap diisi!";
	$config['err_empty_joindate']= "Tanggal join harap diisi!";
	$config['err_invalid_joindate']= "Tanggal join invalid!";
	$config['err_empty_phone']= "Telepon harap diisi!";	
	$config['err_empty_phoneext']= "Extensi telepon harap diisi!";	
	$config['err_empty_mobile']= "No. HP harap diisi!";	
	$config['err_empty_birthdate']= "Tanggal lahir harap diisi!";
	$config['err_invalid_birthdate']= "Format tanggal lahir tidak valid!";
	$config['err_empty_location']= "Lokasi harap diisi!";
	$config['err_empty_city']= "Kota harap diisi!";	
	$config['err_empty_email']= "Email harap diisi!";	
	$config['err_invalid_email']= "Format email invalid!";
	$config['err_exist_email']= "Email sudah ada!";	
	
	$config['email']= "Email";
	$config['account_header']= "Account";
	$config['user_list']= "Daftar Pengguna";
	$config['header_list_user']= "Berikut adalah karyawan ".$company." ini:";
	
	$config['ok_change_pass']= "Password telah diubah.";
	$config['ok_update_user']= "Profil telah diubah.";	
	$config['ok_add_user']= "Pengguna telah ditambakan.";	
	
	$config['err_exipred_session']= "Session telah habis. Harap refresh halaman!";	
	
	$config['directorat']= "Direktorat";
	$config['name']= "Name";
	$config['directorat_name']= "Nama Direktorat";
	$config['status']= "Status";
	$config['lconfirm_change_status'] = "Apakah Anda yakin untuk mengganti status?";
	$config['lconfirm_ildp_catalog_save'] = "Save changes?";
	$config['sort_list_by']= "Urutkan berdasarkan";
	$config['date_added']= "Tambah data";
	$config['directorat_list']= "Daftar Direktorat";
	$config['header_list_directorat']= "Berikut adalah nama direktorat yang tersedia dalam Learning Management System ".$company." ini:";
	
	$config['group_name']= "Nama Grup";
	$config['group']= "Grup";
	$config['group_list']= "Daftar Grup";	
	$config['header_list_group']= "Berikut adalah group yang ada dalam Learning Management System ".$company." ini:";
	
	$config['jabatan']= "Position";
	$config['jabatan_list']= "Daftar Jabatan";
	$config['jabatan_name']= "Nama Jabatan";	
	$config['header_list_jabatan']= "Berikut adalah jabatan yang ada dalam Learning Management System ".$company." ini:";	
	$config['err_jabatan_name']= "Nama jabatan harap diisi!";
	$config['err_exist_jabatan']= "Jabatan sudah ada!";
	$config['err_not_exist_jabatan']= "Jabatan tidak ditemukan!";
	
	$config['unit']= "Unit";
	$config['unit_name']= "Nama Unit";	
	$config['unit_list']= "Daftar Unit";	
	$config['header_list_unit']= "Berikut adalah unit yang ada dalam Learning Management System ".$company." ini:";
	$config['err_not_exist_unit']= "Unit sudah ada!";		
	
	$config['department']= "Departemen";
	$config['department_list']= "Daftar Departemen";
	$config['department_name']= "Nama Departemen";	
	$config['header_list_department']= "Berikut adalah department yang ada dalam Learning Management System ".$company." ini:";
	
	$config['function_list']= "Daftar Fungsi";
	$config['function_desc']= "Deskripsi Fungsi";
	$config['header_list_function']= "Berikut adalah function yang ada dalam Learning Management System ".$company." ini:";	
	$config['description']= "Deskripsi";
	$config['err_function_desc']= "Deskripsi fungsi harap diisi!";	
	$config['err_exist_func']= "Fungsi sudah ada!";
	$config['err_not_exist_func']= "Fungsi tidak ditemukan!";
	
	$config['active']= "Aktif";
	$config['inactive']= "Tidak Aktif";
	
	$config['err_directorat_name']= "Nama direktorat harap diisi!";
	$config['err_exist_directorat_name']= "Direktorat sudah ada!";
	$config['err_not_exist_directory']= "Direktorat tidak ditemukan!";	
	
	$config['err_group_name']= "Nama group harap diisi!";
	$config['err_exist_group']= "Group sudah ada!";	
	
	$config['err_department_name']= "Nama departemen harap diisi!";	
	$config['err_exist_department']= "Departemen sudah ada!";	
	$config['err_not_exist_group']= "Group tidak ditemukan!";	
	
	$config['err_unit_name']= "Nama unit harap diisi!";	
	$config['err_exist_unit']= "Unit sudah ada!";
	$config['err_not_exist_department']= "Department tidak ditemukan!";	
	$config['err_not_exist_unit']= "Unit tidak ditemukan!";	

	$config['ok_add_directorat']= "Direktorat telah berhasil di tambahkan";
	$config['ok_update_directorat']= "Direktorat telah berhasil diubah.";	
	
	$config['ok_add_group']= "Group telah berhasil ditambahkan";
	$config['ok_update_group']= "Group telah berhasil di ubah.";	

	$config['ok_add_department']= "Departemen telah berhasil ditambahkan";
	$config['ok_update_department']= "Departemen telah berhasil diubah.";	

	$config['ok_add_unit']= "Unit telah berhasil ditambahkan";
	$config['ok_update_unit']= "Unit telah berhasil diubah.";	

	$config['ok_add_func']= "Fungsi telah berhasil ditambahkan";
	$config['ok_update_func']= "Fungsi telah berhasil diubah.";	
	
	$config['ok_add_category']= "Kategori telah berhasil ditambahkan";
	$config['ok_update_category']= "Kategori telah berhasil diubah.";		

	$config['ok_add_topic'] = "Topic has been added";
	$config['ok_update_topic'] = "Topic has been updated.";		
	
	$config['ok_add_training']= "Training has been created";
	$config['ok_add_certificate']= "Certificate has been created";
	
	$config['ok_update_training']= "Training telah terupdated";
	$config['ok_update_certificate']= "Certificate telah terupdated";
	$config['ok_update_classroom']= "Classroom telah terupdated";
		
	$config['per_page']= "per halaman";
	$config['of']= "dari";
	$config['confirm_delete']= "Apakah Anda yakin untuk menghapus data?";
	
	$config['category']= "Kategori";
	$config['category_list']= "Daftar Kategori";
	$config['category_name']= "Nama Kategori";	
	$config['category_desc']= "Deskripsi";
	$config['err_category_name']= "Nama kategori harap diisi!";	
	$config['err_exist_category_name']= "Nama kategori sudah ada!";		
	$config['err_not_exist_category_name']= "Nama kategori tidak ditemukan!";
	$config['err_category_code']= "Kode topik harap diisi!";
	$config['err_exist_category_code']= "Kode kategori sudah ada!";		
	$config['err_topic_name']= "Nama topik harap diisi!";	
	$config['err_exist_topic_name']= "Nama topik sudah ada!";	
	
	$config['header_list_category']= "Berikut adalah kategori dari topik yang tersedia dalam ".$company." On-line Learning System:";

	$config['ildp_category_list'] = "Daftar Kategori ILDP";
	$config['ildp_header_list_category'] = "Berikut adalah kategori dari ILDP yang tersedia dalam ".$company." On-line Learning System:";
	
	$config['topic']= "Topik";
	$config['topic_parent']= "Topic Parent";
	$config['topic_name']= "Nama Topik";
	$config['topic_code']= "Kode";
	$config['learning_topics_list']= "Daftar Topik Pembelajaran";
	$config['llearning_topics'] = "Topik";
	
	$config['header_list_topic']= "Berikut adalah topik-topik pembelajaran yang tersedia dalam Learning Management System ".$company." ini:";
	
	$config['password'] = "Kata kunci";
	$config['forgot_password'] = "Lupa Password";
	$config['email_not_in_db'] = "Email Anda tidak ditemukan dalam sistem. Silahkan periksa dan mencoba kembali!";
	$config['send_mail_failed'] = "Kirim email gagal. Harap kontak administrator!";	
	$config['password_resetter_mail_subject'] = "[".$company."] Learning Management System Password resetter";
	
	$config['join_date'] = "Tanggal Bergabung";
	$config['birthdate'] = "Tanggal Lahir";
	$config['location'] = "Lokasi Fisik";
	$config['city'] = "City";
	$config['function'] = "Fungsi";
	$config['work_status'] = "Status Kerja";
	$config['user_type'] = "User Type";
	$config['last_login'] = "Last Login";
	$config['profile'] = "Profil";
	$config['change_pass'] = "Ubah Password";
	$config['edit_profile'] = "Ubah Profil";
	$config['old_password'] = "Password sebelumnya";
	$config['new_password'] = "Password baru";
	$config['confirm_new_password'] = "Konfirmasi password baru";
	$config['confirm_password'] = "Konfirmasi password";
	$config['first_name'] = "Nama Depan";	
	$config['last_name'] = "Nama Belakang";	
	$config['home'] = "Halaman Muka";
	$config['your_profile'] = "Profil";
	$config['master_data'] = "Master Data";
	$config['user'] = "User";
	$config['lall_user'] = "Semua user";    
	$config['logout'] = "Keluar";
	$config['online_training'] = "Pelatihan Online";
	$config['classroom_training'] = "Classroom Training";	
	$config['certification'] = "Sertifikasi";
	$config['resources'] = "Resources";	
	$config['lcertification_list'] = "Certification List";
	
	$config['workstatuses'] = array(1=>"Staff",2=> "Outsource",3=>"Kontrak");
	
	$config['materi_location'] = "Lokasi Materi";
	$config['training_time'] = "Waktu Pelatihan";
	$config['certificate_time'] = "Waktu Sertifikasi";
	$config['until'] = "s.d";	
	$config['linvalid_eligable_grade'] = "Invalid eligable grade!";
	$config['period'] = "Periode";
	$config['per_month'] = "per bulan";
	$config['per_year'] = "per tahun";
	$config['author'] = "Pembuat";
	$config['initial'] = "Initial";	
	$config['training_name'] = "Nama Pelatihan";	
	$config['err_not_exist_training_name'] = "Nama pelatihan tidak ditemukan!";
	$config['all_staff'] = "Semua karyawan";
	$config['lupdateparticipant'] = "Update peserta";
	$config['err_select_topic'] = "Silahkan pilih topik!";
	$config['err_emtpy_training_name'] = "Nama pelatihan harap diisi!";
	$config['err_emtpy_certificate_name'] = "Please type a certificate name!";
	$config['err_emtpy_classroom_name'] = "Please type a classroom name!";	
	$config['err_emtpy_material_location'] = "Lokasi material harap diisi!";
	
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
		
	$config['all_directorat'] = "Semua Direktorat";
	$config['all_group'] = "Semua Grup";
	$config['all_department'] = "Semua Departemen";	
	$config['all_unit'] = "Semua Unit";
	$config['all_jabatan'] = "Semua Jabatan";	
	$config['all_function'] = "Semua Fungsi";
	$config['all_status_emp'] = "Semua Status karyawan";	
	$config['lparticipant'] = "Peserta";
	$config['lprequisite'] = "Prerequisites";	
	$config['lpostrequisite'] = "Postrequisites";	
	$config['ldate'] = "Tanggal";
	$config['lcreate_course'] = "Create Course";	
	$config['ladd_training_time'] = "Tambah periode pelatihan";
	$config['ladd_certificate_time'] = "Add Certificate Periode";
	$config['ladd_classroom_time'] = "Add Classroom Periode";
	
	$config['err_emtpy_material_online'] = "Harap pilih file material!";
	$config['err_invalid_material_online'] = "File material tidak valid!";
	$config['ok_update_participant_training'] = "Peserta telah berhasil diupdate!";	
	$config['err_empty_prequisite'] = "Harap pilih prerequisite!";
	$config['ok_update_prequisite_training'] = "Prerequisite telah berhasil diupdate";
	$config['lpostrequisite'] = "Postrequisite";
	$config['ok_update_postrequisite_training'] = "Postrequisite telah berhasil diupdate";
	$config['err_empty_postrequisite'] = "Harap pilih postrequisite!";
	$config['lsetting'] = "Pengaturan";
	$config['lbank_soal'] = "Bank Soal";
	$config['lbanksoal_list_training'] = "Bank Soal Pelatihan Online";
	$config['lbanksoal_list_certification'] = "Bank Soal Sertifikasi";
	$config['ljumlah_soal'] = "Jumlah Soal";
	$config['lbanksoal_name'] = "Nama Bank Soal";
	$config['lfile'] = "File";
	$config['lconfirm_change_order'] = "Apakah Anda yakin untuk mengurutkan kembali data?";
	$config['lconfirm_reset_data'] = "Reset data?";
	$config['err_banksoal_name'] = "Nama bank soal harap diisi!";
	$config['err_exist_banksoal_name'] = "Bank soal sudah ada!";	
	$config['lbank_soal_training'] = "Pra/Exam Banksoal";
	$config['lbanksoal_form_training'] = "Pra/Exam Banksoal Form";	
	$config['err_emtpy_banksoal_file'] = "Harap pilih file bank soal!";
	$config['err_invalid_banksoal_file'] = "File bank soal ,tidak valid!";
	$config['lno'] = "No";
	$config['lquestion'] = "Question";
	$config['lanswer'] = "Jawaban";
	$config['ok_save_banksoal'] = "Bank soal has saved";	
	$config['ok_update_banksoal'] = "Bank soal has updated";	
	$config['ledit_soal'] = "Edit Soal";
	$config['lquestion'] = "Pertanyaan";
	$config['lanswer'] = "Jawaban";
	$config['ok_save_banksoal'] = "Bank soal telah berhasil disimpan";
	$config['lerr_empty_question'] = "Please type your question!";
	$config['lerr_empty_answer'] = "Please type your answer!";	
	$config['ok_update_soal'] = "Soal has been updated!";	
	$config['ok_add_soal'] = "Soal has been added!";	
	$config['lsoal_not_exist'] = "No soal tidak ada!";	
	$config['lerr_empty_chooice'] = "Please type your chooice!";	
	$config['lpraexam_lexam'] = "Praexam / Exam";
	$config['lpraexam'] = "Praexam";
	$config['lexam'] = "Exam";
	$config['ok_update_banksoal'] = "Bank soal has been updated";	
	$config['err_emtpy_banksoal_praexam'] = "Please select bank soal for pra exam!";
	$config['err_emtpy_banksoal_exam'] = "Please select bank soal for exam!";	
	$config['err_emtpy_banksoal'] = "Please select bank soal!";	
	$config['lcertificate'] = "Certificate";
	$config['llist'] = "List";
	$config['ltraining_max'] = "Maximum Diambil";	
	$config['linvalid_training_max'] = "Invalid Maximum Diambil";	
	$config['ltraining'] = "Training";
	$config['err_invalid_pramax'] = "Invalid max praexam";	
	$config['err_invalid_max'] = "Invalid Max exam";	
	$config['ltraining_pass'] = "Minimal Nilai Lulus";
	$config['err_invalid_prapass'] = "Invalid Nilai kelulusan";	
	$config['certificate_name'] = "Nama Sertifikat";
	$config['lcreate_certificate'] = "Buat Sertifikat";	
	$config['lupdate_setting'] = "Update Setting";
	$config['lduration'] = "Durasi";
	$config['lhour'] = "hour";
	$config['lminute'] = "minute";
	$config['lduration_per_soal'] = "Durasi per soal";
	$config['lsecond'] = "second";	
	$config['ok_update_setting'] = "Setting has been updated!";		
	$config['linvalid_duration'] = "Durasi salah";
	$config['lerr_empty_duration'] = "Please type duration!";
	$config['lerr_empty_durationperquest'] = "Please type duration per question!";	
	$config['lerr_invalid_durationperquest'] = "Invalid duration per question!";
	$config['lerr_empty_minpass'] = "Please type minimal pass value!";	
	$config['lerr_invalid_minpass'] = "Invalid minimal pass value!";
	$config['err_not_exist_banksoal'] = "Bank soal tidak ada!";
	$config['llearning_admin'] = "Learning Admin";
	$config['llearning_admin_certification'] = "Learning Admin & Certification";
	$config['lsettings'] = "Pengaturan";
	$config['luser_admin'] = "User Admin";	
	$config['luser_rights'] = "User Rights";
	$config['lright_list'] = "Group User";
	$config['lheader_list_right'] = "Berikut adalah nama user group yang tersedia dalam Learning Management System ".$company." ini:";
	$config['lright_name'] = "Group Name";	
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
	$config['employee_type'] = 'Tipe Karyawan';
	$config['ljumlah_soal'] = "Jumlah soal";
	$config['lerr_empty_jmsoal'] = "Please type jumlah soal!";	
	$config['lerr_invalid_jmsoal'] = "Invalid jumlah soal!";	
	$config['lerr_empty_certificate'] = "Please type certificate name!";
	$config['err_not_exist_certificate_name'] = "Certificate name is not exist!";
	$config['lbanksoal_form_certificate'] = "Certificate Banksoal Form";	

	$config['lunit_soal'] = "Unit Soal";
	$config['lunit_soal_name'] = "Unit Soal Name";
	$config['ladd_unitsoal'] = "Add Unit Soal";
	$config['lerr_empty_unitsoal'] = "Please type unit soal name!";
	$config['lerr_exist_unitsoal'] = "Unit soal name is already exist!";
	$config['lerr_empty_file_unitsoal'] = "Please choose unit soal file!";	
	$config['lerr_invalid_file_unitsoal'] = "Invalid unit soal file!";
	$config['lerr_invalid_file_unitsoal_jabatan'] = "Nama jabatan ( %s ) dalam unit soal file belum dibuat!";	
	
	$config['lunit_soal_question'] = "Pertanyaan Unit Soal";
	$config['lpacket'] = "Paket";
	$config['lsoal'] = "Soal";
	$config['lkey_answer'] = "Kunci Jawaban";
	$config['lchoose_answer'] = "Pilihan Jawaban";
	$config['lempty_chooice'] = "Pilihan tidak boleh kosong";
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
	$config['lgeneralsetting'] = "Pengaturan Umum";
	$config['linactive_period'] = "Inactive Period";
	$config['lsetting_expiredpassword'] = "Masa kadaluarsa password";
	$config['lsetting_errorlogin'] = "Maximum error login";
	$config['err_invalid_inactiveperiod'] = "Invalid inactive period!";
	$config['err_invalid_expiredpassword'] = "Invalid exipred password!";
	$config['err_invalid_errorlogin'] = "Invalid error login times!";
	$config['ok_save_general_setting'] = "General setting has been updated!";
	
	$config['lmateri'] = "Materi";
	$config['linactive_period_description'] = "Batas waktu user tidak melakukan login ke system (hari) ";
	$config['lexpired_password_description'] = "Batas waktu kadaluarsa password (hari)";
	$config['lerror_login_description']	= "Maksimum percobaan login error";
	$config['lerrprequisite_message'] = "Ada prequisite yang belum diambil";
	$config['lprerequisite_info'] = "T = Training  , C=Certification  , Ca = Classroom ";
	$config['lsudah'] = "Sudah";
	$config['lbelum'] = "Belum";

	$config['err_invalid_prajmlsoal'] = "Invalid jumlah soal for praexam";
	$config['err_empty_prajmlsoal'] = "Please type jumlah soal for praexam";

	$config['err_invalid_jmlsoal'] = "Invalid jumlah soal for exam";
	$config['err_empty_jmlsoal'] = "Please type jumlah soal for exam";
	
	$config['err_max_prajmlsoal'] 	= "Maksimum jumlah soal for pra exam adalah %d";
	$config['err_max_jmlsoal'] 		= "Maksimum jumlah soal for exam adalah %d";
	$config['lconcurent_user'] 		= "Concurrent User";
	$config['lconcurent_user_description'] 	= "Maximum user yang login";	
	$config['err_invalid_concurrentuser'] 	= "Invalid concurren user!";	
	
	$config['lrecordperpage'] = "Jumlah Data per halaman";	
	$config['lrecordperpage_description'] = "Total data per halaman";		
	$config['err_invalid_recordperpage'] = "Total data per halaman invalid";	
	
	$config['lmax_err_login'] 		= "Anda telah mencapai maksimum error login. Please contact your administrator!";
	$config['lexpired_password'] 	= "Your password expired. Please change your password!";
	$config['lmax_user_login'] 		= "Too many user login. Please contact your administrator!";
	
	$config['lsession_idle_time'] 				= "Session idle time";
	$config['lsession_idle_time_description'] 	= "Session timeout (seconds)";
	$config['lerr_session_idle_time'] 			= "Invalid session idle time";
	
	$config['llevel'] 				= "Level";	
	$config['lheader_list_level']	= "Berikut adalah hirarki yang tersedia dalam ".$company." Learning Management System:";
	$config['llevel_name'] 			= "Nama Level";	
	$config['llevel_description'] 	= "Deskripsi";	
	$config['lok_save_level'] 		= "Level telah berhasil di simpan";		
	$config['lok_save_levelgroup'] 		= "Level group telah berhasil di simpan";
	$config['err_level_name'] 		= "Nama level harap diisi";		
	$config['err_exist_level_name'] = "Level sudah ada";	

    $config['lerror_permission']	= "Anda tidak memiliki hak akses ke halaman ini, harap kontak administrator!";	
	
	$config['err_please_type'] 	= "%s harap diisi";	
	$config['invalid_name'] 	= "Nama %s invalid";	
	$config['already_exist'] 	= "%s sudah ada";

	$config['ldelete']		= "Hapus";
	$config['lerr_empty_levelgroup'] = "Please choose group!";
	$config['lall_npk'] = "All ".$lnpk;
	$config['err_empty_participant'] = "Participant is empty";
	$config['ldelete']					= "Hapus";
	$config['lerr_empty_levelgroup'] 	= "Grup harap dipilih!";
	$config['lhierarchy']				= "Hirarki";
	$config['lorganisational_structure']= "Struktur Organisasi";
	$config['lhierarchy_modify']	= "Ubah Hierarchy";
	$config['lhierarchy_add']		= "Tambah Hierarchy";
	$config['lname']				= "Nama";
	
	$config['lmodify_level'] 	= "Ubah %s";
	$config['ladd_level']		= "Tambah %s";
	$config['ljabatan']			= "Jabatan";
	$config['lerr_choose_npk'] = "Please choose ".$lnpk."!";
	$config['lcost']			= "Biaya";
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
	
	$config['lok_jabatan_saved'] = "Jabatan telah disimpan";
	$config['lchange_code'] = "Mengganti kode bisa mempengaruhi proses export-import antara LMS dan sistem lainnya. \r\n Apakah Anda yakin ingin mengganti kode ?";
	//$config['lchange_code_confirm'] = "Apakah Anda yakin ingin mengganti kode ?";
	
	$config['ldefaultlanguange'] = "Default language";
	$config['ldefaultlanguange_description'] = "Default language";	
	$config['lndonesia'] = "Indonesia";
	$config['lenglish'] = "English";
	$config['llearning_trainee'] = "Profil Pembelajaran";
	
	$config['lperiod'] = "Period";
	$config['luntil'] = "s.d";
	
	$config['needpraexam'] = "Sebelum melakukan exam atau membaca materi harus mengambil praexam terlebih dahulu.";
	
	$config['lmypersonal_report'] = "My Personal Report";
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
	
	$config['lerr_jml_soal'] = "Total setting jumlah soal salah!";
	$config['lrightanswered'] = "Jawaban benar";	
	$config['lwronganswered'] = "Jawaban salah";
	$config['llength'] = "Length";	
	
	$config['needpracertificate'] = "Sebelum melakukan ujian sertifikasi, Anda harus menyelesaikan prerequisite dari sertifikasi ini.";
	$config['ltaken']		= "Pernah diambil";	
	
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
	
	$config['ladmin'] 	= "Administrator";
	$config['lunlimit']	= "Jika 0, maka tidak ada batas";
	$config['lall_period'] = "All Period";	
	$config['lnot_enough_soal'] = "Jumlah soal tidak mencukupi. Silahkan hubungi administrator";
	$config['lfileresource_not_found'] = "Can't found resource. Please contact your administrator";	
	
	$config['lshown'] = "Shown";
	$config['lright_answered'] = "Right Answered";
	$config['lwrong_answered'] = "Wrong Answered";
	$config['lexam_rule'] = "Rule";
	$config['lcourse_taken']	= "Anda telah mengikuti kursus ini sebanyak <b>%d</b> kali";
	$config['lcourse_taken']	= "Anda telah mengikuti kursus ini sebanyak <b>%d</b> kali"; 
	$config['lcertification_prepared'] = "Sertifikasi ini disusun oleh : ";
	$config['lstart'] 			= "Mulai";
	$config['lcertificate_sign'] = "Certificate sign";
	$config['lcertificate_sign_description'] = "Certificate sign";	
	$config['ltrainee_menu']	= "Trainee Menu";      
    $config['ladmin_menu']		= "Menu Admin";
    
	$config['lsmtp_host']		= "SMTP Host";
	$config['lsmtp_host_description']		= "SMTP Host";

	$config['lsmtp_user']		= "SMTP User";
	$config['lsmtp_user_description']		= "SMTP User";
	
	$config['lsmtp_password']		= "SMTP Password";
	$config['lsmtp_password_description']		= "SMTP Password";
	$config['lcertification_code']	= "Kode Sertifikasi";
	$config['llokasi_fisik']	= "Lokasi Fisik";
	$config['llokasi']	= "Lokasi";
	$config['llokasi_list']	= "Daftar Lokasi Fisik";
	$config['lheader_list_lokasi'] = "Berikut adalah daftar lokasi fisik yang tersedia dalam Learning Management System ".$company." ini:";
	$config['ladd_lokasi_list']	= "Tambah Lokasi Fisik";
	$config['lupdate_lokasi_list']	= "Edit Lokasi Fisik";
	$config['lok_save_lokasi']	= "Lokasi Fisik telah disimpan";
	$config['lerr_exist_lokasi']	= "Lokasi Fisik telah ada";	
	$config['lreset']	= "Reset";	
	$config['lnoanswer']	= "No answer";
	$config['lsearch_by']	= "Cari berdasarkan";
	$config['lsearch']	= "Cari";
	$config['limport_npk']	= "Import ".$lnpk;
	$config['lempty_filenpk']	= "Choose ".$lnpk." file";
	$config['lempty_npk']	= "Tidak ada data ".$lnpk;
	$config['limportnpk_save']	= "Import ".$lnpk." berhasil.<br />Total data: %d<br />Total ".$lnpk.": %d";
	$config['lexport']	= "Ekspor";
	$config['limport']	= "Impor";
	$config['limport_user']	= "User Import";
	$config['limport_user_new_sap']	= "User Import (new system)";
	$config['luser_file']	= "User File (xls)";
	$config['limport_user_old_system']	= "User Import (old system)";
	$config['lempty_user_file']	= "Please choose user file (xls)";
	$config['lempty_user_file1']	= "Please choose user file (xls / csv)";
	$config['lempty_user_file_data']	= "Data is empty";
	$config['linvalid_user_file_tgl_masuk']	= "Invalid user file (tidak ada field TGL MASUK)";	
	$config['lempty_user_file_data1']	= "Invalid user file (tidak ada field level group)";		
	$config['limportuser_ok']	= "Import user telah berhasil";
	$config['lreset_errorlogin'] = "Reset error login";
	$config['lexport_history'] = "Export History";
	$config['limport_category_topic'] = "Import Category / Topic";
	$config['lcategory_topic_file'] = "Category / Topic File";	
	$config['ltraining_file'] = "Training File";	
	$config['lempty_category_topic_file'] = "Please choose category/topic file (xls)";
	$config['lempty_category_topic_file_data'] = "Data is empty";
	$config['limportcategory_topic_ok'] = "Import category/topic berhasil";	
	
	$config['limport_training'] = "Import Training";
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

	$config['limport_jabatan'] = "Import jabatan";
	$config['ljabatan_file'] = "Jabatan File";
	$config['lempty_jabatan_file'] = "Please choose jabatan file (xls)";
	$config['lempty_jabatan_file_data'] = "Data is empty";
	$config['limportjabatan_ok'] = "Import jabatan berhasil";    
	$config['lall_user'] = "All user";    
	$config['lconfirm_reset_all_npk'] = "Are you sure to reset all ".$lnpk." for this training/certificate?";
	$config['lconfirm_reset_periode'] = "Are you sure to reset all ".$lnpk." for this periode?";
	$config['lreset_npk_per_jabatan'] = "Are you sure to reset all ".$lnpk." for this title?";
	$config['lreset_per_npk'] = "Are you sure to reset all ID for this ".$lnpk."?";
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
	$config['lnpk_classroom_not_exist'] = $lnpk." %s belum ada.";
	$config['lnpk_classroom_empty_level_group'] = "Invalid data. Level group is empty";	
	$config['lclassroom_code'] = "Kode Kelas";
	$config['lclassroom_name'] = "Nama Pelatihan";
	$config['lopen_offline_material'] = "Untuk memulai pelatihan ini, harap masukkan flashdisk anda dan buka index.html di folder %s di browser anda";
	$config['lclassroom_name'] = "Classroom Name";
	$config['lvendor_name'] = "Vendor Name";
	$config['lbatch'] = "Batch";
	$config['linvalid_batch'] = "Invalid batch";
	$config['ltraining_materi_notfound'] = "Training material not found. Please contact your administrator";
	$config['lselect_training'] = "Training List";
	$config['lmaterial_file'] = "Material File (zip)";	
	$config['lmaterial_import'] = "Import Material";
	$config['limpor_material_ok'] = "Import Material successfully";	
	$config['lsave'] = "Simpan";	
	$config['lempty_choose_jabatan'] = "Please choose a jabatan!";
	$config['lempty_choose_group'] = "Please choose a group!";
	$config['lper_month'] = "per month";
	$config['ldays'] = "day(s)";
	$config['lday_interval'] = "Day interval";
	$config['lday_interval_description'] = "Interval day untuk notice";
	$config['err_invalid_day_interval'] = "Invalid interval day";	
	$config['lremindermailsubject'] = "Reminder Subject";
	$config['lremindermailsubjectdescription'] = "Reminder Subject";
	$config['lremindermailsender'] = "Reminder email sender";
	$config['lremindermailsenderdescription'] = "Reminder email sender";
	$config['lremindermailsendername'] = "Reminder sender name";
	$config['lremindermailsendernamedescription'] = "Reminder sender name";		
	$config['ltraining_type'] = "Tipe Pelatihan";	
	$config['ltotal'] = "Total";	
	$config['lclassroom_update'] = "Update Classroom Training";
	
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
	
	$config['laverage_learner_days'] = "Average Learner Days/Staff";
	$config['lcanceled_'] = "Canceled partisiant compare to invitee (classroom)";
	$config['lbudget_realization'] = "Budget Realization";
	$config['lcent_mandatory_programmer'] = "Completion % of mandatory program";
	$config['laverage_program_attend'] = "Average Number of program attended per employee";
	$config['lratio_number'] = "Ratio number of program per learner ";
	$config['ljumlah_trainee'] = "Jumlah Trainers";
	$config['ltraining_delivered'] = "Training Delivered";
	$config['laverage_training_mandays'] = "Average Training Mandays / Trainer";
	
	$config['lreport'] = "Laporan";
	$config['lrefreshment'] = "Refreshment";
	$config['lmonth'] = "month";
	$config['err_invalid_refreshment'] = "Invalid refreshment value!";
	
	$config['ldate'] = "Date";
	$config['lcertificate_no'] = "Certificate No";	
	$config['ltopic_code'] = "Topic Code";
	$config['lallcategory'] = "All Category";
	$config['lalltopic'] = "All Topic";	
	
	$config['linvalid_period'] = "Invalid period!";
	$config['lexport'] = "Ekspor";
	$config['lresources_history'] = "History Resources";
	$config['laverage_learners'] = "Average Learner Days/Staff";
	$config['lcancelled_participant'] = "Canceled partisiant compare to invitee (classroom)";
	$config['ldelegetion'] = "Delegation";
	
	$config['lplease_select_user'] = "Please select user!";
	$config['ltraining_intro']		= "Training Intro";	
	$config['lnotice_per']		= "Notice periodic";
	$config['lnotice_per_description']		= "Notice periodic in days";
	$config['lerr_invalid_notice_per']		= "Invalid notice periodic";	
	
	$config['lcopy_paste']	= "Harap Copy dan Paste address di bawah ini ke browser anda ";
	
	$config['lmateri_offline_message']	 = "* Training ini di lakukan offline dengan menggunakan usb.<Br>";
	$config['lmateri_offline_message']	.= "* Harap tancapkan usb material training ke komputer anda.<BR>";
	$config['lmateri_offline_message']	.= "* Setelah itu , harap pilih di 'Drive' mana usb tersebut<BR><BR>";
	
	$config['ltopic']	= "Topik";		
	$config['lreport_type']	= "Tipe Pelaporan";	
	$config['lgeneral_report_download_link']	= "You can download report on <a href='%s'>%s</a>";
	
	$config['lreminder'] = "Reminder";
	$config['lreminder_shedule_setting'] = "Reminder New Joiner Setting";
	$config['lrefreshment_shedule_setting'] = "Refreshment Participant";
	$config['lnpk'] = $lnpk;
	$config['lcourse'] = "Course";
	$config['lclassroom'] = "Classroom";
	$config['lheader_classroom_list']= "Berikut adalah classroom yang ada dalam Learning Management System ".$company." ini:";
	$config['lclassroom_list'] = "Classroom List";	
	$config['ltype'] = "Type";
	$config['limport_reminder'] = "Import Participant For Reminder New Joiner";
	$config['limport_refreshment'] = "ID Import For Refreshment";
	$config['lcourse_type'] = "Course Type";	
	$config['lempty_file'] = "File is empty";
	$config['lselect_corse'] = "Please select a corse!";
	$config['lempty_reminder_schedule_long'] = "Please type a schedule reminder in days!";	
	$config['lreminder_schedule'] = "Reminder schedule (in days)";
	$config['lnever'] = "Never";
	$config['lonce'] = "Semua History";	
	$config['lndays'] = "N days";		
	$config['lempty_reminder_schedule_condition'] = "Please type n day history!";
	$config['linvalid_reminder_schedule_long'] = "Invalid schedule reminder in days!";
	$config['linvalid_reminder_schedule_condition'] = "Invalid n day history!";	
	$config['limport_reminder_successfully'] = "Import reminder is successfully!";		
	$config['limport_refreshment_successfully'] = "Import refreshment is successfully!";
	$config['l_confirm_import_reminder'] = "Last imported will be disable. Are you sure to import new reminder schedule?";	
	$config['l_confirm_import_refreshment'] = "Last imported will be disable. Are you sure to import new refreshment participant?";	
	$config['lreminder_info'] = "Reminder Info";		
	$config['lupdate_reminder_successfully'] = "Update reminder info is successfully";		
	$config['lremove_reminder_successfully'] = "Remove reminder info is successfully";		
	$config['lreminder_shedule_history'] = "Reminder New Joiner History";
	$config['lrefreshment_shedule_history'] = "Refreshment History";
	$config['lmail_sent'] = "Mail Sent";
	$config['lmail_failed'] = "Mail Failed";
	$config['lsmtp_port'] = "SMTP Port";
	$config['lmail_type'] = "Mail Server";
	$config['lmail_setting'] = "Mail Setting";
	$config['lmail_contenttype'] = "Mail Content Type";	
	$config['lerr_smtp_port'] = "Invalid SMTP Port";
	$config['lrefreshment_info'] = "Refreshment Status";
	$config['lupdate_refreshment_successfully'] = "Update refreshment successfully";
	$config['lildp_admin'] = "ILDP Admin";
	$config['lgrade'] = "Grade";
	$config['lprovider'] = "Penyelenggara Training";	
	$config['lmethod'] = "Metode Pembelajaran";
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
	$config['lheader_ildp_catalog_list']= "Berikut adalah catalog ILDP yang ada dalam Learning Management System ".$company." ini:";
	$config['lheader_ildp_method_list']= "Berikut adalah metode pembelajaran yang ada dalam ".$company." On-line Learning System:";
	$config['lcatalog'] = "Katalog";
	$config['lildp_catalog'] = "Katalog ILDP";	
	$config['ladd_ildp_catalog'] = "Menambah Katalog ILDP";
	$config['ledit_ildp_catalog'] = "Ubah Katalog ILDP";
	
	$config['lregistration_period'] = "Periode Pendaftaran";
	$config['lmonths'] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$config['lsuccess_update_setting'] = "Update setting is successfully";
	$config['lcart_already_exist'] = "Training already exist in your ILDP Form";
	$config['ladd_cart_successfully'] = "Training added successfully";
	$config['lildp_form'] = "Form ILDP";
	$config['lpart1_cart'] = "PART 1 - EMPLOYEE INFORMATION";
	$config['lemployee'] = "Employee";
	$config['ljob_title'] = "Jabatan";
	$config['lempty_catalog_duration'] = "Please type training duration";
	$config['lempty_empty_grade'] = "Please type training grade";
	$config['lexternal_catalog_title'] = "External Catalog Title";
	$config['lexternal_catalog_tag'] = "External Catalog Tag";
	$config['lexternal_catalog_objective'] = "External Catalog Objective";
	$config['lmax_ambil_info'] = "Jika kosong atau 0(nol) maka tidak terbatas";
	$config['lhrrm_setting'] = "Pengaturan HR RM";
	$config['lhrld_setting'] = "HR L&D Setting";
	$config['lheader_lhrrm_setting_list']= "Berikut adalah HR RM setting yang ada dalam ".$company." On-line Learning System:";
	$config['lheader_lhrld_setting_list']= "Berikut adalah HR L&D setting yang ada dalam ".$company." On-line Learning System:";	
	$config['lhrld_setting_already_exist'] = "HR L&D setting is already exist";	
	$config['lhrld_setting_added'] = "HR L&D setting has beeen added";
	
	$config['lhrrm_setting_already_exist'] = "HR RM setting is already exist";
	$config['lhrrm_setting_added'] = "HR RM setting has beeen added";
	$config['lhrrm_setting_added'] = "HR RM setting has beeen added";
	
	$config['lheader_lhrld_setting_list']= "Berikut adalah HR L&D setting yang ada dalam Learning Management System ".$company." ini:";
	$config['lildp_period'] = "Periode ILDP";
	$config['ltopic_not_found'] = "Topic is not found on row %d!";
	$config['lildp_import_success'] = "Import has successfully (%d)";
	$config['lcart'] = "Cart";
	$config['llevel_report'] = "Approval Level By Grade";	
	$config['ltraining_type'] = "Tipe Pelatihan";
	$config['ltraining_type_empty'] = "Please type training type";
	$config['ltraining_type_alreadyexist'] = "Training type already exist!";
	$config['lsuccess_update_ildp_catalog'] = "ILDP Catalog has been updated!";
	$config['lsuccess_create_ildp_catalog'] = "ILDP Catalog has been added!";
	
	$config['ltraining_type_a'] = "A : Training Wajib dari Bank";
	$config['ltraining_type_b'] = "B : Program Wajib yang disyaratkan oleh Regulator sesuai jabatan karyawan (jika ada) ";
	$config['ltraining_type_c'] = "C : Program Teknikal (sesuai kebutuhan karyawan)";
	$config['ltraining_type_d'] = "D : Program Leardership (sesuai kebutuhan karyawan)";
	$config['lactions'] = "Actions";
	$config['ldelete_from_ildp'] = "Delete Selected from ILDP Form";
	$config['lexternal_training'] = "Add External Training";
	$config['lempty_cart_selected'] = "Please select training(s)!";
	$config['ldelete_cart_success'] = "Delete training successful!";
	$config['lempty_cart'] = "ILDP Form is empty";
$config['lcheckout_success'] = "ILDP Form is successfully submitted";
		$config['lsubmit_ildp_form_message'] = "Form ILDP anda telah di submit";
	$config['lobjective'] = "Tujuan Pembelajaran";
	$config['ltag'] = "Tag";
	$config['lildp_form'] 	= "Form ILDP";
	
	$config['ltag_info'] = "Multiple tag, separated by ';' , contoh : tag1;tag2;tag3";
	$config['ladd_to_ildp_form'] = "Tambah ke Form ILDP";
	
	$config['lempty_external_catalog_title'] = "Please type external catalog title!";
	$config['lempty_external_catalog_tag'] = "Please type external xatalog tag!";
	$config['lildp_approval'] = "Persetujuan ILDP";
	$config['lapproval'] = "Approval";
	$config['lapprovalhist_list'] = "Daftar Persetujuan";
	$config['lreporter'] = "Reporter";
	$config['lmy_form'] = "Form Saya";	
	$config['lapproval_list'] = "Approval List";
	$config['lheader_approval_list'] = "Berikut adalah Form ILDP yang menunggu persetujuan Anda";
	$config['lheader_approvalhist_list'] = "Berikut adalah daftar ILDP Form yang telah Anda setujui";	
	$config['lsubmitdate'] = "Tanggal Pengiriman";
	$config['lapproval_form'] = "Approval Form";
	$config['lorder_approved'] = "ILDP Form approved!";
	$config['lmy_ildp_form'] = "ILDP Form Saya";
	
	$config['lheader_my_ildp_form']= "Berikut adalah ILDP Form dalam ".$company." On-line Learning System:";
	
	$config['lthen'] = "Maka";
	$config['llevel_approval'] = "Level Persetujuan";
	$config['lphone'] = "Phone";
	$config['lmobile'] = "Mobile";
	$config['lsave_draft'] = "ILDP Form saved";
	
	$config['lildp_subtitle'] = "Individual Learning &amp; Development Plan Form (ILDP Form)";
	$config['$lpart2_cart'] = "PART 2 - DAFTAR TRAINING";
	$config['$lpart3_cart'] = "DATA EKSTERNAL";
	
	$config['lreport_to'] = "Report To";
	$config['lapproved_by'] = "Disetujui oleh:";
	$config['lorder_rejected'] = "ILDP Form rejected!";
	$config['lstart_approval'] = "Mulai Proses Persetujuan";
	$config['lsave_form'] = "Simpan Form";
	$config['lrejected_by'] = "Ditolak oleh %s ( %s )";
	$config['lpending_approval'] = "Menunggu Persetujuan";
	$config['ldraft'] = "Draft";
	$config['lsubmitted_ildp_form'] = "ILDP Form yang telah dikirim";
	$config['llast_edited'] = "Terakhir diakses pada";
	$config['lsubmitted'] = "Submitted";
	$config['ltrail'] = "ILDP Form Trail";
	$config['lactivity'] = "Activity";	
	$config['startapprovalprocess_by'] = "Submmited by";
	$config['approved_by'] = "Approved by";
	$config['rejected_by'] = "Rejected by";
	$config['savetodraft_by'] = "Drafted by";
	$config['lreject_reason'] = "Alasan Penolakan";
	$config['lapprove_desc'] = "Catatan Persetujuan";
	$config['lempty_reason'] = "Please type a reason!";
	$config['lrejected'] = "Rejected";
	$config['lreject'] = "Tolak";
	$config['lcatalog_rejected'] = "Catalog has been rejected";
	$config['lrejected_date'] = "Rejected date";
	$config['ltba'] = "TBA";
	$config['lchange_this'] = "change this";
	$config['lildp_delegetion'] = "ILDP Delegetion";
	$config['lildp_add_delegetion'] = "ILDP Add Delegetion";
	$config['lildpdelegetion_added'] = "Delegator has been added";
	$config['lildpdelegetion_already_exist'] = "Delegator is already exist";
	
	$config['lsubject_approved_complete'] = "[ILDP] ILDP Form %s telah disetujui";
	$config['lsubject_approved_complete_for_hrrm'] = "[ILDP] ILDP Form is approved";
	$config['lsubject_rejected'] = "[ILDP] ILDP Form ditolak";
	$config['lsubject_approved'] = "[ILDP] ILDP Form disetujui";	
	$config['lsubject_submitted'] = "[ILDP] %s telah menyerahkan ILDP Form";	
	$config['lsubject_for_approval'] = "[ILDP] %s memerlukan persetujuan anda";	
	
	$config['lreminder_new_joiner'] = "Reminder New Joiner";
	$config['lreminder_refreshment'] = "Reminder Refreshment";
	$config['lcheck_all'] = "Pilih Semua";
	$config['lilpd_catalog_import'] = "Impor Katalog ILDP";
	$config['lconfirm_ildp_checkout'] = "Apakah anda yakin ingin men-submit ILDP Form ini ?";
	$config['lconfirm_ildp_approve'] = "Approve ILDP Form?";
	$config['lconfirm_ildp_reject'] = "Reject ILDP Form?";
	$config['lconfirm_ildp_content_reject'] = "Apakah anda yakin ingin menolak ILDP Catalog ini ?";
	$config['lsubject_rejectedcatalog'] = "[ILDP] ILDP Catalog is rejected ";	
	$config['lheader_ildpform_list']= "Berikut adalah ILDP Form yang ada dalam Learning Management System ".$company." ini:";
	$config['lconfirm_ildp_reset'] = "Apakah anda yakin ingin mereset ILDP Form ini ?";
	$config['lildp_resetform_successfully'] = "ILDP Form telah direset";
	$config['lildp_form_reset_empty'] = "Please select a user!";
	$config['reset_by'] = "Reset by ";
	$config['lreset_by'] = "Reset by %s ";
	$config['lconfirm_ildp_draft'] = "Apakah anda yakin ingin menyimpan ILDP Form ini ?";
	$config['lcancel'] = "Batal";
	$config['lreject'] = "Tolak";
	$config['lapproval_history'] = "Riwayat Persetujuan";
	$config['lapprove_hrld'] = "TANGGAL AKHIR PERSETUJUAN HRLD";
	$config['lapproved'] = "Approved";
	$config['lall'] = "All";
	$config['lorder_exdata_rejected'] = "External data ini telah di tolak!";
	$config['lexternaldata_rejected'] = "External data has been rejected";
	$config['lsubject_rejectedextdata'] = "Rejected External Data";
	$config['laddtocart'] = "Tambah ke Form ILDP";
	$config['lcomment'] = "Komentar";
	$config['lrepropose'] = "Ajukan ulang";
	$config['lrepropose_success'] = "Pengajuan ulang berhasil!";
	$config['lextdata_repropose_success'] = "Repropose external data is successfully";	
	$config['lsubject_resetform'] = "[ILDP] Reset ILDP Form";
	$config['leligible_grade']		= "Grade berwenang";

	$config['ltraining_method']		= "Metode pelatihan";
	$config['ladd_ildp_category'] = "Tambah Kategori ILDP";
	$config['ledit_ildp_category'] = "Ubah Kategori ILDP";

	$config['lmax_line'] = "Max line";
	$config['linvalid_max_line'] = "Invalid max line!";
	$config['leligable_grade'] = "Grade berwenang";
	$config['llearning_method'] = "Metode Pembelajaran";

	$config['ledit_learning_method'] = "Ubah Metode Pembelajaran";
	$config['ladd_learning_method'] = "Penambahan Metode Pembelajaran";
	$config['llearning_method_name' ] = "Metode Pembelajaran harap diisi";
	$config['llearning_method_alreadyexist'] = "Metode Pembelajaran sudah ada!";
	$config['lsuccess_update_ildp_method'] = "Metode Pembelajaran telah diubah";
	$config['lsuccess_add_ildp_method'] = "Metode Pembelajaran telah ditambahkan";
	$config['lmax_grade'] = "Max grade";
	$config['lildp_form_title'] = "INDIVIDUAL  LEARNING &  DEVELOPMENT  PLAN  FORM (ILDP FORM)";
	$config['lildp_form_header'] = "Judul Program";
	$config['llearning_method_dev'] = "Metode Pelatihan";
	$config['lbudget'] = "Biaya (Rp.)";
	
	$config['lerr_ildp_period'] = "Bukan dalam periode registrasi ILDP!";
	$config['lerr_invalid_ildp_training_type'] = "Each Program Title can only be requested once";
	$config['linvalid_budget'] = "Budget salah!";
	$config['lildp_registration_period'] = "Periode Pendaftaran";
	$config['lheader_ildp_registration_period']= "Berikut adalah Periode pendaftaran ILDP yang ada dalam ".$company." On-line Learning System:";
	$config['lstart_period'] 			= "Awal Periode";
	$config['lend_period'] 			= "Akhir Periode";
	$config['ladd_ildp_reg_period'] = "Penambahan periode pendaftaran ILDP";
	$config['linvalid_ildp_regperiod'] = "Periode pendaftaran tidak valid!";
	$config['lsuccess_create_ildp_regperiod'] = "Periode Pendaftaran ILDP telah ditambahkan!";
	$config['lnot_regperiod'] = "Not registration period!";
	$config['lempty_learning_method'] = "Please select a learning method";
	$config['limport_confirm']	= "Apakah Anda yakin untuk meng-impor data?";
	
	$config['lapprove'] = "Setuju";
	$config['lwaiting_approve_by'] = "Menunggu persetujuan %s";
	$config['lildp_report'] = "Laporan ILDP";
	$config['lrekap_per_dir'] = "Rekapitulasi berdasarkan Direktorat";
	$config['lrekap_per_group'] = "Rekapitulasi berdasarkan Grup";
	$config['lrekap_per_dept'] = "Rekapitulasi berdasarkan Departemen";
	$config['lrekap_per_unit'] = "Rekapitulasi berdasarkan Unit";
	$config['lrekap'] = "Rekapitulasi";
	$config['lby_dir'] = "berdasarkan Direktorat";
	$config['lby_group'] = "berdasarkan Grup";
	$config['lby_dept'] = "berdasarkan Departemen";	
	$config['lby_unit'] = "berdasarkan Unit";
	$config['ldetail'] = "Detail";
	$config['lsubmit']	= "Kirim";
	$config['ldone'] = "Done";
	$config['lnot_done'] = "Not Done";
	$config['lempty_select_ildp_form'] = "Please select a ILDP Form";

	$config['lexport_ildp_report_confirm'] = "Apakah Anda yakin untuk mengekspor data?";
	$config['lexport_type'] = "Tipe ekspor";
	$config['lmax_score'] = "Max score";
	$config['llast_score'] = "Last score";
	$config['llast_lulus'] = "Last lulus";
	
	$config['lview_options']	= "Pilihan Tampilan";
	
	$config['lup']	= "Naik";
	$config['ldown'] = "Turun";
	
	$config['lshow']	= "Tampilkan";
	
	
	$config['leligible_grade_for_approval'] = "Grade yang berwenang untuk persetujuan";
	$config['lrealization'] 	= "Realisasi";
	$config['lnew']  = "Baru";
	
	$config['llist']	= "Daftar";
	$config['ledit']	= "Ubah";
	$config['lildp_form_import'] = "ILDP Form Import";
	$config['llast_lulus']	= "Last Lulus";	

//-- btn
	$config['lnpk']	= $lnpk;
	$config['lgrade']	= "Pangkat";
	$config['lmaxchangepassword'] = "Jumlah Unique Password";
	$config['lmaxchangepassworddescription'] = "Password sebelumnya yang pernah digunakan tidak bisa dipergunakan lagi";
	$config['lerr_maxchangepassword']  = "Nilai maksimum ubah password salah!";
	$config['lerr_invalid_hist_password'] = "Password is already use before";
	$config['lshow_materi_history'] = "Show materi history";
	$config['lyes'] = "Yes";
	$config['lmaximumtaken'] = "Maximum taken/day for Training";
	$config['lerr_maxtaken'] = "Invalid Maximum taken/day for Training";
	$config['errmaxtaken'] = "Error: Maximum taken/day for Training";
	$config['lpasschange1st'] = "Password expired when first login";
	
	$config['lstatus_code']		= "Kode Status";
	$config['lstatus_description']	= "Deskripsi Status";
	$config['hierarchy_id']		= "Id Hirarki";
	$config['hierarchy_name']		= "Nama Hirarki";

	$config['linvalid_atasan'] = "id atasan tidak valid";
	$config['lsort_by_npk'] = "Urut berdasar ".$lnpk;
	$config['lsort_by_hierarchy']	= "Urut berdasar nama struktur";
	$config['linvalid_npk']	= $lnpk." Salah";
	