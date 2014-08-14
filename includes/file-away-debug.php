<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
if(!function_exists('ssfa_debug')):
function ssfa_debug($url, $dir){
	$thedebuggery = '		
		<div style="background:#FFFFFF; border: 5px solid #CFCAC5; border-radius:0px; padding:20px; color:#444;">			
		<img src="'.SSFA_IMAGES_URL.'fileaway_banner.png" style="width:300px;"><br><br>
		Your File Away shortcode is pointing to the following directory:<br /><br />				
		<code class="ssfa-code">'.$url.'/'.$dir.'</code><br /><br />						
		Got any files in there or what? I mean, is that where you <i>really</i> want to point this thing?<br /><br />
		Either there are files in there but your shortcode is excluding them all, or there ain\'t no files in there, or that directory don\'t exist (ORRRR, your shortcode is working fine but you just wanted to see what debug did).<br /><br />				
		Maybe you used one of these?<br /><br />
		<code class="ssfa-code">fa-firstlast</code> <code class="ssfa-code">fa-username</code> <code class="ssfa-code">fa-userid</code> <code class="ssfa-code">fa-userrole</code><br /><br />
		If you used one of the four dynamic path codes, then the path above is going to be different for every logged-in user. See the table provided under "Dynamic Paths" in the <a href="'. SSFA_OPTIONS_URL .'#tutorials" target="_blank">File Away Tutorials</a> for reference on how the codes will render the pathnames for each individual registered user, and rename your directories accordingly.<br /><br />
		Sincerely,<br />
		MGMT
		</div>';
	return $thedebuggery;
}
endif;