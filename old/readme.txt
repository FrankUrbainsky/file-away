=== File Away ===
Name: File Away
Contributors: thomstark
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2JHFN4UF23ARG
Version: 1.3
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 1.3
License: GPLv3
Tags: files, attachments, shortcodes, lists, tables, directory, file manager, custom css, formidable, forms, dynamic, dynamic paths

Display file download links from your server directories or page attachments in stylized lists or sortable data tables.


== Description ==
Display file download links from your server directories or page attachments in stylized lists or sortable data tables. Construct shortcodes manually or using a point and click UI. Easily create dynamic paths to show different content to different logged-in users.


= Features =

* Display files from your server directories or post/page attachments in stylized lists or sortable data tables with one of two powerful shortcodes.<br><br>
* Two shortcodes with a combined total of 31 optional attributes to fine-tune the appearance and functionality of your lists and tables. <br><br>
* Easily create dynamic paths to display different files to an unlimited number of different logged-in users, using one or more of File Away's four dynamic paths codewords, all with a single shortcode instance.<br><br>
* Formidable Pro users can easily create dynamic paths in Formidable custom displays using Formidable shortcodes inside the File Away shortcode.<br><br>
* Powered by the Emergency's Foo Table, your tables are sortable by column, searchable, and have the option to turn on pagination for large tables. <br><br>
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

[fileaway] [attachaway]

All attributes optional:

* type = list|table 
<br>(default: list)<br><br>
* base = 1|2|3|4|5 
<br>(for file directory shortcode; configured on options page; default: 1)<br><br>
* sub = user defined path extension<br>
(for file directory shortcode)<br><br>
* postid = user defined post id number 
<br>(for attachment shortcode; default: current page)<br><br>
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
* customdata = user defined column heading for directory file tables 
<br>(then easily add customdata to invidual files to go in this column)<br><br>
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










== Changelog ==
= 1.3 =
* Checked compat with WP 3.8.1 - still kicking.
* Fixed issue with WP installations whose WP url and Site url are different.
* Added three new shortcode attributes: 'showto' & 'hidefrom' take comma-separated lists of user roles, and restrict viewing access to the file display based on the logged-in user's role, while 'nolinks=true' disables the hypertext reference portion of the <a> tag, if, for instance, you want to display successful uploads but not provide links to the uploaded files. 
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

= 1.3 = 
Important update: fixed issue with WP Url vs. Site Url, and added three new shortcode attributes. 

= 1.2 =
Important update: added ability to choose by which column to sort on initial page load (for tables).

= 1.1 =
Important update: moved custom css folder to wp-content/uploads, for better security.