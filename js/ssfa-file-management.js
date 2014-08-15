// Bulk Download Check
jQuery(document).ready(function($){
	if($('span[id^=ssfa-bulk-download-engage]').length){
		// Bulk Download Select All Function
		$checkall = $('input[id^="ssfa-bulk-download-select-all-"]');
		$checkall.on('change', function(){
			$uid = this.id;
			$uid = $uid.replace('ssfa-bulk-download-select-all-', '');
			$selectall = $('label#ssfa-select-all-'+$uid);
			if(this.checked){
				$selectall.text('Clear All');
				$('table.bd-table tr[id^=ssfa-file-'+$uid+']').addClass('ssfabd-selected');
			}else{
				$selectall.text('Select All');
				$('table.bd-table tr[id^=ssfa-file-'+$uid+']').removeClass('ssfabd-selected');							
			}
		});
		// Bulk Download Toggle Selected Files
		$('table.bd-table tr[id^=ssfa-file-]').each(function(){
			$(this).on('click', function(){
				if($(this).hasClass('ssfabd-selected')) $(this).removeClass('ssfabd-selected');	
				else $(this).addClass('ssfabd-selected');						
			}); 
		}); 	
	}
	(function($) {
		$(document).ready(function(){
		$('span[id^="ssfa-bulk-download-engage-"]').on('click', function(){
			$uid = this.id;
			$uid = $uid.replace('ssfa-bulk-download-engage-', '');
			$loading3 = $('img#ssfa-engage-ajax-loading-'+$uid);
			if(window.name !== '' && window.name !== 'new' && window.name !== 'blank' && window.name !== '_new'){ 
				$name = window.name;
				$('html, body', window.top.document).animate({
			        scrollTop: $("div#"+$name, window.top.document).offset().top -75
				}, 500);
			}
			var selectedFilesFrom = '';
			var selectedCount = 0;
			var messages = '';
			var jackoff = 0;
			$('table.bd-table tr[id^=ssfa-file-'+$uid+']').each(function(index){
				if($(this).hasClass('ssfabd-selected')){
					var sfx = this.id;
					var filepath = String($('input#filepath-'+sfx).val()); 
					var oldname = $('input#oldname-'+sfx).val();
					var	ext = $('td#filetype-'+sfx+' input').val();
					if (filepath.indexOf('..') >= 0 || filepath === '/') jackoff = 1;
					selectedFilesFrom += filepath+'/'+oldname+'.'+ext+'/*//*/';
					selectedCount++;
				}
			});
			if (jackoff == 1){
				$loading3.show();
				$.post(
					SSFA_FM_Ajax.ajaxurl,
						{
							action : 'ajax-ssfa-file-manager',
							dataType : 'html',	
							act : 'saboteur',
							nextNonce : SSFA_FM_Ajax.nextNonce						
						},
						function( response ) {
							$loading3.hide();								
							filertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
							filertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
								if (e) {
									$(top.location).attr("href",response);
								} else {
									$(top.location).attr("href",response);  
								}
						});
					}
				);				
			} else {			
				if(selectedCount == 0) messages += 'No files have been selected. Click on the table rows of the files you wish to select.<br>';
				if(messages !== ''){ filertify.set({labels:{ok : "OK" }}); filertify.alert(messages) }
				else {
					// Bulk Action Download Function
					$loading3.show();
					$.post(
						SSFA_FM_Ajax.ajaxurl,
							{
								action : 'ajax-ssfa-file-manager',
								dataType : 'html',	
								act : 'bulkdownload',
								files : selectedFilesFrom,
								nextNonce : SSFA_FM_Ajax.nextNonce						
							},
							function( response ) {
								$loading3.hide();		
								if(response === 'Error'){ filertify.set({labels:{ok : "OK" }}); filertify.alert(response); }
								else{
									$('<iframe src="'+response+'" id="fa-bulkdownload" style="visibility:hidden;" name="fa-bulkdownload">').appendTo('body');	
								}
						}
					) // End Bulk Action Download Function
				}
			}
		}); // End Bulk Download Engage Function
		});
	})(jQuery);
});
jQuery(document).ready(function($){
	// Manager Check
	if ($('th.ssfa-manager').length){
		$i=0;
		$('th.ssfa-manager').each(function(){
			$i++;
			if($i > 1) $(this).parents('div:eq(1)').remove();
		});
		if($i > 1){ 
			filertify.set({labels:{ok : "OK" }});
			filertify.alert('Warning: You have multiple Manager Mode tables on the same page. If you need to have more than one Manager Mode table on the same page, to avoid them interfering with one another you need to use the File Away iframe shortcode. See the Tutorials for instructions. In the meantime, for your security, File Away has removed all but the first Manager Mode table from the page.');
		}
		// Allowed Characters Settings
		jQuery(document).ready(function($){
			$('table#ssfa-table tbody tr[id^="ssfa-file-"] input').alphanum({
				allow : "~!@#$%^&()_+`-={}[]',"
			});
			$('table#ssfa-table tbody tr[id^="row-ssfa-create-dir-"] input').alphanum({
				allow : "~!@#$%/^&()_+`-={}[]',"
			});
			$('table#ssfa-table tbody tr[id^="ssfa-dir-"] input').alphanum({
				allow : "~!@#$%^&()_+`-={}[]',"
			});
		});
		(function($) {
			$(document).ready(function(){
				$loading2 = $('img#ssfa-engage-ajax-loading');
				$bm = $('input#ssfa-bad-motivator').data('path');
				$ym = $('input#ssfa-yesmenclature').data('path');
				$wm = $('input#ssfa-whymenclature').data('path');
				$so = $('input#ssfa-smooth-operator').data('path');
				$fafl = $('input#ssfa-fafl').length > 0 ? $('input#ssfa-fafl').val() : false;
				$faui = $('input#ssfa-faui').length > 0 ? $('input#ssfa-faui').val() : false;
				$faun = $('input#ssfa-faun').length > 0 ? $('input#ssfa-faun').val() : false;
				$faur = $('input#ssfa-faur').length > 0 ? $('input#ssfa-faur').val() : false;
				$('table.mngr-table tr[id^=ssfa-dir-]').each(function(i){
					var sfx = this.id;
					var path = $('td#folder-'+sfx+' a').data('path');
				});
				
				// Create Dir
				$('body').on('click', 'a[id^="ssfa-create-dir-"]', function(ev){
					ev.preventDefault();
					var sfx = this.id,
						createinput = $('input#input-'+sfx),
						manager = $('td#manager-'+sfx);
					if($(createinput).is(':visible')){}else{
						createinput.fadeIn(1000).focus();
						manager.html("<a href='' id='save-"+sfx+"' style='display:none;'>Save</a><br><a href='' id='cancel-"+sfx+"' style='display:none;'>Cancel</a>")
						var save = $('a#save-'+sfx),
							cancel = $('a#cancel-'+sfx);
						save.delay(0).fadeIn(1000);
						cancel.delay(0).fadeIn(1000);
					}
				});
				$('body').on('click', 'a[id^="cancel-ssfa-create-dir-"]', function(ev){	
					ev.preventDefault();
					var sfx = this.id.replace('cancel-',''),
						save = $('a#save-'+sfx),
						createinput = $('input#input-'+sfx);
					save.fadeOut(500);
					$(this).fadeOut(500);
					createinput.fadeOut(500).val('');
				});
				$('body').on('click', 'a[id^="save-ssfa-create-dir"]', function(ev){
					ev.preventDefault();
					var sfx = this.id.replace('save-',''),
						cancel = $('a#cancel-'+sfx),
						createinput = $('input#input-'+sfx);
					$newsub = createinput.val();
					if($newsub === ''){
						filertify.set({labels:{ok : "OK"}});
						filertify.alert('You did not specify a name for your sub-directory.');
					}else{
						$(this).fadeOut(500);
						cancel.fadeOut(500);
						createinput.fadeOut(500).val('');					
						var uid = sfx.replace('ssfa-create-dir-','');
						var count = $('table.mngr-table tr[id^=ssfa-dir-]').length;
						var cells = $(this).parents('tr').children('td').length;
						var cls = $(this).parents('table').eq(0).data('cls');
						var page = $(this).parents('table').eq(0).data('pg');
						var drawer = $(this).parents('table').eq(0).data('drw');
						$.post(
							SSFA_FM_Ajax.ajaxurl,
							{
								action : 'ajax-ssfa-file-manager',
								dataType : 'html',	
								act : 'createdir',
								newsub : $newsub,
								parents : $bm,
								base : $so,
								uid : uid,
								count : (+count+1),
								cells : (+cells-2),
								cls : cls,
								page : page,
								drawer : drawer,
								nextNonce : SSFA_FM_Ajax.nextNonce
							},
							function(response){			
								if(response.status === 'error'){
									filertify.set({labels:{ok : "OK"}});
									filertify.alert(response.message);	
								}
								else if(response.status === 'success'){
									filertify.set({labels:{ok : "OK"}});
									filertify.alert(response.message);	
								}
								else if(response.status === 'insert'){
									$newrow = response.message;
									$row = $('tr#row-'+sfx);	
									$row.after($newrow).hide().fadeIn(500);
								}
							}
						);
						return false;
					}
				}); 

				// Delete Directory Function
				$('body').on('click', 'a[id^="delete-ssfa-dir-"]', function(ev){
					ev.preventDefault();
					var sfx = this.id.replace('delete-',''),
						rename = $('a#rename-'+sfx),
						del = $('a#delete-'+sfx),
						manager = $('td#manager-'+sfx);
					del.fadeOut(500);
					rename.fadeOut(500);				
					if(! $('a#canceldel-'+sfx).length) manager.prepend("<a href='' id='canceldel-"+sfx+"' style='display:none;'>Cancel</a>")
					if(! $('a#proceed-'+sfx).length) manager.prepend("<a href='' id='proceed-"+sfx+"' style='display:none;'>Proceed<br></a>")
					if(! $('span#confirm-'+sfx).length) manager.prepend("<span id='confirm-"+sfx+"' style='display:none;'>Delete?<br></span>")				
					var proceed = $('a#proceed-'+sfx),
						canceldel = $('a#canceldel-'+sfx),
						confirms = $('span#confirm-'+sfx);
					proceed.delay(0).fadeIn(1000);
					canceldel.delay(0).fadeIn(1000);						
					confirms.delay(0).fadeIn(1000);										
					$subdir = $('td#folder-'+sfx+' a').data('name');
					$path1 = String($bm);
					$path2 = String($subdir);
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
						rename.delay(0).fadeIn(1000);
						del.delay(0).fadeIn(1000);		
						if($path1.indexOf('..') >= 0 || $path1 === '/' || $path1 === '' || !$path1 || $path1 === 'undefined' || $path1 === undefined){
							filertify.set({labels:{ok : "OK" }}); filertify.alert('There was an error completing your request. The path to the directory has not been properly defined.');
						}else if($path2.indexOf('..') >= 0 || $path2 === '/' || $path2 === '' || !$path2 || $path2 === 'undefined' || $path2 === undefined){
							filertify.set({labels:{ok : "OK" }}); filertify.alert('There was an error completing your request. The path to the directory has not been properly defined.');
						}else{
							$.post(
								SSFA_FM_Ajax.ajaxurl,
								{
									action : 'ajax-ssfa-file-manager',
									dataType : 'html',	
									act : 'deletedir',
									status : 'life',
									path1 : $path1,
									path2 : $path2,
									nextNonce : SSFA_FM_Ajax.nextNonce
								},
								function(response){			
									if(response.status === 'error' || response.status === 'partial'){
										filertify.set({labels:{ok : "well, shucks"}});
										filertify.alert(response.message);	
									}
									else if(response.status === 'success'){
										filertify.set({labels:{ok : "OK"}});
										filertify.alert(response.message);	
										$(del).parents('tr').fadeOut(2000).queue( function(next){
											$(this).remove(); next();
										});
									}
									else if(response.status === 'success-single'){
										$(del).parents('tr').fadeOut(2000).queue( function(next){
											$(this).remove(); next();
										});
									}
									else if(response.status === 'confirm'){
										filertify.set({labels:{ok : "I'm Sure", cancel : "Nevermind" }});
										filertify.confirm(response.message, function (e) {
										if(e){
											$.post(
												SSFA_FM_Ajax.ajaxurl,
												{
													action : 'ajax-ssfa-file-manager',
													dataType : 'html',	
													act : 'deletedir',
													status : 'death',
													path1 : $path1,
													path2 : $path2,
													nextNonce : SSFA_FM_Ajax.nextNonce
												},
												function(response){			
													if(response.status === 'error' || response.status === 'partial'){
														filertify.set({labels:{ok : "well, shucks"}});
														filertify.alert(response.message);	
													}
													else if(response.status === 'success'){
														filertify.set({labels:{ok : "OK"}});
														filertify.alert(response.message);	
														$(del).parents('tr').fadeOut(2000).queue( function(next){
															$(this).remove(); next();
														});
													}
												});
											};
											return false;
										});
									}
								}
							);
							return false;
						}
					}); 
				}); // End Delete Function (Directory Single) 
				
				// Directory Rename Function
				$('body').on('click', 'a[id^="rename-ssfa-dir-"]', function(ev){
					ev.preventDefault();
					var sfx = this.id.replace('rename-', ''),
						del = $('a#delete-'+sfx),
						manager = $('td#manager-'+sfx),
						dirname = $('td#name-'+sfx+' a'),
						dirinput = $('input#rename-'+sfx);
					$subdir = $('td#folder-'+sfx+' a').data('path');
					$(this).fadeOut(500);
					del.fadeOut(500);
					if(!$('a#cancel-'+sfx).length) manager.prepend("<a href='' id='cancel-"+sfx+"' style='display:none;'>Cancel</a>");
					if(!$('a#save-'+sfx).length) manager.prepend("<a href='' id='save-"+sfx+"' style='display:none;'>Save<br></a>");
					var save = $('a#save-'+sfx),
						cancel = $('a#cancel-'+sfx);
					dirname.fadeOut(500);
					save.delay(0).fadeIn(1000);
					cancel.delay(0).fadeIn(1000);			
					dirinput.delay(0).fadeIn(1000);
				});
				$('body').on('click', 'a[id^="cancel-ssfa-dir-"]', function(ev){
					ev.preventDefault();
					var sfx = this.id.replace('cancel-', '');
					$('a#save-'+sfx).fadeOut(500);
					$(this).fadeOut(500);
					$('a#rename-'+sfx).delay(0).fadeIn(1000);
					$('a#delete-'+sfx).delay(0).fadeIn(1000);
					$('input#rename-'+sfx).fadeOut(500);
					$('td#name-'+sfx+' a').delay(0).fadeIn(1000);
				});
				$('body').on('click', 'a[id^="save-ssfa-dir-"]', function(ev){
					ev.preventDefault();				
					var sfx = this.id.replace('save-', '');
					$url = $('td#folder-'+sfx+' a');
					$url2 = $('td#name-'+sfx+' a');
					$subdir = $('td#folder-'+sfx+' a').data('path');
					$oldpath = $so+'/'+$subdir;
					$newname = String($('input#rename-'+sfx).val());
					$page = $(this).parents('table').eq(0).data('pg');
					$('a#save-'+sfx).fadeOut(500);
					$('a#cancel-'+sfx).fadeOut(500);
					$('input#rename-'+sfx).fadeOut(500);
					if($oldpath.indexOf('..') >= 0 || $oldpath === '/' || $newname.indexOf('..') >= 0 || $newname.indexOf('/') >= 0){
						filertify.set({labels:{ok : "OK"}});
						filertify.alert('Sorry, but the name you specified cannot be processed.');
					}
					else if($newname === '' || $newname === 'undefined' || $newname === undefined){
						filertify.set({labels:{ok : "OK"}});
						filertify.alert('You did not specify a new name for the directory.');
					}else{
						$.post(
							SSFA_FM_Ajax.ajaxurl,
							{
								action : 'ajax-ssfa-file-manager',
								dataType : 'html',	
								act : 'renamedir',
								datapath : $subdir,
								oldpath : $oldpath,
								newname : $newname,
								parents : $bm,
								page : $page,
								nextNonce : SSFA_FM_Ajax.nextNonce
							},
							function(response){ 						
								if(response.status === 'error'){ filertify.set({labels:{ok : "OK" }}); filertify.alert(response.message); }
								else{
									$('td#name-'+sfx+' input').val(response.newname).attr('value', response.newname);
									$('td#folder-'+sfx).data('value', "00-"+response.newname).attr('data-value', "00-"+response.newname);
									$('td#name-'+sfx).data('value', "00-"+response.newname).attr('data-value', "00-"+response.newname);
									$('td#folder-'+sfx+' a').attr('href', response.url);
									$('td#folder-'+sfx+' a').data('path', response.newdata).attr('data-path', response.newdata);
									$('td#name-'+sfx+' a').attr('href', response.url);
									$('td#name-'+sfx+' a span').text(response.newname);
								}
								$('a#rename-'+sfx).fadeIn(1000);
								$('a#delete-'+sfx).fadeIn(1000);
								$('td#name-'+sfx+' a').fadeIn(1000);
							}
						);					
						return false;
					}
				});												
				// End Directory Rename Function
				// Primary Table Row Each Function
				$('table.mngr-table tr[id^=ssfa-file-]').each(function(){
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
							var ext = $('td#filetype-'+sfx+' input'),
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
							var faflcheck = (($fafl && String(filepath.val()).indexOf($fafl) >= 0) || !$fafl) ? false : true;
							var fauicheck = (($faui && String(filepath.val()).indexOf($faui) >= 0) || !$faui) ? false : true;
							var fauncheck = (($faun && String(filepath.val()).indexOf($faun) >= 0) || !$faun) ? false : true;
							var faurcheck = (($faur && String(filepath.val()).indexOf($faur) >= 0) || !$faur) ? false : true;					
							if(String(filepath.val()).indexOf('..') >= 0 || filepath.val() === '/' || faflcheck || fauicheck || faurcheck || fauncheck){
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
										$loading2.hide();								
										filertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
										filertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
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
						var ext = $('td#filetype-'+sfx+' input'),
							oldname = $('input#oldname-'+sfx),
							filepath = $('input#filepath-'+sfx);
						del.fadeOut(500);
						rename.fadeOut(500);				
						if(! $('a#canceldel-'+sfx).length) manager.prepend("<a href='' id='canceldel-"+sfx+"' style='display:none;'>Cancel</a>")
						if(! $('a#proceed-'+sfx).length) manager.prepend("<a href='' id='proceed-"+sfx+"' style='display:none;'>Proceed<br></a>")
						if(! $('span#confirm-'+sfx).length) manager.prepend("<span id='confirm-"+sfx+"' style='display:none;'>Delete?<br></span>")				
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
							var faflcheck = (($fafl && String(filepath.val()).indexOf($fafl) >= 0) || !$fafl) ? false : true;
							var fauicheck = (($faui && String(filepath.val()).indexOf($faui) >= 0) || !$faui) ? false : true;
							var fauncheck = (($faun && String(filepath.val()).indexOf($faun) >= 0) || !$faun) ? false : true;
							var faurcheck = (($faur && String(filepath.val()).indexOf($faur) >= 0) || !$faur) ? false : true;			
							if (filepath.val().indexOf('..') >= 0 || filepath.val() === '/' || faflcheck || fauicheck || faurcheck || fauncheck){
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
										$loading2.hide();								
										filertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
										filertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function(e){
											if(e){
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
										} else { filertify.set({labels:{ok : "OK" }}); filertify.alert(response) }
									}
								);
								return false;
							}
						});
					}); // End Delete Function (Single)
					// Bulk Action Toggle Selected Files
					$(this).on('click', function(){
						if ($('a#ssfa-bulk-action-toggle').text() === 'Enabled') {
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
						$checkall = $('input#ssfa-bulk-action-select-all');
						$selectall = $('label#ssfa-select-all');
						$selectall.fadeIn('1000');				
						$checkall.fadeIn('1000');								
						// Bulk Action Select All Function
						$checkall.on('change', function(){
							$selectall = $('label#ssfa-select-all span');
							if(this.checked){
								$selectall.text('Clear All');
								$('table.mngr-table tr[id^=ssfa-file-]').addClass('ssfa-selected');
							}else{
								$selectall.text('Select All');
								$('table.mngr-table tr[id^=ssfa-file-]').removeClass('ssfa-selected');							
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
						$selectall = $('label#ssfa-select-all span');
						$selectall.text('Select All');
						$('select#ssfa-bulk-action-select').find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('liszt:updated');
						$('table.mngr-table tr[id^=ssfa-file-]').each(function(){
							if($(this).hasClass('ssfa-selected')) $(this).removeClass('ssfa-selected');
						});
					}
				}); // End Bulk Action Toggle Function
				// Bulk Action Select Function
				$('select#ssfa-bulk-action-select').on('change', function(){
					var actionselected = this.value;
					var pathcontainer = $('div#ssfa-path-container');
					var pathselect = $('select#ssfa-bulk-action-select');
					if (actionselected == '' || actionselected == 'delete' || actionselected == 'download') pathcontainer.fadeOut(1000);
					else pathcontainer.fadeIn(1000);
				}); // End Bulk Action Select Function
				// Bulk Action Engage Function
				$('span#ssfa-bulk-action-engage').on('click', function(){
					/*if(window.name !== '' && window.name !== 'new' && window.name !== 'blank' && window.name !== '_new'){ 
						$name = window.name;
						$('html, body', window.top.document).animate({
					        scrollTop: $("div#"+$name, window.top.document).offset().top -75
						}, 500);
					}*/
					var selectedAction = $('select#ssfa-bulk-action-select').val();
					var selectedPath = String($('input#ssfa-nomenclature').val());
					var badmotor = String($('input#ssfa-bad-motivator').val());
					var selectedFilesFrom = '';
					var selectedFilesTo = '';
					var selectedExts = '';
					var selectedCount = 0;
					var messages = '';
					var jackoff = 0;
					if(selectedAction !== 'delete' && selectedAction !== 'download'){
						if($fafl) var faflcheck = selectedPath.indexOf($fafl) >= 0 && badmotor.indexOf($fafl) >= 0 ? false : true;
						if($faui) var fauicheck = selectedPath.indexOf($faui) >= 0 && badmotor.indexOf($faui) >= 0 ? false : true;
						if($faun) var fauncheck = selectedPath.indexOf($faun) >= 0 && badmotor.indexOf($faun) >= 0 ? false : true;
						if($faur) var faurcheck = selectedPath.indexOf($faur) >= 0 && badmotor.indexOf($faur) >= 0 ? false : true;
					}
					else if(selectedAction === 'delete' || selectedAction === 'download'){
						if($fafl) var faflcheck = badmotor.indexOf($fafl) >= 0 ? false : true;
						if($faui) var fauicheck = badmotor.indexOf($faui) >= 0 ? false : true;
						if($faun) var fauncheck = badmotor.indexOf($faun) >= 0 ? false : true;
						if($faur) var faurcheck = badmotor.indexOf($faur) >= 0 ? false : true;
					}
					if (selectedPath.indexOf('..') >= 0 || $('input#ssfa-bad-motivator').val().indexOf('..') >= 0) jackoff = 1;
					if (selectedPath === '/' || $('input#ssfa-bad-motivator').val() === '/') jackoff = 1;			
					$('table.mngr-table tr.ssfa-selected').each(function(index){
						var sfx = this.id;
						var filepath = String($('input#filepath-'+sfx).val());
						var oldname = $('input#oldname-'+sfx).val();
						var	ext = $('td#filetype-'+sfx+' input').val();
						if (filepath.indexOf('..') >= 0 || filepath === '/') jackoff = 1;
						selectedFilesFrom += $bm+'/'+oldname+'.'+ext+'/*//*/';
						selectedFilesTo += selectedPath+'/'+oldname+'.'+ext+'/*//*/';
						selectedExts += ext+'/*//*/';
						selectedCount++;
					});
					if (jackoff == 1 || faflcheck || fauicheck || faurcheck || fauncheck){
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
								$loading2.hide();								
								filertify.set({labels:{ok : "Yes I Do", cancel : "Huh?" }});
								filertify.confirm("Think you're a clever bastard? <a href='"+response+"' target='_top'>Get more info here.</a>", function (e) {
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
						if(selectedCount == 0) messages += 'No files have been selected. Click on the table rows of the files you wish to select.<br>';
						if((selectedAction == 'move' || selectedAction == 'copy') && selectedPath == '') messages += 'No destination directory has been selected.<br>';
						if(messages !== ''){ filertify.set({labels:{ok : "OK" }}); filertify.alert(messages); }
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
										$loading2.hide();								
										filertify.set({labels:{ok : "OK" }});
										filertify.alert(response);
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
										$loading2.hide();								
										filertify.set({labels:{ok : "OK" }});
										filertify.alert(response);
										$('tr.ssfa-selected').each(function(){
											$(this).fadeOut(2000).queue( function(next){
												$(this).remove(); next();
											});
										});
									}
								);
							} // End Bulk Action Move Function
							// Bulk Action Download Function
							else if (selectedAction == 'download'){
								$loading2.show();
								$.post(
									SSFA_FM_Ajax.ajaxurl,
									{
										action : 'ajax-ssfa-file-manager',
										dataType : 'html',	
										act : 'bulkdownload',
										files : selectedFilesFrom,
										exts : selectedExts,
										nextNonce : SSFA_FM_Ajax.nextNonce						
									},
									function( response ) {
										$loading2.hide();								
										if(response === 'Error'){ 
											filertify.set({labels:{ok : "OK" }});
											filertify.alert(response);
										}else{
											$('<iframe src="'+response+'" id="fa-bulkdownload" style="visibility:hidden;" name="fa-bulkdownload">').appendTo('body');	
										}
									}
								);
							} // End Bulk Action Download Function
							// Bulk Action Delete Function
							else if (selectedAction == 'delete'){
								var numfiles = selectedCount > 1 ? 'files' : 'file'; 
								filertify.set({labels:{ok : "OK", cancel : "Not OK" }});
								filertify.confirm("You are about to permanently delete "+selectedCount+" "+numfiles+". Press OK if you're OK with that.", function(e){
									if(e){
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
												$loading2.hide();								
												filertify.set({labels:{ok : "OK" }});
												filertify.alert(response);
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
								uploadaction : 'false',
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
						return false;
					}
				});				
			});
		})(jQuery); // End Bulk Action Path Generator Function
		// Bulk Action Path Generator Function (Breadcrumbs)
		(function($){
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
									uploadaction : 'false', 
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
	} // End Manager Check
}); 
// File Up
jQuery(document).ready(function($){
	if ($('div.ssfa_fileup_container').length){
		// Remove File On Click
		function fileupRemove(id, filename){
			if($("span#ssfa_rf input#"+id).length){}else $("span#ssfa_rf").append('<input type="hidden" id="'+id+'" value="'+id+'">');
			$("tr#ssfa_upfile_id_"+id).fadeOut(1000).queue(function(){
				$(this).remove();
				$("div.ssfa_fileup_files_container table#ssfa-table tbody").change();
				if($("div.ssfa_fileup_files_container table#ssfa-table tbody").children('tr').length){} 
				else $("div.ssfa_fileup_files_container table#ssfa-table").remove();
			});
		}
		// FileUp Class
		function FileUp(config){
			this.settings = config; this.file = ""; this.browsed_files = []; var self = this;
			var msg = "Your browser does not support the File Upload API. Please update.";
			FileUp.prototype.fileupDisplay = function(value){
				this.file = value;
				if(this.file.length > 0){
					$("div.ssfa_fileup_files_container").html(''); $("span#ssfa_rf").html(''); this.settings.removed = [];
					var selectedDisplayed = file_id = '<div id="'+this.settings.container+'" class="ssfa-meta-container">'+
						'<div id="ssfa-table-wrap" style="margin: 10px 0 0;">'
							+'<table id="ssfa-table" class="footable ssfa-sortable ssfa-'+this.settings.table+' ssfa-center"><tbody>';
	 				var path = this.settings.fixed ? this.settings.fixed : String($('input#ssfa-upnomenclature').val());
					var jackoff = path.indexOf('..') >= 0 || path === '/' ? true : false;
					var allowedchars = this.settings.fixed ? "~!@#$%^&()_+`-={}[]'," : "~!@#$%^&()_+`-={}[]',/";
					for(var i = 0; i<this.file.length; i++){
						file_id = self.uid(this.file[i].name);
						var rawname = this.file[i].name.substr(0, this.file[i].name.lastIndexOf('.')) || this.file[i].name,
							icon_ext = self.ext(this.file[i].name, true),
							extension = self.ext(this.file[i].name, false),
							color = this.settings.iconcolor === 'random' ? self.randcolor() : this.settings.iconcolor,
							permitted = this.settings.permitted ? ($.inArray(icon_ext.toString(), this.settings.permitted) != -1 ? false : true) : false,
							prohibited = this.settings.prohibited ? ($.inArray(icon_ext.toString(), this.settings.prohibited) != -1 ? true : false) : false,
							fileSize = (this.file[i].size / 1024),
							tooBig = this.file[i].size > this.settings.maxsize ? true : false,
							warningclass = tooBig || permitted || prohibited ? ' ssfa-fileup-warning' : '',
							pretty_max = self.nicesize(this.settings.maxsize  / 1024),
							sizenotice = tooBig ? '<br><span class="'+warningclass+'">This file exceeds the '+pretty_max+' max file size.</span>' : '',
							pernotice = permitted ? '<br><span class="'+warningclass+'">This file type is not permitted. '+
								'<a href="javascript:" onclick="filertify.alert(\''+this.settings.permitted.join(', ')+'\');">View all</a> permitted file types.</span>' : '',
							pronotice = prohibited ? '<br><span class="'+warningclass+'">This file type is not permitted. '+
								'<a href="javascript:" onclick="filertify.alert(\''+this.settings.prohibited.join(', ')+'\');">View all</a> prohibited file types.</span>' : '',
							readonly = tooBig || permitted || prohibited || jackoff ? ' readonly=readonly' : '',
							file_icon = tooBig || permitted || prohibited || jackoff ? self.icon('denied') : self.icon(icon_ext.toString(), color),
							cancel_color = tooBig || permitted || prohibited ? 'red' : 'silver',
							not_defined = false;
						if(tooBig || permitted || prohibited || not_defined || jackoff){
							$("span#ssfa_rf").append('<input type="hidden" id="'+file_id+'" value="'+file_id+'">');
							this.settings.removed[i] = file_id;
						}
						if(typeof this.file[i] !== undefined && this.file[i].name !== ''){
							selectedDisplayed += 
								'<tr id="ssfa_upfile_id_'+file_id+'" style="display: table-row;">'+
									'<td id="ssfa-upfile_type" class="ssfa-sorttype ssfa-'+this.settings.table+'-first-column">'+
										file_icon+'<br>'+extension+
									'</td>'+
									'<td id="ssfa-upfile_name" class="ssfa-sortname">'+
										'<div class="ssfa-upload-input-container">'+
											'<div class="ssfa-upload-progress ssfa-up-progress-'+color+'" id="ssfa_upload_progress_id_'+file_id+'"></div>'+	
											'<input type="text" class="rename_ssfa_upfile" id="rename_ssfa_upfile_id_'+file_id+'" value="'+rawname+'"'+readonly+'>'+
										'</div>'+
										sizenotice+pernotice+pronotice+
									'</td>'+
									'<td id="ssfa-upfile_size" class="ssfa-sortsize">'+
										'<span class="ssfa-filesize'+warningclass+'">'+self.nicesize(fileSize)+'</span>'+
									'</td>'+
									'<td id="ssfa_upfile_status_'+file_id+'" class="ssfa-sortstatus">'+
										'<a id="ssfa_remove_if_'+file_id+'" href="javascript:" onclick="fileupRemove(\''+file_id+'\',\''+this.file[i].name+'\');">'+
											'<span class="ssfa-faminicon ssfa-'+cancel_color+' ssfa-icon-console-2"></span>'+
										'</a>'+
									'</td>'+
								'</tr>';							
						}else{ var not_defined = true; }
					}
					selectedDisplayed += "</tbody></table></div></div>";
					$("div.ssfa_fileup_files_container").append(selectedDisplayed);
					$('input[id^="rename_ssfa_upfile_id_"]').alphanum({allow : allowedchars});
					if(jackoff){ 
						filertify.set({labels:{ok : "OK" }}); 
						filertify.alert('An error has been triggered. Please call 1 (800) 382-5968 for support.'); $("div.ssfa_fileup_files_container").html(''); 
					}
				}
			}
			// Create Unique ID
			FileUp.prototype.uid = function(name){
				return name.replace(/[^a-z0-9\s]/gi, '_').replace(/[_\s]/g, '_');
			}			
			// Get File Extension
			FileUp.prototype.ext = function(file, lowercase){
				return (/[.]/.exec(file)) ? (lowercase ? /[^.]+$/.exec(file.toLowerCase()) : /[^.]+$/.exec(file)) : '';
			}
			// Format File Size
			FileUp.prototype.nicesize = function(fileSize){
				if(fileSize / 1024 > 1){
					if(((fileSize / 1024) / 1024) > 1){
						fileSize = (Math.round(((fileSize / 1024) / 1024) * 100) / 100);
						var niceSize = fileSize + " GB";
					}else{
						fileSize = (Math.round((fileSize / 1024) * 100) / 100)
						var niceSize = fileSize + " MB";
					}
				 }else{
					fileSize = (Math.round(fileSize * 100) / 100)
					var niceSize = fileSize  + " KB";
				}
				return niceSize;
			}
			// Get Random Color
			FileUp.prototype.randcolor = function(){
				array = ["red","green","blue","brown","black","orange","silver","purple","pink"];
				return array[Math.floor(Math.random() * array.length)];
			}
			// Attribute FileType Icons
			FileUp.prototype.icon = function(icon_ext, color){
				if($.inArray(icon_ext, ssfa_filetype_groups.image) != -1){ file_icon = ssfa_filetype_icons.image; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.adobe) != -1){ file_icon = ssfa_filetype_icons.adobe; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.audio) != -1){ file_icon = ssfa_filetype_icons.audio; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.video) != -1){ file_icon = ssfa_filetype_icons.video; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.msdoc) != -1){ file_icon = ssfa_filetype_icons.msdoc; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.msexcel) != -1){ file_icon = ssfa_filetype_icons.msexcel; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.powerpoint) != -1){ file_icon = ssfa_filetype_icons.powerpoint; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.openoffice) != -1){ file_icon = ssfa_filetype_icons.openoffice; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.text) != -1){ file_icon = ssfa_filetype_icons.text; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.compression) != -1){ file_icon = ssfa_filetype_icons.compression; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.application) != -1){ file_icon = ssfa_filetype_icons.application; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.script) != -1){ file_icon = ssfa_filetype_icons.script; }
				else if($.inArray(icon_ext, ssfa_filetype_groups.css) != -1){ file_icon = ssfa_filetype_icons.css; }
				else if(icon_ext === 'denied'){ file_icon = '<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span>'; }
				else{ file_icon = ssfa_filetype_icons.unknown; }
				file_icon = (icon_ext === 'denied' ? file_icon : 
					'<span data-ssfa-icon="'+file_icon+'" class="ssfa-faminicon ssfa-'+color+'" aria-hidden="true"></span>');
				return file_icon;
			}
			//File Reader
			FileUp.prototype.read = function(e) {
				if(e.target.files) {
					self.fileupDisplay(e.target.files);
					self.browsed_files.push(e.target.files);
				} else {
					filertify.set({labels:{ok : "OK" }});
					filertify.alert('Sorry, a file you have specified could not be read.');
				}
			}
			function addEvent(type, el, fn){
				if (window.addEventListener){
					el.addEventListener(type, fn, false);
				} else if (window.attachEvent){
					var f = function(){
					  fn.call(el, window.event);
					};			
					el.attachEvent('on' + type, f)
				}
			}
			// Collect File IDs and Initiate Upload for Submit
			FileUp.prototype.starter = function() {
				if (window.File && window.FileReader && window.FileList && window.Blob) { // Safari Does Not Support FileReader API and cannot read file sizes
					var browsed_file_id = $('#'+this.settings.form_id).find('input[type="file"]').eq(0).attr('id');
					document.getElementById(browsed_file_id).addEventListener('change', this.read, false);
					document.getElementById('ssfa_submit_upload').addEventListener('click', this.submit, true);
				} 
				else { filertify.set({labels:{ok : "OK" }}); filertify.alert(msg); $('div.ssfa_fileup_container').remove(); }
			}
			// Begin Upload on Click
			FileUp.prototype.submit = function(){ self.begin(); }
			// Initiate Upload Iterator
			FileUp.prototype.begin = function() {
				if(!this.settings.fixed && $('input#ssfa-upnomenclature').val() === ''){
					filertify.set({labels:{ok : "OK" }});
					filertify.alert('Please build the path to your destination directory.');	
				}else if(this.browsed_files.length > 0){
					for(var k=0; k<this.browsed_files.length; k++){
						var file = this.browsed_files[k];
						this.fileupAjax(file,k);
					}
					this.browsed_files = [];
				}else{
					filertify.set({labels:{ok : "OK" }});
					filertify.alert('No files have been chosen.');
				}
			}
			// Ajax Upload
			FileUp.prototype.fileupAjax = function(file,i){
				if(file[i] !== undefined && file[i] !== '' && file[i] !== "undefined" ){
					if(file[i]!== undefined){
						var id = file_id = self.uid(file[i].name),
							rawname = file[i].name.substr(0, file[i].name.lastIndexOf('.')) || file[i].name,
							extension = self.ext(file[i].name, false),
							browsed_file_id = $("#"+this.settings.form_id).find("input[type='file']").eq(0).attr("id"),
							path = this.settings.fixed ? this.settings.fixed : String($('input#ssfa-upnomenclature').val()),
							start = $('input#ssfa-upwhymenclature').val(),
							removed_file = $("#"+id).val(),
							newname = String($('input#rename_ssfa_upfile_id_'+id).val()),
							new_name = newname === '' || newname === 'undefined' || newname === undefined ? file[i].name : newname+'.'+extension,
							removed = this.settings.removed,
							loading = this.settings.loading,
							fixedchars = this.settings.fixed;
						if(newname === '' || newname === 'undefined' || newname === undefined) $('input#rename_ssfa_upfile_id_'+id).val(rawname)
						if(removed_file !== '' && removed_file !== undefined && removed_file == id) self.fileupAjax(file,i+1); 
						else{
							var fileupData = new FormData();
							fileupData.append('upload_file',file[i]);
							fileupData.append('upload_file_id',id);
							fileupData.append('max_file_size',this.settings.maxsize);
							fileupData.append('upload_path',path);	
							fileupData.append('new_name',new_name);
							fileupData.append('act','upload'),
							fileupData.append('nextNonce',SSFA_FM_Ajax.nextNonce);
							$.ajax({
								type		: 'POST',
								url			: SSFA_FM_Ajax.ajaxurl+'?action=ajax-ssfa-file-manager',
								data		: fileupData,
								id			: id,
								new_name	: new_name,
								rawname		: rawname,
								extension	: extension,
								path		: path,
								start		: start,
								removed		: removed,
								loading		: loading,
								fixedchars	: fixedchars,
								cache		: false,
								contentType	: false,
								processData	: false,
								beforeSend	: function(xhr, settings){
									$("#ssfa_upfile_status_"+id)
										.html('<span class="ssfa-faminicon ssfa-silver ssfa-icon-denied"></span>');
									var newpath = settings.new_name.substring(0, settings.new_name.lastIndexOf("/") + 1),
										jackoff = false,
										message = '';
									if(''+newpath.indexOf('..') >= 0 || settings.path.indexOf('..') >= 0 || settings.path === '/'){ 
										jackoff = true; 
										message = '<br>You may not use double dots or attempt to override the upload directory.'
									}
									if(!jackoff && $.inArray(settings.id, settings.removed) != -1) jackoff = true; 
									if(!jackoff && settings.fixedchars && settings.new_name.indexOf('/') >= 0){ 
										jackoff = true; 
										message = '<br>Sub-directory creation is disabled.';
									}
									if(!jackoff && settings.path.indexOf(settings.start) < 0){
										jackoff = true; 
										message = '<br>You may not attempt to override the upload directory.'
									}
									if(!jackoff && settings.new_name.indexOf('..') >= 0){ 
										jackoff = true;
										message = '<br>You may not use double dots in the filename.'
									}
									if(!jackoff){
										var pop = settings.rawname.substring(settings.rawname.lastIndexOf(".") + 1, settings.rawname.length);	
										if($.inArray(pop, ssfa_filetype_groups.script) != -1){ 
											if($.inArray(settings.extension.toString(), ssfa_filetype_groups.script) == -1 
											&& $.inArray(settings.extension.toString(), ssfa_filetype_groups.css) == -1) 
												jackoff = true; 
												message = '<br>You may not specify a script filetype prior to a non-script filetype.'
										}
									}
									if(jackoff){
										$('tr#ssfa_upfile_id_'+settings.id+' td#ssfa-upfile_type')
											.html('<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span><br>'+settings.extension);
										$('td#ssfa_upfile_status_'+settings.id)
											.html('<a id="ssfa_remove_if_'+file_id+'" href="javascript:" onclick="fileupRemove(\''
											+settings.id+'\',\''+settings.rawname+'.'+settings.extension									
											+'\');"><span class="ssfa-faminicon ssfa-red ssfa-icon-console-2"></span></a>');
										$('tr#ssfa_upfile_id_'+settings.id+' td#ssfa-upfile_name')
											.append('<br><span class="ssfa-fileup-warning">Sorry about that, but '+settings.rawname+'.'
												+settings.extension+' could not be uploaded.'+message+'</span>');
										if(i+1 < file.length) self.fileupAjax(file,i+1); 
										xhr.abort();
									}
								},
								xhr: function(){
									var xhr = new window.XMLHttpRequest();
									xhr.upload.addEventListener("progress", function(evt){
										if(evt.lengthComputable){
											var percentComplete = evt.loaded / evt.total;
											$('div#ssfa_upload_progress_id_'+id).width((percentComplete * 100) + '%');
										}
									}, false);
									return xhr;
								},
								success		: function(response){
									setTimeout(function(){
										if(response.indexOf(id) != -1){
											$("#ssfa_upfile_status_"+id)
												.html('<span class="ssfa-faminicon ssfa-green ssfa-icon-inbox"></span>');
											$("#ssfa_upfile_id_"+id).delay(500).fadeOut(1000).queue(function(){
												$(this).remove(); 
												$("div.ssfa_fileup_files_container table#ssfa-table tbody").change();
												if($("div.ssfa_fileup_files_container table#ssfa-table tbody").children('tr').length){} 
												else $("div.ssfa_fileup_files_container table#ssfa-table").remove();
											});
										}else{
											$('tr#ssfa_upfile_id_'+id+' td#ssfa-upfile_type')
												.html('<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span><br>'+extension);
											$('td#ssfa_upfile_status_'+id)
												.html('<a id="ssfa_remove_if_'+file_id+'" href="javascript:" onclick="fileupRemove(\''+id+'\',\''+rawname+'.'+extension									
												+'\');"><span class="ssfa-faminicon ssfa-red ssfa-icon-console-2"></span></a>');
											$('tr#ssfa_upfile_id_'+id+' td#ssfa-upfile_name')
												.append('<br><span class="ssfa-fileup-warning">Sorry about that, but '+rawname+'.'+extension+' could not be uploaded.</span>');
										}
										if(i+1 < file.length) self.fileupAjax(file,i+1); 
									},500);
								}
							});
						 }
					} 
				}else{ /* filertify.alert('Sorry, not gonna happen.'); */ }
			}	
			this.starter();
		}
		window.FileUp = FileUp;
		window.fileupRemove = fileupRemove;
		// Upload Path Generator Function
		(function($) {
			$(document).ready(function(){
				$('select#ssfa-fileup-directories-select').chozed({
					allow_single_deselect:false, 
					width: '200px', 
					inherit_select_classes:true,
					no_results_text: "Ain't no thang",
					search_contains: true 
				});
				$loading = $('img#ssfa-fileup-action-ajax-loading');
				$st = $('input#ssfa-upyesmenclature').val();
				$sht = $('input#ssfa-upwhymenclature').val();		
				$('select#ssfa-fileup-directories-select').on('change', function(){
					if($(this).val() !== ''){
						$loading.show();
						$.post(
							SSFA_FM_Ajax.ajaxurl,
							{
								action : 'ajax-ssfa-file-manager', 
								dataType : 'html', 
								act : 'getactionpath',
								uploadaction : 'true', 
								pp : this.value, 
								st : $st, 
								sht : $sht, 
								nextNonce : SSFA_FM_Ajax.nextNonce
							},
							function(response){
								$container = $('div#ssfa-fileup-path-container');
								$hp = $('input#ssfa-upnomenclature');
								$putpath = $('div#ssfa-fileup-action-path');
								$dropdown = $('select#ssfa-fileup-directories-select');
								$dropdown.empty().append(response.ops).trigger('chozed:updated').trigger('liszt:updated');
								$hp.val(response.pp);
								$putpath.html(response.crumbs).append($loading);
								$loading.hide();
								$('div#ssfa-fileup-action-path').change();
							}
						);
						return false;
					}
				});				
			});
		})(jQuery); // End Upload Path Generator Function
		// Upload Path Generator Function (Breadcrumbs)
		(function($){
			$(document).ready(function(){
				$stt = $('input#ssfa-upyesmenclature').val();
				$sht = $('input#ssfa-upwhymenclature').val();		
				$loading = $('img#ssfa-fileup-action-ajax-loading');
				$('div#ssfa-fileup-action-path').change(function(){
					$('a[id^=ssfa-fileup-action-pathpart-]').each(function(){
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
									uploadaction : 'true', 
									pp : data,
									st : $stt,					
									sht : $sht,							
									nextNonce : SSFA_FM_Ajax.nextNonce						
								},
								function( response ) {
									$container = $('div#ssfa-fileup-path-container');
									$hp = $('input#ssfa-upnomenclature');
									$putpath = $('div#ssfa-fileup-action-path');
									$dropdown = $('select#ssfa-fileup-directories-select');
									$dropdown.empty().append(response.ops).trigger('chozed:updated').trigger('liszt:updated');
									$hp.val(response.pp);
									$putpath.html(response.crumbs).append($loading);
									$loading.hide();
									$('div#ssfa-fileup-action-path').change();
								}
							);
							return false;  
						});	
					});	
				});
			});
		})(jQuery); // End Upload Path Generator Function (Breadcrumbs)		
	}
});