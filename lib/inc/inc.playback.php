<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$skipthis = 0; 
$mfile = null; 
$mfiles = array(); 
$has_sample = 0; 
$has_multiple = 0;
$samples = array('mp3','ogg','wav');
foreach($samples as $sample) if(!in_array($sample, $sources) && in_array($oext, $samples) && !in_array($oext, $sources)) $skipthis = 1;
if(!$skipthis && in_array($oext, $sources))
{
	$pbdir = $install ? rtrim(fileaway_utility::replacefirst($dir, $install, ''),'/').'/' : rtrim($dir,'/').'/'; 
	if($playbackpath) $playbackpath = $install ? rtrim(fileaway_utility::replacefirst($playbackpath, $install, ''),'/').'/' : rtrim($playbackpath,'/').'/'; 
	else $playbackpath = $install ? rtrim(fileaway_utility::replacefirst($dir, $install, ''),'/').'/' : rtrim($dir,'/').'/'; 
	$samplefile = $playback_url.$playbackpath.$rawname; 
	$mfilepath = $chosenpath.$playbackpath.$rawname;
	foreach($samples as $x=> $sample)
	{ 
		if(is_file($mfilepath.'.'.$sample))
		{ 
			$mfiles[$sample] = $samplefile.'.'.$sample; 
			$has_sample = 1;
		}
	}
	$player = null; 
	if(count($mfiles) > 0)
	{
		if($playback == 'compact')
		{
			$mfile = implode('|', $mfiles);
			$playeratts = array('fileurl'=>$mfile, 'class'=>'ssfa-player '.$icocol, 'loops'=>$loopaudio);
			$player = $playaway->player($playeratts);
		}
		else
		{
			$playeratts = array();
			if($loopaudio == 'true') $playeratts['loop'] = 'true';
			foreach($mfiles as $e=>$s) $playeratts[$e] = str_replace(' ','%20',str_replace('[', '%5b', str_replace(']', '%5d', $s)));
			$player = wp_audio_shortcode($playeratts);
		}
	}
	$sourcefilepath = $chosenpath.$pbdir.$rawname;
	$sourcefileurl = $playback_url.$pbdir.$rawname; 
	$players = null; 
	$sourcecount = 1;
	foreach($sources as $audioext)
	{
		if(is_file($sourcefilepath.'.'.$audioext))
		{ 
			$dlcolor = !$color ? " ssfa-".$randcolor[array_rand($randcolor)] : " ssfa-$colors";
			$players .= $s2mem ? '<a class="ssfa-audio-download '.$dlcolor.'" href="'.$url.'/?s2member_file_download='.str_replace('&', '%26', $rawname).'.'.$audioext.$s2skip.'">' 
				: '<a class="ssfa-audio-download '.$dlcolor.'" href="'.$sourcefileurl.'.'.$audioext.'" download="'.$rawname.'.'.$audioext.'">';
			$players .= '<div class="ssfa-audio-download" style="margin-bottom:10px;">';
			$players .= '<span class="ssfa-fileaplay-in ssfa-audio-download"></span>';
			$players .= strtoupper($audioext);
			$players .= '</div>';
			$players .= '</a>'; 
			if($sourcecount > 1) $has_multiple = 1;
			$sourcecount++;
		}
	}
 	$used[] = $rawname; 
}
if($skipthis) continue; 