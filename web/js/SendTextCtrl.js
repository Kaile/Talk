function SendTextCtrl($scope, $http) {
	$scope.inputText = '';
	
	$scope.storeText = function() {
		post('?r=site/store', {text : $scope.inputText})
			.done(function() {
				console.log('text is saved');
			})
			.fail(function(data) {
				console.error(data);
			});
	};
	//Нужно сделать приостановку запросов
	$scope.loadText = function() {
		setInterval(function() {
			get('?r=site/load')
				.done(function(data) {
					if (data.length) {
						$('#outputText').text(data);
					} else {
						setTimeout(true, 5000);
					}
				})
				.fail(function() {
					console.error('Can\'t retreave data');
				});
		}, 100);		
	};
	
	setTimeout($scope.loadText(), 1000);	
}