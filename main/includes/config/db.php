<?php
$dsn = 'mysql:dbname=hrp_interaktiv;host=localhost;charset=utf8';
$username = 'hrp-interaktiv.h';
$password = base64_decode("WDdhV0k0TVQ");

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch (PDOException $e) {
    echo $e->getMessage(); // Remove in production code
    die("Error establishing a database connection.");
}
