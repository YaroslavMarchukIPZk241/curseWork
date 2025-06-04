<?php
/** @var string $error_message Повідомлення про помилку */
$this->Title = 'Реєстрація';
?>
<h1>Реєстрація</h1>
<form method="POST" action="" enctype="multipart/form-data">
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="InputUsername" class="form-label">Логін *</label>
        <input value="<?= $this->controller->post->username ?>" name="username" type="text" class="form-control" id="InputUsername" required>
    </div>

    <div class="mb-3">
        <label for="InputEmail" class="form-label">Email</label>
        <input value="<?= $this->controller->post->email ?>" name="email" type="email" class="form-control" id="InputEmail">
    </div>

    <div class="mb-3">
        <label for="InputPassword" class="form-label">Пароль *</label>
        <input name="password" type="password" class="form-control" id="InputPassword" required>
    </div>

    <div class="mb-3">
        <label for="InputPassword2" class="form-label">Пароль (ще раз) *</label>
        <input name="password2" type="password" class="form-control" id="InputPassword2" required>
    </div>

    <button type="submit" class="btn btn-primary">Зареєструватися</button>
</form>

<p>Уже зареєстровані? <a href="/profile/login">Натискайте сюди</a></p>
