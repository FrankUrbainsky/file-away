<?php

$private_content = false;

// If 'fa-userid' is entered anywhere in the sub attribute, it will be replaced with the current user's user id.
if ( stripos ( $dir, 'fa-userid' ) ) {
	$private_content = true;
	$dir = str_ireplace ( 'fa-userid', $fa_userid, $dir );
}

// If 'fa-userrole' is entered anywhere in the sub attribute, it will be replaced with the current user's userrole.
if ( stripos ( $dir, 'fa-userrole' ) ) { 
	$private_content = true;
	$dir = str_ireplace ( 'fa-userrole', strtolower ( $fa_userrole ), $dir );
}

// If 'fa-username' is entered anywhere in the sub attribute, it will be replaced with the current user's username.
if ( stripos ( $dir, 'fa-username' ) ) { 
	$private_content = true;
	$dir = str_ireplace ( 'fa-username', strtolower ( $fa_username ), $dir );
}
	
// If 'fa-firstlast' is found anywhere in the base or sub attributes, it will be replaced with the current user's firstname and lastname.
if ( stripos ( $dir, 'fa-firstlast' ) ) { 
	$private_content = true;
	$dir = str_ireplace ( "fa-firstlast", strtolower ( $fa_firstlast ), $dir );
}


?>