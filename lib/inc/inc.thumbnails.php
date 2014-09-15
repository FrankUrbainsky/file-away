<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if($thumbnails) $getthumb = in_array($extension, array('jpg','jpeg','gif','png','pdf')) ? true : false;
if($manager && $thumbnails && stripos($file, '_thumb_') !== false) $getthumb = false;
if($bannerad) $getthumb = false;
if($getthumb)
{
	if($thumbnails !== "permanent")
	{
		
		$imgprop = getimagesize($rootpath.$dir.'/'.$file);
		while($getthumb)
		{
			if($extension == 'pdf') 
			{
				$getthumb = false;
				break;
			}
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
		if($extension == 'pdf' && function_exists('exec'))
		{ 
			$thumbpath = $rootpath.$dir.'/_thumb_'.$thumbfix.$rawname.'.jpg';
			$tempfile = fileaway_utility::urlesc($file);
			if(!is_file($thumbpath))
			{
				$pdfpath = $rootpath.$dir.'/'.$file;
				//exec("convert \"{$pdfpath}[0]\" -colorspace RGB -geometry 60x40 $thumbpath");
				//exec("convert -define jpeg:size=120x60 \"{$pdfpath}[0]\" -colorspace RGB -geometry 120x60 $thumbpath");
				exec("convert -define jpeg:size=60x60 \"{$pdfpath}[0]\" -colorspace RGB -thumbnail 60x60 -gravity center -crop 60x60+0+0 +repage $thumbpath");
			}
			$thumblink = is_file($thumbpath) ? str_replace($tempfile, '_thumb_'.$thumbfix.fileaway_utility::replacelast($tempfile, '.pdf', '.jpg'), $links[$k]) : false;
		}
		else 
		{
			$tempfile = fileaway_utility::urlesc($file);
			if(!is_file($rootpath.$dir.'/_thumb_'.$thumbfix.$file)) 
			{
				fileaway_utility::createthumb($rootpath.$dir.'/'.$file, $rootpath.$dir.'/_thumb_'.$thumbfix.$file, $extension, $thumbwidth, $thumbheight);
			}
			$thumblink = is_file($rootpath.$dir.'/_thumb_'.$thumbfix.$file) ? str_replace($tempfile, '_thumb_'.$thumbfix.$tempfile, $links[$k]) : false;
		}
	}
}