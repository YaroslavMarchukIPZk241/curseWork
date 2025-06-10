<h1>Список експонатів</h1>

<a href="/MuseumShowcase/admin/exhibits/create" class="btn btn-success mb-3">Додати експонат</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Назва</th>
            <th>Коментарі</th>
            <th>Період</th>
            <th>Зображення</th>
            <th>Популярний</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($exhibits as $exhibit): ?>
            <tr>
                <td><?= htmlspecialchars($exhibit->title) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/reviews/index/<?= $exhibit->id ?>" class="btn btn-info btn-sm">
                        Керувати коментарями
                    </a>
                </td>
                <td><?= htmlspecialchars($periods[$exhibit->period_id] ?? '—') ?></td>
                
                <td>
    <?php if (!empty($exhibit->image_path)): ?>
        <img src="/<?= htmlspecialchars($exhibit->image_path) ?>" alt="зображення" width="100" style="object-fit: contain;">
    <?php else: ?>
        —
    <?php endif; ?>
</td>
                <td><?= $exhibit->is_featured ? 'Так' : 'Ні' ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/exhibits/edit/<?= $exhibit->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/exhibits/delete/<?= $exhibit->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>