<?php
session_start();
require_once __DIR__ . '/../functions/database_functions.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
$connect=connect();

// unset cookie
if (unchekAuth($connect)) {
    unset ($_COOKIE['auth']);
}
//chek if unset cookie
if (!chekAuth($connect)) {
    header('location:' . SITE_REGISTRATION);
    exit;
}
