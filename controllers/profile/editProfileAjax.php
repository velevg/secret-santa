<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name']) && isset($_POST['edit_profile']) && isset($_POST['csrf_token']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
    $success = true;
    $onlyLettersRegex = '/^[a-zA-Z]+$/';
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"\'\:;?\/>]).{7,}$/';

    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $success = false;
        $response['success'] = false;
        session_destroy();
        $response["redirect"] = "/secret-santa/auth";
    }

    if ($success && !empty($_POST['name'])) {
        if (mb_strlen($_POST['name'] >= 2) && preg_match($onlyLettersRegex, $_POST['name'])) {
            $query = $db->prepare("UPDATE users SET username = :name WHERE id = :id");
            $query->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
            $query->bindParam(":id", $_SESSION['user_id'], PDO::PARAM_INT);
            $query->execute();

            $response['message'] = 'Name updated successfully!';
        } else {
            $success = false;
            $response['success'] = false;
            $response['message'] = 'Name cannot be less than 2 characters!';
        }
    }

    if ($success && !empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
        if (mb_strlen($_POST['old_password']) >= 7 && mb_strlen($_POST['new_password']) >= 7 && mb_strlen($_POST['confirm_new_password']) >= 7) {
            if (!preg_match($passwordRegex, $oldPassword) || !preg_match($passwordRegex, $newPassword) || !preg_match($passwordRegex, $confirmNewPassword)) {
                $success = false;
                $response['success'] = false;
                $response['message'] = 'Invalid password format!';
            }

            if ($newPassword !== $confirmNewPassword) {
                $success = false;
                $response['success'] = false;
                $response['message'] = 'Passwords do not match!';
            }

            if ($success) {
                $query_oldPassword = $db->prepare("SELECT password FROM users WHERE id = :id");
                $query_oldPassword->bindParam(":id", $_SESSION['user_id'], PDO::PARAM_INT);
                $query_oldPassword->execute();
                $users_old_password = $query_oldPassword->fetch(PDO::FETCH_ASSOC);

                if (!password_verify($oldPassword, $users_old_password['password'])) {
                    $success = false;
                    $response['success'] = false;
                    $response['message'] = 'Invalid old password!';
                }

                if ($success) {
                    $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                    $query = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
                    $query->bindParam(":password", $newPassword, PDO::PARAM_STR);
                    $query->bindParam(":id", $_SESSION['user_id'], PDO::PARAM_INT);
                    $query->execute();

                    $response['message'] = 'Password changed successfully!';
                }
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid password length!';
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request!';
}

header('Content-Type: application/json');
echo json_encode($response);
