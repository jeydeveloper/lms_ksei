<?php

include_once "base.php"; 
class ILDP extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDP()
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
		$this->load->model("topicmodel");		
		$this->load->model("ildpmodel");
		$this->load->model("ildpcategorymodel");
		
		$this->load->database();	
		
		$this->language = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->language ? $this->language : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->language);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
				
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$this->session->set_userdata(array("referrer"=>current_url()));
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));
			
			$this->sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($this->sess['user_type']);
		}		

		if(! isset($this->modules['ildpadmin']))
		{
			redirect('user');
			exit;
		} 
		
		if(! $this->modules['ildpadmin'])
		{
			redirect('user');
			exit;
		} 
		
		$this->carts = $this->session->userdata('ildp');
		if (! $this->carts)
		{
			$this->ildpmodel->loaddraft($this->sess['user_id']);
			$this->carts = $this->session->userdata('ildp');
		}
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}		
		
		$this->langmodel->init();
		
	}
	
	function category()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $this->config->item('data_per_page');
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "ildp_category_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		
		
		$sess = unserialize($usess);

		if (! isset($this->modules['ildpadmin']))
		{
			redirect(base_url());
		}
						
		if ($keyword && $searchby)
		{
			$this->db->where("UPPER(ildp_category_name) LIKE", "%".strtoupper($keyword)."%");
			$q = $this->db->get("ildp_category");
			$this->db->flush_cache();
			
			$rowcategories = $q->result();
			
			$categoryids[] = 0;
			for($i=0; $i < count($rowcategories); $i++)
			{				
				$categoryids[] = $rowcategories[$i]->ildp_category_id;
				
				$this->ildpcategorymodel->getParentIds($rowcategories[$i]->ildp_category_id, $categoryids);
			}			
			
			$categoryids = array_unique($categoryids);			
		}				

		$trees = array();				
		$this->ildpcategorymodel->getArrayTree($trees, 0, $sortby, $orderby, isset($categoryids) ? $categoryids : false);
		
		$used = $this->ildpcategorymodel->getUsed();
		
		$s = "";
		$this->itot = 0;
		$this->showListCategory($s, $trees, 0, $used);
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("header_list_category", $this->config->item('header_list_category'));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("category_list", ucfirst($this->config->item('category_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
							
		$this->mysmarty->assign("tree_html", $s);
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/list.html");
		$this->mysmarty->display("sess_template.html");		
		
	}
	
	function topic($id=0)
	{
		if ($id == 0)
		{
			redirect(site_url('topic'));
		}
		
		$this->mysmarty->assign("topicid", $id);
		$this->index($id, "topic");
	}
	
	function cart()
	{				
		if (! isset($this->carts))
		{
			redirect(site_url(array("ildp", "topic")));
		}
		if (! is_array($this->carts))
		{
			redirect(site_url(array("ildp", "topic")));
		}
		
		if (count($this->carts) == 0)
		{
			redirect(site_url(array("ildp", "topic")));
		}
		
		$this->index(0, "cart");
	}
	
	function index($topicid=0, $referer="", $userid=0)
	{				
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
		
		if ($referer == "approval")
		{
			// klo admin gak usah dicek validasi
			if (! $this->sess['asadmin'])
			{				
				// disini harus validasi
				if (! $this->ildpmodel->isValidApproval($userid, $this->topicmodel))
				{
					redirect(base_url());
				}
			}
		}
		else
		if ($referer == "myform")
		{
			// get delegator
			
			$this->db->where('delegetion_ildp_delegator', $this->sess['user_id']);
			$this->db->where('delegetion_ildp_status', 1);
			$q = $this->db->get("delegetion_ildp");
			
			$rows = $q->result();
			
			$delegator[] = $this->sess['user_id'];
			for($i=0; $i < count($rows); $i++)
			{
				$delegator[] = $rows[$i]->delegetion_ildp_user;
			}
			
			if (! $this->sess['asadmin'])
			{
				$this->db->where_in("order_user", $delegator);
			}
			$this->db->where("order_id", $userid);
			$total = $this->db->count_all_results("order");
			
			if ($total == 0) 
			{
				// cek apakah dari approval hist
				
				$orderids = $this->ildpmodel->getApprovalHist();
				
				$this->db->where_in("order_id", $orderids);
				$this->db->join("user", "order_user = user_id");
				$total = $this->db->count_all_results("order");
				
				if ($total == 0)
				{				
					redirect(base_url());
				}
			}
		}
		
		if ($topicid)
		{
			$this->db->where("category_id", $topicid);
			$q = $this->db->get("category");
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowtopic = $q->row();
			
			$this->mysmarty->assign("rowtopic", $rowtopic);
		}
		
		if ($referer == "approval")
		{
			$this->db->where("user_id", $userid);
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
			$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
			$q = $this->db->get("user");
			
			$rowuser = $q->row();
		}
		else
		if ($referer == "myform")
		{
			$this->db->where("order_id", $userid);
			$this->db->join("user", "user_id = order_user");
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
			$this->db->join("lokasi", "lokasi_id = user_location", "left outer");			
			$q = $this->db->get("order");
			
			$rowuser = $q->row();
			
			$this->db->where("order_id", $userid);
			$this->db->join("order_catalog_report", "order_catalog_report_catalog = order_id");
			$this->db->join("user", "user_id = order_catalog_report_user");
			$q = $this->db->get("order");
			
			$rowreporters = $q->result();
			for($i=0; $i < count($rowreporters); $i++)
			{
				$t = dbmaketime($rowreporters[$i]->order_catalog_report_approved);
				$rowreporters[$i]->order_catalog_report_approved_fmt = date("d/m/Y H:i:s", $t);
				$reporters[$rowreporters[$i]->order_catalog_report_user] = $rowreporters[$i];
			}			
		}		
		else 
		{					
			$roworder = $this->ildpmodel->isdraft($this->sess['user_id']);
			
			$this->db->where("user_id", $this->sess['user_id']);
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
			$this->db->join("lokasi", "lokasi_id = user_location", "left outer");
						
			if ($roworder)
			{
				$this->db->where("order_id", $roworder->order_id);
				$this->db->join("order", "order_user = user_id");	
			}
			
			$q = $this->db->get("user");
			
			$rowuser = $q->row();			
		}
		
		$cats = array();
		$this->levelmodel->getparentlevelgroups($rowuser->jabatan_level_group, $cats);
			
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("lapproval_form", $this->config->item("lapproval_form"));
		$this->mysmarty->assign("orderid", $userid);
		$this->mysmarty->assign("user", $rowuser);
		$this->mysmarty->assign("cats", array_reverse($cats));
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("ldept", $this->config->item("department"));		
		$this->mysmarty->assign("lunit", $this->config->item("unit"));		
		$this->mysmarty->assign("lphone", $this->config->item("lphone"));
		$this->mysmarty->assign("lmobile", $this->config->item("lmobile"));
		$this->mysmarty->assign("lclassroom_catalog_list", $this->config->item("lclassroom_catalog_list"));
		$this->mysmarty->assign("lheader_catalog_list", $this->config->item("lheader_catalog_list"));
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));		
		$this->mysmarty->assign("lcategory", $this->config->item("category"));		
		$this->mysmarty->assign("ltopic", $this->config->item("topic"));		
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));		
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));		
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));		
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));		
		$this->mysmarty->assign("lildp_form", $this->config->item("lildp_form"));		
		$this->mysmarty->assign("limit", $recordperpage);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("referer", $referer);		
		$this->mysmarty->assign("lpart1_cart", $this->config->item("lpart1_cart"));
		$this->mysmarty->assign("lpart2_cart", $this->config->item("lpart2_cart"));
		$this->mysmarty->assign("lpart3_cart", $this->config->item("lpart3_cart"));
		$this->mysmarty->assign("lemployee", $this->config->item("lemployee"));
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("ljob_title", $this->config->item("ljob_title"));		
		$this->mysmarty->assign("ladd_to_ildp_form", $this->config->item("ladd_to_ildp_form"));		
		$this->mysmarty->assign("lmy_ildp_form", $this->config->item("lmy_ildp_form"));		
		$this->mysmarty->assign("lildp_subtitle", $this->config->item("lildp_subtitle"));
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
					
		
		if ($this->sess['asadmin'] && ($referer == "approval"))
		{
			$this->mysmarty->assign("left_content", "ildp/menu.html");
		}
		else
		if (($referer == "approval") || ($referer == "myform"))
		{
			if ($this->sess['asadmin'])
			{
				$this->mysmarty->assign("left_content", "ildp/menu.html");
			}
			else
			{
				$this->mysmarty->assign("left_content", "user/menu.html");
			}
		}
		else
		if ($referer == "topic")
		{
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "ildp/menu.html");			
		}
		
		$this->mysmarty->assign("main_content", "ildp/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search($offset=0)
	{
		$referer = isset($_POST['referer']) ? $_POST['referer'] : "";
		$orderer = isset($_POST['orderer']) ? $_POST['orderer'] : "";
		$orderid = isset($_POST['orderid']) ? $_POST['orderid'] : "";

		if ($this->sess['user_type'] != 0)
		{
			if ($this->sess['asadmin'])
			{
				redirect(base_url());
			}
			
			if (! isset($this->modules['trainee']))
			{
				redirect(base_url());
			}
			
			if (! $this->modules['trainee'])
			{
				redirect(base_url());
			}
		}
		
		$regtime = $this->ildpmodel->isRegistrationTime($this->sess['user_id']);
		if ($referer != "approval")
		{						
			if (! $regtime)
			{				
				if (($this->sess['asadmin'] != 1) && ($referer != "myform"))
				{
					$callback['html'] = "";
					echo json_encode($callback);
					return;
				}
			}	
		}
		
		if ($referer == "cart")
		{
			$this->db->where("order_user", $this->sess['user_id']);
			$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
			$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));
			$q = $this->db->get("order");
			
			if ($q->num_rows() == 0)
			{
				// baru
				$reportto = array();
				$this->ildpmodel->atasan($this->sess['user_npk_atasan'], $reportto);
				
				$this->mysmarty->assign("reportto", $reportto);
			}
			else
			{	
				// draft
				
				$rowcatorder = $q->row();
				
				$this->db->order_by("order_catalog_report_order", "asc");
				$this->db->where("order_catalog_report_catalog", $rowcatorder->order_id);				
				$this->db->join("user", "user_id = order_catalog_report_user");
				$this->db->join("jabatan", "jabatan_id = user_jabatan");
				$q = $this->db->get("order_catalog_report");	
				
				$this->mysmarty->assign("reportto", $q->result());							
			}				
		}
		
		if ($referer == "myform")
		{			
			$this->db->where("order_id", $orderid);
			$this->db->join("order_catalog", "order_catalog_order = order_id");
			$q = $this->db->get("order");
			
			$this->mysmarty->assign("myorder", $orderid);
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
						
			$roworders = $q->result();
			
			$catalogs[] = 0;			
			for($i=0; $i < count($roworders); $i++)
			{
				$catalogs[] = $roworders[$i]->order_catalog_catalog;
				$catalog_period[$roworders[$i]->order_catalog_catalog] = $roworders[$i]->order_catalog_period;
				$catalog_status[$roworders[$i]->order_catalog_catalog] = $roworders[$i]->order_catalog_status;
				$catalog_id[$roworders[$i]->order_catalog_catalog] = $roworders[$i]->order_catalog_id;
			}
			
			// approved
			
			$this->db->order_by("order_catalog_report_order", "asc");
			$this->db->where("order_id", $orderid);
			$this->db->join("order_catalog_report", "order_catalog_report_catalog = order_id");
			$this->db->join("user", "user_id = order_catalog_report_user");
			$this->db->join("jabatan", "jabatan_id = user_jabatan");
			$q = $this->db->get("order");
			
			$rowreporters = $q->result();
			for($i=0; $i < count($rowreporters); $i++)
			{
				$t = dbmaketime($rowreporters[$i]->order_catalog_report_approved);
				$rowreporters[$i]->order_catalog_report_approved_fmt = date("d/m/Y H:i:s", $t);
			}		
			
			$this->mysmarty->assign("rowreporters", $rowreporters);		
			
			if ($roworders[0]->order_status > 2)
			{
				
				$this->db->where("user_id", $roworders[0]->order_hrrm);
				$this->db->join("jabatan", "jabatan_id = user_jabatan");
				$q = $this->db->get("user");
				
				if ($q->num_rows() > 0)
				{
					$rowhrrm = $q->row();
					
					$this->mysmarty->assign("rowhrrm", $rowhrrm);
					$this->mysmarty->assign("ishrrmapproved", true);
				}												
			}
			
			if ($roworders[0]->order_status > 3)
			{
				
				$this->db->where("user_id", $roworders[0]->order_hrld);
				$this->db->join("jabatan", "jabatan_id = user_jabatan");
				$q = $this->db->get("user");
				
				if ($q->num_rows() > 0)
				{
					$rowhrrm = $q->row();
					
					$this->mysmarty->assign("rowhrld", $rowhrrm);
					$this->mysmarty->assign("ishrldapproved", true);
				}												
			}			
		}				
		
		if ($referer == "approval")
		{				
			// ambil order terakhir
						
			$this->db->order_by("order_date", "desc");
			$this->db->where("order_user", $orderer);
			$this->db->limit(1);
			$q = $this->db->get("order");
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$myroworder = $q->row();
			
			$this->mysmarty->assign("myorder", $myroworder->order_id);
			if ($myroworder->order_status > 1)
			{
				$this->mysmarty->assign("hasapproved", true);
			}
					
			$catalogs[] = 0;

			// get delegator
			
			$this->db->where('delegetion_ildp_delegator', $this->sess['user_id']);
			$this->db->where('delegetion_ildp_status', 1);
			$q = $this->db->get("delegetion_ildp");
			
			$rows = $q->result();
			
			$delegator[] = $this->sess['user_id'];
			for($i=0; $i < count($rows); $i++)
			{
				$delegator[] = $rows[$i]->delegetion_ildp_user;
			}

			$this->db->where("order_id", $myroworder->order_id);
			$this->db->where("order_status", 1);
			$this->db->where("order_catalog_report_status", 0);
			if (! $this->sess['asadmin'])
			{
				$this->db->where_in("order_catalog_report_user", $delegator);
			}
			$this->db->join("order_catalog", "order_catalog_order = order_id");
			$this->db->join("order_catalog_report", "order_catalog_report_catalog = order_id");
			$q = $this->db->get("order");

			if ($q->num_rows() > 0)
			{	
				$this->mysmarty->assign("hasapproved", true);		
				$rowscatalog = $q->result();
						
				for($i=0; $i < count($rowscatalog); $i++)
				{
					$catalogs[] = $rowscatalog[$i]->order_catalog_catalog;
					$catalog_period[$rowscatalog[$i]->order_catalog_catalog] = $rowscatalog[$i]->order_catalog_period;
					$catalog_status[$rowscatalog[$i]->order_catalog_catalog] = $rowscatalog[$i]->order_catalog_status;
					$catalog_rejected[$rowscatalog[$i]->order_catalog_catalog] = $rowscatalog[$i]->order_catalog_rejected;
				}						
			}
			
			// HRRM
			
			$groups = $this->ildpmodel->getHRRM($delegator, $this->levelmodel);
			if (count($groups))
			{
				$this->db->distinct();
				$this->db->where("order_status", 2);
				$this->db->where_in("jabatan_level_group", $groups);
				$this->db->join("order_catalog", "order_id = order_catalog_order");
				$this->db->join("training", "training_id = order_catalog_catalog");
				$this->db->join("user", "order_user = user_id");
				$this->db->join("jabatan", "user_jabatan = jabatan_id");
				$q = $this->db->get("order");			
				
				$rowhrrms = $q->result();		
				for($i=0; $i < count($rowhrrms); $i++)
				{
					$catalogs[] = $rowhrrms[$i]->training_id;
					$catalog_period[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_period;
					$catalog_status[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_status;
					$catalog_rejected[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_rejected;
				}	

			}			
			
			// HRLD
			
			$categories = $this->ildpmodel->getHRLDTopic($delegator, $this->topicmodel);
			if (count($categories))
			{								
				$this->db->where("order_user", $orderer);
				$this->db->where_in("training_topic", $categories);
				$this->db->join("order_catalog", "order_id = order_catalog_order");
				$this->db->join("training", "training_id = order_catalog_catalog");
				$q = $this->db->get("order");
				
				$rowhrrms = $q->result();
				
				for($i=0; $i < count($rowhrrms); $i++)
				{
					$catalogs[] = $rowhrrms[$i]->training_id;
					$catalog_period[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_period;
					$catalog_status[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_status;
					$catalog_rejected[$rowhrrms[$i]->order_catalog_catalog] = $rowhrrms[$i]->order_catalog_rejected;
				}	
			}

			if (count($catalogs) == 1)
			{
				redirect(base_url());
			}						
		}
		
		if (($referer == "approval") || ($referer == "myform") || ($referer == "cart"))
		{
			if ($referer == "approval")
			{
				$this->db->where("order_user", $orderer); 
				$this->db->where("order_date >=", date("Y-m-d H:i:s", $regtime[0]));
			}
			else
			if ($referer == "myform")
			{
				$this->db->where("order_id", $roworders[0]->order_id);
			}
			else
			{
				$this->db->where("order_user", $orderer);
				$this->db->where("order_status", 0);
				$this->db->where("order_date >=", date("Y-m-d H:i:s", $regtime[0]));
			}
						
			$this->db->join("order", "order_id = externaldata_order");
			$q = $this->db->get("order_externaldata");
			
			$rows = $q->result();			
			$this->mysmarty->assign("orderextdata", $rows);		
		}

		$year1 = date("Y", $regtime[0]);
		$month2 = date("n", $regtime[1]);
		$year2 = date("Y", $regtime[1]);
		
		$gmonths = $this->config->item("lmonths");
		
		if ($year2 != $year1)
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".$year2;
			}
		}
		else
		if ($month2 >= $this->config->item("month_year"))
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".($year1+1);
			}				
		}
		else
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".$year2;
			}
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "training_code";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$topicid = isset($_POST['topicid']) ? $_POST['topicid'] : "";		
				
		$this->mysmarty->assign("lnpk", $this->config->item("lnpk"));
		$this->mysmarty->assign("lchange_this", $this->config->item("lchange_this"));
		$this->mysmarty->assign("months", $months);
		$this->mysmarty->assign("lcatalog", strtoupper($this->config->item("lcatalog")));
		$this->mysmarty->assign("lcode", strtoupper($this->config->item("lcode")));
		$this->mysmarty->assign("ltopic", strtoupper($this->config->item("ltopic")));
		$this->mysmarty->assign("lcategory", strtoupper($this->config->item("category")));
		$this->mysmarty->assign("lgrade", strtoupper($this->config->item("lgrade")));
		$this->mysmarty->assign("lprovider", strtoupper($this->config->item("lprovider")));
		$this->mysmarty->assign("lmethod", strtoupper($this->config->item("lmethod")));		
		$this->mysmarty->assign("ldurations", strtoupper($this->config->item("ldurations")));
		$this->mysmarty->assign("ldays", $this->config->item("ldays"));
		$this->mysmarty->assign("lcost", strtoupper($this->config->item("lcost")));
		$this->mysmarty->assign("lperiod", strtoupper($this->config->item("lperiod")));	
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));		
		$this->mysmarty->assign("lperiod", $this->config->item("lperiod"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("ltraining_type_a", $this->config->item("ltraining_type_a"));
		$this->mysmarty->assign("ltraining_type_b", $this->config->item("ltraining_type_b"));
		$this->mysmarty->assign("ltraining_type_c", $this->config->item("ltraining_type_c"));
		$this->mysmarty->assign("ltraining_type_d", $this->config->item("ltraining_type_d"));
		$this->mysmarty->assign("lactions", $this->config->item("lactions"));		
		$this->mysmarty->assign("ldelete_from_ildp", $this->config->item("ldelete_from_ildp"));		
		$this->mysmarty->assign("lexternal_training", $this->config->item("lexternal_training"));		
		$this->mysmarty->assign("lexternal_catalog_title", $this->config->item("lexternal_catalog_title"));
		$this->mysmarty->assign("lexternal_catalog_tag", $this->config->item("lexternal_catalog_tag"));
		$this->mysmarty->assign("lexternal_catalog_objective", $this->config->item("lexternal_catalog_objective"));
		
		$this->mysmarty->assign("ladd_to_ildp_form", $this->config->item("ladd_to_ildp_form"));
		$this->mysmarty->assign("lempty_external_catalog_title", $this->config->item("lempty_external_catalog_title"));
		$this->mysmarty->assign("lempty_external_catalog_tag", $this->config->item("lempty_external_catalog_tag"));
		$this->mysmarty->assign("lreport_to", $this->config->item("lreport_to"));
		$this->mysmarty->assign("lapproved_by", $this->config->item("lapproved_by"));		
		
		// 
		
		$this->db->select("*, catrejector.user_npk catrejector_npk, catrejector.user_first_name catrejector_firstname, catrejector.user_last_name catrejector_last_name, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");		
		if ($referer == "approval")
		{
			$this->db->where("order_user", $orderer); 
			$this->db->where("order_date >=", date("Y-m-d H:i:s", $regtime[0]));
		}
		else
		if ($referer == "myform")
		{
			$this->db->where("order_id", $roworders[0]->order_id);
		}
		else
		{
			$this->db->where("order_user", $orderer);
			$this->db->where("order_status", 0);
			$this->db->where("order_date >=", date("Y-m-d H:i:s", $regtime[0]));
		}							
		
		$this->db->join("order", "order_id = order_catalog_order");		
		$this->db->join("user catrejector", "catrejector.user_id = order_catalog_rejected", "left outer");		
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");		
		
		$q = $this->db->get("order_catalog");		
		
		$rowscatalog = $q->result();
		
		for($i=0; $i < count($rowscatalog); $i++)
		{
			$catalogstatus[$rowscatalog[$i]->order_catalog_catalog] = $rowscatalog[$i];
			
			if (! isset($ordercounts[$rowscatalog[$i]->order_catalog_catalog]))
			{
				$ordercounts[$rowscatalog[$i]->order_catalog_catalog] = 1;
				continue;
			}
			
			$ordercounts[$rowscatalog[$i]->order_catalog_catalog]++;			
		}
		
		if ($topicid)
		{
			$this->db->where("training_topic", $topicid);
			$this->db->where("training_catalog_status", 1);
		}
				
		if ($referer == "cart")
		{
			if (! isset($this->carts))
			{
				$this->db->where("training_id", 0);		
			}
			else
			if ((! is_array($this->carts)) || (count($this->carts) == 0))
			{
				$this->db->where("training_id", 0);		
			}	
			else
			{
				$this->db->where_in("training_id", array_keys($this->carts));		
			}		
			$this->db->where("training_catalog_status", 1);
		}
		
		if (! isset($this->sess['asadmin']))
		{
			if (($referer == "approval") || ($referer == "myform"))
			{
				$this->db->where_in("training_id", $catalogs);
			}
			else
			if ((strlen($this->sess['user_grade_code']) == 0) || (! is_numeric($this->sess['user_grade_code'])))
			{
				$this->db->where("training_grade = '".$this->sess['user_grade_code']."'", null);
			}
			else
			{
				$this->db->where("training_grade <= ".$this->sess['user_grade_code'], null);
			}
		}
		else
		if ($referer == "myform")
		{
			$this->db->where_in("training_id", $catalogs);
		}
		
		$gmonths = $this->config->item("lmonths");
		
		$this->db->order_by($sortby, $orderby);
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$this->db->where("training_status", 0);
		$this->db->where("training_type", 3);
		$this->db->join("category", "training_topic = category_id");		
		if ($referer != "cart")
		{
			$this->db->limit($limit, $offset);
		}
		$q = $this->db->get("training");	
		
		$rows = $q->result();		
		for($i=0; $i < count($rows); $i++)
		{
			$cat = $this->topicmodel->getCategory($rows[$i]->category_id);
			
			$rows[$i]->category_name0 = $cat->category_name;
			$rows[$i]->training_cost_fmt = $rows[$i]->training_cost ? number_format($rows[$i]->training_cost, 0, "", ".") : $this->config->item("ltba");
			$rows[$i]->training_duration_fmt = number_format($rows[$i]->training_duration, 0, "", ".");
			$rows[$i]->order_catalog_status = (isset($catalog_status[$rows[$i]->training_id]) && ($catalog_status[$rows[$i]->training_id] == 1)) ? true : false;
			$rows[$i]->catalog_id = isset($catalog_id[$rows[$i]->training_id]) ? $catalog_id[$rows[$i]->training_id] : 0;
			$rows[$i]->catalog_rejected = isset($catalog_rejected[$rows[$i]->training_id]) ? $catalog_rejected[$rows[$i]->training_id] : 0;
			
			if (isset($catalog_period[$rows[$i]->training_id]))
			{
				$month = $catalog_period[$rows[$i]->training_id]%100;
				$rows[$i]->periods = $gmonths[$month-1]." ".floor($catalog_period[$rows[$i]->training_id]/100);
			}
			else
			if (isset($this->carts[$rows[$i]->training_id]))
			{
				$month = $this->carts[$rows[$i]->training_id]%100;
				$rows[$i]->periods = $gmonths[$month-1]." ".floor($this->carts[$rows[$i]->training_id]/100);
			}
			else
			{
				$rows[$i]->periods = false;
			}
			
			$rows[$i]->ordercounts = isset($ordercounts[$rows[$i]->training_id]) ? $ordercounts[$rows[$i]->training_id] : 0;
			
			$categories = array();
			$this->topicmodel->getCategoryRows(array($rows[$i]->training_topic), $categories);
			
			$categories = array_reverse($categories);
			$rows[$i]->categories = $categories;
		}

		if ($topicid)
		{
			$this->db->where("training_topic", $topicid);
		}
		if ($referer == "cart")
		{
			if (! isset($this->carts))
			{
				$this->db->where("training_id", 0);		
			}
			else
			if ((! is_array($this->carts)) || (count($this->carts) == 0))
			{
				$this->db->where("training_id", 0);		
			}	
			else
			{
				$this->db->where_in("training_id", array_keys($this->carts));		
			}		
			$this->db->where("training_catalog_status", 1);
		}
		
		if (! isset($this->sess['asadmin']))
		{
			if (($referer == "approval") || ($referer == "myform"))
			{
				$this->db->where_in("training_id", $catalogs);
			}
			else
			if ((strlen($this->sess['user_grade_code']) == 0) || (! is_numeric($this->sess['user_grade_code'])))
			{
				$this->db->where("training_grade = '".$this->sess['user_grade_code']."'", null);
			}
			else
			{
				$this->db->where("training_grade <= ".$this->sess['user_grade_code'], null);
			}
		}
				
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$this->db->where("training_status", 0);
		$this->db->where("training_type", 3);
		$this->db->join("category", "training_topic = category_id");
		$total = $this->db->count_all_results("training");	
		
		for($i=0; $i < count($rows); $i++)
		{
			if (! isset($catalogstatus[$rows[$i]->training_id])) continue;
			
			$rows[$i]->catalog = $catalogstatus[$rows[$i]->training_id];
			
			$status = $catalogstatus[$rows[$i]->training_id]->order_catalog_status;
			switch ($status )
			{
				case 1:		
					$rows[$i]->laststatus = $this->ildpmodel->getLastStatus($catalogstatus[$rows[$i]->training_id]);
				break;
				case 2:
					$rows[$i]->laststatus = sprintf($this->config->item("lrejected_by"), "(".$catalogstatus[$rows[$i]->training_id]->catrejector_npk.") ".$catalogstatus[$rows[$i]->training_id]->catrejector_firstname." ".$catalogstatus[$rows[$i]->training_id]->catrejector_last_name);;
			}
		}
		
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("catalogs", $rows);
		$this->mysmarty->assign("ncatalogs", count($rows));
				
		$this->mysmarty->assign("lrejected",  $this->config->item('lrejected'));
		$this->mysmarty->assign("lstart_approval",  $this->config->item('lstart_approval'));
		$this->mysmarty->assign("lsave_form",  $this->config->item('lsave_form'));
		$this->mysmarty->assign("lempty_cart_selected",  $this->config->item('lempty_cart_selected'));	
		$this->mysmarty->assign("lreject_reason",  $this->config->item('lreject_reason'));
		$this->mysmarty->assign("lempty_reason",  $this->config->item('lempty_reason'));
		$this->mysmarty->assign("lrejected_by",  sprintf($this->config->item('lrejected_by'), ""));		
		$this->mysmarty->assign("lrejected_date",  $this->config->item('lrejected_date'));
		$this->mysmarty->assign("lconfirm_ildp_checkout",  $this->config->item('lconfirm_ildp_checkout'));		
		$this->mysmarty->assign("lconfirm_ildp_approve",  $this->config->item('lconfirm_ildp_approve'));		
		$this->mysmarty->assign("lconfirm_ildp_reject",  $this->config->item('lconfirm_ildp_reject'));
		$this->mysmarty->assign("lconfirm_extdata_reject",  $this->config->item('lconfirm_extdata_reject'));
		$this->mysmarty->assign("lconfirm_ildp_content_reject",  $this->config->item('lconfirm_ildp_content_reject'));
		$this->mysmarty->assign("lconfirm_ildp_reset",  $this->config->item('lconfirm_ildp_reset'));
		$this->mysmarty->assign("lconfirm_ildp_draft",  $this->config->item('lconfirm_ildp_draft'));	
		$this->mysmarty->assign("lcancel",  $this->config->item('lcancel'));	
		$this->mysmarty->assign("lsave",  $this->config->item('lsave'));	
		$this->mysmarty->assign("lstatus",  $this->config->item('status'));	
		$this->mysmarty->assign("lreject",  $this->config->item('lreject'));
		$this->mysmarty->assign("lcomment",  $this->config->item('lcomment'));		
		$this->mysmarty->assign("lrepropose",  $this->config->item('lrepropose'));		
		
		$header_external_data = $this->mysmarty->fetch("ildp/externaldata/header.html");
		$this->mysmarty->assign("header_external_data",  $header_external_data);	
		
		$html = $this->mysmarty->fetch("ildp/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
		
	function form($id=0)
	{				
		if ($this->sess['user_type'] != 0)
		{
			redirect(base_url());
		}
		
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		if ($id)
		{
			$this->db->where("training_id", $id);
			$q = $this->db->get("training");
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowedit = $q->row();
			
			$rowedit->category = $this->topicmodel->getCategory($rowedit->training_topic);
			$rowedit->training_cost_fmt = number_format($rowedit->training_cost, 0, "", ".");
			
			$this->mysmarty->assign("rowedit", $rowedit);
		}
				
		if ($this->config->item("grade_min") < $this->config->item("grade_max"))
		{
			for($i=$this->config->item("grade_min"); $i <= $this->config->item("grade_max"); $i++)
			{
				$grades[] = $i;
			}
		}
		
		$tree = "";

		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
				
		$this->mysmarty->assign("lroot", $this->config->item('lroot'));		
		$this->mysmarty->assign("tree", $tree);
		
		$this->mysmarty->assign("grades", $grades);
								
		$this->mysmarty->assign("lmethod", $this->config->item("lmethod"));
		$this->mysmarty->assign("lsave", $this->config->item("lsave"));
		
		$this->mysmarty->assign("lmax_ambil_info", $this->config->item("lmax_ambil_info"));
		
		$this->mysmarty->assign("lprovider", $this->config->item("lprovider"));
		$this->mysmarty->assign("luntil", $this->config->item("until"));
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));
		$this->mysmarty->assign("lcatalog", $this->config->item("lcatalog"));
		$this->mysmarty->assign("lclassroom_name", $this->config->item("lclassroom_name"));
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));	
		$this->mysmarty->assign("ldescription", $this->config->item("description"));	
		$this->mysmarty->assign("ldays", $this->config->item("ldays"));	
		$this->mysmarty->assign("lduration", $this->config->item("lduration"));
		$this->mysmarty->assign("lcost", $this->config->item("lcost"));		
		$this->mysmarty->assign("ltraining_max", $this->config->item("ltraining_max"));		
		$this->mysmarty->assign("lhour", $this->config->item("lhour"));
		$this->mysmarty->assign("lminute", $this->config->item("lminute"));
		$this->mysmarty->assign("lobjective", $this->config->item("lobjective"));		
		$this->mysmarty->assign("ltag", $this->config->item("ltag"));		
		$this->mysmarty->assign("ltag_info", $this->config->item("ltag_info"));		
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/form.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function save($id=0)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}

		$category = isset($_POST['cat']) ? $_POST['cat'] : "";
		$topic = isset($_POST['topic']) ? $_POST['topic'] : "";
		$code = isset($_POST['code']) ? trim($_POST['code']) : "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$grade = isset($_POST['grade']) ? trim($_POST['grade']) : "";
		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$hour = isset($_POST['hour']) ? trim($_POST['hour']) : "";
		$minute = isset($_POST['minute']) ? trim($_POST['minute']) : "";
		$cost = isset($_POST['cost']) ? trim($_POST['cost']) : 0;
		$provider = isset($_POST['provider']) ? trim($_POST['provider']) : "";
		$method = isset($_POST['method']) ? trim($_POST['method']) : "";
		$max = isset($_POST['max']) ? trim($_POST['max']) : 0;
		$objective = isset($_POST['objective']) ? trim($_POST['objective']) : "";
		$tag = isset($_POST['tag']) ? trim($_POST['tag']) : "";
		
		if (strlen($category) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lselect_catalog_category");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($topic) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lselect_catalog_topic");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($code) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lselect_catalog_code");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($name) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_catalog_name");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->where("training_code", $code);
		$this->db->where("training_type", 3);
		$q = $this->db->get("training");
		
		if ($q->num_rows > 0)
		{
			$rowcode = $q->row();
			if ($rowcode->training_id != $id)
			{
				$callback['error'] = true;
				$callback['message'] = $this->config->item("lduplicate_catalog_code");
				
				echo json_encode($callback);
				return;				
			}			
		}		

		if (strlen($grade) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_empty_grade");
			
			echo json_encode($callback);
			return;
		}
		
		/*if ((strlen($hour) == 0) && (strlen($minute) == 0))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_catalog_duration");
			
			echo json_encode($callback);
			return;
		}*/
		
		if ((strlen($hour) > 0) && (! is_numeric($hour)))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_catalog_hour");
			
			echo json_encode($callback);
			return;
		}				

		if ((strlen($minute) > 0) && (! is_numeric($minute)))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_catalog_minute");
			
			echo json_encode($callback);
			return;
		}				

