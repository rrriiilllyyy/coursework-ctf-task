<?php
define('DB_HOST', 'mysql');
define('DB_USER', 'ctf_user');
define('DB_PASSWORD', 'ctf_password');
define('DB_NAME', 'ctf_db');

function getDB() {
    try {
        $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
