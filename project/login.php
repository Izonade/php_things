<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center">Вход</h2>
        <form action="login_process.php" method="post" class="mt-4">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
