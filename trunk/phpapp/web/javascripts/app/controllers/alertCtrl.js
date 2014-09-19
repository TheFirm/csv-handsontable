/**
 * Created by boom on 18.09.14.
 */

APP.controller('alertCtrl', function($scope, $rootScope) {
    $scope.close = function () {
        $scope.message = null;
    };

    $rootScope.$on('popup.message', function(event, data) {
        console.log(data);

        $scope.message = data;
    });

});