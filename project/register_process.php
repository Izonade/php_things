<?php
include 'includes/db.php';

// Получаем данные из формы
$name = $_POST['name'];
$surname = $_POST['surname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];

// Проверка длины пароля
if (strlen($password) < 6) {
    header("Location: register.php?error=Пароль должен содержать не менее 6 символов");
    exit();
}

// Проверка совпадения паролей
if ($password !== $password_repeat) {
    header("Location: register.php?error=Пароли не совпадают");
    exit();
}

// Хеширование пароля
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Проверка на уникальность email и username
$query = "SELECT * FROM users WHERE email = :email OR username = :username";
$statement = $pdo->prepare($query);
$statement->execute(['email' => $email, 'username' => $username]);

if ($statement->rowCount() > 0) {
    header("Location: register.php?error=Логин или email уже используются");
    exit();
}

// Вставка пользователя в базу данных
$query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'client')";
$statement = $pdo->prepare($query);
$statement->execute([
    'username' => $username,
    'email' => $email,
    'password' => $hashed_password
]);

header("Location: login.php?success=Регистрация прошла успешно! Пожалуйста, авторизуйтесь.");
exit();
?>
