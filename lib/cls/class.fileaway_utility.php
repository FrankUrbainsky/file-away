<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_utility'))
{
	class fileaway_utility
	{
		public function __construct()
		{
			add_action('wp_footer', self::flightfoot);
		}
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
			if(is_array($prefix))
			{
				foreach($prefix as $p)
				{
					if(strncmp($source, $p, strlen($p)) == 0) return true;
				}
				return false;
			}
			else return strncmp($source, $prefix, strlen($prefix)) == 0;
		}
		public static function endswith($source, $suffix)
		{
			if(is_array($suffix))
			{
				foreach($suffix as $s)
				{
					if(substr($source, -strlen($s)) == $s) return true;
				}
				return false;
			}
			else return substr($source, -strlen($suffix)) == $suffix;
		}
		public static function recreatecol(&$input, $position, $length = 0, $newkey, $newval = '') 
		{
			$keys = array_keys($input);
			$values = array_values($input);
			$new = array($newkey => $newval);
			array_splice($keys, $position, $length, array_keys($new));
			array_splice($values, $position, $length, array_values($new));
			$input = array_combine($keys, $values);
		}
		public static function formatBytes($size, $precision = 2)
		{
			$size = $size ? $size : 1;
			$base = log($size) / log(1024);
			$suffixes = array('', 'k', 'M', 'G', 'T');   
			return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)]; 
		}
		public static function timezone()
		{
			$string = get_option('timezone_string');
			if($string && $string != '') date_default_timezone_set($string);
			else
			{
				$offset = round(get_option('gmt_offset'));
				$offset = $offset < -11 ? -11 : ($offset > 13 ? 13 : $offset);
				$string = timezone_name_from_abbr(null, $offset * 3600, true);
				$string = $string ? $string : timezone_name_from_abbr(null, $offset * 3600, false);
				date_default_timezone_set($string);
			}
			return $string;
		}
		public static function strtotitle($title)
		{
			$excludearray = array
			(
				'of','a','the','and','an','or','nor','but','is','if','then','else','when',
				'at','from','by','on','off','for','in','out','over','to','into','with','amid','as','onto',
				'per','than','through','toward','towards','until','up','upon','versus','via','with'
			);
			$words = explode(' ', $title); 
			if(is_array($words)) 
			{
				foreach($words as $key => $word) 
				{
					if($key == 0 or !in_array($word, $excludearray)) 
					{
						$words[$key] = ucwords($word);
					}
				}
			}
			return implode(' ', $words);
		}
		public static function sentencecase($string)
		{
			$new_string = ''; 
			$sentences = preg_split('/([.?!]+)/', trim($string), -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
			if(is_array($sentences)) 
			{
				foreach($sentences as $key => $sentence) 
				{
					$new_string .= ($key & 1) == 0 ? ucfirst(strtolower(trim($sentence))) : $sentence.' '; 
				}
			}
			return trim($new_string); 
		}
		public static function urlexists($url)
		{
			$file_headers = @get_headers($url);
			return $file_headers[0] == 'HTTP/1.1 404 Not Found' ? false : true;
		}
		public static function urls()
		{
			$id = $GLOBALS['blog_id'];
			$home1 = rtrim(get_home_url(1), '/');
			$home1http = str_replace('https:', 'http:', $home1);
			$home1https = str_replace('http:', 'https:', $home1);
			$site1 = rtrim(get_site_url(1), '/');
			$site1http = str_replace('https:', 'http:', $site1);
			$site1https = str_replace('http:', 'https:', $site1);
			$url = rtrim(get_bloginfo('url'), '/');
			$urlhttp = str_replace('https:', 'http:', $url);
			$urlhttps = str_replace('http:', 'https:', $url);
			$wpurl = rtrim(get_bloginfo('wpurl'), '/');
			$wpurlhttp = str_replace('https:', 'http:', $wpurl);
			$wpurlhttps = str_replace('http:', 'https:', $wpurl);
			$site =	rtrim(get_site_url($id), '/');
			$sitehttp = str_replace('https:', 'http:', $site);
			$sitehttps = str_replace('http:', 'https:', $site);
			$home =	rtrim(get_home_url($id), '/');
			$homehttp = str_replace('https:', 'http:', $home);
			$homehttps = str_replace('http:', 'https:', $home);
			$network = rtrim(network_site_url(), '/');
			$networkhttp = str_replace('https:', 'http:', $network);
			$networkhttps = str_replace('http:', 'https:', $network);
			$urls = array(
				$home1http => str_replace(array('http://', 'www.'), '', $home1http). ' (HTTP)',
				$home1https => str_replace(array('https://', 'www.'), '', $home1https). ' (HTTPS)',
				$site1http => str_replace(array('http://', 'www.'), '', $site1http). ' (HTTP)',
				$site1https => str_replace(array('https://', 'www.'), '', $site1https). ' (HTTPS)', 
				$urlhttp => str_replace(array('http://', 'www.'), '', $urlhttp). ' (HTTP)',
				$urlhttps => str_replace(array('https://', 'www.'), '', $urlhttps). ' (HTTPS)',
				$wpurlhttp => str_replace(array('http://', 'www.'), '', $wpurlhttp). ' (HTTP)',
				$wpurlhttps => str_replace(array('https://', 'www.'), '', $wpurlhttps). ' (HTTPS)',
				$sitehttp => str_replace(array('http://', 'www.'), '', $sitehttp). ' (HTTP)',
				$sitehttps => str_replace(array('https://', 'www.'), '', $sitehttps). ' (HTTPS)',
				$homehttp => str_replace(array('http://', 'www.'), '', $homehttp). ' (HTTP)',
				$homehttps => str_replace(array('https://', 'www.'), '', $homehttps). ' (HTTPS)',
				$networkhttp => str_replace(array('http://', 'www.'), '', $networkhttp). ' (HTTP)',
				$networkhttps => str_replace(array('https://', 'www.'), '', $networkhttps). ' (HTTPS)',
			);
			return array_unique($urls);
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
			return $prettyrole === null ? null : str_replace (' ', '', (strtolower ($prettyrole)));
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
			$feedback = array
			(
				'dir' => $dir,
				'private_content' => false,
				'logged_in' => $logged_in,
				'fa_userid' => $fa_userid,
				'fa_username' => $fa_username,
				'fa_firstlast' => $fa_firstlast,
				'fa_userrole' => $fa_userrole,
				'fa_metavalues' => array(),
				'fa_userid_used' => false,
				'fa_userrole_used' => false,
				'fa_username_used' => false, 
				'fa_firstlast_used' => false,
				'fa_usermeta_used' => false,
				'playbackpath' => $playbackpath,
			);
			if(stripos($dir, 'fa-userid') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_userid_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-userid', $fa_userid, $feedback['dir']); 
			}
			if(stripos($dir, 'fa-userrole') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_userrole_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-userrole', $fa_userrole, $feedback['dir']); 
			}
			if(stripos($dir, 'fa-username') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_username_used'] = 1; 
				$feedback['dir'] = str_ireplace('fa-username', $fa_username, $feedback['dir']); 
			}
			if(stripos($dir, 'fa-firstlast') !== false)
			{ 
				$feedback['private_content'] = true; 
				$feedback['fa_firstlast_used'] = 1; 
				$feedback['dir'] = str_ireplace("fa-firstlast", $fa_firstlast, $feedback['dir']); 
			}
			if(stripos($dir, 'fa-usermeta(') !== false)
			{
				$feedback['private_content'] = true; 
				$feedback['fa_usermeta_used'] = 1; 
				$umetas = array();
				$countmetas = preg_match_all('/\((.*)\)/U', $dir, $umetas);
				if(is_array($umetas[1]))
				{
					foreach($umetas[1] as $umeta)
					{
						$metavalue = get_user_meta($fa_userid, $umeta, true);
						if(!$metavalue || $metavalue == '') $metavalue = 'fa-nullmeta';
						else $feedback['fa_metavalues'][] = $metavalue;
						$feedback['dir'] = str_ireplace('fa-usermeta('.$umeta.')', $metavalue, $feedback['dir']);
					}
				}
			}
			if($playbackpath)
			{
				if(stripos($playbackpath, 'fa-userid') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['playbackpath'] = str_ireplace('fa-userid', $fa_userid, $feedback['playbackpath']); 
				}
				if(stripos($playbackpath, 'fa-userrole') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['playbackpath'] = str_ireplace('fa-userrole', $fa_userrole, $feedback['playbackpath']); 
				}
				if(stripos($playbackpath, 'fa-username') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['playbackpath'] = str_ireplace('fa-username', $fa_username, $feedback['playbackpath']); 
				}
				if(stripos($playbackpath, 'fa-firstlast') !== false)
				{ 
					$feedback['private_content'] = true; 
					$feedback['playbackpath'] = str_ireplace("fa-firstlast", $fa_firstlast, $feedback['playbackpath']); 
				}
				if(stripos($playbackpath, 'fa-usermeta(') !== false)
				{
					$feedback['private_content'] = true; 
					$umetas = array();
					$countmetas = preg_match_all('/\((.*)\)/U', $dir, $umetas);
					if(is_array($umetas[1]))
					{
						foreach($umetas[1] as $umeta)
						{
							$metavalue = get_user_meta($fa_userid, $umeta, true);
							if(!$metavalue || $metavalue == '') $metavalue = 'fa-nullmeta';
							$feedback['playbackpath'] = str_ireplace('fa-usermeta('.$umeta.')', $metavalue, $feedback['playbackpath']);
						}
					}
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
				$showlevels = preg_split('/(, |,)/', trim($showto), -1, PREG_SPLIT_NO_EMPTY); 
				if(is_array($showlevels))
				{
					foreach($showlevels as $slevel)
					{ 
						if(current_user_can($slevel))
						{ 
							$showtothese = true; 
							break; 
						}
					}
				}
			}
			if($hidefrom)
			{ 
				if(!$logged_in) $showtothese = false; 
				$hidelevels = preg_split('/(, |,)/', trim($hidefrom), -1, PREG_SPLIT_NO_EMPTY); 
				if(is_array($hidelevels))
				{
					foreach($hidelevels as $hlevel)
					{ 
						if(current_user_can($hlevel))
						{ 
							$showtothese = false; 
							break; 
						}
					}
				}
			}
			return $showtothese;	
		}
		public static function recursefiles($directory, $onlydirs, $excludedirs, $filetype = "*")
		{
			self::recursedirs($directory, $directories, $onlydirs); 
			$files = array();
			if(!is_array($directories)) $directories = array();
			foreach($directories as $directory)
			{ 
				if($excludedirs)
				{
					foreach($excludedirs as $exclude) 
					{
						if(self::endswith("$directory", "$exclude")) continue 2;
					}
				}
				$files_array = glob("{$directory}/*.{$filetype}");
				$files_array = is_array($files_array) ? $files_array : array();
				foreach($files_array as $file)
				{ 
					if(is_file($file)) $files[] = $file; 
				}
			}
			return $files;
		}
		public static function recursedirs($directory, &$directories = array(), $onlydirs)
		{
			$folders = glob($directory, GLOB_ONLYDIR | GLOB_NOSORT);
			$folders = is_array($folders) ? $folders : array();
			foreach($folders as $folder)
			{ 
				$direxcluded = 0;
				if($onlydirs && is_array($onlydirs))
				{ 
					$direxcluded = 1; 
					foreach($onlydirs as $onlydir)
					{ 
						if(self::endswith("$folder", "$onlydir"))
						{
							$direxcluded = 0; 
							break;
						} 
					}
				}
				if(!$direxcluded)
				{
					$directories[] = $folder; 
					self::recursedirs("{$folder}/*", $directories, $onlydirs);
				}
			}
		}
		public static function recursivedirs($directory)
		{
			self::recursivedir($directory, $directories);
			$dirs = array();
			if(!is_array($directories)) $directories = array();
			foreach($directories as $directory)
			{ 
				$dir_array = glob("{$directory}/*", GLOB_ONLYDIR);
				$dir_array = is_array($dir_array) ? $dir_array : array();
				foreach($dir_array as $dir)
				{ 
					if(is_dir($dir)) $dirs[] = $dir;
				}
			}
			return $dirs;
		}
		public static function recursivedir($directory, &$directories = array())
		{
			$folders = glob($directory, GLOB_ONLYDIR | GLOB_NOSORT);
			$folders = is_array($folders) ? $folders : array();
			foreach($folders as $folder)
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
			return array
			(
				'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'postlink' => get_permalink($attachment->ID),
				'filelink' => $attachment->guid,
				'title' => $attachment->post_title
			);
		}
		public static function urlesc($string = false, $reverse = false, $spec = false)
		{
			if(!$string) return false;
			$chars = array('#'=>'%23', ' '=>'%20', "'"=>'%27', '['=>'%5b', ']'=>'%5d', '?'=>'%3F', '('=>'%28', ')'=>'%29', '&'=>'%26', ','=>'%2C');	
			if($reverse) $chars = array_flip($chars);
			if($spec)
			{
				$characters = explode(',', $spec);
				foreach($characters as $char)
				{
					$char = $char;
					if(array_key_exists($char, $chars)) 
						$string = str_replace($char, $chars[$char], $string);
				}
			}
			else
			{
				foreach($chars as $char => $code)
				{
					$string = str_replace($char, $code, $string);
				}
			}
			return $string;
		}
		public static function caps()
		{
			$a = array(); 
			$b = array();
			$roles = new WP_Roles; 
			if(!is_array($roles->roles)) $roles->roles = array();
			foreach($roles->roles as $role => $name)
			{ 
				$a[$role] = $role; 
			}
			foreach($roles->roles as $role)
			{
				if(isset($role['capabilities']) && is_array($role['capabilities']))
				{
					foreach($role['capabilities'] as $cap => $bool) 
					{
						if(strpos($cap, 'level_') === false)
						{ 
							$b[$cap] = $cap;
						}
					}
				}
			}
			if(count($b) > 0) ksort($b);
			return array_unique(array_merge($a, $b));
		}
		public static function index($dir = false)
		{
			if(!$dir) return false;
			if(is_file($dir.'/index.php') || is_file($dir.'/index.html') || is_file($dir.'/index.htm')) return false;
			$success = file_put_contents($dir.'/index.php', "<?php  \n// A void filled with echoes.");
			return $success ? true : false;
		}
		public static function indexmulti($dir = false, $parent = false)
		{
			if(!$dir || !$parent) return false;
			$subs = preg_split('#/#', trim(trim(str_replace($parent, '', $dir))), -1, PREG_SPLIT_NO_EMPTY);
			while(count($subs) > 0)
			{
				self::index($parent.implode('/', $subs));
				array_pop($subs);
			}
		}
		public static function querystring($permalink, $string, $add = array(), $remove = false)
		{
			parse_str($string, $query);
			if(isset($query['page_id'])) unset($query['page_id']);
			if($remove)
			{ 
				foreach($add as $k) if(isset($query[$k])) unset($query[$k]);
			}
			else 
			{
				foreach($add as $k => $v) $query[$k] = $v;
			}
			return add_query_arg($query, $permalink);
		}
		public static function feeds($excluded = false)
		{
			$op = get_option('fileaway_options');
			$bkup = $op;
			if(!isset($op['excluded_feeds']) || !is_array($op['excluded_feeds'])) $op['excluded_feeds'] = array();
			if(!isset($op['basefeeds']) || !is_array($op['basefeeds'])) $op['basefeeds'] = array();
			if($op != $bkup) update_option('fileaway_options', $op);
			return $excluded ? $op['excluded_feeds'] : $op['basefeeds'];	
		}
		public static function updatestats($where = false, $value = false, $replace = false)
		{
			$i = 0;
			global $wpdb;
			if(!$where || !$value || !$replace) return;
			$records = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".$wpdb->prefix."fileaway_downloads WHERE ".$where." = %s", $value));
			if($records)
			{
				foreach($records as $record)
				{ 
					if($wpdb->update($wpdb->prefix."fileaway_downloads", array($where=>$replace), array('id'=>$record->id))) $i++;
				}
			}
			return (count($records) == $i) ? $i : false;
		}
		public static function video($attr)
		{
			$post_id = get_post() ? get_the_ID() : 0;
			static $instances = 0;
			$instances++;
			$video = null;
			$default_types = wp_get_video_extensions();
			$defaults_atts = array(
				'src'      => '',
				'poster'   => '',
				'loop'     => '',
				'autoplay' => '',
				'preload'  => 'metadata',
				'width'    => 640,
				'height'   => 360,
			);
			foreach($default_types as $type)
			{ 
				$defaults_atts[$type] = '';
			}
			$atts = shortcode_atts($defaults_atts, $attr, 'video');
			$yt_pattern = '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#';
			$primary = false;
			if(!empty($atts['src']))
			{
				if(!preg_match($yt_pattern, $atts['src']))
				{
					$type = wp_check_filetype($atts['src'], wp_get_mime_types());
					if(!in_array(strtolower($type['ext']), $default_types))
						return sprintf('<a class="wp-embedded-video" href="%s">%s</a>', esc_url($atts['src']), esc_html($atts['src']));
				}
				$primary = true;
				array_unshift($default_types, 'src');
			} 
			else
			{
				foreach($default_types as $ext)
				{
					if(!empty($atts[$ext]))
					{
						$type = wp_check_filetype($atts[$ext], wp_get_mime_types());
						if(strtolower($type['ext']) === $ext) $primary = true;
					}
				}
			}
			if(!$primary)
			{
				$videos = get_attached_media('video', $post_id);
				if (empty($videos)) return;
				$video = reset($videos);
				$atts['src'] = wp_get_attachment_url($video->ID);
				if(empty($atts['src'])) return;
				array_unshift($default_types, 'src');
			}
			$library = apply_filters('wp_video_shortcode_library', 'mediaelement');
			if('mediaelement' === $library && did_action('init'))
			{
				wp_enqueue_style('wp-mediaelement');
				wp_enqueue_script('wp-mediaelement');
			}
			$html_atts = array
			(
				'class'    => apply_filters('wp_video_shortcode_class', 'wp-video-shortcode'),
				'id'       => sprintf('video-%d-%d', $post_id, $instances),
				'width'    => absint($atts['width']),
				'height'   => absint($atts['height']),
				'poster'   => esc_url($atts['poster']),
				'loop'     => $atts['loop'],
				'autoplay' => $atts['autoplay'],
				'preload'  => $atts['preload'],
			);
			foreach(array('poster', 'loop', 'autoplay', 'preload') as $a)
			{
				if(empty($html_atts[$a])) 
				{
					unset($html_atts[$a]);
				}
			}
			$attr_strings = array();
			foreach($html_atts as $k => $v)
			{ 
				$attr_strings[] = $k.'="'.esc_attr($v).'"';
			}
			$html = '';
			if('mediaelement' === $library && 1 === $instances)
				$html .= "<!--[if lt IE 9]><script>document.createElement('video');</script><![endif]-->\n";
			$html .= sprintf('<video %s controls="controls">', join(' ', $attr_strings));
			$fileurl = '';
			$source = '<source type="%s" src="%s" />';
			foreach($default_types as $fallback)
			{
				if(!empty($atts[$fallback]))
				{
					if(empty($fileurl)) $fileurl = $atts[$fallback];
					if('src' === $fallback && preg_match($yt_pattern, $atts['src'])) $type = array('type' => 'video/youtube');
					else $type = wp_check_filetype($atts[$fallback], wp_get_mime_types());
					$url = add_query_arg('_', $instances, $atts[$fallback]);
					$html .= sprintf($source, $type['type'], esc_url($url));
				}
			}
			if('mediaelement' === $library) $html .= wp_mediaelement_fallback($fileurl);
			$html .= '</video>';
			$width_rule = $height_rule = '';
			if(!empty($atts['width'])) $width_rule = sprintf('width: %dpx; ', $atts['width']);
			if(!empty($atts['height'])) $height_rule = sprintf('height: %dpx;', $atts['height']);
			$output = sprintf('<div style="%s%s" class="wp-video">%s</div>', $width_rule, $height_rule, $html);
			return $output;
		}
	}
}