<?php
use core\Core;
use models\Exhibits;

$this->Title = 'Головна';
$db = Core::get()->db;
?>

<div class="home-periods-page">
    <h1>Історичні епохи</h1>

    <?php if (!empty($periods)): ?>
        <div class="periods-grid">
            <?php foreach ($periods as $period): ?>
                <?php
                    $imageFileName = basename($period['image_path'] ?? '');
                    $relativePath = "/museumShowcase/static/uploads/Epoch/" . $imageFileName;
                    $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $relativePath;

                    $imagePath = (empty($period['image_path']) || !file_exists($absolutePath))
                        ? '/museumShowcase/assets/img/fallback.jpg'
                        : $relativePath;
                ?>
                <div class="period-card" onclick="location.href='/MuseumShowcase/period/show/<?= $period['id'] ?>'">
                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($period['name'] ?? 'Назва епохи відсутня') ?>">
                    <h3><?= !empty($period['name']) ? htmlspecialchars($period['name']) : 'Назва епохи відсутня' ?></h3>
                    <h6><?= !empty($period['Section']) ? htmlspecialchars($period['Section']) : 'Місце знаходження відсутнє' ?></h6>
                    <p><?= !empty($period['TimePeriod']) ? htmlspecialchars($period['TimePeriod']) : 'Період відсутній' ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php
                $range = 2;
                if ($page == 1)
                    echo "<strong>1</strong> ";
                else
                    echo "<a href='/MuseumShowcase/period/index/1'>1</a> ";
                if ($page > $range + 2) echo "... ";
                for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) {
                    if ($i == $page)
                        echo "<strong>$i</strong> ";
                    else
                        echo "<a href='/MuseumShowcase/period/index/$i'>$i</a> ";
                }
                if ($page < $totalPages - $range - 1) echo "... ";
                if ($totalPages > 1) {
                    if ($page == $totalPages)
                        echo "<strong>$totalPages</strong>";
                    else
                        echo "<a href='/MuseumShowcase/period/index/$totalPages'>$totalPages</a>";
                }
                ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Наразі історичних епох не знайдено. Спробуйте пізніше.</p>
    <?php endif; ?>
</div>
