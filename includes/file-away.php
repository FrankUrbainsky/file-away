<?php
// THE FILE AWAY SHORTCODE
add_shortcode('fileaway', 'sssc_fileaway');
function sssc_fileaway($atts){
	extract(shortcode_atts(array(
		'heading'	 => '',	'base'		 => '', 
		'sub'		 => '',	'type'		 => '', 
		'hcolor'	 => '',	'color'		 => '', 
		'accent'	 => '',	'iconcolor'	 => '', 
		'style'		 => '',	'display'	 => '', 
		'corners'	 => '',	'width'		 => '', 
		'perpx'		 => '',	'align'		 => '', 
		'textalign'	 => '',	'icons'		 => '', 
		'mod'		 => '',	'size'		 => '', 
		'images'	 => '',	'code'		 => '', 
		'exclude'	 => '',	'include'	 => '', 
		'only'		 => '',	'paginate'	 => '', 
		'search'	 => '',	'pagesize'	 => '', 
		'customdata' => '',	'debug'		 => '',	
		'sortfirst'  => '', 'showto'  	 => '', 
		'hidefrom'   => '', 'nolinks'	 => '',
		'recursive'	 => '', 'directories' => '',
	), $atts));
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
	$base = trim($base, '/');
	$base = ($base === '1' ? SSFA_BASE1 : ($base === '2' ? SSFA_BASE2 : 
			($base === '3' ? SSFA_BASE3 : ($base === '4' ? SSFA_BASE4 : 
			($base === '5' ? SSFA_BASE5 : SSFA_BASE1)))));
	$sub = ($sub ? trim($sub, '/') : null); $dir = ($sub ? $base.'/'.$sub : $base);
	include SSFA_INCLUDES.'private-content.php';  
	$dir = (strpos($dir, '//') ? preg_replace('#/+#', '/', $dir) : $dir);
	if ($private_content == true && !is_dir($dir)) return null;

	if($directories):
		$type = 'table'; 
		$recursive = false;
		$basecheck = trim($base,'/');
		if(strpos($basecheck, '/')):
			$subbase = strrchr($basecheck, "/"); 
			$basebase = str_replace($subbase, '', $basecheck); 
		else: $basebase = $basecheck;
				$subbase = $basebase;
		endif;
		$start = $dir;
		if(isset($_REQUEST['drawer'])): 
			$dir = $basebase.'/'.$_GET['drawer']; 
			$dir = str_replace(',', '/', $dir);
			if (!is_dir($dir))$dir = $start;
		endif;
		$baselessdir = replace_first($basebase, '', $dir);
		$crumbs = explode('/', ltrim($baselessdir, '/'));
		$crumblink = array();
		if (!$heading) $addclass = '-noheading';
		$thefiles .= "<div class='ssfa-crumbs$addclass'>";
		foreach ($crumbs as $k => $crumb):
			$i = 0; while ($i <= $k): if ($i == 0) $comma = null; else $comma ="%2C"; $crumblink[$k] .= $comma.$crumbs[$i]; $i++; endwhile; 
			$thefiles .= "<a href='?drawer=".$crumblink[$k]."'>$crumb</a>/";
		endforeach;
		$thefiles .= "</div>";
	endif;

	include SSFA_INCLUDES.'shortcode-options.php';  		
	if ($type === 'table'):
		if ($directories) $sortfirst = 'type';
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
		$thefiles .= 
			"<script type='text/javascript'>jQuery(function(){ jQuery('.footable').footable();});</script>$searchfield2
			<table id='ssfa-table' data-filter='#filter-$uid' $page class='footable ssfa-sortable $style $textalign'><thead><tr>
			<th class='ssfa-sorttype $style-first-column' title='Click to Sort'".$typesort.">Type</th>
			<th class='ssfa-sortname' title='Click to Sort'".$filenamesort.">File Name</th>";
		$cells = null; if ($mod !== 'no') $cells .= '1,'; if ($size !== 'no') $cells .= '1,'; 		
		if ($customdata):
			$custom_sort = true;
			$customarray = explode(';', $customdata);
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
		$thefiles .= "</tr></thead><tfoot><tr><td colspan='100'>$pagearea</td></tr></tfoot><tbody>"; 
	endif;	
	
	if ($directories):
		foreach ( glob($dir."/*", GLOB_ONLYDIR) as $k=> $folder ):
			$link = replace_first($basebase, '', $folder);
			$folder = str_replace($dir.'/', '', $folder);
			$link = str_replace('/', '%2C', ltrim($link, '/'));
			$thefiles .= "<tr><td data-value='00$k' class='ssfa-sorttype $style-first-column'><a href='?drawer=$link'><span data-ssfa-icon='=' style='font-size:20px; margin-left:3px;' class='$iconstyle $icocol' aria-hidden='true'></span><br>dir</a></td><td class='ssfa-sortname'><h4 style='text-transform:uppercase;'><a href='?drawer=$link'>$folder</a></h4></td>"; 			
			$thecells = explode(',', $cells); foreach ($thecells as $cell): $thefiles .= "<td></td>"; endforeach; $thefiles .= "</tr>";
		endforeach;
	endif;
	
	if($scheduling) $recursize = 0;
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
	asort($rawnames);
	foreach($rawnames as $k => $rawname):
		$link = $links[$k]; $loc = $locs[$k]; $ext = $exts[$k]; $full = $fulls[$k]; $dir = $dirs[$k]; $file = $full;
		if (preg_match('/\[([^\]]+)\]/', $rawname)){
			$file_plus_custom = $rawname;
			list($salvaged_filename, $customvalue) = preg_split("/[\[\]]/", $file_plus_custom);
			$customvalue = str_replace(array('~', '--', '_', '.', '*'), ' ', $customvalue);
			$name = str_replace(array('~', '-', '--', '_', '.', '*'), ' ', $salvaged_filename); }	
		else { $file_plus_custom = null; $customvalue = null; $name = str_replace(array('~', '-', '--', '_', '.', '*'), ' ', $rawname); }
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
			$name = "<span class='ssfa-filename'>".ucwords($name)."</span>"; $customvalue = ucwords($customvalue); $customdata = ucwords($customdata);
			include SSFA_INCLUDES.'file-type-icons.php'; 
			$count += 1;	
			if ($nolinks === 'yes' || $nolinks === 'true'):
				$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' style='cursor:default'>"; 
				$nolinkstable = "<a style='cursor:default'>"; 
			else:	
				$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' href='$link' $linktype>"; 
				$nolinkstable = "<a href='$link' $linktype>";
			endif;
			if (!$type || $type !== 'table'): 				
				$thefiles .= 				
					"$nolinkslist<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $name $listfilesize</span> $datemodified</div></a>"; 				
			elseif ($type === 'table'):
				$thefiles .= 
					"<tr><td class='ssfa-sorttype $style-first-column'>$nolinkstable$icon $ext</a></td>
					<td class='ssfa-sortname'>$nolinkstable$name</a></td>";
				if ($customdata):
					$customvalues = explode(';', $customvalue);
					foreach($customarray as $k=> $customdatum):
						if ($customdatum !== null):
							$value = trim($customvalues[$k], ' ');								
							$thefiles .= "<td class='ssfa-sortcustomdata'>".$value."</td>";
						endif;
					endforeach;
				endif;
				$thefiles .= ($mod !== 'no' ? "<td class='ssfa-sortdate' data-value='$sortdatekey'>$sortdate</td>" : null);						
				$thefiles .= ($size !== 'no' ? "<td class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null);
				$thefiles .= '</tr>'; 
			endif;	
		endif;
	endforeach;
	$thefiles .= ($type === 'table' ? '</tbody></table></div>' : '</div>');
	if ($debug === 'on' && $logged_in): include SSFA_INCLUDES.'file-away-debug.php'; return ssfa_debug($url, $original_dir);
	elseif ($logged_in && $private_content && $count !== 0): return $thefiles; 	
	elseif ($private_content !== true && $count !== 0): return $thefiles; 
	elseif ($directories && ($private_content !== true || ($logged_in && $private_content))): return $thefiles;
	endif;
}

?>