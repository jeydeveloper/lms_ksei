<?php
include_once "base.php"; 

class SAP extends Base {
	var $m_fout;
	var $m_levelgroups;
	var $m_levelparents;
	var $m_trainings;
	var $m_level;
	
	function SAP()
	{
		//parent::Controller();	
		parent::Base();	
				
		$this->load->database();	
		
		$this->m_levelgroups = array();
		$this->m_levelparents = array();
		$this->m_trainings = array();			
		
		$this->gettrainings();
		$this->getgroups();
		
		$this->load->helper('common');	
		$this->load->helper('url');	
		
	}
	
	function getgroups()
	{
		$this->db->select("level_group_id, level_group_name, level_group_parent");
		$q = $this->db->get("level_group");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$this->m_levelgroups[$rows[$i]->level_group_id] = $rows[$i]->level_group_name;
			$this->m_levelparents[$rows[$i]->level_group_id] = $rows[$i]->level_group_parent;
		}
	}
	
	function gethirarki($lvlgrpid)
	{
		$arrhirarki[] = $this->m_levelgroups[$lvlgrpid];				
		$parent = $this->m_levelparents[$lvlgrpid];
		
		while ($parent)
		{
			array_unshift($arrhirarki, $this->m_levelgroups[$parent]);
			$parent = $this->m_levelparents[$parent];
		}
		
		for($i=count($arrhirarki)+1; $i <= 4; $i++)
		{
			$arrhirarki[] = "";
		}
		
		return $arrhirarki;
	}
	
	function gettrainings()
	{
		$this->db->select("training_id, training_exam_type, training_type, training_duration, training_cost");
		$this->db->join("training_exam", "training_exam_training = training_id", "left outer");
		$q = $this->db->get("training");		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			
			$this->m_trainings[$rows[$i]->training_id]['duration'] = $rows[$i]->training_duration ? $rows[$i]->training_duration : 0;
			$this->m_trainings[$rows[$i]->training_id]['cost'] = $rows[$i]->training_cost ? $rows[$i]->training_cost : 0;
			$this->m_trainings[$rows[$i]->training_id]['type'] = $rows[$i]->training_type;
			$this->m_trainings[$rows[$i]->training_id]['exam'][] = $rows[$i]->training_exam_type ? $rows[$i]->training_exam_type : 0;
		}
	}
	
	function generalreport($cli=1, $from=0, $to=0)
	{						
		if($this->report_type == "MTD"){ // Month to Date
			$filename = BASEPATH."../".$this->config->item("outbox")."/".$this->getfilename($cli).date("m").".".$this->config->item("sap_extension");
			$from = date("Ym")."01";
			$to = date("Ymt");
		}else{
			//($this->report_type == "YTD"){  //Year to Date
			$filename = BASEPATH."../".$this->config->item("outbox")."/".$this->getfilename($cli).".".$this->config->item("sap_extension");				
		}
		
		
		if (is_file($filename))
		{				
			$paths = pathinfo($filename);
			
			//-- backup the files by year by month
			$backup_dir = BASEPATH."../".$this->config->item("outbox")."/".date("Y")."/".date("m");
			if(!is_dir($backup_dir)) {
				mkdir($backup_dir,077,true);
			}
			
			$filename1 = $backup_dir."/".date("Ymd_His")."_".$paths['filename'].".".$paths['extension'];
			rename($filename, $filename1);
		}
						
		$this->m_fout = fopen($filename, "w");	
		if (! $this->m_fout)
		{
			die("Can't write to ".$filename);
			return;
		}
		
		fputs($this->m_fout, $this->getheader()."\r\n");
		
		if ($from == 0) $from = date("Y")."0101";
		
		if ($to == 0) $to = date("Ymd");
		
		if ($this->iscoursecode())
		{
			$this->db->select("level_group_id, user_grade_code, user_npk, history_exam_training, history_exam_status, category_name,category_code");		
		}
		else
		{
			$this->db->select("level_group_id, user_grade_code, user_npk, history_exam_training, history_exam_status");		
		}			
		$this->db->join("user", "user_id = history_exam_user");
		$this->db->join("jabatan", "user_jabatan = jabatan_id");
		$this->db->join("level_group", "jabatan_level_group = level_group_id");
		if ($this->iscoursecode())
		{
			$this->db->join("training", "history_exam_training = training_id");
			$this->db->join("category", "training_topic = category_id");
		}
		$this->db->where_in("history_exam_type", array(2, 3, 4));  //training,certification, classroom
		//$this->db->where("user_status", 1);			// active 
		$this->db->where("history_exam_status",1); 	// export yg lulus
		$this->db->where("user_emp", 1); 			// staff
		//$this->db->where("level_group_nth >=", $this->getminlevel());
		$this->db->where("history_exam_date >= ", $from);
		$this->db->where("history_exam_date <= ", $to);
		$q = $this->db->get("history_exam");
		$rows = $q->result();
		//echo $from."::".$to."\r\n";
		$this->process($rows);
		
		
		fclose($this->m_fout);		
	}				
	
	function iscoursecode()
	{
		return false;
	}
	
	function set_type($type){
		$this->report_type = $type;
	}

	function format($i, $val)
	{
		switch($i)
		{
			case 1:
			case 2:
			case 8:
			case 10:
			case 11:
			case 12:
				return numformat($val);
			break;					
			default:
				return $val;
		}		
	}		
	
	function rod()
	{
		$this->load->library('session');
		$this->load->model("langmodel");
		
		$this->lang = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->lang ? $this->lang : $this->langmodel->getDefaultLang()));						
		
		$sfrom = (isset($_POST['from']) && $_POST['from']) ? $_POST['from'] : "01/01/".date("Y");		
		$tfrom = formmaketime($sfrom." 00:00:00");
		$from = date("Ymd", $tfrom);
		
		$sto = (isset($_POST['to']) && $_POST['to']) ? $_POST['to'] : date("d/m/Y");
		$tto = formmaketime($sto." 00:00:00");
		$to = date("Ymd", $tto);				
		
		$this->generalreport("od", $from, $to);
		
		//$link = base_url().$this->config->item("outbox")."/".$this->getfilename("od");
		
		$link = base_url()."index.php/download/sap/".$this->getfilename("od");
		
		
		unset($callback);
		
		$callback['error'] = false;
		$callback['message'] = sprintf($this->config->item("lgeneral_report_download_link"), $link, $this->getfilename("od"));
		
		echo json_encode($callback);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */