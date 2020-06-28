<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class LogModel extends Model {
	var $dir;
	
	function LogModel () 
	{				
		parent::Model();		
	}
	
	function init($key)
	{
		$now = date("Ymd");
		
		$dir = BASEPATH."../log/".$key;
		
		if (! is_dir($dir))
		{
			mkdir($dir);
		}
		
		$this->dir = $dir;						
	}
	
	function append($s)
	{
		$s = "[".date("H:i:s")."] ".$s."\r\n";
		
		$maxsize = $this->config->item("maxlogsize")*1024;
		$now = date("Ymd");
		
		$filename = $this->dir."/".$now.".log";
		if (is_file($filename) && ((filesize($filename)+strlen($s)) > $maxsize))
		{
			// backup
			
			$i = 1;
			while(1)
			{
				$newfilename = $$this->dir."/".$now."_".$i.".log";
				if (! is_file($newfilename)) break;
				
				$i++;	
			}
			
			rename($filename, $newfilename);
		}
		
		$fin = fopen($filename, "a");
		if (! $fin) return;
		
		$try = 1;
		while(1)
		{
			if (flock($fin, LOCK_EX))
			{
				fwrite($fin, $s);
				flock($fin, LOCK_UN); 
				break;
			}
			
			$try++;
			sleep(1);
			
			if ($try > 1000) 
			{
				fclose($fin);
				return;
			}
		}
				
		fclose($fin);
	}
	
}
