<?php
require('../../../vendor/autoload.php');
require('../../../db.php');

session_start();

$response = [
    'success' => true,
    'message' => '',
];

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
    //     $response['success'] = false;
    //     $response['message'] = "reCAPTCHA verification failed.";
    // }

    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) $success = false; // cross-site-request-forgery prevention
    $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[~`%^&*()+}{[\]|"\'\:;?\/>]).{7,}$/';
    if (!preg_match($emailRegex, $_POST['email'])) {
        $response['success'] = false;
        $response['message'] = "Invalid email address.";
        $success = false;
    }
    if (!preg_match($passwordRegex, $_POST['password'])) {
        $response['success'] = false;
        $response['message'] = "Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
        $success = false;
    }

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

                    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'] || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                        $response['success'] = false;
                        $response['message'] = "Session Hijacking Detected!";
                        // Detected a potential session hijacking attempt
                        session_destroy();
                        header("Location: /secret-santa/auth");
                        exit;
                    }

                    $response['success'] = true;
                    $response['message'] = "Registration successful!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Registration failed: There's already an account registered with this Email address!";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Registration failed: There's already an account registered with this IP address!";
            }
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = "Registration failed: " . $e->getMessage();
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Registration failed: Invalid CSRF token";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request!";
}
header('Content-Type: application/json');
echo json_encode($response);
