<?php

include "ildp.php";

class HRLD extends ILDP 
{
	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("hrld_id", $id);
		$this->db->delete("hrld");
		
		redirect(site_url(array("hrld")));
	}
	
	function status($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("hrld_id", $id);
		$q = $this->db->get("hrld");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		$update['hrld_status'] = ($row->hrld_status == 1) ? 2: 1;
		
		$this->db->where("hrld_id", $id);
		$this->db->update("hrld", $update);		
		
		redirect(site_url(array("hrld")));
	}
	
	function index()
	{
		$this->db->order_by("category_name", "asc");
		$this->db->where("category_parent", 0);
		$q = $this->db->get("category");
		
		$rows = $q->result();
						
		$this->mysmarty->assign("cats", $rows);		
		$this->mysmarty->assign("lhrld_setting", $this->config->item("lhrld_setting"));
		$this->mysmarty->assign("lheader_lhrld_setting_list", $this->config->item("lheader_lhrld_setting_list"));
		$this->mysmarty->assign("lcategory", $this->config->item("category"));		
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));		
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));		
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));			
		$this->mysmarty->assign("lildp_subtitle", $this->config->item("lildp_subtitle"));		
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/hrrm/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search($offset=0)
	{
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";		
		$searchby = isset($_POST['searchby']) ? trim($_POST['searchby']) : "";
		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : "";
		$cat = isset($_POST['cat']) ? trim($_POST['cat']) : "";
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		switch($searchby)
		{
			case "cat":
				$this->db->where("hrld_category", $cat);
			break;
			default:
				$this->db->where("user_npk LIKE '%".$keyword."%'", null);
		}
		
		$this->db->order_by($sortby, $orderby);			
		$this->db->join("category", "hrld_category = category_id");
		$this->db->join("user", "hrld_npk = user_id");
		$this->db->limit($limit, $offset);
		$q = $this->db->get("hrld");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$rows[$i]->hrld_status_frm = ($rows[$i]->hrld_status == 1) ? $this->config->item("active") : $this->config->item("inactive");
		}
		
		$this->mysmarty->assign("settings", $rows);
		
		// total

		switch($searchby)
		{
			case "cat":
				$this->db->where("hrld_category", $cat);
			break;
			default:
				$this->db->where("user_npk LIKE '%".$keyword."%'", null);
		}

		$this->db->join("category", "hrld_category = category_id");
		$this->db->join("user", "hrld_npk = user_id");		
		$total = $this->db->count_all_results("hrld");
		
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
		$this->pagination1->lang_title = $this->config->item('lsetting');
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = $total;
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/hrrm/list.html");				
		
		echo json_encode($callback);
	}
	
	function form()
	{	
		$this->db->order_by("category_name", "asc");
		$this->db->where("category_parent", 0);
		$q = $this->db->get("category");
		
		$rows = $q->result();
		
		$this->mysmarty->assign("cats", $rows);
	
		$this->mysmarty->assign("lcategory", $this->config->item("category"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/hrrm/form.html");
		$this->mysmarty->display("sess_template.html");				
	}
	
	function save()
	{
		$npk = isset($_POST['npk']) ? trim($_POST['npk']) : "";
		$cat = isset($_POST['cat']) ? trim($_POST['cat']) : "";
		
		if (strlen($npk) == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_empty_npk");
			
			echo json_encode($callback);
			return;
		}
		
		$this->db->where("user_npk", $npk);
		$q = $this->db->get("user");
		
		if ($q->num_rows() == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("err_not_already_exist_npk");
			
			echo json_encode($callback);
			return;
		}
		
		$row = $q->row();

		$this->db->where("hrld_category", $cat);
		$this->db->where("hrld_npk", $row->user_id);
		$total = $this->db->count_all_results("hrld");
		
		if ($total > 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lhrrm_setting_already_exist");
			
			echo json_encode($callback);
			return;
		}
		
		unset($insert);
		
		$insert['hrld_npk'] = $row->user_id;
		$insert['hrld_category'] = $cat;
		$insert['hrld_status'] = 1;
		$insert['hrld_created'] = date("Y-m-d H:i:s");
		$insert['hrld_creator'] = $this->sess['user_id'];
		
		$this->db->insert("hrld", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lhrrm_setting_added");
		$callback['redirect'] = site_url(array("hrld"));
		
		echo json_encode($callback);		
	}
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
