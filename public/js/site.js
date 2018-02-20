$(document).ready(function() {

    // logout form submit 
    $("#logout-form").on('click', function() {
        $("#logout-form").submit();
    });

    // edit-user ajax call
    $('#edit-user').submit(function(e){

        e.preventDefault();
        var values = $(this).serialize();

        $.ajax({
            url: "http://localhost:8080/php-mvc-bootstrapper/users/edit_user",
            type: "post",
            data: values ,
            success: function (response) {
                if(response.error) {
                    $('#edit-user-error-alert').show();
                    $('#edit-user-error-alert').text(response.error);                    
                }             
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#edit-user-error-alert').show();
                $('#edit-user-error-alert').text(errorThrown);   
            }
        });

    })

});