/**
 * Created by Jesse on 10-6-2015.
 */
var app = angular.module('app',['ngSanitize', 'ngRoute']);


$( document ).ready(function() {
    buildMediaPlayer();
});


/* this code initializes some values */
/*
$scope.init = function () {
    if ($routeParams.Id) {
        //get an existing object
    } else {
        //create a new object
    }
    $scope.isSaving = false;
}

$scope.init();
*/

/* this service makes communication between controllers possible*/
app.factory('sharedService', function($rootScope) {
    var sharedService = {};

    sharedService.songQueue = [];

    sharedService.setSongQueue =  function(data){
        sharedService.songQueue = data;
    }

    sharedService.broadcast = function(message) {
        this.broadcastItem(message);
    };

    /* broadcast a message to all controllers */
    sharedService.broadcastItem = function(message) {
        $rootScope.$broadcast(message);
    };

    return sharedService;
});

app.controller('initialisationController', ['$scope', function($scope) {
    $scope.functions = {};
}]);

/* routing */
app.config(function($routeProvider) {
    $routeProvider

        // uploadForm
        .when('/', {
            templateUrl : 'app/empty',
            controller  : ''
        })
        .when('/upload', {
            templateUrl : 'app/getUploadForm',
            controller  : 'uploadController'
        })
        .when('/uploads', {
            templateUrl : 'app/getUploadsView',
            controller  : 'uploadsController'
        })
        .when('/registration', {
            templateUrl : 'app/getRegistrationForm',
            controller  : 'registrationController'
        })
        .when('/playlists', {
            templateUrl : 'app/getPlaylistsView',
            controller  : 'playlistsController'
        })
        .when('/playlists/:playlistName', {
            templateUrl : 'app/getPlaylistView',
            controller  : 'playlistController'
        })
        .when('/albums', {
            templateUrl : 'app/getAlbumsView',
            controller  : 'albumsController'
        })
        .when('/albums/:albumName', {
            templateUrl : 'app/getAlbumView',
            controller  : 'albumController'
        });

});

// create the controller and inject Angular's $scope
app.controller('uploadController', function($scope) {
});

