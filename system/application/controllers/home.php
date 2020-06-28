<?php

include_once "base.php"; 
class Home extends Base {
	var $langue;
	var $settings;
	var $sess;

	function Home()
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
			$this->modules = $this->commonmodel->getRight($sess['user_type']);
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
	
	function index($page = 1)
	{
		$cms_show_admin_news = $this->settings['cms_show_admin_news'];
		$cms_news_per_page = $this->settings['cms_news_per_page'];

		$cms_news_per_page = !empty($cms_news_per_page) ? $cms_news_per_page : 5; //default 5 rows per page

		if(!empty($cms_show_admin_news)) {
			$limit = $cms_news_per_page;
			$page = !empty($page) ? $page : 1;
			$offset = ($page - 1) * $limit;

			$this->db->select("*, DATE_FORMAT( FROM_UNIXTIME( news_entrydate ) ,  '%d-%m-%Y' ) AS entrydate, CONCAT('".(base_url() . 'uploads/cms_news/')."', news_image) AS url_image", false);
			$this->db->where("news_void != ''");
			$this->db->limit($limit, $offset);
			$this->db->order_by('news_id', 'DESC');
			$q = $this->db->get("cms_news");
			$list = $q->result();

			$cnt = 1;
            $splitNo = 0;
            $splitList = array();
			foreach ($list as $key => $value) {
			    $urlNewsDetail = site_url(array("home", "newsdetail"));
				$list[$key]->news_desc = nl2br($value->news_desc);
                $list[$key]->news_desc = $this->trim_text($list[$key]->news_desc, 250);
                $list[$key]->news_desc .= ' <a href="'.$urlNewsDetail.'/'.$value->news_id.'">[read more]</a>';
                $splitList[$splitNo][] = $list[$key];
                if($cnt > 1 AND ($cnt % 2 == 0)) {
                    $splitNo += 1;
                }
                $cnt++;
			}

			//print_r($splitList);

			$this->db->where("news_void != ''");
			$total = $this->db->count_all_results("cms_news");

			$has_more_page = (($total - ((($page - 1) * $limit) + count($list))) >= $limit) ? true : false;

			$paging_list = '';
			if($page == 1 AND ($total > $limit)) {
				$paging_list .= '<li class="older full-size"><a href="'.site_url('home/index').'/'.($page + 1).'" rel="prev">More&nbsp;News</a></li>';
			} 

			if ($page > 1 AND $has_more_page) {
				$paging_list .= '<li class="older"><a href="'.site_url('home/index').'/'.($page + 1).'" rel="prev">Prev&nbsp;News</a></li>';
				$paging_list .= '<li class="newer"><a href="'.site_url('home/index').'/'.($page - 1).'" rel="next">Next&nbsp;News</a></li>';
			}

			if ($page > 1 AND !$has_more_page) {
				$paging_list .= '<li class="newer full-size"><a href="'.site_url('home/index').'/'.($page - 1).'" rel="Next">Next&nbsp;News</a></li>';
			}

			$this->mysmarty->assign("paging_list", $paging_list);
		}

		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{			
			$loginbyemail = $this->settings['loginbyemail'];

			$this->mysmarty->assign("loginbyemail", $loginbyemail);
			$this->mysmarty->assign("lexpired_password", $this->config->item('lexpired_password'));
			$this->mysmarty->assign("password", $this->config->item('password'));
			$this->mysmarty->assign("forgot_password", $this->config->item('forgot_password'));
			$this->mysmarty->assign("main_content", "user/login.html");
			$this->mysmarty->assign("referrer", $this->session->userdata('referrer') ? $this->session->userdata('referrer') : base_url());

			$this->mysmarty->assign("websiteloginword1", $this->getWebsiteLoginWord1());
			$this->mysmarty->assign("websiteloginword2", $this->getWebsiteLoginWord2());
			$this->mysmarty->assign("pageloginimage", $this->getPageLoginImage());

			if(!empty($cms_show_admin_news)) {
				$this->mysmarty->assign("list", $list);
                $this->mysmarty->assign("splitList", $splitList);
			
				$this->mysmarty->display("sess_template_login.html");
			} else {
				$this->mysmarty->display("sess_template_login_ori.html");
			}
			return;
		} else {
			if(!empty($cms_show_admin_news)) {
				$ol_activities = $this->ol_activities();
				$oc_activities = $this->oc_activities();
				$or_activities = $this->or_activities();

				$this->mysmarty->assign("list", $list);
                $this->mysmarty->assign("splitList", $splitList);

				$this->mysmarty->assign("ol_activities", $ol_activities);
				$this->mysmarty->assign("oc_activities", $oc_activities);
				$this->mysmarty->assign("or_activities", $or_activities);

				$this->mysmarty->assign("show_learning_catalog", $this->settings['show_learning_catalog']);
				
				$this->mysmarty->assign("file_learning_catalog", $this->settings['file_learning_catalog']);
				
				$this->mysmarty->display("sess_template_home.html");
			} else {
				redirect(site_url(array("user", "info")));
			}
			
		}
		
		//redirect(site_url(array("user", "info")));
	}

