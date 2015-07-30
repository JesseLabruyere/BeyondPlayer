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

/* this code adds the ajaxForm action to a form based on a form id*/
function setAjaxForm(formId)
{
    $(formId).ajaxForm(function() {
        alert("Thank you for your upload!");
    });

}


