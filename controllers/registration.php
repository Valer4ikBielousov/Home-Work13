<?php
session_start();
require_once __DIR__ . '/../functions/functions.php';
require_once __DIR__ . '/../functions/validation.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions/database_functions.php';

// require from database "bloger" with PHP (PDO) on mySQL
require_once __DIR__ . "/../db.php";


// set REQUEST_METHOD errors into Session
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setAlerts('Method not allowed!', 'warnings');
    header('location:' . SITE_REGISTRATION);
}

//Set value of Field Name into session
setF($_POST, 'registration_form');

//declare a type of errors on validation form
$bugName = [
    'Name' => 'required|min_lenghth[2]|max_lenghth[30]',
    'lastName' => 'required|min_lenghth[2]|max_lenghth[15]',
    'email' => 'required|email|min_lenghth[6]|max_lenghth[25]|freeEmail',
    'password' => 'required|min_lenghth[4]|max_lenghth[25]|symbol',
    'confirmPassword' => 'required|confirmPassword'
];


// set validation errors messages into Session

$bugArray = validation($_POST, $bugName, $bloger);
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
    'name' => $_POST['Name'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
];

$userId = registrationUser ( $bloger, $userData);
// save new user

if (!$userId){
    setAlerts('Data base error!', 'warnings');
    header('location:' . SITE_REGISTRATION);
    exit;
};

$token = generatrToken($userId);
$sessionData = [
    'user_id' => $userId,
    'token' => $token,
    'user_agent' => getUserAgent(),
    'ip' => getUserIp()
];
$sessionId = createSession ($bloger,  $sessionData);

if (!$sessionId){
    setAlerts('Data base error!', 'warnings');
    header('location:' . SITE_REGISTRATION);
    exit;
};

setcookie('auth' , $token , time() + (3600*24*7), '/');
// redirect to closed page

header('location:' . SITE_LOGIN);


