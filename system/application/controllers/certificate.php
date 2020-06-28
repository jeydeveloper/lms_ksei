<?php
include_once "training.php";

class Certificate extends Training {
	function Certificate()
	{
		parent::Training();
		$this->training_type = "certification";
		$this->load->model("certificatemodel");
	}

	function prefix()
	{
		return "CER";
	}

	function history()
	{
		parent::history(0, 3);
	}

	function index()
	{
		redirect(site_url("certificate/showlist"));
	}

	function showlist($catid = 0){
		parent::showlist($catid);
	}

	function errprequisite($id){
		parent::errprequisite($id);
	}

	function exam($id, $show=0)
	{

		$is_debug = $this->config->item('IS_DEBUG');

		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);

		if($is_debug){
			$this->load->helper('file');
			$log_folder = $this->config->item('PATH_LOG');
			$fname = date("Ymd")."_".$sess['user_id']."_debug_log.txt";
			$filename = $log_folder."/".$fname;
		}

		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] start certificate exam"."\r\n",'a' );

		if (! $sess)
		{
			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] no session "."\r\n",'a' );

			echo json_encode(array("err"=>1, "url"=>base_url()));
			return;
		}

		$privileges = $this->trainingmodel->GetPrivileges($sess, array($id));
		if (! isset($privileges[$id]))
		{
			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] is not privillege"."\r\n",'a' );

			echo json_encode(array("err"=>1, "url"=>site_url(array("generalsetting", "errmessage", "errinvalidprivileges"))));
			return;
		}
		/*
		if ($this->trainingmodel->IsMaximumTaken($sess['user_id'], $id))
		{
			redirect(site_url(array("generalsetting", "errmessage", "errmaxtaken")));
			return;
		}
		*/

		if (! $this->trainingmodel->IsInPeriod($sess, $id))
		{
			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] is not in periode"."\r\n",'a' );

			//echo json_encode(array("err"=>3, "url"=>base_url()));
			echo json_encode(array("err"=>1, "url"=>site_url(array("generalsetting", "errmessage", "errnotisinperiod"))));
			return;
		}

		if (! $this->trainingmodel->IsGotPrerequisite($sess, $id))
		{
			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] got prerequisite"."\r\n",'a' );

			echo json_encode(array("err"=>1, "url"=>site_url(array("training", "errprequisite", $id))));

			//echo json_encode(array("err"=>4, "url"=>site_url(array("generalsetting", "errmessage", "needpracertificate",$this->trainingmodel->id[0]))));
			return;
		}

		// bank soal

		$this->db->where("training_id", $id);
		$this->db->where("training_type", 2);
		$this->db->where("(banksoal_question_jabatan = ".$sess['user_jabatan']." OR banksoal_question_alljabatan = 1)");
		$this->db->where("banksoal_question_answer <>", 0);
		$this->db->where("banksoal_question_status", 1);

		$this->db->distinct();
		$this->db->select("banksoal_question_packet");
		$this->db->join("banksoal", "banksoal_id = training_banksoal");
		$this->db->join("banksoal_unit", "banksoal_id = banksoal_unit_banksoal");
		$this->db->join("banksoal_question", "banksoal_question_banksoal = banksoal_unit_id");

		$q = $this->db->get("training");
//print_r($this->db->queries[count($this->db->queries)-1]);exit;
		$rowspacket = $q->result();

		$this->db->where("training_id", $id);
		$this->db->where("training_type", 2);
		$this->db->where("(banksoal_question_jabatan = ".$sess['user_jabatan']." OR banksoal_question_alljabatan = 1)");
		$this->db->where("banksoal_question_answer <>", 0);
		$this->db->where("banksoal_question_status", 1);
		$this->db->join("banksoal", "banksoal_id = training_banksoal");
		$this->db->join("banksoal_unit", "banksoal_id = banksoal_unit_banksoal");
		$this->db->join("banksoal_question", "banksoal_question_banksoal = banksoal_unit_id");
		$q = $this->db->get("training");

		// random soal, + acak

		$totalsoal = $q->num_rows();
		$idxsoals = array();
		for($i=0; $i < 1000; $i++)
		{
			$idxsoal = rand(0, $totalsoal-1);
			if (in_array($idxsoal, $idxsoals)) continue;

			$idxsoals[] = $idxsoal;
		}


