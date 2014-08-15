<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// THE FILE AWAY IFRAME SHORTCODE
add_shortcode('fileaframe', 'ssfa_fileaframe');
function ssfa_fileaframe($atts){
	extract(shortcode_atts(array(
		'source' => '', 'width' => '100%', 'height' => '', 
		'scroll' => 'no', 'frame' => '0', 'mwidth' => '0px', 
		'mheight' => '0px', 'seamless' => 'seamless', 'name' => ''
	), $atts));
	$seamless = ($seamless !== 'seamless' ? null : 'seamless');
	if(!$name)
	return 'Please assign your fileaframe shortcode a unique name, using [fileaframe name="myuniquename"], and assign the same name to its corresponding [fileaway] shortcode, using [fileaway name="myuniquename"]';
	if($source && $name)
	return "<div id='$name' class='ssfa-meta-container' style='width:100%; height:100%;'><iframe name='$name' id='$name' src='$source' width=$width height=$height scrolling=$scroll frameborder=$frame marginwidth=$mwidth marginheight=$mheight $seamless></iframe></div>";
}