<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
?>

<div class="container">
    <h1 class="mb-4">Админ-панель</h1>
    <ul class="list-group">
        <li class="list-group-item"><a href="products.php">Управление товарами</a></li>
        <li class="list-group-item"><a href="orders.php">Управление заказами</a></li>
        <li class="list-group-item"><a href="categories.php">Управление категориями</a></li>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
