<h1>Редагувати експонат</h1>

<form method="post" enctype="multipart/form-data">
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
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($exhibit->location) ?>">
    </div>

    <div class="form-group">
        <label>Хто знайшов</label>
        <input type="text" name="who_found" class="form-control" value="<?= htmlspecialchars($exhibit->who_found) ?>">
    </div>

    <div class="form-group">
        <label>Популярний?</label>
        <input type="checkbox" name="is_featured" value="1" <?= $exhibit->is_featured ? 'checked' : '' ?>>
    </div>

    <div class="form-group">
        <label>Поточне зображення</label><br>
        <?php if ($exhibit->image_path): ?>
            <img src="<?= htmlspecialchars($exhibit->image_path) ?>" alt="img" style="max-width: 100px;">
        <?php else: ?>
            <span>Зображення відсутнє</span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Завантажити нове зображення</label>
        <input type="file" name="image" accept="image/*" class="form-control">
    </div>

    <div class="form-group">
        <label>Або виберіть існуюче зображення</label>
        <select name="existing_image" class="form-control">
            <option value="">-- Не вибрано --</option>
            <?php
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . 'MuseumShowcase/static/uploads/Exponat/';
            $files = is_dir($uploadDir) ? scandir($uploadDir) : [];
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif'])) {
                    $selected = ($exhibit->image_path && strpos($exhibit->image_path, $file) !== false) ? 'selected' : '';
                    echo "<option value=\"$file\" $selected>$file</option>";
                }
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Оновити</button>
</form>
