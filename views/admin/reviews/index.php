<h1>Коментарі до експоната #<?= htmlspecialchars($exhibitId) ?></h1>

<a href="/MuseumShowcase/admin/exhibits" class="btn btn-secondary mb-3">Повернутися до експонатів</a>

<?php if (empty($comments)): ?>
    <p>Коментарів ще немає.</p>
<?php else: ?>
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Автор</th>
                <th>ID користувача</th>
                <th>Текст</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= htmlspecialchars($comment->id) ?></td>
                    <td><?= htmlspecialchars($comment->username ?? 'Анонім') ?></td>
                    <td><?= htmlspecialchars($comment->user_id) ?></td>
                    <td><?= nl2br(htmlspecialchars($comment->comment)) ?></td>
                    <td><?= htmlspecialchars($comment->created_at) ?></td>
                    <td>
                        <a href="/MuseumShowcase/admin/reviews/delete/<?= $comment->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити цей коментар?')">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
