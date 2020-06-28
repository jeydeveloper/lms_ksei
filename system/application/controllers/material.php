<?php

include_once "base.php"; 
class Material extends Base {
	var $language;
	var $modules;
	var $sess;
	var $carts;

	function Material()
	{
		//parent::Controller();	
		parent::Base();
				
		$this->load->library('mysmarty');
		$this->load->library('session');
		$this->load->library('pagination1');		
		
		$this->load->model("trainingmodel");
	}
	
	function index($dir, $filename="index.html")
	{
		$filename = preg_replace("/_html$/", ".html", $filename);

		$usess = $this->session->userdata('lms_sess');	

		if (! $usess)
		{
			redirect(base_url());
			return;
		}		

		$sess = unserialize($usess);
		$this->sess = $sess;
		
		if ($this->sess['user_type'] == 0)
		{
			readfile($this->config->item("base_path")."/material/".$dir."/".$filename);
			return;
		}
		
		$this->db->where("training_material", $dir);
		$q = $this->db->get("training");
		
		if ($q->num_rows() == 0)
		{
			redirect(base_url());
			return;
		}
		
		$rows = $q->result();
		
		for($i=0; $i < count($rows); $i++)
		{
			$trainingids[] = $rows[$i]->training_id;
		}
		
		$candidates = $this->trainingmodel->GetCandidateUserIds($trainingids);
		
		if (count($candidates) == 0)
		{
			redirect(base_url());
			return;
		}
		
		foreach($candidates as $val)
		{
			$userids = array_keys($val);			
			if (in_array($sess['user_id'], $userids))
			{
				$found = true;
				break;
			}
		}
		
		if (! isset($found))
		{
			redirect(base_url());
			return;
		}
		
		readfile($this->config->item("base_path")."/material/".$dir."/".$filename);
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
