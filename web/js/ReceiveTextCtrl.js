/**
 * Created by Mihail Kornilov on 26.09.2014.
 */
function ReceiveTextCtrl($scope) {
    $scope.intervalId = null;
    $scope.isOn = false;

    var interval = 700;

    //TODO: Нужно сделать приостановку запросов если текста для вывода нет
    $scope.turnOn = function () {
        $scope.isOn = true;

        $scope.intervalId = setInterval(function() {
            get('?r=site/load')
                .done(function (data) {
                    if (data.length) {
                        softOutput('#outputText', data);
                    } else {
                        $scope.isOn = false;
                        clearInterval($scope.intervalId);
                    }
                })
                .fail(function () {
                    console.error('Can\'t retrieve data');
                });
        }, interval);
    };

    setTimeout($scope.turnOn(), 1000);
}