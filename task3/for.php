<!DOCTYPE html>
<html lang="en">
<head>

    <link rel= "stylesheet"  href = "style.css">
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="main">
    <form action="index.php" method="POST">
        <label for="fio">ФИО:</label>
        <input type="text" id="fio" name="fio" required>

        <label for="phone">Телефон:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="birthdate">Дата рождения:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label>Пол:</label>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Мужской</label>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Женский</label>

        <label for="programming-language">Любимый язык программирования:</label>
        <select id="programming-language" name="programming-language[]" multiple required>
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

        <label for="bio">Биография:</label>
        <textarea id="bio" name="bio" rows="4" required></textarea>

        <input type="checkbox" id="contract" name="contract" required>
        <label for="contract">С контрактом ознакомлен(а)</label>

        <input type="submit" value="Сохранить">
    </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$_POST["bio"] = htmlspecialchars($_POST["bio"]);
}
?>

</div>


</body>
</html>
