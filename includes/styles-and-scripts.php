<?php

// CREATE CUSTOM CSS URL
function ssfa_custom_css_dir_create() {
    if (!is_dir(SSFA_CUSTOM_CSS_UPLOADS)) mkdir(SSFA_CUSTOM_CSS_UPLOADS); }
add_action( 'admin_init', 'ssfa_custom_css_dir_create', 20 );	

// STYLES AND SCRIPTS OPTIONS
$custom_ss_name = (SSFA_CUSTOM_STYLESHEET === '' ? null : str_replace ( array ( '.css', '.scss', '.sass', '.less' ), '', SSFA_CUSTOM_STYLESHEET ) );
$custom_ss_url = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS_URL.SSFA_CUSTOM_STYLESHEET );
$custom_ss_path = (SSFA_CUSTOM_STYLESHEET === '' ? null : SSFA_CUSTOM_CSS_UPLOADS.SSFA_CUSTOM_STYLESHEET );


// JAVASCRIPT 
// header
if ( SSFA_JAVASCRIPT === 'header' ) { 
	function ssfa_scripts() {
		wp_register_script ( 'footable', SSFA_JS_URL.'footable.js', array ( 'jquery' ), '1.0', false );
		wp_enqueue_script ( 'footable' ); }
	add_action ( 'wp_enqueue_scripts', 'ssfa_scripts' ); }
// footer
if ( SSFA_JAVASCRIPT === 'footer' ) { 
	function ssfa_register_scripts() {
		wp_register_script ( 'footable', SSFA_JS_URL.'footable.js', array ( 'jquery' ), '1.0', true ); }
	function ssfa_print_scripts() { 
		global $ssfa_add_scripts; 
		if ( !$ssfa_add_scripts )
			return;
		wp_print_scripts ( 'footable' ); }
	add_action ( 'init', 'ssfa_register_scripts' );
	add_action ( 'wp_footer', 'ssfa_print_scripts' );
}

// CSS
//header
if ( SSFA_STYLESHEET === 'header' ) {
	function ssfa_styles() {
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ( 'ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css' ); 
		wp_enqueue_style ( 'ssfa-styles' );
		wp_register_style ( 'ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css' );
		wp_enqueue_style ( 'ssfa-icons-style' );		
		if ( SSFA_CUSTOM_STYLESHEET !== '' ) {
			if ( file_exists ( $custom_ss_path ) ) {
				wp_register_style ( $custom_ss_name, $custom_ss_url ); 
				wp_enqueue_style ( $custom_ss_name ); }
		}
	}
	add_action ( 'wp_enqueue_scripts', 'ssfa_styles' );
}
// footer
if ( SSFA_STYLESHEET === 'footer' ) {
	function ssfa_register_styles() {
		global $custom_ss_name, $custom_ss_url, $custom_ss_path;
		wp_register_style ( 'ssfa-styles', SSFA_CSS_URL.'ssfa-styles.css' ); 
		wp_register_style ( 'ssfa-icons-style', SSFA_CSS_URL.'ssfa-icons-style.css' ); 		
		if ( SSFA_CUSTOM_STYLESHEET !== '' ) {
			if ( file_exists ( $custom_ss_path ) ) {
				wp_register_style ( $custom_ss_name, $custom_ss_url ); }
		}
	}
	function ssfa_print_styles() {
		global $ssfa_add_styles, $custom_ss_name, $custom_ss_path;
		if ( !$ssfa_add_styles )
			return;
		wp_enqueue_style ( 'ssfa-styles' );
		wp_enqueue_style ( 'ssfa-icons-style' );
		if ( SSFA_CUSTOM_STYLESHEET !== '' ) {
			if ( file_exists ( $custom_ss_path ) ) {
				wp_enqueue_style ( $custom_ss_name ); }
		}
	}
	add_action ( 'init', 'ssfa_register_styles' );
	add_action ( 'wp_footer', 'ssfa_print_styles' );
}

function dereg_styles() {
	wp_deregister_style('jquery-ui-style-plugin');	
}
if ( $_SERVER['QUERY_STRING'] == 'page=file-away' ) 
add_action( 'admin_init', 'dereg_styles', 20 );
	

