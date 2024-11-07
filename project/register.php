<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="text-center">Регистрация</h2>
        <form action="register_process.php" method="post" class="mt-4" onsubmit="return validatePassword()">
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" class="form-control" minlength="6" required>
            </div>
            <div class="form-group">
                <label for="password_repeat">Повторите пароль</label>
                <input type="password" name="password_repeat" id="password_repeat" class="form-control" minlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </form>
    </div>
</div>

<script>
function validatePassword() {
    const password = document.getElementById('password').value;
    if (password.length < 6) {
        alert('Пароль должен содержать не менее 6 символов.');
        return false;
    }
    return true;
}
</script>

<?php include 'includes/footer.php'; ?>
