<?php 
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// MODAL STYLES
add_action('admin_enqueue_scripts', 'file_away_style');
function file_away_style(){
	global $pagenow;
	if ($pagenow == 'post-new.php' or $pagenow == 'post.php'){
		wp_register_style('ssfa-modal', SSFA_ADMIN_CSS_URL.'ssfa-modal.css'); 
		wp_enqueue_style('ssfa-modal'); 
	}
}
// TINY MCE FILE AWAY MODAL
add_action('admin_head','ssfa_add_button');
function ssfa_add_button(){  
	global $pagenow;
	if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ) return;
	if (current_user_can(SSFA_MODALACCESS)){
		add_filter('mce_external_plugins', 'ssfa_add_plugin');  
		add_filter('mce_buttons'.SSFA_TMCEROWS.'', 'ssfa_register_button');
	}
}
function ssfa_register_button($buttons){ 
	array_push($buttons, "ssfamodal");  
	return $buttons;
}
function ssfa_add_plugin($plugin_array){  
   $plugin_array['ssfamodal'] = SSFA_ADMIN_URL.'ssfa-modal.js';   
   return $plugin_array;
}  
foreach(array('post.php','post-new.php') as $hook): add_action("admin_head-$hook", 'ssfa_admin_head_js_vars'); endforeach;
/**
 * Localize Script
**/
function ssfa_admin_head_js_vars(){
	$faimg = SSFA_IMAGES_URL.'tmcessfa.png';
	global $wp_version;
	if ($wp_version >= 3.9) $version = 'new';
	else $version = 'old';	
?>
<script type='text/javascript'>
	var ssfa_mce_config = {
		'tb_title': '<?php _e('File Away'); ?>',
		'button_img': '<?php echo $faimg; ?>',
	    'version': '<?php echo $version; ?>',		
		'ajax_url': '<?php echo admin_url('admin-ajax.php')?>',
		'ajax_nonce': '<?php echo wp_create_nonce('_nonce_tinymce_shortcode'); ?>' 
	};
</script>
<style> i.ssfa-fileaway-icon { background-image: url('<?php echo $faimg; ?>'); } </style>
<?php
}
add_action('wp_ajax_ssfa_tinymce_shortcode', 'ssfa_tinymce_shortcode');
function ssfa_tinymce_shortcode(){
	$do_check = check_ajax_referer('_nonce_tinymce_shortcode', 'security', false); 
	if (!$do_check) echo 'error';
	else include_once SSFA_ADMIN.'ssfa-modal.php';
    exit();
}
add_filter('plugin_action_links', 'ss_file_away_plugin_action_links', 10, 2);
// PLUGINS PAGE LINK
function ss_file_away_plugin_action_links ($links, $file){
	if ($file == plugin_basename (SSFA_FILE)){
		$ss_file_away_links = '<a href="'.get_admin_url ().'admin.php?page=file-away">'.__('Configuration').'</a>';
		array_unshift ($links, $ss_file_away_links); 
	}	
	return $links; 
}
// CONFIG NOTICE
add_action('admin_init', 'ssfa_config_nag_ignore');
function ssfa_config_nag_ignore(){
	global $current_user;
	$user_id = $current_user->ID;
	if (isset($_GET['ssfa_config_nag_ignore']) and '0' == $_GET['ssfa_config_nag_ignore']):
		add_user_meta($user_id, 'ssfa_ignore_config_notice', 'true', true);
	endif;
}
add_action('admin_notices', 'ssfa_config_notice');
function ssfa_config_notice(){
	global $current_user;
    $user_id = $current_user->ID;
    global $pagenow;
	if (SSFA_BASE1 === null or SSFA_BS1NAME === '' or  SSFA_BASE1 === '' or SSFA_BS1NAME === null):
		if (! get_user_meta($user_id, 'ssfa_ignore_config_notice')):
			if ($pagenow == 'plugins.php'):
				echo '<div class="updated"><p>';
				printf(__(
					'<strong>File Away Notice:</strong> Your shortcode generator on the TinyMCE panel will not offer full functionality until you assign your first Base Directory and give it a display name. <a href="'.get_admin_url ().'admin.php?page=file-away">Get Started</a> | <a href="%1$s">Dismiss</a>'
				), '?ssfa_config_nag_ignore=0');
		        echo "</p></div>";
	    	elseif ($_SERVER['QUERY_STRING'] == 'page=file-away'):
				echo '<div class="updated"><p>';
				printf(__(
					'<strong>File Away Notice:</strong> Your shortcode generator on the TinyMCE panel will not offer full functionality until you assign your first Base Directory and give it a display name. <a href="%1$s">Dismiss</a>'
				), '?ssfa_config_nag_ignore=0');
		        echo "</p></div>";
			endif;
    	endif;
	endif;
}
