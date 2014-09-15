<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$recursive = false;
$basecheck = trim("$dir",'/');
if(strpos("$basecheck", '/') !== false)
{
	$subbase = strrchr("$basecheck", "/"); 
	$basebase = str_replace("$subbase", '', "$basecheck"); 
}
else
{ 
	$basebase = "$basecheck";
	$subbase = "$basebase";
}
if(isset($_REQUEST['drawer']))
{ 
	$rawdrawer = $_GET['drawer'];
	$aposdrawer = stripslashes("$rawdrawer");
	if($aposdrawer === "/") $aposdrawer = trim($start, '/');
	$dir = "$basebase"."/"."$aposdrawer"; 
	$dir = str_replace('*', '/', "$dir");
	if($rawdrawer === '') $dir = "$start";
	if(!is_dir("$dir")) $dir = "$start";
	if(strpos("$dir", '..') !== false) $dir = "$start";
}
if($private_content)
{
	if($fa_firstlast_used && stripos("$dir", "$fa_firstlast") === false) $dir = "$start"; 
	if($fa_userid_used && strpos("$dir", "$fa_userid") === false) $dir = "$start";
	if($fa_username_used && stripos("$dir", "$fa_username") === false) $dir = "$start"; 
	if($fa_userrole_used && stripos("$dir", "$fa_userrole") === false) $dir = "$start"; 
}
$baselessdir = fileaway_utility::replacefirst("$dir", "$basebase", '');
if($basebase !== $basecheck) $crumbs = explode('/', ltrim("$baselessdir", '/'));
else $crumbs = explode('/', trim("$dir", '/'));		
if(!is_array($crumbs)) $crumbs = array();
$crumblink = array();
$addclass = !$heading ? '-noheading' : null;
$thefiles .= "<div class='ssfa-crumbs$addclass'>";
foreach($crumbs as $k => $crumb)
{
	$crumblink[$k] = '';
	$prettycrumb = str_replace(array('~', '--', '_', '.', '*'), ' ', $crumb); 
	$prettycrumb = preg_replace('/(?<=\D)-(?=\D)/', ' ', $prettycrumb);
	$prettycrumb = preg_replace('/(?<=\d)-(?=\D)/', ' ', $prettycrumb);
	$prettycrumb = preg_replace('/(?<=\D)-(?=\d)/', ' ', $prettycrumb);
	$prettycrumb = fileaway_utility::strtotitle($prettycrumb);
	if($crumb !== '')
	{
		$i = 0; 
		while($i <= $k)
		{ 
			if ($i == 0) $comma = ''; 
			else $comma ="*"; 
			$crumblink[$k] .= $comma."$crumbs[$i]"; 
			$i++; 
		}
		if($basebase === $basecheck) $crumblink[$k] = ltrim(fileaway_utility::replacefirst("$crumblink[$k]", "$basebase", ''), '*');
		$thefiles .= '<a href="'.add_query_arg(array('drawer' => $crumblink[$k]), get_permalink()).'">'."$prettycrumb".'</a> / ';
	}
}
$thefiles .= "</div>";
if($search == 'no') $thefiles .= '<div style="display:block; visibility:hidden; margin:40px 0 0;"></div>';