<?php
session_start();
include 'includes/db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получаем данные о товаре из URL
$product_id = $_GET['product_id'];
$user_id = $_SESSION['user_id'];

// Проверка наличия товара
$query = "SELECT * FROM products WHERE id = :product_id AND stock > 0";
$statement = $pdo->prepare($query);
$statement->execute(['product_id' => $product_id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден или закончился на складе.");
}

// Вставка заказа в таблицу orders
$query = "INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, 'new')";
$statement = $pdo->prepare($query);
$statement->execute([
    'user_id' => $user_id,
    'total_price' => $product['price']
]);

// Получение ID созданного заказа
$order_id = $pdo->lastInsertId();

// Вставка данных о товаре в таблицу order_items
$query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, 1, :price)";
$statement = $pdo->prepare($query);
$statement->execute([
    'order_id' => $order_id,
    'product_id' => $product_id,
    'price' => $product['price']
]);

// Обновление количества товара на складе
$query = "UPDATE products SET stock = stock - 1 WHERE id = :product_id";
$statement = $pdo->prepare($query);
$statement->execute(['product_id' => $product_id]);

// Перенаправление на страницу подтверждения или списка заказов
header("Location: my_orders.php?success=Заказ успешно оформлен");
exit();
?>
