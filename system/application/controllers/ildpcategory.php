<?php
include_once "base.php"; 

class ILDPCategory extends Base{
	var $language;
	var $modules;
	var $sess;
	var $itot;

	function ILDPCategory()
	{
		//parent::Controller();	
		parent::Base();	
				
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');
		
		$this->load->helper('url');	
		$this->load->helper('common');
		$this->load->helper('email');
		
		$this->load->model("ildpcategorymodel");
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
		
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
		$this->langmodel->init();
		
		if(!$this->modules['ildpadmin']){
			redirect('user');
			exit;
		} 	
		
		if ($this->showildp != 1)
		{
			redirect(base_url());
			exit;
		}
	}
	
	function index()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $this->config->item('data_per_page');
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = "ildp_category_order";
		$orderby = "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		
		
		$sess = unserialize($usess);

		if (! isset($this->modules['ildpadmin']))
		{
			redirect(base_url());
		}
						
		if ($keyword && $searchby)
		{
			$this->db->order_by($sortby, $orderby);
			$this->db->where("UPPER(ildp_category_name) LIKE", "%".strtoupper($keyword)."%");
			$q = $this->db->get("ildp_category");
			$this->db->flush_cache();
			
			$rowcategories = $q->result();
			
			$categoryids[] = 0;
			for($i=0; $i < count($rowcategories); $i++)
			{				
				$categoryids[] = $rowcategories[$i]->ildp_category_id;
				
				$this->ildpcategorymodel->getParentIds($rowcategories[$i]->ildp_category_id, $categoryids);
			}			
			
			$categoryids = array_unique($categoryids);			
		}				

		$trees = array();				
		
		$this->ildpcategorymodel->getArrayTree($trees, 0, $sortby, $orderby, isset($categoryids) ? $categoryids : false);
		
		$used = $this->ildpcategorymodel->getUsed();
		
		$s = "";
		$this->itot = 0;
		$this->display($s, $trees, 0, $used);
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
						
		$this->mysmarty->assign("lconfirm_change_status", $this->config->item('lconfirm_change_status'));
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("name", strtoupper($this->config->item('name')));
		$this->mysmarty->assign("category_name", strtoupper($this->config->item('category_name')));
		$this->mysmarty->assign("lcategory_name", $this->config->item('category_name'));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		$this->mysmarty->assign("lildp_category_list", $this->config->item('ildp_category_list'));
		$this->mysmarty->assign("lildp_header_list_category", $this->config->item('ildp_header_list_category'));
		$this->mysmarty->assign("lmax_line", $this->config->item('lmax_line'));
		$this->mysmarty->assign("ltype_area_development", $this->config->item('ltype_area_development'));
						