	function getWebsiteLoginWord1()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "websiteloginword1");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return '';		
		}
		
		$row = $q->row();
		return $row->general_setting_value;
	}

	function getWebsiteLoginWord2()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "websiteloginword2");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return '';		
		}
		
		$row = $q->row();
		return $row->general_setting_value;
	}

	function getPageLoginImage()
	{
		$this->db->flush_cache();
		$this->db->where("general_setting_code", "pageloginimage");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0)
		{
			return '';		
		}
		
		$row = $q->row();
		return $row->general_setting_value;
	}
	
	function forgotpass()
	{
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lemail", $this->config->item("lemail"));
		
		$this->mysmarty->assign("forgot_password", $this->config->item("forgot_password"));
		$this->mysmarty->assign("email", $this->config->item("email"));
		
		$this->mysmarty->assign("main_content", "user/forgot.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function doforgotpass()
	{
		$field = isset($_POST['field']) ? trim($_POST['field']) : "";
		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : "";
		
		$errs = array();
		if (strlen($keyword) == 0)		
		{
			switch($field)
			{
				case "email":
					$errs[] = $this->config->item("err_empty_email");	
				break;
				default:
					$errs[] = $this->config->item("err_empty_npk");	
			}
			
		}
		else
		if ($field == "email")
		{
			if (! valid_email($keyword))
			{
				$errs[] = $this->config->item("err_invalid_email");
			}
			else
			{			
				$this->db->where("user_email", addslashes($keyword));
				$q = $this->db->get("user");			
				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("email_not_in_db");
				}
				else
				{
					$row = $q->row();
					$email = $row->user_email;
				}
			}
		}
		else
		{
				$this->db->where("user_npk", addslashes($keyword));
				$q = $this->db->get("user");			
				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("err_not_already_exist_npk");
				}
				else
				{
					$row = $q->row();
					if (! valid_email($row->user_email))
					{
						$errs[] = $this->config->item("err_invalid_email");
					}
					else
					{
						$email = $row->user_email;
					}					
				}
		}
		
		if (count($errs) == 0)
		{
			if (isset($this->settings['mailtype']) && ($this->settings['mailtype'] == "smtp"))
			{
				$config['protocol'] = "smtp";
				
				$config['smtp_host'] = $this->settings['smtphost'];
				$config['smtp_user'] = $this->settings['smtpuser'];
				$config['smtp_pass'] = $this->settings['smtppass'];
				$config['smtp_port'] = (isset($this->settings['smtpport']) && $this->settings['smtpport']) ? $this->settings['smtpport'] : 25;
			}
			else
			{
				$config['protocol'] = "mail";
			}	
			
			$config['mailtype'] = (isset($this->settings['mailcontenttype']) && $this->settings['mailcontenttype']) ? $this->settings['mailcontenttype'] : "html";
		
			$mailsender = isset($this->settings['remindermailsender']) ? $this->settings['remindermailsender'] : $this->config->item("admin_mail");
			$sendername = isset($this->settings['remindermailsendername']) ? $this->settings['remindermailsendername'] : "";
		
		
			$uniqid = substr(md5(uniqid()), 0, 100);
			
			$this->mysmarty->assign("confirm_pass_url", site_url(array("home", "resetpass", $uniqid)));
			
			$lang = $this->langue ? "id" : "en";
			$message = $this->mysmarty->fetch("user/".$lang."/email-forgot-password.html");
	
			$this->email->initialize($config);		
			$this->email->from($mailsender, $sendername);		
			$this->email->to($email);
			$this->email->subject($this->config->item("password_resetter_mail_subject"));
			$this->email->message($message);
			$send = $this->email->send();			
			if (! $send)
			{
				$errs[] = $this->config->item("send_mail_failed");
			}
			else
			{
				unset ($data);
				
				$data['user_forgotpass_confirm'] = $uniqid;
				$data['user_forgotpass_date'] = date("Ymd");
				
				$this->db->where("user_id", $row->user_id);
				$this->db->update("user", $data);
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
	
	function resetpass()
	{
		//unset session referrer
		$this->session->unset_userdata(array('referrer'=>''));

		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("user_forgotpass_confirm", $id);
		$q = $this->db->get("user");
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
				
		$this->mysmarty->assign("new_password", $this->config->item("new_password"));
		$this->mysmarty->assign("confirm_new_password", $this->config->item("confirm_new_password"));
		$this->mysmarty->assign("user", $q->row());		
		$this->mysmarty->assign("reset", 1);
		$this->mysmarty->assign("ok_change_pass", $this->config->item("ok_change_pass"));		
		$this->mysmarty->assign("main_content", "user/changepass.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function setlang()
	{
		$lang = isset($_POST['lang']) ? $_POST['lang'] : "id";
		
		$this->session->set_userdata("lms_lang", $lang);
	}
	
	function migrasi($pass)
	{		
		$encpass = md5("adilahsoft".date('Ymd'));
		if ($encpass != $pass)
		{
			//die("Invalid password");
		}
		
		$this->load->model("logmodel");
		$this->logmodel->init("migrasi");
		
		// hirarki ver 2
		
		$q = $this->db->get("level_group");
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$groups[$rows[$i]->level_group_nth][$rows[$i]->level_group_name] = $rows[$i];
		}		
		
		// hirarki ver 1
		
		$db = $this->load->database("lmsv1", TRUE);			
		
		$sql = "SELECT *
			FROM			user_group t1
			LEFT OUTER JOIN		departement t2 ON t2.id_dept = t1.id_dept
			LEFT OUTER JOIN		grup t3 ON t3.grup_id = t2.dept_group
			LEFT OUTER JOIN		direktorat t4 ON t4.direktorat_id = t3.grup_direktorat
		";
				
		$q = $db->query($sql);
		
		$rows = $q->result();
		
		$dbdef = $this->load->database("default", TRUE);
		
		for($i=0; $i < count($rows); $i++)
		{
			// direkrorat migrasi
			
			if (isset($groups[1][$rows[$i]->direktorat_nama]))
			{
				$directoratid = $groups[1][$rows[$i]->direktorat_nama]->level_group_id;
			}
			else
			{
				unset($data);
				
				$data['level_group_name'] = $rows[$i]->direktorat_nama;
				$data['level_group_parent'] = 0;
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = 1;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;
											
				$dbdef->insert("level_group", $data);
				$directoratid = $dbdef->insert_id();
				
				$this->logmodel->append("insert directorat: ".$rows[$i]->direktorat_nama);
			}
			
			// grup migrasi
			
			if (isset($groups[2][$rows[$i]->grup_nama]))
			{
				$groupid = $groups[2][$rows[$i]->grup_nama]->level_group_id;
			}
			else
			{
				unset($data);
				
				$data['level_group_name'] = $rows[$i]->grup_nama;
				$data['level_group_parent'] = $directoratid;
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = 2;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;
				
				
				$dbdef->insert("level_group", $data);								
				$groupid = $dbdef->insert_id();
				
				$this->logmodel->append("insert grup: ".$rows[$i]->grup_nama);
			}
			
			// department migrasi
			
			if (isset($groups[3][$rows[$i]->nm_dept]))
			{
				$deptid = $groups[3][$rows[$i]->nm_dept]->level_group_id;
			}
			else
			{
				unset($data);
				
				$data['level_group_name'] = $rows[$i]->nm_dept;
				$data['level_group_parent'] = $groupid;
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = 3;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;
				
				$dbdef->insert("level_group", $data);
				$deptid = $dbdef->insert_id();
				
				$this->logmodel->append("insert department: ".$rows[$i]->nm_dept);
			}
			
			// unit migrasi
			
			if (isset($groups[4][$rows[$i]->nm_group]))
			{
				$unitid = $groups[4][$rows[$i]->nm_group]->level_group_id;
			}
			else
			{
				unset($data);
				
				$data['level_group_name'] = $rows[$i]->nm_group;
				$data['level_group_parent'] = $deptid;
				$data['level_group_status'] = 1;
				$data['level_group_nth'] = 4;
				$data['level_group_created'] = date("Ymd");
				$data['level_group_creator'] = 0;
				
				$dbdef->insert("level_group", $data);
				$unitid = $dbdef->insert_id();
				
				$this->logmodel->append("insert unit: ".$rows[$i]->nm_group);
			}									
		}
	}

	private function ol_activities() {
		$day_periodic = $this->settings['cms_activity_periodic'];
		$day_periodic = !empty($day_periodic) ? $day_periodic : 0;

		$sql = "SELECT DATE_FORMAT( training_created_date ,  '%d-%m-%Y' ) AS entrydate, CONCAT('".(base_url() . 'index.php/training/showlist/')."', category_id) AS url_link, category_id, category_name, training_name, CASE category_status WHEN 1 THEN 'Aktif' ELSE 'Tidak Aktif' END category_status_desc 
		FROM lmsv2_category 
		INNER JOIN lmsv2_training ON (training_topic = category_id) 
		INNER JOIN lmsv2_training_npk ON (training_id = training_npk_training)
		WHERE training_type = 1 AND category_status = 1 AND category_type = 1 AND category_parent <> 0 AND training_npk_npk = '".$this->sess['user_id']."'";

		if(!empty($day_periodic)) $sql .= " AND DATEDIFF(CURDATE(), DATE_FORMAT( training_created_date ,  '%Y-%m-%d' )) <= " . $day_periodic;

		$q = $this->db->query($sql);

		$list = $q->result();
		return $list;
	}

	private function oc_activities() {
		$day_periodic = $this->settings['cms_activity_periodic'];
		$day_periodic = !empty($day_periodic) ? $day_periodic : 0;

		$sql = "SELECT DATE_FORMAT( training_created_date ,  '%d-%m-%Y' ) AS entrydate, CONCAT('".(base_url() . 'index.php/certificate/showlist/')."', category_id) AS url_link, category_id, category_name, training_name, CASE category_status WHEN 1 THEN 'Aktif' ELSE 'Tidak Aktif' END category_status_desc 
		FROM lmsv2_category 
		INNER JOIN lmsv2_training ON (training_topic = category_id) 
		INNER JOIN lmsv2_training_npk ON (training_id = training_npk_training)
		WHERE training_type = 2 AND category_status = 1 AND category_type = 1 AND category_parent <> 0 AND training_npk_npk = '".$this->sess['user_id']."'";

		if(!empty($day_periodic)) $sql .= " AND DATEDIFF(CURDATE(), DATE_FORMAT( training_created_date ,  '%Y-%m-%d' )) <= " . $day_periodic;

		$q = $this->db->query($sql);

		$list = $q->result();
		return $list;
	}

	private function or_activities() {
		$day_periodic = $this->settings['cms_activity_periodic'];
		$day_periodic = !empty($day_periodic) ? $day_periodic : 0;

		/*
		$sql = "SELECT DATE_FORMAT( training_created_date ,  '%d-%m-%Y' ) AS entrydate, CONCAT('".(base_url() . 'index.php/resources/index/')."', category_id) AS url_link, category_id, category_name, training_name, CASE category_status WHEN 1 THEN 'Aktif' ELSE 'Tidak Aktif' END category_status_desc 
		FROM lmsv2_category 
		INNER JOIN lmsv2_training ON (training_topic = category_id) 
		INNER JOIN lmsv2_training_npk ON (training_id = training_npk_training)
		INNER JOIN lmsv2_reference ON (reference_topic = training_topic)
		WHERE reference_status <> 0 AND training_type = 4 AND category_status = 1 AND category_type = 1 AND category_parent <> 0 AND training_npk_npk = '".$this->sess['user_id']."'";

		if(!empty($day_periodic)) $sql .= " AND DATEDIFF(CURDATE(), DATE_FORMAT( training_created_date ,  '%Y-%m-%d' )) <= " . $day_periodic;

		$sql .= " GROUP BY category_id";
		*/

		$sql = "SELECT DATE_FORMAT( reference_created ,  '%d-%m-%Y' ) AS entrydate, reference_name, CONCAT('".(base_url() . 'index.php/resources/download/')."', history_reference_reference) AS url_link FROM lmsv2_history_reference JOIN lmsv2_reference ON (reference_id = history_reference_reference) WHERE history_reference_user = '".$this->sess['user_id']."' GROUP BY reference_id";

		$q = $this->db->query($sql);

		$list = $q->result();
		return $list;
	}

	function create_event() {
		$data = array(
			'evnt_title' => $_POST['event_name'],
			'evnt_desc' => $_POST['event_desc'],
			'evnt_date' => $_POST['event_date'],
			'evnt_entrydate' => date('Y-m-d'),
			'evnt_entryuser' => $this->sess['user_id'],
		);

		$res = $this->db->insert('events', $data);

		redirect(site_url());
	}

	private function trim_text($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

    public function newsdetail($id = '') {
        $this->db->select("*, DATE_FORMAT( FROM_UNIXTIME( news_entrydate ) ,  '%d-%m-%Y' ) AS entrydate, CONCAT('".(base_url() . 'uploads/cms_news/')."', news_image) AS url_image", false);
        $this->db->where("news_id = " . $id);
        $q = $this->db->get("cms_news");
        $rows = $q->row();
//        print_r($rows);

        $this->mysmarty->assign("rows", $rows);
        $this->mysmarty->display("sess_template_news.html");

    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */