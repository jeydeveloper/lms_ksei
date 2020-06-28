<?php
include_once "base.php"; 

class ILDPReport extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPReport()
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
		$this->load->model("logmodel");
		$this->load->model("topicmodel");		
		$this->load->model("ildpmodel");
		$this->load->model("ildpcategorymodel");
		
		$this->load->database();	
		
		$this->language = $this->session->userdata('lms_lang');
		$this->config->load('config.'.($this->language ? $this->language : $this->langmodel->getDefaultLang()));						
		
		$this->mysmarty->assign("lang", $this->language);
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
		}				
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
		
		$this->langmodel->init();
				
	}
		
	function index($topicid=0, $referer="", $userid=0)
	{				
		if (!$this->sess)
		{ 
			redirect(base_url());
		}
		
		if(!$this->modules['ildpadmin'])
		{
			redirect('user');
			exit;
		} 			
		
		$levels = array();
		$this->levelmodel->getalllevels(0, &$levels);

		$this->mysmarty->assign("levels", $levels);			
		
		$this->db->distinct();
		$this->db->select("ildp_registration_period_ildp");
		$q = $this->db->get("ildp_registration_period");
		
		$rows = $q->result();
		$this->mysmarty->assign("periods", $rows);
		$this->mysmarty->assign("yearnow", date("Y"));
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
				
		$this->mysmarty->assign("lildp_report", $this->config->item("lildp_report"));
		$this->mysmarty->assign("lreport_type", $this->config->item("lreport_type"));
		$this->mysmarty->assign("lrekap_per_dir", $this->config->item("lrekap_per_dir"));
		$this->mysmarty->assign("lrekap_per_group", $this->config->item("lrekap_per_group"));
		$this->mysmarty->assign("lrekap_per_dept", $this->config->item("lrekap_per_dept"));
		$this->mysmarty->assign("lrekap_per_unit", $this->config->item("lrekap_per_unit"));
		$this->mysmarty->assign("lexport", $this->config->item("lexport"));
		$this->mysmarty->assign("lrekap", $this->config->item("lrekap"));
		$this->mysmarty->assign("ldetail", $this->config->item("ldetail"));
		$this->mysmarty->assign("lildp_period", $this->config->item("lildp_period"));
		$this->mysmarty->assign("lexport_ildp_report_confirm", $this->config->item("lexport_ildp_report_confirm"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpreport/mainlist.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function doexport()
	{
		$rtype = isset($_POST['rtype']) ? $_POST['rtype'] : "";
		if ($rtype == "rekap")
		{
			$this->dorekap();
			return;
		}
		
		$this->dodetail();
	}

	function getgroups($arr, $id, $allgroups)
	{
		for($i=0; $i < count($allgroups); $i++)
		{
			if ($allgroups[$i]->level_group_id != $id) continue;

			$arr[] = $allgroups[$i]->level_group_name;
			$this->getgroups(&$arr, $allgroups[$i]->level_group_parent, $allgroups);
		}
	}
	
	function dodetailnoothers($period)
	{
		$this->db->select("user.*, ildp_form.*, ildp_method.*, ildp_detail.*,ildp_development_area.*",false);
		//$this->db->select("ildp_catalog_training catalogname",false);
		$this->db->select("ildp_category_name categoryname",false);
		//$this->db->select("ildp_catalog_course_abb",false);
		$this->db->where("ildp_form_ildp_period", $period);
		$this->db->join("ildp_form", "ildp_user_id = user_id");
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id");
		//$this->db->join("ildp_catalog", "ildp_catalog_id = ildp_detail_category_id");
		//$this->db->join("ildp_category", "ildp_category_id = ildp_catalog_category");
		$this->db->join("ildp_category", "ildp_category_id = ildp_detail_category_id");
		$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id");
		$this->db->join("ildp_development_area", "dev_area_id = ildp_detail_devarea and ildp_category_areadev_type = 1", "left outer");
	
		$this->db->from("user");
		$sql = $this->db->_compile_select();
		
		$this->db->where("user_id", 0);
		$this->db->get();
		
		return $sql;
	}
	
	function dodetailothers($period)
	{
		$this->db->select("user.*, ildp_form.*, ildp_method.*, ildp_detail.*,ildp_development_area.*",false);
		//$this->db->select("ildp_detail_others catalogname",false);
		$this->db->select("'Others' categoryname", false);
		//$this->db->select("'' ildp_catalog_course_abb", false);
		$this->db->where("ildp_detail_category_id", 0);
		$this->db->where("ildp_form_ildp_period", $period);
		$this->db->join("ildp_form", "ildp_user_id = user_id");
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id");
		$this->db->join("ildp_method", "ildp_detail_method_id = ildp_method_id");
		$this->db->join("ildp_development_area", "dev_area_id = ildp_detail_devarea", "left outer");
	
		$this->db->from("user");
		$sql = $this->db->_compile_select();
		
		$this->db->where("user_id", 0);
		$this->db->get();
		
		return $sql;
	}
	
	function dodetail()
	{
		$lildp_form_header = $this->config->item("lildp_form_header");
		$llearning_method_dev =  $this->config->item("llearning_method_dev");
		$ltimeline = $this->config->item("ltimeline");
		
		$period = isset($_POST['period']) ? $_POST['period'] : "";
		
		$sql1 = $this->dodetailnoothers($period);
		$sql2 = $this->dodetailothers($period);
		
		$sql = sprintf("SELECT * FROM (%s UNION %s) t1 ORDER BY user_id ASC, ildp_detail_id ASC", $sql1, $sql2);
		$q = $this->db->query($sql);
		$rows = $q->result();
		
		// get groups level
		
		/*$groups = array();
		$this->levelmodel->getGroupChilds(&$groups, 0);
		
		for($i=0; $i < count($rows); $i++)
		{
			$arr = array();
			$this->getgroups(&$arr, $rows[$i]->jabatan_level_group, $groups);
			
			$rows[$i]->groupname = array_reverse($arr);
		}*/
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."ildp-detail.xls");
		
		$worksheet =& $this->xlswriter->addWorksheet("report");		

		$worksheet->write(0, 0, 'NO');
		$worksheet->write(0, 1, 'NPK');
		$worksheet->write(0, 2,  $this->config->item('name'));
		//$worksheet->write(0, 3, $this->config->item('lcourse_abb'));
		$worksheet->write(0, 3, $this->config->item('lcategory'));
		//$worksheet->write(0, 5, $lildp_form_header);
		$worksheet->write(0, 4, $this->config->item('ldevelopment_area'));
		$worksheet->write(0, 5, $llearning_method_dev);
		//$worksheet->write(0, 12, 'BUDGET');
		$worksheet->write(0, 6, $ltimeline);
		$worksheet->write(0, 7, $this->config->item('ltimeline'));
		$worksheet->write(0, 8, 'STATUS');
		$worksheet->write(0, 9, $this->config->item('lshort_term_description'));
		$worksheet->write(0, 10, $this->config->item('llong_term_description'));
		
		for($i=0; $i < count($rows); $i++)
		{
			$grades = explode(",", $rows[$i]->gradelist);
			$grades = array_filter($grades);
			
			$grade = implode(",", $grades);
			
			switch($rows[$i]->ildp_status)
			{
				case 0:
					if ($rows[$i]->ildp_form_rejector)
					{
						$status = "Rejected";
					}
					else
					{
						$status = "Draft";
					}
				break;
				case 1:
					$status = "Waiting";
				break;
				case 2:
					$status = "Approved";
				break;
			}
			
			$worksheet->write($i+1, 0, $i+1);
			$worksheet->write($i+1, 1, $rows[$i]->user_npk);
			$worksheet->write($i+1, 2, $rows[$i]->user_first_name." ".$rows[$i]->user_last_name);
			//$worksheet->write($i+1, 3, $rows[$i]->ildp_catalog_course_abb);
			$worksheet->write($i+1, 3, $rows[$i]->categoryname);
			//$worksheet->write($i+1, 5, $rows[$i]->catalogname);
			$worksheet->write($i+1, 4, ($rows[$i]->dev_area_id)?$rows[$i]->dev_area_title:$rows[$i]->ildp_detail_devarea);
				
			$worksheet->write($i+1, 5, $rows[$i]->ildp_method_name);
			//$worksheet->write($i+1, 12, $rows[$i]->ildp_detail_budget);
			$worksheet->write($i+1, 6, $rows[$i]->ildp_detail_timeline);
			$worksheet->write($i+1, 7, $rows[$i]->ildp_form_ildp_period);
			$worksheet->write($i+1, 8, $status);
			$worksheet->write($i+1, 9, $rows[$i]->ildp_form_short_term);
			$worksheet->write($i+1, 10, $rows[$i]->ildp_form_long_term);
		}

		$this->xlswriter->close();
	}
	
	function dorekap()
	{
		$period = isset($_POST['period']) ? $_POST['period'] : "";
		$rtype = isset($_POST['rekaptype']) ? $_POST['rekaptype'] : "";
				
		// total users per group
		
		$this->db->select("jabatan_level_group");
		$this->db->join("jabatan", "jabatan_id = user_jabatan");
		$this->db->where("user_status",1);
		$q = $this->db->get("user");
		
		$rows = $q->result();
		$users = array();
		for($i=0; $i < count($rows); $i++)
		{
			if (! isset($users[$rows[$i]->jabatan_level_group]))
			{
				$users[$rows[$i]->jabatan_level_group] = 1;
				continue;
			}
			
			$users[$rows[$i]->jabatan_level_group]++;
		}

		// input users per group
		
		$this->db->where("ildp_form_ildp_period", $period);
		$this->db->select("jabatan_level_group, ildp_status,ildp_form_rejector");
		$this->db->join("ildp_form", "ildp_user_id = user_id");
		$this->db->join("jabatan", "jabatan_id = user_jabatan");
		$this->db->where("user_status",1);
		$q = $this->db->get("user");
		
		$rows = $q->result();
		$ildpusers = array();
	
		for($i=0; $i < count($rows); $i++)
		{
			// total input
			
			if (! isset($ildpusers['totalinput'][$rows[$i]->jabatan_level_group]))
			{
				$ildpusers['totalinput'][$rows[$i]->jabatan_level_group] = 1;
			}
			else
			{
				$ildpusers['totalinput'][$rows[$i]->jabatan_level_group]++;
			}
			// reject
			if (($rows[$i]->ildp_status == 0) && $rows[$i]->ildp_form_rejector)
			{			
				
				if (! isset($ildpusers['totalreject'][$rows[$i]->jabatan_level_group]))
				{
					$ildpusers['totalreject'][$rows[$i]->jabatan_level_group] = 1;
				}
				else
				{				
					$ildpusers['totalreject'][$rows[$i]->jabatan_level_group]++;			
				}
			}
			
			// waiting
			if ($rows[$i]->ildp_status == 1)
			{			
				if (! isset($ildpusers['totalwaitingapprove'][$rows[$i]->jabatan_level_group]))
				{
					$ildpusers['totalwaitingapprove'][$rows[$i]->jabatan_level_group] = 1;
				}
				else
				{				
					$ildpusers['totalwaitingapprove'][$rows[$i]->jabatan_level_group]++;			
				}
			}
			
			// approve
			
			if ($rows[$i]->ildp_status == 2)
			{			
				if (! isset($ildpusers['totalapprove'][$rows[$i]->jabatan_level_group]))
				{
					$ildpusers['totalapprove'][$rows[$i]->jabatan_level_group] = 1;
				}
				else
				{				
					$ildpusers['totalapprove'][$rows[$i]->jabatan_level_group]++;			
				}
			}
			
		}
		
		// total budget

		$this->db->where("ildp_form_ildp_period", $period);
		$this->db->select("jabatan_level_group, SUM(ildp_detail_budget) totalbudget");
		$this->db->group_by("jabatan_level_group");
		$this->db->join("ildp_form", "ildp_user_id = user_id");
		$this->db->join("ildp_detail", "ildp_detail_ildp_id = ildp_id");
		$this->db->join("jabatan", "jabatan_id = user_jabatan");
		$this->db->where("user_status",1);
		$q = $this->db->get("user");
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			if (! isset($ildpusers['totalbudget'][$rows[$i]->jabatan_level_group]))
			{
				$ildpusers['totalbudget'][$rows[$i]->jabatan_level_group] = 0;
			}
			$ildpusers['totalbudget'][$rows[$i]->jabatan_level_group] += $rows[$i]->totalbudget;
		}
		
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-ildp-rekap_".$rtype.".xls");
		
		$worksheet =& $this->xlswriter->addWorksheet("report");		
		
		$this->rekap($worksheet, $rtype, $users, $ildpusers);
		$this->xlswriter->close();
		
	}

	function rekap($worksheet, $level, $users, $ildpusers)
	{		
		
		$masters = array();
		for($i=1; $i < $level; $i++)
		{
			$this->db->order_by("level_group_name", "asc");
			$this->db->where("level_group_nth", $i);
			$q = $this->db->get("level_group");
			
			$rows = $q->result();
			for($j=0; $j < count($rows); $j++)
			{
				$masters[$i][$rows[$j]->level_group_id] = $rows[$j];
			}
		}
				
		$this->db->order_by("level_group_name", "asc");
		$this->db->where("level_group_nth", $level);
		$q = $this->db->get("level_group");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			unset($arr);
			$arr[] = $rows[$i]->level_group_id;
			$this->levelmodel->getGroupChildIds(&$arr, $rows[$i]->level_group_id);
			
			for($j=0; $j < count($arr); $j++)
			{
				$groups[$arr[$j]] = $rows[$i]->level_group_id;
			}
		
			$dirs[$rows[$i]->level_group_id]['total'] = 0;
			$dirs[$rows[$i]->level_group_id]['totalinput'] = 0;
			$dirs[$rows[$i]->level_group_id]['totalwaitingapprove'] = 0;
			$dirs[$rows[$i]->level_group_id]['totalapprove'] = 0;
			$dirs[$rows[$i]->level_group_id]['totalreject'] = 0;
			$dirs[$rows[$i]->level_group_id]['totalbudget'] = 0;			
			$dirs[$rows[$i]->level_group_id]['data'] = $rows[$i];
		}
		
		// total karyawan
		
		if ($users)
		{
			foreach($users as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				
				$dirs[$groups[$groupid]]['total'] += $total;
			}
		}
		
		// input ildp

		if (isset($ildpusers['totalinput']))
		{
			foreach($ildpusers['totalinput'] as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				if (! isset($dirs[$groups[$groupid]]['totalinput']))
				{
					$dirs[$groups[$groupid]]['totalinput'] = 0;
				}
				
				$dirs[$groups[$groupid]]['totalinput'] += $total;
			}
		}

		// waiting approve

		if (isset($ildpusers['totalwaitingapprove']))
		{
			foreach($ildpusers['totalwaitingapprove'] as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				if (! isset($dirs[$groups[$groupid]]['totalwaitingapprove']))
				{
					$dirs[$groups[$groupid]]['totalwaitingapprove'] = 0;
				}
				
				$dirs[$groups[$groupid]]['totalwaitingapprove'] += $total;
			}
		}

		// total approve

		if (isset($ildpusers['totalapprove']))
		{
			foreach($ildpusers['totalapprove'] as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				if (! isset($dirs[$groups[$groupid]]['totalapprove']))
				{
					$dirs[$groups[$groupid]]['totalapprove'] = 0;
				}
				
				$dirs[$groups[$groupid]]['totalapprove'] += $total;
			}
		}

		// total reject

		if (isset($ildpusers['totalreject']))
		{
			foreach($ildpusers['totalreject'] as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				if (! isset($dirs[$groups[$groupid]]['totalreject']))
				{
					$dirs[$groups[$groupid]]['totalreject'] = 0;
				}
				
				$dirs[$groups[$groupid]]['totalreject'] += $total;
			}
		}
		
		// total budget

		if (isset($ildpusers['totalbudget']))
		{
			foreach($ildpusers['totalbudget'] as $groupid=>$total)
			{
				if (! isset($groups[$groupid])) continue;
				if (! isset($dirs[$groups[$groupid]]['totalbudget']))
				{
					$dirs[$groups[$groupid]]['totalbudget'] = 0;
				}
				
				$dirs[$groups[$groupid]]['totalbudget'] += $total;
			}
		}
				
		// header
		$cols = array("DIREKTORAT", "GROUP", "DEPARTEMEN", "UNIT");
	
		$worksheet->write(0, 0, 'NO');
		for($i=1; $i <= $level; $i++)
		{
			$worksheet->write(0, $i, $cols[$i-1]);
		}
		$worksheet->write(0, $i++, 'Total Karyawan yang sudah input ILDP Online');
		$worksheet->write(0, $i++, 'Total ILPD Pending (menunggu approval)');
		$worksheet->write(0, $i++, 'Total ILPD Approve');
		$worksheet->write(0, $i++, 'Total ILPD Reject');
		$worksheet->write(0, $i++, 'Total Karyawan yang belum input ILDP Online');
		$worksheet->write(0, $i++, 'Total Budget');
		$worksheet->write(0, $i++, 'Total Karyawan');

		if (! isset($dirs)) return;
			
		$i = 1;
		$cells = array();
		foreach($dirs as $id=>$val)
		{
			$cells[$i-1][0] = $i;
			$this->getParents($masters, $level, $val['data']->level_group_parent, &$cells, $i);

			$cells[$i-1][$level] = $val['data']->level_group_name;
			$cells[$i-1][2+$level-1] = $val['totalinput'];
			$cells[$i-1][3+$level-1] = $val['totalwaitingapprove'];
			$cells[$i-1][4+$level-1] = $val['totalapprove'];
			$cells[$i-1][5+$level-1] = $val['totalreject'];
			$cells[$i-1][6+$level-1] = $val['total']-$val['totalinput'];
			$cells[$i-1][7+$level-1] = $val['totalbudget'];
			$cells[$i-1][8+$level-1] = $val['total'];

			$i++;
		}
		
		switch($level)
		{
			case 1:
				$cells = array_filter($cells, filter1);
			break;
			case 2:				
				$cells = array_filter($cells, filter2);
				usort($cells, "sortbylevel2");
			break;
			case 3:				
				$cells = array_filter($cells, filter3);
				usort($cells, "sortbylevel3");
			break;
			case 4:				
				$cells = array_filter($cells, filter4);
				usort($cells, "sortbylevel4");
			break;

		}			
		
		$j = 1;
		foreach($cells as $cell)
		{
			$worksheet->write($j, 0, $j);
			for($i=1; $i <= 8+$level-1; $i++)
			{
				$worksheet->write($j, $i, $cell[$i]);
			}
			
			$j++;
		}
	}
	
	function getParents($masters, $level, $parent, $cells, $row)
	{
		$parents = array();
		for($i=$level-1; $i >= 1; $i--)
		{
			$cells[$row-1][$i] = isset($masters[$i][$parent]) ? $masters[$i][$parent]->level_group_name : "";
			$parent = isset($masters[$i][$parent]) ? $masters[$i][$parent]->level_group_parent : "";
		}
		
		return $parents;
	}	
}

