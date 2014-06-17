<?php
// DETERMINE ABSPATH IF WP INSTALL IS IN SUBFOLDER OF DOMAIN ROOT
$ssfa_install = false; if(get_bloginfo('url') !== get_bloginfo('wpurl')): 
$ssfa_install = ltrim(str_replace(rtrim(get_bloginfo('url'), '/'), '', rtrim(get_bloginfo('wpurl'), '/')), '/').'/'; endif;
$ssfa_abspath = ($ssfa_install ? substr_replace(ABSPATH, '', strrpos(ABSPATH, $ssfa_install), strlen($ssfa_install)) : ABSPATH);
$ssfa_abspath = (SSFA_ROOT === 'siteurl' ? $ssfa_abspath : ABSPATH);
$ssfa_playback_url = SSFA_ROOT === 'siteurl' ? rtrim(get_bloginfo('url'),'/').'/' : rtrim(get_bloginfo('wpurl'),'/').'/';
// UTILITY ARRAYS
$ssfa_imagetypes = array('bmp', 'jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff');
$ssfa_codexts = array('js', 'pl', 'py', 'rb', 'css', 'less', 'scss', 'sass', 'php', 'htm', 'html', 'cgi', 'asp', 'cfm', 'cpp', 'yml', 'shtm', 'xhtm', 'java', 'class');
$ssfa_nevershow = array('index.htm', 'index.html', 'index.php', '.htaccess', '.htpasswd');
$ssfa_permexclusions = SSFA_EXCLUSIONS ? preg_split('/(, |,)/', SSFA_EXCLUSIONS) : array(); 
// FILE TYPE ICONS
$ssfa_adobe = array('pdf', 'ai', 'aep', 'eps', 'flv', 'fla', 'psd', 'indd', 'pmd', 'fm', 'afm', 'abf', 'psb', 'pdd', 'prc', 'as', 'ppj', 'swf', 'ps');
$ssfa_image = array('jpeg', 'jfif', 'jpg', 'gif', 'bmp', 'png', 'tiff', 'tif', 'raw', 'ppm' , 'exif', 'pgm', 'pbm', 'pnm', 'pfm', 'pam', 'webp', 'hdr', 'rgbe', 'iff', 'tga', 'jxr', 'hdp', 'wdp', 'dds', 'thm', 'yuv');
$ssfa_compression = array('zip', '7z', 'rar', 'gz', 'a', 'ar', 'cpio', 'shar', 'tar', 'mar', 'bz2', 'lz', 'lzma', 'lzo', 'rz', 'sfark', 'xz', 'z', 's7z', 'ace', 'afa', 'cab', 'cfs', 'cpt', 'dar', 'dd', 'dmg', 'sda', 'tar.gz', 'tgz', 'zipx', 'zz');
$ssfa_msdoc = array('doc', 'docx', 'dot', 'dotx', 'docm'); 
$ssfa_msexcel = array('xls', 'xlsx', 'xlw', 'xlt', 'xlsm', 'xltx', 'xltm', 'xlsb');
$ssfa_openoffice = array('odp', 'ods', 'odt', 'dbf', 'sxw', 'stw', 'sxc', 'stc', 'sxi', 'sti');
$ssfa_text = array('wpd', 'wps', 'xml', 'rtf', 'txt', 'log', 'csv', 'uot', 'uof', 'psw', 'wk1', 'wks', '123', 'sql');
$ssfa_audio = array('mp3', 'wav', 'ram', 'aac', 'amr', 'm4a', 'mp2', 'mid', 'm4p', 'm4b', 'ogg', 'aif', 'aiff', 'rex', 'rx2', 'gsm', 'spx', 'wma', 'mpc', 'ots', 'swa', 'vox', 'iff', 'aifc', 'au', 'bwf', 'raw', 'flac', 'la', 'ape', 'tta', 'wv');
$ssfa_video = array('wmv', 'qt', 'avi', 'mkv', 'mp4', 'm4v', 'rmvb', 'vob', 'rm', 'divx', 'mov', 'm4p', 'mpeg', 'mpg');
$ssfa_powerpoint = array('pps', 'ppt', 'pot', 'pptx', 'pptm', 'potx', 'potm', 'pub');
$ssfa_application = array('bat', 'dll', 'exe', 'msi'); 
$ssfa_script = array('js', 'pl', 'py', 'rb', 'php', 'htm', 'html', 'cgi', 'asp', 'cfm', 'cpp', 'yml', 'shtm', 'shtml', 'xhtm', 'xhtml', 'java', 'clas', 'class');
$ssfa_css = array('css', 'less', 'scss', 'sass');