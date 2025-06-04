<?php

namespace controllers;

use core\Controller;
use models\Exhibits;
use models\ExhibitReview;
class ExhibitsController extends Controller
{
 public function actionAddReview()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return $this->redirect('/MuseumShowcase/exhibits');
        
    }

    $user = \models\Users::GetCurrentUser();
    $userId = $user['id'] ?? null;
    if (!$userId) {
        // Користувач не авторизований
        return $this->redirect('/MuseumShowcase/login');
    }

    $exhibitId = (int) ($_POST['exhibit_id'] ?? 0);
    $rating = (int) ($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($exhibitId <= 0 || $rating < 1 || $rating > 5) {
        // Некоректні дані
        return $this->redirect("/MuseumShowcase/exhibits/$exhibitId");
    }

    // Перевірка, чи користувач вже залишав відгук
    $existingReview = ExhibitReview::findByUserAndExhibit($userId, $exhibitId);
    if ($existingReview) {
        // Можна реалізувати оновлення або показати повідомлення про помилку
        return $this->redirect("/MuseumShowcase/exhibits/$exhibitId");
    }

    ExhibitReview::addReview($userId, $exhibitId, $rating, $comment);

    return $this->redirect("/MuseumShowcase/exhibits/$exhibitId");
}
   public function actionView($params)
{
       $id = $params[0] ?? null;
    if ($id === null) return $this->redirect('/MuseumShowcase/exhibits');

    $exhibit = Exhibits::findById((int)$id);
    if (empty($exhibit)) return $this->redirect('/MuseumShowcase/exhibits');

    $reviews = \models\ExhibitReview::findByExhibitId((int)$id);
    $userId = $_SESSION['id'] ?? null;
    $userReview = null;
    if ($userId) {
        $userReview = \models\ExhibitReview::findByUserAndExhibit($userId, (int)$id);
    }

    return $this->render('exhibits/view.php', [ // ← ось тут вказуєш з .php
        'exhibit' => $exhibit,
        'reviews' => $reviews,
        'userReview' => $userReview,
    ]);
}


public function actionRate($params)
{
    header('Content-Type: application/json; charset=utf-8');
    ob_start();

    $id = $params[0] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comment = trim($_POST['comment'] ?? '');

    if ($id === null || !is_numeric($id) || $rating === null || !is_numeric($rating)) {
        echo json_encode(['error' => 'Невірні дані']);
        ob_end_flush();
        exit;
    }

    $user = \models\Users::GetCurrentUser();
    $userId = $user['id'] ?? null;

    if ($userId === null) {
        echo json_encode(['error' => 'Користувач не авторизований']);
        ob_end_flush();
        exit;
    }

    $exhibitId = (int)$id;

    $db = \core\Core::get()->db;
    $result = $db->insert('exhibit_reviews', [
        'exhibit_id' => $exhibitId,
        'user_id' => $userId,
        'rating' => (int)$rating,
        'comment' => $comment, 
        'created_at' => date('Y-m-d H:i:s')
    ]);

    if ($result) {
        echo json_encode(['message' => "Оцінка {$rating} прийнята. Дякуємо!"]);
    } else {
        echo json_encode(['error' => 'Не вдалося записати оцінку']);
    }

    ob_end_flush();
    exit;
}
}
