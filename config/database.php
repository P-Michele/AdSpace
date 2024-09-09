<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

try {
  $conn = new PDO("mysql:host=" . DB_SERVER. "; dbname=adspacedb", DB_USERNAME, DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed";
}

function sanitize($data) {
  return htmlspecialchars(trim($data));
}

?>