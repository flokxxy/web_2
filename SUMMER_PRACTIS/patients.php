


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
print($errors['lastName'] . '<br>');
print($errors['firstName'] . '<br>');
print($errors['middleName'] .'<br>');
print($errors['birthDate'] . '<br>');
print($errors['address'] . '<br>');
?>

<form action="form_patients.php" method="post">
    <label for="lastName">Фамилия:</label>
    <input type="text" id="lastName" name="lastName" <?php if (isset($errors['lastName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['lastName'])) {print $values['lastName'];} ?>" />
    <label for="firstName">Имя:</label>
    <input type="text" id="firstName" name="firstName" <?php if (isset($errors['firstName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['firstName'])) {print $values['firstName'];} ?>" />
    <label for="middleName">Отчество:</label>
    <input type="text" id="middleName" name="middleName" <?php if (isset($errors['middleName'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['middleName'])) {print $values['middleName'];} ?>" />
    <label for="birthDate">Дата рождения:</label>
    <input type="date" id="birthDate" name="birthDate" <?php if (isset($errors['birthDate'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['birthDate'])) {print $values['birthDate'];} ?>" />
    <label for="address">Адрес:</label>
    <input type="text" id="address" name="address" <?php if (isset($errors['address'])) {print 'class="error"';} ?>
           value="<?php if (isset($values['address'])) {print $values['address'];} ?>" />
    <button type="submit">Добавить пациента</button>
</form>
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
