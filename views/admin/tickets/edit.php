<h1>Редагувати квиток</h1>

<form method="post">
    <div class="mb-3">
        <label for="title" class="form-label">Назва</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($ticket->title) ?>" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Ціна (грн)</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= htmlspecialchars($ticket->price) ?>" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Опис</label>
        <textarea name="description" id="description" rows="5" class="form-control" required><?= htmlspecialchars($ticket->description) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="available_at" class="form-label">Доступний з</label>
        <input type="date" name="available_at" id="available_at" class="form-control" value="<?= htmlspecialchars($ticket->available_at) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Зберегти</button>
    <a href="/MuseumShowcase/admin/tickets" class="btn btn-secondary">Скасувати</a>
</form>
