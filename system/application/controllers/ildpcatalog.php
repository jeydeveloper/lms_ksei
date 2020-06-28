<?php
include_once "base.php"; 

class ILDPCatalog extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPCatalog()
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
		$this->load->model("devareamodel");

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
		
		if(!$this->modules['ildpadmin']){
			redirect('user');
			exit;
		} 		
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		
		$this->langmodel->init();
	}
		
	function index($topicid=0, $referer="", $userid=0)
	{				
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("limit", $recordperpage);
		$this->mysmarty->assign("lcatalog", $this->config->item("lcatalog"));
		$this->mysmarty->assign("lildp_catalog", $this->config->item("lildp_catalog"));
		$this->mysmarty->assign("lheader_ildp_catalog_list", $this->config->item("lheader_ildp_catalog_list"));
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));		
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		$this->mysmarty->assign("lcourse_abb", $this->config->item("lcourse_abb"));
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
	
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpcatalog/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function export()
	{
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-ildp-catalog.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("catalog");		
		
		$worksheet->write(0, 0, 'Catalog ID');
		$worksheet->write(0, 1, 'Category ID');
		$worksheet->write(0, 2, 'Category Name');
		$worksheet->write(0, 3, 'Training Type');
		$worksheet->write(0, 4, 'Eligable Grade');
		$worksheet->write(0, 5, 'Status');
		$worksheet->write(0, 6, 'Status Desc');
		$worksheet->write(0, 7, 'Creator ID');
		$worksheet->write(0, 8, 'Creator NPK');
		$worksheet->write(0, 9, 'Created Time');
		
		$this->search(0, "export", $worksheet);
		$this->xlswriter->close();
	}
	
	function search($offset=0, $act="", $worksheet=null)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
						
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "ildp_catalog_training";
		$searchby = isset($_POST['searchby']) ? $_POST['searchby'] : "ildp_catalog_training";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
				
		$this->mysmarty->assign("lapproved_by", $this->config->item("lapproved_by"));		
		
		// 

		if (($act != "export") && ($limit > 0))
		{
			$this->db->limit($limit, $offset);
		}
		
		$this->db->order_by("ildp_category_order", "asc");
		$this->db->order_by($sortby, $orderby);
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$this->db->join("ildp_category", "ildp_catalog_category = ildp_category_id");
		$this->db->join("user", "ildp_catalog_created_by = user_id", "left outer");
		$q = $this->db->get("ildp_catalog");
		
		$rows = $q->result();
		
		$catids[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$catids[] = $rows[$i]->ildp_catalog_id;
		}
		
		// check used in form
		
		$this->db->distinct();
		$this->db->select("ildp_detail_category_id");
		$this->db->where_in("ildp_detail_category_id", $catids);
		$q = $this->db->get("ildp_detail");
		$rowused = $q->result();
		for($i=0; $i < count($rowused); $i++)
		{
			$isused[$rowused[$i]->ildp_detail_category_id] = true;
		}
		
		$this->db->where_in("ildp_catalog_method_catalog", $catids);
		$this->db->join("ildp_method", "ildp_method_id = ildp_catalog_method_method");
		$q = $this->db->get("ildp_catalog_method");
		
		$rowrefs = $q->result();
		for($i=0; $i < count($rowrefs); $i++)
		{
			$methods[$rowrefs[$i]->ildp_catalog_method_catalog][] = $rowrefs[$i]->ildp_method_name;
		}
		
		//get development area
		$this->db->where_in("dev_area_catalog_id", $catids);
		$this->db->order_by("dev_area_catalog_id");
		$this->db->order_by("dev_area_title");
		$q = $this->db->get("ildp_development_area");
		$devareas = array();
		$rowrefs = $q->result();
		for($i=0; $i < count($rowrefs); $i++)
		{
			$devareas[$rowrefs[$i]->dev_area_catalog_id][] = $rowrefs[$i]->dev_area_title;
		}
		/* end development area */
				
		for($i=0; $i < count($rows); $i++)
		{
			$dev_area_string = "";
			if(count($devareas[$rows[$i]->ildp_catalog_id])){
				$dev_area_string = implode(",", $devareas[$rows[$i]->ildp_catalog_id]);
			}
			
			$rows[$i]->ildp_catalog_status_desc = ($rows[$i]->ildp_catalog_status != 1) ? $this->config->item("inactive") : $this->config->item("active");
			$rows[$i]->ildp_catalog_status_image = '<img src="'.base_url().'images/16/'.(($rows[$i]->ildp_catalog_status != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($rows[$i]->ildp_catalog_status != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($rows[$i]->ildp_catalog_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
			$rows[$i]->ildp_catalog_grade1 = substr($rows[$i]->ildp_catalog_grade, 1);
			$rows[$i]->ildp_catalog_grade1 = substr($rows[$i]->ildp_catalog_grade1, 0, strlen($rows[$i]->ildp_catalog_grade1)-1);
			$rows[$i]->method = isset($methods[$rows[$i]->ildp_catalog_id]) ? implode(", ", $methods[$rows[$i]->ildp_catalog_id]) : "";
			$rows[$i]->isused = isset($isused[$rows[$i]->ildp_catalog_id]);
			$rows[$i]->ildp_development_area = $dev_area_string;
			
			$grades = explode(",", $rows[$i]->ildp_catalog_grade1);
			sort($grades);
			$rows[$i]->ildp_catalog_grade1 = implode(",", $grades);
			
			$rows[$i]->ildp_catalog_created_time_t = dbmaketime($rows[$i]->ildp_catalog_created_time);
			
			if ($act == "export")
			{
				$worksheet->write($i+1, 0, $rows[$i]->ildp_catalog_id);
				$worksheet->write($i+1, 1, $rows[$i]->ildp_catalog_category);	
				$worksheet->write($i+1, 2, $rows[$i]->ildp_category_name);	
				$worksheet->write($i+1, 3, $rows[$i]->ildp_catalog_training);	
				$worksheet->write($i+1, 4, $rows[$i]->ildp_catalog_grade1);	
				$worksheet->write($i+1, 5, $rows[$i]->ildp_catalog_status);	
				$worksheet->write($i+1, 6, $rows[$i]->ildp_catalog_status_desc);	
				$worksheet->write($i+1, 7, $rows[$i]->ildp_catalog_created_by);	
				$worksheet->write($i+1, 8, $rows[$i]->user_npk);	
				$worksheet->write($i+1, 9, date("d/m/Y H:i:s", $rows[$i]->ildp_catalog_created_time_t));	
			}
		}
		
		if ($act == "export")
		{
			return;
		}	
						
		$this->db->where($searchby." LIKE '%".$keyword."%'", null);
		$total = $this->db->count_all_results("ildp_catalog");	
		
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
		$this->pagination1->lang_title = $this->config->item('lcatalog');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		$this->mysmarty->assign("catalogs", $rows);
		$this->mysmarty->assign("ncatalogs", count($rows));
		
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("leligable_grade", $this->config->item("leligable_grade"));
		$this->mysmarty->assign("lmethod", $this->config->item("lmethod"));
		$this->mysmarty->assign("lcourse_abb", $this->config->item("lcourse_abb"));
								
		$html = $this->mysmarty->fetch("ildpcatalog/list.html");
		
		$callback['html'] = $html;
		echo json_encode($callback);
	}
		
	function import()
	{
		$this->mysmarty->assign("lilpd_catalog_import", $this->config->item("lilpd_catalog_import"));
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->assign("limport_confirm", $this->config->item("limport_confirm"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpcatalog/import.html");
		$this->mysmarty->display("sess_template.html");		
	}	
	
	function doimport()
	{
		$error = false;
		
		$path = sprintf("%s../%s/", BASEPATH, "uploads");
		
		$config['upload_path'] = $path;
		$config['allowed_types'] = "xls";
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload("file"))
		{
			echo sprintf("<script>parent.setErrorMessage('%s')</script>", str_replace("'", " ", $this->upload->display_errors()));
			exit;
		}

		// categories
		
		$q = $this->db->get("ildp_category");
		$rowcategories = $q->result();
		
		for($i=0; $i < count($rowcategories); $i++)
		{
			$categories[strtoupper($rowcategories[$i]->ildp_category_name)] = $rowcategories[$i]->ildp_category_id;
		}		

		// method

		$q = $this->db->get("ildp_method");
		$rowmethods = $q->result();
		
		for($i=0; $i < count($rowmethods); $i++)
		{
			$methods[strtoupper($rowmethods[$i]->ildp_method_name)] = $rowmethods[$i]->ildp_method_id;
		}		
		
		// development_area
		$q = $this->db->get("ildp_development_area");
		$rowareas = $q->result();
		
		for($i=0; $i < count($rowareas); $i++)
		{
			$devareas[strtoupper($rowareas[$i]->dev_area_title)][$rowareas[$i]->dev_area_catalog_id] = $rowareas[$i]->dev_area_id;
		}		
		
		
		//-- get existing catalog
		$this->db->join("ildp_category", "ildp_catalog_category = ildp_category_id");
		$q = $this->db->get("ildp_catalog");
		$rowcatalogs = $q->result();
		
		$course_abbs = array();
		for($i=0; $i < count($rowcatalogs); $i++)
		{
			$catalogs[strtoupper($rowcatalogs[$i]->ildp_category_name)][strtoupper($rowcatalogs[$i]->ildp_catalog_training)] = $rowcatalogs[$i]->ildp_catalog_id;
			if($rowcatalogs[$i]->ildp_catalog_course_abb)
				$course_abbs[strtoupper($rowcatalogs[$i]->ildp_catalog_course_abb)] = $rowcatalogs[$i]->ildp_catalog_id;
		}		
		
		$datas = $this->upload->data();
		$path = $datas['full_path'];

		$this->load->library("xlsreader");	
		$this->xlsreader->read($path);
				
		$i = 2;
		$nsuccess = 0;
		$nerror = 0;
		
		//-- create log error file even if empty
		$filename = "ildp-catalog-error-".date("Ymd.Hi").".xls";
		$path = sprintf("%s../log/ildp/%s", BASEPATH, $filename);

		$this->load->library("xlswriter");
		//$this->xlswriter->send($filename);
		$this->xlswriter->_filename = $path;
			
		$worksheet =& $this->xlswriter->addWorksheet("catalog");

		$worksheet->write(0, 0, 'Category Name');
		$worksheet->write(0, 1, 'Training Type');
		$worksheet->write(0, 2, 'Eligable Grade');
		$worksheet->write(0, 3, 'Status Desc');
		$worksheet->write(0, 4, 'Training Method');
		$worksheet->write(0, 5, 'Course Abb');
		$worksheet->write(0, 6, 'Development Area');
		
		while(1)
		{
			if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

			$categoryname = trim($this->xlsreader->sheets[0]['cells'][$i][1]);
			$trainingtype = trim($this->xlsreader->sheets[0]['cells'][$i][2]);
			$eligablegrade = $this->xlsreader->sheets[0]['cells'][$i][3];
			$statusdesc = $this->xlsreader->sheets[0]['cells'][$i][4];
			$method = $this->xlsreader->sheets[0]['cells'][$i][5];
			$status = (strcasecmp($statusdesc, "Aktif") == 0) ? 1 : 2;
			$course_abbr = trim($this->xlsreader->sheets[0]['cells'][$i][6]);
			$dev_area = trim($this->xlsreader->sheets[0]['cells'][$i][7]);
			
			
			if (	false
				|| (! isset($categories[strtoupper($categoryname)]))
				|| isset($catalogs[strtoupper($categoryname)][strtoupper($trainingtype)])
				|| ($course_abbr && isset($course_abbs[strtoupper($course_abbr)]))
			)
			{
				/*if (! $error)
				{
					$filename = "ildp-catalog-error-".date("Ymd.Hi").".xls";
					$path = sprintf("%s../log/ildp/%s", BASEPATH, $filename);

					$this->load->library("xlswriter");
					//$this->xlswriter->send($filename);
					$this->xlswriter->_filename = $path;
						
					$worksheet =& $this->xlswriter->addWorksheet("catalog");
			
					$worksheet->write(0, 0, 'Category Name');
					$worksheet->write(0, 1, 'Training Type');
					$worksheet->write(0, 2, 'Eligable Grade');
					$worksheet->write(0, 3, 'Status Desc');
					$worksheet->write(0, 4, 'Training Method');
					$worksheet->write(0, 5, 'Course Abb');
					$worksheet->write(0, 6, 'Development Area');
					
				}
				*/
				$nerror++;
				
				$worksheet->write($nerror, 0, $categoryname);
				$worksheet->write($nerror, 1, $trainingtype);
				$worksheet->write($nerror, 2, $eligablegrade);
				$worksheet->write($nerror, 3, $statusdesc);
				$worksheet->write($nerror, 4, $method);
				$worksheet->write($nerror, 5, $course_abbr);
				$worksheet->write($nerror, 6, $dev_area);
				
				if (! isset($categories[strtoupper($categoryname)])){
					$errs[] = sprintf("line %s: category \"%s\" is not exist\r\n", $nerror, $categoryname);
				}
				else
				if(isset($catalogs[strtoupper($categoryname)][strtoupper($trainingtype)])){
					$errs[] = sprintf("line %s: training type \"%s\" for category \"%s\" is already exist\r\n", $nerror, $trainingtype,$categoryname);
				}else
				if($course_abbr && isset($course_abbs[strtoupper($course_abbr)])){
						$errs[] = sprintf("line %s: course abbr \"%s\" is already exist\r\n", $nerror, $course_abbr);
				}else{
					$errs[] = sprintf("line %s: training type \"%s\" for category \"%s\" is already exist\r\n", $nerror, $trainingtype,$categoryname);
				}
				
				
				$error = true;
				
				$i++;
				continue;
			}
			
			$errmethdod  = $this->invalidcatalogmethod($method, $methods);
			if ($errmethdod)
			{
				$nerror++;
				
				$worksheet->write($nerror, 0, $categoryname);
				$worksheet->write($nerror, 1, $trainingtype);
				$worksheet->write($nerror, 2, $eligablegrade);
				$worksheet->write($nerror, 3, $statusdesc);
				$worksheet->write($nerror, 4, $method);
				$worksheet->write($nerror, 5, $course_abbr);
				$worksheet->write($nerror, 6, $dev_area);
			
				$errs[] = sprintf("line %s: learning method \"%s\" is not exist\r\n", $nerror, $errmethdod);
				$error = true;
				
				$i++;
				continue;
			}
			
			unset($insert);
			
			$insert['ildp_catalog_course_abb'] = $course_abbr;
			$insert['ildp_catalog_category'] = $categories[strtoupper($categoryname)];
			$insert['ildp_catalog_training'] = $trainingtype;
			$insert['ildp_catalog_status'] = $status;
			$insert['ildp_catalog_created_by'] = $this->sess['user_id'];
			$insert['ildp_catalog_created_time'] = date("Y-m-d H:i:s");
			$insert['ildp_catalog_modified_by'] = $this->sess['user_id'];
			$insert['ildp_catalog_modified_time'] = date("Y-m-d H:i:s");
			$insert['ildp_catalog_grade'] = sprintf(",%s,", $eligablegrade);
			
			$this->db->insert("ildp_catalog", $insert);
			$lastid = $this->db->insert_id();
			
			$this->importcatalogmethods($lastid, $method, $methods);
			$this->importcatalogdevareas($lastid, $dev_area,$devareas);
			
			$nsuccess++;
			$i++;
		}

		if ($error)
		{
			$this->xlswriter->close();
			
			$path = sprintf("%s../log/ildp/ildp-error-%s.log", BASEPATH, date("Ymd.Hi"));
			appendlog($path, $errs);
			
			$serror = sprintf("Error data: <a href=\"%slog/ildp/%s\">%s</a><br /><br />Total data : ".($nsuccess+$nerror) ." <br /> %d inserted, %d failed.<br /> error details: <br />%s ", base_url(), $filename, $filename, $nsuccess, $nerror, implode("<br />", $errs));
			$serror = str_replace("\r", "", $serror);
			$serror = str_replace("\n", "", $serror);
			
			echo sprintf("<script>parent.setErrorMessage('%s')</script>", str_replace("'", " ", $serror));
		}else{
			$str_import_success = sprintf($this->config->item('lildp_import_success'),$nsuccess);
			
			echo sprintf("<script>parent.setErrorMessage('%s')</script>", $str_import_success );
		}
		
	}
	
	function invalidcatalogmethod($method, $methods)
	{
		$lmethods = explode(",", $method);
		for($i=0; $i < count($lmethods); $i++)
		{
			$lmethod = strtoupper(trim($lmethods[$i]));
			if (! isset($methods[$lmethod])) return $lmethod;
		}

		return "";
	}
	
	function importcatalogdevareas($lastid, $dev_area,$devareas)
	{
		$this->db->where("dev_area_catalog_id ", $lastid);
		$this->db->delete("ildp_development_area");
		$devareas[strtoupper($rowareas[$i]->dev_area_title)][$rowareas[$i]->dev_area_catalog_id] = $rowareas[$i]->dev_area_id;
		
		$ldevareas = explode(",", $dev_area);
		for($i=0; $i < count($ldevareas); $i++)
		{
			$ldevarea = trim($ldevareas[$i]);
			if (isset($devareas[strtoupper($ldevarea)][$last_id])) {
				continue;
			}
			
			unset($insert);
			if($ldevarea){
				$insert['dev_area_catalog_id'] = $lastid;
				$insert['dev_area_title'] = $ldevarea;
				$insert['dev_area_created'] = date("Y-m-d H:i:s");
				$insert['dev_area_creator']	= _user_id();
				$this->db->insert("ildp_development_area", $insert);
			}
		}
	}
	
	function importcatalogmethods($lastid, $method, $methods)
	{
		$this->db->where("ildp_catalog_method_catalog", $lastid);
		$this->db->delete("ildp_catalog_method");
		
		$lmethods = explode(",", $method);
		for($i=0; $i < count($lmethods); $i++)
		{
			$lmethod = strtoupper(trim($lmethods[$i]));
			if (! isset($methods[$lmethod])) continue;
			
			unset($insert);
			
			$insert['ildp_catalog_method_catalog'] = $lastid;
			$insert['ildp_catalog_method_method'] = $methods[$lmethod];
			
			$this->db->insert("ildp_catalog_method", $insert);
		}
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

		$this->db->order_by("grade_code", "asc");
		$q = $this->db->get("grade");
		$rows = $q->result();
		
		if ($id)
		{
			$this->db->where("ildp_catalog_id", $id);
			$q = $this->db->get("ildp_catalog");
			
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$rowedit = $q->row();			
			$this->mysmarty->assign("rowedit", $rowedit);
			
			$grades = explode(",", $rowedit->ildp_catalog_grade);
			
			$cgrades = array();
			for($i=0; $i < count($grades); $i++)
			{
				if (! $grades[$i]) continue;
				
				$cgrades[] = $grades[$i];
			}

			for($i=0; $i < count($rows); $i++)
			{
				$rows[$i]->checked = in_array($rows[$i]->grade_code, $cgrades);
			}
			
			// get methods
			
			$this->db->where("ildp_catalog_method_catalog", $id);
			$q = $this->db->get("ildp_catalog_method");
			
			$rowmethods = $q->result();
			for($i=0; $i < count($rowmethods); $i++)
			{
				$methods[$rowmethods[$i]->ildp_catalog_method_method] = true;
			}
			
			$this->mysmarty->assign("cgrades", $cgrades);
			$this->mysmarty->assign("ltitle", $this->config->item("ledit_ildp_catalog"));
			
			
			$this->db->where("dev_area_catalog_id", $id);
			$this->db->order_by("dev_area_title");
			$qarea = $this->db->get("ildp_development_area");
			$rowsarea = $qarea->result();
			
			$this->mysmarty->assign("devarea", $rowsarea);
			$this->mysmarty->assign("rowdevarea", count($rowsarea));
			
		}
		else
		{
			$this->mysmarty->assign("ltitle", $this->config->item("ladd_ildp_catalog"));
		}
		
		usort($rows, cmp);
		
		$temp = $rows;
		unset($rows);
		
		$nrow = ceil(count($temp)/3);
		
		$k = 0;
		for($i=0; $i < 3; $i++)
		{
			for($j=0; $j < $nrow; $j++)
			{
				//echo ($j*3+$i)." :: ".$k."<br />";
				
				$l = $j*3+$i;
				if ($l >= count($temp)) break;
				
				$rows[$l] = $temp[$k];
				$k++;
			}
		}

		$this->mysmarty->assign("grades", $rows);
		
		$this->db->order_by("ildp_category_order", "asc");				
		$this->db->where("ildp_category_status", 1);
		$q = $this->db->get("ildp_category");
		$rows = $q->result();
		$this->mysmarty->assign("categories", $rows);
		
		
		$this->db->order_by("ildp_method_name", "asc");
		$q = $this->db->get("ildp_method");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->checked = isset($methods[$rows[$i]->ildp_method_id]);
		}
		$this->mysmarty->assign("methods", $rows);
		
		$this->mysmarty->assign("ltraining_type", $this->config->item("ltraining_type"));
		$this->mysmarty->assign("lconfirm_ildp_catalog_save", $this->config->item("lconfirm_ildp_catalog_save"));
		$this->mysmarty->assign("lsave", $this->config->item("lsave"));
		$this->mysmarty->assign("leligable_grade", $this->config->item("leligable_grade"));
		$this->mysmarty->assign("lcheck_all", $this->config->item("lcheck_all"));
		$this->mysmarty->assign("luntil", $this->config->item("until"));
		$this->mysmarty->assign("lconfirm_reset_data", $this->config->item("lconfirm_reset_data"));
		$this->mysmarty->assign("lmethod", $this->config->item("lmethod"));
		$this->mysmarty->assign("llearning_method_dev", $this->config->item("llearning_method_dev"));
		
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		$this->mysmarty->assign("lcourse_abb", $this->config->item("lcourse_abb"));
		$this->mysmarty->assign("ladd", $this->config->item("ladd"));
		$this->mysmarty->assign("ldevelopment_area", $this->config->item("ldevelopment_area"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpcatalog/form.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function save($id=0)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}

		$category = isset($_POST['cat']) ? $_POST['cat'] : "";
		$abbr  = isset($_POST['abb']) ? $_POST['abb'] : "";
		$training = isset($_POST['training']) ? $_POST['training'] : "";
		$sgrade = (isset($_POST['grade'])  && count($_POST['grade'])) ? (",".implode(",", $_POST['grade']).",") : ""; 
		$methods = isset($_POST['method'])  ? $_POST['method'] : array(); 
		$dev_area = isset($_POST['dev_area'])  ? $_POST['dev_area'] : array(); 
		
		$errs = array();
		
	
		if (strlen($abbr) == 0)
		{
			$callback['error'] = true;
			$errs[] = $this->config->item("linput_abb");
		}

		if (strlen($category) == 0)
		{
			$callback['error'] = true;
			$errs[] = $this->config->item("lselect_catalog_category");
		}

		if (strlen($training) == 0)
		{
			$callback['error'] = true;
			$errs[] = $this->config->item("ltraining_type_empty");
		}
		

		// check abbr unique
		$this->db->where("ildp_catalog_course_abb", $abbr);
		$q = $this->db->get("ildp_catalog");

		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			if ($row->ildp_catalog_id != $id) 
			{
				$callback['error'] = true;
				$errs[] = $this->config->item("lcourse_abbr_already_exists");
			}
		}
		//- check existing training and category		
		/*$this->db->where("ildp_catalog_category", $category);
		$this->db->where("ildp_catalog_training", $training);
		
		$q = $this->db->get("ildp_catalog");

		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			if ($row->ildp_catalog_id != $id) 
			{
				$callback['error'] = true;
				$errs[] = $this->config->item("ltraining_type_alreadyexist");
	
			}
		}*/

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$message = $this->mysmarty->fetch("errmessage.html");
			
			$callback['error'] = true;
			$callback['message'] = $message;
			
			echo json_encode($callback);
				
			return;
		}		

		unset($insert);
		
		$insert['ildp_catalog_course_abb'] = $abbr;
		$insert['ildp_catalog_category'] = $category;
		$insert['ildp_catalog_training'] = $training;
		$insert['ildp_catalog_modified_by'] = $this->sess['user_id'];
		$insert['ildp_catalog_grade'] = $sgrade;
		$insert['ildp_catalog_modified_time'] = date("Y-m-d H:i:s");
				
		if ($id)
		{
			$this->db->where("ildp_catalog_id", $id);
			$this->db->update("ildp_catalog", $insert);
		
			$this->savemethods($id, $methods);
			
			
			//-- simpan development area if exists
			if(count($dev_area)){
				$this->devareamodel->save($id,$dev_area,$this->sess['user_id']);
			}
			
			$callback['error'] = false;
			$callback['message'] = $this->config->item("lsuccess_update_ildp_catalog");
				
			echo json_encode($callback);			
			return;
		}

		$insert['ildp_catalog_status'] = 1;
		$insert['ildp_catalog_created_by'] = $this->sess['user_id'];
		$insert['ildp_catalog_created_time'] = date("Y-m-d H:i:s");
		
		$this->db->insert("ildp_catalog", $insert);
		$id = $this->db->insert_id();
		$this->savemethods($id, $methods);
		
		//-- simpan development area if exists
		if(count($dev_area)){
			$this->devareamodel->save($id,$dev_area,$this->sess['user_id']);
		}
		
		$callback['error'] = false;
		$callback['message'] = $this->config->item("lsuccess_create_ildp_catalog");
			
		echo json_encode($callback);
	}
	
	function savemethods($id, $methods)
	{
		$this->db->where("ildp_catalog_method_catalog", $id);
		$this->db->delete("ildp_catalog_method");
		
		for($i=0; $i < count($methods); $i++)
		{
			unset($insert);
			
			$insert['ildp_catalog_method_catalog']  = $id;
			$insert['ildp_catalog_method_method']  = $methods[$i];
			
			$this->db->insert("ildp_catalog_method", $insert);
		}
	}
	
	function changestatus($id, $status)
	{
		if (! isset($this->modules['ildpadmin']))
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_exipred_session");
			
			echo json_encode($callback);
			exit;
		}
		
		if (! $id)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_exipred_session");
			
			echo json_encode($callback);
			exit;
		}				
				
		$data['ildp_catalog_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("ildp_catalog_id", $id);
		$this->db->update("ildp_catalog", $data);				
		
		$callback['error'] = false;
		
		$statusdesc = ($data['ildp_catalog_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active");
		$statusimage = '<img src="'.base_url().'images/16/'.(($data['ildp_catalog_status'] != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($data['ildp_catalog_status'] != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($data['ildp_catalog_status'] == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
		
		$callback['newstatus'] = sprintf("<a href='#' onclick='javascript: chagestatus(%d, %d)'>%s</a>", $id, $data['ildp_catalog_status'], $statusimage);
		
		echo json_encode($callback);
	}
	
	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("ildp_detail_category_id", $id);
		$total = $this->db->count_all_results("ildp_detail");
		
		if ($total > 0)
		{
			redirect(base_url());
		}
		
		$this->db->where("ildp_catalog_id", $id);
		$this->db->delete("ildp_catalog");
		
		redirect(site_url()."/ildpcatalog");
	}
	
	function getareadevtype()
	{
		$cat = $_POST['cat'];
		
		$this->db->where("ildp_category_id", $cat);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
				$type = 2;
		}
		else
		{
			$row = $q->row();
			$type = $row->ildp_category_areadev_type;
		}
		
		$json["type"] = $type;
		
		echo json_encode($json);
	}

}

function cmp($a, $b)
{
	if (! is_numeric($a->grade_code))
	{
		if (is_numeric($b->grade_code))
		{
			return 1;
		}
		
		return strcmp($a->grade_code, $b->grade_code);
	}
	
	if ($a->grade_code == $b->grade_code) 
	{
        return 0;
    }
    
    return ($a->grade_code < $b->grade_code) ? -1 : 1;
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
