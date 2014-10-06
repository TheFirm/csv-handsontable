APP.directive('selectBox', function ($timeout) {
    return {
        link: function (scope, element, attr) {
            if (scope.$last){
                $timeout(function () {
                    scope.$emit('ngRepeatFinished',element);
                });
            }
        }
    };
});