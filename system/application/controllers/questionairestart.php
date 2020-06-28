<?php

include_once "base.php";

class Questionairestart extends Base{
	var $lang;
	var $modules;

	function Questionairestart()
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
	    $this->mysmarty->assign("main_content", "questionairestart/list.html");
		$this->mysmarty->display("sess_template.html");
	}

	function start($id) {
		$this->checkDisabled($id);

		$this->do_start($id);

		$usess = $this->session->userdata('lms_sess');
		$sess = array();
		if ($usess) $sess = unserialize($usess);

		$res = $this->db->where('qsusr_qstr_id = "'.$id.'" AND qsusr_user_id = "'.$sess['user_id'].'"')->get('questionaire_user_history')->row_array();

		$detail = array();
		if(!empty($res)) {
			$this->mysmarty->assign("deny", 1);
		} else {
			$res = $this->db->where('qstr_id = "'.$id.'"')->join('questionaire_banksoal_detail', 'qstr_qsbs_id = bsdt_qsbs_id')->order_by('bsdt_order_no')->get('questionaire')->result_array();

			foreach ($res as $key => $value) {
				$detail['bank_soal_id'] = $value['qstr_qsbs_id'];
				$detail['bank_soal'][$value['bsdt_id']]['id'] = $value['bsdt_id'];
				$detail['bank_soal'][$value['bsdt_id']]['text'] = $value['bsdt_question'];
				$detail['bank_soal'][$value['bsdt_id']]['no_urut'] = $value['bsdt_order_no'];
				$detail['bank_soal'][$value['bsdt_id']]['opt'] = unserialize($value['bsdt_option']);
			}
		}

		$this->mysmarty->assign("detail", $detail);
	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionairestart/start.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function do_start($id) {
		if(!empty($_POST)) {
			$usess = $this->session->userdata('lms_sess');
			$sess = array();
			if ($usess) $sess = unserialize($usess);
			
			foreach ($_POST['soal'] as $key => $value) {
				$data = array(
					'qsusr_user_id' => $sess['user_id'],
					'qsusr_qstr_id' => $id,
					'qsusr_qsbs_id' => $_POST['bank_soal_id'],
					'qsusr_bsdt_orderno' => $value,
					'qsusr_answer' => $_POST['jawaban'][$value],
					'qsusr_entrydate' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('questionaire_user_history', $data);
			}

			redirect('questionairestart', true);
		}
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
		$this->db->where("qstr_disabled != 1");
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		if (!empty($limit)) $this->db->limit($limit, $offset);
		$list = $this->db->join('questionaire_banksoal', 'qstr_qsbs_id = qsbs_id')->get('questionaire')->result();

		//-------flush cache---------
		$this->db->flush_cache();

		//-------count total rows-------------------------
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		$total_rows = $this->db->join('questionaire_banksoal', 'qstr_qsbs_id = qsbs_id')->where("qstr_disabled != 1")->get('questionaire')->result();
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

	private function checkDisabled($id) {
		$res = $this->db->where('qstr_id = "'.$id.'" AND qstr_disabled != 1')->get('questionaire')->row_array();
		if(empty($res)) {
			$this->mysmarty->assign("disabled", 1);

			$detail = array();
			$this->mysmarty->assign("detail", $detail);
		    $this->mysmarty->assign("left_content", "topic/menu.html");
		    $this->mysmarty->assign("main_content", "questionairestart/start.html");
			$this->mysmarty->display("sess_template.html");

			exit();
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
