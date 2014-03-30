jQuery(document).ready(function($) {

	$('select#manager-role-access').on('change', function(){
		var roleaccess_selected = []; 
		$(this).each(function(i, selected){ 
			roleaccess_selected[i] = $(selected).val(); 
		});
		$('input#manager_role_access').val(roleaccess_selected);
	});

	$('select#manager-user-access').on('change', function(){
		var useraccess_selected = []; 
		$(this).each(function(i, selected){ 
			useraccess_selected[i] = $(selected).val(); 
		});
		$('input#manager_user_access').val(useraccess_selected);
	});
	
	$('select.chozed-select').chozed({
		allow_single_deselect:true, 
		width: '50%', 
		inherit_select_classes:true,
		no_results_text: "Say what?",
		search_contains: true, 
	});


	// Save Settings Ajax
	var frm = $("#ssfa-form"),
		svn = $("#ssfa-saving"),
		bck = $("#ssfa-saving-backdrop"),
		img = $("#ssfa-saving-img"),
		svd = $("#ssfa-settings-saved");
	$(".ssfa-save-btn").click(function(){
		img.css({'bottom' : '-100px'});
	});
	frm.ajaxForm({
		beforeSerialize: function() {
			frm.find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder'))
					input.val('');
			})
			$('input[id^=base]').each(function() {
				var i = $(this),
					rx = /^(wp-admin|\/wp-admin|wp-includes|\/wp-includes)/i;
					test = rx.test(i.val());
		        if (test) i.removeAttr('value');
			});
			$("input#custom_list_classes").val(function(i, val) {
			  return val.replace(/ssfa-/g,"");
			});
			$("input#custom_table_classes").val(function(i, val) {
			  return val.replace(/ssfa-/g, '');
			});
			$("input#custom_color_classes").val(function(i, val) {
			  return val.replace(/ssfa-/g, '');
			});
			$("input#custom_accent_classes").val(function(i, val) {
			  return val.replace(/accent-/g, '');
			});									
		},
		beforeSend: function() {
			svn.fadeIn('slow');
			bck.fadeIn('fast');
			img.fadeIn('slow').css({'bottom' : '50px', 'transition' : 'all 1s ease-out'});
		},
		success: function(){ 
			svn.fadeOut('slow');
			img.delay(2000).queue( function(next){
				$(this).css({'bottom' : '2400px', 'transition' : 'all 4.5s ease-in'}); next();
			});
			svd.delay(1000).fadeIn('slow').delay( 2500 ).fadeOut('slow');
			bck.delay( 4500 ).fadeOut('slow'); 
		}
	});
/*
	// Remove Placeholder Text on Form Submit (non-Ajax)
	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('ssfa-placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur().parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});
*/
	// Accordion Sections
	$(".accordion > dt").click(function(){
    	$('.active').removeClass('active');
	    if(false == $(this).next().is(':visible')) {
	        $(this).addClass('active');
	        $('.accordion > dd').slideUp(600);
	    }
	    $(this).next().slideToggle(600);
	});
	$(".accordion-secondary > dt").click(function(){
    	$('.active-secondary').removeClass('active-secondary');
	    if(false == $(this).next().is(':visible')) {
	        $(this).addClass('active-secondary');
	        $('.accordion-secondary > dd').slideUp(600);
	    }
	    $(this).next().slideToggle(600);
	});
	// Base Directory Stuff
	$('input[id^=base]').each(function() {
    	var idSuffix = this.id,
	       	i = $(this),
	        s = $('#ssfa-abspath-' + idSuffix),
	        w = $('#ssfa-wrap-' + idSuffix),		
	        e = $('#ssfa-error-' + idSuffix),
	        rx = /^(wp-admin|\/wp-admin|wp-includes|\/wp-includes)/i;
		i.on('focus', function() {
			w.addClass('ssfa-focus');
		});
		i.on('blur', function() {
			w.removeClass('ssfa-focus');
		});
		s.on('click', function() {
			i.focus();
		});
		w.on('click', function() {
			i.focus();
		});
	    i.on('keyup', function() {
	        var test = rx.test(i.val());
	        w.toggleClass('ssfa-error', test);
	        if (test) {
    	        e.show(600);
	        } else {
	            e.hide(600);
	        }
	    });
	});
	var	con = $('.ssfa-help-content');
	$('div[id^=ssfa-help-]').each(function() {
		var sfx = this.id,
			mdl = $(this),
			cls = $('.ssfa-help-close'),			
			lnk = $('.link-' + sfx);
		lnk.click(function(){
			mdl.fadeIn('fast');
		});
		mdl.click(function() {
			mdl.fadeOut('fast');
		});
		cls.click(function(){
			mdl.fadeOut('fast');
		});
	});
	con.click(function() {
		return false;
	});
	// Remove Update Notice after 10 Seconds
	setTimeout(function() {	$("div.updated").fadeOut(600);	}, 10000);	
});