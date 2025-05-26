<?php
$host = 'sql303.infinityfree.com';
$dbname = 'if0_39085759_scoreapp';
$username = 'if0_39085759'; 
$password = 'V2DsRXdxC5v';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>