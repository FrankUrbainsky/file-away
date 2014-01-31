<?php

$limited		=	( SSFA_BASE1 !== '' && SSFA_BS1NAME !== '' ? false : true );
$table_classes	=	( SSFA_CUSTOM_TABLE_CLASSES === '' ? '' : preg_split( "/(,\s|,)/", preg_replace( '/\s+/', ' ', SSFA_CUSTOM_TABLE_CLASSES ) ) );
$list_classes	=	( SSFA_CUSTOM_LIST_CLASSES === '' ? '' : preg_split( "/(,\s|,)/", preg_replace( '/\s+/', ' ', SSFA_CUSTOM_LIST_CLASSES ) ) );
$color_classes	=	( SSFA_CUSTOM_COLOR_CLASSES === '' ? '' : preg_split( "/(,\s|,)/", preg_replace( '/\s+/', ' ', SSFA_CUSTOM_COLOR_CLASSES ) ) );
$accent_classes	=	( SSFA_CUSTOM_ACCENT_CLASSES === '' ? '' : preg_split( "/(,\s|,)/", preg_replace( '/\s+/', ' ', SSFA_CUSTOM_ACCENT_CLASSES ) ) );

function ssfa_custom_selections ( $classes ) {
	if ( $classes !== '' ) {
		foreach ( $classes as $class ) {
			list ( $classclass, $classname ) = preg_split ( "/(\|)/", $class );
			$classclass = trim ( $classclass, ' ' ); $classname = trim ( $classname, ' ' );
			echo ( $classclass !== '' ? "<option value='$classclass'>$classname</option>" : null );
		}
	}
}

function ssfa_helplink($class) {
	echo "<span class='link-ssfamodal-help-$class ssfamodal-helplink ssfa-helpinfo4'></span>"; }

