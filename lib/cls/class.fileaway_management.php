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
			$nonce = $_POST['nonce']; 	
			if(!wp_verify_nonce($nonce, 'fileaway-management-nonce')) 
				die('Go directly to jail. Do not pass GO. Do not collect $200 dollars.');
			extract($this->pathoptions);
			$action = $_POST['act'];
			// Create Sub-Directory
			if($action === 'createdir')
			{
				$parents = trim(str_replace('.', '', $_POST['parents']), '/');
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
				$parents = $problemchild ? fileaway_utility::replacefirst(stripslashes($parents), $install, '') : stripslashes($parents);
				$final = $chosenpath.$parents.'/'.$newsub; 
				$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$first"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = fileaway_utility::strtotitle($prettyfolder);
				if(is_dir($final)) $response = array('status'=>'error', 'message'=>__('That directory name already exists in this location.', 'file-away'));
				else
				{ 
					$first_exists = is_dir($chosenpath.$parents.'/'.$first) ? true : false;
					if(mkdir($final, 0755, true))
					{ 
						if(!$first_exists)
						{ 
							$status = "insert";
							$message = 
								"<tr id='ssfa-dir-$uid-$count' class='ssfa-drawers'>".
									"<td id='folder-ssfa-dir-$uid-$count' data-value=\"0 0 0 0 0 $first\" class='ssfa-sorttype $class-first-column'>".
										"<a href=\"".add_query_arg(array('drawer' => $drawer), get_permalink($page))."\" data-name=\"".$first."\" data-path=\"".$start."\">".
											"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-$drawericon' aria-hidden='true'></span>".
											"<br>"._x('dir', 'abbrv. of *directory*', 'file-away').
										"</a>".
									"</td>".
									"<td id='name-ssfa-dir-$uid-$count' data-value='0 0 0 0 0 $first' class='ssfa-sortname'>".
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
				$oldpath = trim(str_replace('..', '', $_POST['oldpath']), '/');
				$oldpath = $problemchild ? fileaway_utility::replacefirst(stripslashes($oldpath), $install, '') : stripslashes($oldpath);
				$newname = str_replace(array('..','/'), '', $_POST['newname']);
				$pp = explode('/', $oldpath);
				$newpath = str_replace(end($pp), $newname, $oldpath);
				$olddata = $_POST['datapath'];
				$datapp = explode('/', $olddata);
				$newdata = str_replace(end($datapp), $newname, $olddata);
				$parents = $_POST['parents'];
				$parents = $problemchild ? fileaway_utility::replacefirst(stripslashes($parents), $install, '') : stripslashes($parents);
				$old = $parents.'/'.end($pp);
				$dst = $chosenpath.$newpath;
				$src = $chosenpath.$old;
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
				$path = $problemchild ? fileaway_utility::replacefirst(stripslashes($path1.'/'.$path2), $install, '') : stripslashes($path1.'/'.$path2);
				$src = $chosenpath.$path;
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
				$newurl = str_replace("$pp/$oldname.$ext", "", str_replace('%23', '#', "$url"));
				$newurl = str_replace('#', '%23', "$newurl$pp/".trim("$rawname", ' ')."$customdata.$ext");
				$newoldname = trim("$rawname", ' ')."$customdata";
				$download = trim("$rawname", ' ')."$customdata.$ext";		
				if(is_file("$oldfile")) rename("$oldfile", "$newfile");
				$errors = is_file("$newfile") ? '' : __('The file was not renamed.', 'file-away');
				$response = array(
					"errors" => $errors, 
					"download" => $download, 
					"pp" => $pp, 
					"newurl" => $newurl, 
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
				$pp = $problemchild ? fileaway_utility::replacefirst($_POST['pp'], $install, '') : $_POST['pp'];
				$oldname = $_POST['oldname'];	
				$ext = $_POST['ext'];
				$oldfile = $chosenpath."$pp/$oldname.$ext";
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
				foreach($files as $file)
				{ 
					$file = stripslashes($file);
					$file = $install ? fileaway_utility::replacefirst($chosenpath.$file, $install, '') : $chosenpath.$file; 
					if(file_exists($file))
					{ 
						$zipfiles[] = $file; 
						$values[] = basename($file); 
					}
				}
				$numvals = array_count_values($values);
				$sitename = get_bloginfo('name'); 
				$time = uniqid();
				$destination = fileaway_dir.'/temp'; 
				if(!is_dir($destination)) mkdir($destination);
				$filename = $sitename.' '.$time.'.zip';
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
					$file = $problemchild ? fileaway_utility::replacefirst($file, $install, '') : $file;
					$total++;
					if(is_file($chosenpath.$file)) unlink($chosenpath.$file);
					if(!is_file($chosenpath.$file)) $success++;
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
					$file_name		= strip_tags($_FILES['upload_file']['name']);
					$new_name 		= strip_tags($_POST['new_name']);
					$file_id 		= strip_tags($_POST['upload_file_id']);
					$file_size 		= $_FILES['upload_file']['size'];
					$max_file_size 	= (int)$_POST['max_file_size'];
					$file_path		= trim($_POST['upload_path'], '/');
					$location 		= str_replace('//','/',$chosenpath.$file_path.'/'.$new_name);
					$dir			= dirname($location);
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
				if($directories)
				{
					foreach($directories as $k=> $folder)
					{
						$direxcluded = 0;
						if($this->settings['direxclusions'])
						{
							$direxes = preg_split( '/(, |,)/', $this->settings['direxclusions']);
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