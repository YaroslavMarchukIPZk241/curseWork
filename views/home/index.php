<?php
use core\Core;
use models\Exhibits;

$this->Title = 'Головна';
$db = Core::get()->db;
$featuredExhibits = $db->select('exhibits', '*', ['is_featured' => 1]);
?>

<!-- Слайдер -->
<?php if (count($featuredExhibits) > 0): ?>
<div class="main-carousel" data-flickity='{ "wrapAround": true, "autoPlay": 5000, "pageDots": false }'>
  <?php foreach ($featuredExhibits as $exhibit): ?>
    <?php
      $image = !empty($exhibit['image_path']) 
       ? "/" . ltrim(htmlspecialchars($exhibit['image_path']), '/') 
          : '/MuseumShowcase/static/images/default.jpg';
      $title = htmlspecialchars($exhibit['title'] ?? 'Без назви');
      $description = htmlspecialchars(mb_substr($exhibit['description'] ?? '', 0, 120) . '...');
    ?>
    <div class="carousel-cell">
      <img src="<?= $image ?>" alt="<?= $title ?>">
      <div class="carousel-caption">
        <h5><?= $title ?></h5>
        <p><?= $description ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
  <p class="text-center text-muted mt-4">Немає рекомендованих експонатів.</p>
<?php endif; ?>

<blockquote>
</blockquote>
<!-- Інформація про музей -->
<section class="mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Ласкаво просимо до нашого музею</h2>
        <p>Наш музей — це місце, де історія оживає! У нас зібрані унікальні експонати, що відображають багатовікову історію людства, культури, мистецтва та науки. Від стародавньої зброї до витворів мистецтва та статуй — кожен знайде щось цікаве.</p>
        <p>Заснований у 1923 році, наш музей щороку приймає тисячі відвідувачів з усього світу.</p>
      </div>
      <div class="col-md-6">
        <img src="static\uploads\museam.jpg" class="img-fluid rounded shadow" alt="Музей">
      </div>
    </div>
  </div>
</section>

<!-- Переваги -->
<section class="bg-light py-5">
  <div class="container">
    <h3 class="text-center mb-4">Чому обирають наш музей?</h3>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <div class="card-body">
            <i class="bi bi-star-fill text-warning fs-3"></i>
            <h5 class="card-title mt-2">Унікальні експонати</h5>
            <p class="card-text">Понад 10 000 експонатів, включаючи рідкісні артефакти, доступні до перегляду кожному відвідувачу.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <div class="card-body">
            <i class="bi bi-people-fill text-primary fs-3"></i>
            <h5 class="card-title mt-2">Інтерактивні тури</h5>
            <p class="card-text">Сучасні технології допоможуть вам зануритися в атмосферу минулого через AR/VR досвід.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <div class="card-body">
            <i class="bi bi-shield-lock-fill text-danger fs-3"></i>
            <h5 class="card-title mt-2">Безпека та комфорт</h5>
            <p class="card-text">Сучасна система охорони, зручні приміщення, доступність для людей з інвалідністю.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Завершальний блок -->
<section class="py-5">
  <div class="container text-center">
    <h4>Приходьте до нас та відкрийте для себе нове!</h4>
    <p class="lead">Ми раді кожному відвідувачу — маленькому чи дорослому, школяру чи професору!</p>
    <a href="/MuseumShowcase/exhibits" class="btn btn-primary btn-lg mt-3">Переглянути всі експонати</a>
  </div>
</section>