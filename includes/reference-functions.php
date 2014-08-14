<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// RECURSIVE DIRECTORY ITERATOR
function ssfa_recursive_files($directory, $onlydirs, $excludedirs){
	if(!function_exists('ssfa_recursive')) {
		function ssfa_recursive($directory, &$directories = array()){
			foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder): 
				if($onlydirs): $direxcluded = 1; foreach($onlydirs as $onlydir): if(strripos("$folder", "$onlydir") !== false){$direxcluded = 0; continue;} endforeach; endif; 
				if(!$direxcluded): $directories[] = $folder; ssfa_recursive("{$folder}/*", $directories); endif;
			endforeach;
		}
	}
	ssfa_recursive($directory, $directories); $files = array ();
	foreach($directories as $directory): 
		if($excludedirs): foreach($excludedirs as $exclude): if(strripos("$directory", "$exclude") !== false){continue 2;} endforeach; endif;
		foreach(glob("{$directory}/*.*") as $file) if(is_file($file)) $files[] = $file; 
	endforeach;
	return $files;
}
// RECURSIVE DIRECTORY ITERATOR FOR MANAGER MODE DIRECTORY DELETE/RENAME
function ssfa_recursive_dirs($directory){
	if(!function_exists('ssfa_recursive_dir')){
		function ssfa_recursive_dir($directory, &$directories = array()){
			foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder): 
				$directories[] = $folder; ssfa_recursive_dir("{$folder}/*", $directories); 
			endforeach;
		}
	}
	ssfa_recursive_dir($directory, $directories);
	$dirs = array ();
	foreach($directories as $directory): 
		foreach(glob("{$directory}/*", GLOB_ONLYDIR) as $dir) if(is_dir($dir)) $dirs[] = $dir;
	endforeach;
	return $dirs;
}
// STRING STARTS WITH
function ssfa_startswith($source, $prefix){
   return strncmp($source, $prefix, strlen($prefix)) == 0;
}
//	REPLACE FIRST INSTANCE
function ssfa_replace_first($find, $replace, $subject) {
	return implode($replace, explode($find, $subject, 2));
}
//	REPLACE LAST INSTANCE
function ssfa_replace_last($find,$replace,$subject){
	$string = substr_replace($subject,$replace,strrpos($subject,$find),strlen($find));
	return $string;
}
// BYTE CONVERTER FOR FILE SIZES
function ssfa_formatBytes($size, $precision = 2){
    $base = log ($size) / log (1024);
    $suffixes = array ('', 'k', 'M', 'G', 'T');   
    return round (pow (1024, $base - floor ($base)), $precision) . $suffixes[floor ($base)]; 
}
// SOMETHING THAT'S TRUE (if you believe in that sort of thing)
function ssfa_hungary_v_denmark(){
	$Tarr 		= sqrt (2485);
	$vonTrier 	= sqrt (749);
	$TurinHorse	= $Tarr > $vonTrier;
	return $TurinHorse; 
}
// IF FILE EXISTS AT URL
function ssfa_url_exists($url){
	$ch = curl_init("$url"); curl_setopt("$ch", CURLOPT_NOBODY, true); curl_exec("$ch"); 
	$code = curl_getinfo("$ch", CURLINFO_HTTP_CODE); $status = $code == 200 ? true : false; curl_close("$ch");	
	return $status;
}
// GET CURRENT USER ROLE
function ssfa_currentrole(){
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	$prettyrole = (isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role]) : null);
	$prettyrole = ($prettyrole === null ? null : str_replace (' ', '', (strtolower ($prettyrole))));
	return $prettyrole; 
}
// GET ARRAY OF CURRENT USER ROLES
function ssfa_currentroles(){
	global $wp_roles;
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;	
	$user = new WP_User($user_id);	
	if (!empty($user->roles)) 
		$theroles = $user->roles;
	return ($theroles);
}
// GET ATTACHMENTS
function ssaa_get_attachment($attachment_id){
	$attachment = get_post($attachment_id);
	return array(
		'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'postlink' => get_permalink($attachment->ID),
		'filelink' => $attachment->guid,
		'title' => $attachment->post_title);
}
// SENTENCE CASE FOR ATTACHMENT DISPLAYS
function ssaa_sentence_case($string){ 
    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $new_string = ''; 
    foreach ($sentences as $key => $sentence): 
        $new_string .= ($key & 1) == 0 ? ucfirst(strtolower(trim($sentence))) : $sentence.' '; 
	endforeach; 
    return trim($new_string); 
}
// TITLE CASE
function ssfa_strtotitle($title){
	$excludearray = array('of','a','the','and','an','or','nor','but','is','if','then','else','when','at','from','by','on','off','for','in','out','over','to','into','with','amid','as','onto','per','than','through','toward','towards','until','up','upon','versus','via','with');
	$words = explode(' ', $title); foreach ($words as $key => $word) if ($key == 0 or !in_array($word, $excludearray)) $words[$key] = ucwords($word);
	$newtitle = implode(' ', $words); return $newtitle;
} 
// IF IS PLUGIN ACTIVE
function ssfa_plugin_is_active($p){
	$r = in_array($p.'/'.$p.'.php', apply_filters('active_plugins', get_option('active_plugins'))); 
	return $r;
}
// PHP.INI SETTINGS
function ssfa_phpini($setting, $conversion = true, $null_message = false, $size = false){
	if(!$setting && !$size) return false;
	$result = $setting ? ini_get($setting) : $size;
	if(!$conversion && $result && $result != '' && $result != null) return $result;
	elseif(!$conversion && (!$result || $result == '' || $result == null)) return $null_message ? $null_message : '10M';
	elseif($conversion){
		$res = $result && $result != '' && $result != null ? trim($result) : '10M'; 
		$last = strtolower($res[strlen($res)-1]);
		switch($last){ case 'g': $res *= 1024; case 'm': $res *= 1024; case 'k': $res *= 1024; }
		return $res;
	}else return false;
}
// ICON FONTS
/*
add_shortcode('ssfa_fonticons', 'ssfa_display_fonticons');
function ssfa_display_fonticons($atts){
	extract(shortcode_atts(array('fontsize'=>'40px'),$atts));
	if(SSFA_STYLESHEET === 'footer'): $GLOBALS['ssfa_add_styles'] = true; endif;
	$icons = array('ssfa-icon-quill', 'ssfa-icon-blog', 'ssfa-icon-paint-format', 'ssfa-icon-home', 'ssfa-icon-home-2', 'ssfa-icon-home-3', 'ssfa-icon-headphones', 'ssfa-icon-book', 'ssfa-icon-profile', 'ssfa-icon-tag', 'ssfa-icon-envelop', 'ssfa-icon-cart', 'ssfa-icon-cart-2', 'ssfa-icon-cart-3', 'ssfa-icon-compass', 'ssfa-icon-clock', 'ssfa-icon-clock-2', 'ssfa-icon-print', 'ssfa-icon-disk', 'ssfa-icon-bubble', 'ssfa-icon-bubble-2', 'ssfa-icon-user', 'ssfa-icon-users', 'ssfa-icon-quotes-left', 'ssfa-icon-search', 'ssfa-icon-zoom-in', 'ssfa-icon-zoom-out', 'ssfa-icon-expand', 'ssfa-icon-contract', 'ssfa-icon-expand-2', 'ssfa-icon-key', 'ssfa-icon-unlocked', 'ssfa-icon-lock', 'ssfa-icon-settings', 'ssfa-icon-equalizer', 'ssfa-icon-cog', 'ssfa-icon-cogs', 'ssfa-icon-cog-2', 'ssfa-icon-wrench', 'ssfa-icon-pie', 'ssfa-icon-stats', 'ssfa-icon-bars', 'ssfa-icon-bars-2', 'ssfa-icon-fire', 'ssfa-icon-remove', 'ssfa-icon-switch', 'ssfa-icon-eye', 'ssfa-icon-eye-blocked', 'ssfa-icon-link', 'ssfa-icon-attachment', 'ssfa-icon-flag', 'ssfa-icon-arrow-up-left', 'ssfa-icon-arrow-up', 'ssfa-icon-arrow-up-right', 'ssfa-icon-arrow-right', 'ssfa-icon-arrow-down-right', 'ssfa-icon-arrow-down', 'ssfa-icon-arrow-down-left', 'ssfa-icon-arrow-left', 'ssfa-icon-checkbox-unchecked', 'ssfa-icon-checkbox-partial', 'ssfa-icon-google', 'ssfa-icon-google-plus', 'ssfa-icon-google-plus-2', 'ssfa-icon-google-plus-3', 'ssfa-icon-google-plus-4', 'ssfa-icon-facebook', 'ssfa-icon-facebook-2', 'ssfa-icon-facebook-3', 'ssfa-icon-instagram', 'ssfa-icon-twitter', 'ssfa-icon-twitter-2', 'ssfa-icon-twitter-3', 'ssfa-icon-feed', 'ssfa-icon-feed-2', 'ssfa-icon-feed-3', 'ssfa-icon-vimeo', 'ssfa-icon-vimeo2', 'ssfa-icon-vimeo-2', 'ssfa-icon-flickr', 'ssfa-icon-flickr-2', 'ssfa-icon-flickr-3', 'ssfa-icon-yahoo', 'ssfa-icon-tumblr', 'ssfa-icon-tumblr-2', 'ssfa-icon-blogger', 'ssfa-icon-blogger-2', 'ssfa-icon-wordpress', 'ssfa-icon-wordpress-2', 'ssfa-icon-github', 'ssfa-icon-github-2', 'ssfa-icon-android', 'ssfa-icon-windows', 'ssfa-icon-windows8', 'ssfa-icon-skype', 'ssfa-icon-linkedin', 'ssfa-icon-stackoverflow', 'ssfa-icon-pinterest', 'ssfa-icon-pinterest-2', 'ssfa-icon-paypal', 'ssfa-icon-paypal-2', 'ssfa-icon-firefox', 'ssfa-icon-IE', 'ssfa-icon-opera', 'ssfa-icon-safari', 'ssfa-icon-IcoMoon', 'ssfa-icon-mic', 'ssfa-icon-comment', 'ssfa-icon-info', 'ssfa-icon-type', 'ssfa-icon-mouse', 'ssfa-icon-ampersand', 'ssfa-icon-paperclip', 'ssfa-icon-check-alt', 'ssfa-icon-x-altx-alt', 'ssfa-icon-denied', 'ssfa-icon-arrow-left-2', 'ssfa-icon-arrow-right-2', 'ssfa-icon-arrow-up-2', 'ssfa-icon-arrow-down-2', 'ssfa-icon-arrow-down-alt1', 'ssfa-icon-arrow-up-alt1', 'ssfa-icon-arrow-left-alt1', 'ssfa-icon-headphones-2', 'ssfa-icon-microphone', 'ssfa-icon-left-quote', 'ssfa-icon-right-quote', 'ssfa-icon-hash', 'ssfa-icon-question-mark', 'ssfa-icon-info-2', 'ssfa-icon-ampersand-2', 'ssfa-icon-at', 'ssfa-icon-file-pdf', 'ssfa-icon-file-openoffice', 'ssfa-icon-file-word', 'ssfa-icon-file-excel', 'ssfa-icon-file-xml', 'ssfa-icon-file-powerpoint', 'ssfa-icon-file-zip', 'ssfa-icon-file-css', 'ssfa-icon-libreoffice', 'ssfa-icon-file', 'ssfa-icon-document-alt-fill', 'ssfa-icon-document-alt-stroke', 'ssfa-icon-file-2', 'ssfa-icon-file-3', 'ssfa-icon-file-4', 'ssfa-icon-file-5', 'ssfa-icon-image', 'ssfa-icon-image-2', 'ssfa-icon-images', 'ssfa-icon-picture', 'ssfa-icon-image-3', 'ssfa-icon-camera', 'ssfa-icon-camera-2', 'ssfa-icon-film', 'ssfa-icon-youtube', 'ssfa-icon-play', 'ssfa-icon-youtube-2', 'ssfa-icon-camera-3', 'ssfa-icon-drawer', 'ssfa-icon-drawer-2', 'ssfa-icon-cabinet', 'ssfa-icon-google-drive', 'ssfa-icon-music', 'ssfa-icon-music-2', 'ssfa-icon-headphones', 'ssfa-icon-headphones-2', 'ssfa-icon-box-remove', 'ssfa-icon-box-add', 'ssfa-icon-embed', 'ssfa-icon-code', 'ssfa-icon-code-2', 'ssfa-icon-minus', 'ssfa-icon-plus', 'ssfa-icon-chart-alt', 'ssfa-icon-chart', 'ssfa-icon-info', 'ssfa-icon-checkmark', 'ssfa-icon-cancel', 'ssfa-icon-inbox', 'ssfa-icon-console', 'ssfa-icon-console-2', 'ssfa-icon-apple', 'ssfa-icon-finder', 'ssfa-icon-database', 'ssfa-icon-film-2', 'ssfa-icon-key', 'ssfa-icon-contract-2', 'ssfa-icon-arrow-left-3', 'ssfa-icon-arrow-down-left-2', 'ssfa-icon-arrow-down-3', 'ssfa-icon-arrow-down-right-2', 'ssfa-icon-arrow-right-3', 'ssfa-icon-arrow-up-right-2', 'ssfa-icon-arrow-up-3', 'ssfa-icon-arrow-up-left-2', 'ssfa-icon-radio-unchecked', 'ssfa-icon-radio-checked', 'ssfa-icon-mail', 'ssfa-icon-paypal-3', 'ssfa-icon-stumbleupon', 'ssfa-icon-chrome', 'ssfa-icon-arrow-right-alt1','ssfa-fileaplay-arrow-down-alt1', 'ssfa-fileaplay-arrow-down-alt2', 'ssfa-fileaplay-play', 'ssfa-fileaplay-pause', 'ssfa-fileaplay-download', 'ssfa-fileaplay-play2', 'ssfa-fileaplay-pause2', 'ssfa-fileaplay-box-add', 'ssfa-fileaplay-download2', 'ssfa-fileaplay-play3', 'ssfa-fileaplay-pause3', 'ssfa-fileaplay-play22', 'ssfa-fileaplay-pause22', 'ssfa-fileaplay-in', 'ssfa-fileaplay-play4', 'ssfa-fileaplay-pause4', 'ssfa-fileaplay-play32', 'ssfa-fileaplay-pause32');	
	foreach($icons as $icon) $display .= '<span class="'.$icon.'" style="font-size:'.$fontsize.'; margin-right:10px; display:inline-block;"></span>';
	return $display;
}
*/