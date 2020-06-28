<?php
set_time_limit(0);

class Migrasi extends Controller {
	function Migrasi()
	{
		parent::Controller();	
		
		$this->load->helper("common");
	}
	
	function exam($commit=0, $type="111")
	{
		$lmsv2db = $this->load->database("default", TRUE);		
		
		// map user 
		
		echo "user lmsv2 mapping....\r\n";
		
		$lmsv2db->distinct();
		$lmsv2db->select("user_npk, user_id");		
		$q = $lmsv2db->get("user");
		$nrows = $q->num_rows();
		$rows = $q->result();
		for($i=0; $i < $nrows; $i++)
		{
			$users[$rows[$i]->user_npk] = $rows[$i]->user_id;
		}
		
		echo "done\r\n";

		// map training
		
		echo "training/sertifikasi lmsv2 mapping....\r\n";
		
		$lmsv2db->distinct();
		$lmsv2db->select("training_type,training_id, training_code, training_name");
		$q = $lmsv2db->get("training");

		$nrows = $q->num_rows();
		$rows = $q->result();
		for($i=0; $i < $nrows; $i++)
		{
			switch ($rows[$i]->training_type)
			{
				case 1:
					$trainings[$rows[$i]->training_code] = $rows[$i]->training_id;
				break;
				case 2:
					$rows[$i]->training_name = strtoupper(trim($rows[$i]->training_name));
					$certificates[$rows[$i]->training_name] = $rows[$i]->training_id;
			}			
		}
		
		echo "done\r\n";

		$root_path=$this->config->item('root_path');
		$err_filename = $root_path."/uploads/".date("Ymd_His")."_migrasi_error.log";
		
		$success_filename_exam = $root_path."/uploads/".date("Ymd_His")."_migrasi_insert_exam.sql";
		$success_filename_preexam 		= $root_path."/uploads/".date("Ymd_His")."_migrasi_preexam_insert.sql";
		$success_filename_certification = $root_path."/uploads/".date("Ymd_His")."_migrasi_certification_insert.sql";

		// lms v1, exam
		
		
		if ($type[0] == "1")
		{
			echo "migrasi exam....\r\n";	
			
			$lmsv1db = $this->load->database("lmsv1", TRUE);	
			//$lmsv1db->where("user_id",20346); // debug		
			$q = $lmsv1db->get("exam_user");		
			
			$nrows = $q->num_rows();
			$rows = $q->result();
			
			$lmsv2db = $this->load->database("default", TRUE);	
			for($i=0; $i < $nrows; $i++)
			{
				$user_id = 0;
				$rows[$i]->user_id = trim($rows[$i]->user_id);
				if (! isset($users[$rows[$i]->user_id]))
				{		
					if(is_numeric($rows[$i]->user_id)) {
						//insert into lmsv2 , if npk is not exist
						$user_id = $this->insert_user($rows[$i]->user_id);
						$users[$rows[$i]->user_id]= $user_id;
						$this->log($err_filename, '[exam_user]['.$i.']'.$rows[$i]->user_id." inserted, with id : ".$user_id);
					}
					else
					{
						$this->log($err_filename, '[exam_user]['.$i.']'.$rows[$i]->user_id." user not found");
						continue;
					}
				}
				else 
				{
					$user_id = $users[$rows[$i]->user_id];
				}
				
				if (! isset($trainings[$rows[$i]->id_training]))
				{		
					$this->log($err_filename, '[exam_user]['.$i.'] ['.$rows[$i]->user_id.']|'.$rows[$i]->id_training."| training not found");
					continue;
				}			
				
				unset($data);			
				$t = dbmaketime($rows[$i]->tgl_jawab." ".$rows[$i]->jam);
				
				$data['history_exam_training'] = $trainings[$rows[$i]->id_training];
				$data['history_exam_date'] = date("Ymd", $t);
				$data['history_exam_time'] = date("Gis", $t);
				$data['history_exam_score'] = $rows[$i]->nilai;
				//$data['history_exam_user'] = $users[$rows[$i]->user_id]->user_id;
				$data['history_exam_user'] = $user_id;
				$data['history_exam_ip'] = '';
				$data['history_exam_status'] = (strcasecmp($rows[$i]->ket_lulus, "Lulus") == 0) ? 1 : 0;; 
				$data['history_exam_minscore'] = 0;
				$data['history_exam_type'] = 2;
				$data['history_exam_startdate'] = date("Ymd", $t);
				$data['history_exam_starttime'] = date("Gis", $t);
				$data['history_exam_no'] = 0;
				$data['history_exam_reset'] = 0; 
				$data['history_exam_lokasi'] = 0;
				$data['history_exam_isexport'] = 0;
				
				if ($commit)
				{
					$lmsv2db->insert("history_exam", $data);
				}
				$sql = $lmsv2db->insert_string("history_exam", $data).";";						
				
				$this->log($success_filename_exam, $sql);
			}
		
			echo "done\r\n";
		}

		if ($type[1] == "1")
		{		
			// pre exam
	
			echo "migrasi preexam....\r\n";
			
			$lmsv1db = $this->load->database("lmsv1", TRUE);	
			$q = $lmsv1db->get("preexam_user");		
			$nrows = $q->num_rows();
			$rows = $q->result();
		
			$lmsv2db = $this->load->database("default", TRUE);	
			for($i=0; $i < $nrows; $i++)
			{
				$rows[$i]->user_id = trim($rows[$i]->user_id);
				$user_id = 0;
				if (! isset($users[$rows[$i]->user_id]))
				{		
					if(is_numeric($rows[$i]->user_id)) {
						$user_id = $this->insert_user($rows[$i]->user_id);
						$users[$rows[$i]->user_id]= $user_id;
						$this->log($err_filename, '[preexam_user]['.$i.']'.$rows[$i]->user_id." inserted, with id : ".$user_id);
					}else {
						$this->log($err_filename, '[preexam_user]['.$i.'] '.$rows[$i]->user_id." user not found");
						continue;
					}
				}else {
					$user_id = $users[$rows[$i]->user_id];
				}
				
				if (! isset($trainings[$rows[$i]->id_training]))
				{		
					$this->log($err_filename, '[preexam_user]['.$i.'] '.$rows[$i]->id_training." training not found");
					continue;
				}			
				
				unset($data);			
				
				$t = dbmaketime($rows[$i]->tgl_jawab." ".$rows[$i]->jam);			
				
				$data['history_exam_training'] = $trainings[$rows[$i]->id_training];
				$data['history_exam_date'] = date("Ymd", $t);
				$data['history_exam_time'] = date("Gis", $t);
				$data['history_exam_score'] = $rows[$i]->nilai;
				//$data['history_exam_user'] = $users[$rows[$i]->user_id]->user_id;
				$data['history_exam_user'] = $user_id;
				$data['history_exam_ip'] = '';
				$data['history_exam_status'] = (strcasecmp($rows[$i]->ket_lulus, "Lulus") == 0) ? 1 : 0;
				$data['history_exam_minscore'] = 0;
				$data['history_exam_type'] = 1;
				$data['history_exam_startdate'] = date("Ymd", $t);
				$data['history_exam_starttime'] = date("Gis", $t);
				$data['history_exam_no'] = 0;
				$data['history_exam_reset'] = 0; 
				$data['history_exam_lokasi'] = 0;
				$data['history_exam_isexport'] = 0;
				
				if ($commit)
				{
					$lmsv2db->insert("history_exam", $data);
				}
				$sql = $lmsv2db->insert_string("history_exam", $data).";";						
				
				$this->log($success_filename_preexam, $sql);
			}	
			
			echo "done\r\n";
		}

		if ($type[2] == "1")
		{
			// certificate
			
			echo "migrasi sertikasi....\r\n";		
			
			$lmsv1db = $this->load->database("lmsv1", TRUE);	
			$q = $lmsv1db->query("SELECT tbl1.cert_user as user_npk, tbl1.cert_status AS cert_status_u, tbl1.* , tbl2.* FROM sertifikasi_exam tbl1 INNER JOIN sertifikasi tbl2 ON tbl1.cert_id = tbl2.cert_id");		
			$nrows = $q->num_rows();
			$rows = $q->result();	
				
			$lmsv2db = $this->load->database("default", TRUE);	
			for($i=0; $i < $nrows; $i++)
			{
				$rows[$i]->cert_judul = strtoupper(trim($rows[$i]->cert_judul));
				$rows[$i]->user_npk = trim($rows[$i]->user_npk);
				
				$user_id=0;
				if (! isset($users[$rows[$i]->user_npk]))
				{		
					if(is_numeric($rows[$i]->user_npk)) {
						$user_id = $this->insert_user($rows[$i]->user_npk);
						$users[$rows[$i]->user_npk]= $user_id;
						$this->log($err_filename, '[sertifikasi]['.$i.']'.$rows[$i]->user_npk." inserted, with id : ".$user_id);
					}else {
						$this->log($err_filename, '[sertifikasi]['.$i.'] '.$rows[$i]->user_npk." user not found");
						continue;
					}
				}else {
					$user_id = $users[$rows[$i]->user_npk];
				}
				
				if (! isset($certificates[$rows[$i]->cert_judul]))
				{		
					$this->log($err_filename, '[sertifikasi]['.$i.'] |'.$rows[$i]->cert_judul."| sertifikasi not found");
					continue;
				}			
				
				unset($data);
				
				$t = dbmaketime($rows[$i]->cert_tgl_ujian);
				$t1 = mktime(date('G', $t), date('i', $t), date('s', $t)+$rows[$i]->cert_lama, date('n', $t), date('j', $t), date('Y', $t));
				
				$data['history_exam_training'] = $certificates[$rows[$i]->cert_judul];
				$data['history_exam_date'] = date("Ymd", $t1);
				$data['history_exam_time'] = date("Gis", $t1);
				$data['history_exam_score'] = $rows[$i]->cert_nilai;
				//$data['history_exam_user'] = $users[$rows[$i]->user_npk]->user_id;
				$data['history_exam_user'] = $user_id;
				$data['history_exam_ip'] = '';
				$data['history_exam_status'] = $rows[$i]->cert_status_u;
				$data['history_exam_minscore'] = 0;
				$data['history_exam_type'] = 3;
				$data['history_exam_startdate'] = date("Ymd", $t);
				$data['history_exam_starttime'] = date("Gis", $t);
				$data['history_exam_no'] = $rows[$i]->cert_no;
				$data['history_exam_reset'] = 0; 
				$data['history_exam_lokasi'] = 0;
				$data['history_exam_isexport'] = 0;
				
				if ($commit)
				{
					$lmsv2db->insert("history_exam", $data);
				}
				$sql = $lmsv2db->insert_string("history_exam", $data).";";						
				
				$this->log($success_filename_certification, $sql);
			}			
			
			echo "done\r\n";
		}
	}	
	
	function insert_user($user_npk){
		$lmsv2db = $this->load->database("default", TRUE);	
		$data['user_npk'] = $user_npk;
		
		//insert if not exist 
		/*$lmsv2db->where("user_npk",$user_npk);
		$q = $lmsv2db->get("user");
		$nrows = $q->num_rows();
		$rows = $q->result();

		if($nrows == 0) {*/
			$lmsv2db->insert("user", $data);
			return $lmsv2db->insert_id();
		/*}else {
			return $rows[0]->user_id;
		}*/
	}
	
	function log($filename, $line)
	{				
		$fout = fopen($filename, "a");
		if (! $fout) die ("can't create file: ".$filename);
		fwrite($fout, $line."\r\n");
		fclose($fout);
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */