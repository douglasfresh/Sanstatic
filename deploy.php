<?php

$file = "less/creative.less";

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

require "less/lessphp/lessc.inc.php";

function autoCompileLess($inputFile, $outputFile) {
    // load the cache
    $cacheFile = $inputFile.".cache";
    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
    } else {
        $cache = $inputFile;
    }
    $less = new lessc;
    $less->setFormatter("compressed");
    $newCache = $less->cachedCompile($cache);
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        file_put_contents($outputFile, $newCache['compiled']);
    }
}
autoCompileLess($file, $file . '.css');
header('Content-type: text/css');
readfile('../' . $file . '.css');
?>