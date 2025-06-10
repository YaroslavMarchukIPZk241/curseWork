<h1>Створити новий період</h1>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Назва</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Шлях до зображення</label>
        <input type="text" name="image_path" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Опис періоду</label>
        <textarea name="DetailPeriod" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Час існування</label>
        <input type="text" name="TimePeriod" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Секція</label>
        <input type="text" name="Section" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Створити</button>
</form>
