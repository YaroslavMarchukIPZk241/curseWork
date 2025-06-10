<?php
/** @var models\InformationPeriod[] $details */
/** @var int $periodId */
?>

<h1>Події <?= $periodId !== null ? "для епохи ID: " . htmlspecialchars((string)$periodId) : "для всіх епох" ?></h1>
<a href="/MuseumShowcase/admin/perioddetails/error" class="btn btn-warning mb-3">фальсифікувати історію 🤯</a>
<?php if (!empty($showAddButton)): ?>
    <?php if (!empty($showAddButton)): ?>
    <a href="/MuseumShowcase/admin/perioddetails/create/<?= $periodId ?>" class="btn btn-success mb-3">
        Додати подію
    </a>
<?php endif; ?>
<?php endif; ?>
<?php if (empty($details)): ?>
    <div class="alert alert-info">Наразі подій для цієї епохи не додано.</div>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Медіа</th>
                <th>Опис</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= htmlspecialchars($detail->id) ?></td>
                    <td><?= htmlspecialchars($detail->name) ?></td>
                    <td>
                        <?php if (!empty($detail->link)): ?>
                            <a href="<?= htmlspecialchars($detail->link) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                Переглянути
                            </a>
                        <?php else: ?>
                            <span class="text-muted">немає</span>
                        <?php endif; ?>
                    </td>
                    <td style="max-width: 300px; overflow-wrap: break-word;">
                        <?= nl2br(htmlspecialchars(mb_strimwidth($detail->information, 0, 100, '...'))) ?>
                    </td>
                    <td>
                        <a href="/MuseumShowcase/admin/perioddetails/edit/<?= $detail->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                        <a href="/MuseumShowcase/admin/perioddetails/delete/<?= $detail->id ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Ви дійсно хочете видалити цю подію?')">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<a href="/MuseumShowcase/admin/periods" class="btn btn-secondary mt-3">← Назад до списку епох</a>
