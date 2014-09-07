<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(preg_match('/\[([^\]]+)\]/', $rawname))
{
	$file_plus_custom = $rawname;
	list($salvaged_filename, $customvalue) = preg_split("/[\[\]]/", $file_plus_custom);
	$customvalue = str_replace(array('~', '--', '_', '.', '*'), ' ', $customvalue);
	$customvalue = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$customvalue");
	$customvalue = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$customvalue");
	$customvalue = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$customvalue");	
	$thename = str_replace(array('~', '--', '_', '.', '*'), ' ', $salvaged_filename); 
}	
else
{ 
	$file_plus_custom = null; 
	$customvalue = null; 
	$thename = str_replace(array('~', '--', '_', '.', '*'), ' ', $rawname); 
	$salvaged_filename = $rawname;
}
$thename = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$thename"); 
$thename = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$thename"); 
$thename = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$thename"); 
$ext = !$ext ? '?' : $ext; 
$ext = substr($ext,0,4);
$bytes = filesize($dir.'/'.$file); 
if($size !== 'no')
{ 
	$fsize = fileaway_utility::formatBytes($bytes, 1); 
	$fsize = (!preg_match('/[a-z]/i', $fsize) ? '1k' : ($fsize === 'NAN' ? '0' : $fsize));
}
$sortdatekey = date("YmdHis", filemtime($dir.'/'.$file)); 
$sortdate = $this->op['daymonth'] === 'dm' ? date("g:i A d/m/Y", filemtime($dir.'/'.$file)) : date("g:i A m/d/Y", filemtime($dir.'/'.$file));
$date = date("F d, Y", filemtime($dir.'/'.$file)); 
$time = date("g:i A", filemtime($dir.'/'.$file));