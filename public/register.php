
<?php
require '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $date = new DateTime ("today");
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
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
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash, 'date' => $date->format('Y-m-d')]);
            header('Location: login.php');
            exit();
        }catch(PDOException $e){
            echo "Internal Error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row justify-content-center"> 
            <div class="col img-container">
                <img alt="alternative" src="images/AdSpace.png">
            </div>
            <div class="col-6">
                <h1>Register here</h1>
                <form action="register.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit">Register</button>
                </form>
                <p>Already have an account?<a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