function ssfa_helpmodal($id) {
	echo "<div id='ssfamodal-help-$id' class='ssfamodal-help-backdrop'>
		<div class='ssfamodal-help-content'><div class='ssfamodal-help-close ssfa-helpclose2'></div>"; }

function ssfa_baseselect($id) {
	echo '<select  id="ssfamodal-'.$id.'-base" class="select ssfamodal_base" name="base">
		<option value="">Base Directory</option>';
	if ( SSFA_BS1NAME !== '' && SSFA_BASE1 !== '' ) 
		echo '<option value="" style="font-style: italic; color: red;">'.SSFA_BS1NAME.'</option>';
	if ( SSFA_BS2NAME !== '' && SSFA_BASE2 !== '' )
		echo '<option value="2">'.SSFA_BS2NAME.'</option>';
	if ( SSFA_BS3NAME !== '' && SSFA_BASE3 !== '' )
		echo '<option value="3">'.SSFA_BS3NAME.'</option>';
	if ( SSFA_BS4NAME !== '' && SSFA_BASE4 !== '' )
		echo '<option value="4">'.SSFA_BS4NAME.'</option>';
	if ( SSFA_BS5NAME !== '' && SSFA_BASE5 !== '' )
		echo '<option value="5">'.SSFA_BS5NAME.'</option>';	
	echo '</select>';
}

function ssfa_inclusionselect ($id, $type){
	echo "<div class='ss".$id."amodal_option' style='display:inline-block;'>
	<select id='ss".$id."amodal-".$id.$type."-images' class='select ss".$id."amodal_images' name='images' style='width:75px;'>
	<option value=''>Images</option>
	<option value='' style='font-style: italic; color: red;'>Include</option>
	<option value='only'>Only</option>
	<option value='none'>Exclude</option>
	</select> 
	<select id='ss".$id."amodal-".$id.$type."-code' class='select ss".$id."amodal_code' name='code' style='width:82px;'>
	<option value=''>Code Docs</option>
	<option value='' style='font-style: italic; color: red;'>Exclude</option>
	<option value='yes'>Include</option>
	</select> ";
	ssfa_helplink('images-code'); 
	echo "</div>
	<div class='ss".$id."amodal_option' style='display:inline-block;'>
	<input type='text' placeholder='Show Only Specific' id='ss".$id."amodal-".$id.$type."-only' class='ss".$id."amodal_only' name='only' value='' /> ";
	ssfa_helplink('only');
	echo "</div>
	<div class='ss".$id."amodal_option' style='display:inline-block;'>
	<input type='text' placeholder='Exclude Specific' id='ss".$id."amodal-".$id.$type."-exclude' class='ss".$id."amodal_exclude' name='exclude' value='' /> ";
	ssfa_helplink('exclude');
	echo "</div>
	<div class='ss".$id."amodal_option' style='display:inline-block;'>
	<input type='text' placeholder='Include Specific' id='ss".$id."amodal-".$id.$type."-include' class='ss".$id."amodal_include' name='include' value='' /> ";
	ssfa_helplink('include');
	echo "</div>";	
}

function ssfa_colorselect ($id, $type, $ctype, $cname, $cclass) {
	$style = 	( $ctype === 'color' ? ' style=\'width:80px;\'' : 
				( $ctype === 'accent' ? ' style=\'width:77px;\'' : 
				( $ctype === 'iconcolor' ? ' style=\'width:77px;\'' : null ) ) );
	echo "<select id='ss".$id."amodal-".$id.$type."-".$ctype."' class='select ss".$id."amodal_".$ctype."' name='".$ctype."'".$style." disabled>
	<option value=''>".$cname."</option>
	<option value='' style='font-style: italic; color: red;'>"; echo ($ctype === 'accent' ? 'Matched' : 'Random' ); echo "</option>
	<option value='black'>Black</option>
	<option value='silver'>Silver</option>
	<option value='red'>Red</option>
	<option value='blue'>Blue</option>
	<option value='green'>Green</option>
	<option value='brown'>Brown</option>
	<option value='orange'>Orange</option>
	<option value='purple'>Purple</option>
	<option value='pink'>Pink</option>";
	ssfa_custom_selections ( $cclass ); 
	echo "</select>";
}

?>
<div id="ssfamodal-form"> 

<div style="float:right;"><?php if(current_user_can('manage_options')){ ?><a href="admin.php?page=file-away" target="_blank" class="ssfa-selectIt ssfa-config-options-modal" style="padding: 2px 15px;">Configure Options</a><?php } ?></div> 

<div id="ssfa-banner-anchor-wrap">
<div id="ssfa-banner">
<img src="<?php echo SSFA_IMAGES_URL.'fileaway_banner.png'; ?>" style="margin-left:5px; margin-right: 0px; position:relative; top:10px; width:425px;">
</div>
<div id="ssaa-banner">
<img src="<?php echo SSFA_IMAGES_URL.'attachaway_banner.png'; ?>" style="margin-left:5px; margin-right: 0px; position:relative; top:10px; width:425px;">
</div>
</div>
<br />
<table id="ssfamodal-table" class="form-table" style="width:100%;">
<tr><td>
<table style="width:100%;"><tr><td style="width: 30%; vertical-align: top;"> 
<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-shortcode-type" class="select ssfamodal_shortcode_type" name="shortcode-type">
<option value="null">Select Shortcode</option>
<option value="fileaway">Directory Files</option>
<option value="attachaway">Post/Page Attachments</option>
</select>
</div>
</td><td style="width: 30%; vertical-align: top;">
<div class="ssfamodal_option" style="display:inline-block; margin-left:1.5px;">
<select id="ssfamodal-type" class="select ssfamodal_type" name="type">
<option value="null">Select Type</option>
<option value="">Alphabetical List</option>
<option value="table">Sortable Data Table</option>
</select>

</div>
</td><td style="width: 30%; vertical-align: top;">
<div id="ssfamodal-submit-wrap" class="ssaamodal_option" style="display:inline-block; margin-left:2.5px;">
<input type="button" id="ssfamodal-submit" class="ssfa-selectIt" style="padding-left:0; padding-right:0; width:160px; margin-top:0; cursor:default;" value="Insert Shortcode" name="submit" disabled />
</div>
</td></tr></table>

<div id="ssfa-anchor-wrap">
<div id="ssfa-fileaway-list-toggle">

<!------------------------------------------------------- FILEAWAY LIST COLUMN 1 ------------------------------------------------------->

<?php if ( $limited ) { ?> 

<table><tr><td style="vertical-align: top;"> 
To use the Directory Files shortcode you need to assign at least the first base directory path and give it a display name. <a href="<?php echo get_admin_url ( ).'admin.php?page=file-away';?>" target="_blank">Get Started</a>
</td></tr></table>

<?php } else { ?> 

<table><tr><td style="width: 30%; vertical-align: top;"> 
<div class="ssfamodal_option" style="display:inline-block;">
<?php ssfa_baseselect('fl') ?>
 <!-- Do Not Remove This Space -->
<?php ssfa_helplink('base') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<input type="text" placeholder="Sub Directory" id="ssfamodal-fl-sub" class="ssfamodal_sub" name="sub" value="" />
<?php ssfa_helplink('sub') ?>
</div>

<?php ssfa_inclusionselect ('f', 'l') ?>

</td>

<!------------------------------------------------------- FILEAWAY LIST COLUMN 2 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">
<div class="ssfamodal_option" style="display:inline-block;">
<input type="text" placeholder="Heading" id="ssfamodal-fl-heading" class="ssfamodal_heading" name="heading" value="" />
<?php ssfa_helplink('heading') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('f', 'l', 'hcolor', 'Heading Color', $color_classes) ?>

<?php ssfa_helplink('hcolor') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block; margin-right:0px;">
<input type="text"  placeholder="Width" id="ssfamodal-fl-width" class="ssfamodal_width" name="width" value="" maxlength="4" size="4" style="width:80px;" />

<select id="ssfamodal-fl-perpx" class="select ssfamodal_perpx" name="perpx" style="width:77px;">
<option value="" style="font-style: italic; color: red;">%</option>
<option value="px">px</option>
</select>
<?php ssfa_helplink('width-perpx') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-align" class="select ssfamodal_align" name="align">
<option value="">Alignment</option>
<option value="" style="font-style: italic; color: red;">Left</option>
<option value="right">Right</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('align') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-size" class="select ssfamodal_size" name="size">
<option value="">File Size</option>
<option value="" style="font-style: italic; color: red;">Show</option>
<option value="no">Hide</option>
</select>
<?php ssfa_helplink('size') ?>
</div>

<div id="ssfa-mod" class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-mod" class="select ssfamodal_mod" name="mod">
<option value="">Date Modified</option>
<option value="no">Hide</option>
<option value="yes">Show</option>
</select>
<?php ssfa_helplink('mod') ?>
</div>

</td>

<!------------------------------------------------------- FILEAWAY LIST COLUMN 3 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">
<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-style" class="select ssfamodal_liststyle" name="style" disabled>
<option value="">Style</option>
<option value="" style="font-style: italic; color: red;">Minimal-List</option>
<option value="silk">Silk</option>
<?php ssfa_custom_selections ( $list_classes ); ?>
</select>
<?php ssfa_helplink('style') ?>
</div>

<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-corners" class="select ssfamodal_corners" name="corners" disabled>
<option value="">Corners</option>
<option value="" style="font-style: italic; color: red;">Rounded</option>
<option value="sharp">Sharp</option>
<option value="roundtop">Rounded Top</option>
<option value="roundbottom">Rounded Bottom</option>
<option value="roundleft">Rounded Left</option>
<option value="roundright">Rounded Right</option>
<option value="elliptical">Elliptical</option>
</select>
<?php ssfa_helplink('corners') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('f', 'l', 'color', 'Link Color', $color_classes) ?>

<?php ssfa_colorselect ('f', 'l', 'accent', 'Accent', $accent_classes) ?>

<?php ssfa_helplink('color-accent') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-icons" class="select ssfamodal_listicons" name="icons" style="width:80px;" disabled>
<option value="">Icons</option>
<option value="" style="font-style: italic; color: red;">File Type</option>
<option value="paperclip">Paperclip</option>
<option value="none">None</option>
</select>

<?php ssfa_colorselect ('f', 'l', 'iconcolor', 'Icon Color', $color_classes) ?>

<?php ssfa_helplink('icons-iconcolor') ?>
</div> 

<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-fl-display" class="select ssfamodal_display" name="display" disabled>
<option value="">Display</option>
<option value="" style="font-style: italic; color: red;">Vertical</option>
<option value="inline">Side-by-Side</option>
<option value="2col">Two Columns</option>
</select>
<?php ssfa_helplink('display') ?>
</div>

<div id="ssfa-table-debug" class="ssfamodal_option">
<select id="ssfamodal-fl-debug" class="select ssfamodal_debug" name="debug" style="margin-bottom:0!important;">
<option value="">Debug</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="on">On</option>
</select>
<?php ssfa_helplink('debug') ?>
</div>
</td></tr>
</table>

<?php } ?> 

</div>

<div id="ssfa-fileaway-table-toggle">

<!------------------------------------------------------- FILEAWAY TABLE COLUMN 1 ------------------------------------------------------->

<?php if ( $limited ) { ?> 

<table><tr><td style="vertical-align: top;"> 
To use the Directory Files shortcode you need to assign at least the first base directory path and give it a display name. <a href="<?php echo get_admin_url ( ).'admin.php?page=file-away';?>" target="_blank">Get Started</a>
</td></tr></table>

<?php } else { ?> 

<table><tr><td style="width: 30%; vertical-align: top;"> 
<div class="ssfamodal_option" style="display:inline-block;">
<?php ssfa_baseselect('ft') ?>
 <!-- Do Not Remove This Space -->
<?php ssfa_helplink('base') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<input type="text" placeholder="Sub Directory" id="ssfamodal-ft-sub" class="ssfamodal_sub" name="sub" value="" />
<?php ssfa_helplink('sub') ?>
</div>

<?php ssfa_inclusionselect ('f', 't') ?>

</td>

<!------------------------------------------------------- FILEAWAY TABLE COLUMN 2 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">
<div class="ssfamodal_option" style="display:inline-block;">
<input type="text" placeholder="Heading" id="ssfamodal-ft-heading" class="ssfamodal_heading" name="heading" value="" />
<?php ssfa_helplink('heading') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('f', 't', 'hcolor', 'Heading Color', $color_classes) ?>

<?php ssfa_helplink('hcolor') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block; margin-right:0px;">
<input type="text"  placeholder="Width" id="ssfamodal-ft-width" class="ssfamodal_width" name="width" value="" maxlength="4" size="4" style="width:80px;" />

<select id="ssfamodal-ft-perpx" class="select ssfamodal_perpx" name="perpx" style="width:77px;">
<option value="" style="font-style: italic; color: red;">%</option>
<option value="px">px</option>
</select>
<?php ssfa_helplink('width-perpx') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-align" class="select ssfamodal_align" name="align">
<option value="">Alignment</option>
<option value="" style="font-style: italic; color: red;">Left</option>
<option value="right">Right</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('align') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-size" class="select ssfamodal_size" name="size">
<option value="">File Size</option>
<option value="" style="font-style: italic; color: red;">Show</option>
<option value="no">Hide</option>
</select>
<?php ssfa_helplink('size') ?>
</div>

<div id="ssfa-mod" class="ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-mod" class="select ssfamodal_mod" name="mod">
<option value="">Date Modified</option>
<option value="no">Hide</option>
<option value="yes">Show</option>
</select>
<?php ssfa_helplink('mod') ?>
</div>

</td>

<!------------------------------------------------------- FILEAWAY TABLE COLUMN 3 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">
<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-style" class="select ssfamodal_tablestyle" name="style" disabled>
<option value="">Style</option>
<option value="" style="font-style: italic; color: red;">Minimalist</option>
<option value="silver-bullet">Silver Bullet</option>
<?php ssfa_custom_selections ( $table_classes ); ?>
</select>
<?php ssfa_helplink('style') ?>
</div>

<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-search" class="select ssfamodal_search" name="search" style="width:87px;" disabled>
<option value="">Filtering</option>
<option value="" style="font-style: italic; color: red;">On</option>
<option value="no">Off</option>
</select>

<select id="ssfamodal-ft-icons" class="select ssfamodal_tableicons" name="icons" style="width:70px;" disabled>
<option value="">Icons</option>
<option value="" style="font-style: italic; color: red;">File Type</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('search-icons') ?>
</div>

<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-paginate" class="select ssfamodal_paginate" name="paginate" style="width:82px" disabled>
<option value="">Paginate</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="yes">On</option>
</select>

<input type="text" placeholder="# per page" id="ssfamodal-ft-pagesize" class="ssfamodal_pagesize" name="pagesize" value="" maxlength="3" size="3" style="width:75px;" disabled />
<?php ssfa_helplink('paginate-pagesize') ?>
</div>

<div class="ssfa-types ssfamodal_option" style="display:inline-block;">
<select id="ssfamodal-ft-textalign" class="select ssfamodal_textalign" name="textalign" disabled>
<option value="">Text Alignment</option>
<option value="" style="font-style: italic; color: red;">Center</option>
<option value="left">Left</option>
<option value="right">Right</option>
</select>
<?php ssfa_helplink('textalign') ?>
</div>

<div class="ssfamodal_option" style="display:inline-block;">
<input type="text" placeholder="Custom Column Name" id="ssfamodal-ft-customdata" class="ssfamodal_customdata" name="customdata" value="" disabled />
<?php ssfa_helplink('customdata') ?>
</div>

<div id="ssfa-table-sortfirst" class="ssfamodal_option">
<select id="ssfamodal-ft-sortfirst" class="select ssfamodal_sortfirst" name="sortfirst">
<option value="">Initial Sort</option>
<option value="" style="font-style: italic; color: red;">Filename (Asc)</option>
<option value="filename-desc">Filename (Desc)</option>
<option value="type">File Type (Asc)</option>
<option value="type-desc">File Type (Desc)</option>
<option value="custom">Custom Column (Asc)</option>
<option value="custom-desc">Custom Column (Desc)</option>
<option value="mod">Date Modified (Asc)</option>
<option value="mod-desc">Date Modified (Desc)</option>
<option value="size">File Size (Asc)</option>
<option value="size-desc">File Size (Desc)</option>
</select>
<?php ssfa_helplink('sortfirst') ?>
</div>

<div id="ssfa-table-debug" class="ssfamodal_option">
<select id="ssfamodal-ft-debug" class="select ssfamodal_debug" name="debug" style="margin-bottom:0!important;">
<option value="">Debug</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="on">On</option>
</select>
<?php ssfa_helplink('debug') ?>
</div>
</td></tr>
</table>

<?php } ?> 

</div>
<div id="ssfa-attachaway-list-toggle">

<!------------------------------------------------------- ATTACHAWAY LIST COLUMN 1 ------------------------------------------------------->

<table>
<tr><td style="width: 30%; vertical-align: top;">

<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Post ID" id="ssaamodal-al-postid" class="ssaamodal_postid" name="postid" value="" style="width:45px;" /> <span style="font-size:10px; color:gray;">Optional</span>
<?php ssfa_helplink('postid') ?>
</div>

<?php ssfa_inclusionselect ('a', 'l') ?>

<div id="ssaa-list-debug" class="ssfamodal_option">
<select id="ssaamodal-al-debug" class="select ssaamodal_debug" name="debug" style="margin-bottom:0!important;">
<option value="">Debug</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="on">On</option>
</select>
<?php ssfa_helplink('debug') ?>
</div>

</td>

<!------------------------------------------------------- ATTACHAWAY LIST COLUMN 2 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">
<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Heading" id="ssaamodal-al-heading" class="ssaamodal_heading" name="heading" value="" />
<?php ssfa_helplink('heading') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('a', 'l', 'hcolor', 'Heading Color', $color_classes) ?>

<?php ssfa_helplink('hcolor') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block; margin-right:0px;">
<input type="text"  placeholder="Width" id="ssaamodal-al-width" class="ssaamodal_width" name="width" value="" maxlength="4" size="4" style="width:80px;" />

<select id="ssaamodal-al-perpx" class="select ssaamodal_perpx" name="perpx" style="width:77px;">
<option value="" style="font-style: italic; color: red;">%</option>
<option value="px">px</option>
</select>
<?php ssfa_helplink('width-perpx') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-align" class="select ssaamodal_align" name="align">
<option value="">Alignment</option>
<option value="" style="font-style: italic; color: red;">Left</option>
<option value="right">Right</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('align') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-size" class="select ssaamodal_size" name="size">
<option value="">File Size</option>
<option value="" style="font-style: italic; color: red;">Show</option>
<option value="no">Hide</option>
</select>
<?php ssfa_helplink('size') ?>
</div>

</td>

<!------------------------------------------------------- ATTACHAWAY LIST COLUMN 3 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-style" class="select ssaamodal_liststyle" name="style" disabled>
<option value="">Style</option>
<option value="" style="font-style: italic; color: red;">Minimal-List</option>
<option value="silk">Silk</option>
<?php ssfa_custom_selections ( $list_classes ); ?>
</select>
<?php ssfa_helplink('style') ?>
</div>

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-corners" class="select ssaamodal_corners" name="corners" disabled>
<option value="">Corners</option>
<option value="" style="font-style: italic; color: red;">Rounded</option>
<option value="sharp">Sharp</option>
<option value="roundtop">Rounded Top</option>
<option value="roundbottom">Rounded Bottom</option>
<option value="roundleft">Rounded Left</option>
<option value="roundright">Rounded Right</option>
<option value="elliptical">Elliptical</option>
</select>
<?php ssfa_helplink('corners') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('a', 'l', 'color', 'Link Color', $color_classes) ?>

<?php ssfa_colorselect ('a', 'l', 'accent', 'Accent', $accent_classes) ?>

<?php ssfa_helplink('color-accent') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-icons" class="select ssaamodal_listicons" name="icons" style="width:80px;" disabled>
<option value="">Icons</option>
<option value="" style="font-style: italic; color: red;">File Type</option>
<option value="paperclip">Paperclip</option>
<option value="none">None</option>
</select>

<?php ssfa_colorselect ('a', 'l', 'iconcolor', 'Icon Color', $color_classes) ?>

<?php ssfa_helplink('icons-iconcolor') ?>
</div> 

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-al-display" class="select ssaamodal_display" name="display" disabled>
<option value="">Display</option>
<option value="" style="font-style: italic; color: red;">Vertical</option>
<option value="inline">Side-by-Side</option>
<option value="2col">Two Columns</option>
</select>
<?php ssfa_helplink('display') ?>
</div>
</td></tr></table>

</div>
<div id="ssfa-attachaway-table-toggle">

<!------------------------------------------------------- ATTACHAWAY TABLE COLUMN 1 ------------------------------------------------------->

<table>
<tr><td style="width: 30%; vertical-align: top;">

<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Post ID" id="ssaamodal-at-postid" class="ssaamodal_postid" name="postid" value="" style="width:45px;" /> <span style="font-size:10px; color:gray;">Optional</span>
<?php ssfa_helplink('postid') ?>
</div>

<?php ssfa_inclusionselect ('a', 't') ?>

<div id="ssaa-table-debug" class="ssfamodal_option">
<select id="ssaamodal-at-debug" class="select ssaamodal_debug" name="debug" style="margin-bottom:0!important;">
<option value="">Debug</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="on">On</option>
</select>
<?php ssfa_helplink('debug') ?>
</div>

</td>

<!------------------------------------------------------- ATTACHAWAY TABLE COLUMN 2 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">

<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Heading" id="ssaamodal-at-heading" class="ssaamodal_heading" name="heading" value="" />
<?php ssfa_helplink('heading') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<?php ssfa_colorselect ('a', 't', 'hcolor', 'Heading Color', $color_classes) ?>

<?php ssfa_helplink('hcolor') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block; margin-right:0px;">
<input type="text"  placeholder="Width" id="ssaamodal-at-width" class="ssaamodal_width" name="width" value="" maxlength="4" size="4" style="width:80px;" />

<select id="ssaamodal-at-perpx" class="select ssaamodal_perpx" name="perpx" style="width:77px;">
<option value="" style="font-style: italic; color: red;">%</option>
<option value="px">px</option>
</select>
<?php ssfa_helplink('width-perpx') ?>
</div>


<div class="ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-align" class="select ssaamodal_align" name="align">
<option value="">Alignment</option>
<option value="" style="font-style: italic; color: red;">Left</option>
<option value="right">Right</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('align') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-size" class="select ssaamodal_size" name="size">
<option value="">File Size</option>
<option value="" style="font-style: italic; color: red;">Show</option>
<option value="no">Hide</option>
</select>
<?php ssfa_helplink('size') ?>
</div>

</td>

<!------------------------------------------------------- ATTACHAWAY TABLE COLUMN 3 ------------------------------------------------------->

<td style="width: 30%; vertical-align: top;">

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-style" class="select ssaamodal_tablestyle" name="style" disabled>
<option value="">Style</option>
<option value="" style="font-style: italic; color: red;">Minimalist</option>
<option value="silver-bullet">Silver Bullet</option>
<?php ssfa_custom_selections ( $table_classes ); ?>
</select>
<?php ssfa_helplink('style') ?>
</div>

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-search" class="select ssaamodal_search" name="search" style="width:87px;" disabled>
<option value="">Filtering</option>
<option value="" style="font-style: italic; color: red;">On</option>
<option value="no">Off</option>
</select>

<select id="ssaamodal-at-icons" class="select ssaamodal_tableicons" name="icons" style="width:70px;" disabled>
<option value="">Icons</option>
<option value="" style="font-style: italic; color: red;">File Type</option>
<option value="none">None</option>
</select>
<?php ssfa_helplink('search-icons') ?>
</div>

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-paginate" class="select ssaamodal_paginate" name="paginate" style="width:82px" disabled>
<option value="">Paginate</option>
<option value="" style="font-style: italic; color: red;">Off</option>
<option value="yes">On</option>
</select>

<input type="text" placeholder="# per page" id="ssaamodal-at-pagesize" class="ssaamodal_pagesize" name="pagesize" value="" maxlength="3" size="3" style="width:75px;" disabled />
<?php ssfa_helplink('paginate-pagesize') ?>
</div>

<div class="ssaa-types ssaamodal_option" style="display:inline-block;">
<select id="ssaamodal-at-textalign" class="select ssaamodal_textalign" name="textalign" disabled>
<option value="">Text Alignment</option>
<option value="" style="font-style: italic; color: red;">Center</option>
<option value="left">Left</option>
<option value="right">Right</option>
</select>
<?php ssfa_helplink('textalign') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Caption Column Name" id="ssaamodal-at-capcolumn" class="ssaamodal_capcolumn" name="capcolumn" value="" disabled />
<?php ssfa_helplink('capcolumn') ?>
</div>

<div class="ssaamodal_option" style="display:inline-block;">
<input type="text" placeholder="Description Column Name" id="ssaamodal-at-descolumn" class="ssaamodal_descolumn" name="descolumn" value="" disabled />
<?php ssfa_helplink('descolumn') ?>
</div>

<div id="ssaa-table-sortfirst" class="ssaa-types ssamodal_option">
<select id="ssaamodal-at-sortfirst" class="select ssaamodal_sortfirst" name="sortfirst" style="margin-bottom:0!important;">
<option value="">Initial Sort</option>
<option value="" style="font-style: italic; color: red;">Filename (Asc)</option>
<option value="filename-desc">Filename (Desc)</option>
<option value="type">File Type (Asc)</option>
<option value="type-desc">File Type (Desc)</option>
<option value="caption">Caption (Asc)</option>
<option value="caption-desc">Caption (Desc)</option>
<option value="description">Description (Asc)</option>
<option value="description-desc">Description (Desc)</option>
<option value="size">File Size (Asc)</option>
<option value="size-desc">File Size (Desc)</option>
</select>
<?php ssfa_helplink('sortfirst') ?>
</div>

</td></tr></table> 
</div>

</td></tr></table>
<br />
</div>

<script>
jQuery(function($) {

	function colorizeSelect(){
	    if($(this).prop('selectedIndex') === 0) $(this).addClass("empty");
	    else $(this).removeClass("empty")
	}
	$(".select").on('change keyup', colorizeSelect).change();

	$('#ssfamodal-type, #ssfamodal-shortcode-type').bind('change', function(event) {
		$("#ssfa-fileaway-list-toggle .select").addClass("empty");
		$("#ssfa-fileaway-table-toggle .select").addClass("empty");
		$("#ssfa-attachaway-list-toggle .select").addClass("empty");
		$("#ssfa-attachaway-table-toggle .select").addClass("empty");						
	});

	$('#ssfamodal-shortcode-type').bind('change', function(event) {
		var $st = $('#ssfamodal-shortcode-type').val(); 
		if($st == "null" || $st == 'fileaway'){
			$('#ssaa-banner').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});
			$('#ssfa-banner').delay( 1000 ).queue( function(next){ 
				$(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next(); 
			});
		}
		if($st == "attachaway"){
			$('#ssfa-banner').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});
			$('#ssaa-banner').delay( 1000 ).queue( function(next){
				$(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next();
			});
		}			 
 	});

	$('#ssfamodal-shortcode-type, #ssfamodal-type').bind('change', function(event) {
		var $sct = $('#ssfamodal-shortcode-type').val(); 
		var $t = $('#ssfamodal-type').val();		   

		if($sct == "null" || $t == 'null') {
			$('#ssfamodal-submit-wrap,\
				#ssfa-attachaway-table-toggle,\
				#ssfa-fileaway-list-toggle,\
				#ssfa-fileaway-table-toggle,\
				#ssfa-attachaway-list-toggle').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});

			$('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'});
				
			$('#ssfa-attachaway-table-toggle input:text,\
				#ssfa-attachaway-table-toggle select,\
				#ssfa-fileaway-list-toggle input:text,\
				#ssfa-fileaway-list-toggle select,\
				#ssfa-fileaway-table-toggle input:text,\
				#ssfa-fileaway-table-toggle select,\
				#ssfa-attachaway-list-toggle input:text,\
				#ssfa-attachaway-list-toggle select').val('').prop('selectedIndex',0).attr('disabled', 'disabled');
		}

        if($sct=="fileaway" && $t==""){
			$('#ssfamodal-submit-wrap,\
				#ssfa-fileaway-table-toggle,\
				#ssfa-attachaway-table-toggle,\
				#ssfa-attachaway-list-toggle').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});

			$('#ssfamodal-submit-wrap, #ssfa-fileaway-list-toggle').delay( 1000 )
				.queue( function(next){ $(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next(); });

			$('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'});
				
			$('#ssfa-fileaway-table-toggle input:text,\
				#ssfa-fileaway-table-toggle select,\
				#ssfa-attachaway-table-toggle input:text,\
				#ssfa-attachaway-table-toggle select,\
				#ssfa-attachaway-list-toggle input:text,\
				#ssfa-attachaway-list-toggle select').val('').prop('selectedIndex',0).attr('disabled', 'disabled');
				  
			$('#ssfamodal-submit-wrap input:button').removeAttr('disabled').css({cursor : 'pointer'});
			$('#ssfa-fileaway-list-toggle input:text,\
				#ssfa-fileaway-list-toggle select').removeAttr('disabled');
			$('#ssfamodal-fl-corners').prop('selectedIndex',0).attr('disabled', 'disabled');
		}
		
	    if($sct=="fileaway" && $t=="table"){
			$('#ssfamodal-submit-wrap,\
				#ssfa-fileaway-list-toggle,\
				#ssfa-attachaway-table-toggle,\
				#ssfa-attachaway-list-toggle').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});

			$('#ssfamodal-submit-wrap, #ssfa-fileaway-table-toggle').delay( 1000 )
				.queue( function(next){ $(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next(); });			  
					
			$('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'});
				
			$('#ssfa-fileaway-list-toggle input:text,\
			   #ssfa-fileaway-list-toggle select,\
			   #ssfa-attachaway-table-toggle input:text,\
			   #ssfa-attachaway-table-toggle select,\
			   #ssfa-attachaway-list-toggle input:text,\
			   #ssfa-attachaway-list-toggle select').val('').prop('selectedIndex',0).attr('disabled', 'disabled');
			  
			$('#ssfamodal-submit-wrap input:button').removeAttr('disabled').css({cursor : 'pointer'});
			$('#ssfa-fileaway-table-toggle input:text,\
			   #ssfa-fileaway-table-toggle select').removeAttr('disabled');
			$('#ssfamodal-ft-pagesize').val('').attr('disabled', 'disabled');				
		}

		if($sct=="attachaway" && $t==""){
			$('#ssfamodal-submit-wrap,\
				#ssfa-fileaway-table-toggle,\
				#ssfa-attachaway-table-toggle,\
				#ssfa-fileaway-list-toggle').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});

			$('#ssfamodal-submit-wrap, #ssfa-attachaway-list-toggle').delay( 1000 )
				.queue( function(next){ $(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next(); }); 		
					
			$('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'});
				
			$('#ssfa-fileaway-table-toggle input:text,\
			   #ssfa-fileaway-table-toggle select,\
			   #ssfa-attachaway-table-toggle input:text,\
			   #ssfa-attachaway-table-toggle select,\
			   #ssfa-fileaway-list-toggle input:text,\
			   #ssfa-fileaway-list-toggle select').val('').prop('selectedIndex',0).attr('disabled', 'disabled');

			$('#ssfamodal-submit-wrap input:button').removeAttr('disabled').css({cursor : 'pointer'});
			$('#ssfa-attachaway-list-toggle input:text,\
				#ssfa-attachaway-list-toggle select').removeAttr('disabled');
			$('#ssaamodal-al-corners').prop('selectedIndex',0).attr('disabled', 'disabled');
		}

		if($sct=="attachaway" && $t=="table"){
			$('#ssfamodal-submit-wrap,\
				#ssfa-fileaway-list-toggle,\
				#ssfa-fileaway-table-toggle,\
				#ssfa-attachaway-list-toggle').css({opacity : '0', 'z-index' : '-1', transition : 'all 1s ease-out'});

			$('#ssfamodal-submit-wrap, #ssfa-attachaway-table-toggle').delay( 1000 )
				.queue( function(next){ $(this).css({opacity : '1', 'z-index' : '1', transition : 'all 1s ease-in'}); next(); }); 				  
					
			$('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'});
				
			$('#ssfa-fileaway-list-toggle input:text,\
				#ssfa-fileaway-list-toggle select,\
				#ssfa-fileaway-table-toggle input:text,\
				#ssfa-fileaway-table-toggle select,\
				#ssfa-attachaway-list-toggle input:text,\
				#ssfa-attachaway-list-toggle select').val('').prop('selectedIndex',0).attr('disabled', 'disabled');
			  
			$('#ssfamodal-submit-wrap input:button').removeAttr('disabled').css({cursor : 'pointer'});
			$('#ssfa-attachaway-table-toggle input:text,\
				#ssfa-attachaway-table-toggle select').removeAttr('disabled');
			$('#ssaamodal-at-pagesize').val('').attr('disabled', 'disabled');				
		}
	});

	var $corners_al = $('#ssaamodal-al-corners'),
		$corners_fl = $('#ssfamodal-fl-corners'),
		$style_al = $('#ssaamodal-al-style');
		$style_fl = $('#ssfamodal-fl-style');	
		$pagination_at = $('#ssaamodal-at-paginate'),
		$pagination_ft = $('#ssfamodal-ft-paginate'),
		$pagenum_at = $('#ssaamodal-at-pagesize');
		$pagenum_ft = $('#ssfamodal-ft-pagesize');	
	
	$style_al.change(function(){
	   	if ($style_al.val() !== '') {
	       	$corners_al.removeAttr('disabled');
		} else {
			$corners_al.attr('disabled', 'disabled').val('');
		}
	}).trigger('change');	

	$style_fl.change(function() {	
		if ($style_fl.val() !== '') {
			$corners_fl.removeAttr('disabled');
		} else {
			$corners_fl.attr('disabled', 'disabled').val('');
		}	
	}).trigger('change');

	$pagination_at.change(function() {
		if ($pagination_at.val() !== '') {
			$pagenum_at.removeAttr('disabled');
		} else {
			$pagenum_at.attr('disabled', 'disabled').val('');
		}
	}).trigger('change');

	$pagination_ft.change(function() {
		if ($pagination_ft.val() !== '') {
			$pagenum_ft.removeAttr('disabled');
		} else {
			$pagenum_ft.attr('disabled', 'disabled').val('');
		}			
	}).trigger('change');

	var	con = $('.ssfamodal-help-content'),
		wba = $('.better-attachments'),
		fao = $('.feature-options');									
	$('div[id^=ssfamodal-help-]').each(function() {
		var sfx = this.id,
			mdl = $(this),
			cls = $('.ssfamodal-help-close'),			
			lnk = $('.link-' + sfx);
		lnk.click(function(){
			mdl.fadeIn('fast');
		});
		mdl.click(function() {
			mdl.fadeOut('fast');
		});
		cls.click(function(){
			mdl.fadeOut('fast');
		});
	});
		con.click(function() {
			return false;
		});
		wba.click(function() {
			window.open('http://wordpress.org/plugins/wp-better-attachments/', '_blank');
		});
		fao.click(function() {
			window.open('admin.php?page=file-away#options', '_blank');
		});				

});
</script>

