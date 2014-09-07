<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(class_exists('fileaway_attributes') && !class_exists('fileaframe'))
{
	class fileaframe extends fileaway_attributes
	{
		public function __construct()
		{
			parent::__construct();
			add_shortcode('fileaframe', array($this, 'sc'));
		}
		public function sc($atts)
		{
			$atts = $this->correct(wp_parse_args($atts, $this->fileaframe), $this->shortcodes['fileaframe']);
			extract($atts);
			$fileaframe = '[fileaframe name="myuniquename"]';
			$fileaway = '[fileaway]';
			$fileaway2 = '[fileaway name="myuniquename"]';
			if(!$name) return 
				sprintf(__('Please assign your fileaframe shortcode a unique name, using %s, and assign the same name to its corresponding %s shortcode, using %s', 'file-away'), 
				$fileaframe, $fileaway, $fileaway2);
			if(!$source) return _x('Please specify a source page.', 'File-a-Frame No Source Error Message', 'file-away');
			if($source && $name) return 
				"<div id='$name' class='ssfa-meta-container' style='width:100%; height:100%;'>".
					"<iframe name='$name' id='$name' src='$source' width=$width height=$height ".
					"scrolling=$scroll frameborder='0' marginwidth=$mwidth marginheight=$mheight seamless>".
					"</iframe>".
				"</div>";
		}	
	}
}