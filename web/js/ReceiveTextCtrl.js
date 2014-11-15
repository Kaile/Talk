/**
 * Created by Mihail Kornilov on 26.09.2014.
 */

/**
 * Контроллер, описывающий функции загрузки данных с сервера
 * @param {Object} $scope - Пространство имен контроллера
 */
function ReceiveTextCtrl($scope) {
	
	/**
	 * Идентификатор функции setInterval запускаемой в пространстве контроллера
	 * @type Number
	 */
    $scope.intervalId = null;
	
	/**
	 * Индикатор работы функции загрузки данных с сервера
	 * @type Boolean
	 */
    $scope.isOn = false;

	/**
	 * 
	 * @type Number
	 */
    var intervalLoad = 300;
	var intervalCheck = 3000;

    //TODO: Нужно сделать приостановку запросов если текста для вывода нет
    $scope.turnOn = function () {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function() {
            get(urlHelper('load'))
                .done(function (data) {
                    data = JSON.parse(data);
                    logInfo(data);
                    if (data.data !== null) {
                        if (data.cmd === 'update') {
                            $('#outputText').html(data.data);
                        } else {
                            softOutput($('#outputText'), data.data, intervalLoad);
                        }
                    } else {
                        $scope.isOn = false;
                        clearInterval($scope.intervalId);
                    }
                })
                .fail(function () {
                    logError('Can\'t retrieve data');
                });
        }, intervalLoad);
    };

	/**
	 * Через определенный интервал времени запускает функцию загрузки текста с 
	 * сервера
	 */
	setInterval(function() {
		if (! $scope.isOn) {
			$scope.turnOn();
		}
	}, intervalCheck);
}