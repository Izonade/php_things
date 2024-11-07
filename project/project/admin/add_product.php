<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';
include '../includes/db.php';

// Обработка формы добавления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;

    // Обработка загрузки изображения
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "../assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = null; // Если изображение не загружено, оставим поле пустым
    }

    // Вставка товара в базу данных
    $query = "INSERT INTO products (name, description, price, stock, category_id, image) 
              VALUES (:name, :description, :price, :stock, :category_id, :image)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock' => $stock,
        'category_id' => $category_id,
        'image' => $image
    ]);

    // Перенаправление с сообщением об успешном добавлении
    header("Location: products.php?success=Товар успешно добавлен");
    exit();
}

// Получение категорий для выпадающего списка
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Добавить товар</h1>

    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="stock">Количество на складе</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="category_id">Категория (необязательно)</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Без категории</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Изображение</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>
        
        <button type="submit" class="btn btn-primary">Добавить товар</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
