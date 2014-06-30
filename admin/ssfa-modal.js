(function(){
   if(ssfa_mce_config.version === 'new'){
		tinymce.PluginManager.add('ssfamodal', function( editor, url ) {
			editor.addButton( 'ssfamodal', {
				title: ssfa_mce_config.tb_title,
				icon: 'icon ssfa-fileaway-icon',
				onclick: function() {
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 640 < width ) ? 640 : width; W = W; H = H;
					tb_show( 'File Away', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=ssfamodal-form' );
            }
        });
    });
   } else {
		tinymce.create('tinymce.plugins.ssfamodal', {
			createControl : function(id, controlManager) {
				if (id == 'ssfamodal') {
					var button = controlManager.createButton('ssfamodal', {
						title: ssfa_mce_config.tb_title, 
						image: ssfa_mce_config.button_img,
						onclick : function() {
							var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 640 < width ) ? 640 : width; W = W; H = H;
							tb_show( 'File Away', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=ssfamodal-form' );
						}
					});
					return button;
				}
				return null;
			}
		});
		tinymce.PluginManager.add('ssfamodal', tinymce.plugins.ssfamodal);
	}
})();
jQuery(function($){
    var table;
    var datat = {
		action: 'ssfa_tinymce_shortcode',
		security: ssfa_mce_config.ajax_nonce
	};
    $.post( 
        ssfa_mce_config.ajax_url, 
        datat,                   
        function( response ){
			if( 'error' == response  ){
				$('<div id="ssfamodal-form"><h1 style="color:#c00;padding:100px 0;width:100%;text-align:center">Ajax error</h1></div>')
					.appendTo('body').hide();
            }
            else {
				form = $(response);
				table = form.find('table');
				form.appendTo('body').hide();
				form.find('#ssfamodal-submit').click(ssfa_submit_shortcode);
			}
		}
	);
	function ssfa_submit_shortcode() {
		var stype = $('#ssfamodal-shortcode-type').val(),
			ttype = $('#ssfamodal-type').val(),
			type = ( ttype === 'table' ? ' type="table"' : '' );
		var	shortcode = (stype === 'fileaway' ? '[fileaway'+type : (stype === 'attachaway' ? '[attachaway'+type : '[fileaframe' ));
		if ( stype === 'fileaway' && ttype !== 'table' ) {
			var	options = { 'base' : '', 'sub' : '', 'images' : '', 'code' : '', 'only' : '', 'exclude' : '', 'include' : '', 'showto' : '', 'hidefrom' : '', 'heading' : '', 'hcolor' : '', 'width' : '', 'perpx' : '', 'align' : '', 'size' : '', 'mod' : '', 'recursive' : '', 'excludedirs' : '', 'onlydirs' : '', 'style' : '', 'corners' : '', 'color' : '', 'accent' : '', 'icons' : '', 'iconcolor' : '', 'display' : '', 'nolinks' : '', 'debug' : '' }; 
			for( var index in options) {
				var value = table.find('#ssfamodal-fl-' + index).val();
				if ( value !== options[index] && value != null ) 
					shortcode += ' ' + index + '="' + value + '"';
			} 
		} 
		if ( stype === 'fileaway' && ttype === 'table' ) {
			var	options = { 'name' : '', 'base' : '', 'sub' : '', 'directories' : '', 'manager' : '', 'role_override' : '', 'user_override' : '', 'password' : '', 'images' : '', 'code' : '', 'only' : '', 'exclude' : '', 'include' : '', 'showto' : '', 'hidefrom' : '', 'heading' : '', 'hcolor' : '', 'width' : '', 'perpx' : '', 'align' : '', 'size' : '', 'mod' : '', 'recursive' : '', 'style' : '', 'search' : '', 'paginate' : '', 'pagesize' : '', 'textalign' : '', 'customdata' : '', 'icons' : '', 'color' : '', 'iconcolor' : '', 'sortfirst' : '', 'nolinks' : '', 'debug' : '', 'drawericon' : '', 'drawerlabel' : '', 'excludedirs' : '', 'onlydirs' : '', 'playback' : '', 'onlyaudio' : '', 'loopaudio' : '', 'playbackpath' : '', 'playbacklabel' : '' }; 
			for( var index in options) {
				var value = table.find('#ssfamodal-ft-' + index).val();
				if ( value !== options[index] && value != null ) 
					shortcode += ' ' + index + '="' + value + '"';
			} 
		} 		
		if ( stype === 'attachaway' && ttype !== 'table' ) {
			var	options = { 'postid' : '', 'images' : '', 'code' : '', 'only' : '', 'exclude' : '', 'include' : '', 'showto' : '', 'hidefrom' : '', 'heading' : '', 'hcolor' : '', 'width' : '', 'perpx' : '', 'align' : '', 'size' : '', 'style' : '', 'corners' : '', 'color' : '', 'accent' : '', 'icons' : '', 'iconcolor' : '', 'display' : '', 'orderby' : '', 'desc' : '', 'debug' : '' }; 
			for( var index in options) {
				var value = table.find('#ssaamodal-al-' + index).val();
				if ( value !== options[index] && value != null ) 
					shortcode += ' ' + index + '="' + value + '"';
			} 
		} 
		if ( stype === 'attachaway' && ttype === 'table' ) {
			var	options = { 'postid' : '', 'images' : '', 'code' : '', 'only' : '', 'exclude' : '', 'include' : '', 'showto' : '', 'hidefrom' : '', 'heading' : '', 'hcolor' : '', 'width' : '', 'perpx' : '', 'align' : '', 'size' : '', 'style' : '', 'search' : '', 'paginate' : '', 'pagesize' : '', 'textalign' : '', 'capcolumn' : '', 'descolumn' : '', 'sortfirst' : '', 'debug' : '' }; 
			for( var index in options) {
				var value = table.find('#ssaamodal-at-' + index).val();
				if ( value !== options[index] && value != null ) 
					shortcode += ' ' + index + '="' + value + '"';
			} 
		}
		if ( stype === 'fileaframe') {
			var	options = { 'name' : '', 'source' : '', 'scroll' : '', 'height' : '', 'width' : '', 'mheight' : '', 'mwidth' : '' }; 
			for( var index in options) {
				var value = table.find('#ssfamodal-fi-' + index).val();
				if ( value !== options[index] && value != null ) 
					shortcode += ' ' + index + '="' + value + '"';
			} 
		} 		
		shortcode += ']';
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		jQuery('#ssfamodal-submit-wrap input:button').attr('disabled', 'disabled').css({cursor : 'default'}); 
		jQuery('#ssfamodal-fl-hcolor, #ssfamodal-ft-hcolor, #ssaamodal-al-hcolor, #ssaamodal-at-hcolor').attr('disabled', 'disabled').val('');
		jQuery('#ssfamodal-ft-pagesize, #ssaamodal-at-pagesize').attr('disabled', 'disabled').val('');
		jQuery('#ssfamodal-table select').addClass('empty').prop('selectedIndex',0).attr('disabled', 'disabled');
		jQuery('#ssfamodal-table input:text').val('').attr('disabled', 'disabled');
		jQuery('#ssfamodal-shortcode-type, #ssfamodal-type').removeAttr('disabled');
		jQuery('#ssaa-banner, #ssfamodal-submit-wrap, #ssfa-fileaway-iframe-toggle, #ssfa-fileaway-list-toggle, #ssfa-fileaway-table-toggle, #ssfa-attachaway-list-toggle, #ssfa-attachaway-table-toggle').css({opacity : '0', 'z-index' : '-1'});
		jQuery('#ssfa-banner').css({opacity : '1', 'z-index' : '1'});
		tb_remove();
    }
});		