<?php
echo '/* YOURCOLOR SECONDARY */
/* 	Add any custom list classes here to hook them into your color,
	adding a comma after each selector */
div#ssfa-list-wrap.ssfa-silk a.accent-yourcolor:hover:before,
div#ssfa-list-wrap.ssfa-minimal-list .accent-yourcolor div.ssfa-listitem:hover span.ssfa-topline,
div#ssfa-list-wrap.ssfa-minimal-list .accent-yourcolor div.ssfa-listitem:active span.ssfa-topline {
    background: rgba(#, #, #, 0.1); 
	/* Set the RGB for your accent color, here with 10% transparency */
}
/* 	Add any custom list classes here to hook them into your color,
	adding a comma after each selector */
div#ssfa-list-wrap.ssfa-silk a.accent-yourcolor:hover,
div#ssfa-list-wrap.ssfa-silk a.accent-yourcolor:active {
	color: #YOURCOLOR;
}
/* END YOURCOLOR SECONDARY */
';