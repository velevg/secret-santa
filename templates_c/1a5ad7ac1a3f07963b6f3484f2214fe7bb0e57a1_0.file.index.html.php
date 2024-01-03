<?php
/* Smarty version 4.3.4, created on 2024-01-03 14:22:36
  from 'F:\WebDev\Xampp\htdocs\secret-santa\views\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65955f9c8cdf74_27446415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a5ad7ac1a3f07963b6f3484f2214fe7bb0e57a1' => 
    array (
      0 => 'F:\\WebDev\\Xampp\\htdocs\\secret-santa\\views\\index.html',
      1 => 1704288155,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65955f9c8cdf74_27446415 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Santa</title>
    <link rel="icon" href="assets/images/48x48.ico" type="image/x-icon" sizes="16x16 32x32 48x48">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"><?php echo '</script'; ?>
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
        if (!sessionStorage.getItem('messageShown_login') && "<?php if ($_SESSION['message_login']) {
echo $_SESSION['message_login'];
}?>") {
            window.sessionMessageLogin = "<?php if ($_SESSION['message_login']) {
echo $_SESSION['message_login'];
}?>";
            sessionStorage.setItem('messageShown_login', true);
        }
        if (!sessionStorage.getItem('messageShown_add_group') && "<?php if ((isset($_SESSION['message_add_group']))) {
echo $_SESSION['message_add_group'];
}?>") {
            window.sessionMessage_add_group = "<?php if ((isset($_SESSION['message_add_group']))) {
echo $_SESSION['message_add_group'];
}?>";
            sessionStorage.setItem('messageShown_add_group', true);
        }
        // if (!sessionStorage.getItem('messageShown_add_user') && "<?php if ((isset($_SESSION['message_add_user']))) {
echo $_SESSION['message_add_user'];
}?>") {
        //     window.messageShown_add_user = "<?php if ((isset($_SESSION['message_add_user']))) {
echo $_SESSION['message_add_user'];
}?>";
        //     sessionStorage.setItem('messageShown_add_user', true); // if i add a second person i wont see the session message this is the issue
        // }
    <?php echo '</script'; ?>
>
</head>

<body>
    <div class='h-100 snow'>

        <div class="d-flex justify-content-center">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-0 active" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                        aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-0" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-0" id="groups-tab" data-bs-toggle="tab"
                        data-bs-target="#groups-tab-pane" type="button" role="tab" aria-controls="groups-tab-pane"
                        aria-selected="false">
                        Groups
                        <?php if ((isset($_smarty_tpl->tpl_vars['group_users']->value)) && count($_smarty_tpl->tpl_vars['group_users']->value) > 0) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group_users']->value, 'group');
$_smarty_tpl->tpl_vars['group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->do_else = false;
?>
                        <?php $_smarty_tpl->_assignInScope('currentUserCount', 0);?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['user']->value['approved'] === 0 && $_smarty_tpl->tpl_vars['user']->value['id'] == $_smarty_tpl->tpl_vars['user_id']->value) {?>
                        <?php $_smarty_tpl->_assignInScope('currentUserCount', $_smarty_tpl->tpl_vars['currentUserCount']->value+1);?>
                        <?php }?>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php if ($_smarty_tpl->tpl_vars['currentUserCount']->value > 0) {?>
                        <div title="<?php echo $_smarty_tpl->tpl_vars['currentUserCount']->value;?>
 new requests"
                            class="bg-warning rounded-circle position-absolute d-flex align-items-center justify-content-center">
                            <span class="badge bg-warning text-dark rounded-circle"><?php echo $_smarty_tpl->tpl_vars['currentUserCount']->value;?>
</span>
                        </div>
                        <?php }?>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php }?>
                    </button>
                </li>
            </ul>
            <div class="position-absolute top-0 end-0">
                <button id="getSession" class="btn btn-sm"><i class="bi bi-clipboard-data"></i></button>
                <a class="" href="auth" id="logout"><i class="bi bi-door-open"></i></a>
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

        <div class="tab-content h-100 d-none" id="myTabContent">
            <!--TAB GIFT-->
            <div class="tab-pane fade d-flex justify-content-center show active h-100" id="home-tab-pane"
                role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="mt-3">
                    <div class="">
                        <label for="groups" class="text-center text-white w-100">Choose group</label>
                        <select name="" id="groups" class="form-select">
                            <option value="">-- select --</option>
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
                    <div class="d-flex justify-content-center align-items-center h-75">
                        <div class='position-relative mt-5 d-flex justify-content-center align-items-center'>
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
                        </div>
                    </div>
                </div>
            </div>
            <!--TAB PROFILE-->
            <div class="tab-pane fade d-flex justify-content-center" id="profile-tab-pane" role="tabpanel"
                aria-labelledby="profile-tab" tabindex="0">
                <div class='w-75 mt-3'>
                    <div class='d-flex justify-content-center'>
                        <h5 class='card-title fs-3 text-white'>Edit Profile</h5>
                    </div>
                    <div class='mt-5 mb-5'>
                        <div class='form-floating mb-1'>
                            <input type='text' class='form-control shadow border border-0' id='profileEmail'
                                placeholder='' value='<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
' name="email" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$'
                                readonly />
                            <label for='profileEmail'>Email</label>
                        </div>
                        <div class='form-floating mb-1'>
                            <input type='text' class='form-control shadow border border-0' id='name' placeholder=''
                                value='<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
' name="name" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$'
                                autocomplete="off" />
                            <label for='name'>Name</label>
                        </div>
                        <div class='form-floating mb-1'>
                            <input class='form-control shadow border border-0' id='old_password' placeholder='' value=''
                                name="old_password" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' autocomplete="off" />
                            <label for='old_password'>old password</label>
                        </div>
                        <div class='form-floating mb-1'>
                            <input class='form-control shadow border border-0' id='new_password' placeholder='' value=''
                                name="new_password" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                            <label for='new_password'>new password</label>
                        </div>
                        <div class='form-floating mb-1'>
                            <input class='form-control shadow border border-0' id='confirm_new_password' placeholder=''
                                value='' name="confirm_new_password" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
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
                            <select name="" id="groupsAdd" class="form-select">
                                <option value="0">-- select --</option>
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
                                        <i class="bi bi-collection"></i> &nbsp;
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_name'];?>

                                    </button>
                                </h2>
                                <div id="collapse_<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionGroups">
                                    <div class="accordion-body">
                                        <table class="groupTable table table-hover w-100 customDataTable">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Email</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                                                <tr
                                                    title="<?php if ($_smarty_tpl->tpl_vars['user']->value['approved'] === 0) {?>Pending approval <?php } elseif ($_smarty_tpl->tpl_vars['user']->value['owner_id'] === $_smarty_tpl->tpl_vars['user']->value['id']) {?> Owner of group <?php }?>">
                                                    <td class="col w-25">
                                                        <?php if ($_smarty_tpl->tpl_vars['user']->value['approved'] === 0) {?> <i
                                                            class="bi bi-exclamation-triangle-fill text-danger"></i>
                                                        <?php }?>
                                                        <?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>

                                                    </td>
                                                    <td class="col w-75"><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</td>
                                                    <td class="col text-end w-auto">
                                                        <?php if ($_smarty_tpl->tpl_vars['user']->value['owner_id'] == $_smarty_tpl->tpl_vars['user_id']->value || $_smarty_tpl->tpl_vars['user_id']->value == $_smarty_tpl->tpl_vars['user']->value['id']) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['user_id']->value == $_smarty_tpl->tpl_vars['user']->value['id'] && $_smarty_tpl->tpl_vars['user']->value['approved'] === 0) {?>
                                                        <input type="button"
                                                            class="btn btn-sm btn-success approveGroupRequest"
                                                            data-user-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
" data-owner-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['owner_id'];?>
"
                                                            data-group-id="<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" value="✔" />
                                                        <?php }?>
                                                        <input type="button" class="btn btn-sm btn-danger deleteUser"
                                                            data-user-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
" data-owner-id="<?php echo $_smarty_tpl->tpl_vars['user']->value['owner_id'];?>
"
                                                            data-group-id="<?php echo $_smarty_tpl->tpl_vars['group']->value[0]['group_id'];?>
" value="X" />
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </tbody>
                                        </table>
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

    <?php echo '<script'; ?>
>
        $(document).ready(function () {
            $(".groupTable").each(function () {
                let table = $(this).DataTable({
                    // columnDefs: [
                    //     { "width": "35%", "targets": 0 },
                    //     { "width": "50%", "targets": 1 },
                    //     { "width": "15%", "targets": 2 }
                    // ]
                });
            })

            {
                const gift = $('.gift');
                const fourleaf = $('.fourleaf');
                const message = $('.message');
                let user;
                function getRandomPerson() {
                    const availableUsers = selectedUsers.filter(u => u !== userName);

                    let selectedUser = null;

                    if (availableUsers.length > 0) {
                        const randomIndex = Math.floor(Math.random() * availableUsers.length);
                        selectedUser = availableUsers[randomIndex];
                    }
                    message.html(selectedUser);

                    if (selectedUser != ' ') {
                        $.ajax({
                            url: 'ajax/updateSelectedUser.php',
                            method: 'POST',
                            data: {
                                userEmail: userEmail,
                                selectedUser: selectedUser
                            },
                            success: function (response) {
                                // console.log(response);
                            },
                            error: function (xhr, status, error) {
                                // console.error('Error updating user: ' + error);
                            }
                        });
                    }
                }

                let clickPerformed = false;
                if (!gift.hasClass('is-open')) {
                    gift.on('click', function () {
                        if (!clickPerformed) {
                            clickPerformed = true;
                            gift.toggleClass('is-open');
                            fourleaf.toggleClass('is-fade-in');
                            message.toggleClass('is-visible');
                            if (gift.hasClass('is-open')) {
                                // $('#userName').prop('disabled', true);
                                // getRandomPerson();
                            }
                        }
                    });
                }

                // Extra functions
                const docTitle = document.title;
                $(window).on({
                    blur: function () {
                        document.title = 'Christmas is coming!';
                    },
                    focus: function () {
                        document.title = docTitle;
                    }
                });

                const today = new Date();
                const xmass = new Date(today.getFullYear(), 11, 25);
                if (today.getMonth() == 11 && today.getDate() > 25) {
                    xmass.setFullYear(xmass.getFullYear() + 1);
                }
                const one_day = 1000 * 60 * 60 * 24;
                const diff = Math.ceil((xmass.getTime() - today.getTime()) / one_day);
                $('#xmass').html(diff + ` days left before Christmas!`);
            }
        });
    <?php echo '</script'; ?>
>
</body>

</html><?php }
}
