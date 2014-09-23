function SendTextCtrl($scope, $http) {
	$scope.inputText = '';
	
	$scope.storeText = function() {
		post('?r=site/store', {text : $scope.inputText});
//		$http.post('?r=site/store', {text : $scope.inputText});
	};
}