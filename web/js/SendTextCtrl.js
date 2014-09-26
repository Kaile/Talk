function SendTextCtrl($scope, $http) {
	$scope.inputText = '';
	
	$scope.storeText = function() {
		post('?r=site/store', {text : $scope.inputText})
			.done(function() {
				alert('done');
			}).fail(function() {
				alert('fail');
			});
	};
}