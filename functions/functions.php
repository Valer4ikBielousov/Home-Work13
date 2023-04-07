<?php
function debug(array $array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function setAlerts(string $messeges, string $type = 'alerts')
{
    $_SESSION[$type][] = $messeges;
}

function getMesseges($type)
{
    $messeges = $_SESSION[$type] ?? [];
    unset ($_SESSION[$type]);
    return  $messeges;
}

function existMesseges (string $type): bool
{
    return isset($_SESSION[$type]);
}