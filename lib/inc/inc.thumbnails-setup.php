<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$thumbnails = $thumbnails && $type == 'table' && extension_loaded('gd') && function_exists('gd_info') ? $thumbnails : false;
if($thumbnails)
{ 
	$graythumbs = $graythumbs ? ' ssfa-thumb-bw' : '';
	$thumbwidth = in_array($thumbstyle, array('widerounded','widesharp','oval')) ? 60 : 40; 
	$thumbheight = 40; 
	$thumbfix = $thumbwidth == 60 ? 'wd_' : 'sq_';
	if($thumbnails !== 'permanent')
	{
		$maxsrcbytes = preg_replace('/[^\\d.]+/', '', $maxsrcbytes);
		$maxsrcwidth = preg_replace('/[^\\d.]+/', '', $maxsrcwidth);
		$maxsrcheight = preg_replace('/[^\\d.]+/', '', $maxsrcheight);
	}
}