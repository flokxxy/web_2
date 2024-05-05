


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_doctors_patients.css" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Добавление пациента</title>
</head>
<style>
    .error {
        border: 2px solid red;
    }
</style>
<body>

<?php
?>
<div class="form-structor">
<form action="form_patients.php" method="post">
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
        <button type="submit" class="btnn">Добавить пациента</button>
</form>
</div>
<br>

</body>
</html>

<?php
if (!empty($message)) {
    print('<div id="message">');
// Выводим все сообщения.
    foreach ($message as $m) {
        print($m);
    }
    print('</div>');
}
?>
