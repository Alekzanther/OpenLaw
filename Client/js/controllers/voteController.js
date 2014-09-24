angular.module('openLaw.controllers').controller('voteController', ['$scope', '$http', function($scope, $http){
	$scope.userVoteStatus = 0;
	
	console.log($scope.votes);
	
	total = 0;
	for(vote in $scope.article.votes)
	{
		total = total +  parseInt($scope.article.votes[vote].value);
	}
	
	$scope.voteCount = total;
	
	$scope.voteUp = function()
	{
		$scope.voteCount += 1;
	};
	
	$scope.voteDown = function()
	{
		$scope.voteCount -= 1;
	};
}]);