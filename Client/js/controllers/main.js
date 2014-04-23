angular.module('openLaw.controllers').controller('main', ['$scope', '$http', function($scope, $http){
  	var model = Model();
	console.log(Model.users);
	$scope.Model = Model;
}]);