<?php

include_once "base.php"; 
class Lokasi extends Base {
	var $sess;
	var $lang;
	var $modules;

	function Lokasi()
	{
		//parent::Controller();	
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
		}			
		$this->langmodel->init();
		
		$this->mysmarty->assign("level_tree", $this->levelmodel->levelmenu());
	}
	
	function index()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		// user right
		
		$this->db->distinct();
		$this->db->select("user_location");
		$q = $this->db->get("user");
		$this->db->flush_cache();
		
		$rowtypes = $q->result();
		for($i=0; $i < count($rowtypes); $i++)
		{
			$usertypes[$rowtypes[$i]->user_location] = true;
		}
		
		// end of user right		
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "lokasi_kota";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		
		$sess = unserialize($usess);
		
		if (! isset($this->modules['master']))
		{
			redirect(base_url());
		}
				
		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE lokasi_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END lokasi_status_desc ", false);
		if ($limit)
		{
			$q = $this->db->get("lokasi", $limit, $offset);
		}
		else
		{
			$q = $this->db->get("lokasi");
		}
		
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			$list[$i]->used = isset($usertypes[$list[$i]->lokasi_id]);
		}
		
		$total = $this->db->count_all("lokasi");
		
		$config['total_rows'] = $total;
		$config['per_page'] = $limit ? $limit : $total; 
				
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
		$this->pagination1->lang_title = $this->config->item('lright');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
		
		
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("lheader_list_lokasi", $this->config->item('lheader_list_lokasi'));
		$this->mysmarty->assign("lcity", strtoupper($this->config->item('city')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("llokasi_list", ucfirst($this->config->item('llokasi_list')));
		$this->mysmarty->assign("llocation", ucfirst($this->config->item('location')));
		$this->mysmarty->assign("confirm_delete", ucfirst($this->config->item('confirm_delete')));		
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		
		$this->mysmarty->assign("lsort_by_city", $this->config->item('lsort_by_city'));
		$this->mysmarty->assign("lsort_by_location", $this->config->item('lsort_by_location'));
		$this->mysmarty->assign("lsort_by_status", $this->config->item('lsort_by_status'));
		
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "lokasi/list.html");
		$this->mysmarty->display("sess_template.html");
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
	
	function form($edit=0)
	{
		$this->checkadmin();

		if (! isset($this->modules['master']))
		{
			redirect(base_url());				
		}
		
		if ($edit)
		{
		
			$this->db->where("lokasi_id", $edit);
			$q = $this->db->get('lokasi');
			$this->db->flush_cache();			

			$row = $q->row();				
			
			$this->mysmarty->assign("lokasi", $row);										
			$ltitle_form = $this->config->item("lupdate_lokasi_list");
			 
		}
		else
		{
			$ltitle_form = $this->config->item("ladd_lokasi_list");
		}

		$this->mysmarty->assign("ltitle_form", $ltitle_form);				
		$this->mysmarty->assign("lcreate_right", $this->config->item("lcreate_right"));
		$this->mysmarty->assign("lcity", $this->config->item("city"));
		$this->mysmarty->assign("llocation", $this->config->item("location"));		
		$this->mysmarty->assign("lok_save_lokasi", $this->config->item("lok_save_lokasi"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		
		$this->mysmarty->assign("left_content", "menu_masterdata.html");
		$this->mysmarty->assign("main_content", "lokasi/form.html");
		$this->mysmarty->display("sess_template.html");
		
	}	
	
	function save($edit=0)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}

		if ($this->sess['user_type'])
		{
			if (! isset($this->modules['master']))
			{
				echo "1\1";
				echo $this->config->item("err_exipred_session");
				exit;
			}
		}
		
		$city = isset($_POST['city']) ? trim($_POST['city']) : "";
		$location = isset($_POST['location']) ? trim($_POST['location']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$errs = array();
		
		if (strlen($city) == 0)
		{
			$errs[] = $this->config->item("err_empty_city");
		}
		
		if (strlen($location) == 0)
		{
			$errs[] = $this->config->item("err_empty_location");
		}
		
		
		if (count($errs) == 0)
		{							
			$this->db->where("lokasi_kota", addslashes($city));
			$this->db->where("lokasi_alamat", addslashes($location));
			
			$q = $this->db->get("lokasi");
			$this->db->flush_cache();
						
			if ($q->num_rows() > 0)
			{
				$lokasi = $q->row();
				
				if (! $edit)
				{
					$errs[] = $this->config->item("lerr_exist_lokasi");
				}
				else
				if ($lokasi->lokasi_id != $edit)
				{
					$errs[] = $this->config->item("lerr_exist_lokasi");
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
		
		unset($data);
		
		$data['lokasi_kota'] = addslashes($city);
		$data['lokasi_alamat'] = addslashes($location);
		$data['lokasi_status'] = addslashes($status);

		if ($edit)
		{			
			$this->db->where("lokasi_id", $edit);			
			$this->db->update("lokasi", $data);
		}
		else
		{
			$data['lokasi_created'] = date("Ymd");
			$data['lokasi_creator'] = $this->sess['user_id'];
				
			$this->db->insert("lokasi", $data);			
		}
	}
	
	function changestatus($id, $status)
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if ($this->sess['user_type'])
		{
			if (! isset($this->modules['master']))
			{
				echo "1\1";
				echo $this->config->item("err_exipred_session");
				exit;
			}
		}
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}				
		
		$data['lokasi_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where("lokasi_id", $id);
		$this->db->update("lokasi", $data);				
	}
	
	function remove($id)
	{
		$this->checkadmin();

		if ($this->sess['user_type'])
		{		
			if (! isset($this->modules['master']))
			{
				redirect(base_url());
			}
		}
		
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("user_location", $id);
		$total = $this->db->count_all_results("user");
		$this->db->flush_cache();
		
		if ($total > 0)
		{
			redirect(base_url());
		}
		
		$this->db->where("lokasi_id", $id);
		$this->db->delete("lokasi");
		
		redirect(site_url("lokasi"));
	}	

	function export()
	{
		$this->db->order_by("lokasi_id", "asc");
		$q = $this->db->select("*
			, CASE lokasi_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END lokasi_status_desc "
			, false
		);
		$q = $this->db->get("lokasi");
		
		$rows = $q->result();
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-lokasi.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("lokasi");
			
		
		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, 'Kota');
		$worksheet->write(0, 2, 'lokasi');
		$worksheet->write(0, 3, 'status code');
		$worksheet->write(0, 4, 'status desc');
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->lokasi_id);	
			$worksheet->write($i+1, 1, $rows[$i]->lokasi_kota);	
			$worksheet->write($i+1, 2, $rows[$i]->lokasi_alamat);	
			$worksheet->write($i+1, 3, $rows[$i]->lokasi_status);	
			$worksheet->write($i+1, 4, $rows[$i]->lokasi_status_desc);	
		}

		$this->xlswriter->close();
	}
	
	function addressselectbox()
	{
		$this->db->order_by("lokasi_alamat");
		$this->db->where("UPPER(lokasi_kota)", $_POST['city']);
		$q = $this->db->get("lokasi");
		$this->db->flush_cache();
		
		$rowlokasies = $q->result();
		
		$this->mysmarty->assign("rowlokasies", $rowlokasies);
		$this->mysmarty->display("lokasi/selectbox-address.html");
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
