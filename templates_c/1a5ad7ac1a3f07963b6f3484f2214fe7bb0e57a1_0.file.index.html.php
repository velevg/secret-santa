<?php
/* Smarty version 4.3.4, created on 2023-12-25 12:11:50
  from 'F:\WebDev\Xampp\htdocs\secret-santa\views\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65896376b123a9_53377233',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a5ad7ac1a3f07963b6f3484f2214fe7bb0e57a1' => 
    array (
      0 => 'F:\\WebDev\\Xampp\\htdocs\\secret-santa\\views\\index.html',
      1 => 1703502700,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65896376b123a9_53377233 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php echo '</script'; ?>
>
</head>

<body>
    <div class='h-100 snow'>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Gift</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                    type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Groups</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!--TAB GIFT-->
            <div class="tab-pane fade show active d-flex justify-content-center" id="home-tab-pane" role="tabpanel"
                aria-labelledby="home-tab" tabindex="0">
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
            <!--TAB PROFILE-->
            <div class="tab-pane fade d-flex justify-content-center" id="profile-tab-pane" role="tabpanel"
                aria-labelledby="profile-tab" tabindex="0">
                <div class='w-75'>
                    <form method="POST" id="editProfileForm">
                        <div class='d-flex justify-content-center'>
                            <h5 class='card-title fs-3'>Edit Profile</h5>
                        </div>
                        <div class='mt-5 mb-5'>
                            <!-- <div class='form-floating mb-1'>
                            <input type='text' class='form-control bg-transparent shadow border border-0'
                                id='profileEmail' placeholder='' value='' name="email"
                                pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                            <label for='profileEmail'>Email</label>
                        </div> -->
                            <div class='form-floating mb-1'>
                                <input type='text' class='form-control bg-transparent shadow border border-0' id='name'
                                    placeholder='' value='' name="name" pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                <label for='name'>Name</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input type='password' class='form-control bg-transparent shadow border border-0'
                                    id='old_password' placeholder='' value='' name="old_password"
                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                <label for='old_password'>old password</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input type='password' class='form-control bg-transparent shadow border border-0'
                                    id='new_password' placeholder='' value='' name="new_password"
                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                <label for='new_password'>new password</label>
                            </div>
                            <div class='form-floating mb-1'>
                                <input type='password' class='form-control bg-transparent shadow border border-0'
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
            <div class="tab-pane fade d-flex justify-content-center" id="contact-tab-pane" role="tabpanel"
                aria-labelledby="contact-tab" tabindex="0">
                Groups tab</div>
        </div>

    </div>

</body>

</html><?php }
}
