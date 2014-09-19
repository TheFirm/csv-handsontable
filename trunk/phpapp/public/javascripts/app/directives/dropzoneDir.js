
APP.directive('ngDropZone', function() {
    return {
        link: function(scope, element, attrs) {
            var defaultOption = {
                paramName: "file",
                url: "/upload.php",
                maxFilesize: 1 //MB
            };

            element.dropzone(angular.extend(defaultOption, scope.options));
        },
        restrict: 'C',
        scope: { options: '=' }
    }
});