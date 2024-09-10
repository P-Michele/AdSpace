<?php
session_start();

require_once  '../../config/database.php';
require_once  'auth.php';

// Verifica se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header('Location: ../backend/login.php'); //Login redirect
    session_destroy();
    exit();
}
header('Location: ../frontend/index.html'); //Home redirect
?>
