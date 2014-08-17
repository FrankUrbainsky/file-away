<?php
/*
   Plugin Name: File Away
   Plugin URI: http://wordpress.org/plugins/file-away/
   Description: Upload, manage, and display files from your server directories or page attachments in stylized lists or sortable data tables.
   Version: 2.3
   Author: Thom Stark
   Author URI: http://imdb.me/thomstark
   License: GPLv3
*/
// DEFINITIONS
// Version
define('SSFA_VERSION', '2.3');
// Ground
define('SSFA_FILE', __FILE__);
define('SSFA_FOLDER', dirname(plugin_basename(SSFA_FILE)));  
// Paths
$uploads = wp_upload_dir();
define('SSFA_PLUGIN', dirname(SSFA_FILE));
define('SSFA_ADMIN', SSFA_PLUGIN . '/admin/');
define('SSFA_ADMIN_JS', SSFA_ADMIN . 'js/');
define('SSFA_ADMIN_CSS', SSFA_ADMIN . 'css/');
define('SSFA_ADMIN_RESOURCES', SSFA_ADMIN . 'resources/');
define('SSFA_INCLUDES', SSFA_PLUGIN . '/includes/');
define('SSFA_JS', SSFA_PLUGIN . '/js/');
define('SSFA_CSS', SSFA_PLUGIN . '/css/');
define('SSFA_TEMPLATES', SSFA_PLUGIN . '/templates/');
define('SSFA_WP_UPLOADS', $uploads['basedir'] . '/');
define('SSFA_CUSTOM_CSS_UPLOADS', SSFA_WP_UPLOADS . '/fileaway-custom-css/');
define('SSFA_IMAGES', SSFA_PLUGIN . '/images/');
// URLs
define('SSFA_OPTIONS_URL', admin_url('?page=file-away'));
define('SSFA_PLUGIN_URL', plugins_url('', SSFA_FILE)); 
define('SSFA_ADMIN_URL', SSFA_PLUGIN_URL . '/admin/');
define('SSFA_ADMIN_JS_URL', SSFA_ADMIN_URL . 'js/'); 
define('SSFA_ADMIN_CSS_URL', SSFA_ADMIN_URL . 'css/'); 
define('SSFA_ADMIN_RESOURCES_URL', SSFA_ADMIN_URL . 'resources/'); 
define('SSFA_INCLUDES_URL', SSFA_PLUGIN_URL . '/includes/'); 
define('SSFA_JS_URL', SSFA_PLUGIN_URL . '/js/'); 
define('SSFA_CSS_URL', SSFA_PLUGIN_URL . '/css/'); 
define('SSFA_SWF_URL', SSFA_PLUGIN_URL . '/swf/'); 
define('SSFA_TEMPLATES_URL', SSFA_PLUGIN_URL . '/templates/'); 
define('SSFA_WP_UPLOADS_URL', $uploads['baseurl'] . '/');
define('SSFA_CUSTOM_CSS_UPLOADS_URL', SSFA_WP_UPLOADS_URL . 'fileaway-custom-css/');
define('SSFA_IMAGES_URL', SSFA_PLUGIN_URL . '/images/'); 
// INITIALIZE
if (is_admin()):
	require_once(SSFA_ADMIN.'class.ssfa-options.php');
