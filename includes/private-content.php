<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
$private_content = false; $fa_userid_used = 0; $fa_userrole_used = 0; $fa_username_used = 0; $fa_firstlast_used = 0;
if(stripos($dir, 'fa-userid') !== false){ $private_content = true; $fa_userid_used = 1; $dir = str_ireplace('fa-userid', $fa_userid, $dir); }
if(stripos($dir, 'fa-userrole') !== false){ $private_content = true; $fa_userrole_used = 1; $dir = str_ireplace('fa-userrole', strtolower ($fa_userrole), $dir); }
if(stripos($dir, 'fa-username') !== false){ $private_content = true; $fa_username_used = 1; $dir = str_ireplace('fa-username', strtolower ($fa_username), $dir); }
if(stripos($dir, 'fa-firstlast') !== false){ $private_content = true; $fa_firstlast_used = 1; $dir = str_ireplace("fa-firstlast", strtolower ($fa_firstlast), $dir); }