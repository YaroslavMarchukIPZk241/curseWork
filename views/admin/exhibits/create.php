<h1>Додати експонат</h1>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Назва</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Опис</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>Категорія</label>
        <select name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Період</label>
        <select name="period_id" class="form-control" required>
            <?php foreach ($periods as $period): ?>
                <option value="<?= $period->id ?>"><?= htmlspecialchars($period->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Локація</label>
        <input type="text" name="location" class="form-control">
    </div>

    <div class="form-group">
        <label>Хто знайшов</label>
        <input type="text" name="who_found" class="form-control">
    </div>

    <div class="form-group">
        <label>Популярний?</label>
        <input type="checkbox" name="is_featured" value="1">
    </div>

    <div class="form-group">
        <label>Зображення (шлях)</label>
        <input type="text" name="image_path" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>
