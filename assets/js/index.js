$(document).ready(function () {
    {
        if ($("#home-tab").hasClass("active")) {
            if ($("#home-tab-pane").hasClass("d-none")) {
                $("#home-tab-pane").removeClass("d-none");
            }
            $("#profile-tab-pane").addClass("d-none");
            $("#groups-tab-pane").addClass("d-none");
        }
        $("#home-tab").on('click', function () {
            $("#home-tab-pane").removeClass("d-none");
            $("#profile-tab-pane").addClass("d-none");
            $("#groups-tab-pane").addClass("d-none");
        });

        $("#profile-tab").on('click', function () {
            $("#home-tab-pane").addClass("d-none");
            $("#profile-tab-pane").removeClass("d-none");
            $("#groups-tab-pane").addClass("d-none");
        });

        $("#groups-tab").on('click', function () {
            $("#home-tab-pane").addClass("d-none");
            $("#profile-tab-pane").addClass("d-none");
            $("#groups-tab-pane").removeClass("d-none");
        });

        $("#old_password").on('input', function () {
            $("#old_password").attr("type", "password");
        })
        $("#new_password").on('input', function () {
            $("#new_password").attr("type", "password");
        })
        $("#confirm_new_password").on('input', function () {
            $("#confirm_new_password").attr("type", "password");
        })
    }

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
    let message = window.sessionMessage;
    if (message) {
        showNotification('success', 'Success', message, 'topCenter', 5000);
    }

    // === VALIDATION
    // const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"':;?/>]).{7,}$/; // (?=.*[a-z]): At least one lowercase letter. (?=.*[A-Z]): At least one uppercase letter. (?=.*\d): At least one digit. (?!.*[~%^&*()+}{[]|"':;?/>])`: Negative lookahead assertion to exclude the specified symbols. .{8,}: Minimum length of 8 characters.

    // Edit Profile
    let editProfileBtnClicks = 0;
    $("#editProfileBtn").on('click', function () {
        editProfileBtnClicks++;
        let success = true;
        let name = $("#name").val();
        let oldPassword = $("#old_password").val();
        let newPassword = $("#new_password").val();
        let confirmNewPassword = $("#confirm_new_password").val();
        // let csrfToken = $('meta[name="csrf-token"]').attr('content');// interesno
        let csrfToken = $("#editProfileCsrf").val();

        if (success && editProfileBtnClicks <= 3 && csrfToken.length === 64) {
            if (oldPassword != '' && newPassword != '' && confirmNewPassword != '') {
                if (!passwordRegex.test(newPassword)) {
                    showNotification('error', '', 'New password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number!', 'topCenter', 5000);
                    success = false;
                    $("#editProfileBtn").attr("disabled", true);
                    $("#editProfileBtn").addClass("btn-danger");
                    $("#editProfileBtn").effect("shake", { times: 5 }, 1000);
                    setInterval(function () {
                        $("#editProfileBtn").removeClass("btn-danger");
                        $("#editProfileBtn").removeAttr("disabled");
                    }, 1100)
                    if (newPassword != confirmNewPassword) {
                        showNotification('error', '', 'New password and confirm new password do not match!', 'topCenter', 5000);
                        success = false;
                        $("#editProfileBtn").attr("disabled", true);
                        $("#editProfileBtn").addClass("btn-danger");
                        $("#editProfileBtn").effect("shake", { times: 5 }, 1000);
                        setInterval(function () {
                            $("#editProfileBtn").removeClass("btn-danger");
                            $("#editProfileBtn").removeAttr("disabled");
                        }, 1100)
                    }
                }
            }
            if (success) {
                $.ajax({
                    type: "POST",
                    url: "controllers/profile/editProfileAjax.php",
                    data: {
                        edit_profile: true,
                        name: name,
                        old_password: oldPassword,
                        new_password: newPassword,
                        confirm_new_password: confirmNewPassword,
                        csrf_token: csrfToken
                    },
                    success: function (response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                        if (response.success == true) {
                            showNotification('success', '', response.message, 'topCenter', 5000);
                        } else {
                            showNotification('error', '', response.message, 'topCenter', 5000);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            }
        } else {
            showNotification('warning', '', 'Too many attempts! Please try wait a bit!', 'topCenter', 5000);
            $("#editProfileBtn").attr("disabled", true);
            $("#editProfileBtn").addClass("btn-danger");
            $("#editProfileBtn").effect("shake", { times: 5 }, 1000);
            setInterval(function () {
                editProfileBtnClicks = 0;
                success = true;
                $("#editProfileBtn").removeClass("btn-danger");
                $("#editProfileBtn").removeAttr("disabled");
            }, 7000)
        }
    })

    $("#createGroupBtn").on('click', function () {
        let newGroupName;

        iziToast.info({
            timeout: 100000,
            overlay: true,
            displayMode: 'once',
            id: 'inputs',
            zindex: 999,
            title: '',
            message: 'Name of new group:',
            position: 'center',
            drag: false,
            inputs: [
                ['<input type="text">', 'keyup', function (instance, toast, input, e) {
                    newGroupName = input.value
                }, true],
                ['<input type="button" id="createGroup" value="Create">', 'click', function (instance, toast, input, e) {
                    console.log(newGroupName);
                    // createGroup(newGroupName);
                }]
            ]
        });

        function createGroup() {
            $.ajax({
                type: "POST",
                url: "controllers/groups/addGroupAjax.php",
                data: {
                    add_group: true,
                    group_name: newGroupName
                },
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                    if (response.success == true) {
                        showNotification('success', '', response.message, 'topCenter', 5000);
                    } else {
                        showNotification('error', '', response.message, 'topCenter', 5000);
                    }
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    })
});