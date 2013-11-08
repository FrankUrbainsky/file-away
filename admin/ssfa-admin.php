<?php 


// MODAL STYLES
function file_away_style() {
	global $pagenow;
	
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
		wp_register_style( 'ssfa-modal', SSFA_ADMIN_CSS_URL.'ssfa-modal.css' ); 
		wp_enqueue_style( 'ssfa-modal' ); 
	}
}
add_action( 'admin_enqueue_scripts', 'file_away_style' );

// TINY MCE FILE AWAY MODAL
	add_action('init','ssfa_add_button');
	function ssfa_add_button()
	{  
		if(current_user_can(SSFA_MODALACCESS))
		{
			add_filter('mce_external_plugins', 'ssfa_add_plugin');  
			add_filter('mce_buttons'.SSFA_TMCEROWS.'', 'ssfa_register_button');
		}
	}

	function ssfa_register_button($buttons) 
	{ 
		array_push($buttons, "ssfamodal");  
		return $buttons;
	}

	function ssfa_add_plugin($plugin_array)
	{  
	   $plugin_array['ssfamodal'] = SSFA_ADMIN_URL.'ssfa-modal.js';   
	   return $plugin_array;
	}  
	foreach( array('post.php','post-new.php') as $hook )
	    add_action( "admin_head-$hook", 'ssfa_admin_head_js_vars' );

/**

 * Localize Script

**/

	function ssfa_admin_head_js_vars() 
	{
        $faimg = SSFA_IMAGES_URL.'tmcessfa.png';
        ?>
<!-- TinyMCE Shortcode Plugin -->
<script type='text/javascript'>
    var ssfa_mce_config = {
        'tb_title': '<?php _e('File Away'); ?>',
        'button_img': '<?php echo $faimg; ?>',
        'ajax_url': '<?php echo admin_url( 'admin-ajax.php')?>',
        'ajax_nonce': '<?php echo wp_create_nonce( '_nonce_tinymce_shortcode' ); ?>' 
    };
</script>
<!-- TinyMCE Shortcode Plugin -->
        <?php
	}

add_action( 'wp_ajax_ssfa_tinymce_shortcode', 'ssfa_tinymce_shortcode' );
function ssfa_tinymce_shortcode() 
	{
    $do_check = check_ajax_referer( '_nonce_tinymce_shortcode', 'security', false ); 
    if( !$do_check )
        echo 'error';
    else
        include_once SSFA_ADMIN.'ssfa-modal.php';
    exit();
	}

// PLUGINS PAGE LINK
function ss_file_away_plugin_action_links ( $links, $file ) 
{
	if ( $file == plugin_basename ( SSFA_FILE ) ) 
	{
		$ss_file_away_links = '<a href="'.get_admin_url ( ).'admin.php?page=file-away">'.__('Configuration').'</a>';
		array_unshift ( $links, $ss_file_away_links ); 
	}	
	return $links; 
}
add_filter( 'plugin_action_links', 'ss_file_away_plugin_action_links', 10, 2 );

// CONFIG NOTICE
add_action('admin_init', 'ssfa_config_nag_ignore');
function ssfa_config_nag_ignore() 
{
	global $current_user;
	$user_id = $current_user->ID;
	if ( isset($_GET['ssfa_config_nag_ignore']) && '0' == $_GET['ssfa_config_nag_ignore'] ) 
	{
		add_user_meta($user_id, 'ssfa_ignore_config_notice', 'true', true);
	}
}
add_action('admin_notices', 'ssfa_config_notice');
function ssfa_config_notice()
{
	global $current_user;
    $user_id = $current_user->ID;
    global $pagenow;
	if ( SSFA_BASE1 === null || SSFA_BS1NAME === '' ||  SSFA_BASE1 === '' || SSFA_BS1NAME === null ) 
	{
		if ( ! get_user_meta($user_id, 'ssfa_ignore_config_notice') ) 
		{
	    	if ( $pagenow == 'plugins.php' ) 
			{
				echo '<div class="updated"><p>';
				printf(__(
					'<strong>File Away Notice:</strong> Your shortcode generator on the TinyMCE panel will not offer full functionality until you assign your first Base Directory and give it a display name. <a href="'.get_admin_url ( ).'admin.php?page=file-away">Get Started</a> | <a href="%1$s">Dismiss</a>'
				 ), '?ssfa_config_nag_ignore=0');
		        echo "</p></div>";
			}
			
	    	if ( $_SERVER['QUERY_STRING'] == 'page=file-away' )
			{
				echo '<div class="updated"><p>';
				printf(__(
					'<strong>File Away Notice:</strong> Your shortcode generator on the TinyMCE panel will not offer full functionality until you assign your first Base Directory and give it a display name. <a href="%1$s">Dismiss</a>'
				 ), '?ssfa_config_nag_ignore=0');
		        echo "</p></div>";
			}

    	}
	}
}
