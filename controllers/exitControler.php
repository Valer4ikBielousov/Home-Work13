<?php
session_start();
require_once __DIR__ . '/../functions/database_functions.php';
require_once __DIR__ . '/../config.php';

// unset cookie
if (unchekAuth()) {
    unset ($_COOKIE['auth']);
}
//chek if unset cookie
if (!chekAuth()) {
    header('location:' . SITE_REGISTRATION);
    exit;
}
