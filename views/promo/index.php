

<div class="promo-container">
    <h2>Введення промо-коду</h2>

    <p>
        Підписуйтесь на наш
        <a href="https://t.me/UaOnlii" target="_blank">телеграм канал</a>, 
       там регулярно публікують промокоди на знижки.
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="/MuseumShowcase/promoCode/" method="post">
        <input type="text" name="promo_code" placeholder="Введите промо-код" required>

        <div class="captcha-label">Захист овід спаму <span style="color: red">*</span></div>
        <div class="h-captcha" data-sitekey="e55cdb06-217e-4202-9a6e-a3fa3e7e1742"></div>

        <br>
        <button type="submit">ВИКОРИСТАТИ</button>
    </form>
</div>

<script src="https://js.hcaptcha.com/1/api.js" async defer></script>