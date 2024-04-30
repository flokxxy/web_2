<?php
?>
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
<form action="form_patients.php" method="post">
    <label for="lastName">Фамилия:</label>
    <input type="text" id="lastName" name="lastName"
    <?php if($errors['lastNamee']) {print 'class="error"';}?> value="<?php $values['lastName']; ?>" >
    <label for="firstName">Имя:</label>
    <input type="text" id="firstName" name="firstName"
    <?php if($errors['firstName']) {print 'class="error"';}?> value="<?php $values['firstName']; ?>" >
    <label for="middleName">Отчество:</label>
    <input type="text" id="middleName" name="middleName"
    <?php if($errors['middleName']) {print 'class="error"';}?> value="<?php $values['middleName']; ?>" >
    <label for="birthDate">Дата рождения:</label>
    <input type="date" id="birthDate" name="birthDate"
    <?php if ($errors['birthDate']) {print 'class="error"';} ?> value="<?php print $values['birthDate']; ?>">
    <label for="address">Адрес:</label>
    <input type="text" id="address" name="address"
    <?php if($errors['address']) {print 'class="error"';}?> value="<?php $values['address']; ?>" >
    <button type="submit">Добавить пациента</button>
</form>
</body>
</html>
