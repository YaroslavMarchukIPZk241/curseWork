<h1>Категорії</h1>
<a href="/MuseumShowcase/admin/category/create" class="btn btn-success">Додати категорію</a>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category->id) ?></td>
                <td><?= htmlspecialchars($category->name) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/category/edit/<?= $category->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/category/delete/<?= $category->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити категорію?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>