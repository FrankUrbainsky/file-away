<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_management'))
{
	class fileaway_management
	{
		public $pathoptions;
		public $settings;
		public function __construct()
		{
			$define = new fileaway_definitions;
			$this->pathoptions = $define->pathoptions;
			$this->settings = get_option('fileaway_options');
			if(is_admin())
			{
				add_action('wp_ajax_fileaway-manager', array($this, 'manager'));
				add_action('wp_ajax_nopriv_fileaway-manager', array($this, 'manager'));
			}
		}
		public function manager()
		{
			if(!wp_verify_nonce($_POST['nonce'], 'fileaway-management-nonce')) 
				die('Go directly to jail. Do not pass GO. Do not collect $200 dollars.');
			extract($this->pathoptions);
			$action = $_POST['act'];
			// Flightbox
			if($action === 'flightbox')
			{
				$linktype = $GLOBALS['is_IE'] || $GLOBALS['is_safari'] ? 'target="_blank"' : 'download';
				list($url, $query) = explode('?', $_POST['url']);
				$src = $url;
				parse_str($query);
				$uid = (string)$_POST['uid'];
				$icons = (string)$_POST['icons'];
				$next = stripslashes($_POST['next']);
				$prev = stripslashes($_POST['prev']);
				$wh = $_POST['wh'];
				$ww = $_POST['ww'];
				if($wh > 1000)
				{ 
					$font = 20;
					$bar = 40;
					$mrg = 20;
				}
				elseif($wh > 800)
				{ 
					$font = 16;
					$bar = 32;
					$mrg = 16;
				}
				elseif($wh > 600)
				{ 
					$font = 14;
					$bar = 28;
					$mrg = 14;
				}
				elseif($wh > 400)
				{
					$font = 12;
					$bar = 24;
					$mrg = 12;
				}
				elseif($wh > 200)
				{ 
					$font = 8;
					$bar = 20;
					$mrg = 8;
				}
				if($t == 'image')
				{
					if($wh < ($mh+150)) $mh = ($wh-150);
					if($ww < $mw) $mw = ($ww-150);
					if($d == 'width')
					{ 
						$ratio = $w / $h;
						$width = $w < $mw ? $w : $mw;
						$height = round($width / $ratio, 0, PHP_ROUND_HALF_DOWN);
						if($height > $mh) $d = 'height';
					}
					if($d == 'height')
					{ 
						$ratio = $h / $w;
						$height = $h < $mh ? $h : $mh;
						$width = round($height / $ratio, 0, PHP_ROUND_HALF_DOWN);
					}
					if($width < 200)
					{
						$offset = ($ww-230) / 2;	
						$cwidth = 200+30;
						$cheight = ($height+$bar+30);
					}
					else
					{
						$offset = ($ww-($width+30)) / 2;	
						$cwidth = $width+30; 
						$cheight = ($height+$bar+30);
					}
					$csize = 'width:'.$cwidth.'px; height:'.$cheight.'px;';
					$isize = 'width:'.$width.'px; height:'.$height.'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$response = array(
						'html' =>
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0px!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.
									'<a href="javascript:" onclick="'.$next.'"><img src="'.$src.'" style="'.$isize.'"></a>'.
								'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="javascript:" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.'>'.
										'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => $cwidth.'px',
						'height' => $cheight.'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
					);
				}
				elseif($t == 'video')
				{	
					$ratio = 1920 / 1080;
					$height = round($w / $ratio, 0, PHP_ROUND_HALF_DOWN);
					if($wh < ($height+150))
					{ 
						$height = ($wh-150);
						$w = round($height * $ratio, 0, PHP_ROUND_HALF_DOWN);
					}
					$csize = 'width:'.($w+30).'px; height:'.($height+$bar+30).'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$offset = ($ww-($w+30)) / 2;
					$response = array(
						'html' => 
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.
									fileaway_utility::video(array(
										'src'=>$src,
										'height' => $height, 
										'width' => $w, 
										'class' => 'ssfa-flightbox-video-player', 
										'preload' => 'none',
										'id' => uniqid('flightbox-video-')
									)).
								'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="javascript:" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.'>'.
										'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => ($w+30).'px',
						'height' => ($height+$bar+30).'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
					);
				}
				elseif($t == 'pdf')
				{
					if($r == 'tall')
					{
						$ratio = 22 / 17;
						$height = ($wh-200);
						$width = round($height / $ratio, 0, PHP_ROUND_HALF_DOWN);
						$boxquery = '?t=pdf&r=wide';
						$rotate = 'expand';
					}
					else
					{
						$ratio = 22 / (17/1.5);
						$height = ($wh-200);
						$width = round($height * $ratio, 0, PHP_ROUND_HALF_DOWN);
						while($width > ($ww-200)) $width = $width-10;
						$boxquery = '?t=pdf&r=tall';
						$rotate = 'contract';
					}
					if($width < 200) $width = 200;
					$csize = 'width:'.($width+30).'px; height:'.($height+$bar+30).'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$offset = ($ww-($width+30)) / 2;
					$response = array(
						'html' => 
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.
									'<iframe src="'.$src.'" frameborder=0 height="'.$height.'" width="'.$width.'" name="'.basename($src).'" scrolling="no" seamless>'.
										'Your browser does not support iframes.'.
									'</iframe>'.
								'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="javascript:" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="flightbox(\''.$url.$boxquery.'\', \''.$uid.'\', \''.$_POST['theme'].'\', \''.$icons.'\');">'.
										'<span class="ssfa-icon-'.$rotate.'" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.'>'.
										'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => ($width+30).'px',
						'height' => ($height+$bar+30).'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
					);					
				}
			}
			// Create Sub-Directory
			elseif($action === 'createdir')
			{
				$parents = stripslashes(trim(str_replace('.', '', $_POST['parents']), '/'));
				$newsub = trim(str_replace('.', '', $_POST['newsub']), '/');
				$uid = $_POST['uid']; 
				$count = $_POST['count']; 
				$page = $_POST['pg']; 
				$drawericon = $_POST['drawer'];
				$cells = $_POST['cells']; 
				$class = $_POST['cls'];
				$base = $_POST['base']; 
				$subs = explode('/', $newsub); 
				$first = $subs[0]; 
				$last = $subs[count($subs)-1];
				$start = trim(fileaway_utility::replacefirst($parents, $base, '').'/'.$first, '/'); 
				$drawer = str_replace('/','*',$start);
				$final = $rootpath.$parents.'/'.$newsub; 
				$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$first"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = fileaway_utility::strtotitle($prettyfolder);
				if(is_dir($final)) $response = array('status'=>'error', 'message'=>__('That directory name already exists in this location.', 'file-away'));
				else
				{ 
					$first_exists = is_dir($rootpath.$parents.'/'.$first) ? true : false;
					if(mkdir($final, 0755, true)) 
					{ 
						fileaway_utility::indexmulti($rootpath.$parents.'/'.$newsub, $rootpath.$parents.'/'); 
						if(!$first_exists)
						{ 
							$status = "insert";
							$message = 
								"<tr id='ssfa-dir-$uid-$count' class='ssfa-drawers'>".
									"<td id='folder-ssfa-dir-$uid-$count' data-value=\"# # # # # $first\" class='ssfa-sorttype $class-first-column'>".
										"<a href=\"".add_query_arg(array('drawer' => $drawer), get_permalink($page))."\" data-name=\"".$first."\" data-path=\"".$start."\">".
											"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-$drawericon' aria-hidden='true'></span>".
											"<br>"._x('dir', 'abbrv. of *directory*', 'file-away').
										"</a>".
									"</td>".
									"<td id='name-ssfa-dir-$uid-$count' data-value='# # # # # $first' class='ssfa-sortname'>".
										"<a href=\"".add_query_arg(array('drawer' => $drawer), get_permalink($page))."\">".
											"<span style='text-transform:uppercase;'>$prettyfolder</span>".
										"</a>".
										"<input id='rename-ssfa-dir-$uid-$count' type='text' value=\"$first\" ".
											"style='width:90%; height:26px; font-size:12px; text-align:center; display:none'>".
									"</td>"; 	
							$icell = 1; 
							while($icell < $cells)
							{ 
								$message .= "<td class='$class'> &nbsp; </td>"; 
								$icell++; 
							}
							$message .= 
								"<td id='manager-ssfa-dir-$uid-$count' class='$class'>".
									"<a href='' id='rename-ssfa-dir-$uid-$count'>".__('Rename', 'file-away')."</a><br>".
									"<a href='' id='delete-ssfa-dir-$uid-$count'>".__('Delete', 'file-away')."</a>".
								"</td>";
							$message .= "</tr>";
						}
						else 
						{
							$status = "success"; 
							$message = __('Your sub-directories have been successfully created.', 'file-away');
						}
						$response = array('status'=>$status, 'message'=>$message, 'uid'=>$uid);
					}
					else 
					{
						$response = array('status'=>'error', 'message' => __('Sorry, there was a problem creating that directory for you.', 'file-away'));
					}
				}
			}
			// Rename Directory
			elseif($action === 'renamedir')
			{
				$oldpath = stripslashes(trim(str_replace('..', '', $_POST['oldpath']), '/'));
				$newname = str_replace(array('..','/'), '', $_POST['newname']);
				$pp = explode('/', $oldpath);
				$newpath = fileaway_utility::replacelast($oldpath, end($pp), $newname);
				$olddata = $_POST['datapath'];
				$datapp = explode('/', $olddata);
				$newdata = fileaway_utility::replacelast($olddata, end($datapp), $newname);
				$parents = stripslashes($_POST['parents']);
				$old = $parents.'/'.end($pp);
				$dst = $rootpath.$newpath;
				$src = $rootpath.$old;
				$page = $_POST['pg'];
				$drawer = str_replace('/', '*', $newdata);
				$newurl = add_query_arg(array('drawer' => $drawer), get_permalink($page));
				$response = false;
				if(is_dir($dst)) $response = array('status'=>'error', 'message' => __('That directory already exists.', 'file-away'));
				elseif(!is_dir($src)) $response = array('status'=>'error','message'=>__('The directory you\'re trying to rename could not be found.', 'file-away'));
				else
				{
					if(!is_dir("$dst")) mkdir("$dst", 0755, true);
					$dirs = fileaway_utility::recursivedirs($src);
					if(is_array($dirs))
					{
						$dirs = array_reverse($dirs);
						$fcount = 0; $fscount = 0;
						$dcount = 1; $dscount = 0;
						foreach($dirs as $dir)
						{
							$dcount++;
							$files = false;
							$filedest = str_replace("$src","$dst","$dir");
							if(!is_dir($filedest)) mkdir("$filedest", 0755, true);
							$files = array_filter(glob("$dir"."/*"), 'is_file');
							if(is_array($files))
							{ 
								foreach($files as $file)
								{ 
									$fcount++; 
									$filename = pathinfo($file, PATHINFO_BASENAME); 
									if(rename("$file", "$filedest"."/"."$filename")) $fscount++; 
								}
							}
							if(rmdir($dir)) $dscount++;
						}
					}
					$basefiles = array_filter(glob("$src"."/*"), 'is_file');
					if(is_array($basefiles))
					{ 
						foreach($basefiles as $file)
						{ 
							$fcount++; 
							$filename = pathinfo($file, PATHINFO_BASENAME); 
							if(rename("$file", "$dst"."/"."$filename")) $fscount++; 
						}
					}
					if(rmdir($src)) $dscount++;
					if($fcount > 0 && !$fscount) 
						$response = array(
							'status'=>'error', 
							'message'=>__('We tried to move the files into the newly-named directory but none of them would budge.', 'file-away')
						);
					elseif($fcount > 0 && $fcount > $fscount)
						$response = array(
							'status'=>'error',
							'message'=>
								__('We tried to move the files into the newly-named directory, but there were some stragglers, so we couldn\'t remove the old directory.', 'file-away')
						);
					elseif(!is_dir($src))
							$response = array(
								'status'=>'success', 
								'url'=>$newurl, 
								'newdata'=>$newdata, 
								'newname'=>$newname
							); 
					else
						$response = array(
							'status'=>'error', 
							'message'=>__('An unspecified error occurred.', 'file-away')
						); 
				}
			}
			// Delete Directory
			elseif($action === 'deletedir')
			{
				$status = $_POST['status'];
				$path1 = $_POST['path1'];
				$path2 = $_POST['path2'];
				$path = stripslashes($path1.'/'.$path2);
				$src = $rootpath.$path;
				$response = false;
				if(!is_dir("$src")) $response = array('status'=>'error','message'=>__('The directory marked for deletion could not be found.', 'file-away').' '.$path); 
				else
				{	
					$dirs = fileaway_utility::recursivedirs($src);
					$dirs = is_array($dirs) ? array_reverse($dirs) : $dirs;
					if($status === 'life')
					{
						$dcount = 0; 
						$fcount = 0;
						if(is_array($dirs))
						{
							foreach($dirs as $dir)
							{
								$dcount++;
								$files = false; 
								$files = array_filter(glob("$dir"."/*"), 'is_file');
								if(is_array($files)) foreach($files as $file) $fcount++;
							}
						}
						$basefiles = array_filter(glob("$src"."/*"), 'is_file');
						if(is_array($basefiles)) foreach($basefiles as $file) $fcount++;
						if($fcount == 0) $status = 'death';
						else
						{ 
							$filemsg = null;
							if($fcount >= 1)
							{
								$plufiles = $fcount > 1 ? _x('files', 'plural', 'file-away') : _x('file', 'singular', 'file-away'); 
								$filemsg = ' '.__('and', 'file-away').' '.$fcount.' '.$plufiles;
							}
							$dirmsg = null;
							if($dcount >= 1)
							{
								$pludirs = $dcount > 1 ? _x('sub-directories', 'plural', 'file-away') : _x('sub-directory', 'singular', 'file-away');
								$dirmsg = ', '.$dcount.' '.$pludirs;
							}
							$message = sprintf(_x('You are about to delete 1 directory%s from the server. '.
								'This action is permanent and cannot be undone. Are you sure you wish to proceed?', 
								'Do not put a space between *directory* and the %s variable', 'file-away'), $dirmsg.$filemsg);
							$response = array('status'=>'confirm', 'message'=>$message);
						}
					}
					if($status === 'death')
					{
						$pcount = 1; 
						$pscount = 0; 
						$dcount = 0; 
						$dscount = 0; 
						$fcount = 0; 
						$fscount = 0;
						if(is_array($dirs))
						{
							foreach($dirs as $dir)
							{
								$dcount++;
								$files = false; 
								$files = array_filter(glob("$dir"."/*"), 'is_file');
								if(is_array($files))
								{
									foreach($files as $file)
									{
										$fcount++; $file = realpath($file); 
										if(is_readable($file))
										{ 
											if(unlink($file)) $fscount++; 
										}
									}
								}
								if(rmdir($dir)) $dscount++;
							}
						}
						$basefiles = array_filter(glob("$src"."/*"), 'is_file');
						if(is_array($basefiles))
						{ 
							foreach($basefiles as $file)
							{
								$fcount++;
								$file = realpath($file); 
								if(is_readable($file))
								{ 
									if(unlink($file)) $fscount++; 
								}
							}
						}
						if(rmdir($src)) $pscount++;
						if(($pscount && $fscount) || ($pscount && !$fcount))
						{
							$success = $pscount == $pcount && $dscount == $dcount && $fscount == $fcount ? 'success' : 'partial';
							$success = $fscount == $fcount && !$fcount ? 'success-single' : $success;
							$filemsg = null;
							if($fcount >= 1)
							{
								$plufiles = $fcount > 1 ? _x('files', 'plural', 'file-away') : _x('file', 'singular', 'file-away'); 
								$filemsg = ' '.__('and', 'file-away').' '.$fscount.' '.__('of', 'file-away').' '.$fcount.' '.$plufiles;
							}
							else $filemsg = ' '.sprintf(__('and %d files', 'file-away'), $fcount);
							$dirmsg = null;
							if($dcount >= 1)
							{
								$pludirs = $dcount > 1 ? _x('sub-directories', 'plural', 'file-away') : _x('sub-directory', 'singular', 'file-away');
								$dirmsg = ', '.$dscount.' '.__('of', 'file-away').' '.$dcount.' '.$pludirs;
							}
							$message = sprintf(_x('%d of 1 directory%s have been removed from the server.', 
								'Do not put a space between *directory* and the %s variable', 'file-away'), $pscount, $dirmsg.$filemsg);
							$response = array('status'=>$success, 'message'=>$message);
						}
						else
						{
							$response = array(
								'status'=>'error',
								'message'=>__('Sorry, but there was an error attempting to remove this directory.', 'file-away')
							);
						}
					}
				}
			}			
			// rename action
			elseif($action === 'rename')
			{
				$url = stripslashes($_POST['url']);	
				$pp = $problemchild ? fileaway_utility::replacefirst(stripslashes($_POST['pp']), $install, '') : stripslashes($_POST['pp']);
				$oldname = stripslashes($_POST['oldname']);	
				$rawname = stripslashes($_POST['rawname']);
				$ext = $_POST['ext'];
				if(strpos($url, '.'.$ext.'?t=') !== false)
				{ 
					list($url, $querystring) = explode('?', $url);	
					$querystring = '?'.$querystring;
				}
				else $querystring = '';
				$oldfile = $chosenpath."$pp/$oldname.$ext";
				$customdata = stripslashes($_POST['customdata']);		
				$customdata = rtrim("$customdata", ',');
				if($customdata !== '') $customdata = " [$customdata]"; 
				else $customdata = null;
				$newfile = $chosenpath."$pp/$rawname$customdata.$ext";
				if($newfile !== $oldfile)
				{
					$i = 1;
					while(is_file($newfile))
					{
						if($i == 1) $rawname = "$rawname" . " ($i)"; 
						else{ 
							$j = ($i - 1); 
							$rawname = rtrim("$rawname", " ($j)");
							$rawname = "$rawname" . " ($i)"; 
						}
						$i++;
						$newfile = $chosenpath."$pp/$rawname$customdata.$ext";
					}
				}
				if($customdata !== null) $customdata = " [".trim(ltrim(rtrim("$customdata", "]"), " ["), " ")."]";
				else $customdata = '';
				$newfile = $chosenpath."$pp/".trim("$rawname", ' ')."$customdata.$ext";		
				$newurl = str_replace("$pp/$oldname.$ext", "", fileaway_utility::urlesc("$url", true));
				$newurl = fileaway_utility::urlesc("$newurl$pp/".trim("$rawname")."$customdata.$ext");
				$newoldname = trim("$rawname", ' ')."$customdata";
				$download = trim("$rawname", ' ')."$customdata.$ext";		
				if(is_file("$oldfile")) rename("$oldfile", "$newfile");
				$errors = is_file("$newfile") ? '' : __('The file was not renamed.', 'file-away');
				$response = array(
					"errors" => $errors, 
					"download" => $download, 
					"pp" => $pp, 
					"newurl" => $newurl.$querystring, 
					"extension" => $ext, 
					"oldfile" => $oldfile, 
					"newfile" => $newfile, 
					"rawname" => $rawname, 
					"customdata" => $customdata, 
					"newoldname" => $newoldname 
				);
			}
			// delete action (single)
			elseif($action === 'delete')
			{
				$pp = $_POST['pp'];
				$oldname = $_POST['oldname'];	
				$ext = $_POST['ext'];
				$oldfile = "$rootpath$pp/$oldname.$ext";
				if(is_file("$oldfile")) unlink("$oldfile"); 
				if(!is_file("$oldfile")) $response = "success"; 
				elseif(is_file("oldfile")) $response = "failure";
			}
			// bulk download action
			elseif($action == 'bulkdownload')
			{
				$files = $_POST["files"];
				$zipfiles = array(); 
				$values = array();
				if(is_array($files))
				{
					foreach($files as $file)
					{ 
						$file = $rootpath.stripslashes($file);
						if(file_exists($file))
						{ 
							$zipfiles[] = $file; 
							$values[] = basename($file); 
						}
					}
				}
				$numvals = array_count_values($values);
				$prefix = isset($this->settings['download_prefix']) ? $this->settings['download_prefix'] : false;
				$prefix = $prefix && $prefix !== '' ? $prefix : date('Y-m-d');
				$time = uniqid();
				$destination = fileaway_dir.'/temp'; 
				if(!is_dir($destination)) mkdir($destination);
				$filename = stripslashes($prefix).' '.$time.'.zip';
				$link = fileaway_url.'/temp/'.$filename;
				$filename = $destination.'/'.$filename;
				if(count($zipfiles))
				{ 
					$zip = new ZipArchive;
					$zip->open($filename, ZipArchive::CREATE);
					foreach($zipfiles as $k => $zipfile)
					{ 
						$zip->addFile($zipfile,basename($zipfile));
						if($numvals[basename($zipfile)] > 1)
						{ 
							$parts = pathinfo($zipfile);
							$zip->renameName(basename($zipfile), $parts['filename'].'_'.$k.'.'.$parts['extension']);
						}
					}
					$zip->close();
				}
				$response = is_file($filename) ? $link : "Error";
			}
			// Bulk Copy Action
			elseif($action == 'bulkcopy')
			{
				$from = $_POST['from'];
				$to = $_POST['to'];		
				$ext = $_POST['exts'];				
				$destination = $problemchild 
					? fileaway_utility::replacefirst(stripslashes($_POST['destination']), $install, '')
					: stripslashes($_POST['destination']);
				$success = 0;
				$total = 0;		
				$renamers = 0;
				foreach($from as $k => $fro)
				{
					$fro = stripslashes($fro);
					$to[$k] = stripslashes($to[$k]);
					$fro = $problemchild ? fileaway_utility::replacefirst("$fro", $install, '') : "$fro";
					$to[$k] = $problemchild ? fileaway_utility::replacefirst("$to[$k]", $install, '') : "$to[$k]";
					$total++;
					$newfile = $chosenpath."$to[$k]";
					if(is_file($chosenpath."$fro") && is_file("$newfile"))
					{
						$i = 1;
						$noext = fileaway_utility::replacelast("$newfile", '.'.$ext[$k], '');
						while(is_file("$newfile"))
						{
							if($i == 1) $noext = "$noext" . " ($i)"; 
							else
							{ 
								$j = ($i - 1); 
								$noext = rtrim("$noext", " ($j)");
								$noext = "$noext" . " ($i)"; 
							}
							$i++;
							$newfile = "$noext".'.'.$ext[$k];
						}
						$renamers ++;
					}
					if(is_file($chosenpath."$fro") && !is_file("$newfile")) copy($chosenpath."$fro", "$newfile"); 
					if(is_file("$newfile")) $success++; 
				}
				$response = $success == 0 
					? __('There was a problem copying the files. Please consult your local pharmacist.', 'file-away') 
					: ($success == 1 
						? sprintf(__('One file was copied to %s and it no longer feels special.', 'file-away'), $destination) 
						: ($success > 1 
							? sprintf(__('%d of %d files were successfully cloned and delivered in a black caravan to %s.', 'file-away'), $success, $total, $destination) 
							: null 
						)
					);
			}
			// bulk move action
			elseif($action == 'bulkmove')
			{
				$from = $_POST["from"];
				$to = $_POST["to"];		
				$ext = $_POST['exts'];				
				$destination = $problemchild 
					? fileaway_utility::replacefirst(stripslashes($_POST["destination"]), $install, '') 
					: stripslashes($_POST["destination"]);
				$success = 0;
				$total = 0;
				$renamers = 0;		
				foreach($from as $k => $fro)
				{
					$fro = stripslashes($fro);
					$to[$k] = stripslashes($to[$k]);
					$fro = $problemchild ? fileaway_utility::replacefirst("$fro", $install, '') : "$fro";
					$to[$k] = $problemchild ? fileaway_utility::replacefirst("$to[$k]", $install, '') : "$to[$k]";
					$total++;
					$newfile = $chosenpath."$to[$k]";			
					if(is_file($chosenpath."$fro") && is_file("$newfile"))
					{
						$i = 1;
						$noext = fileaway_utility::replacelast("$newfile", '.'.$ext[$k], '');
						while(is_file("$newfile"))
						{
							if($i == 1) $noext = "$noext" . " ($i)"; 
							else
							{ 
								$j = ($i - 1); 
								$noext = rtrim("$noext", " ($j)");
								$noext = "$noext" . " ($i)"; 
							}
							$i++;
							$newfile = "$noext".'.'.$ext[$k];
						}
						$renamers ++;
					}
					if(is_file($chosenpath."$fro") && !is_file("$newfile")) rename($chosenpath."$fro", "$newfile");
					if(is_file("$newfile")) $success++; 
				}
				$response = $success == 0 
					? __('There was a problem moving the files. Please consult your local ouija specialist.', 'file-away') 
					: ($success == 1 
						? sprintf(__('One lonesome file was forced to leave all it knew and move to %s.', 'file-away'), $destination) 
						: ($success > 1 
							? sprintf(__('%d of %d files were magically transported to %s.', 'file-away'), $success, $total, $destination) 
							: null 
						)
					);
			}
			// bulk delete action
			elseif($action == 'bulkdelete')
			{
				$files = $_POST['files'];
				$success = 0;
				$total = 0;
				foreach($files as $k => $file)
				{
					$file = stripslashes($file);
					$total++;
					if(is_file($rootpath.$file)) unlink($rootpath.$file);
					if(!is_file($rootpath.$file)) $success++;
				}
				$response = $success == 0 
					? __('There was a problem deleting the files. Please try pressing your delete button emphatically and repeatedly.', 'file-away') 
					: ($success == 1 
						? __('A million fewer files in the world is a victory. One less file, a tragedy. Farewell, file. Au revoir. Auf Wiedersehen. Adieu.', 'file-away') 
						: ($success > 1 
							? sprintf(__('%d of %d files were sent plummeting to the nether regions of cyberspace.', 'file-away'), $success, $total) 
							: null 
						)
					);
			}
			// upload action
			elseif($action == 'upload')
			{
				if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
				{
					$file_name = strip_tags($_FILES['upload_file']['name']);
					$new_name = strip_tags($_POST['new_name']);
					$extension = $_POST['extension'];
					$uploader = $_POST['uploader'];
					$file_id = strip_tags($_POST['upload_file_id']);
					$file_size = $_FILES['upload_file']['size'];
					$max_file_size = (int)$_POST['max_file_size'];
					$file_path = trim($_POST['upload_path'], '/');
					if($uploader)
					{
						$user = new WP_User($uploader);
						$uploadedby = $user->display_name;
						if(preg_match('/\[([^\]]+)\]/', $new_name)) $new_name =	fileaway_utility::replacelast($new_name, ']', ','.$uploadedby.']');
						else $new_name = fileaway_utility::replacelast($new_name, '.'.$extension, ' ['.$uploadedby.'].'.$extension);
					}
					$location = str_replace('//','/',$chosenpath.$file_path.'/'.$new_name);
					$dir = dirname($location);
					$_POST['size_check'] = $file_size > $max_file_size ? 'true' : 'false';
					if($file_size > $max_file_size) echo 'system_error';
					elseif(strpos($dir, '..') !== false) echo 'system_error';
					else
					{
						if(!is_dir($dir)) mkdir($dir, 0755, true);
						$p = pathinfo($location);
						$filename = $p['filename'];
						$i = 1;
						while(is_file($location))
						{
							if($i == 1) $filename = $filename." ($i)"; 
							else
							{ 
								$j = ($i - 1); 
								$filename = rtrim($filename, " ($j)");
								$filename = $filename." ($i)"; 
							}
							$i++;
							$name = $filename.'.'.$p['extension'];
							$location = $p['dirname'].'/'.$name;		
						}
						$name = $filename.'.'.$p['extension'];
						$location = $p['dirname'].'/'.$name;		
						if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $location)) echo $file_id;
						else echo 'system_error';
					}
					exit;
				}
				else
				{ 
					echo 'system_error'; 
					exit;
				}
			}
			// path generator
			elseif($action == 'actionpath')
			{
				$fileup = $_POST['uploadaction'] === 'true' ? 'fileup-' : '';
				$build = null;
				if($problemchild)
				{
					$pathparts = fileaway_utility::replacefirst($_POST['pathparts'], $install, ''); 
					$start = trim(fileaway_utility::replacefirst($_POST['start'], $install, ''), '/');
				}
				else
				{
					$pathparts = $_POST['pathparts']; 
					$start = trim($_POST['start'], '/');
				}
				if($pathparts === '/') $pathparts = $start;
				$pathparts = trim($pathparts, '/');
				$basename = trim($_POST['basename'], '/');
				if(!fileaway_utility::startswith($pathparts, $start)) $pathparts = $start;
				$security = $basename === $start ? false : true;
				$nocrumbs = $security ? trim(fileaway_utility::replacelast("$start","$basename",''), '/') : null;
				if(strpos($pathparts, '..') !== false) $pathparts = $start;
				$dir = $chosenpath.$pathparts;	
				$build .= "<option></option>";
				$directories = glob($dir."/*", GLOB_ONLYDIR);
				if($directories && is_array($directories))
				{
					foreach($directories as $k=> $folder)
					{
						$direxcluded = 0;
						if($this->settings['direxclusions'])
						{
							$direxes = preg_split( '/(, |,)/', $this->settings['direxclusions'], -1, PREG_SPLIT_NO_EMPTY);
							if(is_array($direxes))
							{
								foreach($direxes as $direx)
								{
									$check = strripos($folder, $direx);
									if($check !== false)
									{
										$direxcluded = 1; 
										break;
									}
								}
							}
						}
						if(!$direxcluded)
						{			
							$folder = str_replace($chosenpath, '', $folder); $dirname = explode('/', $folder); $dirname = end($dirname);
							$build .= '<option value="'.$folder.'">'.$dirname.'</option>'; 
						}
					}	
				}
				else $build .= '';
				if($security) $pieces = explode('/', trim(trim(fileaway_utility::replacefirst("$pathparts", "$nocrumbs", ''), '/'), '/')); 
				else $pieces = explode('/', trim("$pathparts", '/'));
				$piecelink = array(); 
				$breadcrumbs = null;
				foreach($pieces as $k => $piece)
				{
					$i = 0; $piecelink[$k] = ($security ? "$nocrumbs/" : null); 
					while($i <= $k)
					{ 
						$piecelink[$k] .= "$pieces[$i]/"; 
						$i++;
					}
					$breadcrumbs .= '<a href="javascript:" data-target="'.trim($piecelink[$k],'/').'" id="ssfa-'.$fileup.'action-pathpart-'.$k.'">'
						.fileaway_utility::strtotitle($piece).'</a> / ';
				}
				$breadcrumbs = stripslashes($breadcrumbs); 
				$pathparts = stripslashes($pathparts); 
				$build = stripslashes($build);
				$response = array
				(
					"ops" => $build, 
					"crumbs" => $breadcrumbs, 
					"pathparts" => $pathparts
				);
			}
			$response = json_encode($response); 
			header("Content-Type: application/json");
			echo $response;	
			exit;	
		}
	}
}