function filter1($var)
{
    // returns whether the input integer is odd
    return ($var[8] > 0);
}

function filter2($var)
{
    // returns whether the input integer is odd
    return ($var[9] > 0);
}

function filter3($var)
{
    // returns whether the input integer is odd
    return ($var[10] > 0);
}

function filter4($var)
{
    // returns whether the input integer is odd
    return ($var[11] > 0);
}

function sortbylevel2($a, $b)
{
	$cmp = strcasecmp($a[1], $b[1]);	
	if ($cmp) return $cmp;
	
	return strcasecmp($a[2], $b[2]);
}

function sortbylevel3($a, $b)
{
	$cmp = strcasecmp($a[1], $b[1]);
	if ($cmp == 0) return $cmp;
	
	$cmp = strcasecmp($a[2], $b[2]);
	if ($cmp == 0) return $cmp;
	
	return strcasecmp($a[3], $b[3]);
}

function sortbylevel4($a, $b)
{
	$cmp = strcasecmp($a[1], $b[1]);
	if ($cmp == 0) return $cmp;
	
	$cmp = strcasecmp($a[2], $b[2]);
	if ($cmp == 0) return $cmp;
	
	$cmp = strcasecmp($a[3], $b[3]);
	if ($cmp == 0) return $cmp;
	
	return strcasecmp($a[4], $b[4]);
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
