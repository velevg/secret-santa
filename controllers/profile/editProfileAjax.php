<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_profile']) && isset($_POST['csrf_token']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password']) && mb_strlen($_POST['old_password']) >= 5 && mb_strlen($_POST['new_password']) >= 5 && mb_strlen($_POST['confirm_new_password']) >= 5) {
    $success = true;
    $response = $_POST;
}

header('Content-Type: application/json');
echo json_encode($response);
