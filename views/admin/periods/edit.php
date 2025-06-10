<h1>Редагувати період</h1>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Назва</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($period->name) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Шлях до зображення</label>
        <input type="text" name="image_path" class="form-control" value="<?= htmlspecialchars($period->image_path) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Опис періоду</label>
        <textarea name="DetailPeriod" class="form-control" rows="4" required><?= htmlspecialchars($period->DetailPeriod) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Час існування</label>
        <input type="text" name="TimePeriod" class="form-control" value="<?= htmlspecialchars($period->TimePeriod) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Секція</label>
        <input type="text" name="Section" class="form-control" value="<?= htmlspecialchars($period->Section) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>