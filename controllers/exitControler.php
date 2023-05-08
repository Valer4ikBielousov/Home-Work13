<?php
session_start();
require_once __DIR__ . '/../functions/database_functions.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// unset cookie
if (unchekAuth($bloger)) {
    unset ($_COOKIE['auth']);
}
//chek if unset cookie
if (!chekAuth($bloger)) {
    header('location:' . SITE_REGISTRATION);
    exit;
}
