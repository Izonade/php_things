<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

// Обработка формы добавления категории
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Проверка на заполненность названия категории
    if (strlen($name) < 1) {
        $error = "Название категории обязательно.";
    } else {
        // Вставка новой категории в базу данных
        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $statement = $pdo->prepare($query);
        $statement->execute([
            'name' => $name,
            'description' => $description
        ]);

        // Перенаправление с сообщением об успешном добавлении
        header("Location: categories.php?success=Категория успешно добавлена");
        exit();
    }
}
?>

<div class="container">
    <h1 class="mb-4">Добавить категорию</h1>

    <!-- Сообщение об ошибке -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="add_category.php" method="post">
        <div class="form-group">
            <label for="name">Название категории</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Описание категории</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Добавить категорию</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
