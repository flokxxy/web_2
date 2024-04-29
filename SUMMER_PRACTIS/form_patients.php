<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $birthDate = $_POST['birthDate'];
    $address = $_POST['address'];

    $sql = "INSERT INTO Patients (LastName, FirstName, MiddleName, BirthDate, Address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$lastName, $firstName, $middleName, $birthDate, $address]);
        echo "Пациент успешно добавлен.";
    } catch (PDOException $e) {
        die("Ошибка при добавлении пациента: " . $e->getMessage());
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
<form action="/submit_patient" method="post">
    <label for="lastName">Фамилия:</label>
    <input type="text" id="lastName" name="lastName" required>
    <label for="firstName">Имя:</label>
    <input type="text" id="firstName" name="firstName" required>
    <label for="middleName">Отчество:</label>
    <input type="text" id="middleName" name="middleName">
    <label for="birthDate">Дата рождения:</label>
    <input type="date" id="birthDate" name="birthDate" required>
    <label for="address">Адрес:</label>
    <input type="text" id="address" name="address" required>
    <button type="submit">Добавить пациента</button>
</form>
</body>
</html>