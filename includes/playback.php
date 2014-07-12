<?php
$mfile = null; $mfiles = array(); $has_sample = 0; $has_multiple = 0;
$samples = array('mp3','ogg','wav');
foreach($samples as $sample): 
	if(!in_array($sample, $sources) && in_array($oext, $samples) && !in_array($oext, $sources)): $skipthis = 1; endif;
endforeach;
if(!$skipthis):
	$pbdir = $GLOBALS['ssfa_install'] ? rtrim(ssfa_replace_first($GLOBALS['ssfa_install'], '', $dir),'/').'/' : rtrim($dir,'/').'/'; 
	if($playbackpath): 
		$playbackpath = $GLOBALS['ssfa_install'] ? rtrim(ssfa_replace_first($GLOBALS['ssfa_install'], '', $playbackpath),'/').'/' : rtrim($playbackpath,'/').'/'; 
	else:
		$playbackpath = $GLOBALS['ssfa_install'] ? rtrim(ssfa_replace_first($GLOBALS['ssfa_install'], '', $dir),'/').'/' : rtrim($dir,'/').'/'; 
	endif;
	$samplefile = $GLOBALS['ssfa_playback_url'].$playbackpath.$rawname; 
	$mfilepath = $GLOBALS['ssfa_abspath'].$playbackpath.$rawname;
	foreach($samples as $x=> $sample): 
		 if(is_file($mfilepath.'.'.$sample)): 
		 	$mfiles[] = $samplefile.'.'.$sample; 
			$has_sample = 1;
		 endif;
	endforeach;
	$player = null; 
	if(count($mfiles) > 0):
		$mfile = implode('|', $mfiles);
		$playeratts = array('fileurl'=>$mfile, 'class'=>'ssfa-player '.$icocol, 'loops'=>$loopaudio);
		$player = ssfa_fileaplay($playeratts);
	endif;
	$sourcefilepath = $GLOBALS['ssfa_abspath'].$pbdir.$rawname;
	$sourcefileurl = $GLOBALS['ssfa_playback_url'].$pbdir.$rawname; 
	$players = null; $sourcecount = 1;
	foreach($sources as $audioext):
		if(is_file($sourcefilepath.'.'.$audioext)): 
			$dlcolor = !$color ? " ssfa-".$randcolor[array_rand($randcolor)] : " ssfa-$colors";
			$players .= $s2mem ? '<a class="ssfa-audio-download '.$dlcolor.'" href="'.$url.'/?s2member_file_download='.str_replace('&', '%26', $rawname).'.'.$audioext.'">' 
				: '<a class="ssfa-audio-download '.$dlcolor.'" href="'.$sourcefileurl.'.'.$audioext.'" download="'.$rawname.'.'.$audioext.'">';
			$players .= '<div class="ssfa-audio-download">';
			$players .= '<span class="ssfa-fileaplay-in ssfa-audio-download"></span>';
			$players .= strtoupper($audioext);
			$players .= '</div>';
			$players .= '</a>'; 
			if($sourcecount > 1) $has_multiple = 1;
			$sourcecount++;
		endif;
	endforeach;
 	$used[] = $rawname; 
	$players = $players == null ? null : "<br>$players";
endif;