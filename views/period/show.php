
<?php
use core\Core;

/** @var array $period */
/** @var array $exhibits */
/** @var array $avgRatings */
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
            <a href="/MuseumShowcase/period/detail/<?= $period['id'] ?>" class="btn btn-primary">Детальніше про епоху</a>
            <a href="/MuseumShowcase/period" class="btn btn-secondary">← До списку епох</a>
        </div>
    </div>
</div>

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
    <input type="text" name="search" id="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Назва експоната">
    <button type="submit" class="btn btn-primary">Застосувати</button>
</form>

<?php if (!empty($exhibits)): ?>
    <div class="exhibit-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <?php foreach ($exhibits as $exhibit): ?>
          <?php
$imagePath = '/museumShowcase/static/uploads/Exponat/' . basename($exhibit['image_path'] ?? '');
$absolutePath = $_SERVER['DOCUMENT_ROOT'] . '/museumShowcase/static/uploads/Exponat/' . basename($exhibit['image_path'] ?? '');

if (empty($exhibit['image_path']) || !file_exists($absolutePath)) {
    $imagePath = '/museumShowcase/assets/img/fallback.jpg';
}
?>

<a href="/MuseumShowcase/exhibits/view/<?= $exhibit['id'] ?>" style="text-decoration: none; color: inherit;">
    <div class="exhibit-card"
        style="border: 1px solid #ccc; padding: 10px; transition: box-shadow 0.2s; cursor: pointer;"
        onmouseover="this.style.boxShadow='0 0 10px rgba(0,0,0,0.2)'" onmouseout="this.style.boxShadow='none'">

        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($exhibit['title'] ?? 'Назва відсутня') ?>" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">

        <h3><?= !empty($exhibit['title']) ? htmlspecialchars($exhibit['title']) : 'Назва відсутня' ?></h3>

        <p><?= !empty($exhibit['description']) 
                ? htmlspecialchars(mb_strimwidth($exhibit['description'], 0, 100, "...")) 
                : 'Опис відсутній.' ?>
        </p>

        <p>
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
                echo "Рейтинг: ще немає";
            }
        ?>
        </p>
    </div>
</a>
        <?php endforeach; ?>
    </div>

     <?php if ($totalPages > 1): ?>
        <div class="pagination home-periods-page" style="margin-top: 30px; text-align: center;">
    <?php
    $range = 2;
    $baseUrl = "/MuseumShowcase/period/show/{$period['id']}?";
    $query = [];

    if (!empty($_GET['category_id'])) $query['category_id'] = $_GET['category_id'];
    if (!empty($_GET['search'])) $query['search'] = $_GET['search'];

    $queryString = fn($page) => http_build_query(array_merge($query, ['page' => $page]));

    // Перша сторінка
    echo ($page == 1)
        ? "<strong>1</strong> "
        : "<a href='{$baseUrl}{$queryString(1)}'>1</a> ";

    // Три крапки
    if ($page > $range + 2) echo "... ";

    // Проміжні сторінки
    for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) {
        echo ($i == $page)
            ? "<strong>$i</strong> "
            : "<a href='{$baseUrl}{$queryString($i)}'>$i</a> ";
    }

    // Три крапки
    if ($page < $totalPages - $range - 1) echo "... ";

    // Остання сторінка
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
