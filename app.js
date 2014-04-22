/* global angular */

var mafiapp = angular.module('mafiapp', ['ngResource', 'ngSanitize']);

mafiapp.factory('Startup', function($resource) {
  return $resource('startups.json');
});

mafiapp.controller('StartupCtrl', function($scope, Startup) {
  $scope.startups = Startup.query();
});

// transforms email addresses to mailto: strings
mafiapp.filter('mailto', function() {
  var replacePattern = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim;
  
    return function(text) {        
      if(text.match(replacePattern)) {
        text = text.replace(replacePattern, "mailto:$1");
      }
      return text;        
    };
});
