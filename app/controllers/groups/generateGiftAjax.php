<?php
require('../../../vendor/autoload.php');
require('../../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['generate_gift']) && isset($_POST['csrf_token']) && isset($_POST['groupId']) && mb_strlen($_POST['groupId']) >= 1) {
    $success = true;

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    // $group_name = $_POST['group_name'];
    // $approved = 1;

    // if ($success) {

    // } else {
    //     $response['success'] = false;
    //     $response['message'] = 'Failed to create group!';
    // }
}

header('Content-Type: application/json');
echo json_encode($response);