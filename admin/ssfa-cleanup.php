<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
if(!wp_next_scheduled( 'ssfa_scheduled_cleanup')) wp_schedule_event(time(), 'hourly', 'ssfa_scheduled_cleanup');
add_action('ssfa_scheduled_cleanup', 'ssfa_cleanup' );
function ssfa_cleanup(){
	if(is_dir(SSFA_PLUGIN.'/ssfatemp')):
		$zips = glob(SSFA_PLUGIN.'/ssfatemp/*'); $time = time();
		if(is_array($zips)): foreach($zips as $zip): if(is_file($zip)) if($time - filemtime($zip) >= 60*60) unlink($zip); endforeach; endif;
	endif;
	die();
}