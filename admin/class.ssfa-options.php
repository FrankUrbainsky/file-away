<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
class File_Away_Options {
	private $sections;
	private $checkboxes;
	private $settings;
	public function __construct(){
 		$this->checkboxes = array();
		$this->settings = array();
		$this->get_settings();
		$this->sections['config']		= __('Basic Configuration');
		$this->sections['options']		= __('Feature Options');
		$this->sections['customcss']	= __('Custom Styles');
		$this->sections['manager']		= __('Manager Mode');		
		$this->sections['reset']		= __('Database Options');		
		$this->sections['tutorials']	= __('Tutorials');
		$this->sections['about']		= __('About');				
		add_action('admin_menu', array(&$this, 'add_pages'));
		add_action('admin_init', array(&$this, 'register_settings'));
		if (! get_option('fileaway_options'))
			$this->initialize_settings();
	}
	public function add_pages(){
		$ssfa_icon = (SSFA_IMAGES_URL.'ssfaicon.png');
		$admin_slug = 'admin.php?page=file-away';
		$admin_page = 
			add_menu_page(__('File Away'), // page title
			__('File Away'), // menu title
			'manage_options', // access
			'file-away', // slug
			array(&$this, 'display_page'), // callback
			$ssfa_icon, // icon
			'99.00000000000000001'); // menu position
		add_action('admin_print_scripts-' . $admin_page, array(&$this, 'scripts'));
		add_action('admin_print_styles-' . $admin_page, array(&$this, 'styles'));
		if (SSFA_CSS_EDITOR === 'syntax')
			add_action('admin_head-'. $admin_page, 'ssfacss_resources');
		// Disable WP Editor in this page if is active
		if (is_plugin_active("wp-editor/wpeditor.php") and $_SERVER['QUERY_STRING'] == 'page=file-away'){
			function remove_wpeditor_header_info(){
				// WP Editor Style
				wp_deregister_style('wpeditor');
				wp_deregister_style('fancybox');
				wp_deregister_style('codemirror');
				wp_deregister_style('codemirror_dialog');
				wp_deregister_style('codemirror_themes');
				// WP Editor Script
				wp_deregister_script('wpeditor');
				wp_deregister_script('wp-editor-posts-jquery');
				wp_deregister_script('fancybox');
				wp_deregister_script('codemirror');
				wp_deregister_script('codemirror_php');
				wp_deregister_script('codemirror_javascript');
				wp_deregister_script('codemirror_css');
				wp_deregister_script('codemirror_xml');
				wp_deregister_script('codemirror_clike');
				wp_deregister_script('codemirror_dialog');
				wp_deregister_script('codemirror_search');
				wp_deregister_script('codemirror_searchcursor');
				wp_deregister_script('codemirror_mustache'); }
			add_action('admin_init', 'remove_wpeditor_header_info', 20);
		}
	}
	public function create_setting($args = array()){
		$defaults = array(
			'id'      	=> '',			'id2'     	=> '',		'title'   	=> __(''),	'desc'    	=> __(''),
			'std'     	=> '',			'std2'    	=> '',		'type'    	=> 'text',		'section' 	=> 'config',
			'choices' 	=> array(),		'class'   	=> '',		'class2'  	=> '',			'dflt'    	=> '',	
			'helplink'	=> '',			'submit'  	=> '', 		'input'		=> 'text');
		extract(wp_parse_args($args, $defaults));
		$field_args = array(
			'type'      => $type,		'id'        => $id,			'id2'       => $id2,		'desc'      => $desc,
			'std'       => $std,		'std2'      => $std2,		'choices'   => $choices,	'label_for' => $id,
			'class'     => $class,		'class2'    => $class2,		'dflt'      => $dflt,		'helplink'	=> $helplink,	
			'submit'	=> $submit, 	'input'		=> $input);
		if ($type == 'checkbox')
			$this->checkboxes[] = $id;
		add_settings_field($id, $title, array($this, 'display_setting'), 'file-away', $section, $field_args);
	}
	public function display_page(){
		if(SSFA_ADMINSTYLE === 'minimal') unset($this->sections['about']);
		$randysave = rand (1, 5);
		if (SSFA_ADMINSTYLE !== 'minimal'):
			if ($randysave < 4): $saving = 'Filing away...'; $saved = 'Oh Glory!'; 
			elseif ($randysave === 4): $saving = 'Gettin\' saved...'; $saved = 'Hallelujah, by and by.'; 
			elseif ($randysave === 5): $saving = 'Just a few more weary days and then...'; $saved = '...your settings will be saved.'; 
			endif;
			$savinganimation = "<img src='".SSFA_IMAGES_URL."saving.gif'>"; $bannersize = '500px';
		else: $saving = 'Saving changes...'; $saved = 'Changes saved.'; $savinganimation = null; $bannersize = '300px';
		endif;
		echo '<div class="wrap">
				<img src="'.SSFA_IMAGES_URL.'fileaway_banner.png" style="width:'.$bannersize.';">';
		if (isset($_GET['settings-updated']) and $_GET['settings-updated'] == true)
			echo '<div class="updated fade"><p>' . __('Settings Saved.') . '</p></div>';
		echo '<form action="options.php" method="post" id="ssfa-form">';
		settings_fields('fileaway_options');
		echo '<div class="ssfa-ui-tabs">
				<ul class="ssfa-ui-tabs-nav">';
		foreach ($this->sections as $section_slug => $section)
			echo "<li class='$section_slug'><a href='#$section_slug' class='$section_slug'>$section</a></li>";
		echo '</ul>';
		do_settings_sections($_GET['page']);
		echo "</div>
		<div id='ssfa-saving-backdrop'>
		<div id='ssfa-saving'>$saving</div>
		<div id='ssfa-saving-img'>$savinganimation</div>		
		<div id='ssfa-settings-saved'>$saved</div>
		</div>
		</form>";
		echo '<script type="text/javascript">
				jQuery(document).ready(function($){
					var sections = [];';
			foreach ($this->sections as $section_slug => $section)
				echo "sections['$section'] = '$section_slug';";
			echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ssfa-ui-tabs-panel\">");
					wrapped.each(function(){
						$(this).parent().append($(this).parent().nextUntil("div.ssfa-ui-tabs-panel"));
					});
					$(".ssfa-ui-tabs-panel").each(function(index){
						$(this).attr("id", sections[$(this).children("h3").text()]);
						if (index > 0)
							$(this).addClass("ssfa-ui-tabs-hide");
					});
					$(".ssfa-ui-tabs").tabs({
						show: {
							effect: "fadeIn",
							duration: 500,
							delay: 500
						},
						hide: {	
							effect: "fadeOut",
							duration: 500,
						},
						activate: function(event, ui){ 
							ui.newTab.index(); 
							cminst.refresh();
						}							
		 			});
					$("input[type=text], textarea").each(function(){
						if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
						$(this).css("color", "#BBBBBB");
					});
					$("input[type=text], textarea").focus(function(){
						if ($(this).val() == $(this).attr("placeholder") || $(this).val() == ""){
							$(this).val("");
							$(this).css("color", "#666666");
						}
					}).blur(function(){
						if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")){
						$(this).val($(this).attr("placeholder"));
						$(this).css("color", "#BBBBBB");
						}
					});
					$(".wrap h3, .wrap table").show();
					$(".warning").change(function(){
						if ($(this).is(":checked"))
						$(this).parent().css("background", "#AB7137").css("color", "#fff").css("fontWeight", "normal");
							else
						$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
					});
					// Browser compatibility
					if ($.browser.mozilla) 
				         $("form").attr("autocomplete", "off");
					});
			</script>';
			include_once SSFA_ADMIN_RESOURCES.'options-help.php'; 		
			echo '</div>';
		// PUSH CUSTOM CSS
		$ssfa_customcss = ssfa_customcss();
		if (!empty($ssfa_customcss))
			ssfa_create_css();
		elseif (empty($ssfa_customcss) and file_exists(css_path()))
			unlink(css_path());
	}
	// SECTION DESCRIPTIONS
	public function display_section(){
		// code
	}
	public function display_config_section(){
		include_once SSFA_ADMIN_RESOURCES.'config-instructions.php'; 		
	}
	public function display_options_section(){
		echo '<p></p>';
	}	
	public function display_customcss_section(){
		include_once SSFA_ADMIN_RESOURCES.'custom-styles-getting-started.php'; 		
	}
	public function display_tutorials_section(){
		include_once SSFA_ADMIN_RESOURCES.'tutorials.php'; 		
	}
	public function display_manager_section(){
		echo '<p></p>';		
	}
	public function display_reset_section(){
		echo '<p></p>';		
	}
	public function display_about_section(){
		if(SSFA_ADMINSTYLE !== 'minimal') include_once SSFA_ADMIN_RESOURCES.'about.php'; 				
	}
	public function display_setting($args = array()){
		extract($args);
		$options = get_option('fileaway_options');
		if (! isset($options[$id]) and $type != 'checkbox')
			$options[$id] = $dflt;
		elseif (! isset($options[$id]))
			$options[$id] = 0;
		$field_class = '';
		if ($class != '')
			$field_class = ' ' . $class;
		$field_class2 = '';
		if ($class2 != '')
			$field_class2 = ' ' . $class2;			
		$submit = ($submit === 'yes' ? '<p class="submit" style="position:relative; left:-175px;"><input name="Submit" type="submit" class="ssfa-save-btn ssfa-selectIt" value="' . __('Save Changes') . '" /><br /></p>' : null);
		global $is_IE, $is_chrome;
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$is_opera = (preg_match('/opr/i', $agent)) ? true : false;
		$chromefix = ($is_chrome or $is_opera ? ' ssfa-abspath-chromefix' : null);
		$iefix = ($is_IE ? ' ssfa-abspath-iefix' : null);
		$abspath = $GLOBALS['ssfa_abspath'];
		$abspath = (strpos($abspath,'/public_html/') !== false ? strstr($abspath, '/public_html/') : $abspath);
		$helplink = ($helplink === 'yes' ? '<span class="link-ssfa-help-'.$id.' ssfa-helplink ssfa-help-iconinfo4"></span>' : null);
		switch ($type){
			case 'heading':
				echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
			break;
			case 'checkbox':
				echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="fileaway_options[' . $id . ']" value="1" ' . checked($options[$id], 1, false) . ' /> <label for="' . $id . '">' . $desc . '</label>' . $helplink;
			break;
			case 'select':
				echo '<select class="select' . $field_class . '" name="fileaway_options[' . $id . ']">';
				foreach ($choices as $value => $label)
					echo '<option value="' . esc_attr($value) . '"' . selected($options[$id], $value, false) . '>' . $label . '</option>';
				echo '</select>' . $helplink;
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>';
				if ($submit != null)
					echo '<br /><br /><br />'.$submit;
			break;
			case 'radio':
				$i = 0;
				echo '<table class="ssfa-radio"><tr><td valign=top>';
				foreach ($choices as $value => $label){
					echo '<input class="radio' . $field_class . '" type="radio" name="fileaway_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr($value) . '" ' . checked($options[$id], $value, false) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ($i < count($options) - 1)
						echo '<br />';
					$i++;
				}
				echo '</td><td valign=top>' . $helplink . '</td></tr></table>';	
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>';
				if ($submit != null)
					echo '<br /><br />'.$submit;					
			break;
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="fileaway_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre($options[$id]) . '</textarea>' . $helplink;
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>';
			break;
			case 'text':
			default:
		 		echo '<input class="regular-text' . $field_class . '" type="'.$input.'" id="' . $id . '" name="fileaway_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" />' . $helplink;
		 		if ($desc != '')
		 			echo '<br /><div class="ssfa-description">' . $desc . '</div>';
				if ($submit != null)
					echo '<br /><br /><br />'.$submit;
		 	break;
			case 'basedir':
						if ($desc != '')
		 			echo '<br /><div class="ssfa-description">' . $desc . '</div><br />';
			default:
				echo '<div id="ssfa-wrap-'.$id.'" class="ssfa-wrap-base"><span id="ssfa-abspath-'.$id.'" class="ssfa-abspath'.$chromefix.'">' . $abspath . '</span> <input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="fileaway_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" /></div> <input class="regular-text' . $field_class2 . '" type="text" id="' . $id2 . '" name="fileaway_options[' . $id2 . ']" placeholder="' . $std2 . '" value="' . esc_attr($options[$id2]) . '" />' . $helplink. '<br />
				<div id="ssfa-error-'.$id.'" style="display:none; line-height:14px;"><p>Sorry. You can\'t point to the wp-admin/ or wp-includes/ directories.
				<br />
				Use wp-uploads, or custom folders in your installation directory.</p></div>';
		 	break;
			case 'customcss':
				echo '<textarea class="ssfa-customcss ' . $field_class . '" id="' . $id . '" name="fileaway_options[' . $id . ']" placeholder="' . $std . '" rows="10" cols="50">' . wp_htmledit_pre($options[$id]) . '</textarea>' . $helplink. '
				<script language="javascript">
					var tocm = document.getElementById("' . $id . '");    
					var cminst = CodeMirror.fromTextArea(tocm, { lineNumbers: true });
				</script>';
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>';
			break;
			case 'modalaccess':
				$user = new WP_User(1);
				$capslist = $user->allcaps;
				echo '<select class="select' . $field_class . '" name="fileaway_options[' . $id . ']">';
				echo '<option value="' . esc_attr('administrator') . '" '.selected($options[$id], 'administrator', false) . '>
							Administrators Only
					  </option>
				  	  <option value="' . esc_attr('ss_fake_cap_nobody') . '" '.selected($options[$id], 'ss_fake_cap_nobody', false) . '>
							Disable for Everyone
					  </option>';
					foreach($capslist as $cap=>$caps)
					{
						if ($cap !== 'administrator' 
						and $cap !== 'level_0' 
						and $cap !== 'level_1' 
						and $cap !== 'level_2' 
						and $cap !== 'level_3' 
						and $cap !== 'level_4' 
						and $cap !== 'level_5' 
						and $cap !== 'level_6' 
						and $cap !== 'level_7' 
						and $cap !== 'level_8' 
						and $cap !== 'level_9' 
						and $cap !== 'level_10')
						{ 
							echo '<option value="' . esc_attr($cap) . '" '.selected($options[$id], $cap, false) . '>'
										.$cap.
								 '</option>';
						}
					}
							echo '</select>' . $helplink;
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>';
			break;
			case 'manager_role_access':
				echo '<input type="'.$input.'" id="'.$id.'" name="fileaway_options['.$id.']" value="'.esc_attr($options[$id]).'" />';
				echo '<select id="manager-role-access" class="select chozed-select" data-placeholder="&nbsp;" multiple>';
				global $wp_roles;
				$all_roles = $wp_roles->roles;
				$editable_roles = apply_filters('editable_roles', $all_roles);
				foreach($editable_roles as $role=>$theroles):
					$roles = explode(',', SSFA_MANAGER_ROLES);
					$selected = null;
					foreach ($roles as $r): if ($r === $role) $selected = 'selected'; endforeach;
					echo '<option value="' . $role . '" '.$selected.'>'.$wp_roles->role_names[$role].'</option>';
				endforeach;
				echo '</select>' . $helplink;
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>'; 
				if ($submit != null)
					echo '<br /><br /><br />'.$submit;					
			break;	
			case 'manager_user_access':
				echo '<input type="'.$input.'" id="'.$id.'" name="fileaway_options['.$id.']" value="'.esc_attr($options[$id]).'" />';
				echo '<select id="manager-user-access" class="select chozed-select" data-placeholder="&nbsp;" multiple>';
				$users = get_users('blog_id='.$GLOBALS['blog_id'].'&orderby=nicename');
				foreach($users as $user):
					$approved = explode(',', SSFA_MANAGER_USERS);
					$selected = null;
					foreach ($approved as $appr): if ( $appr == $user->ID ) $selected = 'selected'; endforeach;
					echo '<option value="' . $user->ID . '" '.$selected.'>'.$user->display_name.'</option>';
				endforeach;
				echo '</select>' . $helplink;
				if ($desc != '')
					echo '<br /><div class="ssfa-description">' . $desc . '</div>'; 
				if ($submit != null)
					echo '<br /><br /><br />'.$submit;					
			break;				
		}
	}
	public function get_settings(){
		/* Basic Configuration
		===========================================*/
		$this->settings['rootdirectory'] = array(
			'section' => 'config',
			'title'   => __('Set Root Directory'),
			'desc'    => __(''),
			'type'    => 'select',
			'std'     => '',
			'dflt'    => 'install',
			'choices' => array(
				'install' => 'WP Install Directory',
				'siteurl' => 'Site Root Directory'
			),
			'helplink'=> 'yes'
		);
		$this->settings['base1'] = array(
			'title'   => __('Base Directory 1'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'basedir',
			'section' => 'config',
			'class'	  => 'ssfa-basedir',
			'id2'	  => 'bs1name',
			'std2'	  => 'Display Name',
			'class2'  => 'ssfa-basename'
		);
		$this->settings['base2'] = array(
			'title'   => __('Base Directory 2'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'basedir',
			'section' => 'config',
			'id2'	  => 'bs2name',
			'std2'	  => 'Display Name',
			'class'	  => 'ssfa-basedir',
			'class2'  => 'ssfa-basename'
		);
		$this->settings['base3'] = array(
			'title'   => __('Base Directory 3'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'basedir',
			'section' => 'config',
			'id2'	  => 'bs3name',
			'std2'	  => 'Display Name',
			'class'	  => 'ssfa-basedir',
			'class2'  => 'ssfa-basename'
		);
		$this->settings['base4'] = array(
			'title'   => __('Base Directory 4'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'basedir',
			'section' => 'config',
			'id2'	  => 'bs4name',
			'std2'	  => 'Display Name',
			'class'	  => 'ssfa-basedir',
			'class2'  => 'ssfa-basename'
		);
		$this->settings['base5'] = array(
			'title'   => __('Base Directory 5'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'basedir',
			'section' => 'config',
			'id2'	  => 'bs5name',
			'std2'	  => 'Display Name',
			'class'	  => 'ssfa-basedir',
			'class2'  => 'ssfa-basename'
		);				
		$this->settings['exclusions'] = array(
			'title'   => __('Permanent Exclusions'),
			'desc'    => __(''),
			'std'     => '.avi, My Embarrasing Photograph, .tif, My Rough Draft Essay',
			'type'    => 'text',
			'section' => 'config',
			'class'   => 'ssfa-permexclusions',
			'helplink'=> 'yes'
		);
		$this->settings['direxclusions'] = array(
			'title'   => __('Exclude Directories'),
			'desc'    => __(''),
			'std'     => 'My Private Files, Weird_Server_Directory_Name, etc.',
			'type'    => 'text',
			'section' => 'config',
			'class'   => 'ssfa-permexclusions',
			'helplink'=> 'yes'
		);
		$this->settings['newwindow'] = array(
			'title'   => __('New Window'),
			'desc'    => __(''),
			'std'     => 'Example: .pdf, .jpg, .png, .gif, .mp3, .mp4',
			'type'    => 'text',
			'section' => 'config',
			'class'   => 'ssfa-newwindow',
			'helplink'=> 'yes',
			'submit' => 'yes'
		);		
		/* Feature Options
		===========================================*/
		$this->settings['modalaccess'] = array(
			'section' => 'options',
			'title'   => __('Modal Access'),
			'desc'    => __(''),
			'type'    => 'modalaccess',
			'std'     => '',
			'dflt'	  => 'edit_posts',
			'helplink'=> 'yes'		
		);
		$this->settings['tmcerows'] = array(
			'section' => 'options',
			'title'   => __('Button Position'),
			'desc'    => __(''),
			'type'    => 'select',
			'std'     => '',
			'dflt'    => '',
			'choices' => array(
				'' => ' First Row',
				'_2' => 'Second Row',
				'_3' => 'Third Row',
				'_4' => 'Fourth Row',								
			),
			'helplink'=> 'yes'
		);		
		$this->settings['stylesheet'] = array(
			'section' => 'options',
			'title'   => __('Stylesheet Placement'),
			'desc'    => __(''),
			'type'    => 'radio',
			'std'     => '',
			'dflt'    => 'footer',
			'choices' => array(
				'footer' => 'Footer when necessary',
				'header' => 'Header all the time'
			),
			'helplink'=> 'yes'
		);
		$this->settings['javascript'] = array(
			'section' => 'options',
			'title'   => __('Javascript Placement'),
			'desc'    => __(''),
			'type'    => 'radio',
			'std'     => '',
			'dflt'    => 'footer',
			'choices' => array(
				'footer' => 'Footer when necessary',
				'header' => 'Header all the time',
			),
			'helplink'=> 'yes'
		);	
		$this->settings['daymonth'] = array(
			'section' => 'options',
			'title'   => __('Date Display Format'),
			'desc'    => __(''),
			'type'    => 'select',
			'std'     => '',
			'dflt'	  => 'md',
			'choices' => array(
				'md' => 'MM/DD/YYYY',
				'dm' => 'DD/MM/YYYY',
			),
			'helplink'=> 'yes'
		);
		$this->settings['postidcolumn'] = array(
			'section' => 'options',
			'title'   => __('Post ID Column'),
			'desc'    => __(''),
			'type'    => 'radio',
			'std'     => '',
			'dflt'    => 'enabled',
			'choices' => array(
				'enabled' => 'Enabled',
				'disabled' => 'Disabled',
			),
			'helplink'=> 'yes',								
		);
		$this->settings['adminstyle'] = array(
			'section' => 'options',
			'title'   => __('Admin Style'),
			'desc'    => __(''),
			'type'    => 'select',
			'std'     => '',
			'dflt'    => '',
			'choices' => array(
				'classic' => 'Classic',
				'minimal' => 'Minimal',
			),
			'helplink'=> 'yes',
			'submit' => 'yes'			
		);		
		/* Custom Styles
		===========================================*/
		$this->settings['custom_list_classes'] = array(
			'title'   => __('Custom List Classes'),
			'desc'    => __(''),
			'std'     => 'classname1|Display Name 1, classname2|Display Name 2',
			'type'    => 'text',
			'section' => 'customcss',
			'class'	  => 'ssfa-custom',
			'helplink'=> 'yes'
		);
		$this->settings['custom_table_classes'] = array(
			'title'   => __('Custom Table Classes'),
			'desc'    => __(''),
			'std'     => 'classname1|Display Name 1, classname2|Display Name 2',
			'type'    => 'text',
			'section' => 'customcss',
			'class'	  => 'ssfa-custom',
			'helplink'=> 'yes'
		);
		$this->settings['custom_color_classes'] = array(
			'title'   => __('Custom Color Classes'),
			'desc'    => __(''),
			'std'     => 'classname1|Display Name 1, classname2|Display Name 2',
			'type'    => 'text',
			'section' => 'customcss',
			'class'	  => 'ssfa-custom',
			'helplink'=> 'yes'
		);
		$this->settings['custom_accent_classes'] = array(
			'title'   => __('Custom Accent Classes'),
			'desc'    => __(''),
			'std'     => 'classname1|Display Name 1, classname2|Display Name 2',
			'type'    => 'text',
			'section' => 'customcss',
			'class'	  => 'ssfa-custom',
			'helplink'=> 'yes'
		);
		$this->settings['custom_stylesheet'] = array(
			'title'   => __('Custom Stylesheet'),
			'desc'    => __(''),
			'std'     => 'my-custom-stylesheet.css',
			'type'    => 'text',
			'section' => 'customcss',
			'class'	  => 'ssfa-custom-stylesheet',
			'helplink'=> 'yes'
		);
		$this->settings['customcss'] = array(
			'title'   => __('Custom Styles'),
			'desc'    => __(''),
			'std'     => '',
			'type'    => 'customcss',
			'section' => 'customcss',
			'class'   => 'code'
		);
		$this->settings['css_editor'] = array(
			'section' => 'customcss',
			'title'   => __('Switch Editors'),
			'desc'    => __(''),
			'type'    => 'select',
			'std'     => '',
			'dflt'    => 'syntax',
			'choices' => array(
				'syntax' => 'Syntax Highlighted',
				'plain' => 'Resizable (Plain Text)'
			),
			'submit' => 'yes'
		);
		/* Manager Mode
		===========================================*/
		$this->settings['manager_role_access'] = array(
			'section' => 'manager',
			'title'   => __('Access by Role'),
			'desc'    => __(''),
			'type'    => 'manager_role_access',
			'helplink'=> 'yes',
			'input'	  => 'hidden',
			'class'   => '',
		);
		$this->settings['manager_user_access'] = array(
			'section' => 'manager',
			'title'   => __('Access by User'),
			'desc'    => __(''),
			'type'    => 'manager_user_access',
			'helplink'=> 'yes',
			'input'	  => 'hidden',
			'class'   => '',
		);
	$this->settings['managerpassword'] = array(
			'title'   => __('Override Password'),
			'desc'    => __(''),
			'type'    => 'text',
			'section' => 'manager',
			'class'   => 'ssfa-overridepassword',
			'helplink'=> 'yes',
			'submit' => 'yes'
		);				
		/* Reset Options
		===========================================*/
		$this->settings['reset_options'] = array(
			'section' => 'reset',
			'title'   => __('Reset to Defaults'),
			'type'    => 'checkbox',
			'std'     => 0,
			'dflt'	  => 0,
			'class'   => 'warning', // Custom class for CSS
			'desc'    => __('Check this box and click "Save Changes" below to reset plugin options to their defaults. Note: any custom styles saved in the CSS editor will be lost.')
		);
		$this->settings['preserve_options'] = array(
			'section' => 'reset',
			'title'   => __('Preserve on Uninstall'),
			'desc'    => __(''),
			'type'    => 'radio',
			'std'     => '',
			'dflt'    => 'preserve',
			'choices' => array(
				'preserve' => 'Preserve Settings on Uninstall',
				'delete'   => 'Delete Settings on Uninstall',
			),
			'helplink'=> 'yes',
			'submit' => 'yes'						
		);
	}
	public function initialize_settings(){
		$default_settings = array();
		foreach ($this->settings as $id => $setting){
			if ($setting['type'] != 'heading')
				$default_settings[$id] = $setting['dflt'];
		}
		update_option('fileaway_options', $default_settings);
	}
	public function register_settings(){
		register_setting('fileaway_options', 'fileaway_options', array (&$this, 'validate_settings'));
		if(SSFA_ADMINSTYLE === 'minimal') unset($this->sections['about']);
		foreach ($this->sections as $slug => $title){
			if ($slug == 'config')
				add_settings_section($slug, $title, array(&$this, 'display_config_section'), 'file-away');
			elseif ($slug == 'options')
				add_settings_section($slug, $title, array(&$this, 'display_options_section'), 'file-away');
			elseif ($slug == 'customcss')
				add_settings_section($slug, $title, array(&$this, 'display_customcss_section'), 'file-away');
			elseif ($slug == 'manager')
				add_settings_section($slug, $title, array(&$this, 'display_manager_section'), 'file-away');
			elseif ($slug == 'tutorials')
				add_settings_section($slug, $title, array(&$this, 'display_tutorials_section'), 'file-away');
			elseif ($slug == 'reset')
				add_settings_section($slug, $title, array(&$this, 'display_reset_section'), 'file-away');
			elseif ($slug == 'about')
				add_settings_section($slug, $title, array(&$this, 'display_about_section'), 'file-away');				
			else
				add_settings_section($slug, $title, array(&$this, 'display_section'), 'file-away');
		}
		$this->get_settings();
		foreach ($this->settings as $id => $setting){
			$setting['id'] = $id;
			$this->create_setting($setting);
		}
	}
	public function scripts(){
		wp_print_scripts('jquery-ui-tabs');
		wp_print_scripts('jquery-effects-core');		
		wp_print_scripts('jquery-form');
		wp_register_script ('ssfa-chozed', SSFA_ADMIN_JS_URL.'chosen.jquery.js', array ('jquery'), '1.0', false);		
		wp_print_scripts('ssfa-chozed');
		wp_register_script ('ZeroClipboard', SSFA_ADMIN_JS_URL.'ZeroClipboard.js', array ('jquery'), '1.0', false);		
		wp_print_scripts('ZeroClipboard');		
		wp_register_script ('admin-footable', SSFA_JS_URL.'footable.js', array ('jquery'), '1.0', false);
		wp_print_scripts ('admin-footable');
		wp_register_script ('ssfa-options', SSFA_ADMIN_JS_URL.'ssfa-options.js', array ('jquery'), '1.0', false);		
		wp_print_scripts('ssfa-options');
	}
	public function styles(){
		$optionscss = SSFA_ADMINSTYLE === 'minimal' ? SSFA_ADMIN_CSS_URL.'ssfa-options-minimal.css' : SSFA_ADMIN_CSS_URL.'ssfa-options.css';
		wp_register_style('ssfa-chozed', SSFA_ADMIN_JS_URL.'chosen.css');
		wp_enqueue_style('ssfa-chozed');
		wp_register_style('ssfa-options', $optionscss);
		wp_enqueue_style('ssfa-options');
	}
	public function validate_settings($input){
		if (! isset($input['reset_options'])){
			$options = get_option('fileaway_options');
			foreach ($this->checkboxes as $id){
				if (isset($options[$id]) and ! isset($input[$id]))
					unset($options[$id]);
			}
			return $input;
		}
		return false;
	}
}
$fileaway_options = new File_Away_Options();
function fileaway_option($option){
	$options = get_option('fileaway_options');
	if (isset($options[$option]))
		return $options[$option];
	else
		return false;
}
function update_fileaway_option($option, $value){
	$options = get_option('fileaway_options');
	if(!isset($options[$option]) || $options[$option] != $value): 
		$options[$option] = $value;
		update_option('fileaway_options', $options);
	endif;
}