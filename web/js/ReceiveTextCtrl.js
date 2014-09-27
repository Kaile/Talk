/**
 * Created by Mihail Kornilov on 26.09.2014.
 */

/**
 * 
 * @param {Object} $scope - Пространство имен контроллера
 */
function ReceiveTextCtrl($scope) {
    $scope.intervalId = null;
    $scope.isOn = false;

    var intervalLoad = 300;
	var intervalCheck = 3000;

    //TODO: Нужно сделать приостановку запросов если текста для вывода нет
    $scope.turnOn = function () {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function() {
            get('?r=site/load')
                .done(function (data) {
                    if (data.length) {
                        softOutput('#outputText', data, intervalLoad);
                    } else {
                        $scope.isOn = false;
                        clearInterval($scope.intervalId);
                    }
                })
                .fail(function () {
                    console.error('Can\'t retrieve data');
                });
        }, intervalLoad);
    };

	setInterval(function() {
		if (! $scope.isOn) {
			$scope.turnOn();
		}
	}, intervalCheck);
}