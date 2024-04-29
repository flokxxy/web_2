<?php

//include ('config.php'); // подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $specialty = $_POST['specialty'];
    $fee = $_POST['fee'];
    $commission = $_POST['commission'];

    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Не могу подключиться к базе данных: " . $e->getMessage());
    }

    // Используйте плейсхолдеры в запросе для безопасности
    $sql = "INSERT INTO Doctors (FullName, Specialty, ConsultationFee, Commission) VALUES (:fullName, :specialty, :fee, :commission)";
    $stmt = $pdo->prepare($sql);

    // Привязка значений к плейсхолдерам
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':specialty', $specialty);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':commission', $commission);

    try {
        $stmt->execute();
        echo "Врач успешно добавлен.";
        $lastId = $pdo->lastInsertId();
        echo "ID нового врача: $lastId";
    } catch (PDOException $e) {
        die("Ошибка при добавлении врача: " . $e->getMessage());
    }
} else {
    header("Location: form_doctors.html");
    exit;
}
?>
