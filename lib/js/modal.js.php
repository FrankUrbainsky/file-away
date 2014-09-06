<?php
/*
** Include JS for TinyMCE
*/
?>
<script>
jQuery(document).ready(function($)
{
	// CHOSEN
	$('select.chozed-select').chozed({
		allow_single_deselect:true, 
		width: '100%',
		disable_search_threshold: 5, 
		inherit_select_classes:true,
		no_results_text: "Say what?",
		search_contains: true, 
	}); 
	$('div.fileaway-wrap').on('hide', function()
	{
		$(this).find('input').val('');    
		$('select.select', this).find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		$('select.select option:selected', this).removeAttr("selected").trigger('chozed:updated').trigger('change');
	});
	$('select#fileaway_shortcode_select').on('change', function()
	{
		$type = $('select#fileaway_type_select');
		$num = $('option:selected', this).data('types');
		if($num < 2 || $(this).val() == '')
		{ 
			$('div#fileaway_type_select').fadeOut(500);
			$type.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else $('div#fileaway_type_select').fadeIn(500);
		$sc = $(this).val();
		$st = $type.val();
		$combined = $st != '' ? $sc+'_'+$st : $sc;
		$banner = $sc == '' ? $('img#fileaway_banner_fileaway') : $('img#fileaway_banner_'+$sc)
		$('div.fileaway-wrap').each(function()
		{
			$container = $(this).data('container');
			if($container != $combined) $(this).fadeOut(500).trigger('hide');
			else $(this).delay(500).fadeIn(500);
		});
		if($banner.is(':visible')){}
		else 
		{
			$('img[id^="fileaway_banner_"]').fadeOut(500);
			$banner.delay(500).fadeIn(500);
		}
	});
	$('select#fileaway_type_select').on('change', function()
	{
		$type = $(this);
		$st = $(this).val();
		$sc = $('select#fileaway_shortcode_select').val();
		$combined = $st != '' ? $sc+'_'+$st : $sc;
		$('div.fileaway-wrap').each(function()
		{
			$container = $(this).data('container');
			if($container != $combined) $(this).fadeOut(500).trigger('hide');
			else $(this).delay(500).fadeIn(500);
		});
	});
	// TABS
	$('a[id^="fileaway-tab-"]').on('click', function(ev)
	{
		ev.preventDefault();
		var parent = $(this).parents('div.fileaway-wrap').eq("0").data('container');
		var slug = $(this).attr('data-tab');
		var panel = $('div#options-container-'+parent+' div#fileaway-panel-'+slug);
		if(panel.is(':visible')){}
		else
		{
			$('div#options-container-'+parent+' li.'+slug).addClass('state-active')
				.siblings('div#options-container-'+parent+' li').removeClass('state-active');
			$('div#options-container-'+parent+' div[id^="fileaway-panel-"]').fadeOut(500);
			panel.delay(500).fadeIn(500);
		}		
	});
	// CONDITIONALS
	// Parents
	$list_base = $('select#fileaway_list_base');
	$table_base = $('select#fileaway_table_base');	
	$list_recursive = $('select#fileaway_list_recursive');
	$table_recursive = $('select#fileaway_table_recursive');
	$directories = $('select#fileaway_table_directories');
	$manager = $('select#fileaway_table_manager');
	$playback = $('select#fileaway_table_playback');
	$thumbnails = $('select#fileaway_table_thumbnails');
	// Children
	$list_s2skipconfirm_container = $('div[id^="fileaway-container-fileaway_list_config_s2skipconfirm_"]');
	$list_s2skipconfirm = $('select#fileaway_list_s2skipconfirm');
	$table_s2skipconfirm_container = $('div[id^="fileaway-container-fileaway_table_config_s2skipconfirm_"]');	
	$table_s2skipconfirm = $('select#fileaway_table_s2skipconfirm');
	$list_excludedirs_container = $('div[id^="fileaway-container-fileaway_list_modes_excludedirs_"]');
	$list_excludedirs = $('input#fileaway_list_excludedirs');
	$table_excludedirs_container = $('div[id^="fileaway-container-fileaway_table_modes_excludedirs_"]');
	$table_excludedirs = $('input#fileaway_table_excludedirs');
	$list_onlydirs_container = $('div[id^="fileaway-container-fileaway_list_modes_onlydirs_"]');
	$list_onlydirs = $('input#fileaway_list_onlydirs');
	$table_onlydirs_container = $('div[id^="fileaway-container-fileaway_table_modes_onlydirs_"]');
	$table_onlydirs = $('input#fileaway_table_onlydirs');
	$drawericon_container = $('div[id^="fileaway-container-fileaway_table_modes_drawericon_"]');
	$drawericon = $('select#fileaway_table_drawericon');
	$drawerlabel_container = $('div[id^="fileaway-container-fileaway_table_modes_drawerlabel_"]');
	$drawerlabel = $('input#fileaway_table_drawerlabel');
	$dirman_access_container = $('div[id^="fileaway-container-fileaway_table_modes_dirman_access_"]');
	$dirman_access = $('select#fileaway_table_dirman_access');
	$role_override_container = $('div[id^="fileaway-container-fileaway_table_modes_role_override_"]');
	$role_override = $('select#fileaway_table_role_override');
	$user_override_container = $('div[id^="fileaway-container-fileaway_table_modes_user_override_"]');
	$user_override = $('input#fileaway_table_user_override');	
	$password_container = $('div[id^="fileaway-container-fileaway_table_modes_password_"]');
	$password = $('input#fileaway_table_password');
	$playbackpath_container = $('div[id^="fileaway-container-fileaway_table_modes_playbackpath_"]');
	$playbackpath = $('input#fileaway_table_playbackpath');
	$playbacklabel_container = $('div[id^="fileaway-container-fileaway_table_modes_playbacklabel_"]');
	$playbacklabel = $('input#fileaway_table_playbacklabel');
	$onlyaudio_container = $('div[id^="fileaway-container-fileaway_table_modes_onlyaudio_"]');
	$onlyaudio = $('select#fileaway_table_onlyaudio');
	$loopaudio_container = $('div[id^="fileaway-container-fileaway_table_modes_loopaudio_"]');
	$loopaudio = $('select#fileaway_table_loopaudio');
	$maxsrcbytes_container = $('div[id^="fileaway-container-fileaway_table_styles_maxsrcbytes_"]');
	$maxsrcbytes = $('input#fileaway_table_maxsrcbytes');
	$maxsrcwidth_container = $('div[id^="fileaway-container-fileaway_table_styles_maxsrcwidth_"]');
	$maxsrcwidth = $('input#fileaway_table_maxsrcwidth');
	$maxsrcheight_container = $('div[id^="fileaway-container-fileaway_table_styles_maxsrcheight_"]');
	$maxsrcheight = $('input#fileaway_table_maxsrcheight');		
	$thumbstyle_container = $('div[id^="fileaway-container-fileaway_table_styles_thumbstyle_"]');
	$thumbstyle = $('select#fileaway_table_thumbstyle');
	$graythumbs_container = $('div[id^="fileaway-container-fileaway_table_styles_graythumbs_"]');
	$graythumbs = $('select#fileaway_table_graythumbs');	
	// Functions
	$list_base.on('change', function()
	{
		if($(this).val() == 's2member-files')
		{
			$list_s2skipconfirm_container.fadeIn(500);
			$('input#fileaway_list_sub').val('');
			$list_recursive.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			$list_s2skipconfirm_container.fadeOut(500);
			$list_s2skipconfirm.find('option:first').attr('selected','selected').trigger('chozed:updated');
		}
	});
	$table_base.on('change', function()
	{
		if($(this).val() == 's2member-files')
		{
			$table_s2skipconfirm_container.fadeIn(500);
			$('input#fileaway_table_sub').val('');			
			$directories.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$table_recursive.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$manager.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			$table_s2skipconfirm_container.fadeOut(500);
			$table_s2skipconfirm.find('option:first').attr('selected','selected').trigger('chozed:updated');
		}
	});
	$list_recursive.on('change', function()
	{
		if($(this).val() != '')
		{ 
			$list_excludedirs_container.fadeIn(500);
			$list_onlydirs_container.fadeIn(500);
			if($list_base.val() == 's2member-files') $list_base.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			$list_excludedirs_container.fadeOut(500);
			$list_onlydirs_container.fadeOut(500);
			$list_excludedirs.val('');
			$list_onlydirs.val('');
		}
	});
	$table_recursive.on('change', function()
	{
		if($(this).val() != '')
		{ 
			$table_excludedirs_container.fadeIn(500);
			$table_onlydirs_container.fadeIn(500);
			if($table_base.val() == 's2member-files') $table_base.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$directories.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$manager.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else if($directories.val() != '' || $manager.val() != '')
		{
			/* Do Nothing */
		}
		else
		{
			$table_excludedirs_container.fadeOut(500);
			$table_onlydirs_container.fadeOut(500);
			$table_excludedirs.val('');
			$table_onlydirs.val('');
		}
	});
	$directories.on('change', function()
	{
		if($(this).val() != '')
		{ 
			$table_excludedirs_container.fadeIn(500);
			$table_onlydirs_container.fadeIn(500);
			$drawericon_container.fadeIn(500);
			$drawerlabel_container.fadeIn(500);
			if($table_base.val() == 's2member-files') $table_base.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$table_recursive.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			if($table_recursive.val() != '' && $manager.val() == '')
			{
				$drawericon_container.fadeOut(500);
				$drawerlabel_container.fadeOut(500);
				$drawericon.find('option:first').attr('selected','selected').trigger('chozed:updated');
				$drawerlabel.val('');
			}
			else if($manager.val() != '')
			{
				/* Do Nothing */
			}
			else
			{
				$table_excludedirs_container.fadeOut(500);
				$table_onlydirs_container.fadeOut(500);
				$table_excludedirs.val('');
				$table_onlydirs.val('');
				$drawericon_container.fadeOut(500);
				$drawerlabel_container.fadeOut(500);
				$drawericon.find('option:first').attr('selected','selected').trigger('chozed:updated');
				$drawerlabel.val('');
			}
		}
	});
	$manager.on('change', function()
	{
		if($(this).val() != '')
		{ 
			$table_excludedirs_container.fadeIn(500);
			$table_onlydirs_container.fadeIn(500);
			$drawericon_container.fadeIn(500);
			$drawerlabel_container.fadeIn(500);
			$dirman_access_container.fadeIn(500);
			$role_override_container.fadeIn(500);
			$user_override_container.fadeIn(500);
			$password_container.fadeIn(500);
			$table_recursive.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			$playback.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			if($table_base.val() == 's2member-files') $table_base.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			if($table_recursive.val() != '' && $directories.val() == '')
			{
				$drawericon_container.fadeOut(500);
				$drawerlabel_container.fadeOut(500);
				$drawericon.find('option:first').attr('selected','selected').trigger('chozed:updated');
				$drawerlabel.val('');
				$dirman_access_container.fadeOut(500);
				$role_override_container.fadeOut(500);
				$user_override_container.fadeOut(500);
				$password_container.fadeOut(500);
				$('option:selected', $dirman_access).removeAttr("selected").trigger('chozed:updated');
				$('option:selected', $role_override).removeAttr("selected").trigger('chozed:updated');
				$user_override.val('');
				$password.val('');
			}
			else if($directories.val() != '')
			{
				$dirman_access_container.fadeOut(500);
				$role_override_container.fadeOut(500);
				$user_override_container.fadeOut(500);
				$password_container.fadeOut(500);
				$('option:selected', $dirman_access).removeAttr("selected").trigger('chozed:updated');
				$('option:selected', $role_override).removeAttr("selected").trigger('chozed:updated');
				$user_override.val('');
				$password.val('');
			}
			else
			{
				$table_excludedirs_container.fadeOut(500);
				$table_onlydirs_container.fadeOut(500);
				$table_excludedirs.val('');
				$table_onlydirs.val('');
				$drawericon_container.fadeOut(500);
				$drawerlabel_container.fadeOut(500);
				$drawericon.find('option:first').attr('selected','selected').trigger('chozed:updated');
				$drawerlabel.val('');
				$dirman_access_container.fadeOut(500);
				$role_override_container.fadeOut(500);
				$user_override_container.fadeOut(500);
				$password_container.fadeOut(500);
				$('option:selected', $dirman_access).removeAttr("selected").trigger('chozed:updated');
				$('option:selected', $role_override).removeAttr("selected").trigger('chozed:updated');
				$user_override.val('');
				$password.val('');				
			}
		}
	});
	$playback.on('change', function()
	{
		if($(this).val() != '')
		{
			$playbackpath_container.fadeIn(500);
			$playbacklabel_container.fadeIn(500);
			$onlyaudio_container.fadeIn(500);
			$loopaudio_container.fadeIn(500);
			$manager.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
		}
		else
		{
			$playbackpath_container.fadeOut(500);
			$playbacklabel_container.fadeOut(500);
			$onlyaudio_container.fadeOut(500);
			$loopaudio_container.fadeOut(500);
			$playbackpath.val('');
			$playbacklabel.val('');
			$onlyaudio.find('option:first').attr('selected','selected').trigger('chozed:updated');
			$loopaudio.find('option:first').attr('selected','selected').trigger('chozed:updated');
		}
	});
	$thumbnails.on('change', function()
	{
		if($(this).val() == 'transient')
		{
			$maxsrcbytes_container.fadeIn(500);
			$maxsrcwidth_container.fadeIn(500);
			$maxsrcheight_container.fadeIn(500);
			$thumbstyle_container.fadeIn(500);
			$graythumbs_container.fadeIn(500);
		}
		else if($(this).val() == 'permanent')
		{
			$thumbstyle_container.fadeIn(500);
			$graythumbs_container.fadeIn(500);		
			$maxsrcbytes_container.fadeOut(500);
			$maxsrcwidth_container.fadeOut(500);
			$maxsrcheight_container.fadeOut(500);
			$maxsrcbytes.val('');
			$maxsrcwidth.val('');
			$maxsrcheight.val('');
		}
		else
		{
			$thumbstyle_container.fadeOut(500);
			$graythumbs_container.fadeOut(500);		
			$maxsrcbytes_container.fadeOut(500);
			$maxsrcwidth_container.fadeOut(500);
			$maxsrcheight_container.fadeOut(500);
			$maxsrcbytes.val('');
			$maxsrcwidth.val('');
			$maxsrcheight.val('');
			$thumbstyle.find('option:first').attr('selected','selected').trigger('chozed:updated');
			$graythumbs.find('option:first').attr('selected','selected').trigger('chozed:updated');
		}
	});
	var	con = $('.fileaway-help-content');
	$('div[id^=fileaway-help-]').each(function()
	{
		var sfx = this.id,
			mdl = $(this),
			cls = $('.fileaway-help-close'),			
			lnk = $('.link-' + sfx);
		lnk.click(function()
		{ 
			mdl.fadeIn('fast'); 
		});
		mdl.click(function()
		{ 
			mdl.fadeOut('fast'); 
		});
		cls.click(function()
		{ 
			mdl.fadeOut('fast'); 
		});
	});
	con.click(function()
	{ 
		return false; 
	});
	var innerlink = $('.inner-link'); 
	innerlink.on('click', function(ev)
	{ 
		ev.preventDefault(); 
		var url = $(this).attr('href'); 
		window.open(url, '_blank'); 
	});	
});
</script>