<?php
$host = 'localhost';
$dbname = 'db7gisffng4iyr';
$username = 'uczrllawgyzfy';
$password = 'tmq3v2ylpxpl';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