<?php ssfa_helpmodal('base'); ?>
<h4>Base Directory</h4>
Begin with one of the base directories you set up in the Configuration page. You can extend this path using the Sub Directory option.
<br />
<br />
Defaults to the first option if left blank.
</div></div>

<?php ssfa_helpmodal('sub'); ?>
<h4>Sub Directory</h4>
Optional: Define a sub-directory to extend the path of your selected base directory. It can be one or more levels deep. You can leave out leading and trailing slashes. I.e., <code>uploads/2010</code> rather than <code>/uploads/2010/</code>
<br />
<br />
You can also use one or more of the four dynamic path codes: <code>fa-firstlast</code> <code>fa-userid</code> <code>fa-username</code> and <code>fa-userrole</code>. If you've created directories that are named for your users' first and last names (e.g., jackhandy), userid (e.g., 15), username (e.g., admin), or user role (e.g., subscriber), the codes will dynamically point whoever is logged in to their appropriate folder. The directories you create for your users must be all lowercase with no spaces. If the username is 'JoanJett,' the directory should be: <code>joanjett</code>
<br />
<br />
For example: <code>uploads/fa-userrole/fa-firstlastfa-userid</code> will point dynamically, depending on who is logged in, to directories like: <code>uploads/editor/jackhandy15</code> or <code>uploads/subscriber/joanjett58</code>.
</div></div>

