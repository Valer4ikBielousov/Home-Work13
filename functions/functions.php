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
 * @return array|string
 */
function getMesseges(string $type): array|string
{
    $messeges = $_SESSION[$type] ?? [];

    return $messeges;
}

/**
 *check if session for $type exist
 * @param string $type
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
function unsetMesseges(string $type): void
{
    unset ($_SESSION[$type]);
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
function getF(string $type_F, string $key): string
{
    return $_SESSION[$type_F][$key] ?? '';
}

function generatrToken($id): string
{
    $time = time();
    $randId = rand(1000, 9999);
    return hash('md5', $id . $randId . $time);
}

/** Get user ip
 * @return string
 */
function getUserIp(): string
{
    return $_SERVER['REMOTE_ADDR'];
}

/**get user system type
 * @return string
 */
function getUserAgent(): string
{
    return $_SERVER['HTTP_USER_AGENT'];
}

/**filter for POST email field
 * @param string $name
 * @param $type
 * @return string
 */
function post(string $name, $type = 'default'): string
{
    $value = filter_input(INPUT_POST, $name, FILTER_SANITIZE_ADD_SLASHES);
    $value = htmlspecialchars($value);
    switch ($type) {
        case 'email':
            $value = filter_var($value, FILTER_SANITIZE_EMAIL);
            break;
    }
    return $value;
}


/**filter for POST array
 * @param array $filters
 * @return array
 */
function filterPostArray(array $filters): array
{
    $filteredData = [];

    foreach ($filters as $key => $filter) {

        $value = filter_input(INPUT_POST, $key, $filter);
        if ($value !== null) {
            $filteredData[$key] = $value;
        }
    }

    return $filteredData;
}
function refilter($data)
{
    return htmlspecialchars_decode($data);
}
