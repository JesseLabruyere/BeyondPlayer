/**
 * Created by Jesse on 29-7-2015.
 *
 * this page contains the javascript for the upload form
 */

$( document ).ready(function() {
    assignFormHandlers();
});

function assignFormHandlers() {

    $(document).on('submit', '#upload_form', function(e){
        e.preventDefault();
        $("#upload_form").ajaxSubmit(function(response) {
            response = JSON.parse(response);
            if(! response['success'])
            {
                alert(response['reason']);
            } else {
                alert("Thank you for your upload!");
                $("#upload_form")[0].reset();
            }
        });
    });

    $(document).on('submit', '#registration_form', function(e){
        e.preventDefault();
        $("#registration_form").ajaxSubmit(function(response) {
            response = JSON.parse(response);
            if(! response['success'])
            {
                alert( response['reason'] );
            } else {
                alert("Thank you for your registration");
                $("#registration_form")[0].reset();
            }
        });
    });

}

