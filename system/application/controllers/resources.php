<?php
include_once "base.php"; 

class Resources extends Base{
	var $sess;
	var $lang;
	var $modules;

	function Resources()
	{
		//parent::Controller();	
		parent::Base();	
	
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');		
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
		$this->load->model("levelmodel");
		$this->load->model("topicmodel");
		$this->load->model("usermodel");
		$this->load->model("resourcesmodel");		
		
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
		}		
		$this->langmodel->init();
		
	}
	
	function index($topicid=0)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "reference_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		
		
		$sess = unserialize($usess);
		
		if ((! isset($this->modules['resources'])) && (! isset($this->modules['trainee'])))
		{
			redirect(base_url());
		}
		
		if ($topicid)
		{
			$this->db->where("category_id", $topicid);
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
				$rowtopic = $q->row();
				$this->mysmarty->assign("rowtopic", $rowtopic);
			}
		}
		
		$arrRefIds = array();
		$arrRefIds[] = 0;
		
		// by level group,jabatan, function, allnpk
		if (! isset($sess['asadmin'])) {
			$arrRefIds = $this->resourcesmodel->getResourcesIds($sess, $topicid);
		}
		/**/
		
		$this->db->order_by($sortby, $orderby);
		if ($topicid)
		{
			$this->db->where("reference_topic", $topicid);
		}
		if ($keyword && $searchby)
		{
			if (in_array($searchby, array("reference_name", "category_name")))
			{
				$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
			}
			else
			if ($searchby == "size_lt")
			{
				if (is_numeric($keyword))
				{
					$this->db->where("reference_filesize <", $keyword*1024);
				}
			}
			else
			if ($searchby == "size_gt")
			{
				if (is_numeric($keyword))
				{
					$this->db->where("reference_filesize >", $keyword*1024);
				}
			}
		}	
		
		/*if (! isset($sess['asadmin'])) {
			$this->db->select("reference_levelgroup_reference, reference_id,	reference_name , reference_filesize ,reference_topic,category_name,reference_filetype");
			$this->db->select("CASE reference_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END reference_status_desc ", false);
			$this->db->join("lmsv2_reference_levelgroup", "reference_id = reference_levelgroup_reference");
			$this->db->where("reference_status", 1);
			$this->db->group_by("reference_levelgroup_reference, reference_id,	reference_name , reference_filesize ,reference_topic,category_name,reference_filetype,reference_status_desc");
		}else {
			$this->db->select("*, CASE reference_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END reference_status_desc ", false);
		}
		$this->db->join("category", "category_id = reference_topic");
		

		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$arrRefIds[] = $rows[$i]->reference_id;			
		}
		*/
		
		$this->db->select("*, CASE reference_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END reference_status_desc ", false);
		$this->db->join("category", "category_id = reference_topic");
		if (! isset($sess['asadmin'])) 
			$this->db->where_in("reference_id",$arrRefIds);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
	
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->size_fmt = number_format($list[$i]->reference_filesize/1024, 2, ",", ".");
			
			$type = explode("/", $list[$i]->reference_filetype);
			$ext = explode(".", $list[$i]->reference_filename);
			
			switch($type[0])
			{
				case "image":
					$list[$i]->reference_png = "doc_image.png";
				break;
				case "text":
					$list[$i]->reference_png = "doc_text.png";
				break;				
			}
			
			if (isset($type[1]))
			{
				switch($type[1])
				{
					case "pdf":
						$list[$i]->reference_png = "doc_pdf.png";
					break;
					case "xhtml+xml":
					case "xml-dtd":
					case "html":
					case "xml":
						$list[$i]->reference_png = "doc_website.png";
					break;
					case "zip":
						$list[$i]->reference_png = "doc_zip.png";
					break;
					case "vnd.ms-excel":
						$list[$i]->reference_png = "doc_excel.png";
					break;
					case "x-shockwave-flash":
						$list[$i]->reference_png = "doc_flash.png";
					break;
					case "vnd.ms-powerpoint":
						$list[$i]->reference_png = "doc_powerpoint.png";
					break;
					case "msword":
						$list[$i]->reference_png = "doc_word.png";
					break;
					default:		
						if (! isset($list[$i]->reference_png))
						{
							$list[$i]->reference_png = "doc_white.png";							
						}
				}				
			}
		}
		
		if ($topicid)
		{
			$this->db->where("reference_topic", $topicid);
		}

		if ($keyword && $searchby)
		{
			if (in_array($searchby, array("reference_name", "category_name")))
			{
				$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
			}
			else
			if ($searchby == "size_lt")
			{
				if (is_numeric($keyword))
				{
					$this->db->where("reference_filesize <", $keyword*1024);
				}
			}
			else
			if ($searchby == "size_gt")
			{
				if (is_numeric($keyword))
				{
					$this->db->where("reference_filesize >", $keyword*1024);
				}
			}
		}
		
		$this->db->join("category", "category_id = reference_topic");
		if (! isset($sess['asadmin'])) 
			$this->db->where_in("reference_id",$arrRefIds);
		
		$total = $this->db->count_all_results("reference");
		//echo $this->db->last_query();
		$this->db->flush_cache();

		
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
		$this->pagination1->lang_title = $this->config->item('unit');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());				
		$this->mysmarty->assign("list", $list);
		
		$this->mysmarty->assign("lsort_by_resource_name", $this->config->item("lsort_by_resource_name"));
		$this->mysmarty->assign("lsort_by_topic_name", $this->config->item("lsort_by_topic_name"));
		$this->mysmarty->assign("lsort_by_size", $this->config->item("lsort_by_size"));
		$this->mysmarty->assign("lsort_by_filetype", $this->config->item("lsort_by_filetype"));
		
		$this->mysmarty->assign("lresources", $this->config->item("lresources"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lresources_name", $this->config->item("lresources_name"));
		
		$this->mysmarty->assign("ltopic", $this->config->item("topic"));		
		$this->mysmarty->assign("lsize", $this->config->item("lsize"));
		$this->mysmarty->assign("lresource_type", $this->config->item("lresource_type"));		
		$this->mysmarty->assign("date_added", $this->config->item("date_added"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("ldelete", $this->config->item("ldelete"));
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("sort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
				
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "resources/list.html");
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
	
	function form($id=0, $topicid=0)
	{
		$this->checkadmin();
		
		if (! isset($this->modules['resources']))
		{
			redirect(base_url());
		}
		
		if ($id)
		{
			$this->db->where("reference_id", $id);
			$q = $this->db->get("reference");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row();			
			
			$arr = array();
			$this->topicmodel->getCategoryIds($row->reference_topic, $arr);
			
			$this->mysmarty->assign("row", $row);
			$def = $arr[0];
		}
		else
		if ($topicid)
		{
			$arr = array();
			$this->topicmodel->getCategoryIds($topicid, $arr);
			
			$def = $arr[0];
		}
		else
		{
			$def = 0;
		}
		
		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
				
		$this->mysmarty->assign("tree", $tree);
				
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		$this->mysmarty->assign("ltopic", $this->config->item("topic"));
		$this->mysmarty->assign("ldescription", $this->config->item("description"));
		$this->mysmarty->assign("lresources", $this->config->item("resources"));
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));		
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "resources/form.html");
		$this->mysmarty->display("sess_template.html");
	}
		
	function save($id=0)
	{						
		$this->checkadmin();
		
		if (! isset($this->modules['resources']))
		{
			redirect(base_url());
		}

		$setting = $this->commonmodel->GetSetting();
		
		$cat = isset($_POST["cat"]) ? $_POST["cat"] : 0;
		$topic = isset($_POST["topic"]) ? $_POST["topic"] : 0;
		$name = isset($_POST["name"]) ? $_POST["name"] : "";
		$desc = isset($_POST["desc"]) ? $_POST["desc"] : "";
		$file = isset($_FILES["file"]) ? $_FILES["file"] : "";
		
		$nofile = 0;

		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("lerr_empty_resource_name");
		}
		
		if (! $file)
		{
			if (! $id) 
			{				
				$errs[] = $this->config->item("lerr_empty_resource_file");
			}
			else
			{
				$nofile = 1;
			}
		}
		else
		if (! $file['name'])
		{
			if (! $id) 
			{								
				$errs[] = $this->config->item("lerr_empty_resource_file");
			}
			else
			{
				$nofile = 2;
			}
		}
		else
		if ($file['size'] == 0)
		{
			$errs[] = $this->config->item("lerr_empty_resource_file");
		}
		else
		{
			if (isset($setting['resourcemaxsize']))
			{
				$maxsize = $setting['resourcemaxsize']*1024;
				if ($file['size'] > $maxsize)
				{
					$errs[] = sprintf($this->config->item("lerr_invalid_resource_filesize"), $setting['resourcemaxsize']);
				}
			}
		}
		
		if (count($errs) == 0)
		{
			if (! $nofile)
			{
				echo "LL: ".$nofile;
				if (isset($setting['resourcetype']))
				{
					$settingtipe = unserialize($setting['resourcetype']);
					$settingtipe = array_filter($settingtipe);										
					
					$tipe = $file['type'];
					$tipes = explode("/", $tipe);
					
					if (! in_array("*", $settingtipe))
					{
						if ((! in_array($tipe, $settingtipe)) && (! in_array($tipes[0], $settingtipe)) && (! in_array($tipes[1], $settingtipe)))
						{
							$errs[] = sprintf($this->config->item("lerr_invalid_resource_filetype"), implode(", ", $settingtipe));
						}
					}
				}
			}
		}
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			$html = str_replace("\n", "", $html);
			$html = str_replace("\r", "", $html);
			$html = str_replace("'", "", $html);
			
			echo "<script>parent.setErrorMessage('".$html."');</script>";
			
			return;
		}
		
		unset($data);
		
		if (! $nofile)
		{
			if (strpos($file['name'], ".") !== FALSE)
			{
				$names = explode(".", $file['name']);
				$ext = array_pop($names);
				
				$newfilename = substr(md5(uniqid()), 0, 80).".".$ext;			
			}
			else
			{
				$newfilename = $name;
			}
			
			move_uploaded_file($file['tmp_name'], BASEPATH."../resources/".$newfilename);
			
			$data['reference_filetupname'] = $newfilename;
			$data['reference_filename'] = $file['name'];
			$data['reference_filetype'] = $file['type'];
			$data['reference_filesize'] = $file['size'];			
		}

		$data['reference_name'] = $name;
		$data['reference_desc'] = $desc;
		$data['reference_topic'] = $topic;
		
		if ($id)
		{
			if (! $nofile)
			{
				$this->db->where("reference_id", $id);
				$q = $this->db->get("reference");
				$this->db->flush_cache();
				
				if ($q->num_rows() > 0)
				{
					$rowfile = $q->row();
					
					@unlink(BASEPATH."../resources/".$rowfile->reference_filetupname);
					
				}
			}
			
			$this->db->where("reference_id", $id);
			$this->db->update("reference", $data);
			
			$redirect = site_url(array("resources"));
			echo "<script>parent.setSuccess('".$this->config->item("ok_update_resource")."', '".$redirect."');</script>";
			return;
		}				
		
		$data['reference_created'] = date("Ymd");
		$data['reference_creator'] = $this->sess['user_id'];		
		$data['reference_status'] = 1;		
		
		$this->db->insert("reference", $data);
		$lastid = $this->db->insert_id();
		
		$redirect = site_url(array("resources", "participant", $lastid));
		echo "<script>parent.setSuccess('".$this->config->item("ok_add_resource")."', '".$redirect."');</script>";
	}
	
	function changestatus($id, $status)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['resources']))
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
		
		$data['reference_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("reference_id", $id);
		$this->db->update("reference", $data);				
	}
	
	function participant($id)
	{
		$this->checkadmin();
		
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$rowreference = $q->row();
		
		// all npk
		
		$this->db->where("reference_npk_reference", $rowreference->reference_id);
		$q = $this->db->get("reference_npk");		
		$this->db->flush_cache();
		
		$npks = $q->result();
		
		$this->db->where("reference_levelgroup_reference", $rowreference->reference_id);
		$totallevelgroup = $this->db->count_all_results("reference_levelgroup");		
		
				
		$arrlevel = array();
		$this->levelmodel->getChilds($arrlevel, 0);
				
		$this->mysmarty->assign("isresources", 1);
		$this->mysmarty->assign("levels", $arrlevel);				
		$this->mysmarty->assign("row", $rowreference);
		$this->mysmarty->assign("npks", $npks);
		$this->mysmarty->assign("totalnpk", count($npks));
		$this->mysmarty->assign("isopenroot", $totallevelgroup > 0);
		
		$this->mysmarty->assign("lall_staff", $this->config->item("all_staff"));
		$this->mysmarty->assign("lresources_participant", $this->config->item("lresources_participant"));		
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("limport_npk", $this->config->item("limport_npk"));		
		
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("ljabatan", $this->config->item("ljabatan"));
		$this->mysmarty->assign("lgroup_list", $this->config->item("group_list"));		

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "resources/participant.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function saveparticipant()
	{
		$errs = array();
		
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo json_encode(array("err"=>1, "message"=>$this->config->item("err_exipred_session")));			
			return;
		}

		$resourceid = isset($_POST['resourceid']) ? $_POST['resourceid'] : "";
		if (! $resourceid)
		{
			echo json_encode(array("err"=>1, "message"=>$resourceid." :: ".$this->config->item("err_exipred_session")));			
			return;
		}
				
		$allemp = isset($_POST['allemp']) ? $_POST['allemp'] : "";
		$jabatans = isset($_POST['jabatan']) ? $_POST['jabatan'] : false;
		$levelgroups = isset($_POST['levelgroup']) ? $_POST['levelgroup'] : false;
		$functions = isset($_POST['function']) ? $_POST['function'] : false;
		$npks = isset($_POST['npk']) ? $_POST['npk'] : false;		
		
		$found = true;
		if ((! $allemp) && (! $jabatans) && (! $levelgroups) && (! $functions) && (! $npks))
		{
			$found = false;			
		}

		foreach($_POST as $key=>$val)
		{
			$pos = strpos($key, "allnpk");
			if ($pos === FALSE) continue;
			
			$val = substr($key, $pos);
			if ($val <= 0) continue;
			
			$allnpk[] = $val;
			$found =  true;
		}	
		
		if (! $found)
		{
			//$errs[] = $this->config->item("err_empty_participant");
		}		
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "message"=>$html));			
			return;
		}
		
		unset($data);			
		$data['reference_allstaff'] = $allemp;
		
		$this->db->where("reference_id", $resourceid);
		$this->db->update("reference", $data);
		$this->db->flush_cache();
		
		if ($allemp)
		{
			echo json_encode(array("err"=>0, "message"=>$this->config->item("ok_update_participant_training")));
			return;	
		}
		
		// level group
		
		$this->db->where("reference_levelgroup_reference", $resourceid);
		$this->db->delete("reference_levelgroup");
		$this->db->flush_cache();
		
		if ($levelgroups)
		{
			foreach($levelgroups as $val)
			{
				unset($data);
				
				$data['reference_levelgroup_reference'] = $resourceid;
				$data['reference_levelgroup_levelgroup'] = $val;
				
				$this->db->insert("reference_levelgroup", $data);
				$this->db->flush_cache();
			}
		}

		// jabatan
		
		$this->db->where("reference_jabatan_reference", $resourceid);
		$this->db->delete("reference_jabatan");
		$this->db->flush_cache();
		
		if ($jabatans)
		{
			foreach($jabatans as $val)
			{
				unset($data);
				
				$data['reference_jabatan_reference'] = $resourceid;
				$data['reference_jabatan_jabatan'] = $val;
				
				$this->db->insert("reference_jabatan", $data);
				$this->db->flush_cache();
			}
		}
				
		// npks
		
		$this->db->where("reference_npk_reference", $resourceid);
		$this->db->delete("reference_npk");
		$this->db->flush_cache();
		
		if ($npks)
		{
			foreach($npks as $val)
			{
				unset($data);
				
				$data['reference_npk_reference'] = $resourceid;
				$data['reference_npk_npk'] = $val;
				
				$this->db->insert("reference_npk", $data);
				$this->db->flush_cache();
			}
		}
				
		// function
		
		$this->db->where("reference_function_reference", $resourceid);
		$this->db->delete("reference_function");
		$this->db->flush_cache();
		
		if ($functions)
		{
			foreach($functions as $val)
			{
				unset($data);
				
				$data['reference_function_reference'] = $resourceid;
				$data['reference_function_function'] = $val;
				
				$this->db->insert("reference_function", $data);
				$this->db->flush_cache();
			}
		}		

		echo json_encode(array("err"=>0, "message"=>$this->config->item("ok_update_participant_training")));
		return;							
	}
	
	
	function open($id)
	{
		$this->checkadmin();
		
		if ((! isset($this->modules['resources'])) && (! isset($this->modules['trainee'])))
		{
			redirect(base_url());
		}
				
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
			return;
		}
		
		$rowresource = $q->row();
		
		$arrtopicresourceids = array();
		$this->topicmodel->getResourcesTopicsUser($this->sess, $arrtopicresourceids);
		$topicresourceids = count($arrtopicresourceids) ? array_keys($arrtopicresourceids) : array(0);	
		
		if (! in_array($rowresource->reference_topic, $topicresourceids))
		{
			redirect(base_url());
		}
		
		if (! is_readable(BASEPATH."../resources/".$rowresource->reference_filetupname))
		{
			redirect(site_url(array("generalsetting", "errmessage", "lfileresource_not_found")));
		}
		
		unset($data);
		
		$data['history_reference_reference'] = $rowresource->reference_id;
		$data['history_reference_date'] = date("Ymd");
		$data['history_reference_time'] = date("Gis");
		$data['history_reference_user'] = $this->sess['user_id'];
		
		$this->db->insert("history_reference", $data);
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", BASEPATH."../resources/".$rowresource->reference_filetupname);
		$this->mysmarty->display("sess_template.html");		
		
		//redirect(base_url()."resources/".$rowresource->reference_filetupname);
	}
	
	function download($id)
	{
		//unset session referrer
		$this->session->unset_userdata(array('referrer'=>''));
	
		$this->checkadmin();
		
		if ((! isset($this->modules['resources'])) && (! isset($this->modules['trainee'])))
		{
			redirect(base_url());
		}
		
	
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
			return;
		}
		
		$rowresource = $q->row();
		
		$arrtopicresourceids = array();
		$this->topicmodel->getResourcesTopicsUser($this->sess, $arrtopicresourceids);
		$topicresourceids = count($arrtopicresourceids) ? array_keys($arrtopicresourceids) : array(0);	
		
		if (! in_array($rowresource->reference_topic, $topicresourceids))
		{
			redirect(base_url());
		}
		
		if (! is_readable(BASEPATH."../resources/".$rowresource->reference_filetupname))
		{
			redirect(site_url(array("generalsetting", "errmessage", "lfileresource_not_found")));
		}
		
		unset($data);
		
		$data['history_reference_reference'] = $rowresource->reference_id;
		$data['history_reference_date'] = date("Ymd");
		$data['history_reference_time'] = date("Gis");
		$data['history_reference_user'] = $this->sess['user_id'];
		
		$this->db->insert("history_reference", $data);
				
		header("Content-Disposition: attachment; filename=\"".$rowresource->reference_filename."\"");
		header("Content-type: application/download");
		
		readfile(BASEPATH."../resources/".$rowresource->reference_filetupname);		
	}	
	
	function history()
	{														
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "reference_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";						

		$this->db->order_by($sortby, $orderby);
		
		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}

		$this->db->distinct();
		$this->db->select("reference.*, category.* ");				
		$this->db->join("reference", "history_reference_reference = reference_id");		
		$this->db->join("category", "reference_topic = category_id");
		$q = $this->db->get("history_reference", $limit, $offset);
		$this->db->flush_cache();
		$list = $q->result();


		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}						
		$this->db->distinct();
		$this->db->select("history_reference");				
		$total = $this->db->count_all_results("history_reference");
		$this->db->flush_cache();

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
		$this->pagination1->lang_title = $this->config->item('lhistory');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$referenceids = array(0);
		for($i=0; $i < count($list); $i++)
		{
			$referenceids[] = $list[$i]->reference_id;
		}
				
		$taketimes = $this->resourcesmodel->taketimes($sess, $referenceids);		
		$takelast = $this->resourcesmodel->takelast($sess, $referenceids);

		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->ntaked = isset($taketimes[$list[$i]->reference_id]) ? $taketimes[$list[$i]->reference_id] : 0;
			$list[$i]->nlasttaked = isset($takelast[$list[$i]->reference_id]) ? $takelast[$list[$i]->reference_id] : 0;
		}		
		
		// terakhir diambil
		
		$this->mysmarty->assign("list", $list);		
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));
		$this->mysmarty->assign("lcode", $this->config->item("lcode"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));		
		$this->mysmarty->assign("lmypersonal_report", strtoupper($this->config->item("lmypersonal_report")));
		$this->mysmarty->assign("ltraining_column", strtoupper($this->config->item('training_name')));
		$this->mysmarty->assign("ltimetakes", strtoupper($this->config->item('ltimetakes')));
		$this->mysmarty->assign("llasttake", strtoupper($this->config->item('llasttake')));
		$this->mysmarty->assign("llastscore", strtoupper($this->config->item('llastscore')));
		$this->mysmarty->assign("lresources_history", $this->config->item('lresources_history'));
		
		if (! isset($sess['asadmin']))
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		
		$this->mysmarty->assign("main_content", "resources/history.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function historydetail($id, $offset=0)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);
		
		if (! $id)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		$isexport = isset($_POST['isexport']) ? $_POST['isexport'] :  0;
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] :  0;
		
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$rowreference = $q->row();
		$this->mysmarty->assign("myreference", $rowreference);	
		
		// list

		if ($searchby)
		{
			$this->db->order_by("history_reference_date", ($searchby == 1) ? "asc" : "desc");
			$this->db->order_by("history_reference_time", ($searchby == 1) ? "asc" : "desc");			
			$this->db->where("history_reference_reference", $rowreference->reference_id);
			$this->db->join("user", "user_id = history_reference_user");
			$q = $this->db->get("history_reference");
			
			$rows = $q->result();
			for($i=0; $i < count($rows); $i++)
			{
				if (isset($access[$rows[$i]->user_id])) continue;
				
				$access[$rows[$i]->user_id] = $rows[$i]->history_reference_id;
			}			
		}

		$this->db->order_by("history_reference_date", "desc");
		$this->db->order_by("history_reference_time", "desc");
		
		if (isset($access))
		{
			foreach($access as $val)
			{
				$accessid[] = $val;
			}
			
			$this->db->where_in("history_reference_id", $accessid);
		}
				
		$this->db->where("history_reference_reference", $rowreference->reference_id);
		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}

		if ($limit && ($isexport == 0))
		{
			$this->db->limit($limit, $offset);
		}

		$this->db->join("user", "user_id = history_reference_user");
		$q = $this->db->get("history_reference");
		$this->db->flush_cache();
		$list = $q->result();
		
		for($i=0; $i < count($list); $i++)
		{
			$t = dbintmaketime($list[$i]->history_reference_date, $list[$i]->history_reference_time);				
			
			$list[$i]->datetime = date("d/m/Y H:i", $t);
		}		
		
		if ($isexport)
		{
			$this->load->library("xlswriter");
			
			$filename = sprintf("resources-history-%s.xls", $rowreference->reference_name);
			$this->xlswriter->send($filename);
			
			$worksheet =& $this->xlswriter->addWorksheet("exam");
			
			if (isset($sess['asadmin']))
			{
				$worksheet->write(0, 0, $this->config->item('lresources_name'));
				$worksheet->write(0, 1, $this->config->item('lnpk'));
				$worksheet->write(0, 2, $this->config->item('luser_name'));
				$worksheet->write(0, 3, $this->config->item('ldate'));
			}
			else
			{
				$worksheet->write(0, 0, 'DATE');
			}
			
			for($i=0; $i < count($list); $i++)
			{
				if (isset($sess['asadmin']))
				{
					$worksheet->write($i+1, 0, $rowreference->reference_name);
					$worksheet->write($i+1, 1, $list[$i]->user_npk);
					$worksheet->write($i+1, 2, $list[$i]->user_first_name." ".$list[$i]->user_last_name);
					$worksheet->write($i+1, 3, $list[$i]->datetime);
				}
				else
				{
					$worksheet->write($i+1, 0, $list[$i]->datetime);
				}
			}
			
			$this->xlswriter->close();
			
			return;
		}
		
		
		if (isset($accessid))
		{
			$this->db->where_in("history_reference_id", $accessid);
		}
		$this->db->where("history_reference_reference", $rowreference->reference_id);
		if (! isset($sess['asadmin']))
		{
			$this->db->where("history_reference_user", $sess['user_id']);
		}		
		$this->db->join("user", "user_id = history_reference_user");
		$total = $this->db->count_all_results("history_reference");
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
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
		$this->pagination1->lang_title = $this->config->item('unit');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());						
				
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("lmypersonal_report", strtoupper($this->config->item("lmypersonal_report")));
		$this->mysmarty->assign("ltraining_column", strtoupper($this->config->item('training_name')));
		$this->mysmarty->assign("ldate", strtoupper($this->config->item('ldate')));				
		$this->mysmarty->assign("lscore", strtoupper($this->config->item('lscore')));		
		$this->mysmarty->assign("lstatus", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("lresources_history", $this->config->item('lresources_history'));
		$this->mysmarty->assign("luser", strtoupper($this->config->item('luser_name')));
		$this->mysmarty->assign("lexport", strtoupper($this->config->item('lexport')));		
		$this->mysmarty->assign("lsearch_by", $this->config->item('lsearch_by'));
		$this->mysmarty->assign("lall_access", $this->config->item('lall_access'));
		$this->mysmarty->assign("lfirst_access", $this->config->item('lfirst_access'));
		$this->mysmarty->assign("llast_access", $this->config->item('llast_access'));
		$this->mysmarty->assign("searchby", $searchby);
		
		if (! isset($sess['asadmin']))
		{
			$this->mysmarty->assign("left_content", "user/menu.html");
		}
		else
		{
			$this->mysmarty->assign("left_content", "topic/menu.html");
		}
		$this->mysmarty->assign("main_content", "resources/historydetail.html");
		$this->mysmarty->display("sess_template.html");		
	}	
	
	function remove($id)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			redirect(base_url());
		}
		
		
		if (! isset($this->modules['resources']))
		{
			redirect(base_url());
		}
		
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		@unlink(BASEPATH."../resources/".$row->reference_filetupname);
		
		$this->db->where("reference_id", $id);
		$this->db->delete("reference");
		
		redirect(site_url(array("resources")));
	}
	
	function importnpk($id)
	{
		$this->db->where("reference_id", $id);
		$q = $this->db->get("reference");
		$this->db->flush_cache();
		
		$errs = array();
		if ($q->num_rows() == 0)
		{
			$errs[] = $this->config->item("err_exipred_session");
		}
		
		if (! isset($_FILES['filenpk']))
		{
			$errs[] = $this->config->item("lempty_filenpk");
		}
		else
		if (! $_FILES['filenpk']['name'])
		{
			$errs[] = $this->config->item("lempty_filenpk");
		}
		else
		{
			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['filenpk']['tmp_name']);			
			
			$i = 2;
			while(1)
			{
				if (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;
				
				$npks[] = $this->xlsreader->sheets[0]['cells'][$i][1];				
				
				$i++;
			}
			
			if (! isset($npks))
			{
				$errs[] = $this->config->item("lempty_npk");
			}
			else
			{
				$this->db->where_in("user_npk", $npks);
				$q = $this->db->get("user");
				$this->db->flush_cache();
				
				if ($q->num_rows() == 0)
				{
					$errs[] = $this->config->item("lempty_npk");
				}
				else
				{
					$rows = $q->result();
					for($i=0; $i < count($rows); $i++)
					{
						$rownpks[$rows[$i]->user_id] = $rows[$i];
					}
					
					foreach($rownpks as $npk)
					{
						unset($data);
						
						$data['reference_npk_npk'] = $npk->user_id;
						$data['reference_npk_reference'] = $id;
						
						@$this->db->insert("reference_npk", $data);												
					}
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
			
			echo "<script>parent.setErrorMessage(\"".$err."\")</script>";
			
			return;
		}
		
		$limportnpk_save = sprintf($this->config->item("limportnpk_save"), count($npks), count($rows));
		
		echo "<script>parent.setSuccess('".$limportnpk_save."')</script>";
	}
	
	function addparticipantbyjabatan()
	{
		$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : false;
		$reference = isset($_POST['reference']) ? $_POST['reference'] : 0;
		
		$errs = array();
		
		if (! $jabatan)
		{
			$errs[]= $this->config->item("lempty_choose_jabatan");
		}
		
		
		if (count($errs) > 0)
		{				
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "errmsg"=>$html));
			
			return;
		}		
		
		foreach($jabatan as $val)
		{
			$this->db->where("reference_jabatan_reference", $reference);
			$this->db->where("reference_jabatan_jabatan", $val);
			$total = $this->db->count_all_results("reference_jabatan");
			
			if ($total > 0) continue;
			
			unset($data);
			
			$data['reference_jabatan_reference'] = $reference;
			$data['reference_jabatan_jabatan'] = $val;
			
			$this->db->insert('reference_jabatan', $data);
		}
		
		echo json_encode(array("err"=>0, "message"=>$this->config->item("lupdateparticipant")));
	}
	
	function addparticipantbygroup()
	{
		$group = isset($_POST['group']) ? $_POST['group'] : false;
		$reference = isset($_POST['reference']) ? $_POST['reference'] : 0;
		
		$errs = array();
		
		if (! $group)
		{
			$errs[]= $this->config->item("lempty_choose_group");
		}
		
		
		if (count($errs) > 0)
		{				
			$this->mysmarty->assign("errs", $errs);
			$html = $this->mysmarty->fetch("errmessage.html");
			
			echo json_encode(array("err"=>1, "errmsg"=>$html));
			
			return;
		}		
		
		foreach($group as $val)
		{
			$this->db->where("reference_levelgroup_reference", $reference);
			$this->db->where("reference_levelgroup_levelgroup", $val);
			$total = $this->db->count_all_results("reference_levelgroup");
			
			if ($total > 0) continue;
			
			unset($data);
			
			$data['reference_levelgroup_reference'] = $reference;
			$data['reference_levelgroup_levelgroup'] = $val;
			
			$this->db->insert('reference_levelgroup', $data);
		}
		
		echo json_encode(array("err"=>0, "message"=>$this->config->item("lupdateparticipant")));
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
