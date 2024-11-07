<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Получение списка заказов для текущего пользователя
$query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
$statement = $pdo->prepare($query);
$statement->execute(['user_id' => $user_id]);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Мои заказы</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<?php if (count($orders) > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                    <td><?= htmlspecialchars($order['total_price']) ?> руб.</td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>У вас пока нет заказов.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
