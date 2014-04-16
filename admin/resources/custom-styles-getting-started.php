<?php 
$ind1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind3 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind4 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$ind5 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';														
echo '
<p><dl class="accordion">
	<dt><label>Getting Started</label></dt>
	<dd style="display:none;">
		<dl class="accordion-secondary">
			<dt><label>Initial Note</label></dt>
			<dd style="display:none;">
			In the CSS editor or your custom stylesheet, all your custom classes need to be prefixed with <code>ssfa-</code>, with the exception of custom accent colors, which need to be prefixed with <code>accent-</code>. But when you add your comma-separated list of classes to the Custom Classes text-fields below, you\'ll leave out the prefix, because the shortcode will add it for you. So in the stylesheet, it will look like this: <code>ssfa-yourstyle</code>, <code>ssfa-yourcolor</code>, or <code>accent-yourcolor</code>. But in the text fields, <code>yourstyle|Display Name</code>, <code>yourcolor|Display Name</code>, <code>youraccentcolor|Display Name</code> Adding this to the text fields will hook your new styles and colors into the shortcode generator modal. <br /><br />
			Below are some examples to get you moving: <br /><br />
			</dd>
			<dt><label>Custom List Styles</label></dt>
			<dd style="display:none;">
			First, <a id="boxed-in-css-classname-link" href="#" data-clipboard-text="boxed-in|Boxed-In,">grab this</a> and paste it into the "Custom List Classes" textfield below. Then, <a id="boxed-in-css-link" href="#" data-clipboard-target="boxed-in-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor below or into your own CSS document. Save your changes then head over to the shortcode modal and you\'ll find the "Boxed-In" style in the "Alphabetical List" category. To add another list style, just repeat the process and adjust the CSS to suit your tastes. 
			<textarea id="boxed-in-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once SSFA_ADMIN_RESOURCES.'boxed-in.php'; 
			echo '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("boxed-in-css-classname-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("boxed-in-css-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			</script>
			 <br /><br />
			 </dd>
			<dt><label>Custom Table Styles</label></dt>
			<dd style="display:none;">
			First, <a id="custom-table-classname-link" href="#" data-clipboard-text="yourtablestyle|Your Table Style Name,">grab this</a> and paste it into the "Custom Table Classes" textfield below, changing the class and display names to match the class you\'ll create. Then, <a id="custom-table-css-link" href="#" data-clipboard-target="custom-table-css" data-clipboard-text="Default clipboard text from attribute">grab this</a>, which is an exact duplicate of the "Minimalist" table style, and paste it into the CSS editor below or into your own CSS document. Remember to change every instance of <code>ssfa-yourtablestyle</code> to <code>ssfa-whatever-you-want</code>, leaving the prefix in tact. Adjust the CSS to create a new table style. To add another table style, just repeat the process. Make sure the classname in your CSS editor matches the classname entered into the "Custom Table Classes" field below (minus the <code>ssfa-</code> prefix of course), and if you create more than one, be sure to separate them with a comma: <code>yourclass1|Display Name 1, yourclass2|Display Name 2, etc.</code> 
			<textarea id="custom-table-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once SSFA_ADMIN_RESOURCES.'custom-table-style.php'; 
			echo '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-table-classname-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-table-css-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			</script>
			 <br /><br />
			</dd>
			<dt><label>Custom Primary Colors</label></dt>
			<dd style="display:none;">
			The primary colors aren\'t Blue, Red, and Yellow. They\'re the colors that affect your Headers and, in list styles, affect your link text and your icons. Adding new primary colors is a piece of cake. First, <a id="custom-color-classname-link" href="#" data-clipboard-text="yourcolor|Your Color Name,">grab this</a> and paste it into the "Custom Color Classes" textfield below, changing the class and display names to match the primary color class you\'ll create. Then, <a id="custom-color-css-link" href="#" data-clipboard-target="custom-color-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor below or into your own CSS document. Remember to change every instance of <code>ssfa-yourcolor</code> to <code>ssfa-whatever-you-want</code>, leaving the prefix in tact. This will hook your new color into the existing table and list styles. Then all you have to do is define a single color hex code and you\'re done! To add another color, just repeat the process. Make sure the classname in your CSS editor matches the classname entered into the "Custom Color Classes" field below (minus the <code>ssfa-</code> prefix of course), and if you create more than one, be sure to separate them with a comma: <code>yourclass1|Display Name 1, yourclass2|Display Name 2, etc.</code> For each Primary Color you create, you will also need to create a corresponding Accent Color... 
			<textarea id="custom-color-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once SSFA_ADMIN_RESOURCES.'custom-color-primary.php'; 
			echo '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-color-classname-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-color-css-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			</script>
			<br /><br />
			</dd>
			<dt><label>Custom Accent Colors</label></dt>
			<dd style="display:none;">
			In list styles, the accent colors affect your icon area backgrounds and a few other things. You will need to make matching accent colors for every primary color you make, and vice versa. The accent color will generally just be a lighter shade of the primary color. But don\'t worry. When you build your shortcode, you can choose non-matching Primary and Accent colors. But each color needs to have a matching color (with the same name), because if you choose not to specify a color or an accent color when building your shortcode, the shortcode will look for Primary and Accent colors with the same name.<br /><br /> First, <a id="custom-accent-classname-link" href="#" data-clipboard-text="yourcolor|Your Accent Name,">grab this</a> and paste it into the "Custom Accent Color Classes" textfield below, changing the class and display names to match the accent color class you\'ll create (minus the <code>accent-</code> prefix of course). Then, <a id="custom-accent-css-link" href="#" data-clipboard-target="custom-accent-css" data-clipboard-text="Default clipboard text from attribute">grab this</a> and paste it into the CSS editor below or into your own CSS document. Remember to change every instance of <code>accent-yourcolor</code> to <code>accent-whatever-you-want</code>, leaving the prefix in tact. This will hook your new accent color into the existing table and list styles. Then all you have to do is define one RGB color code, and one hex code and that\'s it.  
			<textarea id="custom-accent-css" cols="1" rows="1" disabled="disabled" style="display:none;">';
			include_once SSFA_ADMIN_RESOURCES.'custom-color-secondary.php'; 
			echo '</textarea>
			<script>
			var clip = new ZeroClipboard( document.getElementById("custom-accent-classname-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			var clip = new ZeroClipboard( document.getElementById("custom-accent-css-link"), 
				{moviePath: "'.SSFA_ADMIN_JS_URL.'ZeroClipboard.swf"});
				clip.on( "complete", function(client, args){alert("You grabbed it.");});
			</script>
			<br /><br />
			</dd>
			<dt><label>A Final Note About Structure</label></dt>
			<dd style="display:none;">
			You should be able to tell by looking at the CSS examples provided above, but just to make it clear, here is the fixed HTML structure for lists and tables. Any CSS you do has to work with (or around) this structure. Some of the classes only show up if certain options are selected in the shortcode generator, but we will show you where they are regardless. Anything in square brackets is variable. Text in blue is where you get to join the fray.<br /><br />
			For Alphabetical Lists: 
			<br /><br />
			<code>&lt;div id="ssfa-list-wrap" class="ssfa-[<font style="color:#0093d9; font-weight:bold;">your-list-style</font>] [ssfa-corners-style]"&gt;</code><br />
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
			<code>&lt;div id="ssfa-table-wrap" style="margin: 10px 0; [width:#; float:left|right; margin:#;]"&gt;</code><br />
				'.$ind1.'<code>[&lt;h3 class="ssfa-heading ssfa-[<font style="color:#0093d9; font-weight:bold;">your-color-class</font>]"&gt;</code><br />
					'.$ind2.'<code>&lt;div class="ssfa-search-wrap"&gt;</code><br />
						'.$ind3.'<code>&lt;span class="ssfa-searchicon" aria-hidden="true"&gt;&lt;/span&gt;</code><br />
						'.$ind3.'<code>&lt;input class="ssfa-searchfield" placeholder="SEARCH" name="search" id="search" type="text" /&gt;</code><br />
					'.$ind2.'<code>&lt;/div&gt;</code><br />
				'.$ind1.'<code>Heading Here&lt;/h3&gt;] </code><br />
				'.$ind1.'<code>&lt;table id="ssfa-table" class="footable ssfa-sortable ssfa-[<font style="color:#0093d9; font-weight:bold;">your-table-style</font>] ssfa-[left|right]"&gt;</code><br />	
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
		</dl>
	</dd>
</dl></p>';
?>