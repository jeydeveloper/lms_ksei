<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|==========================================================
| Code Igniter - by pMachine
|----------------------------------------------------------
| www.codeignitor.com
|----------------------------------------------------------
| Copyright (c) 2006, pMachine, Inc.
|----------------------------------------------------------
| This library is licensed under an open source agreement:
| www.codeignitor.com/docs/license.html
|----------------------------------------------------------
| File: libraries/Smarty.php
|----------------------------------------------------------
| Purpose: Wrapper for Smarty Templates
|==========================================================
*/
require_once(BASEPATH . "application/libraries/libs/smarty/Smarty.class.php");

class MySmarty extends Smarty{

/*
|==========================================================
| Constructor
|==========================================================
|
|
*/
function MySmarty()
{
	$CI =& get_instance();
	
	$this->compile_dir = BASEPATH . "application/views_c";
	$this->template_dir = BASEPATH . "application/views";
	$this->left_delimiter 	= "{*";
	$this->right_delimiter 	= "*}";	
	
	$this->register_function("number_format", "print_number_format"); 
	$this->register_function("is_checked", "print_is_checked");
	
	$this->assign("app_revision","Rev. ".$CI->config->item('app_revision'));
	log_message('debug', "Smarty Class Initialized");
}



}

function print_number_format($params) 
{ 
	return number_format($params['num'], 0, "", ".");
} 

function print_is_checked($params) 
{ 
	if (! is_array($params['arr']))
	{
		return "";
	}
	
	if (in_array($params['val'], $params['arr']))
	{
		return "checked";
	}
	
	return "";
} 

?>