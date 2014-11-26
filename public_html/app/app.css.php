<?php
header("Content-type: text/css");

//-----------------
// Define globals

// Images
$background =						"../misc/bg.jpg";
$submit_button =					"../misc/button_hover.png";
$submit_button_hover =					"../misc/button.png";

$bg_color =						"#fff";
$shade_color =						"#eee";
$border_color =						"#ccc";

$font_color =						"#000";
$light_font_color =					"#777";
?>

* {
	font-family: verdana, arial, sans;
	font-size: small;
	color: <?=$light_font_color?>;
	margin: 0px;
	padding: 0px;
}
html {
	background-color: <?=$bg_color?>;
	background-image: url(<?=$background?>);
	background-position: top center;
	background-repeat: no-repeat;
}
html, body {
	margin: 0px;
	padding: 0px;
}
h1 {
	padding: 0em 0px .5em 0px;
	font-family: arial, sans;
	font-size: 24px;
	letter-spacing: 2px;
	font-weight: lighter;
	text-align: center;
}
h3 {
	font-size: large;
	font-weight: lighter;
	padding: 0em 0px .75em 0px;
}
p,ul {
	padding: 0em 0px 1em 0px;
	font-size: small;
	color: <?=$font_color?>;
}
ul {
	margin-left: 16px;
}
.left { text-align: left; }
.centered { text-align: center; margin-left: auto; margin-right: auto; }
.right { text-align: right; }
.clear { clear: both; height: 0px; margin: 0px; padding: 0px; font-size: 1px; }
.float-left { float: left; }
.float-right { float: right; }

/* Messes up jquery UI */
a, a:link, a:active, a:focus {
	padding: 0px 3px;
	color: <?=$font_color?>;
	text-decoration: none;
	outline: none;
	border-bottom: <?=$border_color?> solid 1px;
}
a:hover {
	background-color: #5c875f;
	color: #fff;
	border-bottom: #5c875f solid 1px;
}
input[type="button"]::-moz-focus-inner, input[type="submit"]::-moz-focus-inner {
   border: none;
}
input.text {
	width: 250px;
	margin: 0px;
	padding: 2px 6px;
	border: <?=$border_color?> solid 2px;
	font-size: 1.5em !important;
}
textarea.text {
	width: 250px;
	margin: 0px;
	padding: 2px 6px;
	border: <?=$border_color?> solid 2px;
	font-size: 1.25em !important;
	font-weight: bold;
}
.shaderow {
	background-color: <?=$shade_color?>;
}





/***** Main Element Styles *****/
#top {
	width: 100%;
	margin-bottom: 0px;
}
   #top .pagewidth {
		padding: 1em 0px;
		border-bottom: <?=$border_color?> solid 1px;
	}
	#logo {
		width: 300px;
		height: auto;
	}
	#top .float-right {
		margin-top: 1em;
	}
	#top a {
		text-align: right;
		padding: 6px 16px;
		border-top: <?=$border_color?> solid 1px;
		border-bottom: none;
	}
	#top a:hover {
		background-color: transparent;
		color: inherit;
		border-top: #5c875f solid 1px;
	}
	#top a.current, #top a.current:link {
		border-top: #5c875f solid 2px;
	}



#main {
	width: 100%;
	margin: 0px;
	padding: 0px;
}
	.pagewidth {
		width: 1000px;
		margin: 0px auto;
		padding: 0px 0px 3em 0px;
	}



#footer {
	width: 978px;
	padding: 12px 10px 0px 10px;
	margin: 3em auto 3em auto;
	border: <?=$border_color?> solid 1px;
	background-color: <?=$bg_color?>;
}
#footer .float-right { color: <?=$light_font_color?>; }
/***** End Main Element Syles *****/





/***** Minor Element Styles *****/
#calendar {
	width: 100%;
	border-spacing: 0px;
	background-color: <?=$bg_color?>;
}
#calendar h3 { font-size: 12px; font-weight: normal; padding-top: .6em; }
#calendar td, #calendar th {
   border: <?=$border_color?> solid 1px;
   border-left: none;
   width: 225px;
   vertical-align: top;
}
#calendar td {
   padding: 10px;
   border-top: none;
   color: <?=$light_font_color?>;
}
#calendar td.first_col, #calendar th.first_col {
	width: 248px;
   border-left: <?=$border_color?> solid 1px;
	color: <?=$font_color?>;
}





