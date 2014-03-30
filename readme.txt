=== File Away ===
Name: File Away
Contributors: thomstark
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2JHFN4UF23ARG
Version: 1.7.5
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 1.7.5
License: GPLv3
Tags: files, attachments, shortcodes, lists, tables, directory, file manager, custom css, formidable, forms, dynamic, dynamic paths
Display file download links from your server directories or page attachments in stylized lists or sortable data tables.
== Description ==
Display file download links from your server directories or page attachments in stylized lists or sortable data tables. Construct shortcodes manually or using a point and click UI. Easily create dynamic paths to show different content to different logged-in users. Manage files securely from the front-end.
= Features =
* Display files from your server directories or post/page attachments in stylized lists or sortable data tables with one of two powerful shortcodes.<br><br>
* Two shortcodes with over 60 optional attributes to fine-tune the appearance and functionality of your lists and tables. <br><br>
* Optionally make File Away lists and tables recursive, showing all files in all subfolders starting from your specified base directory. <br><br>
* Optionally turn your File Away data table into a Directory Tree, to navigate through sub-directories beginning from your specified directory. <br><br>
* Optionally enable Mannager Mode, a secure front-end framework for renaming, copying, moving, and deleting files, individually or in bulk. Only specified users and/or user roles will have access to Manager Mode. Universal access settings can be overriden on a per-shortcode basis using a password set in the Admin area. <br><br>
* Manager Mode security features prevent backwards access to directories, and notifies the site administrator when someone makes an attempt to do so. Security measures are in place both on the client and server side. <br><br>
* With Directory Tree mode enabled, use the new [fileaframe] shortcode and the new File Away iFrame page template, to embed your Directory Tree table in a seamless iframe on your page, to allow navigation of server directories without refreshing the parent page, and to allow multiple tables on a page without interference. <br><br>
* Easily create dynamic paths to display different files to an unlimited number of different logged-in users, using one or more of File Away's four dynamic paths codewords, all with a single shortcode instance.<br><br>
* Display files recursively, or from only a single specified directory.
* Formidable Pro users can easily create dynamic paths in Formidable custom displays using Formidable shortcodes inside the File Away shortcode.<br><br>
* Powered by themergency's Foo Table, your tables are sortable by column, searchable, and have the option to turn on pagination for large tables. <br><br>
* Easily create custom columns in your tables to provide additional information about your files and attachments. <br><br>
* Build your shortcodes with a smooth point-and-click UI.<br><br>
* Use one of the built-in styles for your list or table, or easily create your own styles using the helpers and built-in CSS editor. <br><br>
* Use the built-in CSS editor, or create your own stylsheet and upload it to the custom-css directory. File Away will enqueue it for you, and backup and restore it on plugin updates.<br><br>
* Easily plug your custom styles and colors into the shortcode generator UI.<br><br>
* Save up to five Base Directories for quick reference when building your shortcodes. <br><br>
* Extend the base directory path with the optional sub-directory attribute on a per-shortcode basis.<br><br>
* Precise control over inclusion and exclusion of specific files and file types on a global or per-shortcode basis. <br><br>
* Choose whether file links are download links or open in a new window per file type. <br><br>
* Adds a custom Post ID column to "All Pages" and "All Posts" for quick reference when pointing the attachments shortcode to a page other than the current page.<br><br>
* Choose whether to load the stylesheets and the Javascript in the header on all pages, or the footer only on necessary pages.<br><br>
* Activate the debug feature on a per-shortcode basis to help with troubleshooting path targets. <br><br>
* Automatically hides dynamic content from logged-out users.<br><br>
* No output when there are no files in the directory to display, so insert your dynamic paths shortcode, and worry about adding files to the directories at your own pace.<br><br>
* Control access to individual file/attachment displays by user role.<br><br>
* Disable link functionality, if desired. For instance, to display successful user uploads.<br><br>
* Choose by user capability who can see and use the shortcode generator UI.<br><br>
* Choose the location of the shortcode button on the TinyMCE panel.<br><br>
* Choose the date display format: MM/DD/YYYY or DD/MM/YYYY.<br><br>
* Comes with numerous tutorials and dozens of quick info links with modal window helpers for each feature and shortcode attribute.<br><br>
* Choose between file-type icons, paperclip icons, or no icons, on a per-shortcode basis. <br><br>
* In tables, choose by which column to sort on initial page load, either ascending or descending. <br><br>
* Icons are web font characters, so no extra image loading time.<br><br>
* Numerous other behind-the-scenes features. The shortcodes work to make your displays presentable and secure.<br><br>

