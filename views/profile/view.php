<?php /** @var array $user */ ?>
<h1>Мій профіль</h1>
<ul class="list-group">
    <li class="list-group-item">Логін: <?=htmlspecialchars($user['username'])?></li>
    <li class="list-group-item">Email: <?=htmlspecialchars($user['email'])?></li>
    <li class="list-group-item">Бонус-код: <?=htmlspecialchars($user['bonus_code'])?></li>
</ul>
<a class="btn btn-primary mt-3" href="/MuseumShowcase/profile/edit">Редагувати профіль</a>