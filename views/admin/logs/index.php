<h1>Логи</h1>

<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Пошук...">
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Action</th>
            <th>IP</th>
            <th>Дата</th>
            <th>Method</th>
            <th>URI</th>
            <th>Детальніше</th>
        </tr>
    </thead>
    <tbody id="logsTableBody">
        <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log->id) ?></td>
                    <td><?= htmlspecialchars($log->user_id) ?></td>
                    <td><?= htmlspecialchars($log->action) ?></td>
                    <td><?= htmlspecialchars($log->ip_address) ?></td>
                    <td><?= htmlspecialchars($log->created_at) ?></td>
                    <td><?= htmlspecialchars($log->method) ?></td>
                    <td><?= htmlspecialchars($log->uri) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="alert(`<?= addslashes($log->message ?? '') ?>`)">
                            Переглянути
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">Логів не знайдено.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
    <div class="pagination mt-4">
        <?php
        $range = 2;
        if ($page == 1)
            echo "<strong>1</strong> ";
        else
            echo "<a href='/MuseumShowcase/admin/logs/index/1'>1</a> ";

        if ($page > $range + 2) echo "... ";

        for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) {
            if ($i == $page)
                echo "<strong>$i</strong> ";
            else
                echo "<a href='/MuseumShowcase/admin/logs/index/$i'>$i</a> ";
        }

        if ($page < $totalPages - $range - 1) echo "... ";

        if ($totalPages > 1) {
            if ($page == $totalPages)
                echo "<strong>$totalPages</strong>";
            else
                echo "<a href='/MuseumShowcase/admin/logs/index/$totalPages'>$totalPages</a>";
        }
        ?>
    </div>
<?php endif; ?>