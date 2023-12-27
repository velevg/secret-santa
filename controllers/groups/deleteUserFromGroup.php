<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user_from_group']) && isset($_POST['csrf_token']) && isset($_POST['userId']) && isset($_POST['groupId'])) {
    $success = true;

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    $user_id = $_POST['userId'];
    $group_id = $_POST['groupId'];

    if ($success) {
        $deleted = 1;
        $user_groups = "UPDATE user_groups SET deleted = :deleted WHERE user_id = :user_id AND group_id = :group_id";
        $stmt = $db->prepare($user_groups);
        $stmt->bindParam(':deleted', $deleted, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $stmt->execute();

        $response['message'] = 'User deleted successfully from group!';
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid token!';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request!';
}

header('Content-Type: application/json');
echo json_encode($response);
