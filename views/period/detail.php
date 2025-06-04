<?php
/** @var models\Period $period - поточна епоха */
/** @var models\InformationPeriod[] $events - події цієї епохи */

$this->Title = "Деталі: " . $period->name;
?>

<div class="period-detail-container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h1 style="font-size: 2rem; margin-bottom: 10px;"><?= htmlspecialchars($period->name) ?></h1>
    <p style="font-size: 1.1rem; color: #555;"><?= nl2br(htmlspecialchars($period->DetailPeriod)) ?></p>

    <hr style="margin: 30px 0;">

    <h2 style="margin-bottom: 20px;">Події цієї епохи:</h2>

    <?php if (!empty($events)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
            <?php foreach ($events as $event): ?>
                <div style="background-color: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <?php if (strpos($event->link, 'youtube.com') !== false || strpos($event->link, 'youtu.be') !== false): ?>
                        <div style="aspect-ratio: 16/9;">
                            <iframe width="100%" height="100%" src="<?= htmlspecialchars($event->link) ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <img src="/<?= htmlspecialchars($event->link) ?>" alt="<?= htmlspecialchars($event->name) ?>" style="width: 100%; height: 180px; object-fit: cover;">
                    <?php endif; ?>
                    <div style="padding: 15px;">
                        <h3 style="font-size: 1.2rem; color: #2c3e50;"><?= htmlspecialchars($event->name) ?></h3>
                        <p style="font-size: 0.95rem; color: #7f8c8d;"><?= nl2br(htmlspecialchars($event->information)) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Подій для цієї епохи ще не додано.</p>
    <?php endif; ?>

    <div style="margin-top: 30px;">
        <a href="/MuseumShowcase/period" style="padding: 10px 18px; background-color: #2c3e50; color: white; border-radius: 6px; text-decoration: none;">← Назад до списку епох</a>
    </div>
</div>
