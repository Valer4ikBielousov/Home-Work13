<?php

/**
 * Just for debug arrays
 * @param array $array
 * @return void
 */
function debug(array $array): void
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    exit;
}

/**
 *set my message into SESSIONS
 * @param string $messege
 * @param string|array $type
 */
function setAlerts(string $messege, string|array $type = 'alerts'): void
{
    $_SESSION[$type][] = $messege;

}

/**
 *Get my message from session
 * @param string|array $type
 * @return array
 */
function getMesseges(string $type): array
{
    $messeges = $_SESSION[$type] ?? [];

    return $messeges;
}

/**
 *check if session for $type exist
 * @param string|array $type
 * @return bool
 */
function existMesseges(string $type): bool
{
    return isset($_SESSION[$type]);
}

/**
 * unset old messeges from screen
 * @param string $type
 * @return void
 */
function unsetMesseges(string $type):void
{
    unset ($_SESSION[$type]);
}

/**
 * check if user was regestrated
 * @param $key
 * @return array|bool
 */
function chekAuth($key):array|bool
{
    return $_COOKIE[$key] ?? false;
}


/** Set value of Field Name into session
 * @param array $F
 * @param string $type_F
 * @return void
 */
function setF(array $F, string $type_F): void
{
    $_SESSION[$type_F] = $F;
}

/** Get value of Field Name into session
 * @param string $type_F
 * @param string $key
 * @return string
 */
function getF(string $type_F,string $key) :string
{
    return $_SESSION[$type_F][$key] ?? '';
}
