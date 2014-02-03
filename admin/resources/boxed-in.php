<?php 

echo '/***** BOXED-IN LIST STYLE *****/

div#ssfa-list-wrap.ssfa-boxed-in h3.ssfa-heading {
    margin: 0 55px 10px 10px;
}

div#ssfa-list-wrap.ssfa-boxed-in {
	border-color: #666;
	border-style: solid;
	border-width: 5px;
	-moz-border-radius: 15px;
	-o-border-radius: 15px;	
	-webkit-border-radius: 15px;
	border-radius: 15px;
	padding: 15px 0;
}

/* Primary Link Body */
div#ssfa-list-wrap.ssfa-boxed-in a,
div#ssfa-list-wrap.ssfa-boxed-in a:visited {
	background: transparent;
	border: 0;	
	border-radius: 0; 
	box-shadow: none; 
	cursor: pointer;
	display: block;	
	font-size: 14px;
	line-height: 1.2em;
	margin: 0;
	padding: 10px 15px 10px 50px;
	*padding: 10px;
	position: relative;
	text-decoration: none;
	-moz-transition: all .8s ease-in;
	-o-transition: all .8s ease-in;
	-webkit-transition: all .8s ease-in;
	transition: all .8s ease-in;	
	zoom: 1;
}

/* Icon Area */
div#ssfa-list-wrap.ssfa-boxed-in a:before {
	background: transparent;
	border: 0;
	border-radius: 0; 
	content: "";			
	display: block;		
	height: 100%;
	left: 0px;
	margin-right: 2px;	
	position: absolute;
	top: 0;
	-moz-transition: all .8s ease-in;
	-o-transition: all .8s ease-in;
	-webkit-transition: all .8s ease-in;
	transition: all .8s ease-in;	
	width: 38px;	
	zoom: 1;
}

/*Primary Link Body on Hover */
div#ssfa-list-wrap.ssfa-boxed-in a:hover {
	background-color: #d9d9d9;
}

/* Icon Area on Hover */
div#ssfa-list-wrap.ssfa-boxed-in a:hover:before {
/* In case you want something to happen in the icon area on hover, 
as with the Silk style. */
}

/* If No Icons are Chosen */
div#ssfa-list-wrap.ssfa-boxed-in .noicons,
div#ssfa-list-wrap.ssfa-boxed-in .noicons {
	padding-left: 10px;
}

/* If No Icons are Chosen */
div#ssfa-list-wrap a.noicons:before,
div#ssfa-list-wrap a.noicons:hover:before {
	background-color: transparent;
}

/* Primary Link Body on Click */
div#ssfa-list-wrap.ssfa-boxed-in a:active {
	background-color: #ededed;	
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(0, 0, 0, 0.2);
	-o-box-shadow: inset 0px 2px 2px 0px rgba(0, 0, 0, 0.2);	
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(0, 0, 0, 0.2);
	box-shadow: inset 0px 2px 2px 0px rgba(0, 0, 0, 0.2); 
}

/* Filetype Icon Style */
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon a:visited {
	color: #666;
	font-size: 20px;
	left: 15px;
	margin-right: 2px;		
	position: absolute;
	text-decoration: none;
	top: 25%;
	vertical-align: middle;
}

/* Paperclip Icon Style */
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip a:visited {
	color: #666;
	font-size: 20px;
	left: 15px;
	margin-right: 2px;		
	position: absolute;
	text-decoration: none;
	top: 25%;
	vertical-align: middle;
}

/* Filesize Area */
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listfilesize,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listfilesize a,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listfilesize a:hover,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listfilesize a:active,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listfilesize a:visited {
	color: #666;
	float: right;
	margin-left: 20px;	
}

/* Date Modified Line */
div#ssfa-list-wrap.ssfa-boxed-in div.ssfa-listitem > div.ssfa-datemodified, 
div#ssfa-list-wrap.ssfa-boxed-in div.ssfa-listitem > div.ssfa-datemodified a, 
div#ssfa-list-wrap.ssfa-boxed-in div.ssfa-listitem > div.ssfa-datemodified a:hover, 
div#ssfa-list-wrap.boxed-in div.ssfa-listitem > div.ssfa-datemodified a:active, 
div#ssfa-list-wrap.boxed-in div.ssfa-listitem > div.ssfa-datemodified a:visited {
	background: transparent;
	color: #666;
	font-size: 9px;
	text-decoration: none;	
	text-transform: uppercase;
}

/* Inline: for when Inline display is activated */
div#ssfa-list-wrap.ssfa-boxed-in a.ssfa-inline {
	display: inline-block;	
	margin-right: 10px;
}

/* Two Columns: for when Two Columns are activated */
div#ssfa-list-wrap.ssfa-boxed-in a.ssfa-twocol {
	display: inline-block;	
	margin-right: 10px;	
	width: 35%;
}