/*
		if (strlen($cost) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_catalog_cost");
			
			echo json_encode($callback);
			return;
		}
*/		
		$cost = str_replace(".", "", $cost);

		if ((strlen($cost) > 0) && (! is_numeric($cost)))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("linvalid_catalog_cost");
			
			echo json_encode($callback);
			return;
		}

		if (strlen($max) > 0)
		{
			if (! is_numeric($max))
			{
				$callback['error'] = true;
				$callback['message'] = $this->config->item("linvalid_training_max");
				
				echo json_encode($callback);
				return;
			}
		}


		unset($insert);
		
		$insert['training_topic'] = $topic;
		$insert['training_name'] = $name;
		$insert['training_desc'] = $desc;
		$insert['training_author_firstname'] = "";
		$insert['training_author_lastname'] = "";
		$insert['training_author_inital'] = "";
		$insert['training_author_email'] = "";
		$insert['training_author_id'] = "";
		$insert['training_status'] = 0; // masih catalog
		$insert['training_material'] = "";
		$insert['training_catalog_status'] = 1;
		$insert['training_max'] = $max ? $max : 0;
		$insert['training_material_type'] = 0;
		$insert['training_type'] = 3;
		$insert['training_pass'] = 0;
		$insert['training_duration'] = $days;
		$insert['training_total_question'] = 0;
		$insert['training_setting_jmlsoal'] = 0;
		$insert['training_setting_bobotmudah'] = 0;
		$insert['training_setting_bobotsedang'] = 0;
		$insert['training_setting_bobotsulit'] = 0;
		$insert['training_durationperquestion'] = 0;
		$insert['training_banksoal'] = 0;
		$insert['training_code'] = $code;
		$insert['training_cost'] = $cost;
		$insert['training_intro'] = "";
		$insert['training_refreshment'] = 0;
		$insert['training_kelompok'] = "";
		$insert['training_grade'] = $grade;
		$insert['training_learning_method'] = $method;
		$insert['training_instructor'] = "";
		$insert['training_organization'] = $provider;
		$insert['training_address'] = "";
		$insert['training_objective'] = $objective;
		$insert['training_tag'] = $tag;				
		$insert['training_modified'] = date("Y-m-d H:i:s");
		$insert['training_modifier'] = $this->sess['user_id'];
				
		if ($id)
		{
			$this->db->where("training_id", $id);
			$this->db->update("training", $insert);
	
			$callback['error'] = false;
			$callback['message'] = $this->config->item("lsuccess_update_catalog");
				
			echo json_encode($callback);			
			return;
		}

		$insert['training_created_date'] = date("Ymd");
		$insert['training_creator'] = $this->sess['user_id'];		
		$insert['training_created_time'] = date("Gis");
		
		$this->db->insert("training", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lsuccess_create_catalog");
			
		echo json_encode($callback);
	}
	
	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("training_id", $id);
		$this->db->delete("training");
		
		redirect(site_url()."/ildp");
	}

	function setting()
	{		
		$q = $this->db->get("ildpsetting");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->ildpsetting_key] = $rows[$i]->ildpsetting_val;
			
			$pos = strpos($rows[$i]->ildpsetting_key, "startreg");
			if (($pos !== FALSE) && ($pos == 0))
			{
				$idx = substr($rows[$i]->ildpsetting_key, strlen("startreg"));
				if ($idx)
				{
					$settings['startregperiod'][$idx] = $rows[$i]->ildpsetting_val;
				}
			}
			
			$pos = strpos($rows[$i]->ildpsetting_key, "endreg");
			if (($pos !== FALSE) && ($pos == 0))
			{
				$idx = substr($rows[$i]->ildpsetting_key, strlen("endreg"));
				if ($idx)
				{
					$settings['endregperiod'][$idx] = $rows[$i]->ildpsetting_val;
				}
			}			
		}
		
		if (! isset($settings['maxgrade']))
		{
			$settings['maxgrade'] = $this->config->item("max_grade");
		}
		
		for($i=0; $i < 12; $i++)
		{
			$months[] = $i+1;
		}

		$this->mysmarty->assign("imonths", $months);
		$this->mysmarty->assign("settings", $settings);
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		$this->mysmarty->assign("luntil", $this->config->item("luntil"));
		$this->mysmarty->assign("months", $this->config->item("lmonths"));
		$this->mysmarty->assign("lsetting", $this->config->item("lsetting"));
		$this->mysmarty->assign("lregistration_period", $this->config->item("lregistration_period"));
		$this->mysmarty->assign("llevel_report", $this->config->item("llevel_report"));		
		$this->mysmarty->assign("lgrade", $this->config->item("lgrade"));
		$this->mysmarty->assign("lthen", $this->config->item("lthen"));
		$this->mysmarty->assign("llevel_approval", $this->config->item("llevel_approval"));
		$this->mysmarty->assign("leligible_grade", $this->config->item("leligible_grade"));
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
		$this->mysmarty->assign("lmax_grade", $this->config->item("lmax_grade"));
		$this->mysmarty->assign("lconfirm_ildp_catalog_save", $this->config->item("lconfirm_ildp_catalog_save"));
		$this->mysmarty->assign("lconfirm_reset_data", $this->config->item("lconfirm_reset_data"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		
		$this->mysmarty->assign("leligible_grade_for_approval", $this->config->item("leligible_grade_for_approval"));
		$this->mysmarty->assign("lmail_notification", $this->config->item("lmail_notification"));
		$this->mysmarty->assign("lyes", $this->config->item("lyes"));
		$this->mysmarty->assign("lno", $this->config->item("lno"));
		
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/setting.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function savesetting()
	{
		foreach($_POST as $key=>$val)
		{
			$this->db->where("ildpsetting_key", $key);
			$this->db->delete("ildpsetting");
			
			unset($insert);
			
			$insert['ildpsetting_key'] = $key;
			$insert['ildpsetting_val'] = $val;
			$insert['ildpsetting_lastmodified'] = date("Y-m-d H:i:s");
			$insert['ildpsetting_lastmodifier'] = $this->sess['user_id'];
			
			$this->db->insert("ildpsetting", $insert);
		}
		
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lsuccess_update_setting");
		
		echo json_encode($callback);
	}
	
	function import()
	{		
		
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/import.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function doimport()
	{
		$config['allowed_types'] = $this->config->item("allowed_filetype");
		$config['upload_path'] = BASEPATH.'../uploads/';
		
		$this->load->library('upload');		
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload("userfile"))
		{
			$error = $this->upload->display_errors();
			
			$error = str_replace("\r", "\\r", $error);
			$error = str_replace("\n", "\\n", $error);			
			$errror = str_replace("'", "", $error);
			
			echo "<script>parent.setErrorMessage('".$error."')</script>";
			return;
		}
		
		$updata = $this->upload->data();	
				
		$this->load->library("xlsreader");			
		$this->xlsreader->read($updata['full_path']);
		
		// ambil topic
		
		$q = $this->db->get("category");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$topics[trim(strtoupper($rows[$i]->category_code))][trim(strtoupper($rows[$i]->category_name))] = $rows[$i]->category_id;
		}
		
		// ambil catalog

		$this->db->where("training_status", 0);
		$this->db->where("training_type", 3);
		$this->db->join("category", "training_topic = category_id");
		$q = $this->db->get("training");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$catalogs[strtoupper($rows[$i]->category_code)][strtoupper($rows[$i]->training_code)] = $rows[$i]->training_id;
		}		
		
		$i = 2;
		while(1)
		{
			if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;
			
			$catcode = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][2]));
			$catname = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][3]));
			
			if (! isset($topics[$catcode][$catname]))
			{
				$this->mysmarty->assign("message", sprintf($this->config->item("ltopic_not_found"), $i-1));
				$this->mysmarty->display("ildp/doimport.html");
				return;
			}
			$i++;
		}		
		
		$i = 2;
		while(1)
		{
			if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;
			
			$grade = trim($this->xlsreader->sheets[0]['cells'][$i][1]);
			$catcode = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][2]));
			$catname = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][3]));
			$trainingcode = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][4]));
			$trainingname = strtoupper(trim($this->xlsreader->sheets[0]['cells'][$i][5]));
			$objective = trim($this->xlsreader->sheets[0]['cells'][$i][6]);
			$provider = trim($this->xlsreader->sheets[0]['cells'][$i][7]);
			$method = trim($this->xlsreader->sheets[0]['cells'][$i][8]);
			$duration = trim($this->xlsreader->sheets[0]['cells'][$i][9]);
			$cost = trim($this->xlsreader->sheets[0]['cells'][$i][10]);
			$tag = trim($this->xlsreader->sheets[0]['cells'][$i][11]);
						
			$topicid = $topics[$catcode][$catname];
			
			unset($insert);
			
			$insert['training_topic'] = $topicid;
			$insert['training_name'] = $trainingname;			
			$insert['training_status'] = 0;
			$insert['training_type'] = 3;
			$insert['training_duration'] = $duration;			
			$insert['training_code'] = $trainingcode;
			$insert['training_cost'] = $cost;			
			$insert['training_grade'] = $grade;
			$insert['training_learning_method'] = $method;
			$insert['training_organization'] = $provider;
			$insert['training_tag'] = $tag;						
			$insert['training_objective'] = $objective;
			$insert['training_modified'] = date("Y-m-d H:i:s");
			$insert['training_modifier'] = $this->sess['user_id'];
			
			if (isset($catalogs[$catcode][$trainingcode]))
			{
				$trainingid = $catalogs[$catcode][$trainingcode];
								
				$this->db->where("training_id", $trainingid);
				$this->db->update("training", $insert);
				
				$i++;
				
				continue;
			}
						
			$insert['training_author_firstname'] = "";
			$insert['training_author_lastname'] = "";
			$insert['training_author_inital'] = "";
			$insert['training_author_email'] = "";
			$insert['training_author_id'] = 0;
			$insert['training_created_date'] = date("Ymd");
			$insert['training_creator'] = $this->sess['user_id'];
			$insert['training_material'] = "";
			$insert['training_catalog_status'] = 1;
			$insert['training_max'] = 0;
			$insert['training_material_type'] = 0;
			$insert['training_pass'] = 0;
			$insert['training_total_question'] = 0;
			$insert['training_banksoal'] = 0;
			$insert['training_setting_jmlsoal'] = 0;
			$insert['training_setting_bobotmudah'] = 0;
			$insert['training_setting_bobotsedang'] = 0;
			$insert['training_setting_bobotsulit'] = 0;
			$insert['training_durationperquestion'] = 0;			
			$insert['training_intro'] = "";
			$insert['training_refreshment'] = 0;
			$insert['training_kelompok'] = "";
			$insert['training_instructor'] = "";
			$insert['training_intro'] = "";
			$insert['training_address'] = "";
			$insert['training_created_time'] = date("Gis");
			
			$this->db->insert("training", $insert);
			
			$i++;
		}

		$this->mysmarty->assign("message", sprintf($this->config->item("lildp_import_success"), $i-2));
		$this->mysmarty->display("ildp/doimportsuccess.html");
		
	}
	
	function add2cart($id)
	{
		if (isset($this->carts[$id]))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lcart_already_exist");
			
			echo json_encode($callback);
			return;
		}
		
		$this->carts[$id] = $_POST['period'];
		$this->session->set_userdata("ildp", $this->carts);
		
		$callback['error'] = false;
		$callback['message'] = $this->config->item("ladd_cart_successfully");
		
		echo json_encode($callback);		
	}
	
	function getcart()
	{
		if (! $this->carts)
		{
			$callback['htmltotal'] = "";
			$callback['total'] = 0;
		}
		else
		{
			$callback['htmltotal'] = " ( ".count($this->carts)." )</a>";
			$callback['total'] = count($this->carts);
		}		
		
		echo json_encode($callback);		
	}
	
	
	function removecart()
	{
		if (! isset($_POST['cart']))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_cart_selected");
			
			echo json_encode($callback);
			return;
		}
		
		for($i=0; $i < count($_POST['cart']); $i++)
		{
			if (! isset($this->carts[$_POST['cart'][$i]])) continue;
			unset($this->carts[$_POST['cart'][$i]]);
		}
		
		$this->session->set_userdata("ildp", $this->carts);		

		$callback['error'] = false;
		$callback['message'] = $this->config->item("ldelete_cart_success");
			
		echo json_encode($callback);
	}
	
	function checkout()
	{
		if ((! is_array($this->carts)) || (count($this->carts) == 0))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_cart");
			
			echo json_encode($callback);
			return;	
		}
		
		$this->db->where("jabatan_id", $this->sess['user_jabatan']);
		$this->db->join("jabatan", "jabatan_level_group = level_group_id");
		$q = $this->db->get("level_group");
		if ($q->num_rows() == 0)
		{
			$groupid = 0;
		}
		else
		{
			$row = $q->row();
			$groupid = $row->level_group_id;
		}
		
		
		$regtime = $this->ildpmodel->isRegistrationTime($this->sess['user_id']);
		if (! $regtime)
		{
			exit;
		}
				
		unset($insert);
		
		$insert['order_status'] = (isset($_POST['isdraft']) && ($_POST['isdraft'] == 1)) ? 0 : 1;
		$insert['order_date'] = date("Y-m-d H:i:s");
		$insert['order_user'] = $this->sess['user_id'];
		$insert['order_user_job'] = $this->sess['user_jabatan'];
		$insert['order_user_grade'] = $this->sess['user_grade_code'];
		$insert['order_group'] = $groupid;
		$insert['order_location'] = $this->sess['user_location'];
		$insert['order_phone'] = isset($_POST['phone']) ?  trim($_POST['phone']) : "";
		$insert['order_mobile'] = isset($_POST['mobile']) ?  trim($_POST['mobile']) : "";
		
		$trail['order'] = $insert;
		
		$this->db->where("order_user", $this->sess['user_id']);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));
		$q = $this->db->get("order");	
				
		if ($q->num_rows() == 0)
		{		
			$this->db->insert("order", $insert);		
			$orderid = $this->db->insert_id();			
		}
		else
		{	
			$rowdraft = $q->row();			
								
			$this->db->where("order_id", $rowdraft->order_id);
			$this->db->update("order", $insert);
						
			$orderid = $rowdraft->order_id;
		}
		
		// catalog
		
		$this->db->where("order_catalog_order", $orderid);
		$this->db->delete("order_catalog");
		
		foreach($this->carts as $key=>$val)
		{
			unset($insert);
		
			$insert['order_catalog_order'] = $orderid;	
			$insert['order_catalog_catalog'] = $key;	
			$insert['order_catalog_period'] = $val;	
			$insert['order_catalog_status'] = 1;	
			
			$trail['catalog'][] = $insert;
			
			$this->db->insert("order_catalog", $insert);
		}

		// external data

		$this->db->where("externaldata_order", $orderid);
		$this->db->delete("order_externaldata");
		
		if (isset($_POST['exttitle']))
		{
			for($i=0; $i < count($_POST['exttitle']); $i++)
			{
				unset($insert);
			
				$insert['externaldata_order'] = $orderid;	
				$insert['externaldata_title'] = $_POST['exttitle'][$i];	
				$insert['externaldata_tag'] = $_POST['exttag'][$i];	
				$insert['externaldata_objective'] = $_POST['extobj'][$i];	
				$insert['externaldata_status'] = 1;	
				$insert['externaldata_created'] = date("Y-m-d H:i:s");	
				$insert['externaldata_creator'] = $this->sess['user_id'];	
				
				$trail['externaldata'][] = $insert;
				
				$this->db->insert("order_externaldata", $insert);
			}
		}

		// reporter

		$this->db->where("order_catalog_report_catalog", $orderid);
		$this->db->delete("order_catalog_report");
		
		$reportto = isset($_POST['reportto']) ? $_POST['reportto'] :  array();
		
		if (count($reportto))
		{
			$this->db->where_in("user_id", $reportto);
			$q = $this->db->get("user");
			
			$rowreporttomails = $q->result();
			for($i=0; $i < count($rowreporttomails); $i++)
			{
				$mails[$rowreporttomails[$i]->user_id] = $rowreporttomails[$i];
			}
		}
		
				
		for($i=0; $i < count($reportto); $i++)
		{
			unset($insert);
		
			$insert['order_catalog_report_catalog'] = $orderid;
			$insert['order_catalog_report_user'] = $reportto[$i];	
			$insert['order_catalog_report_order'] = $i+1;	
			$insert['order_catalog_report_status'] = 0;	
			$insert['order_catalog_report_approved'] = date("Y-m-d H:i:s");	
			$insert['order_catalog_report_approver'] = 0;
			
			$trail['reporter'][] = $insert;
			
			$this->db->insert("order_catalog_report", $insert);
			
			if ($i > 0) continue;
			if (isset($_POST['isdraft']) && ($_POST['isdraft'] == 1)) continue;
			if (! isset($mails[$reportto[$i]]->user_email)) continue;
			if (! valid_email($mails[$reportto[$i]]->user_email)) continue;

			$this->mysmarty->assign("carts", $this->carts);
			$this->mysmarty->assign("reportto", $mails[$reportto[$i]]);
			$message = $this->mysmarty->fetch("ildp/checkoutmail.html");

			// send email
			
			$q = $this->db->get("general_setting");
			$this->db->flush_cache();
	
			$rowsettings = $q->result();
			for($j=0; $j < count($rowsettings); $j++)
			{
				$settings[$rowsettings[$j]->general_setting_code] = $rowsettings[$j]->general_setting_value;
			}
			
			$this->load->library('email');
			
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype']	= "html";

			if (isset($this->settings['mailtype']) && ($this->settings['mailtype'] == "smtp"))	
			{
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = $settings['smtphost'];
				$config['smtp_user'] = isset($settings['smtpuser']) ? 	$settings['smtpuser'] : "";
				$config['smtp_pass'] = 	isset($settings['smtppass']) ? 	$settings['smtppass'] : "";		
			}
			else
			{
				$config['protocol'] = 'mail';
			}
			
			$config['mailtype'] = (isset($this->settings['mailcontenttype']) && $this->settings['mailcontenttype']) ? $this->settings['mailcontenttype'] : "html";
			
			$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
			$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";
	
			$this->email->initialize($config);
			$this->email->from($mailsender, $sendername);
			$this->email->to($mails[$reportto[$i]]->user_email); 
			$this->email->subject($this->config->item("lsubject_submitted"));
			$this->email->message($message);	
			@$this->email->send();
		}		
		
		unset($insert);
		
		$insert['ildp_trail_order'] = $orderid;
		$insert['ildp_trail_user'] = $this->sess['user_id'];
		$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_act'] = (isset($_POST['isdraft']) && ($_POST['isdraft'] == 1)) ? "savetodraft" : "startapprovalprocess";	
		$insert['ildp_trail_data'] = json_encode($trail);
		
		$this->db->insert("ildp_trail", $insert);
		
		if (! isset($_POST['isdraft']))
		{
			$this->carts = array();
			$this->session->set_userdata("ildp", $this->carts);
		}
		
		$callback['error'] = false;
		if (isset($_POST['isdraft']) && ($_POST['isdraft'] == 1))
		{
			$callback['message'] = $this->config->item("lsave_draft");
			$callback['redirect'] = "";
		}
		else
		{		
			$callback['message'] = $this->config->item("lcheckout_success");
			$callback['redirect'] = site_url(array("ildp", "checkoutb"));
		}
		
		
		echo json_encode($callback);
		return;			
	}
	
	function checkoutb()
	{		
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("lsubmit_ildp_form_message", $this->config->item("lsubmit_ildp_form_message"));
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "ildp/checkoutb.html");
		$this->mysmarty->display("sess_template.html");				
	}
	
	function status($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		$update['training_catalog_status'] = ($row->training_catalog_status == 1) ? 2: 1;
		$update['training_modified'] = date("Y-m-d H:i:s");
		$update['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;
		
		$this->db->where("training_id", $id);
		$this->db->update("training", $update);		
		
		redirect(site_url(array("ildp", "")));		
	}
	
	function externaldata()
	{		
		$exttitles = isset($_POST['exttitle']) ? $_POST['exttitle'] : array();
		$exttags = isset($_POST['exttag']) ? $_POST['exttag'] : array();
		$extobjs = isset($_POST['extobj']) ? $_POST['extobj'] : array();
		$extstatus = isset($_POST['extstatus']) ? $_POST['extstatus'] : array();
		$extid = isset($_POST['extid']) ? $_POST['extid'] : array();
		$extorder = isset($_POST['extorder']) ? $_POST['extorder'] : array();
		$extrejected = isset($_POST['extrejected']) ? $_POST['extrejected'] : array();
				
		$extlaststatus = array();
		
		$this->db->where_in("user_id", $extrejected);
		$q = $this->db->get("user");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$users[$rows[$i]->user_id] = $rows[$i];
		}
		
		$this->db->where_in("order_id", $extorder);
		$this->db->select("*, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");		
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");		
		$q = $this->db->get("order");
		$rows = $q->result();
		
		for($i=0; $i < count($extorder); $i++)
		{
			if ($extstatus[$i] == 1)
			{
				for($j=0; $j < count($rows); $j++)
				{
					if ($extorder[$i] != $rows[$j]->order_id) continue;
								
					$extlaststatus[$i] = $this->ildpmodel->getLastStatus($rows[$j]);
				}
			}
			else
			if (isset($users[$extrejected[$i]]))
			{
				$extlaststatus[$i] = sprintf($this->config->item("lrejected_by"), "(".$users[$extrejected[$i]]->user_npk.") ".$users[$extrejected[$i]]->user_first_name." ".$users[$extrejected[$i]]->user_last_name);
			}
		}
				
		$this->mysmarty->assign("isowner", count($rows) && ($rows[0]->order_user == $this->sess['user_id']));
		$this->mysmarty->assign("extlaststatus", $extlaststatus);
		$this->mysmarty->assign("exttitles", $exttitles);
		$this->mysmarty->assign("exttags", $exttags);
		$this->mysmarty->assign("extobjs", $extobjs);
		$this->mysmarty->assign("extstatus", $extstatus);
				
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lrejected", $this->config->item("lrejected"));
		$this->mysmarty->assign("lexternal_catalog_title", $this->config->item("lexternal_catalog_title"));
		$this->mysmarty->assign("lexternal_catalog_tag", $this->config->item("lexternal_catalog_tag"));
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));		
		$this->mysmarty->assign("lpart3_cart", $this->config->item("lpart3_cart"));
		$this->mysmarty->assign("lexternal_catalog_objective", $this->config->item("lexternal_catalog_objective"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/externaldata.html");
		
		echo json_encode($callback);
	}	
	
	function approval($isadmin=0)
	{
		if (! $this->sess)
		{
			redirect(base_url());
		}
		
		if ($isadmin)
		{
			$this->mysmarty->assign("lapproval_list", $this->config->item("lildp_form"));
			$this->mysmarty->assign("lheader_approval_list", $this->config->item("lheader_ildpform_list"));
		}
		else
		{
			$this->mysmarty->assign("lapproval_list", $this->config->item("lapproval_list"));
			$this->mysmarty->assign("lheader_approval_list", $this->config->item("lheader_approval_list"));
		}		
	
		$this->mysmarty->assign("isadmin", $isadmin);	
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));								
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
	
		if ($isadmin)
		{
			$this->mysmarty->assign("left_content", "ildp/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}		
		
		$this->mysmarty->assign("main_content", "ildp/approval/index.html");
		$this->mysmarty->display("sess_template.html");						
	}
	
	
	function searchildpform($offset=0)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

		$regtime = $this->ildpmodel->getILDPPeriod();
		
		$this->db->select("order.*, owner.*, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");
		$this->db->where("order_status >", 0);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-d 23:59:59", $regtime[1]));
		$this->db->join("user owner", "owner.user_id = order_user");
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");
		
		$q = $this->db->get("order");
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$t = dbmaketime($rows[$i]->order_date);
			$rows[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);
	
			$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);			
		}
		
		// 

		$this->db->where("order_status >", 0);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-d 23:59:59", $regtime[1]));
		$this->db->join("user", "user_id = order_user");
		$total = $this->db->count_all_results("order");

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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("users", $rows);
		$this->mysmarty->assign("nuser", count($rows));
		$this->mysmarty->assign("lname", $this->config->item("name"));		
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		$this->mysmarty->assign("lconfirm_ildp_reset", $this->config->item("lconfirm_ildp_reset"));			
		
		$callback['html'] = $this->mysmarty->fetch("ildp/approval/list.html");
		
		echo json_encode($callback);

	}
		
	function searchapproval($offset=0)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		
		// get last period
		
		$regtime = $this->ildpmodel->getILDPPeriod();
		
		// get delegator
		
		$this->db->where('delegetion_ildp_delegator', $this->sess['user_id']);
		$this->db->where('delegetion_ildp_status', 1);
		$q = $this->db->get("delegetion_ildp");
		
		$rows = $q->result();
		
		$delegator[] = $this->sess['user_id'];
		for($i=0; $i < count($rows); $i++)
		{
			$delegator[] = $rows[$i]->delegetion_ildp_user;
		}
		
		// get last approved
		
		$this->db->order_by("order_catalog_report_order", "desc");
		$this->db->where("order_catalog_report_status", 1);		
		$q = $this->db->get("order_catalog_report");		
		$rowsapproved = $q->result();
		
		for($i=0; $i < count($rowsapproved); $i++)
		{
			if (isset($approveds[$rowsapproved[$i]->order_catalog_report_catalog])) continue;
			
			$approveds[$rowsapproved[$i]->order_catalog_report_catalog] = $rowsapproved[$i]->order_catalog_report_order;
		}
		
		$this->db->order_by($sortby, $orderby);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));		
		$this->db->where("order_catalog_report_status", 0);
		$this->db->where("order_status", 1);
		$this->db->where_in("order_catalog_report_user", $delegator);
		$this->db->join("user", "order_user = user_id");
		$this->db->join("order_catalog_report", "order_catalog_report_catalog = order_id");		
		$q = $this->db->get("order");
		$rows = $q->result();
			
		$temp = array();	
		for($i=0; $i < count($rows); $i++)
		{
			if (! isset($approveds[$rows[$i]->order_id]))
			{
				if ($rows[$i]->order_catalog_report_order != 1) continue;
				
				$t = dbmaketime($rows[$i]->order_date);
				$rows[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);

				$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);
				$temp[] = $rows[$i];
				
				continue;
			}
			
			if (($approveds[$rows[$i]->order_id]+1) != $rows[$i]->order_catalog_report_order)
			{
				continue;
			}
			
			$t = dbmaketime($rows[$i]->order_date);
			$rows[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);			
			$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);
			$temp[] = $rows[$i];
		}
				
		// hrrm
				
		$groups = $this->ildpmodel->getHRRM($delegator, $this->levelmodel);
		
		if (count($groups))
		{
			$this->db->distinct();
			$this->db->where("order_status", 2);
			$this->db->where_in("jabatan_level_group", $groups);
			$this->db->join("user", "order_user = user_id");
			$this->db->join("jabatan", "user_jabatan = jabatan_id");
			$q = $this->db->get("order");			
			
			$rowhrlds = $q->result();			
			for($i=0; $i < count($rowhrlds); $i++)
			{
				$t = dbmaketime($rowhrlds[$i]->order_date);
				$rowhrlds[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);
				
				$rowhrlds[$i]->last_status = $this->ildpmodel->getLastStatus($rowhrlds[$i]);
				$rowhrlds[$i]->order_catalog_report_user = $rowhrlds[$i]->user_id;
				$temp[] = $rowhrlds[$i];
			}			
		}
				
		// hrld			
		
		$categories = $this->ildpmodel->getHRLDTopic($delegator, $this->topicmodel);
		if (count($categories))
		{			
			$this->db->distinct();
			$this->db->where("order_status", 3);
			$this->db->where_in("training_topic", $categories);
			$this->db->join("order_catalog", "order_id = order_catalog_order");
			$this->db->join("training", "training_id = order_catalog_catalog");
			$this->db->join("user", "order_user = user_id");
			$q = $this->db->get("order");
			
			$rowhrrms = $q->result();			
			
			
			for($i=0; $i < count($rowhrrms); $i++)
			{
				$t = dbmaketime($rowhrrms[$i]->order_date);
				$rowhrrms[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);
				
				$rowhrrms[$i]->last_status = $this->ildpmodel->getLastStatus($rowhrrms[$i]);
				$rowhrrms[$i]->order_catalog_report_user = $rowhrrms[$i]->user_id;
				$temp[] = $rowhrrms[$i];
			}
		}				
		
		// distinct
		
		$rows = array();
		for($i=0; $i < count($temp); $i++)
		{
			if (isset($users[$temp[$i]->order_catalog_report_user])) continue;			
			$users[$temp[$i]->order_catalog_report_user] = 1;
			
			$rows[] = $temp[$i];
		}		
		
		
		$rows = array_slice($rows, $offset, $limit);
		$total = count($rows);
				
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;
		$this->mysmarty->assign("nuser", $total);

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("users", $rows);
		$this->mysmarty->assign("lname", $this->config->item("name"));		
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		
		$callback['html'] = $this->mysmarty->fetch("ildp/approval/list.html");
		
		echo json_encode($callback);
		
	}
	
	function ildpform($user)
	{
		// check periode
		
		$regtime = $this->ildpmodel->getILDPPeriod();

		$this->db->where("order_user", $user);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));
		$q = $this->db->get("order");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}		
		
		$this->index(0, "approval", $user);
	}
	
	function approved($userid)
	{
		$this->db->order_by("order_date", "desc");
		$this->db->where("order_user", $userid);
		$this->db->limit(1, 0);
		$this->db->join("user", "user_id = order_user");
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$q = $this->db->get("order");
		
		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_approved");
			
			echo json_encode($callback);
			return;
		}
		
		$row = $q->row();
		
		if ($row->order_status == 2)
		{
			// hrrm
			unset($update);
			
			$update['order_status'] = 3;
			$update['order_hrrm'] = $this->sess['user_id'];
			$update['order_hrrm_date'] = date("Y-m-d H:i:s");
			
			$this->db->where("order_id", $row->order_id);
			$this->db->update("order", $update);
			
			$trail['order'] = $update;

			// next approved
			
			// get hr l&d			
			
			$this->db->where("order_catalog_order", $row->order_id);
			$this->db->join("training", "training_id = order_catalog_catalog");
			$q = $this->db->get("order_catalog");
			
			$rowcatalogs = $q->result();
			
			$categories[] = 0;
			for($i=0; $i < count($rowcatalogs); $i++)
			{
				$cats = array();
				$this->topicmodel->getCategoryIds(array($rowcatalogs[$i]->training_topic), $cats);
				
				for($i=0; $i < count($cats); $i++)
				{
					$categories[] = $cats[$i];
				}
			}
						
			$this->db->where_in("hrld_category", $categories);
			$this->db->where("hrld_status", 1);
			$this->db->join("user", "user_id = hrld_npk");
			$q = $this->db->get("hrld");
			
			$rowhrlds = $q->result();
			$nextapproved = array();
			for($i=0; $i < count($rowhrlds); $i++)
			{
				$nextapproved[] = $rowhrlds[$i];
			}			

			$trail['nextapproved'] = $nextapproved;
			
			$insert['ildp_trail_order'] = $row->order_id;	
			$insert['ildp_trail_user'] = $this->sess['user_id'];
			$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
			$insert['ildp_trail_act'] = "approved";	
			$insert['ildp_trail_data'] = json_encode($trail);		
		
			$this->db->insert("ildp_trail", $insert);
			$this->mailtonextapproved($nextapproved);

			$callback['error'] = false;
			$callback['message'] = $this->config->item("lorder_approved");
			$callback['redirect'] = site_url()."/ildp/approval";
			
			echo json_encode($callback);
			
			return;
		}
		
		if ($row->order_status == 3)
		{
			// hrld
			unset($update);
			
			$update['order_status'] = 4;
			$update['order_hrld'] = $this->sess['user_id'];
			$update['order_hrld_date'] = date("Y-m-d H:i:s");
			
			$this->db->where("order_id", $row->order_id);
			$this->db->update("order", $update);
			
			$nextapproved[] = $row;
			$trail['order'] = $update;

			$insert['ildp_trail_order'] = $row->order_id;	
			$insert['ildp_trail_user'] = $this->sess['user_id'];
			$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
			$insert['ildp_trail_act'] = "approved";	
			$insert['ildp_trail_data'] = json_encode($trail);							
		
			$this->db->insert("ildp_trail", $insert);
			$this->mailtonextapproved($nextapproved, "complete");

			$callback['error'] = false;
			$callback['message'] = $this->config->item("lorder_approved");
			$callback['redirect'] = site_url()."/ildp/approval";
				
			echo json_encode($callback);
			
			return;
		}		
		
		// get last approved
		
		$this->db->order_by("order_catalog_report_order", "desc");
		$this->db->where("order_catalog_report_status", 1);
		$this->db->where("order_catalog_report_catalog", $row->order_id);
		$this->db->limit(1);
		
		$q = $this->db->get("order_catalog_report");	
		
		if ($q->num_rows() == 0)
		{
			$order = 1;
		}
		else
		{
			$rowapproved = $q->row();
			$order = $rowapproved->order_catalog_report_order+1;			
		}			
		
		unset($update);
				
		$update['order_catalog_report_status'] = 1;
		$update['order_catalog_report_approved'] = date("Y-m-d H:i:s");
		$update['order_catalog_report_approver'] = $this->sess['user_id'];	
		
		$this->db->where("order_catalog_report_catalog", $row->order_id);
		$this->db->where("order_catalog_report_order", $order);
		$this->db->update("order_catalog_report", $update);
		$this->db->flush_cache();
		
		// cek jika semua sudah approved oleh atasan				
		
		$this->db->order_by("order_catalog_report_order", "asc");
		$this->db->where("order_catalog_report_catalog", $row->order_id);
		$this->db->where("order_catalog_report_status", 0);
		$this->db->join("user", "user_id = order_catalog_report_user");
		$q = $this->db->get("order_catalog_report");
		
		if ($q->num_rows() == 0)
		{		
			unset($update);
			
			$update['order_status'] = 2;
			
			$this->db->where("order_id", $row->order_id);
			$this->db->update("order", $update);
			
			// get all hrrm
			
			$groups[] = $row->jabatan_level_group;
			$this->levelmodel->getparentlevelgroupids($row->jabatan_level_group, $groups);
			
			$this->db->where("hrrm_status", 1);
			$this->db->where_in("hrrm_group", $groups);
			$this->db->join("user", "user_id = hrrm_npk");
			$q = $this->db->get("hrrm");
			$rowhrrms = $q->result();
			
			$nextapproved = array();
			for($i=0; $i < count($rowhrrms); $i++)
			{
				$nextapproved[] = $rowhrrms[$i];
			}						
		}
		else
		{
			$rowreporter = $q->row();
			$nextapproved[] = $rowreporter;
		}
		
		$trail['nextapproved'] = $nextapproved;

		$insert['ildp_trail_order'] = $row->order_id;
		$insert['ildp_trail_user'] = $this->sess['user_id'];
		$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_act'] = "approved";	
		$insert['ildp_trail_data'] = json_encode($trail);		
		
		$this->db->insert("ildp_trail", $insert);
		
		// email to next approved
		$this->mailtonextapproved($nextapproved);
		

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lorder_approved");
		$callback['redirect'] = site_url()."/ildp/approval";
			
		echo json_encode($callback);
		return;
	}

	function mailtonextapproved($nextapproved, $type="", $data="")
	{
		if (! count($nextapproved)) return;
		
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();

		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		}

		$this->load->library('email');
		
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype']	= "html";

		if (isset($settings['mailtype']) && ($settings['mailtype'] == "smtp"))	
		{
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $settings['smtphost'];
			$config['smtp_user'] = isset($settings['smtpuser']) ? 	$settings['smtpuser'] : "";
			$config['smtp_pass'] = 	isset($settings['smtppass']) ? 	$settings['smtppass'] : "";		
		}
		else
		{
			$config['protocol'] = 'mail';
		}
		
		$config['mailtype'] = (isset($settings['mailcontenttype']) && $settings['mailcontenttype']) ? $settings['mailcontenttype'] : "html";
		
		$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
		$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";

						
		for($i=0; $i < count($nextapproved); $i++)
		{
			if (! valid_email($nextapproved[$i]->user_email)) continue;
			
			$this->mysmarty->assign("reportto", $nextapproved[$i]);
			$this->mysmarty->assign("sess", $this->sess);
			if ($type == "complete")
			{
				$subject = $this->config->item("lsubject_approved_complete");
				$message = $this->mysmarty->fetch("ildp/completemail.html");
			}
			else
			if ($type == "rejected")
			{
				
				$data['trail'] = json_decode($data['ildp_trail_data']);
				
				$this->mysmarty->assign("data", $data);	
				$subject = $this->config->item("lsubject_rejected");
				$message = $this->mysmarty->fetch("ildp/rejectedemail.html");
			}
			else
			if ($type == "rejectedcatalog")
			{
				$this->mysmarty->assign("data", $data);	
				$subject = $this->config->item("lsubject_rejectedcatalog");
				$message = $this->mysmarty->fetch("ildp/rejectedcatalogemail.html");				
			}
			else
			if ($type == "rejectedextdata")
			{
				$this->mysmarty->assign("data", $data);	
				$subject = $this->config->item("lsubject_rejectedextdata");
				$message = $this->mysmarty->fetch("ildp/rejectedextdataemail.html");				
			}
			else
			if ($type == "reset")
			{
				$subject = $this->config->item("lsubject_resetform");
				$message = $this->mysmarty->fetch("ildp/resetformemail.html");				
			}			
			else
			{	
				$subject = $this->config->item("lsubject_approved");		
				$message = $this->mysmarty->fetch("ildp/approvemail.html");
			}

			$this->email->initialize($config);
			$this->email->from($mailsender, $sendername);
			$this->email->to($nextapproved[$i]->user_email); 
			$this->email->subject($subject);
			$this->email->message($message);	
			@$this->email->send();
			
			$this->email->clear();
		}
	}
	
	function myform()
	{
		if (! $this->sess)
		{
			redirect(base_url());
		}
		
		$this->mysmarty->assign("lheader_my_ildp_form", $this->config->item("lheader_my_ildp_form"));				
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildp/myform/index.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function searchmyform($offset=0)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
						
		$this->db->select("order.*, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");
		$this->db->order_by("order_date", "desc");
		$this->db->where("order_user", $this->sess['user_id']);
		$this->db->limit($limit, $offset);
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");		
		$q = $this->db->get("order");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$t = dbmaketime($rows[$i]->order_date);
			$rows[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);
			
			$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);
			
			if ($rows[$i]->order_rejected && ($rows[$i]->order_status == 0))
			{
				$rows[$i]->description = $rows[$i]->order_rejected_comment;
			}
			else
			{
				$rows[$i]->description = "";
			}
		}

		$this->db->where("order_status <>", 0);
		$this->db->where("order_user", $this->sess['user_id']);
		$total = $this->db->count_all_results("order");
		
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("rows", $rows);
		
		$this->mysmarty->assign("lsubmitdate", $this->config->item("lsubmitdate"));		
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldescription", $this->config->item("description"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/myform/list.html");
		
		echo json_encode($callback);
	}
	
	function myformdetailhist($orderid)
	{
		$this->index(0, "myform", $orderid);
	}
	
	function myformdetail($orderid)
	{
		$this->index(0, "myform", $orderid);
	}
	
	function reject($userid)
	{
		$reason = isset($_POST['reason']) ? trim($_POST['reason']) : "";
		
		$this->db->order_by("order_date", "desc");
		$this->db->where("order_user", $userid);
		$this->db->join("user", "user_id = order_user");
		$this->db->limit(1, 0);
		$q = $this->db->get("order");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_rejected");

			echo json_encode($callback);
			return;
		}
		
		$roworder = $q->row();
		$trail['reason'] = $reason;
		$trail['order'] = $roworder;
					
		unset($update);
		
		$update['order_resetted'] = 0;
		$update['order_rejected_comment'] = $reason;
		$update['order_status'] = 0;
		$update['order_rejected'] = $this->sess['user_id'];
		$update['order_rejected_date'] = date("Y-m-d H:i:s");
		
		$this->db->where("order_id", $roworder->order_id);
		$this->db->update("order", $update);
		
		$this->db->where("order_catalog_report_catalog", $roworder->order_id);
		$q = $this->db->get("order_catalog_report");
		$rowreports = $q->result();
		
		$trail['reporter'] = $roworder;
		
		unset($update);
		
		$update['order_catalog_report_status'] = 0;
		$this->db->where("order_catalog_report_catalog", $roworder->order_id);
		$this->db->update("order_catalog_report", $update);											
		
		unset($insert);
		
		$insert['ildp_trail_order'] = $roworder->order_id;
		$insert['ildp_trail_user'] = $this->sess['user_id'];
		$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_act'] = "rejected";
		$insert['ildp_trail_data'] = json_encode($trail);
		
		$this->db->insert("ildp_trail", $insert);		
				
		$nextapproved[] = $roworder;
		$this->mailtonextapproved($nextapproved, "rejected", $insert);
		
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lorder_rejected");
		$callback['redirect'] = site_url(array("ildp", "approval"));

		echo json_encode($callback);		
	}
	
	function mytrail($orderid)
	{
		if (! $this->sess)
		{
			redirect(base_url());
		}
		
		$this->mysmarty->assign("orderid", $orderid);
		$this->mysmarty->assign("ltrail", $this->config->item("ltrail"));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildp/trail/index.html");
		$this->mysmarty->display("sess_template.html");								
	}

	function searchtrail($orderid, $offset=0)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$this->db->order_by("ildp_trail_created", "asc");
		$this->db->where("ildp_trail_order", $orderid);
		$this->db->join("user", "ildp_trail_user = user_id");
		$this->db->limit($limit, $offset);
		$q = $this->db->get("ildp_trail");
		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$t = dbmaketime($rows[$i]->ildp_trail_created);
			$rows[$i]->ildp_trail_activity = $this->config->item($rows[$i]->ildp_trail_act."_by")." (".$rows[$i]->user_npk.") ".$rows[$i]->user_first_name." ".$rows[$i]->user_last_name;
			$rows[$i]->ildp_trail_created_fmt = date("d/m/Y H:i:s", $t);
			if ($rows[$i]->ildp_trail_act == "rejected")
			{
				$data = json_decode($rows[$i]->ildp_trail_data);
				$rows[$i]->ildp_trail_description = $data->reason;
			}
		}

		$this->db->where("ildp_trail_order", $orderid);
		$this->db->join("user", "ildp_trail_user = user_id");
		$total = $this->db->count_all_results("ildp_trail");
				
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->assign("lactivity", $this->config->item("lactivity"));		
		$this->mysmarty->assign("ldescription", $this->config->item("description"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		
		$callback['html'] = $this->mysmarty->fetch("ildp/trail/list.html");
		
		echo json_encode($callback);
		
	}
	
	function extdatarepropose()
	{
		$extid = isset($_POST['id']) ? $_POST['id'] : 0;
		
		unset($update);
		
		$update['externaldata_status'] = 1;
		$update['externaldata_repropose'] = date("Y-m-d H:i:s");
		
		$this->db->where("externaldata_id", $extid);
		$this->db->update("order_externaldata", $update);
								
		unset($insert);
		
		$this->db->where("externaldata_id", $extid);
		$this->db->join("order", "order_id = externaldata_order");
		$q = $this->db->get("order_externaldata");
		$roworder = $q->row();
		
		$insert['ildp_trail_order'] = $roworder->order_id;
		$insert['ildp_trail_user'] = $this->sess['user_id'];
		$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_act'] = "repropose";	
		$insert['ildp_trail_data'] = json_encode($roworder);
		
		$this->db->insert("ildp_trail", $insert);		
				
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lextdata_repropose_success");
		
		echo  json_encode($callback);		

	}
	
	function rejectcatalog($userid)
	{
		$reason = isset($_POST['reason']) ? $_POST['reason'] : "";
		$catalog = isset($_POST['catalog']) ? $_POST['catalog'] : "";
		
		if (! $catalog)
		{
			$callback['error'] = true;
			$callback['message'] = "Access denied";
			
			echo  json_encode($callback);
			return;
		}
		
		$this->db->order_by("order_date", "desc");
		$this->db->where("order_user", $userid);
		$this->db->join("user", "user_id = order_user");
		$this->db->limit(1, 0);
		$q = $this->db->get("order");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_rejected");

			echo json_encode($callback);
			return;
		}
		
		$row = $q->row();		
		$nextapproved[] = $row;
		
		$this->db->where("order_catalog_order", $row->order_id);		
		$this->db->where("order_catalog_catalog", $catalog);
		$this->db->join("training", "training_id = order_catalog_catalog");
		$q = $this->db->get("order_catalog");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_rejected");
			
			echo  json_encode($callback);
			return;
		}
		
		$row = $q->row();

		$newstatus = ($row->order_catalog_status == 1) ? 2 : 1;
		
		unset($update);
		
		$update['order_catalog_status'] = 2;
		$update['order_catalog_rejected'] = $this->sess['user_id'];
		$update['order_catalog_rejected_date'] = date("Y-m-d H:i:s");
		$update['order_catalog_rejected_comment'] = $reason;		
		
		$this->db->where("order_catalog_id", $row->order_catalog_id);
		$this->db->update("order_catalog", $update);
				
		$update['catalog'] = $row;
				
		$this->mailtonextapproved($nextapproved, "rejectedcatalog", $update);		

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lcatalog_rejected");
		$callback['src'] = base_url()."images/16/".(($newstatus == 1) ? "active.png" : "inactive.png");
		
		echo  json_encode($callback);
	}

	function rejectextdata($userid)
	{
		$reason = isset($_POST['reason']) ? $_POST['reason'] : "";
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		
		if (! $id)
		{
			$callback['error'] = true;
			$callback['message'] = "Access denied";
			
			echo  json_encode($callback);
			return;
		}
		
		$this->db->order_by("order_date", "desc");
		$this->db->where("order_user", $userid);
		$this->db->join("user", "user_id = order_user");
		$this->db->limit(1, 0);
		$q = $this->db->get("order");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_exdata_rejected");

			echo json_encode($callback);
			return;
		}
		
		$row = $q->row();		
		
		$laststatus = sprintf($this->config->item("lrejected_by"), "(".$this->sess['user_npk'].") ".$this->sess['user_first_name']." ".$this->sess['user_last_name']);
		$nextapproved[] = $row;
		
		$this->db->where("externaldata_order", $row->order_id);		
		$this->db->where("externaldata_id", $id);
		$q = $this->db->get("order_externaldata");

		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lorder_exdata_rejected");
			
			echo  json_encode($callback);
			return;
		}
		
		$row = $q->row();

		$newstatus = ($row->externaldata_status == 1) ? 2 : 1;
		
		unset($update);
		
		$update['externaldata_status'] = 2;
		$update['externaldata_rejector'] = $this->sess['user_id'];
		$update['externaldata_rejected'] = date("Y-m-d H:i:s");
		$update['externaldata_reason'] = $reason;		
		
		$this->db->where("externaldata_id", $row->externaldata_id);
		$this->db->update("order_externaldata", $update);
				
		$update['externaldata'] = $row;
				
		$this->mailtonextapproved($nextapproved, "rejectedextdata", $update);		

		$callback['laststatus'] = $laststatus;
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lexternaldata_rejected");
		$callback['src'] = base_url()."images/16/".(($newstatus == 1) ? "active.png" : "inactive.png");
		
		echo  json_encode($callback);
	}
	
	function rejectedcomment($id)
	{				
		$this->db->where("order_catalog_id", $id);
		$this->db->join("user", "user_id = order_catalog_rejected");
		$q = $this->db->get("order_catalog");
		$row = $q->row();
		
		$t = dbmaketime($row->order_catalog_rejected_date);
		$row->order_catalog_rejected_date_fmt = date("d/m/Y H:i:s", $t);
		
		$callback['rejector'] = "(".$row->user_npk.")".$row->user_first_name." ".$row->user_last_name;
		$callback['date'] = $row->order_catalog_rejected_date_fmt;
		$callback['comment'] = $row->order_catalog_rejected_comment;
		
		echo json_encode($callback);
	}
	
	function changeatasan()
	{
		$npkori = isset($_POST['npkori']) ? trim($_POST['npkori']) : 0;		
		$npknew = isset($_POST['npknew']) ? trim($_POST['npknew']) : 0;
		
		if (! $npknew)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lempty_npk");
			
			echo json_encode($callback);
			return;			
		}
		
		$this->db->where("user_npk", $npknew);
		$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
		$q = $this->db->get("user");
		
		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_not_already_exist_npk");
			
			echo json_encode($callback);
			return;	
		}
		
		$row = $q->row();

		$callback['error'] = false;
		$callback['user'] = $row;
			
		echo json_encode($callback);				
	}
	
	function queue()
	{
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
		$this->approval(1);
	}
	
	function resetform($userid)
	{				
		$users = isset($_POST['users']) ? $_POST['users'] : array();
		if ((! isset($users)) || (count($users) == 0))
		{
			if ($userid == 0)
			{
				// alert, ini dari multiple reset

				$callback['error'] = true;
				$callback['message'] = $this->config->item("lildp_form_reset_empty");
				
				echo json_encode($callback);			
				return;				
			}
			else
			{
				$this->db->where("order_id", $userid);
				$q = $this->db->get("order");				
				$row = $q->row();
				$users[] = $row->order_user;
			}
		}
		
		// looping dengan $users
		
		if (count($users))
		{
			$this->db->where_in("user_id", $users);
			$q = $this->db->get("user");
			$rows = $q->result();
						
			for($i=0; $i < count($rows); $i++)
			{
				$userdetail[$rows[$i]->user_id] = $rows[$i];
			}
		}
		
		for($i=0; $i < count($users); $i++)
		{
			$userid = $users[$i];
		
			$isvalid = $this->ildpmodel->isValidRejector($userid, $this->topicmodel);
			
			if (! $isvalid)
			{
				$callback['error'] = true;
				$callback['message'] = "Access denied";
				
				echo json_encode($callback);			
				return;
			}								
			
			$this->db->order_by("order_date", "desc");
			$this->db->where("order_user", $userid);
			$this->db->join("user", "user_id = order_user");
			$this->db->limit(1, 0);
			$q = $this->db->get("order");
	
			if ($q->num_rows() == 0)
			{
				$callback['error'] = true;
				$callback['message'] = "Access denied";
	
				echo json_encode($callback);
				return;
			}
			
			$roworder = $q->row();
			
			// reset atasan
			
			unset($update);
			$update['order_catalog_report_status'] = 0;
			
			$this->db->where("order_catalog_report_catalog", $roworder->order_id);
			$this->db->update("order_catalog_report", $update);
			
			// reset order
	
			unset($update);
			$update['order_status'] = 0;
			$update['order_resetted'] = $this->sess['user_id'];
			$update['order_resetted_date'] = date("Y-m-d");
			$update['order_rejected'] = 0;
	
			$this->db->where("order_id", $roworder->order_id);
			$this->db->update("order", $update);
			
			// reset catalog
			
			unset($update);
			
			$update['order_catalog_status'] = 1;
			$update['order_catalog_rejected'] = 0;			
			
			$this->db->where("order_catalog_order", $roworder->order_id);
			$this->db->update("order_catalog", $update);
			
			// reset catalog report

			unset($update);
			
			$update['order_catalog_report_status'] = 0;
			$update['order_catalog_report_approver'] = 0;			
			
			$this->db->where("order_catalog_report_catalog", $roworder->order_id);
			$this->db->update("order_catalog_report", $update);
			
			// reset external data

			unset($update);
			
			$update['externaldata_status'] = 1;
			$update['externaldata_rejected'] = 0;			
			
			$this->db->where("externaldata_order", $roworder->order_id);
			$this->db->update("order_externaldata", $update);			
				
			// add trail
			
			unset($insert);
			
			$insert['ildp_trail_order'] = $roworder->order_id;
			$insert['ildp_trail_user'] = $this->sess['user_id'];
			$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
			$insert['ildp_trail_act'] = "reset";	
			$insert['ildp_trail_data'] = json_encode($roworder);
			
			$this->db->insert("ildp_trail", $insert);		
			
			
			if (! isset($userdetail[$userid])) continue;
			
			$this->mailtonextapproved(array($userdetail[$userid]), "reset");
		}
	
		$callback['message'] = $this->config->item("lildp_resetform_successfully");
		$callback['error'] = false;
		$callback['redirect'] = site_url(array("ildp", "queue"));
	
		echo json_encode($callback);		
		return;		
	}
	
	function approvalhist()
	{
		if (! $this->sess)
		{
			redirect(base_url());
		}
		
		$this->mysmarty->assign("lapprovalhist_list", $this->config->item("lapprovalhist_list"));		
		$this->mysmarty->assign("lheader_approvalhist_list", $this->config->item("lheader_approvalhist_list"));				
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("left_content", "user/menu.html");		
		$this->mysmarty->assign("main_content", "ildp/approvalhist/index.html");
		$this->mysmarty->display("sess_template.html");						
		
	}
	
	function searchapprovalhist($offset=0)
	{
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "order_user_npk";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		
		$orderids = $this->ildpmodel->getApprovalHist();		
		
		// get order
		
		if ($sortby == "user_npk")
		{
			$sortby = "order_user_npk";
		}
		
		$this->db->select("order.*, order_user.user_npk order_user_npk, order_user.user_first_name order_user_first_name, order_user.user_last_name order_user_last_name, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");
		$this->db->limit($limit, $offset);
		$this->db->order_by($sortby, $orderby);
		$this->db->where_in("order_id", $orderids);
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");		
		$this->db->join("user order_user", "order_user.user_id = order_user", "left outer");		
		$q = $this->db->get("order");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{			
			$t = dbmaketime($rows[$i]->order_date);
			$rows[$i]->order_date_fmt = date("d/m/Y H:i:s", $t);
			$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);
		}
		
		$this->mysmarty->assign("rows", $rows);
					
		$this->db->where_in("order_id", $orderids);
		$this->db->join("user", "order_user = user_id");
		$total = $this->db->count_all_results("order");
				
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;
		$this->mysmarty->assign("nuser", $total);

		$this->mysmarty->assign("paging", $this->pagination1->create_links());								
		$this->mysmarty->assign("lname", $this->config->item("name"));		
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldate", $this->config->item("ldate"));		
		
		$callback['html'] = $this->mysmarty->fetch("ildp/approvalhist/list.html");
		
		echo json_encode($callback);
		
	}	
	
	function report()
	{
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_status", 1);
		$this->db->where("level_group_parent", 0);
		$q = $this->db->get("level_group");
		$rows = $q->result();
		
		$this->mysmarty->assign("rows", $rows);
		
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("lsubmitdate", $this->config->item("lsubmitdate"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lsubmitted", $this->config->item("lsubmitted"));
		$this->mysmarty->assign("lapproved", $this->config->item("lapproved"));
		$this->mysmarty->assign("lrejected", $this->config->item("lrejected"));
		$this->mysmarty->assign("lall", $this->config->item("lall"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));		
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/report/index.html");
		$this->mysmarty->display("sess_template.html");			
	}
	
	function searchreport($offset=0)
	{
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = (isset($_POST['limit']) && $_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
		$act = isset($_POST['act']) ? $_POST['act'] : "";
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		$submit1 = isset($_POST['submit1']) ? $_POST['submit1'] : 0;
		$submit2 = isset($_POST['submit2']) ? $_POST['submit2'] : 0;
		$dir = isset($_POST['dir']) ? $_POST['dir'] : 0;
		$group = isset($_POST['group']) ? $_POST['group'] : 0;
		
		if ($group)
		{
			$groups[] = $group;
			$this->levelmodel->getparentlevelgroupids($group, $groups);
		}
		else
		if ($dir)
		{
			$groups[] = $dir;
			$this->levelmodel->getparentlevelgroupids($dir, $groups);
		}
		
		if (isset($groups))
		{
			$this->db->where_in("level_group_id", $groups);
			$this->db->join("level_group", "level_group_id = jabatan_level_group");
			$q = $this->db->get("jabatan");
			$rows = $q->result();
			
			$jabatans[] = 0;
			for($i=0; $i < count($rows); $i++)
			{
				$jabatans[] = $rows[$i]->jabatan_id;
			}
		}
		
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lperiod", $this->config->item("period"));
		$this->mysmarty->assign("lapprove_hrld", $this->config->item("lapprove_hrld"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		switch($searchby)
		{
			case "user_npk":
				$this->db->where("order_user LIKE '%".$keyword."%'", null);
			break;
			case "status":
				switch($status)
				{
					case 1:
						$this->db->where("order_status", 1);
					break;
					case 2:
						$this->db->where("order_status", 4);
					break;
					case 3:
						$this->db->where("order_status", 0);
						$this->db->where("order_rejected >", 0);
					break;					
				}				
			break;	
			case "submit":
				if ($submit1)
				{
					$t = formmaketime($submit1." 00:00:00");
					$this->db->where("order_date >=", date("Y-m-d H:i:s", $t));
				}
				if ($submit2)
				{
					$t = formmaketime($submit2." 23:59:59");
					$this->db->where("order_date <=", date("Y-m-d H:i:s", $t));
				}				
			break;
			case "group":
				if (isset($groups))
				{
					$this->db->where_in("jabatan_id", $jabatans);
				}
			break;
		}
		
		if ($act != "export")
		{
			$this->db->limit($limit, $offset);
		}
				
		if ($sortby == "user_npk")
		{
			$sortby = "order_user_npk";
		}
				
		$this->db->order_by($sortby, $orderby);
		$this->db->select("order.*, jabatan.*, level_group.*, order_catalog.*, training.*,  order_user.user_npk order_user_npk, order_user.user_first_name order_user_first_name, order_user.user_last_name order_user_last_name, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name, resettor.user_npk resettor_npk, resettor.user_first_name resettor_firstname, resettor.user_last_name resettor_last_name");
		$this->db->join("user order_user", "order_user.user_id = order_user");
		$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
		$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
		$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
		$this->db->join("user resettor", "resettor.user_id = order_resetted", "left outer");
		$this->db->join("jabatan", "order_user.user_jabatan = jabatan_id");
		$this->db->join("level_group", "jabatan_level_group = level_group_id");
		$this->db->join("order_catalog", "order_catalog_order = order_id");
		$this->db->join("training", "order_catalog_catalog = training_id");
		$q = $this->db->get("order");
		
		$rows = $q->result();						
		for($i=0; $i < count($rows); $i++)
		{
			$cats = array();
			$this->levelmodel->getparentlevelgroups($rows[$i]->jabatan_level_group, $cats);
			
			$rows[$i]->categories = $cats;
			$rows[$i]->order_catalog_period_t = dbintmaketime($rows[$i]->order_catalog_period*100+1, 0);
			$rows[$i]->order_catalog_period_fmt = date("F Y", $rows[$i]->order_catalog_period_t);
			
			if ($rows[$i]->order_status == 4)
			{
				$t = dbmaketime($rows[$i]->order_hrld_date);
				$rows[$i]->order_hrld_date_fmt = date("d/m/Y", $t);
			}
			else
			{
				$rows[$i]->order_hrld_date_fmt = "-";
			}
			
			$rows[$i]->last_status = $this->ildpmodel->getLastStatus($rows[$i]);			

		}
		
		if ($act == "export")
		{
			$this->load->library("xlswriter");
			$this->xlswriter->send(date("Ymd-His")."-ildp.xls");
			
			$worksheet =& $this->xlswriter->addWorksheet("ildp");
			
			$worksheet->write(0, 0, 'NPK');
			$worksheet->write(0, 1, 'NAMA');
			$worksheet->write(0, 2, 'DIREKTORAT');
			$worksheet->write(0, 3, 'GROUP');
			$worksheet->write(0, 4, 'JUDUL TRAINING');
			$worksheet->write(0, 5, 'PERIODE TRAINING');
			$worksheet->write(0, 6, 'TANGGAL AKHIR PERSETUJUAN HRLD');
			$worksheet->write(0, 7, 'STATUS APPROVAL/REJECT');

			for($i=0; $i < count($rows); $i++)
			{
				$worksheet->write($i+1, 0, $rows[$i]->order_user_npk);	
				$worksheet->write($i+1, 1, $rows[$i]->order_user_first_name." ".$rows[$i]->order_user_last_name);					
				if (isset($rows[$i]->categories[1]))
				{
					$worksheet->write($i+1, 2, $rows[$i]->categories[1]->level_group_name);	
				}
				else
				{
					$worksheet->write($i+1, 2, "");	
				}
				
				if (isset($rows[$i]->categories[0]))
				{
					$worksheet->write($i+1, 3, $rows[$i]->categories[0]->level_group_name);	
				}
				else
				{
					$worksheet->write($i+1, 3, "");	
				}
				$worksheet->write($i+1, 4, $rows[$i]->training_name);	
				$worksheet->write($i+1, 5, $rows[$i]->order_catalog_period_fmt);	
				$worksheet->write($i+1, 6, $rows[$i]->order_hrld_date_fmt);	
				$worksheet->write($i+1, 7, $rows[$i]->last_status);	
			}						
			
			$this->xlswriter->close();
			
			return;
		}
		
		$this->mysmarty->assign("rows", $rows);

		switch($searchby)
		{
			case "user_npk":
				$this->db->where("user_npk LIKE '%".$keyword."%'", null);
			break;
			case "status":
				switch($status)
				{
					case 1:
						$this->db->where("order_status", 1);
					break;
					case 2:
						$this->db->where("order_status", 4);
					break;
					case 3:
						$this->db->where("order_status", 0);
						$this->db->where("order_rejected >", 0);
					break;					
				}				
			break;
			case "submit":
				if ($submit1)
				{
					$t = formmaketime($submit1." 00:00:00");
					$this->db->where("order_date >=", date("Y-m-d H:i:s", $t));
				}
				if ($submit2)
				{
					$t = formmaketime($submit2." 23:59:59");
					$this->db->where("order_date <=", date("Y-m-d H:i:s", $t));
				}				
			break;
			case "group":
				if (isset($groups))
				{
					$this->db->where_in("user_jabatan", $jabatans);
				}
			break;			
		}
		
		$this->db->join("user", "user_id = order_user");
		$this->db->join("jabatan", "user_jabatan = jabatan_id");
		$this->db->join("level_group", "jabatan_level_group = level_group_id");
		$this->db->join("order_catalog", "order_catalog_order = order_id");
		$this->db->join("training", "order_catalog_catalog = training_id");
		$total = $this->db->count_all_results("order");		
		
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$callback['html'] = $this->mysmarty->fetch("ildp/report/list.html");
		
		echo json_encode($callback);		
	}
	
	function groups($dir)
	{
		
		if ($dir)
		{
			$this->db->where("level_group_parent", $dir);
		}
		
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_nth", 2);		
		$q = $this->db->get("level_group");
		$rows = $q->result();
		
		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->assign("lall", $this->config->item("lall"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/report/group.html");			
		
		echo json_encode($callback);
		return;
	}
	
	function catalogdetail($id)
	{
		if (! isset($this->sess))
		{
			redirect(base_url());
		}
		
		if (isset($this->sess->asadmin))
		{
			redirect(base_url());
		}
				
		$regtime = $this->ildpmodel->isRegistrationTime($this->sess['user_id']);		
		if (! $regtime)
		{
			redirect(base_url());
		}
		
		$this->db->where("training_type", 3);
		$this->db->where("training_id", $id);
		$this->db->join("category", "category_id = training_topic");
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$year1 = date("Y", $regtime[0]);
		$month2 = date("n", $regtime[1]);
		$year2 = date("Y", $regtime[1]);
		
		$gmonths = $this->config->item("lmonths");
		
		if ($year2 != $year1)
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".$year2;
			}
		}
		else
		if ($month2 >= $this->config->item("month_year"))
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".($year1+1);
			}				
		}
		else
		{
			for($i=1; $i <= 12; $i++)
			{
				$months[sprintf("%d%02d", $year2, $i)] = $gmonths[$i-1]." ".$year2;
			}
		}
		
		
		$this->mysmarty->assign("months", $months);		
		$this->mysmarty->assign("catalog", $row);
		$this->mysmarty->assign("ltopic", $this->config->item("ltopic"));
		$this->mysmarty->assign("ltraining", $this->config->item("ltraining"));		
		$this->mysmarty->assign("lperiod", $this->config->item("lperiod"));
		$this->mysmarty->assign("laddtocart", $this->config->item("laddtocart"));		
$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
			
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "ildp/catalog/detail.html");
		$this->mysmarty->display("sess_template.html");		
		
	}
	
	function repropose($id)
	{				
		unset($update);
		$update['order_catalog_status'] = 1;
		$update['order_catalog_repropose'] = 1;
		
		$this->db->where("order_catalog_id", $id);
		$this->db->update("order_catalog", $update);
		
		$this->db->where("order_catalog_id", $extid);
		$this->db->join("order", "order_id = order_catalog_order");
		$q = $this->db->get("order_catalog");
		$roworder = $q->row();
		
		$insert['ildp_trail_order'] = $roworder->order_id;
		$insert['ildp_trail_user'] = $this->sess['user_id'];
		$insert['ildp_trail_created'] = date("Y-m-d H:i:s");
		$insert['ildp_trail_act'] = "repropose";	
		$insert['ildp_trail_data'] = json_encode($roworder);
		
		$this->db->insert("ildp_trail", $insert);				
		
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lrepropose_success");
		
		echo json_encode($callback);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
