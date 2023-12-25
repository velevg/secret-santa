<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();
session_regenerate_id(true);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login']) && isset($_POST['csrf_token']) && isset($_POST['email']) && isset($_POST['password']) && mb_strlen($_POST['email']) >= 5 && mb_strlen($_POST['password']) >= 7) {
    $success = true;

    // $secretKey = '6LfXrTspAAAAAI9J5f7r_2b_Dpmz5TDPj5mDtVBr';
    // $recaptchaResponse = $_POST['g-recaptcha-response'];

    // $verificationURL = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}";
    // $response = file_get_contents($verificationURL);
    // $responseData = json_decode($response);

    // if (!$responseData->success) {
    //     // reCAPTCHA verification failed
    //     $success = false;
    //     die('reCAPTCHA verification failed.');
    // }

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false; // cross-site-request-forgery prevention
    $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"\'\:;?\/>]).{7,}$/';
    if (!preg_match($emailRegex, $_POST['email'])) $success = false;
    if (!preg_match($passwordRegex, $_POST['password'])) $success = false;

    $email = htmlspecialchars($_POST['email']); // prevent xss attacks
    $password = htmlspecialchars($_POST['password']);

    // check user
    $query_check = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query_check->bindParam(":email", $email, PDO::PARAM_STR);
    $query_check->execute();
    $user = $query_check->fetch(PDO::FETCH_ASSOC);

    if ($user && $success) {
        if (!password_verify($password, $user['password'])) $success = false;

        if ($success) {

            if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'] || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                // Detected a potential session hijacking attempt
                session_destroy();
                header("Location: /secret-santa/auth");
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['message'] = "Login successful!";
            header("Location: /secret-santa");
            exit;
        }
    }
};
