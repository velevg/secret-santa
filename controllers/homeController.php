<?php

function homeController($smarty, $db)
{
    if (isUserLoggedIn()) {
        // if (isset($_SESSION['message_add_user'])) unset($_SESSION['message_add_user']);

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
           -- AND user_groups.approved = 1
            AND groups.deleted IS NULL
            AND user_groups.deleted IS NULL;
        ");
        // mnogo si baven AND user_groups.approved = 1
        $query_groups->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $query_groups->execute();
        $groups = $query_groups->fetchAll(PDO::FETCH_ASSOC);

        $user_groups = [];
        foreach ($groups as $group) {
            $query_user_groups = $db->prepare("
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
            $query_user_groups->bindParam(":group_id", $group['id'], PDO::PARAM_INT);
            $query_user_groups->execute();
            $user_groups[] = $query_user_groups->fetchAll(PDO::FETCH_ASSOC);
        }

        $smarty->assign('user_groups', $user_groups);
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
}
