function SendTextCtrl($scope) {
	$scope.inputText = '';
    $scope.startIndex = 0;
    $scope.isOn = false;
    $scope.intervalId = null;

    $scope.turnOn = function() {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function () {
            var data = $scope.inputText.substr($scope.startIndex);

            $scope.startIndex = $scope.inputText.length;

            if (data.length) {
                post('?r=site/store', {text: data})
                    .done(function () {
                        console.log('text is saved');
                    })
                    .fail(function (data) {
                        console.error(data);
                    });
            } else {
                clearInterval($scope.intervalId);
                $scope.isOn = false;
            }
        }, 500);
    }

    //TODO: Сделать отправку текста порциями
	$scope.storeText = function() {
        if (! $scope.isOn) {
            $scope.turnOn();
        }
	};

    var interval = 500;

	//TODO: Нужно сделать приостановку запросов если текста для вывода нет
	$scope.loadText = function() {
		setInterval(function() {
			get('?r=site/load')
				.done(function(data) {
					if (data.length) {
						softOutput('#outputText', data);
					}
				})
				.fail(function() {
					console.error('Can\'t retrieve data');
				});
		}, interval);
	};
	
	//setTimeout($scope.loadText(), 1000);
}