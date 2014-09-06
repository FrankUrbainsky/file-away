<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$color = ($type === "table" && !$color ? "classic" : ($type === "table" && $color === "random" ? false : $color));
$iconcolor = ($type === "table" && !$iconcolor ? "classic" : ($type === "table" && $iconcolor === "random" ? false : $iconcolor));
$randcolor = array("red","green","blue","brown","black","orange","silver","purple","pink");
$paginated = $paginate ? " data-page-navigation='.ssfa-pagination'" : null;
$pagearea = $paginate ? "<div class='ssfa-pagination ssfa-pagination-centered hide-if-no-paging'></div>" : null;
$pagesized = $paginate ? " data-page-size='$pagesize'" : null;
$page = $paginate ? $paginated.$pagesized : "$paginated data-page-size='100000'";
$display = $display ? ($display === 'inline' ? 'ssfa-inline' : ($display === '2col' ? 'ssfa-twocol' : null )) : null;
$ellipsis = $display === 'ssfa-twocol' ? ' ssfa-ellipsis' : null;
$bordercolor = $color ? $color : $randcolor[array_rand($randcolor)];
$bordercolor = $style === 'silk' || $style === 'minimal-list' ? null : " ssfa-$bordercolor";
$noicons = $icons === 'none' ? ' noicons' : null;
$corners = $style === 'minimal-list' ? null : ($corners ? " ssfa-$corners" : null);
$style = "ssfa-$style";
$textalign = $textalign ? ' ssfa-'.$textalign : null;
$width = preg_replace('[\D]', '', $width);
$width = $width ? "width:$width$perpx;" : null;
$float = " float:$align;";
$margin = $width !== 'width:100%;' ? ($align === 'right' ? ' margin-left:15px;' : ' margin-right:15px;') : null;
$howshouldiputit = $width.$float.$margin;
$thefiles .= $type === 'table' 
	? "<div id='ssfa-table-wrap-$uid' style='margin: 10px 0 0; $howshouldiputit'>" 
	: "<div id='ssfa-list-wrap-$uid' class='$style$corners$bordercolor' style='margin: 10px 0; $howshouldiputit'>";
$searchfield = $type === 'table' && $search !== 'no' 
	? "<div class='ssfa-search-wrap'><span data-ssfa-icon='&#xe047;' class='ssfa-searchicon' aria-hidden='true'></span>".
		"<input id='filter-$uid' class='ssfa-searchfield' placeholder='".__('SEARCH', 'file-away')."' value='' name='search' id='search' type='text' /></div>" 
	: null;
$searchfield2 = !$heading && $search !== 'no' ? "<div class='ssfa-search-container'>$searchfield</div>" : null;
if($heading)
{
	if($hcolor)
	{
		$thefiles .= "<h3 class='ssfa-heading ssfa-$hcolor'>$searchfield$heading</h3>"; 
	}
	else
	{
		$headingColor = $randcolor[array_rand($randcolor)];
		$thefiles .= "<h3 class='ssfa-heading ssfa-$headingColor'>$searchfield$heading</h3>"; 
	}
}