<div class="exhibit-container">
    <h1><?= htmlspecialchars($exhibit->title) ?></h1>
    <img src="/<?= htmlspecialchars($exhibit->image_path) ?>" alt="<?= htmlspecialchars($exhibit->title) ?>">
    <p><strong>Опис:</strong> <?= nl2br(htmlspecialchars($exhibit->description)) ?></p>

    <?php if (!empty($exhibit->location)): ?>
        <p><strong>Локація знахідки:</strong> <?= htmlspecialchars($exhibit->location) ?></p>
    <?php endif; ?>

    <?php if (!empty(trim($exhibit->who_found))): ?>
        <p><strong>Хто виявив:</strong> <?= htmlspecialchars($exhibit->who_found) ?></p>
    <?php endif; ?>

    <!-- ⭐ Форма оцінки -->
    <form id="review-form" data-exhibit-id="<?= $exhibit->id ?>">
        <label>Оцініть експонат:</label><br>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label>
                <input type="radio" name="rating" value="<?= $i ?>" required>
                <?= $i ?>
            </label>
        <?php endfor; ?>

        <br><br>
        <textarea name="comment" placeholder="Ваш коментар (необов’язково)"></textarea><br><br>

        <button type="submit">Надіслати оцінку</button>
    </form>

    <div id="review-message" style="margin-top: 10px; color: green;"></div>

    <h2>Відгуки користувачів</h2>
    <div id="reviews-container" data-exhibit-id="<?= $exhibit->id ?>"></div>
</div>