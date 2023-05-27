<?php
/**save data new user in database
 * @param PDO $savedUser
 * @param array $data
 * @return string|bool
 */
function registrationUser(PDO $savedUser, array $data): string|bool
{
    try {
        $query = "INSERT INTO `USERS` (`role_id` , `name`, `email`, `password`) VALUES (:role_id , :name, :email,:password)";
        $stm = $savedUser->prepare($query);
        $stm->execute($data);
        return $savedUser->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

/** save new session on database with new user
 * @param PDO $savedUser
 * @param array $data
 * @return string|bool
 */
function createSession(PDO $savedUser, array $data): string|bool
{
    try {
        $query = "INSERT INTO `user_session` (`user_id` , `token`, `user_agent`, `ip`) VALUES (:user_id , :token, :user_agent,:ip)";
        $stm = $savedUser->prepare($query);
        $stm->execute($data);
        return $savedUser->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

/** check if auth exist in session
 * @param PDO $con
 * @return int|bool
 */
function chekAuth(PDO $con): int|bool
{

    $token = $_COOKIE['auth'] ?? false;
    if (!$token) {
        return false;
    }

//    require_once  __DIR__ . '/../db.php';
    $session = getSession($con, $token);
    if (!$session) {
        return false;
    }
    return $session['user_id'];
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
        return false;
    }
    return $row;
}

/**
 * @param PDO $connection
 * @param string $email
 * @return false|mixed
 */
function getUserbyEmail(PDO $connection, string $email): mixed
{
    try {
        $query = "SELECT `id`, `email` , `password` FROM `users` WHERE `email` = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row;
    } catch (PDOException $e) {
        return false;
    }
}

/** chek if email exist in database
 * @param $savedUser
 * @param $userEmail
 * @return mixed
 */
function chekUserExist($savedUser, $userEmail): mixed
{
    $query = "SELECT COUNT(`id`) as `counter` from `users`  WHERE `email` = ?";
    $stmt = $savedUser->prepare($query);
    $stmt->execute([$userEmail]);
    return $stmt->fetch()['counter'];
}

/** chek  if password exist in database
 * @param PDO $savedUser
 * @param string $userEmail
 * @return string|null
 */
function chekUserPass(PDO $savedUser, string $userEmail): string|null
{
    $query = "SELECT `password` FROM `users` WHERE `email` = ?";
    $stmt = $savedUser->prepare($query);
    $stmt->execute([$userEmail]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC)['password'];
    return $row;
}

/** unset data from session
 * @param PDO $savedSession
 * @param string $savedToken
 * @return void
 */
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

/** unset data from cookie
 * @param $con
 * @return bool
 */
function unchekAuth($con): bool
{

    $token = $_COOKIE['auth'] ?? false;
    if (!$token) {
        return false;
    }

    require_once __DIR__ . '/../db.php';
    unsetBdSession($con, $token);
    session_destroy();
    return true;
}

/** create token for new user and set it into cookie
 * @param PDO $connect
 * @param $userId
 * @return void
 */
function login(PDO $connect, $userId): void
{
    $token = generatrToken($userId['email']);
    $sessionData = [
        'user_id' => $userId['id'],
        'token' => $token,
        'user_agent' => getUserAgent(),
        'ip' => getUserIp()
    ];
    $sessionId = createSession($connect, $sessionData);
    if (!$sessionId) {
        setAlerts('Data base Error!', 'warnings');
        header('location:' . SITE_LOGIN);
    }

    setcookie('auth', $token, time() + (3600 * 24 * 7), '/');
}

/** get users from data base
 * @param PDO $connection
 * @return array|false
 */
function getAllUser(PDO $connection): array|false
{
    try {
        $query = "SELECT `id`, `name` FROM `users`";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    } catch (PDOException $e) {
        return false;
    }
}

/** add blogs into data base
 * @param PDO $connect
 * @param $data
 * @return false|string
 */
function blog_add(PDO $connect, $data): false|string
{
    try {
        $query = "INSERT INTO `blogs` (`author_id`, `tittle`, `image`, `content`) VALUES (:author_id, :tittle,:image,:content)";
        $stm = $connect->prepare($query);
        $stm->execute($data);
        return $connect->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

/** move file to directory /storage/blogs
 * @param $file
 * @param $to
 * @return bool
 */
function fileMoveTo($file, $to): bool
{
    if (!file_exists($to)) {
        mkdir($to);
    }
    if ($file['error']) {
        return false;
    }
    $filename = $file['name'];
    $tmp_name = $file['tmp_name'];

    return move_uploaded_file($tmp_name, "$to/$filename");
}

/** get blogs from data base
 * @param PDO $connection
 * @param mixed $perPage
 * @param mixed $offset
 * @return array|false
 */
function getAllBlogs(PDO $connection, mixed $perPage = false, mixed $offset = false): array|false
{
    try {
        $query = "SELECT * FROM `blogs`";
        if ($perPage !== false && $offset !== false) {
            $query .= "LIMIT $offset, $perPage";
        }
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    } catch (PDOException $e) {
        return false;
    }
}

/** count numbers of Blogs
 * @param PDO $connection
 * @return int|false
 */
function countBlogs(PDO $connection): int|false
{
    {
        try {
            $query = " SELECT count(`id`) as 'counter' FROM `blogs`";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $row = $stmt->fetchColumn();
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }
}

/** save user actions to file: loger.txt
 * @param PDO $database
 * @param string $message
 * @param string $fileName
 * @return void
 */
function logger(PDO $database, string $message, string $fileName = 'loger.txt'): void
{
    $currentData = date('d.m.Y / H:i:s');
    $usernomber = chekAuth($database);
    $message = "[$currentData][ user #$usernomber ][ $message ]" . PHP_EOL;

    $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $fileName, 'a');
    fwrite($file, $message);
    fclose($file);

}
