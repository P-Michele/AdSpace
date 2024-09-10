<?php

require_once  '../../config/database.php';

function isLoggedIn($conn) {
    //Check user's session
    if (isset($_SESSION['user_id']) && $_SESSION['isLoggedIn'] === true) {
        return true;
    }
    
    //Check user's cookie
    if (isset($_COOKIE['auth'])) {
        $stmt = $conn->prepare('SELECT * FROM users WHERE token = :token AND expires_at > NOW()');
        $stmt->execute(['token' => $_COOKIE['auth'],]);
        $user = $stmt->fetch();

        if ($user) {
            createSession($user);
            return true;
        }
    }
    return false;
}


function createSession($user){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['isLoggedIn'] = true;
}

function createCookie($conn){
    //Random token
    $token = bin2hex(random_bytes(32));
    $expires_at = time() + (86400 * 30);
    $stmt = $conn->prepare('UPDATE users SET token = :token , expires_at = :expires_at WHERE id = :id');
    $stmt->execute([
        'token'=>$token, 
        'expires_at'=>$expires_at,
        'id'=> $_SESSION['user_id']
    ]);
    setcookie('auth', $token, [
        'expires' => $expires_at,
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        //'samesite' => 'Strict'
    ]);        
}

function destroyCookie($conn){
    $stmt = $conn->prepare('UPDATE users SET token = :token , expires_at = :expires_at WHERE id = :id');
    $stmt->execute([
        'token'=>null, 
        'expires_at'=>null,
        'id'=> $_SESSION['user_id']
    ]);
    unset($_COOKIE['auth']);
    setcookie('auth', '', time() - 3600, '/');
}

?>