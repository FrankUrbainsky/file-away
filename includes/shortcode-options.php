<?php
	$paginated = ( $paginate !== 'yes' ? null : " data-page-navigation='.ssfa-pagination'" );
	$pagearea = ( $paginate !== 'yes' ? null : "<div class='ssfa-pagination ssfa-pagination-centered hide-if-no-paging'></div>" );
	$pagesized = ( $paginate !== 'yes' ? null : ( $pagesize ? " data-page-size='$pagesize'" : " data-page-size='15'" ) );
	$page = ( $paginate !== 'yes' ? "$paginated data-page-size='100000'" : $paginated.$pagesized );
	$display = ( $display ? ( $display === 'inline' ? 'ssfa-inline' : ( $display === '2col' ? 'ssfa-twocol' : null ) ) : null );
	$ellipsis = ( $display === 'ssfa-twocol' ? ' ssfa-ellipsis' : null );
	$style = ( $style ? $style : ( $type === 'table' ? 'minimalist' : 'minimal-list' ) );
	$bordercolor = ( $color ? $color : $randcolor[array_rand ( $randcolor )] );
	$bordercolor = ( $style === 'silk' || $style === 'minimal-list' ? null : " ssfa-$bordercolor" );
	$noicons = ( $icons === 'none' ? ' noicons' : null );
	$corners = ( $corners === 'sharp' ? $corners : 
		( $corners === 'roundtop' ? $corners : 
		( $corners === 'roundbottom' ? $corners : 
		( $corners === 'roundright' ? $corners : 
		( $corners === 'roundleft' ? $corners : 
		( $corners === 'elliptical' ? $corners : null ) ) ) ) ) );
	$corners = ( $type === 'table' ? null : ( $style === 'minimal-list' ? null : ( $corners ? " ssfa-$corners" : null ) ) );
	$style = "ssfa-$style";
	$textalign = ( $type === 'table' ? ( $textalign === 'left' ? ' ssfa-left' : ( $textalign === 'right' ? ' ssfa-right' : null ) ) : null );
	$width = preg_replace ( '[\D]', '', $width );
	$width = ( $width ? $width : ( $type === 'table' ? '100' : null ) );
	$perpx = ( $width ? ( $perpx ? ( $perpx === '%' ? $perpx : ( $perpx === 'px' ? $perpx : '%' ) ) : '%' ) : null );
	$width = ( $width ? "width:$width$perpx;" : null );
	$float = ( $align ? " float:$align;" : " float:left;" );
	$margin = ( $width !== 'width:100%;' ? ( $align === 'right' ? ' margin-left:15px;' : ' margin-right:15px;' ) : null );
	$howshouldiputit = $width.$float.$margin;
	$thefiles .= ( $type === 'table' 
		? "<div id='ssfa-table-wrap' style='margin: 10px 0 0; $howshouldiputit'>" 
		: "<div id='ssfa-list-wrap' class='$style$corners$bordercolor' style='margin: 10px 0; $howshouldiputit'>" );
	$searchfield = ( ($type === 'table' and $search !== 'no') 
		? "<div class='ssfa-search-wrap'><span data-ssfa-icon='&#xe047;' class='ssfa-searchicon' aria-hidden='true'></span>
			<input id='filter-$uid' class='ssfa-searchfield' placeholder='SEARCH' value='' name='search' id='search' type='text' /></div>" 
		: null );
	$searchfield2 = ( (!$heading and $search !== 'no') ? "<div class='ssfa-search-container'>$searchfield</div>" : null );
	if ( $heading ) {
		if ( $hcolor ) {
			$thefiles .= "<h3 class='ssfa-heading ssfa-$hcolor'>$searchfield$heading</h3>"; }
		else {
			$headingColor = $randcolor[array_rand ( $randcolor )];
			$thefiles .= "<h3 class='ssfa-heading ssfa-$headingColor'>$searchfield$heading</h3>"; }
	}
?>