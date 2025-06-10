<?php
/** @var array $user */
/** @var bool $edit */

use models\Users;

$this->Title = 'Мій профіль';
$user = Users::GetCurrentUser();
$edit = $edit ?? false;
?>



<?php if ($edit): ?>
<form method="POST" action="">
    <div class="mb-3">
        <label class="form-label">Ім'я користувача</label>
        <input type="text" name="username" value="<?=htmlspecialchars($user['username'])?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Зберегти зміни</button>
    <a href="/MuseumShowcase/profile" class="btn btn-secondary">Скасувати</a>
</form>
<?php else: ?>
<div class="profile-view">
    <h1>Профіль користувача</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Ім’я користувача:</strong> <?=htmlspecialchars($user['username'])?></li>
        <li class="list-group-item"><strong>Email:</strong> <?=htmlspecialchars($user['email'])?></li>
        <li class="list-group-item"><strong>Роль:</strong> <?=htmlspecialchars($user['role'])?></li>
    </ul>
    <a href="/MuseumShowcase/profile/edit" class="btn btn-primary mt-3">Редагувати</a>
    <a href="/MuseumShowcase/profile/promo" class="btn btn-primary mt-3">історія промокодів</a>
</div>
<?php endif; ?>
