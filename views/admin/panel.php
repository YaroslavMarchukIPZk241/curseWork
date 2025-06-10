<?php
$baseUrl = '/MuseumShowcase';
?>

<h1 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Адмін-панель</h1>

<div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; max-width: 600px; margin: auto;">
    <a href="<?= $baseUrl ?>/admin/profiles/index" class="btn btn-primary">Користувачі</a>
    <a href="<?= $baseUrl ?>/admin/categories/index" class="btn btn-primary">Категорії</a>
    <a href="<?= $baseUrl ?>/admin/periods/index" class="btn btn-primary">Епохи</a>
    <a href="<?= $baseUrl ?>/admin/exhibits/index" class="btn btn-primary">Експонати</a>
    <a href="<?= $baseUrl ?>/admin/tickets/index" class="btn btn-primary">Квитки</a>
    <a href="<?= $baseUrl ?>/admin/perioddetails/index" class="btn btn-primary">Події епохи</a>
    <a href="<?= $baseUrl ?>/admin/promoCode/index" class="btn btn-primary">Список активувань промокодів</a>
    <a href="<?= $baseUrl ?>/admin/promoCode/index" class="btn btn-primary">Промокоди</a>
    <a href="<?= $baseUrl ?>/admin/logs/index" class="btn btn-primary">Логи</a>
</div>

<hr style="margin: 30px 0; border: 1px solid #ccc;">

<div style="display: flex; justify-content: space-between; align-items: center; max-width: 600px; margin: auto;">
    <h2 style="font-size: 20px;">Аналітика</h2>
    <a href="<?= $baseUrl ?>/admin/logs/statistics" class="btn btn-success">Статистика</a>
</div>

<hr style="margin: 30px 0; border: 1px solid #ccc;">

<div style="display: flex; justify-content: space-between; align-items: center; max-width: 600px; margin: auto;">
    <h2 style="font-size: 20px;">Управління промокодами</h2>
    <a href="<?= $baseUrl ?>/admin/promoCode/create" class="btn btn-warning">Створити промокод</a>
</div>
