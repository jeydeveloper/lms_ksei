<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class TrainingModel extends Model {
	var $id=array() ;
	
	function TrainingModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->helper("common");
		$this->load->model("levelmodel");
	}	
	
	function GetInfo($id){
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$rows = $q->row();
		
		return $rows;
	}
	
	function IsGotPrerequisite($sess, $training)
	{
		$is_ok = true;
		
		$this->db->where("training_prequisite_training", $training);
		$this->db->join("training","training_id = training_prequisite_prequisite " );
		$q = $this->db->get("training_prequisite");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0) return true;
		
		$rows = $q->result();
				
		/*
			type 0 = materi 
			type 1 = pra exam , no need to check this
			type 2 = exam 
			type 3 = certification
		*/
		for($i=0; $i < count($rows); $i++)
		{
			//online training
			if($rows[$i]->training_type == 1)
			{
				$this->db->where("training_exam_training", $rows[$i]->training_prequisite_prequisite); 
				$this->db->where("training_exam_type", 2); //exam
				$q = $this->db->get("training_exam");
				$this->db->flush_cache();
		
				//if it has no exam, just check the materi 				
				if ($q->num_rows() == 0) 
				{
			
					$this->db->where("history_exam_user", $sess['user_id']);
					$this->db->where("history_exam_training", $rows[$i]->training_prequisite_prequisite);
					$this->db->where("history_exam_type",0);
					$q = $this->db->get("history_exam");
					$this->db->flush_cache();
					if ($q->num_rows() == 0) {
						$is_ok = false;
						$this->id[] = $rows[$i]->training_prequisite_prequisite;
					}
				}
				else 
				{
					$this->db->where("history_exam_user", $sess['user_id']);
					$this->db->where("history_exam_training", $rows[$i]->training_prequisite_prequisite);
					$this->db->where("history_exam_type",2);
					$this->db->where("history_exam_status",1);
					$q = $this->db->get("history_exam");
					$this->db->flush_cache();
					if ($q->num_rows() == 0) {
						$is_ok = false;
						$this->id[] = $rows[$i]->training_prequisite_prequisite;
					}
				}
			
			}
			else
			if($rows[$i]->training_type == 2){ // certification
			
				$this->db->where("history_exam_user", $sess['user_id']);
				$this->db->where("history_exam_training", $rows[$i]->training_prequisite_prequisite);
				$this->db->where("history_exam_type",3);
				$this->db->where("history_exam_status",1);
				$q = $this->db->get("history_exam");
				$this->db->flush_cache();
				if ($q->num_rows() == 0) {
					$is_ok = false;
					$this->id[] = $rows[$i]->training_prequisite_prequisite;
				}
			
			}
		}
		return $is_ok;
	}
	
	function IsMaximumTaken($userid, $trainingid)
	{
		$this->db->where("general_setting_code", "maxtaken");
		$q = $this->db->get("general_setting");
		if ($q->num_rows() == 0) return false;
		
		$row =$q->row();
		$maxtaken = $row->general_setting_value;
		
		if ($maxtaken <= 0) return false;
		
		
		$this->db->where("training_id", $trainingid);
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			return false;
		}
		
		$rowtraining = $q->row();
		
		// get last exam
		
		switch($rowtraining->training_type)
		{
			case 1:
				$this->db->where_in("history_exam_type", array(0, 1, 2));
			break;
			case 2:
				$this->db->where_in("history_exam_type", array(3));
			break;
		}
		
		$this->db->limit(1);
		$this->db->order_by("history_exam_date", "desc");
		$this->db->order_by("history_exam_time", "desc");		
		$this->db->where("history_exam_training <>", $trainingid);
		$this->db->where("history_exam_user", $userid);
		$q = $this->db->get("history_exam");
		
		if ($q->num_rows() == 0) return false;
		
		$rowexam = $q->row();
		
		if ($trainingid == $rowexam->history_exam_training) return false;
		
		//check diff date base on maximum taken
		$diffInSeconds  = timediff($rowexam->history_exam_date,0,date("Ymd"),0);
		$diff = ($diffInSeconds/24/60/60);
		
		/*
		$t = dbintmaketime($rowexam->history_exam_date, $history_exam_time);
		
		$diff = mktime()-$t;
		$maxtakenins = $maxtaken*24*3600;
		
		return ($diff < $maxtakenins);
		*/
		
