
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>task 3</title>
</head>


<body>

<?php
if (!empty($messages)) {
    print('<div id="messages">');
    // Выводим все сообщения.
    foreach ($messages as $message) {
        print($message);
    }
    print('</div>');
}
?>


<div class="form-structor">
    <h2 class="form-title">Форма</h2>
    <form action="index.php" method="POST" class="form_main">
        <div class="form-group">
            <label for="fio">ФИО:</label>
            <input type="text" id="fio" name="fio" required
                <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="ФИО" />
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" required
                <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php print $values['phone']; ?>" placeholder="+7(___)___-__-__" />
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" required
                <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="email" />
        </div>
        <div class="form-group">
            <label for="birthdate">Дата рождения:</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required
                <?php if ($errors['birthdate']) {print 'class="error"';} ?> value="<?php print $values['birthdate']; ?>" />
        </div>
        <div class="form-group">
            <label>Пол:</label>
            <div>
                <input type="radio" id="male" name="gender" value="male" required
                    <?php if ($values['gender']==='male') {print 'checked';} ?>"
                <label for="male">Мужской</label>
            </div>
            <div>
                <input type="radio" id="female" name="gender" value="female"
                <?php if ($values['gender']==='female') {print 'checked';} ?>"
                <label for="female">Женский</label>
            </div>
        </div>
        <div class="form-group">
            <label for="programming-language">Любимый язык программирования:</label>
            <select class="form-control" id="programming-language" name="programming-language" multiple>
                <option value="Pascal" <?php if (in_array('Pascal', $values['programming-language'])) { print 'selected'; } ?>>Pascal</option>
                <option value="C" <?php if (in_array('C', $values['programming-language'])) { print 'selected'; } ?>>C</option>
                <option value="C++" <?php if (in_array('C++', $values['programming-language'])) { print 'selected'; } ?>>C++</option>
                <option value="JavaScript" <?php if (in_array('JavaScript', $values['programming-language'])) { print 'selected'; } ?>>JavaScript</option>
                <option value="PHthon" <?php if (in_array('PHthon', $values['programming-language'])) { print 'selected'; } ?>>Python</option>
                <option value="JavP" <?php if (in_array('JavP', $values['programming-language'])) { print 'selected'; } ?>>PHP</option>
                <option value="Pya" <?php if (in_array('Pya', $values['programming-language'])) { print 'selected'; } ?>>Java</option>
                <option value="Haskel" <?php if (in_array('Haskel', $values['programming-language'])) { print 'selected'; } ?>>Haskel</option>
                <option value="Clrolog" <?php if (in_array('Clrolog', $values['programming-language'])) { print 'selected'; } ?>>Prolog</option>
                <option value="Sojure" <?php if (in_array('Sojure', $values['programming-language'])) { print 'selected'; } ?>>Clojure</option>
                <option value="Pcala" <?php if (in_array('Pcala', $values['programming-language'])) { print 'selected'; } ?>>Scala</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bio">Биография:</label>
            <textarea class="form-control" id="bio" name="bio" rows="4" required <?php if ($errors['bio']) {print 'class="error"';} ?>
            ><?php print $values['bio']; ?></textarea>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="contract" name="contract" required
                <?php if ($errors['contract']) {print 'class="error"';} ?> value="" />
            <label class="form-check-label" for="contract">С контрактом ознакомлен(а)</label>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
