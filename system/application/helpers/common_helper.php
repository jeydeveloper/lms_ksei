<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('appendlog'))
{
	function appendlog($filename, $s)
	{
		$fout = fopen($filename, "a");
		if (! $fout) return;
		
		if (! is_array($s))
		{
			fwrite($fout, date("H:i:s")." => ".$s);
		}
		else
		foreach($s as $l)
		{
			fwrite($fout, date("H:i:s")." => ".$l);
		}
		
		fclose($fout);
	}
}

function slug($sString) {
	$string = strip_tags($sString);
	$string = strtolower($string);
    $string = preg_replace("/&(.)(uml);/", "$1e", $string);
    $string = preg_replace("/&(.)(acute|cedil|circ|ring|tilde|uml);/", "$1", $string);
    $string = preg_replace("/([^a-z0-9]+)/", "-", $string);
    $string = trim($string, "-");
    return $string;
}

function getconfig($key){
 	$CI =& get_instance();
 	return $CI->config->item($key);
}

/**
 * yyyymmdd to date (dd/mm/yyyy) 
 *
 * @access	public
 * @return	time
 */	
if ( ! function_exists('inttodate'))
{
	function inttodate($t)
	{
		$year = substr($t,0,4);
		$month= substr($t,4,2);
		$date = substr($t,6,2);
		
		return $date."/".$month."/".$year;
	}
}


/**
 * yyyy-mm-dd hh:ii:ss to time 
 *
 * @access	public
 * @return	time
 */	
if ( ! function_exists('dbmaketime'))
{
	function dbmaketime($t)
	{
		$ts = explode(" ", $t);
		if (count($ts) != 2) return 0;
		
		$ds = explode("-", trim($ts[0]));
		$ts1 = explode(":", trim($ts[1]));

		if (count($ds) != 3) return 0;
		if (count($ts1) != 3) return 0;
		
		return mktime($ts1[0], $ts1[1], $ts1[2], $ds[1], $ds[2], $ds[0]);
	}
}

/**
 * yyyymmdd hhiiss to time 
 *
 * @access	public
 * @return	time
 */	
if ( ! function_exists('dbintmaketime'))
{
	function dbintmaketime($d, $t)
	{
		$y = floor($d/10000);
		$m = floor(($d%10000)/100);
		$d = ($d%10000)%100;

		$j = floor($t/10000);
		$me = floor(($t%10000)/100);
		$de = ($t%10000)%100;
		
		return mktime($j, $me, $de, $m, $d, $y);

	}
}

/*
@ t1 varchar
return seconds
*/
function timediff($d1,$t1,$d2,$t2){
	if($d1 == 0 || $d2 == 0 || 
		(strlen($d1) <> 8  && strlen($d2) <> 8))
		return "dd";
	
	$time1 = dbintmaketime($d1, $t1);
	$time2 = dbintmaketime($d2, $t2);
	
	$dateDiff = $time2-$time1;
	
	return $dateDiff;
	
}
  

/**
 * dd/mm/yyyy hh:ii:ss to time 
 *
 * @access	public
 * @return	time
 */	
if ( ! function_exists('formmaketime'))
{
	function formmaketime($t)
	{
		$ts = explode(" ", $t);
		
		if (count($ts) != 2) return 0;

		$ds = explode("/", trim($ts[0]));						
		$ts1 = explode(":", trim($ts[1]));
				
		if (count($ds) != 3) return 0;
		if (count($ts1) != 3) return 0;
		
		return mktime($ts1[0]*1, $ts1[1]*1, $ts1[2]*1, $ds[1]*1, $ds[0]*1, $ds[2]*1);
	}
}

if ( ! function_exists('sort_topic_cat'))
{
	function sort_topic_cat_asc($a, $b)
	{
		if (! isset($a->category_name1))  return 0;
		$cmp = strcasecmp($a->category_name1, $b->category_name1);
		
		if ($cmp < 0) return -1;
		if ($cmp > 0) return 1;
		
		return 0;
	}
	
	function sort_topic_cat_desc($a, $b)
	{
		if (! isset($a->category_name1))  return 0;
		$cmp = strcasecmp($a->category_name1, $b->category_name1);
		
		if ($cmp < 0) return 1;
		if ($cmp > 0) return -1;
		
		return 0;

	}	
}

/**
 * dd/mm/yyyy hh:ii:ss to time 
 *
 * @access	public
 * @return	time
 */	
if ( ! function_exists('maptostr'))
{
	function maptostr($p)
	{
		$s = "";
		foreach($p as $key=>$val)
		{
			if ($s) $s .= ",";
			$s .= $key."=".$val;
		}
		
		return $s;
	}
}

if ( ! function_exists('is_alphanumeric'))
{
	function is_alphanumeric($s)
	{
		if (! preg_match("/[0-9]/", $s)) return false;
		
		return preg_match("/[^0-9]/", $s);
	}
}

if ( ! function_exists('postfixdate'))
{
	function postfixdate($d)
	{
		switch($d)
		{
			case 1:
			return "st";
			case 2:
			return "nd";
			case 3:
			return "rd";
			default:
			return "th";
		}
	}
}

if ( ! function_exists('formattime'))
{
	function formattime($s)
	{
		if ($s < 0)
		{
			return "00:00:00";
		}
		
		$jam = floor($s/3600);
		$menit = floor(($s%3600)/60);
		$detik = ($s%3600)%60;
		
		return sprintf("%d:%02d:%02d", $jam, $menit, $detik);
	}
}

function numformat($number){
	return round($number,2);
}

function _user_id(){
	$CI =& get_instance();
	$usess = $CI->session->userdata('lms_sess');	
	$sess = unserialize($usess);
	return $sess['user_id'];
}
			
/* End of file email_helper.php */
/* Location: ./system/helpers/email_helper.php */

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generate_request_no() {
	$CI =& get_instance();
	$res = $CI->db->select('COUNT(*) as total', false)->get('request_training')->row_array();
	$total = (!empty($res['total']) ? $res['total'] : 0) + 1;
	$tmp = (((int) str_replace('-', '', date('Y-m'))) * 100000) + $total;
	$ret = 'UTR' . $tmp;
	return $ret;
}

function get_time_date_diff($date_start, $date_end) {
	$date_start = strtotime($date_start);
	$date_end 	= strtotime($date_end);

	if($date_end == $date_start) return 0;

	$datediff = $date_end - $date_start;
	$diff = floor($datediff/(60*60*24));

	return $diff;
}