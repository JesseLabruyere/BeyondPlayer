/**
 * Created by Jesse on 10-6-2015.
 */
var app = angular.module('app',[]);

app.controller('MyController', function($scope, $http) {

    $scope.myData = {};
    $scope.myData.doClick = function(item, event) {

        var responsePromise = $http.get("app/uploadForm");

        responsePromise.success(function(data, status, headers, config) {


            $scope.myData.fromServer = data;
            /*$('input[type=file]').bootstrapFileInput();*/
        });
        responsePromise.error(function(data, status, headers, config) {
            alert("AJAX failed!");
        });
    }
});


