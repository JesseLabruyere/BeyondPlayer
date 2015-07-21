/**
 * Created by Jesse on 10-6-2015.
 */

$( document ).ready(function() {
    assignEventHandlers();
});

/* function that adds the eventhandlers to elements*/
function assignEventHandlers() {
/*    $('#leftbar_listen').click(function() {
        alert('listen');
    });*/
    $('#leftbar_upload').click(function() {
        loadUploadPage();
    });
}

/*function that loads the uploadpage*/
function loadUploadPage() {

}