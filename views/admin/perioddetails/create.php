<?php /** @var int $periodId */ ?>

<h2>Додати подію до епохи #<?= $periodId ?></h2>

<form method="post" class="mt-4">
    <div class="mb-3">
        <label for="name" class="form-label">Назва події</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="link" class="form-label">Посилання (YouTube або зображення)</label>
        <input type="url" class="form-control" id="link" name="link">
    </div>

    <div class="mb-3">
        <label for="information" class="form-label">Опис</label>
        <textarea class="form-control" id="information" name="information" rows="5" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Додати</button>
    <a href="/MuseumShowcase/admin/perioddetails/index/<?= $periodId ?>" class="btn btn-secondary">Скасувати</a>
</form>
