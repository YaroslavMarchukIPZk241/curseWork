<?php
use core\Core;

/** @var array $period - дані поточної епохи */
/** @var array $exhibits - експонати цієї епохи */
/** @var array $avgRatings - середні рейтинги експонатів */
/** @var array $categories */
/** @var int $page */
/** @var int $totalPages */

$this->Title = $period['name'];
?>

<div class="period-header">
    <h1 class="period-title"><?= htmlspecialchars($period['name']) ?></h1>

    <div class="period-info">
        <p class="period-time"><strong>Період:</strong> <?= htmlspecialchars($period['TimePeriod']) ?></p>

        <div class="period-buttons">
            <a href="/MuseumShowcase/period/detail/<?= $period['id'] ?>" class="btn btn-primary">Детальніше про
                епоху</a>
            <a href="/MuseumShowcase/period" class="btn btn-secondary">← До списку епох</a>
        </div>
    </div>
</div>

<p></p>

<form method="get" class="filter-form">
    <label for="category_id">Категорія:</label>
    <select name="category_id" id="category_id">
        <option value="">Усі категорії</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>" <?= ($category['id'] == ($_GET['category_id'] ?? '')) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="search">Пошук:</label>
    <input type="text" name="search" id="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        placeholder="Назва експоната">

    <button type="submit" class="btn btn-primary">Застосувати</button>
</form>

<?php if (!empty($exhibits)): ?>
    <div class="exhibit-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <?php foreach ($exhibits as $exhibit): ?>
            <a href="/MuseumShowcase/exhibits/view/<?= $exhibit['id'] ?>" style="text-decoration: none; color: inherit;">
                <div class="exhibit-card"
                    style="border: 1px solid #ccc; padding: 10px; transition: box-shadow 0.2s; cursor: pointer;"
                    onmouseover="this.style.boxShadow='0 0 10px rgba(0,0,0,0.2)'" onmouseout="this.style.boxShadow='none'">
                    <img src="/<?= htmlspecialchars($exhibit['image_path']) ?>" alt="<?= htmlspecialchars($exhibit['title']) ?>"
                        style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                    <h3><?= htmlspecialchars($exhibit['title']) ?></h3>
                    <p><?= htmlspecialchars(mb_strimwidth($exhibit['description'], 0, 100, "...")) ?></p>

                    <?php
                   $rating = $avgRatings[$exhibit['id']] ?? null;
if ($rating !== null) {
    $rounded = round($rating * 2) / 2;
    $fullStars = floor($rounded);
    $halfStar = ($rounded - $fullStars) == 0.5 ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;
    for ($i = 0; $i < $fullStars; $i++) {
        echo '⭐';
    }
    if ($halfStar) {
        echo '★'; 
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        echo '';
    }
    echo " ($rating / 5)";
    echo '</p>';
} else {
    echo "<p>Рейтинг: ще немає</p>";
}

                    ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="pagination" style="margin-top: 20px;">
            <?php
            $range = 2;
            $baseUrl = "/MuseumShowcase/period/show/{$period['id']}?";
            $query = [];

            if (!empty($_GET['category_id'])) {
                $query['category_id'] = $_GET['category_id'];
            }
            if (!empty($_GET['search'])) {
                $query['search'] = $_GET['search'];
            }

            $queryString = function ($page) use ($query) {
                $query['page'] = $page;
                return http_build_query($query);
            };

            echo ($page == 1)
                ? "<strong>1</strong> "
                : "<a href='{$baseUrl}{$queryString(1)}'>1</a> ";

            if ($page > $range + 2)
                echo "... ";

            for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) {
                if ($i == $page)
                    echo "<strong>$i</strong> ";
                else
                    echo "<a href='{$baseUrl}{$queryString($i)}'>$i</a> ";
            }

            if ($page < $totalPages - $range - 1)
                echo "... ";

            if ($totalPages > 1) {
                echo ($page == $totalPages)
                    ? "<strong>$totalPages</strong>"
                    : "<a href='{$baseUrl}{$queryString($totalPages)}'>$totalPages</a>";
            }
            ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>Наразі немає експонатів, що відповідають вибраним критеріям.</p>
<?php endif; ?>