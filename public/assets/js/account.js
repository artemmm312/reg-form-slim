$(document).ready(function () {
    $('#logout-button').on("click", function () {
        $.ajax({
            url: pathApp + '/account',
            type: 'POST',
            data: {action: 'LogOut'},
            xhrFields: {
                withCredentials: true
            },
            success(response) {
                if (response.redirect)
                    window.location.href = response.redirect;
            },
            error: function () {
                alert('Произошла ошибка при выходе!');
            }
        });
    });
});