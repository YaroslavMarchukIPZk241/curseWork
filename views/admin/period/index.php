<h1>Історичні періоди</h1>

<a href="/MuseumShowcase/admin/period/create">Створити новий період</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Час</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($periods as $period): ?>
            <tr>
                <td><?= htmlspecialchars($period->id) ?></td>
                <td><?= htmlspecialchars($period->name) ?></td>
                <td><?= htmlspecialchars($period->TimePeriod) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/period/edit/<?= htmlspecialchars($period->id) ?>">Редагувати</a> |
                    <a href="/MuseumShowcase/admin/period/delete/<?= htmlspecialchars($period->id) ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>