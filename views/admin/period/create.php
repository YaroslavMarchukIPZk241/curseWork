<h1><?= isset($period) ? 'Редагувати' : 'Створити' ?> період</h1>
<form method="post">
    <label>Назва</label>
    <input type="text" name="name" value="<?= $period['name'] ?? '' ?>"><br>

    <label>Шлях до зображення</label>
    <input type="text" name="image_path" value="<?= $period['image_path'] ?? '' ?>"><br>

    <label>Опис періоду</label>
    <input type="text" name="DetailPeriod" value="<?= $period['DetailPeriod'] ?? '' ?>"><br>

    <label>Час існування</label>
    <input type="text" name="TimePeriod" value="<?= $period['TimePeriod'] ?? '' ?>"><br>

    <label>Секція</label>
    <input type="text" name="Section" value="<?= $period['Section'] ?? '' ?>"><br>

    <button type="submit">Зберегти</button>
</form>
