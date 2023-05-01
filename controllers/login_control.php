<?php
//session_start();
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

print_r(chekUserPass($bloger,$_POST['email']));

if (!chekUserExist($bloger, $_POST['email'])){
    header('location:' . SITE_REGISTRATION);
    exit;
}

if (!(password_verify($_POST['password'], chekUserPass($bloger,$_POST['email'])))){
    header('location:' . SITE_REGISTRATION);
    exit;
}
header('location:' . SITE_CLOSED);
