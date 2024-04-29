<?php

include('../../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не могу подключиться к базе данных: " . $e->getMessage());
}
?>
