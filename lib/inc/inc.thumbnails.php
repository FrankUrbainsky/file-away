<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if($thumbnails) $getthumb = in_array($extension, array('jpg','jpeg','gif','png')) ? true : false;
if($manager && $thumbnails && stripos($file, '_thumb_') !== false) $getthumb = false;
if($getthumb)
{
	if($thumbnails !== "permanent")
	{
		$imgprop = getimagesize($rootpath.$dir.'/'.$file);
		while($getthumb)
		{
			if(isset($imgprop[0]) && $maxsrcwidth && $imgprop[0] > $maxsrcwidth)
			{ 
				$getthumb = false;
				break;
			}
			if(isset($imgprop[1]) && $maxsrcheight && $imgprop[1] > $maxsrcheight)
			{
				$getthumb = false;
				break; 
			}
			if($maxsrcbytes && $bytes > $maxsrcbytes)
			{ 
				$getthumb = false; 
				break;
			}
			break;
		}
	}
	elseif($thumbnails == 'permanent')
	{
		$templink = $unicode && $encryption ? fileaway_utility::unicode(utf8_encode($links[$k])) : ($unicode ? $link : $links[$k]);
		$tempfile = $unicode ? fileaway_utility::unicode(utf8_encode(str_replace('#', '%23', $file))) : str_replace('#', '%23', $file);
		if(!is_file($rootpath.$dir.'/_thumb_'.$thumbfix.$file)) 
			fileaway_utility::createthumb($rootpath.$dir.'/'.$file, $rootpath.$dir.'/_thumb_'.$thumbfix.$file, $extension, $thumbwidth, $thumbheight);
		$thumblink = is_file($rootpath.$dir.'/_thumb_'.$thumbfix.$file) ? str_replace($tempfile, '_thumb_'.$thumbfix.$tempfile, $templink) : false;
	}
}