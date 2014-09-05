<?php 
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
function ssfa_file_manager() {
	$nonce = $_POST['nextNonce']; 	
	if (! wp_verify_nonce($nonce, 'ssfa-fm-nonce'))
		die ( 'Granny flew the coop!');
	$action = $_POST['act'];
	$abspath = $GLOBALS['ssfa_abspath'];
	$install = $GLOBALS['ssfa_install'];
	$remove_install = (SSFA_ROOT === 'siteurl' ? false : ($install ? true : false)); 
	// bulk copy action
	if ($action === 'bulkcopy'):
		$from = stripslashes($_POST['from']);
		$to = stripslashes($_POST['to']);		
		$ext = $_POST['exts'];				
		$destination = (SSFA_ROOT === 'siteurl' ? stripslashes($_POST['destination']) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($_POST['destination'])) : 
			stripslashes($_POST['destination'])));
		$from = explode('/*//*/', rtrim("$from",'/*//*/'));
		$to = explode('/*//*/', rtrim("$to",'/*//*/'));		
		$ext = explode('/*//*/', rtrim($ext,'/*//*/'));				
		$success = 0;
		$total = 0;		
		$renamers = 0;
		foreach ($from as $k => $fro):
			$fro = (SSFA_ROOT === 'siteurl' ? "$fro" : ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', "$fro") : "$fro"));
			$to[$k] = (SSFA_ROOT === 'siteurl' ? "$to[$k]" : ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', "$to[$k]") : "$to[$k]"));
			$total++;
			$newfile = $abspath."$to[$k]";
			if (is_file($abspath."$fro") && is_file("$newfile")):
				$i = 1;
				$noext = ssfa_replace_last('.'.$ext[$k], '', "$newfile");
				while(is_file("$newfile")):
					if ($i == 1): 
						$noext = "$noext" . " ($i)"; 
					else: 
						$j = ($i - 1); 
						$noext = rtrim("$noext", " ($j)");
						$noext = "$noext" . " ($i)"; 
					endif;
					$i++;
					$newfile = "$noext".'.'.$ext[$k];
				endwhile;
				$renamers ++;
			endif; 
			if(is_file($abspath."$fro") && !is_file("$newfile")): copy($abspath."$fro","$newfile"); endif;
		if(is_file("$newfile")): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem copying the files. Please consult your local pharmacist.' : ($success == 1 ? "One file was copied to $destination and it no longer feels special." : ($success > 1 ? "$success of $total files were successfully cloned and delivered in a black caravan to $destination." : null )));
	// bulk move action
	elseif ($action === 'bulkmove'):
		$from = stripslashes($_POST["from"]);
		$to = stripslashes($_POST["to"]);		
		$ext = $_POST['exts'];				
		$destination = (SSFA_ROOT === 'siteurl' ? stripslashes($_POST["destination"]) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS["ssfa_install"], '', stripslashes($_POST["destination"])) : 
			stripslashes($_POST["destination"])));
		$from = explode('/*//*/', rtrim("$from",'/*//*/'));
		$to = explode('/*//*/', rtrim("$to",'/*//*/'));		
		$ext = explode('/*//*/', rtrim($ext,'/*//*/'));				
		$success = 0;
		$total = 0;
		$renamers = 0;		
		foreach ($from as $k => $fro):
			$fro = (SSFA_ROOT === 'siteurl' ? "$fro" : ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', "$fro") : "$fro"));
			$to[$k] = (SSFA_ROOT === 'siteurl' ? "$to[$k]" : ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', "$to[$k]") : "$to[$k]"));
			$total++;
			$newfile = $abspath."$to[$k]";			
			if (is_file($abspath."$fro") && is_file("$newfile")):
				$i = 1;
				$noext = ssfa_replace_last('.'.$ext[$k], '', $newfile);
				while(is_file("$newfile")):
					if ($i == 1): 
						$noext = "$noext" . " ($i)"; 
					else: 
						$j = ($i - 1); 
						$noext = rtrim("$noext", " ($j)");
						$noext = "$noext" . " ($i)"; 
					endif;
					$i++;
					$newfile = "$noext".'.'.$ext[$k];
				endwhile;
				$renamers ++;
			endif;
			if(is_file($abspath."$fro") && !is_file("$newfile")): rename($abspath."$fro","$newfile"); endif;
			if(is_file("$newfile")): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem moving the files. Please consult your local ouija specialist.' : ($success == 1 ? "One lonesome file was forced to leave all it knew and move to $destination." : ($success > 1 ? "$success of $total files were magically transported to $destination. Or was it Delaware?" : null )));
	// bulk download action
	elseif ($action === 'bulkdownload'):
		$files = stripslashes($_POST["files"]);
		$files = explode('/*//*/', rtrim("$files",'/*//*/'));
		$zipfiles = array(); $values = array();
		foreach($files as $file): 
			$file = $remove_install ? ssfa_replace_first($install, '', $abspath.$file) : $abspath.$file; 
			if(file_exists($file)): $zipfiles[] = $file; $values[] = basename($file); endif;
		endforeach;
		$numvals = array_count_values($values);
		$sitename = get_bloginfo('name'); $time = uniqid();
		$destination = SSFA_PLUGIN.'/ssfatemp'; 
		if(!is_dir($destination)) mkdir($destination);
		$filename = $sitename.' '.$time.'.zip';
		$link = SSFA_PLUGIN_URL.'/ssfatemp/'.$filename;
		$filename = $destination.'/'.$filename;
		if(count($zipfiles)): 
			$zip = new ZipArchive;
			$zip->open($filename, ZipArchive::CREATE);
			foreach($zipfiles as $k => $zipfile): 
				$zip->addFile($zipfile,basename($zipfile));
				if($numvals[basename($zipfile)] > 1): 
					$parts = pathinfo($zipfile);
					$zip->renameName(basename($zipfile), $parts['filename'].'_'.$k.'.'.$parts['extension']);
				endif;
			endforeach;
			$zip->close();
		endif;
		$response = is_file($filename) ? $link : "Error";
	// bulk delete action
	elseif ($action === 'bulkdelete'):
		$files = $_POST['files'];
		$files = explode('/*//*/', rtrim($files,'/*//*/'));
		$success = 0;
		$total = 0;
		foreach ($files as $k => $file):
			$file = (SSFA_ROOT === 'siteurl' ? $file : ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $file) : $file));
			$total++;
			if(is_file($abspath.$file)): unlink($abspath.$file); endif;
			if(!is_file($abspath.$file)): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem deleting the files. Please try pressing your delete button emphatically and repeatedly.' : ($success == 1 ? "A million fewer files in the world is a victory. One less file, a tragedy. Farewell, file. Au revoir. Auf Wiedersehen. Adieu." : ($success > 1 ? "$success of $total files were sent plummeting to the nether regions of cyberspace. Or was it Delaware?" : null )));
	// delete action
	elseif ($action === 'delete'):
		$pp = (SSFA_ROOT === 'siteurl' ? $_POST['pp'] : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['pp']) : 
			$_POST['pp']));
		$oldname = $_POST['oldname'];	
		$ext = $_POST['ext'];
		$oldfile = $abspath."$pp/$oldname.$ext";
		if(is_file("$oldfile")): unlink("$oldfile"); endif;
		if(!is_file("$oldfile")): $response = "success"; 
		elseif(is_file("oldfile")): $response = "failure";
		endif;
	// rename action
	elseif ($action === 'rename'):
		$url = stripslashes($_POST['url']);	
		$pp = (SSFA_ROOT === 'siteurl' ? $_POST['pp'] : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($_POST['pp'])) : 
			stripslashes($_POST['pp'])));
		$oldname = stripslashes($_POST['oldname']);	
		$rawname = stripslashes($_POST['rawname']);
		$ext = $_POST['ext'];
		$oldfile = $abspath."$pp/$oldname.$ext";
		$customdata = stripslashes($_POST['customdata']);		
		$customdata = rtrim("$customdata", ',');
		if ($customdata !== '') $customdata = " [$customdata]"; 
		else $customdata = null;
		$newfile = $abspath."$pp/$rawname$customdata.$ext";
		if ($newfile !== $oldfile):
			$i = 1;
			while(is_file($newfile)):
				if ($i == 1): 
					$rawname = "$rawname" . " ($i)"; 
				else: 
					$j = ($i - 1); 
					$rawname = rtrim("$rawname", " ($j)");
					$rawname = "$rawname" . " ($i)"; 
				endif;
				$i++;
				$newfile = $abspath."$pp/$rawname$customdata.$ext";
			endwhile;
		endif; 
		if ($customdata !== null) $customdata = " [".trim(ltrim(rtrim("$customdata", "]"), " ["), " ")."]";
		$newfile = $abspath."$pp/".trim("$rawname", ' ')."$customdata.$ext";		
		$newurl = str_replace("$pp/$oldname.$ext", "", str_replace('%23', '#', "$url"));
		$newurl = str_replace('#', '%23', "$newurl$pp/".trim("$rawname", ' ')."$customdata.$ext");
		$newoldname = trim("$rawname", ' ')."$customdata.$ext";
		$download = trim("$rawname", ' ')."$customdata.$ext";		
		if (is_file("$oldfile")) rename("$oldfile", "$newfile");
		$errors = ''; if (!is_file("$newfile")) $errors = 'The file was not renamed.';
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
	// get action path
	elseif ($action === 'getactionpath'):
		$fileup = $_POST['uploadaction'] === 'true' ? 'fileup-' : '';
		$build = null;
		if(SSFA_ROOT === 'siteurl' || (SSFA_ROOT !== 'siteurl' && $GLOBALS['ssfa_install'] == false)): $pp = $_POST['pp']; $st = trim($_POST['st'], '/');
		elseif(SSFA_ROOT !== 'siteurl' && $GLOBALS['ssfa_install'] !== false): 
			$pp = ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['pp']); 
			$st = trim(ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['st']), '/');
		endif;
		if ($pp === '/') $pp = $st;
		$pp = trim($pp, '/');
		$sht = trim($_POST['sht'], '/');
		if(!ssfa_startswith($pp, $st)) $pp = $st;
		$security = ($st === $sht ? 0 : 1);
		$nocrumbs = ($security ? trim(ssfa_replace_last("$sht",'',"$st"), '/') : null);
		if (strpos($pp, '..') !== false) $pp = $st;
		$dir = $abspath.$pp;	
		$build .= "<option></option>";
		$directories = glob($dir."/*", GLOB_ONLYDIR);
		if ($directories):
			foreach ($directories as $k=> $folder):
				$direxcluded = 0;
				if (SSFA_DIR_EXCLUSIONS):
					$direxes = preg_split ( '/(, |,)/', SSFA_DIR_EXCLUSIONS );
					foreach($direxes as $direx):
						$check = strripos($folder, $direx);
						if($check !== false) {$direxcluded = 1; break;}
					endforeach;
				endif;
				if (! $direxcluded):			
					$folder = str_replace($abspath, '', $folder); $dirname = explode('/', $folder); $dirname = end($dirname);
					$build .= '<option value="'.$folder.'">'.$dirname.'</option>'; 
				endif;	
			endforeach;
		else: 
			$build .= '';
		endif;
		if ($security) $pieces = explode('/', trim(trim(ssfa_replace_first("$nocrumbs",'',"$pp"), '/'), '/')); 
		else  $pieces = explode('/', trim("$pp", '/'));
		$piecelink = array(); $breadcrumbs = null;
		foreach ($pieces as $k => $piece):
			$i = 0; $piecelink[$k] = ($security ? "$nocrumbs/" : null); 
			while ($i <= $k): $piecelink[$k] .= "$pieces[$i]/"; $i++; endwhile;
			$breadcrumbs .= '<a href="javascript:" data-target="'.trim($piecelink[$k],'/').'" id="ssfa-'.$fileup.'action-pathpart-'.$k.'">'.ssfa_strtotitle($piece).'</a> / ';
		endforeach; 
		$breadcrumbs = stripslashes($breadcrumbs); $pp = stripslashes($pp); $build = stripslashes($build);
		$response = array(
			"ops" => $build, 
			"crumbs" => $breadcrumbs, 
			"pp" => $pp
		);
	// Create Sub-Directory
	elseif($action === 'createdir'):
		$parents = trim(str_replace('.', '', $_POST['parents']), '/');
		$newsub = trim(str_replace('.', '', $_POST['newsub']), '/');
		$uid = $_POST['uid']; $count = $_POST['count']; 
		$page = $_POST['page']; $drawericon = $_POST['drawer'];
		$cells = $_POST['cells']; $class = $_POST['cls'];
		$base = $_POST['base']; $subs = explode('/', $newsub); $first = $subs[0]; $last = $subs[count($subs)-1];
		$start = trim(ssfa_replace_first($base, '', $parents).'/'.$first, '/'); $drawer = str_replace('/','*',$start);
		$parents = (SSFA_ROOT === 'siteurl' ? stripslashes($parents) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($parents)) : 
			stripslashes($parents)));
		$final = $abspath.$parents.'/'.$newsub; $prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$first"); 
		$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder"); $prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
		$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder"); $prettyfolder = ssfa_strtotitle($prettyfolder);
		if(is_dir($final)): $response = array('status'=>'error', 'message'=>'That directory name already exists in this location.');
		else: 
			$first_exists = is_dir($abspath.$parents.'/'.$first) ? true : false;
			if(mkdir($final, 0755, true)): 
				if(!$first_exists): 
					$status = "insert";
					$message = 
						"<tr id='ssfa-dir-$uid-$count' class='ssfa-drawers'>".
								"<td id='folder-ssfa-dir-$uid-$count' data-value=\"00-$first\" class='ssfa-sorttype $class-first-column'>".
									"<a href=\"".add_query_arg(array('drawer' => $drawer), get_permalink($page))."\" data-path=\"".$start."\">".
										"<span style='font-size:20px; margin-left:3px;' class='ssfa-icon-$drawericon' aria-hidden='true'></span>".
										"<br>dir".
									"</a>".
								"</td>".
								"<td id='name-ssfa-dir-$uid-$count' data-value='00-$first' class='ssfa-sortname'>".
									"<a href=\"".add_query_arg(array('drawer' => $drawer), get_permalink($page))."\">".
										"<span style='text-transform:uppercase;'>$prettyfolder</span>".
									"</a>".
									"<input id='rename-ssfa-dir-$uid-$count' type='text' value=\"$first\" ".
										"style='width:90%; height:26px; font-size:12px; text-align:center; display:none'>".
								"</td>"; 	
						$icell = 1; while($icell < $cells): $message .= "<td class='$class'> &nbsp; </td>"; $icell++; endwhile;
						$message .= 
							"<td id='manager-ssfa-dir-$uid-$count' class='$class'>".
								"<a href='' id='rename-ssfa-dir-$uid-$count'>Rename</a><br><a href='' id='delete-ssfa-dir-$uid-$count'>Delete</a>".
							"</td>";
						$message .= "</tr>";
				else: $status = "success"; $message = "Your sub-directories have been sucessfully created.";
				endif; $response = array('status'=>$status, 'message'=>$message, 'uid'=>$uid);
			else: $response = array('status'=>'error', 'message'=>'Sorry, there was a problem creating that directory for you.');
			endif;
		endif;
	// Rename Directory
	elseif($action === 'renamedir'):
		$oldpath = trim(str_replace('..', '', $_POST['oldpath']), '/');
		$oldpath = (SSFA_ROOT === 'siteurl' ? stripslashes($oldpath) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($oldpath)) : 
			stripslashes($oldpath)));
		$newname = str_replace(array('..','/'), '', $_POST['newname']);
		$pp = explode('/',$oldpath);
		$newpath = str_replace(end($pp), $newname, $oldpath);
		$olddata = $_POST['datapath'];
		$datapp = explode('/', $olddata);
		$newdata = str_replace(end($datapp), $newname, $olddata);
		$parents = $_POST['parents'];
		$parents = (SSFA_ROOT === 'siteurl' ? stripslashes($parents) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($parents)) : 
			stripslashes($parents)));
		$old = $parents.'/'.end($pp);
		$dst = $abspath.$newpath;
		$src = $abspath.$old;
		$page = $_POST['page'];
		$drawer = str_replace('/', '*', $newdata);
		$newurl = add_query_arg(array('drawer' => $drawer), get_permalink($page));
		$response = false;
		if(is_dir($dst)): $response = array('status'=>'error', 'message'=>'That directory already exists.');
		elseif(!is_dir($src)): $response = array('status'=>'error','message'=>"The directory you're trying to rename could not be found.");
		else:
			if(!is_dir("$dst")) mkdir("$dst", 0755, true);
			$dirs = ssfa_recursive_dirs($src);
			if(is_array($dirs)):
				$dirs = array_reverse($dirs);
				$fcount = 0; $fscount = 0;
				$dcount = 1; $dscount = 0;
				foreach($dirs as $dir):
					$dcount++;
					$files = false;
					$filedest = str_replace("$src","$dst","$dir");
					if(!is_dir($filedest)) mkdir("$filedest", 0755, true);
					$files = array_filter(glob("$dir"."/*"), 'is_file');
					if(is_array($files)): 
						foreach($files as $file): 
							$fcount++; $filename = pathinfo($file, PATHINFO_BASENAME); 
							if(rename("$file", "$filedest"."/"."$filename")) $fscount++; 
						endforeach; 
					endif;
					if(rmdir($dir)) $dscount++;
				endforeach;
			endif;
			$basefiles = array_filter(glob("$src"."/*"), 'is_file');
			if(is_array($basefiles)): 
				foreach($basefiles as $file): 
					$fcount++; $filename = pathinfo($file, PATHINFO_BASENAME); 
					if(rename("$file", "$dst"."/"."$filename")) $fscount++; 
				endforeach; 
			endif;
			if(rmdir($src)) $dscount++;
			if($fcount > 0 && !$fscount): $response = array('status'=>'error', 'message'=>'We tried to move the files into the newly-named directory but none of them would budge.');
			elseif($fcount > 0 && $fcount > $fscount): $response = array('status'=>'error',
				'message'=>"We tried to move the files into the newly-named directory, but there were some stragglers, so we couldn't remove the old directory.");
			elseif(!is_dir($src)): $response = array('status'=>'success', 'url'=>$newurl, 'newdata'=>$newdata, 'newname'=>$newname); 
			else: $response = array('status'=>'error', 'message'=>'An unspecified error occurred.'); endif;
		endif;
	// Delete Directory
	elseif($action === 'deletedir'):
		$status = $_POST['status'];
		$path1 = $_POST['path1'];
		$path2 = $_POST['path2'];
		$path = (SSFA_ROOT === 'siteurl' ? stripslashes($path1.'/'.$path2) : 
			($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', stripslashes($path1.'/'.$path2)) : 
			stripslashes($path1.'/'.$path2)));
		$src = $abspath.$path;
		$response = false;
		if(!is_dir("$src")): $response = array('status'=>'error','message'=>'The directory marked for deletion could not be found. '.$path); 
		else:	
			$dirs = ssfa_recursive_dirs($src);
			$dirs = is_array($dirs) ? array_reverse($dirs) : $dirs;
			if($status === 'life'):
				$dcount = 0; $fcount = 0;
				if(is_array($dirs)):
					foreach($dirs as $dir):
						$dcount++;
						$files = false; 
						$files = array_filter(glob("$dir"."/*"), 'is_file');
						if(is_array($files)) foreach($files as $file) $fcount++;
					endforeach;
				endif;
				$basefiles = array_filter(glob("$src"."/*"), 'is_file');
				if(is_array($basefiles)) foreach($basefiles as $file) $fcount++;
				if($fcount == 0): $status = 'death';
				else: 
					$filemsg = null;
					if($fcount >= 1):
						$plufiles = $fcount > 1 ? 'files' : 'file'; 
						$filemsg = ' and '.$fcount.' '.$plufiles;
					endif;
					$dirmsg = null;
					if($dcount >= 1):
						$pludirs = $dcount > 1 ? 'sub-directories' : 'sub-directory';
						$dirmsg = ', '.$dcount.' '.$pludirs;
					endif;
					$message = 'You are about to delete 1 directory'.$dirmsg.$filemsg.' from the server. This action is permanent and cannot be undone. Are you sure you wish to proceed?';
					$response = array('status'=>'confirm', 'message'=>$message);
				endif;
			endif;
			if($status === 'death'):
				$pcount = 1; $pscount = 0; 
				$dcount = 0; $dscount = 0; 
				$fcount = 0; $fscount = 0;
				if(is_array($dirs)):
					foreach($dirs as $dir):
						$dcount++;
						$files = false; 
						$files = array_filter(glob("$dir"."/*"), 'is_file');
						if(is_array($files)):
							foreach($files as $file):
								$fcount++; $file = realpath($file); 
								if(is_readable($file)): if(unlink($file)) $fscount++; endif;
							endforeach;
						endif;
						if(rmdir($dir)) $dscount++;
					endforeach;
				endif;
				$basefiles = array_filter(glob("$src"."/*"), 'is_file');
				if(is_array($basefiles)): 
					foreach ($basefiles as $file):
						$fcount++;
						$file = realpath($file); 
						if(is_readable($file)): if(unlink($file)) $fscount++; endif;
					endforeach;
				endif;
				if(rmdir($src)) $pscount++;
				if(($pscount && $fscount) || ($pscount && !$fcount)):
					$success = $pscount == $pcount && $dscount == $dcount && $fscount == $fcount ? 'success' : 'partial';
					$success = $fscount == $fcount && !$fcount ? 'success-single' : $success;
					$filemsg = null;
					if($fcount >= 1):
						$plufiles = $fcount > 1 ? 'files' : 'file'; 
						$filemsg = ' and '.$fscount.' of '.$fcount.' '.$plufiles;
					else:
						$filemsg = ' and '.$fcount.' files';
					endif;
					$dirmsg = null;
					if($dcount >= 1):
						$pludirs = $dcount > 1 ? 'sub-directories' : 'sub-directory';
						$dirmsg = ', '.$dscount.' of '.$dcount.' '.$pludirs;
					endif;
					$message = $pscount.' of 1 directories'.$dirmsg.$filemsg.' have been removed from the server.';
					$response = array('status'=>$success, 'message'=>$message);
				else:
					$response = array('status'=>'error','message'=>'Sorry, but there was an error attempting to remove this directory.');
				endif;
			endif;
		endif;
	// report possible saboteur
	elseif ($action === 'saboteur'):
		$user = wp_get_current_user();
		$name = $user->display_name;
		$id = $user->ID;
		$login = $user->user_login;
		$time = date('Y-m-d H:i:s',strtotime('NOW'));
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key):
			if (array_key_exists($key, $_SERVER) === true):
				foreach (explode(',', $_SERVER[$key]) as $ip):
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false):
						$userip = $ip;
					endif;
				endforeach;
			endif;
		endforeach;
		$to = get_option( 'admin_email' );
		$subject = "Automated Security Alert from File Away re: $name";
		$message = "This user may have tried to manipulate restricted directories:\r\n\r\n";
		$message .= "Name: ".$name."\r\n";
		$message .= "Username: ".$login."\r\n";
		$message .= "User ID: ".$id."\r\n";
		$message .= "IP Address: ".$userip."\r\n";
		$message .= "Time: ".$time."\r\n\r\n\r\n";
		$message .= "Sincerely,\r\n";
		$message .= "File Away\r\n";		
		mail($to, $subject, $message);
		$response = wp_logout_url();
	// FileUp Upload Handler
	elseif ($action === 'upload'):
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
			$file_name		= strip_tags($_FILES['upload_file']['name']);
			$new_name 		= strip_tags($_POST['new_name']);
			$file_id 		= strip_tags($_POST['upload_file_id']);
			$file_size 		= $_FILES['upload_file']['size'];
			$max_file_size 	= (int)$_POST['max_file_size'];
			$file_path		= trim($_POST['upload_path'], '/');
			$location 		= str_replace('//','/',$abspath.$file_path.'/'.$new_name);
			$dir			= dirname($location);
			$_POST['size_check'] = $file_size > $max_file_size ? 'true' : 'false';
			if($file_size > $max_file_size) echo 'system_error';
			elseif(strpos($dir, '..') !== false) echo 'system_error';
			else{
				if(!is_dir($dir)) mkdir($dir, 0755, true);
				$p = pathinfo($location);
				$filename = $p['filename'];
				$i = 1;
				while(is_file($location)):
					if ($i == 1): 
						$filename = $filename." ($i)"; 
					else: 
						$j = ($i - 1); 
						$filename = rtrim($filename, " ($j)");
						$filename = $filename." ($i)"; 
					endif;
					$i++;
					$name = $filename.'.'.$p['extension'];
					$location = $p['dirname'].'/'.$name;		
				endwhile;
				$name = $filename.'.'.$p['extension'];
				$location = $p['dirname'].'/'.$name;		
				if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $location)) echo $file_id;
				else echo 'system_error';
			}
			exit;
		}else{ echo 'system_error'; exit;}
	endif;
	$response = json_encode($response); header( "Content-Type: application/json" );	echo $response;	exit;
}