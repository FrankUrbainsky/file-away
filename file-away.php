<?php
/*
   Plugin Name: File Away
   Plugin URI: http://wordpress.org/plugins/file-away/
   Description: Display file download links from your server directories or page attachments in stylized lists or sortable data tables.
   Version: 1.8
   Author: Thom Stark
   Author URI: http://imdb.me/thomstark
   License: GPLv3
*/
// DEFINITIONS
// Version
define('SSFA_VERSION', '1.8');
// Ground
define('SSFA_FILE', __FILE__);
define('SSFA_FOLDER', dirname(plugin_basename(SSFA_FILE)));  
$ssfa_install = false; if(get_bloginfo('url') !== get_bloginfo('wpurl')): 
$ssfa_install = ltrim(str_replace(rtrim(get_bloginfo('url'), '/'), '', rtrim(get_bloginfo('wpurl'), '/')), '/').'/'; endif;
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
define('SSFA_TEMPLATES_URL', SSFA_PLUGIN_URL . '/templates/'); 
define('SSFA_WP_UPLOADS_URL', $uploads['baseurl'] . '/');
define('SSFA_CUSTOM_CSS_UPLOADS_URL', SSFA_WP_UPLOADS_URL . 'fileaway-custom-css/');
define('SSFA_IMAGES_URL', SSFA_PLUGIN_URL . '/images/'); 
// Options
$option	= get_option ('fileaway_options');
define('SSFA_MANAGER_ROLES', $option['manager_role_access']);
define('SSFA_MANAGER_USERS', $option['manager_user_access']);
define('SSFA_MANAGER_PASSWORD', $option['managerpassword']);
define('SSFA_ROOT', $option['rootdirectory']);
define('SSFA_BASE1', $option['base1']);
define('SSFA_BASE2', $option['base2']);
define('SSFA_BASE3', $option['base3']);
define('SSFA_BASE4', $option['base4']);
define('SSFA_BASE5', $option['base5']);
define('SSFA_BS1NAME', $option['bs1name']);
define('SSFA_BS2NAME', $option['bs2name']);
define('SSFA_BS3NAME', $option['bs3name']);
define('SSFA_BS4NAME', $option['bs4name']);
define('SSFA_BS5NAME', $option['bs5name']);
define('SSFA_EXCLUSIONS', $option['exclusions']);
define('SSFA_DIR_EXCLUSIONS', $option['direxclusions']);
define('SSFA_NEWWINDOW', $option['newwindow']);
define('SSFA_MODALACCESS', $option['modalaccess']);
define('SSFA_TMCEROWS', $option['tmcerows']);
define('SSFA_STYLESHEET', $option['stylesheet']);
define('SSFA_JAVASCRIPT', $option['javascript']);
define('SSFA_DAYMONTH', $option['daymonth']);
define('SSFA_POSTIDCOLUMN', $option['postidcolumn']);
define('SSFA_CUSTOM_TABLE_CLASSES', $option['custom_table_classes']);
define('SSFA_CUSTOM_LIST_CLASSES', $option['custom_list_classes']);
define('SSFA_CUSTOM_COLOR_CLASSES', $option['custom_color_classes']);
define('SSFA_CUSTOM_ACCENT_CLASSES', $option['custom_accent_classes']);
define('SSFA_CSS_EDITOR', $option['css_editor']);
define('SSFA_CUSTOMCSS', $option['customcss']);
define('SSFA_CUSTOM_STYLESHEET', $option['custom_stylesheet']);
define('SSFA_PRESERVE_OPTIONS', $option['preserve_options']);
// INCLUDES
if (is_admin()):
	require_once(SSFA_ADMIN.'class.ssfa-options.php');
	require_once(SSFA_ADMIN.'ssfa-admin.php');
	if (SSFA_POSTIDCOLUMN === 'enabled') 
		require_once(SSFA_ADMIN.'ssfa-post-id-column.php'); 
endif;
require_once(SSFA_ADMIN.'ssfa-custom-css.php');
require_once(SSFA_INCLUDES.'styles-and-scripts.php');
require_once(SSFA_INCLUDES.'reference-functions.php');
require_once(SSFA_INCLUDES.'file-away.php');
require_once(SSFA_INCLUDES.'attach-away.php');
require_once(SSFA_INCLUDES.'file-management.php');
// ABSPATH
$ssfa_abspath = ($ssfa_install ? substr_replace(ABSPATH, '', strrpos(ABSPATH, $ssfa_install), strlen($ssfa_install)) : ABSPATH);
$ssfa_abspath = (SSFA_ROOT === 'siteurl' ? $ssfa_abspath : ABSPATH);
// UNINSTALL
if (SSFA_PRESERVE_OPTIONS === 'delete'):
	register_uninstall_hook (SSFA_FILE, 'ssfa_delete_plugin_options');
	function ssfa_delete_plugin_options(){ delete_option ('fileaway_options'); } 
endif;
?>