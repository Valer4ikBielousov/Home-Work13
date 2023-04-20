<?php
session_start();
require_once __DIR__ . '/../functions/functions.php';
require_once __DIR__ . '/../validation.php';

// require from database "bloger" with PHP (PDO) on mySQL
require_once __DIR__ . "/../db.php";

// set REQUEST_METHOD errors into Session
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setAlerts('Method not allowed!', 'warnings');
    header('location: http://home-work13');
}
$bugName = [
    'Name' => 'required|min_lenghth[2]|max_lenghth[15]',
    'lastName' => 'required|min_lenghth[2]|max_lenghth[15]',
    'email' => 'required|email|min_lenghth[6]|max_lenghth[15]',
    'password' => 'required|min_lenghth[4]|max_lenghth[25]|symbol',
    'confirmPassword' => 'required|confirmPassword'
];

// set validation errors messages into Session

$bugArray = validation($_POST, $bugName);
foreach ($bugArray as $bugField => $bugindex) {
    if (isset($bugindex)) {
        foreach ($bugindex as $bugMassages) {
            setAlerts($bugMassages, $bugField);
        }
        header('location: http://home-work13');
    }
}

// chek if email free
$query = "SELECT `email` FROM `users` WHERE `email` = ?";
$stmt = $bloger->prepare($query);
$stmt->execute([$_POST['email']]);
if ($stmt->rowCount() > 0) {
    setAlerts('Not free email! Try again!', 'warn');
    header('location: http://home-work13');
    exit;
}

// save new user
$sql = 'INSERT INTO `users` (`name`, `email`, `password`) 
        VALUES("' . $_POST['Name'] . '", "' . $_POST['email'] . '", "' . $_POST['password'] . '")';
$statement = $bloger->query($sql);

// set cookie  new user
setcookie('auth', true, time() + 3600 * 24 * 7, '/');
// redirect to closed page
header('location: http://home-work13/closed.php');


