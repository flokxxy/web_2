<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST['patientId'];
    $doctorId = $_POST['doctorId'];
    $date = $_POST['date'];
    $paymentAmount = $_POST['paymentAmount'];

    $sql = "INSERT INTO Appointments (PatientID, DoctorID, Date, PaymentAmount) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$patientId, $doctorId, $date, $paymentAmount]);
        echo "Прием успешно зарегистрирован.";
    } catch (PDOException $e) {
        die("Ошибка при добавлении записи на прием: " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>task 5</title>
</head>
<body>
<form action="/submit_appointment" method="post">
    <label for="patientId">Выберите пациента:</label>
    <select id="patientId" name="patientId" required>
        <!-- Опции загружаются из базы данных -->
    </select>
    <label for="doctorId">Выберите врача:</label>
    <select id="doctorId" name="doctorId" required>
        <!-- Опции загружаются из базы данных -->
    </select>
    <label for="date">Дата приема:</label>
    <input type="datetime-local" id="date" name="date" required>
    <label for="paymentAmount">Сумма оплаты:</label>
    <input type="number" id="paymentAmount" name="paymentAmount" required step="0.01">
    <button type="submit">Записать на прием</button>
</form>
</body>
</html>