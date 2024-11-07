<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

// Получаем список товаров
$query = "SELECT * FROM products";
$statement = $pdo->prepare($query);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="mb-4">Управление товарами</h1>

<!-- Список товаров -->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Наличие</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?> руб.</td>
                <td><?= htmlspecialchars($product['stock']) ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add_product.php" class="btn btn-primary">Добавить новый товар</a>

<?php include '../includes/footer.php'; ?>
