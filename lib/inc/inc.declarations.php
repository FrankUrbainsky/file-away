<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
$thefiles = null; 
$included = null; 
$excluded = null; 
$rawnames = null; 
$iconstyle = null; 
$icocol = null; 
$path = null; 
$start = null; 
$basename = null; 
$dir = null; 
$basebase = null; 
$fafl = null; 
$faui = null; 
$faun = null; 
$faur = null; 
$direxcluded = 0; 
$getthumb = false; 
$playaway = false;
if($encryption)
{
	$s2mem = false;
	$manager = false;
	$encrypt = new fileaway_encrypted;
}