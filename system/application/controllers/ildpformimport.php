<?php
include_once "base.php"; 

class ILDPFormImport extends Base{
	var $language;
	var $modules;
	var $sess;

	function ILDPFormImport()
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
		$this->langmodel->init();
		
		if(!$this->modules['ildpadmin']){
			redirect('user');
			exit;
		}
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		 		
	}
		
	function index()
	{
		$this->mysmarty->assign("lilpd_form_import", $this->config->item("lildp_form_import"));
		$this->mysmarty->assign("lfile", $this->config->item("lfile"));
		$this->mysmarty->assign("limport_confirm", $this->config->item("limport_confirm"));
		$this->mysmarty->assign("limport", $this->config->item("limport"));
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpform/import.html");
		$this->mysmarty->display("sess_template.html");		
	}	
	
	function geteligablenpk($atasan, $grade)
	{
		while(1)
		{
			$this->db->where("user_npk", $atasan);
			$q = $this->db->get("user");
			
			if ($q->num_rows() == 0) return 0;
			
			$row = $q->row();
			if ($row->user_grade_code < $grade)
			{
				$atasan = $row->user_npk_atasan;
				continue;
			}
			
			return $row->user_id;
		}
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
		
		// ambil ildp form
		
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id", "left outer");
		$q = $this->db->get("ildp_form");
		
		$rowildpforms = $q->result();
		for($i=0; $i < count($rowildpforms); $i++)
		{
			$ildforms[$rowildpforms[$i]->ildp_form_ildp_period][$rowildpforms[$i]->ildp_user_id] = $rowildpforms[$i]->ildp_id;			
			$ildpcatalogs[$rowildpforms[$i]->ildp_form_ildp_period][$rowildpforms[$i]->ildp_user_id][$rowildpforms[$i]->ildp_detail_category_id] = true;
			$ildpcatalogs[$rowildpforms[$i]->ildp_form_ildp_period][$rowildpforms[$i]->ildp_user_id][$rowildpforms[$i]->ildp_detail_others] = true;			
		}
				
		// ambil reg period
		
		$q = $this->db->get("ildp_registration_period");
		$rowregs = $q->result();
		
		for($i=0; $i < count($rowregs); $i++)
		{
			$rowregs[$i]->ildp_registration_period_start_t = dbmaketime($rowregs[$i]->ildp_registration_period_start);
			
			$regs[$rowregs[$i]->ildp_registration_period_ildp] = $rowregs[$i];
		}
		
		// ambil configurasi eligable grad
		
		$this->db->where("ildpsetting_key", "reportlevelcond1");
		$q = $this->db->get("ildpsetting");
		
		if ($q->num_rows() == 0)
		{
			printf("<script>parent.setErrorMessage('%s')</script>", "Approval grade is not defined!");
			exit;			
		}
		
		$rowsetting = $q->row();
		
		// npk

		$this->db->join("jabatan", "user_jabatan = jabatan_id", "left outer");
		$q = $this->db->get("user");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$users[strtoupper($rows[$i]->user_npk)] = $rows[$i];			
		}		
		
		// categories

		$q = $this->db->get("ildp_category");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$categories[strtoupper($rows[$i]->ildp_category_name)] = $rows[$i]->ildp_category_id;
		}		

		// catalog
		
		$q = $this->db->get("ildp_catalog");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$catalogs[strtoupper($rows[$i]->ildp_catalog_category)][strtoupper($rows[$i]->ildp_catalog_training)] = $rows[$i]->ildp_catalog_id;
		}		

		// method

		$q = $this->db->get("ildp_method");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$methods[strtoupper($rows[$i]->ildp_method_name)] = $rows[$i]->ildp_method_id;
		}		
		
		$datas = $this->upload->data();
		$path = $datas['full_path'];

		$this->load->library("xlsreader");	
		$this->xlsreader->read($path);
				
		$i = 2;
		$nsuccess = 0;
		$nerror = 0;

		while(1)
		{
			if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

			$ildpperiod = trim($this->xlsreader->sheets[0]['cells'][$i][1]);
			$npk = trim($this->xlsreader->sheets[0]['cells'][$i][2]);
			$categoryname = trim($this->xlsreader->sheets[0]['cells'][$i][3]);
			$trainingname = trim($this->xlsreader->sheets[0]['cells'][$i][4]);
			$method = $this->xlsreader->sheets[0]['cells'][$i][5];
			$budget = isset($this->xlsreader->sheets[0]['cells'][$i][6]) ? $this->xlsreader->sheets[0]['cells'][$i][6] : 0;
			$realisasi = isset($this->xlsreader->sheets[0]['cells'][$i][7]) ? $this->xlsreader->sheets[0]['cells'][$i][7] : "";
			$status = $this->xlsreader->sheets[0]['cells'][$i][8];					
			
			if (	false
				|| (! isset($users[strtoupper($npk)]))
				|| (! isset($methods[strtoupper($method)]))
				|| (! isset($categories[strtoupper($categoryname)]))
				|| ((strtoupper($categoryname) != "OTHERS") && (! isset($catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)])))
			)
			{
				if (! $error)
				{
					$filename = "ildp-form-error-".date("Ymd.Hi").".xls";
					$path = sprintf("%s../log/ildp/%s", BASEPATH, $filename);

					$this->load->library("xlswriter");
					//$this->xlswriter->send($filename);
					$this->xlswriter->_filename = $path;
						
					$worksheet =& $this->xlswriter->addWorksheet("catalog");
			
					$worksheet->write(0, 0, 'Periode ILDP');
					$worksheet->write(0, 1, 'NPK');
					$worksheet->write(0, 2, 'Category');
					$worksheet->write(0, 3, 'Judul program');
					$worksheet->write(0, 4, 'Method');
					$worksheet->write(0, 5, 'budget');
					$worksheet->write(0, 6, 'realisasi');
					$worksheet->write(0, 7, 'status');
				}
				
				$error = true;
				$nerror++;
				
				$worksheet->write($nerror, 0, $ildpperiod);
				$worksheet->write($nerror, 1, $npk);
				$worksheet->write($nerror, 2, $categoryname);
				$worksheet->write($nerror, 3, $trainingname);
				$worksheet->write($nerror, 4, $method);
				$worksheet->write($nerror, 5, $budget);
				$worksheet->write($nerror, 6, $realisasi);
				$worksheet->write($nerror, 7, $status);
				
				if (! isset($users[strtoupper($npk)]))
				{
					$errs[] = sprintf("line %s: npk \"%s\" is not exist\r\n", $i, $npk);
				}
				else
				if (! isset($categories[strtoupper($categoryname)]))
				{
					$errs[] = sprintf("line %s: category \"%s\" is not exist\r\n", $i, $categoryname);
				}				
				else
				if ((strtoupper($categoryname) != "OTHERS") && (! isset($catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)])))
				{
					$errs[] = sprintf("line %s: catalog \"%s\" is not exist\r\n", $i, $trainingname);
				}
				else
				{
					$errs[] = sprintf("line %s: method \"%s\" is not exist\r\n", $i, $method);
				}
								
				
				$i++;
				continue;
			}
			
			// eligable grade approval
			
			$mygrade = $users[strtoupper($npk)]->user_grade_code;
			
			if ($mygrade < $rowsetting->ildpsetting_val)
			{
				$approvalgrade = $rowsetting->ildpsetting_val;
			}
			else
			{
				$approvalgrade = $mygrade+1;
			}
			
			$approvedby = $this->geteligablenpk($users[strtoupper($npk)]->user_npk_atasan, $approvalgrade);
			
			$arr = array();
			$this->levelmodel->getparentlevelgroupids($users[strtoupper($npk)]->jabatan_level_group, &$arr);

			$arr = array_reverse($arr);
			
			$directory_id = count($arr) ? $arr[0] : 0;
			$group_id = (count($arr) > 1) ? $arr[1] : 0;
			$dept_id = (count($arr) > 2) ? $arr[2] : 0;
			$unit_id = (count($arr) > 3) ? $arr[3] : 0;			
			
			unset($insert);
			
			$insert['ildp_period_start'] = $regs[$ildpperiod] ? date("Y-m-d H:i:s", $regs[$ildpperiod]->ildp_registration_period_start_t) : date("Y-m-d H:i:s");
			$insert['ildp_period_end'] = $regs[$ildpperiod] ? date("Y-m-d H:i:s", $regs[$ildpperiod]->ildp_registration_period_start_t) : date("Y-m-d H:i:s");
			$insert['ildp_user_id'] = $users[strtoupper($npk)]->user_id;
			$insert['ildp_user_npk'] = $npk;
			$insert['ildp_user_jabatan_id'] = $users[strtoupper($npk)]->user_jabatan;
			$insert['ildp_user_direktorat'] = $directory_id;
			$insert['ildp_user_group'] = $group_id;
			$insert['ildp_user_dept'] = $dept_id;
			$insert['ildp_user_unit'] = $unit_id;
			$insert['ildp_user_grade_code'] = $users[strtoupper($npk)]->user_grade_code;
			$insert['ildp_comments'] = "";
			
			switch(strtoupper($status))
			{
				 case "REJECTED": 
					$insert['ildp_status'] = -1;
					$insert['ildp_approval_id'] = 0;
					$insert['ildp_approved_by'] = 0;
					$insert['ildp_approved_time'] = "0000-00-00 00:00:00";
				 break;
				 case "APPROVED":
					$insert['ildp_status'] = 2;
					$insert['ildp_approval_id'] = isset($approvedby) ? $approvedby : 0;
					$insert['ildp_approved_by'] = isset($approvedby) ? $approvedby : 0;
					$insert['ildp_approved_time'] = date("Y-m-d H:i:s");
				 break;
				 case "SUBMITTED": 
					$insert['ildp_status'] = 1;
					$insert['ildp_approval_id'] = 0;
					$insert['ildp_approved_by'] = 0;
					$insert['ildp_approved_time'] = "0000-00-00 00:00:00";
				 break;
				 default:
					$insert['ildp_status'] = 0;
					$insert['ildp_approval_id'] = 0;
					$insert['ildp_approved_by'] = 0;
					$insert['ildp_approved_time'] = "0000-00-00 00:00:00";
			}					
			
			$insert['ildp_created_by'] = $this->sess['user_id'];
			$insert['ildp_created_time'] = date("Y-m-d H:i:s");
			$insert['ildp_modified_by'] = $this->sess['user_id'];
			$insert['ildp_modified_time'] = date("Y-m-d H:i:s");
			$insert['ildp_form_ildp_period'] = $ildpperiod;
			
			$insert['ildp_form_rejector'] = 0;
			$insert['ildp_form_rejected'] = "0000-00-00 00:00:00";
			$insert['ildp_form_rejected_reason'] = "";
			
			if (! isset($ildforms[$ildpperiod][$users[strtoupper($npk)]->user_id]))
			{
				$this->db->insert("ildp_form", $insert);
				$lastid = $this->db->insert_id();
				
				$ildforms[$ildpperiod][$users[strtoupper($npk)]->user_id] = $lastid;				
				
				// add trail untuk form
				
				unset($insert1);
				$insert1['ildp_trail_user'] = $insert['ildp_user_id'];
				$insert1['ildp_trail_ildp_id'] = $lastid;
				$insert1['ildp_trail_status'] = ($insert['ildp_status'] == 0) ? -1 : $insert['ildp_status'];
				$insert1['ildp_trail_created_time'] = date("Y-m-d H:i:s");
				$insert1['ildp_trail_comments'] = json_encode(
						array(
						"ildp_period_start" 	=> $insert['ildp_period_start'],
						"ildp_period_end" 		=> $insert['ildp_period_end'],
						"ildp_form_ildp_period"	=> $insert['ildp_form_ildp_period'] ,
						"ildp_user_id"			=> $insert['ildp_user_id'],
						"ildp_user_npk"			=> $insert['ildp_user_npk'],
						"update"				=> $insert
					));
					
				$this->db->insert("ildp_form_trail", $insert1);
				$ildptrailid = $this->db->insert_id();			
				
			}
			else
			{
				$lastid = $ildforms[$ildpperiod][$users[strtoupper($npk)]->user_id];
				
				// ambil trail terakhir untuk $lastid
				
				$this->db->limit(1);
				$this->db->order_by("ildp_trail_created_time", "desc");
				$this->db->where("ildp_trail_ildp_id", $lastid);
				$q = $this->db->get("ildp_form_trail");
				
				if ($q->num_rows() == 0)
				{
					// add trail untuk form
					
					unset($insert1);
					$insert1['ildp_trail_user'] = $insert['ildp_user_id'];
					$insert1['ildp_trail_ildp_id'] = $lastid;
					$insert1['ildp_trail_status'] = ($insert['ildp_status'] == 0) ? -1 : $insert['ildp_status'];
					$insert1['ildp_trail_created_time'] = date("Y-m-d H:i:s");
					$insert1['ildp_trail_comments'] = json_encode(
						array(
						"ildp_period_start" 	=> $insert['ildp_period_start'],
						"ildp_period_end" 		=> $insert['ildp_period_end'],
						"ildp_form_ildp_period"	=> $insert['ildp_form_ildp_period'] ,
						"ildp_user_id"			=> $insert['ildp_user_id'],
						"ildp_user_npk"			=> $insert['ildp_user_npk'],
						"update"				=> $insert
					));
					
					$this->db->insert("ildp_form_trail", $insert1);
					$ildptrailid = $this->db->insert_id();			
				}
				else
				{
					$rowtrail = $q->row();
					$ildptrailid = $rowtrail->ildp_trail_id;
				}
			}
						
			if ((strtoupper($categoryname) != "OTHERS") && (isset($ildpcatalogs[$ildpperiod][$users[strtoupper($npk)]->user_id][$catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)]])))
			{
				if (! $error)
				{
					$filename = "ildp-form-error-".date("Ymd.Hi").".xls";
					$path = sprintf("%s../log/ildp/%s", BASEPATH, $filename);

					$this->load->library("xlswriter");
					//$this->xlswriter->send($filename);
					$this->xlswriter->_filename = $path;
						
					$worksheet =& $this->xlswriter->addWorksheet("catalog");
			
					$worksheet->write(0, 0, 'Periode ILDP');
					$worksheet->write(0, 1, 'NPK');
					$worksheet->write(0, 2, 'Category');
					$worksheet->write(0, 3, 'Judul program');
					$worksheet->write(0, 4, 'Method');
					$worksheet->write(0, 5, 'budget');
					$worksheet->write(0, 6, 'realisasi');
					$worksheet->write(0, 7, 'status');
				}
				
				$nerror++;
				
				$worksheet->write($nerror, 0, $ildpperiod);
				$worksheet->write($nerror, 1, $npk);
				$worksheet->write($nerror, 2, $categoryname);
				$worksheet->write($nerror, 3, $trainingname);
				$worksheet->write($nerror, 4, $method);
				$worksheet->write($nerror, 5, $budget);
				$worksheet->write($nerror, 6, $realisasi);
				$worksheet->write($nerror, 7, $status);
									
				$errs[] = sprintf("line %s: catalog \"%s\" is is already exist in ildp form\r\n", $i, $trainingname);
				
				$error = true;				
				$i++;
				continue;
			}
			
			if ((strtoupper($categoryname) == "OTHERS") && (isset($ildpcatalogs[$ildpperiod][$users[strtoupper($npk)]->user_id][$trainingname])))
			{
				if (! $error)
				{
					$filename = "ildp-form-error-".date("Ymd.Hi").".xls";
					$path = sprintf("%s../log/ildp/%s", BASEPATH, $filename);

					$this->load->library("xlswriter");
					//$this->xlswriter->send($filename);
					$this->xlswriter->_filename = $path;
						
					$worksheet =& $this->xlswriter->addWorksheet("catalog");
			
					$worksheet->write(0, 0, 'Periode ILDP');
					$worksheet->write(0, 1, 'NPK');
					$worksheet->write(0, 2, 'Category');
					$worksheet->write(0, 3, 'Judul program');
					$worksheet->write(0, 4, 'Method');
					$worksheet->write(0, 5, 'budget');
					$worksheet->write(0, 6, 'realisasi');
					$worksheet->write(0, 7, 'status');
				}
				
				$nerror++;
				
				$worksheet->write($nerror, 0, $ildpperiod);
				$worksheet->write($nerror, 1, $npk);
				$worksheet->write($nerror, 2, $categoryname);
				$worksheet->write($nerror, 3, $trainingname);
				$worksheet->write($nerror, 4, $method);
				$worksheet->write($nerror, 5, $budget);
				$worksheet->write($nerror, 6, $realisasi);
				$worksheet->write($nerror, 7, $status);
									
				$errs[] = sprintf("line %s: catalog \"%s\" is is already exist in ildp form\r\n", $i, $trainingname);
				
				$error = true;				
				$i++;
				continue;
			}			
						
			unset($insert);						
			$insert['ildp_detail_ildp_id'] = $lastid;
			
			if (isset($catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)]))
			{
				$insert['ildp_detail_category_id'] = $catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)];
				$insert['ildp_detail_others'] = 0;
			}
			else
			{
				$insert['ildp_detail_category_id'] = 0;
				$insert['ildp_detail_others'] = $trainingname;
			}	
						
			$insert['ildp_detail_method_id'] = $methods[strtoupper($method)];
			$insert['ildp_detail_budget'] = $budget;			
			$insert['ildp_detail_created_by'] = $this->sess['user_id'];
			$insert['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			$insert['ildp_detail_status'] = (strtoupper($realisasi) == "DONE") ? 1 : 0;
			
			$this->db->insert("ildp_detail", $insert);
			
			// detail trail
			
			unset($insert2);
			
			$insert2['ildp_detail_trail_ildp_id'] = $ildptrailid;
			$insert2['ildp_detail_trail_method_id'] = $insert['ildp_detail_method_id'];
			$insert2['ildp_detail_trail_budget'] = $insert['ildp_detail_budget'];			
			$insert2['ildp_detail_trail_category_id'] = $insert['ildp_detail_category_id'];
			$insert2['ildp_detail_others'] = $insert['ildp_detail_others'];
			$insert2['ildp_detail_trail_created_by'] = $insert['ildp_detail_created_by'];
			$insert2['ildp_detail_created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert("ildp_detail_trail", $insert2);			
			

			$nsuccess++;
			$i++;
			
			if (isset($catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)]))
			{
				$ildpcatalogs[$ildpperiod][$users[strtoupper($npk)]->user_id][$catalogs[$categories[strtoupper($categoryname)]][strtoupper($trainingname)]] = true;
			}
			else
			{
				$ildpcatalogs[$ildpperiod][$users[strtoupper($npk)]->user_id][$trainingname] = true;
			}
						
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
			echo "<script>parent.setErrorMessage('Import success')</script>";
		}
		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
