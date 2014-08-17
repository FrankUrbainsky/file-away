<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
// THE FILE AWAY SHORTCODE
add_shortcode('fileaway', 'sssc_fileaway');
function sssc_fileaway($atts){
	extract(shortcode_atts(array(
		// Config
		'type'		  	=> '',
		'base'		  	=> '',
		'sub'		  	=> '',
		'name' 			=> '',
		'paginate'	  	=> '',
		'pagesize'	  	=> '',
		'search'	  	=> '',
		'customdata'  	=> '',
		'sortfirst'   	=> '',
		's2skipconfirm' => '',
		'mod'		  	=> '',
		'size'		  	=> '',
		'nolinks'	  	=> '',		
		'debug'		  	=> '',
		// Modes
		'recursive'	  	=> '', 		
		'directories' 	=> '',
		'manager' 	  	=> '',
		'password'	  	=> '',
		'role_override' => '',
		'user_override' => '',
		'dirman_access' => '',
		'drawericon' 	=> '',
		'drawerlabel' 	=> '',
		'playback'		=> false,
		'playbackpath'	=> false,
		'playbacklabel' => 'Type',
		'onlyaudio'		=> '',
		'loopaudio'		=> 'false',
		'bulkdownload'	=> false,
		// Filters
		'images'	  	=> '',
		'code'		  	=> '',
		'exclude'	  	=> '',		
		'include'	  	=> '',
		'only'		  	=> '',
		'excludedirs'	=> false,
		'onlydirs'		=> false,
		'showto'  	  	=> '', 
		'hidefrom'    	=> '',	
		// Styles
		'style'		  	=> '',
		'width'		  	=> '',
		'perpx'		  	=> '',
		'align'		  	=> '',
		'textalign'	  	=> '',
		'heading'	  	=> '',
		'hcolor'	  	=> '',
		'color'		  	=> '',
		'accent'	  	=> '',
		'iconcolor'	  	=> '',
		'corners'	  	=> '',
		'display'	  	=> '',
		'icons'		  	=> '',
		'thumbnails'	=> false,
		'maxsrcbytes'	=> '1887436.8',
		'maxsrcheight'	=> '2500',
		'maxsrcwidth'	=> '3000',
		'thumbstyle'	=> 'widerounded',
		'graythumbs'	=> false,
	), $atts));
	global $ssfa_abspath, $ssfa_install; $thefiles = null; $included = null; $excluded = null; $rawnames = null; $iconstyle = null; $icocol = null; 
	$path = null; $ssh = null; $sh = null; $td = null; $bb = null; $fafl = null; $faui = null; $faun = null; $faur = null; $direxcluded = 0; 
	$current_user = wp_get_current_user(); $logged_in = is_user_logged_in(); $showtothese = true; $getthumb = false; 
	$type = $playback ? "table" : $type; $playback = !$playback ? false : ($playback === 'extended' ? 'extended' : 'compact'); 
	$color = ($type === "table" && !$color ? "classic" : ($type === "table" && $color === "random" ? false : $color));
	$iconcolor = ($type === "table" && !$iconcolor ? "classic" : ($type === "table" && $iconcolor === "random" ? false : $iconcolor));
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
	$fa_username = ($logged_in ? strtolower($current_user->user_login) : 'fa-nulldirectory');
	$fa_firstlast = ($logged_in ? strtolower($current_user->user_firstname.$current_user->user_lastname) : 'fa-nulldirectory');
	$fa_userrole = ($logged_in ? strtolower(ssfa_currentrole()) : 'fa-nulldirectory');
	$uid = rand(0, 9999); $randcolor = array("red","green","blue","brown","black","orange","silver","purple","pink");
	$tz = get_option('timezone_string'); $timezone = ($tz === '' ? 'UTC' : $tz);
	if (SSFA_JAVASCRIPT === 'footer'): $GLOBALS['ssfa_add_scripts'] = true; endif;
	if (SSFA_STYLESHEET === 'footer'): $GLOBALS['ssfa_add_styles'] = true; endif;
	$s2mem = $base === 's2member-files' && $GLOBALS['ssfa_s2member'] ? true : false;
	$base = ($base === '1' ? SSFA_BASE1 : ($base === '2' ? SSFA_BASE2 : 
			($base === '3' ? SSFA_BASE3 : ($base === '4' ? SSFA_BASE4 : 
			($base === '5' ? SSFA_BASE5 : ($s2mem ? 'wp-content/plugins/s2member-files/' : SSFA_BASE1))))));
	$base = trim($base, '/'); $base = trim($base, '/');
	if($s2mem): $sub = false; $directories = false; $recursive = false; $manager = false; $s2skip = $s2skipconfirm === 'yes' ? '&s2member_skip_confirmation' : ''; endif;
	$sub = ($sub ? trim($sub, '/') : false); $dir = ($sub ? $base.'/'.$sub : $base);
	include SSFA_INCLUDES.'private-content.php';  
	$dir = (str_replace('//', '/', "$dir"));
	$dir = (SSFA_ROOT === 'siteurl' ? $dir : ($ssfa_install ? $ssfa_install.$dir : $dir));
	if ($private_content == true && !is_dir("$dir")) return null;
	$name = ($name ? $name : "ssfa-meta-container-$uid" );
	$thefiles .= "<div id='$name' class='ssfa-meta-container'>";
	$manager = $playback ? false : $manager;
	if($manager) include SSFA_INCLUDES.'manager-access.php';
	if($manager): $type = 'table'; $directories = 1; $bulkdownload = false; endif;
	$bulkclass = $bulkdownload ? 'bd-table' : ($manager ? 'mngr-table' : null);
	$start = "$dir";
	if($type !== 'table') $bulkdownload = false;
	if($directories) include SSFA_INCLUDES.'directory-tree-navigation.php';
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
		if ($directories) $filename = $drawerlabel ? $drawerlabel : "File/Drawer"; else $filename = "File Name";
		if($manager):
			$path = '<input type="hidden" id="ssfa-nomenclature" value="" />';
			$ss = explode('/', $start); $ss = end($ss);
			$ssh = '<input type="hidden" id="ssfa-whymenclature" data-path="'.$ss.'" value="'.$ss.'" />';		
			$sh = '<input type="hidden" id="ssfa-yesmenclature" data-path="'.$start.'" value="'.$start.'" />';
			$td = '<input type="hidden" id="ssfa-bad-motivator" data-path="'.trim("$dir",'/').'" value="'.trim("$dir",'/').'" />';
			$bb = '<input type="hidden" id="ssfa-smooth-operator" data-path="'.$basebase.'" value="'.$basebase.'" />';
			if($private_content):
				$fafl = null; if($fa_firstlast_used): $fafl = "<input type='hidden' id='ssfa-fafl' value=\"$fa_firstlast\" />"; endif;
				$faui = null; if($fa_userid_used): $faui = "<input type='hidden' id='ssfa-faui' value=\"$fa_userid\" />"; endif;
				$faun = null; if($fa_username_used): $faun = "<input type='hidden' id='ssfa-faun' value=\"$fa_username\" />"; endif;
				$faur = null; if($fa_userrole_used): $faur = "<input type='hidden' id='ssfa-faur' value=\"$fa_userrole\" />"; endif;
			endif;
		endif;
		$typelabel = $playback ? $playbacklabel : "Type";
		$typesorter = $playback ? "data-sort-ignore='true'" : "title='Click to Sort' $typesort";
		$drawericon = $drawericon ? $drawericon : 'drawer';
		$data_atts = $manager ? "data-uid='".$uid."' data-pg='".$GLOBALS['post']->ID."' data-drw=\"$drawericon\" data-cls=\"$style\"" : null;
		$thefiles .= 
			"<script type='text/javascript'>jQuery(function(){ jQuery('.footable').footable();});</script>$searchfield2".
			"<table id='ssfa-table' data-filter='#filter-$uid' $page class='footable ssfa-sortable $style $textalign $bulkclass' $data_atts><thead><tr>".
			"<th class='ssfa-sorttype $style-first-column' $typesorter>".$typelabel."</th>".
			"<th class='ssfa-sortname' title='Click to Sort'".$filenamesort.">$filename$path$ssh$sh$td$bb$fafl$faui$faun$faur</th>";
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
	if($recursive || $directories):
		$globaldirexes = array(); $localdirexes = array(); 
		if ($excludedirs) $localdirexes = preg_split ( '/(, |,)/', $excludedirs );
		if (SSFA_DIR_EXCLUSIONS) $globaldirexes = preg_split ( '/(, |,)/', SSFA_DIR_EXCLUSIONS );
		$direxes = array_unique(array_merge($localdirexes, $globaldirexes)); $excludedirs = count($direxes) > 0 ? $direxes : false;
		$justthesedirs = $onlydirs ? preg_split ( '/(, |,)/', $onlydirs ) : 0; $onlydirs = count($justthesedirs) > 0 ? $justthesedirs : 0;
	endif;
	if ($directories):
		$thecells = explode(',', $cells); $ccell = count($thecells); 
		if($manager && $dirman):
			$thefiles .= 
				"<tr id='row-ssfa-create-dir-$uid' class='ssfa-drawers'>".
					"<td id='folder-ssfa-create-dir-$uid' data-value='0' class='ssfa-sorttype $style-first-column'>".
						"<a id='ssfa-create-dir-$uid' href='javascript:'>".
							"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-chart-alt' aria-hidden='true'></span>".
							"<br>new".
						"</a>".
					"</td>".
					"<td id='name-ssfa-create-dir-$uid' data-value='0' class='ssfa-sortname'>".
						'<input id="input-ssfa-create-dir-'.$uid.'" type="text" placeholder="Name Your Sub-Directory" " value="" '.
							'style="width:90%; height:26px; font-size:12px; text-align:center; display:none">'.
					"</td>";
			$icell = 0;
			foreach ($thecells as $cell): $icell++; 
				if($icell < $ccell):
					$thefiles .= "<td class='$style'> &nbsp; </td>"; 
				else: 
					$thefiles .= "<td id='manager-ssfa-create-dir-$uid' class='$style'> &nbsp; </td>";
				endif;
			endforeach;
		endif;
		$checksubdirs = array_filter(glob("$dir"."/*"), 'is_dir');
		if(count($checksubdirs) > 0): $f = 0;
			foreach ( glob("$dir"."/*", GLOB_ONLYDIR) as $k=> $folder ):
				if($onlydirs): $direxcluded = 1; foreach($onlydirs as $onlydir): if(strripos("$folder", "$onlydir") !== false){$direxcluded = 0; continue;} endforeach; endif;
				if($excludedirs): foreach($excludedirs as $exclude): if(strripos("$folder", "$exclude") !== false) continue 2; endforeach; endif;
				if (! $direxcluded):			
					$f++; $dlink = ssfa_replace_first("$basebase", '', "$folder");
					$folder = str_replace("$dir".'/', '', "$folder");
					$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$folder"); 
					$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder");
					$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
					$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder");
					$prettyfolder = ssfa_strtotitle($prettyfolder);
					$dpath = ltrim("$dlink", '/'); $dlink = str_replace('/', '*', "$dpath");
					$managedir = $manager && $dirman ? "<a href='' id='rename-ssfa-dir-$uid-$f'>Rename</a><br><a href='' id='delete-ssfa-dir-$uid-$f'>Delete</a></td>" : ' &nbsp; '; 
					$renamedir = $manager && $dirman ? '<input id="rename-ssfa-dir-'.$uid.'-'.$f.'" type="text" value="'.$folder.'" '.
						'style="width:90%; height:26px; font-size:12px; text-align:center; display:none">' : null;
					$thefiles .= 
						"<tr id='ssfa-dir-$uid-$f' class='ssfa-drawers'>".
							"<td id='folder-ssfa-dir-$uid-$f' data-value='00-$folder' class='ssfa-sorttype $style-first-column'>".
								"<a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\" data-name=\"".$folder."\" data-path=\"".$dpath."\">".
									"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-$drawericon' aria-hidden='true'></span>".
									"<br>dir".
								"</a>".
							"</td>".
							"<td id='name-ssfa-dir-$uid-$f' data-value='00-$folder' class='ssfa-sortname'>".
								"<a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\">".
									"<span style='text-transform:uppercase;'>$prettyfolder</span>".
								"</a>".$renamedir.
							"</td>"; 			
					$icell = 0;
					foreach ($thecells as $cell): $icell++; 
						if($icell < $ccell):
							$thefiles .= "<td class='$style'> &nbsp; </td>"; 
						else: 
							$thefiles .= "<td id='manager-ssfa-dir-$uid-$f' class='$style'>$managedir</td>";
						endif;
					endforeach;
					$thefiles .= "</tr>";
				endif;
			endforeach;
		endif;
	endif;
	if($directories) $recursive = 0;
	$files = $recursive ? ssfa_recursive_files($dir, $onlydirs, $excludedirs) : scandir($dir); 
	date_default_timezone_set($timezone); natcasesort($files); $count = 0; $original_dir = $dir;
	if(is_array($files)):
		foreach($files as $file):
			$link = ($recursive ? "$url/$file" : "$url/$dir/$file"); 
			$slices = pathinfo($link); $extension = isset($slices['extension']) ? $slices['extension'] : false;
			include SSFA_INCLUDES.'includes-excludes.php'; 
			if ($excluded == false):			
				$exts[] = $extension;
				$locs[] = $slices['dirname']; 
				$fulls[] = $slices['basename']; 
				$rawnames[] = $slices['filename'];
				$links[] = ($recursive ? "$url/$file" : "$url/$dir/$file");
				$dirs[] = ($recursive ? str_replace($slices['basename'], '', $file) : $dir);		
			endif;
		endforeach;
	endif;
	$fcount = count($rawnames);
	if($fcount < 1): if($debug === 'on' && $logged_in): include SSFA_INCLUDES.'file-away-debug.php'; return ssfa_debug($url, $original_dir); 
	elseif($fcount < 1 && !$directories): return; endif; endif;
	if($playback): $GLOBALS['ssfa_playback_script'] = true; $used = array(); $sources = $GLOBALS['ssfa_audio']; endif;
	$thumbnails = $thumbnails && $type === 'table' && extension_loaded('gd') && function_exists('gd_info') ? $thumbnails : false;
	if($thumbnails): 
		$graythumbs = $graythumbs ? ' ssfa-thumb-bw' : '';
		$thumbstyles = array('widerounded','widesharp','squarerounded','squaresharp','oval','circle'); 
		$thumbstyle = in_array($thumbstyle, $thumbstyles) ? $thumbstyle : 'widerounded';
		$thumbwidth = in_array($thumbstyle, array('widerounded','widesharp','oval')) ? 60 : 40; $thumbheight = 40; 
		$thumbfix = $thumbwidth == 60 ? 'wd_' : 'sq_';
		if($thumbnails !== 'permanent'):
			$maxsrcbytes = preg_replace('/[^\\d.]+/', '', $maxsrcbytes);
			$maxsrcwidth = preg_replace('/[^\\d.]+/', '', $maxsrcwidth);
			$maxsrcheight = preg_replace('/[^\\d.]+/', '', $maxsrcheight);
		endif;
	endif;
	if(is_array($rawnames)):
		asort($rawnames);
		foreach($rawnames as $k => $rawname):
			if($playback && in_array($rawname, $used) && in_array($exts[$k], $sources)) continue;
			$link = $links[$k]; $loc = $locs[$k]; $ext = $exts[$k]; $oext = $ext; $extension = strtolower($ext); $full = $fulls[$k]; $dir = $dirs[$k]; $file = $full;
			if($onlydirs): foreach($onlydirs as $only): $keeper = 0; if(strpos("$dir", "$only") !== false){ $keeper = 1; break;} endforeach; if(!$keeper) continue; endif;
			if($excludedirs): foreach($excludedirs as $ex): if(strpos("$dir", "$ex") !== false) continue 2; endforeach; endif;
			if (preg_match('/\[([^\]]+)\]/', $rawname)){
				$file_plus_custom = $rawname;
				list($salvaged_filename, $customvalue) = preg_split("/[\[\]]/", $file_plus_custom);
				$customvalue = str_replace(array('~', '--', '_', '.', '*'), ' ', $customvalue);
				$customvalue = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$customvalue");
				$customvalue = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$customvalue");
				$customvalue = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$customvalue");						
				$thename = str_replace(array('~', '--', '_', '.', '*'), ' ', $salvaged_filename); }	
			else { $file_plus_custom = null; $customvalue = null; $thename = str_replace(array('~', '--', '_', '.', '*'), ' ', $rawname); $salvaged_filename = $rawname;}
			$thename = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$thename"); 
			$thename = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$thename"); 
			$thename = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$thename"); 
			$ext = (!$ext ? '?' : $ext); $ext = substr($ext,0,4);
			$bytes = filesize($dir.'/'.$file); $sortdatekey = date("YmdHis", filemtime($dir.'/'.$file)); 
			$sortdate = (SSFA_DAYMONTH === 'dm' ? date("g:i A d/m/Y", filemtime($dir.'/'.$file)) : date("g:i A m/d/Y", filemtime($dir.'/'.$file)));
			$date = date("F d, Y", filemtime($dir.'/'.$file)); $time = date("g:i A", filemtime($dir.'/'.$file));		
			if(is_file($dir.'/'.$file) && $thename !== ''):
				if($size !== 'no'): $fsize = ssfa_formatBytes($bytes, 1); $fsize = (!preg_match('/[a-z]/i', $fsize) ? '1k' : ($fsize === 'NAN' ? '0' : $fsize)); endif;
				if($thumbnails): $getthumb = in_array($extension, array('jpg','jpeg','gif','png')) ? true : false; endif;
				if($manager && $thumbnails && stripos($file, '_thumb_') !== false) $getthumb = false;
				if($getthumb): 	
					$srcpath = (SSFA_ROOT === 'siteurl' ? stripslashes($dir) : 
						($ssfa_install ? ssfa_replace_first($ssfa_install, '', stripslashes($dir)) : stripslashes($dir)));
					if($thumbnails !== "permanent"):
						$imgprop = getimagesize($ssfa_abspath.$srcpath.'/'.$file);
						while($getthumb):
							if(isset($imgprop[0]) && $maxsrcwidth && $imgprop[0] > $maxsrcwidth): $getthumb = false; break; endif;
							if(isset($imgprop[1]) && $maxsrcheight && $imgprop[1] > $maxsrcheight): $getthumb = false; break; endif;
							if($maxsrcbytes && $bytes > $maxsrcbytes): $getthumb = false; break; endif; 
							break;
						endwhile;
					elseif($thumbnails === 'permanent'):
						if(!is_file($ssfa_abspath.$srcpath.'/_thumb_'.$thumbfix.$file)) 
							ssfa_createthumb($ssfa_abspath.$srcpath.'/'.$file, $ssfa_abspath.$srcpath.'/_thumb_'.$thumbfix.$file, $extension, $thumbwidth, $thumbheight);
						$thumblink = is_file($ssfa_abspath.$srcpath.'/_thumb_'.$thumbfix.$file) ? str_replace($file, '_thumb_'.$thumbfix.$file, $link) : false;
					endif;
				endif; 
				if($iconcolor): $icocol = " ssfa-$iconcolor"; endif;
				if($color && !$accent): $accent = $color; $colors = " ssfa-$color accent-$accent"; endif;
				if($color && $accent): $colors = " ssfa-$color accent-$accent"; endif;
				if(($color) && !($iconcolor)): $useIconColor = $randcolor[array_rand($randcolor)]; $icocol = " ssfa-$useIconColor"; endif; 
				if(!($color) && ($iconcolor)): $useColor = $randcolor[array_rand($randcolor)]; $colors = " ssfa-$useColor accent-$useColor"; endif;
				if(!($color) && !($iconcolor)): $useColor = $randcolor[array_rand($randcolor)]; $colors = " ssfa-$useColor accent-$useColor"; $icocol = " ssfa-$useColor"; endif; 
				$datemodified = ($type !== 'table' && $mod === 'yes' ? "<div class='ssfa-datemodified'>Last modified $date at $time</div>" : null);
				$listfilesize = ($type !== 'table' && $size !== 'no' ? 
					($style === 'ssfa-minimal-list' ? "<span class='ssfa-listfilesize'>($fsize)</span>" 
					: "<span class='ssfa-listfilesize'>$fsize</span>") : null);
				$audiocorrect = $playback === 'extended' ? "style='margin-right:10px;'" : ($playback ? "style='display:block; margin-bottom:5px;'" : null);
				$thename = "<span class='ssfa-filename' $audiocorrect>".ssfa_strtotitle($thename)."</span>"; 
				$link = $s2mem ? $url.'/?s2member_file_download='.$file.$s2skip : $link;
				$fulllink = 'href="'.$link.'"';
				include SSFA_INCLUDES.'file-type-icons.php'; 
				$linktype = $s2mem ? '' : $linktype;
				if($playback): $skipthis = 0; include SSFA_INCLUDES.'playback.php'; if($skipthis): continue; endif; else: $player = null; $players = null; endif;
				$count += 1;	
				if($nolinks === 'yes' || $nolinks === 'true'):
					$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' style='cursor:default'>"; 
					$nolinkstable = "<a id='ssfa' class='$colors' style='cursor:default'>"; 
				else:	
					$nolinkslist = "<a id='ssfa' class='$display$noicons$colors' $fulllink $linktype>"; 
					$nolinkstable = "<a id='ssfa' class='$colors' $fulllink $linktype>";
				endif;
				if(!$type || $type !== 'table'): 				
					$thefiles .= 				
						"$nolinkslist<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $thename $listfilesize</span> $datemodified</div></a>"; 				
				elseif($type === 'table'):
					$oext = ($manager || $bulkdownload ? $oext : null);
					$filepath = ($manager || $bulkdownload ? '<input id="filepath-ssfa-file-'.$uid.'-'.$count.'" type="hidden" value="'.$dir.'" />' : null);
					$oldname = ($manager || $bulkdownload ? '<input id="oldname-ssfa-file-'.$uid.'-'.$count.'" type="hidden" value="'.$rawname.'" />' : null);
					$salvaged_filename = ($manager? trim($salvaged_filename, ' ') : $salvaged_filename);
					if ($manager && $customdata) 
						$fileinput = '<input id="rawname-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$salvaged_filename.'" '.
							'style="width:80%; height:26px; font-size:12px; text-align:center; display:none">';
					elseif ($manager && ! $customdata) 
						$fileinput = '<input id="rawname-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$rawname.'" '.
							'style="width:80%; height:26px; font-size:12px; text-align:center; display:none">';
					else $fileinput = null;
					if($playback && in_array($rawname, $used)): 
						if($has_sample && $playback === 'compact'): $iconarea = $player; $thefinalname = $thename;
						elseif($has_sample && $playback === 'extended'): $iconarea = "<br>$nolinkstable$icon</a>"; $thefinalname = $thename.$players.$player; $players = null;
						elseif(!$has_sample && $has_multiple): $thefinalname = $thename; $iconarea = "<br>$nolinkstable$icon</a>"; 
						elseif(!$has_sample && !$has_multiple): $iconarea = "$nolinkstable$icon $ext</a>"; $thefinalname = "$nolinkstable$thename</a>"; $players = null;
						endif;
					else: 
						$iconarea = "$nolinkstable$icon $ext</a>"; $thefinalname = "$nolinkstable$thename</a>"; $players = null;
					endif;
					if($getthumb): $iconarea = "$nolinkstable$icon</a>"; endif;
					$thefiles .= 
						"<tr id='ssfa-file-$uid-$count' class=''>".
						"<td id='filetype-ssfa-file-$uid-$count' class='ssfa-sorttype $style-first-column'>$iconarea<input type='hidden' value='$oext' /></td>".
						"<td id='filename-ssfa-file-$uid-$count' class='ssfa-sortname'>$thefinalname$players $fileinput$filepath$oldname</td>";
					if($customdata):
						$customvalues = explode(',', $customvalue);
						foreach($customarray as $k=> $customdatum):
							if($customdatum !== null):
								$value = ssfa_strtotitle(trim($customvalues[$k], ' '));
								$custominput[$k] = ($manager ? 
									'<input id="customdata-'.$k.'-ssfa-file-'.$uid.'-'.$count.'" type="text" value="'.$value.'" '.
									'style="width:80%; height:26px; font-size:12px; text-align:center; display:none">' 
									: null);
								$thefiles .= "<td id='customadata-cell-$k-ssfa-file-$uid-$count' class='ssfa-sortcustomdata'>".
								"<span id='customadata-$k-ssfa-file-$uid-$count'>"."$value"."</span>".$custominput[$k]."</td>";
							endif;
						endforeach;
					endif;
					$thefiles .= ($mod !== 'no' ? "<td id='mod-ssfa-file-$uid-$count' class='ssfa-sortdate' data-value='$sortdatekey'>$sortdate</td>" : null);						
					$thefiles .= ($size !== 'no' ? "<td id='size-ssfa-file-$uid-$count' class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null);
					$thefiles .= ($manager ? "<td id='manager-ssfa-file-$uid-$count' class='ssfa-sortmanager'><a href='' id='rename-ssfa-file-$uid-$count'>Rename</a><br>".
					"<a href='' id='delete-ssfa-file-$uid-$count'>Delete</a></td>" : null);
					$thefiles .= '</tr>'; 
				endif;	
			endif;
		endforeach;
	endif;
	$thefiles .= ($type === 'table' ? '</tbody></table>' : null);
	if($manager) include SSFA_INCLUDES.'bulk-action-content.php';
	if($bulkdownload) include SSFA_INCLUDES.'bulk-download-content.php'; 
	$thefiles .= "</div></div>";
	if($debug === 'on' && $logged_in): include SSFA_INCLUDES.'file-away-debug.php'; return ssfa_debug($url, $original_dir);
	elseif ($logged_in && $private_content && $count !== 0): return $thefiles; 	
	elseif ($private_content !== true && $count !== 0): return $thefiles; 
	elseif ($directories && ($private_content !== true || ($logged_in && $private_content))): return $thefiles;
	endif;
}