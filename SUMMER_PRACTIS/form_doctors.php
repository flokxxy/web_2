<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $specialty = $_POST['specialty'];
    $fee = $_POST['fee'];
    $commission = $_POST['commission'];

    $sql = "INSERT INTO Doctors (FullName, Specialty, ConsultationFee, Commission) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$fullName, $specialty, $fee, $commission]);
        echo "Врач успешно добавлен.";
    } catch (PDOException $e) {
        die("Ошибка при добавлении врача: " . $e->getMessage());
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
<form action="/submit_doctor" method="post">
    <label for="fullName">ФИО врача:</label>
    <input type="text" id="fullName" name="fullName" required>
    <label for="specialty">Специальность:</label>
    <input type="text" id="specialty" name="specialty" required>
    <label for="fee">Стоимость приема:</label>
    <input type="number" id="fee" name="fee" required step="0.01">
    <label for="commission">Процент отчисления:</label>
    <input type="number" id="commission" name="commission" required step="0.01">
    <button type="submit">Добавить врача</button>
</form>
</body>
</html>