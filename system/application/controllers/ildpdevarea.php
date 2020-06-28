<?php
include_once "base.php"; 

class ILDPDevarea extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function ILDPDevarea()
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
	}
	
	function bytraining(){
		$catalog = isset($_POST['catalog']) ? $_POST['catalog'] : 0;
		$default = isset($_POST['def']) ? $_POST['def'] : 0;
		
		$this->db->order_by("dev_area_title", "asc");
		$this->db->where("dev_area_catalog_id", $catalog);
		$q = $this->db->get("ildp_development_area");
		
		$rows = $q->result();

		$this->mysmarty->assign("default", $default);
		$this->mysmarty->assign("rows", $rows);
		
		//-- get development area value
		$this->db->select("ildp_catalog_id", $catalog);
		$this->db->where("ildp_catalog_id", $catalog);
		
		$q = $this->db->get("ildp_catalog");
		
		$rows = $q->result();
		
		$callback['html'] = $this->mysmarty->fetch("ildp/optionsdevarea.html");		
		
		
		echo json_encode($callback);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
