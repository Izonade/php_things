<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Проверка, что ID категории передан
if (!isset($_GET['id'])) {
    header("Location: categories.php?error=Категория не найдена");
    exit();
}

$category_id = $_GET['id'];

try {
    // Установим category_id товаров в NULL для удаляемой категории
    $query = "UPDATE products SET category_id = NULL WHERE category_id = :category_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['category_id' => $category_id]);

    // Удаление категории из таблицы categories
    $query = "DELETE FROM categories WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $category_id]);

    // Перенаправление с сообщением об успешном удалении
    header("Location: categories.php?success=Категория успешно удалена");
    exit();
} catch (PDOException $e) {
    // Обработка ошибок
    header("Location: categories.php?error=Не удалось удалить категорию.");
    exit();
}
?>
