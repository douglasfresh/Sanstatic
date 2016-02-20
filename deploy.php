<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$variables = "less/variables.less";
$input = "less/creative.less";
$output = "css/less.css";

// Take in design specs
// Create variables.less
// Compile less
// Create static index.html with Phantom
// Push to GitHub

if(isset($_GET["font1"])) 
	$font1 = $_GET["font1"];
if(isset($_GET["font2"]))
	$font2 = $_GET["font2"];
if(isset($_GET["color1"]))
	$color1 = $_GET["color1"];
if(isset($_GET["color2"]))
	$color2 = $_GET["color2"];
if(isset($_GET["bg"])) 
	$bg = $_GET["bg"];

$content = "@theme-primary:" . $color1 . "; @theme-dark:#222;";

echo $content;

file_put_contents($variables, $content);

require "less/lessphp/lessc.inc.php";
$less = new lessc;
echo $less->compileFile($input, $output);

?>