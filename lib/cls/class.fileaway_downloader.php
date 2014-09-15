<?php
isset($_REQUEST['fileaway']) or die('Water, water everywhere, but not a drop to drink.');
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0].'wp-load.php');
if(!class_exists('fileaway_downloader'))
{
	class fileaway_downloader
	{
		public function __construct()
		{
			$this->download();	
		}
		public function download()
		{
			$file = $this->decrypt($_GET['fileaway']);
			$file = str_replace('%26', '&', str_replace('%3F', '?', str_replace('%28', '(', str_replace('%29', ')', $file))));
			if(!is_file($file)) die('Sorry. That file could not be found.');
			if(!wp_verify_nonce($_GET['nonce'], 'fileaway-download')) die('Sorry. The download could not be verified.');
			$name = basename($file);
			$size = filesize($file);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=\"$name\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: " . $size);
			$file = @fopen($file, 'rb');
			if($file)
			{
				while(!feof($file))
				{
					print(fread($file, 1024*8));
					flush();
					if(connection_status()!=0)
					{
						@fclose($file);
						die();
					}
				}
				@fclose($file);
			}
			die();			
		}
		private function decrypt($file)
		{
			$result = '';
			$op = get_option('fileaway_options');
			$key = $op['encryption_key'];
			$file = urldecode($file);
			for($i = 1; $i <= strlen($file); $i++)
			{
				$char = substr($file, $i-1, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result .= $char;
			}
			return $result;
		}				
	}	
}
new fileaway_downloader; 