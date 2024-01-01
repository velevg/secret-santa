<?php
/* Smarty version 4.3.4, created on 2024-01-01 10:28:52
  from 'F:\WebDev\Xampp\htdocs\secret-santa\views\auth.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_659285d4293b28_54539788',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b70bb5d34bf7e91d6217668baada67974c89c192' => 
    array (
      0 => 'F:\\WebDev\\Xampp\\htdocs\\secret-santa\\views\\auth.html',
      1 => 1704101331,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_659285d4293b28_54539788 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Secret-Santa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/js/auth.js"><?php echo '</script'; ?>
>
    <link rel="manifest" href="manifest.json">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"><?php echo '</script'; ?>
>
    <!-- RECAPTCHA -->
    <!-- <?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js" async defer><?php echo '</script'; ?>
> -->
    <?php if ((isset($_SESSION['message']))) {?>
    <?php echo '<script'; ?>
>
        window.sessionMessage = "<?php if ($_SESSION['message']) {
echo $_SESSION['message'];
}?>";
        if (sessionMessage) {
            showNotification('success', 'Success', sessionMessage, 'topCenter', 5000);
        }
    <?php echo '</script'; ?>
>
    <?php }?>
    <?php echo '<script'; ?>
>
        sessionStorage.clear();
    <?php echo '</script'; ?>
>
</head>

<body>

    <div class='d-flex justify-content-center align-items-center h-100 snow'>
        <!-- <button id="getSession" class="btn btn-sm btn-info">getSession</button>
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
> -->
        <!--FLIP CARD-->
        <div class='flip-card-3D-wrapper'>
            <div id='flip-card'>
                <div class='flip-card-front'>
                    <div class='h-100 d-flex justify-content-center align-items-center'>
                        <div class='w-75'>
                            <form method="POST" id="loginForm">
                                <div class='d-flex justify-content-center'>
                                    <h5 class='card-title fs-1'>Login</h5>
                                </div>
                                <div>
                                    <div class='form-floating mt-5 mb-5 d-flex justify-content-center'>
                                        <div>
                                            <div class='d-flex justify-content-start text-center'>
                                                <span class='w-100' style='min-height: 50px !important;'>Welcome back
                                                    <span id='display-login-email'></span></span>
                                            </div>
                                            <div class='form-floating mb-1'>
                                                <input type='email' name="email"
                                                    class='form-control bg-transparent shadow border border-0'
                                                    id='loginEmail' placeholder='' value=''
                                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                                <label class='fw-bold' for='email fs'>Email</label>
                                            </div>
                                            <div class='form-floating'>
                                                <input type='password' name="password"
                                                    class='form-control bg-transparent shadow border border-0'
                                                    id='loginPassword' placeholder='' value='' pattern='^[A-Za-z0-9]+$'
                                                    title="Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number." />
                                                <label class='fw-bold' for='password fs'>Password</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <input id='loginBtn' class='btn btn-primary w-100 fw-bold' value="Login">
                                    <input type="hidden" name="login" value="login">
                                    <input id="loginCsrf" type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <!-- <div class="g-recaptcha" data-sitekey="6LfXrTspAAAAAAyvMrjpM7BhWMFcpfqEAXoGMjjP">
                                    </div> -->
                                </div>
                            </form>
                            <div class='mt-1'>
                                <div class='fw-bold'>Need an account?</div>
                                <button class='btn btn-sm btn-outline-dark' id='flip-card-btn-turn-to-front'>
                                    <i class='bi bi-arrow-left fw-bold'>register!</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='flip-card-back'>
                    <div class='h-100 d-flex justify-content-center align-items-center'>
                        <div class='w-75'>
                            <form method="POST" id="registerForm">
                                <div class='d-flex justify-content-center'>
                                    <h5 class='card-title fs-1'>Register</h5>
                                </div>
                                <div>
                                    <div class='form-floating mt-5 mb-5 d-flex justify-content-center'>
                                        <div>
                                            <div class='d-flex justify-content-start text-center'>
                                                <span class='w-100' style='min-height: 50px !important;'>Welcome
                                                    <span id='display-register-email'></span></span>
                                            </div>
                                            <div class="form-floating mb-1">
                                                <input type='text'
                                                    class='form-control bg-transparent shadow border border-0'
                                                    id='registerEmail' placeholder='' value='' name="email"
                                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' autocomplete="off" />
                                                <label class='fw-bold' for='email fs'>Email</label>
                                            </div>
                                            <div class='form-floating'>
                                                <input type='password'
                                                    class='form-control bg-transparent shadow border border-0'
                                                    name="password" id='registerPassword' placeholder='' value=''
                                                    pattern='^[A-Za-z0-9]+$'
                                                    title="Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number."
                                                    autocomplete="off" />
                                                <label class='fw-bold' for='password fs'>Password</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <input id='registerBtn' class='btn btn-primary w-100 fw-bold' value="Register">
                                    <input type="hidden" name="register" value="register">
                                    <input id="registerCsrf" type="hidden" name="csrf_token" value="<?php echo $_smarty_tpl->tpl_vars['csrf_token']->value;?>
">
                                    <!-- <div class="g-recaptcha" data-sitekey="6LfXrTspAAAAAAyvMrjpM7BhWMFcpfqEAXoGMjjP">
                                    </div> -->
                                </div>
                            </form>
                            <div class='mt-1'>
                                <div class='fw-bold'>Have an account?</div>
                                <button class='btn btn-sm btn-outline-dark' id='flip-card-btn-turn-to-back'>
                                    <i class='bi bi-arrow-left fw-bold'>login!</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php }
}