app.controller('uploadsController', function($scope, $http, $routeParams) {
    $scope.functions = {};

    $scope.functions.loadUploadsView = function (item, event) {
        var response = $http.get("app/getUploads");

        response.success(function (data, status, headers, config) {
            if(data['uploads'] !== undefined && data['success']){
                $scope.songs = data['uploads']['listItems'];

                if(data['playlists'] !== undefined){
                    $scope.playlists = data['playlists'];
                }
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

    $scope.functions.loadUploadsView();

    $scope.functions.removeItem = function (id, index) {

         var response = $http.get("app/removeAudio/" + id);

         response.success(function (data, status, headers, config) {
             if(data['success']){
                alert("Upload removed");
                $scope.functions.removeItemFromData(index);
             }
         });

         response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
         });

    };

    $scope.functions.removeItemFromData = function (index) {
        $scope.songs.splice(index, 1);
    };

    $scope.functions.addToList = function (listId, songId) {

        var response = $http.get("app/addToPlaylist/"+ listId +"/" + songId);

        response.success(function (data, status, headers, config) {
            if(data['success']){
                alert("Added to playlist");
            } else if(data['reason'] == 'duplicate') {
                alert('The playlist already contains this item');
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

});

app.controller('registrationController', function($scope) {
});

app.controller('playlistsController', function($scope, $http) {

    $scope.functions = {};

    $scope.functions.loadPlaylistsView = function (item, event) {
        var response = $http.get("app/getPlaylists");

        response.success(function (data, status, headers, config) {
            if(data['playlists'] !== undefined && data['success']){
                $scope.playlists = data['playlists'];
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

    $scope.functions.loadPlaylistsView();

});

app.controller('playlistController', function($scope, $http, $routeParams, sharedService) {
    $scope.functions = {};

    $scope.functions.loadPlaylistView = function (item, event) {
        var response = $http.get("app/getPlaylist/" + $routeParams.playlistName);

        response.success(function (data, status, headers, config) {
            if(data['playlist'] !== undefined && data['success']){
                $scope.songs = data['playlist']['listItems'];
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

    $scope.functions.loadPlaylistView();

    $scope.functions.playPlaylist = function() {
        /* broadcast using the service so other controllers know the queue has changed*/
        sharedService.setSongQueue($scope.songs);
        sharedService.broadcast('queue');
    }
});

app.controller('albumsController', function($scope, $http) {

    $scope.functions = {};

    $scope.functions.loadAlbumsView = function (item, event) {
        var response = $http.get("app/getAlbums");

        response.success(function (data, status, headers, config) {
            if(data['albums'] !== undefined && data['success']){
                $scope.albums = data['albums'];
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

    $scope.functions.loadAlbumsView();

});

app.controller('albumController', function($scope, $http, $routeParams) {
    $scope.functions = {};

    $scope.functions.loadPlaylistView = function (item, event) {
        var response = $http.get("app/getAlbum/" + $routeParams.albumName);

        response.success(function (data, status, headers, config) {
            if(data['album'] !== undefined && data['success']){
                $scope.songs = data['album']['tracks'];
            }
        });

        response.error(function (data, status, headers, config) {
            alert("AJAX failed!");
        });

    };

    $scope.functions.loadPlaylistView();

});


/* Code for the footer */

app.controller('footerController', function($scope, $http, $routeParams,$timeout, sharedService) {
    $scope.functions = {};
    $scope.songQueue = [];
    $scope.selected = {};
    $scope.future = [];
    $scope.past = [];
    var player;

    $scope.functions.loadQueue = function (item, event) {
    };
    $scope.functions.loadQueue();

    /* When the service broadcasts 'queue'*/
    $scope.$on('queue', function() {
        $scope.songQueue = angular.copy(sharedService.songQueue);
        // no items in the array abort
        if(! $scope.songQueue.length > 0 ) {
            return;
        }
        // the initial future contains all the songs
        $scope.future = angular.copy($scope.songQueue);
        // set the currently playing item to the first item of the future array, and remove it from the future array
        $scope.selected = $scope.future.splice(0, 1)[0];
        $scope.selected.fullPath = $scope.selected.uploadDirectory + '/' + $scope.selected.path;


        /* angularjs timeout, this is needed otherwise the fullPath link was not set in the dom element yet */
        /* there is no timeout set,
        * this is a hack, the intention is to wait until the end of the $digest cycle and then call the function
        * this works because Timeouts are called after all watches are done.
        */
        // set the source for the player
        $timeout(function(){
            player.setSrc($scope.selected.fullPath);
            player.play();
        });
    });

    $scope.functions.nextSong = function (item, event) {
        // add the selected item to the end of the past array
        $scope.past.push($scope.selected);
        // set the currently to the first item of the future
        if($scope.future.length > 0 ) {
            /* everything ok do nothing */
        } else if ($scope.past.length > 0 ){
            /* no items in future repeat items in past*/
            $scope.future = $scope.past;
        } else {
            /* no items in future or past abort */
            return;
        }
        // set selected to the first item of the future, remove item from future
        $scope.selected = $scope.future.splice(0, 1)[0];
        $scope.selected.fullPath = $scope.selected.uploadDirectory + '/' + $scope.selected.path;

        // set the new source for the player
        $timeout(function(){
            player.setSrc($scope.selected.fullPath);
            player.play();
        });
    };

    /* function that builds the mediaplayer */
    $scope.functions.buildMediaPlayer = function () {
        player = new MediaElementPlayer('#audioPLayer', {
            defaultVideoWidth: 200,
            defaultVideoHeight: 50,
            features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
            success: function (mediaElement, domObject) {

                mediaElement.addEventListener('ended', function (e) {
                    setTimeout(function () {
                        $scope.functions.nextSong();
                    }, 500);
                }, false);

            }
        });
        player.pause();
        return player;
    };
    /* build the player */
    $scope.functions.buildMediaPlayer();

});

function buildMediaPlayer(){
    var player = new MediaElementPlayer('#audioPLayer', {
        defaultVideoWidth: 200,
        defaultVideoHeight: 50,
        features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
        success: function (mediaElement, domObject) {}
    });
    player.pause();
    return player;
}

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

/* QUEING AJAX CALLS*/
/*adding new function called loadPlaylistView to the 'functions' object*/
/* $scope.functions.loadPlaylistView = function (item, event) {
 *//*JSON call*//*
 *//*            var response = $http.get("app/getPlaylistView");
 response.success(function (data, status, headers, config) {
 $('#pageCenter').html(data);
 });
 response.error(function (data, status, headers, config) {
 alert("AJAX failed!");
 });*//*
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
 };*/

/* DIRECTIVE */
/* all real dom manipulation should be done in directives*/
/* we can see some dependency injection going on, of the $q service*/
/*app.directive('leftMenuDirective', function($q) {

    // we link onclick
    var linkFn = function ($scope, $http) {

        *//*creating a new object called functions*//*
        $scope.functions = {};

        *//*adding new function called loadUploadPage to the 'functions' object*//*
        $scope.functions.loadUploadPage = function (item, event) {
            *//*JSON call*//*
            var response = $http.get("app/getUploadForm");
            response.success(function (data, status, headers, config) {
                $('#pageCenter').html(data);
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });
        };

        *//*adding new function called loadListenPage to the 'functions' object*//*
        $scope.functions.loadListenPage = function (item, event) {
            $('#pageCenter').html('<h1>Listenpage</h1>');
        };

        *//*adding new function called loadAddUserForm to the 'functions' object*//*
        $scope.functions.loadAddUserForm = function (item, event) {
            *//*JSON call*//*
            var response = $http.get("app/getRegistrationForm");
            response.success(function (data, status, headers, config) {
                $('#pageCenter').html(data);
            });
            response.error(function (data, status, headers, config) {
                alert("AJAX failed!");
            });
        };



    };

    return {
        *//*'A' can be used if we use the directive as an attribute*//*
        restrict: 'E',
        controller: linkFn
    };
});*/


