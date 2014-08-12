<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// DETERMINE ABSPATH IF WP INSTALL IS IN SUBFOLDER OF DOMAIN ROOT
$ssfa_install = false; if(get_bloginfo('url') !== get_bloginfo('wpurl')): 
$ssfa_install = ltrim(str_replace(rtrim(get_bloginfo('url'), '/'), '', rtrim(get_bloginfo('wpurl'), '/')), '/').'/'; endif;
$ssfa_abspath = ($ssfa_install ? substr_replace(ABSPATH, '', strrpos(ABSPATH, $ssfa_install), strlen($ssfa_install)) : ABSPATH);
$ssfa_abspath = (SSFA_ROOT === 'siteurl' ? $ssfa_abspath : ABSPATH);
$ssfa_playback_url = SSFA_ROOT === 'siteurl' ? rtrim(get_bloginfo('url'),'/').'/' : rtrim(get_bloginfo('wpurl'),'/').'/';
// S2MEMBER CHECK
$ssfa_s2member = ssfa_plugin_is_active('s2member') ? true : false; 
// UTILITY ARRAYS
$ssfa_imagetypes = array('bmp', 'jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff');
$ssfa_codexts = array('js', 'pl', 'py', 'rb', 'css', 'less', 'scss', 'sass', 'php', 'htm', 'html', 'cgi', 'asp', 'cfm', 'cpp', 'yml', 'shtm', 'xhtm', 'java', 'class');
$ssfa_nevershow = array('index.htm', 'index.html', 'index.php', '.htaccess', '.htpasswd');
$ssfa_permexclusions = SSFA_EXCLUSIONS ? preg_split('/(, |,)/', SSFA_EXCLUSIONS) : array(); 
// FILE TYPE ICONS
$ssfa_filegroups = array('adobe'=>'Adobe','application'=>'Application','audio'=>'Audio','compression'=>'Compression','css'=>'CSS','image'=>'Image','msdoc'=>'MS Doc','msexcel'=>'MS Excel','openoffice'=>'Open Office','powerpoint'=>'PowerPoint','script'=>'Script','text'=>'Text','video'=>'Video');
$ssfa_adobe = array('abf', 'aep', 'afm', 'ai', 'as', 'eps', 'fla', 'flv', 'fm', 'indd', 'pdd', 'pdf', 'pmd', 'ppj', 'prc', 'ps', 'psb', 'psd', 'swf');
$ssfa_image = array('bmp', 'dds', 'exif', 'gif', 'hdp', 'hdr', 'iff', 'jfif', 'jpeg', 'jpg', 'jxr', 'pam', 'pbm', 'pfm', 'pgm', 'png', 'pnm', 'ppm', 'raw', 'rgbe', 'tga', 'thm', 'tif', 'tiff', 'webp', 'wdp', 'yuv');
$ssfa_compression = array('7z', 'a', 'ace', 'afa', 'ar', 'bz2', 'cab', 'cfs', 'cpio', 'cpt', 'dar', 'dd', 'dmg', 'gz', 'lz', 'lzma', 'lzo', 'mar', 'rar', 'rz', 's7z', 'sda', 'sfark', 'shar', 'tar', 'tgz', 'xz', 'z', 'zip', 'zipx', 'zz');
$ssfa_msdoc = array('doc', 'docm', 'docx', 'dot', 'dotx'); 
$ssfa_msexcel = array('xls', 'xlsm', 'xlsb', 'xlsx', 'xlt', 'xltm', 'xltx', 'xlw');
$ssfa_openoffice = array('dbf', 'dbf4', 'odp', 'ods', 'odt', 'stc', 'sti', 'stw', 'sxc', 'sxi', 'sxw');
$ssfa_text = array('123', 'csv', 'log', 'psw', 'rtf', 'sql', 'txt', 'uof', 'uot', 'wk1', 'wks', 'wpd', 'wps', 'xml');
$ssfa_audio = array('aac', 'aif', 'aifc', 'aiff', 'amr', 'ape', 'au', 'bwf', 'flac', 'iff', 'gsm', 'la', 'm4a', 'm4b', 'm4p', 'mid', 'mp2', 'mp3', 'mpc', 'ogg', 'ots', 'ram', 'raw', 'rex', 'rx2', 'spx', 'swa', 'tta', 'vox', 'wav', 'wma', 'wv');
$ssfa_video = array('avi', 'divx', 'mov', 'm4p', 'm4v', 'mkv', 'mp4', 'mpeg', 'mpg', 'qt', 'rm', 'rmvb', 'vob', 'wmv');
$ssfa_powerpoint = array('pot', 'potm', 'potx', 'pps', 'ppt', 'pptm', 'pptx', 'pub');
$ssfa_application = array('bat', 'dll', 'exe', 'msi'); 
$ssfa_script = array('asp', 'cfm', 'cgi', 'clas', 'class', 'cpp', 'htm', 'html', 'java', 'js', 'php', 'pl', 'py', 'rb', 'shtm', 'shtml', 'xhtm', 'xhtml', 'yml');
$ssfa_css = array('css', 'less', 'sass', 'scss');