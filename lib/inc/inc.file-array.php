<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(is_array($files))
{
	foreach($files as $file)
	{
		$link = $recursive ? "$url/$file" : "$url/$dir/$file"; 
		$slices = pathinfo($link); 
		$extension = isset($slices['extension']) ? $slices['extension'] : false;
		include fileaway_dir.'/lib/inc/inc.filters.php'; 
		$dir = $recursive ? str_replace($slices['basename'], '', $file) : $dir;
		if(!$excluded && is_file($dir.'/'.$slices['basename']))
		{
			$exts[] = $extension;
			$locs[] = $slices['dirname']; 
			$fulls[] = $slices['basename']; 
			$rawnames[] = $slices['filename'];
			$links[] = fileaway_utility::urlesc($link);
			$dirs[] = $dir;
			$times[] = filemtime($dir.'/'.$slices['basename']);
			$dynamics[] = false;
			$bannerads[] = false;
		}
	}
}