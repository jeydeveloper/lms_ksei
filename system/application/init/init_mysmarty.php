<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('mysmarty'))
{
     require_once(APPPATH.'libraries/mysmarty'.EXT);
}

$obj =& get_instance();
$obj->mysmarty = new mysmarty();
$obj->ci_is_loaded[] = 'mysmarty';

?>