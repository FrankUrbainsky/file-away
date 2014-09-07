<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$output .= 
	'<div class="tutorials-select-wrap">'.
		'<div class="select-tutorials-label"><label for="fileaway-tutorials">Select Tutorial</label></div>'.
		'<div class="fileaway-inline" id="fileaway-container-tutorials">'.
			'<select id="fileaway-tutorials" class="select chozed-select" data-placeholder="&nbsp;">'.
				'<option value=""></option>'.
				'<option value="directory-security">Directory Security</option>'.
				'<option value="attachment-management">Attachment Management</option>'.
				'<option value="custom-css">Custom CSS</option>'.
				'<option value="fileaway-attributes">File Away Attributes</option>'.
				'<option value="attachaway-attributes">Attach Away Attributes</option>'.
				'<option value="fileup-attributes">File-Up Attributes</option>'.
				'<option value="fileaframe-attributes">File-a-Frame Attributes</option>'.
				'<option value="manager-mode">Manager Mode</option>'.
				'<option value="dynamic-paths">Dynamic Paths</option>'.
				'<option value="formidable-pro">Formidable Pro</option>'.
				'<option value="timezone-settings">Timezone Settings</option>'.
			'</select>'.
		'</div>'.
	'</div>';
// Directory Security
$output .= 
	'<div id="fileaway-tutorials-directory-security" class="fileaway-tutorials" style="display:none;">'.
		'To prevent users from directly accessing your directory listings, you have two options, and a combination of both is preferable. <br /><br />'.
		'1. The simplest way to prevent direct directory listing access is to disable all directory listings. This usually involves adding a special command to the .htaccess file found in your root directory, or some other similar method. Contact your web host to find out how to do this safely and correctly for your particular server. Do not attempt to do this unless you have help or already know what you are doing. <br /><br />'.
		'2. Include a simple index.html file in each and every directory that you create for file storage. Doing so is easy. Just <a id="index-html-link" href="#" data-clipboard-target="index-html" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into a blank Notepad document, then save the document as <code>index.html</code>. Keep this file on hand, and copy it into any and all directories that you create. This will prevent users from direct access to your directory listings.'.
'<textarea id="index-html" cols="1" rows="1" disabled="disabled" style="display:none;"><html><head><title>Access Denied</title></head><body bgcolor="#000000"></body></html></textarea>'.
		'<script> '.
			'var clip = new ZeroClipboard(document.getElementById("index-html-link"), '.
			'{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"}); '.
			'clip.on("complete", function(client, args){ filertify.alert("You grabbed it."); }); '.
		'</script> '.
	'</div>';
// Attachment Management
$output .= 
	'<div id="fileaway-tutorials-attachment-management" class="fileaway-tutorials" style="display:none;">'.
		'For all your WordPress attachment needs, File Away cannot recommend Dan Holloran\'s <a href="http://wordpress.org/plugins/wp-better-attachments/" target="_blank">WP Better Attachments</a> highly enough. Directly from your post or page editor, it will allow you to add attachments (images, documents, music, whatever), see a list of all files currently attached to the post or page, edit each attachment\'s Title, its Caption, and its Description. The Caption and Description fields can be added to [attachaway]\'s Sortable Data Tables as custom columns. (See the tutorial on Attach Away Attributes, or the info links on the shortcode generator, for details.) WP Better Attachments also allows you to remove attachments from the current page, and numerous other features. It provides everything you\'ll need to compliment the [attachaway] shortcode. <br /><br />'.
		'Note that, with attachments, the [attachaway] shortcode will look first for the Title of the file, and if that is not defined, the shortcode will prettify the filename, subtract its extension, and try to give it a nice title-case. This is what will appear as the filename on all [attachaway] lists and tables. You can override the file name by defining the Title field, and with WP Better Attachments, it\'s a breeze.<br /><br />'.
	'</div>';
