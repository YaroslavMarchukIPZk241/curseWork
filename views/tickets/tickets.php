<h1>Квитки на вхід</h1>
<div class="ticket-container">
    <?php foreach ($tickets as $ticket): ?>
        <?php
        // Розрахунок ціни зі знижкою для кожного квитка
        $ticketOriginalPrice = $ticket->price;
        $ticketDiscountedPrice = $ticket->price;
        $hasActivePromoForTicket = false;

        if (isset($activePromoCode) && $activePromoCode) {
            $ticketDiscountedPrice = $ticketOriginalPrice * (1 - $discountPercentage / 100);
            $hasActivePromoForTicket = true;
        }
        ?>
        <div class="ticket"
             onclick="openModal(
                 `<?= htmlspecialchars($ticket->title) ?>`,
                 `<?= nl2br(htmlspecialchars($ticket->description)) ?>`,
                 `<?= htmlspecialchars($ticketOriginalPrice) ?>`,
                 `<?= htmlspecialchars($ticketDiscountedPrice) ?>`,
                 `<?= htmlspecialchars($ticket->available_at) ?>`,
                 `<?= $hasActivePromoForTicket ? htmlspecialchars($activePromoCode->name) : '' ?>`,
                 `<?= $hasActivePromoForTicket ? htmlspecialchars($discountPercentage) : 0 ?>`
             )">
            <h3><?= htmlspecialchars($ticket->title) ?></h3>
            <p>
                <strong>Ціна:</strong>
                <?php if ($hasActivePromoForTicket): ?>
                    <span style="text-decoration: line-through; color: #999;"><?= number_format($ticketOriginalPrice, 2) ?></span>
                    <span style="color: green; font-weight: bold;">
                        <?= number_format($ticketDiscountedPrice, 2) ?>
                    </span> грн
                    <span class="discount-badge" style="background-color: #28a745; color: white; padding: 2px 5px; border-radius: 3px; font-size: 0.8em; margin-left: 5px;">
                        -<?= htmlspecialchars($discountPercentage) ?>%
                    </span>
                <?php else: ?>
                    <?= number_format($ticketOriginalPrice, 2) ?> грн
                <?php endif; ?>
            </p>
            <p><em>Доступно з:</em> <?= htmlspecialchars($ticket->available_at) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div id="ticketModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle"></h2>
        <p><strong>Ціна:</strong> <span id="modalPrice"></span> грн</p>
        <p><em>Доступно з:</em> <span id="modalDate"></span></p>
        <p id="modalDescription"></p>
        <p id="modalPromoInfo" style="display: none; color: green; font-weight: bold;"></p>
    </div>
</div>

<?php if (isset($activePromoCode) && $activePromoCode): ?>
    <div class="promo-info" style="text-align: center; margin-top: 30px; padding: 15px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724; border-radius: 8px;">
        <p style="margin: 0;">Ваш промокод "<strong><?= htmlspecialchars($activePromoCode->name) ?></strong>" активний!</p>
        <p style="margin: 5px 0 0 0;">Знижка: <?= htmlspecialchars($discountPercentage) ?>% діє до <?= date('d.m.Y H:i', strtotime($activePromoCode->expires_at)) ?></p>
    </div>
<?php endif; ?>




