/**
 * Created by boom on 18.09.14.
 */

APP.controller('alertCtrl', function($scope, $rootScope, $route, $routeParams) {
    console.log('Controller: alertCtrl');

    $rootScope.$on('popup.message', function(event, data) {
        console.log(data);

        if(data.success){
            $scope.message = {
                error: false,
                text: "Validation successful. You may import data."
            };
        } else {
            var errorText = 'Error';
            console.log(data.errors.bestMatch);
            var bestMatch = data.errors.bestMatch;
            var configName = Object.keys(bestMatch)[0];
            var errors = bestMatch[configName];

            if(errors.from_file.length === 0 && errors.from_conf.length !== 0){
                errorText = 'You are missing columns: ' + errors.from_conf.join(', ')
            } else if(errors.from_file.length !== 0 && errors.from_conf.length === 0){
                errorText = 'You have to much columns: ' + errors.from_file.join(', ')
            } else if(errors.from_file.length !== 0 && errors.from_conf.length !== 0){
                errorText = 'You have errors columns: ' + errors.from_file.join(', ')
            }

            $scope.message = {
                error: true,
                text: errorText
            };
        }
    });

});