<?php ssfa_helpmodal('images-code'); ?>
<h4>Images</h4>
Optional: If left blank, the default behavior is to list image files along with all other files. You can alternatively choose to exclude all image types from your display, or to show only image types in your display. Image types are: .bmp, .gif, .jpg, .jpeg, .png, .tif, .tiff
<br />
<br />
<h4>Code Documents</h4>
By default, and for security, web code documents are excluded from file displays. If you have a directory or attachment page with some code docs that you want to include in your display, you can choose to include them along with any/all other file types. Code file types excluded by default are: .asp, .cfm, .cgi, .class, .cpp, .css, .htm, .html, .java, .js, .less, .php, .pl, .py, .rb, .sass, .scss, .shtm, .shtml, .xhtm, .xhtml, and .yml. The one exception is index.htm/l and index.php files, which are always excluded, and will not be included if Code Docs are enabled.
</div></div>

<?php ssfa_helpmodal('only'); ?>
<h4>Show Only Specific</h4>
If you'd like, you can enter a comma-separated list of filenames and/or file extensions here. Doing this will filter out anything not here entered. Do not use quotation marks. Just separate each item with a comma. 
<br />
<br />
Example: 
<br />
<br />
<code>My Polished Essay, .mp3, Gertrude Stein Essay, .jpg</code>
<br />
<br />
This will tell the shortcode only to ouput files that have the string 'My Polished Essay' or 'Gertrude Stein Essay', and any file with the extension .mp3 or .jpg
</div></div>

