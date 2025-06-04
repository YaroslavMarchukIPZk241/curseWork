<?php
$this->Title = 'About';
?>
<h1>Про автора</h1>
<div class="about-card">
    <div class="about-content">
        <div class="about-text">
            <h1>Привіт!</h1>
            <h2>Я — <?= $admin ?>, автор <?= $title ?></h2>
            <p>Я створив цей чат, щоб забезпечити сучасну, стильну та швидку платформу для спілкування в реальному часі. Тут кожен знайде своє місце</p>
        </div>
        <div class="about-image">
            <img src="/chatter/assets/img/hero_me.jpg" alt="Автор Chatter">
        </div>
    </div>
    <div class="about-telegram">
        <a href="https://t.me/vader_vad" target="_blank">
            <img src="/chatter/assets/img/telegram_icon.png" alt="Telegram" />
        </a>
    </div>
</div>