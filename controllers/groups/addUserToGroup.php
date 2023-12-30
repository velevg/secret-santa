<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_user_to_group']) && isset($_POST['csrf_token']) && isset($_POST['selectedGroup']) && isset($_POST['selectedUser'])) {
    $success = true;
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false;

    if ($success) {
        $selectedGroup = $_POST['selectedGroup'];
        $selectedEmail = $_POST['selectedUser'];

        $query = $db->prepare("SELECT id FROM users WHERE email = :email AND deleted IS NULL");
        $query->bindValue(':email', $selectedEmail, PDO::PARAM_STR);
        $query->execute();
        $query_result = $query->fetch(PDO::FETCH_ASSOC);

        if ($query_result) {
            $selected_user_id = $query_result['id'];

            $query = $db->prepare("SELECT user_id, group_id FROM user_groups WHERE 1 AND user_id = :user_id AND group_id = :group_id");
            $query->bindValue(':user_id', $selected_user_id, PDO::PARAM_INT);
            $query->bindValue(':group_id', $selectedGroup, PDO::PARAM_INT);
            $query_result = $query->fetch(PDO::FETCH_ASSOC);

            if ($query_result) {
                $success = false;
                $response['message'] = "User is already in the group!";
            }

            if ($success) {
                $query = $db->prepare("INSERT INTO user_groups (group_id, user_id) VALUES (:group_id, :user_id)");
                $query->bindValue(':group_id', $selectedGroup, PDO::PARAM_INT);
                $query->bindValue(':user_id', $selected_user_id, PDO::PARAM_INT);
                $query->execute();

                $response['success'] = true;
                $_SESSION['messageShown_add_user'] = 'User added to group successfully!';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'User not found!';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
