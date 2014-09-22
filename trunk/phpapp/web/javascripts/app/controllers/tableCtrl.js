/**
 * Created by boom on 18.09.14.
 */
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
APP.controller('tableCtrl', function($scope, $rootScope, $location, fileUploadResponseService) {

    $scope.tableData = fileUploadResponseService.getFileUploadResponse();
    $scope.tableHeaderSelects = [];

    //if empty table data, got to root path
    if(!$scope.tableData || Object.keys($scope.tableData).length === 0){
        $location.path("/");
    }

    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent,element) {
        $(element.parent()).selectric('refresh');
    });

    $scope.countUnknownColumns = 1;

    $scope.deleteColumn = function (index) {
        //if (!confirm("Delete column?")) {
        //    return false;
        //}
        //var test = {success:true};
        //$rootScope.$broadcast('errorEvent', test);

        var removedColumn = $scope.tableData.headers.splice(index, 1);
        $scope.tableData.data.forEach(function (rowItem) {
            delete rowItem[removedColumn];
        });
        //$scope.$apply();
    };

    $scope.editHeader = function (colNum, newValue) {
        var oldHeaderValue = $scope.tableData.headers[colNum];
        $scope.tableData.headers[colNum] = newValue;

        $scope.tableData.data.forEach(function (dataItem) {
            if(dataItem.hasOwnProperty(oldHeaderValue)){
                dataItem[newValue] = dataItem[oldHeaderValue];
                delete dataItem[oldHeaderValue];
            } else {
                dataItem[newValue] = "";
            }
        });
        $scope.$apply();
    };

    $scope.editCell = function (rowNum, colNum, newValue) {
        var rowItem = $scope.tableData.data[rowNum];

        var i = 0;
        for(var cellItem in rowItem){
            if(rowItem.hasOwnProperty(cellItem)){
                if(i === colNum){
                    debugger;
                    rowItem[cellItem] = newValue;
                    break;
                } else {
                    i++;
                }
            }
        }
        $scope.$apply();
    };

    $scope.addRow = function () {
        var rowItem = {};
        $scope.tableData.headers.forEach(function (headerTitle) {
            rowItem[headerTitle] = "";
        });
        $scope.tableData.data.push(rowItem);
        $scope.$apply();
    };

    $scope.addColumn = function () {
        var newHeaderName = "Unknown" + $scope.countUnknownColumns;
        $scope.tableData.headers.push(newHeaderName);
        $scope.countUnknownColumns++;
        $scope.tableData.data.forEach(function (dataItem) {
            dataItem[newHeaderName] = "";
        });
        $scope.$apply();
    };

    $scope.select = function(headerTitle,index){
        console.log($scope.mySelect[headerTitle],index);
    }


    //for debug remove later
    window.editCell = $scope.editCell;
    window.addRow = $scope.addRow;
    window.editHeader = $scope.editHeader;
    window.addColumn = $scope.addColumn;
    //for debug remove later


});