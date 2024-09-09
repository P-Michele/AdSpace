<?php
    require '../config/database.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(empty($_POST['email']) || empty($_POST['password'])){
            echo 'Please fill in all fields';
            die();
        }
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email'=>$_POST['email']]);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php'); 
            exit();
        } else {
            echo 'Invalid Credentials';
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
            <div class="col-6" style="padding-top: 25px;">
                <h1>Login here</h1>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account?<a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    document.querySelector('#form').addEventListener('submit', function(e){
        e.preventDefault();
        if(document.querySelector('#email').value === '' || document.querySelector('#password').value === ''){
            alert('Please fill in all fields');
        }else{
            this.submit();
        }
    });
</script>