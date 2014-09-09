<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_encrypted'))
{
	class fileaway_encrypted
	{
		public function url($file = false)
		{
			if(!$file) return false;	
			$file = str_replace('&', '%26', str_replace('?', '%3F', str_replace('(', '%28', str_replace(')', '%29', $file))));
			$nonce = wp_create_nonce('fileaway-download');
			return fileaway_url.'/lib/cls/class.fileaway_downloader.php?fileaway='.$this->encrypt($file).'&nonce='.$nonce;	
		}
		public function encrypt($file)
		{ 
			$result = '';
			$op = get_option('fileaway_options');
			if(!isset($op['encryption_key']) || strlen($op['encryption_key']) < 16) $key = $this->key($op);
			else $key = $op['encryption_key'];
			for($i = 1; $i <= strlen($file); $i++)
			{
				$char = substr($file, $i-1, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)+ord($keychar));
				$result .= $char;
			}
			return urlencode($result);
		}
		private function key($options)
		{
			if(function_exists('openssl_random_pseudo_bytes'))
				$options['encryption_key'] = bin2hex(openssl_random_pseudo_bytes(16));
			else
			{
				$key = '';
				$keys = array_merge(range(0, 9), range('a', 'z'));
				for($i = 0; $i < 32; $i++) $key .= $keys[array_rand($keys)];
				$options['encryption_key'] = $key;
			}
			update_option('fileaway_options', $options);
			return $options['encryption_key'];
		}
	}
}