<?php
require('vendor/autoload.php');

$router = new AltoRouter();
$router->setBasePath('/secret-santa');

$smarty = new Smarty();

function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}

$router->map('GET|POST', '/', function () use ($smarty) {
    if (isUserLoggedIn()) {
        if (!$_SESSION['csrf_token'] || empty($_SESSION['csrf_token'])) header('Location: /secret-santa/auth');
        $csrf_token = $_SESSION['csrf_token'];
        $smarty->assign('csrf_token', $csrf_token);
        $smarty->display('views/index.html');
    } else {
        session_destroy();
        session_start();
        header('Location: /secret-santa/auth');
        exit();
    }
});

$router->map('GET|POST', '/auth', function () use ($smarty) {
    session_destroy();
    session_start();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
    $smarty->assign('csrf_token', $csrf_token);
    $smarty->display('views/auth.html');
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 Not Found';
}
