<?php
$this->title = 'Мої промокоди';
$this->params['breadcrumbs'] = [
    ['label' => 'Профіль', 'url' => '/profile'],
    ['label' => $this->title],
];
?>

<div class="profile-promo">
    <h1>Мої промокоди</h1>

    <?php if (!empty($promoCodesHistory)): ?>
        <div class="promo-history">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Промокод</th>
                            <th>Знижка</th>
                            <th>Статус</th>
                            <th>Термін дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promoCodesHistory as $promo): ?>
                            <?php 
                            $isActive = strtotime($promo->expires_at) > time();
                            $statusClass = $isActive ? 'text-success' : 'text-muted';
                            $statusText = $isActive ? 'Активний' : 'Неактивний';
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($promo->name) ?></strong></td>
                                <td><?= $promo->discount_percentage ?>%</td>
                                <td class="<?= $statusClass ?>"><?= $statusText ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($promo->expires_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Ви ще не використовували жодного промокоду.
        </div>
    <?php endif; ?>
</div>

