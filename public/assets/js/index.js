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
                        window.location.reload(); // tyka imash sushto problem
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
    $("#groups").on('change', function () {
        let gift = `
            <!--gift-->
            <svg xmlns='http://www.w3.org/2000/svg' class='gift' viewbox='-180 -200 800 800'>
                <path
                    d='M425.435 273.698v193.301c0 24.899-20.099 45-45 45h-150v-271h131.4c1.8 0 3.6.3 5.099.899l48.6 17.701c6 2.1 9.901 7.8 9.901 14.099z'
                    fill='#c60034' />
                <path
                    d='M415.534 259.599l-48.6-17.701c-1.5-.599-3.3-.899-5.099-.899h-311.4c-8.401 0-15 6.599-15 15v211c0 24.899 20.099 45 45 45h300c24.901 0 45-20.101 45-45V273.698c0-6.299-3.901-11.999-9.901-14.099z'
                    fill='#fc1a40' />
                <path d='M185.435 240.999v271h90v-271h-90z' fill='#fcbf29' />
                <g class='gift-top'>
                    <path
                        d='M420.035 97.788c-5.099-20.7-20.4-36.899-41.1-43.5-20.4-6.301-42.301-1.8-58.2 12.599l-34.801 30.601-6.899-45.899c-3.3-21-16.8-38.701-36.899-47.1-3.9-1.501-7.8-2.701-11.7-3.301-16.5-3.3-33.6.3-47.401 10.501-18.3 13.2-27.599 35.4-24.6 57.599 3.301 22.2 18.301 41.1 39.6 48.6l32.401 11.7 39.9 14.7h.3l69.3 25.499c6.899 2.401 14.099 3.602 20.999 3.602 14.702 0 29.101-5.402 40.501-15.601 16.799-15 23.999-38.101 18.599-60z'
                        fill='#fe9923' />
                    <path
                        d='M401.435 157.788c-11.4 10.199-25.8 15.601-40.501 15.601-6.899 0-14.099-1.201-20.999-3.602l-69.3-25.499h-.3l-39.9-14.7V1.187c3.9.601 7.8 1.8 11.7 3.301 20.099 8.399 33.6 26.1 36.899 47.1l6.899 45.899 34.801-30.601c15.899-14.399 37.8-18.9 58.2-12.599 20.7 6.601 36 22.8 41.1 43.5 5.401 21.9-1.799 45.001-18.599 60.001z'
                        fill='#fe8821' />
                    <path
                        d='M476.735 234.098l-20.4 56.4c-2.401 6-8.101 9.6-14.101 9.6-1.8 0-3.6-.3-5.099-.899l-155.101-56.4-14.099-46.5-37.5 8.399-32.999 7.5-155.101-56.4c-7.8-2.999-11.699-11.7-9-19.2l20.7-56.398c3.9-11.4 12.301-20.402 23.101-25.501s23.099-5.7 34.499-1.5l118.801 43.2 8.101 2.999s32.399 58.801 33.3 58.801c.601 0 13.5-7.2 26.1-14.101 12.597-6.9 25.198-14.099 25.198-14.099l126.599 46.199c11.4 4.2 20.4 12.601 25.499 23.401 5.102 10.799 5.701 23.1 1.502 34.499z'
                        fill='#ff3e75' />
                    <path
                        d='M476.735 234.098l-20.4 56.4c-2.401 6-8.101 9.6-14.101 9.6-1.8 0-3.6-.3-5.099-.899l-155.101-56.4-14.099-46.5-37.5 8.399V96.399l8.101 2.999s32.399 58.801 33.3 58.801c.601 0 13.5-7.2 26.1-14.101 12.598-6.9 25.199-14.099 25.199-14.099l126.599 46.199c11.4 4.2 20.4 12.601 25.499 23.401 5.102 10.799 5.701 23.1 1.502 34.499z'
                        fill='#fc1a40' />
                    <path
                        d='M238.535 99.398l-8.101 22.2-32.999 90.601 32.999 12.001 37.5 13.5 14.099 5.099 41.102-112.8-84.6-30.601z'
                        fill='#fcbf29' />
                    <path fill='#fe9923'
                        d='M323.135 129.999l-41.101 112.8-14.099-5.1-37.5-13.5V121.598l8.1-22.2z' />
                </g>
                <path fill='#fe9923' d='M230.439 240.999h45v271h-45z' />
            </svg>
            <!--fourleaf-->
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 152 152' fill-rule='evenodd'
                clip-rule='evenodd' stroke-linejoin='round' stroke-miterlimit='1.41421' width='100'
                height='100' class='fourleaf'>
                <path fill='none' d='M-20-20h192v192H-20z' />
                <path
                    d='M67.975 80C70.197 80 72 81.804 72 84.025v63.95c0 2.222-1.803 4.025-4.025 4.025H4.025C1.803 152 0 150.197 0 147.975v-63.95C0 81.804 1.803 80 4.025 80h63.95zm80 0c2.222 0 4.025 1.804 4.025 4.025v63.95c0 2.222-1.803 4.025-4.025 4.025h-63.95c-2.222 0-4.025-1.803-4.025-4.025v-63.95C80 81.804 81.803 80 84.025 80h63.95zm-80-80C70.197 0 72 1.804 72 4.025v63.95C72 70.197 70.197 72 67.975 72H4.025C1.803 72 0 70.197 0 67.975V4.025C0 1.804 1.803 0 4.025 0h63.95zm80 0C150.197 0 152 1.804 152 4.025v63.95c0 2.222-1.803 4.025-4.025 4.025h-63.95C81.803 72 80 70.197 80 67.975V4.025C80 1.804 81.803 0 84.025 0h63.95z'
                    fill='none' />
                <clipPath id='a'>
                    <path
                        d='M67.975 80C70.197 80 72 81.804 72 84.025v63.95c0 2.222-1.803 4.025-4.025 4.025H4.025C1.803 152 0 150.197 0 147.975v-63.95C0 81.804 1.803 80 4.025 80h63.95zm80 0c2.222 0 4.025 1.804 4.025 4.025v63.95c0 2.222-1.803 4.025-4.025 4.025h-63.95c-2.222 0-4.025-1.803-4.025-4.025v-63.95C80 81.804 81.803 80 84.025 80h63.95zm-80-80C70.197 0 72 1.804 72 4.025v63.95C72 70.197 70.197 72 67.975 72H4.025C1.803 72 0 70.197 0 67.975V4.025C0 1.804 1.803 0 4.025 0h63.95zm80 0C150.197 0 152 1.804 152 4.025v63.95c0 2.222-1.803 4.025-4.025 4.025h-63.95C81.803 72 80 70.197 80 67.975V4.025C80 1.804 81.803 0 84.025 0h63.95z' />
                </clipPath>
                <g clip-path='url(#a)'>
                    <path
                        d='M20.577 20.577C23.066 8.826 33.51 0 46 0c14.35 0 26 11.65 26 26v46L48.315 32.658v-.001l-.002-.004-.044-.073h-.001C43.714 25.043 35.441 20 26 20c-1.86 0-3.675.196-5.423.577zM72 126c0 14.35-11.65 26-26 26-12.49 0-22.934-8.826-25.423-20.577 1.748.381 3.563.577 5.423.577 9.441 0 17.714-5.043 22.268-12.58h.001L72 80v46zM80 26c0-14.35 11.65-26 26-26 12.49 0 22.934 8.826 25.423 20.577C129.675 20.196 127.86 20 126 20c-9.441 0-17.714 5.043-22.268 12.58h-.001L80 72V26zM103.685 119.342l.046.078h.001C108.286 126.957 116.559 132 126 132c1.86 0 3.675-.196 5.423-.577C128.934 143.174 118.49 152 106 152c-14.35 0-26-11.65-26-26V80l23.685 39.342z'
                        fill='#40bf4f' />
                    <path
                        d='M131.423 20.577C143.174 23.066 152 33.51 152 46c0 14.323-11.606 25.956-26 26H80l39.342-23.685h.001l.004-.002.073-.044v-.001C126.957 43.714 132 35.441 132 26c0-1.86-.196-3.675-.577-5.423z'
                        fill='#40bf4f' />
                    <path
                        d='M80 72l23.685-39.342v-.001l.002-.004.044-.073h.001C108.286 25.043 116.559 20 126 20c1.86 0 3.675.196 5.423.577.381 1.748.577 3.563.577 5.423 0 9.441-5.043 17.714-12.58 22.268v.001L80 72z'
                        fill='#308d3b' />
                    <path
                        d='M20.577 20.577C20.196 22.325 20 24.14 20 26c0 9.441 5.043 17.714 12.58 22.268v.001L72 72H26C11.65 72 0 60.35 0 46c0-12.49 8.826-22.934 20.577-25.423z'
                        fill='#40bf4f' />
                    <path
                        d='M20.577 20.577C22.325 20.196 24.14 20 26 20c9.441 0 17.714 5.043 22.268 12.58h.001L72 72 32.658 48.315h-.001l-.004-.002-.073-.044v-.001C25.043 43.714 20 35.441 20 26c0-1.86.196-3.675.577-5.423z'
                        fill='#308d3b' />
                    <path
                        d='M126 80c14.394.044 26 11.677 26 26 0 12.49-8.826 22.934-20.577 25.423.381-1.748.577-3.563.577-5.423 0-9.441-5.043-17.714-12.58-22.268v-.001L80 80h46z'
                        fill='#40bf4f' />
                    <path
                        d='M119.342 103.685l.078.046v.001C126.957 108.286 132 116.559 132 126c0 1.86-.196 3.675-.577 5.423-1.748.381-3.563.577-5.423.577-9.441 0-17.714-5.043-22.268-12.58h-.001L80 80l39.342 23.685z'
                        fill='#308d3b' />
                    <path
                        d='M72 80l-39.342 23.685h-.001l-.004.002-.073.044v.001C25.043 108.286 20 116.559 20 126c0 1.86.196 3.675.577 5.423C8.826 128.934 0 118.49 0 106c0-14.35 11.65-26 26-26h46z'
                        fill='#40bf4f' />
                    <path
                        d='M48.315 119.342v.001l-.002.004-.044.073h-.001C43.714 126.957 35.441 132 26 132c-1.86 0-3.675-.196-5.423-.577C20.196 129.675 20 127.86 20 126c0-9.441 5.043-17.714 12.58-22.268v-.001L72 80l-23.685 39.342z'
                        fill='#308d3b' />
                </g>
            </svg>
            <!--message-->
            <h3 class='message'></h3>
        `;
        let giftContainer = $("#gift-container");
        let groupId = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'app/controllers/groups/generateGiftAjax.php',
            data: {
                generate_gift: true,
                groupId: groupId,
                csrf_token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    $("#gift-container").empty();


                    // $("#gift-container").append(response.gift);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error generating gift:', error);
            }
        })
    });
});