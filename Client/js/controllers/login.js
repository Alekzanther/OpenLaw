angular.module('openLaw.controllers').controller('login', ['$scope', '$http', function($scope, $http){
	$scope.username = "username";
	$scope.password = "password";
	
	$scope.authenticate = function(){
		$.post( "http://localhost/OpenLaw/Server/DataAccess/authenticate.php", { username : $scope.username, password : $scope.password }, function( data ) { console.log("klar"); });
	}; 
	$scope.create = function(){
		newUser = new user();
		newUser.name = $scope.username;
		model.create(newUser);
	};
}]);