<?php ssfa_helpmodal('exclude'); ?>
<h4>Exclude Specific</h4>
Here you can enter a comma-separated list of filenames or file extensions to exclude from your list. Example: 
<br />
<br />
<code>.doc, .ppt, My Unfinished Draft Essay, Embarrassing Photo Name</code> 
<br />
<br />
This will exclude all .doc and .ppt files from your list, as well as your ugly first draft and that photo of you after that party.
</div></div>

<?php ssfa_helpmodal('include'); ?>
<h4>Include Specific</h4>
This option also takes a comma-separated list of files or file extensions, but it is primarily for correcting / fine tuning. For instance, if you excluded '.doc' in the above field, you may want to include '.docx' here, so it isn't filtered out, if that's your fancy.
</div></div>

<?php ssfa_helpmodal('heading'); ?>
<h4>Heading</h4>
Optional: Give your list or table a nice title.
</div></div>

<?php ssfa_helpmodal('hcolor'); ?>
<h4>Heading Color</h4>
Defaults to random color if left blank.
</div></div>

<?php ssfa_helpmodal('width-perpx'); ?>
<h4>Width</h4>
Optional: If left blank, will default to auto-width if the type is set as 'Alphabetical List,' and to 100% if the type is set as 'Sortable Data Table.' If less than 100%, text will wrap around your list or table to the left or right, depending upon your alignment setting.
<br />
<br />
<h4>Width Type</h4>
Specify whether your width integer should be processed as a percentage or in pixels. Default: %
</div></div>

