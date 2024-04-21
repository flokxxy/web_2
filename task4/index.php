<?php
session_start();
include('../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;


if(!isset($_SESSION['ERROR'])){
    $_SESSION['ERROR'] = array();
}

$fio = $phone = $email = $birthdate = $gender = '';
$langs = [];



$fio = isset($_POST['fio'])?trim($_POST['fio']):'';
$phone = isset($_POST['phone'])?trim($_POST['phone']):'';
$email = isset($_POST['email'])?trim($_POST['email']):'';
$birthdate = isset($_POST['birthdate'])?trim($_POST['birthdate']):'';
$gender = isset($_POST['gender'])?trim($_POST['gender']):'';
$bio = isset($_POST['bio'])?trim($_POST['bio']):'';
$langs = isset($_POST['programming-language']) ? (array)$_POST['programming-language'] : [];
$langs_check = ['c', 'c++', 'js', 'java', 'clojure', 'pascal', 'python', 'haskel', 'scala', 'php', 'prolog'];


function checkLangs($langs, $langs_check) {
    for ($i = 0; $i < count($langs); $i++) {
        $isTrue = FALSE;
        for ($j = 0; $j < count($langs_check); $j++) {
            if ($langs[$i] === $langs_check[$j]) {
                $isTrue = TRUE;
                break;
            }
        }
        if ($isTrue === FALSE) return FALSE;
    }
    return TRUE;
}

//валидация данных
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'This script only works with POST queries';
    exit();
}

$errors = FALSE;

if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
    $errors = TRUE;
    print (" mistake in fio ");
}

if (empty($phone) || !preg_match('/^[0-9+]+$/', $phone)) {
    $errors = TRUE;
    print (" mistake in phone ");
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors = TRUE;
    print (" mistake in mail ");
}


$dateObject = DateTime::createFromFormat('Y-m-d', $birthdate);
if ($dateObject === false || $dateObject->format('Y-m-d') !== $birthdate) {
    $errors = TRUE;
    print (" mistake in date ");
    //добавить проверку на 0
}

if ($gender != 'male' && $gender != 'female') {
    $errors = TRUE;
    print (" mistake in male ");
}

/*
if (!checkLangs($langs, $langs_check)) {
    $errors = TRUE;
    print (" mistake in check ");
}*/

if(empty($_POST['contract'])){
    $errors = TRUE;
    print (" mistake in check ");
}

if ($errors === TRUE) {
    echo 'mistake';
    exit();
}


if(!empty($_COOKIE['fio'])){
    $fio=$_COOKIE['fio'];
    $phone=$_COOKIE['phone'];
    $email=$_COOKIE['email'];
}

if(!empty($_SESSION['error'] )){
    foreach ($_SESSION['error'] as $error) {
        echo "<p>".$error."</p>";
    }
    $_SESSION['error'] = array();
}
try {
    $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully ";
    $sql = "INSERT INTO request (fio, phone, email, birthdate, gender, bio)
VALUES ('$fio', '$phone', '$email', '$birthdate', '$gender', '$bio')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $lastId = $conn->lastInsertId();

    for ($i = 0; $i < count($langs); $i++) {
        $sql = "SELECT id_lang FROM Program_language WHERE name_lang = :langName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':langName', $langs[$i]);
        $stmt->execute();
        $result = $stmt->fetch();
        $lang_id = $result['id_lang'];
        $sql = "INSERT INTO feedback (id, id_lang) VALUES ($lastId, $lang_id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    echo nl2br("\nNew record created successfully");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>
