<?php
header('Content-Type: text/html; charset=UTF-8');
session_start(); // Начало сессии для хранения данных формы и сообщений об ошибках

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $message = array();

    if (!empty($_COOKIE['save'])) {
        setcookie("save", '', time() - 3600);
        $message[] = 'Данные слхрани';
    }

    $errors = array();
    $errors['lastName'] = !empty($_COOKIE['lastName_errors']);
    $errors['firstName'] = !empty($_COOKIE['firstName_errors']);
    $errors['middleName'] = !empty($_COOKIE['middleName_errors']);
    $errors['birthDate'] = !empty($_COOKIE['birthDate_errors']);
    $errors['address'] = !empty($_COOKIE['address_errors']);

    if ($errors['lastName']) {
        setcookie("lastName_errors", '', time() - 3600);
        setcookie("lastName_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните фамилию пациента.</div>';
    }
    if ($errors['firstName']) {
        setcookie("firstName_errors", '', time() - 3600);
        setcookie("firstName_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните специальность врача.</div>';
    }
    if ($errors['middleName']) {
        setcookie("middleName_errors", '', time() - 3600);
        setcookie("middleName_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните стоимость приема.</div>';
    }
    if ($errors['birthDate']) {
        setcookie("birthDate_errors", '', time() - 3600);
        setcookie("birthDate_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните дату рождения.</div>';
    }
    if ($errors['address']) {
        setcookie("address_errors", '', time() - 3600);
        setcookie("address_values", '', time() - 3600);
        $message[] = '<div class="error">Заполните адрес проживания.</div>';
    }

    $values = array();
    $values['lastName'] = empty($_COOKIE['lastName_value']) ? '' : $_COOKIE['lastName_value'];
    $values['firstName'] = empty($_COOKIE['firstName_value']) ? '' : $_COOKIE['firstName_value'];
    $values['middleName'] = empty($_COOKIE['middleName_value']) ? '' : $_COOKIE['middleName_value'];
    $values['birthDate'] = empty($_COOKIE['birthDate_value']) ? '' : $_COOKIE['birthDate_value'];
    $values['address'] = empty($_COOKIE['address']) ? '' : $_COOKIE['address'];


    include('patients.php');
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {


    $errors = FALSE;
    if (empty(trim($_POST['lastName'])) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['lastName'])) {
        $errors = TRUE;
        setcookie("lastName_errors", '1', time() + 3600);
        print('Фамилия обязательно к заполнению.'."\n");
    }else setcookie('lastName_value', $_POST['lastName'], time() + (86400 * 30));

    if(empty($_POST['firstName']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['firstName'])){
        $errors = TRUE;
        setcookie("firstName_errors", '1', time() + 3600);
        print('Имя обязательно к заполнению.'."\n");
    }else setcookie('firstName_value', $_POST['firstName'], time() + (86400 * 30));

    if(empty($_POST['middleName']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['middleName'])){
        $errors = TRUE;
        setcookie("middleName_errors", '1', time() + 3600);
        print('Отчество обязательно к заполнению.'."\n");
    }else setcookie('middleName_value', $_POST['middleName'], time() + (86400 * 30));

    $dateObject = DateTime::createFromFormat('Y-m-d', $_POST['birthDate']);
    if ($dateObject === false || $dateObject->format('Y-m-d') !== $_POST['birthDate']) {
        $errors = TRUE;
        setcookie('birthDate_error', '1', time() + 24 * 60 * 60);
        print (" Укажите дату рождения ");
    }
    else setcookie('birthDate_value', $_POST['birthDate'], time() + 30 * 24 * 60 * 60);


    if(empty($_POST['address'])){
        $errors = TRUE;
        setcookie("address_errors", '1', time() + 3600);
        print('Укажите корректный адрес проживания.'."\n");
    }else setcookie('address_value', $_POST['address'], time() + (86400 * 30));

    if ($errors || empty($lastName) || empty($firstName) || empty($middleName) || empty($birthDate)|| empty($address)) {
        print('что-то не так');
        header("Location: form_patients.php"); // Перенаправление обратно на форму
        exit;
    }
    else {
        setcookie('lastName_errors', '', time() - 3600);
        setcookie('firstName_errors', '', time() - 3600);
        setcookie('middleName_errors', '', time() - 3600);
        setcookie('birthDate_errors', '', time() - 3600);
        setcookie('address_errors', '', time() - 3600);
    }

    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Patients (LastName,FirstName, MiddleName, BirthDate, Address) VALUES (:lastName, :firstName, :middleName, :birthDate, :address)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':middleName', $middleName);
        $stmt->bindParam(':birthDate', $birthDate);
        $stmt->bindParam(':address', $address);

        $stmt->execute();
        echo "Пациент успешно добавлен.";
        $lastId = $pdo->lastInsertId();
        echo "ID нового пациента: $lastId";

        // Очистка данных формы в сессии после успешного добавления
        unset($_SESSION['form_input']);
    } catch (PDOException $e) {
        $errors['database'] = "Ошибка при добавлении врача: " . $e->getMessage();
    }
    setcookie('save', '1');

    header("Location: form_patients.php"); // Перенаправление обратно на форму
    exit;

}
?>

