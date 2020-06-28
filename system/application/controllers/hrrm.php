<?php

include "ildp.php";

class HRRM extends ILDP 
{
	function index()
	{
		$this->mysmarty->assign("lheader_lhrrm_setting_list", $this->config->item("lheader_lhrrm_setting_list"));
		$this->mysmarty->assign("ldata_added", $this->config->item("date_added"));		
		$this->mysmarty->assign("lsort_list_by", $this->config->item("sort_list_by"));		
		$this->mysmarty->assign("lsearch", $this->config->item("lsearch"));		
		$this->mysmarty->assign("lsearch_by", $this->config->item("lsearch_by"));			
		$this->mysmarty->assign("lildp_subtitle", $this->config->item("lildp_subtitle"));		
		$this->mysmarty->assign("ltraining_method", $this->config->item("ltraining_method"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/hrld/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function search($offset=0)
	{
		$levels = array();
		$this->levelmodel->getalllevels(0, &$levels);
		
		$this->mysmarty->assign("levels", $levels);	
		$this->mysmarty->assign("nlevel", count($levels));
		
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : "asc";
		$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "user_npk";		
		$searchby = isset($_POST['searchby']) ? trim($_POST['searchby']) : "";
		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : "";
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;
		
		switch($searchby)
		{
			case "name":
				$this->db->where("user_first_name LIKE '%".$keyword."%' OR user_last_name LIKE '%".$keyword."%'", null);				
			break;
			default:
				$this->db->where("user_npk LIKE '%".$keyword."%'", null);
		}
		
		$this->db->order_by($sortby, $orderby);			
		$this->db->join("level_group", "hrrm_group = level_group_id");
		$this->db->join("user", "hrrm_npk = user_id");
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		$q = $this->db->get("hrrm");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$arr = array();
			$this->levelmodel->getparentlevelgroups($rows[$i]->level_group_id, &$arr);
			
			unset($grouplevels);			
			for($j=0; $j < count($arr); $j++)
			{
				$grouplevels[$arr[$j]->level_group_nth] = $arr[$j]->level_group_name;
			}
			
			if (isset($grouplevels))
			{
				$rows[$i]->grouplevels = $grouplevels;
			}
			$rows[$i]->hrrm_status_frm = ($rows[$i]->hrrm_status == 1) ? $this->config->item("active") : $this->config->item("inactive");
		}
		
		$this->mysmarty->assign("settings", $rows);
		
		// total

		switch($searchby)
		{
			case "name":
				$this->db->where("user_first_name LIKE '%".$keyword."%' OR user_last_name LIKE '%".$keyword."%'", null);				
			break;
			default:
				$this->db->where("user_npk LIKE '%".$keyword."%'", null);
		}

		$this->db->join("level_group", "hrrm_group = level_group_id");
		$this->db->join("user", "hrrm_npk = user_id");		
		$total = $this->db->count_all_results("hrrm");
		
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
		$this->mysmarty->assign("ldirectorat", $this->config->item("directorat"));
		$this->mysmarty->assign("lgroup", $this->config->item("group"));
		$this->mysmarty->assign("ldepartment", $this->config->item("department"));
		$this->mysmarty->assign("lunit", $this->config->item("unit"));
		$this->mysmarty->assign("lstatus", $this->config->item("status"));
		$this->mysmarty->assign("lname", $this->config->item("lname"));
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item("lconfirm_change_status"));
		
		$callback['html'] = $this->mysmarty->fetch("ildp/hrld/list.html");				
		
		echo json_encode($callback);
	}

	function status($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("hrrm_id", $id);
		$q = $this->db->get("hrrm");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		$update['hrrm_status'] = ($row->hrrm_status == 1) ? 2: 1;
		
		$this->db->where("hrrm_id", $id);
		$this->db->update("hrrm", $update);		
		
		redirect(site_url(array("hrrm")));
	}

	function remove($id)
	{
		if (! $this->modules['ildpadmin'])
		{
			redirect(base_url());
		}
		
		$this->db->where("hrrm_id", $id);
		$this->db->delete("hrrm");
		
		redirect(site_url()."/hrrm");
	}

	function form()
	{	
		$levels = array();
		$this->levelmodel->getalllevels(0, &$levels);
		
		$this->mysmarty->assign("levels", $levels);
		$this->mysmarty->assign("nlevel", count($levels));
	
		$this->mysmarty->assign("lall", $this->config->item("lall"));
		$this->mysmarty->assign("lconfirm_ildp_catalog_save", $this->config->item("lconfirm_ildp_catalog_save"));
		$this->mysmarty->assign("lconfirm_reset_data", $this->config->item("lconfirm_reset_data"));		
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildp/hrld/form.html");
		$this->mysmarty->display("sess_template.html");				
	}
	
	function loadgroup($level, $parent)
	{
		
		//echo $iddv.";".$selectedid."<BR>";
		

		$arr = array();
		$this->levelmodel->getGroupChilds(&$arr, $parent, true);
		
		$callback['groups'] = $arr;
		
		echo json_encode($callback);		
	}
	
	function save()
	{
		$npk = isset($_POST['npk']) ? trim($_POST['npk']) : "";
		$npks = explode(" ", $npk);
		if (count($npks))
		{
			$npk = $npks[0];
		}

		$levels = array();
		$this->levelmodel->getalllevels(0, &$levels);
		
		for($i=count($levels)-1; $i >= 0; $i--)
		{
			if (! $_POST['groupid'.$levels[$i]->level_nth]) continue;
			
			$grpid = $_POST['groupid'.$levels[$i]->level_nth];
			break;
		}
		
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
		
		if ($grpid == 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lerr_empty_levelgroup");
			
			echo json_encode($callback);
			return;
		}

		$this->db->where("hrrm_group", $grpid);
		$this->db->where("hrrm_npk", $row->user_id);
		$total = $this->db->count_all_results("hrrm");
		
		if ($total > 0)
		{
			$callback['error'] = true;
			$callback['message'] = $this->config->item("lhrld_setting_already_exist");
			
			echo json_encode($callback);
			return;
		}
		
		unset($insert);
		
		$insert['hrrm_npk'] = $row->user_id;
		$insert['hrrm_group'] = $grpid;
		$insert['hrrm_status'] = 1;
		$insert['hrrm_created'] = date("Y-m-d H:i:s");
		$insert['hrrm_creator'] = $this->sess['user_id'];
		
		$this->db->insert("hrrm", $insert);

		$callback['error'] = false;
		$callback['message'] = $this->config->item("lhrld_setting_added");
		$callback['redirect'] = site_url(array("hrrm"));
		
		echo json_encode($callback);		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
