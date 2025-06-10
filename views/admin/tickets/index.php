<h1>Квитки</h1>
<a href="/MuseumShowcase/admin/tickets/create" class="btn btn-success mb-3">Додати квиток</a>

<table class="table table-striped table-bordered table-hover mb-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th style="text-align: right;">Ціна</th>
            <th>Опис</th>
            <th>Доступний з</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket->id) ?></td>
                <td><?= htmlspecialchars($ticket->title) ?></td>
                <td style="text-align: right; white-space: nowrap;"><?= htmlspecialchars(number_format($ticket->price, 2)) ?> <span style="font-weight: normal;">грн</span></td>
                <td><?= nl2br(htmlspecialchars($ticket->description)) ?></td>
                <td><?= htmlspecialchars($ticket->available_at) ?></td>
                <td>
                    <a href="/MuseumShowcase/admin/tickets/edit/<?= $ticket->id ?>" class="btn btn-primary btn-sm">Редагувати</a>
                    <a href="/MuseumShowcase/admin/tickets/delete/<?= $ticket->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити квиток?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>