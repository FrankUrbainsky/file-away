jQuery(document).ready(function($)
{
	// Bulk Download Check
	if($('span[id^=ssfa-bulk-download-engage]').length)
	{
		// Cache the Data on DOM Ready
		$('table.bd-table tr[id^=ssfa-file-]').each(function()
		{
			$sfx = this.id;
			$type = $('td#filetype-'+$sfx).data('ext');
			$path = $('td#filename-'+$sfx).data('path');
			$name = $('td#filename-'+$sfx).data('name');
		});
		// Bulk Download Select All Function
		$checkall = $('input[id^="ssfa-bulk-download-select-all-"]');
		$checkall.on('change', function()
		{
			$uid = this.id;
			$uid = $uid.replace('ssfa-bulk-download-select-all-', '');
			$selectalltext = $(this).data('selectall');
			$clearalltext = $(this).data('clearall');
			$selectall = $('label#ssfa-bulkdownload-select-all-'+$uid);
			if(this.checked)
			{
				$selectall.text($clearalltext);
				$('table.bd-table tr[id^=ssfa-file-'+$uid+']').addClass('ssfabd-selected');
			}
			else
			{
				$selectall.text($selectalltext);
				$('table.bd-table tr[id^=ssfa-file-'+$uid+']').removeClass('ssfabd-selected');							
			}
		});
		// Bulk Download Toggle Selected Files
		$('table.bd-table tr[id^=ssfa-file-]').each(function()
		{
			$('a', this).on('click', function(e)
			{
				e.stopPropagation();
			});
			$(this).on('click', function()
			{
				if($(this).hasClass('ssfabd-selected')) $(this).removeClass('ssfabd-selected');	
				else $(this).addClass('ssfabd-selected');						
			}); 
		}); 	
		// Bulk Download Engage Function
		$('span[id^="ssfa-bulk-download-engage-"]').on('click', function()
		{
			$uid = this.id;
			$uid = $uid.replace('ssfa-bulk-download-engage-', '');
			$loading = $('img#ssfa-engage-ajax-loading-'+$uid);
			var selectedFilesFrom = {};
			var selectedCount = 0;
			var messages = '';
			var jackoff = false;
			$('table.bd-table tr[id^=ssfa-file-'+$uid+']').each(function(index)
			{
				if($(this).hasClass('ssfabd-selected'))
				{
					var sfx = this.id;
					var filepath = String($('td#filename-'+sfx).data('path'));
					var oldname = String($('td#filename-'+sfx).data('name'));
					var	ext = String($('td#filetype-'+sfx).data('ext'));
					if(oldname.indexOf('..') >= 0 || filepath.indexOf('..') >= 0 || filepath === '/') jackoff = true;
					else
					{
						selectedFilesFrom[index] = filepath+'/'+oldname+'.'+ext;
						selectedCount++;
					}
				}
			});
			if(jackoff)
			{
				filertify.set({labels:{ok : fileaway_mgmt.ok_label}});
				filertify.alert(fileaway_mgmt.tamper1);
			} 
			else 
			{			
				if(selectedCount == 0) 
					messages += fileaway_mgmt.no_files_selected+'<br>';
				if(messages !== '')
				{ 
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
					filertify.alert(messages) 
				}
				else 
				{
					// Ajax Bulk Action Download Function
					$loading.show();
					$.post(
						fileaway_mgmt.ajaxurl,
						{
							action : 'fileaway-manager',
							dataType : 'html',	
							act : 'bulkdownload',
							files : selectedFilesFrom,
							nonce : fileaway_mgmt.nonce						
						},
						function(response)
						{
							$loading.hide();		
							if(response == 'Error')
							{ 
								filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
								filertify.alert(response); 
							}
							else 
							{
								$('<iframe src="'+response+'" id="fa-bulkdownload" style="visibility:hidden;" name="fa-bulkdownload">').appendTo('body');	
							}
						}
					) // End Ajax Bulk Action Download Function
				}
			}
		}); // End Bulk Download Engage Function
	} // End Bulk Download Check
}); 
jQuery(document).ready(function($)
{
	// Manager Check
	if($('th.ssfa-manager').length)
	{
		// Multi-Manager Check
		$i = 0;
		$('th.ssfa-manager').each(function()
		{
			$i++;
			if($i > 1) $(this).parents('div:eq(1)').remove();
		});
		if($i > 1)
		{ 
			filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
			filertify.alert('Warning: You have multiple Manager Mode tables on the same page. If you need to have more than one Manager Mode table on the same page, to avoid them interfering with one another you need to use the File Away iframe shortcode. See the Tutorials for instructions. In the meantime, for your security, File Away has removed all but the first Manager Mode table from the page.');
		}
		// Cache the Data on DOM Ready
		$('table.mngr-table').each(function()
		{
			$uid = $(this).data('uid');
			$page = $(this).data('pg');
			$drawer = $(this).data('drw');
			$class = $(this).data('cls');
			$basename = $(this).data('basename');
			$start = $(this).data('start');
			$dir = $(this).data('dir');
			$base = $(this).data('base');
			$basedir = $(this).data('basedir');
			$fafl = $(this).data('fafl');
			$faui = $(this).data('faui');
			$faun = $(this).data('faun');
			$faur = $(this).data('faur');
		});
		$('table.mngr-table tr[id^=ssfa-dir-]').each(function()
		{
			$sfx = this.id;
			$path = $('td#folder-'+$sfx+' a').data('path');
			$name = $('td#folder-'+$sfx+' a').data('name');			
		});
		$('table.mngr-table tr[id^=ssfa-file-]').each(function()
		{
			$sfx = this.id;
			$type = $('td#filetype-'+$sfx).data('ext');
			$path = $('td#filename-'+$sfx).data('path');
			$name = $('td#filename-'+$sfx).data('name');
		});
		// Allowed Characters Settings
		$('table[id^="ssfa-table-"] tbody tr[id^="ssfa-file-"] input').alphanum({allow : "~!@#$%^&()_+`-={}[]',"});
		$('table[id^="ssfa-table-"] tbody tr[id^="row-ssfa-create-dir-"] input').alphanum({allow : "~!@#$%/^&()_+`-={}[]',"});
		$('table[id^="ssfa-table-"] tbody tr[id^="ssfa-dir-"] input').alphanum({allow : "~!@#$%^&()_+`-={}[]',"});
		// Initialize Chosen Select
		$('select.ssfa-directories-select, select.ssfa-bulk-action-select').chozed({
			allow_single_deselect:true, 
			width: '150px', 
			inherit_select_classes:true,
			no_results_text: fileaway_mgmt.no_results,
			search_contains: true 
		});
		// Create Dir
		$('body').on('click', 'a[id^="ssfa-create-dir-"]', function(ev)
		{
			ev.preventDefault();
			var sfx = this.id,
				createinput = $('input#input-'+sfx),
				manager = $('td#manager-'+sfx);
			if($(createinput).is(':visible')){}
			else
			{
				createinput.fadeIn(1000).focus();
				manager.html("<a href='javascript:' id='save-"+sfx+"' style='display:none;'>"+fileaway_mgmt.save_link+"</a><br>"+
					"<a href='javascript:' id='cancel-"+sfx+"' style='display:none;'>"+fileaway_mgmt.cancel_link+"</a>")
				var save = $('a#save-'+sfx),
					cancel = $('a#cancel-'+sfx);
				save.delay(500).fadeIn(500);
				cancel.delay(500).fadeIn(500);
			}
		});
		$('body').on('click', 'a[id^="cancel-ssfa-create-dir-"]', function(ev)
		{	
			ev.preventDefault();
			var sfx = this.id.replace('cancel-',''),
				save = $('a#save-'+sfx),
				createinput = $('input#input-'+sfx);
			save.fadeOut(500);
			$(this).fadeOut(500);
			createinput.fadeOut(500).val('');
		});
		$('body').on('click', 'a[id^="save-ssfa-create-dir"]', function(ev)
		{
			ev.preventDefault();
			var sfx = this.id.replace('save-',''),
				cancel = $('a#cancel-'+sfx),
				createinput = $('input#input-'+sfx);
			$newsub = createinput.val();
			if($newsub === '')
			{
				filertify.set({labels:{ok : fileaway_mgmt.ok_label}});
				filertify.alert(fileaway_mgmt.no_subdir_name);
			}
			else
			{
				$(this).fadeOut(500);
				cancel.fadeOut(500);
				createinput.fadeOut(500).val('');					
				var uid = sfx.replace('ssfa-create-dir-','');
				var count = $('table.mngr-table tr[id^=ssfa-dir-]').length;
				var cells = $(this).parents('tr').children('td').length;
				var cls = $(this).parents('table').eq(0).data('cls');
				var page = $(this).parents('table').eq(0).data('pg');
				var drawer = $(this).parents('table').eq(0).data('drw');
				var dir = String($(this).parents('table').eq(0).data('dir'));
				var base = String($(this).parents('table').eq(0).data('base'));
				$.post
				(
					fileaway_mgmt.ajaxurl,
					{
						action : 'fileaway-manager',
						dataType : 'html',	
						act : 'createdir',
						newsub : $newsub,
						parents : dir,
						base : base,
						uid : uid,
						count : (+count+1),
						cells : (+cells-2),
						cls : cls,
						pg : page,
						drawer : drawer,
						nonce : fileaway_mgmt.nonce
					},
					function(response)
					{
						if(response.status === 'error')
						{
							filertify.set({labels:{ok : fileaway_mgmt.ok_label}});
							filertify.alert(response.message);	
						}
						else if(response.status === 'success')
						{
							filertify.set({labels:{ok : fileaway_mgmt.ok_label}});
							filertify.alert(response.message);	
						}
						else if(response.status === 'insert')
						{
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
		$('body').on('click', 'a[id^="delete-ssfa-dir-"]', function(ev)
		{
			ev.preventDefault();
			var sfx = this.id.replace('delete-',''),
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				manager = $('td#manager-'+sfx);
			del.fadeOut(500);
			rename.fadeOut(500);				
			if(! $('a#canceldel-'+sfx).length) manager.prepend("<a href='javascript:' id='canceldel-"+sfx+"' style='display:none;'>"+fileaway_mgmt.cancel_link+"</a>")
			if(! $('a#proceed-'+sfx).length) manager.prepend("<a href='javascript:' id='proceed-"+sfx+"' style='display:none;'>"+fileaway_mgmt.proceed_link+"<br></a>")
			if(! $('span#confirm-'+sfx).length) manager.prepend("<span id='confirm-"+sfx+"' style='display:none;'>"+fileaway_mgmt.delete_check+"<br></span>")				
			var proceed = $('a#proceed-'+sfx),
				canceldel = $('a#canceldel-'+sfx),
				confirms = $('span#confirm-'+sfx);
			proceed.delay(500).fadeIn(500);
			canceldel.delay(500).fadeIn(500);						
			confirms.delay(500).fadeIn(500);										
			$subdir = $('td#folder-'+sfx+' a').data('name');
			var dir = String($(this).parents('table').eq(0).data('dir'));
			var base = String($(this).parents('table').eq(0).data('base'));
			$path1 = dir;
			$path2 = String($subdir);
			$(canceldel).on('click', function(ev)
			{
				ev.preventDefault();
				proceed.fadeOut(500);
				canceldel.fadeOut(500);
				confirms.fadeOut(500);					
				rename.delay(0).fadeIn(1000);
				del.delay(0).fadeIn(1000);					
			});
			$(proceed).on('click', function(ev)
			{
				ev.preventDefault();
				proceed.fadeOut(500);
				canceldel.fadeOut(500);
				confirms.fadeOut(500);					
				rename.delay(500).fadeIn(500);
				del.delay(500).fadeIn(500);		
				if($path1.indexOf('..') >= 0 || $path1 === '/' || $path1 === '' || !$path1 || $path1 === 'undefined' || $path1 === undefined)
				{
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
					filertify.alert(fileaway_mgmt.tamper2);
				}
				else if($path2.indexOf('..') >= 0 || $path2 === '/' || $path2 === '' || !$path2 || $path2 === 'undefined' || $path2 === undefined)
				{
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
					filertify.alert(fileaway_mgmt.tamper2);
				}
				else
				{
					$.post
					(
						fileaway_mgmt.ajaxurl,
						{
							action : 'fileaway-manager',
							dataType : 'html',	
							act : 'deletedir',
							status : 'life',
							path1 : $path1,
							path2 : $path2,
							nonce : fileaway_mgmt.nonce
						},
						function(response)
						{			
							if(response.status === 'error' || response.status === 'partial')
							{
								filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
								filertify.alert(response.message);	
							}
							else if(response.status === 'success')
							{
								filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
								filertify.alert(response.message);	
								$(del).parents('tr').fadeOut(2000).queue( function(next){ $(this).remove(); next();	});
							}
							else if(response.status === 'success-single')
							{
								$(del).parents('tr').fadeOut(2000).queue( function(next){ $(this).remove(); next();	});
							}
							else if(response.status === 'confirm')
							{
								filertify.set({labels:{ok : fileaway_mgmt.confirm_label, cancel : fileaway_mgmt.cancel_label }});
								filertify.confirm(response.message, function(e)
								{
									if(e)
									{
										$.post(
											fileaway_mgmt.ajaxurl,
											{
												action : 'fileaway-manager',
												dataType : 'html',	
												act : 'deletedir',
												status : 'death',
												path1 : $path1,
												path2 : $path2,
												nonce : fileaway_mgmt.nonce
											},
											function(response)
											{
												if(response.status === 'error' || response.status === 'partial')
												{
													filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
													filertify.alert(response.message);	
												}
												else if(response.status === 'success')
												{
													filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
													filertify.alert(response.message);	
													$(del).parents('tr').fadeOut(2000).queue( function(next){ $(this).remove(); next(); });
												}
											}
										);
										return false;
									}										
								});
							}
						}
					);
					return false;
				}
			}); 
		}); // End Delete Function (Directory Single) 
		// Directory Rename Function
		$('body').on('click', 'a[id^="rename-ssfa-dir-"]', function(ev)
		{
			ev.preventDefault();
			var sfx = this.id.replace('rename-', ''),
				del = $('a#delete-'+sfx),
				manager = $('td#manager-'+sfx),
				dirname = $('td#name-'+sfx+' a'),
				dirinput = $('input#rename-'+sfx);
			$subdir = $('td#folder-'+sfx+' a').data('path');
			$(this).fadeOut(500);
			del.fadeOut(500);
			if(!$('a#cancel-'+sfx).length) manager.prepend("<a href='' id='cancel-"+sfx+"' style='display:none;'>"+fileaway_mgmt.cancel_link+"</a>");
			if(!$('a#save-'+sfx).length) manager.prepend("<a href='' id='save-"+sfx+"' style='display:none;'>"+fileaway_mgmt.save_link+"<br></a>");
			var save = $('a#save-'+sfx),
				cancel = $('a#cancel-'+sfx);
			dirname.fadeOut(500);
			save.delay(500).fadeIn(500);
			cancel.delay(500).fadeIn(500);			
			dirinput.delay(500).fadeIn(500);
		});
		$('body').on('click', 'a[id^="cancel-ssfa-dir-"]', function(ev)
		{
			ev.preventDefault();
			var sfx = this.id.replace('cancel-', '');
			$('a#save-'+sfx).fadeOut(500);
			$(this).fadeOut(500);
			$('a#rename-'+sfx).delay(500).fadeIn(500);
			$('a#delete-'+sfx).delay(500).fadeIn(500);
			$('input#rename-'+sfx).fadeOut(500);
			$('td#name-'+sfx+' a').delay(500).fadeIn(500);
		});
		$('body').on('click', 'a[id^="save-ssfa-dir-"]', function(ev)
		{
			ev.preventDefault();				
			var sfx = this.id.replace('save-', '');
			$dir = String($(this).parents('table').eq(0).data('dir'));
			$base = String($(this).parents('table').eq(0).data('base'));
			$url = $('td#folder-'+sfx+' a');
			$url2 = $('td#name-'+sfx+' a');
			$subdir = $('td#folder-'+sfx+' a').data('path');
			$oldpath = $base+'/'+$subdir;
			$newname = String($('input#rename-'+sfx).val());
			$page = $(this).parents('table').eq(0).data('pg');
			$('a#save-'+sfx).fadeOut(500);
			$('a#cancel-'+sfx).fadeOut(500);
			$('input#rename-'+sfx).fadeOut(500);
			if($oldpath.indexOf('..') >= 0 || $oldpath === '/' || $newname.indexOf('..') >= 0 || $newname.indexOf('/') >= 0)
			{
				filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
				filertify.alert(fileaway_mgmt.tamper3);
			}
			else if($newname === '' || $newname === 'undefined' || $newname === undefined)
			{
				filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
				filertify.alert(fileaway_mgmt.no_subdir_name);
			}
			else
			{
				$.post
				(
					fileaway_mgmt.ajaxurl,
					{
						action : 'fileaway-manager',
						dataType : 'html',	
						act : 'renamedir',
						datapath : $subdir,
						oldpath : $oldpath,
						newname : $newname,
						parents : $dir,
						pg : $page,
						nonce : fileaway_mgmt.nonce
					},
					function(response)
					{ 
						if(response.status === 'error')
						{ 
							filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
							filertify.alert(response.message); 
						}
						else
						{
							$('td#name-'+sfx+' input').val(response.newname).attr('value', response.newname);
							$('td#folder-'+sfx).data('value', "# # # # # "+response.newname).attr('data-value', "# # # # # "+response.newname);
							$('td#name-'+sfx).data('value', "# # # # # "+response.newname).attr('data-value', "# # # # # "+response.newname);
							$('td#folder-'+sfx+' a').attr('href', response.url);
							$('td#folder-'+sfx+' a').data('path', response.newdata).attr('data-path', response.newdata);
							$('td#name-'+sfx+' a').attr('href', response.url);
							$('td#folder-'+sfx+' a').data('name', response.newname).attr('data-name', response.newname);
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
		// File Rename Function
		$('body').on('click', 'a[id^="rename-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();
			$id = this.id;
			var sfx = $id.replace('rename-', ''),
				uid = $(this).parents('table:eq(0)').data('uid'),
				rename = $(this),
				del = $('a#delete-'+sfx),
				filename = $('td#filename-'+sfx+' a'),
				rawname = $('input#rawname-'+sfx),
				manager = $('td#manager-'+sfx);
			if(!$('a#cancel-'+sfx).length) manager.prepend("<a href='' id='cancel-"+sfx+"' style='display:none;'>"+fileaway_mgmt.cancel_link+"</a>")
			if(!$('a#save-'+sfx).length) manager.prepend("<a href='' id='save-"+sfx+"' style='display:none;'>"+fileaway_mgmt.save_link+"<br></a>")
			var save = $('a#save-'+sfx);
			var cancel = $('a#cancel-'+sfx);
			rename.fadeOut(500);
			filename.fadeOut(500);
			del.fadeOut(500);				
			save.delay(500).fadeIn(500);
			cancel.delay(500).fadeIn(500);			
			rawname.delay(500).fadeIn(500);
			var customs = $('input[id^="customdata-"][id$="'+sfx+'"]').length;
			customs = customs - 1;
			for(var i=0; i <= customs; i++)
			{
				var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
				cdata.siblings('span').fadeOut('fast');
				cdata.delay(500).fadeIn(500);
			}
		}); 
		$('body').on('click', 'a[id^="cancel-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();
			$id = this.id;
				sfx = $id.replace('cancel-', ''),
				uid = $(this).parents('table:eq(0)').data('uid'),
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				save = $('a#save-'+sfx),
				cancel = $(this),
				filename = $('td#filename-'+sfx+' a'),
				rawname = $('input#rawname-'+sfx),
				manager = $('td#manager-'+sfx);
			save.fadeOut(500);
			cancel.fadeOut(500);
			rename.delay(500).fadeIn(500);
			del.delay(500).fadeIn(500);
			rawname.fadeOut(500);
			filename.delay(500).fadeIn(500);
			var customs = $('input[id^="customdata-"][id$="'+sfx+'"]').length;
			customs = customs - 1;
			for(var i=0; i <= customs; i++)
			{
				var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
				$(cdata).fadeOut(500);
				$(cdata).siblings('span').delay(500).fadeIn(500);
			}
		});
		$('body').on('click', 'a[id^="save-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();				
			$id = this.id;
			var sfx = $id.replace('save-', '');
				uid = $(this).parents('table:eq(0)').data('uid'),
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				save = $(this),
				cancel = $('a#cancel-'+sfx),
				filename = $('td#filename-'+sfx+' a'),
				manager = $('td#manager-'+sfx),
				ext = $('td#filetype-'+sfx).data('ext'),
				url = $('td#filename-'+sfx+' a'),
				url2 = $('td#filetype-'+sfx+' a'),					
				rawname = $('input#rawname-'+sfx),
				oldname = String($('td#filename-'+sfx).data('name')),
				filepath = String($('td#filename-'+sfx).data('path')),
				dir = String($('table#ssfa-table-'+$uid).data('dir'));
			var customs = $('input[id^="customdata-"][id$="'+sfx+'"]').length;
			customs = customs - 1;
			customdata = '';
			for(var i=0; i <= customs; i++)
			{
				var cdata = $('input[id^="customdata-'+i+'-'+sfx+'"]');
				customdata += cdata.val()+',';
				cdata.fadeOut(500);
			}
			customdata = customdata.substring(0, customdata.length - 1);
			rawname.fadeOut(500);
			save.fadeOut(500);
			cancel.fadeOut(500);
			$.post
			(
				fileaway_mgmt.ajaxurl,
				{
					action : 'fileaway-manager',
					dataType : 'html',	
					act : 'rename',
					ext : ext,
					url : url.attr('href'),
					rawname : rawname.val(),
					oldname : oldname,								
					pp : dir,
					customdata : customdata,
					nonce : fileaway_mgmt.nonce
				},
				function(response)
				{			
					url.attr("href", response.newurl);
					url.attr("download", response.download);
					url2.attr("href", response.newurl);
					url2.attr("download", response.download);									
					rawname.val(response.rawname);
					$('td#filename-'+sfx).data('name', response.newoldname)
					$('td#filename-'+sfx).attr('data-name', response.newoldname)
					rename.fadeIn(1000);
					del.fadeIn(1000);									
					$('input#rawname-'+sfx).val(response.rawname);
					filename.text(response.rawname);
					filename.fadeIn(1000);
					var newcustomdata = response.customdata;
					newcustomdata = newcustomdata.replace("]", ""); 
					newcustomdata = newcustomdata.replace(" [", "");									
					var newcdata = newcustomdata.split(',');
					for(var i=0; i <= customs; i++)
					{
						var cinput = $('input[id^="customdata-'+i+'-'+sfx+'"]');
						if(newcdata[i] != undefined) cinput.siblings('span').text(newcdata[i]).fadeIn(1000);
						else cinput.siblings('span').text('').fadeIn(1000);
					}
				}
			);					
			return false;
		});	// End Rename Function
		// Delete Function (Single)
		$('body').on('click', 'a[id^="delete-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();				
			$id = this.id;
			var sfx = $id.replace('delete-', ''),
				rename = $('a#rename-'+sfx),
				del = $(this),
				manager = $('td#manager-'+sfx);			
			del.fadeOut(500);
			rename.fadeOut(500);				
			if(!$('a#canceldel-'+sfx).length) manager.prepend("<a href='' id='canceldel-"+sfx+"' style='display:none;'>"+fileaway_mgmt.cancel_link+"</a>")
			if(!$('a#proceed-'+sfx).length) manager.prepend("<a href='' id='proceed-"+sfx+"' style='display:none;'>"+fileaway_mgmt.proceed_link+"<br></a>")
			if(!$('span#confirm-'+sfx).length) manager.prepend("<span id='confirm-"+sfx+"' style='display:none;'>"+fileaway_mgmt.delete_check+"<br></span>")				
			var proceed = $('a#proceed-'+sfx),
				canceldel = $('a#canceldel-'+sfx),
				confirms = $('span#confirm-'+sfx);
			proceed.delay(500).fadeIn(500);
			canceldel.delay(500).fadeIn(500);
			confirms.delay(500).fadeIn(500);
		}); 
		$('body').on('click', 'a[id^="canceldel-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();
			$id = this.id;
			var sfx = $id.replace('canceldel-', ''),
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				canceldel = $(this),
				proceed = $('a#proceed-'+sfx),
				confirms = $('span#confirm-'+sfx);
			proceed.fadeOut(500);
			canceldel.fadeOut(500);
			confirms.fadeOut(500);					
			rename.delay(500).fadeIn(500);
			del.delay(500).fadeIn(500);					
		});
		$('body').on('click', 'a[id^="proceed-ssfa-file-"]', function(ev)
		{
			ev.preventDefault();
			$id = this.id;
			var sfx = $id.replace('proceed-', ''),
				uid = $(this).parents('table:eq(0)').data('uid');
				rename = $('a#rename-'+sfx),
				del = $('a#delete-'+sfx),
				proceed = $(this),
				canceldel = $('a#canceldel-'+sfx),
				confirms = $('span#confirm-'+sfx),
				ext = $('td#filetype-'+sfx).data('ext'),
				oldname = String($('td#filename-'+sfx).data('name')),
				filepath = String($('td#filename-'+sfx).data('path')),
				dir = String($('table#ssfa-table-'+$uid).data('dir'));
			proceed.fadeOut(500);
			canceldel.fadeOut(500);
			confirms.fadeOut(500);					
			$.post
			(
				fileaway_mgmt.ajaxurl,
				{
					action : 'fileaway-manager',
					dataType : 'html',	
					act : 'delete',
					ext : ext,
					oldname : oldname,								
					pp : dir,
					nonce : fileaway_mgmt.nonce
				},
				function(response)
				{			
					if(response == 'success') 
					{	
						del.parents('tr:eq(0)').fadeOut(2000)
							.queue(function(next){ $(this).remove(); next(); });
					}
					else 
					{ 
						filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
						filertify.alert(response);
					}
				}
			);
			return false;
		}); // End Delete Function (Single)
		// Bulk Action Toggle Selected Files
		$('table.mngr-table td[id^=filetype-ssfa-] a, table.mngr-table td[id^=filename-ssfa-] a').on('click', function(e)
		{
			e.stopPropagation();
		});
		$('table.mngr-table tr[id^=ssfa-file-]').on('click', function()
		{
			$uid = $(this).parents('table:eq(0)').data('uid');
			$enabled = $('a#ssfa-bulk-action-toggle-'+$uid).data('enabled');
			if($('a#ssfa-bulk-action-toggle-'+$uid).text() == $enabled)
			{
				if($(this).hasClass('ssfa-selected')) $(this).removeClass('ssfa-selected');	
				else $(this).addClass('ssfa-selected');						
			}
		}); // End Bulk Action Toggle Selected Files		
		// Bulk Action Toggle Function
		$('a[id^="ssfa-bulk-action-toggle-"]').on('click', function(ev)
		{
			ev.preventDefault();
			$id = this.id;
			$uid = $id.replace('ssfa-bulk-action-toggle-', '');
			$enabled = $(this).data('enabled');
			$disabled = $(this).data('disabled');
			$actionarea = $('div#ssfa-bulk-action-select-area-'+$uid);
			$actionselect = $('select#ssfa-bulk-action-select-'+$uid);
			$checkall = $('input#ssfa-bulk-action-select-all-'+$uid);
			$selectalltext = $checkall.data('selectall');
			$selectall = $('label#ssfa-bulkaction-select-all-'+$uid+' span');
			if($(this).text() == $disabled)
			{
				$(this).text($enabled);
				$actionarea.fadeIn(500);	
			}
			else if($(this).text() == $enabled)
			{ 
				$(this).text($disabled);
				$actionarea.fadeOut(500);	
				$checkall.attr('checked', false).trigger('change');
				$selectall.text($selectalltext);
				$actionselect.find('option:first').attr('selected','selected').trigger('chozed:updated').trigger('change');
			}
		}); // End Bulk Action Toggle Function
		// Bulk Action Select All Function
		$('input[id^="ssfa-bulk-action-select-all-"]').on('change', function()
		{
			$id = this.id;
			$uid = $id.replace('ssfa-bulk-action-select-all-', '');
			$selectalltext = $(this).data('selectall');
			$clearalltext = $(this).data('clearall');
			$selectall = $('label#ssfa-bulkaction-select-all-'+$uid+' span');
			if(this.checked)
			{
				$selectall.text($clearalltext);
				$('table.mngr-table tr[id^=ssfa-file-'+$uid+']').addClass('ssfa-selected');
			}
			else
			{
				$selectall.text($selectalltext);
				$('table.mngr-table tr[id^=ssfa-file-'+$uid+']').removeClass('ssfa-selected');							
			}
		}); // End Bulk Action Select All Function
		// Bulk Action Select Function
		$('select[id^="ssfa-bulk-action-select-"]').on('change', function()
		{
			$id = this.id;
			$uid = $id.replace('ssfa-bulk-action-select-', '');
			$actionselected = this.value;
			$pathcontainer = $('div#ssfa-path-container-'+$uid);
			if($actionselected == '' || $actionselected == 'delete' || $actionselected == 'download') $pathcontainer.fadeOut(500);
			else $pathcontainer.fadeIn(500);
		}); // End Bulk Action Select Function
		// Bulk Action Path Generator Function
		$('select[id^="ssfa-directories-select-"]').on('change', function()
		{
			$id = this.id;
			$uid = $id.replace('ssfa-directories-select-', '');
			$loading = $('img#ssfa-path-ajax-loading-'+$uid);
			if($(this).val() !== '')
			{
				$basename = $('table#ssfa-table-'+$uid).data('basename');
				$start = $('table#ssfa-table-'+$uid).data('start');		
				$send = actionpath(this.value, $basename, $start, $loading);
			}
		});				
		$('body').on('click', 'a[id^=ssfa-action-pathpart-]', function(ev)
		{
			ev.preventDefault();
			$id = $(this).parents('div:eq(0)').attr('id');
			$uid = $id.replace('ssfa-action-path-', '');
			$pathparts = $(this).attr('data-target');
			$basename = $('table#ssfa-table-'+$uid).data('basename');
			$start = $('table#ssfa-table-'+$uid).data('start');		
			$loading = $('img#ssfa-path-ajax-loading-'+$uid);
			$send = actionpath($pathparts, $basename, $start, $loading);	
		});
		function actionpath($pathparts, $basename, $start, $loading)
		{
			$loading.show();
			$.post(
				fileaway_mgmt.ajaxurl,
				{
					action : 'fileaway-manager',
					dataType : 'html',
					act : 'actionpath',
					uploadaction : 'false',
					pathparts : $pathparts,
					basename : $basename,
					start : $start,
					nonce : fileaway_mgmt.nonce
				},
				function(response)
				{
					$container = $('div#ssfa-path-container-'+$uid);
					$actionpath = $('input#ssfa-actionpath-'+$uid);
					$putpath = $('div#ssfa-action-path-'+$uid);
					$dropdown = $('select#ssfa-directories-select-'+$uid);
					$dropdown.empty().append(response.ops).trigger('chozed:updated');
					$actionpath.val(response.pathparts);
					$putpath.html(response.crumbs).append($loading);
					$loading.hide();
				}
			);
			return false;  
		} // End Bulk Action Path Generator Function
		// Bulk Action Engage Function
		$('span[id^="ssfa-bulk-action-engage-"]').on('click', function()
		{
			$id = this.id;
			$uid = $id.replace('ssfa-bulk-action-engage-', '');
			$loading = $('img#ssfa-engage-ajax-loading-'+$uid);
			var selectedAction = $('select#ssfa-bulk-action-select-'+$uid).val();
			var selectedPath = String($('input#ssfa-actionpath-'+$uid).val());
			var dir = String($('table#ssfa-table-'+$uid).data('dir'));
			var selectedFilesFrom = {};
			var selectedFilesTo = {};
			var selectedExts = {};
			var selectedCount = 0;
			var messages = '';
			var jackoff = selectedAction == 'delete' || selectedAction == 'download' ? false : fileasec(selectedPath, $uid);
			$('table.mngr-table tr.ssfa-selected').each(function(index)
			{
				var sfx = this.id;
				var filepath = String($('td#filename-'+sfx).data('path'));
				var oldname = String($('td#filename-'+sfx).data('name'));
				var	ext = String($('td#filetype-'+sfx).data('ext'));
				selectedFilesFrom[index] = dir+'/'+oldname+'.'+ext;
				selectedFilesTo[index] = selectedPath+'/'+oldname+'.'+ext;
				selectedExts[index] = ext;
				selectedCount++;
			});
			if(selectedAction == '') messages += fileaway_mgmt.no_action+'<br>';
			if(selectedCount == 0) messages += fileaway_mgmt.no_files_selected+'<br>';
			if((selectedAction == 'move' || selectedAction == 'copy') && selectedPath == '') messages += fileaway_mgmt.no_destination+'<br>';
			if(messages !== '')
			{ 
				filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
				filertify.alert(messages); 
			} 
			else 
			{
				if(jackoff)
				{	
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
					filertify.alert(fileaway_mgmt.tamper1);
				} 
				else 
				{			
					// Bulk Action Download Function
					if(selectedAction == 'download')
					{
						$loading.show();
						$.post
						(
							fileaway_mgmt.ajaxurl,
							{
								action : 'fileaway-manager',
								dataType : 'html',	
								act : 'bulkdownload',
								files : selectedFilesFrom,
								exts : selectedExts,
								nonce : fileaway_mgmt.nonce						
							},
							function(response)
							{
								$loading.hide();								
								if(response === 'Error')
								{ 
									filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
									filertify.alert(response);
								}
								else
								{
									$('<iframe src="'+response+'" id="fa-bulkdownload" style="visibility:hidden;" name="fa-bulkdownload">').appendTo('body');	
								}
							}
						);
					} // End Bulk Action Download Function
					// Bulk Action Copy Function
					else if(selectedAction == 'copy')
					{
						$loading.show();
						$.post
						(
							fileaway_mgmt.ajaxurl,
							{
								action : 'fileaway-manager',
								dataType : 'html',	
								act : 'bulkcopy',
								from : selectedFilesFrom,
								to : selectedFilesTo,
								exts : selectedExts,
								destination : selectedPath,
								nonce : fileaway_mgmt.nonce						
							},
							function(response)
							{
								$loading.hide();								
								filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
								filertify.alert(response);
							}
						);
					} // End Bulk Action Copy Function
					// Bulk Action Move Function
					else if(selectedAction == 'move')
					{
						$loading.show();
						$.post
						(
							fileaway_mgmt.ajaxurl,
							{
								action : 'fileaway-manager',
								dataType : 'html',	
								act : 'bulkmove',
								from : selectedFilesFrom,
								to : selectedFilesTo,
								exts : selectedExts,
								destination : selectedPath,
								nonce : fileaway_mgmt.nonce						
							},
							function(response)
							{
								$loading.hide();								
								filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
								filertify.alert(response);
								$('tr.ssfa-selected').each(function()
								{
									$(this).fadeOut(2000).queue(function(next){
										$(this).remove(); next();
									});
								});
							}
						);
					} // End Bulk Action Move Function
					// Bulk Action Delete Function
					else if(selectedAction == 'delete')
					{
						var numfiles = selectedCount > 1 ? fileaway_mgmt.file_plural : fileaway_mgmt.file_singular; 
						var confirmmessage = fileaway_mgmt.delete_confirm.replace('numfiles', +selectedCount+" "+numfiles);
						filertify.set({labels:{ok : fileaway_mgmt.confirm_label, cancel : fileaway_mgmt.cancel_label }});
						filertify.confirm(confirmmessage, function(e)
						{
							if(e)
							{
								$loading.show();
								$.post
								(
									fileaway_mgmt.ajaxurl,
									{
										action : 'fileaway-manager',
										dataType : 'html',	
										act : 'bulkdelete',
										files : selectedFilesFrom,
										nonce : fileaway_mgmt.nonce						
									},
									function(response)
									{
										$loading.hide();								
										filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
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
		function fileasec($path, $uid)
		{
			var jackoff = 0;
			$fafl = String($('table#ssfa-table-'+$uid).data('fafl'));
			$faui = String($('table#ssfa-table-'+$uid).data('faui'));
			$faun = String($('table#ssfa-table-'+$uid).data('faun'));
			$faur = String($('table#ssfa-table-'+$uid).data('faur'));
			$fafl = $fafl == '0' ? false : $fafl;
			$faui = $faui == '0' ? false : $faui;
			$faun = $faun == '0' ? false : $faun;
			$faur = $faur == '0' ? false : $faur;
			var faflcheck = false;
			var fauicheck = false;
			var fauncheck = false;
			var faurcheck = false;
			if($fafl) faflcheck = $path.indexOf($fafl) >= 0 ? false : true;
			if($faui) fauicheck = $path.indexOf($faui) >= 0 ? false : true;
			if($faun) fauncheck = $path.indexOf($faun) >= 0 ? false : true;
			if($faur) faurcheck = $path.indexOf($faur) >= 0 ? false : true;
			if($path.indexOf('..') >= 0 || $path === '/' || faflcheck || fauicheck || fauncheck || faurcheck) jackoff = 1;
			return jackoff ? true : false;
		}
	} // End Manager Check
}); 
// File Up
jQuery(document).ready(function($)
{
	if ($('div.ssfa_fileup_container').length)
	{
		// Remove File On Click
		function fileupRemove(id, filename)
		{
			if($("span#ssfa_rf input#"+id).length){}
			else $("span#ssfa_rf").append('<input type="hidden" id="'+id+'" value="'+id+'">');
			$("tr#ssfa_upfile_id_"+id).fadeOut(1000).queue(function()
			{
				$(this).remove();
				$("div.ssfa_fileup_files_container table#ssfa-table tbody").change();
				if($("div.ssfa_fileup_files_container table#ssfa-table tbody").children('tr').length){} 
				else $("div.ssfa_fileup_files_container table#ssfa-table").remove();
			});
		}
		// FileUp Class
		function FileUp(config)
		{
			this.settings = config; 
			this.file = ""; 
			this.browsed_files = []; 
			var self = this;
			var msg = fileaway_mgmt.no_upload_support;
			FileUp.prototype.fileupDisplay = function(value)
			{
				this.file = value;
				if(this.file.length > 0)
				{
					$("div.ssfa_fileup_files_container").html(''); 
					$("span#ssfa_rf").html(''); 
					this.settings.removed = [];
					var selectedDisplayed = file_id = '<div id="'+this.settings.container+'" class="ssfa-meta-container">'+
						'<div id="ssfa-table-wrap" style="margin: 10px 0 0;">'
							+'<table id="ssfa-table" class="footable ssfa-sortable ssfa-'+this.settings.table+' ssfa-center"><tbody>';
	 				var path = this.settings.fixed ? this.settings.fixed : String($('input#ssfa-upload-actionpath').val());
					var jackoff = path.indexOf('..') >= 0 || path === '/' ? true : false;
					var allowedchars = this.settings.fixed ? "~!@#$%^&()_+`-={}[]'," : "~!@#$%^&()_+`-={}[]',/";
					for(var i = 0; i<this.file.length; i++)
					{
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
							sizemsg = fileaway_mgmt.exceeds_size.replace('prettymax', pretty_max);
							sizenotice = tooBig ? '<br><span class="'+warningclass+'">'+sizemsg+'</span>' : '',
							pernotice = permitted ? '<br><span class="'+warningclass+'">'+fileaway_mgmt.type_not_permitted+' '+
								'<a href="javascript:" onclick="filertify.alert(\''+this.settings.permitted.join(', ')+'\');">'+fileaway_mgmt.view_all_permitted+'</a></span>' : '',
							pronotice = prohibited ? '<br><span class="'+warningclass+'">'+fileaway_mgmt.type_not_permitted+' '+
								'<a href="javascript:" onclick="filertify.alert(\''+this.settings.prohibited.join(', ')+'\');">'+fileaway_mgmt.view_all_prohibited+'</a></span>' : '',
							readonly = tooBig || permitted || prohibited || jackoff ? ' readonly=readonly' : '',
							file_icon = tooBig || permitted || prohibited || jackoff ? self.icon('denied') : self.icon(icon_ext.toString(), color),
							cancel_color = tooBig || permitted || prohibited ? 'red' : 'silver',
							not_defined = false;
						if(tooBig || permitted || prohibited || not_defined || jackoff)
						{
							$("span#ssfa_rf").append('<input type="hidden" id="'+file_id+'" value="'+file_id+'">');
							this.settings.removed[i] = file_id;
						}
						if(typeof this.file[i] !== undefined && this.file[i].name !== '')
						{
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
						}
						else var not_defined = true; 
					}
					selectedDisplayed += "</tbody></table></div></div>";
					$("div.ssfa_fileup_files_container").append(selectedDisplayed);
					$('input[id^="rename_ssfa_upfile_id_"]').alphanum({allow : allowedchars});
					if(jackoff)
					{ 
						filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
						filertify.alert(fileaway_mgmt.tamper4); 
						$("div.ssfa_fileup_files_container").html(''); 
					}
				}
			}
			// Create Unique ID
			FileUp.prototype.uid = function(name)
			{
				return name.replace(/[^a-z0-9\s]/gi, '_').replace(/[_\s]/g, '_');
			}			
			// Get File Extension
			FileUp.prototype.ext = function(file, lowercase)
			{
				return (/[.]/.exec(file)) ? (lowercase ? /[^.]+$/.exec(file.toLowerCase()) : /[^.]+$/.exec(file)) : '';
			}
			// Format File Size
			FileUp.prototype.nicesize = function(fileSize)
			{
				if(fileSize / 1024 > 1)
				{
					if(((fileSize / 1024) / 1024) > 1)
					{
						fileSize = (Math.round(((fileSize / 1024) / 1024) * 100) / 100);
						var niceSize = fileSize + " GB";
					}
					else
					{
						fileSize = (Math.round((fileSize / 1024) * 100) / 100)
						var niceSize = fileSize + " MB";
					}
				 }
				 else
				 {
					fileSize = (Math.round(fileSize * 100) / 100)
					var niceSize = fileSize  + " KB";
				}
				return niceSize;
			}
			// Get Random Color
			FileUp.prototype.randcolor = function()
			{
				array = ["red","green","blue","brown","black","orange","silver","purple","pink"];
				return array[Math.floor(Math.random() * array.length)];
			}
			// Attribute FileType Icons
			FileUp.prototype.icon = function(icon_ext, color)
			{
				if($.inArray(icon_ext, fileaway_filetype_groups.image) != -1) file_icon = ssfa_filetype_icons.image; 
				else if($.inArray(icon_ext, fileaway_filetype_groups.adobe) != -1) file_icon = ssfa_filetype_icons.adobe; 
				else if($.inArray(icon_ext, fileaway_filetype_groups.audio) != -1) file_icon = ssfa_filetype_icons.audio;
				else if($.inArray(icon_ext, fileaway_filetype_groups.video) != -1) file_icon = ssfa_filetype_icons.video;
				else if($.inArray(icon_ext, fileaway_filetype_groups.msdoc) != -1) file_icon = ssfa_filetype_icons.msdoc;
				else if($.inArray(icon_ext, fileaway_filetype_groups.msexcel) != -1) file_icon = ssfa_filetype_icons.msexcel;
				else if($.inArray(icon_ext, fileaway_filetype_groups.powerpoint) != -1) file_icon = ssfa_filetype_icons.powerpoint;
				else if($.inArray(icon_ext, fileaway_filetype_groups.openoffice) != -1) file_icon = ssfa_filetype_icons.openoffice;
				else if($.inArray(icon_ext, fileaway_filetype_groups.text) != -1) file_icon = ssfa_filetype_icons.text;
				else if($.inArray(icon_ext, fileaway_filetype_groups.compression) != -1) file_icon = ssfa_filetype_icons.compression;
				else if($.inArray(icon_ext, fileaway_filetype_groups.application) != -1) file_icon = ssfa_filetype_icons.application;
				else if($.inArray(icon_ext, fileaway_filetype_groups.script) != -1) file_icon = ssfa_filetype_icons.script;
				else if($.inArray(icon_ext, fileaway_filetype_groups.css) != -1) file_icon = ssfa_filetype_icons.css;
				else if(icon_ext === 'denied') file_icon = '<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span>';
				else file_icon = ssfa_filetype_icons.unknown; 
				file_icon = icon_ext === 'denied' 
					? file_icon 
					: '<span data-ssfa-icon="'+file_icon+'" class="ssfa-faminicon ssfa-'+color+'" aria-hidden="true"></span>';
				return file_icon;
			}
			//File Reader
			FileUp.prototype.read = function(e) 
			{
				if(e.target.files) 
				{
					self.fileupDisplay(e.target.files);
					self.browsed_files.push(e.target.files);
				} 
				else 
				{
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
					filertify.alert(fileaway_mgmt.unreadable_file);
				}
			}
			function addEvent(type, el, fn)
			{
				if(window.addEventListener)
				{
					el.addEventListener(type, fn, false);
				} 
				else if(window.attachEvent)
				{
					var f = function()
					{
					  fn.call(el, window.event);
					};			
					el.attachEvent('on' + type, f)
				}
			}
			// Collect File IDs and Initiate Upload for Submit
			FileUp.prototype.starter = function() 
			{
				if(window.File && window.FileReader && window.FileList && window.Blob) 
				{ // Safari Does Not Support FileReader API and cannot read file sizes
					var browsed_file_id = $('#'+this.settings.form_id).find('input[type="file"]').eq(0).attr('id');
					document.getElementById(browsed_file_id).addEventListener('change', this.read, false);
					document.getElementById('ssfa_submit_upload').addEventListener('click', this.submit, true);
				} 
				else 
				{ 
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }}); 
					filertify.alert(msg); 
					$('div.ssfa_fileup_container').remove(); 
				}
			}
			// Begin Upload on Click
			FileUp.prototype.submit = function()
			{ 
				self.begin(); 
			}
			// Initiate Upload Iterator
			FileUp.prototype.begin = function() 
			{
				if(!this.settings.fixed && $('input#ssfa-upload-actionpath').val() === '')
				{
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
					filertify.alert(fileaway_mgmt.build_path);	
				}
				else if(this.browsed_files.length > 0)
				{
					for(var k=0; k<this.browsed_files.length; k++)
					{
						var file = this.browsed_files[k];
						this.fileupAjax(file,k);
					}
					this.browsed_files = [];
				}
				else
				{
					filertify.set({labels:{ok : fileaway_mgmt.ok_label }});
					filertify.alert(fileaway_mgmt.no_files_chosen);
				}
			}
			// Ajax Upload
			FileUp.prototype.fileupAjax = function(file,i)
			{
				if(file[i] !== undefined && file[i] !== '' && file[i] !== "undefined" )
				{
					if(file[i]!== undefined)
					{
						var id = file_id = self.uid(file[i].name),
							rawname = file[i].name.substr(0, file[i].name.lastIndexOf('.')) || file[i].name,
							extension = self.ext(file[i].name, false),
							browsed_file_id = $("#"+this.settings.form_id).find("input[type='file']").eq(0).attr("id"),
							path = this.settings.fixed ? this.settings.fixed : String($('input#ssfa-upload-actionpath').val()),
							pathcheck = String(this.settings.pathcheck),
							removed_file = $("#"+id).val(),
							newname = String($('input#rename_ssfa_upfile_id_'+id).val()),
							new_name = newname === '' || newname === 'undefined' || newname === undefined ? file[i].name : newname+'.'+extension,
							removed = this.settings.removed,
							loading = this.settings.loading,
							fixedchars = this.settings.fixed;
						if(newname === '' || newname === 'undefined' || newname === undefined) $('input#rename_ssfa_upfile_id_'+id).val(rawname)
						if(removed_file !== '' && removed_file !== undefined && removed_file == id) self.fileupAjax(file,i+1); 
						else
						{
							var fileupData = new FormData();
							fileupData.append('upload_file',file[i]);
							fileupData.append('upload_file_id',id);
							fileupData.append('max_file_size',this.settings.maxsize);
							fileupData.append('upload_path',path);	
							fileupData.append('new_name',new_name);
							fileupData.append('extension',extension);
							fileupData.append('uploader',this.settings.uploader);
							fileupData.append('act','upload');
							fileupData.append('nonce',fileaway_mgmt.nonce);				
							$.ajax(
							{
								type		: 'POST',
								url			: fileaway_mgmt.ajaxurl+'?action=fileaway-manager',
								data		: fileupData,
								id			: id,
								new_name	: new_name,
								rawname		: rawname,
								extension	: extension,
								path		: path,
								pathcheck	: pathcheck,
								removed		: removed,
								loading		: loading,
								fixedchars	: fixedchars,
								cache		: false,
								contentType	: false,
								processData	: false,
								beforeSend	: function(xhr, settings)
								{
									$("#ssfa_upfile_status_"+id)
										.html('<span class="ssfa-faminicon ssfa-silver ssfa-icon-denied"></span>');
									var newpath = settings.new_name.substring(0, settings.new_name.lastIndexOf("/") + 1),
										jackoff = false,
										message = '';
									if(''+newpath.indexOf('..') >= 0 || settings.path.indexOf('..') >= 0 || settings.path === '/')
									{ 
										jackoff = true; 
										message = '<br>'+fileaway_mgmt.double_dots_override;
									}
									if(!jackoff && $.inArray(settings.id, settings.removed) != -1) jackoff = true; 
									if(!jackoff && settings.fixedchars && settings.new_name.indexOf('/') >= 0)
									{ 
										jackoff = true; 
										message = '<br>'+fileaway_mgmt.creation_disabled;
									}
									if(!jackoff && settings.path.indexOf(settings.pathcheck) < 0)
									{
										jackoff = true; 
										message = '<br>'+fileaway_mgmt.no_override;
									}
									if(!jackoff && settings.new_name.indexOf('..') >= 0)
									{ 
										jackoff = true;
										message = '<br>'+fileaway_mgmt.double_dots;
									}
									if(!jackoff)
									{
										var pop = settings.rawname.substring(settings.rawname.lastIndexOf(".") + 1, settings.rawname.length);	
										if($.inArray(pop, fileaway_filetype_groups.script) != -1)
										{ 
											if($.inArray(settings.extension.toString(), fileaway_filetype_groups.script) == -1 
											&& $.inArray(settings.extension.toString(), fileaway_filetype_groups.css) == -1) 
											{
												jackoff = true; 
												message = '<br>'+fileaway_mgmt.multi_type;
											}
										}
									}
									if(jackoff)
									{
										var upload_failure = fileaway_mgmt.upload_failure.replace('filename', settings.rawname+'.'+settings.extension);
										$('tr#ssfa_upfile_id_'+settings.id+' td#ssfa-upfile_type')
											.html('<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span><br>'+settings.extension);
										$('td#ssfa_upfile_status_'+settings.id)
											.html('<a id="ssfa_remove_if_'+file_id+'" href="javascript:" onclick="fileupRemove(\''
											+settings.id+'\',\''+settings.rawname+'.'+settings.extension									
											+'\');"><span class="ssfa-faminicon ssfa-red ssfa-icon-console-2"></span></a>');
										$('tr#ssfa_upfile_id_'+settings.id+' td#ssfa-upfile_name')
											.append('<br><span class="ssfa-fileup-warning">'+upload_failure+message+'</span>');
										if(i+1 < file.length) self.fileupAjax(file,i+1); 
										xhr.abort();
									}
								},
								xhr: function()
								{
									var xhr = new window.XMLHttpRequest();
									xhr.upload.addEventListener("progress", function(evt)
									{
										if(evt.lengthComputable)
										{
											var percentComplete = evt.loaded / evt.total;
											$('div#ssfa_upload_progress_id_'+id).width((percentComplete * 100) + '%');
										}
									}, false);
									return xhr;
								},
								success		: function(response)
								{
									setTimeout(function()
									{
										if(response.indexOf(id) != -1)
										{
											$("#ssfa_upfile_status_"+id)
												.html('<span class="ssfa-faminicon ssfa-green ssfa-icon-inbox"></span>');
											$("#ssfa_upfile_id_"+id).delay(500).fadeOut(1000).queue(function()
											{
												$(this).remove(); 
												$("div.ssfa_fileup_files_container table#ssfa-table tbody").change();
												if($("div.ssfa_fileup_files_container table#ssfa-table tbody").children('tr').length){} 
												else $("div.ssfa_fileup_files_container table#ssfa-table").remove();
											});
										}
										else
										{
											var upload_failure = fileaway_mgmt.upload_failure.replace('filename', rawname+'.'+extension);
											$('tr#ssfa_upfile_id_'+id+' td#ssfa-upfile_type')
												.html('<span class="ssfa-faminicon ssfa-red ssfa-icon-denied"></span><br>'+extension);
											$('td#ssfa_upfile_status_'+id)
												.html('<a id="ssfa_remove_if_'+file_id+'" href="javascript:" onclick="fileupRemove(\''+id+'\',\''+rawname+'.'+extension									
												+'\');"><span class="ssfa-faminicon ssfa-red ssfa-icon-console-2"></span></a>');
											$('tr#ssfa_upfile_id_'+id+' td#ssfa-upfile_name')
												.append('<br><span class="ssfa-fileup-warning">'+upload_failure+'</span>');
										}
										if(i+1 < file.length) self.fileupAjax(file,i+1); 
									},500);
								}
							});
						 }
					} 
				}
			}	
			this.starter();
		}
		window.FileUp = FileUp;
		window.fileupRemove = fileupRemove;
		// Upload Path Generator Function
		$('select#ssfa-fileup-directories-select').chozed({
			allow_single_deselect:false, 
			width: '200px', 
			inherit_select_classes:true,
			no_results_text: fileaway_mgmt.no_results,
			search_contains: true 
		});
		$('select#ssfa-fileup-directories-select').on('change', function()
		{
			$loading = $('img#ssfa-fileup-action-ajax-loading');
			if($(this).val() !== '')
			{
				$basename = $('input#ssfa-upload-actionpath').data('basename');
				$start = $('input#ssfa-upload-actionpath').data('start');		
				$send = actionpath(this.value, $basename, $start, $loading);
			}
		});				
		$('body').on('click', 'a[id^=ssfa-fileup-action-pathpart-]', function(ev)
		{
			ev.preventDefault();
			$basename = $('input#ssfa-upload-actionpath').data('basename');
			$start = $('input#ssfa-upload-actionpath').data('start');		
			$loading = $('img#ssfa-fileup-action-ajax-loading');
			$pathparts = $(this).attr('data-target');
			$send = actionpath($pathparts, $basename, $start, $loading);	
		});
		function actionpath($pathparts, $basename, $start, $loading)
		{
			$loading.show();
			$.post(
				fileaway_mgmt.ajaxurl,
				{
					action : 'fileaway-manager',
					dataType : 'html',	
					act : 'actionpath',
					uploadaction : 'true', 
					pathparts : $pathparts,
					basename : $basename,					
					start : $start,							
					nonce : fileaway_mgmt.nonce						
				},
				function(response)
				{
					$container = $('div#ssfa-fileup-path-container');
					$actionpath = $('input#ssfa-upload-actionpath');
					$putpath = $('div#ssfa-fileup-action-path');
					$dropdown = $('select#ssfa-fileup-directories-select');
					$dropdown.empty().append(response.ops).trigger('chozed:updated').trigger('liszt:updated');
					$actionpath.val(response.pathparts);
					$putpath.html(response.crumbs).append($loading);
					$loading.hide();
				}
			);
			return false;  
		} // End Upload Path Generator Function			
	}
});