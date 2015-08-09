/**
 * Created by Jesse on 10-6-2015.
 *
 * this page contains currently unimportant/old code
 */

$( document ).ready(function() {
    assignEventHandlers();
});

/* function that adds the eventhandlers to elements*/
function assignEventHandlers() {
}

function renderPlaylistData(data) {
    for(var i = 0; i < data.length; i++) {
        $('#playListView').append("<p>[id:] "+ data[i]['id'] +" [name:] "+ data[i]['listName'] +"</p>")
    }
}