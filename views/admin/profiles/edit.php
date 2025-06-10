<h1>Редагувати користувача</h1>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Ім’я користувача</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user->username) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user->email) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Роль</label>
        <select name="role" class="form-control">
            <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>Користувач</option>
            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Адміністратор</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Новий пароль</label>
        <input type="password" name="password" class="form-control">
        <div class="form-text">Залиште порожнім, якщо не хочете змінювати</div>
    </div>
    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>