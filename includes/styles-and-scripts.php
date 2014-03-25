<?php
// COPY iFRAME TEMPLATE TO THEME DIRECTORY
add_action('admin_init', 'ssfa_copy_iframe_template', 30);	
function ssfa_copy_iframe_template(){
	$themedir = get_template_directory();
	$template = 'file-away-iframe-template.php';
	if (!file_exists($themedir.'/'.$template)):
		copy(SSFA_TEMPLATES.$template, $themedir.'/'.$template);
	endif;
}
// CREATE CUSTOM CSS URL
add_action('admin_init', 'ssfa_custom_css_dir_create', 20);	
function ssfa_custom_css_dir_create(){
    if (!is_dir(SSFA_CUSTOM_CSS_UPLOADS)) mkdir(SSFA_CUSTOM_CSS_UPLOADS); }
// STYLES AND SCRIPTS OPTIONS
$custom_ss_name = (SSFA_CUSTOM_STYLESHEET === '' ? null : str_replace (array ('.css', '.scss', '.sass', '.less'), '', SSFA_CUSTOM_STYLESHEET));
$custom_ss_url = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS_URL.SSFA_CUSTOM_STYLESHEET);
$custom_ss_path = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS.SSFA_CUSTOM_STYLESHEET);
// JAVASCRIPT 
// header
if (SSFA_JAVASCRIPT === 'header'): add_action ('wp_enqueue_scripts', 'ssfa_scripts'); 
	function ssfa_scripts(){
	    wp_register_script( 'ssfa-jquery_alphanum', SSFA_JS_URL.'jquery.alphanum.js', array('jquery'), '1.0', false );		
		wp_enqueue_script ('ssfa-jquery_alphanum'); 
		wp_register_script ('ssfa-footable', SSFA_JS_URL.'footable.js', array ('jquery'), '1.0', false);
		wp_enqueue_script ('ssfa-footable'); 
		wp_register_script ('ssfa-alertify', SSFA_JS_URL.'alertify.js', array ('jquery'), '1.1.0', false);
		wp_enqueue_script ('ssfa-alertify'); 		
		wp_register_script ('ssfa-chosen', SSFA_JS_URL.'chosen/chosen.jquery.js', array ('jquery'), '1.1.0', false);
		wp_enqueue_script ('ssfa-chosen'); 		
	    wp_enqueue_script( 'ssfa_file_management', SSFA_JS_URL.'ssfa-file-management.js', array( 'jquery' ));	
	    wp_localize_script( 'ssfa_file_management', 'SSFA_FM_Ajax', array(
	        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
	        'nextNonce'     => wp_create_nonce( 'ssfa-fm-nonce' ))
	    ); 
	}
endif;
// footer
if (SSFA_JAVASCRIPT === 'footer'): 
	add_action ('init', 'ssfa_register_scripts');
	add_action ('wp_footer', 'ssfa_print_scripts');
	function ssfa_register_scripts(){
		wp_register_script ('ssfa-footable', SSFA_JS_URL.'footable.js', array ('jquery'), '1.0', true); 
		wp_register_script ('ssfa-chosen', SSFA_JS_URL.'chosen/chosen.jquery.js', array ('jquery'), '1.0', true); 		
		wp_register_script ('ssfa-alertify', SSFA_JS_URL.'alertify.js', array ('jquery'), '1.0', true); 				
		wp_register_script ('ssfa_file_management', SSFA_JS_URL.'ssfa-file-management.js', array ('jquery'), '1.0', true); 
	    wp_register_script ('ssfa-jquery_alphanum', SSFA_JS_URL.'jquery.alphanum.js', array ('jquery'), '1.0', true);		
	}
	function ssfa_print_scripts(){ 
		global $ssfa_add_scripts; 
		if (!$ssfa_add_scripts)
			return;
		wp_print_scripts ('ssfa-footable');
		wp_print_scripts ('ssfa-chosen');		
		wp_print_scripts ('ssfa-alertify');				
		wp_print_scripts ('ssfa-jquery_alphanum');		
		wp_print_scripts ('ssfa_file_management'); 
	}
	add_action ('wp_enqueue_scripts', 'ssfa_localize_script'); 
	function ssfa_localize_script(){ 
		wp_localize_script('ssfa_file_management', 'SSFA_FM_Ajax', array(
	        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
	        'nextNonce'     => wp_create_nonce( 'ssfa-fm-nonce' ))
	    );	
	}
endif;
// CSS
//header
if (SSFA_STYLESHEET === 'header'){
	add_action ('wp_enqueue_scripts', 'ssfa_styles');
	function ssfa_styles(){
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ('ssfa-chosen-style', SSFA_JS_URL.'chosen/chosen.css');
		wp_enqueue_style ('ssfa-chosen-style');		
		wp_register_style ('ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css');
		wp_enqueue_style ('ssfa-icons-style');		
		wp_register_style ('ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css'); 
		wp_enqueue_style ('ssfa-styles');
		if (SSFA_CUSTOM_STYLESHEET !== ''){
			if (file_exists ($custom_ss_path)){
				wp_register_style ($custom_ss_name, $custom_ss_url); 
				wp_enqueue_style ($custom_ss_name); }
		}
	}
}
// footer
if (SSFA_STYLESHEET === 'footer'){
	add_action ('init', 'ssfa_register_styles');
	add_action ('wp_footer', 'ssfa_print_styles');
	function ssfa_register_styles(){
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ('ssfa-chosen-style', SSFA_JS_URL.'chosen/chosen.css'); 				
		wp_register_style ('ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css'); 
		wp_register_style ('ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css'); 		
		if (SSFA_CUSTOM_STYLESHEET !== ''){
			if (file_exists ($custom_ss_path)){
				wp_register_style ($custom_ss_name, $custom_ss_url); }
		}
	}
	function ssfa_print_styles(){
		global $ssfa_add_styles, $custom_ss_name, $custom_ss_path;
		if (!$ssfa_add_styles)
			return;
		wp_enqueue_style ('ssfa-chosen-style');		
		wp_enqueue_style ('ssfa-styles');
		wp_enqueue_style ('ssfa-icons-style');
		if (SSFA_CUSTOM_STYLESHEET !== ''){
			if (file_exists ($custom_ss_path)){
				wp_enqueue_style ($custom_ss_name); }
		}
	}
}
// Admin
function dereg_styles(){
	if(is_admin()) 
		wp_deregister_style('jquery-ui-style-plugin');	
}
if ($_SERVER['QUERY_STRING'] == 'page=file-away') 
	add_action('admin_init', 'dereg_styles', 20);
if ( is_admin() ) {
	add_action( 'wp_ajax_ajax-ssfa-file-manager', 'ssfa_file_manager' );
	add_action( 'wp_ajax_nopriv_ajax-ssfa-file-manager', 'ssfa_file_manager' );
}
