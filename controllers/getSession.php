<?php
require('../vendor/autoload.php');
require('../db.php');

session_start();

$response = [
    'success' => true,
    'session' => [],
    'server' => [],
];

$response['session'] = $_SESSION;
$response['server'] = $_SERVER;

header('Content-Type: application/json');
echo json_encode($response);
