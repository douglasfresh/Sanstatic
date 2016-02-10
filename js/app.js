(function () {

  // Modules
  angular.module('app', ['contentful']);

  angular
    .module('app')
    .config(function (contentfulProvider) {
      contentfulProvider.setOptions({
        space: 'bhbl6r0rag31',
        accessToken: '9249ff3590642679bcf612864e139395ad456fdad79e3870b78f9221da8d4726'
      });
    });

  angular
    .module('app')
    .controller('MenuCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entries("content_type=menuItem&order=fields.order");

      promise.then(
          function (response) {
            $scope.menu = angular.fromJson(response.data.items);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

      promise = contentful.entry('6BSzb6P3LaU2ge6Ww0s0WO');

      promise.then(
          function (response) {
            $scope.brand = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

  angular
    .module('app')
    .controller('DemoCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entries();

      promise.then(
          function (response) {
            $scope.objects = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('HeaderCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('7Ky7tWQopOWqgkOuw4UI2o');

      promise.then(
          function (response) {
            $scope.header = angular.fromJson(response.data);
            $scope.bgImage = angular.fromJson(response.data.fields.bgImage.fields)
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('StoryCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('45kAzMGvLGQq2m8GicSQYA');

      promise.then(
          function (response) {
            $scope.story = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('ContentCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('2cSNbqs3PSWQC6GAEQoC6Q');

      promise.then(
          function (response) {
            $scope.content = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('DesignCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('4lyRGg3ZmM6IgIe8AMg06C');

      promise.then(
          function (response) {
            $scope.design = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('StartCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('Jw638rRTKUKW0ysW828o8');

      promise.then(
          function (response) {
            $scope.start = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

    angular
    .module('app')
    .controller('ContactCtrl', function ($scope, contentful) {

      var promise;

      $scope.busy = false;
      $scope.response = null;

      promise = contentful.entry('3jfyvgSzqECi4wCwQE88IK');

      promise.then(
          function (response) {
            $scope.contact = angular.fromJson(response.data);
            $scope.busy = false;
          },
          function (response) {
            $scope.busy = false;
          }
        )

    });

})();
