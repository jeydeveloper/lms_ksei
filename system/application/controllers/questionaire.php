<?php

include_once "base.php";

class Questionaire extends Base{
	var $lang;
	var $modules;

	function Questionaire()
	{
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
		$this->load->model("ildpmodel");

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
		} else {
			redirect('');
			exit();
		}
		$this->langmodel->init();
	}

	function index()
	{
		$this->set_paging();
	    
	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionaire/list.html");
		$this->mysmarty->display("sess_template.html");
	}

	function add_new()
	{
		if(!empty($_POST)) {
			$this->do_add_new();
		}

		$list_banksoal = $this->db->get('questionaire_banksoal')->result();

		$this->mysmarty->assign("list_banksoal", $list_banksoal);
	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionaire/form_new.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function do_add_new() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('qstr_name', 'Nama', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');
		$this->form_validation->set_rules('qstr_qsbs_id', 'Bank Soal', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');

		if($this->form_validation->run()) {
			$data = array(
				'qstr_name' => $this->input->post('qstr_name'),
				'qstr_desc' => $this->input->post('qstr_desc'),
				'qstr_qsbs_id' => $this->input->post('qstr_qsbs_id'),
				'qstr_disabled' => $this->input->post('qstr_disabled'),
				'qstr_entrydate' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('questionaire', $data);

			redirect('questionaire/add_new', true);
		} else {
			$this->mysmarty->assign("err_msg", validation_errors());
		}
	}

	function edit($id)
	{
		if(!empty($_POST)) {
			$this->do_edit($id);
		} else {
			$res = $this->db->where('qstr_id = "'.$id.'"')->get('questionaire')->row_array();
			$_POST = $res;
		}

		$list_banksoal = $this->db->get('questionaire_banksoal')->result();

		$this->mysmarty->assign("list_banksoal", $list_banksoal);
	    $this->mysmarty->assign("detail", $res);
	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionaire/form_edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function do_edit($id) {
		if(!empty($_POST)) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('qstr_name', 'Nama', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');
			$this->form_validation->set_rules('qstr_qsbs_id', 'Bank Soal', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');

			if($this->form_validation->run()) {
				$data = array(
					'qstr_name' => $this->input->post('qstr_name'),
					'qstr_desc' => $this->input->post('qstr_desc'),
					'qstr_qsbs_id' => $this->input->post('qstr_qsbs_id'),
					'qstr_disabled' => $this->input->post('qstr_disabled'),
					'qstr_changedate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('qstr_id = "'.$id.'"')->update('questionaire', $data);

				redirect('questionaire', true);
			} else {
				$this->mysmarty->assign("err_msg", validation_errors());
			}
		}
	}

	function history($id) {
		$sortby = !empty($_POST["sortby"]) ? $_POST["sortby"] : "user_first_name";
		$orderby = !empty($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$searchby = !empty($_POST['searchby']) ? $_POST['searchby'] : '';
		$keyword = !empty($_POST['keyword']) ? $_POST['keyword'] : '';
		
		$this->db->order_by($sortby .' '. $orderby . ', bsdt_order_no asc');
		if(!empty($searchby) AND !empty($keyword)) $this->db->where($searchby.' LIKE "%'.$keyword.'%"');

		$res = $this->db->where('qsusr_qstr_id = "'.$id.'"')->join('user', 'qsusr_user_id = user_id')->join('questionaire_banksoal_detail', 'qsusr_bsdt_orderno = bsdt_order_no AND qsusr_qsbs_id = bsdt_qsbs_id')->get('questionaire_user_history')->result_array();

		$col_history = array();
		$row_history = array();
		foreach ($res as $key => $value) {
			$col_history['optional'][$value['qsusr_bsdt_orderno']] = unserialize($value['bsdt_option']);
			$col_history['soal'][$value['qsusr_bsdt_orderno']] = $value['bsdt_question'];
			$col_history['no_urut'][$value['qsusr_bsdt_orderno']] = $value['bsdt_order_no'];

			$row_history[$value['qsusr_user_id']]['nama'] = $value['user_first_name'];
			$row_history[$value['qsusr_user_id']]['nik'] = $value['user_npk'];
			
			$tmp = explode(' ', $value['qsusr_entrydate']);
			$tanggalPengisian = !empty($tmp[0]) ? $tmp[0] : '';
			$row_history[$value['qsusr_user_id']]['tanggalPengisian'] = $tanggalPengisian;

			$row_history[$value['qsusr_user_id']]['jawaban'][$value['qsusr_bsdt_orderno']] = $value['qsusr_answer'];
		}

		$res = $this->db->where('general_setting_code = "questionaire_anonim_user"')->get('general_setting')->row_array();
		if(!empty($res['general_setting_value'])) {
			$this->mysmarty->assign("main_content", "questionaire/history_anonim.html");
		} else {
			$this->mysmarty->assign("main_content", "questionaire/history.html");
		}

		$this->mysmarty->assign("keyword", $keyword);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);	

		$this->mysmarty->assign("col_history", $col_history);
	    $this->mysmarty->assign("row_history", $row_history);
	    $this->mysmarty->assign("qstr_id", $id);
	    $this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->display("sess_template.html");
	}
	/*
	function export_history($id) {
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-questionaire-history.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("questionaire-history");

		$res = $this->db->where('qsusr_qstr_id = "'.$id.'"')->join('user', 'qsusr_user_id = user_id')->join('questionaire_banksoal_detail', 'qsusr_bsdt_id = bsdt_id')->order_by('bsdt_order_no')->get('questionaire_user_history')->result_array();

		$col_history = array();
		$row_history = array();
		foreach ($res as $key => $value) {
			$col_history['optional'][$value['qsusr_bsdt_id']] = unserialize($value['bsdt_option']);
			$col_history['soal'][$value['qsusr_bsdt_id']] = $value['bsdt_question'];
			$col_history['no_urut'][$value['qsusr_bsdt_id']] = $value['bsdt_order_no'];

			$row_history[$value['qsusr_user_id']]['nama'] = $value['user_first_name'];
			$row_history[$value['qsusr_user_id']]['nik'] = $value['user_npk'];
			$row_history[$value['qsusr_user_id']]['jawaban'][$value['qsusr_bsdt_id']] = $value['qsusr_answer'];
		}

		$worksheet->write(0, 0, 'NIK');
		$worksheet->write(0, 1, 'Nama');

		$nxt = 2;
		foreach ($col_history['no_urut'] as $key => $value) {
			$worksheet->write(0, $nxt, $col_history['soal'][$key]);
			$nxt++;
		}
		
		$i = 0;
		foreach ($row_history as $key => $value) {
			$worksheet->write($i+1, 0, $value['nik']);	
			$worksheet->write($i+1, 1, $value['nama']);

			$nxt = 2;
			foreach ($col_history['no_urut'] as $key2 => $value2) {
				$worksheet->write($i+1, $nxt, $col_history['optional'][$key2][($value['jawaban']-1)]);

				$nxt++;
			}

			$i++;
		}

		$this->xlswriter->close();
	}
	*/

	function export_history($id) {
		$filename = date("Ymd-His")."-questionaire-history.xls";

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");

		$res = $this->db->where('qsusr_qstr_id = "'.$id.'"')->join('user', 'qsusr_user_id = user_id')->join('questionaire_banksoal_detail', 'qsusr_bsdt_orderno = bsdt_order_no AND qsusr_qsbs_id = bsdt_qsbs_id')->order_by('bsdt_order_no')->get('questionaire_user_history')->result_array();

		$col_history = array();
		$row_history = array();
		foreach ($res as $key => $value) {
			$col_history['optional'][$value['qsusr_bsdt_orderno']] = unserialize($value['bsdt_option']);
			$col_history['soal'][$value['qsusr_bsdt_orderno']] = $value['bsdt_question'];
			$col_history['no_urut'][$value['qsusr_bsdt_orderno']] = $value['bsdt_order_no'];

			$row_history[$value['qsusr_user_id']]['nama'] = $value['user_first_name'];
			$row_history[$value['qsusr_user_id']]['nik'] = $value['user_npk'];

			$tmp = explode(' ', $value['qsusr_entrydate']);
			$tanggalPengisian = !empty($tmp[0]) ? $tmp[0] : '';
			$row_history[$value['qsusr_user_id']]['tanggalPengisian'] = $tanggalPengisian;

			$row_history[$value['qsusr_user_id']]['jawaban'][$value['qsusr_bsdt_orderno']] = $value['qsusr_answer'];
		}

		$res = $this->db->where('general_setting_code = "questionaire_anonim_user"')->get('general_setting')->row_array();
		if(!empty($res['general_setting_value'])) {
			$this->mysmarty->assign("main_content", "questionaire/history_excel_anonim.html");
		} else {
			$this->mysmarty->assign("main_content", "questionaire/history_excel.html");
		}

		$this->mysmarty->assign("col_history", $col_history);
	    $this->mysmarty->assign("row_history", $row_history);
	    
		$this->mysmarty->display("sess_template_export.html");
	}

	private function set_paging() {
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = !empty($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = !empty($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = !empty($_POST["sortby"]) ? $_POST["sortby"] : "qstr_id";
		$orderby = !empty($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = !empty($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = !empty($_POST["searchby"]) ? $_POST["searchby"] : "";

		//--------select limit rows-----------
		$this->db->order_by($sortby, $orderby);
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		if (!empty($limit)) $this->db->limit($limit, $offset);
		$list = $this->db->join('questionaire_banksoal', 'qstr_qsbs_id = qsbs_id')->get('questionaire')->result();

		//-------flush cache---------
		$this->db->flush_cache();

		//-------count total rows-------------------------
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		$total_rows = $this->db->join('questionaire_banksoal', 'qstr_qsbs_id = qsbs_id')->get('questionaire')->result();
		$total = count($total_rows);
		
		$s = "";
		$this->itot = 0;
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['next_link'] = '<img src="'.base_url().'/images/16/blue_next.gif" alt="next" width="16" height="16" border="0" />';
		$config['next_tag_open'] = "<td>";
		$config['next_tag_close'] = "</td>";
		$config['prev_link'] = '<img src="'.base_url().'/images/16/blue_back.gif" alt="prev" width="16" height="16" border="0" />';
		$config['prev_tag_open'] = "<td>";
		$config['prev_tag_close'] = "</td>";
		$config['first_link'] = '<img src="'.base_url().'/images/16/blue_first.gif" alt="prev" width="16" height="16" border="0" />';
		$config['last_link'] = '<img src="'.base_url().'/images/16/blue_last.gif" alt="prev" width="16" height="16" border="0" />';
		$limits = array(10=>10, 20=>20, 50=>50);
		if (! in_array($recordperpage, $limits)) 
		{
			$limits[$recordperpage] = $recordperpage;
			ksort($limits);
		} 
		$limits[0] = 'all';
		$this->pagination1->initialize($config);		
		$this->pagination1->lang_title = $this->config->item('lcms_news');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;
		
		$this->mysmarty->assign("keyword", $keyword);		
		$this->mysmarty->assign("limit", $limit);		
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());
		$this->mysmarty->assign("list", $list);

		$this->get_additional_info($list);
	}

	private function get_additional_info($list = array()) {
		$history = array();

		$arr_id = array();
		foreach ($list as $key => $value) {
			$arr_id[] = $value->qstr_id;
		}

		if(!empty($arr_id)) {
			$id = join(',', $arr_id);
			$res = $this->db->where('qsusr_qstr_id IN ('.$id.')')->group_by('qsusr_qstr_id')->get('questionaire_user_history')->result_array();
			foreach ($res as $key => $value) {
				$history[$value['qsusr_qstr_id']] = 1;
			}
		}

		$this->mysmarty->assign("history", $history);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
