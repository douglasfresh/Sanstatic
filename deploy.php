<?php

// Take in design specs
// Create variables.less
// Compile less
// Create static index.html with Phantom
// Push to GitHub

if(isset[$_GET["font1"]]) 
	$font1 = $_GET["font1"];
if(isset[$_GET["font2"]]) 
	$font2 = $_GET["font2"];
if(isset[$_GET["color1"]]) 
	$color1 = $_GET["color1"];
if(isset[$_GET["color2"]]) 
	$color2 = $_GET["color2"];
if(isset[$_GET["bg"]]) 
	$bg = $_GET["bg"];

require "lessc.php";

$less = new lessc;
echo $less->compileFile('less/creative.less');

?>