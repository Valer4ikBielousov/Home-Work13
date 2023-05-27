<?php
session_start();
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

// parametr for function filterPostArray with type of filter to fields
$filters = [
    'Name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'lastName' => FILTER_SANITIZE_SPECIAL_CHARS,
    'email' => FILTER_SANITIZE_EMAIL,
    'password' => FILTER_SANITIZE_SPECIAL_CHARS,
    'confirmPassword' => FILTER_SANITIZE_SPECIAL_CHARS
];
//function to filter POST array
$filteredPost = filterPostArray($filters);

//Set value of Field Name into session
setF($filteredPost, 'registration_form');

//declare a type of errors on validation form
$bugName = [
    'Name' => 'required|min_lenghth[2]|max_lenghth[30]',
    'lastName' => 'required|min_lenghth[2]|max_lenghth[15]',
    'email' => 'required|email|min_lenghth[6]|max_lenghth[25]|freeEmail',
    'password' => 'required|min_lenghth[4]|max_lenghth[25]|symbol',
    'confirmPassword' => 'required|confirmPassword'
];


// set validation errors messages into Session

$bugArray = validation($filteredPost, $bugName, $connect);
foreach ($bugArray as $bugField => $bugindex) {
    if (isset($bugindex)) {
        foreach ($bugindex as $bugMassages) {
            setAlerts($bugMassages, $bugField);
        }
        header('location:' . SITE_REGISTRATION);
        exit;
    }
}

$userData = [
    'role_id' => 2,
    'name' => $filteredPost['Name'],
    'email' => $filteredPost['email'],
    'password' => password_hash($filteredPost['password'], PASSWORD_BCRYPT)
];

$userId = registrationUser($connect, $userData);
// save new user

if (!$userId) {
    setAlerts('Data base error!', 'warnings');
    header('location:' . SITE_REGISTRATION);
    exit;
}

$token = generatrToken($userId);
$sessionData = [
    'user_id' => $userId,
    'token' => $token,
    'user_agent' => getUserAgent(),
    'ip' => getUserIp()
];
$sessionId = createSession($connect, $sessionData);

if (!$sessionId) {
    setAlerts('Data base error!', 'warnings');
    header('location:' . SITE_REGISTRATION);
    exit;
}

setcookie('auth', $token, time() + (3600 * 24 * 7), '/');
// redirect to closed page

header('location:' . SITE_CLOSED);


