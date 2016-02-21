<?php

/* testing the forms

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

if(isset($_GET["font1"])) 
	$font1 = $_GET["font1"];

if(isset($_GET["font2"]))
	$font2 = $_GET["font2"];

if(isset($_GET["color1"]))
	$color1 = "#" . $_GET["color1"];
else
	$color1 = '#76ff03';

if(isset($_GET["color2"]))
	$color2 = $_GET["color2"];

if(isset($_GET["bg"])) 
	$bg = $_GET["bg"];

$content = "@theme-primary:" . $color1 . "; @theme-dark:#222;";

echo $content;

file_put_contents($variables, $content);

require "less/lessphp/lessc.inc.php";
$less = new lessc;
$less->compileFile($input, $output);

$phantom_script= dirname(__FILE__). '/js/get-website.js'; 
$response =  exec ('phantomjs ' . $phantom_script);
echo  htmlspecialchars($response);

*/ 

?>

<!DOCTYPE html>
<html lang="en" ng-app="app" ng-controller="ContentfulCtrl">

<head>
	<title>Design elements configuration</title>
	<!-- Angular -->
	<script src="https://storage.googleapis.com/cdnsanstatic/js/angular.min.js"></script>
    <script src="https://storage.googleapis.com/cdnsanstatic/js/contentful.min.js"></script>
    <script src="http://sanstatic.com/site/js/angular-route.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://storage.googleapis.com/cdnsanstatic/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://storage.googleapis.com/cdnsanstatic/css/animate.min.css" type="text/css">
    <link rel="stylesheet" href="http://sanstatic.com/site/css/creative.css" type="text/css">

<div ng-controller="ExampleController">
  <form novalidate class="simple-form">
  	<h1>Design elements configuration</h1>
    Name: <input type="text" ng-model="user.name" /><br />
    E-mail: <input type="email" ng-model="user.email" /><br />
    Gender: <input type="radio" ng-model="user.gender" value="male" />male
    <input type="radio" ng-model="user.gender" value="female" />female<br />
    <input type="button" ng-click="reset()" value="Reset" />
    <input type="submit" ng-click="update(user)" value="Save" />
  </form>
  <pre>user = {{user.name}}, {{user.email}}, and {{user.gender}}</pre>
  <pre>master = {{master | json}}</pre>
</div>

<script>
  angular.module('formExample', [])
    .controller('ExampleController', ['$scope', function($scope) {
      $scope.master = {};

      $scope.update = function(user) {
        $scope.master = angular.copy(user);
      };

      $scope.reset = function() {
        $scope.user = angular.copy($scope.master);
      };

      $scope.reset();
    }]);
</script>