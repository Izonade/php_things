</main>
<footer class="bg-custom text-light py-4 mt-5">
    <div class="container-fluid">
        <div class="row">
            <!-- Ссылки на страницы -->
            <div class="col-md-4 mb-3">
                <h5>Навигация</h5>
                <ul class="list-unstyled">
                    <li><a href="/project/index.php" class="text-light">Главная</a></li>
                    <li><a href="/project/catalog.php" class="text-light">Каталог</a></li>
                    <li><a href="/project/contact.php" class="text-light">Контакты</a></li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="/project/admin/index.php" class="text-light">Администрирование</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Контактная информация -->
            <div class="col-md-4 mb-3">
                <h5>Контакты</h5>
                <p>г. Москва, ул. Примерная, д. 1</p>
                <p>Телефон: +7 (123) 456-78-90</p>
                <p>Email: <a href="mailto:info@company.com" class="text-light">info@company.com</a></p>
            </div>

            <!-- Социальные сети -->
            <div class="col-md-4 mb-3">
                <h5>Мы в соцсетях</h5>
                <a href="#" class="text-light mr-2"><i class="fab fa-facebook"></i> Facebook</a><br>
                <a href="#" class="text-light mr-2"><i class="fab fa-instagram"></i> Instagram</a><br>
                <a href="#" class="text-light"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="mb-0">&copy; <?= date("Y") ?> Магазин. Все права защищены.</p>
        </div>
    </div>
</footer>
