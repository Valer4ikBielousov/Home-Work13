<?php
session_start();
require_once __DIR__ . '/../functions/functions.php';
require_once __DIR__ . '/../functions/validation.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database_functions.php';

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
    'Name' => 'required|min_lenghth[2]|max_lenghth[15]',
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
    'name' => $_POST['Name'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
];


// save new user

registrationUser ( $bloger, $userData);
// redirect to closed page

header('location:' . SITE_CLOSED);


