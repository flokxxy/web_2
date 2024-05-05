
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_doctors_patients.css" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Заявление на прием</title>
</head>
<style>
    .error {
        border: 2px solid red;
    }
    .buttons{
        display: flex;
        flex-direction: row;
        margin:5px;
        justify-content: space-between;
        align-items: center;
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
<div class="form-structor">
<form action="form_appointments.php" method="post">
    <div class="form-group">
    <label for="lastName">Фамилия:</label>
    <input type="text" class="form-control" id="lastName" name="lastName" <?php if (($errors['lastName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['lastName'])) {print $values['lastName'];} ?>" />
    </div>
    <div class="form-group">
        <label for="firstName">Имя:</label>
    <input type="text" class="form-control" id="firstName" name="firstName" <?php if (($errors['firstName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['firstName'])) {print $values['firstName'];} ?>" />
    </div>
    <div class="form-group">
        <label for="middleName">Отчество:</label>
    <input type="text" class="form-control" id="middleName" name="middleName" <?php if (($errors['middleName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['middleName'])) {print $values['middleName'];} ?>" />
    </div>
    <div class="form-group">
        <label for="birthDate">Дата рождения:</label>
    <input type="date" class="form-control" id="birthDate" name="birthDate" <?php if (($errors['birthDate'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['birthDate'])) {print $values['birthDate'];} ?>" />
    </div>
    <div class="form-group">
    <label for="address">Адрес:</label>
    <input type="text" class="form-control" id="address" name="address" <?php if (($errors['address'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['address'])) {print $values['address'];} ?>" />
    </div>

    <div class="form-group">
        <label for="specialty">Выбрать врача:</label>
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

    $sql = "SELECT DoctorID,Specialty, FullName FROM Doctors";
    $result = $conn->query($sql);

    echo "<select name='doctor_id' class='form-control'>";


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
    </div>

    <label for="date">Дата приема:</label>
    <input type="datetime-local" class="form-control" id="date" name="date" >
    </div>
 <div class="buttons">
     <button type="submit"  class="btnn">Записать на прием</button>
     <br>
     <a href="quintation.php">
         <button type="button" class="btnn">Сформировать квитанцию об оплате</button>
     </a>
 </div>



</form>
</div>
</body>
</html>