= The Shortcodes = 
[fileaway] [attachaway] (oh and [fileaframe], which is its own thing)

* type = list|table 
<br>(default: list)<br><br>
* name = your-unique-table-name
<br>(for file away tables in conjunction with iframe shortcode — see help links etc.)<br><br>
* base = 1|2|3|4|5 
<br>(for file directory shortcode; configured on options page; default: 1)<br><br>
* sub = user defined path extension<br>
(for file directory shortcode)<br><br>
* postid = user defined post id number 
<br>(for attachment shortcode; default: current page)<br><br>
* recursive = ohglory 
<br>(for file directory shortcode, either list or table)<br><br>
* directories = hallelujah 
<br>(for file directory shortcode, tables only)<br><br>
* manager = whaaaaat 
<br>(for file away tables)<br><br>
* role_override = list of user roles
<br>(for file away tables with manager mode enabled, see help links and tutorial)<br><br>
* user_override = list of user IDs
<br>(for file away tables with manager mode enabled, see help links and tutorial)<br><br>
* password = special override password
<br>(for file away tables with manager mode enabled, see help links and tutorial)<br><br>
* heading = user defined title<br><br>
* hcolor = black|silver|red|blue|green|brown|orange|purple|pink|(custom) 
<br>(heading color; default: random)<br><br>
* color = black|silver|red|blue|green|brown|orange|purple|pink|(custom) 
<br>(link color for lists only; default: random)<br><br>
* accent = black|silver|red|blue|green|brown|orange|purple|pink|(custom) 
<br>(accent color for lists only; default: matched)<br><br>
* iconcolor = black|silver|red|blue|green|brown|orange|purple|pink|(custom) 
<br>(for lists only; default: random)<br><br>
* style = minimalist|silver-bullet|(custom) or minimal-list|silk|(custom) 
<br>(default: minimalist/minimal-list)<br><br>
* display = inline|2col 
<br>(for lists only; default: vertical)<br><br>
* corners = sharp|roundtop|roundbottom|roundleft|roundright|elliptical 
<br>(for lists only; default: all round)<br><br>
* width = user defined integer 
<br>(default for lists: auto, default for tables: 100)<br><br>
* perpx = %|px 
<br>(width type; default: %)<br><br>
* align = left|right|none 
<br>(default: left)<br><br>
* textalign = left|center|right 
<br>(for tables only; default: center)<br><br>
* icons = paperclip|none 
<br>(default: file-type)<br><br>
* mod = yes|no 
<br>(for file directory shortcode; shows date modified; default for lists: no, default for tables: yes)<br><br>
* size = no 
<br>(shows file size; default: yes)<br><br>
* images = only|none 
<br>(default: include with other types)<br><br>
* code = yes 
<br>(regarding code file types; default: exclude)<br><br>
* only = user defined list of filenames or extensions, all else will be excluded<br><br>
* exclude = user defined list of filenames or extensions to exclude<br><br>
* include = user defined list of filenames or extensions to include 
<br>(overrides excludes for fine-tuning)<br><br>
* showto = user defined list of user roles, only those with a role specified will see display<br><br>
* hidefrom = user defined list of user roles, none of those with a role specified will see display<br><br>
* paginate = yes 
<br>(turns on pagination for tables; default: no)<br><br>
* pagesize = user defined integer 
<br>(number of files to display per table page; default: 15)<br><br>
* search = no 
<br>(show/hide the search bar for tables; default: yes)<br><br>
* customdata = user defined column heading(s) for directory file tables 
<br>(then easily add customdata to invidual files to go in these columns)<br><br>
* capcolumn = user defined column heading for attachments tables 
<br>(then data is pulled from attachment's caption)<br><br>
* descolumn = user defined column heading for attachments tables 
<br>(then data is pulled from attachment's description)<br><br>
* sortfirst = type | type-desc | filename | filename-desc | size | size-desc | mod | mod-desc | custom | custom-desc | caption | caption-desc | description | description-desc 
<br>(for tables only; default: filename)<br><br>
* nolinks = true | false
<br>(for file directory shortcode; disables link functionality while still displaying the file list)<br><br>
* debug = on 
<br>(shows path or post to which shortcode is pointing; default: off)<br><br>

= Requirements =
* PHP 5.3+
* WordPress 3.5+

== Installation ==
1. Upload 'file-away/' to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the provided shortcode generator and use the codes on your pages, posts, widgets, etc.

== Screenshots ==
01. The File Away menu can be found below the Settings menu on the Admin panel. Begin by configuring your Base Directories.
02. Set permissions, enable/disable some options, choose where to enqueue the CSS and Javascript, etc.
03. Easily create your own custom CSS styles for your lists and tables, using File Away's Custom Styles helpers and the built-in CSS editor, or create your own stylesheet and File Away will enqueue it for you.
04. Here you can reset all your settings to their defaults (be careful with this!), or choose whether to preserve or delete your settings when you uninstall the plugin.
05. A host of extensive tutorials for your reference.
06. The obligatory About page. Nothing to see here.
07. Info links on almost every setting field open up a modal window to give you a clear and detailed understanding of File Away's functionality.
08. The shortcode button on the TinyMCE Panel.
09. The shortcode generator opens up. Begin by selecting your shortcode and the type of display you want.
10. [fileaway] list type shortcode options
11. [fileaway] table type shortcode options
12. [attachaway] list type shortcode options
13. [attachaway] table type shortcode options
14. Info links next to every option open up a modal window to explain exactly what the option does and how you can get the most out of it.
15. A couple of Silk style lists.
16. Here's a Silk list with the Date Modified included.
17. A Minimalist style table: sortable, searchable, paginated.
18. A Silver Bullet style table: sortable, searchable, paginated.
19. Enter a search term in the search field (here: "png") and everything else gets filtered out of the table.
20. Use the File Away iFrame template with your [fileaway] table shortcode and directories enabled, then...
21. Use the [fileaframe] shortcode to embed your iframe-templated page into your parent page, for seamless navigation of your Directory Tree table with no parent-page refreshes and no conflicts with other File Away tables on the same page. 
22. The Manager Mode tab sets access privileges for the Manager Mode options on the Shortcode Generator, and for use of Manager Mode on the front-end.
23. With Directory Tree mode enabled, use the breadcrumbs at the top of the table to navigate backwards, and simply click on the directory name in the table to navigate forward. 
24. With Manager Mode, click at the bottom of the table to enable Bulk Action mode, then just click on the table rows to select the files you want to Copy, Move, or Delete in bulk. The specified action will be performed via Ajax, so no page refreshes. Just some entertaining success dialogs. 
25. Easily rename files right there on the table. If custom data columns are included on the table, File Away will add fields for each custom column present, and automatically format your file name for File Away Custom Data column display, as soon as you press Save. No page refreshes. 
26. See the new tutorial additions, under "Manager Mode," and of course check out all the new shortcode attributes under, well, "Shortcode Attributes."
27. Lots of new options as of version 1.7. 

== Frequently Asked Questions ==
= Does the File Away shortcode include Directory Tree navigation? =
Uh-huh.
= Does the File Away shortcode include subdirectories recursively? =
YES! 
= Are you going to make it so that the File Away shortcode includes subdirectories recursively? =
See above.
= When?!! =
As of version 1.5, some few minutes before the rapid contraction of the universe. 
= I installed the latest update and now the TinyMCE button has disappeared from my page editor. What gives? =
Yeah, that's a weird bug with WordPress's auto-update process that occurs sometimes. To fix, just download the plugin manually and install it via FTP or something.

== Changelog ==
= 1.7.5 =
* Minor update: Improved pretty foldernames/filenames by excluding most prepositions and conjunctions from capitalization.
= 1.7.4 =
* Bug Fixes: Manager Mode Copy/Move/Rename/Delete didn't work if source or destination directory had an apostrophe in it. Fixed.
= 1.7.3 =
* Gee Whiz. More bug fixes.
* Fixed the recursive mode, which was, well, broke.
* Fixed inconsistency in Bulk Action mode Destination Directory generator.
* All important stuff, folks. 
* Sigh.
= 1.7.2 =
* Fixed: Directory Tree Navigation was not compatible with WP permalink structure. Now is.
* Fixed: Some general php warnings and notices.
* Please let me know when you find a bug!
= 1.7.1 =
* Important bug fixes in this update, and one item of improved functionality:
* Fixed: Ajax calls not working when scripts set to print to footer.
* Fixed: Manager mode editing functions not working when WordPress is installed in subdirectory of site url (i.e., when WP Site URL and WP Install URL are different).
* Fixed: Files not displaying when (see above).
* Improved: Bulk Action Destination Directory layout: changed label to display block for tables in a tight squeeze.
* New Feature: Select All/Clear All checkbox in Bulk Action Mode with Manager Mode on.
= 1.7 =
* So many big new things in this build, I decided to skip version 1.6 altogether! Please read all the juicy details below:
* First, what isn't here yet but is coming down the line: Front-End multi-file uploading to server directories. Front-End directory creation, directory renaming, directory cloning, directory moving, and directory deletion. Auto-generation of directories for site users, according to desired specifications in desired location. And a bunch more stuff I can't think of at the moment because I haven't slept in days. You're welcome. 
* Bad News: One or two updates ago, I added unlimited Custom Data columns to File Away tables, and told you to separate custom data with a semi-colon. Turns out Safari and sometimes other browsers truncate filenames after semi-colons upon file download. So we had to switch to plain-old comma separation. That means, in your filenames, any commas inside square brackets will be a division marker for custom column display. E.g.: "All-Along-the-Watchtower-[Bob-Dylan,John-Wesley-Harding,Columbia,1968].mp3" will correspond to [fileaway type=table customdata="Artist,Album,Label,Release"]. So anyway, sorry for the change, but we don't want filenames getting truncated on download, AND...
* Good News: Lots of new features, including renaming files on the front-end, with auto-formatting for File Away Custom Columns. I hope that makes up for it. 
* New Feature: Directory Trees. Turn your File Away data table into a Directory Tree for directory navigation. Set the start directory with a static directory name, or a dynamic path, and users will be able to navigate all subdirectories, but no parent directories. 
* Related New Feature: Exclude certain directories from Directory Tree tables, and from Manager Mode access, as a global setting on the File Away Options "Config" tab. 
* New Feature: File Away iFrame shortcode complete with auto-generated File Away iFrame page template, for use with Directory Tree tables, to allow navigation without refreshing the parent page, and to allow for multiple tables on the same page without interference.
* New Feature: Manager Mode. Set access rights according to specified user roles and/or user IDs, and those with privileges can access Manager Mode on the front-end, which allows for Ajax-powered file renaming, file deletion, and bulk file copying, moving, and deletion. Move files to another directory, watch as they disappear, then navigate to that directory and see them in their new home. No page refreshing necessary! 
* You can grant dynamic access to Manager Mode in conjunction with a dynamic path in your shortcode, to allow individual users to manage their own files in their own directories, with no access to others' files.
* Security measures on client and server side to prevent attempts to access directories outside a user's established purview. Attempts to manipulate files in restricted directories will log the user out, and the site administrator will be notified via email of the user's foolhearty nefarious activities. 
* Manager Mode destination directory generator (powered by Ajax) utilizes Chosen's jQuery autocomplete dropdown. Hundreds of directories in a single directory? No worries. Just start typing and watch the others disappear. 
* File renaming fields include jQuery-powered special-character restrictions. 
* Success, error, and confirmation dialogs brought to you by Alertify. 
* Improvement: When pagination is enabled on data tables, the page now scrolls smoothly to the top of the table when a new page is clicked. 
* Bug Fix: Last page number was not being added if only one file on the page. Fixed. 
* All new shortcode attributes updated on the Shortcode Generator modal, including the new [fileaframe] shortcode. 
* 8 new screenshots. 
* Other bug fixes and general improvements. I can't remember everything.
* Enjoy! Now I have to go back to my real job for a while.
= 1.5.1 = 
* Important Bug Fix: Fatal Error when calling two recursive directories on the same page. All better now. Please install this update. 
= 1.5 = 
* RECURSIVE DIRECTORY ITERATION IS HERE. Just add "recursive=ohjeezusitgoeson4ever" to your shortcode (or, I guess, "recursive=anything"), and the files from the specified directory, and all subdirectories, will be output by the shortcode. To disable, just leave the "recusrsive" attribute out of the shortcode.
* Also, bug fixes and some general improvements. Fixed bug with file type icons where file extensions were capitalized. Also fixed dumb bug with the pagesize field on the modal. And some other stuff.
* But Recursion! Infinite Recursion. 
= 1.4 = 
* Expanded Functionality: You can now add an unlimited number of Custom Columns to your File Away tables, using the same method as before. In the shortcode, using the customdata attribute, separate multiple column headings by comma. Then in your file names, inside the square brackets, separate the corresponding data sets by comma.<br><br>
Example Shortcode:<br>
[fileaway type=table customdata="Artist*, Album, Label, Year" sortfirst="custom"]<br>
The asterisk next to "Artist" indicates that sortfirst="custom" should apply to the "Artist" column.<br><br>
Example Filenames:<br>
  My Funny Valentine [Chet Baker, My Funny Valentine, Blue Note, 1994].mp3<br>
  So What [Miles Davis, Kind of Blue, Columbia, 1959].mp3<br>
  Birdland [Weather Report, Heavy Weather, Columbia, 1977].mp3<br><br><br>
Technically, the number of columns you can add is limited only by the size of your WordPress page, and that's really only an aesthetic limitation. 
= 1.3.2 = 
* Bux fixes: Fixed the showto= and hidefrom= attributes. Due to some really inexplicably dumb coding when I originally added this feature, it only worked for the first role in the list. So now I've replaced the really dumb code with some different code that, while not necessarily genius, at least does what it is supposed to do.
= 1.3.1 =
* Bug fixes: Fixed issue with files not displaying to logged out users. Fixed scandir error when using dynamic paths.
= 1.3 =
* Checked compat with WP 3.8.1 - still kicking.
* Fixed issue with WP installations whose WP url and Site url are different.
* Added three new shortcode attributes: 'showto' & 'hidefrom' take comma-separated lists of user roles, and restrict viewing access to the file display based on the logged-in user's role, while 'nolinks=true' disables the hypertext reference portion of the anchor tag, if, for instance, you want to display successful uploads but not provide links to the uploaded files. 
* Narcissism: fixed typo in About tab link to my IMDb page.
= 1.2 =
* Added new shortcode attribute: sortfirst -- Allows user to choose by which column to sort on initial page load (for tables only).
* Added global option on the Basic Configuration page: allows specification of specific file types to open in new window rather than the default download link behavior.
* Added links to two new plugins in the About page.
= 1.1 =
* Moved custom CSS folder from plugin directory to wp-content/uploads/fileaway-custom-css to ensure preservation of custom styles on plugin updates. Be sure to manually back up your custom stylesheet if you have one in the current custom-css folder. You won't ever have to do this again.
= 1.0 =
* Initial release

== Upgrade Notice ==
= 1.7.1 = 
Important bug fixes.
= 1.7 =
Important update: Just download it, man. You'll see.
= 1.5 = 
Important update: Recursive Directory Iteration has arrived! 
= 1.3 = 
Important update: fixed issue with WP Url vs. Site Url, and added three new shortcode attributes. 
= 1.2 =
Important update: added ability to choose by which column to sort on initial page load (for tables).
= 1.1 =
Important update: moved custom css folder to wp-content/uploads, for better security.