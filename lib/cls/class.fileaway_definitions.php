<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_definitions'))
{
	class fileaway_definitions
	{
		private $options;
		public $pathoptions, $filegroups, $imagetypes, $codexts, $nevershows, $file_exclusions, $dir_exclusions;
		public static $s2member;
		public function __construct()
		{
			$this->options = get_option('fileaway_options');
			self::$s2member = fileaway_utility::active('s2member') ? true : false;
			$this->pathoptions = array(); 
			$this->paths();
			$this->imagetypes = array('bmp', 'jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff');
			$this->codexts = array('js', 'pl', 'py', 'rb', 'css', 'less', 'scss', 'sass', 'php', 'htm', 
				'html', 'cgi', 'asp', 'cfm', 'cpp', 'yml', 'shtm', 'xhtm', 'java', 'class');
			$this->nevershows = array('index.htm', 'index.html', 'index.php', '.htaccess', '.htpasswd');
			$this->file_exclusions = $this->options['exclusions'] 
				? preg_split('/(, |,)/', trim($this->options['exclusions']), -1, PREG_SPLIT_NO_EMPTY) 
				: array();
			$this->dir_exclusions = $this->options['direxclusions'] 
				? preg_split('/(, |,)/', trim($this->options['direxclusions']), -1, PREG_SPLIT_NO_EMPTY) 
				: array();
			$this->filegroups = array(
				'adobe'=>array(
					'Adobe',
					'&#x21;',
					array('abf', 'aep', 'afm', 'ai', 'as', 'eps', 'fla', 'flv', 'fm', 'indd', 
						'pdd', 'pdf', 'pmd', 'ppj', 'prc', 'ps', 'psb', 'psd', 'swf')
				),
				'application'=>array(
					'Application',
					'&#x54;',
					array('bat', 'dll', 'exe', 'msi')
				),
				'audio'=>array(
					'Audio',
					'&#x43;',
					array('aac', 'aif', 'aifc', 'aiff', 'amr', 'ape', 'au', 'bwf', 'flac', 'iff', 
						'gsm', 'la', 'm4a', 'm4b', 'm4p', 'mid', 'mp2', 'mp3', 'mpc', 'ogg', 'ots', 
						'ram', 'raw', 'rex', 'rx2', 'spx', 'swa', 'tta', 'vox', 'wav', 'wma', 'wv')
				),
				'compression'=>array(
					'Compression',
					'&#x27;',
					array('7z', 'a', 'ace', 'afa', 'ar', 'bz2', 'cab', 'cfs', 'cpio', 'cpt', 'dar', 
						'dd', 'dmg', 'gz', 'lz', 'lzma', 'lzo', 'mar', 'rar', 'rz', 's7z', 'sda', 
						'sfark', 'shar', 'tar', 'tgz', 'xz', 'z', 'zip', 'zipx', 'zz')
				),
				'css'=>array(
					'CSS',
					'&#x28;',
					array('css', 'less', 'sass', 'scss')
				),
				'image'=>array(
					'Image',
					'&#x31;',
					array('bmp', 'dds', 'exif', 'gif', 'hdp', 'hdr', 'iff', 'jfif', 'jpeg', 'jpg', 
						'jxr', 'pam', 'pbm', 'pfm', 'pgm', 'png', 'pnm', 'ppm', 'raw', 'rgbe', 'tga', 
						'thm', 'tif', 'tiff', 'webp', 'wdp', 'yuv')
				),
				'msdoc'=>array(
					'MS Doc',
					'&#x23;',
					array('doc', 'docm', 'docx', 'dot', 'dotx')
				),
				'msexcel'=>array(
					'MS Excel',
					'&#x24;',
					array('xls', 'xlsm', 'xlsb', 'xlsx', 'xlt', 'xltm', 'xltx', 'xlw')
				),
				'openoffice'=>array(
					'Open Office',
					'&#x22;',
					array('dbf', 'dbf4', 'odp', 'ods', 'odt', 'stc', 'sti', 'stw', 'sxc', 'sxi', 'sxw')
				),
				'powerpoint'=>array(
					'PowerPoint',
					'&#x26;',
					array('pot', 'potm', 'potx', 'pps', 'ppt', 'pptm', 'pptx', 'pub')
				),
				'script'=>array(
					'Script',
					'&#x25;',
					array('asp', 'cfm', 'cgi', 'clas', 'class', 'cpp', 'htm', 'html', 'java', 'js', 
						'php', 'pl', 'py', 'rb', 'shtm', 'shtml', 'xhtm', 'xhtml', 'yml')
				),
				'text'=>array(
					'Text',
					'&#x2e;',
					array('123', 'csv', 'log', 'psw', 'rtf', 'sql', 'txt', 'uof', 'uot', 'wk1', 
						'wks', 'wpd', 'wps', 'xml')
				),
				'video'=>array(
					'Video',
					'&#x57;',
					array('avi', 'divx', 'mov', 'm4p', 'm4v', 'mkv', 'mp4', 'mpeg', 'mpg', 'qt', 
						'rm', 'rmvb', 'vob', 'wmv')
				),
				'unknown'=>array(
					'Unknown',
					'&#x29;',
					false
				)
			);
		}
		private function paths()
		{
			$install = trim(get_bloginfo('url'), '/') !== trim(get_bloginfo('wpurl'), '/') 
				? str_replace('//', '/', ltrim(str_replace(rtrim(get_bloginfo('url'), '/'), '', rtrim(get_bloginfo('wpurl'), '/')), '/').'/') 
				: false;
			$install = $install === '/' ? false : $install; 
			$installpath = ABSPATH;
			$rootpath = ($install ? substr_replace(ABSPATH, '', strrpos(ABSPATH, $install), strlen($install)) : ABSPATH);
			$chosenpath = ($this->options['rootdirectory'] === 'siteurl' ? $rootpath : ABSPATH);
			$problemchild = $install && $this->options['rootdirectory'] !== 'siteurl' ? true : false;
			$playback_url = $this->options['rootdirectory'] === 'siteurl' ? rtrim(get_bloginfo('url'),'/').'/' : rtrim(get_bloginfo('wpurl'),'/').'/';
			$this->pathoptions = array(
				'install'		=> $install, 
				'installpath'	=> $installpath, 
				'rootpath'		=> $rootpath, 
				'chosenpath'	=> $chosenpath, 
				'problemchild'	=> $problemchild, 
				'playback_url'	=> $playback_url
			);
		}
		public static function s2member()
		{
			return self::$s2member;
		}
	}
}