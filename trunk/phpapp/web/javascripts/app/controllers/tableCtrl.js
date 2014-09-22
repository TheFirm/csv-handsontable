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

APP.controller('tableCtrl', function ($scope, $rootScope, $location, TableDataService) {

    $scope.tableData = TableDataService.getData();
    $scope.checkedRows = [];
    $scope.tableHeaderSelects = [];
    $scope.possibleValues = [];

    //if empty table data, got to root path
    if (!$scope.tableData || Object.keys($scope.tableData).length === 0) {
        $location.path("/");
        return false;
    }

    if($scope.tableData.errors.hasOwnProperty('bestMatch')){
        var confName = Object.keys($scope.tableData.errors.bestMatch);
        $scope.possibleValues = $scope.tableData.errors.bestMatch[confName].from_conf;
        $scope.possibleValues.unshift("Choose");
    }

    $scope.tableHeaderSelects = [];

    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent,element) {
        $(element.parent()).selectric('refresh');
    });


    //console.log($scope.tableData);
    //localLoader.fetch("sample_server_response.json").then(function(data) {
    //
    //});

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
        //$scope.$apply();
    };

    $scope.editCell = function (rowNum, colNum, newValue) {
        var rowItem = $scope.tableData.data[rowNum];

        var i = 0;
        for (var cellItem in rowItem) {
            if (rowItem.hasOwnProperty(cellItem)) {
                if (i === colNum) {
                    rowItem[cellItem] = newValue;
                    break;
                } else {
                    i++;
                }
            }
        }
        if (!$scope.$$phase) {
            $scope.$apply();
        }
    };

    $scope.addRow = function () {
        var rowItem = {};
        $scope.tableData.headers.forEach(function (headerTitle) {
            rowItem[headerTitle] = "";
        });
        $scope.tableData.data.push(rowItem);
        //$scope.$apply();
    };

    $scope.addColumn = function () {
        //$scope.$apply(function () {
        var newHeaderName = "Unknown" + $scope.countUnknownColumns;
        $scope.tableData.headers.push(newHeaderName);
        $scope.countUnknownColumns++;
        $scope.tableData.data.forEach(function (dataItem) {
            dataItem[newHeaderName] = "Unknown";
        });
        //});
    };

    $scope.mySelect = {};

    $scope.select = function(selectedName,index){
        $scope.editHeader(index,selectedName);
    }


    $scope.checkUncheckAllRows = function () {
        var newValue = !$scope.allRowsChecked();

        $scope.checkedRows.forEach(function (row) {
            row.checked = newValue;
        });
    };

    // Returns true if and only if all todos are done.
    $scope.allRowsChecked = function () {
        var countChecked = 0;
        $scope.checkedRows.forEach(function (checkItem) {
            return countChecked += checkItem.checked ? 1 : 0;
        });

        return (countChecked === $scope.checkedRows.length);
    };

    $scope.columnHasError = function (colName) {
        var errorInThisColumn = $scope.tableData.columnsWithErrors && $scope.tableData.columnsWithErrors.indexOf(colName) !== -1;
        return errorInThisColumn;
    }

});