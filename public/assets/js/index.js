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
    let sessionMessageLogin = window.sessionMessageLogin;
    if (sessionMessageLogin) {
        showNotification('success', 'Success', sessionMessageLogin, 'topCenter', 5000);
    }
    let sessionMessage_add_group = window.sessionMessage_add_group;
    if (sessionMessage_add_group) {
        showNotification('success', 'Success', sessionMessage_add_group, 'topCenter', 5000);
    }
    // let messageShown_add_user = window.messageShown_add_user;
    // if (messageShown_add_user) {
    //     showNotification('success', 'Success', messageShown_add_user, 'topCenter', 5000);
    // }

    // === VALIDATION
    var onlyLettersRegex = /^[a-zA-Z]+$/;
    // const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"':;?/>]).{7,}$/; // (?=.*[a-z]): At least one lowercase letter. (?=.*[A-Z]): At least one uppercase letter. (?=.*\d): At least one digit. (?!.*[~%^&*()+}{[]|"':;?/>])`: Negative lookahead assertion to exclude the specified symbols. .{8,}: Minimum length of 8 characters.
    let csrfToken = $("#editProfileCsrf").val();

    // === PROFILE
    if ($("#name").val().length === 0) {
        let name;
        iziToast.info({
            timeout: 100000,
            overlay: true,
            displayMode: 'once',
            id: 'inputs',
            zindex: 999,
            title: '',
            message: 'Please enter your name:',
            position: 'center',
            drag: false,
            inputs: [
                ['<input type="text">', 'keyup', function (instance, toast, input, e) {
                    $("#name").val(input.value);
                }, true],
                ['<input type="button" id="addName" value="Add">', 'click', function (instance, toast, input, e) {
                    // updateProfile(name);
                    $("#editProfileBtn").click();
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }]
            ]
        });
    }
    $("#name").on('input', function () {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
    })
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
            if (!onlyLettersRegex.test(name)) {
                showNotification('error', '', 'Name must only contain letters!', 'topCenter', 5000);
                success = false;
                $("#editProfileBtn").attr("disabled", true);
                $("#editProfileBtn").addClass("btn-danger");
                $("#editProfileBtn").effect("shake", { times: 5 }, 1000);
                setInterval(function () {
                    $("#editProfileBtn").removeClass("btn-danger");
                    $("#editProfileBtn").removeAttr("disabled");
                }, 1200)
            }
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
                    }, 1200)
                    if (newPassword != confirmNewPassword) {
                        showNotification('error', '', 'New password and confirm new password do not match!', 'topCenter', 5000);
                        success = false;
                        $("#editProfileBtn").attr("disabled", true);
                        $("#editProfileBtn").addClass("btn-danger");
                        $("#editProfileBtn").effect("shake", { times: 5 }, 1000);
                        setInterval(function () {
                            $("#editProfileBtn").removeClass("btn-danger");
                            $("#editProfileBtn").removeAttr("disabled");
                        }, 1200)
                    }
                }
            }
            if (success) {
                $.ajax({
                    type: "POST",
                    url: "app/controllers/profile/editProfileAjax.php",
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
                    input.value = input.value.replace(/[^a-zA-Z0-9-_]/g, ''); // letters, numbers and - _
                    newGroupName = input.value;
                }, true],
                ['<input type="button" id="createGroup" value="Create">', 'click', function (instance, toast, input, e) {
                    createGroup(newGroupName);
                }]
            ]
        });

        function createGroup() {
            $.ajax({
                type: "POST",
                url: "app/controllers/groups/addGroupAjax.php",
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
            url: 'app/controllers/groups/deleteUserFromGroupAjax.php',
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
                url: 'app/controllers/groups/searchUserAjax.php',
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
        let selectedGroup = $("#groupsAdd").val();
        let selectedUser = $("#searchUser").val();

        if (selectedGroup > 0) {
            if (selectedUser.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'app/controllers/groups/addUserToGroupAjax.php',
                    data: {
                        add_user_to_group: true,
                        selectedGroup: selectedGroup,
                        selectedUser: selectedUser,
                        csrf_token: csrfToken
                    },
                    success: function (response) {
                        if (response.success) {
                            showNotification('success', '', response.message, 'topCenter', 5000);
                            // response.message = sessionStorage.setItem('messageShown_add_group', true); // Tupak si
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showNotification('error', '', response.message, 'topCenter', 5000);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error adding user:', error);
                    }
                })
            } else {
                showNotification('error', '', 'Please select a user', 'topCenter', 5000);
            }
        } else {
            showNotification('error', '', 'Please select a group and a user', 'topCenter', 5000);
        }
    })

    console.log(sessionStorage);

    $(".approveGroupRequest").each(function () {
        $(this).on('click', function () {
            let groupId = $(this).data('group-id');
            let userId = $(this).data('user-id');
            $.ajax({
                type: 'POST',
                url: 'app/controllers/groups/approveGroupRequestAjax.php',
                data: {
                    approve_group_request: true,
                    groupId: groupId,
                    userId: userId,
                    csrf_token: csrfToken
                },
                success: function (response) {
                    if (response.success) {
                        showNotification('success', '', response.message, 'topCenter', 5000);
                        // window.location.reload(); // tyka imash sushto problem
                    } else {
                        showNotification('error', '', response.message, 'topCenter', 5000);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error approving group request:', error);
                }
            })
        })
    });

    // select group -> generate with ajax the gift -> append the gift
});