// AngularJS Application
var app = angular.module( "app", ['ngRoute'] );

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

// Specify Template Routes
app.config(function($routeProvider) {
  $routeProvider
    .when("/",
    {
      templateUrl: "templates/creative.html",
    })
    .when('/:template', 
    {
      templateUrl: function(params) {
        return "templates/" + params.template + ".html";
      },
      controller: 'ContentfulCtrl'
    })
});

// Contenful Controller
app.controller('ContentfulCtrl', ['$scope', '$q', '$http', '$routeParams', function($scope, $q, $http, $routeParams) {

  // View Model
  var vm = this;

  // Contentful Entries
  var entries = $q.when(client.entries());

  vm.slides = Array();
  vm.sections = Array();
  vm.menu = Array();

  entries.then(function(entries) {

    entries.forEach(function(entry) {

      switch(entry.sys.contentType.sys.id) {
        case "header":
          vm.header = entry.fields;
          break;

        case "story":
          vm.story = entry.fields;
          break;

        case "start":
          vm.start = entry.fields;
          break;

        case "brand":
          vm.brand = entry.fields;
          break;

        case "contact":
          vm.contact = entry.fields;
          break;

        case "content":
          vm.content = entry.fields;
          break;

        case "design":
          vm.design = entry.fields;
          break;

        case "slide":
          vm.slides.push(entry.fields);
          break;

        case "section":
          vm.sections.push(entry.fields);
          break;

        case "menuItem":
          vm.menu.push(entry.fields);
          break;

        default:
          break;
      } 

    });

  });

}]);

// Format Font Name
app.filter("getFont", function() {

  //convert + to space
  return function(input){
    if(input) return input.replace(/\s+/g," "); 
  }

});

// Set Template On Route Change
app.run(['$rootScope', function($rootScope) {

    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {

      if(current.params.template)
        $rootScope.template = current.params.template;

    });

}]);