<div class="exhibit-container">
    <h1><?= htmlspecialchars($exhibit->title) ?></h1>
    <img src="/<?= htmlspecialchars($exhibit->image_path) ?>" alt="<?= htmlspecialchars($exhibit->title) ?>">
    <p><strong>Опис:</strong> <?= nl2br(htmlspecialchars($exhibit->description)) ?></p>

    <?php if (!empty($exhibit->location)): ?>
        <p><strong>Локація знахідки:</strong> <?= htmlspecialchars($exhibit->location) ?></p>
    <?php endif; ?>
<?php if (isset($exhibit->who_found) && trim($exhibit->who_found) !== ''): ?>
    <p><strong>Хто виявив:</strong> <?= htmlspecialchars($exhibit->who_found) ?></p>
<?php endif; ?>
    <!-- ⭐ Форма оцінки -->
    <form id="rating-form" data-exhibit-id="<?= $exhibit->id ?>">
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

    <div id="rating-message" style="margin-top: 10px; color: green;"></div>

    <h2>Відгуки користувачів</h2>

    <?php if (!empty($reviews)): ?>
        <div class="reviews">
            <?php foreach ($reviews as $review): ?>
                <div class="review-card" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                    <strong><?= htmlspecialchars($review->username ?? 'Анонім') ?></strong>
                    <div>Оцінка: <?= str_repeat('⭐', (float)$review->rating) ?> (<?= $review->rating ?>/5)</div>
                    <?php if (!empty($review->comment)): ?>
                        <p><?= nl2br(htmlspecialchars($review->comment)) ?></p>
                    <?php else: ?>
                        <p><em>Без коментаря</em></p>
                    <?php endif; ?>
                    <div style="font-size: 0.8em; color: #888;">
                        <?= date('d.m.Y H:i', strtotime($review->created_at)) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Поки що немає жодного відгуку. Будь першим!</p>
    <?php endif; ?>
</div>