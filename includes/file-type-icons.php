<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
$linktype = 'download="'.$rawname.'.'.$oext.'"';
if (SSFA_NEWWINDOW !== ''):
	$newwindows = preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', SSFA_NEWWINDOW));
	foreach ($newwindows as $new):
		if ($extension === strtolower($new) || '.' . $extension === strtolower($new)): 
			$linktype = 'target="_blank"'; 
			break; 
		endif;
	endforeach;
endif;
if (!$icons || $icons === 'filetype'):
	$icontype = false; $icon = null;
	while(!$icontype):
		if(in_array($extension, $GLOBALS['ssfa_adobe'])): $icon = '&#x21;'; $icontype = 'adobe'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_image'])): $icon = '&#x31;'; $icontype = 'image'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_audio'])): $icon = '&#x43;'; $icontype = 'audio'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_video'])): $icon = '&#x57;'; $icontype = 'video'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_msdoc'])): $icon = '&#x23;'; $icontype = 'msdoc'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_msexcel'])): $icon = '&#x24;'; $icontype = 'msexcel'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_powerpoint'])): $icon = '&#x26;'; $icontype = 'powerpoint'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_openoffice'])): $icon = '&#x22;'; $icontype = 'openoffice'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_text'])): $icon = '&#x2e;'; $icontype = 'text'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_compression'])): $icon = '&#x27;'; $icontype = 'compression'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_application'])): $icon = '&#x54;'; $icontype = 'application'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_script'])): $icon = '&#x25;'; $icontype = 'script'; if($icontype) break; endif;
		if(in_array($extension, $GLOBALS['ssfa_css'])): $icon = '&#x28;'; $icontype = 'css'; if($icontype) break; endif;
		$icon = '&#x29;'; $icontype = 'unknown'; 
	endwhile;
	$iconstyle = ($type === 'table' ? 'ssfa-faminicon' : 'ssfa-listicon');
	$icon = "<span data-ssfa-icon='$icon' class='$iconstyle $icocol' aria-hidden='true'></span>";
	$icon = ($type === 'table' ? $icon.'<br />' : $icon);
else:
	$papersize = ($type === 'table' ? ' style="font-size:18px;"' : null);
	$icon = ($icons === 'paperclip' ? "<span data-ssfa-icon='&#xe1d0;' class='ssfa-paperclip $icocol' $papersize aria-hidden='true'></span>" : null);
	$icon = ($type === 'table' ? $icon.'<br />' : $icon);
endif;
if($getthumb):
	if($thumbnails === 'permanent'):
		$icon = $thumblink ? '<img src="'.$thumblink.'" class="ssfa-thumb ssfa-thumb-'.$thumbstyle.$graythumbs.'">' : $icon;
	else:
		$thumb = SSFA_INCLUDES_URL.'thumbnails.php?fileaway='.base64_encode($ssfa_abspath.$srcpath.'/'.$file).'&width='.$thumbwidth.'&height='.$thumbheight.'';
		$icon = '<img src="'.$thumb.'" class="ssfa-thumb ssfa-thumb-'.$thumbstyle.$graythumbs.'">';
	endif;
endif;