<?php
if (is_admin()
	and function_exists('add_action')
	and function_exists('add_filter')
	and function_exists('get_taxonomies')
	and function_exists('get_post_types')
	and function_exists('version_compare')){
		add_action('admin_init' , 'ssaa_add_custom_columns');
		add_action('admin_head' , 'ssaa_add_custom_columns_css'); 
	}
function ssaa_add_custom_columns (){
	global $wp_version;
	$is_wp_v3_1 = version_compare($wp_version , '3.0.999' , '>');
	add_filter('manage_media_columns' ,       'ssaa_custom_column_add');
	add_action('manage_media_custom_column' , 'ssaa_custom_column_value' , 10 , 2);
	add_filter('manage_link-manager_columns' , 'ssaa_custom_column_add');
	add_action('manage_link_custom_column' , 'column_value' , 10 , 2);
	add_action('manage_edit-link-categories_columns' , 'ssaa_custom_column_add');
	add_filter('manage_link_categories_custom_column' , 'column_return_value' , 10 , 3);
	foreach(get_taxonomies() as $taxonomy){
		add_action("manage_edit-${taxonomy}_columns" ,  'ssaa_custom_column_add');
		add_filter("manage_${taxonomy}_custom_column" , 'ssaa_custom_column_return_value' , 10 , 3);
		if ($is_wp_v3_1){	add_filter("manage_edit-${taxonomy}_sortable_columns" , 'ssaa_custom_column_add'); }
	}
	foreach(get_post_types() as $post_type){
		add_action("manage_edit-${post_type}_columns" ,        'ssaa_custom_column_add');
		add_filter("manage_${post_type}_posts_custom_column" , 'ssaa_custom_column_value' , 10 , 3);
		if ($is_wp_v3_1){	add_filter("manage_edit-${post_type}_sortable_columns" , 'ssaa_custom_column_add'); }
	}
	add_action('manage_users_columns' ,       'ssaa_custom_column_add');
	add_filter('manage_users_custom_column' , 'ssaa_custom_column_return_value' , 10 , 3);
	if ($is_wp_v3_1){	add_filter("manage_users_sortable_columns" , 'ssaa_custom_column_add'); }
	add_action('manage_edit-comments_columns' ,  'ssaa_custom_column_add');
	add_action('manage_comments_custom_column' , 'ssaa_custom_column_value' , 10 , 2);
	if ($is_wp_v3_1){	add_filter("manage_edit-comments_sortable_columns" , 'ssaa_custom_column_add'); }
}
function ssaa_custom_column_add ($columns){
	$column_id = array('ssaa_id' => __('ID'));
	$columns = array_slice($columns, 0, 1, true) + $column_id + array_slice($columns, 1, NULL, true);
	return $columns; 
}
function ssaa_custom_column_value ($column_name , $id){ 
	if ($column_name === 'ssaa_id'){	echo $id; } 
}
function ssaa_custom_column_return_value ($value , $column_name , $id){ 
	if ($column_name === 'ssaa_id'){ $value .= $id; }
	return $value; 
}
function ssaa_add_custom_columns_css(){ 
	echo PHP_EOL . '<style type="text/css"> table.widefat th.column-ssaa_id { width: 50px; } </style>' . PHP_EOL; 
}