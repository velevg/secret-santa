<?php
require('../../vendor/autoload.php');
require('../../db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login']) && isset($_POST['csrf_token']) && isset($_POST['email']) && isset($_POST['password']) && mb_strlen($_POST['email']) >= 5 && mb_strlen($_POST['password']) >= 5) {
    $success = true;
}
