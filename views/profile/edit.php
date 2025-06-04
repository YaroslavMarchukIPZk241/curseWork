<?php
/** @var array $user */
$this->Title = 'Редагування профілю';
?>

<div class="profile-edit">
    <h1 class="mb-4">Редагування профілю</h1>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/MuseumShowcase/profile/edit">
        <div class="mb-3">
            <label for="username" class="form-label">Ім'я користувача</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <hr class="my-4">

        <h5 class="mb-3">Зміна паролю (необов'язково)</h5>

        <div class="mb-3">
            <label for="current_password" class="form-label">Поточний пароль</label>
            <input type="password" class="form-control" id="current_password" name="current_password">
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Новий пароль</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Підтвердження нового паролю</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>

        <button type="submit" class="btn btn-success"> Зберегти зміни</button>
        <a href="/profile" class="btn btn-secondary ms-2"> Скасувати</a>
    </form>
</div>