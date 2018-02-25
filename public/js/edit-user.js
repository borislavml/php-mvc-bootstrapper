$(document).ready(function() {
    var APP_URL = (typeof APP_URL === 'undefined') ? "http://localhost/php-mvc-bootstrapper" : APP_URL;
    var error_alert = "#error-editing-user-alert";
    var success_alert = "#sucess-editing-user-alert";

    function fadeoutAlert(selector, delay) {
        setTimeout(function() {
            $(selector).fadeTo(500, 0).slideUp(500, function() {
                $(selector).attr("style", 'display:none');;
            });
        }, delay);
    };

    function handle_ajax_success(message) {
        $(success_alert).attr('style', 'display:block');
        $(success_alert).text(message);
        fadeoutAlert(success_alert, 3000);
    }

    function handle_ajax_error(error) {
        $(error_alert).attr('style', 'display:block');
        $(error_alert).text(error);
        fadeoutAlert(error_alert, 3000);
    }

    // edit-user-profile ajax call
    $('#edit-user-profile').submit(function(e) {
        e.preventDefault();
        var values = $(this).serialize();

        var result = confirm('Save user profile changes?');
        if (result) {
            $.ajax({
                url: APP_URL + "/users/edit_user_profile",
                type: "post",
                data: values,
                success: function(response) {
                    if (response.error) {
                        handle_ajax_error(response.error);
                    } else {
                        handle_ajax_success(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    handle_ajax_error(errorThrown);
                }
            });
        }
    })

    //   edit user roles
    $("#edit-user-roles").submit(function(e) {
        e.preventDefault();

        // set hidden input values according to checkboxes
        if ($('#admin_role').is(":checked")) {
            $('input[name=admin_role]').val('true');
        }

        var values = $(this).serialize();
        var result = confirm("Save user role changes?");
        if (result) {
            $.ajax({
                url: APP_URL + '/users/edit_user_roles',
                method: "POST",
                data: values,
                success: function(response) {
                    if (response.error) {
                        handle_ajax_error(response.error);
                    } else {
                        handle_ajax_success(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    handle_ajax_error(errorThrown);
                }
            });
        }
    });

    // change user password
    $("#change-user-password").submit(function(e) {
        $('#changePasswordSection').modal('toggle');
        e.preventDefault();
        var values = $(this).serialize();

        $.ajax({
            url: APP_URL + '/users/change_user_password',
            method: "POST",
            data: values,
            success: function(response) {
                if (response.error) {
                    handle_ajax_error(response.error);
                } else {
                    handle_ajax_success(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                handle_ajax_error(errorThrown);
            },
            complete: function() {
                $("#new-password").val('');
                $("#confirm-password").val('');
            }
        });
    });
});