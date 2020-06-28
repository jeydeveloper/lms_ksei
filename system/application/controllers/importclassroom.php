<?php

class Importclassroom extends Controller {
	public $docRoot;
	public $fileExcel;

	function __construct() {
		parent::Controller();

		$this->load->database();
		$this->load->model("levelmodel");

		//-----document root application--------
		$this->docRoot = $_SERVER['DOCUMENT_ROOT'] . '/NCCLP2/';

		//-----file import excel classroom----------
		$this->fileExcel = $this->docRoot . 'import/Classroom/import.xls';
	}

	function index()
	{
		//echo $this->cleanText('Andy/Andi "j" ~ \' & : (Juliadi)');
		//exit();

		ini_set("max_execution_time", 0);
		ini_set("memory_limit", "1024M");

		echo "\n";
		echo "-------- IMPORT START, PLEASE WAITING --------";
		echo "\n";
		echo "\n";

		$this->load->library("xlsreader");
		$this->xlsreader->read($this->fileExcel);

		$levels = array();
		$this->levelmodel->getalllevels(0, &$levels);

		$data = array();
		$errs = array();
		$level = array();

		$irow = 2;
		while(1) {
			if(!isset($this->xlsreader->sheets[0]['cells'][$irow][1]) AND !isset($this->xlsreader->sheets[0]['cells'][$irow][2])) break;

			$row = array();

			$row['npk'] = $this->xlsreader->sheets[0]['cells'][$irow][1];				
				
			$row['name'] = isset($this->xlsreader->sheets[0]['cells'][$irow][2]) ? $this->xlsreader->sheets[0]['cells'][$irow][2] : "";

			$row['trainingname'] = isset($this->xlsreader->sheets[0]['cells'][$irow][3]) ? $this->xlsreader->sheets[0]['cells'][$irow][3] : "";

			$row['durasi'] = isset($this->xlsreader->sheets[0]['cells'][$irow][4]) ? $this->xlsreader->sheets[0]['cells'][$irow][4] : "";
			$row['batch'] = isset($this->xlsreader->sheets[0]['cells'][$irow][5]) ? $this->xlsreader->sheets[0]['cells'][$irow][5] : "";
			
			$row['datestart'] = isset($this->xlsreader->sheets[0]['cells'][$irow][6]) ? $this->xlsreader->sheets[0]['cells'][$irow][6] : "";
			$row['dateend'] = isset($this->xlsreader->sheets[0]['cells'][$irow][7]) ? $this->xlsreader->sheets[0]['cells'][$irow][7] : "";

			$dateStart = date('d/m/Y', strtotime('1899-12-31+'.($row['datestart']-1).' days'));
			if($dateStart == '01/01/1970') $dateStart = $row['datestart'];

			$dateEnd = date('d/m/Y', strtotime('1899-12-31+'.($row['dateend']-1).' days'));
			if($dateEnd == '01/01/1970') $dateEnd = $row['dateend'];

			$row['tdatestart'] = date("Ymd", $this->formmaketime($dateStart." 00:00:00"));
			$row['tdateend'] = date("Ymd", $this->formmaketime($dateEnd." 00:00:00"));
			
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
				$level[] = $this->xlsreader->sheets[0]['cells'][$irow][$j+11];
			}
			
			$j = count($levels)+11;

			$row['level'] = $level;
			$row['jabatan'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j] : "";
			$row['alamat'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+1]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+1] : "";
			$row['kota'] = isset($this->xlsreader->sheets[0]['cells'][$irow][$j+2]) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+2] : "";
			$row['cost'] = (isset($this->xlsreader->sheets[0]['cells'][$irow][$j+3]) && is_numeric($this->xlsreader->sheets[0]['cells'][$irow][$j+3])) ? $this->xlsreader->sheets[0]['cells'][$irow][$j+3] : 0;

			$data[] = $row;

			$irow++;
		}

		if(!empty($data)) {
			//---------DANGERRrrr!!!!!!!!---------
			/*
			$res = $this->db->select('training_id')->where('training_type = 3')->get('training')->result_array();
			if(!empty($res)) {
				foreach ($res as $key => $value) {
					$this->db->where('history_exam_training = ' . $value['training_id'])->delete('history_exam');
					echo "DELETE HISTORY EXAM TRAINING ID: " . $value['training_id'];
					echo "\n";
				}
			}
			*/

			$res = $this->db->select('history_exam_id')->where('history_exam_date = "19700101"')->get('history_exam')->result_array();
			if(!empty($res)) {
				foreach ($res as $key => $value) {
					$this->db->where('history_exam_id = ' . $value['history_exam_id'])->delete('history_exam');
					echo "DELETE HISTORY EXAM '1970-01-01' ID: " . $value['history_exam_id'];
					echo "\n";
				}
			}

			$res = $this->db->select('training_time_id')->where('training_time_date1 = "19700101"')->get('training_time')->result_array();
			if(!empty($res)) {
				foreach ($res as $key => $value) {
					$this->db->where('training_time_id = ' . $value['training_time_id'])->delete('training_time');
					echo "DELETE TRAINING TIME '1970-01-01' ID: " . $value['training_time_id'];
					echo "\n";
				}
			}

			//---------right---------
			$res = $this->db->select('right_id')->where('right_name = "trainee"')->get('right')->row_array();
			if(!empty($res)) {
				$usertype = $res['right_id'];
			} else {
				$usertype = 0;
			}

			$info = array();
			$cnt = 1;
			foreach ($data as $value) {
				echo "Data $cnt import";
				echo "\n";

				//-------category--------
				$value['category'] = $this->cleanText($value['category']);
				//$res = $this->db->select('category_id')->where('category_name = "'.$value['category'].'" AND category_parent = 0 AND category_type = 1')->get('category')->row_array();
				$res = $this->db->select('category_id')->where('category_name = "'.$value['category'].'" AND category_parent = 0')->get('category')->row_array();
				if(!empty($res)) {
					$training_topic = $res['category_id'];
				} else {
					$array = array(
						'category_name' => $value['category'],
						'category_type' => 1,
						'category_parent' => 0,
						'category_code' => substr(md5($value['category']), 0, 8),
						'category_created' => date("Ymd"),
						'category_creator' => 1,
					);

					$res = $this->db->insert('category', $array);

					$training_topic = $this->db->insert_id();

					$info['newCategory'][$training_topic] = $value['category'];
				}

				//----------lokasi-----------
				$value['kota'] = !empty($value['kota']) ? $this->cleanText($value['kota']) : '';
				$value['alamat'] = !empty($value['alamat']) ? $this->cleanText($value['alamat']) : '';
				$res = $this->db->select('lokasi_id')->where('lokasi_kota = "'.$value['kota'].'" AND lokasi_alamat = "'.$value['alamat'].'"')->get('lokasi')->row_array();
				if(!empty($res)) {
					$lokasiid = $res['lokasi_id'];
				} else {
					$array = array(
						'lokasi_kota' => $value['kota'],
						'lokasi_alamat' => $value['alamat'],
						'lokasi_created' => date("Ymd"),
						'lokasi_status' => 1,
					);

					$res = $this->db->insert('lokasi', $array);

					$lokasiid = $this->db->insert_id();

					$info['newLocation'][$lokasiid] = 'KOTA: '.$value['kota'].', ALAMAT: '.$value['alamat'];
				}

				//-------training--------
				$value['trainingname'] = $this->cleanText($value['trainingname']);
				$value['trainingauthor'] = $this->cleanText($value['trainingauthor']);
				$value['trainingtype'] = $this->cleanText($value['trainingtype']);
				$value['cost'] = trim($value['cost']);
				$res = $this->db->select('training_id')->where('training_topic = "'.$training_topic.'" AND training_name = "'.$value['trainingname'].'"')->get('training')->row_array();
				if(!empty($res)) {
					$trainingid = $res['training_id'];
				} else {
					$insert = array();
				
					$insert['training_topic'] = $training_topic;
					$insert['training_cost'] = $value['cost'];
					$insert['training_author_firstname'] = $value['trainingauthor'];
					$insert['training_author_lastname'] = $value['trainingtype'];
					$insert['training_banksoal'] = $value['batch'];
					$insert['training_duration'] = $value['durasi']*3600;
					$insert['training_modified'] = date("Y-m-d H:i:s");
					$insert['training_name'] = $value['trainingname'];
					$insert['training_desc'] = "";								
					$insert['training_author_inital'] = "";
					$insert['training_author_email'] = "";
					$insert['training_author_id'] = 0;
					$insert['training_created_date'] = date("Ymd");
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

					$res = $this->db->insert('training', $insert);

					$trainingid = $this->db->insert_id();

					$info['newTraining'][$trainingid] = 'TOPIC: '.$value['category'].', TRAINING NAME: '.$value['trainingname'];
				}

				//----------training lokasi-----------
				$res = $this->db->select('training_lokasi_id')->where('training_lokasi_lokasi = "'.$lokasiid.'" AND training_lokasi_training = "'.$trainingid.'"')->get('training_lokasi')->row_array();
				if(!empty($res)) {
					$training_lokasi_id = $res['training_lokasi_id'];
				} else {
					$insert = array();

					$insert['training_lokasi_lokasi'] = $lokasiid;
					$insert['training_lokasi_training'] = $trainingid;

					$res = $this->db->insert('training_lokasi', $insert);

					$training_lokasi_id = $this->db->insert_id();

					$info['newTrainingLocation'][$training_lokasi_id] = 'LOKASI ID: '.$lokasiid.', TRAINING ID: '.$trainingid;
				}

				//----------training time-----------
				$value['tdatestart'] = trim($value['tdatestart']);
				$value['tdateend'] = trim($value['tdateend']);
				$res = $this->db->select('training_time_id')->where('training_time_date1 = "'.$value['tdatestart'].'" AND training_time_date2 = "'.$value['tdateend'].'" AND training_time_training = "'.$trainingid.'"')->get('training_time')->row_array();
				if(!empty($res)) {
					$training_time_id = $res['training_time_id'];
				} else {
					$insert = array();

					$insert['training_time_date1'] = $value['tdatestart'];
					$insert['training_time_date2'] = $value['tdateend'];
					$insert['training_time_period'] = 0;
					$insert['training_time_training'] = $trainingid;
					$insert['training_time_parent'] = 0;
					$insert['training_time_refreshed'] = 0;

					$res = $this->db->insert('training_time', $insert);

					$training_time_id = $this->db->insert_id();

					$info['newTrainingTime'][$training_time_id] = 'TIME START: '.$value['tdatestart'].', TIME END: '.$value['tdateend'].', TRAINING ID: '.$trainingid;
				}

				//-------user--------
				//$value['npk'] = $this->cleanText($value['npk']);
				$value['npk'] = $value['npk'];
				$value['name'] = $this->cleanText($value['name']);
				$res = $this->db->select('user_id')->where('user_npk = "'.$value['npk'].'"')->get('user')->row_array();
				if(!empty($res)) {
					$userid = $res['user_id'];
				} else {
					$insert = array();

					$insert['user_npk'] = $value['npk'];
					$insert['user_first_name'] = $value['name'];
					$insert['user_pass'] = substr(md5($value['npk']), 0, 100);				
					$insert['user_last_name'] = "";
					$insert['user_join_date'] = date("Ymd");
					$insert['user_birthdate'] = date("Ymd");
					$insert['user_description'] = "";
					$insert['user_location'] = 0;
					$insert['user_type'] = $usertype;
					$insert['user_lastlogin_date'] = 0;
					$insert['user_created_date'] = date("Ymd");
					$insert['user_created_time'] = date("Gis");
					$insert['user_email'] = '';
					$insert['user_function'] = 0;
					$insert['user_jabatan'] = '';
					$insert['user_status'] = 1;
					$insert['user_emp'] = 1;
					$insert['user_forgotpass_confirm'] = '';
					$insert['user_forgotpass_date'] = 0;
					$insert['user_lastmodifiedpassword'] = 0;
					$insert['user_loginerror'] = 0;
					$insert['user_import'] = 0;

					$res = $this->db->insert('user', $insert);

					$userid = $this->db->insert_id();

					$info['newUser'][$userid] = $value['npk'];
				}

				//-------history exam--------
				$value['tdatestart'] = trim($value['tdatestart']);
				$res = $this->db->select('history_exam_id')->where('history_exam_user = "'.$userid.'" AND history_exam_training = "'.$trainingid.'" AND history_exam_startdate = "'.$value['tdatestart'].'"')->get('history_exam')->row_array();
				if(!empty($res)) {
					$history_exam_id = $res['history_exam_id'];
				} else {
					$insert = array();

					$insert['history_exam_training'] = $trainingid;
					$insert['history_exam_date'] = $value['tdatestart'];
					$insert['history_exam_time'] = 90000;
					$insert['history_exam_score'] = 0;
					$insert['history_exam_user'] = $userid;
					$insert['history_exam_ip'] = $_SERVER['REMOTE_ADDR'];
					$insert['history_exam_status'] = 1;
					$insert['history_exam_minscore'] = 0;
					$insert['history_exam_type'] = 4;
					$insert['history_exam_startdate'] = $value['tdatestart'];
					$insert['history_exam_starttime'] = 90000;
					$insert['history_exam_no'] = 0;
					$insert['history_exam_reset'] = 0;
					$insert['history_exam_lokasi'] = $lokasiid;

					$res = $this->db->insert('history_exam', $insert);

					$history_exam_id = $this->db->insert_id();

					$info['newHistoryExam'][$history_exam_id] = $trainingid;
				}

				$cnt++;
			}
		} else {
			echo "Data kosong!";
			echo "\n";
		}

		echo "\n";

		echo "-------- IMPORT DONE --------";
		echo "\n";
		echo "\n";

		if(!empty($info)) {
			echo "INFORMATION:";
			echo "\n";
			
			if(!empty($info['newCategory'])) {
				echo "TOTAL NEW CATEGORY: ".count($info['newCategory']);
				echo "\n";
			}

			if(!empty($info['newLocation'])) {
				echo "TOTAL NEW LOCATION: ".count($info['newLocation']);
				echo "\n";
			}

			if(!empty($info['newTraining'])) {
				echo "TOTAL NEW TRAINING: ".count($info['newTraining']);
				echo "\n";
			}

			if(!empty($info['newTrainingLocation'])) {
				echo "TOTAL NEW TRAINING LOCATION: ".count($info['newTrainingLocation']);
				echo "\n";
			}

			if(!empty($info['newTrainingTime'])) {
				echo "TOTAL NEW TRAINING TIME: ".count($info['newTrainingTime']);
				echo "\n";
			}

			if(!empty($info['newUser'])) {
				echo "TOTAL NEW USER: ".count($info['newUser']);
				echo "\n";
			}

			if(!empty($info['newHistoryExam'])) {
				echo "TOTAL NEW HISTORY EXAM: ".count($info['newHistoryExam']);
				echo "\n";
			}
		}
	}

	function formmaketime($t)
	{
		$ts = explode(" ", $t);
		
		if (count($ts) != 2) return 0;

		$ds = explode("/", trim($ts[0]));						
		$ts1 = explode(":", trim($ts[1]));
				
		if (count($ds) != 3) return 0;
		if (count($ts1) != 3) return 0;
		
		return mktime($ts1[0]*1, $ts1[1]*1, $ts1[2]*1, $ds[1]*1, $ds[0]*1, $ds[2]*1);
	}

	function cleanText($text, $len = 190) {
		$text = trim($text);
		$text = iconv("utf-8", "ascii//TRANSLIT//IGNORE", $text);
		$text =  preg_replace("/^'|[^A-Za-z0-9&():\/\'\"\s-]|'$/", '', $text);
		$text =  preg_replace("/\s+/", ' ', $text);
		return substr($text, 0, $len);
	}
}