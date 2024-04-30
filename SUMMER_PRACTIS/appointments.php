<?php
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