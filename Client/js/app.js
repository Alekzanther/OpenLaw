'use strict';


// Declare app level module which depends on filters, and services
angular.module('openLaw', [
  'ngRoute',
  'openLaw.filters',
  'openLaw.services',
  'openLaw.directives',
  'openLaw.controllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/home', {templateUrl: 'partials/partial1.html', controller: 'home'});
  $routeProvider.when('/login', {templateUrl: 'partials/partial2.html', controller: 'login'});
  $routeProvider.otherwise({redirectTo: 'partials/error.html'});
}]);
