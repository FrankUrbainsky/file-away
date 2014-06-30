<?php

$thefiles .= 
	"<div id='ssfa-bulk-action-toggle' style='text-align:right; float:right'>Bulk Action Mode: <a href='javascript:' id='ssfa-bulk-action-toggle'>Disabled</a><br>
		<div style='text-align:left; margin-top:5px;'>
			<select style='display:none;' class='chozed-select ssfa-bulk-action-select' id='ssfa-bulk-action-select' data-placeholder='Select Action'>
				<option></option>
				<option value='copy'>Copy</option>
				<option value='move'>Move</option>
				<option value='delete'>Delete</option>
			</select>
			<span id='ssfa-bulk-action-engage' class='ssfa-bulk-action-engage' style='display:none;'>File Away</span>
		</div>
		<br><img id='ssfa-engage-ajax-loading' src='".SSFA_IMAGES_URL."ajax.gif' style='width:20px; display:none;'>
	</div>
	<div id='ssfa-path-container' style='display:none; float:left;'>
		<div id='ssfa-directories-select-container' class='frm_form_field form-field frm_required_field frm_top_container frm_full'>
			<label for='ssfa-directories-select' class='frm_primary_label' style='display:block!important; margin-bottom:5px!important;'>
				Destination Directory<span class='frm_required'> <span style='color:red'>*</span></span>
			</label>
			<select name='ssfa-directories-select' id='ssfa-directories-select' class='chozed-select ssfa-directories-select' data-placeholder='&nbsp;'>
				<option></option>
				<option value=\"$start\">$ss</option>
			</select>
			<br>
			<div id='ssfa-action-path' style='margin-top:5px; min-height:25px;'>
				<img id='ssfa-action-ajax-loading' src='".SSFA_IMAGES_URL."ajax.gif' style='width:20px; display:none;'>
			</div>
		</div>
	</div>";