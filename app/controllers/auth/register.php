<?php
require('../../../vendor/autoload.php');
require('../../../db.php');

session_start();
session_regenerate_id(true);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register']) && isset($_POST['csrf_token']) && isset($_POST['email']) && isset($_POST['password']) && mb_strlen($_POST['email']) >= 5 && mb_strlen($_POST['password']) >= 7) {
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

    $email = htmlspecialchars($_POST['email']); // Sanitize input to prevent XSS attacks
    $password = htmlspecialchars($_POST['password']);

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($success) {
        try {
            $query_ip = $db->prepare("SELECT ip FROM users WHERE ip = :ip");
            $query_ip->bindParam(":ip", $ip, PDO::PARAM_STR);
            $query_ip->execute();
            $query_ip_result = $query_ip->fetchColumn();

            if (!$query_ip_result) {
                $query_email = $db->prepare("SELECT email FROM users WHERE email = :email");
                $query_email->bindParam(":email", $email, PDO::PARAM_STR);
                $query_email->execute();
                $query_email_result = $query_email->fetchColumn();

                if (!$query_email_result) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $query_insert = $db->prepare("INSERT INTO users (email, password, user_agent, ip) VALUES (?, ?, ?, ?)");
                    if (!$query_insert->execute([$email, $hashed_password, $user_agent, $ip])) $success = false;

                    if ($success) {
                        if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'] || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                            // Detected a potential session hijacking attempt
                            $response['success'] = false;
                            $response['message'] = "Session Hijacking Detected!";
                            session_destroy();
                            header("Location: /secret-santa/auth");
                            exit;
                        }

                        $_SESSION['user_id'] = $db->lastInsertId();
                        $_SESSION['email'] = $email;
                        $_SESSION['message'] = "Registration successful!";
                        header('Location: /secret-santa');
                        exit;
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Registration failed: " . $e->getMessage();
        }
    }
}
