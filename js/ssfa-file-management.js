// Manager Check
jQuery(document).ready(function($){
	if ($('th.ssfa-manager').length){
// Allowed Characters Settings
jQuery(document).ready(function($){
	$('table#ssfa-table input').alphanum({
		allow : "~!@#$%^&()_+`-={}[]';,"
	});
});
(function($) {
	$(document).ready(function(){
		$loading2 = $('img#ssfa-engage-ajax-loading');
		$bm = $('input#ssfa-bad-motivator').val();
		// Primary Table Row Each Function
		$('tr[id^=ssfa-file-]').each(function(){
			var sfx = this.id,
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				filename = $('td#filename-'+sfx+' a'),
				rawname = $('input#rawname-'+sfx),
				manager = $('td#manager-'+sfx);
			// Rename Function
			$(rename).on('click', function(ev){
				ev.preventDefault();
				rename.fadeOut('fast');
				if(! $('a#cancel-'+sfx).length) manager.prepend("<a href='' id='cancel-"+sfx+"' style='display:none;'>Cancel</a>")
				if(! $('a#save-'+sfx).length) manager.prepend("<a href='' id='save-"+sfx+"' style='display:none;'>Save<br></a>")
				var save = $('a#save-'+sfx),
					cancel = $('a#cancel-'+sfx);
				filename.fadeOut(500);
				del.fadeOut(500);				
				save.delay(0).fadeIn(1000);
				cancel.delay(0).fadeIn(1000);			
				rawname.delay(0).fadeIn(1000);
				var customs = $('input[id^="customdata-"][id$="'+sfx+'"]').length;
				customs = customs - 1;
				for (var i=0; i <= customs; i++){
					var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
						$(cdata).siblings('span').fadeOut('fast');
						$(cdata).delay(0).fadeIn(1000);
				}
				$(cancel).on('click', function(ev){
					ev.preventDefault();
					save.fadeOut(500);
					cancel.fadeOut(500);
					rename.delay(0).fadeIn(1000);
					del.delay(0).fadeIn(1000);
					rawname.fadeOut(500);
					filename.delay(0).fadeIn(1000);
					for (var i=0; i <= customs; i++){
						var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
							$(cdata).fadeOut(500);
							$(cdata).siblings('span').delay(0).fadeIn(1000);
					}
				});
				$(save).on('click', function(ev){
					ev.preventDefault();				
					ext = $('td#filetype-'+sfx+' input'),
					url = $('td#filename-'+sfx+' a'),
					url2 = $('td#filetype-'+sfx+' a'),					
					rawname = $('input#rawname-'+sfx),
					oldname = $('input#oldname-'+sfx),
					filepath = $('input#filepath-'+sfx);
					var customs = $('input[id^="customdata-"][id$="'+sfx+'"]').length;
					customs = customs - 1;
					customdata = '';
					for (var i=0; i <= customs; i++){
						var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
						customdata += cdata.val()+",";
						cdata.fadeOut(500);
					}
					customdata = customdata.substring(0, customdata.length - 1);
					rawname.fadeOut(500);
					save.fadeOut(500);
					cancel.fadeOut(500);
					if (filepath.val().indexOf('..') >= 0 || filepath.val() === '/'){
						$loading2.show();
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'saboteur',
									nextNonce : SSFA_FM_Ajax.nextNonce						
								},
								function( response ) {
									$('div#ssfa-bulk-action-toggle').append($loading2);
									$loading2.hide();								
									alertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
									alertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
										if (e) {
											$(top.location).attr("href",response);  
										} else {
											$(top.location).attr("href",response);  
										}
								});
							}
						);
					} else {
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'rename',
									ext : ext.val(),
									url : url.attr('href'),
									rawname : rawname.val(),
									oldname : oldname.val(),								
									pp : $bm,
									customdata : customdata,
									nextNonce : SSFA_FM_Ajax.nextNonce
								},
									function( response ) {			
										$(url).attr("href", response.newurl);
										$(url).attr("download", response.download);
										$(url2).attr("href", response.newurl);
										$(url2).attr("download", response.download);									
										$(rawname).val(response.rawname);
										$(oldname).val(response.newoldname);
										rename.fadeIn(1000);
										del.fadeIn(1000);									
										$('input#rawname-'+sfx).val(response.rawname);
										filename.text(response.rawname);
										filename.fadeIn(1000);
										var newcustomdata = response.customdata;
										newcustomdata = newcustomdata.replace("]", ""); 
										newcustomdata = newcustomdata.replace(" [", "");									
										var newcdata = newcustomdata.split(',');
										for (var i=0; i <= customs; i++){
											var cinput = $('input[id^="customdata-'+i+'-'+sfx+'"]');
											$(cinput).siblings('span').text(newcdata[i]).fadeIn(1000);
										}
								}
						);					
					return false;
					}
				});				
			}); // End Rename Function
			// Delete Function (Single)
			$(del).on('click', function(ev){
				ev.preventDefault();				
				ext = $('td#filetype-'+sfx+' input'),
				oldname = $('input#oldname-'+sfx),
				filepath = $('input#filepath-'+sfx);
				del.fadeOut(500);
				rename.fadeOut(500);				
				if(! $('a#canceldel-'+sfx).length) manager.prepend("<a href='' id='canceldel-"+sfx+"' style='display:none;'>Cancel</a>")
				if(! $('a#proceed-'+sfx).length) manager.prepend("<a href='' id='proceed-"+sfx+"' style='display:none;'>Proceed<br></a>")
				if(! $('span#confirm-'+sfx).length) manager.prepend("<span id='confirm-"+sfx+"' style='display:none;'>You Sure?<br></span>")				
				var proceed = $('a#proceed-'+sfx),
					canceldel = $('a#canceldel-'+sfx),
					confirms = $('span#confirm-'+sfx);
				proceed.delay(0).fadeIn(1000);
				canceldel.delay(0).fadeIn(1000);						
				confirms.delay(0).fadeIn(1000);										
				$(canceldel).on('click', function(ev){
					ev.preventDefault();
					proceed.fadeOut(500);
					canceldel.fadeOut(500);
					confirms.fadeOut(500);					
					rename.delay(0).fadeIn(1000);
					del.delay(0).fadeIn(1000);					
				});
				$(proceed).on('click', function(ev){
					ev.preventDefault();
					proceed.fadeOut(500);
					canceldel.fadeOut(500);
					confirms.fadeOut(500);					
					if (filepath.val().indexOf('..') >= 0 || filepath.val() === '/'){
						$loading2.show();
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'saboteur',
									nextNonce : SSFA_FM_Ajax.nextNonce						
								},
								function( response ) {
									$('div#ssfa-bulk-action-toggle').append($loading2);
									$loading2.hide();								
									alertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
									alertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
										if (e) {
											$(top.location).attr("href",response);  
										} else {
											$(top.location).attr("href",response);  
										}
								});
							}
						);					
					} else {
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'delete',
									ext : ext.val(),
									oldname : oldname.val(),								
									pp : $bm,
									nextNonce : SSFA_FM_Ajax.nextNonce
								},
								function( response ) {			
									if (response == 'success'){
										$(ext).parents('tr').fadeOut(2000).queue( function(next){
											$(this).remove(); next();
										});
									} else { alertify.alert(response) }
								}
						);
						return false;
					}
				});
			}); // End Delete Function (Single)
			// Bulk Action Toggle Selected Files
			$(this).on('click', function(){
				if ($('a#ssfa-bulk-action-toggle').text() == 'Enabled') {
					if($(this).hasClass('ssfa-selected')) $(this).removeClass('ssfa-selected');	
					else $(this).addClass('ssfa-selected');						
				}
			}); // End Bulk Action Toggle Selected Files		
		}); // End Primary Table Row Each Function
		// Bulk Action Toggle Function
		$('a#ssfa-bulk-action-toggle').on('click', function(ev){
			ev.preventDefault();
			$('select#ssfa-bulk-action-select').chozed({
				allow_single_deselect:true, 
				width: '150px', 
				inherit_select_classes:true,
				no_results_text: "Say what?",
				search_contains: true 
			});
			$selectaction = $('div#ssfa_bulk_action_select_chozed');
			$engageaction = $('span#ssfa-bulk-action-engage');			
			$pathcontainer = $('div#ssfa-path-container');
			if($(this).text() == 'Disabled'){
				$(this).text('Enabled');
				$selectaction.fadeIn('1000');	
				$engageaction.fadeIn('1000');
				if(! $('input#ssfa-bulk-action-select-all').length) 
					$('div#ssfa-bulk-action-toggle')
						.append('<input type="checkbox" id="ssfa-bulk-action-select-all" style="display:inline-block; margin-top:5px!important; margin-right:5px;" />'+
								'<label for="ssfa-bulk-action-select-all" id="ssfa-select-all" style="display:inline-block; font-size:12px;"> Select All</label>');
				$checkall = $('input#ssfa-bulk-action-select-all');
				$selectall = $('label#ssfa-select-all');
				$selectall.hide().fadeIn('1000');				
				$checkall.hide().fadeIn('1000');								
				$checkall = $('input#ssfa-bulk-action-select-all');
					// Bulk Action Select All Function
					$checkall.on('change', function(){
						if(this.checked){
							$selectall.text('Clear All');
							$('tr[id^=ssfa-file-]').addClass('ssfa-selected');
						}else{
							$selectall.text('Select All');
							$('tr[id^=ssfa-file-]').removeClass('ssfa-selected');							
						}
					});
			}
			else if($(this).text() == 'Enabled') { 
				$(this).text('Disabled');
				$selectaction.fadeOut('1000');	
				$engageaction.fadeOut('1000');									
				$pathcontainer.fadeOut('1000');
				$selectall = $('label#ssfa-select-all');
				$checkall = $('input#ssfa-bulk-action-select-all');
				$selectall.fadeOut('1000');
				$checkall.fadeOut('1000');
				$checkall.attr('checked', false);
				$('select#ssfa-bulk-action-select').find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('liszt:updated');
				$('tr[id^=ssfa-file-]').each(function(){
					if($(this).hasClass('ssfa-selected')) $(this).removeClass('ssfa-selected');
				});
			}
		}); // End Bulk Action Toggle Function
		// Bulk Action Select Function
		$('select#ssfa-bulk-action-select').on('change', function(){
			var actionselected = this.value;
			var pathcontainer = $('div#ssfa-path-container');
			var pathselect = $('select#ssfa-bulk-action-select');
			if (actionselected == '' || actionselected == 'delete'){
				pathcontainer.fadeOut(1000);
			}
			else pathcontainer.fadeIn(1000);
		}); // End Bulk Action Select Function
		// Bulk Action Engage Function
		$('span#ssfa-bulk-action-engage').on('click', function(){
			var selectedAction = $('select#ssfa-bulk-action-select').val();
			var selectedPath = $('input#ssfa-nomenclature').val();
			var selectedFilesFrom = '';
			var selectedFilesTo = '';
			var selectedExts = '';
			var selectedCount = 0;
			var messages = '';
			var jackoff = 0;
			if (selectedPath.indexOf('..') >= 0 || $('input#ssfa-bad-motivator').val().indexOf('..') >= 0) jackoff = 1;
			if (selectedPath === '/' || $('input#ssfa-bad-motivator').val() === '/') jackoff = 1;			
			$('tr.ssfa-selected').each(function(index){
				var sfx = this.id;
				var filepath = $('input#filepath-'+sfx).val();				
				var oldname = $('input#oldname-'+sfx).val();
				var	ext = $('td#filetype-'+sfx+' input').val();
				if (filepath.indexOf('..') >= 0 || filepath === '/') jackoff = 1;
				selectedFilesFrom += $bm+'/'+oldname+'.'+ext+'/*//*/';
				selectedFilesTo += selectedPath+'/'+oldname+'.'+ext+'/*//*/';
				selectedExts += ext+'/*//*/';
				selectedCount++;
			});
			if (jackoff == 1){
				$loading2.show();
				$.post(
					SSFA_FM_Ajax.ajaxurl,
						{
							action : 'ajax-ssfa-file-manager',
							dataType : 'html',	
							act : 'saboteur',
							nextNonce : SSFA_FM_Ajax.nextNonce						
						},
						function( response ) {
							$('div#ssfa-bulk-action-toggle').append($loading2);
							$loading2.hide();								
							alertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
							alertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
								if (e) {
									$(top.location).attr("href",response);
								} else {
									$(top.location).attr("href",response);  
								}
						});
					}
				);				
			} else {			
				if(selectedAction == '') messages += 'No action has been selected.<br>';
				if(selectedCount == 0) messages += 'No files have been selected.<br>';
				if((selectedAction == 'move' || selectedAction == 'copy') && selectedPath == '') messages += 'No destination directory has been selected.<br>';
				if(messages !== '') alertify.alert(messages)
				else {
					// Bulk Action Copy Function
					if (selectedAction == 'copy'){
						$loading2.show();
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'bulkcopy',
									from : selectedFilesFrom,
									to : selectedFilesTo,
									exts : selectedExts,
									destination : selectedPath,
									nextNonce : SSFA_FM_Ajax.nextNonce						
								},
								function( response ) {
									$('div#ssfa-bulk-action-toggle').append($loading2);
									$loading2.hide();								
									alertify.alert(response);
							}
						);
					} // End Bulk Action Copy Function
					// Bulk Action Move Function
					else if (selectedAction == 'move'){
						$loading2.show();
						$.post(
							SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'bulkmove',
									from : selectedFilesFrom,
									to : selectedFilesTo,
									exts : selectedExts,
									destination : selectedPath,
									nextNonce : SSFA_FM_Ajax.nextNonce						
								},
								function( response ) {
									$('div#ssfa-bulk-action-toggle').append($loading2);
									$loading2.hide();								
									alertify.alert(response);
									$('tr.ssfa-selected').each(function(){
										$(this).fadeOut(2000).queue( function(next){
											$(this).remove(); next();
										});
									});
							}
						);
					} // End Bulk Action Move Function
					// Bulk Action Delete Function
					else if (selectedAction == 'delete'){
						var numfiles = selectedCount > 1 ? 'files' : 'file'; 
						alertify.confirm("You are about to permanently delete "+selectedCount+" "+numfiles+". Press OK if you're OK with that.", function (e) {
							if (e) {
								$loading2.show();
								$.post(
									SSFA_FM_Ajax.ajaxurl,
										{
											action : 'ajax-ssfa-file-manager',
											dataType : 'html',	
											act : 'bulkdelete',
											files : selectedFilesFrom,
											nextNonce : SSFA_FM_Ajax.nextNonce						
										},
										function( response ) {
											$('div#ssfa-bulk-action-toggle').append($loading2);
											$loading2.hide();								
											alertify.alert(response);
											$('tr.ssfa-selected').each(function(){
												$(this).fadeOut(2000).queue( function(next){
													$(this).remove(); next();
												});
											});
									}
								);
							}
						});
					} // End Bulk Action Delete Function
				}
			}
		}); // End Bulk Action Engage Function
	});
})(jQuery);
// Bulk Action Path Generator Function
(function($) {
	$(document).ready(function(){
		$('select#ssfa-directories-select').chozed({
				allow_single_deselect:false, 
				width: '200px', 
				inherit_select_classes:true,
				no_results_text: "Ain't no thang",
				search_contains: true 
			});
		$loading = $('img#ssfa-action-ajax-loading');
		$st = $('input#ssfa-yesmenclature').val();
		$sht = $('input#ssfa-whymenclature').val();		
		$('select#ssfa-directories-select').on('change', function(){
			if($(this).val() !== ''){
				$loading.show();
				$.post(
					SSFA_FM_Ajax.ajaxurl,
						{
							action : 'ajax-ssfa-file-manager',
							dataType : 'html',	
							act : 'getactionpath',
							pp : this.value,
							st : $st,					
							sht : $sht,							
							nextNonce : SSFA_FM_Ajax.nextNonce						
							},
							function( response ) {
								$container = $('div#ssfa-path-container');
								$hp = $('input#ssfa-nomenclature');
								$putpath = $('div#ssfa-action-path');
								$dropdown = $('select#ssfa-directories-select');
								$dropdown.empty().append(response.ops).trigger('chozed:updated').trigger('liszt:updated');
								$hp.val(response.pp);
								$putpath.html('Destination: '+response.crumbs).append($loading);
								$loading.hide();
								$('div#ssfa-action-path').change();
						}
				);
			}
			return false;
		});			
	});
})(jQuery); // End Bulk Action Path Generator Function
// Bulk Action Path Generator Function (Breadcrumbs)
(function($) {
	$(document).ready(function(){
		$stt = $('input#ssfa-yesmenclature').val();
		$sht = $('input#ssfa-whymenclature').val();		
		$loading = $('img#ssfa-action-ajax-loading');
		$('div#ssfa-action-path').change(function(){
			$('a[id^=ssfa-action-pathpart-]').each(function(){
				$(this).on('click', function(ev){
					ev.preventDefault();
					var data = $(this).attr('data-target');
					$loading.show();
					$.post(
						SSFA_FM_Ajax.ajaxurl,
							{
								action : 'ajax-ssfa-file-manager',
								dataType : 'html',	
								act : 'getactionpath',
								pp : data,
								st : $stt,					
								sht : $sht,							
								nextNonce : SSFA_FM_Ajax.nextNonce						
							},
							function( response ) {
								$container = $('div#ssfa-path-container');
								$hp = $('input#ssfa-nomenclature');
								$putpath = $('div#ssfa-action-path');
								$dropdown = $('select#ssfa-directories-select');
								$dropdown.empty().append(response.ops).trigger('chozed:updated').trigger('liszt:updated');
								$hp.val(response.pp);
								$putpath.html('Destination: '+response.crumbs).append($loading);
								$loading.hide();
								$('div#ssfa-action-path').change();
							}
					);
					return false;  
				});	
			});
		});
	});
})(jQuery); // End Bulk Action Path Generator Function (Breadcrumbs)
	}
}); // End Manager Check