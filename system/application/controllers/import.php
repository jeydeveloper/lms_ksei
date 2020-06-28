<?php
include_once "base.php"; 

class Import extends Base{
	var $sess;
	var $lang;
	var $modules;
	var $settings;

	function Import()
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
		$this->load->model("banksoalmodel");
		$this->load->model("levelmodel");
		$this->load->model("logmodel");
		
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
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu());	
		
		$q = $this->db->get("general_setting");
		$this->db->flush_cache();
		
		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$this->settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		}		
	}
	
	function index(){
		redirect(base_url());
	}
	
	function topic_traning()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$sess = unserialize($usess);
		
		$this->mysmarty->assign("limport_category_topic", ucfirst($this->config->item('limport_category_topic')));
		$this->mysmarty->assign("limport_training", ucfirst($this->config->item('limport_training')));
		
		$this->mysmarty->assign("lcategory_topic_file", $this->config->item('lcategory_topic_file'));
		$this->mysmarty->assign("ltraining_file", $this->config->item('ltraining_file'));
		$this->mysmarty->assign("limport_historyexam", $this->config->item('limport_historyexam'));	
		$this->mysmarty->assign("lhistoryexam_file", $this->config->item('lhistoryexam_file'));		
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/import.html");
		$this->mysmarty->display("sess_template.html");		
	}

	function masterdata()
	{
		$this->mysmarty->assign("limport_org", ucfirst($this->config->item('limport_org')));
		$this->mysmarty->assign("lorg_file", $this->config->item('lorg_file'));
		$this->mysmarty->assign("limport_hirarchy_group", ucfirst($this->config->item('limport_hirarchy_group')));
		$this->mysmarty->assign("lhirarchy_group_file", $this->config->item('lhirarchy_group_file'));
		$this->mysmarty->assign("limport_jabatan", ucfirst($this->config->item('limport_jabatan')));
		$this->mysmarty->assign("ljabatan_file", $this->config->item('ljabatan_file'));
		$this->mysmarty->assign("limport_lokasi", ucfirst($this->config->item('limport_lokasi')));
		$this->mysmarty->assign("llokasi_file", $this->config->item('llokasi_file'));		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "level/import.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function savecategory($file="", $isrename=false)
	{		
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{		
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_category_topic_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_category_topic_file");
			}
		}
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{			
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['parent'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : 0;
				$row['code'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : "";
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : "";
				$row['desc'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : "";
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? $this->xlsreader->sheets[0]['cells'][$irow][6] : "";
				$row['type'] = isset($this->xlsreader->sheets[0]['cells'][$irow][8]) ? $this->xlsreader->sheets[0]['cells'][$irow][8] : "";
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++$irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['parent'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['code'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['name'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();
                    $row['desc'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(5, $irow)->getValue();
                    $row['type'] = $worksheet->getCellByColumnAndRow(7, $irow)->getValue();

                    $data[] = $row;
                }

            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_category_topic_file_data");
				}
			}			
		}
		
		$this->logmodel->init("import_category");

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import category failed", '', "category");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportcat', \"".$err."\")</script>";
			}
			
			return;
		}
		
		$this->db->delete("category");		
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['category_id'] = $data[$i]['id'];
			$insert['category_name'] = $data[$i]['name'];
			$insert['category_desc'] = $data[$i]['desc'];
			$insert['category_parent'] = $data[$i]['parent'];
			$insert['category_created'] = date("Ymd");
			$insert['category_creator'] = $sess['user_id'];
			$insert['category_status'] = $data[$i]['status'];
			$insert['category_code'] = $data[$i]['code'];			
			$insert['category_type'] = $data[$i]['type'];
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{
				$s = maptostr($insert);
				$this->logmodel->append($s);
			}
			
			$this->db->insert("category", $insert);
		}		
			
		if (is_file($file))
		{
			$s_echo =  "total category/topic: ".count($data)."\r\n";
			
			$this->logmodel->append($s_echo);
			
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import category successfully", $s_echo, "category");			
		}
		else
		{				
			echo "<script>parent.setSuccess('messageimportcat', \"".$this->config->item('limportcategory_topic_ok')."\")</script>";
		}
	}	
	
	function noticeadmin($subject, $message, $type)
	{
		$message .= "for detail see <a href='".base_url()."log/".$type."/".date("Ymd").".log'>".$type." log</a>\r\n";
		
		$this->load->library('email');
		
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
	
	function savetraining($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_training_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_training_file");
			}
		}
			
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");

			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{			
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['topic'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : 0;
				$row['code'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : "";
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : "";
				$row['created'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? $this->xlsreader->sheets[0]['cells'][$irow][6] : date("Ymd");
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? $this->xlsreader->sheets[0]['cells'][$irow][7] : 1;
				$row['type'] = isset($this->xlsreader->sheets[0]['cells'][$irow][9]) ? $this->xlsreader->sheets[0]['cells'][$irow][9] : 1;
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['topic'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['code'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();
                    $row['name'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();
                    $row['created'] = $worksheet->getCellByColumnAndRow(5, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(6, $irow)->getValue();
                    $row['type'] = $worksheet->getCellByColumnAndRow(8, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_training_file_data");
				}
			}			
		}

		$this->logmodel->init("import_training");

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import training failed", '', "training");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimporttraining', \"".$err."\")</script>";
			}
			
			return;
		}
		
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rowtrainings  = $q->result();
		for($i=0; $i < count($rowtrainings); $i++)
		{
			$trainings[$rowtrainings[$i]->training_id] = $rowtrainings[$i];
		}
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['training_id'] = $data[$i]['id'];
			$insert['training_topic'] = $data[$i]['topic'];
			$insert['training_name'] = $data[$i]['name'];
			$insert['training_created_date'] = $data[$i]['created'];
			$insert['training_status'] = $data[$i]['status'];
			$insert['training_type'] = $data[$i]['type'];
			$insert['training_code'] = $data[$i]['code'];
			$insert['training_modified'] = date("Y-m-d H:i:s");
			$insert['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;
			
			if (isset($trainings[$data[$i]['id']]))
			{
				$this->db->where("training_id", $data[$i]['id']);
				$this->db->update("training", $insert);
				$this->db->flush_cache();
				
				if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
				{
					$s = maptostr($insert);
					$this->logmodel->append($s);
				}				
			}
			else
			{			
				$insert['training_desc'] = "";
				$insert['training_author_firstname'] = "";
				$insert['training_author_lastname'] = "";
				$insert['training_author_inital'] = "";
				$insert['training_author_email'] = "";	
				$insert['training_author_id'] = $sess['user_id'];			
				$insert['training_creator'] = $sess['user_id'];
				$insert['training_material'] = "";
				$insert['training_all_staff'] = 1;
				$insert['training_max'] = 0;
				$insert['training_material_type'] = 1;		
				$insert['training_pass'] = 0;
				$insert['training_duration'] = 0;
				$insert['training_total_question'] = 0;
				$insert['training_setting_jmlsoal'] = 0;
				$insert['training_setting_bobotmudah'] = 0;
				$insert['training_setting_bobotsedang'] = 0;
				$insert['training_setting_bobotsulit'] = 0;
				$insert['training_durationperquestion'] = 0;
				$insert['training_banksoal'] = 0;			
				$insert['training_cost'] = 0;
				$insert['training_intro'] = 0;
				$insert['training_created_date'] = date("Ymd");
				
				$this->db->insert("training", $insert);
				$trainingid = $this->db->insert_id();
				
				$trainings[$trainingid] = $insert;

				if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
				{
					$s = maptostr($insert);
					$this->logmodel->append($s);
				}				
			}
		}		

		if (is_file($file))
		{
			$s_echo =  "total training/certificate/classroom: ".count($data)."\r\n";
			
			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import training successfully", $s_echo, "training");
		}
		else
		{	
			echo "<script>parent.setSuccess('messageimporttraining', \"".$this->config->item('limporttraining_ok')."\")</script>";
		}
	}	
	
	function savehistoryexam($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_historyexam_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_historyexam_file");
			}
		}
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{			
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['training'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : 0;
				$row['date'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : date("Ymd");
				$row['time'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : date("Gis");
				$row['score'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? $this->xlsreader->sheets[0]['cells'][$irow][6] : 0;
				$row['user'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? $this->xlsreader->sheets[0]['cells'][$irow][7] : 0;
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][8]) ? $this->xlsreader->sheets[0]['cells'][$irow][8] : 1;
				$row['code'] = isset($this->xlsreader->sheets[0]['cells'][$irow][10]) ? $this->xlsreader->sheets[0]['cells'][$irow][10] : 1;
				$row['no'] = isset($this->xlsreader->sheets[0]['cells'][$irow][12]) ? $this->xlsreader->sheets[0]['cells'][$irow][12] : 1;
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['training'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['date'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();
                    $row['time'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();
                    $row['score'] = $worksheet->getCellByColumnAndRow(5, $irow)->getValue();
                    $row['user'] = $worksheet->getCellByColumnAndRow(6, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(7, $irow)->getValue();
                    $row['code'] = $worksheet->getCellByColumnAndRow(9, $irow)->getValue();
                    $row['no'] = $worksheet->getCellByColumnAndRow(11, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_historyexam_file_data");
				}
			}			
		}

		$this->logmodel->init("import_exam");

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import exam failed", '', "exam");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportexam', \"".$err."\")</script>";
			}
			
			return;
		}
		
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();
		
		$rowexams  = $q->result();
		for($i=0; $i < count($rowexams); $i++)
		{
			$exams[$rowexams[$i]->history_exam_id] = $rowexams[$i];
		}
		
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rowtrainings  = $q->result();
		for($i=0; $i < count($rowtrainings); $i++)
		{
			$trainings[$rowtrainings[$i]->training_id] = $rowtrainings[$i];
		}
				
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);

			//--------get user id from npk--------
			$res = $this->db->select('user_id')->where('user_npk = "'.$data[$i]['user'].'"')->get('user')->row_array();
			$this->db->flush_cache();
			//-------jika user id tidak ditemukan, maka lewatkan
			if(empty($res['user_id'])) continue;
			
			$insert['history_exam_id'] = $data[$i]['id'];
			$insert['history_exam_training'] = $data[$i]['training'];
			$insert['history_exam_date'] = $data[$i]['date'];
			$insert['history_exam_time'] = $data[$i]['time'];
			$insert['history_exam_score'] = $data[$i]['score'];
			$insert['history_exam_user'] = $res['user_id'];
			$insert['history_exam_status'] = $data[$i]['status'];
			$insert['history_exam_type'] = $data[$i]['code'];
			$insert['history_exam_startdate'] = $data[$i]['date'];
			$insert['history_exam_starttime'] = $data[$i]['time'];
			$insert['history_exam_no'] = $data[$i]['no'];
						
			if (isset($exams[$data[$i]['id']]))
			{
				$this->db->where("history_exam_id", $data[$i]['id']);
				$this->db->update("history_exam", $insert);
				$this->db->flush_cache();
				
				if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
				{
					$s = maptostr($insert);
					$this->logmodel->append($s);
				}
			}
			else
			{			
				if (isset($trainings[$data[$i]['training']]))
				{
					$insert['history_exam_minscore'] = $trainings[$data[$i]['training']]->training_pass;
				}
				else
				{
					$insert['history_exam_minscore'] = 0;
				}
				
				$insert['history_exam_ip'] = "";				
				$insert['history_exam_reset'] = 0;				
				
				$this->db->insert("history_exam", $insert);
				
				$examid = $this->db->insert_id();
				$exams[$examid] = $insert;
				
				if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
				{
					$s = maptostr($insert);
					$this->logmodel->append($s);
				}
			}
		}		
			
		if (is_file($file))
		{
			$s_echo =  "total history exam: ".count($data)."\r\n";
			
			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}			
			
			$this->noticeadmin("import exam successfully", $s_echo, "exam");			
		}
		else
		{				
			echo "<script>parent.setSuccess('messageimportexam', \"".$this->config->item('limporthistoryexamok')."\")</script>";
		}
	}
	
	function saveorg($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{				
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_org_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_org_file");
			}
		}
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : 0;
				$row['parent'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : "";
				$row['nth'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : "";
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['name'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['parent'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['nth'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_org_file_data");
				}
			}			
		}

		$this->logmodel->init("import_org");
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import org failed", '', "org");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportorg', \"".$err."\")</script>";
			}						
			
			return;
		}
		
		$this->db->delete("level");		
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['level_id'] = $data[$i]['id'];
			$insert['level_name'] = $data[$i]['name'];
			$insert['level_parent'] = $data[$i]['parent'];
			$insert['level_status'] = 1;
			$insert['level_nth'] = $data[$i]['nth'];
			$insert['level_description'] = '';
			$insert['level_created'] = date("Ymd");
			$insert['level_creator'] = $sess['user_id'];			
			
			$this->db->insert("level", $insert);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{
				$s = maptostr($insert);
				$this->logmodel->append($s);
			}
		}		
		
		if (is_file($file))
		{
			$s_echo =  "total hirarki org: ".count($data)."\r\n";
			
			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import org successfully", $s_echo, "org");
		}
		else
		{
			echo "<script>parent.setSuccess('messageimportorg', \"".$this->config->item('limportorg_ok')."\")</script>";
		}
	}
	
	function savegroup($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_hirarchy_group_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_hirarchy_group_file");
			}
		}
		
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
							
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";
				$row['parent'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : 0;
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : 1;
				$row['nth'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? $this->xlsreader->sheets[0]['cells'][$irow][7] : 1;
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['name'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['parent'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();
                    $row['nth'] = $worksheet->getCellByColumnAndRow(6, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_hirarchy_group_file_data");
				}
			}			
		}

		$this->logmodel->init("import_group");
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import group failed", '', "group");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportgroup', \"".$err."\")</script>";
			}
			
			return;
		}
		
		$this->db->delete("level_group");		
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['level_group_id'] = $data[$i]['id'];
			$insert['level_group_name'] = $data[$i]['name'];
			$insert['level_group_parent'] = $data[$i]['parent'];
			$insert['level_group_status'] = $data[$i]['status'];
			$insert['level_group_nth'] = $data[$i]['nth'];
			$insert['level_group_created'] = date("Ymd");
			$insert['level_group_creator'] = $sess['user_id'];			
			
			$this->db->insert("level_group", $insert);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{
				$s = maptostr($insert);
				$this->logmodel->append($s);
			}			
		}	
		
		if (is_file($file))
		{
			$s_echo =  "total hirarki group: ".count($data)."\r\n";

			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import group successfully", $s_echo, "group");			
		}
		else
		{					
			echo "<script>parent.setSuccess('messageimportgroup', \"".$this->config->item('limporthirarchy_group_ok')."\")</script>";
		}
	}
	
	function savejabatan($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_jabatan_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_jabatan_file");
			}
		}
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : 0;
				$row['group'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : 1;
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['name'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['group'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_jabatan_file_data");
				}
			}			
		}
		
		$this->logmodel->init("import_jabatan");

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import jabatan failed", '', "jabatan");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportjabatan', \"".$err."\")</script>";
			}			
			
			return;
		}
		
		$this->db->delete("jabatan");		
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['jabatan_id'] = $data[$i]['id'];
			$insert['jabatan_name'] = $data[$i]['name'];
			$insert['jabatan_status'] = $data[$i]['status'];			
			$insert['jabatan_created'] = date("Ymd");
			$insert['jabatan_creator'] = $sess['user_id'];	
			$insert['jabatan_level_group'] = $data[$i]['group'];		
			
			$this->db->insert("jabatan", $insert);

			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{
				$s = maptostr($insert);
				$this->logmodel->append($s);
			}			
		}		

		if (is_file($file))
		{
			$s_echo =  "total jabatan: ".count($data)."\r\n";

			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import jabatan successfully", $s_echo, "jabatan");
		}
		else
		{					
			echo "<script>parent.setSuccess('messageimportjabatan', \"".$this->config->item('limportjabatan_ok')."\")</script>";
		}
	}
	
	function savelokasi($file="", $isrename=false)
	{
		$usess = $this->session->userdata('lms_sess');	
		$sess = unserialize($usess);

		$errs = array();
		
		if (! is_file($file))
		{
			if (! isset($_FILES['userfile']))
			{
				$errs[] = $this->config->item("lempty_lokasi_file");
			}
			else
			if (! $_FILES['userfile']['name'])
			{
				$errs[] = $this->config->item("lempty_lokasi_file");
			}
		}
		
		if (count($errs) == 0)
		{
		    /*
			$this->load->library("xlsreader");
			
			if (is_file($file))
			{
				$this->xlsreader->read($file);
			}
			else
			{			
				$this->xlsreader->read($_FILES['userfile']['tmp_name']);
			}
			
			$irow = 2;
			while(1)
			{
				if  (! isset($this->xlsreader->sheets[0]['cells'][$irow][1])) break;
				
				unset($row);
				
				$row['id'] = $this->xlsreader->sheets[0]['cells'][$irow][1];
				$row['kota'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";
				$row['alamat'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : "";
				$row['status'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : 1;
				
				$data[] = $row;								
				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            if (is_file($file))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            }
            else
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);
            }

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++ $irow) {
                    unset($row);

                    $row['id'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();
                    $row['kota'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();
                    $row['alamat'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['status'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();

                    $data[] = $row;
                }
            }
			
			if (count($errs) == 0)
			{
				if (! isset($data))
				{
					$errs[] = $this->config->item("lempty_lokasi_file_data");
				}
			}			
		}

		$this->logmodel->init("import_lokasi");
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$err = $this->mysmarty->fetch("errmessage.html");
			$err = str_replace("\"", "'", $err);
			$err = str_replace("\r", "", $err);
			$err = str_replace("\n", "", $err);
			
			$s_error = join(",", $errs);
			$this->logmodel->append($s_error);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{				
				echo $s_error."\r\n";	
				$this->noticeadmin("import lokasi failed", '', "lokasi");
			}
			else
			{
				echo "<script>parent.setErrorMessage('messageimportlokasi', \"".$err."\")</script>";
			}			
			
			return;
		}
		
		$this->db->delete("lokasi");		
		
		for($i=0; $i < count($data); $i++)
		{					
			unset($insert);
			
			$insert['lokasi_id'] = $data[$i]['id'];
			$insert['lokasi_kota'] = $data[$i]['kota'];
			$insert['lokasi_alamat'] = $data[$i]['alamat'];			
			$insert['lokasi_created'] = date("Ymd");
			$insert['lokasi_creator'] = $sess['user_id'];	
			$insert['lokasi_status'] = $data[$i]['status'];		
			
			$this->db->insert("lokasi", $insert);
			
			if (isset($_SERVER['CLIENTNAME']) && (strcasecmp($_SERVER['CLIENTNAME'], "CONSOLE") == 0))
			{
				$s = maptostr($insert);
				$this->logmodel->append($s);
			}
		}		

		if (is_file($file))
		{
			$s_echo =  "total lokasi: ".count($data)."\r\n";
			
			$this->logmodel->append($s_echo);
			if ($isrename) 
			{
				$paths = pathinfo($file);
				$newfile = $paths['dirname'].date("Ymd")."_".$paths['basename'];
				
				rename($file, $newfile);
			}
			
			$this->noticeadmin("import lokasi successfully", $s_echo, "lokasi");			
		}
		else
		{	
			echo "<script>parent.setSuccess('messageimportlokasi', \"".$this->config->item('limportlokasi_ok')."\")</script>";
		}
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
