<?php
session_start(['session.name' => 'SECURITY']);

function logIn() {
    global $statusCode, $res;

    if (isAuthorized()) {
        $statusCode = 400;
        $res['err'] = 'You are authorized already';
    } else {
        $username = $_POST['username']  ?? null;
        $password = $_POST['password'] ?? '';  // ensured while registration

        if ($username && $password) {
            $user = getUserByUsername($username);
            if ($user && $user['password_hash'] === password_hash($password, PASSWORD_DEFAULT)) {
                authorize($username);
            }
        } else {
            $res['err'] = 'Some fields are not provided';
            $statusCode = 400;
        }
    }
}

function register() {
    global $statusCode, $res;
    
    if (isAuthorized()) {
        $statusCode = 400;
        $res['err'] = 'You are authorized already';
    } else {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $repeatPassword = $_POST['repeatPassword'] ?? null;

        if ($username && $password && $repeatPassword) {  // ensure not empty password
            if ($password === $repeatPassword) {
                if (getUserByUsername($username)) {
                    $statusCode = 400;
                    $res['err'] = "The user with username '$username' exists already";
                    $res['username'] = $username;
                } else {
                    // THE CORE
                    insert_user($username, password_hash($password, PASSWORD_DEFAULT));
                    authorize($username);
                    $statusCode = 201;
                    $res['username'] = $username;
                }
            } else {
                $statusCode = 400;
                $res['err'] = 'Passwords differ';
            }
        } else {
            $statusCode = 400;
            $res['err'] = 'Some fields are not provided';
        }
    }   
}

function logOut() {
    global $statusCode;

    $_SESSION = [];
    unset($_COOKIE[session_name()]);
    session_destroy();
    $statusCode = 204;
}

/**
 * Finish the script
 */
function response(int $statusCode, array $res) {
    http_response_code($statusCode);
    header('Content-type: application/json');
    echo json_encode($res);
    exit();
}

// User providers (database)
function insert_user(string $username, string $passwordHash) {
    $dir = dirname(__FILE__);
    $dsn = "sqlite:$dir"."/users.db";
    $pdo = new \PDO($dsn, null, null);
    $stmt = $pdo->prepare('INSERT INTO "user" ("username", "password_hash") VALUES (?, ?)');
    $stmt->execute([$username, $passwordHash]);
}
function getUserByUsername(string $username): array {
    $dir = dirname(__FILE__);
    $dsn = "sqlite:$dir"."/users.db";
    $pdo = new \PDO($dsn, null, null);
    $stmt = $pdo->prepare('SELECT * FROM "user" WHERE "username"=?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    if (false === $user) {
        $user = [];
    }
    return $user;
}

/**
 * Check if user is authorized already
 */
function isAuthorized($sessionToken = 'token'): bool {
    return array_key_exists($sessionToken, $_SESSION);
}

/**
 * Set the session token
 */
function authorize($username, $sessionToken = 'token') {
    $_SESSION[$sessionToken] = password_hash($username, PASSWORD_DEFAULT);
}

// router
$uri = $_SERVER['REQUEST_URI'];
$uri = '/' === substr($uri, -1) ? substr($uri, 0, -1) : $uri;

$statusCode = 200;
$res = [];

switch ($uri) {
    case '/login':
        logIn();
        break;
    case '/register':
        register();
        break;
    case '/logout':
        logOut();    
        break;
    default:
        $statusCode = 404;
        $res['err'] = 'No such resource';
        break;
}

response($statusCode, $res);
