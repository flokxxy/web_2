
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>добавление пациента</title>
</head>
<style>
    .error {
        border: 2px solid red;
    }
</style>
<body>

<?php
/*
print($errors['lastName'] . '<br>');
print($errors['firstName'] . '<br>');
print($errors['middleName'] .'<br>');
print($errors['birthDate'] . '<br>');
print($errors['address'] . '<br>');
*/
?>

<form action="form_appointments.php" method="post">
    <label for="lastName">Фамилия:</label>
    <input type="text" id="lastName" name="lastName" <?php if (($errors['lastName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['lastName'])) {print $values['lastName'];} ?>" />
    <label for="firstName">Имя:</label>
    <input type="text" id="firstName" name="firstName" <?php if (($errors['firstName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['firstName'])) {print $values['firstName'];} ?>" />
    <label for="middleName">Отчество:</label>
    <input type="text" id="middleName" name="middleName" <?php if (($errors['middleName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['middleName'])) {print $values['middleName'];} ?>" />
    <label for="birthDate">Дата рождения:</label>
    <input type="date" id="birthDate" name="birthDate" <?php if (($errors['birthDate'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['birthDate'])) {print $values['birthDate'];} ?>" />
    <label for="address">Адрес:</label>
    <input type="text" id="address" name="address" <?php if (($errors['address'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['address'])) {print $values['address'];} ?>" />

<br>
       <!-- Опции загружаются из базы данных -->
    <!--
    <label for="doctorId" >Выберите врача:</label>
    -->
    <?php
    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Specialty, FullName FROM Doctors";
    $result = $conn->query($sql);

    echo "<select name='select_name'>";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["DoctorID"];
            $specialty = $row["Specialty"];
            $fullName = $row["FullName"];
            echo "<option value='$id'>$fullName ($specialty)</option>";
        }
    } else {
        echo "<option>No data available</option>";
    }

    echo "</select>";

    $conn->close();
    ?>

    <label for="date">Дата приема:</label>
    <input type="datetime-local" id="date" name="date" >

    <!-- это должно выводиться в квитанции
    <label for="paymentAmount">Сумма оплаты:</label>
    <input type="number" id="paymentAmount" name="paymentAmount" required step="0.01">
    -->
    <button type="submit">Записать на прием</button>

</form>
</body>
</html>




