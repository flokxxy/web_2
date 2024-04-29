<?php

header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-cache, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['DBERROR'])) {
        $messages[] = $_COOKIE['DBERROR'] . '<br><br>';
        setcookie('DBERROR', '', time() - 3600);
    }
    if (!empty($_COOKIE['logMASS'])) {
        $messages[] = $_COOKIE['logMASS'];
        setcookie('logMASS', '', time() - 3600);
    }

    if (!empty($_COOKIE['save'])) {
        $messages[] = 'Спасибо, результаты сохранены.';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете войти с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.<br>',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
    }

    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['programming-language'] = !empty($_COOKIE['programming-language_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000);
        setcookie('fio_value', '', 100000);
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        setcookie('phone_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните почту.</div>';
    }
    if ($errors['birthdate']) {
        setcookie('birthdate_error', '', 100000);
        setcookie('birthdate_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);
        $messages[] = '<div class="error">Заполните пол.</div>';
    }
    if ($errors['programming-language']) {
        setcookie('programming-language_error', '', 100000);
        setcookie('programming-language_value', '', 100000);
        $messages[] = '<div class="error">выберите язык.</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error">Заполните дополнительную информаци о себе.</div>';
    }
    if ($errors['contract']) {
        setcookie('contract_error', '', 100000);
        setcookie('contract_value', '', 100000);
        $messages[] = '<div class="error">Согласитель на обработку персональных данных.</div>';
    }


    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : $_COOKIE['birthdate_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['programming-language'] = empty($_COOKIE['programming-language_value']) ? array() : unserialize($_COOKIE['programming-language_value']) ;
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];


    $started_session = session_start();
    $messages[] = 'has entered: '. !empty($_SESSION['hasentered']).'<br> ';

    if (!empty($_COOKIE[session_name()]) &&
        $started_session && !empty($_SESSION['hasentered'])) {
        $messages[]='Вход с логином: '. $_SESSION['login'] . '<br>';
        // TODO: загрузить данные пользователя из БД
        // и заполнить переменную $values,
        // предварительно санитизовав.
        $messages[] = '<a href ="login.php?enter=1"> Выйти </a>';
    }
    else{
        $messages[]='<a href="login.php?">Войти</a><br>';
    }

    include('form.php');
    exit();
}
else {
//обработка POST запроса
    $fio = $phone = $email = $birthdate = $gender = '';
    $langs = [];
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $langs = isset($_POST['programming-language']) ? (array)$_POST['programming-language'] : [];
    $langs_check = ['c', 'c++', 'js', 'java', 'clojure', 'pascal', 'python', 'haskel', 'scala', 'php', 'prolog'];


//валидация данных

    $errors = FALSE;

    if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
        $errors = TRUE;
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        print (" mistake in фио ");
    }
    else setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['phone']) || !preg_match('/^[0-9+]+$/', $_POST['phone'])) {
        $errors = TRUE;
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        print (" mistake in тел ");
    }
    else setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors = TRUE;
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        print (" mistake in мыло ");
    }
    else setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);


    $dateObject = DateTime::createFromFormat('Y-m-d', $_POST['birthdate']);
    if ($dateObject === false || $dateObject->format('Y-m-d') !== $_POST['birthdate']) {
        $errors = TRUE;
        setcookie('birthdate_error', '1', time() + 24 * 60 * 60);
        print (" mistake in дата ");
    }
    else setcookie('birthdate_value', $_POST['birthdate'], time() + 30 * 24 * 60 * 60);

    if ($_POST['gender'] != 'male' && $_POST['gender'] != 'female') {
        $errors = TRUE;
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        print (" mistake in гендр ");
    }
    else setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

    /*
    if (!checkLangs($langs, $langs_check)) {
        $errors = TRUE;
        print (" mistake in check ");
    }*/

    if(!isset($_POST['contract'])){
        $errors = TRUE;
        setcookie('contract_error', '1', time() + 24 * 60 * 60);
        print (" mistake in галочка ");
    }
    else setcookie('contract_value', $_POST['contract'], time() + 30 * 24 * 60 * 60);

    if ($errors === TRUE) {
        echo 'mistake';
        exit();
    }
    else {
        setcookie('fio_error', '', time() - 30 * 24 * 60 * 60);
        setcookie('phone_value', '', time() - 30 * 24 * 60 * 60);
        setcookie('email_value', '', time() - 30 * 24 * 60 * 60);
        setcookie('birthdate_value', '', time() - 30 * 24 * 60 * 60);
        setcookie('gender_value', '', time() - 30 * 24 * 60 * 60);
        setcookie('contract_value', '', time() - 30 * 24 * 60 * 60);
    }

    function generateUsername() {
        return 'user_' . uniqid(); // генерация уникального ID для простоты
    }


    include('../SecretData.php');
    $servername = "localhost";
    $username = user;
    $password = pass;
    $dbname = user;


    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login']) && false) {
        // TODO: перезаписать данные в БД новыми данными,
        // кроме логина и пароля.
    }
    else {
        // ААААААААААААААААААААААААААААААААААААААА
        $login = generateUsername();
        $pass = rand();
        //$hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $hashed_password = md5($pass);
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $pass);

        $_SESSION['hasentered'] = false;

        try {
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Вставка данных в базу
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['username' => $login, 'password' => $hashed_password]);
        } catch(PDOException $e) {
            setcookie('DBERROR', 'Error1 : ' . $e->getMessage());
        }
    }
    setcookie('save', '1');

    // Делаем перенаправление.
    header('Location: ./');

    $conn = null;
}
?>