/* Sharp Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-sharp {
	-moz-border-radius: 0px;
	-o-border-radius: 0px;	
	-webkit-border-radius: 0px;
	border-radius: 0px; 
}

/* Rounded Right Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-roundright {
	-moz-border-radius: 0 15px 15px 0;
	-o-border-radius: 0 15px 15px 0;	
	-webkit-border-radius: 0 15px 15px 0;
	border-radius: 0 15px 15px 0;
}

/* Rounded Left Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-roundleft {
	-moz-border-radius: 15px 0 0 15px;
	-o-border-radius: 15px 0 0 15px;	
	-webkit-border-radius: 15px 0 0 15px;	
	border-radius: 15px 0 0 15px;
}

/* Rounded Top Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-roundtop {
	-moz-border-radius: 15px 15px 0 0;
	-o-border-radius: 15px 15px 0 0;	
	-webkit-border-radius: 15px 15px 0 0;
	border-radius: 15px 15px 0 0;
}

/* Rounded Bottom Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-roundbottom {
	-moz-border-radius: 0 0 15px 15px;
	-o-border-radius: 0 0 15px 15px;	
	-webkit-border-radius: 0 0 15px 15px;
	border-radius: 0 0 15px 15px;
}

/* Elliptical Corners */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-elliptical {
	-moz-border-radius: 15px 0 15px 0;
	-o-border-radius: 15px 0 15px 0;	
	-webkit-border-radius: 15px 0 15px 0;
	border-radius: 15px 0 15px 0;
}';

echo '


/***** BOXED-IN PRIMARY COLORS (HEADINGS, ICONS AND LINKS) *****/

/* Black Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-black a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-black a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-black, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-black a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-black a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-black a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-black a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-black, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-black a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-black a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-black a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-black a:visited { 
	color: #444; 
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-black {
	border-color:#444; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}

/* Silver Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-silver a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-silver a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-silver, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-silver a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-silver a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-silver a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-silver a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-silver, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-silver a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-silver a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-silver a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-silver a:visited { 
	color: #777777; 
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-silver {
	border-color:#777777; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}  

/* Red Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-red a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-red a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-red, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-red a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-red a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-red a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-red a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-red, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-red a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-red a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-red a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-red a:visited {
	color: #AD2125;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-red {
	border-color:#AD2125; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}  

/* Blue Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-blue a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-blue a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-blue, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-blue a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-blue a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-blue a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-blue a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-blue, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-blue a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-blue a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-blue a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-blue a:visited {
	color: #2B769E; 
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-blue {
	border-color:#2B769E; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}  

/* Green Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-green a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-green a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-green, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-green a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-green a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-green a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-green a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-green, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-green a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-green a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-green a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-green a:visited {
	color: #569662;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-green {
	border-color:#569662; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}  

/* Brown Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-brown a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-brown a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-brown, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-brown a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-brown a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-brown a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-brown a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-brown, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-brown a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-brown a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-brown a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-brown a:visited {
	color: #6A523F;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-brown {
	border-color:#6A523F; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}  

/* Orange Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-orange a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-orange a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-orange, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-orange a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-orange a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-orange a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-orange a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-orange, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-orange a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-orange a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-orange a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-orange a:visited {
	color: #BE5D38;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-orange {
	border-color:#BE5D38; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}

/* Purple Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-purple a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-purple a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-purple, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-purple a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-purple a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-purple a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-purple a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-purple, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-purple a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-purple a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-purple a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-purple a:visited {
	color: #5B4886;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-purple {
	border-color: #5B4886; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}

/* Pink Primary */
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-pink a,
div#ssfa-list-wrap.ssfa-boxed-in.ssfa-pink a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-pink, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-pink a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-pink a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-pink a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-listicon.ssfa-pink a:visited,
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-pink, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-pink a, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-pink a:hover, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-pink a:active, 
div#ssfa-list-wrap.ssfa-boxed-in span.ssfa-paperclip.ssfa-pink a:visited {
	color: #DD416F;
}

div#ssfa-list-wrap.ssfa-boxed-in.ssfa-pink {
	border-color: #DD416F; 
	/* Silk and Minimal-List do not use border colors on the outer div. */
}


/***** BOXED-IN ACCENT COLORS *****/

/* Black Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-black:hover {
    background: rgba(0, 0, 0, 0.1);
}

/* 
Use this color for Black accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-black:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-black:active {
	color: #575757;
}
*/

/* Silver Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-silver:hover {
	background: rgba(150, 150, 150, 0.1);
}

/* 
Use this color for Silver accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-silver:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-silver:active {
	color: #969696;
}
*/

/* Red Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-red:hover {
    background: rgba(207, 71, 57, 0.1);
}
/* 
Use this color for Red accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-red:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-red:active {
	color: #CF4739;
}
*/

/* Blue Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-blue:hover {
    background: rgba(91, 160, 208, 0.1);
}

/* 
Use this color for Blue accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-blue:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-blue:active {
	color: #5BA0D0;
}
*/

/* Green Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-green:hover {
	background: rgba(109, 185, 123, 0.1);
}

/* 
Use this color for Green accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-green:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-green:active {
	color: #6DB97B;
}
*/

/* Brown Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-brown:hover {
    background: rgba(136, 105, 76, 0.1);
}

/* 
Use this color for Brown accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-brown:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-brown:active {
	color: #88694C;
}
*/

/* Orange Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-orange:hover {
    background: rgba(203, 120, 88, 0.1);
}

/* 
Use this color for Orange accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-orange:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-orange:active {
	color: #CB7858;
}
*/

/* Purple Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-purple:hover {
    background: rgba(113, 89, 163, 0.1);
}

/* 
Use this color for Purple accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-purple:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-purple:active {
	color: #7159A3;
}
*/
	
/* Pink Secondary */
div#ssfa-list-wrap.ssfa-boxed-in a.accent-pink:hover {
    background: rgba(217, 98, 132, 0.1);
}

/* 
Use this color for Pink accents that are not background colors (not used by Boxed-In)
Example:
div#ssfa-list-wrap.ssfa-boxed-in a.accent-pink:hover,
div#ssfa-list-wrap.ssfa-boxed-in a.accent-pink:active {
	color: #D96284;
}
*/

/***** END BOXED-IN STYLES *****/


';

?>