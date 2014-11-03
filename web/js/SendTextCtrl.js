//TODO: Теперь встает проблема что отправлять при удалении текста
/**
 * Контроллер, описывающий функции отправки данных на сервер
 * @param {Object} $scope - Пространство имен контроллера
 */
function SendTextCtrl($scope) {
	$scope.inputText = '';
    $scope.startIndex = 0;
    $scope.isOn = false;
    $scope.intervalId = null;
    $scope.intervalPeriod = 1000; //ms
    $scope.contacts = {};

    //TODO: Переделать все в класс
    function updateText(text) {
        post(urlHelper('store'), {text: text, id_to: getContacts(), cmd: 'update'})
            .done(function() {
                logInfo('Text on server is up to date');
            })
            .fail(function(data) {
                logError('Text not updated :( : ' + data);
            });
    };

    $scope.turnOn = function() {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function () {
            if ($scope.startIndex >= $scope.inputText.length) {
                updateText($scope.inputText);
            }

            var data = $scope.inputText.substr($scope.startIndex);

            $scope.startIndex = $scope.inputText.length;

            if (data.length && getContacts()) {
                //TODO: Придумать принцип для удобного расширения команд и их обработки
                post(urlHelper('store'), {text: data, id_to: getContacts(), cmd: 'store'})
                    .done(function () {
                        logInfo('text is saved');
                    })
                    .fail(function (data) {
                        logError(data);
                    });
            } else {
                clearInterval($scope.intervalId);
                $scope.isOn = false;
            }
        }, $scope.intervalPeriod);
    };

	$scope.storeText = function() {
        if (! $scope.isOn) {
            $scope.turnOn();
        }
	};

	$scope.fixMessage = function() {
		addMessage($scope.inputText);

		post(urlHelper('fix'), {text: $scope.inputText, id_to: getContacts()})
			.done(function() {
				$scope.inputText = '';
			})
			.fail(function(data) {
				logError('Can not to fix message to user: ' + getContacts());
			});
		$scope.inputText = '';
	}
}
