<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

// Получаем заказы
$query = "SELECT orders.id, orders.total_price, orders.status, orders.created_at, users.username
          FROM orders
          JOIN users ON orders.user_id = users.id
          ORDER BY orders.created_at DESC";
$statement = $pdo->prepare($query);
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Управление заказами</h1>

<table>
    <tr>
        <th>ID заказа</th>
        <th>Пользователь</th>
        <th>Сумма</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars($order['username']) ?></td>
            <td><?= htmlspecialchars($order['total_price']) ?> руб.</td>
            <td><?= htmlspecialchars($order['status']) ?></td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
            <td>
                <a href="order_details.php?id=<?= $order['id'] ?>">Просмотр</a> | 
                <a href="confirm_order.php?id=<?= $order['id'] ?>">Подтвердить</a> | 
                <a href="cancel_order.php?id=<?= $order['id'] ?>" onclick="return confirm('Вы уверены, что хотите отменить заказ?')">Отменить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
