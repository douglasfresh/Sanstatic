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

// AngularJS Application
var app = angular.module( "app", ['ngRoute'] );

app.config(function($routeProvider) {
  $routeProvider
    .when("/",
    {
      templateUrl: "http://sanstatic.com/site/templates/creative.html",
    })
    .when('/:template', 
    {
      templateUrl: function(params) {
        return 'http://sanstatic.com/site/templates/' + params.template + '.html';
      },
      controller: 'ContentfulCtrl'
    })
});

app.controller('ContentfulCtrl', ['$scope', '$q', '$http', function($scope, $q, $http) {
  $scope.slides = Array();
  $scope.sections = Array();
  $scope.menu = Array();

  $scope.setColor = function(color) {
    less.modifyVars({
      '@theme-primary': color
    });
  }

  var entries = $q.when(client.entries());
  
  entries.then(function(entries) {

    entries.forEach(function(entry) {

      switch(entry.sys.contentType.sys.id) {
        case "header":
          $scope.header = entry.fields;
          break;

        case "story":
          $scope.story = entry.fields;
          break;

        case "start":
          $scope.start = entry.fields;
          break;

        case "brand":
          $scope.brand = entry.fields;
          break;

        case "contact":
          $scope.contact = entry.fields;
          break;

        case "content":
          $scope.content = entry.fields;
          break;

        case "design":
          $scope.design = entry.fields;
          break;

        case "slide":
          $scope.slides.push(entry.fields);
          break;

        case "section":
          $scope.sections.push(entry.fields);
          break;

        case "menuItem":
          $scope.menu.push(entry.fields);
          break;

        default:
          break;
      } 
    });
  });
}]);

app.filter("getFont", function() {
  //convert + to space
  return function(input){
    if(input) return input.replace(/\s+/g," "); 
  }
});

app.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
      $rootScope.template = current.params.template;
    });
}]);