

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
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
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
// Включение отображения ошибок для отладки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных с использованием PDO
include('../impotent.php');
$servername = "localhost";
$username = username;
$password = password;
$dbname = username;

$dsn = "mysql:host=$servername;dbname=$dbname; charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


// Функция для генерации уникального логина
function generateUsername() {
    return 'user_' . uniqid(); // генерация уникального ID для простоты
}

// Функция для генерации безопасного пароля
function generatePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

// Генерация логина и пароля
$username = generateUsername();
$password = generatePassword();

// Хеширование пароля
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Вставка данных в базу
$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username, 'password' => $hashed_password]);

echo "Логин: $username\n";
echo "Пароль: $password (сохранен в хешированном виде)\n";
echo "Пароль hash: $hashed_password (сохранен в хешированном виде)\n";
echo "Новый пользователь успешно добавлен.";
?>
