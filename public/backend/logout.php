<?php
session_start();

require_once "auth.php";
require_once "../../config/database.php";

if(isLoggedIn($conn)){ 
    session_unset();
    session_destroy();
    header("Location: ../frontend/login.html");
    exit();
}
header("Location: index.php");
?>