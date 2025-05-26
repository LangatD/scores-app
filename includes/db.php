<?php
$host = 'localhost';
$dbname = 'scoreapp';
$username = 'root'; // Default XAMPP MySQL user (change if needed)
$password = '';     // Default XAMPP MySQL password (change if needed)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>