<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Newsmodel extends Model {
	function NewsModel () 
	{				
		parent::Model();	
		
		$this->load->database();	
	}
}
