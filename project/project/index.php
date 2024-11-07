<?php
include 'includes/header.php';
include 'includes/db.php';

// Получение случайных товаров для карусели
$query = "SELECT * FROM products WHERE stock > 0 ORDER BY RAND() LIMIT 5";
$statement = $pdo->prepare($query);
$statement->execute();
$carousel_products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center">Популярные товары</h2>

    <div id="productCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($carousel_products as $index => $product): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Формируем полный путь к изображению -->
                            <img src="assets/images/<?= htmlspecialchars($product['image']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="col-md-6">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <p><strong>Цена: </strong><?= htmlspecialchars($product['price']) ?> руб.</p>
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Элементы управления каруселью -->
        <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Следующий</span>
        </a>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
