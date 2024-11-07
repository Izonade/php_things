<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

$id = $_GET['id'];

// Получение данных товара
$query = "SELECT * FROM products WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->execute(['id' => $id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден.");
}

// Обновление товара
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    // Если новое изображение загружено, обновляем его
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "../assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image']; // Используем старое изображение
    }

    $query = "UPDATE products SET name = :name, description = :description, price = :price, 
              stock = :stock, category_id = :category_id, image = :image WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock' => $stock,
        'category_id' => $category_id,
        'image' => $image,
        'id' => $id
    ]);

    header("Location: products.php");
    exit();
}

// Получение категорий для выпадающего списка
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Редактировать товар</h1>

<form action="edit_product.php?id=<?= $product['id'] ?>" method="post" enctype="multipart/form-data">
    <label>Название: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required></label><br>
    <label>Описание: <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea></label><br>
    <label>Цена: <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required></label><br>
    <label>Количество на складе: <input type="number" name="stock" value="<?= $product['stock'] ?>" required></label><br>
    <label>Категория:
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Изображение: <input type="file" name="image"></label><br>
    <button type="submit">Сохранить изменения</button>
</form>

<?php include '../includes/footer.php'; ?>
