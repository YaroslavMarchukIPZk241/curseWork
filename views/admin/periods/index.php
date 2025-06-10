<h1>Історичні періоди</h1>

<a href="/MuseumShowcase/admin/periods/create" class="btn btn-success mb-3">Створити новий період</a>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>події епохи</th>
            <th>Назва</th>
            <th>Час</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($periods as $period): ?>
            <tr>
                <td><?= htmlspecialchars($period->id) ?></td>
                <td><a href="/MuseumShowcase/admin/perioddetails/index/<?= htmlspecialchars($period->id) ?>" class="btn btn-info btn-sm">Події Епохи</a></td> 
                <td><?= htmlspecialchars($period->name) ?></td>
                <td><?= htmlspecialchars($period->TimePeriod) ?></td>
                <td>                
                    <a href="/MuseumShowcase/admin/periods/edit/<?= htmlspecialchars($period->id) ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/periods/delete/<?= htmlspecialchars($period->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
