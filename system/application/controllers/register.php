<?php

include_once "base.php"; 
class Register extends Base {
	var $langue;
	var $settings;
	var $sess;

	function Register()
	{
		parent::Base();	
		
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('email');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model('commonmodel');
		$this->load->model('langmodel');

		//--- admin news model -------
		$this->load->model("newsmodel");

		$this->load->database();	
		
		$this->langue = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->langue ? $this->langue : $this->langmodel->getDefaultLang()));
		
		$this->mysmarty->assign("lang", $this->langue);		
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		$this->mysmarty->assign("current_url", $this->uri->segment(2)? current_url() : site_url(array("home", "index")));		
		
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));

			$sess = unserialize($usess);
			
			$this->sess = $sess;			
		}
		else
		{
			$this->mysmarty->assign("website_title", $this->commonmodel->getWebsiteTitle());
			$this->mysmarty->assign("website_logo", $this->commonmodel->getWebsiteLogo());		
			
			/* footer yeart */
			$initYear = 2005;
			$strYear =($initYear == date("Y"))?$initYear:$initYear." - ".date("Y");
			
			$this->mysmarty->assign("strYear",$strYear);	
		}
		
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();
		
		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$this->settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		};
				
		$this->langmodel->init();
		
	}
	
	function index()
	{
		session_start();
		$image;

		$usess = $this->session->userdata('lms_sess');	
		if (!$usess)
		{			
			if(!empty($_POST)) {
				if($this->do_save()) {
					redirect(site_url(array("user", "info")));
					exit();
				}
			} else {
				$_SESSION['count'] = time();
				$this->create_image();
			}

			$arrlevel = array();
			$this->levelmodel->getChilds($arrlevel, 0);
			
			$this->db->order_by("lokasi_kota", "asc");
			$this->db->distinct();
			$this->db->select("lokasi_kota");
			$this->db->flush_cache();
			$q = $this->db->get("lokasi");
			
			$rowcities = $q->result();

			$this->db->order_by("grade_id", "asc");
			$q = $this->db->get("grade");
			
			$rowgrades = $q->result();
					
			$this->mysmarty->assign("grades", $rowgrades);
			$this->mysmarty->assign("cities", $rowcities);
			$this->mysmarty->assign("levels", $arrlevel);		
			$this->mysmarty->assign("nlevels", count($arrlevel));
			$this->mysmarty->assign("usertypes", $usertypes);
			$this->mysmarty->assign("workstatuses", $this->config->item("workstatuses"));
			$this->mysmarty->assign("email", $this->config->item("email"));
			$this->mysmarty->assign("first_name", $this->config->item("first_name"));
			$this->mysmarty->assign("last_name", $this->config->item("last_name"));
			$this->mysmarty->assign("join_date", $this->config->item("join_date"));
			$this->mysmarty->assign("birthdate", $this->config->item("birthdate"));
			$this->mysmarty->assign("description", $this->config->item("description"));	
			$this->mysmarty->assign("location", $this->config->item("location"));
			$this->mysmarty->assign("city", $this->config->item("city"));	
			$this->mysmarty->assign("directorat", $this->config->item("directorat"));
			$this->mysmarty->assign("group", $this->config->item("group"));
			$this->mysmarty->assign("department", $this->config->item("department"));
			$this->mysmarty->assign("unit", $this->config->item("unit"));
			$this->mysmarty->assign("jabatan", $this->config->item("jabatan"));
			$this->mysmarty->assign("function", $this->config->item("function"));
			$this->mysmarty->assign("work_status", $this->config->item("work_status"));
			$this->mysmarty->assign("user_type", $this->config->item("user_type"));
			$this->mysmarty->assign("last_login", $this->config->item("last_login"));
			$this->mysmarty->assign("confirm_password", $this->config->item("confirm_password"));
			$this->mysmarty->assign("password", $this->config->item("password"));
			$this->mysmarty->assign("status", $this->config->item("status"));		
			$this->mysmarty->assign("active", $this->config->item("active"));
			$this->mysmarty->assign("inactive", $this->config->item("inactive"));
			$this->mysmarty->assign("llast_login", $this->config->item("last_login"));
			
			$this->mysmarty->assign("ok_update_user", $this->config->item("ok_update_user"));
			$this->mysmarty->assign("ok_add_user", $this->config->item("ok_add_user"));		
			$this->mysmarty->assign("unit", $this->config->item("unit"));
			$this->mysmarty->assign("jabatan_name", $this->config->item("jabatan_name"));
			$this->mysmarty->assign("department", $this->config->item("department"));		
			$this->mysmarty->assign("status", $this->config->item("status"));
			$this->mysmarty->assign("active", $this->config->item("active"));
			$this->mysmarty->assign("inactive", $this->config->item("inactive"));
			$this->mysmarty->assign("directorat", $this->config->item("directorat"));	
			$this->mysmarty->assign("group", $this->config->item("group"));
			$this->mysmarty->assign("ok_save_jabatan", $edit ? $this->config->item("ok_update_jabatan") : $this->config->item("ok_add_jabatan"));		
			$this->mysmarty->assign("edit", $edit);
			$this->mysmarty->assign("fromlist", true);
			$this->mysmarty->assign("employee_type", $this->config->item("employee_type"));
			$this->mysmarty->assign("ltrainee", $this->config->item("ltrainee"));
			$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
			$this->mysmarty->assign("latasan", $this->config->item("latasan"));
			$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
			$this->mysmarty->assign("hide_famaly_field", $this->config->item("hide_family_field"));
			$this->mysmarty->assign("lname", $this->config->item("luser_name"));

			//$this->mysmarty->assign("img_captca", ('http://localhost/ncclp2/uploads/image'.$_SESSION['count'].'.png'));
			$this->mysmarty->assign("img_captca", ($this->config->item("base_url").'/uploads/image'.$_SESSION['count'].'.png'));
			
			$this->mysmarty->assign("main_content", "register/form.html");
			$this->mysmarty->assign("referrer", $this->session->userdata('referrer') ? $this->session->userdata('referrer') : base_url());

			$this->mysmarty->display("sess_template_register.html");
		} else {
			redirect(site_url(array("user", "info")));
		}
		
		//redirect(site_url(array("user", "info")));
	}

	function do_save($edit=0)
	{
		session_start();

		$usess = $this->session->userdata('lms_sess');					

		$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		$firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : "";
		$lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : "";
		$joindate = isset($_POST['joindate']) ? trim($_POST['joindate']) : "";
		$birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : "";
		$description = isset($_POST['description']) ? trim($_POST['description']) : "";
		$location = isset($_POST['location']) ? trim($_POST['location']) : "";
		$city = isset($_POST['city']) ? trim($_POST['city']) : "";
		$type = isset($_POST['type']) ? trim($_POST['type']) : "";
		$emp = isset($_POST['emp']) ? trim($_POST['emp']) : "";
		$levelgroup = isset($_POST['levelgroup']) ? $_POST['levelgroup'] : "";
		$jabatan = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : "";
		$function = isset($_POST['function']) ? trim($_POST['function']) : "";
		$npk = isset($_POST['npk']) ? trim($_POST['npk']) : "";
		$password = isset($_POST['password']) ? trim($_POST['password']) : "";
		$cpassword = isset($_POST['cpassword']) ? trim($_POST['cpassword']) : "";
		$status = isset($_POST['status']) ? $_POST['status'] : 1;
		$atasan = isset($_POST['atasan']) ? $_POST['atasan'] : "";
		$grade = isset($_POST['grade']) ? $_POST['grade'] : 0;
		$lastlogindate = (isset($_POST['lastlogindate']) && ($_POST['lastlogindate'] <> "") ) ? $_POST['lastlogindate'] : date("d/m/Y");

		$user_telp = isset($_POST['user_telp']) ? trim($_POST['user_telp']) : "";
		$user_fb = isset($_POST['user_fb']) ? trim($_POST['user_fb']) : "";
		$user_twitter = isset($_POST['user_twitter']) ? trim($_POST['user_twitter']) : "";
		$user_instagram = isset($_POST['user_instagram']) ? trim($_POST['user_instagram']) : "";

		$user_captca = isset($_POST['user_captca']) ? trim($_POST['user_captca']) : "";
		
		$errs = array();
		
		$npk = $this->get_npk();

		if (strtolower($user_captca) != strtolower($_SESSION['captcha_string']))
		{
			//$errs[] = $this->config->item("err_empty_email");
			$errs[] = 'Captca is incorrect';
		}
		
		if (strlen($password) == 0)
		{
			$errs[] = $this->config->item("err_empty_pass");
		} elseif ($password != $cpassword)
		{
			$errs[] = $this->config->item("err_invalid_confirmpass");
		}
		else
		{
			$q = $this->db->get("general_setting");
			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				$gensetting[$rows[$i]->general_setting_code] = $rows[$i]->general_setting_value;
			}
			
			if (isset($gensetting['minpasslen']) && $gensetting['minpasslen'])
			{
				if (strlen($password) < $gensetting['minpasslen'])
				{
					$errs[] = sprintf($this->config->item("lerr_invalid_minpasslen1"), $gensetting['minpasslen']);
				}
			}

			if (isset($gensetting['maxpasslen']) && $gensetting['maxpasslen'])
			{
				if (strlen($password) > $gensetting['maxpasslen'])
				{
					$errs[] = sprintf($this->config->item("lerr_invalid_maxpasslen1"), $gensetting['maxpasslen']);
				}
			}
			
			if (isset($gensetting['passchar']) && ($gensetting['passchar'] == "alphanumeric"))
			{
				if (! is_alphanumeric($password))
				{
					$errs[] = $this->config->item("lerr_invalid_pass_alphanumeric");
				}
			}					
		}

		if (strlen($email) == 0)
		{
			$errs[] = $this->config->item("err_empty_email");
		}
		else
		if (! valid_email($email))
		{
			$errs[] = $this->config->item("err_invalid_email");
		}
		else
		{				
			$this->db->flush_cache();
			$this->db->where("user_email", $email);
			$q = $this->db->get("user");
			if ($q->num_rows() > 0)				
			{
				$resemail = $q->row();
				if ($resemail->user_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_email");
				}
			}
		}
		
		if (strlen($firstname) == 0)
		{
			$errs[] = $this->config->item("err_empty_firstname");
		}
		
		/*if (strlen($lastname) == 0)
		{
			$errs[] = $this->config->item("err_empty_lastname");
		}*/
		
		if (strlen($joindate) == 0)
		{
			//$errs[] = $this->config->item("err_empty_joindate");
		}
		else
		{
			$tjoin = formmaketime($joindate." 00:00:00");
			if (date("d/m/Y", $tjoin) != $joindate)
			{
				$errs[] = $this->config->item("err_invalid_joindate");	
			}
		}
		
		if (strlen($birthdate) == 0)
		{
			/* birtdate is not mandatory */
			//$errs[] = $this->config->item("err_empty_birthdate");
		}
		else
		{
			$tbirth = formmaketime($birthdate." 00:00:00");
			if (date("d/m/Y H:i:s", $tbirth) != ($birthdate." 00:00:00"))
			{
				$errs[] = $this->config->item("err_invalid_birthdate");	
			}				
		}
		
		if (strlen($city) == 0)
		{
			$errs[] = $this->config->item("err_empty_city");
		}
		
		if (strlen($location) == 0)
		{
			//$errs[] = $this->config->item("err_empty_location");
		}
		
		// pengecekan level group

		for($i=0; $i < count($levelgroup); $i++)
		{
			if ($levelgroup[$i])
			{
				$levelgroupid = $levelgroup[$i];
			}
		}
		
		if (! isset($levelgroupid))
		{
			//$errs[] = $this->config->item("lerr_empty_levelgroup");
		}
		
		if(strlen($jabatan) == 0){
			//$errs[] = getconfig("err_jabatan_name");
		}

		$tlastlogindate = formmaketime($lastlogindate." 00:00:00");
		if (date("d/m/Y", $tlastlogindate) != $lastlogindate)
		{
			//$errs[] = $this->config->item("err_invalid_lastlogindate");	
		}
		
		if (count($errs) > 0)
		{
			echo count($errs);
			echo "\1";

			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}		
		
		$data['user_email'] = addslashes($email);
		$data['user_emp'] = addslashes($emp);
		$data['user_first_name'] = addslashes($firstname);
		if (! $this->config->item("hide_famaly_field"))
		{
			$data['user_last_name'] = addslashes($lastname);
		}
		$data['user_join_date'] = date("Ymd", $tjoin);
		$data['user_birthdate'] = date("Ymd", $tbirth);
		$data['user_description'] = addslashes($description);
		$data['user_location'] = addslashes($location);
		//$data['user_type'] = addslashes($type);
		$data['user_type'] = 7; //7 = trainee
		$data['user_status'] = addslashes($status);
		$data['user_jabatan'] = $jabatan;
		$data['user_function'] = isset($function) ? $function : 0;
		$data['user_npk_atasan'] = addslashes($atasan);
		$data['user_grade_code'] = addslashes($grade);
		$data['user_lastlogin_date'] = date("Ymd", $tlastlogindate);


		$data['user_telp'] = addslashes($user_telp);
		$data['user_fb'] = addslashes($user_fb);
		$data['user_twitter'] = addslashes($user_twitter);
		$data['user_instagram'] = addslashes($user_instagram);

		$data['user_city'] = addslashes($city);

		if ($edit)
		{
			$this->db->flush_cache();		
			$this->db->where("user_id", $edit);
			$this->db->update("user", $data);
		}
		else
		{
			$data['user_status'] = 1;
			$data['user_npk'] = addslashes($npk);
			$data['user_pass'] = addslashes(substr(md5($password), 0, 100));
			
			$this->db->flush_cache();
			$this->db->insert("user", $data);

			session_start();
			$this->db->where("user_npk", addslashes($npk));
			$this->db->join("right", "right_id = user_type", "left outer");
			$q = $this->db->get("user");
			$row = $q->row_array();

			$this->session->set_userdata('lms_sess', serialize($row));
			$_SESSION['UserIsLoggedIn'] = 'yes';

			echo "\1";
		}
	}

	private function get_npk() {
		$npk = mt_rand(100000,999999);
		$this->db->where("user_npk", $npk);

		$total = $this->db->count_all_results("user");
		if ($total) {
			$this->get_npk();
		} else {
			return $npk;
		}
	}

	function  create_image()
	{
	    global $image;
	    $image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");

	    $background_color = imagecolorallocate($image, 255, 255, 255);
	    $text_color = imagecolorallocate($image, 0, 255, 255);
	    $line_color = imagecolorallocate($image, 64, 64, 64);
	    $pixel_color = imagecolorallocate($image, 0, 0, 255);

	    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

	    /*
	    for ($i = 0; $i < 3; $i++) {
	        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
	    }
	    */

	    for ($i = 0; $i < 1000; $i++) {
	        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
	    }


	    //$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	    $letters = '123456789';
	    $len = strlen($letters);
	    $letter = $letters[rand(0, $len - 1)];

	    $text_color = imagecolorallocate($image, 0, 0, 0);
	    $word = "";
	    for ($i = 0; $i < 6; $i++) {
	        $letter = $letters[rand(0, $len - 1)];
	        imagestring($image, 7, 5 + ($i * 30), 20, $letter, $text_color);
	        $word .= $letter;
	    }
	    $_SESSION['captcha_string'] = $word;

	    $images = glob("*.png");
	    foreach ($images as $image_to_delete) {
	        @unlink($image_to_delete);
	    }

	    //$file_img = $_SERVER['DOCUMENT_ROOT']."/NCCLP2/uploads/image" . $_SESSION['count'] . ".png";
	    $file_img = $this->config->item("base_path")."uploads/image" . $_SESSION['count'] . ".png";
	    imagepng($image, $file_img);

	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
