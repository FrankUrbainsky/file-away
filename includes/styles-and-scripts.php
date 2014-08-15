<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// STYLES AND SCRIPTS OPTIONS
$custom_ss_name = (SSFA_CUSTOM_STYLESHEET === '' ? null : str_replace (array ('.css', '.scss', '.sass', '.less'), '', SSFA_CUSTOM_STYLESHEET));
$custom_ss_url = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS_URL.SSFA_CUSTOM_STYLESHEET);
$custom_ss_path = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS.SSFA_CUSTOM_STYLESHEET);
// JAVASCRIPT 
// header
if (SSFA_JAVASCRIPT === 'header'): add_action ('wp_enqueue_scripts', 'ssfa_scripts'); add_action('wp_head', 'ssfa_filetype_icons'); endif;
function ssfa_scripts(){
    wp_register_script( 'ssfa-jquery_alphanum', SSFA_JS_URL.'jquery.alphanum.js', array('jquery'), '1.0', false );		
	wp_enqueue_script ('ssfa-jquery_alphanum'); 
	wp_register_script ('ssfa-footable', SSFA_JS_URL.'footable.js', array('jquery'), '1.0', false);
	wp_enqueue_script ('ssfa-footable'); 
	wp_register_script ('ssfa-filertify', SSFA_JS_URL.'filertify.js', array('jquery'), '1.1.0', false);
	wp_enqueue_script ('ssfa-filertify'); 		
	wp_register_script ('ssfa-chosen', SSFA_JS_URL.'chosen/chosen.jquery.js', array('jquery'), '1.1.0', false);
	wp_enqueue_script ('ssfa-chosen'); 		
	wp_register_script('ssfa-soundmanager2', SSFA_JS_URL.'soundmanager2-nodebug-jsmin.js', array('jquery'), '2.9', false);
	wp_enqueue_script('ssfa-soundmanager2');
}
add_action('wp_enqueue_scripts', 'ssfa_file_management_script');
function ssfa_file_management_script(){
    wp_enqueue_script( 'ssfa_file_management', SSFA_JS_URL.'ssfa-file-management.js', array( 'jquery' ));	
    wp_localize_script( 'ssfa_file_management', 'SSFA_FM_Ajax', array(
        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
        'nextNonce'     => wp_create_nonce( 'ssfa-fm-nonce' ))
    );
}
// footer
if (SSFA_JAVASCRIPT === 'footer'): 
	add_action('init', 'ssfa_register_scripts');
	add_action('wp_footer', 'ssfa_print_scripts');
	add_action('wp_footer', 'ssfa_filetype_icons');