.button {
	width: 170px;
	height: 36px;
	display: block;
	margin: 0px auto 10px auto;
	background-image: url(<?=$submit_button?>);
	background-repeat: no-repeat;
	background-color: transparent;
	display: block;
	color: #fff;
	font-size: 115%;
	font-weight: bold;
	vertical-align: middle;	border-bottom: #bbb solid 1px;
	border: none;
}
.button:hover {
	background-image: url(<?=$submit_button_hover?>);
}
.button:active {
	background-image: url(<?=$submit_button?>);
}
/***** End Minor Element Styles *****/




/***** Application elements *****/
#response_box {
	width: 300px;
	margin: 5px 0px 2em auto;
	padding: 10px;
	/*background-color: <?=$shade_color?>;
	border: <?=$border_color?> solid 1px;*/
}
#calendar ul {
	min-height: 50px;
	margin: 0px;
	margin-bottom: 5px;
	padding: 0px;
	list-style: none;
	color: <?=$light_font_color?>
}
.todo_col {
	max-height: 250px;
	overflow-y: auto;
	overflow-x: hidden;
}

.task {
	font-size: 11px;
	margin: 3px 0px;
	padding: 3px 6px 4px 6px;
	overflow: hidden;
}
	.task:hover {
		padding: 2px 5px 3px 5px;
   	background-color: #eee !important;
		color: <?=$light_font_color?> !important;
   	border: <?=$border_color?> solid 1px;
	}
	.task input {
		vertical-align: middle;
	}
#calendar td#cat_new_add {
	color: <?=$light_font_color?>;
}
#calendar td div.add_task, #calendar td div.edit_cat {
	font-size: 8px;
	color: <?=$light_font_color?>;
	padding: 4px 5px 5px 5px;
}
#calendar td div.add_task:hover, #calendar td div.edit_cat:hover {
	padding: 3px 4px 4px 4px;
	background-color: <?=$shade_color?>;
   border: <?=$border_color?> solid 1px;
}

/***** End Application elements *****/





/***** jquery UI Adjustments *****/
.ui-dialog-title {
	color: #fff;
}
.ui-dialog-titlebar-close, .ui-dialog-titlebar-close span {
	border: none !important;
	text-decoration: none !important;
}
/***** End jquery UI Adjustments *****/





/***** COLOR CLASSES *****/
.bggreen { background-color: #5c875f; }
.bgwhite { background-color: #fff; }
.bgbrown { background-color: #4f3d33; }
.bggrey { background-color: #ccc; }
.bgltgreen { background-color: #71eb83; }
.green { color: #5c875f; }
.white { color: #fff; }
.brown { color: #4f3d33; }
.grey { color: #ccc; }
.ltgreen { color: #71eb83; }


.swatch {
	display: block;
	float: left;
	width: 60px;
	height: 50px;
	border: <?=$bg_color?> solid 3px;
}
.color1 {
	background-color: <?=$bg_color?>;
	color: <?=$light_font_color?>;
}
.color2 {
	background-color: #222;
	color: #fff;
}
.color3 {
	background-color: #9CF;
	color: #222;
}
.color4 {
	background-color: #9FF;
	color: #000;
}
.color5 {
	background-color: #C06;
	color: #fff;
}
.color6 {
	background-color: #CCFF99;
	color: #000;
}
.color7 {
	background-color: #FFFFCC;
	color: #000;
}
.color8 {
	background-color: #FFFF66;
	color: #000;
}
.color9 {
	background-color: #FFCC99;
	color: #000;
}
.color10 {
	background-color: #CCFFCC;
	color: #000;
}
.color11 {
	background-color: #CCFF33;
	color: #000;
}
.color12 {
	background-color: #CC99FF;
	color: #fff;
}
.color13 {
	background-color: #009900;
	color: #fff;
}
.color14 {
	background-color: #CC0033;
	color: #fff;
}
.color15 {
	background-color: #663366;
	color: #fff;
}
.color16 {
	background-color: #000033;
	color: #fff;
}
.color17 {
	background-color: #003333;
	color: #fff;
}
.color18 {
	background-color: #003399;
	color: #fff;
}
.color19 {
	background-color: #003300;
	color: #fff;
}
.color20 {
	background-color: #bbb;
	color: #000;
}
.color21 {
	background-color: #ddd;
	color: #444;
}

/***** END COLOR CLASSES *****/
