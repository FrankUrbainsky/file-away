<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(class_exists('fileaway_attributes') && !class_exists('fileup'))
{
	class fileup extends fileaway_attributes
	{
		public function __construct()
		{
			parent::__construct();
			add_shortcode('fileup', array($this, 'sc'));
		}
		public function sc($atts)
		{
			$get = new fileaway_definitions;
			extract($get->pathoptions);
			extract($this->correct(wp_parse_args($atts, $this->fileup), $this->shortcodes['fileup']));
			if(!fileaway_utility::visibility($hidefrom, $showto)) return;
			if($this->op['javascript'] == 'footer') $GLOBALS['fileaway_add_scripts'] = true;
			if($this->op['stylesheet'] == 'footer') $GLOBALS['fileaway_add_styles'] = true;
			// Build Initial Directory
			$base = $this->op['base'.$base];
			$base = trim($base, '/'); 
			$base = trim($base, '/');
			$sub = $sub ? trim($sub, '/') : false; 
			$dir = $sub ? $base.'/'.$sub : $base;
			extract(fileaway_utility::dynamicpaths($dir));
			$dir = str_replace('//', '/', "$dir");
			$debugpath = $chosenpath.$dir;
			// line below requires testing /* */
			$dir = $problemchild ? $install.$dir : $dir;
			if($private_content && !is_dir("$dir")) return;
			$start = "$dir"; 
			$pathparts = explode('/', $start); 
			$basename = end($pathparts);
			$fixed = $start; 
			// line below requires testing //
			$fixed = $fixedlocation ? ($problemchild ? fileaway_utility::replacefirst($fixed, $install, '') : $fixed) : null;
			$path = '<input type="hidden" id="ssfa-upload-actionpath" value="'.$fixed.'" data-basename="'.$basename.'" data-start="'.$start.'" />';
			// File Type Permissions
			$types = array(); 
			if($filetypes)
			{
				$filetypes = preg_split('/(, |,)/', $filetypes); 
				foreach($filetypes as $type) $types[] = strtolower(str_replace(array('.',' '), '', $type));
			}
			if($filegroups)
			{
				$groups = preg_split('/(, |,)/', strtolower(str_replace(' ', '', $filegroups)));
				foreach($get->filegroups as $group => $discard) if(in_array($group, $groups)) $types = array_merge($types, $get->filegroups[$group][2]);
			}
			if(count($types) > 0)
			{ 
				$types = array_unique($types); 
				asort($types); 
				$filetypes = '["'.implode('", "',$types).'"]'; 
			}
			else $filetypes = false; 
			$permitted = ($filetypes || $filegroups) && $action == 'permit' ? $filetypes : 'false';
			$prohibited = ($filetypes || $filegroups) && $action == 'prohibit' ? $filetypes : 'false';	
			// Configure Settings
			$uid = rand(0, 9999); 
			$name = $name ? $name : "ssfa-meta-container-$uid";
			$width = is_numeric(preg_replace('[\D]', '', $width)) ? preg_replace('[\D]', '', $width) : '100'; 
			$width = "width:$width$perpx;";
			$float = ' float:'.$align.';';  
			$margin = ($width !== 'width:100%;' ? ($align === 'right' ? ' margin-left:15px;' : ' margin-right:15px;') : null);
			$inlinestyle = $width.$float.$margin;
			$multiple = $single ? '' : ' multiple=multiple';
			$addfiles = $single ? __('+ Add File', 'file-away') : __('+ Add Files', 'file-away');
			$uploadlabel = $uploadlabel ? $uploadlabel : __('File Up &#10138;', 'file-away');
			$pathcheck = $problemchild ? fileaway_utility::replacefirst($start, $install, '') : $start;
			$uploader = $uploader ? get_current_user_id() : 0;
			// Configure Max File Size Setting
			$max_file_size = trim(preg_replace('[\D]', '', $maxsize));
			$max_size_type = trim(strtolower($maxsizetype));
			$max_file_size = is_numeric($max_file_size) ? $max_file_size : 10; 
			$max_size_type = in_array($max_size_type, array('k','m','g')) ? $max_size_type : 'm';
			$ms = $max_file_size.$max_size_type;
			$ms = fileaway_utility::ini(false, true, false, $ms);
			$pms = fileaway_utility::ini('post_max_size');
			$ums = fileaway_utility::ini('upload_max_filesize');
			$maxsize = $pms < $ms ? $pms : $ms;
			$maxsize = $ums < $maxsize ? $ums : $maxsize;
			// Initialize Settings
			$fixedsetting = $fixedlocation ? '"'.$fixed.'"' : 'false';
			$initialize = 
				'<script> '.
					'jQuery(document).ready(function($){ '.
						'new FileUp({ '.
							'form_id: "ssfa_fileup_form", '.
							'uid: '.$uid.', '.
							'container: "'.$name.'", '.
							'table: "'.$style.'", '.
							'iconcolor: "'.$iconcolor.'", '.
							'maxsize: '.$maxsize.', '.
							'permitted: '.$permitted.', '.
							'prohibited: '.$prohibited.', '.
							'fixed: '.$fixedsetting.', '.
							'pathcheck: "'.$pathcheck.'", '.
							'uploader: '.$uploader.', '.
							'loading: "'.fileaway_url.'/lib/img/ajax.gif" '.
						'}); '.
					'}); '.
				'</script>';
			// Form Output
			if(!is_dir($debugpath)) return current_user_can('administrator') 
				? __('File Up Admin Notice: The initial directory specified does not exist:', 'file-away').'<br>'.$debugpath 
				: null;
			$dropdown = $fixedlocation 
				? null 
				: '<div id="ssfa-fileup-path-container" style="display:inline-block; float:left;">'.
					'<div id="ssfa-fileup-directories-select-container">'.
						'<label for="ssfa-fileup-directories-select" style="display:block!important; margin-bottom:5px!important;">'.__('Destination Directory', 'file-away').'</label>'.
						'<select name="ssfa-fileup-directories-select" id="ssfa-fileup-directories-select" class="chozed-select ssfa-fileup-directories-select" data-placeholder="&nbsp;">'.
							'<option></option>'.
							'<option value="'.$start.'">'.$basename.'</option>'.
						'</select>'.
						'<br>'.
						'<div id="ssfa-fileup-action-path" style="margin-top:5px; min-height:25px;">'.
							'<img id="ssfa-fileup-action-ajax-loading" src="'.fileaway_url.'/lib/img/ajax.gif" '.
								'style="width:15px; margin:0 0 0 5px!important; box-shadow:none!important; display:none;">'.
						'</div>'.
					'</div>'.
				'</div>';
			$form = 
				'<div class="ssfa_fileup_container" style="'.$inlinestyle.'">'.
					'<form name="ssfa_fileup_form" id="ssfa_fileup_form" action="javascript:void(0);" enctype="multipart/form-data">'
						.$path.$dropdown.
						'<div class="ssfa_fileup_buttons_container" style="text-align:right;">'.
							'<span class="ssfa_fileup_wrapper" style="text-align:left;">'.
								'<input type="file" name="ssfa_fileup_files[]" id="ssfa_fileup_files" class="ssfa_hidden_browse"'.$multiple.' />'.
								'<span class="ssfa_add_files">'.$addfiles.'</span>'.
								'<span id="ssfa_submit_upload">'.$uploadlabel.'</span>'.
							'</span>'.
						'</div>'.
					'</form>'.
					'<div class="ssfa_fileup_files_container"></div>'.
					'<span id="ssfa_rf" style="display:none;"></span>'.
				'</div>';
			return do_shortcode($initialize.$form);
		}		
	}
}