endif;
function ssfa_register_scripts(){
	wp_register_script ('ssfa-footable', SSFA_JS_URL.'footable.js', array ('jquery'), '1.0', true); 
	wp_register_script ('ssfa-chosen', SSFA_JS_URL.'chosen/chosen.jquery.js', array ('jquery'), '1.0', true); 		
	wp_register_script ('ssfa-filertify', SSFA_JS_URL.'filertify.js', array ('jquery'), '1.0', true); 				
    wp_register_script ('ssfa-jquery_alphanum', SSFA_JS_URL.'jquery.alphanum.js', array ('jquery'), '1.0', true);		
	wp_register_script('ssfa-soundmanager2', SSFA_JS_URL.'soundmanager2-nodebug-jsmin.js', array('jquery'), '2.9', true);
}
function ssfa_print_scripts(){ 
	global $ssfa_add_scripts; 
	if(!$ssfa_add_scripts)
		return;
	wp_print_scripts ('ssfa-footable');
	wp_print_scripts ('ssfa-chosen');		
	wp_print_scripts ('ssfa-filertify');				
	wp_print_scripts ('ssfa-jquery_alphanum');		
	wp_print_scripts ('ssfa-soundmanager2');
}
function ssfa_filetype_icons(){
	if(SSFA_JAVASCRIPT === 'header' || 
	(SSFA_JAVASCRIPT === 'footer' && $GLOBALS['ssfa_add_scripts'])):
?>
<script type='text/javascript'>
var ssfa_filetype_groups = {
	'adobe'		: ['<?php echo implode("', '",$GLOBALS['ssfa_adobe']) ?>'],
	'image'		: ['<?php echo implode("', '",$GLOBALS['ssfa_image']) ?>'],
	'audio'		: ['<?php echo implode("', '",$GLOBALS['ssfa_audio']) ?>'],
	'video'		: ['<?php echo implode("', '",$GLOBALS['ssfa_video']) ?>'],
	'msdoc'		: ['<?php echo implode("', '",$GLOBALS['ssfa_msdoc']) ?>'],
	'msexcel'	: ['<?php echo implode("', '",$GLOBALS['ssfa_msexcel']) ?>'],
	'powerpoint'	: ['<?php echo implode("', '",$GLOBALS['ssfa_powerpoint']) ?>'],
	'openoffice'	: ['<?php echo implode("', '",$GLOBALS['ssfa_openoffice']) ?>'],
	'text'		: ['<?php echo implode("', '",$GLOBALS['ssfa_text']) ?>'],
	'compression'	: ['<?php echo implode("', '",$GLOBALS['ssfa_compression']) ?>'],
	'application'	: ['<?php echo implode("', '",$GLOBALS['ssfa_application']) ?>'],
	'script'	: ['<?php echo implode("', '",$GLOBALS['ssfa_script']) ?>'],
	'css'		: ['<?php echo implode("', '",$GLOBALS['ssfa_css']) ?>']
};
var ssfa_filetype_icons = {
	'adobe'		: '&#x21;',
	'image'		: '&#x31;',
	'audio'		: '&#x43;',
	'video'		: '&#x57;',
	'msdoc'		: '&#x23;',
	'msexcel'	: '&#x24;',
	'powerpoint'	: '&#x26;',
	'openoffice'	: '&#x22;',
	'text'		: '&#x2e;',
	'compression'	: '&#x27;',
	'application'	: '&#x54;',
	'script'	: '&#x25;',
	'css'		: '&#x28;',
	'unknown'	: '&#x29;'		
}
</script>
<?php endif;
}
// CSS
//header
if (SSFA_STYLESHEET === 'header'){
	add_action ('wp_enqueue_scripts', 'ssfa_styles');
}
	function ssfa_styles(){
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ('ssfa-chosen-style', SSFA_JS_URL.'chosen/chosen.css');
		wp_enqueue_style ('ssfa-chosen-style');		
		wp_register_style ('ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css');
		wp_enqueue_style ('ssfa-icons-style');		
		wp_register_style ('ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css'); 
		wp_enqueue_style ('ssfa-styles');
//		wp_register_style('ssfa-flashblock', SSFA_CSS_URL.'flashblock.css');
//		wp_enqueue_style('ssfa-flashblock');
		if (SSFA_CUSTOM_STYLESHEET !== ''){
			if (file_exists ($custom_ss_path)){
				wp_register_style ($custom_ss_name, $custom_ss_url); 
				wp_enqueue_style ($custom_ss_name); }
		}
	}
// footer
if (SSFA_STYLESHEET === 'footer'){
	add_action ('init', 'ssfa_register_styles');
	add_action ('wp_footer', 'ssfa_print_styles');
}
	function ssfa_register_styles(){
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ('ssfa-chosen-style', SSFA_JS_URL.'chosen/chosen.css'); 				
		wp_register_style ('ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css'); 
		wp_register_style ('ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css');
//		wp_register_style ('ssfa-flashblock', SSFA_CSS_URL.'flashblock.css');
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
		wp_enqueue_style ('ssfa-uploader');
//		wp_enqueue_style ('ssfa-flashblock');
		if (SSFA_CUSTOM_STYLESHEET !== ''){
			if (file_exists ($custom_ss_path)){
				wp_enqueue_style ($custom_ss_name); }
		}
	}
// Admin
function dereg_styles(){
	if(is_admin()) 
		wp_deregister_style('jquery-ui-style-plugin');	
}
if($_SERVER['QUERY_STRING'] == 'page=file-away') 
	add_action('admin_init', 'dereg_styles', 20);
if(is_admin()){
	add_action('wp_ajax_ajax-ssfa-file-manager', 'ssfa_file_manager');
	add_action('wp_ajax_nopriv_ajax-ssfa-file-manager', 'ssfa_file_manager');
}