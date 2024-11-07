<?php
session_start();
include 'includes/db.php';

// Получаем данные из формы
$username = $_POST['username'];
$password = $_POST['password'];

// Проверка пользователя в базе данных
$query = "SELECT * FROM users WHERE username = :username";
$statement = $pdo->prepare($query);
$statement->execute(['username' => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Успешная авторизация
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    
    // Перенаправление в зависимости от роли
    if ($user['role'] === 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit();
} else {
    die("Неверный логин или пароль");
}
?>