<?php ssfa_helpmodal('align'); ?>
<h4>Alignment</h4>
Defaults to 'Left' if blank. Use in combination with the width setting to float your list or table to the left or right of the page, to allow other page content to wrap around it. Choose 'None' to prevent wrapping.
</div></div>

<?php ssfa_helpmodal('size'); ?>
<h4>File Size</h4>
Will show the file size by default if left blank. In tables, you'll be able to sort by file size.
</div></div>

<?php ssfa_helpmodal('mod'); ?>
<h4>Date Modified</h4>
If left blank, will show by default in tables, as a sortable column, and will hide by default in lists. (Note: This option is not available for Post / Page Attachments.)
</div></div>

<?php ssfa_helpmodal('style'); ?>
<h4>Style</h4>
If left blank, tables will default to the Minimalist style, while lists will default to the Minimal-List style.
</div></div>

<?php ssfa_helpmodal('corners'); ?>
<h4>Corners</h4>
Defaults to Rounded Corners if left blank. Does not apply to tables or to the Minimal-List style.
</div></div>

<?php ssfa_helpmodal('color-accent'); ?>
<h4>Link Color</h4>
Defaults to Random Colors if left blank. If random, the accent colors will automatically match the link colors.
<br />
<br />
<h4>Accent Color</h4>
Will automatically accentuate the Link Color if left blank.
</div></div>

