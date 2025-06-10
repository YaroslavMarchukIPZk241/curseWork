<?php
$currentUser = \models\Users::GetCurrentUser();
$adminCount = \models\Users::countAdmins();
?>

<h1>Користувачі</h1>
<a href="/MuseumShowcase/admin/profiles/create" class="btn btn-success mb-3">Додати користувача</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Ім'я користувача</th>
            <th>Email</th>
            <th>Роль</th>
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
                <td><?= htmlspecialchars($user->created_at) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/profiles/edit/<?= $user->id ?>" class="btn btn-primary btn-sm">Редагувати</a>

                    <?php
                        $isCurrentUser = $currentUser && $currentUser['id'] == $user->id;
                        $isLastAdmin = $user->role === 'admin' && $adminCount <= 1;
                        if (!$isCurrentUser && !$isLastAdmin):
                    ?>
                        <a href="/MuseumShowcase/admin/profiles/delete/<?= $user->id ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Видалити користувача?')">Видалити</a>
                    <?php else: ?>
                        <span class="text-muted">Видалення недоступне</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                   