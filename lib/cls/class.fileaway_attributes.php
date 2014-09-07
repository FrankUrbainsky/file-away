<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_attributes'))
{
	class fileaway_attributes
	{
		public $op;
		public $classes;
		public $shortcodes;
		public $fileaway;
		public $attachaway;
		public $fileup;
		public $fileaframe;
		public function __construct()
		{
			$this->op = get_option('fileaway_options');
			$this->classes = array(
				'lists'=>array(),
				'tables'=>array(),
				'colors'=>array(),
				'accents'=>array()
			);
			$this->classes();
			$this->shortcodes = array(
				'fileaway'=>array(),
				'attachaway'=>array(),
				'fileup'=>array(),
				'fileaframe'=>array()
			);
			$this->handle();
			$this->fileaway = $this->atts('fileaway');
			$this->attachaway = $this->atts('attachaway');
			$this->fileup = $this->atts('fileup');
			$this->fileaframe = $this->atts('fileaframe');
		}
		public function base($fileup = false)
		{
			$options = array(); $op = $this->op;
			if($op['base1'] && $op['bs1name']) $options[''] = $op['bs1name'];
			if($op['base2'] && $op['bs2name']) $options['2'] = $op['bs2name'];
			if($op['base3'] && $op['bs3name']) $options['3'] = $op['bs3name'];
			if($op['base4'] && $op['bs4name']) $options['4'] = $op['bs4name'];
			if($op['base5'] && $op['bs5name']) $options['5'] = $op['bs5name'];
			if(!$fileup && fileaway_definitions::$s2member) $options['s2member-files'] = 's2member-files';
			return $options;
		}
		public function classes()
		{
			$lists = $this->op['custom_list_classes']; $tables = $this->op['custom_table_classes'];
			$colors = $this->op['custom_color_classes']; $accents = $this->op['custom_accent_classes'];
			$lists = !$lists || $lists == '' ? false : preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', $lists));
			$tables = !$tables || $tables == '' ? false : preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', $tables));
			$colors = !$colors || $colors == '' ? false : preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', $colors));
			$accents = !$accents || $accents == '' ? false : preg_split("/(,\s|,)/", preg_replace('/\s+/', ' ', $accents));
			$this->classes['lists'] = $this->classcleaner($lists);
			$this->classes['tables'] = $this->classcleaner($tables);
			$this->classes['colors'] = $this->classcleaner($colors);
			$this->classes['accents'] = $this->classcleaner($accents);
		}
		public function classcleaner($classes)
		{
			if(!$classes) return false;
			$newclasses = array();
			foreach($classes as $c)
			{
				list($class, $label) = preg_split ("/(\|)/", $c);
				$class = trim($class, ' '); $label = trim($label, ' ');
				if($class != '') $newclasses[$class] = $label;
			}
			return $newclasses;
		}
		public function colors($type)
		{
			$primary = array(
				'black' => 'Black',
				'silver' => 'Silver',
				'red' => 'Red',
				'blue' => 'Blue',
				'green' => 'Green',
				'brown' => 'Brown',
				'orange' => 'Orange',
				'purple' => 'Purple',
				'pink' => 'Pink',
			);
			if($type === 'matched')
			{
				$accents = $this->classes['accents'] ? array_merge($primary, $this->classes['accents']) : $primary;	
				$output = array_merge(array('' => 'Matched'), $accents);
				return $output;
			}
			else
			{
				$colors = $this->classes['colors'] ? array_merge($primary, $this->classes['colors']) : $primary;
			}
			if($type === 'classic')
			{
				$output = array_merge(array('' => 'Classic', 'random' => 'Random'), $colors);
			}
			else $output = array_merge(array('' => 'Random'), $colors);
			return $output;
		}
		public function styles($type)
		{
			if($type === 'lists')
			{
				$primary = array('' => 'Minimal-List', 'silk' => 'Silk');
				$styles = $this->classes['lists'] ? array_merge($primary, $this->classes['lists']) : $primary;
			}
			else
			{
				$primary = array('' => 'Minimalist', 'silver-bullet' => 'Silver Bulllet');
				$styles = $this->classes['tables'] ? array_merge($primary, $this->classes['tables']) : $primary;
			}
			return $styles;
		}
		public function filegroups()
		{
			$filegroups = array();
			$defs = new fileaway_definitions;
			foreach($defs->filegroups as $value => $array)
			{
				$filegroups[$value] = $array[0];
			}
			unset($filegroups['unknown']);
			return $filegroups;
		}
		public function handle($handler = false)
		{			
			$base = $this->base(); 
			$upbase = $this->base(true);
			$liststyles = $this->styles('lists');
			$tablestyles = $this->styles('tables');
			$random = $this->colors('random');
			$matched = $this->colors('matched');
			$classic = $this->colors('classic');
			$filegroups = $this->filegroups();
			$roles = fileaway_utility::caps();
			$all = $handler && in_array($handler, $this->shortcodes) ? false : true;
			if($all || $handler == 'fileaway')
			{
				$this->shortcodes['fileaway'] = array(
					// Config
					'type' => array(
						'default' => 'list',
						'options' => array(
							'' => 'Alphabetical List',
							'table' => 'Sortable Data Table'
						),
					),
					'base' => array(
						'list' => array(
							'default' => '1',
							'options' => $base,
						),
						'table'	=> array(
							'default' => '1',
							'options' => $base,
						),
					),
					'sub' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),					
					),
					'makedir' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
						),
					),
					'name' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'paginate' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled',
							),
							'binary' => 'true',
						),
					),
					'pagesize' => array(
						'table' => array(
							'default' => '15',
							'options' => false,
						),
					),
					'search' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Enabled',
								'no' => 'Disabled',
							),
						),
					),
					'customdata' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'sortfirst' => array(
						'table' => array(
							'default' => 'filename',
							'options' => array(
								'' => 'Filename ASC',
								'filename-desc' => 'Filename DSC', 
								'type' => 'Filetype ASC', 
								'type-desc' => 'Filetype DSC', 
								'custom' => 'Custom Column ASC', 
								'custom-desc' => 'Custom Column DSC', 
								'mod' => 'Date Modified ASC', 
								'mod-desc' => 'Date Modified DSC', 
								'size' => 'Filesize ASC', 
								'size-desc' => 'Filesize DSC',
							),
						),
					),
					'mod' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Hide',
								'yes' => 'Show'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Show',
								'no' => 'Hide'
							),
						),
					),
					'size' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Show',
								'no' => 'Hide'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Show',
								'no' => 'Hide'
							),
						),
					),
					'nolinks' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'False',
								'yes' => 'True'
							),
							'binary' => 'yes',
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'False',
								'yes' => 'True'
							),
							'binary' => 'yes',
						),
					),
					'unicode' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
							'binary' => 'true'
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
							'binary' => 'true'
						),
					),
					'debug' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
						),
					),
					's2skipconfirm' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Confirmations On',
								'true' => 'Confirmations Off'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Confirmations On',
								'true' => 'Confirmations Off'
							),
						),
					),
					// Modes
					'bulkdownload' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
					),
					'playback' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'compact' => 'Compact',
								'extended' => 'Extended',
							),
							'binary' => 'compact',
						),
					),
					'encryption' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
					),
					'recursive' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
					),
					'directories' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
					),
					'manager' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
							'binary' => 'on',
						),
					),
					'playbackpath' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'playbacklabel' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'onlyaudio' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
							'binary' => 'true',
						),
					),
					'loopaudio' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled'
							),
							'binary' => 'true',
						),
					),
					'excludedirs' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'onlydirs' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'drawericon' => array(
						'table' => array(
							'default' => 'drawer',
							'options' => array(
								'' => 'Drawer',
								'drawer-2' => 'Drawer Alt',
								'book' => 'Book',
								'cabinet' => 'Cabinet',
								'console' => 'Console',
							),
						),
					),
					'drawerlabel' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'password' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'user_override' => array(
						'table' => array(
							'default' => false,
							'options' => false,
						),
					),
					'role_override' => array(
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),
					),
					'dirman_access' => array(
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),
					),
					// Filters
					'exclude' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'include' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'only' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'images' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Include',
								'only' => 'Only',
								'none' => 'Exclude',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Include',
								'only' => 'Only',
								'none' => 'Exclude',
							),
						),
					),
					'code' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Exclude',
								'yes' => 'Include',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Exclude',
								'yes' => 'Include',
							),
						),
					),					
					'showto' => array(
						'list' => array(
							'default' => 'skip',
							'options' => $roles,
						),
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),							
					),
					'hidefrom' => array(
						'list' => array(
							'default' => 'skip',
							'options' => $roles,
						),
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),							
					),
					// Styles
					'style' => array(
						'list' => array(
							'default' => 'minimal-list',
							'options' => $liststyles,
						),
						'table' => array(
							'default' => 'minimalist',
							'options' => $tablestyles,
						),
					),
					'heading' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),					
					'width' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => '100',
							'options' => false,
						),
					),
					'perpx' => array(
						'list' => array(
							'default' => '%',
							'options' => array(
								'' => 'Percent',
								'px' => 'Pixels',
							),
						),
						'table' => array(
							'default' => '%',
							'options' => array(
								'' => 'Percent',
								'px' => 'Pixels',
							),
						),
					),
					'align' => array(
						'list' => array(
							'default' => 'left',
							'options' => array(
								'' => 'Left',
								'right' => 'Right',
								'none' => 'None',
							),
						),
						'table' => array(
							'default' => 'left',
							'options' => array(
								'' => 'Left',
								'right' => 'Right',
								'none' => 'None',
							),
						),
					),
					'textalign' => array(
						'table' => array(
							'default' => 'center',
							'options' => array(
								'' => 'Center',
								'left' => 'Left',
								'right' => 'Right',
							),
						),
					),
					'hcolor' => array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $random,
						),
					),
					'color' => array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $classic,
						),					
					),
					'accent' => array(
						'list' => array(
							'default' => false,
							'options' => $matched,
						),
					),
					'iconcolor' => array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $classic,
						),
					),
					'icons' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Filetype',
								'paperclip' => 'Paperclip',
								'none' => 'None',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Filetype',
								'paperclip' => 'Paperclip',
							),
						),
					),
					'corners' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Rounded',
								'sharp' => 'Sharp',
								'roundtop' => 'Rounded Top',
								'roundbottom' => 'Rounded Bottom',
								'roundleft' => 'Rounded Left',
								'roundright' => 'Rounded Right',
								'elliptical' => 'Elliptical'
							),
						),
					),
					'display' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Vertical',
								'inline' => 'Side-by-Side',
								'2col' => 'Two Columns',
							),
						),
					),
					'thumbnails' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'transient' => 'Transient',
								'permanent' => 'Permanent',
							),
							'binary' => 'transient',
						),
					),
					'thumbstyle' => array(
						'table' => array(
							'default' => 'widerounded',
							'options' => array(
								'' => 'Wide-Rounded',
								'widesharp' => 'Wide-Sharp',
								'squarerounded' => 'Square-Rounded',
								'squaresharp' => 'Square-Sharp',
								'oval' => 'Oval',
								'circle' => 'Circle'
							),
						),
					),
					'graythumbs' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'None',
								'true' => 'Grayscale',
							),
						),
					),
					'maxsrcbytes' => array(
						'table' => array(
							'default' => '1887436.8',
							'options' => false,
						),
					),
					'maxsrcheight' => array(
						'table' => array(
							'default' => 2500,
							'options' => false,
						),
					),
					'maxsrcwidth' => array(
						'table' => array(
							'default' => 3000,
							'options' => false,
						),
					),
				);
			}
			if($all || $handler == 'attachaway')
			{
				$this->shortcodes['attachaway'] = array(
					// Config
					'type' => array(
						'default' => 'list',
						'options' => array(
							'' => 'Alphabetical List',
							'table' => 'Sortable Data Table'
						),
					),
					'postid' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),					
					'capcolumn'	=> array(
						'table' => array(
							'default' => false,
							'options' => false,
						),										
					),
					'descolumn'	=> array(
						'table' => array(
							'default' => false,
							'options' => false,
						),					
					),
					'search' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Enabled',
								'no' => 'Disabled',
							),
						),
					),
					'paginate' => array(
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'true' => 'Enabled',
							),
						),
					),
					'pagesize' => array(
						'table' => array(
							'default' => 15,
							'options' => false,
						),
					),
					'size' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Show',
								'no' => 'Hide'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Show',
								'no' => 'Hide'
							),
						),
					),
					'sortfirst' => array(
						'table' => array(
							'default' => 'filename',
							'options' => array(
								'' => 'Filename ASC',
								'filename-desc' => 'Filename DSC', 
								'type' => 'Filetype ASC', 
								'type-desc' => 'Filetype DSC', 
								'caption' => 'Caption Column ASC', 
								'caption-desc' => 'Caption Column DSC', 
								'description' => 'Description Column ASC',
								'description-desc' => 'Description Column DSC',
								'mod' => 'Date Modified ASC', 
								'mod-desc' => 'Date Modified DSC', 
								'size' => 'Filesize ASC', 
								'size-desc' => 'Filesize DSC',
							),
						),
					),					
					'orderby' => array(
						'list' => array(
							'default' => 'title',
							'options' => array(
								'' => 'Title',
								'menu_order' => 'Menu Order',
								'ID' => 'ID',
								'date' => 'Date',
								'modified' => 'Modified',
								'rand' => 'Random',
							),
						),					
					),
					'desc' => array(
						'list' => array(
							'default' => 'asc',
							'options' => array(
								'' => 'Asc',
								'true' => 'Desc',
							),
						),									
					),
					'debug' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Disabled',
								'on' => 'Enabled'
							),
						),
					),
					// Filters
					'exclude' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'include' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'only' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),
					'images' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Include',
								'only' => 'Only',
								'none' => 'Exclude',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Include',
								'only' => 'Only',
								'none' => 'Exclude',
							),
						),
					),
					'code' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Exclude',
								'yes' => 'Include',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Exclude',
								'yes' => 'Include',
							),
						),
					),					
					'showto' => array(
						'list' => array(
							'default' => 'skip',
							'options' => $roles,
						),
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),							
					),
					'hidefrom' => array(
						'list' => array(
							'default' => 'skip',
							'options' => $roles,
						),
						'table' => array(
							'default' => 'skip',
							'options' => $roles,
						),							
					),
					// Styles
					'style' => array(
						'list' => array(
							'default' => 'minimal-list',
							'options' => $liststyles,
						),
						'table' => array(
							'default' => 'minimalist',
							'options' => $tablestyles,
						),
					),
					'heading' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => false,
							'options' => false,
						),							
					),					
					'width' => array(
						'list' => array(
							'default' => false,
							'options' => false,
						),
						'table' => array(
							'default' => '100',
							'options' => false,
						),
					),
					'perpx' => array(
						'list' => array(
							'default' => '%',
							'options' => array(
								'' => 'Percent',
								'px' => 'Pixels',
							),
						),
						'table' => array(
							'default' => '%',
							'options' => array(
								'' => 'Percent',
								'px' => 'Pixels',
							),
						),
					),
					'align' => array(
						'list' => array(
							'default' => 'left',
							'options' => array(
								'' => 'Left',
								'right' => 'Right',
								'none' => 'None',
							),
						),
						'table' => array(
							'default' => 'left',
							'options' => array(
								'' => 'Left',
								'right' => 'Right',
								'none' => 'None',
							),
						),
					),
					'textalign' => array(
						'table' => array(
							'default' => 'center',
							'options' => array(
								'' => 'Center',
								'left' => 'Left',
								'right' => 'Right',
							),
						),
					),
					'hcolor'	=> array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $random,
						),					
					),
					'color' => array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $classic,
						),					
					),
					'accent' => array(
						'list' => array(
							'default' => false,
							'options' => $matched,
						),
					),
					'iconcolor' => array(
						'list' => array(
							'default' => false,
							'options' => $random,
						),
						'table' => array(
							'default' => false,
							'options' => $classic,
						),
					),
					'icons' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Filetype',
								'paperclip' => 'Paperclip',
								'none' => 'None',
							),
						),
						'table' => array(
							'default' => false,
							'options' => array(
								'' => 'Filetype',
								'paperclip' => 'Paperclip',
							),
						),
					),
					'corners' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Rounded',
								'sharp' => 'Sharp',
								'roundtop' => 'Rounded Top',
								'roundbottom' => 'Rounded Bottom',
								'roundleft' => 'Rounded Left',
								'roundright' => 'Rounded Right',
								'elliptical' => 'Elliptical'
							),
						),
					),
					'display' => array(
						'list' => array(
							'default' => false,
							'options' => array(
								'' => 'Vertical',
								'inline' => 'Side-by-Side',
								'2col' => 'Two Columns',
							),
						),
					),
				);
			}
			if($all || $handler == 'fileup')
			{
				$this->shortcodes['fileup'] = array(			
					// Config
					'base' => array(
						'default' => 1,
						'options' => $upbase,
					),
					'sub' => array(
						'default' => false,
						'options' => false,					
					),
					'makedir'	=> array(
						'default' => false,
						'options' => array(
							'' => 'Disabled',
							'true' => 'Enabled',
						),
					),					
					'name' => array(
						'default' => false,
						'options' => false,
					),
					'single' => array(
						'default' => false,
						'options' => array(
							'' => 'Multiple',
							'true' => 'Single',
						),					
					),
					'maxsize' => array(
						'default' => '10',
						'options' => false,					
					),
					'maxsizetype' => array(
						'default' => 'm',
						'options' => array(
							'' => 'MB',
							'k' => 'KB',
							'g' => 'GB',							
						),					
					),
					'uploadlabel' => array(
						'default' => false,
						'options' => false,
					),
					'fixedlocation'	=> array(
						'default' => false,
						'options' => array(
							'' => 'Allow Sub Selection',
							'true' => 'Fixed Location',
						),
					),
					'uploader'	=> array(
						'default' => false,
						'options' => array(
							'' => 'Disabled',
							'true' => 'Enabled',
						),
					),
					// Filters
					'action' => array(
						'default' => 'permit',
						'options' => array(
							'' => 'Permit',
							'prohibit' => 'Prohibit',
						),
					),
					'filetypes' => array(
						'default' => false,
						'options' => false,					
					),
					'filegroups' => array(
						'default' => 'skip',
						'options' => $filegroups,
					),
					'showto' => array(
						'default' => 'skip',
						'options' => $roles,
					),
					'hidefrom' => array(
						'default' => 'skip',
						'options' => $roles,
					),
					// Style
					'style' => array(
						'default' => 'minimalist',
						'options' => $tablestyles,
					),
					'width' => array(
						'default' => '100',
						'options' => false,
					),
					'perpx' => array(
						'default' => '%',
						'options' => array(
							'' => 'Percent',
							'px' => 'Pixels',
						),
					),
					'align' => array(
						'default' => 'none',
						'options' => array(
							'' => 'None',
							'left' => 'Left',
							'right' => 'Right',
						),
					),
					'iconcolor' => array(
						'default' => false,
						'options' => $classic,
					),
				);
			}
			if($all || $handler == 'fileaframe')
			{
				$this->shortcodes['fileaframe'] = array(			
					// Config
					'source' => array(
						'default' => false,
						'options' => false,					
					),
					'name' => array(
						'default' => false,
						'options' => false,
					),
					// Style
					'scroll' => array(
						'default' => 'no',
						'options' => array(
							'' => 'Off',
							'yes' => 'On',
							'auto' => 'Auto',
						),					
					),
					'width' => array(
						'default' => '100%',
						'options' => false,
					),
					'height' => array(
						'default' => '1000px',
						'options' => false,					
					),
					'mwidth' => array(
						'default' => '0px',
						'options' => false,
					),
					'mheight' => array(
						'default' => '0px',
						'options' => false,
					),
				);
			}
		}
		protected function atts($handle)
		{
			$atts = array(); if(!$handle) $handle = 'fileaway';
			foreach($this->shortcodes[$handle] as $att => $discard) $atts[$att] = '';
			return $atts;
		}
		protected function correct($atts, $ctrl)
		{
			foreach($atts as $a => $v)
			{
				$ops = isset($ctrl[$a]['options']) ? $ctrl[$a]['options'] : false;
				$dflt = isset($ctrl[$a]['default']) ? $ctrl[$a]['default'] : false;
				if(!$ops && !$dflt) continue;
				if(!$v && !$dflt) continue;
				if($dflt == 'skip') continue;
				if($v && $ops && !array_key_exists($v, $ops)) $atts[$a] = $dflt;
				elseif(!$v && $dflt) $atts[$a] = $dflt; 
			}
			return $atts;
		}		
		protected function correctatts($atts, $control, $shortcode)
		{
			extract($atts);	
			if($shortcode == 'fileaway') 
				$type = $type == 'table' || $directories || $manager || $playback || $bulkdownload || $thumbnails ? 'table' : 'list';
			else $type = $type == 'table' ? 'table' : 'list';
			foreach($atts as $a => $v)
			{
				if($a == 'type')
				{
					$atts[$a] = $type;
					continue;	
				}
				$ctrl = isset($control[$a][$type]) ? $control[$a][$type] : false;
				if(!$ctrl)
				{
					$atts[$a] = false; 
					continue;
				}
				$ops = isset($ctrl['options']) ? $ctrl['options'] : false;
				$dflt = isset($ctrl['default']) ? $ctrl['default'] : false;
				$binary = isset($ctrl['binary']) ? $ctrl['binary'] : false;
				if(!$ops && !$dflt) continue;
				if(!$v && !$dflt) continue;
				if($dflt == 'skip') continue;
				if($v && $ops && $binary) $atts[$a] = !array_key_exists($v, $ops) ? $binary : $v;
				elseif($v && $ops && !array_key_exists($v, $ops)) $atts[$a] = $dflt;
				elseif(!$v && $dflt) $atts[$a] = $dflt; 
			}
			return $atts;
		}
	}
}