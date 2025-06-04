<h1>Список експонатів</h1>
<a href="admin/exhibits/create" class="btn btn-success">Додати експонат</a>

<table class="table">
    <thead>
        <tr>
            <th>Назва</th>
            <th>Категорія</th>
            <th>Період</th>
            <th>Локація</th>
            <th>Зображення</th>
            <th>Популярний</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($exhibits as $exhibit): ?>
            <tr>
                <td><?= htmlspecialchars($exhibit->title) ?></td>
                <td><?= $categories[$exhibit->category_id] ?? '—' ?></td>
                <td><?= $periods[$exhibit->period_id] ?? '—' ?></td>
                <td><?= htmlspecialchars($exhibit->location) ?></td>
                <td>
                    <?php if ($exhibit->image_path): ?>
                        <img src="<?= $exhibit->image_path ?>" alt="img" width="50">
                    <?php endif; ?>
                </td>
                <td><?= $exhibit->is_featured ? 'Так' : 'Ні' ?></td>
                <td>
                    <a href="admin/exhibits/edit/<?= $exhibit->id ?>" class="btn btn-sm btn-primary">Редагувати</a>
                    <a href="admin/exhibits/delete/<?= $exhibit->id ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>