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

    /* onchange for the fileInput*/
/*    $( document).on( "change", "#fileInput", function() {
        uploadFile(this);
    });*/
}

/*function that loads the uploadpage*/
function loadUploadPage() {

}

function uploadFile(fileInput){
    if ('files' in fileInput) {
        var file;
        for(var i = 0; i < fileInput.files.length; i++) {
            file = fileInput.files[i];
            alert(file.name + " - " + file.size + " bytes");
        }

    }
}

