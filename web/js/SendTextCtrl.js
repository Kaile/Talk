function SendTextCtrl($scope) {
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
	//TODO: Нужно сделать приостановку запросов если текста для вывода нет
	$scope.loadText = function() {
		setInterval(function() {
			get('?r=site/load')
				.done(function(data) {
					if (data.length) {
						$('#outputText').text(data);
					}
				})
				.fail(function() {
					console.error('Can\'t retrieve data');
				});
		}, 100);		
	};
	
	setTimeout($scope.loadText(), 1000);	
}