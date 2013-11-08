<?php

// THE FILE AWAY SHORTCODE
add_shortcode ( 'fileaway', 'sssc_fileaway' );
function sssc_fileaway ( $atts ) {
	extract ( shortcode_atts ( array ( 
		'heading'	 => '',	'base'		 => '', 'sub'		 => '',	'type'		 => '', 
		'hcolor'	 => '',	'color'		 => '', 'accent'	 => '',	'iconcolor'	 => '', 
		'style'		 => '',	'display'	 => '', 'corners'	 => '',	'width'		 => '', 
		'perpx'		 => '',	'align'		 => '', 'textalign'	 => '',	'icons'		 => '', 
		'mod'		 => '',	'size'		 => '', 'images'	 => '',	'code'		 => '', 
		'exclude'	 => '',	'include'	 => '', 'only'		 => '',	'paginate'	 => '', 
		'search'	 => '',	'pagesize'	 => '', 'customdata' => '',	'debug'		 => '' 
	 ), $atts ) );
	$url = get_site_url(); $nietzsche = ssfa_hungary_v_denmark(); 
	$current_user = wp_get_current_user(); $logged_in = is_user_logged_in(); 
	$fa_userid = ( $logged_in ? get_current_user_id() : 'fa-nulldirectory' );
	$fa_username = ( $logged_in ? $current_user->user_login : 'fa-nulldirectory' );
	$fa_firstlast = ( $logged_in ? $current_user->user_firstname.$current_user->user_lastname : 'fa-nulldirectory' );
	$fa_userrole = ( $logged_in ? ssfa_currentrole() : 'fa-nulldirectory' );
	$uid = rand ( 0, 9999 ); $randcolor = array ( "red","green","blue","brown","black","orange","silver","purple","pink" );
	$tz = get_option ( 'timezone_string' ); $timezone = ( $tz === '' ? 'UTC' : $tz );
	if ( SSFA_JAVASCRIPT === 'footer' )	{ global $ssfa_add_scripts; $ssfa_add_scripts = true; }
	if ( SSFA_STYLESHEET === 'footer' ) { global $ssfa_add_styles; $ssfa_add_styles = true; }
	$base = trim ( $base, '/' );
	$base = ( $base === '1' ? SSFA_BASE1 : 
			( $base === '2' ? SSFA_BASE2 : 
			( $base === '3' ? SSFA_BASE3 : 
			( $base === '4' ? SSFA_BASE4 : 
			( $base === '5' ? SSFA_BASE5 : SSFA_BASE1 ) ) ) ) );
	$sub = ( $sub ? trim ( $sub, '/' ) : null ); $dir = ( $sub ? $base.'/'.$sub : $base );
	include SSFA_INCLUDES.'private-content.php';  
	$dir = ( strpos ( $dir, '//' ) ? preg_replace( '#/+#', '/', $dir ) : $dir );
	include SSFA_INCLUDES.'shortcode-options.php';  
	if ( $type === 'table' ) {
		$thefiles .= 
			"<script type='text/javascript'>jQuery (function(){ jQuery('.footable').footable();});</script>$searchfield2
			<table id='ssfa-table' data-filter='#filter-$uid' $page class='footable ssfa-sortable $style $textalign'><thead><tr>
			<th class='ssfa-sorttype $style-first-column' title='Click to Sort'>Type</th>
			<th class='ssfa-sortname' data-sort-initial='true' title='Click to Sort'>File Name</th>";
		$thefiles .= ( $customdata ? "<th class='ssfa-sortcustomdata' title='Click to Sort'>$customdata</th>" : null );
		$thefiles .= ( $mod !== 'no' ? "<th class='ssfa-sortdate' data-type='numeric' title='Click to Sort'>Date Modified</th>" : null );
		$thefiles .= ( $size !== 'no' ? "<th class='ssfa-sortsize' data-type='numeric' title='Click to Sort'>Size</th>" : null );
		$thefiles .= "</tr></thead><tfoot><tr><td colspan='100'>$pagearea</td></tr></tfoot><tbody>"; }
	$files = scandir ( $dir ); date_default_timezone_set ( $timezone ); natcasesort ( $files ); $count = 0;
	foreach ( $files as $file ) {
		include SSFA_INCLUDES.'includes-excludes.php'; 
		$link = $url.'/'.$dir.'/'.$file;
		$slices = pathinfo ( $link ); $loc = $slices['dirname']; $full = $slices['basename']; $ext = $slices['extension']; $rawname = $slices['filename'];
		if ( preg_match ( '/\[([^\]]+)\]/', $rawname ) ) {
			$file_plus_custom = $rawname;
			list ( $salvaged_filename, $customvalue ) = preg_split ( "/[\[\]]/", $file_plus_custom );
			$customvalue = str_replace ( array ( '~', '--', '_', '.', '*' ), ' ', $customvalue );
			$name = str_replace ( array ( '~', '-', '--', '_', '.', '*' ), ' ', $salvaged_filename ); }	
		else { $file_plus_custom = null; $customvalue = null; $name = str_replace ( array ( '~', '-', '--', '_', '.', '*' ), ' ', $rawname ); }
		$ext = ( !$ext ? '?' : $ext ); $ext = substr ( $ext,0,4 );
		$bytes = filesize ( $dir.'/'.$file ); $sortdatekey = date ( "YmdHis", filemtime ( $dir.'/'.$file ) );	
		$sortdate = ( SSFA_DAYMONTH === 'dm' ? date ( "g:i A d/m/Y", filemtime ( $dir.'/'.$file ) ) : date ( "g:i A m/d/Y", filemtime ( $dir.'/'.$file ) ) );
		$date = date ( "F d, Y", filemtime ( $dir.'/'.$file ) ); $time = date ( "g:i A", filemtime ( $dir.'/'.$file ) );		
		if ( is_file ( $dir.'/'.$file ) ) {
			if ( $size !== 'no' ) { 
				$fsize = ssfa_formatBytes ( $bytes, 1 ); $fsize = ( !preg_match ( '/[a-z]/i', $fsize ) ? '1k' : ( $fsize === 'NAN' ? '0' : $fsize )); } 
			if ( $iconcolor ) $icocol = " ssfa-$iconcolor"; 
			if ( $color && !$accent ) { $accent = $color; $colors = " ssfa-$color accent-$accent"; } 
			if ( $color && $accent ) $colors = " ssfa-$color accent-$accent"; 
			if ( ( $color ) && ! ( $iconcolor ) ) { $useIconColor = $randcolor[array_rand ( $randcolor )]; $icocol = " ssfa-$useIconColor"; } 
			if ( ! ( $color ) && ( $iconcolor ) ) { $useColor = $randcolor[array_rand ( $randcolor )]; $colors = " ssfa-$useColor accent-$useColor"; } 
			if ( ! ( $color ) && ! ( $iconcolor ) )	{ $useColor = $randcolor[array_rand ( $randcolor )]; $colors = " ssfa-$useColor accent-$useColor"; 
				$icocol = " ssfa-$useColor"; } 
			$icocol = ( $type === 'table' ? null : $icocol );
			$datemodified = ( $type !== 'table' && $mod === 'yes' ? "<div class='ssfa-datemodified'>Last modified $date at $time</div>" : null );
			$listfilesize = ( $type !== 'table' && $size !== 'no' ? 
				( $style === 'ssfa-minimal-list' ? "<span class='ssfa-listfilesize'> ($fsize)</span>" 
				: "<span class='ssfa-listfilesize'>$fsize</span>" ) : null );
			$name = "<span class='ssfa-filename'>".ucwords ( $name )."</span>"; $customvalue = ucwords ( $customvalue ); $customdata = ucwords ( $customdata );
			include SSFA_INCLUDES.'file-type-icons.php'; 
			if ( $exclusions ) {			
				$count += 1;	
				if ( !$type || $type !== 'table' ) 				
					$thefiles .= 				
						"<a id='ssfa' class='$display$noicons$colors' href='$link' download>						
						<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $name $listfilesize</span> $datemodified</div>					
						</a>"; 				
				if ( $type === 'table' ) {
					$thefiles .= 
						"<tr><td class='ssfa-sorttype $style-first-column'><a href='$link' download>$icon $ext</a></td>
						<td class='ssfa-sortname'><a href='$link' download>$name</a></td>";
					$thefiles .= ( $customdata ? "<td class='ssfa-sortcustomdata'>$customvalue</td>" : null );
					$thefiles .= ( $mod !== 'no' ? "<td class='ssfa-sortdate' data-value='$sortdatekey'>$sortdate</td>" : null );						
					$thefiles .= ( $size !== 'no' ? "<td class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null );
					$thefiles .= '</tr>'; }
			}
	    }
	}
	$thefiles .= ( $type === 'table' ? '</tbody></table></div>' : '</div>' );
	if ( $debug === 'on' && $logged_in ) { include SSFA_INCLUDES.'file-away-debug.php'; return ssfa_debug($url, $dir); }
	elseif ( $logged_in && $private_content && $count !== 0 ) return $thefiles; 	
	elseif ( !$private_content && $count !== 0 ) return $thefiles; 
}