<?php 
function ssfa_file_manager() {
	$nonce = $_POST['nextNonce']; 	
	if (! wp_verify_nonce($nonce, 'ssfa-fm-nonce'))
		die ( 'Granny flew the coop!');
	$action = $_POST['act'];
	$abspath = ABSPATH;
	
	// bulk copy action
	if ($action === 'bulkcopy'):
		$from = $_POST['from'];
		$to = $_POST['to'];		
		$ext = $_POST['exts'];				
		$destination = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['destination']) : $_POST['destination']);
		$from = explode('/*//*/', rtrim($from,'/*//*/'));
		$to = explode('/*//*/', rtrim($to,'/*//*/'));		
		$ext = explode('/*//*/', rtrim($ext,'/*//*/'));				
		$success = 0;
		$total = 0;		
		$renamers = 0;
		foreach ($from as $k => $fro):
			$fro = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $fro) : $fro);
			$to[$k] = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $to[$k]) : $to[$k]);
			$total++;
			$newfile = $abspath.$to[$k];
			if (is_file($abspath.$fro) && is_file($newfile)):
				$i = 1;
				$noext = ssfa_replace_last('.'.$ext[$k], '', $newfile);
				while(is_file($newfile)):
					if ($i == 1): 
						$noext = $noext . " ($i)"; 
					else: 
						$j = ($i - 1); 
						$noext = rtrim($noext, " ($j)");
						$noext = $noext . " ($i)"; 
					endif;
					$i++;
					$newfile = $noext.'.'.$ext[$k];
				endwhile;
				$renamers ++;
			endif; 
			if(is_file($abspath.$fro) && !is_file($newfile)): copy($abspath.$fro,$newfile); endif;
		if(is_file($newfile)): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem copying the files. Please consult your local pharmacist.' : ($success == 1 ? "One file was copied to $destination and it no longer feels special." : ($success > 1 ? "$success of $total files were successfully cloned and delivered in a black caravan to $destination." : null )));
	// bulk move action
	elseif ($action === 'bulkmove'):
		$from = $_POST['from'];
		$to = $_POST['to'];		
		$ext = $_POST['exts'];				
		$destination = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['destination']) : $_POST['destination']);
		$from = explode('/*//*/', rtrim($from,'/*//*/'));
		$to = explode('/*//*/', rtrim($to,'/*//*/'));		
		$ext = explode('/*//*/', rtrim($ext,'/*//*/'));				
		$success = 0;
		$total = 0;
		$renamers = 0;		
		foreach ($from as $k => $fro):
			$fro = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $fro) : $fro);
			$to[$k] = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $to[$k]) : $to[$k]);
			$total++;
			$newfile = $abspath.$to[$k];			
			if (is_file($abspath.$fro) && is_file($newfile)):
				$i = 1;
				$noext = ssfa_replace_last('.'.$ext[$k], '', $newfile);
				while(is_file($newfile)):
					if ($i == 1): 
						$noext = $noext . " ($i)"; 
					else: 
						$j = ($i - 1); 
						$noext = rtrim($noext, " ($j)");
						$noext = $noext . " ($i)"; 
					endif;
					$i++;
					$newfile = $noext.'.'.$ext[$k];
				endwhile;
				$renamers ++;
			endif;
			if(is_file($abspath.$fro) && !is_file($newfile)): rename($abspath.$fro,$newfile); endif;
			if(is_file($newfile)): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem moving the files. Please consult your local ouija specialist.' : ($success == 1 ? "One lonesome file was forced to leave all it knew and move to $destination." : ($success > 1 ? "$success of $total files were magically transported to $destination. Or was it Delaware?" : null )));
	// bulk delete action
	elseif ($action === 'bulkdelete'):
		$files = $_POST['files'];
		$files = explode('/*//*/', rtrim($files,'/*//*/'));
		$success = 0;
		$total = 0;
		foreach ($files as $k => $file):
			$file = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $file) : $file);
			$total++;
			if(is_file($abspath.$file)): unlink($abspath.$file); endif;
			if(!is_file($abspath.$file)): $success++; endif;
		endforeach;
		$response = ($success == 0 ? 'There was a problem deleting the files. Please try pressing your delete button emphatically and repeatedly.' : ($success == 1 ? "A million fewer files in the world is a victory. One less file, a tragedy. Farewell, file. Au revoir. Auf Wiedersehen. Adieu." : ($success > 1 ? "$success of $total files were sent plummeting to the nether regions of cyberspace. Or was it Delaware?" : null )));
	// delete action
	elseif ($action === 'delete'):
		$pp = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['pp']) : $_POST['pp']);
		$oldname = $_POST['oldname'];	
		$ext = $_POST['ext'];
		$oldfile = $abspath."$pp/$oldname.$ext";
		if(is_file("$oldfile")): unlink("$oldfile"); endif;
		if(!is_file("$oldfile")): $response = "success"; 
		elseif(is_file("oldfile")): $response = "failure";
		endif;
	// rename action
	elseif ($action === 'rename'):
		$url = $_POST['url'];	
		$pp = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['pp']) : $_POST['pp']);
		$oldname = $_POST['oldname'];	
		$rawname = $_POST['rawname'];
		$ext = $_POST['ext'];
		$oldfile = $abspath."$pp/$oldname.$ext";
		$customdata = $_POST['customdata'];		
		$customdata = rtrim("$customdata", ',');
		if ($customdata !== '') $customdata = " [$customdata]"; 
		else $customdata = null;
		$newfile = $abspath."$pp/$rawname$customdata.$ext";
		if ($newfile !== $oldfile):
			$i = 1;
			while(is_file($newfile)):
				if ($i == 1): 
					$rawname = $rawname . " ($i)"; 
				else: 
					$j = ($i - 1); 
					$rawname = rtrim($rawname, " ($j)");
					$rawname = $rawname . " ($i)"; 
				endif;
				$i++;
				$newfile = $abspath."$pp/$rawname$customdata.$ext";
			endwhile;
		endif; 
		if ($customdata !== null) $customdata = " [".trim(ltrim(rtrim("$customdata", "]"), " ["), " ")."]";
		$newfile = $abspath."$pp/".trim("$rawname", ' ')."$customdata.$ext";		
		$newurl = str_replace("$pp/$oldname.$ext", "", "$url");
		$newurl = "$newurl$pp/".trim("$rawname", ' ')."$customdata.$ext";		
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
		$build = null;
		$pp = ($GLOBALS['ssfa_install'] ? ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['pp']) : $_POST['pp']);
		$st = ($GLOBALS['ssfa_install'] ? trim(ssfa_replace_first($GLOBALS['ssfa_install'], '', $_POST['st']), '/') : trim($_POST['st'], '/'));	
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
			$breadcrumbs .= '<a href="javascript:" data-target="'.trim($piecelink[$k],'/').'" id="ssfa-action-pathpart-'.$k.'">'.$piece.'</a>/';
		endforeach; 
		$response = array(
			"ops" => $build, 
			"crumbs" => $breadcrumbs, 
			"pp" => $pp
		);
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
	endif;
	$response = json_encode($response); header( "Content-Type: application/json" );	echo $response;	exit;
}