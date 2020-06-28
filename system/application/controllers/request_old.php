<?php
include_once "base.php"; 

class Request extends Base {
	var $sess;
	var $lang;
	var $itot;
	var $modules;
	private $_error_form;
	private $_user_info;
	private $_data_x;

	function request()
	{	
		parent::Base();	
	
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("usermodel");
		$this->load->model("topicmodel");
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
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
			
			$this->sess = unserialize($usess);
			$this->modules = $this->commonmodel->getRight($this->sess['user_type']);

			$this->db->select('user_id, user_first_name, user_telp, user_npk_atasan, level_group_name, jabatan_name');
			$this->db->from('user');
			$this->db->join('jabatan', 'user_jabatan = jabatan_id', 'left');
			$this->db->join('level_group', 'jabatan_level_group = level_group_id', 'left');
			$this->db->where('user_id = "'.$this->sess['user_id'].'"');
			$this->_user_info = $this->db->get()->row_array();

			$this->mysmarty->assign("is_admin", $this->sess['user_id']);
		}		
		$this->langmodel->init();

		$this->_data_x = array();
	}

	function training() {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$arr_training_type = array(
			1 => 'Pelatihan Inhouse',
			2 => 'Pelatihan Eksternal',
			3 => 'On The Job Training',
		);

		$arr_jenis_pendidikan = array(
			1 => 'Technical Skill / Soft Skill',
			2 => 'BI Category',
		);

		$arr_status_approval = array(
			0 => 'Waiting',
			1 => 'Onprogress',
			2 => 'Approved',
			3 => 'rejected',
		);

		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "rqtr_id";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		

		if(!empty($_POST["_searchby"])) {
			$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
		}

		//print_r($_POST); exit();
		
		$sess = unserialize($usess);

		if (! isset($this->modules['master']))
		{
			//redirect(base_url());
		}
		
		if ($searchby AND !empty($keyword))
		{
			if ($searchby == "rqtr_judul")
			{	
				$this->db->where("rqtr_judul LIKE", '%'.strtoupper($keyword).'%');
			}

			if ($searchby == "rqtr_request_no")
			{	
				$this->db->where("rqtr_request_no ='".$keyword."'");
			}

			if ($searchby == "rqtr_request_code")
			{	
				$this->db->where("rqtr_request_code ='".$keyword."'");
			}

			if ($searchby == "status")
			{	
				$keywordx = $keyword - 1;
				$this->db->where("rqtr_status_approval = '".$keywordx."'");
			}
		}

		if($this->sess['user_type'] > 0) $this->db->where('rqtr_user_id = "'.$this->sess['user_id'].'"');
			
		$this->db->order_by($sortby, $orderby);
		
		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		$q = $this->db->select('request_training.*, DATE_FORMAT(rqtr_entrytime, "%d-%m-%Y") as tgl', false)->get("request_training");
		$list = $q->result_array();
		//echo $this->db->last_query(); exit();

		if ($searchby AND !empty($keyword))
		{
			if ($searchby == "rqtr_judul")
			{	
				$this->db->where("rqtr_judul LIKE", '%'.strtoupper($keyword).'%');
			}

			if ($searchby == "rqtr_request_no")
			{	
				$this->db->where("rqtr_request_no ='".$keyword."'");
			}

			if ($searchby == "rqtr_request_code")
			{	
				$this->db->where("rqtr_request_code ='".$keyword."'");
			}

			if ($searchby == "status")
			{	
				$keywordx = $keyword - 1;
				$this->db->where("rqtr_status_approval = '".$keywordx."'");
			}
		}

		if($this->sess['user_type'] > 0) $this->db->where('rqtr_user_id = "'.$this->sess['user_id'].'"');

		$total = $this->db->count_all_results("request_training");

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
		
		$this->mysmarty->assign("limit", $limit);		
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_category_jabatan", $this->config->item('lheader_list_category_jabatan'));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lcategory_jabatan_list", ucfirst($this->config->item('lcategory_jabatan_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		
		$this->mysmarty->assign("lsort_by_category_name", $this->config->item('lsort_by_category_name'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));

		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("arr_training_type", $arr_training_type);
		$this->mysmarty->assign("arr_jenis_pendidikan", $arr_jenis_pendidikan);
		$this->mysmarty->assign("arr_status_approval", $arr_status_approval);
		$this->mysmarty->assign("user_type", $this->sess['user_type']);

		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/list.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formtraining() {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		if(!empty($_POST)) {
			if($this->do_formtraining()) {
				redirect('request/training');
				exit();
			}
		}

		if(!empty($this->_error_form)) $this->_error_form = join(', ', $this->_error_form);

		$_POST['data_peserta'] = $this->_user_info['user_first_name'];
		$_POST['handphone'] = $this->_user_info['user_telp'];
		$_POST['divisi'] = $this->_user_info['level_group_name'];

		$data_jenispendidikan = $this->db->get('request_jenis_pendidikan')->result_array();
		$data_bicategory = $this->db->get('request_bi_category')->result_array();

		$this->mysmarty->assign("user_type", $this->sess['user_type']);
		$this->mysmarty->assign("data_jenispendidikan", $data_jenispendidikan);
		$this->mysmarty->assign("data_bicategory", $data_bicategory);
		$this->mysmarty->assign("frm", $_POST);
		$this->mysmarty->assign("error_form", $this->_error_form);
		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/form.html");
		$this->mysmarty->display("sess_template.html");
	}

	function do_formtraining() {
		$this->logmodel->init("notification_request_approval");

		$training_type = $_POST['training_type'];
		$penyelenggara = $_POST['penyelenggara'];
		$tema = $_POST['tema'];
		$judul = $_POST['judul'];
		$request_schedule = $_POST['request_schedule'];
		$biaya_lain = $_POST['biaya_lain'];
		$user_selected = $_POST['user_selected'];
		$tempat = $_POST['tempat'];
		$pembicara = $_POST['pembicara'];
		$tujuan_pelatihan = $_POST['tujuan_pelatihan'];
		$rekomendasi_supervisor = $_POST['rekomendasi_supervisor'];
		$biaya_program = $_POST['biaya_program'];
		$akomodasi = $_POST['akomodasi'];
		$transportasi = $_POST['transportasi'];
		$uang_makan = $_POST['uang_makan'];
		$rekomendasi_development = $_POST['rekomendasi_development'];
		$rqtr_jepd_id = !empty($_POST['rqtr_jepd_id']) ? $_POST['rqtr_jepd_id'] : '';
		$rqtr_bict_id = !empty($_POST['rqtr_bict_id']) ? $_POST['rqtr_bict_id'] : '';
		$rqtr_request_code = $_POST['rqtr_request_code'];

		if(empty($training_type)) $this->_error_form[] = 'Training Type';
		if(empty($penyelenggara)) $this->_error_form[] = 'Penyelenggara';
		if(empty($tema)) $this->_error_form[] = 'Tema';
		if(empty($judul)) $this->_error_form[] = 'Judul';
		if(empty($tempat)) $this->_error_form[] = 'Tempat';
		if(empty($pembicara)) $this->_error_form[] = 'Pembicara';
		if(empty($tujuan_pelatihan)) $this->_error_form[] = 'Tujuan Pelatihan';
		//if(empty($rekomendasi_supervisor)) $this->_error_form[] = 'Rekomendasi Supervisor';
		//if(empty($biaya_program)) $this->_error_form[] = 'Biaya Program';
		//if(empty($akomodasi)) $this->_error_form[] = 'Akomodasi';
		//if(empty($transportasi)) $this->_error_form[] = 'Transportasi';
		//if(empty($uang_makan)) $this->_error_form[] = 'Uang Makan';
		//if(empty($rekomendasi_development)) $this->_error_form[] = 'Rekomendasi Development';
		//if(empty($rqtr_jepd_id)) $this->_error_form[] = 'Jenis Pendidikan';
		//if(empty($rqtr_bict_id)) $this->_error_form[] = 'BI Category';

		if(!empty($this->_error_form)) return false;

		$this->load->library('upload');

		$arr_attach = array();
	    $files = $_FILES;
	    if(!empty($files)) {
	    	$cpt = count($_FILES['userfile']['name']);
		    for($i=0; $i<$cpt; $i++)
		    {           
		        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
		        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
		        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
		        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
		        $_FILES['userfile']['size']= $files['userfile']['size'][$i];

		        if ($_FILES['userfile']['name'] == '') continue;

		        $this->upload->initialize($this->set_upload_options());
		        $this->upload->do_upload();

		        $file_array = $this->upload->data();
		        $arr_attach['userfile'][$i] = $file_array['file_name'];
		    }
	    }

	    $biaya_program = str_replace('.', '', $biaya_program);
		$akomodasi = str_replace('.', '', $akomodasi);
		$transportasi = str_replace('.', '', $transportasi);
		$uang_makan = str_replace('.', '', $uang_makan);

		$jumlah = $biaya_program + $akomodasi + $transportasi + $uang_makan;
		if(!empty($biaya_lain['nama_biaya'])) {
			foreach ($biaya_lain['nama_biaya'] as $key => $value) {
				$biaya_lain['jumlah_biaya'][$key] = str_replace('.', '', $biaya_lain['jumlah_biaya'][$key]);
				$jumlah += $biaya_lain['jumlah_biaya'][$key];
			}
		}

		$generate_request_no = generate_request_no();
		$data = array(
			'rqtr_request_no' => $generate_request_no,
			'rqtr_request_code' => $rqtr_request_code,
			'rqtr_user_id' => $this->sess['user_id'],
			'rqtr_type' => $training_type,
			'rqtr_penyelenggara' => $penyelenggara,
			'rqtr_tema' => $tema,
			'rqtr_judul' => $judul,
			'rqtr_schedule' => !empty($request_schedule) ? serialize($request_schedule) : '',
			'rqtr_biaya_lain' => !empty($biaya_lain) ? serialize($biaya_lain) : '',
			'rqtr_participant' => !empty($user_selected) ? serialize($user_selected) : '',
			'rqtr_tempat' => $tempat,
			'rqtr_pembicara' => $pembicara,
			'rqtr_pemohon' => $this->_user_info['user_first_name'],
			'rqtr_divisi' => $this->_user_info['level_group_name'],
			'rqtr_tujuan_pelatihan' => $tujuan_pelatihan,
			'rqtr_rekomendasi_supervisor' => $rekomendasi_supervisor,
			'rqtr_biaya_program' => $biaya_program,
			'rqtr_akomodasi' => $akomodasi,
			'rqtr_transportasi' => $transportasi,
			'rqtr_uang_makan' => $uang_makan,
			'rqtr_jumlah' => $jumlah,
			'rqtr_rekomendasi_development' => $rekomendasi_development,
			'rqtr_jepd_id' => $rqtr_jepd_id,
			'rqtr_bict_id' => $rqtr_bict_id,
			'rqtr_attachment' => serialize($arr_attach),
			'rqtr_entryuser' => $this->_user_info['user_first_name'],
			'rqtr_entrytime' => date('Y-m-d H:i:s'),
		);

		//print_r($data); exit();

		$this->db->insert("request_training", $data);
		$request_training_id = $this->db->insert_id();

		/*
		$this->userid_atasan($this->sess['user_npk_atasan']);
		$arr_userid_atasan = $this->_data_x;

		if(!empty($arr_userid_atasan)) {
			foreach ($arr_userid_atasan as $value) {
				$data = array(
					'trap_rqtr_id' => $request_training_id,
					'trap_user_id' => $value,
					'trap_entryuser' => $this->_user_info['user_first_name'],
					'trap_entrytime' => date('Y-m-d H:i:s'),
				);

				$this->db->insert("request_training_approval", $data);
			}
		}
		*/

		$res = $this->db->where('trdf_jabatan_request = "'.$this->_user_info['jabatan_name'].'"')->get('request_training_default')->row_array();

		if(!empty($res['trdf_jabatan_approval'])) {
			$jabatan_approval = unserialize($res['trdf_jabatan_approval']);
			if(!empty($jabatan_approval)) {
				$next_step_approval = array();

				foreach ($jabatan_approval as $key => $value) {
					$tmp_jabatan = explode(',', $value);
					if(is_array($tmp_jabatan)) {
						foreach ($tmp_jabatan as $value2) {
							$value2 = trim($value2);

							$res = $this->db->select('user_id')->join('jabatan', 'user_jabatan = jabatan_id')->where('jabatan_name = "'.$value2.'" AND user_status = 1')->get('user')->row_array();
							$user_id = !empty($res['user_id']) ? $res['user_id'] : 0;

							$data = array(
								'trap_rqtr_id' => $request_training_id,
								'trap_jabatan' => $value2,
								'trap_user_id' => $user_id,
								'trap_step_order_no' => $key,
								'trap_entryuser' => $this->_user_info['user_first_name'],
								'trap_entrytime' => date('Y-m-d H:i:s'),
							);
							$this->db->insert("request_training_approval", $data);

							if(!empty($user_id)) $next_step_approval[$key][$user_id] = $user_id;
						}
					} else {
						$res = $this->db->select('user_id')->join('jabatan', 'user_jabatan = jabatan_id')->where('jabatan_name = "'.$value.'" AND user_status = 1')->get('user')->row_array();
						$user_id = !empty($res['user_id']) ? $res['user_id'] : 0;

						$data = array(
							'trap_rqtr_id' => $request_training_id,
							'trap_jabatan' => $value,
							'trap_user_id' => $user_id,
							'trap_step_order_no' => $key,
							'trap_entryuser' => $this->_user_info['user_first_name'],
							'trap_entrytime' => date('Y-m-d H:i:s'),
						);
						$this->db->insert("request_training_approval", $data);

						if(!empty($user_id)) $next_step_approval[$key][$user_id] = $user_id;
					}
				}

				if(!empty($next_step_approval[1])) {
					foreach ($next_step_approval[1] as $key => $value) {
						$this->sendmail($request_training_id, $value);
					}
				}
			}
		}

		return true;
	}

	function formtraining_edit($request_id = '') {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$frm = array();
		if(!empty($_POST)) {
			if($this->do_formtraining_edit()) {
				redirect('request/training');
				exit();
			}
			$frm = $_POST;
			$request_id = $_POST['hd_request_id'];
		} else {
			$this->db->select('request_training.*');
			$this->db->from('request_training');
			$this->db->where('rqtr_id = "'.$request_id.'"');
			$frm = $this->db->get()->row_array();
			if(!empty($frm)) {
				list($year, $month, $day) = explode('-', $frm['rqtr_tanggal']);
				$frm['rqtr_tanggal'] = $day . '/' . $month . '/' . $year;
			}
			$frm['rqtr_schedule'] = !empty($frm['rqtr_schedule']) ? unserialize($frm['rqtr_schedule']) : array();
			$frm['rqtr_biaya_lain'] = !empty($frm['rqtr_biaya_lain']) ? unserialize($frm['rqtr_biaya_lain']) : array();
			$frm['rqtr_participant'] = !empty($frm['rqtr_participant']) ? unserialize($frm['rqtr_participant']) : array();
			$frm['rqtr_attachment'] = !empty($frm['rqtr_attachment']) ? unserialize($frm['rqtr_attachment']) : array();

			$frm['rqtr_attachment_alter'] = array();
			$arr_img = array('jpg', 'png', 'gif');

			if(!empty($frm['rqtr_attachment']['userfile'])) {
				foreach ($frm['rqtr_attachment']['userfile'] as $key => $value) {
					$expl = explode('.', $value);
					if(in_array($expl[1], $arr_img)) $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 2;
					else  $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 1;
					$frm['rqtr_attachment_alter'][$key]['file_name'] = $value;
				}
			}

			$frm['participant_detail'] = array();
			if(!empty($frm['rqtr_participant'])) {
				if(is_array($frm['rqtr_participant'])) {
					$tmp = join(',', $frm['rqtr_participant']);
				} else {
					$tmp = $frm['rqtr_participant'];
				}
				
				$res = $this->db->select('user_id, user_npk, user_first_name', false)->where('user_id IN ('.$tmp.') AND user_status = 1')->get('user')->result_array();
				foreach ($res as $key => $value) {
					$frm['participant_detail'][$value['user_id']] = array(
						'id' => $value['user_id'],
						'name' => ($value['user_first_name'] . ' (' . $value['user_npk'] . ')')
					);
				}
			}
		}

		$this->db->select('trap_id, user_first_name, level_group_name, trap_status_approval, trap_reason_approval, trap_step_order_no, jabatan_name');
		$this->db->from('request_training_approval');
		$this->db->join('user', 'trap_user_id = user_id');
		$this->db->join('jabatan', 'user_jabatan = jabatan_id', 'left');
		$this->db->join('level_group', 'jabatan_level_group = level_group_id', 'left');
		$this->db->where('trap_rqtr_id = "'.$request_id.'"');
		$this->db->order_by('trap_step_order_no', 'ASC');
		$res = $this->db->get()->result_array();

		$userid_approval = array();
		foreach ($res as $key => $value) {
			if(!empty($userid_approval[$value['trap_step_order_no']]['trap_status_approval']) AND $userid_approval[$value['trap_step_order_no']]['trap_status_approval'] == 1) continue;
			$userid_approval[$value['trap_step_order_no']] = $value;
		}

		if(!empty($this->_error_form)) $this->_error_form = join(', ', $this->_error_form);

		$data_jenispendidikan = $this->db->get('request_jenis_pendidikan')->result_array();
		$data_bicategory = $this->db->get('request_bi_category')->result_array();

		$this->mysmarty->assign("user_type", $this->sess['user_type']);
		$this->mysmarty->assign("data_jenispendidikan", $data_jenispendidikan);
		$this->mysmarty->assign("data_bicategory", $data_bicategory);
		$this->mysmarty->assign("frm", $frm);
		$this->mysmarty->assign("hd_request_id", $request_id);
		$this->mysmarty->assign("error_form", $this->_error_form);
		$this->mysmarty->assign("userid_approval", $userid_approval);
		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/form_edit.html");
		$this->mysmarty->display("sess_template.html");
	}

	function do_formtraining_edit() {
		$request_id = $_POST['hd_request_id'];

		$training_type = $_POST['training_type'];
		$penyelenggara = $_POST['penyelenggara'];
		$tema = $_POST['tema'];
		$judul = $_POST['judul'];
		$request_schedule = $_POST['request_schedule'];
		$biaya_lain = $_POST['biaya_lain'];
		$user_selected = $_POST['user_selected'];
		$tempat = $_POST['tempat'];
		$pembicara = $_POST['pembicara'];
		$tujuan_pelatihan = $_POST['tujuan_pelatihan'];
		$rekomendasi_supervisor = $_POST['rekomendasi_supervisor'];
		$biaya_program = $_POST['biaya_program'];
		$akomodasi = $_POST['akomodasi'];
		$transportasi = $_POST['transportasi'];
		$uang_makan = $_POST['uang_makan'];
		$rekomendasi_development = $_POST['rekomendasi_development'];
		$rqtr_jepd_id = !empty($_POST['rqtr_jepd_id']) ? $_POST['rqtr_jepd_id'] : '';
		$rqtr_bict_id = !empty($_POST['rqtr_bict_id']) ? $_POST['rqtr_bict_id'] : '';
		$userfile_exists = $_POST['userfile_exists'];
		$rqtr_request_code = $_POST['rqtr_request_code'];
		
		if(empty($training_type)) $this->_error_form[] = 'Training Type';
		if(empty($penyelenggara)) $this->_error_form[] = 'Penyelenggara';
		if(empty($tema)) $this->_error_form[] = 'Tema';
		if(empty($judul)) $this->_error_form[] = 'Judul';
		if(empty($tempat)) $this->_error_form[] = 'Tempat';
		if(empty($pembicara)) $this->_error_form[] = 'Pembicara';
		if(empty($tujuan_pelatihan)) $this->_error_form[] = 'Tujuan Pelatihan';
		//if(empty($rekomendasi_supervisor)) $this->_error_form[] = 'Rekomendasi Supervisor';
		//if(empty($biaya_program)) $this->_error_form[] = 'Biaya Program';
		//if(empty($akomodasi)) $this->_error_form[] = 'Akomodasi';
		//if(empty($transportasi)) $this->_error_form[] = 'Transportasi';
		//if(empty($uang_makan)) $this->_error_form[] = 'Uang Makan';
		//if(empty($rekomendasi_development)) $this->_error_form[] = 'Rekomendasi Development';
		//if(empty($rqtr_jepd_id)) $this->_error_form[] = 'Jenis Pendidikan';
		//if(empty($rqtr_bict_id)) $this->_error_form[] = 'BI Category';

		if(!empty($this->_error_form)) return false;

		$this->load->library('upload');

		$arr_attach = array();
		$start_user_file = 0;

		if(!empty($userfile_exists)) {
			foreach ($userfile_exists as $value) {
				$arr_attach['userfile'][$start_user_file] = $value;
				$start_user_file++;
			}
		}

	    $files = $_FILES;
	    if(!empty($files)) {
		    $cpt = count($_FILES['userfile']['name']);
		    for($i=0; $i<$cpt; $i++)
		    {           
		        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
		        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
		        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
		        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
		        $_FILES['userfile']['size']= $files['userfile']['size'][$i];

		        if ($_FILES['userfile']['name'] == '') continue;

		        $this->upload->initialize($this->set_upload_options());
		        $this->upload->do_upload();

		        $file_array = $this->upload->data();
		        $next_idx = $i + $start_user_file;
		        $arr_attach['userfile'][$next_idx] = $file_array['file_name'];
		    }
		}

		$biaya_program = str_replace('.', '', $biaya_program);
		$akomodasi = str_replace('.', '', $akomodasi);
		$transportasi = str_replace('.', '', $transportasi);
		$uang_makan = str_replace('.', '', $uang_makan);

		$jumlah = $biaya_program + $akomodasi + $transportasi + $uang_makan;
		if(!empty($biaya_lain['nama_biaya'])) {
			foreach ($biaya_lain['nama_biaya'] as $key => $value) {
				$biaya_lain['jumlah_biaya'][$key] = str_replace('.', '', $biaya_lain['jumlah_biaya'][$key]);
				$jumlah += $biaya_lain['jumlah_biaya'][$key];
			}
		}

		$data = array(
			'rqtr_request_code' => $rqtr_request_code,
			'rqtr_type' => $training_type,
			'rqtr_penyelenggara' => $penyelenggara,
			'rqtr_tema' => $tema,
			'rqtr_judul' => $judul,
			'rqtr_schedule' => !empty($request_schedule) ? serialize($request_schedule) : '',
			'rqtr_biaya_lain' => !empty($biaya_lain) ? serialize($biaya_lain) : '',
			'rqtr_participant' => !empty($user_selected) ? serialize($user_selected) : '',
			'rqtr_tempat' => $tempat,
			'rqtr_pembicara' => $pembicara,
			'rqtr_tujuan_pelatihan' => $tujuan_pelatihan,
			'rqtr_rekomendasi_supervisor' => $rekomendasi_supervisor,
			'rqtr_biaya_program' => $biaya_program,
			'rqtr_akomodasi' => $akomodasi,
			'rqtr_transportasi' => $transportasi,
			'rqtr_uang_makan' => $uang_makan,
			'rqtr_jumlah' => $jumlah,
			'rqtr_rekomendasi_development' => $rekomendasi_development,
			'rqtr_jepd_id' => $rqtr_jepd_id,
			'rqtr_bict_id' => $rqtr_bict_id,
			'rqtr_attachment' => serialize($arr_attach),
			'rqtr_updateuser' => $this->_user_info['user_first_name'],
			'rqtr_updatetime' => date('Y-m-d H:i:s'),
		);

		$this->db->where('rqtr_id = "'.$request_id.'"')->update("request_training", $data);
		return true;
	}

	private function userid_atasan($user_npk_atasan, $limit = 3) {
		if(empty($limit)) return true;

		if(!empty($user_npk_atasan)) {
			$this->db->where("user_npk", $user_npk_atasan );
			$res = $this->db->get("user")->row_array();

			if(empty($res)) return true;
			if(in_array($res['user_id'], $this->_data_x)) return true;

			$this->_data_x[$res['user_id']] = $res['user_id'];

			if(!empty($res['user_npk_atasan'])) $this->userid_atasan($res['user_npk_atasan'], ($limit-1));
		}

		return true;
	}

	function approval() {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		$arr_training_type = array(
			1 => 'Pelatihan Inhouse',
			2 => 'Pelatihan Eksternal',
			3 => 'On The Job Training',
		);

		$arr_jenis_pendidikan = array(
			1 => 'Technical Skill / Soft Skill',
			2 => 'BI Category',
		);

		$arr_status_approval = array(
			0 => 'Waiting',
			1 => 'Onprogress',
			2 => 'Approved',
			3 => 'rejected',
		);

		$this->db->select('trap_rqtr_id');
		$this->db->from('request_training_approval');

		if($this->sess['user_type'] > 0) $this->db->where('trap_user_id = "'.$this->sess['user_id'].'"');

		$list = $this->db->get()->result_array();
		$arr_rqtr_id = array();
		foreach ($list as $value) {
			$arr_rqtr_id[] = $value['trap_rqtr_id'];
		}

		$list = array();
		if(!empty($arr_rqtr_id)) {

			$recordperpage = $this->commonmodel->getRecordPerPage();
		
			$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
			$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;		
			$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "rqtr_judul";
			$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
			$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
			$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		

			if(!empty($_POST["_searchby"])) {
				$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
			}

			//print_r($_POST); exit();
			
			$sess = unserialize($usess);

			if (! isset($this->modules['master']))
			{
				//redirect(base_url());
			}
			
			if ($searchby AND !empty($keyword))
			{
				if ($searchby == "rqtr_judul")
				{	
					$this->db->where("rqtr_judul LIKE", '%'.strtoupper($keyword).'%');
				}

				if ($searchby == "rqtr_request_no")
				{	
					$this->db->where("rqtr_request_no ='".$keyword."'");
				}

				if ($searchby == "rqtr_request_code")
				{	
					$this->db->where("rqtr_request_code ='".$keyword."'");
				}

				if ($searchby == "status")
				{	
					$keywordx = $keyword - 1;
					$this->db->where("rqtr_status_approval = '".$keywordx."'");
				}
			}

			$this->db->where('rqtr_id IN ('.join(',', $arr_rqtr_id).')');
				
			$this->db->order_by($sortby, $orderby);
			
			if ($limit)
			{
				$this->db->limit($limit, $offset);
			}

			$this->db->select('request_training.*, DATE_FORMAT(rqtr_entrytime, "%d-%m-%Y") as tgl', false);
			$this->db->from('request_training');
			$list = $this->db->get()->result_array();

			if ($searchby AND !empty($keyword))
			{
				if ($searchby == "rqtr_judul")
				{	
					$this->db->where("rqtr_judul LIKE", '%'.strtoupper($keyword).'%');
				}

				if ($searchby == "rqtr_request_no")
				{	
					$this->db->where("rqtr_request_no ='".$keyword."'");
				}

				if ($searchby == "rqtr_request_code")
				{	
					$this->db->where("rqtr_request_code ='".$keyword."'");
				}

				if ($searchby == "status")
				{	
					$keywordx = $keyword - 1;
					$this->db->where("rqtr_status_approval = '".$keywordx."'");
				}
			}

			$this->db->where('rqtr_id IN ('.join(',', $arr_rqtr_id).')');
			
			$total = $this->db->count_all_results("request_training");

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
		}

		$this->mysmarty->assign("limit", $limit);		
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_category_jabatan", $this->config->item('lheader_list_category_jabatan'));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lcategory_jabatan_list", ucfirst($this->config->item('lcategory_jabatan_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		
		$this->mysmarty->assign("lsort_by_category_name", $this->config->item('lsort_by_category_name'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));

		$this->mysmarty->assign("list", $list);

		$this->mysmarty->assign("arr_training_type", $arr_training_type);
		$this->mysmarty->assign("arr_jenis_pendidikan", $arr_jenis_pendidikan);
		$this->mysmarty->assign("arr_status_approval", $arr_status_approval);
		$this->mysmarty->assign("user_type", $this->sess['user_type']);

		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/list_approval.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formtraining_edit_approval($request_id = '') {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		if(!empty($_POST)) $request_id = $_POST['hd_request_id'];

		if($this->sess['user_type'] > 0) {
			$this->db->select('trap_rqtr_id');
			$this->db->from('request_training_approval');
			$this->db->where('trap_user_id = "'.$this->sess['user_id'].'" AND trap_rqtr_id = "'.$request_id.'"');
			$res = $this->db->get()->row_array();

			if(empty($res)) {
				redirect('request/training');
				exit();
			}
		}

		$frm = array();
		if(!empty($_POST)) {
			if($this->do_formtraining_edit_approval()) {
				redirect('request/approval');
				exit();
			}
			$frm = $_POST;

			$this->db->select('request_training.*');
			$this->db->from('request_training');
			$this->db->where('rqtr_id = "'.$request_id.'"');
			$frm_attachment = $this->db->get()->row_array();

			$frm_attachment['rqtr_attachment'] = !empty($frm_attachment['rqtr_attachment']) ? unserialize($frm_attachment['rqtr_attachment']) : array();

			$frm['rqtr_attachment_alter'] = array();
			$arr_img = array('jpg', 'png', 'gif');

			if(!empty($frm_attachment['rqtr_attachment']['userfile'])) {
				foreach ($frm_attachment['rqtr_attachment']['userfile'] as $key => $value) {
					$expl = explode('.', $value);
					if(in_array($expl[1], $arr_img)) $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 2;
					else  $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 1;
					$frm['rqtr_attachment_alter'][$key]['file_name'] = $value;
				}
			}

			$request_id = $_POST['hd_request_id'];
		} else {
			$this->db->select('request_training.*');
			$this->db->from('request_training');
			$this->db->where('rqtr_id = "'.$request_id.'"');
			$frm = $this->db->get()->row_array();

			$frm['rqtr_attachment'] = !empty($frm['rqtr_attachment']) ? unserialize($frm['rqtr_attachment']) : array();

			$frm['rqtr_attachment_alter'] = array();
			$arr_img = array('jpg', 'png', 'gif');

			if(!empty($frm['rqtr_attachment']['userfile'])) {
				foreach ($frm['rqtr_attachment']['userfile'] as $key => $value) {
					$expl = explode('.', $value);
					if(in_array($expl[1], $arr_img)) $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 2;
					else  $frm['rqtr_attachment_alter'][$key]['is_pdf'] = 1;
					$frm['rqtr_attachment_alter'][$key]['file_name'] = $value;
				}
			}
		}

		$this->db->select('trap_id, trap_user_id, user_first_name, level_group_name, trap_status_approval, trap_reason_approval, trap_step_order_no, jabatan_name');
		$this->db->from('request_training_approval');
		$this->db->join('user', 'trap_user_id = user_id');
		$this->db->join('jabatan', 'user_jabatan = jabatan_id', 'left');
		$this->db->join('level_group', 'jabatan_level_group = level_group_id', 'left');
		$this->db->where('trap_rqtr_id = "'.$request_id.'"');
		$this->db->order_by('trap_step_order_no', 'ASC');
		$userid_approval = $this->db->get()->result_array();

		$status_urut_approve = array();
		foreach ($userid_approval as $key => $value) {
			if(!empty($value['trap_status_approval'])) {
				$status_urut_approve[$value['trap_step_order_no']] = 1;
			}
		}

		foreach ($userid_approval as $key => $value) {
			if($value['trap_user_id'] == $this->sess['user_id']) {
				/*
				if(empty($key) AND empty($value['trap_status_approval'])) {
					$userid_approval[$key]['can_approve'] = 1;
					break;
				}

				if(!empty($key) AND !empty($userid_approval[($key-1)]['trap_status_approval']) AND empty($value['trap_status_approval'])) {
					$userid_approval[$key]['can_approve'] = 1;
					break;
				}
				*/
				$urt_bfr = $value['trap_step_order_no'] - 1;
				if(empty($urt_bfr) OR !empty($status_urut_approve[$urt_bfr])) {
					$userid_approval[$key]['can_approve'] = 1;
					break;
				}
			}
		}

		if(!empty($this->_error_form)) $this->_error_form = join(', ', $this->_error_form);

		$frm['rqtr_schedule'] = !empty($frm['rqtr_schedule']) ? unserialize($frm['rqtr_schedule']) : array();
		$frm['rqtr_biaya_lain'] = !empty($frm['rqtr_biaya_lain']) ? unserialize($frm['rqtr_biaya_lain']) : array();
		$frm['rqtr_participant'] = !empty($frm['rqtr_participant']) ? unserialize($frm['rqtr_participant']) : array();

		$frm['participant_detail'] = array();
		if(!empty($frm['rqtr_participant'])) {
			$tmp = join(',', $frm['rqtr_participant']);
			$res = $this->db->select('user_id, user_npk, user_first_name', false)->where('user_id IN ('.$tmp.') AND user_status = 1')->get('user')->result_array();
			foreach ($res as $key => $value) {
				$frm['participant_detail'][$value['user_id']] = array(
					'id' => $value['user_id'],
					'name' => ($value['user_first_name'] . ' (' . $value['user_npk'] . ')')
				);
			}
		}

		$data_jenispendidikan = $this->db->get('request_jenis_pendidikan')->result_array();
		$data_bicategory = $this->db->get('request_bi_category')->result_array();

		$this->mysmarty->assign("user_type", $this->sess['user_type']);
		$this->mysmarty->assign("data_jenispendidikan", $data_jenispendidikan);
		$this->mysmarty->assign("data_bicategory", $data_bicategory);
		$this->mysmarty->assign("frm", $frm);
		$this->mysmarty->assign("hd_request_id", $request_id);
		$this->mysmarty->assign("error_form", $this->_error_form);
		$this->mysmarty->assign("userid_approval", $userid_approval);
		$this->mysmarty->assign("can_approve", $can_approve);
		$this->mysmarty->assign("user_id", $this->sess['user_id']);
		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/form_edit_approval.html");
		$this->mysmarty->display("sess_template.html");
	}

	function do_formtraining_edit_approval() {
		$this->logmodel->init("notification_request_approval");
		
		$request_id = $_POST['hd_request_id'];

		if($this->sess['user_type'] > 0) {
			if(!empty($_POST['status_approval'])) {
				$data = array(
					'trap_status_approval' => $_POST['status_approval'],
					'trap_reason_approval' => (!empty($_POST['trap_reason_approval']) ? $_POST['trap_reason_approval'] : ''),
					'trap_updateuser' => $this->_user_info['user_first_name'],
					'trap_updatetime' => date('Y-m-d H:i:s'),
				);
			} else {
				$data = array(
					'trap_reason_approval' => (!empty($_POST['trap_reason_approval']) ? $_POST['trap_reason_approval'] : ''),
					'trap_updateuser' => $this->_user_info['user_first_name'],
					'trap_updatetime' => date('Y-m-d H:i:s'),
				);
			}
			$this->db->where('trap_rqtr_id = "'.$request_id.'" AND trap_user_id = "'.$this->sess['user_id'].'"')->update("request_training_approval", $data);
		}

		//------------do proses change approval status---------------
		$this->db->select('trap_status_approval, trap_step_order_no, trap_user_id');
		$this->db->from('request_training_approval');
		$this->db->where('trap_rqtr_id = "'.$request_id.'"');
		$this->db->order_by('trap_step_order_no', 'DESC');
		$res = $this->db->get()->result_array();

		if(!empty($res)) {
			$data = array(
				'rqtr_updateuser' => $this->_user_info['user_first_name'],
				'rqtr_updatetime' => date('Y-m-d H:i:s'),
			);

			if($this->sess['user_type'] > 0) {
				$first = true;
				$last_trap_step_order_no = 0;
				$cnt = 0;
				foreach ($res as $value) {
					if($first) {
						$last_trap_step_order_no = $value['trap_step_order_no'];
						$first = false;
					}

					if(!empty($value['trap_status_approval']) AND $value['trap_status_approval'] == 2) {
						$data['rqtr_status_approval'] = 3; //rejected all
						break;
					}

					if($last_trap_step_order_no == $value['trap_step_order_no'] AND (!empty($value['trap_status_approval']) AND $value['trap_status_approval'] == 1)) {
						$data['rqtr_status_approval'] = 2; //approved all
					}

					if(!empty($value['trap_status_approval'])) $cnt += 1;
				}

				if(empty($data['rqtr_status_approval'])) {
					if(empty($cnt)) {
						$data['rqtr_status_approval'] = 0;
					} else {
						$data['rqtr_status_approval'] = 1;
					}
				}

				$data['rqtr_rekomendasi_supervisor'] = !empty($_POST['rekomendasi_supervisor']) ? $_POST['rekomendasi_supervisor'] : '';
				$data['rqtr_rekomendasi_development'] = !empty($_POST['rekomendasi_development']) ? $_POST['rekomendasi_development'] : '';

				$this->db->where('rqtr_id = "'.$request_id.'" AND rqtr_status_approval != 2')->update("request_training", $data);

				if(!empty($_POST['status_approval']) AND $_POST['status_approval'] == 1) {
					$res = $this->db->where('trap_user_id = "'.$this->sess['user_id'].'"')->order_by('trap_step_order_no')->get('request_training_approval')->row_array();
					if(!empty($res)) {
						$res = $this->db->where('trap_step_order_no > '.$res['trap_step_order_no'])->order_by('trap_step_order_no')->get('request_training_approval')->result_array();
						$next_step_approval = array();
						$next_step = 0;
						if(!empty($res)) {
							foreach ($res as $key => $value) {
								if(empty($next_step_approval) OR !empty($next_step_approval[$value['trap_step_order_no']])) {
									$next_step_approval[$value['trap_step_order_no']][$value['trap_user_id']] = $value['trap_user_id'];
									$next_step = $value['trap_step_order_no'];
								}
							}
						}

						if(!empty($next_step_approval[$next_step])) {
							foreach ($next_step_approval[$next_step] as $key => $value) {
								$this->sendmail($request_id, $value);
							}
						}
					}
				}
			} else {
				if(!empty($_POST['rqtr_status_admin_approval'])) {
					$data = array(
						'rqtr_status_admin_approval' => 1,
						'rqtr_reason_admin_approval' => (!empty($_POST['rqtr_reason_admin_approval']) ? $_POST['rqtr_reason_admin_approval'] : ''),
						'rqtr_status_approval' => 2,
						'rqtr_updateuser' => $this->_user_info['user_first_name'],
						'rqtr_updatetime' => date('Y-m-d H:i:s'),
						'rqtr_rekomendasi_supervisor' => (!empty($_POST['rekomendasi_supervisor']) ? $_POST['rekomendasi_supervisor'] : ''),
						'rqtr_rekomendasi_development' => (!empty($_POST['rekomendasi_development']) ? $_POST['rekomendasi_development'] : ''),
					);
				} else {
					$data = array(
						'rqtr_reason_admin_approval' => (!empty($_POST['rqtr_reason_admin_approval']) ? $_POST['rqtr_reason_admin_approval'] : ''),
						'rqtr_updateuser' => $this->_user_info['user_first_name'],
						'rqtr_updatetime' => date('Y-m-d H:i:s'),
						'rqtr_rekomendasi_supervisor' => (!empty($_POST['rekomendasi_supervisor']) ? $_POST['rekomendasi_supervisor'] : ''),
						'rqtr_rekomendasi_development' => (!empty($_POST['rekomendasi_development']) ? $_POST['rekomendasi_development'] : ''),
					);
				}
				$this->db->where('rqtr_id = "'.$request_id.'" AND rqtr_status_approval != 2')->update("request_training", $data);
			}
		}

		return true;
	}

	function do_search_user() {
		$status = array(
			'err_msg' => '',
		);

		if(empty($_POST['user_keyword']) AND empty($_POST['extra_option'])) {
			$status['err_msg'] = 'User keyword is empty';
			echo json_encode($status);
		}

		$extra_option = $_POST['extra_option'];
		$user_keyword = $_POST['user_keyword'];

		//$res = $this->db->join('jabatan', 'user_jabatan=jabatan_id', 'LEFT')->join('level_group', 'jabatan_level_group=level_group_id', 'LEFT')->where('user_status = 1 AND (user_first_name LIKE "%'.$user_keyword.'%" OR user_npk LIKE "%'.$user_keyword.'%" OR jabatan_name LIKE "%'.$user_keyword.'%" OR level_group_name LIKE "%'.$user_keyword.'%")')->order_by('user_first_name', 'ASC')->get('user')->result_array();

		$condition = 'user_status = 1';
		if(!empty($extra_option)) $condition .= ' AND jabatan_name = "'.$extra_option.'"';
		if(!empty($user_keyword)) $condition .= ' AND (user_first_name LIKE "%'.$user_keyword.'%" OR user_npk LIKE "%'.$user_keyword.'%")';

		$res = $this->db->from('user')->join('jabatan', 'user_jabatan=jabatan_id', 'LEFT')->join('level_group', 'jabatan_level_group=level_group_id', 'LEFT')->where($condition)->order_by('user_first_name', 'ASC')->get()->result_array();

		//echo $this->db->last_query();

		foreach ($res as $key => $value) {
			$status['detail'][] = array(
				'id' => $value['user_id'],
				'label' => $value['user_first_name'] . ' (NPK: ' . $value['user_npk'] . ', Jabatan: ' . $value['jabatan_name'] . ')'
			);
		}

		echo json_encode($status);
	}

	function formtraining_edit_setting($request_id = '') {
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}

		//-------only superadmin can entry this page--------
		if($this->sess['user_id'] != 1) die("Oops.. you can't access this page");

		$frm = array();
		if(!empty($_POST)) {
			if($this->do_formtraining_edit_setting()) {
				redirect('request/training');
				exit();
			}
			$frm = $_POST;
			$request_id = $_POST['hd_request_id'];
		} else {
			$this->db->select('*');
			$this->db->from('request_training_approval');
			$this->db->join('request_training', 'rqtr_id=trap_rqtr_id');
			$this->db->where('trap_rqtr_id = "'.$request_id.'"');
			$this->db->order_by('trap_step_order_no');
			$res = $this->db->get()->result_array();

			foreach ($res as $key => $value) {
				$frm['trse_user_step_approval'][$value['trap_step_order_no']][] = $value['trap_user_id'];
				$frm['jabatan_approval'][$value['trap_step_order_no']][] = $value['trap_jabatan'];
				$frm['rqtr_request_no'] = $value['rqtr_request_no'];
			}

			$frm['total_step_approval'] = !empty($frm['trse_user_step_approval']) ? count($frm['trse_user_step_approval']) : 1;

			foreach($frm['trse_user_step_approval'] as $kMain => $vMain) {
				$arr_detail = array();
				if(!empty($vMain)) {
					$tmp = join(',', $vMain);
					$res = $this->db->select('user_id, user_npk, user_first_name, jabatan_name', false)->join('jabatan', 'user_jabatan=jabatan_id', 'LEFT')->join('level_group', 'jabatan_level_group=level_group_id', 'LEFT')->where('user_id IN ('.$tmp.') AND user_status = 1')->get('user')->result_array();
					foreach ($res as $key => $value) {
						$arr_detail[$value['user_id']] = array(
							'id' => $value['user_id'],
							'name' => ($value['user_first_name'] . ' (NPK: ' . $value['user_npk'] . ', Jabatan: ' . $value['jabatan_name'] . ')')
						);
					}
				}
				$frm['hd_step_approval'][$kMain]['detail'] = $arr_detail;
				$frm['hd_step_approval'][$kMain]['jabatan'] = !empty($frm['jabatan_approval'][$kMain]) ? join(', ', $frm['jabatan_approval'][$kMain]) : '';
			}

			if(empty($frm['hd_step_approval'])) {
				$frm['hd_step_approval'][1]['detail'] = array();
			}
		}

		if(!empty($this->_error_form)) $this->_error_form = join(', ', $this->_error_form);

		$extra_option_approval = $this->db->select('jabatan_id,jabatan_name')->group_by('jabatan_name')->order_by('jabatan_name')->get("jabatan")->result_array();
		$this->mysmarty->assign("extra_option_approval", $extra_option_approval);

		$flash_msg = $this->session->flashdata('flash_msg');

		if(!empty($flash_msg)) $this->mysmarty->assign("flash_msg", $flash_msg);

		$this->mysmarty->assign("frm", $frm);
		$this->mysmarty->assign("hd_request_id", $request_id);
		$this->mysmarty->assign("error_form", $this->_error_form);
		$this->mysmarty->assign("userid_approval", $userid_approval);
		$this->mysmarty->assign("left_content", "request/menu.html");
		$this->mysmarty->assign("main_content", "request/form_edit_setting.html");
		$this->mysmarty->display("sess_template.html");
	}

	function do_formtraining_edit_setting() {
		$request_id = $_POST['hd_request_id'];

		//--------delete request_training_approval first--------
		//$this->db->where('trap_rqtr_id = "'.$request_id.'"')->delete("request_training_approval");
		
		$total_user_approval = 0;
		$list_user_approval = array();

		if(!empty($_POST['hd_step_approval'])) {
			$tmp = $this->db->where('rqtr_id = "'.$request_id.'" AND rqtr_status_approval = "2"')->get('request_training')->row_array();
			if(!empty($tmp)) {
				$this->session->set_flashdata('flash_msg', 'request training sudah di-approved, update data tidak diizinkan');
				redirect('request/formtraining_edit_setting/'.$request_id);
				exit();
			}

			if(!empty($_POST['btn_sendemail'])) {
				$res = $this->db->select('trap_step_order_no')->where('trap_rqtr_id = "'.$request_id.'" AND trap_status_approval = 0')->order_by('trap_step_order_no')->get('request_training_approval')->row_array();
				if(!empty($res['trap_step_order_no']))
				{
					$res = $this->db->select('trap_user_id')->where('trap_rqtr_id = "'.$request_id.'" AND trap_step_order_no = "'.$res['trap_step_order_no'].'"')->get('request_training_approval')->result_array();
					if(!empty($res)) {
						foreach ($res as $key => $value) {
							$this->sendmail($request_id, $value['trap_user_id']);
						}
						$this->session->set_flashdata('flash_msg', 'Email approval sudah terkirim');
						redirect('request/formtraining_edit_setting/'.$request_id);
						exit();
					}
				}
			}

			$tmp = $this->db->where('trap_rqtr_id = "'.$request_id.'"')->get('request_training_approval')->result_array();
			$list_approval = array();
			$list_user = array();
			foreach ($tmp as $key => $value) {
				$list_approval[$value['trap_step_order_no']][$value['trap_user_id']] = 1;
				$list_user[$value['trap_user_id']] = $value['trap_user_id'];
			}

			foreach ($_POST['hd_step_approval'] as $kMain => $vMain) {
				$no_urut = $kMain+1;
				$lbl = 'user_approval_request_training_'.$no_urut;
				$data_user_step_approval['info'][$no_urut] = !empty($_POST[$lbl]) ? $_POST[$lbl] : '';
				$user_approval_request_training = array();
				if(!empty($_POST[$lbl])) {
					$user_approval_request_training = $_POST[$lbl];
					foreach ($user_approval_request_training as $key => $value) {
						if(!empty($list_user[$value]) AND !empty($list_approval[$no_urut][$value])) unset($list_user[$value]); //sisa user approval yang di-delete
						if(in_array($value, $list_user_approval)) continue; //biar tidak ada yang berulang
						$list_user_approval[] = $value;

						$tmp = $this->db->select('jabatan_name')->where('user_id = "'.$value.'"')->join('jabatan', 'user_jabatan = jabatan_id')->get('user')->row_array();
						$trap_jabatan = !empty($tmp['jabatan_name']) ? $tmp['jabatan_name'] : '';

						if(empty($list_approval[$no_urut][$value])) {
							$data_user_step_approval['user'][$no_urut][] = $data = array(
								'trap_rqtr_id' => $request_id,
								'trap_jabatan' => $trap_jabatan,
								'trap_user_id' => $value,
								'trap_step_order_no' => $no_urut,
								'trap_entryuser' => $this->_user_info['user_first_name'],
								'trap_entrytime' => date('Y-m-d H:i:s'),
							);

							$this->db->insert("request_training_approval", $data);
						}

						$total_user_approval++;
					}
				}
			}

			if(!empty($list_user)) {
				$this->db->where('trap_rqtr_id = "'.$request_id.'" AND trap_user_id IN ('.join(',', $list_user).')')->delete("request_training_approval");
			}
		}

		/*
		$data = array(
			'rqtr_status_admin_approval' => 0,
			'rqtr_reason_admin_approval' => '',
			'rqtr_status_approval' => 0,
			'rqtr_updateuser' => $this->_user_info['user_first_name'],
			'rqtr_updatetime' => date('Y-m-d H:i:s'),
		);

		$this->db->where('rqtr_id = "'.$request_id.'"')->update("request_training", $data);
		*/

		return true;
	}

	private function set_upload_options()
	{   
	    //upload an image options
	    $config = array();
	    $config['upload_path'] = 'uploads/request_training/';
	    $config['allowed_types'] = 'pdf|gif|jpg|png';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $config['encrypt_name']     = true;

	    return $config;
	}

	function jenispendidikan()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "jepd_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		

		if(!empty($_POST["_searchby"])) {
			$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
		}

		//print_r($_POST); exit();
		
		$sess = unserialize($usess);

		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
		
		if ($searchby)
		{
			if ($searchby == "jepd_name")
			{	
				$this->db->where("jepd_name LIKE", '%'.strtoupper($keyword).'%');
			}
		}
			
		$this->db->order_by($sortby, $orderby);
		
		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}
		
		$this->db->select("*, DATE_FORMAT( FROM_UNIXTIME( jepd_entrydate ) ,  '%d-%m-%Y' ) AS tanggal", false);

		$q = $this->db->get("request_jenis_pendidikan");
		$list = $q->result();
		
		if (isset($newsids))
		{
			$this->db->where_in("jepd_id", $newsids);
		}
		
		if ($searchby)
		{
			if ($searchby == "jepd_name")
			{	
				$this->db->where("jepd_name LIKE", '%'.strtoupper($keyword).'%');
			}
		}
		$total = $this->db->count_all_results("request_jenis_pendidikan");
		
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
		$this->pagination1->lang_title = $this->config->item('lrequest_jenis_pendidikan');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;
		
		$this->mysmarty->assign("limit", $limit);		
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));

		$this->mysmarty->assign("list", $list);
		
		$this->mysmarty->assign("left_content", "request/menu.html");		
		$this->mysmarty->assign("main_content", "request/list_jenispendidikan.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formjenispendidikan($edit=0)
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		if ($edit)
		{
			$this->db->where("jepd_id", $edit);
			$q = $this->db->get("request_jenis_pendidikan");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("jenispendidikanedit", $row);

			$ltitle_form = 'Edit Jenis Pendidikan';
		
		}
		else
		{
			$ltitle_form = 'Add Jenis Pendidikan';
		}		

		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("left_content", "request/menu.html");		
		$this->mysmarty->assign("main_content", "request/formjenispendidikan.html");
		$this->mysmarty->display("sess_template.html");	
	}

	function savejenispendidikan($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$jepd_name = isset($_POST['jepd_name']) ? trim($_POST['jepd_name']) : "";		
		
		$errs = array();
		if (strlen($jepd_name) == 0)
		{
			$errs[] = 'Name harus diisi';
		}
		else
		{
			$this->db->where("jepd_name", addslashes($jepd_name));
			$q = $this->db->get("request_jenis_pendidikan");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->jepd_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
				}				
			}
			
		}
		
		//echo count($errs);
		//echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}		

		unset($data);	
		
		$data['jepd_name'] = addslashes($jepd_name);

		if ($edit)
		{						
			$this->db->flush_cache();
			$this->db->where("jepd_id", $edit);

			$data['jepd_changedate'] = date('Y-m-d H:i:s');
			$data['jepd_changeuser'] = $this->sess['user_id'];
			
			$this->db->update("request_jenis_pendidikan", $data);
		}
		else
		{			
			$data['jepd_entrydate'] = date('Y-m-d H:i:s');
			$data['jepd_entryuser'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("request_jenis_pendidikan", $data);
		}

		$rdct = base_url() . 'index.php/request/jenispendidikan';
		redirect($rdct);
		exit();
	}

	function deletejenispendidikan($id)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$childs = array($id);
		
		$this->db->where_in("jepd_id", $childs);
		$this->db->delete("request_jenis_pendidikan");

		redirect(site_url(array("request", "jenispendidikan")));
	}

	function checkadmin($redirect=true)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			if ($redirect)
			{
				redirect(base_url());
				return false;
			}
		}
		
		$this->sess = unserialize($usess);		
		return true;
	}

	function bicategory()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;		
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "bict_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		

		if(!empty($_POST["_searchby"])) {
			$searchby = isset($_POST["_searchby"]) ? $_POST["_searchby"] : "";
		}

		//print_r($_POST); exit();
		
		$sess = unserialize($usess);

		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
		
		if ($searchby)
		{
			if ($searchby == "bict_name")
			{	
				$this->db->where("bict_name LIKE", '%'.strtoupper($keyword).'%');
			}
		}
			
		$this->db->order_by($sortby, $orderby);
		
		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}
		
		$this->db->select("*, DATE_FORMAT( FROM_UNIXTIME( bict_entrydate ) ,  '%d-%m-%Y' ) AS tanggal", false);

		$q = $this->db->get("request_bi_category");
		$list = $q->result();
		
		if (isset($newsids))
		{
			$this->db->where_in("bict_id", $newsids);
		}
		
		if ($searchby)
		{
			if ($searchby == "bict_name")
			{	
				$this->db->where("bict_name LIKE", '%'.strtoupper($keyword).'%');
			}
		}
		$total = $this->db->count_all_results("request_bi_category");
		
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
		$this->pagination1->lang_title = $this->config->item('lrequest_bi_category');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;
		
		$this->mysmarty->assign("limit", $limit);		
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));

		$this->mysmarty->assign("list", $list);
		
		$this->mysmarty->assign("left_content", "request/menu.html");		
		$this->mysmarty->assign("main_content", "request/list_bicategory.html");
		$this->mysmarty->display("sess_template.html");
	}

	function formbicategory($edit=0)
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		if ($edit)
		{
			$this->db->where("bict_id", $edit);
			$q = $this->db->get("request_bi_category");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("bicategoryedit", $row);

			$ltitle_form = 'Edit BI Category';
		
		}
		else
		{
			$ltitle_form = 'Add BI Category';
		}		

		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("left_content", "request/menu.html");		
		$this->mysmarty->assign("main_content", "request/formbicategory.html");
		$this->mysmarty->display("sess_template.html");	
	}

	function savebicategory($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$bict_name = isset($_POST['bict_name']) ? trim($_POST['bict_name']) : "";		
		
		$errs = array();
		if (strlen($bict_name) == 0)
		{
			$errs[] = 'Name harus diisi';
		}
		else
		{
			$this->db->where("bict_name", addslashes($bict_name));
			$q = $this->db->get("request_bi_category");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->bict_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
				}				
			}
			
		}
		
		//echo count($errs);
		//echo "\1";
		
		if (count($errs) > 0)
		{
			$this->mysmarty->assign("errs", $errs);
			$this->mysmarty->display("errmessage.html");
			
			return;
		}		

		unset($data);	
		
		$data['bict_name'] = addslashes($bict_name);

		if ($edit)
		{						
			$this->db->flush_cache();
			$this->db->where("bict_id", $edit);

			$data['bict_changedate'] = date('Y-m-d H:i:s');
			$data['bict_changeuser'] = $this->sess['user_id'];
			
			$this->db->update("request_bi_category", $data);
		}
		else
		{			
			$data['bict_entrydate'] = date('Y-m-d H:i:s');
			$data['bict_entryuser'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("request_bi_category", $data);
		}

		$rdct = base_url() . 'index.php/request/bicategory';
		redirect($rdct);
		exit();
	}

	function deletebicategory($id)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['master']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}		
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$childs = array($id);
		
		$this->db->where_in("bict_id", $childs);
		$this->db->delete("request_bi_category");

		redirect(site_url(array("request", "bicategory")));
	}

	function export_excel()
	{
		$arr_training_type = array(
			1 => 'Pelatihan Inhouse',
			2 => 'Pelatihan Eksternal',
			3 => 'On The Job Training',
		);

		$arr_status_approval = array(
			0 => 'Waiting',
			1 => 'Onprogress',
			2 => 'Approved',
			3 => 'rejected',
		);

		$rows = $this->db->join('request_jenis_pendidikan', 'rqtr_jepd_id=jepd_id', 'left')->join('request_bi_category', 'rqtr_bict_id=bict_id', 'left')->join('user', 'rqtr_user_id=user_id', 'left')->order_by('rqtr_id')->get("request_training")->result();

		$schedule_start = array();
		$schedule_end = array();
		$lama_hari = array();
		$data_peserta = array();
		for($i=0; $i < count($rows); $i++)
		{
			$data = unserialize($rows[$i]->rqtr_participant);
			if(!empty($data)) {
				$tmp = join(',', $data);
				$res = $this->db->select('user_id, user_npk, user_first_name', false)->where('user_id IN ('.$tmp.') AND user_status = 1')->get('user')->result_array();
				foreach ($res as $key => $value) {
					$data_peserta[$i][$value['user_id']]['nama'] = $value['user_first_name'];
					$data_peserta[$i][$value['user_id']]['npk'] = $value['user_npk'];
				}
			}

			$data = unserialize($rows[$i]->rqtr_schedule);
			
			$schedule_end[$i] = $schedule_start[$i] = '';
			$lama_hari[$i] = 0;
			if(!empty($data)) {
				$tanggal_akhir[$i] = $tanggal_awal[$i] = $data['tanggal'][0];
				$sz = count($data['tanggal']);
				//$schedule_end[$i] = $schedule_start[$i] = '[ tanggal : '.$data['tanggal'][0].', Waktu : '.$data['waktu_awal'][0].' s/d '.$data['waktu_akhir'][0].' ]';
				$schedule_end[$i] = $schedule_start[$i] = $data['tanggal'][0];
				if($sz > 1) {
					$tanggal_akhir[$i] = $data['tanggal'][($sz-1)];
					//$schedule_end[$i] = '[ tanggal : '.$data['tanggal'][($sz-1)].', Waktu : '.$data['waktu_awal'][($sz-1)].' s/d '.$data['waktu_akhir'][($sz-1)].' ]';
					$schedule_end[$i] = $data['tanggal'][($sz-1)];

				}
				$lama_hari[$i] = get_time_date_diff($tanggal_awal[$i], $tanggal_akhir[$i]);
				$lama_hari[$i] = !empty($lama_hari[$i]) ? ($lama_hari[$i] + 1) : 1;
			}
		}
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-request-training.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("jabatan");
			
		
		$this->mysmarty->assign("lhierarchy", $this->config->item('lhierarchy')); 
		
		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, 'Request No');
		$worksheet->write(0, 2, 'Request Training Code');
		$worksheet->write(0, 3, 'Request User');
		$worksheet->write(0, 4, 'Request Date');
		$worksheet->write(0, 5, 'Training Type');
		$worksheet->write(0, 6, 'Jenis Pendidikan');
		$worksheet->write(0, 7, 'BI Category');
		$worksheet->write(0, 8, 'Penyelenggara');
		$worksheet->write(0, 9, 'Tema');
		$worksheet->write(0, 10, 'Judul');
		$worksheet->write(0, 11, 'Tanggal Awal');
		$worksheet->write(0, 12, 'Tanggal Akhir');
		$worksheet->write(0, 13, 'Lama Hari');
		$worksheet->write(0, 14, 'Tempat');
		$worksheet->write(0, 15, 'Pembicara');
		$worksheet->write(0, 16, 'Nama Peserta');
		$worksheet->write(0, 17, 'NIK Peserta');
		$worksheet->write(0, 18, 'Jumlah Peserta');
		$worksheet->write(0, 19, 'Tujuan Pelatihan');
		$worksheet->write(0, 20, 'Rekomendasi (Direct Supervisor)');
		$worksheet->write(0, 21, 'Rekomendasi (Program Development)');
		$worksheet->write(0, 22, 'Status Approval');
		$worksheet->write(0, 23, 'Biaya Program');
		$worksheet->write(0, 24, 'Biaya Akomodasi');
		$worksheet->write(0, 25, 'Biaya Transportasi');
		$worksheet->write(0, 26, 'Biaya Uang Makan');
		$worksheet->write(0, 27, 'Training Cost');
		
		$cnt = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->rqtr_type = !empty($arr_training_type[$rows[$i]->rqtr_type]) ? $arr_training_type[$rows[$i]->rqtr_type] : '-';
			$rows[$i]->rqtr_status_approval = !empty($arr_status_approval[$rows[$i]->rqtr_status_approval]) ? $arr_status_approval[$rows[$i]->rqtr_status_approval] : '-';

			if(!empty($data_peserta[$i])) {
				foreach ($data_peserta[$i] as $key => $value) {
					$worksheet->write($cnt+1, 0, $rows[$i]->rqtr_id);	
					$worksheet->write($cnt+1, 1, $rows[$i]->rqtr_request_no);	
					$worksheet->write($cnt+1, 2, $rows[$i]->rqtr_request_code);	
					$worksheet->write($cnt+1, 3, $rows[$i]->user_first_name);	
					$worksheet->write($cnt+1, 4, $rows[$i]->rqtr_entrytime);	
					$worksheet->write($cnt+1, 5, $rows[$i]->rqtr_type);	
					$worksheet->write($cnt+1, 6, $rows[$i]->jepd_name);	
					$worksheet->write($cnt+1, 7, $rows[$i]->bict_name);	
					$worksheet->write($cnt+1, 8, $rows[$i]->rqtr_penyelenggara);	
					$worksheet->write($cnt+1, 9, $rows[$i]->rqtr_tema);	
					$worksheet->write($cnt+1, 10, $rows[$i]->rqtr_judul);	
					$worksheet->write($cnt+1, 11, $schedule_start[$i]);	
					$worksheet->write($cnt+1, 12, $schedule_end[$i]);	
					$worksheet->write($cnt+1, 13, $lama_hari[$i]);	
					$worksheet->write($cnt+1, 14, $rows[$i]->rqtr_tempat);	
					$worksheet->write($cnt+1, 15, $rows[$i]->rqtr_pembicara);	
					$worksheet->write($cnt+1, 16, $value['nama']);	
					$worksheet->write($cnt+1, 17, $value['npk']);	
					$worksheet->write($cnt+1, 18, 1);	
					$worksheet->write($cnt+1, 19, $rows[$i]->rqtr_tujuan_pelatihan);	
					$worksheet->write($cnt+1, 20, $rows[$i]->rqtr_rekomendasi_supervisor);
					$worksheet->write($cnt+1, 21, $rows[$i]->rqtr_rekomendasi_development);
					$worksheet->write($cnt+1, 22, $rows[$i]->rqtr_status_approval);
					$worksheet->write($cnt+1, 23, $rows[$i]->rqtr_biaya_program);	
					$worksheet->write($cnt+1, 24, $rows[$i]->rqtr_akomodasi);	
					$worksheet->write($cnt+1, 25, $rows[$i]->rqtr_transportasi);	
					$worksheet->write($cnt+1, 26, $rows[$i]->rqtr_uang_makan);	
					$worksheet->write($cnt+1, 27, $rows[$i]->rqtr_jumlah);

					$cnt++;
				}
			} else {
				$worksheet->write($cnt+1, 0, $rows[$i]->rqtr_id);	
				$worksheet->write($cnt+1, 1, $rows[$i]->rqtr_request_no);	
				$worksheet->write($cnt+1, 2, $rows[$i]->rqtr_request_code);	
				$worksheet->write($cnt+1, 3, $rows[$i]->user_first_name);	
				$worksheet->write($cnt+1, 4, $rows[$i]->rqtr_entrytime);	
				$worksheet->write($cnt+1, 5, $rows[$i]->rqtr_type);	
				$worksheet->write($cnt+1, 6, $rows[$i]->jepd_name);	
				$worksheet->write($cnt+1, 7, $rows[$i]->bict_name);	
				$worksheet->write($cnt+1, 8, $rows[$i]->rqtr_penyelenggara);	
				$worksheet->write($cnt+1, 9, $rows[$i]->rqtr_tema);	
				$worksheet->write($cnt+1, 10, $rows[$i]->rqtr_judul);	
				$worksheet->write($cnt+1, 11, $schedule_start[$i]);	
				$worksheet->write($cnt+1, 12, $schedule_end[$i]);	
				$worksheet->write($cnt+1, 13, $lama_hari[$i]);	
				$worksheet->write($cnt+1, 14, $rows[$i]->rqtr_tempat);	
				$worksheet->write($cnt+1, 15, $rows[$i]->rqtr_pembicara);	
				$worksheet->write($cnt+1, 16, '');	
				$worksheet->write($cnt+1, 17, '');	
				$worksheet->write($cnt+1, 18, '');	
				$worksheet->write($cnt+1, 19, $rows[$i]->rqtr_tujuan_pelatihan);	
				$worksheet->write($cnt+1, 20, $rows[$i]->rqtr_rekomendasi_supervisor);
				$worksheet->write($cnt+1, 21, $rows[$i]->rqtr_rekomendasi_development);
				$worksheet->write($cnt+1, 22, $rows[$i]->rqtr_status_approval);
				$worksheet->write($cnt+1, 23, $rows[$i]->rqtr_biaya_program);	
				$worksheet->write($cnt+1, 24, $rows[$i]->rqtr_akomodasi);	
				$worksheet->write($cnt+1, 25, $rows[$i]->rqtr_transportasi);	
				$worksheet->write($cnt+1, 26, $rows[$i]->rqtr_uang_makan);	
				$worksheet->write($cnt+1, 27, $rows[$i]->rqtr_jumlah);

				$cnt++;
			}	
		}

		$this->xlswriter->close();
	}

	function importapproval()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}

		if(!empty($_POST)) {
			$data_excel = array();

			$this->load->library("xlsreader");
			$this->xlsreader->read($_FILES['userfile']['tmp_name']);			
			
			$i = 2;
			$ii = 0;
			while(1)
			{
				$j = 1;
				$jj = 0;
				while(1) {
					if (! isset($this->xlsreader->sheets[0]['cells'][$i][$j])) break;
				
					$data_excel[$ii][$jj] = $this->xlsreader->sheets[0]['cells'][$i][$j];				
					
					$j++;
					$jj++;
				}

				if (! isset($this->xlsreader->sheets[0]['cells'][$i][1])) break;

				$i++;
				$ii++;
			}

			//print_r($data_excel);

			if(!empty($data_excel)) {
				foreach ($data_excel as $key => $value) {
					$data = array(
						'rqtr_status_admin_approval' => 1,
						'rqtr_reason_admin_approval' => $value[1],
						'rqtr_status_approval' => 2,
						'rqtr_updateuser' => $this->_user_info['user_first_name'],
						'rqtr_updatetime' => date('Y-m-d H:i:s'),
					);

					$this->db->where('rqtr_request_no = "'.$value[0].'" AND rqtr_status_approval != 2')->update("request_training", $data);
				}
			}
		}

		$ltitle_form = "Import Approval";

		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		$this->mysmarty->assign("left_content", "request/menu.html");		
		$this->mysmarty->assign("main_content", "request/formimportapproval.html");
		$this->mysmarty->display("sess_template.html");
	}

	function sendmail($request_training_id, $user_id)
	{	
		$q = $this->db->get("general_setting");
		
		$rowsettings = $q->result();
		for($i=0; $i < count($rowsettings); $i++)
		{
			$settings[$rowsettings[$i]->general_setting_code] = $rowsettings[$i]->general_setting_value;
		}

		$this->settings = $settings;

		if(empty($this->settings['notif_email_approval'])) {
			$this->logmodel->append('Notification approval disabled');
			return 0;
		}

		$user_info = $this->db->where('user_id = "'.$user_id.'"')->get("user")->row_array();
		if(empty($user_info)) {
			$this->logmodel->append('User notification approval is empty');
			return 0;
		}

		$request_training_info = $this->db->where('rqtr_id = "'.$request_training_id.'"')->get("request_training")->row_array();
		if(empty($request_training_info)) {
			$this->logmodel->append('Info training notification approval is empty');
			return 0;
		}
				
		$this->load->library('email');
		
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype']	    	= "html";

		if (isset($this->settings['mailtype']) && ($this->settings['mailtype'] == "smtp"))	
		{
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $settings['smtphost'];
			$config['smtp_user'] = isset($settings['smtpuser']) ? 	$settings['smtpuser'] : "";
			$config['smtp_pass'] = 	isset($settings['smtppass']) ? 	$settings['smtppass'] : "";		
			$config['smtp_port'] = (isset($this->settings['smtpport']) && $this->settings['smtpport']) ? $this->settings['smtpport'] : 25;
		}
		else
		{
			$config['protocol'] = 'mail';
		}	
		
		$config['mailtype'] = (isset($this->settings['mailcontenttype']) && $this->settings['mailcontenttype']) ? $this->settings['mailcontenttype'] : "html";
		
		$mailsender = isset($settings['remindermailsender']) ? $settings['remindermailsender'] : $this->config->item("admin_mail");
		$sendername = isset($settings['remindermailsendername']) ? $settings['remindermailsendername'] : "";
		
		$subject = isset($settings['remindermailsubject']) ? $settings['remindermailsubject'] : "[lmsv2] Notification Approval";

		$this->mysmarty->assign("user_approval", $user_info['user_first_name']);
		$this->mysmarty->assign("request_training", $request_training_info['rqtr_judul']);
		$message = $this->mysmarty->fetch("generalsetting/notif_approval_email_body.html");
		if(empty($message)) {
			$message = 'Hi '.$user_info['user_first_name'].', training : "'.$request_training_info['rqtr_judul'].'"" ini butuh approval mu. <br/><br/>Terima Kasih.';
		}
		
		$this->email->initialize($config);
		$this->email->from($mailsender, $sendername);
		$this->email->to($user_info['user_email']); 
		$this->email->subject($subject);
		$this->email->message($message);
		
		if ($this->email->send())
		{
			$s_echo = "OK send mail notification training approval ".$request_training_info['rqtr_judul']." to ".$user_info['user_npk']." ".$user_info['user_first_name']." ".$user_info['user_last_name']." ".$user_info['user_email'].")\r\n";
			$message1 = $s_echo." ".$message;

			unset($insert);
						
			$desc["subject"] = $subject;
			$desc["message"] = $message;
			$desc["npk"] = $user_info['user_npk'];
			
			$insert['log_type'] = "notification_approval";
			$insert['log_user'] = $user_info['user_id'];
			$insert['log_status'] = 1;
			$insert['log_created'] = date("Y-m-d H:i:s");
			$insert['log_desc'] = json_encode($desc);
			$insert['log_param1'] = $request_training_info['rqtr_id'];
			
			$this->db->insert("log", $insert);
			
			$sent = 1;
		}
		else
		{
			$s_echo = "NOK send mail notification training approval ".$request_training_info['rqtr_judul']." to ".$user_info['user_npk']." ".$user_info['user_first_name']." ".$user_info['user_last_name']." ".$user_info['user_email'].")\r\n";
			$message1 = $s_echo." ".$message;
			$sent = 0;

			unset($insert);
						
			$desc["subject"] = $subject;
			$desc["message"] = $message;
			$desc["npk"] = $user_info['user_npk'];
			
			$insert['log_type'] = "notification_approval";
			$insert['log_user'] = $user_info['user_id'];
			$insert['log_status'] = 1;
			$insert['log_created'] = date("Y-m-d H:i:s");
			$insert['log_desc'] = json_encode($desc);
			$insert['log_param1'] = $request_training_info['rqtr_id'];
			
			$this->db->insert("log", $insert);

		}
		
		$this->email->clear(TRUE);
		
		//echo $message1;
		$this->logmodel->append($message1);		
		
		return $sent;
	}

}