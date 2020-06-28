<?php
class MY_session extends CI_Session {
	var $CI;
	
	function MY_session($params=array()){
    	parent::CI_Session($params);
    	log_message('debug', 'Extended CI session class instantiated!');
    	
    	/* 2010/03/27 Dedy  
    		set user id from session since it can not called from the extended mysql db driver 
    	*/
    	
    	$sess = unserialize($this->userdata('lms_sess'));	
    	if(!$sess['user_npk'])
    		$sess['user_npk'] = "9999999";
    	
    	$this->CI=& get_instance(); //grab a reference to the controller
        $this->CI->db->setUserId($sess['user_npk']);
   	}
   	
   	/*
    * Do not update an existing session on ajax calls
    *
    * @access    public
    * @return    void
    */
   	public function sess_update()
    {
        if ( ! IS_AJAX)
        {
            parent::sess_update();
        }
    }

    function sess_destroy()
    {
        parent::sess_destroy();

        $this->userdata = array();
    }	

}
?>