		$this->mysmarty->assign("tree_html", $s);
		$this->mysmarty->assign("lview_options", $this->config->item("lview_options"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpcategory/list.html");
		$this->mysmarty->display("sess_template.html");				
	}

	function display(&$s, $tree, $level, $used=false)
	{							
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		$sess = unserialize($usess);
					
		for($i=0; $i < count($tree); $i++)
		{			
			$s .= '<tr'. 	(($this->itot%2) ? 'class="odd"' : '').'>';
			$s .= '<td class="odd">';
			
			for($j=0; $j < $level; $j++)
			{
				$s .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			$s .= '	<a href="'.site_url().'/ildpcategory/form/'.$tree[$i]->ildp_category_id.'">'.$tree[$i]->ildp_category_name.'</a>';
			
			$s .= '</td>';
			
			$s .= "<td>".$tree[$i]->ildp_category_maxline."</td>";
			$s .= "<td>".(($tree[$i]->ildp_category_areadev_type == 1)? $this->config->item("ldropbox") : $this->config->item("lfree_text"))."</td>";
			
			if (isset($this->modules['ildpadmin']))
			{
				$imgstat = '<img src="'.base_url().'images/16/'.(($tree[$i]->ildp_category_status != 1) ? "inactive.png" : "active.png").'" border="0" title="'.(($tree[$i]->ildp_category_status != 1) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($tree[$i]->ildp_category_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
				
				$s .= '<td class="odd"><div id="status'.$tree[$i]->ildp_category_id.'"><a href="#" onclick="javascript:chagestatus('.$tree[$i]->ildp_category_id.','.$tree[$i]->ildp_category_status.')">'.$imgstat.'</a></div></td>';
				
				if (count($tree) > 1)
				{
					if ($i == 0)
					{
						$s .= '<td>';
						$s .= '&nbsp;';
						$s .= '</td>';
						$s .= '<td>';
						$s .= '<a href="'.site_url().'/ildpcategory/down/'.$tree[$i]->ildp_category_id.'" onclick="javascript: return confirm(\''.$this->config->item('lconfirm_change_order').'\')">'.$this->config->item('ldown').'</a>';
						$s .= '</td>';
					}
					else
					if (($i+1) == count($tree)) 
					{
						$s .= '<td>';						
						$s .= '<a href="'.site_url().'/ildpcategory/up/'.$tree[$i]->ildp_category_id.'" onclick="javascript: return confirm(\''.$this->config->item('lconfirm_change_order').'\')">'.$this->config->item('lup').'</a>';
						$s .= '</td>';
						$s .= '<td>';
						$s .= '&nbsp;';
						$s .= '</td>';
					}
					else
					{
						$s .= '<td>';
						$s .= '<a href="'.site_url().'/ildpcategory/up/'.$tree[$i]->ildp_category_id.'" onclick="javascript: return confirm(\''.$this->config->item('lconfirm_change_order').'\')">'.$this->config->item('lup').'</a>';
						$s .= '</td>';
						$s .= '<td>';						
						$s .= '<a href="'.site_url().'/ildpcategory/down/'.$tree[$i]->ildp_category_id.'" onclick="javascript: return confirm(\''.$this->config->item('lconfirm_change_order').'\')">'.$this->config->item('ldown').'</a>';
						$s .= '</td>';
					}					
				}
				
				if (isset($tree[$i]->child))
				{
					$s .= '<td>&nbsp;</td>';
				}
				else
				if (is_array($used) && isset($used[$tree[$i]->ildp_category_id]))
				{
					$s .= '<td>&nbsp;</td>';
				}
				else 
				if (strcasecmp($tree[$i]->ildp_category_name, "others") == 0)
				{
					$s .= '<td>&nbsp;</td>';
				}
				else
				{
					$s .= '<td>';
					$s .= '<a href="'.site_url().'/ildpcategory/remove/'.$tree[$i]->ildp_category_id.'" onclick="javascript: return confirm(\''.$this->config->item('confirm_delete').'\');"><img src="'.base_url().'images/b_del.gif" width="12" height="12" border="0" /></a>';					
					$s .= '</td>';
		
				}
			}
			
			$s .= '</tr>';			
			
			$this->itot++;
			if (isset($tree[$i]->child))
			{
				$this->display($s, $tree[$i]->child, $level+1, $used);
			}
		}		
	}

	function form($edit=0)
	{
		if (! isset($this->modules['ildpadmin']))
		{
			redirect(base_url());
		}
				
		if ($edit)
		{
			$this->db->where("ildp_category_id", $edit);
			$q = $this->db->get("ildp_category");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("catedit", $row);	
			
			$def = $row['category_parent'];
			$ltitle_form = $this->config->item("ledit_ildp_category");		
		}
		else
		{
			$ltitle_form = $this->config->item("ladd_ildp_category");
			$def = 0;
		}
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		
		$tree = "";
		$this->ildpcategorymodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
		$this->mysmarty->assign("lmax_line", $this->config->item("lmax_line"));
		$this->mysmarty->assign("category_desc", $this->config->item("category_desc"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("category_name", $this->config->item("category_name"));		
		$this->mysmarty->assign("ok_save_category", $edit ? $this->config->item("ok_update_category") : $this->config->item("ok_add_category"));		
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("lparent", $this->config->item("lparent"));
		$this->mysmarty->assign("lroot", $this->config->item("lroot"));	
		$this->mysmarty->assign("tree", $tree);		
		$this->mysmarty->assign("type", 0);	
		$this->mysmarty->assign("lconfirm_ildp_category_save", $this->config->item("lconfirm_ildp_catalog_save"));
		$this->mysmarty->assign("lconfirm_reset_data", $this->config->item("lconfirm_reset_data"));
		$this->mysmarty->assign("ltype_area_development", $this->config->item("ltype_area_development"));		
		$this->mysmarty->assign("lfree_text", $this->config->item("lfree_text"));
		$this->mysmarty->assign("ldropbox", $this->config->item("ldropbox"));
		
		$this->mysmarty->assign("left_content", "ildp/menu.html");
		$this->mysmarty->assign("main_content", "ildpcategory/form.html");
		$this->mysmarty->display("sess_template.html");		
	}

	function save($edit=0)
	{
		if (! isset($this->modules['ildpadmin']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";		
		$status = isset($_POST['status']) ? trim($_POST['status']) : 1;
		$parent = isset($_POST['parent']) ? trim($_POST['parent']) : 0;
		$maxline = isset($_POST['maxline']) ? trim($_POST['maxline']) : 0;
		$typeareadev = isset($_POST['typeareadev']) ? trim($_POST['typeareadev']) : 2;
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("ildp_category_name", addslashes($name));
			$this->db->where("ildp_category_parent", $parent);
			$q = $this->db->get("ildp_category");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->ildp_category_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
				}				
			}
			
		}
		
		if (! is_numeric($maxline))
		{
			$errs[] = $this->config->item("linvalid_max_line");
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

		
		if(!$edit) {
			$this->db->select_max("ildp_category_order");
			$q = $this->db->get("ildp_category");
			
			if ($q->num_rows() == 0)
			{
				$max = 1;
			}
			else
			{
				$row = $q->row();
				$max = $row->ildp_category_order+1;
			}
			
			$data['ildp_category_order'] = $max;
		}
		
		$data['ildp_category_name'] = addslashes($name);
		$data['ildp_category_status'] = $status;				
		$data['ildp_category_parent'] = $parent;
		$data['ildp_category_desc'] = $_POST['desc'];
		$data['ildp_category_maxline'] = $maxline;
		$data['ildp_category_areadev_type'] = $typeareadev;
		
		$data['ildp_category_modified_by'] = $this->sess['user_id'];
		$data['ildp_category_modified_time'] = date("Y-m-d H:i:s");

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("ildp_category_id", $edit);
			
			$this->db->update("ildp_category", $data);
		}
		else
		{
			$data['ildp_category_created'] = date("Ymd");
			$data['ildp_category_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("ildp_category", $data);
		}
	}	

	function changestatus($id=0, $status=0)
	{
		if 	(! isset($this->modules['ildpadmin']))
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
		
		$childs[] = $id;
		$this->ildpcategorymodel->getChildIds($id, $childs);
		
		unset($data);
		$data['ildp_category_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where_in("ildp_category_id", $childs);				
		$this->db->update("ildp_category", $data);				
	}

	function remove($id=0)
	{
		if 	(! isset($this->modules['ildpadmin']))
		{
			redirect(base_url());
		}
				
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("ildp_category_id", $id);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$used = $this->ildpcategorymodel->GetUsed();
		if (isset($used[$id]))
		{
			redirect(base_url());
		}

		$row = $q->row();
		
		$this->db->where("ildp_category_id", $id);
		$this->db->delete("ildp_category");
		
		redirect(site_url(array("ildpcategory")));
	}
	
	function up($id)
	{
		$this->db->where("ildp_category_id", $id);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$this->db->limit(1);
		$this->db->order_by("ildp_category_order", "desc");
		$this->db->where("ildp_category_order <", $row->ildp_category_order);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
			//redirect(base_url());
				redirect("ildpcategory");
		}
		
		$rowup = $q->row();
		
		// naik
		
		unset($update);
		
		$update['ildp_category_order'] = $rowup->ildp_category_order;
		
		$this->db->where("ildp_category_id", $row->ildp_category_id);
		$this->db->update("ildp_category", $update);
		
		// turun

		unset($update);
		
		$update['ildp_category_order'] = $row->ildp_category_order;
		
		$this->db->where("ildp_category_id", $rowup->ildp_category_id);
		$this->db->update("ildp_category", $update);
		
		$this->index();
		
	}

	function down($id)
	{
		$this->db->where("ildp_category_id", $id);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$row = $q->row();
		
		$this->db->limit(1);
		$this->db->order_by("ildp_category_order", "asc");
		$this->db->where("ildp_category_order >", $row->ildp_category_order);
		$q = $this->db->get("ildp_category");
		
		if ($q->num_rows() == 0)
		{
			//redirect(base_url());
			redirect("ildpcategory");
		}
		
		$rowdown = $q->row();
		
		// naik
		
		unset($update);
		
		$update['ildp_category_order'] = $rowdown->ildp_category_order;
		
		$this->db->where("ildp_category_id", $row->ildp_category_id);
		$this->db->update("ildp_category", $update);
		
		// turun

		unset($update);
		
		$update['ildp_category_order'] = $row->ildp_category_order;
		
		$this->db->where("ildp_category_id", $rowdown->ildp_category_id);
		$this->db->update("ildp_category", $update);
		
		$this->index();
		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
