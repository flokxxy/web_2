<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $programmingLanguages = $_POST['programming-language'];
    $bio = $_POST['bio'];
    // Дополнительная обработка данных формы
    // Например, сохранение в базу данных или отправка по электронной почте
}
?>

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
<div class="form-structor">
    <h2 class="form-title">Форма</h2>
    <form action="index.php" method="POST" class="form_main">
        <div class="form-group">
            <label for="fio">ФИО:</label>
            <input type="text" class="form-control" id="fio" name="fio" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="birthdate">Дата рождения:</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>
        <div class="form-group">
            <label>Пол:</label>
            <div>
                <input type="radio" id="male" name="gender" value="male" required>
                <label for="male">Мужской</label>
            </div>
            <div>
                <input type="radio" id="female" name="gender" value="female" required>
                <label for="female">Женский</label>
            </div>
        </div>
        <div class="form-group">
            <label for="programming-language">Любимый язык программирования:</label>
            <select class="form-control" id="programming-language" name="programming-language" multiple>
                <option value="Pascal">Pascal</option>
                <option value="C">C</option>
                <option value="C++">C++</option>
                <option value="JavaScript">JavaScript</option>
                <option value="PHP">PHP</option>
                <option value="Python">Python</option>
                <option value="Java">Java</option>
                <option value="Haskel">Haskel</option>
                <option value="Clojure">Clojure</option>
                <option value="Prolog">Prolog</option>
                <option value="Scala">Scala</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bio">Биография:</label>
            <textarea class="form-control" id="bio" name="bio" rows="4" required></textarea>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="contract" name="contract" required>
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
