function SendTextCtrl($scope, $http) {
	$scope.inputText = '';
	
	$scope.storeText = function() {
		 $http.post('', 
			{
				'text' : $scope.inputText,
				'r' : 'site/store',
			})
			.success(function(data) {
				console.info(data);
			})
			.error(function(data) {
				console.error(data);
			});
	};
}