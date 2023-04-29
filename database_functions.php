<?php
function registrationUser (PDO $savedUser, array $data)
{
    $query = "INSERT INTO `USERS` (`name`, `email`, `password`) VALUES (:name, :email,:password)";
    $stm =$savedUser->prepare($query);
    $stm->execute($data);
}
