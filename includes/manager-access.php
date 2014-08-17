<?php
defined('SSFA_FILE') or die("Shirley, you can't be serious.");
$manager = 0;
while (!$manager):
	if(current_user_can('administrator')) $manager = 1; 
	if($manager) break;
	$allowed_roles = explode(',', SSFA_MANAGER_ROLES);
	foreach($allowed_roles as $role): 
		if(current_user_can($role)): 
			$manager = 1; 
			break; 
		endif;
	endforeach; 
	if($manager) break;
	$allowed_users = explode(',', SSFA_MANAGER_USERS); 
	foreach($allowed_users as $user): 
		if($fa_userid == $user): 
			$manager = 1; 
			break; 
		endif;
	endforeach;
	if($manager) break;
	if($password): 
		if($password == SSFA_MANAGER_PASSWORD):
			if($role_override):
				if(preg_match("/fa-userrole/i", $role_override)): 
					if($logged_in): 
						$manager = 1; 
						break; 
					endif;
				else:
					$override_roles = preg_split('/(, |,)/', trim($role_override, ' ')); 
					foreach($override_roles as $role):
						if(current_user_can($role)): 
							$manager = 1; 
							break; 
						endif;
					endforeach;
					if($manager) break;
				endif;
			endif;
			if($user_override):
				if(preg_match("/fa-userid/i", $user_override)): 
					$ID = get_current_user_id();
					if($fa_userid == $ID): 
						$manager = 1; 
						break;
					endif;
				else:
					$override_users = preg_split('/(, |,)/', trim($user_override, ' '));
					foreach($override_users as $user): 
						if($fa_userid == $user): 
							$manager = 1; 
							break;
						endif;
					endforeach;
					if($manager) break;
				endif;
			endif;
		endif;	
	endif;
	break;
endwhile;
if($manager && !$dirman_access): $dirman = 1;
elseif($manager && $dirman_access): 
	$dirman = 0; $dirman_roles = preg_split('/(, |,)/', $dirman_access); 
	foreach($dirman_roles as $drole): if(current_user_can($drole)): $dirman = 1; break; endif; endforeach;
else: $dirman = 0; endif;