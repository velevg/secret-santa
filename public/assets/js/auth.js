$(document).ready(function () {
    sessionStorage.clear();
    localStorage.clear();
    // === CARD FLIP
    $('#flip-card-btn-turn-to-back').on('click', function () {
        $('#flip-card').toggleClass('do-flip');
    });

    $('#flip-card-btn-turn-to-front').on('click', function () {
        $('#flip-card').toggleClass('do-flip');
    });

    $('#loginEmail').on('input', function () {
        var enteredName = '</br>' + $(this).val();
        $('#display-login-email').html(enteredName);
    });
    $('#registerEmail').on('input', function () {
        var enteredName = '</br>' + $(this).val();
        $('#display-register-email').html(enteredName);
    });

    // === VALIDATION
    // var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    // var passwordRegex = /^[A-Za-z0-9]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"':;?/>]).{7,}$/; // (?=.*[a-z]): At least one lowercase letter. (?=.*[A-Z]): At least one uppercase letter. (?=.*\d): At least one digit. (?!.*[~%^&*()+}{[]|"':;?/>])`: Negative lookahead assertion to exclude the specified symbols. .{8,}: Minimum length of 8 characters.

    // === LOGIN
    var loginBtnClicked = 0;
    $('#loginBtn').on('click', function () {
        loginBtnClicked++;
        if (loginBtnClicked <= 3) {
            let success = true;
            let email = $('#loginEmail').val();
            let password = $('#loginPassword').val();
            let csrf_token = $('#loginCsrf').val();


            if (!emailRegex.test(email)) {
                success = false;
                showNotification('error', '', 'Please enter a valid email!', 'topCenter', 5000);
                $("#loginBtn").attr("disabled", true);
                $("#loginBtn").addClass("btn-danger");
                $("#loginBtn").effect("shake", { times: 5 }, 1000);
                setTimeout(function () {
                    $("#loginBtn").removeClass("btn-danger");
                    $("#loginBtn").removeAttr("disabled");
                }, 1100)
            }

            if (!passwordRegex.test(password)) {
                success = false;
                showNotification('error', '', 'Please enter a valid password! Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number.', 'topCenter', 5000);
                $("#loginBtn").attr("disabled", true);
                $("#loginBtn").addClass("btn-danger");
                $("#loginBtn").effect("shake", { times: 5 }, 1000);
                setTimeout(function () {
                    $("#loginBtn").removeClass("btn-danger");
                    $("#loginBtn").removeAttr("disabled");
                }, 1100)
            }

            if (success && emailRegex.test(email) && passwordRegex.test(password)) {

                $.ajax({
                    type: "POST",
                    url: "app/controllers/auth/loginAjax.php",
                    data: {
                        login: "true",
                        email: email,
                        password: password,
                        csrf_token: csrf_token
                    },
                    success: function (response) {
                        if (response.success == true) {
                            $("#loginForm").attr('action', 'app/controllers/auth/login.php').submit();
                        } else {
                            showNotification('error', '', response.message, 'topCenter', 5000);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                })
            }
        } else if (loginBtnClicked > 3) {
            showNotification('warning', '', 'You have reached the maximum number of login attempts. Please wait a bit!', 'topCenter', 7000);
            $("#loginBtn").attr('disabled', true);
            $("#loginBtn").addClass("btn-danger");
            $("#loginBtn").effect("shake", { times: 5 }, 1000);
            setInterval(function () {
                $("#loginBtn").removeClass("btn-danger");
                $("#loginBtn").removeAttr('disabled');
                loginBtnClicked = 0;
            }, 7000);
        }
    })

    // === REGISTER
    var registerBtnClicked = 0;
    $('#registerBtn').on('click', function () {
        registerBtnClicked++;
        if (registerBtnClicked <= 3) {
            let success = true;
            let email = $('#registerEmail').val();
            let password = $('#registerPassword').val();
            let csrf_token = $('#registerCsrf').val();

            if (!emailRegex.test(email)) {
                success = false;
                showNotification('error', '', 'Please enter a valid email address!', 'topCenter', 5000);
                $("#registerBtn").attr("disabled", true);
                $("#registerBtn").addClass("btn-danger");
                $("#registerBtn").effect("shake", { times: 5 }, 1000);
                setTimeout(function () {
                    $("#registerBtn").removeClass("btn-danger");
                    $("#registerBtn").removeAttr("disabled");
                }, 1100)
            }

            if (!passwordRegex.test(password)) {
                success = false;
                showNotification('error', '', 'Please enter a valid password! Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number.', 'topCenter', 5000);
                $("#registerBtn").attr("disabled", true);
                $("#registerBtn").addClass("btn-danger");
                $("#registerBtn").effect("shake", { times: 5 }, 1000);
                setTimeout(function () {
                    $("#registerBtn").removeClass("btn-danger");
                    $("#registerBtn").removeAttr("disabled");
                }, 1100)
            }

            if (success && emailRegex.test(email) && passwordRegex.test(password)) {
                $.ajax({
                    type: "POST",
                    url: "app/controllers/auth/registerAjax.php",
                    data: {
                        register: 'true',
                        email: email,
                        password: password,
                        csrf_token: csrf_token
                    },
                    success: function (response) {
                        if (response.success == true) {
                            $("#registerForm").attr('action', 'app/controllers/auth/register.php').submit();
                        } else {
                            showNotification('error', '', response.message, 'topCenter', 5000);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                })
            }
        } else if (registerBtnClicked > 3) {
            showNotification('warning', '', 'You have reached the maximum number of registration attempts. Please wait a bit!', 'topCenter', 7000);
            $("#registerBtn").attr('disabled', true);
            $("#registerBtn").addClass("btn-danger");
            $("#registerBtn").effect("shake", { times: 5 }, 1000);
            setInterval(function () {
                $("#registerBtn").removeClass("btn-danger");
                $("#registerBtn").removeAttr('disabled');
                registerBtnClicked = 0;
            }, 7000);
        }
    })

    function showNotification(type, title, message, position, timeout) {
        switch (type) {
            case 'success':
                iziToast.success({
                    title: title,
                    message: message,
                    position: position,
                    timeout: timeout,
                });
                break;
            case 'error':
                iziToast.error({
                    title: title,
                    message: message,
                    position: position,
                    timeout: timeout,
                });
                break;
            case 'info':
                iziToast.info({
                    title: title,
                    message: message,
                    position: position,
                    timeout: timeout,
                });
                break;
            case 'warning':
                iziToast.warning({
                    title: title,
                    message: message,
                    position: position,
                    timeout: timeout,
                });
                break;
            default:
                console.error('Invalid notification type:', type);
        }
    }


});