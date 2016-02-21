<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$variables = "less/variables.less";
$input = "less/creative.less";
$output = "css/creative.css";

// Take in design specs
// Create variables.less
// Compile less
// Create static index.html with Phantom
// Push to GitHub

if(isset($_GET["font1"])) {
	$font1 = $_GET["font1"];
}
else{
	$font1 = "Open+Sans";
}

if(isset($_GET["font2"])) {
	$font2 = $_GET["font2"];
}
else {
	$font2 = "Merriweather";
}

if(isset($_GET["color1"])) {
	$color1 = "#" . $_GET["color1"];
}
else {
	$color1 = '#76ff03';
}

if(isset($_GET["color2"])) {
	$color2 = $_GET["color2"];
}
else {
	$color2 = "#f05f40";
}

if(isset($_GET["bg"])) {
	$bg = $_GET["bg"];
}
else {
	$bg = "http://sanstatic.com/Themes/startbootstrap-creative-1.0.2/img/header.jpg";
}

$content = "@primaryColor:" . $color1 . "; @secondaryColor: " . $color2 . "; @headingFont: " . $font1 . "; @paragraphFont: " . $font2 . "; @background:" . $bg . ";";

// Set the LESS variables
$vars = "@theme-primary:" . $color1 . "; @theme-dark:#222;";
file_put_contents($variables, $vars);

// Compile the LESS to CSS
require "less/lessphp/lessc.inc.php";
$less = new lessc;
$less->compileFile($input, $output);

// Create static index.html
//$phantom_script= dirname(__FILE__). '/js/get-website.js'; 
//$response =  exec ('phantomjs ' . $phantom_script);
//echo  htmlspecialchars($response);

?>

<!-- Angular -->
<script src="https://storage.googleapis.com/cdnsanstatic/js/angular.min.js"></script>
<script src="https://storage.googleapis.com/cdnsanstatic/js/contentful.min.js"></script>
<script src="http://sanstatic.com/site/js/angular-route.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="https://storage.googleapis.com/cdnsanstatic/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="https://storage.googleapis.com/cdnsanstatic/css/animate.min.css" type="text/css">
<link rel="stylesheet" href="http://sanstatic.com/site/css/creative.css" type="text/css">

<div ng-app="myApp" ng-controller="formCtrl" action="deploy.php">
  <form novalidate>
    Primary Color:<br>
    <input type="text" ng-model="design.color1" name="color1"><br>
    Secondary Color:<br>
    <input type="text" ng-model="design.color2" name="color2"><br>
    Heading Font:<br>
    <input type="text" ng-model="design.font1" name="font1"><br>
    Paragraph Font:<br>
    <input type="text" ng-model="design.font2" name="font2"><br>
    Background:<br>
    <input type="text" ng-model="design.bg" name="bg"><br>
    <br><br>
    <button ng-click="reset()">RESET</button>
    <button type="submit">DEPLOY</button>
  </form>
  <p>Contentful Brand = {{brand}}</p>
  <p ng-repeat="(field, value) in brand">Form Inputs = {{contentful.toString();}}</p>
  <p>URL Parameters = <?php echo $content; ?></p>
</div>

<script>
var app = angular.module('myApp', []);
app.controller('formCtrl', ['$scope', '$q', '$http', function($scope, $q, $http) {

   // Contentul API Client
   var client = contentful.createClient({
      // ID of Space
     space: 'bhbl6r0rag31',

     // A valid access token within the Space 
     accessToken: '9249ff3590642679bcf612864e139395ad456fdad79e3870b78f9221da8d4726',

     // Enable or disable SSL. Enabled by default.
     secure: true,

     // Set an alternate hostname, default shown.
     host: 'cdn.contentful.com',

     // Resolve links to entries and assets
     resolveLinks: true,

   });

   $scope.reset = function() {
   	   var entries = $q.when(client.entries({content_type: 'brand'}));

	   entries.then(function(entries) {
	      $scope.brand = entries[0].fields;
	      $scope.design = new Array();
	      $scope.design["color1"] = entries[0].fields.colorScheme;
	      $scope.design["font1"] = entries[0].fields.primaryFont;
	      $scope.design["font2"] = entries[0].fields.secondaryFont;
	      $scope.design["bg"] = entries[0].fields.picture;
	   });
   };

}]);
</script>