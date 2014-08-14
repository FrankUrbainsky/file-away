<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");

add_shortcode('fileup', 'ssfa_fileup');
function ssfa_fileup($atts){
	extract(shortcode_atts(array(
		'name'			=> false,
		'base'			=> '1',
		'sub'			=> false,
		'style'			=> 'silver-bullet',
		'iconcolor'		=> 'classic',
		'width'			=> '100',
		'perpx'			=> '%',
		'align'			=> 'none',
		'filetypes'		=> false,
		'filegroups'	=> false,
		'action'		=> 'permit',
		'showto'		=> false,
		'hidefrom'		=> false,
		'single'		=> false,
		'maxsize'		=> 10,
		'maxsizetype'	=> 'm',
	),$atts));
	if(SSFA_JAVASCRIPT === 'footer'): $GLOBALS['ssfa_add_scripts'] = true; endif;
	if(SSFA_STYLESHEET === 'footer'): $GLOBALS['ssfa_add_styles'] = true; endif;
	$current_user = wp_get_current_user(); $logged_in = is_user_logged_in(); 
		
	// Visibility Permissions
	$showtothese = true;
	if($hidefrom): 
		if(!$logged_in) $showtothese = false; 
		$hidelevels = preg_split('/(, |,)/', $hidefrom); 
		foreach($hidelevels as $hlevel): if(current_user_can($hlevel)): $showtothese = false; break; endif; endforeach; 
	endif; 
	if($showto): 
		$showtothese = false; 
		$showlevels = preg_split('/(, |,)/', $showto); 
		foreach($showlevels as $slevel): if(current_user_can($slevel)): $showtothese = true; break; endif; endforeach;
	endif;
	if(!$showtothese) return;
	
	// Build Initial Directory
	$fa_userid = ($logged_in ? get_current_user_id() : 'fa-nulldirectory');
	$fa_username = ($logged_in ? strtolower($current_user->user_login) : 'fa-nulldirectory');
	$fa_firstlast = ($logged_in ? strtolower($current_user->user_firstname.$current_user->user_lastname) : 'fa-nulldirectory');
	$fa_userrole = ($logged_in ? strtolower(ssfa_currentrole()) : 'fa-nulldirectory');	
	$base = ($base === '1' ? SSFA_BASE1 : ($base === '2' ? SSFA_BASE2 : 
			($base === '3' ? SSFA_BASE3 : ($base === '4' ? SSFA_BASE4 : 
			($base === '5' ? SSFA_BASE5 : SSFA_BASE1)))));	
	$base = trim($base, '/'); $base = trim($base, '/');
	$sub = ($sub ? trim($sub, '/') : false); $dir = ($sub ? $base.'/'.$sub : $base);
	$playback = false; include SSFA_INCLUDES.'private-content.php';  
	$dir = (str_replace('//', '/', "$dir"));
	$debugpath = $GLOBALS['ssfa_abspath'].$dir;
	$dir = (SSFA_ROOT === 'siteurl' ? $dir : ($GLOBALS['ssfa_install'] ? $GLOBALS['ssfa_install'].$dir : $dir));
	if ($private_content == true && !is_dir("$dir")) return null;
	$start = "$dir"; $ss = explode('/', $start); $ss = end($ss);
	$path = '<input type="hidden" id="ssfa-upnomenclature" value="" />';
	$ssh = '<input type="hidden" id="ssfa-upwhymenclature" value="'.$ss.'" />';		
	$sh = '<input type="hidden" id="ssfa-upyesmenclature" value="'.$start.'" />';

	// File Type Permissions
	$types = array(); 
	if($filetypes):
		$filetypes = preg_split('/(, |,)/', $filetypes); 
		foreach($filetypes as $type) $types[] = strtolower(str_replace(array('.',',',' '), '', $type));
	endif;
	if($filegroups):
		$groups = preg_split('/(, |,)/', strtolower(str_replace(' ', '', $filegroups)));
		foreach($GLOBALS['ssfa_filegroups'] as $group => $discard) if(in_array($group, $groups)) $types = array_merge($types, $GLOBALS['ssfa_'.$group]);
	endif;
	if(count($types) > 0): $types = array_unique($types); asort($types); $filetypes = '["'.implode('", "',$types).'"]'; else: $filetypes = false; endif;
	$action = $action === 'prohibit' ? $action : 'permit';
	$permitted = ($filetypes || $filegroups) && $action === 'permit' ? $filetypes : 'false';
	$prohibited = ($filetypes || $filegroups) && $action === 'prohibit' ? $filetypes : 'false';	
	
	// Configure Settings
	$uid = rand(0, 9999); 
	$name = $name ? $name : "ssfa-meta-container-$uid";
	$width = is_numeric(preg_replace('[\D]', '', $width)) ? 
		preg_replace('[\D]', '', $width) : '100'; 
	$perpx = $perpx === 'px' ? 'px' : '%'; 
	$width = "width:$width$perpx;";
	$float = $align === 'left' ? ' float:left;' : ($align === 'right' ? ' float:right;' : null);
	$margin = ($width !== 'width:100%;' ? ($align === 'right' ? ' margin-left:15px;' : ' margin-right:15px;') : null);
	$inlinestyle = $width.$float.$margin;
	$multiple = $single ? '' : ' multiple=multiple';
	$addfiles = $single ? '+ Add File' : '+ Add Files';

	// Configure Max File Size Setting
	$max_file_size = trim(preg_replace('[\D]', '', $maxsize));
	$max_size_type = trim(strtolower($maxsizetype));
	$max_file_size = is_numeric($max_file_size) ? $max_file_size : 10; 
	$max_size_type = in_array($max_size_type, array('k','m','g')) ? $max_size_type : 'm';
	$ms = $max_file_size.$max_size_type;
	switch($max_size_type){ case 'g': $ms *= 1024; case 'm': $ms *= 1024; case 'k': $ms *= 1024; }
	$post_max_size = ini_get('post_max_size');
	$pms = trim($post_max_size);
	$last = strtolower($pms[strlen($pms)-1]);
	switch($last){ case 'g': $pms *= 1024; case 'm': $pms *= 1024; case 'k': $pms *= 1024; }
	$maxsize = $pms < $ms ? $pms : $ms;

	// Initialize Settings
	$initialize = '
	<script type="text/javascript">
	jQuery(document).ready(function($){
		new FileUp({
			form_id: "ssfa_fileup_form", 
			uid: '.$uid.',
			container: "'.$name.'",
			table: "'.$style.'",
			iconcolor: "'.$iconcolor.'",
			maxsize: '.$maxsize.',
			permitted: '.$permitted.',
			prohibited: '.$prohibited.',
			loading: "'.SSFA_IMAGES_URL.'ajax.gif"
		});
	});
	</script>';
	
	// Form Output
	if(!is_dir($debugpath)) return current_user_can('administrator') ? 'File Up Admin Notice: The initial directory specified does not exist:<br>'.$debugpath : null;
	$form = '
		<div class="ssfa_fileup_container" style="'.$inlinestyle.'">
			<form name="ssfa_fileup_form" id="ssfa_fileup_form" action="javascript:void(0);" enctype="multipart/form-data">
				'.$path.$ssh.$sh.'
				<div id="ssfa-fileup-path-container" style="display:inline-block;">
					<div id="ssfa-fileup-directories-select-container">
						<label for="ssfa-fileup-directories-select" style="display:block!important; margin-bottom:5px!important;">Destination Directory</label>
						<select name="ssfa-fileup-directories-select" id="ssfa-fileup-directories-select" class="chozed-select ssfa-fileup-directories-select" data-placeholder="&nbsp;">
							<option></option>
							<option value="'.$start.'">'.$ss.'</option>
						</select>
						<br>
						<div id="ssfa-fileup-action-path" style="margin-top:5px; min-height:25px;">
							<img id="ssfa-fileup-action-ajax-loading" src="'.SSFA_IMAGES_URL.'ajax.gif" style="width:15px; margin:0!important; display:none;">
						</div>
					</div>
				</div>
				<span class="ssfa_fileup_wrapper">
					<input type="file" name="ssfa_fileup_files[]" id="ssfa_fileup_files" class="ssfa_hidden_browse"'.$multiple.' />
					<span class="ssfa_add_files">'.$addfiles.'</span>
					<span id="ssfa_submit_upload">File Up &#10138;</span>
				</span>
			</form>
			<div class="ssfa_fileup_files_container"></div>
			<span id="ssfa_rf" style="display:none;"></span>
		</div>';
	
	return do_shortcode($initialize.$form);
}