<?php

$post_title = get_the_title($theid);
$idcheck = get_post($theid);
if (! $attachments): 
	if ($idcheck): 
		if ($post_title !== '') $post_title = '<em>'.$post_title.'</em>,'; else $post_title = null;  
		$thefiles = "<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>
		<img src='".SSFA_IMAGES_URL."attachaway_banner.png' style='width:300px;'><br /><br />				
		You're trying to display attachments from $post_title post ID $theid, but there's nothing attached to that one, yo.</div>"; 
	else:  
		$thefiles = "<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>
		<img src='".SSFA_IMAGES_URL."attachaway_banner.png' style='width:300px;'><br /><br />
		You're trying to display attachments from post ID $theid, but I'm not sure that one even exists, dude.</div>";
	endif; 
endif; 
if ($attachments): 
	if ($post_title !== '') $post_title = "<em>$post_title</em>,"; else $post_title = null;  
	$thefiles = "<div style='background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;'>
	<img src='".SSFA_IMAGES_URL."attachaway_banner.png' style='width:300px;'><br /><br />
	You're trying to display attachments from $post_title post ID $theid. It's got stuff attached. Maybe you've excluded everything? Just a guess. I can't really tell from here though, especially since I probably don't even know you personally.</div>"; 
endif; 

?>