<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(class_exists('fileaway_admin') && !class_exists('fileaway_tutorials'))
{
	class fileaway_tutorials
	{
		public $optioninfo;
		public $helplinks;
		public function __construct()
		{
			$this->optioninfo = array();
			$this->optioninfo();
			$this->helplinks = array();
			$this->helplinks();
		}
		public function optioninfo()
		{
			$get = new fileaway_definitions;
			$optioninfo = array();
			$optioninfo['password'] = array(
				'heading' => 'Manager Mode: Override Password',
				'info' => "Enter the Override Password here, and if it matches the Override Password established in the File Away Options page, then any user IDs or user roles specified in the prior fields (in addition to the roles and users set in the permanent settings) will have Manager Mode privileges for this shortcode only."
			);
			$optioninfo['color'] = array(
				'heading' => 'Link Color',
				'info' => "The color of primary links and styles. Default for lists: Random. Default for tables: Classic."
			);			
			$optioninfo['accent'] = array(
				'heading' => 'Accent Color',
				'info' => "Defaults to random if left blank."
			);			
			$optioninfo['iconcolor'] = array(
				'heading' => 'Icon Color',
				'info' => "Default for lists: Random. Default for tables: Classic."
			);			
			$optioninfo['icons'] = array(
				'heading' => 'Icons',
				'info' => "Defaults to File Type icons if left blank."
			);			
			$optioninfo['display'] = array(
				'heading' => 'Display Style',
				'info' => "Alphabetical Lists default to vertical layout by default."
			);			
			$optioninfo['debug'] = array(
				'heading' => 'Debug Mode',
				'info' => "If nothing is showing up on the page when you insert the shortcode, it's either because there are no files in the directory/attached to the page that you're pointing to, or because you've excluded anything that's in the directory/attached to the page that you're pointing to. Activating the debug feature will display a box in the page content that will tell you the directory or the attachment page to which your shortcode is pointing."
			);			
			$optioninfo['search'] = array(
				'heading' => 'Filtering',
				'info' => "By default, a search icon will be placed at the top-right of the table, which allows users to filter out table content to find what they're looking for. You can disable it if desired."
			);			
			$optioninfo['paginate'] = array(
				'heading' => 'Pagination',
				'info' => "By default, pagination on tables is disabled. Recommended only for large file directories."
			);			
			$optioninfo['pagesize'] = array(
				'heading' => 'Number per Page',
				'info' => "If pagination is enabled, you can set the number of files to show per page. Default is 15."
			);			
			$optioninfo['textalign'] = array(
				'heading' => 'Text Alignment',
				'info' => "For tables. Defaults to Center."
			);			
			$optioninfo['customdata'] = array(
				'heading' => 'Custom Column(s)',
				'info' => "You can add multiple custom columns to your table and add custom data to any file you want. Name the columns here, e.g., <code>Artist</code>, then to add data to your files, just put the data in between square brackets [ ] at the *end* of your file name, *before* the extension. If you want to add more than one column, separate the column names here with a comma (e.g., <code>Artist, Album, Label, Year</code>), and separate the corresponding data in the fileneames with a comma. Example filenames: <br /><br /><code>My Funny Valentine [Chet Baker, My Funny Valentine, Blue Note, 1994].mp3</code><br /><code>So What [Miles Davis, Kind of Blue, Columbia, 1959].mp3</code><br /><code>Birdland [Weather Report, Heavy Weather, Columbia, 1977].mp3</code><br /><br />The data in square brackets will be automatically added to the column(s) that you create here. This feature can be used for any purpose you like.<br /><br />Note that anything in square brackets will only show up in Data Tables, and, in that case, only if you name your custom column(s) here."
			);			
			$optioninfo['postid'] = array(
				'heading' => 'Post / Page ID',
				'info' => "If left blank, by default the shortcode will grab the attachments from the page or post where the shortcode is inserted (the current page). Alternatively, you can specify a post/page ID here, and the shortcode will grab the attachments from that one instead. <br /><br />If you don't know the ID, Attach Away has added an 'ID' column to your 'All Pages' and 'All Posts' pages. This column can be enabled or disabled in the File Away settings page."
			);			
			$optioninfo['capcolumn'] = array(
				'heading' => 'Caption Column',
				'info' => "You can add a custom column to your table and add custom data to any attachment file you want. For this particular column, the data will be pulled from the attachment's 'Caption' field. Name the column here, anything you want, e.g., <code>Artist</code>. Then just add the specific data to the Caption field for each attachment file. Example:<br /><br /><code>Caption Column Name: Artist</code><br /><code>Attachment 1 Caption: Jon Bon Jovi</code><br /><code>Attachment 2 Caption: Michael J. Iafrate</code><br /><br />For easy management of your attachments without leaving the page editor, File Away recommends the <a href='https://wordpress.org/plugins/wp-better-attachments/' class='inner-link' target='_blank'>WP Better Attachments</a> plugin by Dan Holloran."
			);			
			$optioninfo['descolumn'] = array(
				'heading' => 'Description Column',
				'info' => "You can add a second custom column to your table and add custom data to any attachment file you want. For this column, the data will be pulled from the attachment's 'Description' field. Name the column here, anything you want, e.g., <code>Author</code>. Then just add the specific data to the Description field for each attachment file. Example:<br /><br /><code>Description Column Name: Author</code><br /><code>Attachment 1 Description: Vaclav Havel</code><br /><code>Attachment 2 Description: Terry Eagleton</code><br /><br />For easy management of your attachments without leaving the page editor, File Away recommends the <a href='https://wordpress.org/plugins/wp-better-attachments/' class='inner-link' target='_blank'>WP Better Attachments</a> plugin by Dan Holloran."
			);			
			$optioninfo['sortfirst'] = array(
				'heading' => 'Initial Sorting',
				'info' => "Choose the column by which to sort your table on initial page load. You can choose to sort in ascending or descending order for each column. Defaults to Filename (Asc) if left blank.<br /><br />Note: If you are using multiple custom columns in a <code>[fileaway]</code> table, and you wish to sort initially by one of those custom columns, set your Initial Sorting to either Custom Column (Asc) or Custom Column (Desc) here, then in the Custom Column Name(s) field (i.e., the <code>customdata</code> attribute), put an asterisk(*) next to the name of the column by which you wish to sort initially. Don't worry. The asterisk will be removed before it gets to the page."
			);			
			$optioninfo['nolinks'] = array(
				'heading' => 'Disable Links',
				'info' => "Defaults to false. If Disable Links is set to 'True', the hypertext reference is removed from the &#60;a&#62; tag. This is in case you want, for instance, to display successful uploads without providing links to the files. You'll still want to style your links using the shortcode options, but the link functionality will be removed."
			);
			$optioninfo['unicode'] = array(
				'heading' => 'Unicode Support',
				'info' => "Defaults to false. If enabled, File Away will run an extra operation to support some common unicode characters for filenames and download links. Note that if the filename begins with a unicode character, it will generate a PHP warning. This is because PHP does not really support unicode at all and they actually gave up trying several years ago. All you have to do is rename the file with an underscore, space, or non-unicode character at the beginning of the file name. Any subsequent unicode characters will validate fine."
			);						
			$optioninfo['showto'] = array(
				'heading' => 'Show to Roles',
				'info' => "Takes a comma-separated list of user roles. If used, only those users with one of the user roles specified in this field will have access to the file/attachment display or file upload form."
			);			
			$optioninfo['hidefrom'] = array(
				'heading' => 'Hide from Roles',
				'info' => "Takes a comma-separated list of user roles. If used, those users with one of the user roles specified in this field will <em>not</em> have access to the file/attachment display or file upload form. If this attribute is used, logged-out users are also prevented from seeing the file/attachment display or file upload form."
			);			
			$optioninfo['maxsize'] = array(
				'heading' => 'Max Size',
				'info' => "The maximum allowed file size for each individual uploaded file. Enter an integer (e.g., 20). You will specify MB, KB, or GB under Max Size Type. If left blank, the default will be 10MB. Note that the system will also check the post_max_size and upload_max_filesize settings from your php.ini file, and if either is smaller than the size you specify here, that one will override your specification. Here are your current php.ini settings for your reference:<br /><br />post_max_size: ".fileaway_utility::ini('post_max_size', false, 'Not Set')."<br />upload_max_filesize: ".fileaway_utility::ini('upload_max_filesize', false, 'Not Set'),
			);			
			$optioninfo['maxsizetype'] = array(
				'heading' => 'Max Size Type',
				'info' => "Defaults to MB if left blank. Complements your Max Size setting. Note that the system will also check the post_max_size and upload_max_filesize settings from your php.ini file, and if either is smaller than the size you specify here, that one will override your specification. Here are your current php.ini settings for your reference:<br /><br />post_max_size: ".fileaway_utility::ini('post_max_size', false, 'Not Set')."<br />upload_max_filesize: ".fileaway_utility::ini('upload_max_filesize', false, 'Not Set'),
			);			
			$optioninfo['name'] = array(
				'heading' => 'Unique Name',
				'info' => "For File Away tables: Required only if in use with a corresponding iframe shortcode, otherwise optional. Assign a unique name. One word, no spaces. You will assign the same unique name to the corresponding File Away iframe shortcode. This will (1) enable the iframe to scroll to the top of the table when a new page is clicked, and (2) allow for easier reference when multiple iframed tables are on the same page.<br><br>For File Away iframes: Required. Assign a unique name. One word, no spaces. You will assign the same unique name to the corresponding File Away shortcode. This will (1) enable the iframe to scroll to the top of the table when a new page is clicked, and (2) allow for easier reference when multiple iframed tables are on the same page. <br><br>For File-Up shortcodes: Completely optional. Assign a unique name. One word, no spaces. If no name is assigned, a random unique name will be generated on each pageload."
			);
			$optioninfo['source'] = array(
				'heading' => 'Source Slug/URL',
				'info' => "Required. Enter the full URL, or just the page slug (like this: <code>/my-page-slug/</code>, of the iframed-templated page where you put your <code>[fileaway]</code> shortcode. To apply the File Away iframe template to that page, select 'File Away iframe' from the Page Template dropdown on the WordPress page editor."
			);			
			$optioninfo['scroll'] = array(
				'heading' => 'Scrolling',
				'info' => "Defaults to 'Off' if left blank. You will want to set your height attribute to a sufficient integer, and compensate by activating pagination on your <code>[fileaway]</code> table, and setting the pagination pagesize to a small number such as 10 or 20."
			);			
			$optioninfo['height'] = array(
				'heading' => 'Height',
				'info' => "Required. Enter an integer. The height attribute does not permit percentages. It is automatically in pixels so only the number is required. It is recommended to set it to a sufficient height such as 1000. If the height attribute is not set, well, your thing will look funny."
			);			
			$optioninfo['width'] = array(
				'heading' => 'Width',
				'info' => "For File Away and Attach Away shortcodes: Optional: If left blank, will default to auto-width if the type is set as 'Alphabetical List,' and to 100% if the type is set as 'Sortable Data Table.' If less than 100%, text will wrap around your list or table to the left or right, depending upon your alignment setting.<br><br>For File Away iframe shortcodes: Defaults to 100% if left blank. Otherwise, specify a pixel width by entering only the number desired. E.g., 800.<br><br>For File-Up shortcodes: Optional: If left blank, will default to 100%. If less than 100%, text will wrap around your upload form to the left or right, depending upon your alignment setting."
			);			
			$optioninfo['perpx'] = array(
				'heading' => 'Width Type',
				'info' => "Specify whether your width integer should be processed as a percentage or in pixels. Default: %"
			);
			$optioninfo['mheight'] = array(
				'heading' => 'Margin Height',
				'info' => "Defaults to 0 if left blank."
			);			
			$optioninfo['mwidth'] = array(
				'heading' => 'Margin Width',
				'info' => "Defaults to 0 if left blank."
			);			
			$optioninfo['base'] = array(
				'heading' => 'Base Directory',
				'info' => "Begin with one of the base directories you set up in the Configuration page. You can extend this path using the Sub Directory option. Defaults to Base 1 if left blank.<br><br>For File-Up shortcodes: This is the initial folder to which a user may upload files. If uploads are not set to a fixed location, they will be able to upload to any subdirectories, but not to any parent directories of the initial directory specified. You can extend this initial path using the Sub Directory option."
			);			
			$optioninfo['sub'] = array(
				'heading' => 'Sub-Directory',
				'info' => "Optional: Define a sub-directory to extend the path of your selected base directory. It can be one or more levels deep. You can leave out leading and trailing slashes. I.e., <code>uploads/2010</code> rather than <code>/uploads/2010/</code><br /><br />You can also use one or more of the four dynamic path codes: <code>fa-firstlast</code> <code>fa-userid</code> <code>fa-username</code> and <code>fa-userrole</code>. If you've created directories that are named for your users' first and last names (e.g., jackhandy), userid (e.g., 15), username (e.g., admin), or user role (e.g., subscriber), the codes will dynamically point whoever is logged in to their appropriate folder. The directories you create for your users must be all lowercase with no spaces. If the username is 'JoanJett,' the directory should be: <code>joanjett</code><br /><br />For example: <code>uploads/fa-userrole/fa-firstlastfa-userid</code> will point dynamically, depending on who is logged in, to directories like: <code>uploads/editor/jackhandy15</code> or <code>uploads/subscriber/joanjett58</code>."
			);			
			$optioninfo['images'] = array(
				'heading' => 'Images',
				'info' => "Optional: If left blank, the default behavior is to list image files along with all other files. You can alternatively choose to exclude all image types from your display, or to show only image types in your display. Image types are: ".implode(', ', $get->imagetypes)
			);			
			$optioninfo['code'] = array(
				'heading' => 'Code Documents',
				'info' => "By default, and for security, web code documents are excluded from file displays. If you have a directory or attachment page with some code docs that you want to include in your display, you can choose to include them along with any/all other file types. Code file types excluded by default are: ".implode(', ', $get->codexts).". The one exception is index.htm/l and index.php files, which are always excluded, and will not be included if Code Docs are enabled."
			);			
			$optioninfo['only'] = array(
				'heading' => 'Show Only Specific',
				'info' => "If you'd like, you can enter a comma-separated list of filenames and/or file extensions here. Doing this will filter out anything not here entered. Do not use quotation marks. Just separate each item with a comma. <br /><br />Example: <br /><br /><code>My Polished Essay, .mp3, Gertrude Stein Essay, .jpg</code><br /><br />This will tell the shortcode only to ouput files that have the string 'My Polished Essay' or 'Gertrude Stein Essay', and any file with the extension .mp3 or .jpg"
			);			
			$optioninfo['exclude'] = array(
				'heading' => 'Exclude Specific',
				'info' => "Here you can enter a comma-separated list of filenames or file extensions to exclude from your list. Example: <br /><br /><code>.doc, .ppt, My Unfinished Draft Essay, Embarrassing Photo Name</code> <br /><br />This will exclude all .doc and .ppt files from your list, as well as your ugly first draft and that photo of you after that party."
			);
			$optioninfo['include'] = array(
				'heading' => 'Include Specific',
				'info' => "This option also takes a comma-separated list of files or file extensions, but it is primarily for correcting / fine tuning. For instance, if you excluded '.doc' in the above field, you may want to include '.docx' here, so it isn't filtered out, if that's your fancy."
			);						
			$optioninfo['action'] = array(
				'heading' => 'File Type Action',
				'info' => "If you specify any file types or file groups, the action you select here will determine whether the specified file types are prohibited, or the only permitted file types. If left blank, the default option will be permit."
			);			
			$optioninfo['filetypes'] = array(
				'heading' => 'File Types',
				'info' => "This option takes a comma-separated list of file extensions (do not precede the extension with a period). These file types will be either permitted or prohibited, depending on the action you select. If you also specify file groups, the file types associated with the selected groups will be added to the list here."
			);			
			$filegroups = '';
			foreach($get->filegroups as $group => $discard)
			{
				if($group == 'unknown') continue;
				$filegroups .= '<span style="color:red;">'.$group.':</span> ['.implode(', ', $get->filegroups[$group][2]).']<br>';
			}
			$optioninfo['filegroups'] = array(
				'heading' => 'File Type Groups',
				'info' => "You may select multiple groups from the list of available file groups. All file types associated with the selected file groups will be either permitted or prohibited, depending on the action you select. If you also specify a list of individual file types, they will be added to the list here.<br /><br />$filegroups"
			);			
			$optioninfo['heading'] = array(
				'heading' => 'Heading',
				'info' => "Optional: Give your list or table a nice title."
			);			
			$optioninfo['hcolor'] = array(
				'heading' => 'Heading Color',
				'info' => "Defaults to random color if left blank."
			);			
			$optioninfo['single'] = array(
				'heading' => 'Single or Multiple Uploads',
				'info' => "Optional: If left blank, will default to multiple. If single is selected, a user may only upload one file at a time."
			);			
			$optioninfo['align'] = array(
				'heading' => 'Alignment',
				'info' => "Use in combination with the width setting to float your upload form to the left or right of the page, to allow other page content to wrap around it. Choose 'None' to prevent wrapping. For lists and tables, defaults to 'Left.' For File-Up shortcodes, defaults to 'None.'"
			);			
			$optioninfo['size'] = array(
				'heading' => 'File Size',
				'info' => "Will show the file size by default if left blank. In tables, you'll be able to sort by file size."
			);			
			$optioninfo['corners'] = array(
				'heading' => 'Corners',
				'info' => "Defaults to all corners rounded if not used. Does not apply to the minimal-list style, or to tables."
			);			
			$optioninfo['mod'] = array(
				'heading' => 'Date Modified',
				'info' => "If left blank, will show by default in tables, as a sortable column, and will hide by default in lists. (Note: This option is not available for Post / Page Attachments.)"
			);			
			$optioninfo['bulkdownload'] = array(
				'heading' => 'Bulk Download',
				'info' => "If enabled, users will be able to select specific files, or select all files, in a table, then click on the download button at the bottom of the table in order to download a zip file containing their selections. Note that Bulk Downloads are automatically enabled in Manager Mode, but can be enabled here for any other table type (regular, recursive, directory tree, or audio playback). Default: Disabled."
			);			
			$optioninfo['recursive'] = array(
				'heading' => 'Recursive Directory Iteration',
				'info' => "If disabled (the default), only the files in the single directory specified will be displayed. If enabled, the files from all subdirectories will be displayed as well. If Directory Tree mode is enabled, Recursive Directory Iteration will be disabled."
			);			
			$optioninfo['directories'] = array(
				'heading' => 'Directory Tree Mode',
				'info' => "If disabled (the default), your File Away table will display only the single directory specified in your Base and Sub attributes. If Directory Tree mode is enabled, the directory specified will be the starting-off point, but the user will be able to navigate through any subsequent directories as well. It is recommended that you use this mode in conjunction with the File Away iframe shortcode (see instructions under that shortcode option)."
			);			
			$optioninfo['manager'] = array(
				'heading' => 'Manager Mode',
				'info' => "If enabled, users with access privileges will be able to manage files from the front-end. Users without access privileges will still see the table, but the management features will not be output to the page. Manager Mode currently includes the ability to rename and delete files individually, and to copy, move, and delete files in bulk.<br /><br />If custom columns are included in the table, the Rename feature will provide additional fields for each visible custom column, and will automatically format the filename for use with File Away custom columns.<br /><br />See the Manager Mode tab on the File Away options page to set access privileges and/or use the Manager Mode options below to fine tune privileges on a per-shortcode basis. If Manager Mode is enabled, Directory Tree Mode will also be enabled automatically. Default: Disabled."
			);			
			$optioninfo['role_override'] = array(
				'heading' => 'Manager Mode: User Role Access Override',
				'info' => "If the Override Password is provided in the password field, and it matches the Override Password established in the File Away Options page, then any user roles specified here (in addition to the user roles set in the permanent settings) will have Manager Mode privileges for this shortcode only. Enter a comma-separated list of user roles, like so: <code>author,subscriber,townidiot</code>.<br /><br />Alternatively, in place of specifying actual roles, you can elect to enter the dynamic code: <code>fa-userrole</code> into the Role Access Override field. Be aware that doing this will effectively grant Manager Mode access to all logged in users. Thus, the dynamic role code should only be used on File Away tables where the directory paths are also dynamic. This will grant users access to rename, copy, move, and delete files within the confines of their of own subdirectories."
			);			
			$optioninfo['dirman_access'] = array(
				'heading' => 'Manager Mode: Directory Management Access',
				'info' => "If left blank, all users otherwise able to access manager mode will have the ability to create/delete/rename sub-directories of the established parent directory. If you wish to limit access to sub-directory management, include a comma-separated list of user roles here. Only those roles listed here will have access to directory management."
			);			
			$optioninfo['user_override'] = array(
				'heading' => 'Manager Mode: User Access Override',
				'info' => "If the Override Password is provided in the password field, and it matches the Override Password established in the File Away Options page, then any user IDs specified here (in addition to the users set in the permanent settings) will have Manager Mode privileges, for this shortcode only. Enter a comma-separated list of user IDs, like so: <code>20,217,219</code>.<br /><br />Alternatively, in place of specifying actual user IDs, you can elect to enter the dynamic code: <code>fa-userid</code> into the User Access Override field. Be aware that doing this will effectively grant Manager Mode access to all logged in users. Thus, the dynamic user ID code should only be used on File Away tables where the directory paths are also dynamic. This will grant users access to rename, copy, move, and delete files within the confines of their of own subdirectories."
			);			
			$optioninfo['drawericon'] = array(
				'heading' => 'Directory Icon',
				'info' => "The icon used for directories in Directory Tree mode. Default: Drawer."
			);			
			$optioninfo['drawerlabel'] = array(
				'heading' => 'Directory Column Label',
				'info' => "The column heading for the Directory Names and File Names. Default: Drawer/File."
			);			
			$optioninfo['excludedirs'] = array(
				'heading' => 'Exclude Directories',
				'info' => "In addition to any permanent directory exclusions specified on the File Away Options config tab, here you can include a comma-separated list of directory names you wish to exclude from this specific Directory Tree table or Recursive table/list. Do not include the forward slashes ('/'). The names listed here must match your directory names exactly, and are case-sensitive. Example:<br /><br /><code>My Private Files, Weird_Server_Directory_Name, etc.</code>"
			);			
			$optioninfo['onlydirs'] = array(
				'heading' => 'Only These Directories',
				'info' => "For your Directory Tree tables or Recursive tables/lists, here you can specify a comma-separated list of the only directory names you want to include in this table. All other sibling directories will be excluded. These directories must be found in the parent directory to which your shortcode is pointing (ie, your Base Directory and Sub Directory shortcode settings).<br /><br />Note: If you specify a directory 'My Files,' any subdirectories of 'My Files' will also be included. Example:<br /><br /><code>My Public Files, Public Records, etc.</code>"
			);			
			$optioninfo['playback'] = array(
				'heading' => 'Audio Playback',
				'info' => "Please read these notes carefully:<br /><br />You have two activation options: compact, and extended. Compact will put a small play/stop button in your filetype column. Extended will put a full-featured audio controller, with play/pause, draggable progress bar, track time, and volume, in your filename column.<br /><br />The audio player is compatible with mp3, ogg, and wav. If any of those file types are found, the player will be added to the column. Note that if you have multiple types with the same filename, then only one will show in the table, and the other file types will be added to the player as fallbacks for greater cross-browser compatibility. For instance: <br /><br />'My Song.mp3', 'My Song.ogg', and 'My Song.wav' will only show once on the table, but each file will be nested in the audio player as fallbacks for each other. If you only have one or two of those types in the directory, then only those found will be added to the player. One is sufficient. <br /><br />Note that any other audio file types that have the same filename will appear as download links under the File Name in the File Name column. (See <a class='inner-link' href='https://wordpress.org/plugins/file-away/screenshots/' target='_blank'>screenshots</a> for clarity.) For instance:<br /><br />If you have 'My Song.mp3', 'My Song.ogg', 'My Song.aiff', 'My Song.rx2' in the directory, then the mp3 and ogg files will be nested in the player, and each of the four matching audio files will be given their own download link in the second column, specifying their file type. The system searches for the following file types with matching file names, and will add them automatically: <code>".implode(', ', $get->filegroups['audio'][2])."</code><br /><br />If no mp3, ogg, or wav file exists for that file name, then the files will appear in the table as any other file type, with no audio player. <br /><br />Note that you can also place your sample/playback files (mp3, ogg, wav) in a separate directory from the downloadable files (any audio file type), and specify the playback file directory using the 'playbackpath' shortcode attribute. See the info link next to 'Playback Path' for more info on that.<br /><br />Finally, note that Audio Playback mode is compatible with regular tables, Directory Tree tables, and Recursive tables, but is not compatible with Manager Mode."
			);			
			$optioninfo['onlyaudio'] = array(
				'heading' => 'Audio Files Only',
				'info' => "Activate this option and only audio files will be shown in the table. Disabled, all otherwise-not-excluded files will be shown, but only audio files will get the playback button."
			);			
			$optioninfo['loopaudio'] = array(
				'heading' => 'Loop Audio',
				'info' => "Activate this option to play audio files in a continuous loop."
			);			
			$optioninfo['playbackpath'] = array(
				'heading' => 'Playback Path',
				'info' => "Optional. By default, the Playback system will search for mp3, ogg, and wav files in the directory specified by your Base Directory and Sub Directory shortcode attributes. If, however, you wish to store your playback files in a separate location from your download files, you can specify that location here. Rules:<br /><br />Do NOT include opening and closing forward slashes. Correct: <code>Files/Audio/Samples</code>. Incorrect: <code>/Files/Audio/Samples/</code><br /><br />Note: You must include the entire path beginning from your WordPress installation directory or site root. The Playback Path is ignorant of your specified base directory. So, let's say Base Directory 1 equals 'Files':<br /><br /><code>[fileaway base=\"1\" sub=\"Audio/Downloads\" playbackpath=\"Files/Audio/Samples\" playback=\"yes\"]</code><br /><br />If you have Directory Tree mode or Recursive mode enabled, you will probably want to be sure that your Playback folder is not a subdirectory of your Downloads folder.<br /><br />Finally, you can only specify one playback path for any given File Away table. It will not recurse into subdirectories looking for playback files."
			);			
			$optioninfo['playbacklabel'] = array(
				'heading' => 'Playback Column Label',
				'info' => "When Audio Playback is not enabled, this column heading is fixed to 'Type'. When compact Playback is enabled, you can specify a different column label if desired. E.g., 'Sample'"
			);	
			$optioninfo['encryption'] = array(
				'heading' => 'Encrypted Downloads',
				'info' => "Disabled by default. If enabled, download links will be encrypted and the file locations will be masked. Not compatible with Manager Mode. Not smart to use with Directory Tree Navigation (since the directories are plain to see anyway), or with Bulk Downloads (the file paths can be found in a data-attribute in the HTML of each table row), but fine with Recursive Mode and with Audio Playback."
			);					
			$optioninfo['orderby'] = array(
				'heading' => 'Order By',
				'info' => "Choose whether to order your page attachments by title, menu order, post id, date, date modified, or random."
			);			
			$optioninfo['desc'] = array(
				'heading' => 'Descending',
				'info' => "Omit for ascending order; 'Yes' for descending order."
			);			
			$optioninfo['s2skipconfirm'] = array(
				'heading' => 'S2Members Skip Confirmation',
				'info' => "Deactivates the javascript confirm dialogue on S2Member download links."
			);			
			$optioninfo['fixedlocation'] = array(
				'heading' => 'Upload Loations Options',
				'info' => "If set to fixed, the only upload directory will be the path you specify with the base+sub attributes. By default, a user will be able to select subdirectories of that specified path from a dropdown."
			);	
			$optioninfo['uploader'] = array(
				'heading' => 'Append Uploader Name to File Name',
				'info' => "If enabled and if the user is logged in, the user's display_name will be appended to the uploaded filename in File Away customdata format. In turn, you can display the uploader information in your File Away table using <code>[fileaway type=\"table\" customdata=\"Uploaded By\"]</code>"
			);						
			$optioninfo['uploadlabel'] = array(
				'heading' => 'Upload Label',
				'info' => "Change the text on the upload button."
			);			
			$optioninfo['thumbnails'] = array(
				'heading' => 'Image Thumbnails',
				'info' => "You have two options for jpg/jpeg, gif, and png thumbnails: transient and permanent. Transient requires resources every time the page loads, as it generates a thumbnail for each image, but only temporarily. It does it all over again the next time the page loads. Permanent will create a permanent thumbnail image the first time the page loads. The next time the page loads, if that thumbnail already exists, it doesn't have to create it again. Permanent thumbnails are prefixed by <code>_thumb_wd_</code> or <code>_thumb_sq_</code>, followed by the filename.<br /><br />Since transient thumbnails require more resources, there are other options to determine how to skip over images that are too large for your server to handle. See the info links for the Max Source Bytes, Max Source Width, and Max Source Height options that will appear below when the Transient option is selected."
			);			
			$optioninfo['thumbstyle'] = array(
				'heading' => 'Thumbnail Style',
				'info' => "The cropped dimensions and aesthetics of your generated thumbnails. The dimensions (wide/oval, square/circle) are fed into the server-side script that generates the thumbnails. The sharp/rounded specification is handled by the CSS on the client-side."
			);			
			$optioninfo['graythumbs'] = array(
				'heading' => 'Thumbnail Grayscale Filter',
				'info' => "If set to Grayscale, the css will apply a grayscale filter to your thumbnails for all browsers that can handle it."
			);			
			$optioninfo['maxsrcbytes'] = array(
				'heading' => 'Max Image Source Size in Bytes',
				'info' => "This setting applies to 'transient' thumbnails only. Default: <code>1887436.8</code> (i.e., 1.8M)<br /><br />If the pixel dimensions and/or filesize of your image are too large for your server to handle, the script will fail and return a broken image graphic in place of your thumbnail. To prevent this, we set the maximum size in bytes, maximum width in pixels, and maximum height in pixels, of the source image. If the source image is greater than any one of these, the filetype icon will be output instead of attempting to generate a thumbnail.<br /><br />Tweak these three settings to suit your server and find the right balance. Find the lowest threshold for an image where the server can easily handle generating the thumbnail, and set it there. <br /><br />You can also adjust your <code>memory_limit</code> setting in your php.ini file, but be very careful about making this limit too large, which might create other problems for you."
			);			
			$optioninfo['maxsrcwidth'] = array(
				'heading' => 'Max Image Source Width in Pixels',
				'info' => "This setting applies to 'transient' thumbnails only. Default: <code>3000</code><br /><br />If the pixel dimensions and/or filesize of your image are too large for your server to handle, the script will fail and return a broken image graphic in place of your thumbnail. To prevent this, we set the maximum size in bytes, maximum width in pixels, and maximum height in pixels, of the source image. If the source image is greater than any one of these, the filetype icon will be output instead of attempting to generate a thumbnail. <br /><br />Tweak these three settings to suit your server and find the right balance. Find the lowest threshold for an image where the server can easily handle generating the thumbnail, and set it there. <br /><br />You can also adjust your <code>memory_limit</code> setting in your php.ini file, but be very careful about making this limit too large, which might create other problems for you."
			);			
			$optioninfo['maxsrcheight'] = array(
				'heading' => 'Max Image Source Height in Pixels',
				'info' => "This setting applies to 'transient' thumbnails only. Default: <code>2500</code><br /><br />If the pixel dimensions and/or filesize of your image are too large for your server to handle, the script will fail and return a broken image graphic in place of your thumbnail. To prevent this, we set the maximum size in bytes, maximum width in pixels, and maximum height in pixels, of the source image. If the source image is greater than any one of these, the filetype icon will be output instead of attempting to generate a thumbnail. <br /><br />Tweak these three settings to suit your server and find the right balance. Find the lowest threshold for an image where the server can easily handle generating the thumbnail, and set it there. <br /><br />You can also adjust your <code>memory_limit</code> setting in your php.ini file, but be very careful about making this limit too large, which might create other problems for you."
			);
			$this->optioninfo = $optioninfo;
		}
		public function helplinks()
		{
			$helplinks = array();
			$helplinks['rootdirectory'] = array(
				'heading' => 'Set Root Directory',
				'info' => "If your WordPress URL and Site URL are one and the same, you can disregard this setting. If your WordPress installation is in a subdirectory of your domain root directory, this option is for you. Choose whether your absolute path is relative to the WordPress Installation directory (default), or the domain root directory.<br><br>Note: if you choose the latter, be sure to refresh the Config page after changes finish saving, so the abspath in your Base Directory options will be updated to reflect your selection."
			);
			$helplinks['exclusions'] = array(
				'heading' => 'Permanent Exclusions',
				'info' => "A comma-separated list of filenames and/or file extensions you wish to permanently exclude from all lists and tables. Be sure to include the dot ( . ) if it's a file extension. (Not case sensitive.) Example: <br /><br /><code>My File Name, .bat, .php, My Other File Name</code>"
			);
			$helplinks['direxclusions'] = array(
				'heading' => 'Exclude Directories',
				'info' => "A comma-separated list of directory names you wish to permanently exclude from all Directory Tree tables and Recursive tables/lists, and from Manager Mode Bulk Action Destination generators. Do not include the forward slashes (\"/\") Example: <br /><br /><code>My Private Files, Weird_Server_Directory_Name, etc.</code>"
			);
			$helplinks['newwindow'] = array(
				'heading' => 'New Window',
				'info' => "By default, all file links in lists and tables are download links. If you want certain file types to open in a new window instead (e.g., .pdf or image files), add a comma-separated list of file extensions here for the file types you want to open in a new window. Be sure to include the dot ( . ). ( Not case sensitive. ) Example: <br /><br /><code>.pdf, .jpg, .png, .gif, .mp3, .mp4</code><br /><br />Also be aware that most file types will not open in a browser window."
			);
			$helplinks['encryption_key'] = array(
				'heading' => 'Encryption Key',
				'info' => "For File Away shortcode encrypted downloads. Use the randomly generated key provided, or set your own secure key, at least 16 characters in length, using upper and lowercase letters and numbers.<br><br>Note: If you want to generate a new random key, delete the existing key, Save Changes, and refresh the page. A new key will be generated for you."
			);			
			$helplinks['modalaccess'] = array(
				'heading' => 'Modal Access',
				'info' => "By user capability, choose who has access to the shortcode generator modal, or disable it completely. <br><br>Default: edit_posts"
			);
			$helplinks['tmcerows'] = array(
				'heading' => 'Button Position',
				'info' => "Choose the position of the shortcode button on the TinyMCE panel. Default: Second Row"
			);
			$helplinks['adminstyle'] = array(
				'heading' => 'Admin Style',
				'info' => "Choose between classic (animated) or minimal admin style. Default: Classic."
			);
			$helplinks['loadusers'] = array(
				'heading' => 'Load Users',
				'info' => "Some websites have so many registered users (upwards of 20k, for instance) that loading all those users into dropdowns, or the Dynamic Paths table in the tutorial here, puts so much strain on their server that the File Away settings page cannot finish loading. Thus, by default, displaying lists of registered site users is disabled. If this isn't a problem for your setup, you can set Load Users to true."
			);
			$helplinks['stylesheet'] = array(
				'heading' => 'Stylesheet Placement',
				'info' => "Choose whether the stylesheet is enqueued in the header on all pages and posts, or in the footer only on pages and posts where any of the File Away shortcodes are used. For better performance, enqueuing to the footer is highly recommended, but if you are experiencing problems with the appearance of your displays on the page, try enqueuing to the header. <br><br>Default: Footer"
			);
			$helplinks['javascript'] = array(
				'heading' => 'Javascript Placement',
				'info' => "Choose whether the javascript is enqueued in the header on all pages and posts, or in the footer only on pages and posts where any of the File Away shortcodes are used. <br><br>Default: Header"
			);
			$helplinks['daymonth'] = array(
				'heading' => 'Date Display Format',
				'info' => "Choose whether the Date Modified column in sortable tables displays the month or the date first. Default: MM/DD/YYYY"
			);
			$helplinks['postidcolumn'] = array(
				'heading' => 'Post ID Column',
				'info' => "Enables/disables the custom Post ID column added to 'All Posts' and 'All Pages.' When enabled, provides easy reference when displaying attachments from a post or page other than your current one. Default: Enabled"
			);
			$helplinks['custom_list_classes'] = array(
				'heading' => 'Custom List Classes',
				'info' => "Add a comma-separated list of your custom list classes. It needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this:<br><br><code>classname1|Display Name 1, classname2|Display Name 2, classname3|Display Name 3</code>"
			);
			$helplinks['custom_table_classes'] = array(
				'heading' => 'Custom Table Classes',
				'info' => "Add a comma-separated list of your custom table classes. It needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this:<br><br><code>classname1|Display Name 1, classname2|Display Name 2, classname3|Display Name 3</code><br><br>In the stylesheet, all of your table class names must be prefixed by <code>ssfa-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.ssfa-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator."
			);
			$helplinks['custom_color_classes'] = array(
				'heading' => 'Custom Color Classes',
				'info' => "Add a comma-separated list of your custom primary color classes. The primary color class affects the color of the file name (not hovered), the icon color, and the header. Your list needs to include the class name (minus the <code>ssfa-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this (with your own color names of course):<br><br><code>turquoise|Turquoise, thistle|Thistle, salamander-orange|Salamander Orange</code><br><br>In the stylesheet, all of your primary color class names must be prefixed by <code>ssfa-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.ssfa-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator."
			);
			$helplinks['custom_accent_classes'] = array(
				'heading' => 'Custom Accent Classes',
				'info' => "Add a comma-separated list of your custom accent color classes. The accent color class affects the color of the file name (on hover), the icon background color, and a few other little things. Your list needs to include the class name (minus the <code>accent-</code> prefix) and the display name for each comma-delimited class, and should look exactly like this (with your own color names of course):<br><br><code>turquoise|Turquoise, thistle|Thistle, salamander-orange|Salamander Orange</code><br><br>In the stylesheet, all of your accent color class names must be prefixed by <code>accent-</code>, but here you leave out the prefix. So, for instance, in the stylesheet it will look like this: <code>.accent-myclassname</code> but here it will look like this: <code>myclassname|My Display Name</code>. The shortcode will automatically add the prefix for you when you select your class in the shortcode generator."
			);
			$helplinks['custom_stylesheet'] = array(
				'heading' => 'Custom Stylesheet',
				'info' => "As an alternative to using the CSS editor here, you can create your own CSS file and drop it into the File Away Custom CSS directory here: <br><br><code>".WP_CONTENT_URL."/uploads/fileaway-custom-css</code><br><br>Then just enter the filename of the stylesheet into the custom stylesheet field.	<br><br>Keeping your custom stylesheet in the wp-content/uploads/fileaway-custom-css directory will ensure that your styles are never overwritten on plugin updates."
			);
			$helplinks['preserve_options'] = array(
				'heading' => 'Preserve on Uninstall',
				'info' => "Normally, your settings and custom CSS will be lost upon uninstallation of the plugin. Check this box to preserve your settings (i.e., if you plan to reinstall). Default: Preserve"
			);
			$helplinks['reset_options'] = array(
				'heading' => 'Reset to Defaults',
				'info' => "Warning: If you choose to reset on save, any custom CSS in the CSS editor will be erased. Might want to back it up before hitting save."
			);
			$helplinks['manager_role_access'] = array(
				'heading' => 'Manager Mode: Permanent User Role Access',
				'info' => "Specify which user roles will have access to Manager Mode on File Away tables. Manager mode allows users to rename and delete individual files, and to copy, move, and delete files in bulk. Only those with the roles specified here will have access to the Manager Mode settings on the shortcode generator modal (if they already have access to the modal) and actual access to Manager Mode on the front-end page. Site administrators will have access to manager mode regardless of the specifications set here. The settings here are permanent. Additional roles can be granted access on a per-shortcode basis (see the help link next to \"Override Password\" below).  <br><br>Default: Administrator"
			);
			$helplinks['manager_user_access'] = array(
				'heading' => 'Manager Mode: Permanent User Access',
				'info' => "A comma-separated list of user IDs. Specify which specific users will have access to Manager Mode on File Away tables. This setting should be used in case a specific user merits access to Manager Mode who does not have one of the user roles specified in the above setting. Manager mode allows users to rename and delete individual files, and to copy, move, and delete files in bulk. Individual users specified here will have access to the Manager Mode settings on the shortcode generator modal (if they already have access to the modal) and actual access to Manager Mode on the front-end page. The settings here are permanent. Additional users can be granted access on a per-shortcode basis (see the help link next to \"Override Password\" below). <br><br>Default: None"
			);
			$helplinks['managerpassword'] = array(
				'heading' => 'Manager Mode: Override Password',
				'info' => "Set an override password here, then use the password in your [fileaway] shortcode if you wish to grant front-end Manager Mode access to additional roles or individual users (by identifying their user_id) on a per-shortcode basis. Your File Away shortcode would need to look something like: <br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" role_override=\"author,subscriber\"]</code> or <br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" user_override=\"125,214\"]</code><br><br>In place of using actual roles or user ids in the override shortcode attributes, you can elect to use <code>fa-userrole</code> or <code>fa-userid</code> like this: <br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" role_override=\"fa-userrole\"]</code> or <br><br><code>[fileaway manager=\"on\" password=\"yourpassword\" user_override=\"fa-userid\"]</code><br><br> Be aware that doing this will effectively grant Manager Mode access to all logged in users. Thus, the dynamic role and user id codes should only be used on File Away tables where the directory paths are dynamic. This will grant users access to rename, copy, move, and delete files within the confines of their of own subdirectories. "
			);
			$this->helplinks = $helplinks;
		}
		public function tutorial($shortcode)
		{
			if(!$shortcode) return false;
			$atts = new fileaway_attributes;
			$array = $atts->shortcodes[$shortcode];
			$hastypes = isset($atts->shortcodes[$shortcode]['type']) ? true : false;
			$typeheader = $hastypes ? '<th>for&nbsp;type</th>' : null;
			$output = 
				'<table id="fileaway-table" class="fileaway-minimalist fileaway-left fileaway-attributes" style="display: table;">'.
					'<thead><tr>'.
						'<th class="fileaway-minimalist-first-column">attribute</th>'.
						$typeheader.
						'<th>acceptable&nbsp;values</th>'.
						'<th class="fileaway-minimalist-last-column">notes</th>'.
					'</tr></thead>'.
					'<tbody>';
			foreach($array as $key=>$a)
			{	
				$typecol = null;
				$values = array();
				if($hastypes)
				{
					$types = array();								
					if($key != 'type')
					{
						foreach($array[$key] as $type=>$ar)
						{ 
							if($type == 'default' || $type == 'options') continue;
							$types[] = $type;	
						}
						$typecol = '<td>'.implode(', ', $types).'</td>';									
						foreach($types as $type)
						{
							$opts = isset($array[$key][$type]['options']) && $array[$key][$type]['options']
								? $array[$key][$type]['options'] 
								: array('User Defined' => 1);
							$o = array();
							foreach($opts as $k=>$opt)
							{
								if($k == '')
								{ 
									$k = isset($array[$key][$type]['default']) 
										? $array[$key][$type]['default']
										: false;	
								}
								if($k) $o[] = $k;	
							}
							$values[] = 'For '.$type.'s:<br>'.implode(', ', $o);	
						}
						if(isset($values[1]) && isset($types[1]))
						{ 
							if(str_replace('For '.$types[0].'s:<br>', 'For '.$types[1].'s:<br>', $values[0]) === $values[1])
								$values = array(str_replace('For '.$types[0].'s:<br>', '', $values[0]));
						}
						elseif(isset($types[0]))
							$values = array(str_replace('For '.$types[0].'s:<br>', '', $values[0]));
					}
					else 
					{
						foreach($array['type']['options'] as $k=>$v) $types[] = $k == '' ? $array['type']['default'] : $k;
						$values[] = implode(', ', $types);
						$typecol = '<td></td>';
					}
				}
				else
				{
					$opts = isset($array[$key]['options']) && $array[$key]['options']
						? $array[$key]['options'] 
						: array('User Defined' => 1);
					$o = array();
					foreach($opts as $k=>$opt)
					{
						if($k == '')
						{ 
							$k = isset($array[$key]['default']) 
								? $array[$key]['default']
								: false;	
						}
						if($k) $o[] = $k;	
					}
					$values[] = implode(', ', $o);
				}
				$details = isset($this->optioninfo[$key]['info']) ? $this->optioninfo[$key]['info'] : null;
				$output .= 
					'<tr>'.
						'<td class="fileaway-minimalist-first-column">'.$key.'</td>'.
						$typecol.
						'<td>'.implode('<br><br>', $values).'</td>'.
						'<td class="fileaway-minimalist-last-column">'.$details.'</td>'.
					'</tr>';
			}
			$output .= '</tbody></table><br><br>';	
			return $output;
		}
	}
}