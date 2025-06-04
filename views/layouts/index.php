<?php
/** @var string $Title */
/** @var string $Content */

use models\Users;
use models\Session;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script src="/MuseumShowcase/assets/js/script.js"></script>
    <title><?= $Title ?? 'MuseumShowcase' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/MuseumShowcase/assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <base href="/MuseumShowcase/">
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
</head>
<body>
    <header class="bg-light border-bottom mb-3">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand text-primary fw-bold" href="/MuseumShowcase">Museum-travel for millennia</a>
        <a class="navbar-brand text-primary fw-bold" href="/MuseumShowcase/period">Експонати</a>

        <div class="ms-auto">
            <?php if(Users::isUserLogged()): ?>
                <!-- Авторизований -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="<?= $_SESSION['user']['profile_picture'] ?? '/MuseumShowcase/assets/img/default-avatar.png' ?>" alt="avatar" class="rounded-circle" width="32" height="32">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/MuseumShowcase/profile">Мій профіль</a></li>
                        <?php if(Users::isCurrentUserAdmin()): ?>
                            <li><a class="dropdown-item" href="/MuseumShowcase/admin/panel">Адміністрування</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="/MuseumShowcase/profile/logout">Вийти</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Гість -->
                <a class="btn btn-link text-primary me-2" href="/MuseumShowcase/home/about">Про автора</a>
                <a class="btn btn-primary" href="/MuseumShowcase/profile/login">Вхід</a>
                <a class="btn btn-primary" href="/MuseumShowcase/profile/register">Реєстрація</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

    <main class="container">
        <?= $Content ?? '' ?>
    </main>

</body>
</html>
