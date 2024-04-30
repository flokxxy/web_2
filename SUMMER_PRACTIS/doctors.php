<?php
header('Cache-Control: no-cache, must-revalidate');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>task 5</title>
</head>
<body>


<form action="form_doctors.php" method="post">
    <label for="fullName">ФИО врача:</label>
    <input type="text" name="fullName" <?php if (isset($errors['fullName'])) {print 'class="error"';} ?>
    value="<?php if (isset($values['fullName'])) {print $values['fullName'];} ?>" />



    <label for="specialty">Специальность:</label>
    <!--<input type="text" id="specialty" name="specialty" <?php if (isset($errors['specialty'])) {print 'class="error"';} ?>
    value="<?php if (isset($values['specialty'])) {print $values['specialty'];} ?>" />
    -->
    <select id="specialty" name="specialty" <?php if (isset($errors['specialty'])) {echo 'class="error"';} ?>>
    <option value="">Выберите специальность</option>
    <option value="терапевт" <?php echo (isset($values['specialty']) && $values['specialty'] == 'терапевт') ? 'selected' : ''; ?>>Терапевт</option>
    <option value="кардиолог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'кардиолог') ? 'selected' : ''; ?>>Кардиолог</option>
    <option value="невролог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'невролог') ? 'selected' : ''; ?>>Невролог</option>
    <option value="хирург" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Хирург</option>
    </select>


    <label for="fee">Стоимость приема:</label>
    <input type="number" id="fee" name="fee" <?php if (isset($errors['fee'])) {print 'class="error"';} ?>
    value="<?php if (isset($values['fee'])) {print $values['fee'];} ?>" />
    <label for="commission">Процент отчисления:</label>
    <input type="number" id="commission" name="commission" <?php if (isset($errors['commission'])) {print 'class="error"';} ?>
    value="<?php if (isset($values['commission'])) {print $values['commission'];} ?>" />
    <button type="submit">Добавить врача</button>
</form>



<!--
<label for="specialty">Специальность:</label>
<select id="specialty" name="specialty">
  <option value="терапевт">Терапевт</option>
  <option value="хирург">Хирург</option>
  <option value="офтальмолог">Офтальмолог</option>
   Добавьте другие варианты специальностей по аналогии -->
</select>


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

</body>
</html>
