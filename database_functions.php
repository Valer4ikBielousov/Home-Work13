<?php
function registrationUser (PDO $savedUser, array $data)
{
    try {
        $query = "INSERT INTO `USERS` (`role_id` , `name`, `email`, `password`) VALUES (:role_id , :name, :email,:password)";
        $stm = $savedUser->prepare($query);
        $stm->execute($data);
        return $savedUser->lastInsertId();
    } catch (PDOException $e){
        return false;
    }
}

function createSession (PDO $savedUser, array $data)
{
    try {
        $query = "INSERT INTO `user_session` (`user_id` , `token`, `user_agent`, `ip`) VALUES (:user_id , :token, :user_agent,:ip)";
        $stm = $savedUser->prepare($query);
        $stm->execute($data);
        return $savedUser->lastInsertId();
    } catch (PDOException $e){
        return false;
    }
}

/** check if auth exist in session
 * @return bool
 */
function chekAuth(): bool
{

    $token = $_COOKIE['auth'] ?? false;
    if (!$token) {
        return false;
    }

    require_once __DIR__ . './db.php';
    $session = getSession($bloger, $token);
    if (!$session) {
        return false;
    }
    return true;
}

/** get Session data from data base
 * @param PDO $savedSession
 * @param string $savedToken
 * @return false|void
 */
function getSession(PDO $savedSession, string $savedToken)
{
    try {
        $query = "SELECT * FROM `user_session` WHERE `token` = ?";
        $stmt = $savedSession->prepare($query);
        $stmt->execute([$savedToken]);
        $row = $stmt->fetch();
    } catch (PDOException $e) {
        return true;
    }
    return $row;
}

function chekUserExist ($savedUser, $userEmail)
{
    $query = "SELECT COUNT(`id`) as `counter` from `users`  WHERE `email` = ?";
    $stmt = $savedUser->prepare($query);
    $stmt->execute([$userEmail]);
    return $stmt->fetch()['counter'];
}

function chekUserPass(PDO $savedUser, string $userEmail): ?string
{
    $query = "SELECT `password` FROM `users` WHERE `email` = ?";
    $stmt = $savedUser->prepare($query);
    $stmt->execute([$userEmail]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC)['password'];;
    return $row;
}
function unsetBdSession(PDO $savedSession, string $savedToken)
{
    try {
        $query = "DELETE FROM `user_session` WHERE `token` = ?";
        $stmt = $savedSession->prepare($query);
        $stmt->execute([$savedToken]);

    } catch (PDOException $e) {
        return true;
    }

}
