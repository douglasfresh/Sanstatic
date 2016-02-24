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

// Contenful Controller
app.controller('ContentfulCtrl', ['$scope', '$q', '$http', '$routeParams', function($scope, $q, $http, $routeParams) {

  // View Model
  var vm = this;

  vm.status = 'done';

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

    angular.element(document).ready(function () {
      var html = document.getElementsByTagName('html')[0];
      var includes = document.getElementById('includes');

      console.log(angular.outerHTML);
      html.removeChild(includes);

      var data = {
          'html' : document.getElementsByTagName('html')[0].outerHTML,
      };
      $http.post("http://sanstatic.com/config/static.php", data).success(function(data, status) {
          console.log('post complete');
      }) 
    });

  });

}]);

app.filter("getFont", function() {

  //convert + to space
  return function(input){
    if(input) return input.replace(/\s+/g," "); 
  }

});