<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if($recursive || $directories)
{
	$globaldirexes = array(); $localdirexes = array(); 
	if($excludedirs) $localdirexes = preg_split('/(, |,)/', $excludedirs);
	if($this->op['direxclusions']) $globaldirexes = preg_split('/(, |,)/', $this->op['direxclusions']);
	$direxes = array_unique(array_merge($localdirexes, $globaldirexes)); 
	$excludedirs = count($direxes) > 0 ? $direxes : false;
	$justthesedirs = $onlydirs ? preg_split ( '/(, |,)/', $onlydirs ) : 0; 
	$onlydirs = count($justthesedirs) > 0 ? $justthesedirs : 0;
}
if($directories)
{
	$recursive = false;
	$ccell = count($cells); 
	if($manager && $dirman)
	{
		$thefiles .= 
			"<tr id='row-ssfa-create-dir-$uid' class='ssfa-drawers'>".
				"<td id='folder-ssfa-create-dir-$uid' data-value='# # # #' class='ssfa-sorttype $style-first-column'>".
					"<a id='ssfa-create-dir-$uid' href='javascript:'>".
						"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-chart-alt' aria-hidden='true'></span>".
						"<br>".__('new', 'file-away').
					"</a>".
				"</td>".
				"<td id='name-ssfa-create-dir-$uid' data-value='# # # #' class='ssfa-sortname'>".
					'<input id="input-ssfa-create-dir-'.$uid.'" type="text" placeholder="'.__('Name Your Sub-Directory', 'file-away').'" " value="" '.
						'style="width:90%; height:26px; font-size:12px; text-align:center; display:none">'.
				"</td>";
		$icell = 0;
		foreach($cells as $cell)
		{ 
			$icell++; 
			if($icell < $ccell) $thefiles .= "<td class='$style'> &nbsp; </td>"; 
			else $thefiles .= "<td id='manager-ssfa-create-dir-$uid' class='$style'> &nbsp; </td>";
		}
	}
	$checksubdirs = array_filter(glob("$dir"."/*"), 'is_dir');
	if(count($checksubdirs) > 0)
	{ 
		$f = 0;
		foreach(glob("$dir"."/*", GLOB_ONLYDIR) as $k=> $folder)
		{
			if($onlydirs)
			{ 
				$direxcluded = 1; 
				foreach($onlydirs as $onlydir)
				{ 
					if(strripos("$folder", "$onlydir") !== false)
					{
						$direxcluded = 0; 
						continue;
					} 
				}
			}
			if($excludedirs)
			{ 
				foreach($excludedirs as $exclude) if(strripos("$folder", "$exclude") !== false) continue 2; 
			}
			if(!$direxcluded)
			{			
				$f++; 
				$dlink = fileaway_utility::replacefirst("$folder", "$basebase", '');
				$folder = str_replace("$dir".'/', '', "$folder");
				$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$folder"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder");
				$prettyfolder = fileaway_utility::strtotitle($prettyfolder);
				$dpath = ltrim("$dlink", '/'); 
				$dlink = str_replace('/', '*', "$dpath");
				$managedir = $manager && $dirman 
					? 	"<a href='' id='rename-ssfa-dir-$uid-$f'>".__('Rename', 'file-away')."</a><br>".
						"<a href='' id='delete-ssfa-dir-$uid-$f'>".__('Delete', 'file-away')."</a></td>" 
					: 	' &nbsp; '; 
				$renamedir = $manager && $dirman ? '<input id="rename-ssfa-dir-'.$uid.'-'.$f.'" type="text" value="'.$folder.'" '.
					'style="width:90%; height:26px; font-size:12px; text-align:center; display:none">' : null;
				$thefiles .= 
					"<tr id='ssfa-dir-$uid-$f' class='ssfa-drawers'>".
						"<td id='folder-ssfa-dir-$uid-$f' data-value='# # # # # $folder' class='ssfa-sorttype $style-first-column'>".
							"<a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\" data-name=\"".$folder."\" data-path=\"".$dpath."\">".
								"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-$drawericon' aria-hidden='true'></span>".
								"<br>"._x('dir', 'abbrv. of *directory*', 'file-away').
							"</a>".
						"</td>".
						"<td id='name-ssfa-dir-$uid-$f' data-value='# # # # # $folder' class='ssfa-sortname'>".
							"<a href=\"".add_query_arg(array('drawer' => $dlink), get_permalink())."\">".
								"<span style='text-transform:uppercase;'>$prettyfolder</span>".
							"</a>".$renamedir.
						"</td>"; 			
				$icell = 0;
				foreach ($cells as $cell)
				{
					$icell++; 
					$thefiles .= $icell < $ccell 
						? "<td class='$style'> &nbsp; </td>" 
						: "<td id='manager-ssfa-dir-$uid-$f' class='$style'>$managedir</td>";
				}
				$thefiles .= "</tr>";
			}
		}
	}
}