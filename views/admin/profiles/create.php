<h1>Створити нового користувача</h1>

<form method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Ім’я користувача</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Роль</label>
        <select name="role" class="form-control">
            <option value="user">Користувач</option>
            <option value="admin">Адміністратор</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Створити</button>
</form>