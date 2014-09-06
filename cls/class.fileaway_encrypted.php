<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_encrypted'))
{
	class fileaway_encrypted
	{
		public function url($file = false)
		{
			if(!$file) return false;	
			else return fileaway_url.'/lib/cls/class.fileaway_downloader.php?fileaway='.$this->encrypt($file);	
		}
		public function encrypt($file)
		{
			$result = '';
			$op = get_option('fileaway_options');
			$key = $op['encryption_key'];
			$file = str_replace('&', '%26', str_replace('?', '%3F', $file));
			for($i = 1; $i <= strlen($file); $i++)
			{
				$char = substr($file, $i-1, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)+ord($keychar));
				$result .= $char;
			}
			return urlencode($result);
		}
	}
}