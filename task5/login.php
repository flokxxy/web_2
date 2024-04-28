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

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
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
