$(document).ready(function () {
    $('#login-form').submit(function (event) {
        event.preventDefault();

        let username = $('#username').val();
        let password = $('#password').val();

        if (!isValidUsername(username)) {
            alert('Логин должен состоять из латинских символов и цифр, не менее 2 символов и не более 20.');
            return;
        }

        if (!isValidPassword(password)) {
            alert('Пароль должен быть не менее 5 символов и содержать символы, кроме цифр.');
            return;
        }

        $.ajax({
            url: pathApp + '/registration',
            type: 'POST',
            data: {username: username, password: password},
            success: function (response) {
                if (response.message && response.redirect) {
                    alert(response.message);
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert('Произошла ошибка: ' + xhr.responseJSON.error);
                } else {
                    alert('Произошла ошибка при регистрации.');
                    console.log(pathApp);
                }
            }
        });
    });
});

// Функция для проверки логина
function isValidUsername(username) {
    let regex = /^[a-zA-Z0-9]{2,20}$/;
    return regex.test(username);
}

// Функция для проверки пароля
function isValidPassword(password) {
    let regex = /^(?=\D*$).{5,}$/;
    return regex.test(password);
}