<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$url = $this->op['baseurl']; 
$s2mem = fileaway_definitions::$s2member && $base == 's2member-files' ? true : false;
$base = $s2mem ? 'wp-content/plugins/s2member-files' : $this->op['base'.$base];
$base = trim($base, '/'); 
$base = trim($base, '/');
if($base == '' || $base == null) 
{
	echo 'Your Base Directory is not set.'; 
	return 2;
}
if($s2mem)
{
	$sub = false; 
	$directories = false; 
	$recursive = false; 
	$manager = false; 
	$s2skip = $s2skipconfirm ? '&s2member_skip_confirmation' : '';	
}
$sub = $sub ? trim($sub, '/') : false;
$dir = $sub ? $base.'/'.$sub : $base;
$dir = str_replace('//', '/', "$dir");
$dir = $problemchild ? $install.$dir : $dir;
$plabackpath = $playback ? $playbackpath : false;