$(document).ready(function () {

    {
        const lastActiveTab = sessionStorage.getItem('lastActiveTab');
        if (lastActiveTab) {
            $(`#${lastActiveTab}`).tab('show');
            showTabContent(`${lastActiveTab}-pane`);
        }

        if ($("#home-tab").hasClass("active")) {
            if ($("#home-tab-pane").hasClass("d-none")) {
                $("#home-tab-pane").removeClass("d-none");
            }
            $("#profile-tab-pane").addClass("d-none");
            $("#groups-tab-pane").addClass("d-none");
        }

        $("#home-tab").on('click', function () {
            sessionStorage.setItem('lastActiveTab', 'home-tab');
            showTabContent('home-tab-pane');
        });
        $("#profile-tab").on('click', function () {
            sessionStorage.setItem('lastActiveTab', 'profile-tab');
            showTabContent('profile-tab-pane');
        });
        $("#groups-tab").on('click', function () {
            sessionStorage.setItem('lastActiveTab', 'groups-tab');
            showTabContent('groups-tab-pane');
        });

        function showTabContent(tabPaneId) {
            $(".tab-pane").addClass("d-none");
            $(`#${tabPaneId}`).removeClass("d-none");
        }
        //
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

    let sessionMessage_add_group = window.sessionMessage_add_group;
    if (sessionMessage_add_group) {
        showNotification('success', 'Success', sessionMessage_add_group, 'topCenter', 5000);
    }

    // === VALIDATION
    // const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"':;?/>]).{7,}$/; // (?=.*[a-z]): At least one lowercase letter. (?=.*[A-Z]): At least one uppercase letter. (?=.*\d): At least one digit. (?!.*[~%^&*()+}{[]|"':;?/>])`: Negative lookahead assertion to exclude the specified symbols. .{8,}: Minimum length of 8 characters.
    let csrfToken = $("#editProfileCsrf").val();

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
                    createGroup(newGroupName);
                    // let append = `
                    //     <div class="accordion-item">
                    //         <h2 class="accordion-header">
                    //             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    //                 data-bs-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1">
                    //                 ${newGroupName}
                    //             </button>
                    //         </h2>
                    //         <div id="collapse_1" class="accordion-collapse collapse"
                    //             data-bs-parent="#accordionGroups">
                    //             <div class="accordion-body">
                    //                 <div class="row">
                    //                     <div class="col-4">Name: </div>
                    //                     <div class="col-8">Email: </div>
                    //                     <div class="col-3"><input type="button" class="btn btn-sm btn-danger"/></div>
                    //                 </div>
                    //             </div>
                    //         </div>
                    //     </div>
                    // `;

                    // $("#accordionGroups").append(append);
                }]
            ]
        });

        function createGroup() {
            $.ajax({
                type: "POST",
                url: "controllers/groups/addGroupAjax.php",
                data: {
                    add_group: true,
                    group_name: newGroupName,
                    csrf_token: csrfToken
                },
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                    if (response.success == true) {
                        showNotification('success', '', response.message, 'topCenter', 5000);
                        window.location.reload();
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

    let userGroupDelete;
    let userRowDelete;
    $(".deleteUser").each(function () {
        $(this).on('click', function () {
            userGroupDelete = $(this).parent().parent().parent().parent().parent();
            userRowDelete = $(this).parent().parent().parent();
            let userId = $(this).data('user-id');
            let groupId = $(this).data('group-id');
            console.log(userGroupDelete);
            deleteUserFromGroup(userId, groupId);
        })
    })

    function deleteUserFromGroup(userId, groupId) {
        $.ajax({
            type: 'POST',
            url: 'controllers/groups/deleteUserFromGroup.php',
            data: {
                delete_user_from_group: true,
                userId: userId,
                groupId: groupId,
                csrf_token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    showNotification('success', '', response.message, 'topCenter', 5000);
                    userGroupDelete.remove();
                } else {
                    showNotification('error', '', response.message, 'topCenter', 5000);
                }
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error('Error deleting user:', error);
            }
        });
    }

    $("#searchUser").on('input', function () {
        let searchValue = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'controllers/groups/searchUser.php',
            data: {
                search_user: true,
                searchValue: searchValue,
                csrf_token: csrfToken
            },
            success: function (response) {
                console.log(response.users);
                if (response.success) {
                    // response.data.foreach(function (user) {
                        // console.log(user);
                    // })
                    // $("#searchresults").html(response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error searching users:', error);
            }
        })
    })
});