<?php
require_once  '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $date = new DateTime ("today");
    $username = sanitize($_POST['username']);
    $email = sanitize(filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL));
    $passwordHash = password_hash(sanitize($_POST['password']) , PASSWORD_BCRYPT);
    
    if(empty($username) || empty($email) || empty(sanitize($_POST['password']))){
        echo "Please fill in all fields";
    } else {
        try{
            // Check if user already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->execute(['username' => $username, 'email' => $email]);
            if($stmt->rowCount() > 0){
                echo "Username or email already exists";
                exit();
            }
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (username,email,password,subscription_date) VALUES (:username,:email,:password,:date)");
            $stmt->execute([
                'username' => $username,
                'email' => $email, 'password' => $passwordHash,
                'date' => $date->format('Y-m-d')
            ]);
            header('Location: login.php');
            exit();
        }catch(PDOException $e){
            echo "Internal Error";
        }
    }
}
?>