<?php
require('vendor/autoload.php');
require('db.php');
require('functions.php');

$router = new AltoRouter();
$router->setBasePath('/secret-santa');

$smarty = new Smarty();

$router->map('GET|POST', '/', function () use ($smarty) {
    global $db;
    require('homeController.php');
    homeController($smarty, $db);
});

$router->map('GET|POST', '/auth', function () use ($smarty) {
    require('auth/authController.php');
    authController($smarty);
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 Not Found';
}
