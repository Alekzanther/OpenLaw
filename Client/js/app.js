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
  $routeProvider.when('/main', {templateUrl: 'partials/main.html', controller: 'main'});
  $routeProvider.when('/admin', {templateUrl: 'partials/admin.html', controller: 'admin'});
  $routeProvider.when('/details', {templateUrl: 'partials/details.html', controller: 'details'});
  $routeProvider.when('/login', {templateUrl: 'partials/login.html', controller: 'login'});
  $routeProvider.otherwise({redirectTo: 'partials/error.html'});
}]);
