<?php

echo "<div id='ssfa-help-exclusions' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Permanent Exclusions</h4>
		A comma-separated list of filenames and/or file extensions you wish to permanently exclude from all lists and tables. Be sure to include the dot ( . ) if it's a file extension. ( Not case sensitive. ) Example: 
		<br />
		<br />
		<code>My File Name, .bat, .php, My Other File Name</code>
		</div></div>";

echo "<div id='ssfa-help-modalaccess' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Modal Access</h4>
		By user capability, choose who has access to the shortcode generator modal, or disable it completely. 
		<br>
		<br>
		Default: edit_posts
	</div></div>";

echo "<div id='ssfa-help-tmcerows' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Button Position</h4>
		Choose the position of the shortcode button on the TinyMCE panel. 
		<br>
		<br>			
		Default: First Row
	</div></div>";
	
echo "<div id='ssfa-help-stylesheet' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Stylesheet Placement</h4>
		Choose whether the stylesheet is enqueued in the header on all pages and posts, or in the footer only on pages and posts where the [fileaway] or [attachaway] shortcodes are used. For better performance, enqueuing to the footer is highly recommended, but if you are experiencing problems with the appearance of your displays on the page, try enqueuing to the header. 
		<br>
		<br>
		Default: Footer
	</div></div>";
	
echo "<div id='ssfa-help-javascript' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Javascript Placement</h4>
		Choose whether the javascript is enqueued in the header on all pages and posts, or in the footer only on pages and posts where the [fileaway] or [attachaway] shortcodes are used. For better performance, enqueuing to the footer is highly recommended, but if you are experiencing problems with the functionality of your Sortable Data Tables, try enqueuing to the header. 
		<br>
		<br>
		Default: Footer
	</div></div>";
	
echo "<div id='ssfa-help-daymonth' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Date Display Format</h4>
		Choose whether the Date Modified column in sortable tables displays the month or the date first. 
		<br>
		<br>
		Default: MM/DD/YYYY
	</div></div>";
	
echo "<div id='ssfa-help-postidcolumn' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Post ID Column</h4>
		Enables/disables the custom Post ID column added to 'All Posts' and 'All Pages.' When enabled, provides easy reference when displaying attachments from a post or page other than your current one. 
		<br>
		<br>
		Default: Enabled
	</div></div>";
	
echo "<div id='ssfa-help-custom_list_classes' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Custom List Classes</h4>
		Add a comma-separated list of your custom list classes. It needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this:
		<br>
		<br>
		<code>classname1|Display Name 1, classname2|Display Name 2, classname3|Display Name 3</code>
	</div></div>";
	
echo "<div id='ssfa-help-custom_table_classes' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Custom Table Classes</h4>
		Add a comma-separated list of your custom table classes. It needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this:
		<br>
		<br>
		<code>classname1|Display Name 1, classname2|Display Name 2, classname3|Display Name 3</code>
		<br>
		<br>
		In the stylesheet, all of your table class names must be prefixed by <code>ssfa-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.ssfa-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator.
	</div></div>";
	
echo "<div id='ssfa-help-custom_color_classes' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Custom Color Classes</h4>
		Add a comma-separated list of your custom primary color classes. The primary color class affects the color of the file name (not hovered), the icon color, and the header. Your list needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this (with your own color names of course):
		<br>
		<br>
		<code>turquoise|Turquoise, thistle|Thistle, salamander-orange|Salamander Orange</code>
		<br>
		<br>
		In the stylesheet, all of your primary color class names must be prefixed by <code>ssfa-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.ssfa-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator.
	</div></div>";
	
echo "<div id='ssfa-help-custom_accent_classes' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Custom Accent Classes</h4>
		Add a comma-separated list of your custom accent color classes. The accent color class affects the color of the file name (on hover), the icon background color, and a few other little things. Your list needs to include the class name (minus the <code>accent-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this (with your own color names of course):
		<br>
		<br>
		<code>turquoise|Turquoise, thistle|Thistle, salamander-orange|Salamander Orange</code>
		<br>
		<br>
		In the stylesheet, all of your accent color class names must be prefixed by <code>accent-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.accent-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator.
	</div></div>";
	
echo "<div id='ssfa-help-custom_stylesheet' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Custom Stylesheet</h4>
		As an alternative to using the CSS editor here, you can create your own CSS file and drop it into the File Away Custom CSS directory here: 
		<br>
		<br>
		<code>" . SSFA_PLUGIN_URL . "/custom-css/</code>
		<br>
		<br>
		Then just enter the filename of the stylesheet into the custom stylesheet field.
		<br>
		<br>
		When updating the plugin, anything in the /custom-css/ directory should be automatically backed up and restored, but it is always a good idea to backup your custom stylesheet manually before every update.
	</div></div>";
	
echo "<div id='ssfa-help-preserve_options' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Preserve on Uninstall</h4>
		By default, your settings and custom CSS will be lost upon uninstallation of the plugin. Check this box to preserve your settings (i.e., if you plan to reinstall). 
		<br>
		<br>
		Note: this will preserve custom CSS added to the CSS editor, but will not preserve custom stylesheet docs uploaded to the custom-css directory. If you are using a custom stylesheet, you should backup that directory manually if you plan to reinstall the plugin for continued use.
		<br>
		<br>
		Default: Preserve
	</div></div>";											
	
	
	
	
?>