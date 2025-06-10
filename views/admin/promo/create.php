<?php /** @var array $errors */ ?>
<?php /** @var bool $success */ ?>
<?php /** @var array $post */ ?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Створення промокоду</title>
    <script>
        function generatePromoCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for(let i = 0; i < 8; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('name').value = code;
        }
    </script>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        label { display: block; margin-bottom: 10px; }
        input[type="text"], input[type="number"], input[type="date"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; width: 250px; }
        button[type="submit"], button[type="button"] { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button[type="submit"]:hover, button[type="button"]:hover { background-color: #0056b3; }
        .form-check { margin-top: 20px; }
        .form-check-label { display: inline; margin-left: 5px; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>

<h1>Створення промокоду</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $error): ?>
            <li><?=htmlspecialchars($error)?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green;">Промокод успішно створений!</p>
<?php endif; ?>

<form method="post">
    <label>
        Промокод:
        <input type="text" id="name" name="name" value="<?=htmlspecialchars($post['name'] ?? '')?>" required>
        <button type="button" onclick="generatePromoCode()">Згенерувати код</button>
    </label>
    <br><br>

    <label>
        Максимальна кількість учасників:
        <input type="number" name="limit_users" min="1" value="<?=htmlspecialchars($post['limit_users'] ?? '1')?>" required>
    </label>
    <br><br>

    <label>
        Термін дії (до):
        <input type="date" name="expires_at" value="<?=htmlspecialchars($post['expires_at'] ?? '')?>" required>
    </label>
    <br><br>

    <label>
        Відсоток знижки:
        <input type="number" name="discount_percentage" min="0" max="100" value="<?=htmlspecialchars($post['discount_percentage'] ?? '0')?>" required>
    </label>
    <br><br>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="acknowledge_responsibility" id="acknowledgeResponsibility" required>
        <label class="form-check-label" for="acknowledgeResponsibility">
            Я усвідомлюю відповідальність за правильне використання промокодів та розумію, що всі мої дії фіксуються в системі.
        </label>
    </div>
    <br><br>

    <button type="submit">Створити</button>
</form>

</body>
</html>