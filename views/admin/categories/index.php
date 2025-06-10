<h1>Категорії</h1>

<a href="/MuseumShowcase/admin/categories/create" class="btn btn-success mb-3">Додати категорію</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
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
                    <a href="/MuseumShowcase/admin/categories/edit/<?= $category->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/categories/delete/<?= $category->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити категорію?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
