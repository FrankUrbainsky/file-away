<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
$thefiles .= 
	"<div id='ssfa-bulk-download-area' style='text-align:right; float:right'>
		<div style='text-align:left; margin-top:5px;'>
		<input type='checkbox' id='ssfa-bulk-download-select-all-$uid' style='display:inline-block; margin-top:5px!important; margin-right:5px;' />
		<label for='ssfa-bulk-download-select-all-$uid' id='ssfa-select-all-$uid' style='display:inline-block; font-size:12px;'> Select All</label>
		<span id='ssfa-bulk-download-engage-$uid' class='ssfa-bulk-download-engage'>Download</span>
		</div>
		<br><img id='ssfa-engage-ajax-loading-$uid' src='".SSFA_IMAGES_URL."ajax.gif' style='width:15px; display:none; margin: 0 5px 0 0!important; box-shadow: none;'>
	</div>";