<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once "base.php";

class Ajax extends Base {
	function Ajax()
	{
		parent::Base();
		$this->load->database();
		$this->load->library('session');
		$usess = $this->session->userdata('lms_sess');	
		if (!$usess)	{
			die('You must login first!');
		}
	}

	function json_training(){
		$data = array();

		$this->db->select("*, DATE_FORMAT(training_time_date1, '%Y-%m-%d') as date_start, DATE_FORMAT(training_time_date2, '%Y-%m-%d') as date_end, DATE_FORMAT(training_time_date1, '%d-%m-%Y') as tanggal_start, DATE_FORMAT(training_time_date2, '%d-%m-%Y') as tanggal_end", false);
		$this->db->where("training_type", 1);
		$this->db->where("training_status", 1);
		$this->db->join("category", "training_topic = category_id");
		$this->db->join("training_time", "training_id = training_time_training");
		$q = $this->db->get("training");
		$list = $q->result_array();

		foreach ($list as $value) {
			$data[] = array(
				'id' 			=> $value['training_id'],
				'title' 		=> $value['training_name'],
				'start' 		=> $value['date_start'] . 'T00:00:00',
				'end' 			=> $value['date_end'] . 'T23:59:00',
				'desc' 			=> $value['training_desc'],
				'tanggal_start' => $value['tanggal_start'],
				'tanggal_end' 	=> $value['tanggal_end'],
				'target_url' 	=> '#',
				'className' 	=> 'training',
			);
		}

		$this->db->select("*, DATE_FORMAT(training_time_date1, '%Y-%m-%d') as date_start, DATE_FORMAT(training_time_date2, '%Y-%m-%d') as date_end, DATE_FORMAT(training_time_date1, '%d-%m-%Y') as tanggal_start, DATE_FORMAT(training_time_date2, '%d-%m-%Y') as tanggal_end", false);
		$this->db->where("training_type", 2);
		$this->db->where("training_status", 1);
		$this->db->join("category", "training_topic = category_id");
		$this->db->join("training_time", "training_id = training_time_training");
		$q = $this->db->get("training");
		$list = $q->result_array();

		foreach ($list as $value) {
			$data[] = array(
				'id' 			=> $value['training_id'],
				'title' 		=> $value['training_name'],
				'start' 		=> $value['date_start'] . 'T00:00:00',
				'end' 			=> $value['date_end'] . 'T23:59:00',
				'desc' 			=> $value['training_desc'],
				'tanggal_start' => $value['tanggal_start'],
				'tanggal_end' 	=> $value['tanggal_end'],
				'target_url' 	=> '#',
				'className' 	=> 'certification',
			);
		}

		$this->db->select("*", false);
		$q = $this->db->get("events");
		$list = $q->result_array();

		foreach ($list as $value) {
			$data[] = array(
				'id' 			=> $value['evnt_id'],
				'title' 		=> $value['evnt_title'],
				'start' 		=> $value['evnt_date'] . 'T00:00:00',
				'desc' 			=> $value['evnt_desc'],
				'date' 			=> $value['evnt_date'],
				'target_url' 	=> '#',
				'className' 	=> 'eventsx',
			);
		}

		echo json_encode($data);
	}

}