return ($diff < $maxtaken);
		
	}
	
	function IsInPeriod($sess, $training)
	{
		
		$this->db->where("training_time_training", $training);
		$tottimes = $this->db->count_all_results("training_time");
		$this->db->flush_cache();
		
		if ($tottimes == 0) return true;
		
		$now = date("Ymd");
		
		$this->db->where("training_time_training", $training);
		$this->db->where("training_time_date1 <=", $now);
		$this->db->where("training_time_date2 >=", $now);
		$total = $this->db->count_all_results("training_time");
		$this->db->flush_cache();

		return $total > 0;
	}
	
	function IsGotMateri($sess, $trainingid){
		$rs = $this->GetHistoryExamByType($sess['user_id'],$trainingid,0);
		if(count($rs) > 0 )
			return true;
		else
			return false;
		
	}
	
	function GetHistoryExamByType($user,$trainingid,$type=1){
		$this->db->where("history_exam_user", $user);
		$this->db->order_by("history_exam_startdate", "desc");
		$this->db->where("history_exam_training", $trainingid);
		$this->db->where("history_exam_type", $type);				
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{				
			return false;
		}else
			return $q->result();		
	}
	
	function IsGotPraexam($sess, $trainingid)
	{
		$this->db->where("training_exam_type", 1);
		$this->db->where("training_exam_training", $trainingid);
		$q = $this->db->get("training_exam");			
		$this->db->flush_cache();
		
		if ($q->num_rows() > 0)
		{			
			/*$this->db->where("history_exam_user", $sess['user_id']);
			$this->db->order_by("history_exam_startdate", "desc");
			$this->db->where("history_exam_training", $trainingid);
			$this->db->where("history_exam_type", 1);				
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{				
				return false;
			}*/
			
			$rs = $this->GetHistoryExamByType($sess['user_id'],$trainingid,1);
			if ($rs === FALSE) return false;
			
			return count($rs) > 0;
		}

		return true;		
	}
	
	function taketimes($sess, $trainingids, $userid=0)
	{
		$this->db->group_by(array("history_exam_type", "history_exam_training")); 
		$this->db->where_in("history_exam_training", $trainingids);
		
		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}
		else
		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}
		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);
		$this->db->select("history_exam_type, history_exam_training, count(*) total");
		$q = $this->db->get("history_exam");		
		$this->db->flush_cache();
		
		$rowhists = $q->result();		
		
		$hist = array();
		for($i=0; $i < count($rowhists); $i++)
		{
			$hist[$rowhists[$i]->history_exam_type][$rowhists[$i]->history_exam_training] = $rowhists[$i]->total;
		}		
		
		return $hist;
	}
	
	function takelast($sess, $trainingids, $userid=0)
	{
		$this->db->order_by("history_exam_date", "desc");
		$this->db->order_by("history_exam_time", "desc");
		$this->db->where_in("history_exam_training", $trainingids);
		
		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}
		else
		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}
		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);		
		$q = $this->db->get("history_exam");		
		$this->db->flush_cache();
		
		$rowhists = $q->result();		

		$hist = array();
		for($i=0; $i < count($rowhists); $i++)
		{
			if (isset($hist[$rowhists[$i]->history_exam_type][$rowhists[$i]->history_exam_training])) continue;
			
			$t = dbintmaketime($rowhists[$i]->history_exam_date, $rowhists[$i]->history_exam_time);				
			$hist[$rowhists[$i]->history_exam_type][$rowhists[$i]->history_exam_training] = array(date("d/m/Y H:i", $t), $rowhists[$i]->history_exam_score);
		}		
		
		return $hist;
	}

	function bestscore($sess, $trainingids, $userid=0)
	{
		$this->db->group_by(array("history_exam_type", "history_exam_training")); 
		$this->db->where_in("history_exam_training", $trainingids);
		
		if ((! isset($sess['asadmin'])) || $sess['user_type'])
		{
			$this->db->where("history_exam_user", $sess['user_id']);
		}
		else
		if ($userid)
		{
			$this->db->where("history_exam_user", $userid);
		}
		
		$this->db->where("history_exam_date >", 0);
		$this->db->where("history_exam_time >", 0);		
		$this->db->select("history_exam_type, history_exam_training, MAX(history_exam_score) total");
		$q = $this->db->get("history_exam");		
		$this->db->flush_cache();
		
		$rowhists = $q->result();		
		
		$hist = array();
		for($i=0; $i < count($rowhists); $i++)
		{
			$hist[$rowhists[$i]->history_exam_type][$rowhists[$i]->history_exam_training] = $rowhists[$i]->total;
		}		
		
		return $hist;
	}	
	
	function GetPrivileges($sess, $trainingids)	
	{		
		$privileges = array();
		
		// all staff 
		
		$this->db->where("training_all_staff", 1);
		if (is_array($trainingids) && count($trainingids))
		{
			$this->db->where_in("training_id", $trainingids);
		}
		$q = $this->db->get("training");
		
		$rowprivileges = $q->result();		
		for($i=0; $i < count($rowprivileges); $i++)
		{
			$privileges[$rowprivileges[$i]->training_id] = true;
			if (is_array($trainingids) && count($trainingids))
			{			
				$trainingids = array_diff($trainingids, array($rowprivileges[$i]->training_id));
			}
		}		
		
		if (is_array($trainingids))
		{					
			if (count($trainingids) == 0) return $privileges;
		}
		
		// per category jabatan
		
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		if (is_array($trainingids))
		{					
			$this->db->where_in("training_catjabatan_training", $trainingids);
		}		
		$this->db->join("training", "training_id = training_catjabatan_training");
		$this->db->join("jabatan", "jabatan_category = training_catjabatan_category");
		
		$q = $this->db->get("training_catjabatan");
		$this->db->flush_cache();
		$rowscatjabs = $q->result();
				
		for($i=0; $i < count($rowscatjabs); $i++)
		{
			$privileges[$rowscatjabs[$i]->training_catjabatan_training] = true;
			if (is_array($trainingids))
			{						
				$trainingids = array_diff($trainingids, array($rowscatjabs[$i]->training_catjabatan_training));
			}			
		}
		
		// per jabatan
		
		if (is_array($trainingids))
		{					
			if (count($trainingids) == 0) return $privileges;
		}		
		
		$this->db->where("training_jabatan_jabatan", $sess['user_jabatan']);
		if (is_array($trainingids))
		{			
			$this->db->where_in("training_jabatan_training", $trainingids);
		}
		$this->db->join("training", "training_id = training_jabatan_training");
		
		$q = $this->db->get("training_jabatan");
				
		$rowjabatan = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rowjabatan); $i++)
		{
			$privileges[$rowjabatan[$i]->training_jabatan_training] = true;
			if (is_array($trainingids))
			{						
				$trainingids = array_diff($trainingids, array($rowjabatan[$i]->training_jabatan_training));
			}
		}						
		
		if (is_array($trainingids))
		{					
			if (count($trainingids) == 0) return $privileges;
		}
		
		// per function
		
		$this->db->where("training_function_function", $sess['user_function']);
		if (is_array($trainingids))
		{					
			$this->db->where_in("training_function_training", $trainingids);
		}
		$this->db->join("training", "training_id = training_function_training");
		
		$q = $this->db->get("training_function");
		$rowfunction = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rowfunction); $i++)
		{
			$privileges[$rowfunction[$i]->training_function_training] = true;
			if (is_array($trainingids))
			{						
				$trainingids = array_diff($trainingids, array($rowfunction[$i]->training_function_training));
			}
		}						
		
		if (is_array($trainingids))
		{					
			if (count($trainingids) == 0) return $privileges;
		}
		
		// per level group		
		
		if (! $sess['user_jabatan']) return $privileges;
				
		$this->db->where("jabatan_id", $sess['user_jabatan']);
		$q = $this->db->get("jabatan");		
		$this->db->flush_cache();		
		
		if ($q->num_rows() == 0) return $privileges;
		
		$row = $q->row();
		
		$arr = array();			
		$this->levelmodel->getparentlevelgroups($row->jabatan_level_group, $arr);
		
		$arrids = array(0);
		for($i=0; $i < count($arr); $i++)
		{
			$arrids[] = $arr[$i]->level_group_id;
		}		
				
		$this->db->where_in("training_levelgroup_levelgroup", $arrids);
		if (is_array($trainingids))
		{					
			$this->db->where_in("training_levelgroup_training", $trainingids);
		}
		$this->db->join("training", "training_id = training_levelgroup_training");
		
		$q = $this->db->get("training_levelgroup");
		$rowlevelgroups = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rowlevelgroups); $i++)
		{
			$privileges[$rowlevelgroups[$i]->training_levelgroup_training] = true;
			if (is_array($trainingids))
			{						
				$trainingids = array_diff($trainingids, array($rowlevelgroups[$i]->training_levelgroup_training));
			}
		}		
		
		if (is_array($trainingids))
		{					
			if (count($trainingids) == 0) return $privileges;
		}
		
		// per npk
		
		$this->db->where("training_npk_npk", $sess['user_id']);
		if (is_array($trainingids))
		{					
			$this->db->where_in("training_npk_training", $trainingids);
		}
		$this->db->join("training", "training_id = training_npk_training");
		
		$q = $this->db->get("training_npk");
		$rownpk = $q->result();
		$this->db->flush_cache();
		
		for($i=0; $i < count($rownpk); $i++)
		{
			$privileges[$rownpk[$i]->training_npk_training] = true;
		}		
		
		return $privileges;
	}

	function acak($settings, $soals, $try=1000)
	{
		$n = $settings[0];
		$tot = count($soals);
		
		$nmudah = floor($settings[1]*$n/100);
		$nsedang = floor($settings[2]*$n/100);
		$nsulit = $n-$nmudah-$nsedang;
		
		$arr = array();
		
		if ($n > $tot) return $arr;
		
		$bobots = array("Mudah", "Sedang", "Sulit");
				
		$try = 1;
		while(1)
		{
			if ($try > 10000) break;
			if (count($arr) >= $n) return $arr;
			
			$i = rand(0, $tot-1);
			if (in_array($i, $arr))
			{							
				$try++;
				continue;
			}
			
			if (isset($soals[$i]->banksoal_question_bobot) && (strcasecmp($soals[$i]->banksoal_question_bobot, $bobots[0]) == 0))
			{
				if ($nmudah == 0)
				{
					$try++;
					continue;
				}
				$nmudah--;
			}
			else
			if (isset($soals[$i]->banksoal_question_bobot) && (strcasecmp($soals[$i]->banksoal_question_bobot, $bobots[1]) == 0))
			{
				if ($nsedang == 0)
				{
					$try++;
					continue;
				}
				$nsedang--;
			}			
			else
			{
				if ($nsulit == 0)
				{
					$try++;
					continue;
				}
				$nsulit--;
			}
			
			array_push($arr, $i);
		}
		
		if (count($arr) < $n)
		{
			for($i=0; $i < $tot; $i++)
			{
				if ($nmudah <= 0) break;								
				if (count($arr) >= $n) return $arr;		
				
				if (in_array($i, $arr)) continue;
				if (strcasecmp($soals[$i]->banksoal_question_bobot, "Mudah") != 0) continue;
				
				$nmudah--;		
				array_push($arr, $i);
			}

			for($i=0; $i < $tot; $i++)
			{
				if ($nsedang <= 0) break;								
				if (count($arr) >= $n) return $arr;		
				
				if (in_array($i, $arr)) continue;
				if (strcasecmp($soals[$i]->banksoal_question_bobot, "Sedang") != 0) continue;
				
				$nsedang--;		
				array_push($arr, $i);
			}

			for($i=0; $i < $tot; $i++)
			{
				if ($nsulit <= 0) break;								
				if (count($arr) >= $n) return $arr;		
				
				if (in_array($i, $arr)) continue;
				if (strcasecmp($soals[$i]->banksoal_question_bobot, "Sulit") != 0) continue;
				
				$nsulit--;		
				array_push($arr, $i);
			}
		}

		if (count($arr) < $n)
		{
                        for($i=0; $i < $tot; $i++)
                        {
                                if (count($arr) >= $n) return $arr;
                                if (in_array($i, $arr)) continue;

                                array_push($arr, $i);
                        }			
		}

		return $arr;
	}
	
	function GetUsed($ids)
	{
		$used = array();
		
		// apakah dipakai user
		
		$this->db->distinct();
		$this->db->select("history_exam_training");
		$this->db->where_in("history_exam_training", $ids);
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();	
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$used[$rows[$i]->history_exam_training] = true;			
		}			

		return $used;		
	}		
	
	function IsMaximum($sess, $id, $tipe)
	{
		$this->db->where("training_exam_training", $id);
		$this->db->where("training_exam_type", $tipe);		
		$q = $this->db->get("training_exam");
		$this->db->flush_cache();
		
		$rowmaxngambil = $q->row();
		
		if ($rowmaxngambil->training_exam_max == 0) return false;
		
		// cek period
		
		$this->db->where("training_time_date1 <=", date("Ymd"));
		$this->db->where("training_time_date2 >=", date("Ymd"));
		$this->db->where("training_time_training", $id);
		$q = $this->db->get("training_time");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			$this->db->where("history_exam_training", $id);
			$this->db->where("history_exam_type", $tipe);		
			$this->db->where("history_exam_user", $sess['user_id']);
			$this->db->flush_cache();
			
			$ngambil = $this->db->count_all_results("history_exam");
			
			return ($ngambil >= $rowmaxngambil->training_exam_max);
		}
		
		$rowperiod = $q->row();

		$this->db->where("history_exam_date >=", $rowperiod->training_time_date1);
		$this->db->where("history_exam_date <=", $rowperiod->training_time_date2);
		$this->db->where("history_exam_training", $id);
		$this->db->where("history_exam_type", $tipe);		
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->flush_cache();
		
		$ngambil = $this->db->count_all_results("history_exam");
		
		return ($ngambil >= $rowmaxngambil->training_exam_max);
	}
	
	function IsCertificateTakeMaximum($sess, $id)
	{
		$this->db->where("training_id", $id);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rowmaxngambil = $q->row();
		
		if ($rowmaxngambil->training_max == 0) return false;
		
		// cek period
		
		$this->db->where("training_time_date1 <=", date("Ymd"));
		$this->db->where("training_time_date2 >=", date("Ymd"));
		$this->db->where("training_time_training", $id);
		$q = $this->db->get("training_time");

		$this->db->flush_cache();

		if ($q->num_rows() == 0)
		{
			$this->db->where("history_exam_training", $id);
			$this->db->where("history_exam_type", 3);		
			$this->db->where("history_exam_user", $sess['user_id']);
			$this->db->where("history_exam_reset", 0);
			$this->db->flush_cache();
			
			$ngambil = $this->db->count_all_results("history_exam");
					
			return ($ngambil >= $rowmaxngambil->training_max);			
		}				

		$rowperiod = $q->row();

		$this->db->where("history_exam_date >=", $rowperiod->training_time_date1);
		$this->db->where("history_exam_date <=", $rowperiod->training_time_date2);
		$this->db->where("history_exam_type", 3);		
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("history_exam_reset", 0);
		$this->db->where("history_exam_training", $id);
		$ngambil = $this->db->count_all_results("history_exam");
		$this->db->flush_cache();
		return ($ngambil >= $rowmaxngambil->training_max);			
	}	
	
	function GetCertificateNo($tipe, $userid, $training, $date)
	{				
		$this->db->order_by("history_exam_date", "desc");
		$this->db->order_by("history_exam_time", "desc");
		$this->db->where("history_exam_type", $tipe);
		$this->db->where("history_exam_user", $userid);
		$this->db->where("history_exam_training", $training);
		$this->db->join("training", "training_id = history_exam_training");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			// belum pernah ngambil
			
			$this->db->where("history_exam_type", $tipe);
			$this->db->select("MAX(history_exam_no) _max");
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();		
		
			if ($q->num_rows() == 0)
			{
				return 1;
			}
				
			$rowmax = $q->row();
			return $rowmax->_max + 1;
		}
		
		// sudah pernah ngambil
				
		$rowexam = $q->row();
		
		// cek apakah all period
		
		$this->db->where("training_time_training", $training);
		$totalperiod = $this->db->count_all_results("training_time");		
		if ($totalperiod == 0)
		{
			// all period, jika tidak ada refreshment hanya 1 nomor
			
			if ($rowexam->training_refreshment == 0)
			{
				return $rowexam->history_exam_no;
			}
			
			$t = dbintmaketime($rowexam->history_exam_date, $rowexam->history_exam_time);
			$nextperiod = mktime(0, 0, 0, date('n', $t)+$rowexam->training_refreshment, date('j', $t), date('Y', $t));
			
			if ($nextperiod < mktime())
			{
				return $rowexam->history_exam_no;
			}
						
			$this->db->where("history_exam_type", $tipe);
			$this->db->select("MAX(history_exam_no) _max");
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();		
			
			if ($q->num_rows() == 0)
			{
				return 1;
			}
					
			$rowmax = $q->row();
			return $rowmax->_max + 1;			
		}
		
		// cek periode yg mana
		
		$this->db->where("training_time_training", $training);
		$this->db->where("training_time_date1 <=", $date);
		$this->db->where("training_time_date2 >=", $date);
		$q = $this->db->get("training_time");
		$this->db->flush_cache();
		
		if ($q->num_rows() == 0)
		{
			// tidak mungkin karena, all period sudah dicek di paling atas						
			return $rowexam->history_exam_no;
		}
		
		$rowtime = $q->row();
		
		if (($rowexam->history_exam_date >= $rowtime->training_time_date1) && ($rowexam->history_exam_date <= $rowtime->training_time_date2))
		{
			// sudah pernah ambil untuk periode yang sama
			
			return $rowexam->history_exam_no;
		}
		
		$this->db->where("history_exam_type", $tipe);
		$this->db->select("MAX(history_exam_no) _max");
		$q = $this->db->get("history_exam");
		$this->db->flush_cache();		
		
		if ($q->num_rows() == 0)
		{
			return 1;
		}
				
		$rowmax = $q->row();
		return $rowmax->_max + 1;
	}
	
	function GetUnitSetting($unitids, $trainingid)
	{
		$settings = array();
		
		$this->db->where_in("banksoal_unit_setting_unit", $unitids);
		$this->db->where("banksoal_unit_setting_training", $trainingid);
		$q = $this->db->get("banksoal_unit_setting");
		$this->db->flush_cache();
		
		
		$res = $q->result();
		for($i=0; $i < count($res); $i++)
		{
			$settings[$res[$i]->banksoal_unit_setting_unit] = $res[$i];
		}
		
		return $settings;
	}
	
	function GetCandidateNPK($ids)
	{
		$trainings = array();
		$userTrainings = array();
		$userArray = array();
				
		$this->db->where_in("training_id", $ids);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rowsTraining = $q->result();
		for($i=0; $i < count($rowsTraining); $i++)
		{
			if ($rowsTraining[$i]->training_all_staff)
			{	
				$this->db->where("user_status", 1);	//user active only
				$trainings[$rowsTraining[$i]->training_id] = $this->db->count_all_results("user");
				$ids = array_diff($ids, array($rowsTraining[$i]->training_id));
			}else{
				$userArray = array();
				
				//count by jabatan
				$this->db->where_in("training_jabatan_training", $rowsTraining[$i]->training_id);
				$this->db->select("training_jabatan_training, user_id");
				$this->db->join("training_jabatan", "user_jabatan = training_jabatan_jabatan");	
			//	$this->db->where_not_in('user_id', $userArray);
				$this->db->where("user_status", 1);	//user active only
				$q = $this->db->get("user");
				$this->db->flush_cache();		
		
				$rowsJabatan = $q->result();
				foreach($rowsJabatan as $value){
					$userArray[] = $value->user_id;
				}
				
				//by training function
				$this->db->group_by("training_function_training");
				$this->db->where_in("training_function_training",  $rowsTraining[$i]->training_id);
				$this->db->select("training_function_training, user_id");
				$this->db->join("training_function", "user_function = training_function_function");
				$this->db->where("user_status", 1);	//user active only		
				//$this->db->where_not_in('user_id', $userArray);
				$q = $this->db->get("user");
				$this->db->flush_cache();		
		
				$rowsFunctionTraining = $q->result();
				foreach($rowsFunctionTraining as $value){
					$userArray[] = $value->user_id;
				}
				
				// by npk
				//$this->db->group_by("training_npk_training");
				$this->db->where_in("training_npk_training",  $rowsTraining[$i]->training_id);
				$this->db->select("training_npk_training, user_id");
				$this->db->join("training_npk", "user_id = training_npk_npk");	
				$this->db->where("user_status", 1);	//user active only	
				//$this->db->where_not_in('user_id', $userArray);
				$q = $this->db->get("user");
				
				$this->db->flush_cache();		
				$rowsNPK = $q->result();
				foreach($rowsNPK as $value){
					$userArray[] = $value->user_id;
				}

				if($rowsTraining[$i]->training_id == 52){
					//echo $this->db->last_query();
					//print_r($userArray);
				}
				
				
				$userTrainings[$rowsTraining[$i]->training_id] = array_unique($userArray);
			}
		}
		
		if(count($ids)) {
			//-- get by levelgroup		
			$this->db->where_in("training_levelgroup_training", $ids);
			$q = $this->db->get("training_levelgroup");
			$rows = $q->result();
			$this->db->flush_cache();
		}

		if(!empty($rows)) {
            for($j=0; $j < count($rows); $j++)
            {
                $userArrayLevel = array();
                $allgroups[] = $rows[$j]->training_levelgroup_levelgroup;
                $this->levelmodel->getGroupChildIds($allgroups, $rows[$j]->training_levelgroup_levelgroup);
                $allgroups = array_unique($allgroups);

                $this->db->select("jabatan_level_group,user_id");
                $this->db->where_in("jabatan_level_group", $allgroups);
                $this->db->join("jabatan", "jabatan_id = user_jabatan");
                $this->db->where("user_status", 1);	//user active only

                $this->db->where_in("training_levelgroup_training", $rows[$j]->training_levelgroup_training);
                $this->db->join("training_levelgroup","training_levelgroup_levelgroup = jabatan_level_group","left outer");

                $q = $this->db->get("user");
                $this->db->flush_cache();

                $res = $q->result();
                if(count($res)){
                    foreach($res as $value){
                        $userArrayLevel[$rows[$j]->training_levelgroup_training][] = $value->user_id;
                    }

                    foreach($userArrayLevel[$rows[$j]->training_levelgroup_training] as $key => $value){
                        array_push($userTrainings[$rows[$j]->training_levelgroup_training],$value);
                    }
                }

                $this->db->flush_cache();
            }
            //print_r($userTrainings[45]);
        }
			
		for($i=0; $i < count($rowsTraining); $i++){
		    if(empty($trainings[$rowsTraining[$i]->training_id])) $trainings[$rowsTraining[$i]->training_id] = 0;
		    if(empty($userTrainings[$rowsTraining[$i]->training_id])) $userTrainings[$rowsTraining[$i]->training_id] = 0;
			$trainings[$rowsTraining[$i]->training_id] += count($userTrainings[$rowsTraining[$i]->training_id]);
		}
		
		return $trainings;
	}		
	
	function GetCandidateNPKPerjabatan($ids)
	{
		$trainings = array();
		
		$this->db->where_in("training_id", $ids);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if ($rows[$i]->training_all_staff)
			{	
				$this->db->group_by("user_jabatan");
				$this->db->select("user_jabatan, count(*) tot");			
				$q = $this->db->get("user");
				$this->db->flush_cache();
				
				$rowusers = $q->result();
				for($j=0; $j < count($rowusers); $j++)
				{
					$trainings[$rows[$i]->training_id][$rowusers[$j]->user_jabatan] = $rowusers[$j]->tot;
				}
				
				$ids = array_diff($ids, array($rows[$i]->training_id));				
			}			
		}
		
		if (count($ids) == 0) return $trainings;
		
		$this->db->where_in("training_levelgroup_training", $ids);
		$q = $this->db->get("training_levelgroup");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$allgroups[] = $rows[$i]->training_levelgroup_levelgroup;
			$this->levelmodel->getGroupChildIds($allgroups, $rows[$i]->training_levelgroup_levelgroup);
			
			$this->db->where_in("jabatan_level_group", $allgroups);
			$this->db->group_by("user_jabatan");
			$this->db->select("user_jabatan, count(*) tot");
			$this->db->join("jabatan", "jabatan_id = user_jabatan");
			$q = $this->db->get("user");
			$this->db->flush_cache();
			
			$rowusers = $q->result();
			for($j=0; $j < count($rowusers); $j++)
			{
				$trainings[$rows[$i]->training_levelgroup_training][$rowusers[$j]->user_jabatan] = $rowusers[$j]->tot;
			}			
			
			$ids = array_diff($ids, array($rows[$i]->training_levelgroup_training));
		}
		
		if (count($ids) == 0) return $trainings;

		$this->db->group_by("training_jabatan_training, training_jabatan_jabatan");
		$this->db->where_in("training_jabatan_training", $ids);
		$this->db->select("training_jabatan_training, training_jabatan_jabatan, count(*) tot");
		$this->db->join("training_jabatan", "user_jabatan = training_jabatan_jabatan");		
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_jabatan_training][$rows[$i]->training_jabatan_jabatan] = $rows[$i]->tot;
			$ids = array_diff($ids, array($rows[$i]->training_jabatan_training));
		}
		
		if (count($ids) == 0) return $trainings;

		$this->db->group_by("training_function_training, user_jabatan");
		$this->db->where_in("training_function_training", $ids);
		$this->db->select("training_function_training, user_jabatan, count(*) tot");
		$this->db->join("training_function", "user_function = training_function_function");		
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_function_training][$rows[$i]->user_jabatan] = $rows[$i]->tot;
			$ids = array_diff($ids, array($rows[$i]->training_function_training));
		}
		
		if (count($ids) == 0) return $trainings;
		
		$this->db->group_by("training_npk_training, user_jabatan");
		$this->db->where_in("training_npk_training", $ids);
		$this->db->select("training_npk_training, user_jabatan, count(*) tot");
		$this->db->join("training_npk", "user_id = training_npk_npk");		
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_npk_training][$rows[$i]->user_jabatan] = $rows[$i]->tot;
		}		
		
		return $trainings;
	}	

	function GetCandidateUserIds($ids)
	{
		$trainings = array();
		
		$this->db->where_in("training_id", $ids);
		$q = $this->db->get("training");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			if ($rows[$i]->training_all_staff)
			{	
				$this->db->where("user_status", 1);	//user active only			
				$q = $this->db->get("user");
				$rowusers = $q->result();
				for($j=0; $j < count($rowusers); $j++)
				{
					$trainings[$rows[$i]->training_id][$rowusers[$j]->user_id] = $rowusers[$j];
				}
				//$ids = array_diff($ids, array($rows[$i]->training_id));
			}
		}
		
		//if (count($ids) == 0) return $trainings;
		
		$this->db->where_in("training_levelgroup_training", $ids);
		$q = $this->db->get("training_levelgroup");
		$this->db->flush_cache();
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$allgroups[] = $rows[$i]->training_levelgroup_levelgroup;
			$this->levelmodel->getGroupChildIds($allgroups, $rows[$i]->training_levelgroup_levelgroup);
			
			$this->db->where_in("jabatan_level_group", $allgroups);
			$this->db->join("jabatan", "jabatan_id = user_jabatan");
			$this->db->where("user_status", 1);	//user active only
			$q = $this->db->get("user");
			$rowusers = $q->result();
			for($j=0; $j < count($rowusers); $j++)
			{
				$trainings[$rows[$i]->training_levelgroup_training][$rowusers[$j]->user_id] = $rowusers[$j];
			}

			$this->db->flush_cache();
						
			//$ids = array_diff($ids, array($rows[$i]->training_levelgroup_training));
		}
		
		//if (count($ids) == 0) return $trainings;
		
		$this->db->where_in("training_jabatan_training", $ids);
		$this->db->join("training_jabatan", "user_jabatan = training_jabatan_jabatan");		
		$this->db->where("user_status", 1);	//user active only
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_jabatan_training][$rows[$i]->user_id] = $rows[$i];
			//$ids = array_diff($ids, array($rows[$i]->training_jabatan_training));
		}
		
		if (count($ids) == 0) return $trainings;

		$this->db->where_in("training_function_training", $ids);
		$this->db->join("training_function", "user_function = training_function_function");		
		$this->db->where("user_status", 1);	//user active only
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_function_training][$rows[$i]->user_id] = $rows[$i];
			//$ids = array_diff($ids, array($rows[$i]->training_function_training));
		}
		
		//if (count($ids) == 0) return $trainings;
		
		$this->db->where_in("training_npk_training", $ids);
		$this->db->join("training_npk", "user_id = training_npk_npk");	
		$this->db->where("user_status", 1);	//user active only	
		$q = $this->db->get("user");
		$this->db->flush_cache();		

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$trainings[$rows[$i]->training_npk_training][$rows[$i]->user_id] = $rows[$i];
		}		
		
		return $trainings;
	}		

}
