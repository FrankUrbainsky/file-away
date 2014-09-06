<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(class_exists('fileaway_attributes') && !class_exists('attachaway'))
{
	class attachaway extends fileaway_attributes
	{
		public function __construct()
		{
			parent::__construct();
			add_shortcode('attachaway', array($this, 'sc'));
		}
		public function sc($atts)
		{
			$get = new fileaway_definitions;
			extract($get->pathoptions);
			extract($this->correctatts(wp_parse_args($atts, $this->attachaway), $this->shortcodes['attachaway'], 'attachaway'));
			if(!fileaway_utility::visibility($hidefrom, $showto)) return;
			if($this->op['javascript'] == 'footer') $GLOBALS['fileaway_add_scripts'] = true;
			if($this->op['stylesheet'] == 'footer') $GLOBALS['fileaway_add_styles'] = true;
			$randcolor = array ("red","green","blue","brown","black","orange","silver","purple","pink");
			$count = 0;
			$uid = rand(0, 9999); 
			global $post; 
			$mimes = get_allowed_mime_types(); 
			$ascdesc = $desc ? 'DESC' : 'ASC'; 
			if(!$postid)
			{
				$id = $post->ID;
				$attachments = get_posts(array(
					'orderby'			=> $orderby,
					'order'				=> $ascdesc,
					'post_type'			=> 'attachment',
					'posts_per_page'	=> -1,
					'post_parent'		=> $post->ID
				)); 
			}
			else
			{
				$id = $postid;
				$attachments = get_posts(array(
					'orderby'			=> $orderby,
					'order'				=> $ascdesc,
					'post_type'			=> 'attachment',
					'posts_per_page'	=> -1,
					'post_parent'		=> $postid
				));
			}
			if($debug === 'on' && is_user_logged_in()) return $this->debug($id, $attachments); 
			$thefiles = "<div id='ssfa-meta-container-$uid' class='ssfa-meta-container'>";
			include fileaway_dir.'/lib/inc/inc.styles.php';
			if($type === 'table')
			{
				$typesort = null; 
				$filenamesort = null; 
				$capsort = null; 
				$dessort = null; 
				$sizesort = null;
				if($sortfirst === 'type') $typesort = " data-sort-initial='true'"; 
				elseif($sortfirst === 'type-desc') $typesort = " data-sort-initial='descending'"; 
				elseif($sortfirst === 'filename') $filenamesort = " data-sort-initial='true'"; 
				elseif($sortfirst === 'filename-desc') $filenamesort = " data-sort-initial='descending'";
				elseif($sortfirst === 'caption') $capsort = " data-sort-initial='true'"; 
				elseif($sortfirst === 'caption-desc') $capsort = " data-sort-initial='descending'";
				elseif($sortfirst === 'description') $dessort = " data-sort-initial='true'"; 
				elseif($sortfirst === 'description-desc') $dessort = " data-sort-initial='descending'";
				elseif($sortfirst === 'size') $sizesort = " data-sort-initial='true'"; 
				elseif($sortfirst === 'size-desc') $sizesort = " data-sort-initial='descending'";
				else $filenamesort = " data-sort-initial='true' "; 
		 		$thefiles .= 
					"<script type='text/javascript'>jQuery(function(){jQuery('.footable').footable();});</script>$searchfield2".
					"<table id='ssfa-table' data-filter='#filter-$uid'$page class='footable ssfa-sortable $style$textalign'><thead><tr>".
					"<th class='ssfa-sorttype $style-first-column' title=\""._x('Click to Sort', 'Column Sort Message', 'file-away')."\"".$typesort.">".
						_x('Type', 'File Type Column', 'file-away').
					"</th>".
					"<th class='ssfa-sortname' title=\""._x('Click to Sort', 'Column Sort Message', 'file-away')."\"".$filenamesort.">".
						_x('File&nbsp;Name', 'File Name Column', 'file-away').
					"</th>";
				$thefiles .= $capcolumn 
					? "<th class='ssfa-sortcapcolumn' title=\""._x('Click to Sort', 'Column Sort Message', 'file-away')."\"".$capsort.">".$capcolumn."</th>" 
					: null;
				$thefiles .= $descolumn 
					? "<th class='ssfa-sortdescolumn' title=\""._x('Click to Sort', 'Column Sort Message', 'file-away')."\"".$dessort.">".$descolumn."</th>" 
					: null;
				$thefiles .= $size !== 'no' 
					? "<th class='ssfa-sortsize' data-type='numeric' title=\""._x('Click to Sort', 'Column Sort Message', 'file-away')."\"".$sizesort.">".
						_x('Size', 'File Size Column', 'file-away')."</th>" 
					: null;
				$thefiles .= "</tr></thead><tfoot><tr><td colspan='100'>$pagearea</td></tr></tfoot><tbody>";
			}
			if(is_array($attachments))
			{ 
				foreach($attachments as $attachment)
				{
					$meta = fileaway_utility::getattachment($attachment->ID); 
					$caption = $meta['caption']; 
					$alt = $meta['alt']; 
					$description = $meta['description'];
					$postlink = $meta['postlink']; 
					$filelink = $meta['filelink']; 
					$metatitle = $meta['title'];
					$filetype = wp_check_filetype($filelink); 
					$ext = $filetype['ext']; 
					$extension = $ext; 
					$basename = basename($filelink);
					$rawname = str_replace('.'.$ext, '', $basename); 
					$filename = str_replace(array('~', '-', '--', '_', '.', '*'), ' ', $rawname); 
					$oext = $ext; 
					$title = ($metatitle ? $metatitle : $filename);
					if(strtoupper($caption) === $caption) $caption = strtolower($caption);
					if(strtolower($caption) === $caption) $caption = fileaway_utility::sentencecase($caption);
					if(strtoupper($description) === $description) $description = strtolower($description);
					if(strtolower($description) === $description) $description = fileaway_utility::sentencecase($description);
					if(strtoupper($title) === $title) $title = strtolower($title);
					$title = "<span class='ssfa-filename'>".fileaway_utility::strtotitle($title)."</span>"; 
					$ext = !$ext ? '?' : $ext; 
					$ext = strtolower($ext); 
					$ext = substr($ext,0,4).'';
					$bytes = filesize(get_attached_file($attachment->ID));
					if($size !== 'no')
					{ 
						$fsize = fileaway_utility::formatBytes($bytes, 1); 
						$fsize = !preg_match('/[a-z]/i', $fsize) ? '1k' : ($fsize === 'NAN' ? '0' : $fsize);
					}
					include fileaway_dir.'/lib/inc/inc.colors.php';
					$listfilesize = $type !== 'table' && $size !== 'no' 
						? ($style === "ssfa-minimal-list" 
							? "<span class='ssfa-listfilesize'> ($fsize)</span>" 
							: "<span class='ssfa-listfilesize'>$fsize</span>") 
						: null;
					$file = $basename;
					$manager = false;
					$onlyaudio = false;
					include fileaway_dir.'/lib/inc/inc.filters.php';
					if($excluded) continue; 
					$getthumb = false;
					$thumbnails = false;
					include fileaway_dir.'/lib/inc/inc.icons.php';
					$count += 1;
					if($type !== 'table')
					{ 
						$thefiles .= 
							"<a id='ssfa' class='$display$noicons$colors' href='$filelink' $linktype>".
							"<div class='ssfa-listitem $ellipsis'><span class='ssfa-topline'>$icon $title $listfilesize</span></div>".
							"</a>"; 
					}
					else
					{
						$thefiles .= 				
							"<tr><td class='ssfa-sorttype $style-first-column'><a href='$filelink' $linktype>$icon $ext</a></td>".
							"<td class='ssfa-sortname'><a href='$filelink' class='$colors' $linktype>$title</a></td>"; 
						$thefiles .= ($capcolumn ? "<td class='ssfa-sortcapcolumn'>$caption</td>" : null);
						$thefiles .= ($descolumn ? "<td class='ssfa-sortdescolumn'>$description</td>" : null);
						$thefiles .= ($size !== 'no' ? "<td class='ssfa-sortsize' data-value='$bytes'>$fsize</td>" : null);
						$thefiles .= '</tr>';
					} 
				}
				$thefiles .= $type === 'table' ? '</tbody></table></div>' : '</div>';
				$thefiles .= "</div>";
			}
			return $count > 0 ? $thefiles : null;
		}
		public function debug($id, $attachments)
		{
			$post_title = get_the_title($id);
			$idcheck = get_post($id);
			if(!$attachments)
			{ 
				if($idcheck)
				{ 
					if($post_title !== '') $post_title = '<em>'.$post_title.'</em>,'; 
					else $post_title = null;  
					return 
						"<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>".
							"<img src='".fileaway_url."/lib/img/attachaway_banner.png' style='width:300px; box-shadow:none!important; border-radius:0!important; border:0!important'>".
							"<br /><br />".
							"You\'re trying to display attachments from $post_title post ID $id, but there\'s nothing attached to that one.".
						"</div>"; 
				}
				else
				{  
					return 
						"<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>".
							"<img src='".fileaway_url."/lib/img/attachaway_banner.png' style='width:300px; box-shadow:none!important; border-radius:0!important; border:0!important'>".
							"<br /><br />".
							"You\'re trying to display attachments from post ID $id, but I\'m not sure that post even exists.".
						"</div>";
				}
			}
			else
			{
				if($post_title !== '') $post_title = "<em>$post_title</em>,"; 
				else $post_title = null;  
				return 
					"<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>".
						"<img src='".fileaway_url."/lib/img/attachaway_banner.png' style='width:300px; box-shadow:none!important; border-radius:0!important; border:0!important'>".
						"<br /><br />".
						"You\'re trying to display attachments from $post_title post ID $id. It\'s got stuff attached. Maybe you\'ve excluded everything?'".
					"</div>"; 
			}
		}
	}
}