
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_doctors.css" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Добавление врача</title>
</head>
<body>

<div class="form-structor">
<form action="form_doctors.php" method="post">
    <div class="form-group">
        <label for="fullName">ФИО врача:</label>
        <input type="text" class="form-control"  name="fullName" <?php if (isset($errors['fullName'])) {print 'class="error"';} ?>
        value="<?php if (isset($values['fullName'])) {print $values['fullName'];} ?>" />
    </div>
    <div class="form-group">
        <label for="specialty">Специальность:</label>
        <select class="form-control" id="specialty" name="specialty" <?php if (isset($errors['specialty'])) {echo 'class="error"';} ?>>
            <option value="Терапевт" <?php echo (isset($values['specialty']) && $values['specialty'] == 'терапевт') ? 'selected' : ''; ?>>Терапевт</option>
            <option value="Кардиолог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'кардиолог') ? 'selected' : ''; ?>>Кардиолог</option>
            <option value="Невролог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'невролог') ? 'selected' : ''; ?>>Невролог</option>
            <option value="Хирург" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Хирург</option>
            <option value="Эндокринолог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Эндокринолог</option>
            <option value="Гинекологи" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Гинекологи</option>
            <option value="Офтальмолог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Офтальмолог</option>
            <option value="Инфекционист" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Инфекционист</option>
            <option value="Онколог" <?php echo (isset($values['specialty']) && $values['specialty'] == 'хирург') ? 'selected' : ''; ?>>Онколог</option>
        </select>
    </div>
    <div class="form-group">
        <label for="fee">Стоимость приема:</label>
        <input type="number"  class="form-control"  id="fee" name="fee" <?php if (isset($errors['fee'])) {print 'class="error"';} ?>
        value="<?php if (isset($values['fee'])) {print $values['fee'];} ?>" />
    </div>
    <div class="form-group">
        <label for="commission">Процент отчисления:</label>
        <input type="number"  class="form-control" id="commission" name="commission" <?php if (isset($errors['commission'])) {print 'class="error"';} ?>
        value="<?php if (isset($values['commission'])) {print $values['commission'];} ?>" />
    </div>
    <button type="submit" class="btnn">Добавить врача</button>
</form>
</div>



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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