<?php ssfa_helpmodal('icons-iconcolor'); ?>
<h4>Icons</h4>
Defaults to File Type icons if left blank.
<br />
<br />
<h4>Icon Color</h4>
Defaults to random if left blank.
</div></div>

<?php ssfa_helpmodal('display'); ?>
<h4>Display Style</h4>
Alphabetical Lists default to vertical layout by default.
</div></div>

<?php ssfa_helpmodal('debug'); ?>
<h4>Debug</h4>
If nothing is showing up on the page when you insert the shortcode, it's either because there are no files in the directory (or attached to the page) that you're pointing to, or because you've excluded anything that's in the directory (or attached to the page) that you're pointing to. Activating the debug feature will display a box in the page content that will tell you the directory or the attachment page to which your shortcode is pointing.
</div></div>

<?php ssfa_helpmodal('search-icons'); ?>
<h4>Filtering</h4>
By default, a search icon will be placed at the top-right of the table, which allows users to filter out table content to find what they're looking for. You can disable it if desired.
<br />
<br />
<h4>Icons</h4>
Defaults to File Type icons if left blank.
</div></div>

<?php ssfa_helpmodal('paginate-pagesize'); ?>
<h4>Pagination</h4>
By default, pagination on tables is disabled. Recommended only for large file directories.
<br />
<br />
<h4>Number Per Page</h4>
If pagination is on, you can set the number of files to show per page. Default is 15.
</div></div>

