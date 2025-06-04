<h1>Редагувати експонат</h1>

<form method="post">
    <div class="form-group">
        <label>Назва</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($exhibit->title) ?>" required>
    </div>

    <div class="form-group">
        <label>Опис</label>
        <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($exhibit->description) ?></textarea>
    </div>

    <div class="form-group">
        <label>Категорія</label>
        <select name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= $category->id == $exhibit->category_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Період</label>
        <select name="period_id" class="form-control" required>
            <?php foreach ($periods as $period): ?>
                <option value="<?= $period->id ?>" <?= $period->id == $exhibit->period_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($period->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Локація</label>
        <textarea name="location" class="form-control" rows="2"><?= htmlspecialchars($exhibit->location) ?></textarea>
    </div>

    <div class="form-group">
        <label>Хто знайшов</label>
        <textarea name="who_found" class="form-control" rows="2"><?= htmlspecialchars($exhibit->who_found) ?></textarea>
    </div>

    <div class="form-group">
        <label>Популярний?</label>
        <input type="checkbox" name="is_featured" value="1" <?= $exhibit->is_featured ? 'checked' : '' ?>>
    </div>

    <div class="form-group">
        <label>Зображення (шлях)</label>
        <textarea name="image_path" class="form-control" rows="2"><?= $exhibit->image_path ? htmlspecialchars($exhibit->image_path) : '' ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Оновити</button>
</form>
