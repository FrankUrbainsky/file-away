<?php
// THE FILE AWAY SHORTCODE
add_shortcode('fileaway', 'sssc_fileaway');
function sssc_fileaway($atts){
	extract(shortcode_atts(array(
		'heading'	  	=> '',	'base'		  	=> '', 
		'sub'		  	=> '',	'type'		  	=> '', 
		'hcolor'	  	=> '',	'color'		  	=> '', 
		'accent'	  	=> '',	'iconcolor'	  	=> '', 
		'style'		  	=> '',	'display'	  	=> '', 
		'corners'	  	=> '',	'width'		  	=> '', 
		'perpx'		  	=> '',	'align'		  	=> '', 
		'textalign'	  	=> '',	'icons'		  	=> '', 
		'mod'		  	=> '',	'size'		  	=> '', 
		'images'	  	=> '',	'code'		  	=> '', 
		'exclude'	  	=> '',	'include'	  	=> '', 
		'only'		  	=> '',	'paginate'	  	=> '', 
		'search'	  	=> '',	'pagesize'	  	=> '', 
		'customdata'  	=> '',	'debug'		  	=> '',	
		'sortfirst'   	=> '', 	'showto'  	  	=> '', 
		'hidefrom'    	=> '', 	'nolinks'	  	=> '',
		'recursive'	  	=> '', 	'directories' 	=> '', 
		'manager' 	  	=> '', 	'password'	  	=> '',
		'role_override' => '',	'user_override' => '',
		'name' 			=> '',
	), $atts));
	$thefiles = null; $included = null; $permexcluded = null; $excluded = null; $rawnames = null; $iconstyle = null; $icocol = null; 
	$current_user = wp_get_current_user(); $logged_in = is_user_logged_in(); 
	$showtothese = true;
	if ($hidefrom): 
		if (! $logged_in) $showtothese = false; 
		$hidelevels = preg_split('/(, |,)/', $hidefrom); 
		foreach($hidelevels as $hlevel): if (current_user_can($hlevel)) $showtothese = false; endforeach; 
	endif; 
	if ($showto): 
		$showtothese = false; 
		$showlevels = preg_split('/(, |,)/', $showto); 
		foreach($showlevels as $slevel): if (current_user_can($slevel)) $showtothese = true; endforeach;
	endif;
	if ($showtothese == false) return;
	$siteaddress = rtrim(get_bloginfo('url'), '/'); $wpaddress = rtrim(get_bloginfo('wpurl'), '/');	
	if ($siteaddress !== '' && $siteaddress !== null && $siteaddress !== $wpaddress) $url = $siteaddress; 
	else $url = get_site_url(); $nietzsche = ssfa_hungary_v_denmark(); 
	$fa_userid = ($logged_in ? get_current_user_id() : 'fa-nulldirectory');
	$fa_username = ($logged_in ? $current_user->user_login : 'fa-nulldirectory');
	$fa_firstlast = ($logged_in ? $current_user->user_firstname.$current_user->user_lastname : 'fa-nulldirectory');
	$fa_userrole = ($logged_in ? ssfa_currentrole() : 'fa-nulldirectory');
	$uid = rand(0, 9999); $randcolor = array("red","green","blue","brown","black","orange","silver","purple","pink");
	$tz = get_option('timezone_string'); $timezone = ($tz === '' ? 'UTC' : $tz);
	if (SSFA_JAVASCRIPT === 'footer'): global $ssfa_add_scripts; $ssfa_add_scripts = true; endif;
	if (SSFA_STYLESHEET === 'footer'): global $ssfa_add_styles; $ssfa_add_styles = true; endif;
	$base = ($base === '1' ? SSFA_BASE1 : ($base === '2' ? SSFA_BASE2 : 
			($base === '3' ? SSFA_BASE3 : ($base === '4' ? SSFA_BASE4 : 
			($base === '5' ? SSFA_BASE5 : SSFA_BASE1)))));
	$base = trim($base, '/'); $base = trim($base, '/');
	$sub = ($sub ? trim($sub, '/') : null); $dir = ($sub ? $base.'/'.$sub : $base);
	include SSFA_INCLUDES.'private-content.php';  
	$dir = (str_replace('//', '/', "$dir"));
	$dir = (SSFA_ROOT === 'siteurl' ? $dir : ($GLOBALS['ssfa_install'] ? $GLOBALS['ssfa_install'].$dir : $dir));
	if ($private_content == true && !is_dir("$dir")) return null;
	$name = ($name ? $name : "ssfa-meta-container-$uid" );
	$thefiles .= "<div id='$name' class='ssfa-meta-container'>";
	if($manager):
		$manager = 0;
		while ($manager == 0):
			if(current_user_can('administrator')) $manager = 1;
			$allowed_roles = explode(',', SSFA_MANAGER_ROLES);
			foreach ($allowed_roles as $role) if(current_user_can($role)) $manager = 1;
			$allowed_users = explode(',', SSFA_MANAGER_USERS); 
			foreach($allowed_users as $user) if($fa_userid == $user) $manager = 1;
			if($password): 
				if($password == SSFA_MANAGER_PASSWORD):
					if($role_override):
						if(preg_match("/fa-userrole/i", $role_override)): 
							if($logged_in): $manager = 1; endif;
						else:
							$override_roles = preg_split('/(, |,)/', trim($role_override, ' ')); 
							foreach($override_roles as $role) if(current_user_can($role)): $manager = 1; endif;
						endif;
					endif;
					if($user_override):
						if(preg_match("/fa-userid/i", $user_override)): 
							$ID = get_current_user_id();
							if($fa_userid == $ID): $manager = 1; endif;
						else:
							$override_users = preg_split('/(, |,)/', trim($user_override, ' '));
							foreach($override_users as $user) if($fa_userid == $user): $manager = 1; endif;
						endif;
					endif;
				endif;	
			endif;
			break;
		endwhile;
	endif; 
	if($manager): 
		$type = 'table'; 
		$directories = 1; 
	endif;
	$start = "$dir";
	if($directories):
		$type = 'table'; 
		$recursive = false;
		$basecheck = trim("$dir",'/');
		if(strpos("$basecheck", '/') !== false):
			$subbase = strrchr("$basecheck", "/"); 
			$basebase = str_replace("$subbase", '', "$basecheck"); 
		else: $basebase = "$basecheck";
				$subbase = "$basebase";
		endif;
		if(isset($_REQUEST['drawer'])): 
			$rawdrawer = $_GET['drawer'];
			$aposdrawer = stripslashes("$rawdrawer");
			if($aposdrawer === "/") $aposdrawer = trim($start, '/');
			$dir = "$basebase"."/"."$aposdrawer"; 
			$dir = str_replace('*', '/', "$dir");
			if ($rawdrawer === '') $dir = "$start";
			if (!is_dir("$dir")) $dir = "$start";
			if (strpos("$dir", '..') !== false) $dir = "$start";
		endif;
		$baselessdir = ssfa_replace_first("$basebase", '', "$dir");
		if ($basebase !== $basecheck) $crumbs = explode('/', ltrim("$baselessdir", '/'));
		else $crumbs = explode('/', trim("$dir", '/'));		
		$crumblink = array();
		if (!$heading) $addclass = '-noheading';
		$thefiles .= "<div class='ssfa-crumbs$addclass'>";
		foreach ($crumbs as $k => $crumb):
			$prettycrumb = str_replace(array('~', '--', '_', '.', '*'), ' ', $crumb); 
			$prettycrumb = preg_replace('/(?<=\D)-(?=\D)/', ' ', $prettycrumb);
			$prettycrumb = preg_replace('/(?<=\d)-(?=\D)/', ' ', $prettycrumb);
			$prettycrumb = preg_replace('/(?<=\D)-(?=\d)/', ' ', $prettycrumb);
			$prettycrumb = ssfa_strtotitle($prettycrumb);
			if($crumb !== ''):
				$i = 0; while ($i <= $k): if ($i == 0) $comma = null; else $comma ="*"; $crumblink[$k] .= $comma."$crumbs[$i]"; $i++; endwhile;
				if ($basebase === $basecheck): $crumblink[$k] = ltrim(ssfa_replace_first("$basebase", '', "$crumblink[$k]"), '*'); endif;
				$thefiles .= '<a href="'.add_query_arg( array( 'drawer' => $crumblink[$k] ), get_permalink()).'">'."$prettycrumb".'</a> / ';
			endif;
		endforeach;
		$thefiles .= "</div>";
	endif;
	include SSFA_INCLUDES.'shortcode-options.php';  		
	if ($type === 'table'):
		if ($directories) $sortfirst = 'filename';
		$typesort = null; $filenamesort = null; $customsort = null; $modsort = null; $sizesort = null;
		if ($sortfirst === 'type') $typesort = " data-sort-initial='true'"; 
		elseif ($sortfirst === 'type-desc') $typesort = " data-sort-initial='descending'"; 
		elseif ($sortfirst === 'filename') $filenamesort = " data-sort-initial='true'"; 
		elseif ($sortfirst === 'filename-desc') $filenamesort = " data-sort-initial='descending'";
		elseif ($sortfirst === 'custom') $customsort = " data-sort-initial='true'"; 
		elseif ($sortfirst === 'custom-desc') $customsort = " data-sort-initial='descending'";
		elseif ($sortfirst === 'mod') $modsort = " data-sort-initial='true'"; 
		elseif ($sortfirst === 'mod-desc') $modsort = " data-sort-initial='descending'";
		elseif ($sortfirst === 'size') $sizesort = " data-sort-initial='true'"; 
		elseif ($sortfirst === 'size-desc') $sizesort = " data-sort-initial='descending'";
		else $filenamesort = " data-sort-initial='true' "; 
		if ($directories) $filename= "File/Drawer"; else $filename = "File Name";
		if($manager):
			$path = '<input type="hidden" id="ssfa-nomenclature" value="" />';
			$ss = explode('/', $start); $ss = end($ss);
			$ssh = '<input type="hidden" id="ssfa-whymenclature" value="'.$ss.'" />';		
			$sh = '<input type="hidden" id="ssfa-yesmenclature" value="'.$start.'" />';
			$td = '<input type="hidden" id="ssfa-bad-motivator" value="'.trim("$dir",'/').'" />';
		endif;
		$thefiles .= 
			"<script type='text/javascript'>jQuery(function(){ jQuery('.footable').footable();});</script>$searchfield2
			<table id='ssfa-table' data-filter='#filter-$uid' $page class='footable ssfa-sortable $style $textalign'><thead><tr>
			<th class='ssfa-sorttype $style-first-column' title='Click to Sort'".$typesort.">Type</th>
			<th class='ssfa-sortname' title='Click to Sort'".$filenamesort.">$filename$path$ssh$sh$td</th>";
		$cells = null; if ($mod !== 'no') $cells .= '1,'; if ($size !== 'no') $cells .= '1,'; if ($manager) $cells .= '1,'; 	
		if ($customdata):
			$custom_sort = true;
			$customarray = explode(',', $customdata);
			foreach($customarray as $customdatum): if (preg_match('/[*]/', $customdatum)) $custom_sort = false; endforeach;
			foreach($customarray as $customdatum):
				if ($customdatum !== ''):
					$cells .= '1,';
					if (preg_match('/[*]/', $customdatum)): $customdatum = str_replace('*', '', $customdatum); $custom_sort = true; endif;
					if ($custom_sort == true) $custom_sort = $customsort;
					$customdatum = trim($customdatum, ' ');
					$thefiles .= "<th class='ssfa-sortcustomdata' title='Click to Sort'".$custom_sort.">$customdatum</th>";
				endif;
			endforeach;
		endif;
		$cells = rtrim($cells,',');
		$thefiles .= ($mod !== 'no' ? "<th class='ssfa-sortdate' data-type='numeric' title='Click to Sort'".$modsort.">Date Modified</th>" : null);
		$thefiles .= ($size !== 'no' ? "<th class='ssfa-sortsize' data-type='numeric' title='Click to Sort'".$sizesort.">Size</th>" : null);
		if ($manager) $thefiles .= ($size !== 'no' ? "<th style='width:90px!important;' class='ssfa-manager' data-sort-ignore='true'>Manage</th>" : null);		
		$thefiles .= "</tr></thead><tfoot><tr><td colspan='100'>$pagearea</td></tr></tfoot><tbody>"; 
	endif;	
	if ($directories):
		foreach ( glob("$dir"."/*", GLOB_ONLYDIR) as $k=> $folder ):
			$direxcluded = 0;
			if (SSFA_DIR_EXCLUSIONS):
				$direxes = preg_split ( '/(, |,)/', SSFA_DIR_EXCLUSIONS );
				foreach($direxes as $direx):
					$check = strripos($folder, $direx);
					if($check !== false) {$direxcluded = 1; break;}
				endforeach;
			endif;
			if (! $direxcluded):			
				$dlink = ssfa_replace_first("$basebase", '', "$folder");
				$folder = str_replace("$dir".'/', '', "$folder");
				$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$folder"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder");
				$prettyfolder = ssfa_strtotitle($prettyfolder);
				$dlink = str_replace('/', '*', ltrim("$dlink", '/'));
				$thefiles .= "<tr class='ssfa-drawers'><td data-value='00-$folder' class='ssfa-sorttype $style-first-column'><a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\"><span data-ssfa-icon='=' style='font-size:20px; margin-left:3px;' class='$iconstyle $icocol' aria-hidden='true'></span><br>dir</a></td><td data-value='00-$folder' class='ssfa-sortname'><a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\"><span style='text-transform:uppercase;'>$prettyfolder</span></a></td>"; 			
				$thecells = explode(',', $cells); foreach ($thecells as $cell): $thefiles .= "<td class='$style'> &nbsp; </td>"; endforeach; $thefiles .= "</tr>";
			endif;
		endforeach;
	endif;
	if($directories) $recursive = 0;
	$files = ($recursive ? (ssfa_recursive_files($dir)) : $files = scandir($dir)); 
	date_default_timezone_set($timezone); natcasesort($files); $count = 0; $original_dir = $dir;
	foreach($files as $file):
		include SSFA_INCLUDES.'includes-excludes.php'; 
		if ($exclusions):			
			$link = ($recursive ? $url.'/'.$file : $url.'/'.$dir.'/'.$file);
			$slices = pathinfo($link); 
			$locs[] = $slices['dirname']; 
			$fulls[] = $slices['basename']; 
			$exts[] = $slices['extension']; 
			$rawnames[] = $slices['filename'];
			$links[] = ($recursive ? $url.'/'.$file : $url.'/'.$dir.'/'.$file);
			$dirs[] = ($recursive ? str_replace($slices['basename'], '', $file) : $dir);		
		endif;
	endforeach;
	$fcount = count($rawnames);
	if($fcount > 0):
	asort($rawnames);
	foreach($rawnames as $k => $rawname):
		$link = $links[$k]; $loc = $locs[$k]; $ext = $exts[$k]; $oext = $ext; $full = $fulls[$k]; $dir = $dirs[$k]; $file = $full;
		if (preg_match('/\[([^\]]+)\]/', $rawname)){
			$file_plus_custom = $rawname;
			list($salvaged_filename, $customvalue) = preg_split("/[\[\]]/", $file_plus_custom);
			$customvalue = str_replace(array('~', '--', '_', '.', '*'), ' ', $customvalue);
			$customvalue = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$customvalue");
			$customvalue = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$customvalue");
			$customvalue = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$customvalue");						
			$name = str_replace(array('~', '--', '_', '.', '*'), ' ', $salvaged_filename); }	
		else { $file_plus_custom = null; $customvalue = null; $name = str_replace(array('~', '--', '_', '.', '*'), ' ', $rawname); $salvaged_filename = $rawname;}
		$name = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$name"); $name = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$name"); $name = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$name"); 
		$ext = (!$ext ? '?' : $ext); $ext = substr($ext,0,4);
		$bytes = filesize($dir.'/'.$file); $sortdatekey = date("YmdHis", filemtime($dir.'/'.$file));	
		$sortdate = (SSFA_DAYMONTH === 'dm' ? date("g:i A d/m/Y", filemtime($dir.'/'.$file)) : date("g:i A m/d/Y", filemtime($dir.'/'.$file)));
		$date = date("F d, Y", filemtime($dir.'/'.$file)); $time = date("g:i A", filemtime($dir.'/'.$file));		
		if (is_file($dir.'/'.$file) && $name !== ''):
			if ($size !== 'no'): 
				$fsize = ssfa_formatBytes($bytes, 1); $fsize = (!preg_match('/[a-z]/i', $fsize) ? '1k' :($fsize === 'NAN' ? '0' : $fsize));
			endif; 
			if ($iconcolor): $icocol = " ssfa-$iconcolor"; endif;
			if ($color && !$accent): $accent = $color; $colors = " ssfa-$color accent-$accent"; endif;
			if ($color && $accent): $colors = " ssfa-$color accent-$accent"; endif;
			if (($color) && !($iconcolor)): $useIconColor = $randcolor[array_rand($randcolor)]; $icocol = " ssfa-$useIconColor"; endif; 
			if (!($color) and($iconcolor)): $useColor = $randcolor[array_rand($randcolor)]; $colors = " ssfa-$useColor accent-$useColor"; endif;
			if (!($color) && !($iconcolor)): $useColor = $randcolor[array_rand($randcolor)]; $colors = " ssfa-$useColor accent-$useColor"; $icocol = " ssfa-$useColor"; endif; 
			$icocol = ($type === 'table' ? null : $icocol);
			$datemodified = ($type !== 'table' && $mod === 'yes' ? "<div class='ssfa-datemodified'>Last modified $date at $time</div>" : null);
			$listfilesize = ($type !== 'table' && $size !== 'no' ? 
				($style === 'ssfa-minimal-list' ? "<span class='ssfa-listfilesize'>($fsize)</span>" 
				: "<span class='ssfa-listfilesize'>$fsize</span>") : null);
			$name = "<span class='ssfa-filename'>".ssfa_strtotitle($name)."</span>"; 
			$fulllink = 'href="'.$link.'"';
			include SSFA_INCLUDES.'file-type-icons.php'; 
			$count += 1;	
			if ($nolinks === 'yes' || $nolinks === 'true'):
				$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' style='cursor:default'>"; 
				$nolinkstable = "<a style='cursor:default'>"; 
			else:	
				$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' $fulllink $linktype>"; 
				$nolinkstable = "<a $fulllink $linktype>";
			endif;
			if (!$type || $type !== 'table'): 				
				$thefiles .= 				
					"$nolinkslist<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $name $listfilesize</span> $datemodified</div></a>"; 				
			elseif ($type === 'table'):
				$oext = ($manager ? $oext : null);
				$filepath = ($manager ? '<input id="filepath-ssfa-file-'.$uid.'-'.$count.'" type="hidden" value="'.$dir.'" />' : null);
				$oldname = ($manager ? '<input id="oldname-ssfa-file-'.$uid.'-'.$count.'" type="hidden" value="'.$rawname.'" />' : null);
				$salvaged_filename = ($manager? trim($salvaged_filename, ' ') : $salvaged_filename);
				if ($manager && $customdata) $fileinput = '<input id="rawname-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$salvaged_filename.'" style="width:80%; height:26px; font-size:12px; text-align:center; display:none">';
				elseif ($manager && ! $customdata) $fileinput = '<input id="rawname-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$rawname.'" style="width:80%; height:26px; font-size:12px; text-align:center; display:none">';
				else $fileinput = null;
				$thefiles .= 
					"<tr id='ssfa-file-$uid-$count' class=''>
					<td id='filetype-ssfa-file-$uid-$count' class='ssfa-sorttype $style-first-column'>$nolinkstable$icon $ext</a><input type='hidden' value='$oext' /></td>
					<td id='filename-ssfa-file-$uid-$count' class='ssfa-sortname'>$nolinkstable$name</a>$fileinput$filepath$oldname</td>";
				if ($customdata):
					$customvalues = explode(',', $customvalue);
					foreach($customarray as $k=> $customdatum):
						if ($customdatum !== null):
							$value = ssfa_strtotitle(trim($customvalues[$k], ' '));
							$custominput[$k] = ($manager ? 
								'<input id="customdata-'.$k.'-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$value.'" 
								style="width:80%; height:26px; font-size:12px; text-align:center; display:none">' 
								: null);
							$thefiles .= "<td id='customadata-cell-$k-ssfa-file-$uid-$count' class='ssfa-sortcustomdata'>
								<span id='customadata-$k-ssfa-file-$uid-$count'>"."$value"."</span>".$custominput[$k]."</td>";
						endif;
					endforeach;
				endif;
				$thefiles .= ($mod !== 'no' ? "<td id='mod-ssfa-file-$uid-$count' class='ssfa-sortdate' data-value='$sortdatekey'>$sortdate</td>" : null);						
				$thefiles .= ($size !== 'no' ? "<td id='size-ssfa-file-$uid-$count' class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null);
				$thefiles .= ($manager ? "<td id='manager-ssfa-file-$uid-$count' class='ssfa-sortmanager'><a href='' id='rename-ssfa-file-$uid-$count'>Rename</a><br>
				<a href='' id='delete-ssfa-file-$uid-$count'>Delete</a></td>" : null);
				$thefiles .= '</tr>'; 
			endif;	
		endif;
	endforeach;
	endif;
	$thefiles .= ($type === 'table' ? '</tbody></table>' : null);
	if ($manager) $thefiles .= 
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
		</div>";
	if ($manager): 
		$thefiles .= "<div id='ssfa-path-container' style='display:none; float:left;'>
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
	endif;
	$thefiles .= "</div></div>";
	if ($debug === 'on' && $logged_in): include SSFA_INCLUDES.'file-away-debug.php'; return ssfa_debug($url, $original_dir);
	elseif ($logged_in && $private_content && $count !== 0): return $thefiles; 	
	elseif ($private_content !== true && $count !== 0): return $thefiles; 
	elseif ($directories && ($private_content !== true || ($logged_in && $private_content))): return $thefiles;
	endif;
}
// THE FILE AWAY IFRAME SHORTCODE
add_shortcode('fileaframe', 'ssfa_fileaframe');
function ssfa_fileaframe($atts){
	extract(shortcode_atts(array(
		'source' => '', 'width' => '100%', 'height' => '', 
		'scroll' => 'no', 'frame' => '0', 'mwidth' => '0px', 
		'mheight' => '0px', 'seamless' => 'seamless', 'name' => ''
	), $atts));
	$seamless = ($seamless !== 'seamless' ? null : 'seamless');
	if(!$name)
	return 'Please assign your fileaframe shortcode a unique name, using [fileaframe name="myuniquename"], and assign the same name to its corresponding [fileaway] shortcode, using [fileaway name="myuniquename"]';
	if($source && $name)
	return "<div id='$name' class='ssfa-meta-container' style='width:100%; height:100%;'><iframe name='$name' id='$name' src='$source' width=$width height=$height scrolling=$scroll frameborder=$frame marginwidth=$mwidth marginheight=$mheight $seamless></iframe></div>";
}
?>