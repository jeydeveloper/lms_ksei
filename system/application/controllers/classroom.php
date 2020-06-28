<?php

include_once "training.php";

class Classroom extends Training {
	var $sess;
	var $lang;
	var $modules;

	function Classroom()
	{
		parent::training();	
		
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');		
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
		$this->load->model("trainingmodel");
		$this->load->model("topicmodel");
		
		$this->load->database();	
		$this->lang = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->lang ? $this->lang : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->lang);
		$this->mysmarty->assign("base_url", base_url());
		$this->mysmarty->assign("site_url", site_url());
		
		$this->mysmarty->assign("page", $this->uri->segment(1));
		$this->mysmarty->assign("subpage", $this->uri->segment(2));
		
		$usess = $this->session->userdata('lms_sess');	
		if ($usess)
		{
			$this->mysmarty->assign("sess", unserialize($usess));	
			
			$sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($sess['user_type']);					
		}		
		$this->langmodel->init();
	}
	
	function saveimport()
	{
		ini_set("max_execution_time", 0);
		ini_set("memory_limit", "1024M");

		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$own_err = array();
		$list_topic = array();
	
		$levels = array();
		$this->levelmodel->getalllevels(0, $levels);
				
		$sess = unserialize($usess);		
		
		$cat = isset($_POST['cat']) ? trim($_POST['cat']) : "";
		$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";				

		$q = $this->db->get("user");
		$this->db->flush_cache();
		
		$rownpks  = $q->result();
		for($i=0; $i < count($rownpks); $i++)
		{
			$npks[$rownpks[$i]->user_npk] = $rownpks[$i];
		}

		$errs = array();
		
		if (! $topic)
		{
			//$errs[] = $this->config->item("err_select_topic");
		}
		
		if (! isset($_FILES['userfile']))
		{
			$errs[] = $this->config->item("lemplty_classroom_file");
		}
		else
		if (! $_FILES['userfile']['name'])
		{
			$errs[] = $this->config->item("lemplty_classroom_file");
		}
		else
		{
		    /*
			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['userfile']['tmp_name']);

			$irow = 2;
			while(1)
			{
				if  (!isset($this->xlsreader->sheets[0]['cells'][$irow][1]) AND !isset($this->xlsreader->sheets[0]['cells'][$irow][2])) break;
				
				unset($row);

				$k_topic = $topic;
				$list_topic[$k_topic]['topic_id'] = $topic;

				
				$row['npk'] = $this->xlsreader->sheets[0]['cells'][$irow][1];				
				
				$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";

				$row['trainingname'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : "";
				$row['trainingname'] = trim(strtolower($row['trainingname']));

				$row['durasi'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : "";
				$row['batch'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : "";
				
				$row['datestart'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? $this->xlsreader->sheets[0]['cells'][$irow][6] : "";
				$row['dateend'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? $this->xlsreader->sheets[0]['cells'][$irow][7] : "";

				$dateStart = date('d/m/Y', strtotime('1899-12-31+'.($row['datestart']-1).' days'));
				if($dateStart == '01/01/1970') $dateStart = $row['datestart'];

				$dateEnd = date('d/m/Y', strtotime('1899-12-31+'.($row['dateend']-1).' days'));
				if($dateEnd == '01/01/1970') $dateEnd = $row['dateend'];

				$row['tdatestart'] = date("Ymd", formmaketime($dateStart." 00:00:00"));
				$row['tdateend'] = date("Ymd", formmaketime($dateEnd." 00:00:00"));

//				echo $row['tdatestart'];
//				echo "#";
//				echo $row['tdatestart'];
//				echo "#";

				$row['trainingtype'] = isset($this->xlsreader->sheets[0]['cells'][$irow][8]) ? $this->xlsreader->sheets[0]['cells'][$irow][8] : "";
				$row['trainingauthor'] = isset($this->xlsreader->sheets[0]['cells'][$irow][9]) ? $this->xlsreader->sheets[0]['cells'][$irow][9] : "";
				$row['category'] = isset($this->xlsreader->sheets[0]['cells'][$irow][10]) ? $this->xlsreader->sheets[0]['cells'][$irow][10] : "";

				unset($level);
				
				if (! isset($this->xlsreader->sheets[0]['cells'][$irow][11]))
				{
					$errs[] = $this->config->item("lnpk_classroom_empty_level_group");
					break;
				}

				$level[] = $this->xlsreader->sheets[0]['cells'][$irow][11];
				
				for($j=1; $j < count($levels); $j++)
				{
					//if (! isset($this->xlsreader->sheets[0]['cells'][$irow][$j])) break;
					
					$level[] = $this->xlsreader->sheets[0]['cells'][$irow][$j+11];
				}
				
				$j = count($levels)+11;

				$row['level'] = $level;
				$row['jabatan'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j] : "";
				$row['alamat'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+1]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+1] : "";
				$row['kota'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+2]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+2] : "";
				$row['cost'] = (isset($this->xlsreader->sheets[0]['cells'][$irow][$j+3]) && is_numeric($this->xlsreader->sheets[0]['cells'][$irow][$j+3])) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+3] : 0;
				//$row['history_exam_nonpb'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+4]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+4] : "";
				//$row['history_exam_kodeprog'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+5]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+5] : "";
				//$row['history_exam_durhari'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+6]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+6] : "";
				//$row['history_exam_durjam'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+7]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+7] : "";
				
				$list_topic[$k_topic]['detail'][] = $row;

				$irow++;				
			}
			*/

            require_once BASEPATH . "application/libraries/PHPExcel.php";
            require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['userfile']['tmp_name']);

            $data = array();

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($irow = 2; $irow <= $highestRow; ++$irow) {
                    unset($row);

                    $k_topic = $topic;
                    $list_topic[$k_topic]['topic_id'] = $topic;


                    $row['npk'] = $worksheet->getCellByColumnAndRow(0, $irow)->getValue();

                    $row['name'] = $worksheet->getCellByColumnAndRow(1, $irow)->getValue();

                    $row['trainingname'] = $worksheet->getCellByColumnAndRow(2, $irow)->getValue();
                    $row['trainingname'] = trim(strtolower($row['trainingname']));

                    $row['durasi'] = $worksheet->getCellByColumnAndRow(3, $irow)->getValue();
                    $row['batch'] = $worksheet->getCellByColumnAndRow(4, $irow)->getValue();

                    $row['datestart'] = $worksheet->getCellByColumnAndRow(5, $irow)->getValue();
                    $row['dateend'] = $worksheet->getCellByColumnAndRow(6, $irow)->getValue();

                    $dateStart = date('d/m/Y', strtotime('1899-12-31+'.($row['datestart']-1).' days'));
                    if($dateStart == '01/01/1970') $dateStart = $row['datestart'];

                    $dateEnd = date('d/m/Y', strtotime('1899-12-31+'.($row['dateend']-1).' days'));
                    if($dateEnd == '01/01/1970') $dateEnd = $row['dateend'];

                    $row['tdatestart'] = date("Ymd", formmaketime($dateStart." 00:00:00"));
                    $row['tdateend'] = date("Ymd", formmaketime($dateEnd." 00:00:00"));

//				echo $row['tdatestart'];
//				echo "#";
//				echo $row['tdatestart'];
//				echo "#";

                    $row['trainingtype'] = $worksheet->getCellByColumnAndRow(7, $irow)->getValue();
                    $row['trainingauthor'] = $worksheet->getCellByColumnAndRow(8, $irow)->getValue();
                    $row['category'] = $worksheet->getCellByColumnAndRow(9, $irow)->getValue();

                    unset($level);

                    $lvl = $worksheet->getCellByColumnAndRow(10, $irow)->getValue();
                    if (! isset($lvl))
                    {
                        $errs[] = $this->config->item("lnpk_classroom_empty_level_group");
                        break;
                    }

                    $level[] = $worksheet->getCellByColumnAndRow(10, $irow)->getValue();

                    for($j=1; $j < count($levels); $j++)
                    {
                        //if (! isset($this->xlsreader->sheets[0]['cells'][$irow][$j])) break;

                        $level[] = $worksheet->getCellByColumnAndRow(($j+10), $irow)->getValue();
                    }

                    $j = count($levels)+10;

                    $row['level'] = $level;
                    $row['jabatan'] = $worksheet->getCellByColumnAndRow($j, $irow)->getValue();
                    $row['alamat'] = $worksheet->getCellByColumnAndRow(($j+1), $irow)->getValue();
                    $row['kota'] = $worksheet->getCellByColumnAndRow(($j+2), $irow)->getValue();
                    $row['cost'] = $worksheet->getCellByColumnAndRow(($j+3), $irow)->getValue();
                    //$row['history_exam_nonpb'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+4]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+4] : "";
                    //$row['history_exam_kodeprog'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+5]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+5] : "";
                    //$row['history_exam_durhari'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+6]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+6] : "";
                    //$row['history_exam_durjam'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+7]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+7] : "";

                    //print_r($row);exit();

                    $list_topic[$k_topic]['detail'][] = $row;
                }

            }

			//exit();
			
			if (count($errs) == 0)
			{
				if (! isset($list_topic))
				{
					$errs[] = $this->config->item("lempty_classroom_file_data");
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
			
			echo "<script>parent.setErrorMessage('messageimport', \"".$err."\")</script>";
			
			return;
		}

		$q = $this->db->get("lokasi");
		$this->db->flush_cache();
		
		$rowlokasies  = $q->result_array();
		for($i=0; $i < count($rowlokasies); $i++)
		{
			$lokasies[strtoupper($rowlokasies[$i]['lokasi_kota'])][strtoupper($rowlokasies[$i]['lokasi_alamat'])] = $rowlokasies[$i];
		}

		$q = $this->db->get("level_group");
		$this->db->flush_cache();
		
		$rowgroups  = $q->result();
		for($i=0; $i < count($rowgroups); $i++)
		{
			$groups[$rowgroups[$i]->level_group_nth][$rowgroups[$i]->level_group_parent][$rowgroups[$i]->level_group_name] = $rowgroups[$i];
		}

		$q = $this->db->get("jabatan");
		$this->db->flush_cache();
		
		$rowjabatans  = $q->result();
		for($i=0; $i < count($rowjabatans); $i++)
		{
			$jabatans[$rowjabatans[$i]->jabatan_level_group][$rowjabatans[$i]->jabatan_name] = $rowjabatans[$i];
		}

		$this->db->where("training_type", 3);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rowtrainings  = $q->result_array();
		for($i=0; $i < count($rowtrainings); $i++)
		{
			$rowtrainings[$i]["training_name"] = trim(strtolower($rowtrainings[$i]["training_name"]));
			$trainings[$rowtrainings[$i]["training_topic"]][$rowtrainings[$i]["training_name"]] = $rowtrainings[$i];
		}

		$this->db->where("history_exam_type", 4);
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();
		
		$rowexams  = $q->result();
		for($i=0; $i < count($rowexams); $i++)
		{
			$exams[$rowexams[$i]->history_exam_training][$rowexams[$i]->history_exam_user][$rowexams[$i]->history_exam_lokasi][$rowexams[$i]->history_exam_startdate] = $rowexams[$i];
		}
		
		$q = $this->db->get("training_lokasi");
		$this->db->flush_cache();
		
		$rowlokasies  = $q->result();
		for($i=0; $i < count($rowlokasies); $i++)
		{
			$traininglokasi[$rowlokasies[$i]->training_lokasi_training][$rowlokasies[$i]->training_lokasi_lokasi] = $rowlokasies[$i]->training_lokasi_id;
		}
		
		$this->db->where("training_type", 3);
		$this->db->join("training", "training_id = training_time_training");
		$q = $this->db->get("training_time");		
		$this->db->flush_cache();
		
		$rowtimes  = $q->result();
		for($i=0; $i < count($rowtimes); $i++)
		{
			$trainingtimes[$rowtimes[$i]->training_time_training][$rowtimes[$i]->training_time_date1][$rowtimes[$i]->training_time_date2] = $rowtimes[$i];
		}		

		// search right
		
		$this->db->where("right_name", "trainee");
		$q  = $this->db->get("right");			
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$usertype = 0;
		}
		else
		{
			$rowtype = $q->row();
			$usertype = $rowtype->right_id;
		}

		foreach($list_topic as $key => $value) {
			if(empty($value['topic_id'])) continue;

			$topic = $value['topic_id'];
			$data = $value['detail'];
			for($i=0; $i < count($data); $i++)
			{	
				if (isset($lokasies[strtoupper($data[$i]['kota'])][strtoupper($data[$i]['alamat'])]))
				{
					$lokasiid = $lokasies[strtoupper($data[$i]['kota'])][strtoupper($data[$i]['alamat'])]['lokasi_id'];
				}
				else
				{
					unset($insert);	
					
					$insert['lokasi_kota'] = $data[$i]['kota'];
					$insert['lokasi_alamat'] = $data[$i]['alamat'];
					$insert['lokasi_creator'] = $sess['user_id'];
					$insert['lokasi_created'] = date("Ymd");
					$insert['lokasi_status'] = 1;												
					
					$this->db->insert("lokasi", $insert);
					
					$lokasiid = $this->db->insert_id();	

					$insert['lokasi_id'] = $lokasiid;

					$lokasies[strtoupper($data[$i]['kota'])][strtoupper($data[$i]['alamat'])] = $insert;			
				}
				
				// trainings
				
				unset($insert);
				
				$insert['training_topic'] = $topic;
				$insert['training_cost'] = $data[$i]['cost'];
				$insert['training_author_firstname'] = $data[$i]['trainingauthor'];
				$insert['training_author_lastname'] = $data[$i]['trainingtype'];
				$insert['training_banksoal'] = $data[$i]['batch'];
				$insert['training_duration'] = $data[$i]['durasi']*3600;
				$insert['training_modified'] = date("Y-m-d H:i:s");
				$insert['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;
				
				if (isset($trainings[$topic][$data[$i]['trainingname']]))
				{
					$trainingid = $trainings[$topic][$data[$i]['trainingname']]['training_id'];
								
					$this->db->where("training_id", $trainingid);
					$this->db->update("training", $insert);
					$this->db->flush_cache();
				}
				else 
				{												
					$insert['training_name'] = $data[$i]['trainingname'];
					$insert['training_desc'] = "";								
					$insert['training_author_inital'] = "";
					$insert['training_author_email'] = "";
					$insert['training_author_id'] = 0;
					$insert['training_created_date'] = date("Ymd");
					$insert['training_creator'] = $sess['user_id'];
					$insert['training_status'] = 1;
					$insert['training_material'] = "";
					$insert['training_all_staff'] = 1;
					$insert['training_max'] = 0;
					$insert['training_material_type'] = 0;
					$insert['training_type'] = 3;
					$insert['training_pass'] = 0;				
					$insert['training_total_question'] = 0;
					$insert['training_setting_jmlsoal'] = 0;
					$insert['training_setting_bobotmudah'] = 0;
					$insert['training_setting_bobotsedang'] = 0;
					$insert['training_setting_bobotsulit'] = 0;
					$insert['training_durationperquestion'] = 0;				
					$insert['training_code'] = substr(md5(uniqid()), 0, 29);				
					$insert['training_intro'] = '';
					$insert['training_created_date'] = date("Ymd");
					
					$this->db->insert("training", $insert);
					$trainingid = $this->db->insert_id();
					
					$insert["training_id"] = $trainingid;
					
					$trainings[$topic][$data[$i]['trainingname']] = $insert;							
				}
				
				// lokasi training
							 
				if (! isset($traininglokasi[$trainingid][$lokasiid]))
				{
					unset($insert);
					
					$insert['training_lokasi_lokasi'] = $lokasiid;
					$insert['training_lokasi_training'] = $trainingid;
					
					$this->db->insert("training_lokasi", $insert);
					
					$traininglokasi[$trainingid][$lokasiid] = $insert;
				}
				
				// time
				
				
				if (! isset($trainingtimes[$trainingid][$data[$i]['tdatestart']][$data[$i]['tdateend']]))
				{
					unset($insert);
					
					$insert['training_time_date1'] = $data[$i]['tdatestart'];
					$insert['training_time_date2'] = $data[$i]['tdateend'];
					$insert['training_time_period'] = 0;
					$insert['training_time_training'] = $trainingid;
					$insert['training_time_parent'] = 0;
					$insert['training_time_refreshed'] = 0;
					
					$this->db->insert("training_time", $insert);
					
					$trainingtimes[$trainingid][$data[$i]['tdatestart']][$data[$i]['tdateend']] = $insert;
				}			
				
				// npk
				
				unset($insert);
				$insert['user_first_name'] = $data[$i]['name'];
				
				if (isset($npks[$data[$i]['npk']]))
				{
					$userid = $npks[$data[$i]['npk']]->user_id;
					
					$this->db->where("user_id", $userid);
					$this->db->update("user", $insert);
					$this->db->flush_cache();
				}
				else
				{									
					$insert['user_npk'] = $data[$i]['npk'];
					$insert['user_pass'] = substr(md5($data[$i]['npk']), 0, 100);				
					$insert['user_last_name'] = "";
					$insert['user_join_date'] = date("Ymd");
					$insert['user_birthdate'] = date("Ymd");
					$insert['user_description'] = "";
					$insert['user_location'] = 0;
					$insert['user_type'] = $usertype;
					$insert['user_lastlogin_date'] = 0;
					$insert['user_creator'] = $sess['user_id'];
					$insert['user_created_date'] = date("Ymd");
					$insert['user_created_time'] = date("Gis");
					$insert['user_email'] = $data[$i]['npk'];
					$insert['user_function'] = 0;
					$insert['user_jabatan'] = $jabatanid;
					$insert['user_status'] = 1;
					$insert['user_emp'] = 1;
					$insert['user_forgotpass_confirm'] = '';
					$insert['user_forgotpass_date'] = 0;
					$insert['user_lastmodifiedpassword'] = 0;
					$insert['user_loginerror'] = 0;
					$insert['user_import'] = 0;
					
					$this->db->insert("user", $insert);
					
					$npks[$data[$i]['npk']] = $insert;
					$userid = $this->db->insert_id();
				}
				
				if (! isset($exams[$trainingid][$userid][$lokasiid][$data[$i]['datestart']]))
				{
					if(empty($userid)) continue;

					unset($insert);	

					$insert['history_exam_training'] = $trainingid;
					$insert['history_exam_date'] = $data[$i]['tdateend'];
					$insert['history_exam_time'] = 90000;
					$insert['history_exam_score'] = 0;
					$insert['history_exam_user'] = $userid;
					$insert['history_exam_ip'] = $_SERVER['REMOTE_ADDR'];
					$insert['history_exam_status'] = 1;
					$insert['history_exam_minscore'] = 0;
					$insert['history_exam_type'] = 4;
					$insert['history_exam_startdate'] = $data[$i]['tdatestart'];
					$insert['history_exam_starttime'] = 90000;
					$insert['history_exam_no'] = 0;
					$insert['history_exam_reset'] = 0;
					$insert['history_exam_lokasi'] = $lokasiid;
					//$insert['history_exam_nonpb'] = $data[$i]['history_exam_nonpb'];
					//$insert['history_exam_kodeprog'] = $data[$i]['history_exam_kodeprog'];
					//$insert['history_exam_durhari'] = $data[$i]['history_exam_durhari'];
					//$insert['history_exam_durjam'] = $data[$i]['history_exam_durjam'];
					
					$this->db->insert("history_exam", $insert);	
					$exams[$trainingid][$userid][$lokasiid][$data[$i]['datestart']] = $insert;			
				}
			}
		}
				
		echo "<script>parent.setSuccess('messageimport', \"".$this->config->item('limportclassroom_ok')."\")</script>";			
	}
	
	function import()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}				
		
		$sess = unserialize($usess);
				
		$def = 0;
		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("limport_classroom", $this->config->item("limport_classroom"));
		$this->mysmarty->assign("lclassroom_file", $this->config->item("lclassroom_file"));		
		$this->mysmarty->assign("lcategory_name", $this->config->item("category_name"));
		$this->mysmarty->assign("ltopic_code", $this->config->item("topic"));		
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "classroom/import.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function pageid()
	{
		return "classroom";
	}	
	
	function type()
	{
		return 3;
	}	
	
	function history()
	{
		parent::history(0, 4);
	}	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
