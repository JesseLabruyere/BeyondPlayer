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
/* we can see some dependency injection going on, of the $q service*/
app.directive('leftMenuDirective', function($q) {

    // we link onclick
    var linkFn = function ($scope, $http) {

        /*creating a new object called functions*/
        $scope.functions = {};

        /*adding new function called loadUploadPage to the 'functions' object*/
        $scope.functions.loadUploadPage = function (item, event) {
            /*JSON call*/
            var response = $http.get("app/getUploadForm");
            response.success(function (data, status, headers, config) {
                $('#pageCenter').html(data);
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });
        };

        /*adding new function called loadListenPage to the 'functions' object*/
        $scope.functions.loadListenPage = function (item, event) {
            $('#pageCenter').html('<h1>Listenpage</h1>');
        };

        /*adding new function called loadAddUserForm to the 'functions' object*/
        $scope.functions.loadAddUserForm = function (item, event) {
            /*JSON call*/
            var response = $http.get("app/getRegistrationForm");
            response.success(function (data, status, headers, config) {
                $('#pageCenter').html(data);
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });
        };

        /*adding new function called loadPlaylistView to the 'functions' object*/
        $scope.functions.loadPlaylistView = function (item, event) {
            /*JSON call*/
/*            var response = $http.get("app/getPlaylistView");
            response.success(function (data, status, headers, config) {
                $('#pageCenter').html(data);
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });*/
            // this way we can que multiple ajax calls, and give them the same callback
            $q.all({
                view: $http.get('app/getPlaylistView')
                    .error(function (data, status, headers, config) {
                        alert("AJAX failed!");
                    })
                ,
                data: $http.get('app/getPlaylists')
                    .error(function (data, status, headers, config) {
                        alert("AJAX failed!");
                    })
            }).then(function(results) {
                var view = results.view.data;
                var data = results.data.data;

                $('#pageCenter').html(view);

                var playlists = data['playlists'];

                if(playlists !== undefined && data['success']){
                    renderPlaylistData(playlists);
                }
            });
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






