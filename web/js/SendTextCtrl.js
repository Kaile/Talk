
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
    $scope.intervalPeriod = 800; //ms

    $scope.turnOn = function() {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function () {
            var data = $scope.inputText.substr($scope.startIndex);

            $scope.startIndex = $scope.inputText.length;



            if (data.length) {
                post('?r=site/store', {text: data, id_to: $('#users-list').val()})
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
        }, $scope.intervalPeriod);
    };

	$scope.storeText = function() {
        if (! $scope.isOn) {
            $scope.turnOn();
        }
	};
}