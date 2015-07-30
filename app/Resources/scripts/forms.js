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
        $("#upload_form").ajaxSubmit(function() {
            alert("Thank you for your upload!");
        });
    });

    $(document).on('submit', '#registration_form', function(e){
        e.preventDefault();
        $("#registration_form").ajaxSubmit(function() {
            alert("Thank you for your registration");
        });
    });

}