<?php ssfa_helpmodal('textalign'); ?>
<h4>Text Alignment</h4>
Defaults to Center. (Applies only to tables.)
</div></div>

<?php ssfa_helpmodal('customdata'); ?>
<h4>Custom Column</h4>
You can add a custom column to your table and add custom data to any file you want. Name the column here, e.g., <code>Artist</code>, then to add data to your files, just put the data in between square brackets [ ] at the *end* of your file name, *before* the extension. Example filenames: 
<br />
<br />
<code>My Funny Valentine [Chet Baker].mp3</code><br />
<code>So What [Miles Davis].mp3</code><br />
<code>Birdland [Weather Report].mp3</code>
<br />
<br />
The data in square brackets will be automatically added to the column that you create here. This feature can be used for any purpose you like.
<br />
<br />
Note that anything in square brackets will only show up in Data Tables, and, in that case, only if you name a custom column here. 
</div></div>

<?php ssfa_helpmodal('postid'); ?>
<h4>Post / Page ID</h4>
If left blank, by default the shortcode will grab the attachments from the page or post where the shortcode is inserted (the current page). Alternatively, you can specify a post/page ID here, and the shortcode will grab the attachments from that one instead.
<br />
<br />
If you don't know the ID, Attach Away has added an 'ID' column to your 'All Pages' and 'All Posts' pages. <?php if(current_user_can('manage_options')){ ?>This column can be enabled or disabled in File Away > <a href="admin.php?page=file-away#options" class="feature-options" target="_blank">Feature Options</a><?php } ?>
</div></div>

<?php ssfa_helpmodal('capcolumn'); ?>
<h4>Caption Column</h4>
You can add a custom column to your table and add custom data to any attachment file you want. For this particular column, the data will be pulled from the attachment's 'Caption' field. Name the column here, anything you want, e.g., <code>Artist</code>. Then just add the specific data to the Caption field for each attachment file. Example:
<br />
<br />
<code>Caption Column Name: Artist</code><br />
<code>Attachment 1 Caption: Jon Bon Jovi</code><br />
<code>Attachment 2 Caption: Michael J. Iafrate</code>
<br />
<br />
For easy management of your attachments without leaving the page editor, File Away recommends the <a href="#" class="better-attachments" target="_blank">WP Better Attachments</a> plugin by Dan Holloran.
</div></div>

<?php ssfa_helpmodal('descolumn'); ?>
<h4>Description Column</h4>
You can add a second custom column to your table and add custom data to any attachment file you want. For this column, the data will be pulled from the attachment's 'Description' field. Name the column here, anything you want, e.g., <code>Author</code>. Then just add the specific data to the Description field for each attachment file. Example:
<br />
<br />
<code>Description Column Name: Author</code><br />
<code>Attachment 1 Description: Vaclav Havel</code><br />
<code>Attachment 2 Description: Terry Eagleton</code>
<br />
<br />
For easy management of your attachments without leaving the page editor, File Away recommends the <a href="#" class="better-attachments" target="_blank">WP Better Attachments</a> plugin by Dan Holloran.
</div></div>

<?php ssfa_helpmodal('sortfirst'); ?>
<h4>Initial Sorting</h4>
Choose the column by which to sort your table on initial page load. You can choose to sort in ascending or descending order for each column. Defaults to Filename (Asc) if left blank.
</div></div>

</div>
<?php  ?>