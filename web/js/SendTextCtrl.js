function SendTextCtrl($scope, $http) {
	$scope.inputText = '';
	
	$scope.storeText = function() {
		 Request({
			 uri: '',
			 data: '',
			 method: 'POST',
		 });
	};
}