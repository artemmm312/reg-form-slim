$(document).ready(function () {
    $('#authorization-form').submit(function (event) {
        event.preventDefault();

        let username = $('#username').val();
        let password = $('#password').val();

        $.ajax({
            url: pathApp + '/authorization',
            //url: '/LabX/authorization',
            type: 'POST',
            data: {username: username, password: password},
            success: function (response) {
                if (response.message && response.redirect) {
                    alert(response.message);
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                let errorMessage = JSON.parse(xhr.responseText);
                alert(errorMessage.error);
            }
        });
    });
});
