<?php
require('vendor/autoload.php');
require('db.php');

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
        global $db;
        $email = $_SESSION['email'];
        $csrf_token = $_SESSION['csrf_token'];

        $query_check = $db->prepare("SELECT * FROM users WHERE 1 AND email = :email AND deleted IS NULL;");
        $query_check->bindParam(":email", $email, PDO::PARAM_STR);
        $query_check->execute();
        $user = $query_check->fetch(PDO::FETCH_ASSOC);

        $query_groups = $db->prepare("
            SELECT
                groups.id,
                user_groups.approved
            FROM
                groups
            LEFT JOIN
                user_groups ON groups.id = user_groups.group_id
            WHERE 1
            AND user_groups.user_id = :user_id
            AND user_groups.approved = 1
            AND groups.deleted IS NULL
            AND user_groups.deleted IS NULL;
        ");
        $query_groups->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $query_groups->execute();
        $groups = $query_groups->fetchAll(PDO::FETCH_ASSOC);

        $group_users = [];
        foreach ($groups as $group) {
            $query_group_users = $db->prepare("
                SELECT
                    users.id,
                    users.username,
                    users.email,
                    groups.id AS group_id,
                    groups.group_name,
                    groups.owner AS owner_id,
                    user_groups.id AS user_group_id,
                    user_groups.user_id AS user_group_user_id,
                    user_groups.approved
                FROM
                    users
                LEFT JOIN
                    user_groups ON users.id = user_groups.user_id
                LEFT JOIN
                    groups ON user_groups.group_id = groups.id
                WHERE 1
                AND user_groups.group_id = :group_id
                AND user_groups.deleted IS NULL;
            ");
            $query_group_users->bindParam(":group_id", $group['id'], PDO::PARAM_INT);
            $query_group_users->execute();
            $group_users[] = $query_group_users->fetchAll(PDO::FETCH_ASSOC);
        }

        $smarty->assign('group_users', $group_users);
        $smarty->assign('user_id', $user['id']);
        $smarty->assign('username', $user['username']);
        $smarty->assign('email', $user['email']);
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
