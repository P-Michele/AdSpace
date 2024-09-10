<?php
    session_start();

    require_once  '../../config/database.php';
    require_once  'auth.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(empty($_POST['email']) || empty($_POST['password'])){
            echo 'Please fill in all fields';
            die();
        }
        //Check if user exists
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email'=>$_POST['email']]);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            //Create user's session
            createSession($user);
            createCookie($conn);
            header('Location: index.php'); 
            exit();
        } else {
            session_destroy();
            echo 'Invalid Credentials';
        }
    }

    isLoggedIn($conn) ? header('Location: ../backend/index.php') : header('Location: ../frontend/login.html');
    exit();
?>