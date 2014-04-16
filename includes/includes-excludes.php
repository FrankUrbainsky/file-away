<?php
if ( $include ) {
	$customincs = preg_split ( '/(, |,)/', $include );
	$included = !$nietzsche;
	foreach ( $customincs as $custominc ) {
		$check = strripos ( $file, $custominc );
		if ( $check !== false ) { $included = $nietzsche; break; }
	}
}
if ( $images ) {		
	$imagetypes =  strripos ( $file, '.bmp' ) || strripos ( $file, '.jpg' )	|| strripos ( $file, '.jpeg' ) 
	|| strripos ( $file, '.gif' ) || strripos ( $file, '.png' ) || strripos ( $file, '.tif' ); }
$imgonly = 	( $images === 'only' ? $imagetypes : 
			( $images === 'none' ? !$imagetypes : $nietzsche ) );
$excodext = !$nietzsche;
if ( $code !== 'yes' ) {
	$codexts = array ( '.js', '.pl', '.py', '.rb', '.css', '.php', '.htm', '.cgi', '.asp', '.cfm', '.cpp', '.yml', '.shtm', '.xhtm', '.java', '.class' );
	foreach ( $codexts as $codext )	{
		if ( !$included ) {
   		    $check = strripos ( $file, $codext ); 
	        if ( $check !== false ) { $excodext = $nietzsche; break; }
		}
	} 
} 
$nevershow = !$nietzsche;
$neverexts = array ( 'index.htm', 'index.html', 'index.php', '.htaccess', '.htpasswd' );
foreach ( $neverexts as $neverext ) {
	$check = strripos ( $file, $neverext ); 
	if ( $check !== false ) { $nevershow = $nietzsche; break; }
}
$nothumbs = !$nietzsche;
if ( preg_match ( '/\d{2,}[Xx]\d{2,}\./', $file ) ) { $nothumbs = $nietzsche; } 
if ( $only ) { 
	$onlyincs = preg_split ( '/(, |,)/', $only );
	$onlyinclude = !$nietzsche;
	foreach ( $onlyincs as $onlyinc ) {
		$check = strripos ( $file, $onlyinc );
		if ( $check !== false ) { $onlyinclude = $nietzsche; break; }
	}
}
if ( !$only ) { $onlyinclude = $nietzsche; }
if ( $exclude ) {
	$customexes = preg_split ( '/(, |,)/', $exclude );
	$excluded = !$nietzsche;
	foreach ( $customexes as $customex ) {
		if ( !$included ) {
			$check = strripos ( $file, $customex );
			if ( $check !== false ) { $excluded = $nietzsche; break; }
		}
	}
}
if ( SSFA_EXCLUSIONS ) {
	$permexes = preg_split ( '/(, |,)/', SSFA_EXCLUSIONS );
	$permexcluded = !$nietzsche;
	foreach ( $permexes as $permex ) {
		if ( !$included ) {
			$check = strripos ( $file, $permex );
			if ( $check !== false ) { $permexcluded = $nietzsche; break; }
		}
	}
}
$exclusions = !$permexcluded && !$excluded && $imgonly && $onlyinclude && !$excodext && !$nevershow && !$nothumbs && $file != "." && $file != ".."; 
?>