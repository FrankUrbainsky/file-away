<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if($thumbnails) $getthumb = in_array($extension, array('jpg','jpeg','gif','png')) ? true : false;
if($manager && $thumbnails && stripos($file, '_thumb_') !== false) $getthumb = false;
if($getthumb)
{
	$srcpath = $problemchild ? fileaway_utility::replacefirst(stripslashes($dir), $install, '') : stripslashes($dir);
	if($thumbnails !== "permanent")
	{
		$imgprop = getimagesize($chosenpath.$srcpath.'/'.$file);
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
		if(!is_file($chosenpath.$srcpath.'/_thumb_'.$thumbfix.$file)) 
			fileaway_utility::createthumb($chosenpath.$srcpath.'/'.$file, $chosenpath.$srcpath.'/_thumb_'.$thumbfix.$file, $extension, $thumbwidth, $thumbheight);
		$thumblink = is_file($chosenpath.$srcpath.'/_thumb_'.$thumbfix.$file) ? str_replace($file, '_thumb_'.$thumbfix.$file, $link) : false;
	}
}