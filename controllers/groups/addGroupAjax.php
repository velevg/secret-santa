<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_group']) && isset($_POST['csrf_token']) && isset($_POST['group_name']) && mb_strlen($_POST['group_name']) >= 1) {
    $success = true;

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    $group_name = $_POST['group_name'];
    $approved = 1;

    if ($success) {
        $groups = "INSERT INTO groups (group_name, owner) VALUES (:group_name, :user_id)";
        $stmt = $db->prepare($groups);
        $stmt->bindParam(':group_name', $group_name, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        $group_id = $db->lastInsertId();

        $user_groups = "INSERT INTO user_groups (group_id, user_id, approved) VALUES (:group_id, :user_id, :approved)";
        $stmt = $db->prepare($user_groups);
        $stmt->bindParam(':approved', $approved, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['message_add_group'] = 'Group created!';
        $response['message'] = 'Group created!';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to create group!';
    }
};

header('Content-Type: application/json');
echo json_encode($response);
