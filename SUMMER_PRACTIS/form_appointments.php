<?php
include('../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;
// Подключение к базе данных
$db = mysqli_connect('localhost', 'username', 'password', 'database_name');

// SQL-запрос для получения всех докторов из первой таблицы
$query = 'SELECT * FROM doctors';
$result = mysqli_query($db, $query);

// Вывод докторов в виде выпадающего списка
echo '<form action="patients.php" method="post">';
echo '<select name="doctor_id">';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}
echo '</select>';

// Поля для ввода данных о приеме
echo '<input type="date" name="date">';
echo '<input type="time" name="time">';
echo '<input type="text" name="room">';
echo '<input type="submit" value="Add Appointment">';
echo '</form>';

// Обработка данных формы и добавление их во вторую таблицу
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $room = $_POST['room'];

    $query = "INSERT INTO appointments (doctor_id, date, time, room) VALUES ($doctor_id, '$date', '$time', '$room')";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo 'Appointment added successfully.';
    } else {
        echo 'Error adding appointment: ' . mysqli_error($db);
    }
}

// Закрытие соединения с базой данных
mysqli_close($db);
?>


<?php
/*
include('../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



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
*/
?>



<?php
/*
// Подключение к базе данных
include('../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;
$connection = new mysqli($servername, $username, $password, $dbname);

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorId = $_POST['doctorId'];

    // Выбор данных из первой таблицы
    $sql_select = "SELECT * FROM Doctors WHERE DoctorID = $doctorId";
    $result = $connection->query($sql_select);

    // Вставка данных во вторую таблицу
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $field1 = $row['field1'];
            $field2 = $row['field2'];
            // Продолжайте для других полей

            // Вставка данных во вторую таблицу
            $sql_insert = "INSERT INTO second_table (field1, field2) VALUES ('$field1', '$field2')";
            if ($connection->query($sql_insert) !== TRUE) {
                echo "Ошибка при записи информации: " . $connection->error;
            }
        }
        echo "Информация успешно записана во вторую таблицу базы данных";
    } else {
        echo "Нет данных для выбранного доктора";
    }
}

// Закрытие соединения с базой данных
$connection->close();
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
*/
