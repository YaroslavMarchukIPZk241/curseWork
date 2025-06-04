<h1>Редагувати період</h1>
<h1><?= isset($period) && $period->id ? 'Редагувати' : 'Створити' ?> період</h1>

<form method="post">
    <label>Назва</label><br>
    <input type="text" name="name" value="<?= isset($period) ? htmlspecialchars($period->name) : '' ?>" required><br><br>

    <label>Шлях до зображення</label><br>
    <input type="text" name="image_path" value="<?= isset($period) ? htmlspecialchars($period->image_path) : '' ?>"><br><br>

    <label>Опис періоду</label><br>
    <textarea name="DetailPeriod" required><?= isset($period) ? htmlspecialchars($period->DetailPeriod) : '' ?></textarea><br><br>

    <label>Час існування</label><br>
    <input type="text" name="TimePeriod" value="<?= isset($period) ? htmlspecialchars($period->TimePeriod) : '' ?>" required><br><br>

    <label>Секція</label><br>
    <input type="text" name="Section" value="<?= isset($period) ? htmlspecialchars($period->Section) : '' ?>"><br><br>

    <button type="submit">Зберегти</button>
</form>