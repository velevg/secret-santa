<?php

function authController($smarty)
{
    session_destroy();
    session_start();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $csrf_token = generateCSRFToken();
    $_SESSION['csrf_token'] = $csrf_token;
    $smarty->assign('csrf_token', $csrf_token);
    $smarty->display('views/auth.html');
}
