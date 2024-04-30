<?php
header('Content-Type: text/html; charset=UTF-8');
session_start(); // Начало сессии для хранения данных формы и сообщений об ошибках


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$fullName = $_POST['fullName'] ?? '';
    $fullName = $_POST['fullName'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $fee = $_POST['fee'] ?? '';
    $commission = $_POST['commission'] ?? '';


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

        include('form_doctors.php');
        exit();
    } else {

        $fullName = $_POST['fullName'] ?? '';
        $specialty = $_POST['specialty'] ?? '';
        $fee = $_POST['fee'] ?? '';
        $commission = $_POST['commission'] ?? '';

        $_SESSION['form_input'] = $_POST;

        // Валидация входных данных
        /*
        $errors = [];
        if (empty($fullName) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fullName'])) {
            $errors = true;
            setcookie('fullName', '1', time() + (86400 * 30));
            $errors['fullName'] = 'ФИО врача обязательно к заполнению.';
            print("ошибка в фамилии врача");
        } else setcookie('fullName_value', $_POST['fullName'], time() + (86400 * 30));
        if (empty($specialty) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $_POST['specialty'])) {
            $errors['specialty'] = 'Специальность врача обязательна к заполнению.';
        }
        if (!is_numeric($fee) || $fee <= 0) {
            $errors['fee'] = 'Укажите корректную стоимость приема.';
        }
        if (!is_numeric($commission) || $commission < 0) {
            $errors['commission'] = 'Укажите корректный процент отчисления.';
        }*/

        $errors = FALSE;
        if (empty(trim($_POST['fullName'])) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fullName'])) {
            $errors = TRUE;
            print('ФИО врача обязательно к заполнению.');
        }
        if(empty($_POST['specialty']||!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $_POST['specialty']))){
            $errors = TRUE;
            print('Специальность врача обязательна к заполнению.\n');
        }
        if(empty($_POST['fee']||!preg_match('/^[0-9]+$/u', $_POST['fee']))){
            $errors = TRUE;
            print('Укажите корректную стоимость приема.');
        }
        if(empty($_POST['commission']||!preg_match('/^[0-9]+$/u', $_POST['commission']))){
            $errors = TRUE;
            print('Укажите корректный процент отчисления.');
        }

        if ($errors === true) {
            echo 'mistake';
            exit();
        } else {
            setcookie('fullName', '', time() - 3600);
            setcookie('specialty', '', time() - 3600);
            setcookie('fee', '', time() - 3600);
            setcookie('commission', '', time() - 3600);
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

            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':specialty', $specialty);
            $stmt->bindParam(':fee', $fee);
            $stmt->bindParam(':commission', $commission);

            $stmt->execute();
            echo "Врач успешно добавлен.";
            $lastId = $pdo->lastInsertId();
            echo "ID нового врача: $lastId";

            // Очистка данных формы в сессии после успешного добавления
            unset($_SESSION['form_input']);
        } catch (PDOException $e) {
            $errors['database'] = "Ошибка при добавлении врача: " . $e->getMessage();
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;

            header("Location: form_doctors.html"); // Перенаправление обратно на форму
            exit;
        }

    }
}
/*
    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    // Сохранение введенных значений в сессии
    $_SESSION['form_input'] = $_POST;

    // Валидация входных данных
    $errors = false;
    if (empty($fullName)||!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fullName'])) {
        setcookie('fullName', '1', time() + (86400 * 30));
        $errors['fullName'] = 'ФИО врача обязательно к заполнению.';
    }
    if (empty($specialty)) {
        $errors['specialty'] = 'Специальность врача обязательна к заполнению.';
    }
    if (!is_numeric($fee) || $fee <= 0) {
        $errors['fee'] = 'Укажите корректную стоимость приема.';
    }
    if (!is_numeric($commission) || $commission < 0) {
        $errors['commission'] = 'Укажите корректный процент отчисления.';
    }

    if (count($errors) === 0) {
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO Doctors (FullName, Specialty, ConsultationFee, Commission) VALUES (:fullName, :specialty, :fee, :commission)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':specialty', $specialty);
            $stmt->bindParam(':fee', $fee);
            $stmt->bindParam(':commission', $commission);

            $stmt->execute();
            echo "Врач успешно добавлен.";
            $lastId = $pdo->lastInsertId();
            echo "ID нового врача: $lastId";

            // Очистка данных формы в сессии после успешного добавления
            unset($_SESSION['form_input']);
        } catch (PDOException $e) {
            $errors['database'] = "Ошибка при добавлении врача: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;

        header("Location: form_doctors.html"); // Перенаправление обратно на форму
        exit;
    }
} else {
    header("Location: form_doctors.html");
    exit;
}*/

?>
