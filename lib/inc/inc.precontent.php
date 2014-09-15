<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$thefiles .= $type === 'table' 
	? "<div id='ssfa-table-wrap-$uid'>" 
	: "<div id='ssfa-list-wrap-$uid' class='$theme$corners$bordercolor'>";
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