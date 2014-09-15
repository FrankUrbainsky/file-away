	<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(class_exists('fileaway_admin') && !class_exists('fileaway_modal'))
{
	class fileaway_modal extends fileaway_admin
	{
		public $shortcodes;
		public $optioninfo;
		public function __construct()
		{
			$get = new fileaway_attributes;
			$this->shortcodes = $get->shortcodes;
			$get = new fileaway_tutorials;
			$this->optioninfo = $get->optioninfo;
			unset($get);
			$this->params();
			$this->modal();
		}
		public function modal()
		{
			$output = null;
			$info = null; 
			$constainers = array(); 
			$sections = array(); 
			$fields = array(); 
			$i = 0; 
			$x = 0;
			$shortcode_select_options = null;
			foreach($this->shortcodes as $shortcode => $array)
			{
				$numtypes = count($array['types']);	
				$shortcode_select_options .= '<option data-types="'.$numtypes.'" id="fileaway_shortcode_'.$shortcode.'" value="'.$shortcode.'">'.$array['option'].'</option>';
				$instructions = $shortcode == 'fileaframe' 
					?	"<div class='clearfix' style='width:95%'>".
						"<h3>File Away iframe Instructions</h3>".
						"<ol style='font-size:11px;'>".
							"<li>Create a new page and using the Template dropdown under Page Attributes, set the template to File Away iframe.</li>".
							"<li>Under Sortable Data Tables, insert your [fileaway] shortcode with the Directory Tree setting enabled, and assign it a Unique Name.</li>".
							"<li>Save the page and remember the page slug.</li>".
							"<li>Edit another page with your normal template, and insert the above File Away iframe shortcode, with the page slug from the other page inserted ".
								"into the Source URL field, and the unique name from the [fileaway] shortcode inserted into the Unique Name field. Click on all the info links to ".
								"see what each setting does.</li>".
							"<li>Done! Now you\'ve got a Directory Tree table on your front-end page, ".
								"that will navigate through the directories without refreshing the parent page.</li>".
						"</ol>".
						"</div>" 
					: 	null;
				foreach($array['types'] as $type)
				{
					$prefix = $shortcode.'_'.$type;
					$datacontainer = $numtypes > 1 ? $shortcode.'_'.$type : $shortcode;	
					$containers[$shortcode][$type][] = 
						'<div id="options-container-'.$datacontainer.'" data-container="'.$datacontainer.'" '.
							'data-sc="'.$shortcode.'" data-type="'.$type.'" class="fileaway-wrap" style="display:none;">'.
						'<div class="fileaway-tabs"><ul class="fileaway-tabs-nav">';
					$ops = null;
					foreach($array as $key => $a)
					{
						if($key == 'type' || $key == 'options' || $key == 'sections' || $key == 'option' || $key == 'types') continue;
						if($numtypes > 1 && !isset($a[$type])) continue;
						$src = $numtypes > 1 ? $a[$type] : $a;
						$newline = strpos($a['class'], 'fileaway-first-inline') !== false ? '<div style="display:block; visibility:hidden;"></div>' : null;
						$style = isset($a['style']) ? $a['style'] : null;
						$section = $a['section'];
						$infolink = $key == 'theme' ? null : '<span class="link-fileaway-help-'.$key.' fileaway-helplink fileaway-help-iconinfo2"></span>';
						if($a['element'] == 'text')
						{
							$fields[$shortcode][$type][$section][$i] = $newline.'<div style="'.$style.'" class="fileaway-inline '.$a['class'].'" '.
								'id="fileaway-container-'.$prefix.'_'.$section.'_'.$key.'_'.$i.'">';
							$fields[$shortcode][$type][$section][$i] .= '<div style="width:100%; text-align:right; margin: 2px 0 3px;">'.
								'<label for="'.$prefix.'_'.$key.'">'.$infolink.$a['label'].'</label></div>';
		 					$fields[$shortcode][$type][$section][$i] .=  
								'<input class="fileaway-text " type="text" id="'.$prefix.'_'.$key.'" '.
								'name="'.$prefix.'_'.$key.'" placeholder="" value="" data-attribute="'.$key.'" />'.
								'</div>';
						}
						elseif($a['element'] == 'select' || $a['element'] == 'multiselect')
						{				
							$ops = $numtypes > 1 ? $a[$type]['options'] : $a['options'];
							$multiple = $a['element'] == 'multiselect' ? ' multiple=multiple' : null;
							$fields[$shortcode][$type][$section][$i]  = $newline.'<div style="'.$style.'" class="fileaway-inline '.$a['class'].'" '.
								'id="fileaway-container-'.$prefix.'_'.$section.'_'.$key.'_'.$i.'">';
							$fields[$shortcode][$type][$section][$i] .= '<div style="width:100%; text-align:right; margin: 2px 0 3px;">'.
								'<label for="'.$prefix.'_'.$key.'">'.$infolink.$a['label'].'</label></div>';
							$fields[$shortcode][$type][$section][$i] .= '<select id="'.$prefix.'_'.$key.'" class="select '.
								'chozed-select" data-placeholder="&nbsp;" name="'.$prefix.'_'.$key.'" data-attribute="'.$key.'"'.$multiple.'>'.
								'<option value=""></option>';
							if(isset($ops) && is_array($ops))
							{
								foreach($ops as $value => $option)
								{
									$fields[$shortcode][$type][$section][$i] .= '<option value="'.esc_attr($value).'">'.stripslashes($option).'</option>';
								}
							}
							$fields[$shortcode][$type][$section][$i] .= '</select></div>';
						}
						$i++;
					}
					$initclass = 0; $tabindex = 0; $panelindex = 0;
					foreach($array['sections'] as $key => $section)
					{
						if($type == 'list' && $key == 'bannerize') continue;
						$initclass = $tabindex < 1 ? ' state-active' : '';
						$tabs[$shortcode][$type][] = 
							'<li class="'.$key.$initclass.'" data-tab="'.$key.'"><a href="javascript:" data-tab="'.$key.'" id="fileaway-tab-'.$key.'">'.$section.'</a></li>';
							$tabindex++;
						$initdisplay = $panelindex < 1 || count($array['sections']) < 2 ? 'block;' : 'none;'; 
						$sections[$shortcode][$type][] = '<div class="fileaway-tabs-panel" id="fileaway-panel-'.$key.'" style="display:'.$initdisplay.'">'.
						implode(' ',$fields[$shortcode][$type][$key]).'</div>';
						$panelindex++;
					}
					foreach($tabs[$shortcode][$type] as $tab)
					{
						$containers[$shortcode][$type][] .= $tab;
					}
					$containers[$shortcode][$type][] .= '</ul></div>';
					foreach($sections[$shortcode][$type] as $section)
					{
						$containers[$shortcode][$type][] .= $section;
					}
					$output .= implode(' ', $containers[$shortcode][$type]).$instructions.'</div>';			
				}
			}
			$shortcode_select = 
				'<div class="fileaway-first-inline fileaway_shortcode_select" id="fileaway_shortcode_select">'.
					'<label for="fileaway_shortcode_select">Select Shortcode</label>'.
					'<select id="fileaway_shortcode_select" class="select chozed-select" data-placeholder="&nbsp;" name="fileaway_shortcode_select">'.
						'<option value=""></option>'.$shortcode_select_options.
					'</select>'.
				'</div>';
			$type_select = 
				'<div style="display:block; visibility:hidden; margin:20px 0;"></div>'.
				'<div class="fileaway-first-inline fileaway_type_select" style="display:none;" id="fileaway_type_select">'.
					'<label for="fileaway_type_select">Select Type</label>'.
					'<select id="fileaway_type_select" class="select chozed-select" data-placeholder="&nbsp;" name="fileaway_type_select">'.
						'<option value=""></option>'.
						'<option value="list">Alphabetical List</option>'.
						'<option value="table">Sortable Data Table</option>'.
					'</select>'.
				'</div>';
			foreach($this->optioninfo as $option => $array)
				$info .= 
					'<div id="fileaway-help-'.$option.'" class="fileaway-help-backdrop">'.
						'<div class="fileaway-help-content">'.
							'<div class="fileaway-help-close fileaway-help-iconclose2"></div>'.
							'<h4>'.$this->optioninfo[$option]['heading'].'</h4>'.
							$this->optioninfo[$option]['info'].
						'</div>'.
					'</div>';	
			$form = 
				'<div id="fileawaymodal-form" style="width:100%;">'.
				'<form id="fileawaymodal-form">'.
					'<table style="width:100%"><tr><td>'.
						'<div id="fileawaymodal-metacontainer" style="width:100%;">'.
							'<div class="clearfix" style="width:100%">'.
								'<img id="fileaway_banner_fileaway" src="'.fileaway_url.'/lib/img/fileaway_banner.png" '.
									'style="width:300px; position:absolute; right:20px; top:35px; margin:0;">'.
								'<img id="fileaway_banner_attachaway" src="'.fileaway_url.'/lib/img/attachaway_banner.png" '.
									'style="display:none; width:300px; position:absolute; right:20px; top:35px; margin:0;">'.
								'<img id="fileaway_banner_fileup" src="'.fileaway_url.'/lib/img/fileup_banner.png" '.
									'style="display:none; width:300px; position:absolute; right:20px; top:35px; margin:0;">'.
								'<img id="fileaway_banner_fileaframe" src="'.fileaway_url.'/lib/img/fileaframe_banner.png" '.
									'style="display:none; width:300px; position:absolute; right:20px; top:35px; margin:0;">'.
								$shortcode_select.$type_select.		
								'<span class="fileaway-selectIt" id="fileaway-shortcode-submit">Insert Shortcode</span>'.
							'</div><br>'.
						'</div>'.
					'</td></tr></table>'.$output.$info.				
				'</form>'.
				'</div>';
			include fileaway_dir.'/lib/js/chosen/modal.chosen.js.php';
			echo $form;			
			include fileaway_dir.'/lib/js/modal.js.php';
		}
		public function params()
		{
			// File Away
			$fileaway = $this->shortcodes['fileaway'];
			$fileaway['option'] = 'Directory Files';
			$fileaway['types'] = array('list', 'table');
			$fileaway['sections'] = array(
				'config' => 'Config',
				'modes' => 'Modes',
				'filters' => 'Filters',
				'styles' => 'Styles',
				'bannerize' => 'Bannerize'				
			);
			$fileaway['name']['section'] = 'config';
			$fileaway['name']['label'] = 'Unique Name';
			$fileaway['name']['element'] = 'text';
			$fileaway['name']['class'] = 'fileaway-half';
			$fileaway['base']['section'] = 'config';
			$fileaway['base']['label'] = 'Base Directory';
			$fileaway['base']['element'] = 'select';
			$fileaway['base']['class'] = '';
			$fileaway['sub']['section'] = 'config';
			$fileaway['sub']['label'] = 'Sub Directory';
			$fileaway['sub']['element'] = 'text';
			$fileaway['sub']['class'] = '';
			$fileaway['paginate']['section'] = 'config';
			$fileaway['paginate']['label'] = 'Paginate';
			$fileaway['paginate']['element'] = 'select';
			$fileaway['paginate']['class'] = 'fileaway-half';
			$fileaway['pagesize']['section'] = 'config';
			$fileaway['pagesize']['label'] = '# per page';
			$fileaway['pagesize']['element'] = 'text';
			$fileaway['pagesize']['class'] = 'fileaway-half';
			$fileaway['search']['section'] = 'config';
			$fileaway['search']['label'] = 'Searchable';
			$fileaway['search']['element'] = 'select';
			$fileaway['search']['class'] = '';
			$fileaway['customdata']['section'] = 'config';
			$fileaway['customdata']['label'] = 'Custom Column Name(s)';
			$fileaway['customdata']['element'] = 'text';
			$fileaway['customdata']['class'] = '';
			$fileaway['sortfirst']['section'] = 'config';
			$fileaway['sortfirst']['label'] = 'Initial Sort';
			$fileaway['sortfirst']['element'] = 'select';
			$fileaway['sortfirst']['class'] = '';
			$fileaway['s2skipconfirm']['section'] = 'config';
			$fileaway['s2skipconfirm']['label'] = 'Skip Confirmation';
			$fileaway['s2skipconfirm']['element'] = 'select';
			$fileaway['s2skipconfirm']['style'] = 'display:none';
			$fileaway['s2skipconfirm']['class'] = '';
			$fileaway['mod']['section'] = 'config';
			$fileaway['mod']['label'] = 'Date Modified';
			$fileaway['mod']['element'] = 'select';
			$fileaway['mod']['class'] = 'fileaway-half';
			$fileaway['size']['section'] = 'config';
			$fileaway['size']['label'] = 'File Size';
			$fileaway['size']['element'] = 'select';
			$fileaway['size']['class'] = 'fileaway-half';
			$fileaway['nolinks']['section'] = 'config';
			$fileaway['nolinks']['label'] = 'Disable Links';
			$fileaway['nolinks']['element'] = 'select';
			$fileaway['nolinks']['class'] = 'fileaway-half';
			$fileaway['makedir']['section'] = 'config';
			$fileaway['makedir']['label'] = 'Make Directory';
			$fileaway['makedir']['element'] = 'select';
			$fileaway['makedir']['class'] = 'fileaway-half';
			$fileaway['debug']['section'] = 'config';
			$fileaway['debug']['label'] = 'Debug';
			$fileaway['debug']['element'] = 'select';
			$fileaway['debug']['class'] = 'fileaway-half';
			$fileaway['flightbox']['section'] = 'modes';
			$fileaway['flightbox']['label'] = 'FlightBox';
			$fileaway['flightbox']['element'] = 'select';
			$fileaway['flightbox']['class'] = '';
			$fileaway['boxtheme']['section'] = 'modes';
			$fileaway['boxtheme']['label'] = 'Box Theme';
			$fileaway['boxtheme']['element'] = 'select';
			$fileaway['boxtheme']['style'] = 'display:none';
			$fileaway['boxtheme']['class'] = 'fileaway-half';
			$fileaway['maximgwidth']['section'] = 'modes';
			$fileaway['maximgwidth']['label'] = 'Max Image Width';
			$fileaway['maximgwidth']['element'] = 'text';
			$fileaway['maximgwidth']['style'] = 'display:none';
			$fileaway['maximgwidth']['class'] = 'fileaway-half';
			$fileaway['maximgheight']['section'] = 'modes';
			$fileaway['maximgheight']['label'] = 'Max Image Height';
			$fileaway['maximgheight']['element'] = 'text';
			$fileaway['maximgheight']['style'] = 'display:none';
			$fileaway['maximgheight']['class'] = 'fileaway-half';
			$fileaway['videowidth']['section'] = 'modes';
			$fileaway['videowidth']['label'] = 'Video Width';
			$fileaway['videowidth']['element'] = 'text';
			$fileaway['videowidth']['style'] = 'display:none';
			$fileaway['videowidth']['class'] = 'fileaway-half';
			$fileaway['recursive']['section'] = 'modes';
			$fileaway['recursive']['label'] = 'Recursive Iteration';
			$fileaway['recursive']['element'] = 'select';
			$fileaway['recursive']['class'] = '';
			$fileaway['directories']['section'] = 'modes';
			$fileaway['directories']['label'] = 'Directory Tree Navigation';
			$fileaway['directories']['element'] = 'select';
			$fileaway['directories']['class'] = '';
			$fileaway['manager']['section'] = 'modes';
			$fileaway['manager']['label'] = 'Manager Mode';
			$fileaway['manager']['element'] = 'select';
			$fileaway['manager']['class'] = '';
			$fileaway['password']['section'] = 'modes';
			$fileaway['password']['label'] = 'Override Password';
			$fileaway['password']['element'] = 'text';
			$fileaway['password']['style'] = 'display:none';
			$fileaway['password']['class'] = '';
			$fileaway['excludedirs']['section'] = 'modes';
			$fileaway['excludedirs']['label'] = 'Exclude Directories';
			$fileaway['excludedirs']['element'] = 'text';
			$fileaway['excludedirs']['style'] = 'display:none';
			$fileaway['excludedirs']['class'] = '';
			$fileaway['onlydirs']['section'] = 'modes';
			$fileaway['onlydirs']['label'] = 'Only These Directories';
			$fileaway['onlydirs']['element'] = 'text';
			$fileaway['onlydirs']['style'] = 'display:none';
			$fileaway['onlydirs']['class'] = '';
			$fileaway['role_override']['section'] = 'modes';
			$fileaway['role_override']['label'] = 'Role/Cap Access Override';
			$fileaway['role_override']['element'] = 'multiselect';
			$fileaway['role_override']['style'] = 'display:none';
			$fileaway['role_override']['class'] = 'fileaway-first-inline';
			$fileaway['user_override']['section'] = 'modes';
			$fileaway['user_override']['label'] = 'User Access Override';
			$fileaway['user_override']['element'] = 'text';
			$fileaway['user_override']['style'] = 'display:none';
			$fileaway['user_override']['class'] = '';
			$fileaway['dirman_access']['section'] = 'modes';
			$fileaway['dirman_access']['label'] = 'Directory Management Access';
			$fileaway['dirman_access']['element'] = 'multiselect';
			$fileaway['dirman_access']['style'] = 'display:none';
			$fileaway['dirman_access']['class'] = '';
			$fileaway['drawericon']['section'] = 'modes';
			$fileaway['drawericon']['label'] = 'Directory Icon';
			$fileaway['drawericon']['element'] = 'select';
			$fileaway['drawericon']['style'] = 'display:none';
			$fileaway['drawericon']['class'] = '';
			$fileaway['drawerlabel']['section'] = 'modes';
			$fileaway['drawerlabel']['label'] = 'Drawer Column Label';
			$fileaway['drawerlabel']['element'] = 'text';
			$fileaway['drawerlabel']['style'] = 'display:none';
			$fileaway['drawerlabel']['class'] = '';
			$fileaway['playback']['section'] = 'modes';
			$fileaway['playback']['label'] = 'Audio Playback';
			$fileaway['playback']['element'] = 'select';
			$fileaway['playback']['class'] = '';
			$fileaway['playbackpath']['section'] = 'modes';
			$fileaway['playbackpath']['label'] = 'Playback Path';
			$fileaway['playbackpath']['element'] = 'text';
			$fileaway['playbackpath']['style'] = 'display:none';
			$fileaway['playbackpath']['class'] = '';
			$fileaway['playbacklabel']['section'] = 'modes';
			$fileaway['playbacklabel']['label'] = 'Playback Column Label';
			$fileaway['playbacklabel']['element'] = 'text';
			$fileaway['playbacklabel']['style'] = 'display:none';
			$fileaway['playbacklabel']['class'] = '';
			$fileaway['onlyaudio']['section'] = 'modes';
			$fileaway['onlyaudio']['label'] = 'Audio Files Only';
			$fileaway['onlyaudio']['element'] = 'select';
			$fileaway['onlyaudio']['style'] = 'display:none';
			$fileaway['onlyaudio']['class'] = 'fileaway-half';
			$fileaway['loopaudio']['section'] = 'modes';
			$fileaway['loopaudio']['label'] = 'Loop Audio';
			$fileaway['loopaudio']['element'] = 'select';
			$fileaway['loopaudio']['style'] = 'display:none';
			$fileaway['loopaudio']['class'] = 'fileaway-half';
			$fileaway['bulkdownload']['section'] = 'modes';
			$fileaway['bulkdownload']['label'] = 'Bulk Download';
			$fileaway['bulkdownload']['element'] = 'select';
			$fileaway['bulkdownload']['class'] = '';
			$fileaway['encryption']['section'] = 'modes';
			$fileaway['encryption']['label'] = 'Encrypted Downloads';
			$fileaway['encryption']['element'] = 'select';
			$fileaway['encryption']['class'] = '';
			$fileaway['images']['section'] = 'filters';
			$fileaway['images']['label'] = 'Images';
			$fileaway['images']['element'] = 'select';
			$fileaway['images']['class'] = '';
			$fileaway['code']['section'] = 'filters';
			$fileaway['code']['label'] = 'Code Docs';
			$fileaway['code']['element'] = 'select';
			$fileaway['code']['class'] = '';
			$fileaway['exclude']['section'] = 'filters';
			$fileaway['exclude']['label'] = 'Exclude Specific';
			$fileaway['exclude']['element'] = 'text';
			$fileaway['exclude']['class'] = '';
			$fileaway['include']['section'] = 'filters';
			$fileaway['include']['label'] = 'Include Specific';
			$fileaway['include']['element'] = 'text';
			$fileaway['include']['class'] = '';
			$fileaway['only']['section'] = 'filters';
			$fileaway['only']['label'] = 'Show Only Specific';
			$fileaway['only']['element'] = 'text';
			$fileaway['only']['class'] = '';
			$fileaway['showto']['section'] = 'filters';
			$fileaway['showto']['label'] = 'Show to Roles/Caps';
			$fileaway['showto']['element'] = 'multiselect';
			$fileaway['showto']['class'] = 'fileaway-first-inline';
			$fileaway['hidefrom']['section'] = 'filters';
			$fileaway['hidefrom']['label'] = 'Hide from Roles/Caps';
			$fileaway['hidefrom']['element'] = 'multiselect';
			$fileaway['hidefrom']['class'] = '';
			$fileaway['devices']['section'] = 'filters';
			$fileaway['devices']['label'] = 'Device Visibility';
			$fileaway['devices']['element'] = 'select';
			$fileaway['devices']['class'] = '';
			$fileaway['theme']['section'] = 'styles';
			$fileaway['theme']['label'] = 'Theme';
			$fileaway['theme']['element'] = 'select';
			$fileaway['theme']['class'] = '';
			$fileaway['width']['section'] = 'styles';
			$fileaway['width']['label'] = 'Width';
			$fileaway['width']['element'] = 'text';
			$fileaway['width']['class'] = 'fileaway-half';
			$fileaway['perpx']['section'] = 'styles';
			$fileaway['perpx']['label'] = 'Width In';
			$fileaway['perpx']['element'] = 'select';
			$fileaway['perpx']['class'] = 'fileaway-half';
			$fileaway['align']['section'] = 'styles';
			$fileaway['align']['label'] = 'Align';
			$fileaway['align']['element'] = 'select';
			$fileaway['align']['class'] = 'fileaway-half';
			$fileaway['textalign']['section'] = 'styles';
			$fileaway['textalign']['label'] = 'Text Align';
			$fileaway['textalign']['element'] = 'select';
			$fileaway['textalign']['class'] = 'fileaway-half';
			$fileaway['heading']['section'] = 'styles';
			$fileaway['heading']['label'] = 'Heading';
			$fileaway['heading']['element'] = 'text';
			$fileaway['heading']['class'] = '';
			$fileaway['hcolor']['section'] = 'styles';
			$fileaway['hcolor']['label'] = 'Heading Color';
			$fileaway['hcolor']['element'] = 'select';
			$fileaway['hcolor']['class'] = 'fileaway-half';
			$fileaway['color']['section'] = 'styles';
			$fileaway['color']['label'] = 'Link Color';
			$fileaway['color']['element'] = 'select';
			$fileaway['color']['class'] = 'fileaway-half';
			$fileaway['accent']['section'] = 'styles';
			$fileaway['accent']['label'] = 'Accent';
			$fileaway['accent']['element'] = 'select';
			$fileaway['accent']['class'] = 'fileaway-half';
			$fileaway['iconcolor']['section'] = 'styles';
			$fileaway['iconcolor']['label'] = 'Icon Color';
			$fileaway['iconcolor']['element'] = 'select';
			$fileaway['iconcolor']['class'] = 'fileaway-half';
			$fileaway['corners']['section'] = 'styles';
			$fileaway['corners']['label'] = 'Corners';
			$fileaway['corners']['element'] = 'select';
			$fileaway['corners']['class'] = '';
			$fileaway['display']['section'] = 'styles';
			$fileaway['display']['label'] = 'Display';
			$fileaway['display']['element'] = 'select';
			$fileaway['display']['class'] = '';
			$fileaway['icons']['section'] = 'styles';
			$fileaway['icons']['label'] = 'Icons';
			$fileaway['icons']['element'] = 'select';
			$fileaway['icons']['class'] = 'fileaway-half';
			$fileaway['thumbnails']['section'] = 'styles';
			$fileaway['thumbnails']['label'] = 'Image Thumbnails';
			$fileaway['thumbnails']['element'] = 'select';
			$fileaway['thumbnails']['class'] = '';
			$fileaway['maxsrcbytes']['section'] = 'styles';
			$fileaway['maxsrcbytes']['label'] = 'Max Source Image Bytes';
			$fileaway['maxsrcbytes']['element'] = 'text';
			$fileaway['maxsrcbytes']['style'] = 'display:none';
			$fileaway['maxsrcbytes']['class'] = '';
			$fileaway['maxsrcwidth']['section'] = 'styles';
			$fileaway['maxsrcwidth']['label'] = 'Max Source Image Width';
			$fileaway['maxsrcwidth']['element'] = 'text';
			$fileaway['maxsrcwidth']['style'] = 'display:none';
			$fileaway['maxsrcwidth']['class'] = '';
			$fileaway['maxsrcheight']['section'] = 'styles';
			$fileaway['maxsrcheight']['label'] = 'Max Source Image Height';
			$fileaway['maxsrcheight']['element'] = 'text';
			$fileaway['maxsrcheight']['style'] = 'display:none';
			$fileaway['maxsrcheight']['class'] = '';
			$fileaway['thumbstyle']['section'] = 'styles';
			$fileaway['thumbstyle']['label'] = 'Thumbnail Style';
			$fileaway['thumbstyle']['element'] = 'select';
			$fileaway['thumbstyle']['style'] = 'display:none';
			$fileaway['thumbstyle']['class'] = '';
			$fileaway['graythumbs']['section'] = 'styles';
			$fileaway['graythumbs']['label'] = 'Thumbnail Color Filter';
			$fileaway['graythumbs']['element'] = 'select';
			$fileaway['graythumbs']['style'] = 'display:none';
			$fileaway['graythumbs']['class'] = '';
			$fileaway['bannerize']['section'] = 'bannerize';
			$fileaway['bannerize']['label'] = 'Banner Interval';
			$fileaway['bannerize']['element'] = 'text';
			$fileaway['bannerize']['class'] = 'fileaway-half';						
			$this->shortcodes['fileaway'] = $fileaway;
			// Attach Away
			$attachaway = $this->shortcodes['attachaway'];
			$attachaway['option'] = 'Post/Page Attachments';
			$attachaway['types'] = array('list', 'table');
			$attachaway['sections'] = array(
				'config' => 'Config',
				'modes' => 'Modes',
				'filters' => 'Filters',
				'styles' => 'Styles'
			);
			$attachaway['postid']['section'] = 'config';
			$attachaway['postid']['label'] = 'Post ID';
			$attachaway['postid']['element'] = 'text';
			$attachaway['postid']['class'] = 'fileaway-half';
			$attachaway['paginate']['section'] = 'config';
			$attachaway['paginate']['label'] = 'Paginate';
			$attachaway['paginate']['element'] = 'select';
			$attachaway['paginate']['class'] = 'fileaway-half';
			$attachaway['pagesize']['section'] = 'config';
			$attachaway['pagesize']['label'] = '# per page';
			$attachaway['pagesize']['element'] = 'text';
			$attachaway['pagesize']['class'] = 'fileaway-half';
			$attachaway['search']['section'] = 'config';
			$attachaway['search']['label'] = 'Searchable';
			$attachaway['search']['element'] = 'select';
			$attachaway['search']['class'] = 'fileaway-half';
			$attachaway['capcolumn']['section'] = 'config';
			$attachaway['capcolumn']['label'] = 'Caption Column Name';
			$attachaway['capcolumn']['element'] = 'text';
			$attachaway['capcolumn']['class'] = '';
			$attachaway['descolumn']['section'] = 'config';
			$attachaway['descolumn']['label'] = 'Description Column Name';
			$attachaway['descolumn']['element'] = 'text';
			$attachaway['descolumn']['class'] = '';
			$attachaway['sortfirst']['section'] = 'config';
			$attachaway['sortfirst']['label'] = 'Initial Sort';
			$attachaway['sortfirst']['element'] = 'select';
			$attachaway['sortfirst']['class'] = '';
			$attachaway['orderby']['section'] = 'config';
			$attachaway['orderby']['label'] = 'Order By';
			$attachaway['orderby']['element'] = 'select';
			$attachaway['orderby']['class'] = '';
			$attachaway['desc']['section'] = 'config';
			$attachaway['desc']['label'] = 'Asc/Desc';
			$attachaway['desc']['element'] = 'select';
			$attachaway['desc']['class'] = 'fileaway-half';
			$attachaway['size']['section'] = 'config';
			$attachaway['size']['label'] = 'File Size';
			$attachaway['size']['element'] = 'select';
			$attachaway['size']['class'] = 'fileaway-half';
			$attachaway['debug']['section'] = 'config';
			$attachaway['debug']['label'] = 'Debug';
			$attachaway['debug']['element'] = 'select';
			$attachaway['debug']['class'] = 'fileaway-half';
			$attachaway['flightbox']['section'] = 'modes';
			$attachaway['flightbox']['label'] = 'Flightbox';
			$attachaway['flightbox']['element'] = 'select';
			$attachaway['flightbox']['class'] = '';
			$attachaway['boxtheme']['section'] = 'modes';
			$attachaway['boxtheme']['label'] = 'Box Theme';
			$attachaway['boxtheme']['element'] = 'select';
			$attachaway['boxtheme']['style'] = 'display:none';
			$attachaway['boxtheme']['class'] = 'fileaway-half';
			$attachaway['maximgwidth']['section'] = 'modes';
			$attachaway['maximgwidth']['label'] = 'Max Image Width';
			$attachaway['maximgwidth']['element'] = 'text';
			$attachaway['maximgwidth']['style'] = 'display:none';
			$attachaway['maximgwidth']['class'] = 'fileaway-half';
			$attachaway['maximgheight']['section'] = 'modes';
			$attachaway['maximgheight']['label'] = 'Max Image Height';
			$attachaway['maximgheight']['element'] = 'text';
			$attachaway['maximgheight']['style'] = 'display:none';
			$attachaway['maximgheight']['class'] = 'fileaway-half';
			$attachaway['videowidth']['section'] = 'modes';
			$attachaway['videowidth']['label'] = 'Video Width';
			$attachaway['videowidth']['element'] = 'text';
			$attachaway['videowidth']['style'] = 'display:none';
			$attachaway['videowidth']['class'] = 'fileaway-half';
			$attachaway['images']['section'] = 'filters';
			$attachaway['images']['label'] = 'Images';
			$attachaway['images']['element'] = 'select';
			$attachaway['images']['class'] = '';
			$attachaway['code']['section'] = 'filters';
			$attachaway['code']['label'] = 'Code Docs';
			$attachaway['code']['element'] = 'select';
			$attachaway['code']['class'] = '';
			$attachaway['exclude']['section'] = 'filters';
			$attachaway['exclude']['label'] = 'Exclude Specific';
			$attachaway['exclude']['element'] = 'text';
			$attachaway['exclude']['class'] = '';
			$attachaway['include']['section'] = 'filters';
			$attachaway['include']['label'] = 'Include Specific';
			$attachaway['include']['element'] = 'text';
			$attachaway['include']['class'] = '';
			$attachaway['only']['section'] = 'filters';
			$attachaway['only']['label'] = 'Show Only Specific';
			$attachaway['only']['element'] = 'text';
			$attachaway['only']['class'] = '';
			$attachaway['showto']['section'] = 'filters';
			$attachaway['showto']['label'] = 'Show to Roles/Caps';
			$attachaway['showto']['element'] = 'multiselect';
			$attachaway['showto']['class'] = 'fileaway-first-inline';
			$attachaway['hidefrom']['section'] = 'filters';
			$attachaway['hidefrom']['label'] = 'Hide from Roles/Caps';
			$attachaway['hidefrom']['element'] = 'multiselect';
			$attachaway['hidefrom']['class'] = '';
			$attachaway['devices']['section'] = 'filters';
			$attachaway['devices']['label'] = 'Device Visibility';
			$attachaway['devices']['element'] = 'select';
			$attachaway['devices']['class'] = '';
			$attachaway['theme']['section'] = 'styles';
			$attachaway['theme']['label'] = 'Theme';
			$attachaway['theme']['element'] = 'select';
			$attachaway['theme']['class'] = '';
			$attachaway['width']['section'] = 'styles';
			$attachaway['width']['label'] = 'Width';
			$attachaway['width']['element'] = 'text';
			$attachaway['width']['class'] = 'fileaway-half';
			$attachaway['perpx']['section'] = 'styles';
			$attachaway['perpx']['label'] = 'Width In';
			$attachaway['perpx']['element'] = 'select';
			$attachaway['perpx']['class'] = 'fileaway-half';
			$attachaway['align']['section'] = 'styles';
			$attachaway['align']['label'] = 'Align';
			$attachaway['align']['element'] = 'select';
			$attachaway['align']['class'] = 'fileaway-half';
			$attachaway['textalign']['section'] = 'styles';
			$attachaway['textalign']['label'] = 'Text Align';
			$attachaway['textalign']['element'] = 'select';
			$attachaway['textalign']['class'] = 'fileaway-half';
			$attachaway['heading']['section'] = 'styles';
			$attachaway['heading']['label'] = 'Heading';
			$attachaway['heading']['element'] = 'text';
			$attachaway['heading']['class'] = '';
			$attachaway['hcolor']['section'] = 'styles';
			$attachaway['hcolor']['label'] = 'Heading Color';
			$attachaway['hcolor']['element'] = 'select';
			$attachaway['hcolor']['class'] = 'fileaway-half';
			$attachaway['color']['section'] = 'styles';
			$attachaway['color']['label'] = 'Link Color';
			$attachaway['color']['element'] = 'select';
			$attachaway['color']['class'] = 'fileaway-half';
			$attachaway['accent']['section'] = 'styles';
			$attachaway['accent']['label'] = 'Accent';
			$attachaway['accent']['element'] = 'select';
			$attachaway['accent']['class'] = 'fileaway-half';
			$attachaway['iconcolor']['section'] = 'styles';
			$attachaway['iconcolor']['label'] = 'Icon Color';
			$attachaway['iconcolor']['element'] = 'select';
			$attachaway['iconcolor']['class'] = 'fileaway-half';
			$attachaway['corners']['section'] = 'styles';
			$attachaway['corners']['label'] = 'Corners';
			$attachaway['corners']['element'] = 'select';
			$attachaway['corners']['class'] = '';
			$attachaway['display']['section'] = 'styles';
			$attachaway['display']['label'] = 'Display';
			$attachaway['display']['element'] = 'select';
			$attachaway['display']['class'] = '';
			$attachaway['icons']['section'] = 'styles';
			$attachaway['icons']['label'] = 'Icons';
			$attachaway['icons']['element'] = 'select';
			$attachaway['icons']['class'] = 'fileaway-half';
			$this->shortcodes['attachaway'] = $attachaway;
			// File Up
			$fileup = $this->shortcodes['fileup'];
			$fileup['option'] = 'File Uploads';
			$fileup['types'] = array('upload');
			$fileup['sections'] = array(
				'config' => 'Config',
				'filters' => 'Filters',
				'styles' => 'Styles'
			);
			$fileup['name']['section'] = 'config';
			$fileup['name']['label'] = 'Unique Name';
			$fileup['name']['element'] = 'text';
			$fileup['name']['class'] = 'fileaway-half';
			$fileup['base']['section'] = 'config';
			$fileup['base']['label'] = 'Base Directory';
			$fileup['base']['element'] = 'select';
			$fileup['base']['class'] = '';
			$fileup['sub']['section'] = 'config';
			$fileup['sub']['label'] = 'Sub Directory';
			$fileup['sub']['element'] = 'text';
			$fileup['sub']['class'] = '';
			$fileup['makedir']['section'] = 'config';
			$fileup['makedir']['label'] = 'Make Directory';
			$fileup['makedir']['element'] = 'select';
			$fileup['makedir']['class'] = 'fileaway-half';			
			$fileup['single']['section'] = 'config';
			$fileup['single']['label'] = 'Uploads at a Time';
			$fileup['single']['element'] = 'select';
			$fileup['single']['class'] = '';
			$fileup['maxsize']['section'] = 'config';
			$fileup['maxsize']['label'] = 'Max Size';
			$fileup['maxsize']['element'] = 'text';
			$fileup['maxsize']['class'] = 'fileaway-half';
			$fileup['maxsizetype']['section'] = 'config';
			$fileup['maxsizetype']['label'] = 'Max Size In';
			$fileup['maxsizetype']['element'] = 'select';
			$fileup['maxsizetype']['class'] = 'fileaway-half';
			$fileup['uploadlabel']['section'] = 'config';
			$fileup['uploadlabel']['label'] = 'Upload Label';
			$fileup['uploadlabel']['element'] = 'text';
			$fileup['uploadlabel']['class'] = '';
			$fileup['fixedlocation']['section'] = 'config';
			$fileup['fixedlocation']['label'] = 'Allow Subdirectories';
			$fileup['fixedlocation']['element'] = 'select';
			$fileup['fixedlocation']['class'] = '';
			$fileup['uploader']['section'] = 'config';
			$fileup['uploader']['label'] = 'Append Uploader Name';
			$fileup['uploader']['element'] = 'select';
			$fileup['uploader']['class'] = '';			
			$fileup['filetypes']['section'] = 'filters';
			$fileup['filetypes']['label'] = 'File Types';
			$fileup['filetypes']['element'] = 'text';
			$fileup['filetypes']['class'] = '';
			$fileup['filegroups']['section'] = 'filters';
			$fileup['filegroups']['label'] = 'File Type Groups';
			$fileup['filegroups']['element'] = 'multiselect';
			$fileup['filegroups']['class'] = 'fileaway-first-inline';
			$fileup['action']['section'] = 'filters';
			$fileup['action']['label'] = 'File Type Action';
			$fileup['action']['element'] = 'select';
			$fileup['action']['class'] = '';
			$fileup['showto']['section'] = 'filters';
			$fileup['showto']['label'] = 'Show to Roles/Caps';
			$fileup['showto']['element'] = 'multiselect';
			$fileup['showto']['class'] = '';
			$fileup['hidefrom']['section'] = 'filters';
			$fileup['hidefrom']['label'] = 'Hide from Roles/Caps';
			$fileup['hidefrom']['element'] = 'multiselect';
			$fileup['hidefrom']['class'] = '';
			$fileup['devices']['section'] = 'filters';
			$fileup['devices']['label'] = 'Device Visibility';
			$fileup['devices']['element'] = 'select';
			$fileup['devices']['class'] = '';
			$fileup['theme']['section'] = 'styles';
			$fileup['theme']['label'] = 'Theme';
			$fileup['theme']['element'] = 'select';
			$fileup['theme']['class'] = '';
			$fileup['width']['section'] = 'styles';
			$fileup['width']['label'] = 'Width';
			$fileup['width']['element'] = 'text';
			$fileup['width']['class'] = 'fileaway-half';
			$fileup['perpx']['section'] = 'styles';
			$fileup['perpx']['label'] = 'Width In';
			$fileup['perpx']['element'] = 'select';
			$fileup['perpx']['class'] = 'fileaway-half';
			$fileup['align']['section'] = 'styles';
			$fileup['align']['label'] = 'Align';
			$fileup['align']['element'] = 'select';
			$fileup['align']['class'] = 'fileaway-half';
			$fileup['iconcolor']['section'] = 'styles';
			$fileup['iconcolor']['label'] = 'Icon Color';
			$fileup['iconcolor']['element'] = 'select';
			$fileup['iconcolor']['class'] = 'fileaway-half';
			$this->shortcodes['fileup'] = $fileup;
			// File-a-Frame
			$fileaframe = $this->shortcodes['fileaframe'];
			$fileaframe['option'] = 'File Away iframe';
			$fileaframe['types'] = array('iframe');
			$fileaframe['sections'] = array(
				'config' => 'Config',
				'filters' => 'Filters',
			);
			$fileaframe['source']['section'] = 'config';
			$fileaframe['source']['label'] = 'Source URL';
			$fileaframe['source']['element'] = 'text';
			$fileaframe['source']['class'] = '';
			$fileaframe['name']['section'] = 'config';
			$fileaframe['name']['label'] = 'Unique Name';
			$fileaframe['name']['element'] = 'text';
			$fileaframe['name']['class'] = '';
			$fileaframe['width']['section'] = 'config';
			$fileaframe['width']['label'] = 'Width';
			$fileaframe['width']['element'] = 'text';
			$fileaframe['width']['class'] = 'fileaway-half';
			$fileaframe['height']['section'] = 'config';
			$fileaframe['height']['label'] = 'Height';
			$fileaframe['height']['element'] = 'text';
			$fileaframe['height']['class'] = 'fileaway-half';			
			$fileaframe['mwidth']['section'] = 'config';
			$fileaframe['mwidth']['label'] = 'Margin Width';
			$fileaframe['mwidth']['element'] = 'text';
			$fileaframe['mwidth']['class'] = 'fileaway-half';
			$fileaframe['mheight']['section'] = 'config';
			$fileaframe['mheight']['label'] = 'Margin Height';
			$fileaframe['mheight']['element'] = 'text';
			$fileaframe['mheight']['class'] = 'fileaway-half';			
			$fileaframe['scroll']['section'] = 'config';
			$fileaframe['scroll']['label'] = 'Scrolling';
			$fileaframe['scroll']['element'] = 'select';
			$fileaframe['scroll']['class'] = '';
			$fileaframe['devices']['section'] = 'filters';
			$fileaframe['devices']['label'] = 'Device Visibility';
			$fileaframe['devices']['element'] = 'select';
			$fileaframe['devices']['class'] = '';						
			$this->shortcodes['fileaframe'] = $fileaframe;
		}
	}
}