// Custom CSS
$ind1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind3 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind4 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind5 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$output .=
	'<div id="fileaway-tutorials-custom-css" class="fileaway-tutorials" style="display:none;">'.
		'<dl class="fileaway-accordion">
			<dt><label class="fileaway-accordion-label">Initial Note</label></dt>
			<dd style="display:none;">
			In the CSS editor or your custom stylesheet, all your custom classes need to be prefixed with <code>ssfa-</code>, with the exception of custom accent colors, which need to be prefixed with <code>accent-</code>. But when you add your comma-separated list of classes to the Custom Classes text-fields on the Custom CSS tab, you\'ll leave out the prefix, because the shortcode will add it for you. So in the stylesheet, it will look like this: <code>ssfa-yourstyle</code>, <code>ssfa-yourcolor</code>, or <code>accent-yourcolor</code>. But in the text fields, <code>yourstyle|Display Name</code>, <code>yourcolor|Display Name</code>, <code>youraccentcolor|Display Name</code> Adding this to the text fields will hook your new styles and colors into the shortcode generator modal. <br /><br />
			Below are some examples to get you moving: <br /><br />
			</dd>
			<dt><label class="fileaway-accordion-label">Custom List Styles</label></dt>
			<dd style="display:none;">
			First, <a id="boxed-in-css-classname-link" href="#" data-clipboard-text="boxed-in|Boxed-In,">grab this</a> and paste it into the "Custom List Classes" textfield on the Custom CSS tab. Then, <a id="boxed-in-css-link" href="#" data-clipboard-target="boxed-in-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor on the Custom CSS tab or into your own CSS document. Save your changes then head over to the shortcode modal and you\'ll find the "Boxed-In" style in the "Alphabetical List" category. To add another list style, just repeat the process and adjust the CSS to suit your tastes. 
			<textarea id="boxed-in-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once fileaway_dir.'/lib/inc/inc.admin.boxed-in.php'; 
			$output .= '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("boxed-in-css-classname-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("boxed-in-css-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			</script>
			 <br /><br />
			 </dd>
			<dt><label class="fileaway-accordion-label">Custom Table Styles</label></dt>
			<dd style="display:none;">
			First, <a id="custom-table-classname-link" href="#" data-clipboard-text="yourtablestyle|Your Table Style Name,">grab this</a> and paste it into the "Custom Table Classes" textfield on the Custom CSS tab, changing the class and display names to match the class you\'ll create. Then, <a id="custom-table-css-link" href="#" data-clipboard-target="custom-table-css" data-clipboard-text="Default clipboard text from attribute">grab this</a>, which is an exact duplicate of the "Minimalist" table style, and paste it into the CSS editor on the Custom CSS tab or into your own CSS document. Remember to change every instance of <code>ssfa-yourtablestyle</code> to <code>ssfa-whatever-you-want</code>, leaving the prefix in tact. Adjust the CSS to create a new table style. To add another table style, just repeat the process. Make sure the classname in your CSS editor matches the classname entered into the "Custom Table Classes" field on the Custom CSS tab (minus the <code>ssfa-</code> prefix of course), and if you create more than one, be sure to separate them with a comma: <code>yourclass1|Display Name 1, yourclass2|Display Name 2, etc.</code> 
			<textarea id="custom-table-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once fileaway_dir.'/lib/inc/inc.admin.custom-table-style.php'; 
			$output .= '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-table-classname-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-table-css-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			</script>
			 <br /><br />
			</dd>
			<dt><label class="fileaway-accordion-label">Custom Primary Colors</label></dt>
			<dd style="display:none;">
			The primary colors aren\'t Blue, Red, and Yellow. They\'re the colors that affect your Headers and, in list styles, affect your link text and your icons. Adding new primary colors is a piece of cake. First, <a id="custom-color-classname-link" href="#" data-clipboard-text="yourcolor|Your Color Name,">grab this</a> and paste it into the "Custom Color Classes" textfield on the Custom CSS tab, changing the class and display names to match the primary color class you\'ll create. Then, <a id="custom-color-css-link" href="#" data-clipboard-target="custom-color-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor on the Custom CSS tab or into your own CSS document. Remember to change every instance of <code>ssfa-yourcolor</code> to <code>ssfa-whatever-you-want</code>, leaving the prefix in tact. This will hook your new color into the existing table and list styles. Then all you have to do is define a single color hex code and you\'re done! To add another color, just repeat the process. Make sure the classname in your CSS editor matches the classname entered into the "Custom Color Classes" field on the Custom CSS tab (minus the <code>ssfa-</code> prefix of course), and if you create more than one, be sure to separate them with a comma: <code>yourclass1|Display Name 1, yourclass2|Display Name 2, etc.</code> For each Primary Color you create, you will also need to create a corresponding Accent Color... 
			<textarea id="custom-color-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once fileaway_dir.'/lib/inc/inc.admin.custom-color-primary.php'; 
			$output .= '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-color-classname-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-color-css-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			</script>
			<br /><br />
			</dd>
			<dt><label class="fileaway-accordion-label">Custom Accent Colors</label></dt>
			<dd style="display:none;">
			In list styles, the accent colors affect your icon area backgrounds and a few other things. You will need to make matching accent colors for every primary color you make, and vice versa. The accent color will generally just be a lighter shade of the primary color. But don\'t worry. When you build your shortcode, you can choose non-matching Primary and Accent colors. But each color needs to have a matching color (with the same name), because if you choose not to specify a color or an accent color when building your shortcode, the shortcode will look for Primary and Accent colors with the same name.<br /><br /> First, <a id="custom-accent-classname-link" href="#" data-clipboard-text="yourcolor|Your Accent Name,">grab this</a> and paste it into the "Custom Accent Color Classes" textfield on the Custom CSS tab, changing the class and display names to match the accent color class you\'ll create (minus the <code>accent-</code> prefix of course). Then, <a id="custom-accent-css-link" href="#" data-clipboard-target="custom-accent-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor on the Custom CSS tab or into your own CSS document. Remember to change every instance of <code>accent-yourcolor</code> to <code>accent-whatever-you-want</code>, leaving the prefix in tact. This will hook your new accent color into the existing table and list styles. Then all you have to do is define one RGB color code, and one hex code and that\'s it.  
			<textarea id="custom-accent-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once fileaway_dir.'/lib/inc/inc.admin.custom-color-secondary.php'; 
			$output .= '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-accent-classname-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-accent-css-link"), 
				{moviePath: "'.fileaway_url.'/lib/js/clipboard/ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){filertify.alert("You grabbed it.");});
			</script>
			<br /><br />
			</dd>
			<dt><label class="fileaway-accordion-label">A Final Note About Structure</label></dt>
			<dd style="display:none;">
			You should be able to tell by looking at the CSS examples provided above, but just to make it clear, here is the fixed HTML structure for lists and tables. Any CSS you do has to work with (or around) this structure. Some of the classes only show up if certain options are selected in the shortcode generator, but we will show you where they are regardless. Anything in square brackets is variable. Text in blue is where you get to join the fray.<br /><br />
			For Alphabetical Lists: 
			<br /><br />
			<code>&lt;div id="ssfa-list-wrap-[<font style="color:#0093d9; font-weight:bold;">randomUniqueID</font>]" '.
				'class="ssfa-[<font style="color:#0093d9; font-weight:bold;">your-list-style</font>] [ssfa-corners-style]"&gt;</code><br />
				'.$ind1.'<code>[&lt;h3 class="ssfa-heading ssfa-[<font style="color:#0093d9; font-weight:bold;">your-color-class</font>]"&gt;Heading Here&lt;/h3&gt;]</code><br />
				'.$ind1.'<code>&lt;!-- Repeated Section Begins --&gt;</code><br /> 	
				'.$ind1.'<code>&lt;a id="ssfa" class="ssfa-[<font style="color:#0093d9; font-weight:bold;">your-color-class</font>] accent-[<font style="color:#0093d9; font-weight:bold;">your-accent-class</font>] [ssfa-inline|ssfa-twocol] [noicons]" href="[filelink]"&gt;</code><br />
					'.$ind2.'<code>&lt;div class="ssfa-listitem"&gt;</code><br />
						'.$ind3.'<code>&lt;span class="ssfa-topline"&gt;</code><br />					
							'.$ind4.'<code>[&lt;span class="ssfa-[listicon|paperclip] ssfa-[<font style="color:#0093d9; font-weight:bold;">your-color-class</font>]"&gt;Icon Here&lt;/span&gt;]</code><br />
							'.$ind4.'<code>&lt;span class="ssfa-filename"&gt;Filename Here&lt;/span&gt;</code><br />
							'.$ind4.'<code>[&lt;span class="ssfa-listfilesize"&gt;File Size Here&lt;/span&gt;]</code><br />
						'.$ind3.'<code>&lt;/span&gt;</code><br />
						'.$ind3.'<code>[&lt;div class="ssfa-datemodified"&gt;Date, Time&lt;/div&gt;]</code><br />
					'.$ind2.'<code>&lt;/div&gt;</code><br />
				'.$ind1.'<code>&lt;/a&gt;</code><br />
				'.$ind1.'<code>&lt;!-- Repeated Section Ends --&gt;</code><br /> 	
			<code>&lt;/div&gt;</code>
			<br /><br />			
			For Sortable Data Tables: 
			<br /><br />
			<code>&lt;div id="ssfa-table-wrap-[<font style="color:#0093d9; font-weight:bold;">randomUniqueID</font>]" '.
				'style="margin: 10px 0; [width:#; float:left|right; margin:#;]"&gt;</code><br />
				'.$ind1.'<code>[&lt;h3 class="ssfa-heading ssfa-[<font style="color:#0093d9; font-weight:bold;">your-color-class</font>]"&gt;</code><br />
					'.$ind2.'<code>&lt;div class="ssfa-search-wrap"&gt;</code><br />
						'.$ind3.'<code>&lt;span class="ssfa-searchicon" aria-hidden="true"&gt;&lt;/span&gt;</code><br />
						'.$ind3.'<code>&lt;input class="ssfa-searchfield" placeholder="SEARCH" name="search" id="search" type="text" /&gt;</code><br />
					'.$ind2.'<code>&lt;/div&gt;</code><br />
				'.$ind1.'<code>Heading Here&lt;/h3&gt;] </code><br />
				'.$ind1.'<code>&lt;table id="ssfa-table-[<font style="color:#0093d9; font-weight:bold;">randomUniqueID</font>]" '.
					'class="footable ssfa-sortable ssfa-[<font style="color:#0093d9; font-weight:bold;">your-table-style</font>] ssfa-[left|right]"&gt;</code><br />	
					'.$ind2.'<code>&lt;thead&gt;&lt;tr&gt;</code><br />
						'.$ind3.'<code>&lt;th class="ssfa-sorttype"&gt;File Type&lt;/th&gt;</code><br />
						'.$ind3.'<code>&lt;th class="ssfa-sortname"&gt;File Name&lt;/th&gt;</code><br />
						'.$ind3.'<code>[&lt;th class="ssfa-sortcustomdata"&gt;Custom Column&lt;/th&gt;&lt;!-- For Directory Files Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;th class="ssfa-sortcapcolumn"&gt;Custom Column 1&lt;/th&gt;&lt;!-- For Page Attachments Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;th class="ssfa-sortdescolumn"&gt;Custom Column 2&lt;/th&gt;&lt;!-- For Page Attachments Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;th class="ssfa-sortdate"&gt;Date Modified&lt;/th&gt;]</code><br />
						'.$ind3.'<code>[&lt;th class="ssfa-sortsize"&gt;File Size&lt;/th&gt;]</code><br />
					'.$ind2.'<code>&lt;/tr&gt;&lt;/thead&gt;</code><br />
					'.$ind2.'<code>&lt;tfoot&gt;&lt;tr&gt;</code><br />
						'.$ind3.'<code>&lt;td colspan="100"&gt;</code><br />
							'.$ind4.'<code>&lt;div class="ssfa-pagination ssfa-pagination-centered"&gt;&lt;/div&gt;</code><br />
						'.$ind3.'<code>&lt;/td&gt;</code><br />
					'.$ind2.'<code>&lt;/tr&gt;&lt;/tfoot&gt; </code><br />
					'.$ind2.'<code>&lt;tbody&gt;</code><br />
					'.$ind2.'<code>&lt;!-- Repeated Section Begins --&gt;</code><br />
					'.$ind2.'<code>&lt;tr&gt;</code><br />
						'.$ind3.'<code>&lt;td class="ssfa-sorttype"&gt;File Type&lt;/td&gt;</code><br />
							'.$ind4.'<code>&lt;a href="[filelink]"&gt;</code><br />
								'.$ind5.'<code>&lt;span class="ssfa-[faminicon|paperclip]"&gt;.ext&lt;/span&gt;</code><br />
							'.$ind4.'<code>&lt;/a&gt;</code><br />
						'.$ind3.'<code>&lt;td class="ssfa-sortname"&gt;&lt;a href="[filelink]"&gt;File Name&lt;/a&gt;&lt;/td&gt;</code><br />
						'.$ind3.'<code>[&lt;td class="ssfa-sortcustomdata"&gt;Custom Data&lt;/td&gt;&lt;!-- For Directory Files Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;td class="ssfa-sortcapcolumn"&gt;Caption&lt;/td&gt;&lt;!-- For Page Attachments Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;td class="ssfa-sortdescolumn"&gt;Description&lt;/td&gt;&lt;!-- For Page Attachments Tables --&gt;]</code><br />
						'.$ind3.'<code>[&lt;td class="ssfa-sortdate"&gt;Date, Time&lt;/td&gt;]</code><br />
						'.$ind3.'<code>[&lt;td class="ssfa-sortsize"&gt;File Size&lt;/td&gt;]</code><br />
					'.$ind2.'<code>&lt;/tr&gt;</code><br />
					'.$ind2.'<code>&lt;!-- Repeated Section Ends --&gt;</code><br />
					'.$ind2.'<code>&lt;/tbody&gt;</code><br />
				'.$ind1.'<code>&lt;/table&gt;</code><br />
			<code>&lt;/div&gt;</code><br />
			</dd>
		</dl>'.
	'</div>';
// Fileaway Attributes
$output .= 
	'<div id="fileaway-tutorials-fileaway-attributes" class="fileaway-tutorials" style="display:none;">'.
		'No single attribute is required. Just entering [fileaway] into your page content will, by default, display all files in Base Directory 1, in an Alphabetical List, with the Minimal-List style, and random colors, excluding all web code documents and any filenames or file types permanently excluded on the Basic Configuration page. But to fine tune the functionality and appearance of your file display, the two shortcodes offer a total of 31 attributes. <br /><br />'.
		'The point-and-click shortcode generator will take care of these attributes for you, but if you want to build your shortcodes manually, or just want to know what all is underneath the machinery, below is a table detailing each one. To build a shortcode manually, follow this format: <code>[fileaway attribute="value" attribute="value"]</code>, replacing "attribute" and "value" with the names of the attributes of your choosing, and their accepted values, detailed in the table below:<br><br>'.
		'<style>table tbody td{ vertical-align:top!important; }</style>'.
		$info->tutorial('fileaway').
	'</div>';
// Attachaway Attributes
$output .= 
	'<div id="fileaway-tutorials-attachaway-attributes" class="fileaway-tutorials" style="display:none;">'.
		'No single attribute is required. Just entering [attachaway] into your page content will, by default, grab the current post\'s/page\'s attachments, in an Alphabetical List, with the Minimal-List style, and random colors, excluding all web code documents and any filenames or file types permanently excluded on the Basic Configuration page. But to fine tune the functionality and appearance of your file display, the two shortcodes offer a total of 31 attributes. <br /><br />'.
		'The point-and-click shortcode generator will take care of these attributes for you, but if you want to build your shortcodes manually, or just want to know what all is underneath the machinery, below is a table detailing each one. To build a shortcode manually, follow this format: <code>[attachaway attribute="value" attribute="value"]</code>, replacing "attribute" and "value" with the names of the attributes of your choosing, and their accepted values, detailed in the table below:<br><br>'.
		$info->tutorial('attachaway').
	'</div>';
// File-Up Attributes	
$output .= 
	'<div id="fileaway-tutorials-fileup-attributes" class="fileaway-tutorials" style="display:none;">'.
		'Front-end file uploading is finally here with File Away\'s new [fileup] shortcode! File Up delivers ajax-powered uploading to your server directories with a wide range of customizable features. Now you can File Up and File Away! A couple of quick notes:'.
		'<ol>'.
			'<li>You can rename your files on the page before uploading.</li>'.
			'<li>Insider trick: If you rename a file from "my_document" to "Documents/my_document", it will create a subdirectory called Documents for you. You can do this to create sub-directories as many levels deep as you\'d like.</li>'.
		'</ol>'.
		'The point-and-click shortcode generator will take care of these attributes for you, but if you want to build your shortcodes manually, or just want to know what all is underneath the machinery, below is a table detailing each one. To build a shortcode manually, follow this format: <code>[fileup attribute="value" attribute="value"]</code>, replacing "attribute" and "value" with the names of the attributes of your choosing, and their accepted values, detailed in the table below:<br><br>'.
		$info->tutorial('fileup').
	'</div>';
// File-a-Frame Attributes
$output .= 
	'<div id="fileaway-tutorials-fileaframe-attributes" class="fileaway-tutorials" style="display:none;">'.
		'<ol>'.
			'<li> Create a new page and using the Template dropdown under Page Attributes, set the template to File Away iframe.</li>'.
			'<li> Under Sortable Data Tables, insert your [fileaway] shortcode with the Directory Tree setting enabled, and assign it a Unique Name.</li>'.
			'<li> Save the page and remember the page slug. </li>'.
			'<li> Edit another page with your normal template, and insert the above File Away iframe shortcode, with the page slug from the other page inserted '.
				'into the Source URL field, and the unique name from the [fileaway] shortcode inserted into the Unique Name field. Click on all the info links to '.
				'see what each setting does.</li>'.
			'<li> Done! Now you\'ve got a Directory Tree table on your front-end page, that will navigate through the directories without refreshing the parent page. </li>'.
		'</ol>'.
		'The point-and-click shortcode generator will take care of these attributes for you, but if you want to build your shortcodes manually, or just want to know what all is underneath the machinery, below is a table detailing each one. To build a shortcode manually, follow this format: <code>[fileaframe attribute="value" attribute="value"]</code>, replacing "attribute" and "value" with the names of the attributes of your choosing, and their accepted values, detailed in the table below:<br><br>'.
		$info->tutorial('fileaframe').
	'</div>';
// Manager Mode
$output .= 
	'<div id="fileaway-tutorials-manager-mode" class="fileaway-tutorials" style="display:none;">'.
		'The features are self-explanatory when Manager Mode is enabled. To bulk edit, toggle Bulk Action Mode from "Disabled" to "Enabled" at the bottom of the table. Specify your action in the dropdown, specify your destination directory (if applicable) in the subsequent dropdown, then simply click on the table rows for each file you want to download, copy, move, or delete.<br><br>'.
		'Several security features are in place to protect your files. Users cannot navigate backwards from the specified start directory, nor can they move or copy (or delete) content to directories behind or parallel to their branch of the tree. If users attempt to manipulate the HTML to access directories beyond their purview, File Away will foil their attempts in several ways, both on the client and server side of the process. Moreover, if an attempt is made to copy, move, or delete files to/in directories outside of their purview, they will be logged out, and an email will be sent to the site administrator with their name, user login, user id, ip address, and the time stamp, notifying the admin of their attempt.'. 
	'</div>';
// Dynamic Paths
$output .= 
	'<div id="fileaway-tutorials-dynamic-paths" class="fileaway-tutorials" style="display:none;">'.
		'<code>Note:</code> Below these instructions there is a table with a list of all your site\'s users, each column displaying how each dynamic code will be rendered for each user. Use this table as a reference when creating your directories.<br /><br />'.
		'You can create dynamic paths to your user\'s files using one or more of File Away\'s codewords. This means that you can point to a theoretically unlimited number of different file directories, all with a single shortcode, and each logged-in user will only ever see the files they are meant to see. <br /><br />'.
		'The four codes are: <code>fa-firstlast</code>, <code>fa-username</code>, <code>fa-userid</code>, and <code>fa-userrole</code>. You can use them separately, or in combination with each other. You can use them in your Base Directory paths, and/or in your Sub Directory specification in the shortcode generator. Wherever the codes are used in the path, they will be replaced dynamically by the <code>firstname+lastname</code>, the <code>username</code>, the <code>user ID number</code>, or the <code>user role</code>, respectively, of whoever is logged in. Thus, if you create folders for your users such as: "bobsmith" or "bobsloginname" or "15" or "editor", using these dynamic codes will point whoever is logged in to their own folders. You can combine them, or use them separately. You can use them along with static words. You can use them more than once in the same path. <br /><br />'.
		'If you\'ve created directories that are named (or partially named) for your users\' first and last names (e.g., jackhandy), user id (e.g., 15), username (e.g., admin), or user role (e.g., subscriber), the codes will dynamically point whoever is logged in to their appropriate folder. The directories you create for your users must be all lowercase with no spaces, with one exception. Under the Basic Configuration tab, you can choose whether to force lowercase for usernames, or to allow strict, case-sensitive matching. The default is to force lowercase. If the username is \'JoanJett,\' the directory should be: <code>joanjett</code>, if force lowercase is chosen. If strict matching is chosen, then the directory should match the actual username exactly, case-sensitive. For emphasis, this option only applies to the <code>fa-username</code> code, not to the other three. Alternatively, add <code>makedir="true"</code> to your File Away or File Up shortcodes, and the directories will be created for you on page load, properly formatted, if they do not already exist. Examples: <br /><br />'.
		'<code>uploads/fa-userrole/fa-firstlastfa-userid</code> will point dynamically, depending on who is logged in, to directories like: <code>uploads/editor/jackhandy15</code> or <code>uploads/subscriber/joanjett58</code>.<br /><br />'.
		'<code>files/fa-userid/fa-firstlast-docs</code> will point to: <code>files/15/bobsmith-docs</code> or <code>files/14/maryjane-docs</code> <br />'.
		'<code>uploads/fa-firstlastfa-userid/photos</code> will point to: <code>uploads/bobsmith15/photos</code> or <code>uploads/maryjane14/photos</code><br /><br />'.
		'Note that these codes do not need to be separated from whatever comes before or after them. <code>misterfa-firstlastisawesome</code> will render: <code>misterbobsmithisawesome</code>. You can even pluralize your user role directories. Rather than creating directories called <code>administrator</code>, <code>editor</code>, and <code>author</code>, you can create ones called <code>administrators</code>, <code>editors</code>, and <code>authors</code>. Then when you enter the code, just append an \'s\' to the end: <code>fa-userroles</code>. The shortcode is translating the code to the role in the singular, and you\'re just adding the \'s\' to the path as a static character.<br /><br />'.
		'A few small points to make about dynamic paths: '.
		'<ul class="fileaway-bulletlist">'.
			'<li>You can use them in your base directories or in your sub directories specified in the shortcode generator.</li>'.
			'<li>If a dynamic path is used in your shortcode, the file list or table will not be visible to logged-out users.</li>'.
			'<li>If no files are found in the directory, the list or table will not be visible. That way, with dynamic paths, only those logged-in users who have something to see will be able to see anything. The exception to this rule is if you have enabled Directory Tree or Manager Mode.</li>'.
			'<li>If the directories do not already exist, add <code>makedir="true"</code> to your File Away or File Up shortcodes, and they will create the directory on the fly if it doesn\'t already exist.</li>'.
			'<li>Note also that the folders you create for a user\'s first and last name must be all lowercase with no spaces, and must match the user\'s first and last names as recorded in their user profile. See the table below for reference when creating your directories.</li>'.
			'<li>Folders created to match usernames (user logins) can be all lowercase, or case-sensitive, depending upon your selection in the Basic Configuration tab. Again, see the table below for reference.</li>'.
			'<li>There\'s a debug feature in the shortcode that you can use if you\'re having trouble with your paths.</li>'.
		'</ul><br />';
if($this->options['loadusers'] == 'true')
{
	$output .=	
		'<div class="ssfa-meta-container" id="ssfa-meta-container-dynamic-paths">'.
		'<br /><div id="fileaway-table-wrap" style="margin: 10px 0 0; width:100%;">'.
			'<div class="fileaway-search-wrap">'.
				'<span class="fileaway-searchicon fileaway-icon-search" aria-hidden="true"></span>'.
				'<input id="filter-dynamic-paths" class="fileaway-searchfield" placeholder="SEARCH" value="" name="search" id="search" type="text" />'.
			'</div>'.
			'<script type="text/javascript">jQuery(function(){jQuery(".footable").footable();});</script>'.
			'<table id="fileaway-table" data-filter="#filter-dynamic-paths" data-page-size="25" class="footable fileaway-sortable fileaway-minimalist">'.
				'<thead><tr>'.
					'<th class="fileaway-minimalist-first-column" data-sort-initial="true" title="Click to Sort">fa-firstlast</th>'.
					'<th title="Click to Sort">fa-username</th>'.
					'<th title="Click to Sort">fa-userid</th>'.
					'<th class="fileaway-minimalist-last-column" title="Click to Sort">fa-userrole</th>'.
				'</tr></thead>'.
				'<tfoot><tr>'.
					'<td colspan="100"><div class="fileaway-pagination fileaway-pagination-centered hide-if-no-paging"></div></td>'.
				'</tr></tfoot>'. 
				'<tbody>';
	$blogusers = get_users('blog_id='.$GLOBALS['blog_id'].'&orderby=nicename');
	foreach($blogusers as $user)
	{
		$userrole = new WP_User($user->ID);
		$username = $this->options['strictlogin'] === 'true' ? $user->user_login : strtolower($user->user_login);
		$output .= 
			'<tr>'.
				'<td class="fileaway-minimalist-first-column">'.strtolower($user->user_firstname).strtolower($user->user_lastname).'</td>'.
				'<td>'.$username.'</td>'.
				'<td>'.$user->ID.'</td>'.
				'<td class="fileaway-minimalist-last-column">'.strtolower($userrole->roles[0]).'</td>'.
			'</tr>'; 
	}
	$output .= '</tbody></table></div></div>';
}
else
{
	$output .= '<code>You must set "Feature Options > Load Users" to "true," save, then refresh the page, in order to display this table.</code>';
}
$output .= '</div>';
// Formidable Pro
$output .= 
	'<div id="fileaway-tutorials-formidable-pro" class="fileaway-tutorials" style="display:none;">'.
		'Users of the <a href="http://formidablepro.com/" target="_blank">Formidable Pro</a> plugin can create dynamic paths in File Away lists and tables inside Formidable custom displays, following the same basic principles outlined under "Dynamic Paths" above. <br /><br />'.
		'When inserting your [fileaway] shortcode inside a custom display, you can set a base directory or your sub directory attribute to point dynamiclly to directories named for any form field datum or user meta, using Formidable\'s shortcodes inside the [fileaway] shortcode. Examples:<br /><br />'.
		'<code>[fileaway base="1" sub="[125 show=\'user_login\']"]</code>, where "125" is the field ID number of your form\'s user ID field. This will point dynamically to any directory named for the user_login of the custom display\'s current form entry. So if base=1 equals something like, <code>client-files/docs</code>, then the sub directory would append each entry\'s username to the end of the path, e.g., <code>client-files/docs/jackhandy</code> or <code>client-files/docs/joanjett</code>. <br /><br />'.
		'<code>[fileaway base="2" sub="hr/[125 show=\'first_name\'][125 show=\'last_name\']/pdfs"]</code>, if Base Directory 2 equals <code>staff-files</code>, would point to: <code>staff-files/hr/jeremyrenner/pdfs</code> or <code>staff-files/hr/tomcruise/pdfs</code>. <br /><br />'.
		'You can do the same with <code>[125 show=\'display_name\']</code> and <code>[125 show=\'ID\']</code>, or, technically, any field shortcode from any form, e.g., <code>[889]</code>. You can use File Away to point dynamically to virtually anything, and adding <code>makedir="true"</code> to your File Away or File Up shortcode will create it for you on page load if the directory does not already exist. In this case, the output will be dynamic based not on who is logged in, as with the File Away dynamic path codes, but dynamic based on the currently displayed entry in your Formidable custom display.<br /><br />'.
		'Unlike File Away\'s own dynamic path codewords (which forces translated output to lowercase), Formidable shortcodes will be case sensitive, either upper or lowercase, depending on user input. Use the debug feature in the <code>[fileaway]</code> shortcode for help figuring out where your paths are pointing. And once again, if no files are in the directory to which the shortcode is pointing, nothing will be displayed, unless Directory Tree or Manager Mode are enabled. This means you can add a shortcode that points dynamically to different directories, and worry about adding files to those directories at your own pace. The shortcode will not output anything until there is something in the (dynamically determined) directory to display.'.
	'</div>';
// Timezone Settings
$output .= 
	'<div id="fileaway-tutorials-timezone-settings" class="fileaway-tutorials" style="display:none;">'.
		'For your Date Modified data on lists and tables, the shortcode automatically grabs the timezone settings from your WordPress installation. If, however, you use the UTC timezone format in your WordPress settings, the time reflected in your Date Modified column will be UTC with no local offset. If you want the times to accurately reflect your local time, you need to go to Settings > <a href="options-general.php" target="_blank">General</a> and make sure your timezone format is set to the Country/City format. So if you lived in Chicago, you\'d set it to <code>America/Chicago</code>, rather than <code>UTC+6</code>.'.
	'</div>';