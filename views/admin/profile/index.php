<h1>Користувачі</h1>
<a href="/MuseumShowcase/admin/profile/create" class="btn btn-success">Додати користувача</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ім'я користувача</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Бонус-код</th>
            <th>Дата створення</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->id) ?></td>
                <td><?= htmlspecialchars($user->username) ?></td>
                <td><?= htmlspecialchars($user->email) ?></td>
                <td><?= htmlspecialchars($user->role) ?></td>
                <td><?= $user->bonus_code !== null ? htmlspecialchars($user->bonus_code) : '—' ?></td>
                <td><?= htmlspecialchars($user->created_at) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/profile/edit/<?= $user->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/profile/delete/<?= $user->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити користувача?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
