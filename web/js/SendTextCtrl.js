
//TODO: Сделать параметр, указывающий на то, кому отправляется сообщение
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

    //TODO: Переделать все в класс
    function updateText(text) {
        post(urlHelper('store'), {text: text, cmd: 'update'})
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

            if (data.length) {
                post('?r=site/store', {text: data, id_to: $('#users-list').val()})
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
}