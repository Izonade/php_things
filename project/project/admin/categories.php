<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

// Получение списка категорий из базы данных
$query = "SELECT * FROM categories";
$statement = $pdo->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="mb-4">Категории товаров</h1>

    <!-- Сообщение об успешном удалении категории -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Кнопка для добавления новой категории -->
    <a href="add_category.php" class="btn btn-primary mb-3">Добавить категорию</a>

    <!-- Таблица с категориями и кнопками для удаления -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td><?= htmlspecialchars($category['description']) ?></td>
                    <td>
                        <!-- Кнопка удаления категории с подтверждением -->
                        <a href="delete_category.php?id=<?= $category['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить категорию?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
