<?php

//include ('config.php'); // подключение к базе данных

session_start(); // Начало сессии для хранения данных формы и сообщений об ошибках

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $fee = $_POST['fee'] ?? '';
    $commission = $_POST['commission'] ?? '';

    include('../impotent.php');
    $servername = "localhost";
    $username = username; // Убедитесь, что username определен в impotent.php
    $password = password;
    $dbname = username;

    // Сохранение введенных значений в сессии
    $_SESSION['form_input'] = $_POST;

    // Валидация входных данных
    $errors = [];
    if (empty($fullName)) {
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
}

?>
