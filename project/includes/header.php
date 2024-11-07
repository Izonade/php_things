
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 // Убедимся, что сессия начата
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <!-- Подключаем Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="/project/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/project/assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-custom">
            <a class="navbar-brand" href="/project/index.php">Магазин</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/project/index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="/project/catalog.php">Каталог</a></li>
                    <li class="nav-item"><a class="nav-link" href="/project/contact.php">Контакты</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Показать кнопку "Администрирование" только для администратора -->
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="/project/admin/index.php">Администрирование</a></li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Кнопка "Мои заказы" -->
                            <li class="nav-item"><a class="nav-link" href="/project/my_orders.php">Мои заказы</a></li>
                        <?php endif; ?>

                        
                        <!-- Кнопка "Выйти" для всех авторизованных пользователей -->
                        <li class="nav-item"><a class="nav-link" href="/project/logout.php">Выйти</a></li>
                    <?php else: ?>
                        <!-- Кнопки "Вход" и "Регистрация" для неавторизованных пользователей -->
                        <li class="nav-item"><a class="nav-link" href="/project/login.php">Вход</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project/register.php">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
