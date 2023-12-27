<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_user']) && isset($_POST['csrf_token']) && isset($_POST['searchValue'])) {
    $success = true;
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    if ($success) {
        $searchValue = $_POST['searchValue'];

        $query_users = $db->prepare("SELECT email FROM users WHERE 1 AND email LIKE :searchValue AND deleted IS NULL");
        $query_users->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
        $query_users->execute();
        $query_result = $query_users->fetchAll();

        $response['users'] = $query_result;
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request!';
}

header('Content-Type: application/json');
echo json_encode($response);
