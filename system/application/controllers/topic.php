<?php
include_once "base.php"; 

class Topic extends Base {
	var $sess;
	var $lang;
	var $itot;
	var $modules;

	function Topic()
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
		$this->load->model("topicmodel");
		$this->load->model("langmodel");
		$this->load->model("commonmodel");
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
		}		
		$this->langmodel->init();
						
	}
	
	function onlinetraining()
	{
		$this->index(0, 1);
	}
	
	function certificate()
	{
		$this->index(0, 2);
	}

	function resources()
	{
		$this->index(0, 4);
	}
	
	function classroom()
	{
		$this->index(0, 3);
	}

	function index($catid=0, $trainingtype=-1)
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$recordperpage = $this->commonmodel->getRecordPerPage();
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $recordperpage;		
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "category_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";
		
		$sess = unserialize($usess);
		
		if ($sess['user_type'])
		{
			if (
					(! isset($this->modules['topic']))
				&& 	(! isset($this->modules['training']))
				&&	(! isset($this->modules['certificate']))
				&&	(! isset($this->modules['resources']))
				&&	(! isset($this->modules['trainee']))
			)
			{
				redirect(base_url());
			}
		}
		
		// cek apakah trainee punya training/certificate/resource/classroom
		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{			
			$arrtopicids = array();
			$arrtopictrainingids = array();
			$arrtopiccertificateids = array();
			$arrtopicresourceids = array();
			$arrtopiccatalogids = array();
			
			$this->topicmodel->getTopicsUser($sess, $arrtopicids, $arrtopictrainingids, $arrtopiccertificateids, $trainingtype);	
			if (($trainingtype == -1) || ($trainingtype == 4))
			{
				$this->topicmodel->getResourcesTopicsUser($sess, $arrtopicresourceids);								
			}	

			if (($trainingtype == -1) || ($trainingtype == 3))
			{
				$this->topicmodel->getCatalogsTopicsUser($sess, $arrtopiccatalogids);
			}
						
			
			$topicids = count($arrtopicids) ? array_keys($arrtopicids) : array(0);
			$topictrainingids = count($arrtopictrainingids) ? array_keys($arrtopictrainingids) : array(0);
			$topiccertificateids = count($arrtopiccertificateids) ? array_keys($arrtopiccertificateids) : array(0);						
			$topicresourceids = count($arrtopicresourceids) ? array_keys($arrtopicresourceids) : array(0);	
			$topiccatalogids = count($arrtopiccatalogids) ? array_keys($arrtopiccatalogids) : array(0);
			
			// cek apakah sudah ada topic dalam history
			
			$this->db->distinct();
			$this->db->select("category_id");
			$this->db->where_in("category_id", $topicids);
			$this->db->join("training", "training_id = history_exam_training");			
			$this->db->join("category", "category_id = training_topic");
			$q = $this->db->get("history_exam");
			$this->db->flush_cache();
			
			$rowexams = $q->result();
			for($i=0; $i < count($rowexams); $i++)
			{
				$exams[$rowexams[$i]->category_id] = true;
			}
			
			// cek apalah sudah ada topic dalam history resource
			
			$this->db->distinct();
			$this->db->select("category_id");
			$this->db->where_in("category_id", $topicresourceids);
			$this->db->join("reference", "reference_id = history_reference_reference");			
			$this->db->join("category", "category_id = reference_topic");
			$q = $this->db->get("history_reference");
			$this->db->flush_cache();
			
			$rowtakeresources = $q->result();
			for($i=0; $i < count($rowtakeresources); $i++)
			{
				$takeresources[$rowtakeresources[$i]->category_id] = true;
			}
			
			
			
			if ($catid)
			{
				$this->db->where("category_id", $catid);
				$q = $this->db->get("category");
				$this->db->flush_cache();
				
				if ($q->num_rows() == 0)
				{
					redirect(base_url());
				}
				
				$rowcatid = $q->row();
				$this->mysmarty->assign("rowcatid", $rowcatid);
			}
		}
		
		if ($keyword && $searchby && ($searchby == "category_parent"))
		{
			$this->db->where("UPPER(category_name) LIKE", "%".strtoupper($keyword)."%");
			$this->db->where("category_type", 0);
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			$rowcategories = $q->result();
			
			$categoryids[] = 0;
			for($i=0; $i < count($rowcategories); $i++)
			{				
				$categoryids[] = $rowcategories[$i]->category_id;
				
				$this->topicmodel->GetChildIds($rowcategories[$i]->category_id, $categoryids);
			}
			
			$categoryids = array_unique($categoryids);		
		}	

		$this->db->order_by($sortby, $orderby);
		$q = $this->db->select("*, CASE category_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END category_status_desc ", false);
		
		if ($keyword && $searchby)
		{
			if (in_array($searchby, array("category_code", "category_name")))
			{
				$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
			}
			else
			if ($searchby == "category_parent")
			{
				$this->db->where_in("category_parent", $categoryids);
			}			
		}
				
		if ($limit)
		{			
			if (isset($topicids))
			{
				$this->db->where_in("category_id", array_merge($topicids, $topicresourceids, $topiccatalogids));
			}
			
			if ($catid)
			{
				$this->db->where("category_parent", $catid);
			}

			if (! isset($sess['asadmin']))
			{
				$this->db->where("category_status", 1);
			}
			
			$this->db->where("category_type", 1);
			$this->db->where("category_parent <>", 0);
			$q = $this->db->get("category", $limit, $offset);
		}
		else
		{			
			if (isset($topicids))
			{
				$this->db->where_in("category_id", array_merge($topicids, $topicresourceids, $topiccatalogids));
			}
			
			if ($catid)
			{
				$this->db->where("category_parent", $catid);
			}			
			
			if (! isset($sess['asadmin']))
			{
				$this->db->where("category_status", 1);
			}

			$this->db->where("category_type", 1);
			$this->db->where("category_parent <>", 0);
			$q = $this->db->get("category");
		}		
		
		$list = $q->result();
		//print_r($list);
		//echo $this->db->last_query();
		
		$used = $this->topicmodel->GetUsed();
		
		for($i=0; $i < count($list); $i++)
		{
			$topparent = $this->topicmodel->getCategory($list[$i]->category_id);
			if (! $topparent) continue;
			
			$categories = array();
			$this->topicmodel->getCategoryRows(array($list[$i]->category_id), $categories);
			
			if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
			{
				$list[$i]->hastakeresources = isset($takeresources[$list[$i]->category_id]);
				$list[$i]->hasexam = isset($exams[$list[$i]->category_id]);
				$list[$i]->hastraining = isset($topictrainingids) && in_array($list[$i]->category_id, $topictrainingids);
				$list[$i]->hascertificate = isset($topiccertificateids) && in_array($list[$i]->category_id, $topiccertificateids);
				$list[$i]->hasresources = isset($topicresourceids) && in_array($list[$i]->category_id, $topicresourceids);				
				$list[$i]->hascatalogs = isset($topiccatalogids) && in_array($list[$i]->category_id, $topiccatalogids) && $this->ildpmodel->isRegistrationTime($this->sess['user_id']);
			}
			else
			{
				$list[$i]->hastakeresources = false;
				$list[$i]->hasexam = false;
				$list[$i]->hastraining = true;
				$list[$i]->hascertificate = true;
				$list[$i]->hasresources = true;
				$list[$i]->hascatalogs = false;
			}
			
			
			$list[$i]->topcategory = $categories[count($categories)-1];
			$list[$i]->category = $topparent;
			$list[$i]->used = isset($used[$list[$i]->category_id]);
		}
		
		if ($sortby == "category_id")
		{
			usort($list, "sort_topic_cat_".$orderby);
		}

		if (isset($topicids))
		{
			$this->db->where_in("category_id", array_merge($topicids, $topicresourceids, $topiccatalogids));
		}
		
		if ($catid)
		{
			$this->db->where("category_parent", $catid);
		}
		
		if (! isset($sess['asadmin']))
		{
			$this->db->where("category_status", 1);
		}

		if ($keyword && $searchby)
		{
			if (in_array($searchby, array("category_code", "category_name")))
			{
				$this->db->where("UPPER(".$searchby.") LIKE ", "%".strtoupper($keyword)."%");
			}
			else
			if ($searchby == "category_parent")
			{
				$this->db->where_in("category_parent", $categoryids);
			}			
		}
						
		$this->db->where("category_type", 1);
		$total = $this->db->count_all_results("category");
		$this->db->flush_cache();
		
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
		switch($trainingtype)
		{
			case 1:
				$this->pagination1->lang_title = $this->config->item('online_training');
			break;
			case 2:
				$this->pagination1->lang_title = $this->config->item('certification');
			break;			
			case 3:
				$this->pagination1->lang_title = $this->config->item('classroom_training');
			break;			
			case 4:
				$this->pagination1->lang_title = $this->config->item('resources');
			break;			
			default:
				$this->pagination1->lang_title = $this->config->item('ltopic');
		}
		
		$this->pagination1->lang_per_page = $this->config->item('per_page');
		$this->pagination1->limits = $limits;
		$this->pagination1->lang_of = $this->config->item('of');
		$this->pagination1->total_records = count($list);
		$this->pagination1->cur_page = $offset;

		$this->mysmarty->assign("paging", $this->pagination1->create_links());		
				
		$this->mysmarty->assign("hasrighttopic", isset($this->modules['topic']));
		$this->mysmarty->assign("hasrightcategory", isset($this->modules['category']));
		$this->mysmarty->assign("hasrighttraining", isset($this->modules['training']));
		$this->mysmarty->assign("hasrightcertificate", isset($this->modules['certificate']));		
		$this->mysmarty->assign("hasrightresources", isset($this->modules['resources']));
		
		$this->mysmarty->assign("currenturl", current_url());
		$this->mysmarty->assign("trainingtype", $trainingtype);
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("header_list_topic", $this->config->item('header_list_topic'));
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));

		$this->mysmarty->assign("lclassroom", ucfirst($this->config->item('lclassroom')));
		$this->mysmarty->assign("topic", ucfirst($this->config->item('topic')));
		$this->mysmarty->assign("lcategory", strtoupper($this->config->item('category')));
		$this->mysmarty->assign("status", strtoupper($this->config->item('status')));
		$this->mysmarty->assign("learning_topics_list", ucfirst($this->config->item('learning_topics_list')));
		$this->mysmarty->assign("topic_code", ucfirst($this->config->item('topic_code')));	
		$this->mysmarty->assign("lsort_by_topic_code", ucfirst($this->config->item('lsort_by_topic_code')));	
		$this->mysmarty->assign("lsort_by_topic_name", ucfirst($this->config->item('lsort_by_topic_name')));	
			
		$this->mysmarty->assign("online_training", $this->config->item('online_training'));		
		$this->mysmarty->assign("lcertificate", $this->config->item('lcertificate'));
		$this->mysmarty->assign("resources", $this->config->item('resources'));
		$this->mysmarty->assign("classroom_training", $this->config->item('classroom_training'));			
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		$this->mysmarty->assign("topic_code1", ucfirst($this->config->item('topic_code')));
				
		$this->mysmarty->assign("ltaken", getconfig('ltaken'));
		$this->mysmarty->assign("list", $list);
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/list_topic.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function category()
	{
		$usess = $this->session->userdata('lms_sess');	
		if (! $usess)
		{
			redirect(base_url());
		}
		
		$limit = isset($_POST['limit']) ? $_POST['limit'] :  $this->config->item('data_per_page');
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
		$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : "category_name";
		$orderby = isset($_POST["orderby"]) ? $_POST["orderby"] : "asc";
		$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
		$searchby = isset($_POST["searchby"]) ? $_POST["searchby"] : "";		
		
		$sess = unserialize($usess);

		if ( 	TRUE
			&& (! isset($this->modules['category']))
			&& (! isset($this->modules['trainee']))
		)
		{
			redirect(base_url());
		}
		
		
		if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
		{		
			$arrtopicids = array();
			$arrtopictrainingids = array();
			$arrtopiccertificateids = array();
			$arrtopicresourceids = array();
						
			$this->topicmodel->getTopicsUser($sess, $arrtopicids, $arrtopictrainingids, $arrtopiccertificateids);
			$this->topicmodel->getResourcesTopicsUser($sess, $arrtopicresourceids);
			
			$ids = array(0);
			
			if (count($arrtopicids))
			{
				foreach($arrtopicids as $arrtopicid)
				{
					array_push($ids, $arrtopicid->category_id);
				}
			}
			
			if (count($arrtopicresourceids))
			{
				foreach($arrtopicresourceids as $arrtopicresourceid)
				{
					array_push($ids, $arrtopicresourceid->category_id);
				}
			}			
			
			$categories = array();
			$this->topicmodel->getCategoryIds($ids, $categories);
		}
		else
		{
			$categories = false;
		}
				
		if ($keyword && $searchby)
		{
			$this->db->where("UPPER(category_name) LIKE", "%".strtoupper($keyword)."%");
			$this->db->where("category_type", 0);
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			$rowcategories = $q->result();
			
			$categoryids[] = 0;
			for($i=0; $i < count($rowcategories); $i++)
			{				
				$categoryids[] = $rowcategories[$i]->category_id;
				
				$this->topicmodel->GetParentIds($rowcategories[$i]->category_id, $categoryids);
			}			
			
			$categoryids = array_unique($categoryids);			
		}				
		
		$trees = array();				
		$this->topicmodel->getArrayTree($trees, 0, 0, isset($sess['asadmin']) ? -1 : 1, $sortby, $orderby, $categories, isset($categoryids) ? $categoryids : false);
		
		$used = $this->topicmodel->GetUsed();
		
		$s = "";
		$this->itot = 0;
		$this->showListCategory($s, $trees, 0, $used);
		
		$this->mysmarty->assign("limit", $limit);
		$this->mysmarty->assign("offset", $offset);
		$this->mysmarty->assign("sortby", $sortby);
		$this->mysmarty->assign("orderby", $orderby);		
				
		$this->mysmarty->assign("confirm_delete", $this->config->item('confirm_delete'));
		$this->mysmarty->assign("lcategory_name", ucfirst($this->config->item('name')));
		$this->mysmarty->assign("header_list_category", $this->config->item('header_list_category'));
		$this->mysmarty->assign("category_name", ucfirst($this->config->item('category_name')));
		$this->mysmarty->assign("status", ucfirst($this->config->item('status')));
		$this->mysmarty->assign("lsort_by_status", ucfirst($this->config->item('lsort_by_status')));
		
		$this->mysmarty->assign("sort_list_by", $this->config->item('sort_list_by'));
		$this->mysmarty->assign("date_added", $this->config->item('date_added'));
		$this->mysmarty->assign("category_list", ucfirst($this->config->item('category_list')));
		$this->mysmarty->assign("lexport", ucfirst($this->config->item('lexport')));
		$this->mysmarty->assign("lsearch_by", ucfirst($this->config->item('lsearch_by')));
		$this->mysmarty->assign("lsearch", ucfirst($this->config->item('lsearch')));
		$this->mysmarty->assign("lsort_by_category_name", ucfirst($this->config->item('lsort_by_category_name')));
						
		$this->mysmarty->assign("tree_html", $s);
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/list.html");
		$this->mysmarty->display("sess_template.html");		
		
	}
	
	function showListCategory(&$s, $tree, $level, $used=false)
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
			
			if (isset($this->modules['trainee']) && (! isset($sess['asadmin'])))
			{
				if (isset($tree[$i]->child))
				{
					$s .= $tree[$i]->category_name;
				}
				else
				{
					$s .= '	<a href="'.site_url().'/topic/index/'.$tree[$i]->category_id.'">'.$tree[$i]->category_name.'</a>';
				}				
			}
			else
			{
				$s .= '	<a href="'.site_url().'/topic/formcategory/'.$tree[$i]->category_id.'">'.$tree[$i]->category_name.'</a>';
			}
			
			$s .= '</td>';
			
			if (isset($this->modules['category']) && isset($sess['asadmin']))
			{
				$imgstat = '<img src="'.base_url().'images/16/'.(($tree[$i]->category_status == 2) ? "inactive.png" : "active.png").'" border="0" title="'.(($tree[$i]->category_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" alt="'.(($tree[$i]->category_status == 2) ? $this->config->item("inactive") : $this->config->item("active")).'" />';
				
				$s .= '<td class="odd"><div id="status'.$tree[$i]->category_id.'"><a href="#" onclick="javascript:chagestatus('.$tree[$i]->category_id.','.$tree[$i]->category_status.')">'.$imgstat.'</a></div></td>';
				if (isset($tree[$i]->child))
				{
					$s .= '<td>&nbsp;</td>';
				}
				else
				if (is_array($used) && isset($used[$tree[$i]->category_id]))
				{
					$s .= '<td>&nbsp;</td>';
				}
				else
				{
					$s .= '<td><a href="'.site_url().'/topic/remove/'.$tree[$i]->category_id.'" onclick="javascript: return confirm(\''.$this->config->item('confirm_delete').'\');"><img src="'.base_url().'images/b_del.gif" width="12" height="12" border="0" /></a></td>';
				}
			}
			
			$s .= '</tr>';			
			
			$this->itot++;
			if (isset($tree[$i]->child))
			{
				$this->showListCategory($s, $tree[$i]->child, $level+1, $used);
			}
		}		
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
	
	function remove()
	{
		$this->checkadmin();
		
		if ($this->sess['user_type'])
		{
			if 	(
						TRUE
					&& 	(! isset($this->modules['category']))
					&&	(! isset($this->modules['topic']))
			)
			{
				redirect(base_url());
			}
		}
				
		$id = $this->uri->segment(3);
		if (! $id)
		{
			redirect(base_url());
		}
		
		$this->db->where("category_id", $id);
		$q = $this->db->get("category");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
		}
		
		$used = $this->topicmodel->GetUsed();
		if (isset($used[$id]))
		{
			redirect(base_url());
		}

		$row = $q->row();
		
		$this->db->where("category_id", $id);
		$this->db->delete("category");
		
		if ($row->category_type == 0)
		{		
			redirect(site_url(array("topic", "category")));
		}
		
		redirect(site_url(array("topic")));
	}
		
	
	function changestatus()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if 	(
				TRUE
				&& (! isset($this->modules['category']))
				&& (! isset($this->modules['topic']))
		)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$id = $this->uri->segment(3);	
		$status = $this->uri->segment(4);
		
		if (! $id)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}				
		
		$childs[] = $id;
		$this->topicmodel->getChildIds($id, $childs);
		
		unset($data);
		$data['category_status'] = ($status == 2) ? 1 : 2;
		
		$this->db->where_in("category_id", $childs);				
		$this->db->update("category", $data);				
	}
	
	function formtopic()
	{
		$this->checkadmin();
		
		
		if (! isset($this->modules['topic']))
		{
			redirect(base_url());
		}
		
		$edit = $this->uri->segment(3);
		if ($edit)
		{
			$this->db->where("category_id", $edit);
			$q = $this->db->get("category");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$row['category'] = $this->topicmodel->getCategory($row['category_id']);
			
			$def = $row['category']->category_id;
			
			$this->mysmarty->assign("catedit", $row);	
			$ltitle_form = sprintf(getconfig("lmodify_level"), getconfig("llearning_topics"));
	
		}
		else
		{
			$def = 0;
			$ltitle_form = sprintf(getconfig("ladd_level"), getconfig("llearning_topics"));
		}
		
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
			
		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
		$this->mysmarty->assign("category_desc", $this->config->item("category_desc"));
		$this->mysmarty->assign("status", $this->config->item("status"));
		$this->mysmarty->assign("active", $this->config->item("active"));
		$this->mysmarty->assign("inactive", $this->config->item("inactive"));
		$this->mysmarty->assign("category_name", $this->config->item("category_name"));		
		$this->mysmarty->assign("ok_save_topic", $edit ? $this->config->item("ok_update_topic") : $this->config->item("ok_add_topic"));		
		$this->mysmarty->assign("edit", $edit);
		$this->mysmarty->assign("isedit", $edit ? "true" : "false");
		$this->mysmarty->assign("tree", $tree);
		$this->mysmarty->assign("topic_parent", $this->config->item("topic_parent"));		
		$this->mysmarty->assign("topic_name", $this->config->item("topic_name"));
		$this->mysmarty->assign("topic_code", $this->config->item("topic_code"));
		$this->mysmarty->assign("flashtime", $this->config->item("flashtime"));
		$this->mysmarty->assign("lchange_code",getconfig('lchange_code'));
		$this->mysmarty->assign("lchange_code_confirm",getconfig('lchange_code_confirm'));
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/form_topic.html");
		$this->mysmarty->display("sess_template.html");
	}
	
	function formcategory()
	{
		$this->checkadmin();
		
		if (! isset($this->modules['category']))
		{
			redirect(base_url());
		}
				
		$edit = $this->uri->segment(3);
		if ($edit)
		{
			$this->db->where("category_id", $edit);
			$q = $this->db->get("category");
			if ($q->num_rows() == 0)
			{
				redirect(base_url());
			}
			
			$row = $q->row_array();
			$this->mysmarty->assign("catedit", $row);	
			
			$def = $row['category_parent'];
			$ltitle_form = sprintf(getconfig("lmodify_level"), getconfig("category"));
		
		}
		else
		{
			$ltitle_form = sprintf(getconfig("ladd_level"), getconfig("category"));
			$def = 0;
		}
		$this->mysmarty->assign("ltitle_form", $ltitle_form);
		
		$tree = "";
		$this->topicmodel->getParentTreeOptions($tree, 0, $def, 0, 0);
		
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
		
		$this->mysmarty->assign("left_content", "topic/menu.html");
		$this->mysmarty->assign("main_content", "topic/form.html");
		$this->mysmarty->display("sess_template.html");		
	}
	
	function savetopic()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['topic']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$cat = isset($_POST['cat']) ? trim($_POST['cat']) : "";
		$parent = isset($_POST['parent']) ? trim($_POST['parent']) : "";		
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$code = isset($_POST['code']) ? trim($_POST['code']) : "";
		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$status = isset($_POST['status']) ? trim($_POST['status']) : "";
		
		$edit = $this->uri->segment(3);
		
		$errs = array();
		if (strlen($cat) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("category_id", $cat);
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			if ($q->num_rows() == 0)
			{
				$errs[] = $this->config->item("err_not_exist_category_name");
			}
			else
			{
				$rowcat = $q->row();				
				if (! $parent)
				{
					$parent = $rowcat->category_id;
				}				
			}			
		}
		
		if (strlen($code) == 0)
		{
			$errs[] = $this->config->item("err_category_code");
		}
		else
		{
			/* 20100713 
				Dedy
				No need to check, category code , can be more than 1
			*/
			/*$this->db->where("category_code", addslashes($code));
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
				$rowcode = $q->row();
				if ($rowcode->category_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_code");
				}
			}*/
		}

		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_topic_name");
		}
		else
		{
			$this->db->where("category_name", addslashes($name));
			$this->db->where("category_parent", $parent);
			$q = $this->db->get("category");
			$this->db->flush_cache();
			
			if ($q->num_rows() > 0)
			{
				$rowname = $q->row();
				if ($rowname->category_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_topic_name");
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
		$data['category_name'] = addslashes($name);
		$data['category_desc'] = addslashes($desc);
		$data['category_parent'] = $parent;
		$data['category_code'] = $code;
		$data['category_status'] = $status;		

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("category_id", $edit);
			
			$this->db->update("category", $data);
		}
		else
		{
			$data['category_type'] = 1;
			$data['category_created'] = date("Ymd");
			$data['category_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("category", $data);
		}
		
	}
	
	function save()
	{
		$isadmin = $this->checkadmin(false);
		if (! $isadmin)
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		if (! isset($this->modules['category']))
		{
			echo "1\1";
			echo $this->config->item("err_exipred_session");
			exit;
		}
		
		$desc = isset($_POST['desc']) ? trim($_POST['desc']) : "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : "";		
		$status = isset($_POST['status']) ? trim($_POST['status']) : 1;
		$parent = isset($_POST['parent']) ? trim($_POST['parent']) : 0;		
		
		$edit = $this->uri->segment(3);
		
		$errs = array();
		if (strlen($name) == 0)
		{
			$errs[] = $this->config->item("err_category_name");
		}
		else
		{
			$this->db->where("category_name", addslashes($name));
			$this->db->where("category_parent", $parent);
			$q = $this->db->get("category");
			if ($q->num_rows() > 0)
			{
				$rowsdesc = $q->row();
				if ($rowsdesc->category_id != $edit)
				{
					$errs[] = $this->config->item("err_exist_category_name");
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
		$data['category_name'] = addslashes($name);
		$data['category_desc'] = addslashes($desc);
		$data['category_status'] = $status;				
		$data['category_parent'] = $parent;

		if ($edit)
		{
			$this->db->flush_cache();
			$this->db->where("category_id", $edit);
			
			$this->db->update("category", $data);
		}
		else
		{
			$data['category_type'] = 0;			
			$data['category_created'] = date("Ymd");
			$data['category_creator'] = $this->sess['user_id'];
				
			$this->db->flush_cache();		
			$this->db->insert("category", $data);
		}
	}	
	
	function checkcode($id)
	{
		$this->db->where("category_id", $id);
		$q = $this->db->get("category");		
		$row = $q->row();
		
		$code = isset($_POST['code']) ? trim($_POST['code']) : "";
		
		if ($row->category_code == $code)
		{
			echo json_encode(array("iscodechange"=>0));
			return;
		}
		
		echo json_encode(array("iscodechange"=>1, "message"=>$this->config->item("lchange_code")));
	}
	
	function getcatlist()
	{
		$this->db->order_by("category_name", "asc");
		$this->db->where("category_status", 1);
		$this->db->where("category_parent", 0);
		$q = $this->db->get("category");
		$list = $q->result();
		for($i=0; $i < count($list); $i++)
		{
			if ($i > 0)
			{
				echo "\1";
			}			
			echo $list[$i]->category_name;
		}
	}
	
	function getparent()
	{
		$cat = isset($_POST["cat"]) ? trim($_POST["cat"]) : "";		
		$def = isset($_POST["parent"]) ? trim($_POST["parent"]) : 0;
		$isshowroot = isset($_POST["isshowroot"]) ? trim($_POST["isshowroot"]) : "yes";
		$selectname = isset($_POST["selectname"]) ? trim($_POST["selectname"]) : "parent";
		$onchange = isset($_POST["onchange"]) ? trim($_POST["onchange"]) : "";	
		$disabled = isset($_POST["disabled"]) ? trim($_POST["disabled"]) : "";		
		$lroot = isset($_POST["lroot"]) ? trim($_POST["lroot"]) : "root";
		
		if (strlen($cat) == 0) 
		{
			echo '<select name="parent" id="parent"';
			
			if ($disabled)
			{
				echo " disabled ";
			}
			
			if ($onchange)
			{
				echo " onchange='javascript:".$onchange."'";
			}
			
			echo '>';
			echo '</select>';
			return;
		}
		
		$this->db->where("category_id", $cat);
		$q = $this->db->get("category");
		
		if ($q->num_rows() == 0)
		{
			echo '<select name="'.$selectname.'" id="'.$selectname.'"';

			if ($onchange)
			{
				echo " onchange='javascript:".$onchange."'";
			}

			if ($disabled)
			{
				echo " disabled ";
			}

			echo '>';

			if ($isshowroot == "yes")
			{
				echo '	<option value="0">'.$lroot.'</option>';
			}

			echo '</select>';
			return;			
		}

		$cat = $q->row(); 
		
		echo '<select name="'.$selectname.'" id="'.$selectname.'" style="width: 320px;"';
		if ($onchange)
		{
			echo " onchange='javascript:".$onchange."'";
		}
		if ($disabled)
		{
			echo " disabled ";
		}
		echo '>';
				
		if ($isshowroot == "yes")
		{
			echo '	<option value="0">'.$lroot.'</option>';
		}
		
		$s = "";
		$this->topicmodel->getParentTreeOptions($s, $cat->category_id, $def, 0, 1);
		
		echo $s;
		
		echo '</select>';
		
	}
	
	function export()
	{
		$this->db->order_by("category_parent", "asc");
		$this->db->order_by("category_name", "asc");
		$q = $this->db->select("*
			, CASE category_status WHEN 1 THEN '".$this->config->item('active')."' ELSE '".$this->config->item('inactive')."' END category_status_desc
			, CASE category_type WHEN 1 THEN 'topic' ELSE 'category' END category_type_desc "
			, false
		);
		$q = $this->db->get("category");
		
		$rows = $q->result();

		/*
		$this->load->library("xlswriter");
		$this->xlswriter->send(date("Ymd-His")."-category_topic.xls");
			
		$worksheet =& $this->xlswriter->addWorksheet("category_topic");
			
		
		$worksheet->write(0, 0, 'id');
		$worksheet->write(0, 1, 'parent id');
		$worksheet->write(0, 2, 'code');
		$worksheet->write(0, 3, 'name');
		$worksheet->write(0, 4, 'description');
		$worksheet->write(0, 5, 'status code');
		$worksheet->write(0, 6, 'status');
		$worksheet->write(0, 7, 'type code');
		$worksheet->write(0, 8, 'type desc');
		
		for($i=0; $i < count($rows); $i++)
		{
			$worksheet->write($i+1, 0, $rows[$i]->category_id);	
			$worksheet->write($i+1, 1, $rows[$i]->category_parent);	
			$worksheet->write($i+1, 2, $rows[$i]->category_code);
			$worksheet->write($i+1, 3, $rows[$i]->category_name);	
			$worksheet->write($i+1, 4, $rows[$i]->category_desc);	
			$worksheet->write($i+1, 5, $rows[$i]->category_status);	
			$worksheet->write($i+1, 6, $rows[$i]->category_status_desc);	
			$worksheet->write($i+1, 7, $rows[$i]->category_type);	
			$worksheet->write($i+1, 8, $rows[$i]->category_type_desc);	
		}

		$this->xlswriter->close();
		*/

        /*
        require_once BASEPATH . "application/libraries/xlsxwriter.php";
        $filename = date("Ymd-His")."-category_topic.xls";
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $writer = new XLSXWriter();
        $writer->setTempDir((BASEPATH . "logs"));
        $writer->setAuthor('Some Author');

        $rows = array(
            array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00'),
            array('2003','2', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
        );

        foreach($rows as $row) {
            $writer->writeSheetRow('Sheet1', $row);
        }

        $writer->writeToStdOut();
        exit(0);
        */

        /*
        require_once BASEPATH . "application/libraries/xlsxwriter.php";
        $filename = date("Ymd-His")."-category_topic.xls";
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $header = array(
            'c1-text'=>'string',//text
            'c2-text'=>'@',//text
            'c3-integer'=>'integer',
            'c4-integer'=>'0',
            'c5-price'=>'price',
            'c6-price'=>'#,##0.00',//custom
            'c7-date'=>'date',
            'c8-date'=>'YYYY-MM-DD',
        );
        $rows = array(
            array('x101',102,103,104,105,106,'2018-01-07','2018-01-08'),
            array('x201',202,203,204,205,206,'2018-02-07','2018-02-08'),
            array('x301',302,303,304,305,306,'2018-03-07','2018-03-08'),
            array('x401',402,403,404,405,406,'2018-04-07','2018-04-08'),
            array('x501',502,503,504,505,506,'2018-05-07','2018-05-08'),
            array('x601',602,603,604,605,606,'2018-06-07','2018-06-08'),
            array('x701',702,703,704,705,706,'2018-07-07','2018-07-08'),
        );
        $writer = new XLSXWriter();
        $writer->setTempDir((BASEPATH . "logs"));
        $writer->writeSheetHeader('Sheet1', $header);
        foreach($rows as $row)
            $writer->writeSheetRow('Sheet1', $row);

        $writer->writeToStdOut();
        exit(0);
        */

        // Starting the PHPExcel library
        //$this->load->library('PHPExcel');
        //$this->load->library('PHPExcel/IOFactory');
        require_once BASEPATH . "application/libraries/PHPExcel.php";
        require_once BASEPATH . "application/libraries/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'id');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'parent id');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'code');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'name');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'description');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'status code');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'status');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'type code');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'type desc');

        for($i=0; $i < count($rows); $i++)
        {
            $row = $i + 2;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $rows[$i]->category_id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $rows[$i]->category_parent);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $rows[$i]->category_code);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $rows[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rows[$i]->category_desc);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rows[$i]->category_status);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $rows[$i]->category_status_desc);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $rows[$i]->category_type);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $rows[$i]->category_type_desc);
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
	}		
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
