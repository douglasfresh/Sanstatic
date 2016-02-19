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

function ContentfulCtrl($scope, $q) {
  var entries = $q.when(client.entries());

  $scope.sections = Array();
  $scope.menu = Array();

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
          less.modifyVars({'@theme-primary': $scope.brand.colorScheme})
          break;
        case "contact":
          $scope.contact = entry.fields;
          break;
        case "design":
          $scope.design = entry.fields;
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
}

angular.module('app', []).
  controller('ContentfulCtrl', ContentfulCtrl)
  .filter("getFont", function(){
    return function(input){
      if(input) return input.replace(/\s+/g," "); 
    }
  });