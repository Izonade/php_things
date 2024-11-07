<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

$order_id = $_GET['id'];

// Получение данных о заказе
$query = "SELECT orders.id, orders.total_price, orders.status, orders.created_at, users.username 
          FROM orders 
          JOIN users ON orders.user_id = users.id 
          WHERE orders.id = :order_id";
$statement = $pdo->prepare($query);
$statement->execute(['order_id' => $order_id]);
$order = $statement->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Заказ не найден.");
}

// Получение товаров из заказа
$query = "SELECT products.name, order_items.quantity, order_items.price 
          FROM order_items 
          JOIN products ON order_items.product_id = products.id 
          WHERE order_items.order_id = :order_id";
$statement = $pdo->prepare($query);
$statement->execute(['order_id' => $order_id]);
$items = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Детали заказа №<?= htmlspecialchars($order['id']) ?></h1>

<p><strong>Пользователь:</strong> <?= htmlspecialchars($order['username']) ?></p>
<p><strong>Дата заказа:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
<p><strong>Статус:</strong> <?= htmlspecialchars($order['status']) ?></p>
<p><strong>Общая сумма:</strong> <?= htmlspecialchars($order['total_price']) ?> руб.</p>

<h2>Товары в заказе</h2>
<table>
    <tr>
        <th>Название товара</th>
        <th>Количество</th>
        <th>Цена</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= htmlspecialchars($item['price']) ?> руб.</td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="confirm_order.php?id=<?= $order['id'] ?>">Подтвердить заказ</a> | 
<a href="cancel_order.php?id=<?= $order['id'] ?>" onclick="return confirm('Вы уверены, что хотите отменить заказ?')">Отменить заказ</a></p>

<?php include '../includes/footer.php'; ?>
