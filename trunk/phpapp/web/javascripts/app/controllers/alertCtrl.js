APP.controller('alertCtrl', function($scope, $rootScope) {
    $scope.close = function () {
        $scope.message = null;
    };

    $rootScope.$on('popup.message', function(event, data) {
        $scope.message = data;
    });
});