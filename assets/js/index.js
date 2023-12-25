$(document).ready(function () {
    $("#home-tab").on('click', function () {
        $("#profile_snippet").addClass("d-none");
        $("#groups_snippet").addClass("d-none");
    });

    $("#profile-tab").on('click', function () {
        let url = "views/components/profile.html";
        $("#profile_snippet").load(url)

        $("#profile_snippet").removeClass("d-none");
        $("#groups_snippet").addClass("d-none");
    });

    $("#groups-tab").on('click', function () {
        let url = "views/components/groups.html";
        $("#groups_snippet").load(url)

        $("#profile_snippet").addClass("d-none");
        $("#groups_snippet").removeClass("d-none");
    });

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

    // Edit Profile
    $("#profile_snippet").on('click', '#editProfileBtn', function () {
        let name = $("#name").val();
        let oldPassword = $("#old_password").val();
        let newPassword = $("#new_password").val();
        let confirmNewPassword = $("#confirm_new_password").val();
        // let csrfToken = $('meta[name="csrf-token"]').attr('content');// interesno
        let csrfToken = $("#editProfileCsrf").val();
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
    })
});