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
   
        return $this->redirect('/MuseumShowcase/login');
    }

    $exhibitId = (int) ($_POST['exhibit_id'] ?? 0);
    $rating = (int) ($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($exhibitId <= 0 || $rating < 1 || $rating > 5) {
        return $this->redirect("/MuseumShowcase/exhibits/$exhibitId");
    }
    $existingReview = ExhibitReview::findByUserAndExhibit($userId, $exhibitId);
    if ($existingReview) {
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

    return $this->render('exhibits/view.php', [ 
        'exhibit' => $exhibit,
        'reviews' => $reviews,
        'userReview' => $userReview,
    ]);
}

public function actionRate($params)
{
    header('Content-Type: application/json; charset=utf-8');

    $id = $params[0] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comment = trim($_POST['comment'] ?? '');

    if ($id === null || !is_numeric($id) || $rating === null || !is_numeric($rating)) {
        echo json_encode(['error' => 'Невірні дані']);
        exit;
    }

    $user = \models\Users::GetCurrentUser();
    $userId = $user['id'] ?? null;
    $username = $user['username'] ?? 'Анонім';

    if ($userId === null) {
        echo json_encode(['error' => 'Користувач не авторизований']);
        exit;
    }

    $exhibitId = (int)$id;
    $existing = \models\ExhibitReview::findByUserAndExhibit($userId, $exhibitId);
    if ($existing) {
        echo json_encode(['error' => 'Ви вже залишали відгук.']);
        exit;
    }

    $result = \models\ExhibitReview::addReview($userId, $exhibitId, (int)$rating, $comment);

    if ($result) {
        echo json_encode([
            'message' => "Оцінка {$rating} прийнята. Дякуємо!",
            'username' => $username,
            'rating' => (int)$rating,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    } else {
        echo json_encode(['error' => 'Не вдалося записати оцінку']);
    }

    exit;
}
public function actionGetReviews($params)
{
    header('Content-Type: application/json; charset=utf-8');

    $id = $params[0] ?? null;
    if ($id === null || !is_numeric($id)) {
        echo json_encode(['error' => 'Невірний ID']);
        exit;
    }

    $reviews = \models\ExhibitReview::findByExhibitId((int)$id);
    $user = \models\Users::GetCurrentUser();
    $userId = $user['id'] ?? null;

    $alreadyRated = false;
    if ($userId) {
        $existing = \models\ExhibitReview::findByUserAndExhibit($userId, (int)$id);
        $alreadyRated = $existing !== null;
    }

    $result = [];
    foreach ($reviews as $review) {
        $result[] = [
            'username' => $review->username ?? 'Анонім',
            'rating' => (int)$review->rating,
            'comment' => $review->comment,
            'created_at' => $review->created_at
        ];
    }

    echo json_encode([
        'reviews' => $result,
        'alreadyRated' => $alreadyRated
    ]);
    exit;
}

}
