/**
 * Created by Jesse on 10-6-2015.
 */
var app = angular.module('app',['ngSanitize']);

/* mainly used for editting the models of elements*/
/*
app.controller('MyController', ['$scope', '$http', function($scope, $http) {
    */
/*creating a new object called functions*//*

    $scope.functions = {};
    */
/*adding new function called loadUploadPage to the 'functions' object*//*

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
*/

/* all real dom manipulation should be done in directives*/
app.directive('leftMenuDirective', function() {

    // we link onclick
    var linkFn = function ($scope, $http) {

        /*creating a new object called functions*/
        $scope.functions = {};

        /*adding new function called loadUploadPage to the 'functions' object*/
        $scope.functions.loadUploadPage = function (item, event) {
            /*JSON call*/
            var response = $http.get("app/uploadForm");
            response.success(function (data, status, headers, config) {
                alert('loading');
                $('#pageCenter').html(data);
                /*initializeFileInput();*/
                /*$('input[type=file]').bootstrapFileInput();*/
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });
        };

        /*adding new function called loadListenPage to the 'functions' object*/
        $scope.functions.loadListenPage = function (item, event) {
            $('#pageCenter').html('<h1>Listenpage</h1>');
        };

    };

    return {
        /*'A' can be used if we use the directive as an attribute*/
        restrict: 'E',
        controller: linkFn
    };
});

/*function initializeFileInput() {
    $(function () {
        $('#fileInput').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            }
        });
    });
}*/





/*

angular.module('bindHtmlExample', ['ngSanitize'])
    .controller('ExampleController', ['$scope', function($scope) {
        $scope.myHTML =
            'I am an <code>HTML</code>string with ' +
            '<a href="#">links!</a> and other <em>stuff</em>';
    }]);
*/






