<?php
echo "<div id='ssfa-help-rootdirectory' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Set Root Directory</h4>
		If your WordPress URL and Site URL are one and the same, you can disregard this setting. If your WordPress installation is in a subdirectory of your domain root directory, this option is for you. Choose whether your absolute path is relative to the WordPress Installation directory (default), or the domain root directory.<br><br>
		Note: if you choose the latter, be sure to refresh the Config page after changes finish saving, so the abspath in your Base Directory options will be updated to reflect your selection.
		</div></div>";
echo "<div id='ssfa-help-exclusions' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Permanent Exclusions</h4>
		A comma-separated list of filenames and/or file extensions you wish to permanently exclude from all lists and tables. Be sure to include the dot ( . ) if it's a file extension. ( Not case sensitive. ) Example: 
		<br />
		<br />
		<code>My File Name, .bat, .php, My Other File Name</code>
		</div></div>";
echo "<div id='ssfa-help-direxclusions' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Exclude Directories</h4>
		A comma-separated list of directory names you wish to permanently exclude from all Directory Tree tables and Recursive tables/lists, and from Manager Mode Bulk Action Destination generators. Do not include the forward slashes (\"/\") Example: 
		<br />
		<br />
		<code>My Private Files, Weird_Server_Directory_Name, etc.</code>
		</div></div>";
echo "<div id='ssfa-help-newwindow' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>New Window</h4>
		By default, all file links in lists and tables are download links. If you want certain file types to open in a new window instead (e.g., .pdf or image files), add a comma-separated list of file extensions here for the file types you want to open in a new window. Be sure to include the dot ( . ). ( Not case sensitive. ) Example: 
		<br />
		<br />
		<code>.pdf, .jpg, .png, .gif, .mp3, .mp4</code>
		<br />
		<br />
		Also be aware that most file types will not open in a browser window.
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
echo "<div id='ssfa-help-adminstyle' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Admin Style</h4>
		Choose between classic (animated) or minimal admin style. 
		<br>
		<br>			
		Default: Classic
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
		<code>" . SSFA_CUSTOM_CSS_UPLOADS_URL . "</code>
		<br>
		<br>
		Then just enter the filename of the stylesheet into the custom stylesheet field.
		<br>
		<br>
		Keeping your custom stylesheet in the wp-content/uploads/fileaway-custom-css directory will ensure that your styles are never overwritten on plugin updates.
	</div></div>";
echo "<div id='ssfa-help-preserve_options' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Preserve on Uninstall</h4>
		By default, your settings and custom CSS will be lost upon uninstallation of the plugin. Check this box to preserve your settings (i.e., if you plan to reinstall). 
		<br>
		<br>
		Default: Preserve
	</div></div>";											
echo "<div id='ssfa-help-manager_role_access' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Manager Mode: Permanent User Role Access</h4>
		Specify which user roles will have access to Manager Mode on File Away tables. Manager mode allows users to rename and delete individual files, and to copy, move, and delete files in bulk. Only those with the roles specified here will have access to the Manager Mode settings on the shortcode generator modal (if they already have access to the modal) and actual access to Manager Mode on the front-end page. Site administrators will have access to manager mode regardless of the specifications set here. The settings here are permanent. Additional roles can be granted access on a per-shortcode basis (see the help link next to \"Override Password\" below).  
		<br>
		<br>
		Default: Administrator
	</div></div>";											
echo "<div id='ssfa-help-manager_user_access' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Manager Mode: Permanent User Access</h4>
		Specify which specific users will have access to Manager Mode on File Away tables. This setting should be used in case a specific user merits access to Manager Mode who does not have one of the user roles specified in the above setting. Manager mode allows users to rename and delete individual files, and to copy, move, and delete files in bulk. Individual users specified here will have access to the Manager Mode settings on the shortcode generator modal (if they already have access to the modal) and actual access to Manager Mode on the front-end page. The settings here are permanent. Additional users can be granted access on a per-shortcode basis (see the help link next to \"Override Password\" below).  
		<br>
		<br>
		Default: None
	</div></div>";											
echo "<div id='ssfa-help-managerpassword' class='ssfa-help-backdrop'>
		<div class='ssfa-help-content'><div class='ssfa-help-close ssfa-help-iconclose2'></div>
		<h4>Manager Mode: Override Password</h4>
		Set an override password here, then use the password in your [fileaway] shortcode if you wish to grant front-end Manager Mode access to additional roles or individual users (by identifying their user_id) on a per-shortcode basis. Your File Away shortcode would need to look something like: 
		<br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" role_override=\"author,subscriber\"]</code> or
		<br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" user_override=\"125,214\"]</code>
		<br>
		<br>
		In place of using actual roles or user ids in the override shortcode attributes, you can elect to use <code>fa-userrole</code> or <code>fa-userid</code> like this:
		<br><br>
		<code>[fileaway manager=\"on\" password=\"yourpassword\" role_override=\"fa-userrole\"]</code> or
		<br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" user_override=\"fa-userid\"]</code><br><br>
		Be aware that doing this will effectively grant Manager Mode access to all logged in users. Thus, the dynamic role and user id codes should only be used on File Away tables where the directory paths are dynamic. This will grant users access to rename, copy, move, and delete files within the confines of their of own subdirectories. 
	</div></div>";											