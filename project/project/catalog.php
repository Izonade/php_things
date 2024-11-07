<?php
include 'includes/header.php';
include 'includes/db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$category_id = $_GET['category'] ?? null;
$sort = $_GET['sort'] ?? 'created_at';

$query = "SELECT * FROM products WHERE stock > 0";
$params = [];

if ($category_id) {
    $query .= " AND category_id = :category_id";
    $params['category_id'] = $category_id;
}

if ($sort === 'price') {
    $query .= " ORDER BY price ASC";
} else {
    $query .= " ORDER BY created_at DESC";
}

$statement = $pdo->prepare($query);
$statement->execute($params);
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="mb-4">Каталог товаров</h1>

<!-- Фильтр и сортировка -->
<form method="get" action="catalog.php" class="form-inline mb-4">
    <div class="form-group mr-2">
        <select name="category" class="form-control">
            <option value="">Все категории</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category_id == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group mr-2">
        <select name="sort" class="form-control">
            <option value="created_at" <?= $sort == 'created_at' ? 'selected' : '' ?>>Сначала новые</option>
            <option value="price" <?= $sort == 'price' ? 'selected' : '' ?>>По цене</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Применить</button>
</form>

<!-- Список товаров -->
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="assets/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text">Цена: <?= htmlspecialchars($product['price']) ?> руб.</p>
                    <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary">Подробнее</a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Кнопка "Заказать" видна только для авторизованных пользователей -->
                        <a href="order.php?product_id=<?= $product['id'] ?>" class="btn btn-primary">Заказать</a>
                    <?php else: ?>
                        <p class="text-muted">Авторизуйтесь, чтобы заказать</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
