<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve_group_request']) && isset($_POST['csrf_token']) && isset($_POST['groupId']) && isset($_POST['userId'])) {
    $success = true;
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    if ($success) {
        $groupId = $_POST['groupId'];
        $userId = $_POST['userId'];

        $query = $db->prepare("UPDATE user_groups SET approved = 1 WHERE group_id = :group_id AND user_id = :user_id AND deleted IS NULL");
        $query->bindParam(':group_id', $groupId);
        $query->bindParam(':user_id', $userId);
        $query->execute();

        $response['message'] = "Request approved";
    };
};

header('Content-Type: application/json');
echo json_encode($response);
