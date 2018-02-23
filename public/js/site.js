$(document).ready(function() {

    function fadeoutAlert(selector, delay){
        window.setTimeout(function () {
            $(selector).fadeTo(500, 0).slideUp(500, function () {
                $(selector).attr("style", 'display:none');;
            });
        }, delay);
    };

    // logout form submit 
    $("#logout-form").on('click', function() {
        $("#logout-form").submit();
    });

    // edit-user ajax call
    $('#edit-user-profile').submit(function(e){
        e.preventDefault();
        var values = $(this).serialize();

        $.ajax({
            url: "http://localhost:8080/php-mvc-bootstrapper/users/edit_user_profile",
            type: "post",
            data: values ,
            success: function (response) {
                if(response.error) {
                    $('#error-editing-user-alert').attr('style', 'display:block');
                    $('#error-editing-user-alert').text(response.error);                   
                    fadeoutAlert('#error-editing-user-alert', 4000);               
                } else {
                    $('#sucess-editing-user-alert').attr('style', 'display:block');
                    $('#sucess-editing-user-alert').text(response.message);                   
                    fadeoutAlert('#sucess-edditing-user-alert', 4000);                         
                }          
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#error-editing-user-alert').attr('style', 'display:block');
                $('#error-editing-user-alert').text(errorThrown);                   
                fadeoutAlert('#error-editing-user-alert', 4000);
            }
        });
    })



});