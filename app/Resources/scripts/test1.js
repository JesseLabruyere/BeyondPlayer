/**
 * Created by Jesse on 10-6-2015.
 */
var app = angular.module('app',['ngSanitize']);

/* mainly used for editting the models of elements*/
app.controller('MyController', ['$scope', '$http', function($scope, $http) {
    /*creating a new object called functions*/
    $scope.functions = {};
    /*adding new function called loadUploadPage to the 'functions' object*/
    $scope.functions.loadUploadPage = function(item, event) {

        var response = $http.get("app/uploadForm");

        response.success(function(data, status, headers, config) {
            $('#pageCenter').html(data);
            $('input[type=file]').bootstrapFileInput();
        });
        response.error(function(data, status, headers, config) {
            alert("AJAX failed!");
        });
    }
}]);

/* all real dom manipulation should be done in directives*/
/*app.directive('MyDirective', ['$scope', '$http', function($scope, $http) {
    *//*creating a new object called functions*//*
    $scope.functions = {};
    *//*adding new function called loadUploadPage to the 'functions' object*//*
    $scope.functions.loadUploadPage = function(item, event) {

        var response = $http.get("app/uploadForm");

        response.success(function(data, status, headers, config) {
            alert($(data).prop('outerHTML'));
            $scope.pageCenter  = 'test <input type="file" title="Search for a file to add"> test' +
            '<a href="#">links!</a> and other <em>stuff</em>';
            *//*$('input[type=file]').bootstrapFileInput();*//*
        });
        response.error(function(data, status, headers, config) {
            alert("AJAX failed!");
        });
    }
}]);*/







/*

angular.module('bindHtmlExample', ['ngSanitize'])
    .controller('ExampleController', ['$scope', function($scope) {
        $scope.myHTML =
            'I am an <code>HTML</code>string with ' +
            '<a href="#">links!</a> and other <em>stuff</em>';
    }]);
*/






