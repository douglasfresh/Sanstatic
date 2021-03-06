<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$compile = false;
$content = "No variables found.";

if(isset($_GET["color1"])) {
	$compile = true;
	$color1 = $_GET["color1"];
	$content = "@primaryColor:" . $color1 . ";";
}

if(isset($_GET["color2"])) {
	$color2 = $_GET["color2"];
	$content += " @secondaryColor:" . $color2 . ";";
}

if(isset($_GET["font1"])) {
	$font1 = $_GET["font1"];
	$content += " @headingFont:" . $font1 . ";";
}

if(isset($_GET["font2"])) {
	$font2 = $_GET["font2"];
	$content += " @paragraphFont:" . $font2 . ";";
}

if(isset($_GET["bg"])) {
	$bg = $_GET["bg"];
	$content += " @background:" . $bg . ";";
}

if($compile) {
	// Resources
	$variables = "less/variables.less";
	$input = "less/creative.less";
	$output = "css/creative.css";

	// Set the LESS variables
	$vars = "@theme-primary:" . $color1 . "; @theme-dark:#222;";
	$content = $vars;
	file_put_contents($variables, $vars);

	// Compile the LESS to CSS
	require "less/lessphp/lessc.inc.php";
	$less = new lessc;
	$less->compileFile($input, $output);
}

// Create static index.html with PhantomJS
// Push new CSS & HTML to GitHub

?>

<!-- JS -->
<script src="https://storage.googleapis.com/cdnsanstatic/js/angular.min.js"></script>
<script src="https://storage.googleapis.com/cdnsanstatic/js/contentful.min.js"></script>
<script src="http://sanstatic.com/site/js/angular-route.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="https://storage.googleapis.com/cdnsanstatic/css/bootstrap.min.css" type="text/css">

<!-- Inline CSS -->
<style>
	form {
		width:300px;
    	margin-left:15px;
	}
	form input {
		float:right;
	}
</style>

<!-- deployApp -->
<div ng-app="deployApp" ng-controller="formCtrl" action="deploy.php">
	<div class="container" style="width:90%">
		<div class="row">
	    	<div class="col-lg-12">
		    	<h3>Settings</h3>
			    <form novalidate action="deploy.php" method="get">
			    	<div class="row">
					    <label>Contentful Space</label>
					    <input type="text" ng-model="design.space" name="space"><br/>
					</div>
			    	<div class="row">
					    <label>Primary Color</label>
					    <input type="text" ng-model="design.color1" name="color1"><br/>
					</div>
					<div class="row">
					    <label>Secondary Color</label>
					    <input type="text" ng-model="design.color2" name="color2"><br/>
				    </div>
					<div class="row">
					    <label>Heading Font</label>
					    <input type="text" ng-model="design.font1" name="font1"><br/>
				    </div>
					<div class="row">
				    	<label>Paragraph Font</label>
				    	<input type="text" ng-model="design.font2" name="font2"><br/>
			    	</div>
					<div class="row">
					    <label>Background</label>
					    <input type="text" ng-model="design.bg" name="bg"><br/>
					</div>
					<br/>
					<div class="row">
					    <button ng-click="reset()">RESET</button>
					    <button type="submit">DEPLOY</button>
					</div>
			   	</form>
		   </div>
		</div>
	    <div class="row">
	        <div class="col-lg-12">
                <h3>Contentful Brand</h3>
                <p class="text-muted">{{brand}}</p>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-lg-12">
                <h3>Form Inputs</h3>
                <p class="text-muted">Color1: {{design.color1}}, Color2: {{design.color2}}, Font1: {{design.font1}}, Font2: {{design.font2}}, and BG: {{design.bg}}</p>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-lg-12">
                <h3>LESS Variables</h3>
                <p class="text-muted"><?php echo $content; ?></p>
	        </div>
	    </div>
		<div class="row">
	    	<div class="col-lg-12">
		    	<h3>Resources</h3>
		    	<ul>
		    		<li><a href="https://www.google.com/design/spec/style/color.html" target="_blank">Google Colors</a></li>
		    		<li><a href="https://www.google.com/design/spec/style/color.html" target="_blank">Google Fonts</a></li>
		    		<li><a href="https://www.pexels.com/" target="_blank">Pexel Stock Photos</a></li>
		    	</ul>
		    </div>
		</div>
	</div>
</div>

<script>
	// Angular deployApp module with formCtrl controller
	var app = angular.module('deployApp', []);

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
		      $scope.design["color1"] = entries[0].fields.primaryColor;
		      $scope.design["color2"] = entries[0].fields.secondaryColor;
		      $scope.design["font1"] = entries[0].fields.primaryFont;
		      $scope.design["font2"] = entries[0].fields.secondaryFont;
		      $scope.design["bg"] = entries[0].fields.picture;
		      $scope.design["space"] = entries[0].fields.space;
		   });
	   };

	   $scope.reset();

	}]);
</script>