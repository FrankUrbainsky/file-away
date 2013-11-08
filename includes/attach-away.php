<?php

// THE ATTACH AWAY SHORTCODE
add_shortcode ( 'attachaway', 'sssc_attachaway' );
function sssc_attachaway ( $atts ) { 
	extract ( shortcode_atts ( array ( 
		'postid'	=> '',	'heading'	=> '',	'type'		=> '',	'hcolor'	=> '', 
		'color'		=> '',	'accent'	=> '',	'iconcolor'	=> '',	'style'		=> '', 
		'display'	=> '',	'corners'	=> '',	'width'		=> '',	'perpx'		=> '', 
		'align'		=> '',	'textalign'	=> '',	'icons'		=> '',	'capcolumn'	=> '',
		'descolumn'	=> '',	'size'		=> '',	'images'	=> '',	'code'		=> '', 
		'exclude'	=> '',	'include'	=> '',	'only'		=> '',	'paginate'	=> '', 
		'search'	=> '',	'pagesize'	=> '',	'debug'		=> '' 
	 ), $atts ) );	
	$logged_in = is_user_logged_in ( );	$nietzsche = ssfa_hungary_v_denmark ( ); $count = 0;
	$uid = rand ( 0, 9999 ); $randcolor = array ( "red","green","blue","brown","black","orange","silver","purple","pink" );
	if ( SSFA_JAVASCRIPT === 'footer' ) { global $ssfa_add_scripts; $ssfa_add_scripts = true; }
	if ( SSFA_STYLESHEET === 'footer' )	{ global $ssfa_add_styles; $ssfa_add_styles = true; }
	global $post; $mimes = get_allowed_mime_types();
	if (!$postid) { 
		$theid = $post->ID;
		$attachments = get_posts( array(
			'orderby'			=> 'title',
			'order'				=> 'ASC',
			'post_type'			=> 'attachment',
			'posts_per_page'	=> -1,
			'post_parent'		=> $post->ID
		)); }
	else { 
		$theid = $postid;
		$attachments = get_posts( array(
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_type'			=> 'attachment',
			'posts_per_page'	=> -1,
			'post_parent'		=> $postid
		)); }
	include SSFA_INCLUDES.'shortcode-options.php';  
	if ( $type === 'table' ) { 
		$thefiles .= 
			"<script type='text/javascript'>jQuery(function(){jQuery('.footable').footable();});</script>$searchfield2
			<table id='ssfa-table' data-filter='#filter-$uid'$page class='footable ssfa-sortable $style$textalign'><thead><tr>
			<th class='ssfa-sorttype $style-first-column' title='Click to Sort'>Type</th>
			<th class='ssfa-sortname' data-sort-initial='true' title='Click to Sort'>File Name</th>";
		$thefiles .= ( $capcolumn ? "<th class='ssfa-sortcapcolumn' title='Click to Sort'>$capcolumn</th>" : null );
		$thefiles .= ( $descolumn ? "<th class='ssfa-sortdescolumn' title='Click to Sort'>$descolumn</th>" : null );
		$thefiles .= ( $size !== no ? "<th class='ssfa-sortsize' data-type='numeric' title='Click to Sort'>Size</th>" : null );
		$thefiles .= "</tr></thead><tfoot><tr><td colspan='100'>$pagearea</td></tr></tfoot><tbody>"; }
	if ( $debug === 'on' ) include SSFA_INCLUDES.'attach-away-debug.php'; 		
	if ( $attachments && $debug !== 'on' ) { 
		foreach ( $attachments as $attachment ) { 
			$meta = ssaa_get_attachment($attachment->ID); $caption = $meta['caption']; $alt = $meta['alt']; $description = $meta['description'];
			$postlink = $meta['postlink']; $filelink = $meta['filelink']; $metatitle = $meta['title'];
			$filetype = wp_check_filetype($filelink); $ext = $filetype['ext']; $basename = basename ( $filelink );
			$filename = str_replace( '.'.$ext, '', $basename ); $filename = str_replace ( array ( '~', '-', '--', '_', '.', '*' ), ' ', $filename );
			$title = ( $metatitle ? $metatitle : $filename );
			if (strtoupper($caption) === $caption) $caption = strtolower($caption);
			if (strtolower($caption) === $caption) $caption = ssaa_sentence_case($caption);
			if (strtoupper($description) === $description) $description = strtolower($description);
			if (strtolower($description) === $description) $description = ssaa_sentence_case($description);
			if (strtoupper($title) === $title) $title = strtolower($title);
			$title = "<span class='ssfa-filename'>".ucwords($title)."</span>"; 
			$ext = ( !$ext ? '?' : $ext ); $ext = strtolower ( $ext ); $ext = substr ( $ext,0,4 ).'';
			$bytes = filesize( get_attached_file( $attachment->ID ) );
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
			$listfilesize = ( $type !== 'table' && $size !== 'no' ? 
				( $style === "ssfa-minimal-list" ? "<span class='ssfa-listfilesize'> ($fsize)</span>" 
				: "<span class='ssfa-listfilesize'>$fsize</span>" ) : null );
			$file = $basename;
			include SSFA_INCLUDES.'includes-excludes.php'; include SSFA_INCLUDES.'file-type-icons.php'; 
			if ( $exclusions ) { 
				$count += 1;
				if ( !$type || $type !== 'table' || $type === 'list' ) 
					$thefiles .= 
						"<a id='ssfa' class='$display$noicons$colors' href='$filelink' download>
						<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $title $listfilesize</span></div>
						</a>"; 
				if ( $type === 'table' ) { 
					$thefiles .= 				
						"<tr><td class='ssfa-sorttype $style-first-column'><a href='$filelink' download>$icon $ext</a></td>
						<td class='ssfa-sortname'><a href='$filelink' download>$title</a></td>"; 
					$thefiles .= ( $capcolumn ? "<td class='ssfa-sortcapcolumn'>$caption</td>" : null );
					$thefiles .= ( $descolumn ? "<td class='ssfa-sortdescolumn'>$description</td>" : null );
					$thefiles .= ( $size !== 'no' ? "<td class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null );
					$thefiles .= '</tr>'; } 
			} 
		} 
		$thefiles .= ( $type === 'table' ? '</tbody></table></div>' : '</div>' );
	}
	$thefiles = ( $debug === 'on' && $logged_in ? $thefiles : ( $debug !== 'on' && $count !== 0 ? $thefiles : null ) );
	return $thefiles;
}