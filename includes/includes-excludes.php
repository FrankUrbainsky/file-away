<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
$excluded = false;
while(!$excluded):
	// NEVER SHOW THESE
	foreach($GLOBALS['ssfa_nevershow'] as $nevershow): if(strripos($file, $nevershow) !== false) $excluded = true; endforeach; if($excluded) break;
	// DON'T SHOW THUMBNAILS FROM UPLOADED IMAGES
	$excluded = preg_match('/\d{2,}[Xx]\d{2,}\./', $file) ? true : false; if($excluded) break;
	// ONLY INCLUDE THESE
	if($only): 
		$onlyinclude = 0; 
		$onlyincs = preg_split ('/(, |,)/', $only); 
		foreach($onlyincs as $onlyinc): 
			if(strripos("$file", "$onlyinc") !== false): 
				$onlyinclude = 1; 
				break; 
			endif; 
		endforeach; 
		$excluded = $onlyinclude ? false : true;
		if($excluded) break;
	endif;
	// CUSTOM DEFINED SPECIAL INCLUSIONS
	$included = 0; 
	if($include): 
		$customincs = preg_split('/(, |,)/', $include); 
		foreach($customincs as $custominc): 
			if(strripos($file, $custominc) !== false): 
				$included = 1; 
				break; 
			endif; 
		endforeach; 
	endif;
	// EXCLUDE CODE TYPE DOCUMENTS
	$excluded = $code !== 'yes' && !$included && in_array(strtolower($extension), $GLOBALS['ssfa_codexts']) ? true : false; if($excluded) break;
	// IMAGES ONLY OR NONE
	if($images && !$included): 
		$is_image = 0; 
		if(in_array(strtolower($extension), $GLOBALS['ssfa_imagetypes'])) $is_image = 1; 
	endif; 
	$imgonly = ($images === 'only' ? $is_image : ($images === 'none' ? !$is_image : 1 ));
	$excluded = $imgonly ? false : true;
	if($excluded) break;
	// AUDIO FILES ONLY	
	if($onlyaudio && !$included):
		$is_audio = 0;
		if(in_array(strtolower($extension), $GLOBALS['ssfa_audio'])) $is_audio = 1;
		$excluded = $is_audio ? false : true;
		if($excluded) break; 
	endif;
	// EXCLUDE THESE
	if(($exclude || SSFA_EXCLUSIONS) && !$included): 
		$customexes = $exclude ? preg_split('/(, |,)/', $exclude) : array(); 
		$allexcludes = array_unique(array_merge($customexes, $GLOBALS['ssfa_permexclusions']));
		foreach($allexcludes as $exc): 
			if(strripos($file, $exc) !== false): 
				$excluded = true; break;
			endif;
		endforeach; 
		if($excluded) break;
	endif;
	// FINISHING TOUCHES
	$excluded = $file != "." && $file != ".." ? false : true; 
	break;
endwhile;