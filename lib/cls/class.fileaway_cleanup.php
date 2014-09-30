<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_cleanup'))
{
	class fileaway_cleanup
	{
		public function __construct()
		{
			if(!wp_next_scheduled('ssfa_scheduled_cleanup')) 
				wp_schedule_event(time(), 'hourly', 'ssfa_scheduled_cleanup');
			add_action('ssfa_scheduled_cleanup', array($this, 'cleanup'));	
		}
		public function cleanup()
		{
			if(is_dir(fileaway_dir.'/temp'))
			{
				$zips = glob(fileaway_dir.'/temp/*'); 
				if(is_array($zips)) foreach($zips as $zip) if(is_file($zip) && (time() - filemtime($zip)) >= 60*60) unlink($zip);
			}
			die();	
		}
	}
}