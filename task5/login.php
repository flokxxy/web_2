
<?php

$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
    $session_started = true;
    if(!empty($_GET['enter'])){
        session_destroy();
        header("Location:index.php");
        exit();
    }
    if (!empty($_SESSION['login'])) {
        header('Location: ./');
        exit();
    }
}
// Включение отображения ошибок для отладки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных с использованием PDO



echo "Логин:" . $_GET['log'];
echo "Пароль:" . $_GET['pas'];
echo "Новый пользователь успешно добавлен.";

//$hashed_password = password_hash($_GET['pas'], PASSWORD_DEFAULT);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            margin-top: 100px;
        }
        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .btn-custom {
            color: #fff;
            background-color: #152573;
            border-color: #152573;
        }
        .btn-custom:hover {
            color: #fff;
            background-color: #152573;
            border-color: #152573;
        }
    </style>
</head>
<body>
<div class="container form-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form class="form-signin" action="login.php" method="post">
                <h2 class="h3 mb-3 font-weight-normal text-center">Please sign in</h2>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" >
                    <label for="username">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                    <label for="password">Password</label>
                </div>
                <div class="checkbox mb-3 mt-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-custom" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
else
{
    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


    $loggined=false;
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $flag = '';
    try {
        //$pdo = new PDO($dsn, $username, $password, $options);
        $pr = "SELECT * FROM users";
        $issue = $db->query($pr);
        if (!$session_started) {
            session_start();
        }

        $kkk = $issue->fetchall();
        setcookie('kkk', serialize($kkk));
        /*while ($row = $issue->fetch()) {
            $flag=$flag.$row['username']." - ". $hashed_password == $row['password'].'<br>';
            if($_POST['username'] == $row['username'] && $hashed_password == $row['password']) {
                $loggined = true;

                break;
            }
        }*/
    }catch (PDOException $e) {
        setcookie('DBERROR', 'Error2 : ' . $e->getMessage());
    }
    setcookie('flag', $flag);
    setcookie('logMASS',$_POST['username'].' '.$_POST['password'] . ' ' . $loggined .'<br>');

    if($loggined){
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['hasentered'] = true;

    }
    else{
        $_SESSION['login'] = '';
        $_SESSION['password'] = '';
        $_SESSION['hasentered'] = false;
    }






header('Location: ./');
}
?>
