<?php

include_once "base.php"; 
class User extends Base{
	var $lang;
	var $modules;
	var $sess;

	function User()
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
		$this->load->model("ildpmodel");

		//--- admin news model -------
		$this->load->model("newsmodel");
		
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
			
			$this->sess = $sess;
			$this->modules = $this->commonmodel->getRight($sess['user_type']);
		}		
		$this->langmodel->init();

        $this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu());	
	}
	
	function index(){
		$this->info();
	}
		
	function asadmin()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);		
		
		$sess['asadmin'] = 1;		
		$this->session->set_userdata('lms_sess', serialize($sess));

		redirect(base_url());
	}
	
	function astrainee()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);		
		
		unset($sess['asadmin']);
		$this->session->set_userdata('lms_sess', serialize($sess));

		redirect(base_url());

	}
	
	
	function info()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);

		$this->db->where("user_id", $sess['user_id']);
		$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
		$this->db->join("right", "right_id = user_type", "left outer");
		$this->db->join("function", "function_id = user_function", "left outer");
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$q = $this->db->get("user");
		$row = $q->row_array();
		
		// level
		
		$arr1 = array();		
		$this->levelmodel->getparentlevelgroups($row['jabatan_level_group'], $arr1);		
		$arr1 = array_reverse($arr1);
		
		$arrlevels = array();
		$this->levelmodel->getalllevels(0, $arrlevels);
		
		for($i=0; $i < count($arr1); $i++)
		{
			$arr[$arr1[$i]->level_group_nth] = $arr1[$i];
		}
		
		for($i=0; $i < count($arrlevels); $i++)
		{
			$arrlevels[$i]->group = isset($arr[$arrlevels[$i]->level_nth]) ? $arr[$arrlevels[$i]->level_nth]->level_group_name : "";
		}
		
		$t = dbintmaketime($row['user_join_date'], 0);
		$row['user_join_datetime'] = date("d/m/Y", $t);
		
		$t = dbintmaketime($row['user_birthdate'], 0);
		$row['user_birthdate'] = date("d/m/Y", $t);
		
		$t = dbintmaketime($row['user_lastlogin_date'], $row['user_lastlogin_time']);
		$row['user_lastlogin_datetime'] = date("d/m/Y H:i:s", $t);
		
		if ($row['right_id'])
		{
			$row['user_type_desc'] =  $row['right_name'];
		}
		else
		{
			$row['user_type_desc'] = $this->usermodel->getTypeDesc($row['right_name']);
		}
		$row['user_emp_desc'] = $this->usermodel->getEmployementDesc($row['user_emp']);		
		
		$this->mysmarty->assign("levels", $arrlevels);		
		$this->mysmarty->assign("email", $this->config->item("email"));
		$this->mysmarty->assign("name", $this->config->item("name"));
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
		$this->mysmarty->assign("employee_type", $this->config->item("employee_type"));
		$this->mysmarty->assign("user_type", $this->config->item("user_type"));
		$this->mysmarty->assign("last_login", $this->config->item("last_login"));		
		
		$this->mysmarty->assign("user", $row);
		$this->mysmarty->assign("account_header", $this->config->item("account_header"));		
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "user/account.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function editinfo()
	{
		/* 2010/03/14 user can not edit profile */
		redirect(base_url());
		/* end */

		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);				
		
		$this->db->where("user_id", $sess['user_id']);
		$this->db->join("function", "function_id = user_function", "left outer");
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$q = $this->db->get("user");
		$row = $q->row_array();
		
		$t = dbintmaketime($row['user_join_date'], 0);
		$row['user_join_date_fmt'] = date("d/m/Y", $t);

		$t = dbintmaketime($row['user_birthdate'], 0);
		$row['user_birthdate_fmt'] = date("d/m/Y", $t);
		
		$this->db->order_by("right_name", "asc");
		$q = $this->db->get("right");				
		
		$usertypes = $q->result();
		
		$this->mysmarty->assign("usertypes", $usertypes);		
		
		$this->mysmarty->assign("edit", $sess['user_id']);				
		$this->mysmarty->assign("user", $row);
		$this->mysmarty->assign("ok_update_user", $this->config->item("ok_update_user"));
		$this->mysmarty->assign("ok_add_user", $this->config->item("ok_add_user"));
		
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
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));		
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("ltrainee", $this->config->item("ltrainee"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "user/form.html");
		$this->mysmarty->display("sess_template.html");				
	}

	function deletesession()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$this->db->where("user_data LIKE '%\"user_id\";s:%:\"".$_POST['userid']."\";%'", null);
		$this->db->delete("sessions");
	}
	
	function changepass()
	{

		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
				
		$this->mysmarty->assign("old_password", $this->config->item("old_password"));
		$this->mysmarty->assign("new_password", $this->config->item("new_password"));		
		$this->mysmarty->assign("confirm_new_password", $this->config->item("confirm_new_password"));		
		$this->mysmarty->assign("ok_change_pass", $this->config->item("ok_change_pass"));
			$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "user/changepass.html");
		$this->mysmarty->display("sess_template.html");		
	}

	function doresetpass()
	{
		//unset session referrer
		$this->session->unset_userdata(array('referrer'=>''));

		$errs = array();
			
		$id = $this->uri->segment(3);
		if (! $id)
		{
			$errs[] = "Invalid reset id!";
		}
		else
		{
			$this->db->where("user_forgotpass_confirm", $id);
			$q = $this->db->get("user");
			if ($q->num_rows() == 0)
			{
				$errs[] = "Invalid reset id!";
			}
			else
			{
				$row = $q->row();
			}
		}
		
		$newpass = isset($_POST['newpass']) ? $_POST['newpass'] : "";
		$cnewpass = isset($_POST['cnewpass']) ? $_POST['cnewpass'] : "";
		
		if (strlen($newpass) == 0)
		{
			$errs[] = "Please type a your new password!";
		}
		else
		if ($newpass != $cnewpass)
		{
			$errs[] = "Invalid confirm password!";
		}				
				
		echo count($errs);
		echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}
		
		$this->db->flush_cache();
		
		$data['user_pass'] = substr(md5($newpass), 0, 100);
		$data['user_forgotpass_confirm'] = "";
		$data['user_lastmodifiedpassword'] = date("Ymd");
		
		$this->db->where("user_id", $row->user_id);
		$this->db->update("user", $data);		
	}
	
	function changepass1()
	{

		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$this->sess = unserialize($usess);
		
		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}		
		
		$this->mysmarty->assign("old_password", $this->config->item("old_password"));
		$this->mysmarty->assign("new_password", $this->config->item("new_password"));		
		$this->mysmarty->assign("confirm_new_password", $this->config->item("confirm_new_password"));		
		$this->mysmarty->assign("ok_change_pass", $this->config->item("ok_change_pass"));
		
		$this->mysmarty->assign("admin", 1);
		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "user/changepass.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function save($edit=0)
	{
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
		
		$errs = array();
		if (! $usess)
		{
			$errs[] = $this->config->item("err_exipred_session");
		}
		else
		{	
			$sess = unserialize($usess);	
			if (! $edit)
			{
				if (($sess['user_type'] != 0) && (! $this->modules['user']))
				{
					$errs[] = $this->config->item("err_exipred_session");
				}
			}
			else
			{
				if (($sess['user_type'] != 0) && (! $this->modules['user']))
				{
					if ($sess['user_id'] != $edit)
					{
						$errs[] = $this->config->item("err_exipred_session");
					}
				}
			}

			if (! $edit)
			{
				if (strlen($npk) == 0)
				{
					$errs[] = $this->config->item("err_empty_npk");
				}							
				else
				{
					$this->db->where("user_npk", $npk);
					$total = $this->db->count_all_results("user");
					if ($total)
					{
						$errs[] = $this->config->item("err_already_exist_npk");
					}
				}	
				
				if (strlen($password) == 0)
				{
					$errs[] = $this->config->item("err_empty_pass");
				}
				else
				if ($password != $cpassword)
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
				$errs[] = $this->config->item("err_empty_joindate");
			}
			else
			{
				$tjoin = formmaketime($joindate." 00:00:00");
				if (date("d/m/Y", $tjoin) != $joindate)
				{
					//$errs[] = $this->config->item("err_invalid_joindate");	
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
					//$errs[] = $this->config->item("err_invalid_birthdate");	
				}				
			}
			
			if (strlen($city) == 0)
			{
				$errs[] = $this->config->item("err_empty_city");
			}
			
			if (strlen($location) == 0)
			{
				$errs[] = $this->config->item("err_empty_location");
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
				$errs[] = $this->config->item("lerr_empty_levelgroup");
			}
			
			if(strlen($jabatan) == 0){
				$errs[] = getconfig("err_jabatan_name");
			}

			$tlastlogindate = formmaketime($lastlogindate." 00:00:00");
			if (date("d/m/Y", $tlastlogindate) != $lastlogindate)
			{
				$errs[] = $this->config->item("err_invalid_lastlogindate");	
			}

		}
		
		/* 2012/04/20 atasan is not mandatory */
		/* if (count($errs) == 0)
		{
			$this->db->where("user_npk", $atasan);
			$totalatasan = $this->db->count_all_results("user");
			if ($totalatasan == 0)
			{
				$errs[] = $this->config->item("linvalid_atasan");
			}
		}*/
		
		if ($edit) {
			$this->db->where("user_npk", $npk);
			$this->db->where("user_id !=", $edit);
			$total = $this->db->count_all_results("user");
			if ($total)
			{
				$errs[] = $this->config->item("err_already_exist_npk");
			} else {
				$data['user_npk'] = mysql_escape_string($npk);
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
		$data['user_type'] = addslashes($type);
		$data['user_status'] = addslashes($status);
		$data['user_jabatan'] = $jabatan;
		$data['user_function'] = isset($function) ? $function : 0;
		$data['user_npk_atasan'] = addslashes($atasan);
		$data['user_grade_code'] = addslashes($grade);
		$data['user_lastlogin_date'] = date("Ymd", $tlastlogindate);

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
		}
	}

	function dochangepass()
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		//$_POST['npk'] = !empty($sess['user_npk']) ? $sess['user_npk'] : '';
		$_POST['npk'] = !empty($_POST['npk']) ? $_POST['npk'] : (!empty($sess['user_npk']) ? $sess['user_npk'] : '');

		$oldpass = isset($_POST['oldpass']) ? $_POST['oldpass'] : "";
		$newpass = isset($_POST['newpass']) ? $_POST['newpass'] : "";
		$cnewpass = isset($_POST['cnewpass']) ? $_POST['cnewpass'] : "";
		$isadmin = (isset($_POST['isadmin']) && $_POST['isadmin']) ? 1 : 0;

		$errs = array();
		if (! $usess)
		{
			$errs[] = $this->config->item("err_exipred_session");
		}
		else
		{
			if (isset($_POST['npk']) && (strlen(trim($_POST['npk'])) == 0))
			{
				$errs[] = $this->config->item("err_empty_npk");
			}
			else
			{
				//$sess = unserialize($usess);
				if (isset($_POST['npk']))
				{
					$this->db->where("user_npk",  trim($_POST['npk']));
				}
				else
				{
					$this->db->where("user_id",  $sess['user_id']);
				}

				$q = $this->db->get("user");
				$row = $q->row();

				if ($q->num_rows() == 0)
				{
					if (isset($_POST['npk']))
					{
						$errs[] = $this->config->item("err_not_already_exist_npk");
					}
					else
					{
						$errs[] = $this->config->item("err_exipred_session");
					}
				}
				else
				if ((strlen($oldpass) == 0) && (! $isadmin))
				{
					$errs[] = $this->config->item("err_empty_oldpass");
				}
				else
				{
					$oldpassmd5 = substr(md5($oldpass), 0, 100);
					if (($oldpassmd5 != $row->user_pass) && (! $isadmin))
					{
						$errs[] = $this->config->item("err_invalid_oldpass");
					}
					else
					if (strlen($newpass) == 0)
					{
						$errs[] = $this->config->item("err_empty_newpass");
					}
					else
					if ($newpass != $cnewpass)
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
							if (strlen($newpass) < $gensetting['minpasslen'])
							{
								$errs[] = sprintf($this->config->item("lerr_invalid_minpasslen1"), $gensetting['minpasslen']);
							}
						}

						if (isset($gensetting['maxpasslen']) && $gensetting['maxpasslen'])
						{
							if (strlen($newpass) > $gensetting['maxpasslen'])
							{
								$errs[] = sprintf($this->config->item("lerr_invalid_maxpasslen1"), $gensetting['maxpasslen']);
							}
						}

						if (isset($gensetting['passchar']) && ($gensetting['passchar'] == "alphanumeric"))
						{
							if (! is_alphanumeric($newpass))
							{
								$errs[] = $this->config->item("lerr_invalid_pass_alphanumeric");
							}
						}

						if (count($errs) == 0)
						{
							$this->db->where_in("general_setting_code", "maxchangepassword");
							$q = $this->db->get("general_setting");
							$this->db->flush_cache();

							$maxchangepassword = 0;
							if ($q->num_rows())
							{
								$rowsetting = $q->row();
								$maxchangepassword = $rowsetting->general_setting_value;
							}

							// cek apakah password pertama sudah dimasukkan ke hist

							$this->db->where("pass_hist_user_id", $row->user_id);
							$totalhist = $this->db->count_all_results("password_hist");
							if ($totalhist == 0)
							{
								unset($insert);

								$insert["pass_hist_user_id"] = $row->user_id;
								$insert["pass_hist_user_npk"] = $row->user_npk;
								$insert["pass_hist_user_pass"] = $row->user_pass;
								$insert["pass_hist_created"] = date("Y-m-d H:i:s");

								$this->db->insert("password_hist", $insert);
							}

							if ($maxchangepassword > 0)
							{
								$this->db->limit($maxchangepassword);
								$this->db->order_by("pass_hist_created", "desc");
								$this->db->where("pass_hist_user_id", $row->user_id);
								$q = $this->db->get("password_hist");

								$rowshist = $q->result();

								$newpassmd5 = substr(md5($newpass), 0, 100);
								for($i=0; $i < count($rowshist); $i++)
								{
									if ($rowshist[$i]->pass_hist_user_pass != $newpassmd5) continue;

									$errs[] = $this->config->item("lerr_invalid_hist_password");
									break;
								}
							}
						}
					}
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

		$this->db->flush_cache();

		$data['user_pass'] = substr(md5($newpass), 0, 100);
		$data['user_lastmodifiedpassword'] = date("Ymd");

		$this->db->where("user_id", $row->user_id);
		$this->db->update("user", $data);

		unset($insert);

		$insert["pass_hist_user_id"] = $row->user_id;
		$insert["pass_hist_user_npk"] = $row->user_npk;
		$insert["pass_hist_user_pass"] = $data['user_pass'];
		$insert["pass_hist_created"] = date("Y-m-d H:i:s");

		$this->db->insert("password_hist", $insert);

	}

	function logout()
	{
		$this->db->order_by("general_setting_lastupdated", "desc");
		$this->db->limit(1);
		$this->db->where("general_setting_code", "multiplelogin");
		$q = $this->db->get("general_setting");

		$ismultiplelogin = true;
		if ($q->num_rows() > 0)
		{
			$row = $q->row();

			$ismultiplelogin = $row->general_setting_value != 2;
		}


		$this->session->sess_destroy();
		if ($ismultiplelogin)
		{
			redirect(base_url());
			return;
		}

		$this->db->where("user_data LIKE '%\"user_npk\";s:6:\"".$this->sess["user_npk"]."\"%'");
		$this->db->delete("sessions");

		redirect(base_url());
	}

	function login()
	{
		session_start();

		$this->db->where("general_setting_code", "loginbyemail");
		$res = $this->db->get("general_setting")->row_array();

		if(!empty($res['general_setting_value'])) {
			$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		} else {
			$login = isset($_POST['npk']) ? trim($_POST['npk']) : "";
		}

		$pass = isset($_POST['pass']) ? $_POST['pass'] : "";
		if ($pass)
		{
			$pass = substr(md5($pass), 0, 100);
		}

		$errs = array();

		if(!empty($res['general_setting_value'])) {
			if (strlen($email) == 0)
			{
				$errs[] = $this->config->item("err_empty_email");
			}
		} else {
			if (strlen($login) == 0)
			{
				$errs[] = $this->config->item("err_empty_npk");
			}
		}

		if (strlen($pass) == 0)
		{
			$errs[] = $this->config->item("err_empty_pass");
		}

		if (count($errs) == 0)
		{
			// cek maximum error login

			$this->db->where("general_setting_code", "errorlogin");
			$this->db->where("general_setting_value >", 0);

			$q = $this->db->get("general_setting");
			$this->db->flush_cache();

			if ($q->num_rows() > 0)
			{
				$setting = $q->row();

				if(!empty($res['general_setting_value'])) {
					$this->db->where("user_email", addslashes($email));
				} else {
					$this->db->where("user_npk", addslashes($login));
				}

				$q = $this->db->get("user");
				$this->db->flush_cache();

				if ($q->num_rows() > 0)
				{
					$rowuser = $q->row();

					if ($rowuser->user_loginerror >= $setting->general_setting_value)
					{
						$errs[] = $this->config->item("lmax_err_login");
					}
				}
			}
		}

		if (count($errs) == 0)
		{
			if(!empty($res['general_setting_value'])) {
				$this->db->where("user_email", addslashes($email));
			} else {
				$this->db->where("user_npk", addslashes($login));
			}

			$this->db->where("user_pass", addslashes($pass));
			$this->db->join("right", "right_id = user_type", "left outer");
			$q = $this->db->get("user");

			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				if(!empty($res['general_setting_value'])) {
					$errs[] = $this->config->item("err_invalid_login_new");
				} else {
					$errs[] = $this->config->item("err_invalid_login");
				}

				$this->db->flush_cache();

				unset($data);

				if(!empty($res['general_setting_value'])) {
					$this->db->where("user_email", addslashes($email));
				} else {
					$this->db->where("user_npk", addslashes($login));
				}

				$q = $this->db->get("user");

				if ($q->num_rows() > 0)
				{
					$rowuser = $q->row();
					$data['user_loginerror'] = $rowuser->user_loginerror+1;

					$this->db->where("user_type <>", 0);
					$this->db->where("user_id", $rowuser->user_id);
					$this->db->update("user", $data);
				}
			}
			else
			{
				$row = $q->row_array();

				// cek terakhir login

				if ($row['user_type'] != 0)
				{
					$this->db->where("general_setting_code", "inactiveperiod");
					$this->db->where("general_setting_value >", 0);

					$q = $this->db->get("general_setting");

					if ($q->num_rows())
					{
						$rowinactive = $q->row();
						//$delta = mktime() - dbintmaketime($row['user_lastlogin_date'], $row['user_lastlogin_time']);
						$delta = mktime() - dbintmaketime($row['user_lastlogin_date'], 0);

						if ($delta > ($rowinactive->general_setting_value*24*3600))
						{
							$errs[] = $this->config->item("lerr_inactiveperiod");

							echo count($errs);
							echo "\1";

							if (count($errs) > 0)
							{
								$this->mysmarty->assign("errs", $errs);
								$this->mysmarty->display("errmessage.html");

								return;
							}
						}
					}
				}

				//cek apakah multiple login atau tidak

				$this->db->where("general_setting_code", "multiplelogin");
				$q = $this->db->get("general_setting");

				if ($q->num_rows() == 0)
				{
					$ismultiplelogin = true;
				}
				else
				{
					$rowmultiplelogin = $q->row();
					$ismultiplelogin = $rowmultiplelogin->general_setting_value != 2;
				}

				if (! $ismultiplelogin)
				{
					$this->db->where("ip_address <>", $_SERVER['REMOTE_ADDR']);
					$this->db->where("user_data <>", '');
					$q = $this->db->get("sessions");

					if ($q->num_rows() > 0)
					{
						$rowmultiplelogins = $q->result();

						for($i=0; $i < 	count($rowmultiplelogins); $i++)
						{
							$lastactivity = date("d/m/Y H:i:s", $rowmultiplelogins[$i]->last_activity);
							$lastsess = unserialize($rowmultiplelogins[$i]->user_data);

							if (isset($lastsess['lms_sess']))
							{
								$lastlmssess = unserialize($lastsess['lms_sess']);

								if (isset($lastlmssess['user_id']) && ($lastlmssess['user_id'] == $row['user_id']))
								{
									$errs[] = $this->config->item("lerr_multiple_login");
									break;
								}
							}
						}
					}

				}

				if (count($errs) == 0)
				{
					if ($row['user_type'] != 0)
					{
						// check concurent

						$this->db->where("general_setting_code", "concurrentuser");
						$this->db->where("general_setting_value >", 0);
						$q = $this->db->get("general_setting");
						$this->db->flush_cache();

						if ($q->num_rows() > 0)
						{
							$concurrentuser = $q->row();

							$this->db->where("user_data <>", "");
							$this->db->like('user_data', 'user_npk'); //-- cari user yg login

							$totaluser = $this->db->count_all_results("sessions");

							if ($totaluser >= $concurrentuser->general_setting_value)
							{
								$errs[] = $this->config->item("lmax_user_login");
							}
						}

						// end of concurent
					}
				}

				if (count($errs) == 0)
				{
					$this->db->where("right_id", $row['user_type']);
					$this->db->where("module_name", "trainee");
					$this->db->join("right_module", "right_module_module = module_id");
					$this->db->join("right", "right_module_right = right_id");
					$total = $this->db->count_all_results("module");
					$this->db->flush_cache();

					if ($total == 0)
					{
						$row['asadmin'] = 1;
					}

					$this->session->set_userdata('lms_sess', serialize($row));

					// load ildp cart

					$this->ildpmodel->loaddraft($row['user_id']);

					unset($data);

					$data['user_lastlogin_date'] = date("Ymd");
					$data['user_lastlogin_time'] = date("Gis");
					$data['user_loginerror'] = 0;

					$this->db->flush_cache();
					$this->db->where("user_id", $row['user_id']);
					$this->db->update("user", $data);

					// cek kapan terakhir ganti password

					$this->db->where("general_setting_code", "changepass1st");
					$q = $this->db->get("general_setting");
					$this->db->flush_cache();

					$changepass1st = 0;
					if ($q->num_rows() > 0)
					{
						$rowchangepass1st = $q->row();
						$changepass1st = $rowchangepass1st->general_setting_value;
						if ($changepass1st && ($row['user_lastmodifiedpassword'] == 0))
						{
							$isexpiredpassword = 1;
						}
					}

					$this->db->where("general_setting_code", "expiredpassword");
					$this->db->where("general_setting_value >", 0);
					$q = $this->db->get("general_setting");
					$this->db->flush_cache();

					if ($q->num_rows() > 0)
					{
						$setting = $q->row();
						$lastchangepassword = $row['user_lastmodifiedpassword'];

						if ($lastchangepassword > 0)
						{
							$year = floor($lastchangepassword/10000);
							$month = floor(($lastchangepassword%10000)/100);
							$day = ($lastchangepassword%10000)%100;

							$t1 = mktime(0, 0, 0, $month, $day, $year);
							$t2 = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

							$diffday = (($t2-$t1)/(3600*24));

							if ($diffday > $setting->general_setting_value)
							{
								$isexpiredpassword = 1;
							}
						}

					}
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
		}else{
			//session_start();
			$_SESSION['UserIsLoggedIn'] = 'yes';
		}

		echo isset($isexpiredpassword) ? 1 : 0;
	}

	function activities($group=0)
	{
		$this->showlist($group, "activities");
	}

	function showlist($group=0, $referer="")
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);

		/*
		if (! isset($this->modules['user']))
		{
			if 	(	FALSE
					|| (! isset($_POST['dialog']))
				)

			{
				redirect(base_url());
			}
		}
		*/

		if (isset($_POST['delegetion']) && $_POST['delegetion'])
		{

			$this->db->where("module_name <>", "trainee");
			$this->db->where("module_name", $_POST['pageid']);
			$this->db->join("right_module", "right_id = right_module_right");
			$this->db->join("module", "module_id = right_module_module");
			$q = $this->db->get("right");

			$rows = $q->result();

			$rightids = array(0);
			for($i=0; $i < count($rows); $i++)
			{
				$rightids[] = $rows[$i]->right_id;
			}

			$this->db->flush_cache();

			if ($sess['user_type'] != 0)
			{
				$this->db->where('delegetion_creator', $sess['user_id']);
			}

			$this->db->where('training_name', $_POST['deltraining']);
			$this->db->where('training_topic', $_POST['deltopic']);

			$this->db->join("training", "training_id = delegetion_training");
			$q = $this->db->get("delegetion");

			$dellist = $q->result();
			for($i=0; $i < count($dellist); $i++)
			{
				$delusers[] = $dellist[$i]->delegetion_user;
			}

			$this->db->flush_cache();
		}

		$recordperpage = $this->commonmodel->getRecordPerPage();

		if ($group)
		{
			$this->db->where("level_group_id", $group);
			$q = $this->db->get("level_group");
			$this->db->flush_cache();

			if ($q->num_rows() > 0)
			{
				$rowgroup = $q->row();
				$_POST['searchby'] = "level".$rowgroup->level_group_nth;
				$_POST['keyword'] = $rowgroup->level_group_name;
			}
		}

		// cek login atau tidak


		$q = $this->db->get("sessions");
		$rowsessions = $q->result();

		for($i=0; $i < count($rowsessions); $i++)
		{
			if (! $rowsessions[$i]->session_id) continue;
			if (! $rowsessions[$i]->user_data) continue;

			$data = $this->session->_unserialize($rowsessions[$i]->user_data);

			if (empty($data['lms_sess'])) continue;

			$sess = unserialize($data['lms_sess']);
			$loginids[] = $sess["user_id"];
		}

		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) :  "";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] :  "";

		if ($keyword && $searchby)
		{
			if (substr($searchby, 0, 5) == "level")
			{
				$this->db->where("UPPER(level_group_name) LIKE", '%'.strtoupper($_POST['keyword']).'%');
				$this->db->where("level_group_id", $group);

				$this->db->where("level_group_nth", substr($searchby, 5));
				$q = $this->db->get("level_group");
				$this->db->flush_cache();

				if ($q->num_rows() > 0)
				{
					$rowgroup = $q->row();
					$groupids[] = $rowgroup->level_group_id;

					$this->levelmodel->getGroupChildIds($groupids, $rowgroup->level_group_id);
				}
				else
				{
					$groupids = array(0);
				}
			}
		}

		if (isset($_POST['showtype']) && ($_POST['showtype'] == "export"))
		{
			$limit = 0;
		}
		else
		{
			$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		}

		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "user_npk";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";

		if (($keyword || isset($_POST['_status'])) && $searchby)
		{
			if ($searchby == "user_status")
			{
				if ($_POST['_status'])
				{
					$this->db->where("user_status", $_POST['_status']);
				}
			}
			else
			if ($searchby == "user_name")
			{
				$this->db->where("(user_first_name LIKE '%".addslashes($keyword)."%' OR user_last_name LIKE '%".addslashes($keyword)."%' OR CONCAT(user_first_name, ' ', user_last_name) LIKE '%".addslashes($keyword)."%')", null);
			}else
			if ($searchby == "user_npk")
			{
				$this->db->where("(user_npk LIKE '%".addslashes($keyword)."%')", null);
			}

			else
			if (substr($searchby, 0, 5) != "level")
			{
				$this->db->like($searchby, $keyword);
			}
		}

		if (isset($_POST['jabatan']) && ($_POST['jabatan'] >= 0))
		{
			$this->db->where("user_jabatan", $_POST['jabatan']);
		}

		if (isset($_POST['notadmin']) && $_POST['notadmin'])
		{
			$this->db->where("user_type <>", 0);
		}
		if (isset($delusers))
		{
			$this->db->where_not_in("user_id", $delusers);
		}

		if (isset($rightids))
		{
			$this->db->where_in("user_type", $rightids);
		}

		if($this->sess['asadmin'] != 1) {
			//print_r($this->sess);
			$result_npk_atasan = array();
			$arr_npk_atasan = array($this->sess['user_npk']);
			$get_bawahan = $this->own_get_bawahan($arr_npk_atasan, $result_npk_atasan);

			if(!empty($result_npk_atasan)) {
				//print_r(array_keys($result_npk_atasan));
				$arr_user_npk_atasan = array_keys($result_npk_atasan);
			} else {
				$arr_user_npk_atasan = array($this->sess['user_npk']);
			}

			$this->db->where_in("user_npk_atasan", $arr_user_npk_atasan);
		}

		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CONCAT(user_first_name, ' ', user_last_name) user_name, CASE user_status WHEN 2 THEN '".$this->config->item('inactive')."' ELSE '".$this->config->item('active')."' END user_status_desc ", false);
		if ($limit)
		{
			$this->db->join("function", "function_id = user_function", "left outer");
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");

			if (substr($searchby, 0, 5) == "level")
			{
				if(!empty($groupids)) $this->db->where_in("level_group_id", $groupids);
				$this->db->join("level_group", "level_group_id = jabatan_level_group");
			}

			$q = $this->db->get("user", $limit, $offset);
		}
		else
		{
			if (isset($_POST['showtype']) && ($_POST['showtype'] == "export"))
			{
				$this->db->where("user_type <>", 0);
			}

			$this->db->join("function", "function_id = user_function", "left outer");
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");

			if (substr($searchby, 0, 5) == "level")
			{
				$this->db->where_in("level_group_id", $groupids);
				$this->db->join("level_group", "level_group_id = jabatan_level_group");
			}

			$this->db->join("level_group", "level_group_id = jabatan_level_group", "left outer");
			$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
			$q = $this->db->get("user");
		}

		$this->db->flush_cache();

		$list = $q->result();
		//echo $this->db->last_query();

		//get inactive login user
		$this->db->where("general_setting_code", "inactiveperiod");
		$this->db->where("general_setting_value >", 0);

		$qsettings = $this->db->get("general_setting");
		$rowinactive = 0;
		if ($qsettings->num_rows()){
			$qrow = $qsettings->row();
			$rowinactive = $qrow->general_setting_value*24*3600;
		}

		$uids = array();
		for($i=0; $i < count($list); $i++){
			$uids[] = $list[$i]->user_id;
		}

		$userUsed = array();
		if(count($uids))
			$userUsed = $this->usermodel->getUserUsed($uids);

		for($i=0; $i < count($list); $i++){
			$delta = mktime() - dbintmaketime($list[$i]->user_lastlogin_date, 0);
			if($delta > $rowinactive) {
				$list[$i]->isinactive = true;
				$list[$i]->inactive_day = floor($delta/3600/24);
			}
			$list[$i]->logged = isset($loginids) && in_array($list[$i]->user_id, $loginids);
			$list[$i]->userUsed = isset($userUsed[$list[$i]->user_id])?true:false;

		}

		if (isset($_POST['showtype']) && ($_POST['showtype'] == "export"))
		{
			$arrlevels = array();
			$this->levelmodel->getalllevels(0, $arrlevels);

			$this->load->library("xlswriter");
			$this->xlswriter->send(date("Ymd-His")."-user.xls");

			$worksheet =& $this->xlswriter->addWorksheet("userlist per ".date("Ymd-His"));

			$worksheet->write(0, 0, $this->config->item('lnpk'));
			$worksheet->write(0, 1, $this->config->item('first_name'));
			$worksheet->write(0, 2, $this->config->item('id_jabatan'));
			$worksheet->write(0, 3, $this->config->item('jabatan_name'));

			$j = 4;
			for($i=0; $i < count($arrlevels); $i++)
			{
				$worksheet->write(0, $j, 'ID '.strtoupper($arrlevels[$i]->level_name));
				$worksheet->write(0, $j+1, strtoupper($arrlevels[$i]->level_name));

				$j += 2;
			}

			$worksheet->write(0, $j++, $this->config->item('join_date'));
			$worksheet->write(0, $j++, $this->config->item('birthdate'));
			$worksheet->write(0, $j++, $this->config->item('location_code'));
			$worksheet->write(0, $j++, $this->config->item('location'));
			$worksheet->write(0, $j++, $this->config->item('ltown_code'));
			$worksheet->write(0, $j++, $this->config->item('ltown'));
			$worksheet->write(0, $j++, $this->config->item('status_code'));
			$worksheet->write(0, $j++, $this->config->item('status'));
			$worksheet->write(0, $j++, $this->config->item('employee_status_code'));
			$worksheet->write(0, $j++, $this->config->item('employee_status'));
			$worksheet->write(0, $j++, $this->config->item('email'));

			for($i=0; $i < count($list); $i++)
			{
				$worksheet->write($i+1, 0, $list[$i]->user_npk);
				$worksheet->write($i+1, 1, $list[$i]->user_first_name." ".$list[$i]->user_last_name);
				$worksheet->write($i+1, 2, $list[$i]->jabatan_id);
				$worksheet->write($i+1, 3, $list[$i]->jabatan_name);

				$arrgroups = array();
				$this->levelmodel->getparentlevelgroups($list[$i]->level_group_id, $arrgroups);
				$arrgroups = array_reverse($arrgroups);

				$j = 4;
				for($k=0; $k < count($arrlevels); $k++)
				{
					if (isset($arrgroups[$k]))
					{
						$worksheet->write($i+1, $j, $arrgroups[$k]->level_group_id);
						$worksheet->write($i+1, $j+1, $arrgroups[$k]->level_group_name);
					}
					else
					{
						$worksheet->write($i+1, $j, '');
						$worksheet->write($i+1, $j+1, '');
					}

					$j += 2;
				}

				$worksheet->write($i+1, $j++, $list[$i]->user_join_date);
				$worksheet->write($i+1, $j++, $list[$i]->user_birthdate);
				$worksheet->write($i+1, $j++, $list[$i]->lokasi_id);
				$worksheet->write($i+1, $j++, $list[$i]->lokasi_alamat);
				$worksheet->write($i+1, $j++, $list[$i]->lokasi_kota);
				$worksheet->write($i+1, $j++, $list[$i]->lokasi_kota);
				$worksheet->write($i+1, $j++, $list[$i]->user_status);
				$worksheet->write($i+1, $j++, $list[$i]->user_status_desc);
				$worksheet->write($i+1, $j++, $list[$i]->user_emp);
				$worksheet->write($i+1, $j++, $this->usermodel->getEmployementDesc($list[$i]->user_emp));
				$worksheet->write($i+1, $j++, $list[$i]->user_email);

			}

			$this->xlswriter->close();

			return;
		}

		if (isset($_POST['jabatan']) && ($_POST['jabatan'] >= 0))
		{
			$this->db->where("jabatan_id", $_POST['jabatan']);
			$q = $this->db->get("jabatan");
			$rowjabatan = $q->row();
			$this->db->flush_cache();

			$this->mysmarty->assign("jabatan", $rowjabatan);

			$this->db->where("user_jabatan", $_POST['jabatan']);
		}
		else
		{
			$this->mysmarty->assign("jabatan", "");
		}

		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");

		if (isset($_POST['notadmin']) && $_POST['notadmin'])
		{
			$this->db->where("user_type <>", 0);
		}

		if (($keyword || isset($_POST['_status'])) && $searchby)
		{
			if ($searchby == "user_status")
			{
				if ($_POST['_status'])
				{
					$this->db->where("user_status", $_POST['_status']);
				}
			}
			else
			if ($searchby == "user_name")
			{
				$this->db->where("(user_first_name LIKE '%".addslashes($keyword)."%' OR user_last_name LIKE '%".addslashes($keyword)."%' OR CONCAT(user_first_name, ' ', user_last_name) LIKE '%".addslashes($keyword)."%')", null);
			}
			else
			if ($searchby == "user_npk")
			{
				$this->db->where("(user_npk LIKE '%".addslashes($keyword)."%')", null);
			}else
			if (substr($searchby, 0, 5) == "level")
			{
				if(!empty($groupids)) $this->db->where_in("level_group_id", $groupids);
				$this->db->join("level_group", "level_group_id = jabatan_level_group");
			}
			else
			{
				$this->db->like($searchby, $keyword);
			}
		}

		if (isset($delusers))
		{
			$this->db->where_not_in("user_id", $delusers);
		}

		if (isset($rightids))
		{
			$this->db->where_in("user_type", $rightids);
		}

		if($this->sess['asadmin'] != 1) {
			if(!empty($result_npk_atasan)) {
				//print_r(array_keys($result_npk_atasan));
				$arr_user_npk_atasan = array_keys($result_npk_atasan);
			} else {
				$arr_user_npk_atasan = array($this->sess['user_npk']);
			}

			$this->db->where_in("user_npk_atasan", $arr_user_npk_atasan);
		}

		$total = $this->db->count_all_results("user");

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

		$levels = array();
		$this->levelmodel->getalllevels(0, $levels);

		$this->pagination1->ref = isset($_POST['funcpage']) ? $_POST['funcpage'] : 'page';
		$this->pagination1->initialize($config);
		$this->pagination1->lang_title = $this->config->item('user');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());

		$this->mysmarty->assign("levels", $levels);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("ldelete", $this->config->item('ldelete'));

		$this->mysmarty->assign("department", strtoupper($this->config->item('department')));
		$this->mysmarty->assign("group", strtoupper($this->config->item('group')));
		$this->mysmarty->assign("unit_title", $this->config->item('group'));
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('luser_name')));
		$this->mysmarty->assign("email", strtoupper($this->config->item('email')));
		$this->mysmarty->assign("header_list_user", $this->config->item('header_list_user'));
		$this->mysmarty->assign("jabatan", strtoupper($this->config->item('jabatan')));
		$this->mysmarty->assign("ljabatan1", $this->config->item('jabatan'));
		$this->mysmarty->assign("ljabatan", $this->config->item('jabatan'));
		$this->mysmarty->assign("directorat_name", strtoupper($this->config->item('directorat')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lsearch_by", $this->config->item('lsearch_by'));
		$this->mysmarty->assign("lsearch", $this->config->item('lsearch'));
		$this->mysmarty->assign("lname", $this->config->item('luser_name'));
		$this->mysmarty->assign("lexport", $this->config->item('lexport'));
		$this->mysmarty->assign("lreset_errorlogin", $this->config->item('lreset_errorlogin'));
		$this->mysmarty->assign("ldelete_session", $this->config->item('ldelete_session'));
		$this->mysmarty->assign("ldelete_session_successfully", $this->config->item('ldelete_session_successfully'));
		$this->mysmarty->assign("lstatus", $this->config->item('status'));
		$this->mysmarty->assign("lactive", $this->config->item('active'));
		$this->mysmarty->assign("linactive", $this->config->item('inactive'));
		$this->mysmarty->assign("lall_status", $this->config->item('lall_status'));

		$this->mysmarty->assign("lsort_by_npk", $this->config->item('lsort_by_npk'));
		$this->mysmarty->assign("lsort_by_name", $this->config->item('lsort_by_name'));
		$this->mysmarty->assign("lsort_by_email", $this->config->item('lsort_by_email'));
		$this->mysmarty->assign("lsort_by_position", $this->config->item('lsort_by_position'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));
		$this->mysmarty->assign("lreset_datelogin", $this->config->item('lreset_datelogin'));
		$this->mysmarty->assign("lreset_datelogin_tooltips", $this->config->item('lreset_datelogin_tooltips'));

		$this->mysmarty->assign("user_list", ucfirst(strtolower($this->config->item('user_list'))));

		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("referer", $referer);

		if ($referer == "activities")
		{
			if($this->sess['asadmin'] == 1) {
				$this->mysmarty->assign("left_content", "topic/menu.html");
			} else {
				$this->mysmarty->assign("left_content", "user/menu.html");
			}
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu_admin.html");
		}


		$this->mysmarty->assign("main_content", "user/list.html");
		$this->mysmarty->display("sess_template.html");
	}


    function resetdatelogin_forall() {
        $usess = $this->session->userdata('lms_sess');
		if (! $usess)
            {
                redirect(base_url());
            }

		$sess = unserialize($usess);
		if (! isset($this->modules['user']))
            {
                redirect(base_url());
            }
        unset($data);

        $data['user_lastlogin_date'] = date("Ymd");
		$data['user_lastlogin_time'] = date("Gis");

        $this->db->update("user", $data);

        redirect(site_url(array("user", "showlist")));
    }

	function resetdatelogin($id){
		unset($data);
		$data['user_lastlogin_date'] = date("Ymd");
		$data['user_lastlogin_time'] = date("Gis");
		$this->resetdata($id,$data);
	}

	function resetdata($id,$data){
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$sess = unserialize($usess);
		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}

		$this->db->where("user_id", $id);
		$this->db->update("user", $data);
		$this->db->flush_cache();

		redirect(site_url(array("user", "showlist")));
	}


    function reseterrlogin_forall() {
        $usess = $this->session->userdata('lms_sess');
		if (! $usess)
            {
                redirect(base_url());
            }

		$sess = unserialize($usess);
		if (! isset($this->modules['user']))
            {
                redirect(base_url());
            }
        unset($data);

        $data['user_loginerror'] = 0;
        $this->db->update("user", $data);

        redirect(site_url(array("user", "showlist")));
    }


	function reseterrlogin($id){
		unset($data);
		$data['user_loginerror'] = 0;
		$this->resetdata($id,$data);
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

	function form($edit=0)
	{
		$this->checkadmin();

		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}

		if ($edit)
		{
			$this->db->where("user_id", $edit);
			$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
			$this->db->join("function", "function_id = user_function", "left outer");
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");

			$q = $this->db->get("user");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row_array();
			if ($row['user_type'] == 0)
			{
				redirect(base_url());
			}

			$groups = array();
			$this->levelmodel->getparentlevelgroups($row['jabatan_level_group'], $groups);
			$groups = array_reverse($groups);
			for($i=0; $i < count($groups); $i++)
			{
				$mygroups[$groups[$i]->level_group_nth] = $groups[$i];
			}

			$t = dbintmaketime($row['user_join_date'], 0);
			$row['user_join_date_fmt'] = date("d/m/Y", $t);

			$t = dbintmaketime($row['user_birthdate'], 0);
			$row['user_birthdate_fmt'] = date("d/m/Y", $t);

			$row['user_lastlogin_date_fmt'] = "";
			if($row['user_lastlogin_date']) {
				$t = dbintmaketime($row['user_lastlogin_date'], 0);
				$row['user_lastlogin_date_fmt'] = date("d/m/Y", $t);
			}

			$tmp = $this->db->select('user_first_name')->where('user_npk = "'.$row['user_npk_atasan'].'"')->get('user')->row_array();
			$row['nama_atasan'] = !empty($tmp['user_first_name']) ? $tmp['user_first_name'] : '';

			$this->mysmarty->assign("mygroups", isset($mygroups) ? $mygroups : "");
			$this->mysmarty->assign("user", $row);
		}

		$this->db->order_by("right_name", "asc");
		$q = $this->db->get("right");

		$usertypes = $q->result();

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
		$this->mysmarty->assign("lnama_atasan", $this->config->item("lnama_atasan"));
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
		$this->mysmarty->assign("hide_famaly_field", $this->config->item("hide_family_field"));
		$this->mysmarty->assign("lname", $this->config->item("luser_name"));


		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "user/form.html");
		$this->mysmarty->display("sess_template.html");

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

		if (! isset($this->modules['user']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$data['user_status'] = ($status == 2) ? 1 : 2;

		$this->db->where("user_id", $id);
		$this->db->update("user", $data);
	}

	function remove()
	{
		$this->checkadmin();

		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}

		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}

		// superadmin tidak boleh dihapus

		$this->db->where("user_id", $id);
		$q = $this->db->get("user");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$row = $q->row();
		if ($row->user_type == 0)
		{
			redirect(base_url());
		}


		//-- tidak boleh hapus user yg sdh punya history
		$userUsed = $this->usermodel->getUserUsed($id);
		if($userUsed[$id]){
			redirect(site_url(array("user", "showlist")));
			exit;
		}

		$this->db->where("user_id", $id);
		$this->db->delete("user");

		redirect(site_url(array("user", "showlist")));
	}

	/*function getnpk()
	{
		$this->db->order_by("user_npk", "asc");
		$this->db->where("user_status", 1);

		$q = $this->db->get("user");
		$list = $q->result();

		for($i=0; $i < count($list); $i++)
		{
			echo $list[$i]->user_npk;
			echo "\1";
		}

		$this->db->flush_cache();
	}*/

    function getnpk()
    {
        $this->db->order_by("user_npk", "asc");
        $this->db->where("user_status", 1);

        $q = $this->db->get("user");
        $list = $q->result();

        $data = [];
        for($i=0; $i < count($list); $i++)
        {
            $data[$i] = [
                'name' => $list[$i]->user_npk
            ];
        }

        $this->db->flush_cache();

        echo json_encode($data);
    }

	function showlokasi()
	{
		$city = isset($_POST['city']) ? $_POST['city'] : "";
		$def = isset($_POST['def']) ? $_POST['def'] : 0;

		if ($city)
		{
			$this->db->order_by("lokasi_alamat", "asc");
			$this->db->where("lokasi_kota", $city);
			$q = $this->db->get("lokasi");
			$this->db->flush_cache();

			$rows = $q->result();
			$this->mysmarty->assign("lokasies", $rows);
			$this->mysmarty->assign("def", $def);
		}

		$this->mysmarty->assign("location", $this->config->item("location"));
		$this->mysmarty->display("user/selectboxlokasi.html");
	}

	function import()
	{
		$this->checkadmin();

		if (! isset($this->modules['user']))
		{
			redirect(base_url());
		}

		$this->mysmarty->assign("show_old_import", $this->config->item("show_old_import"));
		$this->mysmarty->assign("luser_file", $this->config->item("luser_file"));
		$this->mysmarty->assign("limport_user_new_sap", $this->config->item("limport_user_new_sap"));
		$this->mysmarty->assign("limport_user_old_system", $this->config->item("limport_user_old_system"));
		$this->mysmarty->assign("limport_user", $this->config->item("limport_user"));

		$this->mysmarty->assign("left_content", "user/menu_admin.html");
		$this->mysmarty->assign("main_content", "user/import.html");
		$this->mysmarty->display("sess_template.html");
	}

	function saveimportold()
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		$errs = array();

		if (! isset($_FILES['userfile']))
		{
			$errs[] = $this->config->item("lempty_user_file");
		}
		else
		if (! $_FILES['userfile']['name'])
		{
			$errs[] = $this->config->item("lempty_user_file");
		}
		else
		{
		    /*
			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['userfile']['tmp_name']);

			$this->xlsreader->setColumnFormat(8, "0xe");

			$this->logmodel->init("import_user");

			$this->logmodel->append("start import ");

			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;

				unset($row);

				$row['npk'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['firstname'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";
				$row['jabatan'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][3])) : "";

				$level['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][4])) : "";
				$row['level'][] = $level;

				$level['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][5])) : "";
				$row['level'][] = $level;

				$level['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][6])) : "";
				$row['level'][] = $level;

				$level['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][7])) : "";
				$row['level'][] = $level;

				$row['tglmasuk'] = isset($this->xlsreader->sheets[0]['cells'][$irow][8]) ? $this->xlsreader->sheets[0]['cells'][$irow][8] : "";
				$row['tgllahir'] = isset($this->xlsreader->sheets[0]['cells'][$irow][9]) ? $this->xlsreader->sheets[0]['cells'][$irow][9] : "";
				$row['material'] = isset($this->xlsreader->sheets[0]['cells'][$irow][10]) ? $this->xlsreader->sheets[0]['cells'][$irow][10] : "";
				$row['alamat'] = isset($this->xlsreader->sheets[0]['cells'][$irow][11]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][11])) : "";
				$row['kota'] = isset($this->xlsreader->sheets[0]['cells'][$irow][12]) ? strtoupper(trim($this->xlsreader->sheets[0]['cells'][$irow][12])) : "";
				$row['employee'] = isset($this->xlsreader->sheets[0]['cells'][$irow][13]) ? $this->xlsreader->sheets[0]['cells'][$irow][13] : "";

				// 1 :: 1/1/1900
				$row['tglmasuk'] = date('Ymd', mktime(0, 0, 0, 1, $row['tglmasuk']-1, 1900));
				$row['tgllahir'] = date('Ymd', mktime(0, 0, 0, 1, $row['tgllahir']-1, 1900));

				$data[] = $row;
				$irow++;
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);

            $data = array();

            $this->logmodel->init("import_user");

            $this->logmodel->append("start import ");

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['npk'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['firstname'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['jabatan'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();

                    $level['name'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();
                    $row['level'][] = $level;

                    $level['name'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();
                    $row['level'][] = $level;

                    $level['name'] = $worksheet->getCellByColumnAndRow(5, $irow)->getValue();
                    $row['level'][] = $level;

                    $level['name'] = $worksheet->getCellByColumnAndRow(6, $irow)->getValue();
                    $row['level'][] = $level;

                    $row['tglmasuk'] = $worksheet->getCellByColumnAndRow(7, $irow)->getValue();
                    $row['tgllahir'] = $worksheet->getCellByColumnAndRow(8, $irow)->getValue();
                    $row['material'] = $worksheet->getCellByColumnAndRow(9, $irow)->getValue();
                    $row['alamat'] = $worksheet->getCellByColumnAndRow(10, $irow)->getValue();
                    $row['kota'] = $worksheet->getCellByColumnAndRow(11, $irow)->getValue();
                    $row['employee'] = $worksheet->getCellByColumnAndRow(12, $irow)->getValue();

                    // 1 :: 1/1/1900
                    $row['tglmasuk'] = date('Ymd', mktime(0, 0, 0, 1, $row['tglmasuk']-1, 1900));
                    $row['tgllahir'] = date('Ymd', mktime(0, 0, 0, 1, $row['tgllahir']-1, 1900));

                    $data[] = $row;
                    $irow++;
                }
            }

			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_user_file_data");
				}
			}
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			echo "<script>parent.setErrorMessage('messageimportold', \"".$err."\")</script>";

			return;
		}

		//$this->db->delete("lokasi");
		//$this->db->delete("jabatan");
		//$this->db->delete("level_group");

		// jabatan
		$this->logmodel->append("get jabatan");

		$q = $this->db->get("jabatan");
		$this->db->flush_cache();

		$rowjabatans  = $q->result();
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$rowjabatans[$i]->jabatan_name = trim($rowjabatans[$i]->jabatan_name);
			$jabatans[$rowjabatans[$i]->jabatan_level_group][strtoupper(trim($rowjabatans[$i]->jabatan_name))] = $rowjabatans[$i];
		}

		// level group
		$this->logmodel->append("get level group");

		$q = $this->db->get("level_group");
		$this->db->flush_cache();

		$rowgroups  = $q->result();
		for($i=0; $i < count($rowgroups); $i++)
		{
			$groups[$rowgroups[$i]->level_group_parent][strtoupper(trim($rowgroups[$i]->level_group_name))] = $rowgroups[$i];
	}

		// lokasi
		$this->logmodel->append("get lokasi");

		$q = $this->db->get("lokasi");
		$this->db->flush_cache();

		$rowlokasi  = $q->result();
		for($i=0; $i < count($rowlokasi); $i++)
		{
			$lokasies[strtoupper(trim($rowlokasi[$i]->lokasi_kota))][strtoupper(trim($rowlokasi[$i]->lokasi_alamat))] = $rowlokasi[$i];
		}

		// user
		$this->logmodel->append("get user");

		$this->db->where("user_type !=", 0);
		$q = $this->db->get("user");
		$this->db->flush_cache();

		$rownpks  = $q->result();
		for($i=0; $i < count($rownpks); $i++)
		{
			$npks[$rownpks[$i]->user_npk] = $rownpks[$i];
			$npkids[$rownpks[$i]->user_id] = $rownpks[$i];
		}

		unset($insert);

		$insert['import_date'] = date("Ymd");
		$insert['import_time'] = date("Gis");
		$insert['import_nrecords'] = count($data);
		$insert['import_nactive'] = 0;
		$insert['import_nnoactive'] = count($data);
		$insert['import_creator'] = $sess['user_id'];

		$sql = $this->db->insert_string("import", $insert);
		$this->logmodel->append("insert table import : ".$sql);

		$this->db->insert("import", $insert);
		$importid = $this->db->insert_id();

		for($i=0; $i < count($data); $i++)
		{
			unset($insert);
			$data[$i]['jabatan'] = trim($data[$i]['jabatan']);

			if ($data[$i]['kota'] && $data[$i]['alamat'])
			{
				if (isset($lokasies[$data[$i]['kota']][$data[$i]['alamat']]))
				{
					$lokasiid = $lokasies[$data[$i]['kota']][$data[$i]['alamat']]->lokasi_id;
					//echo $data[$i]['kota']." : ".$data[$i]['alamat']." : lokasi found\r\n<br />";
				}
				else
				{
					$insert['lokasi_kota'] = $data[$i]['kota'];
					$insert['lokasi_alamat'] = $data[$i]['alamat'];
					$insert['lokasi_status'] = 1;
					$insert['lokasi_created'] = date("Ymd");
					$insert['lokasi_creator'] = $sess['user_id'];

					$sql = $this->db->insert_string("lokasi", $insert);
					$this->logmodel->append("insert table lokasi : ".$sql);

					$this->db->insert("lokasi", $insert);
					$lokasiid = $this->db->insert_id();

					$lokasies[$data[$i]['kota']][$data[$i]['alamat']]->lokasi_id = $lokasiid;
				}
			}
			else
			{
				$lokasiid = 0;
			}

			$parentid = 0;
			for($j=0; $j < count($data[$i]['level']); $j++)
			{
				unset($insert);

				if (! $data[$i]['level'][$j]['name'])
				{
					break;
				}


				if (isset($groups[$parentid][$data[$i]['level'][$j]['name']]))
				{
					$parentid = $groups[$parentid][$data[$i]['level'][$j]['name']]->level_group_id;
				}
				else
				{
					$insert['level_group_name'] = $data[$i]['level'][$j]['name'];
					$insert['level_group_parent'] = $parentid;
					$insert['level_group_status'] = 1;
					$insert['level_group_nth'] = $j+1;
					$insert['level_group_created'] = date("Ymd");
					$insert['level_group_creator'] = $sess['user_id'];

					$sql = $this->db->insert_string("level_group", $insert);
					$this->logmodel->append("insert table level_group : ".$sql);
					$this->db->insert("level_group", $insert);
					$temp = $parentid;
					$parentid = $this->db->insert_id();

					$groups[$temp][$data[$i]['level'][$j]['name']]->level_group_id = $parentid;
				}
			}

			if(isset($jabatans[$parentid][$data[$i]['jabatan']]))
			{
				$jabatanid = $jabatans[$parentid][$data[$i]['jabatan']]->jabatan_id;
			}
			else
			{
				unset($insert);

				$insert['jabatan_name'] = trim($data[$i]['jabatan']);
				$insert['jabatan_status'] = 1;
				$insert['jabatan_created'] = date("Ymd");
				$insert['jabatan_creator'] = $sess['user_id'];
				$insert['jabatan_level_group'] = $parentid;

				$sql = $this->db->insert_string("jabatan", $insert);
				$this->logmodel->append("insert jabatan : ".$sql);

				$this->db->insert("jabatan", $insert);
				$jabatanid = $this->db->insert_id();

				$jabatans[$parentid][$data[$i]['jabatan']]->jabatan_id = $jabatanid;

			}

			// search right

			$this->db->where("UPPER(module_name)", strtoupper("trainee"));
			$this->db->join("module", "right_module_module = module_id");
			$q  = $this->db->get("right_module");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$usertype = 0;
			}
			else
			{
				$rowtype = $q->row();
				$usertype = $rowtype->right_module_right;
			}

			unset($insert);

			$insert['user_npk'] = $data[$i]['npk'];
			$insert['user_first_name'] = $data[$i]['firstname'];
			$insert['user_last_name'] = '';
			$insert['user_join_date'] = $data[$i]['tglmasuk'];
			$insert['user_birthdate'] = $data[$i]['tgllahir'];
			$insert['user_location'] = $lokasiid;
			$insert['user_email'] = $data[$i]['npk'];
			$insert['user_jabatan'] = $jabatanid;
			$insert['user_status'] = 1;
			$insert['user_emp'] = 1; //$this->usermodel->getEmployement($data[$i]['employee']);
			$insert['user_import'] = $importid;

			if (isset($npks[$data[$i]['npk']]))
			{
				$this->db->where("user_id", $npks[$data[$i]['npk']]->user_id);
				$this->db->update("user", $insert);
				$this->db->flush_cache();
			}
			else
			{
				/*if (! isset($npkids[$data[$i]['npk']]))
				{
					$insert['user_id'] = $data[$i]['npk'];
				}*/

				$insert['user_pass'] = substr(md5($data[$i]['npk']), 0, 100);
				$insert['user_description'] = '';
				$insert['user_lastlogin_date'] = date("Ymd");
				$insert['user_lastlogin_time'] = date("Gis");
				$insert['user_creator'] = $sess['user_id'];
				$insert['user_created_date'] = date("Ymd");
				$insert['user_created_time'] = date("Gis");
				$insert['user_function'] = 0;
				$insert['user_forgotpass_confirm'] = '';
				$insert['user_forgotpass_date'] = 0;
				$insert['user_lastmodifiedpassword'] = 0;
				$insert['user_loginerror'] = 0;
				$insert['user_type'] = $usertype;

				$sql = $this->db->insert_string("user", $insert);
				$this->logmodel->append("insert user: ".$sql);

				$this->db->insert("user", $insert);
				$npkid = $this->db->insert_id();

				$npks[$data[$i]['npk']]->user_id = $npkid;
				$npkids[$npkid] = $insert;
			}
		}

		echo "<script>parent.setSuccess('messageimportold', \"".$this->config->item('limportuser_ok')."\")</script>";
	}

	function sap($type="csv", $filename="") 
	{
		set_time_limit(0);

		if ($filename)
		{
			$file = $filename;
		}
		else
		{
			$file = $this->config->item("root_path")."/".$this->config->item("inbox")."/".$this->config->item("importfilename");
		}


		$this->logmodel->init("import_user");

		if (! is_file($file))
		{
			$s_echo = "can't open ".$file;
			$this->logmodel->append($s_echo);

			if ($filename) return array($s_echo);

			echo $s_echo."\r\n";
			return;
		}

		$nlevel = $this->levelmodel->getnlevel();
		$startrow = 2;
		$TotalColumn = 18+(2*$nlevel);

		if ($type == "xls")
		{
			/*$this->load->library("xlsreader");

			if (! $this->xlsreader->read($file))
			{
				$s_echo = $this->config->item("lempty_user_file1");

				$this->logmodel->append($s_echo);

				if ($filename) return array($s_echo);

				echo $s_echo."\r\n";

				return;
			}*/

			require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = PHPExcel_IOFactory::load($filename);

			if (empty($objPHPExcel))
			{
				$s_echo = $this->config->item("lempty_user_file1");

				$this->logmodel->append($s_echo);

				if ($filename) return array($s_echo);

				echo $s_echo."\r\n";

				return;
			}

			$this->logmodel->append("start reading excel file");

			/*$i = $startrow;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

				for($j=1;$j<=$TotalColumn;$j++)
				{
					if (! isset($this->xlsreader->sheets[0]['cells'][$i][$j]))
					{
						$rows[$i-2][$j-1] = "";
						continue;
					}

					if ($this->xlsreader->sheets[0]['cellsInfo'][$i][$j]['type'] == "date")
					{
						$rows[$i-2][$j-1] = date("Ymd", $this->xlsreader->sheets[0]['cellsInfo'][$i][$j]["raw"]);
						continue;
					}

					$rows[$i-2][$j-1] = trim($this->xlsreader->sheets[0]['cells'][$i][$j]);
				}
				$i++;
			}*/

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = $startrow; $irow <= $highestRow; $irow++) {
                    for($j=0;$j<$TotalColumn;$j++)
					{
						$nilai = $worksheet->getCellByColumnAndRow($j, $irow)->getValue();
						if (empty($nilai))
						{
							$rows[$irow-2][$j] = "";
							continue;
						}
						$rows[$irow-2][$j] = trim($nilai);
					}
                }
            }

            //print_r($rows); exit();

			$this->logmodel->append("end reading excel file");
		}
		else
		{

			$fin = fopen($file, "rb");
			if (! $fin)
			{
				echo "can't open file ".$file;
				$this->logmodel->append("can't open file ".$file);

				return;
			}

			$this->logmodel->append("start reading csv file");
			$i = 0;
			while(! feof($fin))
			{
				$line = trim(fgets($fin));
				if ($i == 0)
				{
					$i++;
					continue;
				}

				if (strlen($line) == 0) break;
				$lines = explode(";",  $line);

				for($j=1;$j<=$TotalColumn;$j++)
				{
					$rows[$i-1][$j-1] = isset($lines[$j-1]) ? trim($lines[$j-1]) : "";
				}

				$i++;
			}

			fclose($fin);
			$this->logmodel->append("end reading csv file");

		}

		if (! isset($rows))
		{
			unset($data);

			$data['import_date'] = date("Ymd");
			$data['import_time'] = date("Gis");
			$data['import_nrecords'] = 0;
			$data['import_nactive'] = 0;
			$data['import_nnoactive'] = 0;
			$data['import_creator'] = 0;

			$this->db->insert("import", $data);

			$s_echo = "file is empty";

			$this->logmodel->append($s_echo);

			if ($filename) return array($s_echo);

			echo $s_echo."\r\n";
			return;
		}

		$this->logmodel->append("start updating database");

		// trainee

		$usertypedef = $this->config->item("usertype_default");
		if ($usertypedef)
		{
			$this->db->where("UPPER(right_name)", strtoupper("trainee"));
			$q  = $this->db->get("right");

			if ($q->num_rows() == 0)
			{
				$usertype = 0;
			}
			else
			{
				$rowtype = $q->row();
				$usertype = $rowtype->right_id;
			}
		}
		else
		{
			$this->db->where("UPPER(module_name)", strtoupper("trainee"));
			$this->db->join("module", "right_module_module = module_id");
			$q  = $this->db->get("right_module");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$usertype = 0;
			}
			else
			{
				$rowtype = $q->row();
				$usertype = $rowtype->right_module_right;
			}
		}

		//$jend = 4+2*$nlevel-1;
		$jend = ( 4 + (2 * $nlevel) ) - 1;

		$total_nactive = $total_nnoactive = 0;
		$usr_grade = array(0);
		$company = $this->config->item("theme");

		//print_r($rows); exit();

		for($i=0; $i < count($rows); $i++)
		{
			// kota

			unset($data);

			$data['lokasi_kota'] = trim($rows[$i][$jend+5]);
			$data['lokasi_alamat'] = trim($rows[$i][$jend+3]);
			$data['lokasi_creator'] = 0;
			$data['lokasi_created'] = date("Ymd");
			$data['lokasi_status'] = 1;

			$this->db->where("lokasi_kota", $data['lokasi_kota']);
			$this->db->where("lokasi_alamat", $data['lokasi_alamat']);
			$q = $this->db->get("lokasi");

			$this->db->flush_cache();

			if ($q->num_rows() > 0)
			{
				$row = $q->row();
				$lokasiid = $row->lokasi_id;
			}
			else
			{
				$this->logmodel->append("insert lokasi : npk(".$rows[$i][0].") == ".$data['lokasi_kota']." kol(".($jend+5)." :: ".$rows[$i][$jend+5]." :: ".$rows[$i][$jend+6].")/".$data['lokasi_alamat']." kol(".(($jend+3)).")");
				$this->db->insert("lokasi", $data);
				$lokasiid = $this->db->insert_id();
			}

			// group

			$parent = 0;

			$k = 1;
			for($j=4; $j <= $jend; $j+=2)
			{
				unset($data);

				$data['level_group_parent'] = $parent;
				$data['level_group_name'] = trim($rows[$i][$j+1]);
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = $k++;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;

				if (($parent > 0) && (! $data['level_group_name']))
				{
					break;
				}

				$data['level_group_name'] = iconv("utf-8", "ascii//TRANSLIT//IGNORE", $data['level_group_name']);
				$data['level_group_name'] =  preg_replace("/^'|[^A-Za-z0-9\s-]|'$/", '', $data['level_group_name']);

				$this->db->where("level_group_name", $data['level_group_name']);
				$this->db->where("level_group_parent", $data['level_group_parent']);

				$q = $this->db->get("level_group");
				$this->db->flush_cache();

				if ($q->num_rows() > 0)
				{
					$row = $q->row();
					$parent = $row->level_group_id;
				}
				else
				{
					$this->db->insert("level_group", $data);
					$parent = $this->db->insert_id();
				}
			}

			// jabatan

			unset($data);

			$data['jabatan_name'] = trim($rows[$i][3]);
			$data['jabatan_status'] = 1;
			$data['jabatan_created'] = date("Ymd");
			$data['jabatan_creator'] = 0;
			$data['jabatan_level_group'] = $parent;
			$data['jabatan_category'] = 0;

			$this->db->where("jabatan_name", $data['jabatan_name']);
			$this->db->where("jabatan_level_group", $data['jabatan_level_group']);

			$q = $this->db->get("jabatan");
			$this->db->flush_cache();

			if ($q->num_rows() > 0)
			{
				$row = $q->row();
				$jabatanid = $row->jabatan_id;
			}
			else
			{
				$this->db->insert("jabatan", $data);
				$jabatanid = $this->db->insert_id();
			}

			// user

			unset($data);

			$data['user_npk'] = $rows[$i][0];
			$data['user_first_name'] = trim($rows[$i][1]);
			$data['user_last_name'] = "";
			$data['user_join_date'] = trim($rows[$i][$jend+1]);
			$data['user_birthdate'] = trim($rows[$i][$jend+2]);
			$data['user_location'] = $lokasiid;
			$data['user_email'] = trim($rows[$i][$jend+9]);
			$data['user_jabatan'] = $jabatanid;

			/*
			2011 04 12 :  N2, N3, N4, N5 is eligible
			*/
			$user_grade_code = "";
			switch(strtoupper($rows[$i][$jend+10])){
				case "N2" :
					$user_grade_code = 92;
				break;
				case "N3" :
					$user_grade_code = 93;
				break;
				case "N4" :
					$user_grade_code = 94;
				break;
				case "N5" :
					$user_grade_code = 95;
				break;
				default :
					$user_grade_code = intval($rows[$i][$jend+10]);
			}

			$data['user_grade_code'] = $user_grade_code;  //karena type data di field adalah integer
			$user_grade_description = $rows[$i][$jend+11];

			//-- insert into table master if not exist
			$this->update_user_grade($data['user_grade_code'], $user_grade_description, $usr_grade);

			/*
			2011 04 12 : dari sap nya 8 digit
						 kalo > 5 digit, dan 3 digit sebelah kiri = 0, ambil 5 digit terakhir
			*/
			$npk_atasan_v = $rows[$i][$jend+12];

			/* disabled, npk_atasan must complete 20160508
			if($company <> 'smart') {
				// 2012 01 06 , terutama u/ permata
				if(strlen($npk_atasan_v) > 5 ){
					$npk_atasan_v = substr($npk_atasan_v, -5);    // returns "xxxxxx"
				}
			}
			*/

			$data['user_npk_atasan'] = $npk_atasan_v;

			/*
			1  : staff
			2  : outsource
			3  : contract
			*/
			switch(trim(strtoupper($rows[$i][$jend+8]))){
				case "STAFF" :
					$data['user_emp']  = "1";
				break;
				case "OUTSOURCE" :
					$data['user_emp']  = "2";
				break;
				case "KONTRAK" :
				case "CONTRAK" :
					$data['user_emp']  = "3";
				break;
			}

			$data['user_status'] =  ( trim($rows[$i][$jend+6]) == "1") ? trim($rows[$i][$jend+6]) : "2";  // 1=aktif , 2 = inactive/withdraw

			if($data['user_status'] == 1)
				$total_nactive++;
			else
			if($data['user_status'] == 2)
				$total_nnoactive++;

			$this->db->where("user_npk", $data['user_npk']);

			$q = $this->db->get("user");
			$this->db->flush_cache();

			if ($q->num_rows() > 0)
			{
				$row = $q->row();
				$this->logmodel->append("update user npk : ".$row->user_npk."  id:".$row->user_id);

				$this->db->where("user_id", $row->user_id);
				$this->db->update("user", $data);
			}
			else
			{
				$data['user_forgotpass_confirm'] = "";
				$data['user_forgotpass_date'] = 0;
				$data['user_lastmodifiedpassword'] = 0;
				$data['user_loginerror'] = 0;
				$data['user_import'] = 0;
				$data['user_function'] = 0;
				$data['user_type'] = $usertype;
				$data['user_lastlogin_date'] = date("Ymd");
				$data['user_lastlogin_time'] = date("Gis");
				$data['user_creator'] = 0;
				$data['user_created_date'] = date("Ymd");
				$data['user_created_time'] = date("Gis");
				$data['user_description'] = "";
				$data['user_pass'] = substr(md5($data['user_npk']), 0, 100);
				$this->logmodel->append("insert user npk : ".$data['user_npk']);
				$this->db->insert("user", $data);
			}
		}

		unset($data);

		$data['import_date'] = date("Ymd");
		$data['import_time'] = date("Gis");
		$data['import_nrecords'] = count($rows);
		//$data['import_nactive'] = count($rows);
		$data['import_nactive'] = $total_nactive;
		$data['import_nnoactive'] = $total_nnoactive;
		$data['import_creator'] = 0;

		$this->db->insert("import", $data);

		$this->logmodel->append("end updating database");
		if ($filename == "")
		{
			//-- rename the file
			$oldFile =$this->config->item("root_path")."/".$this->config->item("inbox")."/".$this->config->item("importfilename");
			$newFile = $this->config->item("root_path")."/".$this->config->item("inbox")."/".date("Ymd_His")."_".$this->config->item("importfilename");
			rename($oldFile,$newFile);
		}

		return 0;
	}

	function update_user_grade($grade, $grade_description = '',&$usr_grade){
		$exist = false;
		if(!in_array($grade, $usr_grade)){
			$this->logmodel->append("ga ada di array : ".$grade);

			$this->db->where("grade_code",$grade);
			$q = $this->db->get("grade");
			if ($q->num_rows() > 0){
				$exist = true;
			}
		}else {
			$this->logmodel->append("ada di array : ".$grade);
			$exist = true;
		}

		//-- if not exist and grade > 0
		if(!$exist && ($grade > 0)){
				$data['grade_id'] = $grade;
				$data['grade_code'] = $grade;
				$data['grade_description'] = $grade_description;
				$this->db->insert("grade",$data);
				$this->logmodel->append("insert into table grade : ".$grade);

				array_push($usr_grade,$grade);
		}

		if($exist && ($grade > 0)) {
			$data['grade_description'] = $grade_description;
			$this->db->where("grade_id", $grade);
			$this->db->update("grade", $data);
			$this->logmodel->append("update into table grade : ".$grade);
		}
	}

	function saveimport($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		$errs = array();

		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_user_file1");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_user_file1");
			}
		}

		if (count($errs) == 0)
		{
			if ($_FILES['userfile']['type'] != 'application/vnd.ms-excel' && $_FILES['userfile']['type'] != "application/octet-stream")
			{
				$errs[] = $this->config->item("lempty_user_file1");
			}
			else
			{
				$paths = pathinfo($_FILES['userfile']['name']);
				if (strcasecmp($paths['extension'], "xls") != 0)
				{
					$errs[] = $this->config->item("lempty_user_file1");
				}

			}
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			$s_error = join(",", $errs);
			echo "<script>parent.setErrorMessage('messageimportnew', \"".$err."\")</script>";

			return;
		}

		$filename = $_FILES['userfile']['tmp_name'];


		$errs = $this->sap("xls", $filename);

		if (is_array($errs))
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);

			$s_error = join(",", $errs);
			echo "<script>parent.setErrorMessage('messageimportnew', \"".$err."\")</script>";
			return;
		}

		printf("<script>parent.setSuccess('messageimportnew', '%s')</script>", $this->config->item("limportuser_ok"));
	}

	function noticeadmin($subject, $message, $type)
	{
		$message .= "for detail see <a href='".base_url()."log/".$type."/".date("Ymd").".log'>".$type." log</a>\r\n";

		$this->load->library('email');

		$config['protocol'] = $this->config->item("email_protocol");

		if ($config['protocol'] == "smtp")
		{
			$config['smtp_host'] = $this->config->item("email_smtp_host");
			$config['smtp_user'] = $this->config->item("email_smtp_user");
			$config['smtp_pass'] = $this->config->item("email_smtp_pass");
		}

		$this->email->initialize($config);
		$this->email->from($this->config->item("admin_mail"), $this->config->item("admin_name"));
		$this->email->to($this->config->item("admin_mail"));
		$this->email->subject($subject);
		$this->email->message($message);

		if ($this->email->send())
		{
			$this->logmodel->append("notice sent");
		}
		else
		{
			$this->logmodel->append("notice failed");
		}
	}

	function getList()
	{
		$this->db->select("user_first_name, user_last_name, user_npk");
		$q = $this->db->get("user");
		$rows = $q->result();

		$datas = array();
		for($i=0; $i < count($rows); $i++)
		{
			$datas[] = sprintf("%s ( %s %s )", $rows[$i]->user_npk, $rows[$i]->user_first_name, $rows[$i]->user_last_name);
		}

		$callback['rows'] = $datas;
		echo json_encode($callback);
	}

	function group($parent)
	{
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_status", 1);
		$this->db->where("level_group_parent", $parent);

		$q = $this->db->get("level_group");

		$rows = $q->result();

		$callback["groups"] = $rows;
		echo json_encode($callback);
	}

	function jabatan($groupid)
	{
		$this->db->order_by("jabatan_name", "asc");
		$this->db->where("jabatan_status", 1);
		$this->db->where("jabatan_level_group", $groupid);

		$q = $this->db->get("jabatan");

		$rows = $q->result();

		$callback["jabatans"] = $rows;
		echo json_encode($callback);
	}

	function func($jabatan)
	{
		$this->db->order_by("function_desc", "asc");
		$this->db->where("function_status", 1);
		$this->db->where("function_jabatan", $jabatan);

		$q = $this->db->get("function");

		$rows = $q->result();

		$callback["functions"] = $rows;
		echo json_encode($callback);

	}

	function admin_news()
	{
		$usess = $this->session->userdata('lms_sess');
		if (! $usess)
		{
			redirect(base_url());
		}

		$recordperpage = $this->commonmodel->getRecordPerPage();

		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "news_title";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";

		if(!empty($_POST["_searchby"])) {
			$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
		}

		//print_r($_POST); exit();

		$sess = unserialize($usess);

		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}

		if ($searchby)
		{
			if ($searchby == "news_title")
			{
				$this->db->where("news_title LIKE", '%'.strtoupper($keyword).'%');
			}
		}

		$this->db->order_by($sortby, $orderby);

		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		$this->db->select("*, DATE_FORMAT( FROM_UNIXTIME( news_entrydate ) ,  '%d-%m-%Y' ) AS tanggal", false);

		$q = $this->db->get("cms_news");
		$list = $q->result();

		if (isset($newsids))
		{
			$this->db->where_in("news_id", $newsids);
		}

		if ($searchby)
		{
			if ($searchby == "news_title")
			{
				$this->db->where("news_title LIKE", '%'.strtoupper($keyword).'%');
			}
		}
		$total = $this->db->count_all_results("cms_news");

		$s = "";
		$this->itot = 0;

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
		$this->pagination1->lang_title = $this->config->item('lcms_news');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("paging", $this->pagination1->create_links());

		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_category_jabatan", $this->config->item('lheader_list_category_jabatan'));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lcategory_jabatan_list", ucfirst($this->config->item('lcategory_jabatan_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));

		$this->mysmarty->assign("lsort_by_category_name", $this->config->item('lsort_by_category_name'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));

		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("left_content", "user/menu_admin_news.html");
		$this->mysmarty->assign("main_content", "user/list_news.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formadminnews($edit=0, $act="")
	{
		$this->checkadmin();

		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}

		if ($edit)
		{
			$this->db->where("news_id", $edit);
			$q = $this->db->get("cms_news");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$row = $q->row_array();

			$row['news_image'] = !empty($row['news_image']) ? ('<img style="width:100%;max-width=100%;" src="'.base_url().'uploads/cms_news/'.$row['news_image'].'" alt="'.$row['news_title'].'" />') : '';
			$this->mysmarty->assign("cmsnewsedit", $row);

			$def = $row['cms_news_parent'];
			$ltitle_form = $this->config->item("lmodify_news_list");

		}
		else
		{
			$ltitle_form = $this->config->item("ladd_news_list");
			$def = 0;
		}
		$this->mysmarty->assign("ltitle_form", $ltitle_form);

		$this->mysmarty->assign("category_desc", $this->config->item("category_desc"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("category_name", $this->config->item("category_name"));
		$this->mysmarty->assign("ok_save_category_jabatan", $edit ? $this->config->item("ok_update_category_jabatan") : $this->config->item("ok_add_category_jabatan"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("act", $act);
		$this->mysmarty->assign("lparent", $this->config->item("lparent"));
		$this->mysmarty->assign("lroot", $this->config->item("lroot"));
		$this->mysmarty->assign("type", 0);

		$this->mysmarty->assign("left_content", "user/menu_admin_news.html");
		$this->mysmarty->assign("main_content", "user/formadminnews.html");
		$this->mysmarty->display("sess_template.html");
	}

	function savecmsnews($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$news_title = isset($_POST['news_title']) ? trim($_POST['news_title']) : "";
		$news_desc = isset($_POST['news_desc']) ? trim($_POST['news_desc']) : "";
		$news_void = !empty($_POST['news_void']) ? trim($_POST['news_void']) : 0;

		$errs = array();
		if (strlen($news_title) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("news_title", addslashes($news_title));
			$q = $this->db->get("cms_news");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->news_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
				}
			}

		}

		//echo count($errs);
		//echo "\1";

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		unset($data);

		if (isset($_FILES['news_image']) && $_FILES['news_image']['name'] && $_FILES['news_image']['size'])
		{
			//print_r($_FILES); exit();
			move_uploaded_file($_FILES['news_image']['tmp_name'], BASEPATH."/../uploads/cms_news/".$_FILES['news_image']['name']);
			$_POST['news_image'] = $_FILES['news_image']['name'];
			$data['news_image'] = addslashes($_POST['news_image']);
		}

		$data['news_title'] = addslashes($news_title);
		//$data['news_desc'] = addslashes($news_desc);
		$data['news_desc'] = $news_desc;
		$data['news_void'] = $news_void;

		if ($edit)
		{						
			$this->db->flush_cache();
			$this->db->where("news_id", $edit);
			
			$this->db->update("cms_news", $data);
		}
		else
		{			
			$data['news_entrydate'] = strtotime(date('Y-m-d'));
			$data['news_entryuser'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("cms_news", $data);
		}

		$rdct = base_url() . 'index.php/user/admin_news';
		redirect($rdct);
		exit();
	}

	function changestatuscmsnews($id, $status)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$childs = array($id);
		
		$data['news_void'] = empty($status) ? 1 : 0;
		
		$this->db->where_in("news_id", $childs);
		$this->db->update("cms_news", $data);
	}

	function deletecmsnews($id)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$childs = array($id);
		
		$data['news_void'] = empty($status) ? 1 : 0;
		
		$this->db->where_in("news_id", $childs);
		$this->db->delete("cms_news");

		redirect(site_url(array("user", "admin_news")));
	}

	private function own_get_bawahan($arr_npk_atasan, &$result_npk_atasan) {
		if(empty($arr_npk_atasan)) return;

		$this->db->select("user_npk, user_npk_atasan");
		$this->db->where_in('user_npk_atasan', $arr_npk_atasan);
		$q = $this->db->get("user");
		$list = $q->result_array();

		if ($q->num_rows() == 0) return;

		$arr_npk_atasan = array();
		foreach ($list as $value) {
			$result_npk_atasan[$value['user_npk_atasan']] = $value['user_npk_atasan'];
			$arr_npk_atasan[] = $value['user_npk'];
		}

		if(!empty($arr_npk_atasan)) {
			$this->own_get_bawahan($arr_npk_atasan, $result_npk_atasan);
		} else {
			return;
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
