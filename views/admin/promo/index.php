<h1>Промокоди</h1>

<table class="table table-striped table-bordered table-hover mb-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Знижка</th>
            <th>Ліміт використань</th>
            <th>Дійсний до</th>
            <th>Статус</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($promoCodes as $promo): ?>
            <tr>
                <td><?= htmlspecialchars($promo->id) ?></td>
                <td><?= htmlspecialchars($promo->name) ?></td>
                <td><?= htmlspecialchars($promo->discount_percentage) ?>%</td>
                <td><?= htmlspecialchars($promo->limit_users) ?></td>
                <td><?= htmlspecialchars($promo->expires_at) ?></td>
                <td>
                    <?php if ($promo->isActive()): ?>
                        <span class="badge bg-success">Активний</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Неактивний</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>