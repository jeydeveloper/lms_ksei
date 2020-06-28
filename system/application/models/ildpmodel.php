<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ILDPModel extends Model {
	var $atasan;
		
	function ILDPModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}	
	
	function getILDPPeriod()
	{
		$q = $this->db->get("ildpsetting");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->ildpsetting_key] = $rows[$i]->ildpsetting_val;
		}
		
		if (! isset($settings['startreg']))	return false;
		if (! isset($settings['endreg'])) return false;
		
		$dyear = -100;
		while(1)
		{			
			if ($settings['endreg'] >= $settings['startreg'])
			{
				$startreg_t = mktime(0, 0, 0, $settings['startreg'], 1, date("Y")+$dyear);
				$endreg_t = mktime(0, 0, 0, $settings['endreg'], 1, date("Y")+$dyear);
			}
			else
			{
				$startreg_t = mktime(0, 0, 0, $settings['startreg'], 1, date("Y")+$dyear);
				$endreg_t = mktime(0, 0, 0, $settings['endreg'], 1, date("Y")+$dyear+1);			
			}
			
			if ($startreg_t > mktime()) return $last;
			
			$dyear++;
			$last =  array($startreg_t, $endreg_t);		
		}
		
		return false;
	}
	
	function isdraft($userid)
	{
		$regtime = $this->getILDPPeriod();
		
		$this->db->where("order_user", $userid);
		$this->db->where("order_status", 0);
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));
		$q = $this->db->get("order");
		if ($q->num_rows() == 0) return 0;
		
		$row = $q->row();
		return $row;
	}
	
	function isRegistrationTime($userid)
	{		
		// cek apakah sekarang saatnya pendaftaran

		$q = $this->db->get("ildpsetting");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->ildpsetting_key] = $rows[$i]->ildpsetting_val;
		}
		
		if (! isset($settings['startreg'])) return false;
		if (! isset($settings['endreg'])) return false;
		
		$now = mktime(0, 0, 0, date('n'), 1, date("Y"));
		
		$found = false;
		$dyear = -100;
		while(1)
		{
			if ($dyear > 1) break;
			
			if ($settings['endreg'] >= $settings['startreg'])
			{
				$startreg_t = mktime(0, 0, 0, $settings['startreg'], 1, date("Y")+$dyear);
				$endreg_t = mktime(0, 0, 0, $settings['endreg'], 1, date("Y")+$dyear);
			}
			else
			{
				$startreg_t = mktime(0, 0, 0, $settings['startreg'], 1, date("Y")+$dyear);
				$endreg_t = mktime(0, 0, 0, $settings['endreg'], 1, date("Y")+1+$dyear);			
			}

			if ($now < $startreg_t) 
			{
				$dyear++;
				continue;
			}
			
			if ($now > $endreg_t)
			{
				$dyear++;
				continue;				
			}
					
			$found = true;
			break;			
		}
		
		if (! $found) return false;
		
		$this->db->where("ildp_user_id", $userid);
		//$this->db->where("ildp_status <>", 0);
		$this->db->where("ildp_period_start >=", date("Y-m-d 00:00:00", $startreg_t));
		$this->db->where("ildp_period_end <=", date("Y-m-31 23:23:59", $endreg_t));
		$q = $this->db->get("ildp_form");
		if ($q->num_rows() > 0)
		{
			return false;
		}
				
		return array($startreg_t, $endreg_t);
	}
	
	function getngradereport()
	{		
		$q = $this->db->get("ildpsetting");
		
		if ($q->num_rows() == 0)
		{
			return $this->config->item("reportlevel");
		}
				
		$rows = $q->result();		
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->ildpsetting_key] = $rows[$i]->ildpsetting_val;
		}
		
		if (!  isset($settings['reportlevelcond1']))
		{
			return $this->config->item("reportlevel");
		}
		
		if (!  isset($settings['reportlevelval1']))
		{
			return $this->config->item("reportlevel");
		}

		if (!  isset($settings['reportlevelval2']))
		{
			return $this->config->item("reportlevel");
		}
		
		if ($this->sess['user_grade_code'] <= $settings['reportlevelcond1'])
		{
			return $settings['reportlevelval1'];
		}		
		
		return $settings['reportlevelval2'];
	}
	
	function atasan($npk, &$arr)
	{
		if (count($arr) == 0)
		{
			$this->atasan = array();
		}
		
		if (count($arr) >= $this->getngradereport()) return;
		
		$this->db->where("user_npk", $npk);
		$this->db->join("jabatan", "jabatan_id = user_jabatan");
		$q = $this->db->get("user");
		
		if ($q->num_rows() == 0) return;
		
		$row = $q->row();

		if (in_array($row->user_npk_atasan, $this->atasan)) return;
		
		array_push($this->atasan, $npk);
		array_push($arr, $row);
		$this->atasan($row->user_npk_atasan, $arr);
	}
	
	function getHRLDTopic($userid, $topicmodel)
	{
		$this->db->where("hrld_status", 1); 
		$this->db->where_in("hrld_npk", $userid); 
		$q = $this->db->get("hrld");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		
		$categories = array();
		for($i=0; $i < count($rows); $i++)
		{
			$categories[] = $rows[$i]->hrld_category;
			$topicmodel->getAllTopics($categories, $rows[$i]->hrld_category);
		}
			
		return $categories;
	}
	
	function isHRRM($userid)
	{
		$this->db->where("hrrm_status", 1); 
		$this->db->where("hrrm_npk", $userid); 
		$q = $this->db->get("hrrm");
		
		if ($q->num_rows() == 0) return false;
		
		return true;
	}

	function getHRRM($userid, $levelmodel)
	{
		$this->db->where("hrrm_status", 1); 
		$this->db->where_in("hrrm_npk", $userid); 
		$q = $this->db->get("hrrm");
		
		if ($q->num_rows() == 0) return;
		
		$rows = $q->result();
		
		$groups = array();
		for($i=0; $i < count($rows); $i++)
		{
			$groups[] = $rows[$i]->hrrm_group;
			$levelmodel->getGroupChildIds($groups, $rows[$i]->hrrm_group);
		}
			
		return $groups;
	}
	
	function isHRLD($userid)
	{
		$this->db->where("hrld_status", 1); 
		$this->db->where("hrld_npk", $userid); 
		$q = $this->db->get("hrld");
		
		if ($q->num_rows() == 0) return false;
		
		return true;
	}	
	
	function loaddraft($userid)
	{
		$regtime = $this->isRegistrationTime($userid);
		if (! $regtime)
		{
			return;
		}		
		
		$this->db->where("order_date >=", date("Y-m-d 00:00:00", $regtime[0]));
		$this->db->where("order_date <=", date("Y-m-31 23:23:59", $regtime[1]));		
		$this->db->where("order_user", $userid);
		$this->db->where("order_status", 0);
		//$this->db->where("training_status", 1);
		$this->db->join("order_catalog", "order_id = order_catalog_order");
		$this->db->join("training", "order_catalog_catalog = training_id");
		$q = $this->db->get("order");
		$rowsildp = $q->result();
		
		for($i=0; $i < count($rowsildp); $i++)
		{
			$ildpcarts[$rowsildp[$i]->order_catalog_catalog] = $rowsildp[$i]->order_catalog_period;
		}
		
		if (isset($ildpcarts))
		{
			$this->session->set_userdata("ildp", $ildpcarts);
		}		
	}
	
	function getLastStatus($order)
	{
		switch($order->order_status)
		{
			case 0:
				if ($order->order_rejected)
				{
					 return sprintf($this->config->item("lrejected_by"), "(".$order->rejector_npk.") ".$order->rejector_firstname." ".$order->rejector_last_name);
				}
				
				if ($order->order_resetted)
				{
					return sprintf($this->config->item("lreset_by"), "(".$order->resettor_npk.") ".$order->resettor_firstname." ".$order->resettor_last_name);
				}

				return $this->config->item("ldraft");
			case 1:					
			case 2:
				$this->db->order_by("order_catalog_report_order", "desc");
				$this->db->limit(1, 0);
				$this->db->where("order_catalog_report_status", 1);
				$this->db->where("order_catalog_report_catalog", $order->order_id);
				$this->db->join("user", "user_id = order_catalog_report_approver");
				$q = $this->db->get("order_catalog_report");
								
				if ($q->num_rows() == 0)
				{
					return $this->config->item("lsubmitted");
				}

				$rowapproved = $q->row();					
				return $this->config->item("lapproved_by")." (".$rowapproved->user_npk.") ".$rowapproved->user_first_name." ".$rowapproved->user_last_name;
			case 3:
				$this->db->select("order.*, rejector.user_npk rejector_npk, rejector.user_first_name rejector_firstname, rejector.user_last_name rejector_last_name, hrrmor.user_npk hrrmor_npk, hrrmor.user_first_name hrrmor_firstname, hrrmor.user_last_name hrrmor_last_name, hrldor.user_npk hrldor_npk, hrldor.user_first_name hrldor_firstname, hrldor.user_last_name hrldor_last_name");
				$this->db->where("order_id", $order->order_id);
				$this->db->join("user rejector", "rejector.user_id = order_rejected", "left outer");
				$this->db->join("user hrrmor", "hrrmor.user_id = order_hrrm", "left outer");
				$this->db->join("user hrldor", "hrldor.user_id = order_hrld", "left outer");
				$q = $this->db->get("order");
				
				$rowhrrm = $q->row();
			
				return $this->config->item("lapproved_by")." (".$rowhrrm->hrrmor_npk.") ".$rowhrrm->hrrmor_firstname." ".$rowhrrm->hrrmor_last_name;
			break;
			case 4:
				return $this->config->item("lapproved_by")." (".$order->hrldor_npk.") ".$order->hrldor_firstname." ".$order->hrldor_last_name;
			break;				
		}		
	}	
	
	function isValidRejector($userid, $topicmodel)
	{
		if ($this->sess['asadmin'])
		{
			return true;
		}
		
		return $this->isValidApproval($userid, $topicmodel);		
	}
	
	function isValidApproval($userid, $topicmodel)
	{
			$this->db->order_by("order_date", "desc");
			$this->db->where("order_user", $userid);
			$this->db->limit(1);
			$q = $this->db->get("order");
			
			if ($q->num_rows() == 0) return false;
			
			$roworder = $q->row();
			
			// get delegator
			
			$this->db->where('delegetion_ildp_delegator', $this->sess['user_id']);
			$this->db->where('delegetion_ildp_status', 1);
			$q = $this->db->get("delegetion_ildp");
			
			$rows = $q->result();
			
			$delegator[] = $this->sess['user_id'];
			for($i=0; $i < count($rows); $i++)
			{
				$delegator[] = $rows[$i]->delegetion_ildp_user;
			}
						
			if ($roworder->order_status == 1)
			{
				// last approved
				
				$this->db->order_by("order_catalog_report_order", "desc");
				$this->db->where("order_catalog_report_status", 1);
				$this->db->where("order_catalog_report_catalog", $roworder->order_id);
				$this->db->limit(1);
				
				$q = $this->db->get("order_catalog_report");
				
				if ($q->num_rows() == 0) 
				{
					$order = 1;
				}
				else
				{
					$rowapproved = $q->row();
					$order = $rowapproved->order_catalog_report_order+1;
				}												

				$this->db->where("order_catalog_report_order", $order);
				$this->db->where("order_catalog_report_status", 0);
				$this->db->where("order_catalog_report_catalog", $roworder->order_id);
				$this->db->where_in("order_catalog_report_user", $delegator);
				$this->db->limit(1);				
				$q = $this->db->get("order_catalog_report");

				if ($q->num_rows() == 0) return false;
				
				return true;	
			}
			
			if ($roworder->order_status == 2)
			{								
				$groups = $this->getHRRM($delegator, $this->levelmodel);
				if (! count($groups)) return false;								
				
				$this->db->where("user_id", $userid);
				$this->db->where_in("jabatan_level_group", $groups);
				$this->db->join("jabatan", "user_jabatan = jabatan_id");
				$total = $this->db->count_all_results("user");			

				return ($total > 0);
			}

			if ($roworder->order_status == 3)
			{				
				$categories = $this->ildpmodel->getHRLDTopic($delegator, $topicmodel);
				
				if (! count($categories)) return false;
				
				$this->db->distinct();
				$this->db->where_in("training_topic", $categories);
				$this->db->where("order_catalog_order", $roworder->order_id);
				$this->db->join("training", "training_id = order_catalog_catalog");
				$total = $this->db->count_all_results("order_catalog");				
				
				return ($total > 0);
			}
			
			return false;
	}
	
	function getApprovalHist()
	{
		$orderids[] = 0;
		
		// atasan
		
		$this->db->distinct();
		$this->db->select("order_catalog_report_catalog");
		$this->db->where("(order_catalog_report_approver = '".$this->sess['user_id']."' and order_catalog_report_status = 1) or (order_catalog_report_user = '".$this->sess['user_id']."' and order_catalog_report_status = 1) ", null);
		$q = $this->db->get("order_catalog_report");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$orderids[] = $rows[$i]->order_catalog_report_catalog;
		}
		
		// hrrm atau hrld

		$this->db->distinct();
		$this->db->select("order_id");
		$this->db->where("order_hrrm = '".$this->sess['user_id']."' or order_hrld = '".$this->sess['user_id']."' or order_rejected = '".$this->sess['user_id']."'", null);
		$q = $this->db->get("order");

		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			$orderids[] = $rows[$i]->order_id;
		}	
		
		return $orderids;	
	}
	
	function getSetting()
	{
		$q = $this->db->get("ildpsetting");
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$settings[$rows[$i]->ildpsetting_key] = $rows[$i]->ildpsetting_val;
		}
		
		return $settings;
	}
	
}
