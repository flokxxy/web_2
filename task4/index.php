<?php
session_start();


header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        $messages[] = 'Спасибо, результаты сохранены.'; // Если есть параметр save, то выводим сообщение пользователю.
    }
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['programming-language'] = !empty($_COOKIE['programming-language_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fio_value', '', 100000);
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('phone_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните почту.</div>';
    }
    if ($errors['birthdate']) {
        setcookie('birthdate_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('birthdate_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('gender_value', '', 100000);
        $messages[] = '<div class="error">Заполните пол.</div>';
    }
    if ($errors['programming-language']) {
        setcookie('programming-language_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('programming-language_value', '', 100000);
        $messages[] = '<div class="error">выберите язык.</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error">Заполните дополнительную информаци о себе.</div>';
    }
    if ($errors['contract']) {
        setcookie('contract_error', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('contract_value', '', 100000);
        $messages[] = '<div class="error">Согласитель на обработку персональных данных.</div>';
    }


    $values = array(); // Складываем предыдущие значения полей в массив, если есть.
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : $_COOKIE['birthdate_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['programming-language'] = empty($_COOKIE['programming-language_value']) ? array() : unserialize($_COOKIE['programming-language_value']) ;
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];

    include('form.php');
    exit();
}
else{
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
}
?>
