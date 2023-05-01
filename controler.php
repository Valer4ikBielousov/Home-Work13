<?php
session_start();
require_once __DIR__ . '/database_functions.php';
require_once __DIR__ . '/config.php';
/** unset data from swssion
 * @return bool
 */
function unchekAuth(): bool
{

    $token = $_COOKIE['auth'] ?? false;
    if (!$token) {
        return false;
    }

    require_once __DIR__ . '/db.php';
    unsetBdSession($bloger, $token);
    session_destroy();
    return true;
}
// unset cookie
if (unchekAuth()) {
    unset ($_COOKIE['auth']);
}
//chek if unset cookie
if (!chekAuth()) {
    header('location:' . SITE_REGISTRATION);
    exit;
}
