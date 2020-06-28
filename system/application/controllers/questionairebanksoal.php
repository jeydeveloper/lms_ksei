<?php

include_once "base.php";

class Questionairebanksoal extends Base{
	var $lang;
	var $modules;

	function Questionairebanksoal()
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
	    $this->mysmarty->assign("main_content", "questionairebanksoal/list.html");
		$this->mysmarty->display("sess_template.html");
	}

	function add_new()
	{
		if(!empty($_POST)) {
			$this->do_add_new();
		}

	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionairebanksoal/form_new.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function do_add_new() {
		$this->load->library('form_validation');		

		$this->form_validation->set_rules('qsbs_name', 'Nama', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');

		if($this->form_validation->run()) {
			$data = array(
				'qsbs_name' => $this->input->post('qsbs_name'),
				'qsbs_entrydate' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('questionaire_banksoal', $data);

			$id = $this->db->insert_id();

			if(!empty($_POST['is_import'])) {
				$filename = $_FILES['fileupload']['tmp_name'];
				if(!empty($filename)) $this->do_import_file($id, $filename);
			} else {
				if(!empty($_POST['bsdt_question'])) {
					foreach ($_POST['bsdt_question'] as $key => $value) {
						if(empty($value)) continue;

						$lbl_opsi = "bsdt_option_".$key;
						$opt = array();
						if(!empty($_POST[$lbl_opsi])) {
							foreach ($_POST[$lbl_opsi] as $key2 => $value2) {
								if(empty($value2)) continue;

								$opt[$key2] = $value2;
							}
						}

						$data = array(
							'bsdt_qsbs_id' => $id,
							'bsdt_order_no' => ($key + 1),
							'bsdt_question' => $value,
							'bsdt_option' => serialize($opt),
							'bsdt_entrydate' => date('Y-m-d H:i:s'),
						);

						$this->db->insert('questionaire_banksoal_detail', $data);
					}
				}
			}

			redirect('questionairebanksoal/add_new', true);
		} else {
			$this->mysmarty->assign("err_msg", validation_errors());
		}
	}

	function edit($id)
	{
		if(!empty($_POST)) {
			$this->do_edit($id);
		} else {
			$res = $this->db->where('qsbs_id = "'.$id.'"')->get('questionaire_banksoal')->row_array();
			$_POST = $res;
		}

		$detail_soal = $this->db->where('bsdt_qsbs_id = "'.$id.'"')->order_by('bsdt_order_no')->get('questionaire_banksoal_detail')->result();

		$head_option = array();
		foreach ($detail_soal as $key => $value) {
			$bsdt_option = unserialize($value->bsdt_option);
			$detail_soal[$key]->bsdt_option = $bsdt_option;

			if(count($bsdt_option) > count($head_option)) $head_option = $bsdt_option;
		}

		$res = $this->db->where('qsusr_qsbs_id = "'.$id.'"')->get('questionaire_user_history')->result_array();

		$history = 0;
		if(!empty($res)) $history = 1;

		//print_r($detail_soal);
		
		$this->mysmarty->assign("head_option", $head_option);
		$this->mysmarty->assign("count_head_option", count($head_option));
		$this->mysmarty->assign("history", $history);
	    $this->mysmarty->assign("detail", $_POST);
	    $this->mysmarty->assign("detail_soal", $detail_soal);
	    $this->mysmarty->assign("left_content", "topic/menu.html");
	    $this->mysmarty->assign("main_content", "questionairebanksoal/form_edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	private function do_edit($id) {
		if(!empty($_POST)) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('qsbs_name', 'Nama', 'trim|htmlspecialchars|encode_php_tags|prep_for_form|required|xss_clean');

			if($this->form_validation->run()) {
				$data = array(
					'qsbs_name' => $this->input->post('qsbs_name'),
					'qsbs_changedate' => date('Y-m-d H:i:s'),
				);
				$this->db->where('qsbs_id = "'.$id.'"')->update('questionaire_banksoal', $data);

				if(!empty($_POST['is_import'])) {
					$filename = $_FILES['fileupload']['tmp_name'];
					if(!empty($filename)) $this->do_import_file($id, $filename);
				} else {
					if(!empty($_POST['bsdt_question'])) {
						$this->db->where('bsdt_qsbs_id ="'.$id.'"')->delete('questionaire_banksoal_detail');

						foreach ($_POST['bsdt_question'] as $key => $value) {
							if(empty($value)) continue;

							$lbl_opsi = "bsdt_option_".$key;
							$opt = array();
							if(!empty($_POST[$lbl_opsi])) {
								foreach ($_POST[$lbl_opsi] as $key2 => $value2) {
									if(empty($value2)) continue;
									
									$opt[$key2] = $value2;
								}
							}

							$data = array(
								'bsdt_qsbs_id' => $id,
								'bsdt_order_no' => ($key + 1),
								'bsdt_question' => $value,
								'bsdt_option' => serialize($opt),
								'bsdt_entrydate' => date('Y-m-d H:i:s'),
							);
							
							$this->db->insert('questionaire_banksoal_detail', $data);
						}
					}
				}

				redirect('questionairebanksoal', true);
			} else {
				$this->mysmarty->assign("err_msg", validation_errors());
			}
		}
	}

	function delete($id = '') {
		$this->db->where('qsbs_id = "'.$id.'"')->delete('questionaire_banksoal');
		$this->db->where('bsdt_qsbs_id = "'.$id.'"')->delete('questionaire_banksoal_detail');
		redirect('questionairebanksoal', true);
	}

	private function do_import_file($id, $filename) {
		set_time_limit(0);

		/*
		//-------PHP 5.2.17 script ini tidak jalan-----------
		
		$this->load->library("xlsreader");

		$this->xlsreader->read($filename);

		$rows = array();
		$TotalColumn = 3;
		$i = 2;
		while(1)
		{	
			if  (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;
																		
			for($j=1;$j<=$TotalColumn;$j++)
			{
				if (! isset($this->xlsreader->sheets[0]['cells'][$i][$j]))
				{
					$rows[$i-2][$j-1] = "";
					continue;
				}
				
				if ($this->xlsreader->sheets[0]['cellsInfo'][$i][$j]['type'] == "date")
				{
					$rows[$i-2][$j-1] = date("Ymd", $this->xlsreader->sheets[0]['cellsInfo'][$i][$j]["raw"]);
					continue; 
				}
				
				$rows[$i-2][$j-1] = trim($this->xlsreader->sheets[0]['cells'][$i][$j]);
			}						
			$i++;	
		}
		*/

		//-------alternatif untuk PHP 5.2.17-----------

		$this->load->library("PhpExcelReader");		
		$excel = new PhpExcelReader;
		$excel->read($filename);
		
		$rows = array();
		$TotalColumn = 3;
		$i = 2;
		while(1)
		{	
			if  (! isset($excel->sheets[0]['cells'][$i][1])) break;
																		
			for($j=1;$j<=$TotalColumn;$j++)
			{
				if (! isset($excel->sheets[0]['cells'][$i][$j]))
				{
					$rows[$i-2][$j-1] = "";
					continue;
				}
				
				if ($excel->sheets[0]['cellsInfo'][$i][$j]['type'] == "date")
				{
					$rows[$i-2][$j-1] = date("Ymd", $excel->sheets[0]['cellsInfo'][$i][$j]["raw"]);
					continue; 
				}
				
				$rows[$i-2][$j-1] = trim($excel->sheets[0]['cells'][$i][$j]);

				//echo $rows[$i-2][$j-1];
			}						
			$i++;	
		}

		//exit();

		//print_r($rows); exit();

		$this->db->where('bsdt_qsbs_id ="'.$id.'"')->delete('questionaire_banksoal_detail');

		if(!empty($rows)) {
			foreach ($rows as $key => $value) {
				$data = array(
					'bsdt_qsbs_id' => $id,
					'bsdt_order_no' => ($key + 1),
					'bsdt_question' => $value[0],
					'bsdt_option' => serialize(array($value[1], $value[2])),
					'bsdt_entrydate' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('questionaire_banksoal_detail', $data);
			}
		}
	}

	private function set_paging() {
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = !empty($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = !empty($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = !empty($_POST["sortby"]) ? $_POST["sortby"] : "qsbs_id";
		$orderby = !empty($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = !empty($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = !empty($_POST["searchby"]) ? $_POST["searchby"] : "";

		//--------select limit rows-----------
		$this->db->order_by($sortby, $orderby);
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		if (!empty($limit)) $this->db->limit($limit, $offset);
		$list = $this->db->get('questionaire_banksoal')->result();

		//-------flush cache---------
		$this->db->flush_cache();

		//-------count total rows-------------------------
		if (!empty($searchby)) $this->db->where("$searchby LIKE", '%'.strtoupper($keyword).'%');
		$total_rows = $this->db->get('questionaire_banksoal')->result();
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
			$arr_id[] = $value->qsbs_id;
		}

		if(!empty($arr_id)) {
			$id = join(',', $arr_id);
			$res = $this->db->where('qstr_qsbs_id IN ('.$id.')')->get('questionaire')->result_array();
			foreach ($res as $key => $value) {
				$history[$value['qstr_qsbs_id']] = 1;
			}
		}

		$this->mysmarty->assign("history", $history);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
