<?php

$file = 'static.html';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Write the contents to the file
file_put_contents($file, clean($request->hmtl));

function clean(html) {
	//Remove ng tags
	var $filteredHTML = preg_replace('/<p style="(.+?)">(.+?)<\/p>/i', "<p>$2</p>", $html);
}

?>