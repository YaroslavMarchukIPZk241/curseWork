

<?php /** @var array $exhibits */ /** @var array $avgRatings */ ?>

<?php
file_put_contents(__DIR__.'/debug_view.txt', "Входить у view\n");
file_put_contents(__DIR__.'/debug_view.txt', print_r($exhibits, true), FILE_APPEND);
?>
<?php if (!empty($exhibits)): ?>
    <div class="exhibit-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <?php foreach ($exhibits as $exhibit): ?>
            <a href="/MuseumShowcase/exhibits/view/<?= $exhibit['id'] ?>" style="text-decoration: none; color: inherit;">
                <div class="exhibit-card"
                     style="border: 1px solid #ccc; padding: 10px; transition: box-shadow 0.2s; cursor: pointer;"
                     onmouseover="this.style.boxShadow='0 0 10px rgba(0,0,0,0.2)'"
                     onmouseout="this.style.boxShadow='none'">
                     
                    <img src="/<?= htmlspecialchars(str_replace('\\', '/', $exhibit['image_path'])) ?>"
                         alt="<?= htmlspecialchars($exhibit['title']) ?>"
                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover;"
                         onerror="this.src='/static/uploads/fallback.jpg';">

                    <h3><?= htmlspecialchars($exhibit['title']) ?></h3>
                    <p><?= htmlspecialchars(mb_strimwidth($exhibit['description'], 0, 100, "...")) ?></p>

                    <?php
                    $rating = $avgRatings[$exhibit['id']] ?? null;
                    if ($rating !== null) {
                        $rounded = round($rating * 2) / 2;
                        $fullStars = floor($rounded);
                        $halfStar = ($rounded - $fullStars) == 0.5 ? 1 : 0;
                        for ($i = 0; $i < $fullStars; $i++) echo '⭐';
                        if ($halfStar) echo '★';
                        echo " ($rating / 5)";
                    } else {
                        echo "<p>Рейтинг: ще немає</p>";
                    }
                    ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Наразі немає експонатів, що відповідають вибраним критеріям.</p>
<?php endif; ?>