endif;
// Options
$ssfa_option = get_option('fileaway_options');
define('SSFA_MANAGER_ROLES', $ssfa_option['manager_role_access']);
define('SSFA_MANAGER_USERS', $ssfa_option['manager_user_access']);
define('SSFA_MANAGER_PASSWORD', $ssfa_option['managerpassword']);
define('SSFA_ROOT', $ssfa_option['rootdirectory']);
define('SSFA_BASE1', $ssfa_option['base1']);
define('SSFA_BASE2', $ssfa_option['base2']);
define('SSFA_BASE3', $ssfa_option['base3']);
define('SSFA_BASE4', $ssfa_option['base4']);
define('SSFA_BASE5', $ssfa_option['base5']);
define('SSFA_BS1NAME', $ssfa_option['bs1name']);
define('SSFA_BS2NAME', $ssfa_option['bs2name']);
define('SSFA_BS3NAME', $ssfa_option['bs3name']);
define('SSFA_BS4NAME', $ssfa_option['bs4name']);
define('SSFA_BS5NAME', $ssfa_option['bs5name']);
define('SSFA_EXCLUSIONS', $ssfa_option['exclusions']);
define('SSFA_DIR_EXCLUSIONS', $ssfa_option['direxclusions']);
define('SSFA_NEWWINDOW', $ssfa_option['newwindow']);
define('SSFA_MODALACCESS', $ssfa_option['modalaccess']);
define('SSFA_TMCEROWS', $ssfa_option['tmcerows']);
define('SSFA_ADMINSTYLE', $ssfa_option['adminstyle']); 
define('SSFA_STYLESHEET', $ssfa_option['stylesheet']);
define('SSFA_JAVASCRIPT', $ssfa_option['javascript']);
define('SSFA_DAYMONTH', $ssfa_option['daymonth']);
define('SSFA_POSTIDCOLUMN', $ssfa_option['postidcolumn']);
define('SSFA_CUSTOM_TABLE_CLASSES', $ssfa_option['custom_table_classes']);
define('SSFA_CUSTOM_LIST_CLASSES', $ssfa_option['custom_list_classes']);
define('SSFA_CUSTOM_COLOR_CLASSES', $ssfa_option['custom_color_classes']);
define('SSFA_CUSTOM_ACCENT_CLASSES', $ssfa_option['custom_accent_classes']);
define('SSFA_CSS_EDITOR', $ssfa_option['css_editor']);
define('SSFA_CUSTOMCSS', $ssfa_option['customcss']);
define('SSFA_CUSTOM_STYLESHEET', $ssfa_option['custom_stylesheet']);
define('SSFA_PRESERVE_OPTIONS', $ssfa_option['preserve_options']);
// INCLUDES
require_once(SSFA_ADMIN.'ssfa-custom-css.php');
require_once(SSFA_ADMIN.'ssfa-cleanup.php');
require_once(SSFA_INCLUDES.'styles-and-scripts.php');
require_once(SSFA_INCLUDES.'reference-functions.php');
require_once(SSFA_INCLUDES.'global-definitions.php');
require_once(SSFA_INCLUDES.'file-away.php');
require_once(SSFA_INCLUDES.'attach-away.php');
require_once(SSFA_INCLUDES.'file-up.php');
require_once(SSFA_INCLUDES.'file-management.php');
require_once(SSFA_INCLUDES.'fileaplay.php');
require_once(SSFA_INCLUDES.'fileaframe.php');
if(is_admin()){
	require_once(SSFA_ADMIN.'ssfa-admin.php');
	if(SSFA_POSTIDCOLUMN === 'enabled') 
		require_once(SSFA_ADMIN.'ssfa-post-id-column.php'); 	
}
// INITIALIZATION HOOK
add_action('admin_init', 'ssfa_initialize');
function ssfa_initialize(){ 
	$GLOBALS['ssfa_option']['version'] = isset($GLOBALS['ssfa_option']['version']) ? $GLOBALS['ssfa_option']['version'] : 1;
	$version = $GLOBALS['ssfa_option']['version'];
	if($version == SSFA_VERSION) return;
	$themedir = get_template_directory(); 
	$template = 'file-away-iframe-template.php';
	if(!$version || (int)$version <= 2.0): copy(SSFA_TEMPLATES.$template, $themedir.'/'.$template);
	else: if(!file_exists($themedir.'/'.$template)): copy(SSFA_TEMPLATES.$template, $themedir.'/'.$template); endif;
	endif;
	if(!is_dir(SSFA_CUSTOM_CSS_UPLOADS)) mkdir(SSFA_CUSTOM_CSS_UPLOADS); 
	update_fileaway_option('version', SSFA_VERSION);
}
// UNINSTALL
if (SSFA_PRESERVE_OPTIONS === 'delete'):
	register_uninstall_hook (SSFA_FILE, 'ssfa_delete_plugin_options');
	function ssfa_delete_plugin_options(){ delete_option ('fileaway_options'); } 
endif;
?>