<?php /** @var models\InformationPeriod $detail */ ?>

<h2>Редагувати подію #<?= $detail->id ?></h2>

<form method="post" class="mt-4">
    <div class="mb-3">
        <label for="name" class="form-label">Назва події</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($detail->name) ?>" required>
    </div>

    <div class="mb-3">
        <label for="link" class="form-label">Посилання (YouTube або зображення)</label>
        <input type="url" class="form-control" id="link" name="link" value="<?= htmlspecialchars($detail->link) ?>">
    </div>

    <div class="mb-3">
        <label for="information" class="form-label">Опис</label>
        <textarea class="form-control" id="information" name="information" rows="5" required><?= htmlspecialchars($detail->information) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
     <a href="/MuseumShowcase/admin/perioddetails/index/<?= $detail->Period_id ?>" class="btn btn-primary btn-sm">Скасувати</a>
</form>
