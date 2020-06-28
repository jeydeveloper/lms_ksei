<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CertificateModel extends Model {
	function CertificateModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
		$this->load->helper("common");
		$this->load->model("levelmodel");
	}	

	function GetQuestion($sess, $certificateid, $nosoal)
	{
		$is_debug = $this->config->item('IS_DEBUG');
		
		if($is_debug){
			$this->load->helper('file');
			$log_folder = $this->config->item('PATH_LOG');
			$fname = date("Ymd")."_".$sess['user_id']."_debug_log.txt";
			$filename = $log_folder."/".$fname;
		}
		
		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] Start GetQuestion \r\n",'a' );
		
		$this->db->where("history_answer_order", $nosoal);
		$this->db->where("history_exam_training", $certificateid);
		$this->db->where("history_exam_date", 0);
		$this->db->where("history_exam_time", 0);
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("training_type", 2);
		$this->db->join("training", "training_id = history_exam_training");				
		$this->db->join("history_answer", "history_answer_history_exam = history_exam_id");
		
		$q = $this->db->get("history_exam");				
		$this->db->flush_cache();

		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] ".$this->db->last_query()."\r\n",'a' );

		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] End GetQuestion \r\n",'a' );

		return $q->result();
	}
	
	function GetSoalNoAnswer($sess, $certificateid, $order="desc")
	{
		$this->db->order_by("history_answer_order", $order);		
		$this->db->where("history_answer_answer", 0);
		$this->db->where("history_exam_training", $certificateid);
		$this->db->where("history_exam_date", 0);
		$this->db->where("history_exam_time", 0);
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("training_type", 2);
		$this->db->join("training", "training_id = history_exam_training");						
		$this->db->join("history_answer", "history_answer_history_exam = history_exam_id");
		$this->db->join("banksoal_question", "banksoal_question_id = history_answer_question");
		
		$q = $this->db->get("history_exam");				
		$this->db->flush_cache();
		
		return $q->result();
	}
	
	function GetSoalInitAnswer($sess, $certificateid)
	{
		$this->db->order_by("history_answer_order", "asc");
		$this->db->where("history_answer_answer", -1);
		$this->db->where("history_exam_training", $certificateid);
		$this->db->where("history_exam_date", 0);
		$this->db->where("history_exam_time", 0);
		$this->db->where("history_exam_user", $sess['user_id']);
		$this->db->where("training_type", 2);
		$this->db->join("training", "training_id = history_exam_training");				
		$this->db->join("history_answer", "history_answer_history_exam = history_exam_id");
		
		$q = $this->db->get("history_exam");				
		$this->db->flush_cache();
		
		return $q->result();
	}
	
	function GetSoal($sess, $certificateid, $order="desc", $type=3, $examid=0)
	{
		$is_debug = $this->config->item('IS_DEBUG');
		
		if($is_debug){
			$this->load->helper('file');
			$log_folder = $this->config->item('PATH_LOG');
			$fname = date("Ymd")."_".$sess['user_id']."_debug_log.txt";
			$filename = $log_folder."/".$fname;
		}
		
		if($is_debug)
			write_file($filename,"[".date("H:i:s")."] Start GetSoal \r\n",'a' );
			
		if (! $examid)
		{
			// get exam untuk meyakinkan bahwa id hanya ada 1
			
			$this->db->order_by("history_exam_id", "desc");
			$this->db->where("history_exam_date", 0);
			$this->db->where("history_exam_time", 0);			
			$this->db->where("history_exam_training", $certificateid);
			$this->db->where("history_exam_type", $type);
			$this->db->where("history_exam_user", $sess['user_id']);			
			$q = $this->db->get("history_exam");
			
			$rowexam = $q->row();
			$examid = $rowexam->history_exam_id;
			if($is_debug)
				write_file($filename,"[".date("H:i:s")."] ".$this->db->last_query()."\r\n",'a' );

		}
		
		$this->db->order_by("history_answer_order", $order);		
		$this->db->where("history_exam_id", $examid);
				
		$this->db->where("history_exam_user", $sess['user_id']);		
		$this->db->join("training", "training_id = history_exam_training");						
		$this->db->join("history_answer", "history_answer_history_exam = history_exam_id");
		$this->db->join("banksoal_question", "banksoal_question_id = history_answer_question");
		
		$q = $this->db->get("history_exam");				
		$this->db->flush_cache();

		if($is_debug)
				write_file($filename,"[".date("H:i:s")."] ".$this->db->last_query()."\r\n",'a' );

		if($is_debug)
				write_file($filename,"[".date("H:i:s")."] END GetSoal  \r\n",'a' );

		return $q->result();
	}		
}
