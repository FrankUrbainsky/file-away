<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_utility'))
{
	class fileaway_utility
	{
		public static function active($plugin)
		{
			return in_array($plugin.'/'.$plugin.'.php', apply_filters('active_plugins', get_option('active_plugins'))); 
		}
		public static function replacefirst($source, $search, $replace)
		{
			return implode($replace, explode($search, $source, 2));
		}
		public static function replacelast($source, $search, $replace)
		{
			return substr_replace($source, $replace, strrpos($source, $search), strlen($search));
		}
		public static function startswith($source, $prefix)
		{
			return strncmp($source, $prefix, strlen($prefix)) == 0;
		}
		public static function formatBytes($size, $precision = 2)
		{
			$size = $size ? $size : 1;
			$base = log ($size) / log (1024);
			$suffixes = array('', 'k', 'M', 'G', 'T');   
			return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)]; 
		}
		public static function strtotitle($title)
		{
			$excludearray = array('of','a','the','and','an','or','nor','but','is','if','then','else','when',
				'at','from','by','on','off','for','in','out','over','to','into','with','amid','as','onto',
				'per','than','through','toward','towards','until','up','upon','versus','via','with'
			);
			$words = explode(' ', $title); 
			foreach($words as $key => $word) if($key == 0 or !in_array($word, $excludearray)) $words[$key] = ucwords($word);
			return implode(' ', $words);
		}
		public static function sentencecase($string)
		{ 
			$sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
			$new_string = ''; 
			foreach($sentences as $key => $sentence) 
				$new_string .= ($key & 1) == 0 ? ucfirst(strtolower(trim($sentence))) : $sentence.' '; 
			return trim($new_string); 
		}
		public static function urlexists($url)
		{
			$ch = curl_init("$url"); 
			curl_setopt("$ch", CURLOPT_NOBODY, true); 
			curl_exec("$ch"); 
			$code = curl_getinfo("$ch", CURLINFO_HTTP_CODE); 
			$status = $code == 200 ? true : false; 
			curl_close("$ch");	
			return $status;
		}
		public static function ini($setting, $conversion = true, $null_message = false, $size = false)
		{
			if(!$setting && !$size) return false;
			$result = $setting ? ini_get($setting) : $size;
			if(!$conversion && $result && $result != '' && $result != null) return $result;
			elseif(!$conversion && (!$result || $result == '' || $result == null)) return $null_message ? $null_message : '10M';
			elseif($conversion)
			{
				$res = $result && $result != '' && $result != null ? trim($result) : '10M'; 
				$last = strtolower($res[strlen($res)-1]);
				switch($last)
				{ 
					case 'g': $res *= 1024; 
					case 'm': $res *= 1024; 
					case 'k': $res *= 1024; 
				}
				return $res;
			}
			else return false;
		}
		public static function currentrole()
		{
			global $wp_roles;
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;
			$role = array_shift($roles);
			$prettyrole = isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role]) : null;
			$prettyrole = $prettyrole === null ? null : str_replace (' ', '', (strtolower ($prettyrole)));
			return $prettyrole; 
		}
		public static function currentroles()
		{
			$user = new WP_User(get_current_user_id());	
			return empty($user->roles) ? false : $user->roles;
		}
		public static function dynamicpaths($dir, $playbackpath = false)
		{
			$op = get_option('fileaway_options');
			$current_user = wp_get_current_user(); 
			$logged_in = is_user_logged_in();			
			$fa_userid = $logged_in ? get_current_user_id() : 'fa-nulldirectory';
			$fa_username = $logged_in ? ($op['strictlogin'] === 'true' ? $current_user->user_login : strtolower($current_user->user_login)) : 'fa-nulldirectory';
			$fa_firstlast = $logged_in ? strtolower($current_user->user_firstname.$current_user->user_lastname) : 'fa-nulldirectory';
			$fa_userrole = $logged_in ? strtolower(self::currentrole()) : 'fa-nulldirectory';	
			$feedback = array(
				'dir' => $dir,
				'private_content' => false,
				'logged_in' => $logged_in,
				'fa_userid' => $fa_userid,
				'fa_username' => $fa_username,
				'fa_firstlast' => $fa_firstlast,
				'fa_userrole' => $fa_userrole,
				'fa_userid_used' => false,
				'fa_userrole_used' => false,
				'fa_username_used' => false, 
				'fa_firstlast_used' => false,
				'playbackpath' => $playbackpath,
			);
			if(stripos($dir, 'fa-userid') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_userid_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-userid', $fa_userid, $dir); 
			}
			if(stripos($dir, 'fa-userrole') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_userrole_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-userrole', $fa_userrole, $dir); 
			}
			if(stripos($dir, 'fa-username') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_username_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-username', $fa_username, $dir); 
			}
			if(stripos($dir, 'fa-firstlast') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_firstlast_used'] = 1; 
				$feedback['dir'] = str_ireplace("fa-firstlast", $fa_firstlast, $dir); 
			}
			if($playbackpath)
			{
				if(stripos($playbackpath, 'fa-userid') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['fa_userid_used'] = 1; 
					$feedback['playbackpath'] = str_ireplace('fa-userid', $fa_userid, $playbackpath); 
				}
				if(stripos($playbackpath, 'fa-userrole') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['fa_userrole_used'] = 1; 
					$feedback['playbackpath'] = str_ireplace('fa-userrole', $fa_userrole, $playbackpath); 
				}
				if(stripos($playbackpath, 'fa-username') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['fa_username_used'] = 1; 
					$feedback['playbackpath'] = str_ireplace('fa-username', $fa_username, $playbackpath); 
				}
				if(stripos($playbackpath, 'fa-firstlast') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['fa_firstlast_used'] = 1; 
					$feedback['playbackpath'] = str_ireplace("fa-firstlast", $fa_firstlast, $playbackpath); 
				}
			}
			return $feedback;
		}
		public static function visibility($hidefrom = false, $showto = false)
		{
			$current_user = wp_get_current_user(); 
			$logged_in = is_user_logged_in();
			$showtothese = true;
			if($showto)
			{ 
				$showtothese = false; 
				$showlevels = preg_split('/(, |,)/', $showto); 
				foreach($showlevels as $slevel)
				{ 
					if(current_user_can($slevel))
					{ 
						$showtothese = true; 
						break; 
					}
				}
			}
			if($hidefrom)
			{ 
				if(!$logged_in) $showtothese = false; 
				$hidelevels = preg_split('/(, |,)/', $hidefrom); 
				foreach($hidelevels as $hlevel)
				{ 
					if(current_user_can($hlevel))
					{ 
						$showtothese = false; 
						break; 
					}
				}
			}
			return $showtothese ? true : false;	
		}
		public static function recursefiles($directory, $onlydirs, $excludedirs)
		{
			self::recursedirs($directory, $directories, $onlydirs, $excludedirs); 
			$files = array ();
			foreach($directories as $directory)
			{ 
				if($excludedirs)
				{
					foreach($excludedirs as $exclude) if(strripos("$directory", "$exclude") !== false) continue 2;
				}
				foreach(glob("{$directory}/*.*") as $file) if(is_file($file)) $files[] = $file; 
			}
			return $files;
		}
		public static function recursedirs($directory, &$directories = array(), $onlydirs, $excludedirs)
		{
			foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder)
			{ 
				$direxcluded = 0;
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
				if(!$direxcluded)
				{ 
					$directories[] = $folder; 
					self::recursedirs("{$folder}/*", $directories, $onlydirs, $excludedirs);
				}
			}
		}
		public static function recursivedirs($directory)
		{
			self::recursivedir($directory, $directories);
			$dirs = array ();
			foreach($directories as $directory)
			{ 
				foreach(glob("{$directory}/*", GLOB_ONLYDIR) as $dir) if(is_dir($dir)) $dirs[] = $dir;
			}
			return $dirs;
		}
		public static function recursivedir($directory, &$directories = array())
		{
			foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder)
			{ 
				$directories[] = $folder; 
				self::recursivedir("{$folder}/*", $directories); 
			}
		}
		public static function createthumb($name, $filename, $extension, $iThumbnailWidth, $iThumbnailHeight)
		{
			if($extension === 'jpeg' || $extension === 'jpg') $img = imagecreatefromjpeg($name);
			elseif($extension === 'png') $img = imagecreatefrompng($name);
			elseif($extension === 'gif') $img = imagecreatefromgif($name);	
			else return false;
			$iOrigWidth = imagesx($img); $iOrigHeight = imagesy($img);
			$fScale = max($iThumbnailWidth/$iOrigWidth,$iThumbnailHeight/$iOrigHeight);
			if($fScale < 1)
			{
				$yAxis = 0; $xAxis = 0;
				$iNewWidth = floor($fScale*$iOrigWidth);
				$iNewHeight = floor($fScale*$iOrigHeight);
				$tmpimg = imagecreatetruecolor($iNewWidth,$iNewHeight);
				$tmp2img = imagecreatetruecolor($iThumbnailWidth,$iThumbnailHeight);
				imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);
				if($iNewWidth == $iThumbnailWidth)
				{ 
					$yAxis = ($iNewHeight/2)-($iThumbnailHeight/2); 
					$xAxis = 0; 
				}
				elseif($iNewHeight == $iThumbnailHeight)
				{ 
					$yAxis = 0; 
					$xAxis = ($iNewWidth/2)-($iThumbnailWidth/2); 
				}
				imagecopyresampled($tmp2img, $tmpimg, 0, 0, $xAxis, $yAxis, $iThumbnailWidth, $iThumbnailHeight, $iThumbnailWidth, $iThumbnailHeight);
				imagedestroy($img); 
				imagedestroy($tmpimg); 
				$img = $tmp2img;
				if($extension === 'png') imagepng($img,$filename); 
				elseif($extension === 'gif') imagegif($img,$filename); 
				else imagejpeg($img,$filename); 
			}
		}
		public static function getattachment($id)
		{
			$attachment = get_post($id);
			return array(
				'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'postlink' => get_permalink($attachment->ID),
				'filelink' => $attachment->guid,
				'title' => $attachment->post_title
			);
		}
		public static function unicode($file)
		{
			$chars = array(
				'ƒ'=>'%83','„'=>'%84','…'=>'%85','†'=>'%86','‡'=>'%87','ˆ'=>'%88','‰'=>'%89','Š'=>'%8A','‹'=>'%8B','Œ'=>'%8C','Ž'=>'%8E','‘'=>'%91','’'=>'%92','“'=>'%93',
				'”'=>'%94','•'=>'%95','–'=>'%96','—'=>'%97','˜'=>'%98','™'=>'%99','š'=>'%9A','›'=>'%9B','œ'=>'%9C','ž'=>'%9E','Ÿ'=>'%9F','¡'=>'%A1','¢'=>'%A2','£'=>'%A3',
				'¤'=>'%A4','¥'=>'%A5','¦'=>'%A6','§'=>'%A7','¨'=>'%A8','©'=>'%A9','ª'=>'%AA','«'=>'%AB','¬'=>'%AC','®'=>'%AE','¯'=>'%AF','°'=>'%B0','±'=>'%B1','²'=>'%B2',
				'³'=>'%B3','´'=>'%B4','µ'=>'%B5','¶'=>'%B6','·'=>'%B7','¸'=>'%B8','¹'=>'%B9','º'=>'%BA','»'=>'%BB','¼'=>'%BC','½'=>'%BD','¾'=>'%BE','¿'=>'%BF','À'=>'%C0',
				'Á'=>'%C1','Â'=>'%C2','Ã'=>'%C3','Ä'=>'%C4','Å'=>'%C5','Æ'=>'%C6','Ç'=>'%C7','È'=>'%C8','É'=>'%C9','Ê'=>'%CA','Ë'=>'%CB','Ì'=>'%CC','Í'=>'%CD','Î'=>'%CE',
				'Ï'=>'%CF','Ð'=>'%D0','Ñ'=>'%D1','Ò'=>'%D2','Ó'=>'%D3','Ô'=>'%D4','Õ'=>'%D5','Ö'=>'%D6','×'=>'%D7','Ø'=>'%D8','Ù'=>'%D9','Ú'=>'%DA','Û'=>'%DB','Ü'=>'%DC',
				'Ý'=>'%DD','Þ'=>'%DE','ß'=>'%DF','à'=>'%E0','á'=>'%E1','â'=>'%E2','ã'=>'%E3','ä'=>'%E4','å'=>'%E5','æ'=>'%E6','ç'=>'%E7','è'=>'%E8','é'=>'%E9','ê'=>'%EA',
				'ë'=>'%EB','ì'=>'%EC','í'=>'%ED','î'=>'%EE','ï'=>'%EF','ð'=>'%F0','ñ'=>'%F1','ò'=>'%F2','ó'=>'%F3','ô'=>'%F4','õ'=>'%F5','ö'=>'%F6','÷'=>'%F7','ø'=>'%F8',
				'ù'=>'%F9','ú'=>'%FA','û'=>'%FB','ü'=>'%FC','ý'=>'%FD','þ'=>'%FE','ÿ'=>'%FF');	
			foreach($chars as $key => $value) $file = str_replace($key, $value, $file);
			return $file;
		}
		public static function caps()
		{
			$roles = new WP_Roles; 
			$a = array(); 
			$b = array();
			foreach($roles->roles as $role => $name) $a[$role] = $role; 
			foreach($roles->roles as $role)
			{
				foreach($role['capabilities'] as $cap => $bool) if(strpos($cap, 'level_') === false) $b[$cap] = $cap;
			}
			if(is_array($b)) ksort($b);
			$caps = array_unique(array_merge($a, $b));
			return $caps;	
		}
		public static function index($dir)
		{
			if(is_file($dir.'/index.php')) return false;
			if(!$file = fopen($dir.'/index.php', 'w')) return false;
			fwrite($file, '<?php // Silence is golden. ?>');			
			fclose($file);	
		}
	}
}