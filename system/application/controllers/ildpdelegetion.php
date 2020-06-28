<?php

include "ildp.php";

class ILDPDelegetion extends ILDP 
{
	function index()
	{
		$this->mysmarty->assign("lildp_delegetion", $this->config->item("lildp_delegetion"));
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));				
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildp/delegetion/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
		
		if (! $this->sess)
		{
			redirect(base_url());
		}
	}
	
	function search($offset=0)
	{
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		$this->db->order_by($sortby, $orderby);			
		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->join("user", "delegetion_ildp_delegator = user_id");
		$this->db->limit($limit, $offset);
		$q = $this->db->get("delegetion_ildp");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$arr = array();			
			$rows[$i]->delegetion_ildp_status_fmt = ($rows[$i]->delegetion_ildp_status == 1) ? $this->config->item("active") : $this->config->item("inactive");
		}
		
		$this->mysmarty->assign("settings", $rows);
		
		// total


		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->join("user", "delegetion_ildp_delegator = user_id");
		$total = $this->db->count_all_results("delegetion_ildp");
		
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
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
		
		$this->mysmarty->assign("lname", $this->config->item("name"));
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);
		$this->mysmarty->assign("lconfirm_delete", $this->config->item("confirm_delete"));
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("ldepartment", $this->config->item("department"));
		$this->mysmarty->assign("lunit", $this->config->item("unit"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/delegetion/list.html");				
		
		echo json_encode($callback);
	}

	function status($id)
	{
		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->where("delegetion_ildp_id", $id);
		$q = $this->db->get("delegetion_ildp");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		$update['delegetion_ildp_status'] = ($row->delegetion_ildp_status == 1) ? 2: 1;
		
		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->where("delegetion_ildp_id", $id);
		$this->db->update("delegetion_ildp", $update);		
		
		redirect(site_url(array("ildpdelegetion")));
	}

	function remove($id)
	{
		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->where("delegetion_ildp_id", $id);
		$q = $this->db->get("delegetion_ildp");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}

		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->where("delegetion_ildp_id", $id);
		$this->db->delete("delegetion_ildp");
		
		redirect(site_url()."/ildpdelegetion");
	}

	function form()
	{	
		$this->mysmarty->assign("lildp_add_delegetion", $this->config->item("lildp_add_delegetion"));
		
		$this->mysmarty->assign("left_content", "user/menu.html");
		$this->mysmarty->assign("main_content", "ildp/delegetion/form.html");
		$this->mysmarty->display("sess_template.html");				
	}
	
	function save()
	{
		$npk = isset($_POST['npk']) ? trim($_POST['npk']) : "";
		
		
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

		$this->db->where("delegetion_ildp_user", $this->sess['user_id']);
		$this->db->where("delegetion_ildp_delegator", $row->user_id);
		$total = $this->db->count_all_results("delegetion_ildp");
		
		if ($total > 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lildpdelegetion_already_exist");
			
			echo json_encode($callback);
			return;
		}
		
		unset($insert);
		
		$insert['delegetion_ildp_user'] = $this->sess['user_id'];
		$insert['delegetion_ildp_delegator'] = $row->user_id;
		$insert['delegetion_ildp_status'] = 1;
		$insert['delegetion_ildp_created'] = date("Y-m-d H:i:s");
		
		$this->db->insert("delegetion_ildp", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lildpdelegetion_added");
		$callback['redirect'] = site_url(array("ildpdelegetion"));
		
		echo json_encode($callback);		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */