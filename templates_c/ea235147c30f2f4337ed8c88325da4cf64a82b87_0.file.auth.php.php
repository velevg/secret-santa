<?php
/* Smarty version 4.3.4, created on 2023-12-23 11:23:19
  from 'F:\WebDev\Xampp\htdocs\secret-santa\views\auth.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6586b517383ba3_84690663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea235147c30f2f4337ed8c88325da4cf64a82b87' => 
    array (
      0 => 'F:\\WebDev\\Xampp\\htdocs\\secret-santa\\views\\auth.php',
      1 => 1703326997,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6586b517383ba3_84690663 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Secret-Santa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/js/login.js"><?php echo '</script'; ?>
>
    <link rel="manifest" href="manifest.json">
</head>

<body>
    <?php echo '<?php'; ?>

    echo 'tyk';
    <?php echo '?>'; ?>

    <div class='d-flex justify-content-center align-items-center h-100 snow'>
        <!--FLIP CARD-->
        <div class='flip-card-3D-wrapper'>
            <div id='flip-card'>
                <div class='flip-card-front'>
                    <div class='h-100 d-flex justify-content-center align-items-center'>
                        <div class='w-75'>
                            <form action="controllers/login.php" method="POST" id="loginForm">
                                <div class='d-flex justify-content-center'>
                                    <h5 class='card-title fs-1'>Login</h5>
                                </div>
                                <div>
                                    <div class='d-flex justify-content-start'></div>
                                    <div class='form-floating mt-5 mb-5 d-flex justify-content-center'>
                                        <div>
                                            <div class='d-flex justify-content-start text-center'>
                                                <span class='w-100' style='min-height: 50px !important;'>Welcome back
                                                    <span id='display-name'></span></span>
                                            </div>
                                            <div class='form-floating'>
                                                <input type='email' name="email"
                                                    class='form-control bg-transparent shadow border border-0'
                                                    id='loginEmail' placeholder='' value=''
                                                    pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                                <label class='fw-bold' for='email fs'>Email</label>
                                            </div>
                                            <div class='form-floating'>
                                                <input type='password' name="password"
                                                    class='form-control bg-transparent shadow border border-0'
                                                    id='loginPassword' placeholder='' value=''
                                                    pattern='^[A-Za-z0-9]+$' />
                                                <label class='fw-bold' for='password fs'>Password</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <button type="submit" id='loginBtn' class='btn btn-primary w-100 fw-bold'>
                                        Login
                                    </button>
                                    <input type="hidden" name="login" value="login">
                                </div>
                            </form>
                            <div class='mt-1'>
                                <div class='fw-bold'>Need an account?</div>
                                <button class='ms-1 btn btn-sm btn-outline-dark' id='flip-card-btn-turn-to-front'>
                                    <i class='bi bi-arrow-left fw-bold'>register!</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='flip-card-back'>
                    <div class='h-100 d-flex justify-content-center align-items-center'>
                        <div class='w-75'>
                            <form action="controllers/register.php" method="POST">
                                <div class='d-flex justify-content-center'>
                                    <h5 class='card-title fs-1'>Register</h5>
                                </div>
                                <div class='form-floating mt-5 d-flex justify-content-center'>
                                    <input type='text' class='form-control bg-transparent shadow border border-0'
                                        id='registerEmail' placeholder='' value='' name="email"
                                        pattern='[^\s@]+@[^\s@]+\.[^\s@]+$' />
                                    <label class='fw-bold' for='email fs'>Email</label>
                                </div>
                                <div class='form-floating mb-5 d-flex justify-content-center'>
                                    <input type='password' class='form-control bg-transparent shadow border border-0'
                                        name="password" id='registerPassword' placeholder='' value=''
                                        pattern='^[A-Za-z0-9]+$' />
                                    <label class='fw-bold' for='password fs'>Password</label>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <button type="submit" id='registerBtn' class='btn btn-primary w-100 fw-bold'>
                                        Register
                                    </button>
                                    <input type="hidden" name="register" value="register">
                                </div>

                            </form>
                            <div class='mt-1'>
                                <div class='fw-bold'>Have an account?</div>
                                <button class='ms-1 btn btn-sm btn-outline-dark' id='flip-card-btn-turn-to-back'>
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
