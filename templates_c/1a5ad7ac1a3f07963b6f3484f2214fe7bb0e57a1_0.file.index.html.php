<?php
/* Smarty version 4.3.4, created on 2023-12-29 10:50:36
  from 'F:\WebDev\Xampp\htdocs\secret-santa\views\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_658e966c608c57_44945235',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a5ad7ac1a3f07963b6f3484f2214fe7bb0e57a1' => 
    array (
      0 => 'F:\\WebDev\\Xampp\\htdocs\\secret-santa\\views\\index.html',
      1 => 1703843435,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_658e966c608c57_44945235 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Santa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/js/index.js"><?php echo '</script'; ?>
>
    <link rel="manifest" href="manifest.json">
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"><?php echo '</script'; ?>
>
    <!-- RECAPTCHA -->
    <!-- <?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js" async defer><?php echo '</script'; ?>
> -->
    <?php echo '<script'; ?>
>
        // Check if the message has already been shown
        if (!sessionStorage.getItem('messageShown') && "<?php if ($_SESSION['message']) {
echo $_SESSION['message'];
}?>") {
            window.sessionMessage = "<?php if ($_SESSION['message']) {
echo $_SESSION['message'];
}?>";
            sessionStorage.setItem('messageShown', true);
        }

        if (!sessionStorage.getItem('messageShown_add_group') && "<?php if ((isset($_SESSION['message_add_group']))) {
echo $_SESSION['message_add_group'];
}?>") {
            window.sessionMessage_add_group = "<?php if ((isset($_SESSION['message_add_group']))) {
echo $_SESSION['message_add_group'];
}?>";
            sessionStorage.setItem('messageShown_add_group', true);
        }

        if (!sessionStorage.getItem('messageShown_add_user') && "<?php if ((isset($_SESSION['messageShown_add_user']))) {
echo $_SESSION['messageShown_add_user'];
}?>") {
            window.messageShown_add_user = "<?php if ((isset($_SESSION['messageShown_add_user']))) {
echo $_SESSION['messageShown_add_user'];
}?>";
            sessionStorage.setItem('messageShown_add_user', true); // ako dobavim 2ri 4ovek oba4e iskame pak da go vidim, a taka ne go vijdame :s
        }
    <?php echo '</script'; ?>
>
</head>

<body>
    <div class='h-100 snow'>

        <div class="d-flex justify-content-center">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="groups-tab" data-bs-toggle="tab" data-bs-target="#groups-tab-pane"
                        type="button" role="tab" aria-controls="groups-tab-pane" aria-selected="false">Groups</button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <!--TAB GIFT-->
            <div class="tab-pane fade d-flex justify-content-center show active" id="home-tab-pane" role="tabpanel"
                aria-labelledby="home-tab" tabindex="0">
                <div class="mt-3">
                    Home
                    <a href="auth" id="logout">Logout</a>
                    <button id="getSession" class="btn btn-sm btn-info">getSession</button>
                    <?php echo '<script'; ?>
>
                        $(document).ready(function () {
                            $("#getSession").click(function () {
                                $.ajax({
                                    type: "GET",
                                    url: "controllers/getSession.php",
                                    success: function (response) {
                                        console.log(response)
                                    }
                                })
                            })
                        })
                    <?php echo '</script'; ?>
>
                </div>
            </div>
            <!--TAB PROFILE-->
            <div class="tab-pane fade d-flex justify-content-center" id="profile-tab-pane" role="tabpanel"
                aria-labelledby="profile-tab" tabindex="0">
                <div class='w-75 mt-3'>
                    <form method="POST" id="editProfileForm">
                        <div class='d-flex justify-content-center'>
                            <h5 class='card-title fs-3'>Edit Profile</h5>
                        </div>
                        <div class='mt-5 mb-5'>
                            <div class='form-floating mb-1'>
                                <input type='text' class='form-control bg-transparent shadow border border-0'
                                    id='profileEmail' placeholder='' value='<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
' name="email"
                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' readonly />
                                <label for='profileEmail'>Email</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input type='text' class='form-control bg-transparent shadow border border-0' id='name'
                                    placeholder='' value='<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
' name="name" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$'
                                    autocomplete="off" />
                                <label for='name'>Name</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input class='form-control bg-transparent shadow border border-0' id='old_password'
                                    placeholder='' value='' name="old_password" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$'
                                    autocomplete="off" />
                                <label for='old_password'>old password</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input class='form-control bg-transparent shadow border border-0' id='new_password'
                                    placeholder='' value='' name="new_password" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                <label for='new_password'>new password</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input class='form-control bg-transparent shadow border border-0'
                                    id='confirm_new_password' placeholder='' value='' name="confirm_new_password"
                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                <label for='confirm_new_password'>confirm new password</label>
                            </div>
                        </div>
                        <div class='d-flex justify-content-center'>
                            <input id="editProfileBtn" class="btn btn-success" value="Save">
                            <input type="hidden" name="edit_profile" value="edit_profile">
                            <input id="editProfileCsrf" type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                            <!-- <div class="g-recaptcha" data-sitekey="6LfXrTspAAAAAAyvMrjpM7BhWMFcpfqEAXoGMjjP">
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
            <!--TAB GROUPS-->
            <div class="tab-pane fade" id="groups-tab-pane" role="tabpanel" aria-labelledby="groups-tab" tabindex="0">
                <div class="d-flex justify-content-center mt-3 mb-3">
                    <button id="createGroupBtn" class="btn btn-sm btn-primary">Create group</button>
                </div>

                <?php if ((isset($_smarty_tpl->tpl_vars['group_users']->value)) && count($_smarty_tpl->tpl_vars['group_users']->value) > 0) {?>
                <div class="d-flex justify-content-center mt-3 mb-3">
                    <div class="row mx-auto w-lg-50">
                        <div class="col-4">
                            <select name="" id="groups" class="form-select">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group_users']->value, 'group');
$_smarty_tpl->tpl_vars['group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->do_else = false;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" class="form-select"><?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_name'];?>

                                </option>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                        </div>
                        <div class="col-7">
                            <input type="text" id="searchUser" class="form-control" placeholder="Search user by email">
                            <ul id="searchResultsUl" class="list-group position-absolute" style="z-index: 99;"></ul>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                            <button id="addUserBtn" class="btn btn-sm btn-primary">Add</button>
                        </div>
                    </div>
                </div>
                <?php }?>
                <!-- -->
                <div class="d-flex justify-content-center">
                    <div class="w-75">
                        <div class="accordion" id="accordionGroups">

                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group_users']->value, 'group');
$_smarty_tpl->tpl_vars['group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->do_else = false;
?>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" aria-expanded="false"
                                        aria-controls="collapse_<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_name'];?>

                                    </button>
                                </h2>
                                <div id="collapse_<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionGroups">
                                    <div class="accordion-body">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                                        <div class="row">
                                            <div class="col-3">Name: <?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</div>
                                            <div class="col-7">Email: <?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</div>
                                            <div class="col-2">
                                                <?php if ($_smarty_tpl->tpl_vars['user']->value['owner_id'] == $_smarty_tpl->tpl_vars['user_id']->value || $_smarty_tpl->tpl_vars['user_id']->value == $_smarty_tpl->tpl_vars['user']->value['id']) {?>
                                                <input type="button" class="btn btn-sm btn-danger deleteUser" value="X"
                                                    data-user-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
" data-owner-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['owner_id'];?>
"
                                                    data-group-id="<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" />
                                                <?php }?>
                                            </div>
                                        </div>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </div>
                                </div>
                            </div>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                        </div>
                    </div>
                </div>
                <!---->

            </div>
        </div>

    </div>

</body>

</html><?php }
}
