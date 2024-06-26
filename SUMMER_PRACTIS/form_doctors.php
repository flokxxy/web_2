<?php
header('Content-Type: text/html; charset=UTF-8');

header('Cache-Control: no-cache, must-revalidate');

session_start(); // Начало сессии для хранения данных формы и сообщений об ошибках

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $message = array();

    if (!empty($_COOKIE['save'])) {
        setcookie("save", '', time() - 3600);
        $message[] = 'Данные слхрани';
    }

    $errors = array();
    $errors['fullName'] = !empty($_COOKIE['fullName_errors']);
    $errors['specialty'] = !empty($_COOKIE['specialty_errors']);
    $errors['fee'] = !empty($_COOKIE['fee_errors']);
    $errors['commission'] = !empty($_COOKIE['commission_errors']);

    if ($errors['fullName']) {
        setcookie("fullName_errors", '', time() - 3600);
        setcookie("fullName_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните фамилию врача.</div>';
    }
    if ($errors['specialty']) {
        setcookie("specialty_errors", '', time() - 3600);
        setcookie("specialty_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните специальность врача.</div>';
    }
    if ($errors['fee']) {
        setcookie("fee_errors", '', time() - 3600);
        setcookie("fee_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните стоимость приема.</div>';
    }
    if ($errors['commission']) {
        setcookie("commission_errors", '', time() - 3600);
        setcookie("commission_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните процент отчислений.</div>';
    }

    $values = array();
    $values['fullName'] = empty($_COOKIE['fullName_value']) ? '' : $_COOKIE['fullName_value'];
    $values['specialty'] = empty($_COOKIE['specialty_value']) ? '' : $_COOKIE['specialty_value'];
    $values['fee'] = empty($_COOKIE['fee_value']) ? '' : $_COOKIE['fee_value'];
    $values['commission'] = empty($_COOKIE['commission_value']) ? '' : $_COOKIE['commission_value'];

    include('doctors.php');
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
/*
    $fullName = $_POST['fullName'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $fee = $_POST['fee'] ?? '';
    $commission = $_POST['commission'] ?? '';

    $_SESSION['form_input'] = $_POST;
   */
    $errors = FALSE;
    if (empty(trim($_POST['fullName'])) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fullName'])) {
        $errors = TRUE;
        setcookie("fullName_errors", '1', time() + 3600);
        print('ФИО врача обязательно к заполнению.'."\n");
    }else setcookie('fullName_value', $_POST['fullName'], time() + (86400 * 30));
    if(empty($_POST['specialty']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $_POST['specialty'])){
        $errors = TRUE;
        setcookie("specialty_errors", '1', time() + 3600);
        print('Специальность врача обязательна к заполнению.'."\n");
    }else setcookie('specialty_value', $_POST['specialty'], time() + (86400 * 30));
    if(empty($_POST['fee']) || !preg_match('/^[0-9]+$/u', $_POST['fee'])){
        $errors = TRUE;
        setcookie("fee_errors", '1', time() + 3600);
        print('Укажите корректную стоимость приема.'."\n");
    }else setcookie('fee_value', $_POST['fee'], time() + (86400 * 30));
    if(empty($_POST['commission']) || !preg_match('/^[0-9]+$/u', $_POST['commission'])){
        $errors = TRUE;
        setcookie("commission_errors", '1', time() + 3600);
        print('Укажите корректный процент отчисления.'."\n");
    }else setcookie('commission_value', $_POST['commission'], time() + (86400 * 30));

    if ($errors) {
        print('что-то не так');
        header("Location: form_doctors.php"); // Перенаправление обратно на форму
        exit;
    }
    else {
        setcookie('fullName_errors', '', time() - 3600);
        setcookie('specialty_errors', '', time() - 3600);
        setcookie('fee_errors', '', time() - 3600);
        setcookie('commission_errors', '', time() - 3600);
    }

    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Doctors (FullName, Specialty, ConsultationFee, Commission) VALUES (:fullName, :specialty, :fee, :commission)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':fullName', $_POST['fullName']);
        $stmt->bindParam(':specialty', $_POST['specialty']);
        $stmt->bindParam(':fee', $_POST['fee']);
        $stmt->bindParam(':commission', $_POST['commission']);

        $stmt->execute();
        echo "Врач успешно добавлен.";
        $lastId = $pdo->lastInsertId();
        echo "ID нового врача: $lastId";
        
    } catch (PDOException $e) {
        $errors['database'] = "Ошибка при добавлении врача: " . $e->getMessage();
    }
    setcookie('save', '1');

    header("Location: form_doctors.php"); // Перенаправление обратно на форму
    exit;

}

?>
