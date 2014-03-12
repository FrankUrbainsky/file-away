<?php

strtolower($ext);
$linktype = 'download';
if (SSFA_NEWWINDOW !== ''):
	$newwindows = preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', SSFA_NEWWINDOW));
	foreach ($newwindows as $new):
		if (strtolower($ext) === strtolower($new) || '.' . strtolower($ext) === strtolower($new)): $linktype = 'target="_blank"'; break; endif;
	endforeach;
endif;
if (!$icons || $icons === 'filetype'):
	$iconmatch = false;
	if ($iconmatch === false):
		$adobe = array('pdf', 'ai', 'aep', 'eps', 'flv', 'fla', 'psd', 'indd', 'pmd', 'fm', 'afm', 'abf', 'psb', 'pdd', 'prc', 'as', 'ppj', 'swf', 'ps');
		foreach ($adobe as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x21;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$pics = array('jpeg', 'jfif', 'jpg', 'gif', 'bmp', 'png', 'tiff', 'tif', 'raw', 'ppm' , 'exif', 'pgm', 'pbm', 'pnm', 'pfm', 'pam', 'webp', 'hdr', 'rgbe', 'iff', 'tga', 'jxr', 'hdp', 'wdp', 'dds', 'thm', 'yuv');
		foreach ($pics as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x31;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$zips = array('zip', '7z', 'rar', 'gz', 'a', 'ar', 'cpio', 'shar', 'tar', 'mar', 'bz2', 'lz', 'lzma', 'lzo', 'rz', 'sfark', 'xz', 'z', 's7z', 'ace', 'afa', 'cab', 'cfs', 'cpt', 'dar', 'dd', 'dmg', 'sda', 'tar.gz', 'tgz', 'zipx', 'zz');
		foreach ($zips as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x27;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$docs = array('doc', 'docx', 'dot', 'dotx', 'docm'); 
		foreach ($docs as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x23;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$excel = array('xls', 'xlsx', 'xlw', 'xlt', 'xlsm', 'xltx', 'xltm', 'xlsb');
		foreach ($excel as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x24;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$openoffice = array('odp', 'ods', 'odt', 'dbf', 'sxw', 'stw', 'sxc', 'stc', 'sxi', 'sti');
		foreach ($openoffice as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x22;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$texts = array('wpd', 'wps', 'xml', 'rtf', 'txt', 'log', 'csv', 'uot', 'uof', 'psw', 'wk1', 'wks', '123', 'sql');
		foreach ($texts as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x2e;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$music = array('wav', 'mp3', 'ram', 'aac', 'amr', 'm4a', 'mp2', 'mid', 'm4b', 'ogg', 'aif', 'aiff');
		foreach ($music as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x43;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$videos = array('wmv', 'qt', 'avi', 'mkv', 'mp4', 'm4v', 'rmvb', 'vob', 'rm', 'divx', 'mov', 'm4p', 'mpeg', 'mpg');
		foreach ($videos as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x57;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$powerpoint = array('pps', 'ppt', 'pot', 'pptx', 'pptm', 'potx', 'potm', 'pub');
		foreach ($powerpoint as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x26;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false): 
		$apps = array('bat', 'dll', 'exe', 'msi'); 
		foreach ($apps as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x54;'; $iconmatch = true; break; endif; endforeach;
	endif;		
	if ($iconmatch === false):
		$scripts = array('js', 'pl', 'py', 'rb', 'php', 'htm', 'html', 'cgi', 'asp', 'cfm', 'cpp', 'yml', 'shtm', 'shtml', 'xhtm', 'xhtml', 'java', 'clas', 'class');
		foreach ($scripts as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x25;'; $iconmatch = true; break; endif; endforeach;
	endif;
	if ($iconmatch === false):
		$css = array('css', 'less', 'scss', 'sass');
		foreach ($css as $a): if (strtolower($ext) === strtolower($a)): $icon = '&#x28;'; $iconmatch = true; break; endif; endforeach;
	endif;
	$icon = ($iconmatch === false ? '&#x29;' : $icon);
	$iconstyle = ($type === 'table' ? 'ssfa-faminicon' : 'ssfa-listicon');
	$icon = "<span data-ssfa-icon='$icon' class='$iconstyle $icocol' aria-hidden='true'></span>";
	$icon = ($type === 'table' ? $icon.'<br />' : $icon);
else:
	$papersize = ($type === 'table' ? ' style="font-size:18px;"' : null);
	$icon = ($icons === 'paperclip' ? "<span data-ssfa-icon='&#xe1d0;' class='ssfa-paperclip $icocol' $papersize aria-hidden='true'></span>" : null);
	$icon = ($type === 'table' ? $icon.'<br />' : $icon);
endif;

?>