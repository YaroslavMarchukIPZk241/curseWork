<h1>Редагувати категорію</h1>
<form method="post">
    Назва категорії: 
    <input type="text" name="name" value="<?php echo htmlspecialchars($category->name); ?>" />
    <button type="submit">Зберегти</button>
</form>