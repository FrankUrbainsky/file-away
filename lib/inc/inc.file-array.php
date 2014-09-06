<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(is_array($files))
{
	natcasesort($files); 
	foreach($files as $file)
	{
		$link = $recursive ? "$url/$file" : "$url/$dir/$file"; 
		$slices = pathinfo($link); 
		$extension = isset($slices['extension']) ? $slices['extension'] : false;
		include fileaway_dir.'/lib/inc/inc.filters.php'; 
		if(!$excluded)
		{
			$exts[] = $extension;
			$locs[] = $slices['dirname']; 
			$fulls[] = $slices['basename']; 
			$rawnames[] = $slices['filename'];
			$links[] = str_replace('#', '%23', $link);
			$dirs[] = $recursive ? str_replace($slices['basename'], '', $file) : $dir;		
		}
	}
}