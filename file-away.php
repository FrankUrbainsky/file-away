<?php
/*
** Plugin Name: File Away
** Plugin URI: http://wordpress.org/plugins/file-away/
** Text Domain: file-away
** Domain Path: /lib/lng
** Description: Upload, manage, and display files from your server directories or page attachments in stylized lists or sortable data tables.
** Version: 2.6
** Author: Thom Stark
** Author URI: http://imdb.me/thomstark
** License: GPLv3
*/
define('fileaway', __FILE__);
define('fileaway_dir', dirname(fileaway));
define('fileaway_url', plugins_url('', fileaway));
define('fileaway_version', '2.6');
if(!class_exists('fileaway_autofiler'))
{
	class fileaway_autofiler
	{
		public function __construct()
		{
			spl_autoload_register(array($this, 'load'));
		}
        private function load($class)
		{
			$file = fileaway_dir.'/lib/cls/class.'.$class.'.php';
			if(!file_exists($file)) return false;
			include_once($file);
        }
	}
}
new fileaway_autofiler;
new fileaway_languages;
if(is_admin())
{ 
	new fileaway_admin;
	new fileaway_notices;
}
new fileaway_attributes;
new fileaway_definitions;
if(!is_admin())
{ 
	new fileaway_prints;
	new fileaway;
	new attachaway;
	new fileup;
	new fileaframe;
}
new fileaway_management;
new fileaway_cleanup;
include_once fileaway_dir.'/lib/inc/inc.deprecated.php';