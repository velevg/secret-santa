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

    // === SESSION MESSAGES
    let message = window.sessionMessage;
    if (message) {
        showNotification('success', 'Success', message, 'topCenter', 5000);
    }
    let sessionMessage_add_group = window.sessionMessage_add_group;
    if (sessionMessage_add_group) {
        showNotification('success', 'Success', sessionMessage_add_group, 'topCenter', 5000);
    }
    let messageShown_add_user = window.messageShown_add_user;
    if (messageShown_add_user) {
        showNotification('success', 'Success', messageShown_add_user, 'topCenter', 5000);
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

    $(".deleteUser").each(function () {
        $(this).on('click', function () {
            let userId = $(this).data('user-id');
            let groupId = $(this).data('group-id');
            let ownerId = $(this).data('owner-id');

            if (userId == ownerId) {
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    zindex: 999,
                    message: 'You are the owner of the group! Deleting will also delete all users in the group. Are you sure? You can instead change the owner of the group.',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            deleteUserFromGroup(userId, ownerId, groupId);

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });

            } else {
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    zindex: 999,
                    message: 'Are you sure you want to delete this user from the group?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            deleteUserFromGroup(userId, ownerId, groupId);

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
            }
        })
    })

    function deleteUserFromGroup(userId, ownerId, groupId) {
        $.ajax({
            type: 'POST',
            url: 'controllers/groups/deleteUserFromGroup.php',
            data: {
                delete_user_from_group: true,
                userId: userId,
                groupId: groupId,
                ownerId: ownerId,
                csrf_token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    showNotification('success', '', response.message, 'topCenter', 5000);
                    window.location.reload();
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
        let success = true;
        // const searchRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"':;?/>]).{7,}$/; // (?=.*[a-z]): At least one lowercase letter. (?=.*[A-Z]): At least one uppercase letter. (?=.*\d): At least one digit. (?!.*[~%^&*()+}{[]|"':;?/>])`: Negative lookahead assertion to exclude the specified symbols. .{8,}: Minimum length of 8 characters.
        let searchValue = $(this).val();

        // if (!searchRegex.test(searchValue)) {
        // success = false;
        // $("#searchResultsUl").empty();
        // return;
        // }

        if (searchValue.length == 0 || searchValue.length == 1) {
            $("#searchResultsUl").empty();
            return;
        }

        if (searchValue.length > 1 && success) {
            $.ajax({
                type: 'POST',
                url: 'controllers/groups/searchUser.php',
                data: {
                    search_user: true,
                    searchValue: searchValue,
                    csrf_token: csrfToken
                },
                success: function (response) {
                    if (response.success) {
                        $("#searchResultsUl").empty();
                        let users = response.users;
                        users.forEach(user => {
                            $("#searchResultsUl").append(`<button class="list-group-item list-group-item-action" data-user-email="${user.email}">${user.email}</button>`);
                        });
                        $(document).on('click', 'button.list-group-item', function () {
                            let userEmail = $(this).data('user-email');
                            $("#searchUser").val(userEmail);
                            $("#searchResultsUl").empty();
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error searching users:', error);
                }
            })
        }
    })

    $("#addUserBtn").on('click', function () {
        let selectedGroup = $("#groups").val();
        let selectedUser = $("#searchUser").val();

        $.ajax({
            type: 'POST',
            url: 'controllers/groups/addUserToGroup.php',
            data: {
                add_user_to_group: true,
                selectedGroup: selectedGroup,
                selectedUser: selectedUser,
                csrf_token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    response.message = sessionStorage.setItem('messageShown_add_group', true);
                    window.location.reload();
                } else {
                    showNotification('error', '', response.message, 'topCenter', 5000);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error adding user:', error);
            }
        })

    })

    console.log(sessionStorage);
});