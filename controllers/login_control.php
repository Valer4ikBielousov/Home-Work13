<?php
//session_start();
require_once __DIR__ . '/../functions/functions.php';
require_once __DIR__ . '/../functions/validation.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions/database_functions.php';

// require from database "bloger" with PHP (PDO) on mySQL
require_once __DIR__ . "/../db.php";
$connect = connect();

// set REQUEST_METHOD errors into Session
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setAlerts('Method not allowed!', 'warnings');
    header('location:' . SITE_REGISTRATION);
}
$filters = [
    'Name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'lastName' => FILTER_SANITIZE_SPECIAL_CHARS,
    'email' => FILTER_SANITIZE_EMAIL,
    'password' => FILTER_SANITIZE_SPECIAL_CHARS,
    'confirmPassword' => FILTER_SANITIZE_SPECIAL_CHARS
];
$filteredPost = filterPostArray($filters);
$userId = getUserbyEmail($connect, post('email', 'email'));

if (!chekUserExist($connect, post('email', 'email'))) {

    header('location:' . SITE_REGISTRATION);
    print_r('1');
    exit;
}

if ((password_verify($filteredPost['password'], chekUserPass($connect, post('email', 'email'))))) {

    login($connect, $userId);
    header('location:' . SITE_CLOSED);
} else {
    setAlerts('email or pass Error!', 'warnings');
    header('location:' . SITE_LOGIN);

    exit;
}

