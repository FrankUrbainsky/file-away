<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$linktype = 'download="'.$rawname.'.'.$oext.'"';
if($this->op['newwindow'] !== '')
{
	$newwindows = preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', $this->op['newwindow']), -1, PREG_SPLIT_NO_EMPTY);
	if(is_array($newwindows))
	{
		foreach($newwindows as $new)
		{
			if($extension === strtolower($new) || '.' . $extension === strtolower($new))
			{ 
				$linktype = 'target="_blank"'; 
				break; 
			}
		}
	}
}
if(!$icons || $icons === 'filetype')
{
	$icontype = false; 
	$icon = null;
	while(!$icontype)
	{
		if(in_array($extension, $get->filegroups['adobe'][2])){
			$icon = '&#x21;'; 
			$icontype = 'adobe'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['image'][2]))
		{ 
			$icon = '&#x31;';
			$icontype = 'image';
			if($icontype) break; 
		}
		if(in_array($extension, $get->filegroups['audio'][2]))
		{ 
			$icon = '&#x43;';
			$icontype = 'audio';
			if($icontype) break; 
		}
		if(in_array($extension, $get->filegroups['video'][2]))
		{ 
			$icon = '&#x57;'; 
			$icontype = 'video'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['msdoc'][2]))
		{ 
			$icon = '&#x23;'; 
			$icontype = 'msdoc'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['msexcel'][2]))
		{ 
			$icon = '&#x24;'; 
			$icontype = 'msexcel'; 
			if($icontype) break; 
		}
		if(in_array($extension, $get->filegroups['powerpoint'][2]))
		{ 
			$icon = '&#x26;'; 
			$icontype = 'powerpoint'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['openoffice'][2]))
		{
			$icon = '&#x22;'; 
			$icontype = 'openoffice'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['text'][2]))
		{ 
			$icon = '&#x2e;'; 
			$icontype = 'text'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['compression'][2]))
		{ 
			$icon = '&#x27;'; 
			$icontype = 'compression'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['application'][2]))
		{ 
			$icon = '&#x54;'; 
			$icontype = 'application'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['script'][2]))
		{ 
			$icon = '&#x25;';
			$icontype = 'script'; 
			if($icontype) break;
		}
		if(in_array($extension, $get->filegroups['css'][2]))
		{ 
			$icon = '&#x28;'; 
			$icontype = 'css'; 
			if($icontype) break;
		}
		$icon = '&#x29;'; 
		$icontype = 'unknown'; 
	}
	$iconstyle = $type == 'table' ? 'ssfa-faminicon' : 'ssfa-listicon';
	$icon = "<span data-ssfa-icon='$icon' class='$iconstyle $icocol' aria-hidden='true'></span>";
	$icon = $type == 'table' ? $icon.'<br />' : $icon;
}
else
{
	$papersize = $type == 'table' ? ' style="font-size:18px;"' : null;
	$icon = $icons == 'paperclip' ? "<span data-ssfa-icon='&#xe1d0;' class='ssfa-paperclip $icocol' $papersize aria-hidden='true'></span>" : null;
	$icon = $type == 'table' ? $icon.'<br />' : $icon;
}
if($getthumb)
{
	if($thumbnails == 'permanent')
	{
		$icon = $thumblink ? '<img src="'.$thumblink.'" class="ssfa-thumb ssfa-thumb-'.$thumbstyle.$graythumbs.'">' : $icon;
	}
	else
	{
		$thumb = fileaway_url.'/lib/inc/ext.thumbnails.php?fileaway='.base64_encode($chosenpath.$srcpath.'/'.$file).'&width='.$thumbwidth.'&height='.$thumbheight.'';
		$icon = '<img src="'.$thumb.'" class="ssfa-thumb ssfa-thumb-'.$thumbstyle.$graythumbs.'">';
	}
}