//print_r($this->db->queries[count($this->db->queries)-1]);exit;
		if ($q->num_rows() == 0)
		{
			echo json_encode(array("err"=>5, "url"=>site_url(array("generalsetting", "errmessage", "lnot_enough_soal"))));
			return;
		}

		$rowtraining = $q->row();
		//$rowsoal = $q->result();
		$rowsoaltemp = $q->result();
		for($i=0; $i < count($idxsoals); $i++)
		{
			$rowsoal[] = $rowsoaltemp[$idxsoals[$i]];
		}

		for($i=0; $i < count($rowsoaltemp); $i++)
		{
			if (in_array($i, $idxsoals)) continue;

			$rowsoal[] = $rowsoaltemp[$i];
		}

		// pilih packet

		$jmlperpacket = array();
		for($i=0; $i < count($rowsoal); $i++)
		{
			if (! isset($jmlperpacket[$rowsoal[$i]->banksoal_question_packet])) $jmlperpacket[$rowsoal[$i]->banksoal_question_packet] = 0;
			$jmlperpacket[$rowsoal[$i]->banksoal_question_packet]++;
		}

		$packets = array_keys($jmlperpacket);

		// pilih soal by packet

		$temp = $rowsoal;

		$try = 0;
		while(1)
		{
			if ($try > 1000) break;
			$idx = rand(0, count($rowspacket)-1);

			if (isset($packets[$idx]) && isset($jmlperpacket[$packets[$idx]]) && ($jmlperpacket[$packets[$idx]] > 0)) break;
			$try++;
		}

		$rowsoal = array();
		for($i=0; $i < count($temp); $i++)
		{
			if ($temp[$i]->banksoal_question_packet != $packets[$idx]) continue;

			$rowsoal[] = $temp[$i];
		}

		// cek apakah masih ada session

		$this->db->where("history_exam_training", $rowtraining->training_id);
		$this->db->where("history_exam_date", 0);
		$this->db->where("history_exam_time", 0);
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("training_type", 2);
		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();

		if ($q->num_rows() > 0)
		{
			$rowexam = $q->row();

			$t = dbintmaketime($rowexam->history_exam_startdate, $rowexam->history_exam_starttime);
			$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date('Y'));
			$len = $now-$t;

			if ($len < $rowtraining->training_duration)
			{
				if ($show)
				{
					$this->showexam($rowtraining->training_id);
					return;
				}

				echo json_encode(array("err"=>0));
				return;
			}

			// session habis

			unset($update);

			$update['history_exam_date'] = date("Ymd", $t+$rowtraining->training_duration);
			$update['history_exam_time'] = date("Gis", $t+$rowtraining->training_duration);

			$this->db->where("history_exam_training", $rowtraining->training_id);
			$this->db->where("history_exam_date", 0);
			$this->db->where("history_exam_time", 0);
			$this->db->where("history_exam_user", $sess['user_id']);
			$this->db->update("history_exam", $update);

			$this->session->unset_userdata("lmsv2_certificate_index");
			$this->session->unset_userdata("over_question");

			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] session habis"."\r\n",'a' );

			echo json_encode(array("err"=>6, "url"=>site_url(array("certificate", "score", $id))));
			return;
		}

		$this->session->unset_userdata("lmsv2_certificate_index");
		$this->session->unset_userdata("over_question");

		if ($this->trainingmodel->IsCertificateTakeMaximum($sess, $id))
		{
			echo json_encode(array("err"=>6, "url"=>site_url(array("certificate", "errmaxexam", $id, 3))));
			return;
		}

		$unitids = array(0);
		for($i=0; $i < count($rowsoal); $i++)
		{
			$unitids[] = $rowsoal[$i]->banksoal_unit_id;
		}

		$settings = $this->trainingmodel->GetUnitSetting($unitids, $rowtraining->training_id);

		for($i=0; $i < count($rowsoal); $i++)
		{
			if (! isset($settings[$rowsoal[$i]->banksoal_unit_id]))
			{
				$jmlperunit[$rowsoal[$i]->banksoal_unit_id] = array($rowtraining->training_setting_jmlsoal, $rowtraining->training_setting_bobotmudah, $rowtraining->training_setting_bobotsedang, $rowtraining->training_setting_bobotsulit);
			}
			else
			{
				$jml = $settings[$rowsoal[$i]->banksoal_unit_id]->banksoal_unit_setting_jmlsoal;
				$mudah = $settings[$rowsoal[$i]->banksoal_unit_id]->banksoal_unit_setting_mudah;
				$sedang = $settings[$rowsoal[$i]->banksoal_unit_id]->banksoal_unit_setting_sedang;
				$sulit = $settings[$rowsoal[$i]->banksoal_unit_id]->banksoal_unit_setting_sulit;

				$jmlperunit[$rowsoal[$i]->banksoal_unit_id] = array($jml, $mudah, $sedang, $sulit);
			}
		}

		// jumlah soal per jabatan

		$this->db->where("banksoal_jabatan_jabatan", $sess['user_jabatan']);
		$this->db->where("banksoal_jabatan_training", $id);
		$q = $this->db->get("banksoal_jabatan");
		$this->db->flush_cache();
		$rowjabatan = $q->result();

		for($i=0; $i < count($rowjabatan); $i++)
		{
			$jmlperunit[$rowjabatan[$i]->banksoal_jabatan_unit] = array($rowjabatan[$i]->banksoal_jabatan_jmlsoal, $rowjabatan[$i]->banksoal_jabatan_bobotmudah, $rowjabatan[$i]->banksoal_jabatan_bobotsedang, $rowjabatan[$i]->banksoal_jabatan_bobotsulit);
		}

		// pilih soal secara acak

		if (! isset($jmlperunit))
		{
			echo json_encode(array("err"=>7, "url"=>base_url()));
			return;
		}

		// jumlah soal per unit

		for($i=0; $i < count($rowsoal); $i++)
		{
			$soals[$rowsoal[$i]->banksoal_question_banksoal][] = $rowsoal[$i];
		}

		$found = false;
		foreach($jmlperunit as $key=>$val)
		{
			if (! isset($soals[$key])) continue;

			$soalpilihan[$key] = $this->trainingmodel->acak($val, $soals[$key]);
			if (count($soalpilihan[$key]) > 0)
			{
				$found = true;
			}
		}

		if (! $found)
		{
			echo json_encode(array("err"=>5, "url"=>site_url(array("generalsetting", "errmessage", "lnot_enough_soal"))));
			return;
		}

		$max = $this->trainingmodel->GetCertificateNo(3, $sess['user_id'], $id, date("Ymd"));

		// simpan session ke db

		// cek apakah all period ato bukan

		$this->db->where("training_time_training", $id);
		$isallperiod = $this->db->count_all_results("training_time") == 0;
		$this->db->flush_cache();

		// ambil data terakhir ngambil

		$this->db->order_by("history_exam_date", "ASC");
		$this->db->order_by("history_exam_time", "ASC");
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("history_exam_training", $id);
		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam", 1);
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			// belum pernah ngambil
			$vrefreshment = 0;
		}
		else
		{
			$row1sttake = $q->row();

			if ($row1sttake->history_exam_refreshment == 1)
			{
				// sebelumnyanya refreshment, pastinya setelahnya refreshment juga
				$vrefreshment = 1;
			}
			else
			if ($row1sttake->training_refreshment == 0)
			{
				// jika training tidak punya refrehment
				$vrefreshment = 0;
			}
			else
			{
				// penanganan untuk pertama kali ngambil dan ke dua

				$t1sttake = dbintmaketime($row1sttake->history_exam_date, $row1sttake->history_exam_time);
				$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));

				if ($isallperiod)
				{
					// untuk all perido, refreshment jika sekarang > pertama ngambil + periode refreshment

					$nextmonth = mktime(date("G", $t1sttake), date("i", $t1sttake), date("s", $t1sttake), date("n", $t1sttake)+$row1sttake->training_refreshment, date("j", $t1sttake), date("Y", $t1sttake));
					$vrefreshment = ($now >= $nextmonth) ? 1 : 0;
				}
				else
				{
					// cari periodenya

					$this->db->where("training_time_training", $id);
					$this->db->where("training_time_date1 <=", date("Ymd", $t1sttake));
					$this->db->where("training_time_date2 >=", date("Ymd", $t1sttake));
					$q = $this->db->get("training_time");

					if ($q->num_rows() == 0)
					{
						// ini tidak mungkin, handle jika data corrupt
						$vrefreshment = 0;
					}
					else
					{
						$rowtrainingperiod = $q->row();

						$tperiod1 = dbintmaketime($rowtrainingperiod->training_time_date1, $rowtrainingperiod->training_time_date1);
						$tperiod2 = dbintmaketime($rowtrainingperiod->training_time_date2, $rowtrainingperiod->training_time_date2);

						// jika sekarang > periode pertama kali dia ngambil
						$vrefreshment = ($now > $tperiod2) ? 1 : 0;
					}
				}
			}
		}

		unset($data);

		$data['history_exam_training'] = $id;
		$data['history_exam_date'] = 0;
		$data['history_exam_time'] = 0;
		$data['history_exam_score'] = 0;
		$data['history_exam_user'] = $sess['user_id'];
		$data['history_exam_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['history_exam_status'] = 0;
		$data['history_exam_minscore'] = $rowtraining->training_pass;
		$data['history_exam_type'] = 3;
		$data['history_exam_startdate'] = date("Ymd");
		$data['history_exam_starttime'] = date("Gis");
		$data['history_exam_no'] = $max;
		$data['history_exam_refreshment'] = $vrefreshment;

		$this->db->insert("history_exam", $data);
		$lastid = $this->db->insert_id();

		$this->session->set_userdata("lastid_exam", $lastid);

		if (isset($soalpilihan))
		{
			$i = 0;
			foreach($soalpilihan as $key=>$val)
			{
				foreach($val as $no)
				{
					unset($data);

					$data['history_answer_question'] = $soals[$key][$no]->banksoal_question_id;
					$data['history_answer_history_exam'] = $lastid;
					$data['history_answer_answer'] = -1;
					$data['history_answer_order'] = ++$i;

					$this->db->insert("history_answer", $data);
				}
			}
		}

		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] certificate end "."\r\n",'a' );

		echo json_encode(array("err"=>0));

	}

	function type()
	{
		return 2;
	}

	function pageid()
	{
		return "certificate";
	}

	function setting()
	{
		$topicid = $this->uri->segment(3);
		$trainingid = $this->uri->segment(4);

		if ($trainingid)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");
			$row = $q->row();

			$mycategory = $this->topicmodel->getCategory($row->training_topic);

			$this->mysmarty->assign("category_name", $mycategory->category_name);
			$this->mysmarty->assign("topicid", $row->training_topic);
			$this->mysmarty->assign("training_name", $row->training_name);

			$topicid = $row->training_topic;
			$def = $mycategory->category_id;
		}
		else
		if ($topicid)
		{
			$mycategory = $this->topicmodel->getCategory($topicid);
			$def = $mycategory->category_id;

			$this->mysmarty->assign("category_name", $mycategory->category_name);
		}
		else
		{
			$def = 0;
		}

		$this->checkadmin();

		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);

		$this->mysmarty->assign("trainingid", $trainingid);

		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topicid", $topicid);
		$this->mysmarty->assign("setting", 1);
		$this->mysmarty->assign("ledit_header", $this->config->item("lupdate_setting"));
		$this->mysmarty->assign("ltraining_name", $this->config->item("training_name"));
		$this->mysmarty->assign("lcertificate_name", $this->config->item("certificate_name"));
		$this->mysmarty->assign("url", site_url(array("certificate", "getsetting")));
		$this->mysmarty->assign("pageid", $this->pageid());

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "training/edit.html");
		$this->mysmarty->display("sess_template.html");
	}


	function getsetting()
	{
		if(!empty($_POST['_topic'])) {
			$_POST['topic'] = $_POST['_topic'];
		}

		if(!empty($_POST['_name'])) {
			$_POST['name'] = $_POST['_name'];
		}

		if (isset($_POST['name']))
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['topic']))
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$errs = array();
		if (! $topic)
		{
			$errs[] = $this->config->item("err_topic_name");
		}
		if (! $name)
		{
			$errs[] = $this->config->item("lerr_empty_certificate");
		}

		if (count($errs) == 0)
		{

			$this->db->where("training_name", $name);
			$this->db->where("training_topic", $topic);

			$this->db->join("banksoal",  "banksoal_id = training_banksoal", "left outer");
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_certificate_name");
			}
			else
			{
				$rowtraining = $q->row();

				$rowtraining->training_duration_hour = floor($rowtraining->training_duration/3600);
				$rowtraining->training_duration_minute = floor(($rowtraining->training_duration%3600)/60);

				$this->mysmarty->assign("training", $rowtraining);
			}
		}

		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		//theme
		//$defaultintro = $this->mysmarty->fetch("certificate/cert.rule.layout.html");
		$base_path = $this->config->item('base_path');
		$theme = $this->config->item('theme');
		$theme_cert_rule = sprintf("%s/theme/%s/views/certificate/cert.rule.layout.html", $base_path, $theme);

		if(file_exists($theme_cert_rule))
			$files = file($theme_cert_rule);
		else
			$files = file(BASEPATH . "application/views/certificate/cert.rule.layout.html");

		$defaultintro = implode(" ", $files);

		$this->mysmarty->assign("defaultintro", htmlspecialchars($defaultintro, ENT_QUOTES));
		$this->mysmarty->assign("lduration", $this->config->item("lduration"));
		$this->mysmarty->assign("lhour", $this->config->item("lhour"));
		$this->mysmarty->assign("lminute", $this->config->item("lminute"));
		$this->mysmarty->assign("lduration_per_soal", $this->config->item("lduration_per_soal"));
		$this->mysmarty->assign("lsecond", $this->config->item("lsecond"));
		$this->mysmarty->assign("ltraining_pass", $this->config->item("ltraining_pass"));
		$this->mysmarty->assign("lbank_soal", $this->config->item("lbank_soal"));
		$this->mysmarty->assign("ok_update_setting", $this->config->item("ok_update_setting"));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));
		$this->mysmarty->assign("lunit_soal", $this->config->item("lunit_soal"));
		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));
		$this->mysmarty->assign("lmudah", $this->config->item("lmudah"));
		$this->mysmarty->assign("lsedang", $this->config->item("lsedang"));
		$this->mysmarty->assign("lsulit", $this->config->item("lsulit"));
		$this->mysmarty->assign("ldefault_setting", $this->config->item("ldefault_setting"));
		$this->mysmarty->assign("lok_update_defsetting", $this->config->item("lok_update_defsetting"));
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("ltraining_max", $this->config->item("ltraining_max"));
		$this->mysmarty->assign("lexam_rule", $this->config->item("lexam_rule"));
		$this->mysmarty->assign("lunlimit", $this->config->item("lunlimit"));

		$this->mysmarty->display("training/setting.html");
	}

	function savesetting()
	{
		//print_r($_POST);
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if(!empty($_POST['_topic'])) {
			$_POST['topic'] = $_POST['_topic'];
		}

		if(!empty($_POST['_name'])) {
			$_POST['name'] = $_POST['_name'];
		}

		if (isset($_POST['name']))
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}
		else
		{
			$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		}

		if (isset($_POST['topic']))
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}
		else
		{
			$topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		}

		$nosoal = isset($_POST['nosoal']) ? trim($_POST['nosoal']) : "";
		$dhour = isset($_POST['dhour']) ? trim($_POST['dhour']) : "";
		$dminute = isset($_POST['dminute']) ? trim($_POST['dminute']) : "";
		$dpersoal = isset($_POST['dpersoal']) ? trim($_POST['dpersoal']) : "";
		$pass = isset($_POST['pass']) ? trim($_POST['pass']) : "";
		$certificatemax = isset($_POST['certificatemax']) ? trim($_POST['certificatemax']) : "";
		$bank_soal = isset($_POST['bank_soal']) ? trim($_POST['bank_soal']) : "";
		$_rule = isset($_POST['_rule']) ? trim($_POST['_rule']) : "";

		$jmlsoal = isset($_POST['jmlsoal']) ? trim($_POST['jmlsoal']) : "";
		$bobotmudah = isset($_POST['bobotmudah']) ? trim($_POST['bobotmudah']) : "";
		$bobotsedang = isset($_POST['bobotsedang']) ? trim($_POST['bobotsedang']) : "";
		$bobotsulit = isset($_POST['bobotsulit']) ? trim($_POST['bobotsulit']) : "";

		$errs = array();

		$isvalidnosoal = true;
		if (! $nosoal)
		{
			$errs[] = $this->config->item("lerr_empty_jmsoal");
			$isvalidnosoal = false;
		}
		else
		if (! is_numeric($nosoal))
		{
			$errs[] = $this->config->item("lerr_invalid_jmsoal");
			$isvalidnosoal = false;
		}

		$isvaliddsoal = true;
		if ((! $dhour) && (! $dminute))
		{
			$isvaliddsoal = false;
			$errs[] = $this->config->item("lerr_empty_duration");
		}
		else
		{
			if ($dhour && (! is_numeric($dhour)))
			{
				$isvaliddsoal = false;
				$errs[] = $this->config->item("linvalid_duration");
			}

			if ($dminute && (! is_numeric($dminute)))
			{
				$isvaliddsoal = false;
				$errs[] = $this->config->item("linvalid_duration");
			}
		}

		$isvaliddpersoal = true;
		if (! $dpersoal)
		{
			$isvaliddpersoal = false;
			$errs[] = $this->config->item("lerr_empty_durationperquest");
		}
		else
		if (! is_numeric($dpersoal))
		{
			$isvaliddpersoal = false;
			$errs[] = $this->config->item("lerr_invalid_durationperquest");
		}

		if ($isvalidnosoal && $isvaliddsoal && $isvaliddpersoal)
		{
			$dhour = ($dhour) ? $dhour : 0;
			$dminute = ($dminute) ? $dminute : 0;

			if (($dpersoal*$nosoal) > ($dhour*3600+$dminute*60))
			{
				$errs[] = $this->config->item("lerr_invalid_duration");
			}
		}

		if (! $pass)
		{
			$errs[] = $this->config->item("lerr_empty_minpass");
		}
		else
		if (! is_numeric($pass))
		{
			$errs[] = $this->config->item("lerr_invalid_minpass");
		}

		if ($certificatemax && (! is_numeric($certificatemax)))
		{
			$errs[] = $this->config->item("err_invalid_max");
		}

		if (! $jmlsoal)
		{
			$errs[] = $this->config->item("lerr_empty_jmsoal_defsetting");
		}
		else
		if (! is_numeric($jmlsoal))
		{
			$errs[] = $this->config->item("lerr_invalid_jmsoal_defsetting");
		}

		$isvalidbobotmudah = true;
		/*
		if (! $bobotmudah)
		{
			$isvalidbobotmudah = false;
			$errs[] = $this->config->item("lerr_empty_bobotmudah_defsetting");
		}
		else
		*/
		if (! is_numeric($bobotmudah))
		{
			$isvalidbobotmudah = false;
			$errs[] = $this->config->item("lerr_invalid_bobotmudah_defsetting");
		}

		$isvalidbobotsedang = true;
		/*
		if (! $bobotsedang)
		{
			$isvalidbobotsedang = false;
			$errs[] = $this->config->item("lerr_empty_bobotsedang_defsetting");
		}
		else
		*/
		if (! is_numeric($bobotsedang))
		{
			$isvalidbobotsedang = false;
			$errs[] = $this->config->item("lerr_invalid_bobotsedang_defsetting");
		}

		$isvalidbobotsulit = true;
		/*
		if (! $bobotsulit)
		{
			$isvalidbobotsulit = false;
			$errs[] = $this->config->item("lerr_empty_bobotsulit_defsetting");
		}
		else
		*/
		if (! is_numeric($bobotsulit))
		{
			$isvalidbobotsulit = false;
			$errs[] = $this->config->item("lerr_invalid_bobotsulit_defsetting");
		}


		if ($isvalidbobotsulit && $isvalidbobotsedang && $isvalidbobotmudah)
		{
			$totbobot = $bobotmudah + $bobotsedang + $bobotsulit;
			if ($totbobot != 100)
			{
				$errs[] = $this->config->item("lerr_invalid_total_bobot");
			}
		}

		if (! $bank_soal)
		{
			$errs[] = $this->config->item("err_emtpy_banksoal");
		}
		else
		{
			$this->db->where('banksoal_type', 2);
			$this->db->where("banksoal_name", $bank_soal);
			$q = $this->db->get("banksoal");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_banksoal");
			}
			else
			{
				$rowsetting = $q->row();

				// cek jumlah total soal pada bank soal

				$this->db->where("banksoal_type", 2);
				$this->db->where("banksoal_id", $rowsetting->banksoal_id);
				$this->db->join("banksoal_unit", "banksoal_question_banksoal = banksoal_unit_id");
				$this->db->join("banksoal", "banksoal_id = banksoal_unit_banksoal");
				$total = $this->db->count_all_results("banksoal_question");
				$this->db->flush_cache();

				if ($total < $nosoal)
				{
					$errs[] = $this->config->item("lerr_jml_soal");
				}
			}
		}

		// cek jumlah soal

		if (count($errs) == 0)
		{
			$this->db->where("training_topic", $topic);
			$this->db->where("training_name", $name);
			$this->db->where("training_type", 2);
			$this->db->flush_cache();

			$q = $this->db->get("training");
			$rowtraining = $q->row();

			$this->db->distinct();
			$this->db->select("banksoal_question_jabatan, banksoal_question_banksoal");
			//$this->db->where("banksoal_unit_banksoal = ".$rowsetting->banksoal_id." OR banksoal_question_alljabatan = 1");
			//$this->db->where("banksoal_unit_banksoal = ".$rowsetting->banksoal_id);
			$this->db->where("banksoal_question_packet IS NOT NULL");
			$this->db->join("banksoal_unit", "banksoal_question_banksoal = banksoal_unit_id AND banksoal_unit_banksoal = ".$rowsetting->banksoal_id);
			$q = $this->db->get("banksoal_question");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("lerr_empty_jmsoal");
			}
			else
			{
				// setting jumlah soal pada training

				$rows = $q->result();
				for($i=0; $i < count($rows); $i++)
				{
					$unitids[] = $rows[$i]->banksoal_question_banksoal;
					$jmlsoalsetting[$rows[$i]->banksoal_question_jabatan][$rows[$i]->banksoal_question_banksoal] = $jmlsoal;
				}

				$unitids = array_unique($unitids);
				// setting jumlah soal pada unit

				$this->db->where_in("banksoal_unit_setting_unit", $unitids);
				$this->db->where_in("banksoal_unit_setting_training", $rowtraining->training_id);
				$q = $this->db->get("banksoal_unit_setting");
				$this->db->flush_cache();

				$rows = $q->result();
				for($i=0; $i < count($rows); $i++)
				{
					$jmlsoalunitsetting[$rows[$i]->banksoal_unit_setting_unit] = $rows[$i]->banksoal_unit_setting_jmlsoal;
				}

				foreach($jmlsoalsetting as $jabatan=>$val)
				{
					foreach($val as $unit=>$val1)
					{
						if (! isset($jmlsoalunitsetting[$unit])) continue;

						$jmlsoalsetting[$jabatan][$unit] = $jmlsoalunitsetting[$unit];
					}
				}

				// setting pada jabatan

				$this->db->where_in("banksoal_jabatan_unit", $unitids);
				$this->db->where("banksoal_jabatan_training", $rowtraining->training_id);
				$q = $this->db->get("banksoal_jabatan");
				$this->db->flush_cache();

				$rows = $q->result();
				for($i=0; $i < count($rows); $i++)
				{
					$jmlsoalsetting[$rows[$i]->banksoal_jabatan_jabatan][$rows[$i]->banksoal_jabatan_unit] = $rows[$i]->banksoal_jabatan_jmlsoal;
				}


				$alljabatan = 0;
				if (isset($jmlsoalsetting[0]))
				{
					foreach($jmlsoalsetting[0] as $key=>$val)
					{
						$alljabatan += $val;
						$unitalljabatan[$key] = 1;
					}
				}

				// cek jumlah

				$this->db->where("training_jabatan_training", $rowtraining->training_id);
				$this->db->join("jabatan", "jabatan_id = training_jabatan_jabatan");
				$q = $this->db->get("training_jabatan");
				$this->db->flush_cache();

				$rowjabatans = $q->result();
				for($i=0; $i < count($rowjabatans); $i++)
				{
					$jabatanid = (isset($jmlsoalsetting[$rowjabatans[$i]->jabatan_id])) ? $rowjabatans[$i]->jabatan_id : 0;

					if (! isset($jmlsoalsetting[$jabatanid])) continue;

					$totjml = 0;
					foreach ($jmlsoalsetting[$jabatanid] as $key=>$val)
					{
						$totjml += $val;
					}

					// sementara dilepas, if ($totjml != $nosoal)
					if (false)
					{
						$errs[] = $this->config->item("lerr_jml_soal");
						break;
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

		$_topic = isset($_POST['topic']) ? trim($_POST['topic']) : "";
		$_name = isset($_POST['name']) ? trim($_POST['name']) : "";

		unset($data);

		$data['training_total_question'] = $nosoal;
		$data['training_duration'] = $dhour*3600+$dminute*60;
		$data['training_durationperquestion'] = $dpersoal;
		$data['training_pass'] = $pass;
		$data['training_max'] = $certificatemax;
		$data['training_setting_jmlsoal'] = $jmlsoal;
		$data['training_setting_bobotmudah'] = $bobotmudah;
		$data['training_setting_bobotsedang'] = $bobotsedang;
		$data['training_setting_bobotsulit'] = $bobotsulit;
		$data['training_durationperquestion'] = $dpersoal;

		$data['training_banksoal'] = $rowsetting->banksoal_id;
		$data['training_intro'] = $_rule;
		$data['training_modified'] = date("Y-m-d H:i:s");
		$data['training_modifier'] = isset($this->sess['user_id']) ? $this->sess['user_id'] : 0;

		$this->db->where("training_topic", $_topic);
		$this->db->where("training_name", $_name);
		$this->db->where("training_type", 2);
		$this->db->update("training", $data);
	}

	function loadunitsoal()
	{
		if (! $_POST['banksoal'])
		{
			return;
		}

		$this->db->where("banksoal_name", $_POST['banksoal']);
		$this->db->where("banksoal_type", 2);
		$q = $this->db->get("banksoal");
		$this->db->flush_cache();

		if ($q->num_rows() == 0 )
		{
			echo $this->config->item("err_exipred_session");
			exit;
		}

		$rowbanksoal = $q->row();

		$this->db->where("banksoal_unit_banksoal", $rowbanksoal->banksoal_id);
		$q = $this->db->get("banksoal_unit");
		$this->db->flush_cache();

		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			$unitsoal[] = $rows[$i]->banksoal_unit_id;
		}

		if (isset($unitsoal))
		{

			$this->db->where_in("banksoal_question_banksoal", $unitsoal);

			$this->db->join("jabatan", "jabatan_id = banksoal_question_jabatan");
			$q = $this->db->get("banksoal_question");

			$rowjabatan = $q->result();

			unset($jabatans);
			for($i=0; $i < count($rowjabatan); $i++)
			{
				$unitsoaljabatans[$rowjabatan[$i]->jabatan_id][] = $rowjabatan[$i];
				$jabatans[$rowjabatan[$i]->jabatan_id] = $rowjabatan[$i];
			}

			for($i=0; $i < count($rows); $i++)
			{
				if (! isset($jabatans)) continue;
				$rows[$i]->jabatans = $jabatans;
			}
		}

		$this->mysmarty->assign("list", $rows);

		$this->mysmarty->assign("lpercent_bobot", $this->config->item("lpercent_bobot"));
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("lunit_soal_name", $this->config->item("lunit_soal_name"));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));

		$this->mysmarty->assign("lmudah", $this->config->item("lmudah"));
		$this->mysmarty->assign("lsedang", $this->config->item("lsedang"));
		$this->mysmarty->assign("lsulit", $this->config->item("lsulit"));
		$this->mysmarty->assign("ldefault_setting", $this->config->item("ldefault_setting"));
		$this->mysmarty->assign("ljabatan_setting", $this->config->item("ljabatan_setting"));

		$this->mysmarty->display("certificate/list.html");
	}

	function savedefsetting()
	{
		$unitid = isset($_POST['unitid']) ? trim($_POST['unitid']) : "";
		$jmlsoal = isset($_POST['jmlsoal']) ? trim($_POST['jmlsoal']) : "";
		$mudah = isset($_POST['jmlsoal']) ? trim($_POST['mudah']) : "";
		$sedang = isset($_POST['jmlsoal']) ? trim($_POST['sedang']) : "";
		$sulit = isset($_POST['jmlsoal']) ? trim($_POST['sulit']) : "";
		$jabatan = isset($_POST['jabatan']) ? trim($_POST['jabatan']) : "";
		$trainingid = isset($_POST['trainingid']) ? trim($_POST['trainingid']) : "";

		$errs = array();

		if ((! $unitid) || (! $trainingid))
		{
			$errs[] = $this->config->item("err_exipred_session");
		}

		if (! $jmlsoal)
		{
			$errs[] = $this->config->item("lerr_empty_jmsoal");
		}
		else
		if (! is_numeric($jmlsoal))
		{
			$errs[] = $this->config->item("lerr_invalid_jmsoal");
		}

		/*
		if (! $mudah)
		{
			$errs[] = $this->config->item("lempty_bobot_mudah");
		}
		else
		*/
		if (! is_numeric($mudah))
		{
			$errs[] = $this->config->item("linvalid_bobot_mudah");
		}

		/*
		if (! $sedang)
		{
			$errs[] = $this->config->item("lempty_bobot_sedang");
		}
		else
		*/
		if (! is_numeric($sedang))
		{
			$errs[] = $this->config->item("linvalid_bobot_sedang");
		}

		/*
		if (! $sulit)
		{
			$errs[] = $this->config->item("lempty_bobot_sulit");
		}
		else
		*/
		if (! is_numeric($sulit))
		{
			$errs[] = $this->config->item("linvalid_bobot_sulit");
		}

		if (count($errs) == 0)
		{
			$tot = $mudah + $sedang + $sulit;
			if ($tot != 100)
			{
				$errs[] = $this->config->item("linvalid_bobot_percent");
			}
		}

		// cek jumlah soal

		$this->db->where("banksoal_question_banksoal", $unitid);
		$this->db->distinct();
		$this->db->select("banksoal_question_alljabatan");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		$rowalljabatan = $q->row();
		$isalljabatan = $rowalljabatan->banksoal_question_alljabatan == 1;

		if ($jabatan)
		{
			if ($isalljabatan)
			{
				$this->db->where("banksoal_question_banksoal", $unitid);
				$this->db->where("banksoal_question_alljabatan", 1);
			}
			else
			{
				$this->db->where("banksoal_question_banksoal", $unitid);
				$this->db->where("banksoal_question_banksoal", $unitid);
			}
		}
		else
		{
			$this->db->where("banksoal_question_banksoal", $unitid);
		}

		$total = $this->db->count_all_results("banksoal_question");
		$this->db->flush_cache();

		if ($total < $jmlsoal)
		{
			$errs[] = $this->config->item("lerr_invalid_jmsoal");
		}

		echo count($errs);
		echo "\1";
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");

			return;
		}

		if ($jabatan)
		{
			// remove old setting

			$this->db->where("jabatan_name", $jabatan);
			$q = $this->db->get("jabatan");

			$rowsjabatan = $q->result();
			for($i=0; $i < count($rowsjabatan); $i++)
			{
				$this->db->where("banksoal_jabatan_unit", $unitid);
				$this->db->where("banksoal_jabatan_jabatan", $rowsjabatan[$i]->jabatan_id);
				$this->db->delete("banksoal_jabatan");
				$this->db->flush_cache();

				unset($data);

				$data['banksoal_jabatan_training'] = $trainingid;
				$data['banksoal_jabatan_unit'] = $unitid;
				$data['banksoal_jabatan_jabatan'] = $rowsjabatan[$i]->jabatan_id;
				$data['banksoal_jabatan_jmlsoal'] = $jmlsoal;
				$data['banksoal_jabatan_bobotmudah'] = $mudah;
				$data['banksoal_jabatan_bobotsedang'] = $sedang;
				$data['banksoal_jabatan_bobotsulit'] = $sulit;
				$data['banksoal_jabatan_bobotsulit'] = $sulit;

				$this->db->insert("banksoal_jabatan", $data);
			}

			return;
		}

		unset($data);

		$this->db->where("banksoal_unit_setting_unit", $unitid);
		$this->db->where("banksoal_unit_setting_training", $trainingid);
		$q = $this->db->get("banksoal_unit_setting");
		$this->db->flush_cache();

		$data['banksoal_unit_setting_jmlsoal'] = $jmlsoal;
		$data['banksoal_unit_setting_mudah'] = $mudah;
		$data['banksoal_unit_setting_sedang'] = $sedang;
		$data['banksoal_unit_setting_sulit'] = $sulit;

		if ($q->num_rows() > 0)
		{
			$this->db->where("banksoal_unit_setting_unit", $unitid);
			$this->db->where("banksoal_unit_setting_training", $trainingid);
			$this->db->update("banksoal_unit_setting", $data);
		}
		else
		{
			$data['banksoal_unit_setting_unit'] = $unitid;
			$data['banksoal_unit_setting_training'] = $trainingid;

			$this->db->insert("banksoal_unit_setting", $data);
		}

	}

	function jabatansetting()
	{
		// info unit

		$this->db->where("banksoal_unit_id", $_POST['unitid']);
		$q = $this->db->get("banksoal_unit");
		$rowunit  = $q->row();

		// all jabatan

		$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
		$this->db->distinct();
		$this->db->select("banksoal_question_jabatan");
		$q = $this->db->get('banksoal_question');
		$this->db->flush_cache();

		$rows = $q->result();

		// settingan per jabatan

		$this->db->where("banksoal_jabatan_unit", $_POST['unitid']);
		$q = $this->db->get("banksoal_jabatan");
		$this->db->flush_cache();

		$rowsettings = $q->result();

		for($i=0; $i < count($rowsettings); $i++)
		{
			$settings[$rowsettings[$i]->banksoal_jabatan_jabatan] = $rowsettings[$i];
		}

		// jabatan settings

		for($i=0; $i < count($rows); $i++)
		{
			if (isset($settings[$rows[$i]->banksoal_question_jabatan]))
			{
				$rows[$i]->settings = $settings[$rows[$i]->banksoal_question_jabatan];
			}
			else
			{
				$rows[$i]->settings = $rowunit;
			}

			$rows[$i]->defaultunit = ! isset($settings[$rows[$i]->banksoal_question_jabatan]);
		}

		echo json_encode($rows);
	}

	function defaultsetting()
	{
		if (isset($_POST['jabatan']) && $_POST['jabatan'])
		{
			$this->mysmarty->assign("jabatanid", $_POST['jabatan']);

			$this->db->where("jabatan_name", $_POST['jabatan']);
			$q = $this->db->get("jabatan");

			$row = $q->row();
			$_POST['jabatan'] = $row->jabatan_id;
		}

		$this->mysmarty->assign("lbobot", $this->config->item("lbobot"));
		$this->mysmarty->assign("lmudah", $this->config->item("lmudah"));
		$this->mysmarty->assign("lsedang", $this->config->item("lsedang"));
		$this->mysmarty->assign("lsulit", $this->config->item("lsulit"));
		$this->mysmarty->assign("ldefault_setting", $this->config->item("ldefault_setting"));
		$this->mysmarty->assign("lok_update_defsetting", $this->config->item("lok_update_defsetting"));
		$this->mysmarty->assign("ljabatan", $this->config->item("jabatan"));
		$this->mysmarty->assign("ljumlah_soal", $this->config->item("ljumlah_soal"));
		$this->mysmarty->assign("tipe", $_POST['tipe']);
		$this->mysmarty->assign("intrainingid", $_POST['trainingid']);

		// setting pada sertifikasi

		$this->db->where("training_id", $_POST['trainingid']);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		$row = $q->row();

		$this->mysmarty->assign("injmlsoal", $row->training_setting_jmlsoal ? $row->training_setting_jmlsoal : $_POST['defjml']);
		$this->mysmarty->assign("inmudah", $row->training_setting_bobotmudah ? $row->training_setting_bobotmudah : $_POST['defmudah']);
		$this->mysmarty->assign("insedang", $row->training_setting_bobotsedang ? $row->training_setting_bobotsedang : $_POST['defsedang']);
		$this->mysmarty->assign("insulit", $row->training_setting_bobotsulit ? $row->training_setting_bobotsulit : $_POST['defsulit']);

		// setting per sertifikasi dan unit

		$this->db->where("banksoal_unit_setting_unit", $_POST['unitid']);
		$this->db->where("banksoal_unit_setting_training", $_POST['trainingid']);
		$q = $this->db->get("banksoal_unit_setting");
		$this->db->flush_cache();

		if ($q->num_rows() > 0)
		{
			$row = $q->row();

			$this->mysmarty->assign("injmlsoal", $row->banksoal_unit_setting_jmlsoal);
			$this->mysmarty->assign("inmudah", $row->banksoal_unit_setting_mudah);
			$this->mysmarty->assign("insedang", $row->banksoal_unit_setting_sedang);
			$this->mysmarty->assign("insulit", $row->banksoal_unit_setting_sulit);
		}

		if ($_POST['tipe'] == 1)
		{
			$this->mysmarty->display("certificate/defsetting.html");
			return;
		}

		$this->db->where("banksoal_question_packet IS NOT NULL");
		$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
		$this->db->distinct();
		$this->db->select("banksoal_question_alljabatan");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		$rowalljabatan = $q->row();
		$isalljabatan = $rowalljabatan->banksoal_question_alljabatan == 1;

		if ($isalljabatan)
		{
			$this->db->distinct();
			$this->db->select("jabatan_name");
			$q = $this->db->get("jabatan");
			$this->db->flush_cache();
		}
		else
		{
			$this->db->distinct();
			$this->db->select("jabatan_name");
			$this->db->where("banksoal_question_banksoal", $_POST['unitid']);
			$this->db->join("jabatan", "jabatan_id = banksoal_question_jabatan");
			$q = $this->db->get("banksoal_question");
			$this->db->flush_cache();
		}

		$rows = $q->result();

		// lihat jumlah soal

		$this->db->where("banksoal_jabatan_training", $_POST['trainingid']);
		$this->db->where("banksoal_jabatan_unit", $_POST['unitid']);
		if ($_POST['jabatan'])
		{
			$this->db->where("banksoal_jabatan_jabatan", $_POST['jabatan']);
		}
		else
		{
			$this->db->where("banksoal_jabatan_jabatan", $rows[0]->jabatan_id);
		}

		$q = $this->db->get("banksoal_jabatan");

		if ($q->num_rows() > 0)
		{
			$row = $q->row();

			$this->mysmarty->assign("injmlsoal", $row->banksoal_jabatan_jmlsoal);
			$this->mysmarty->assign("inmudah", $row->banksoal_jabatan_bobotmudah);
			$this->mysmarty->assign("insedang", $row->banksoal_jabatan_bobotsedang);
			$this->mysmarty->assign("insulit", $row->banksoal_jabatan_bobotsulit);
		}

		$this->mysmarty->assign("rows", $rows);
		$this->mysmarty->display("certificate/defsetting.html");

	}

	function showexam($trainingid)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);
		if (! $sess)
		{
			redirect(base_url());
		}

		$tmp_showcertificationquestionall = $this->db->select('general_setting_value')->where('general_setting_code = "showcertificationquestionall"')->get('general_setting')->row_array();
		$showcertificationquestionall = !empty($tmp_showcertificationquestionall['general_setting_value']) ? $tmp_showcertificationquestionall['general_setting_value'] : 0;

		$nosoal = $this->session->userdata('lmsv2_certificate_index');

		if (strlen($nosoal) > 0)
		{
			$res = $this->certificatemodel->GetQuestion($sess, $trainingid, $nosoal);
			if (count($res) > 0)
			{
				if(!empty($showcertificationquestionall)) {
					$answer = isset($_POST['answer']) ? $_POST['answer'] : -1;
				} else {
					$answer = isset($_POST['answer']) ? $_POST['answer'] : 0;
				}

				unset($data);

				$data['history_answer_answer'] = $answer;

				$this->db->where("history_answer_id", $res[0]->history_answer_id);
				$this->db->update("history_answer", $data);
				$this->db->flush_cache();
			}

			if ($nosoal == 0)
			{
				// update lagi: baru mulai

				unset($data);

				$data['history_exam_startdate'] = date("Ymd");
				$data['history_exam_starttime'] = date("Gis");

				$this->db->where("history_exam_training", $trainingid);
				$this->db->where("history_exam_date", 0);
				$this->db->where("history_exam_time", 0);
				$this->db->where("history_exam_user", $sess['user_id']);
				$this->db->where("history_exam_type", 3);
				$this->db->update("history_exam", $data);
				$this->db->flush_cache();
			}
			//echo "stringx - $nosoal";
			$nosoal++;
		}
		else
		{
			$res = $this->certificatemodel->GetSoalInitAnswer($sess, $trainingid);
			if (count($res) == 0)
			{
				$res = $this->certificatemodel->GetSoalNoAnswer($sess, $trainingid);
				if (count($res) == 0)
				{
					$this->deleteSessionLooping($trainingid);
					redirect(site_url(array("certificate", "score", $trainingid)));
				}
				else
				{
					$this->deleteSessionLooping($trainingid);
					redirect(site_url(array("certificate", "showexamall", $trainingid)));
				}
			}
			else
			{
				if ($res[0]->history_answer_order == 1)
				{
					$nosoal = 0;
				}
				else
				{
					$nosoal = $res[0]->history_answer_order;
				}

				//echo "stringy - $nosoal";
			}
		}

		$this->session->set_userdata("lmsv2_certificate_index", $nosoal);

		if (count($res) > 0)
		{
	    		$d = $res[0]->history_exam_startdate;
	    		$t = $res[0]->history_exam_starttime;

			$starttime = dbintmaketime($d, $t);
			$nowtime = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));

			$delta = $nowtime - $starttime;
			$sisa = $res[0]->training_duration - $delta;

			$h = floor($sisa/3600);
			$d = floor(($sisa%3600)/60);
			$s = ($sisa%3600)%60;

			$this->mysmarty->assign("watch", sprintf("%02d:%02d:%02d", $h, $d, $s));
			$this->mysmarty->assign("watch_hour", $h);
			$this->mysmarty->assign("watch_minute", $d);
			$this->mysmarty->assign("watch_second", $s);
		}

		$this->mysmarty->assign("trainingid", $trainingid);
		$this->mysmarty->assign("lcertificate", $this->config->item("lcertificate"));

		if ($nosoal == 0)
		{
			$this->db->where("training_id", $trainingid);
			$q = $this->db->get("training");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$rowtraining = $q->row();
			$rowtrainingku = $q->row_array();

			$h = floor($rowtrainingku['training_duration']/3600);
			$m = floor(($rowtrainingku['training_duration']%3600)/60);
			$s = ($rowtrainingku['training_duration']%3600)%60;

			$rowtrainingku['training_duration_fmt'] = sprintf("%02d:%02d:%02d", $h, $m, $s);

			$this->db->where("user_id", $sess['user_id']);
			$this->db->join("jabatan", "jabatan_id = user_jabatan", "left outer");
			$q = $this->db->get("user");

			$rowuser = $q->row_array();

			$this->mysmarty->assign("duration", $rowtraining->training_duration);
			$this->mysmarty->assign("nlen", 0);
			$this->mysmarty->assign("mycertificate", $rowtraining);
			$this->mysmarty->assign("certificateku", $rowtrainingku);
			$this->mysmarty->assign("userku", $rowuser);
			$this->mysmarty->assign("now", date("d/m/Y"));
			$this->mysmarty->assign("buffer", $rowtraining->training_intro);

			$this->mysmarty->assign("left_content", "topic/menu.html");
			$this->mysmarty->assign("main_content", "certificate/intro.html");
			$this->mysmarty->display("sess_template.html");

			return;
		}

		//------tampilkan pertanyaan satu-satu di ujung, bila settingan true/1
		if(!empty($showcertificationquestionall)) {
			$lastid_exam = $this->session->userdata('lastid_exam');
			if(empty($lastid_exam)) {
				$tmp = $this->db->select('history_exam_id')->where('history_exam_training = "'.$trainingid.'" AND history_exam_user = "'.$sess['user_id'].'" AND history_exam_ip = "'.$_SERVER['REMOTE_ADDR'].'"')->order_by('history_exam_id', 'DESC')->get('history_exam')->row_array();
				$this->session->set_userdata("lastid_exam", $tmp['history_exam_id']);
			}
			$tmp_total_soal = $this->db->select('MAX(history_answer_order) as total_soal', false)->where('history_answer_history_exam = "'.$lastid_exam.'"')->get('history_answer')->row_array();
			if(!empty($tmp_total_soal)) {
				if($nosoal > $tmp_total_soal['total_soal']) {
					$this->session->set_userdata("over_question", 1);
				}
			}

			if($this->session->userdata('over_question')) {
				//echo "stringx";
				$row = $this->db->where('general_setting_code = "typeloopcertification"')->get('general_setting')->row_array();

				if(empty($row['general_setting_value'])) {
					$tmp = $this->db->select('history_answer_order')->where('history_answer_history_exam = "'.$lastid_exam.'" AND history_answer_answer = -1')->order_by('history_answer_order')->get('history_answer')->result_array();
				} else {
					$tmp = $this->db->select('history_answer_order')->where('history_answer_history_exam = "'.$lastid_exam.'" AND history_answer_answer != -1')->order_by('history_answer_order')->get('history_answer')->result_array();

					$cnt = count($tmp);

					$tmp = array();
					if($cnt != $tmp_total_soal['total_soal']) {
						$tmp = $this->db->select('history_answer_order')->where('history_answer_history_exam = "'.$lastid_exam.'"')->order_by('history_answer_order')->get('history_answer')->result_array();
					}
					
				}

				if(!empty($tmp)) {
					//echo "stringy";
					$cnt = count($tmp);

					$arr_data = array();
					foreach ($tmp as $key => $value) {
						$arr_data[$key] = $value['history_answer_order'];
					}

					if($nosoal > $arr_data[($cnt-1)]) {
						$nosoal = $arr_data[0];
					} else {
						$key = array_search($nosoal, $arr_data);
						if(empty($key)) {
							foreach ($arr_data as $key => $value) {
								if($value >= $nosoal) {
									$nosoal = $value;
									break;
								}
							}
						} else {
							$nosoal = $arr_data[$key];
						}
					}

					$this->session->set_userdata("lmsv2_certificate_index", $nosoal);
					//echo "stringz - $nosoal";

					$lbl = 'nomor_' . $nosoal;
					if($this->session->userdata($lbl)) {
						$this->session->set_userdata($lbl, ($this->session->userdata($lbl) + 1));

						$looping_index = $this->session->userdata($lbl);
						//echo "stringx - " . $lbl;
						//echo "stringy - " . $looping_index;
					} else {
						$this->setSessionLooping($trainingid);

						$this->session->set_userdata($lbl, ($this->session->userdata($lbl) + 1));
					}

					$this->checklooping($nosoal, $trainingid);
				} else {
					//echo "stringz";
					$nosoal = $tmp_total_soal['total_soal'] + 1;
					$this->session->set_userdata("lmsv2_certificate_index", $nosoal);
					//echo "stringA - $nosoal";
				}
			}
		}

		//echo "stringy-".$nosoal;

		$res = $this->certificatemodel->GetQuestion($sess, $trainingid, $nosoal);
		if (count($res) == 0)
		{
			// soal abis
			// jika sudah dijawab semua tentukan score
			// jika ada yang belum dijawab tampilakn semua

			$res = $this->certificatemodel->GetSoalNoAnswer($sess, $trainingid);
			if (count($res) == 0)
			{
				$this->deleteSessionLooping($trainingid);
				redirect(site_url(array("certificate", "score", $trainingid)));
			}
			else
			{
				$this->deleteSessionLooping($trainingid);
				redirect(site_url(array("certificate", "showexamall", $trainingid)));
			}
		}
		else
		{
			$row = $res[0];

	    		$d = $row->history_exam_startdate;
	    		$t = $row->history_exam_starttime;

			$starttime = dbintmaketime($d, $t);
			$nowtime = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));

			$delta = $nowtime - $starttime;
			$sisa = $row->training_duration - $delta;

			$h = floor($sisa/3600);
			$d = floor(($sisa%3600)/60);
			$s = ($sisa%3600)%60;

			$this->mysmarty->assign("watch", sprintf("%02d:%02d:%02d", $h, $d, $s));
			$this->mysmarty->assign("watch_hour", $h);
			$this->mysmarty->assign("watch_minute", $d);
			$this->mysmarty->assign("watch_second", $s);

			$this->mysmarty->assign("duration", $row->training_durationperquestion);
			$this->mysmarty->assign("certificate_name", $row->training_name);

			$t = dbintmaketime($row->history_exam_startdate, $row->history_exam_starttime);
			$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date('Y'));
			$len = $now-$t;

			if ($len > $row->training_duration)
			{
				/*
				echo "string-z";
				print_r($row);
				exit();
				*/

				$this->deleteSessionLooping($trainingid);
				redirect(site_url(array("certificate", "score", $trainingid)));
			}
		}

		$this->db->order_by("banksoal_answer_order", "asc");
		$this->db->where("banksoal_question_id", $row->history_answer_question);
		$this->db->join("banksoal_answer", "banksoal_answer_question = banksoal_question_id");
		$q = $this->db->get("banksoal_question");
		$this->db->flush_cache();

		$rowquest = $q->result();

		for($i=0; $i < count($rowquest); $i++)
		{
			$rowquest[$i]->banksoal_answer_order_str = chr($rowquest[$i]->banksoal_answer_order - 1 + ord('A'));
		}

		$this->mysmarty->assign("row", $row);
		$this->mysmarty->assign("rowxyz", $row);
		$this->mysmarty->assign("quests", $rowquest);

		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/soal.html");
		$this->mysmarty->display("sess_template.html");
	}

	function showexamall($trainingid)
	{
		$usess = $this->session->userdata('lms_sess');
		$sess = unserialize($usess);
		if (! $sess)
		{
			redirect(base_url());
		}

		$res = $this->certificatemodel->GetSoalNoAnswer($sess, $trainingid, "asc");

		$t = dbintmaketime($res[0]->history_exam_startdate, $res[0]->history_exam_starttime);
		$now = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date('Y'));
		$len = $now-$t;

		if ($len > $res[0]->training_duration)
		{
			redirect(site_url(array("certificate", "score", $trainingid)));
		}

		$delta = $res[0]->training_duration-$len;

		$h = floor($delta/3600);
		$d = floor(($delta%3600)/60);
		$s = ($delta%3600)%60;

		$this->mysmarty->assign("watch", sprintf("%02d:%02d:%02d", $h, $d, $s));
		$this->mysmarty->assign("watch_hour", $h);
		$this->mysmarty->assign("watch_minute", $d);
		$this->mysmarty->assign("watch_second", $s);

		$this->mysmarty->assign("duration", $res[0]->training_duration);
		$this->mysmarty->assign("nlen", $len);
		$this->mysmarty->assign("res", $res);

		$quests = array();
		for($i=0; $i < count($res); $i++)
		{
			$quests[$res[$i]->history_answer_question] = $res[$i];
		}

		if (count($quests))
		{
			$this->db->order_by("banksoal_answer_order", "asc");
			$this->db->where_in("banksoal_answer_question", array_keys($quests));
			$q = $this->db->get("banksoal_answer");
			$this->db->flush_cache();

			$res = $q->result();
			for($i=0; $i < count($res); $i++)
			{
				$res[$i]->banksoal_answer_order_str = chr($res[$i]->banksoal_answer_order - 1 + ord('A'));
				$choices[$res[$i]->banksoal_answer_question][] = $res[$i];
			}

			foreach($quests as $key=>$val)
			{
				if (! isset($choices[$key])) continue;

				$quests[$key]->choices = $choices[$key];
			}
		}

		$this->mysmarty->assign("quests", $quests);
		$this->mysmarty->assign("lcertificate", $this->config->item("lcertificate"));
		$this->mysmarty->assign("trainingid", $trainingid);
		$this->mysmarty->assign("lselesai", $this->config->item("lselesai"));
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "certificate/soalall.html");
		$this->mysmarty->display("sess_template.html");
	}

	function examfinished($trainingid)
	{
		foreach($_POST as $key=>$val)
		{
			$pos = strpos($key, "answer");
			if ($pos === FALSE) continue;

			$id = substr($key, strlen("answer"));

			unset($data);

			$data['history_answer_answer'] = $val;
			$this->db->where("history_answer_id", $id);
			$this->db->update("history_answer", $data);
			$this->db->flush_cache();
		}

		redirect(site_url(array("certificate", "score", $trainingid)));
	}

	function score($trainingid, $type=3, $examid=0){
		parent::score($trainingid, $type, $examid);
	}

	function resetter($id, $timeid=0, $jabatan=0, $userid=0)
	{
		if (! $id)
		{
			redirect(base_url());
		}

		if ($this->sess['user_type'])
		{
			if (! isset($this->modules['certificate']))
			{
				redirect(base_url());
			}
		}

		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		if ($timeid)
		{
			$this->db->where("training_time_id", $timeid);
			$q = $this->db->get("training_time");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$rowtime = $q->row();

			$t1 = dbintmaketime($rowtime->training_time_date1, 0);
			$t2 = dbintmaketime($rowtime->training_time_date2, 0);
		}
		if ($jabatan)
		{
			$this->db->where("user_jabatan", $jabatan);
			$q = $this->db->get("user");
			$this->db->flush_cache();

			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}

			$rowusers = $q->result();

			$users = array(0);
			for($i=0; $i < count($rowusers); $i++)
			{
				$users[] = $rowusers[$i]->user_id;
			}
		}

		unset($data);

		$data['history_exam_reset'] = 1;

		$this->db->where("history_exam_training", $id);

		if (isset($t1) && isset($t2))
		{
			$this->db->where("history_exam_startdate >=", date("Ymd", $t1));
			$this->db->where("history_exam_startdate <=", date("Ymd", $t2));
		}

		if (isset($users))
		{
			$this->db->where_in("history_exam_user", $users);
		}

		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}

		$this->db->update("history_exam", $data);
		$this->db->flush_cache();

		if ($userid)
		{
			redirect(site_url(array("certificate", "historynpk", $timeid, $jabatan, $id, "list", 1, 1, 0)));
		}
		else
		if ($jabatan)
		{
			redirect(site_url(array("certificate", "historyparticipant", $timeid)));
		}
		else
		if ($timeid)
		{
			redirect(site_url(array("certificate", "historyexam", $id)));
		}
		else
		{
			redirect(site_url(array("certificate", "showlist")));
		}
	}

	function exporthistory($type=0, $filetype="xls"){
		parent::exporthistory($type, $filetype);
	}

	private function checklooping($nosoal = 0, $trainingid = '') {
		if(empty($trainingid)) return false;

		$row = $this->db->where('general_setting_code = "totalloopcertification"')->get('general_setting')->row_array();

		if(empty($row['general_setting_value'])) {
			$this->deleteSessionLooping($trainingid);
			return false;
		}

		$lbl = 'nomor_' . $nosoal;
		$looping_index = $this->session->userdata($lbl);

		$max_looping = $row['general_setting_value'] + 1;

		if($looping_index > $max_looping) {
			$this->deleteSessionLooping($trainingid);
			redirect(site_url(array("certificate", "score", $trainingid)));
			exit();
		}
	}

	private function setSessionLooping($trainingid = '') {
		$lastid_exam = $this->session->userdata('lastid_exam');
		$tmp = $this->db->select('history_answer_order')->where('history_answer_history_exam = "'.$lastid_exam.'"')->order_by('history_answer_order')->get('history_answer')->result_array();

		foreach ($tmp as $key => $value) {
			$lbl = 'nomor_' . $value['history_answer_order'];
			$this->session->set_userdata($lbl, 1);
		}
	}

	private function deleteSessionLooping($trainingid = '') {
		$lastid_exam = $this->session->userdata('lastid_exam');
		$tmp = $this->db->select('history_answer_order')->where('history_answer_history_exam = "'.$lastid_exam.'"')->order_by('history_answer_order')->get('history_answer')->result_array();

		foreach ($tmp as $key => $value) {
			$lbl = 'nomor_' . $value['history_answer_order'];
			$this->session->unset_userdata($lbl);
		}
	}

	public function exportPersonal($trainingId, $userId) {
		$filename = date("Ymd-His")."-certificate-export-personal-".$userId.".xls";

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");

		$arrOpt = array(
			0 => 'A',
			1 => 'B',
			2 => 'C',
			3 => 'D',
			4 => 'E',
			5 => 'F',
			6 => 'G',
			7 => 'H',
			8 => 'I',
			9 => 'J',
		);

		$arrStatus = array(
			0 => 'Tidak Lulus',
			1 => 'Lulus',
		);

		$score = '';
		$status = '';
		$unitSoal = '';
		$nik = '';
		$nama = '';
		$maxJawaban = 0;
		$row_soal = array();
		$urutanJawaban = array();

		$res = $this->db
		->join('user', 'user_id = history_exam_user')
		->where('history_exam_training = "'.$trainingId.'" AND history_exam_user = "'.$userId.'"')
		->order_by('history_exam_id DESC')
		->get('history_exam')
		->row_array();

		if(!empty($res['history_exam_id'])) {
			$nik = $res['user_npk'];
			$nama = $res['user_first_name'];
			$score = $res['history_exam_score'];
			$status = $res['history_exam_status'];

			/*
			$res = $this->db
			->join('banksoal_question', 'history_answer_question = banksoal_question_id')
			->join('banksoal_answer', 'banksoal_answer_question = banksoal_question_id')
			->join('banksoal_unit', 'banksoal_question_banksoal = banksoal_unit_id')
			->join('banksoal', 'banksoal_id = banksoal_unit_banksoal')
			->where('history_answer_history_exam = "'.$res['history_exam_id'].'"')
			->order_by('history_answer_order, banksoal_answer_order')
			->get('history_answer')
			->result_array();
			*/

			$res = $this->db
			->join('banksoal_question', 'history_answer_question = banksoal_question_id')
			->join('banksoal_answer', 'banksoal_answer_question = banksoal_question_id')
			->join('banksoal', 'banksoal_id = banksoal_question_banksoal')
			->where('history_answer_history_exam = "'.$res['history_exam_id'].'"')
			->order_by('history_answer_order, banksoal_answer_order')
			->get('history_answer')
			->result_array();

			//echo $this->db->last_query();

			if(!empty($res)) {
				foreach ($res as $key => $value) {
					$row_soal[$value['history_answer_question']]['soal'] = $value['banksoal_question_quest'];
					$row_soal[$value['history_answer_question']]['paketSoal'] = $value['banksoal_question_packet'];
					$row_soal[$value['history_answer_question']]['bobotSoal'] = $value['banksoal_question_bobot'];
					$row_soal[$value['history_answer_question']]['jawaban'] = $value['history_answer_answer'];
					$row_soal[$value['history_answer_question']]['kunciJawaban'] = $value['banksoal_question_answer'];
					$row_soal[$value['history_answer_question']]['statusJawaban'] = ($value['history_answer_answer'] == $value['banksoal_question_answer'] ? 'T' : 'F');
					$row_soal[$value['history_answer_question']]['pilihanJawaban'][$value['banksoal_answer_id']] = $value['banksoal_answer_text'];
					$row_soal[$value['history_answer_question']]['urutanJawaban'][$value['banksoal_answer_id']] = $value['banksoal_answer_order'];
					//$unitSoal = $value['banksoal_unit_name'];
					$unitSoal = $value['banksoal_name'];
				}

				if(!empty($row_soal)) {
					foreach ($row_soal as $key => $value) {
						$cnt = count($value['urutanJawaban']);
						if($cnt > $maxJawaban) {
							$urutanJawaban = $value['urutanJawaban'];
							$maxJawaban = $cnt;
						}
					}
				}
			}
		}

		//print_r($row_soal); exit();

	    $this->mysmarty->assign("arrStatus", $arrStatus);
	    $this->mysmarty->assign("score", $score);
	    $this->mysmarty->assign("status", $status);
	    $this->mysmarty->assign("nik", $nik);
	    $this->mysmarty->assign("nama", $nama);
	    $this->mysmarty->assign("unitSoal", $unitSoal);
	    $this->mysmarty->assign("urutanJawaban", $urutanJawaban);
	    $this->mysmarty->assign("maxJawaban", $maxJawaban);
	    $this->mysmarty->assign("arrOpt", $arrOpt);
	    $this->mysmarty->assign("rowSoal", $row_soal);

	    $this->mysmarty->assign("main_content", "certificate/exportPersonal.html");
	    
		$this->mysmarty->display("sess_template_export.html");
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
