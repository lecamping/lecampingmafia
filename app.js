/* global angular */

var mafiapp = angular.module('mafiapp', ['ngResource', 'ngSanitize']);

mafiapp.factory('Startup', function($resource) {
  return $resource('startups.json');
});

mafiapp.controller('StartupCtrl', function($scope, Startup) {
  $scope.startups = Startup.query();
});