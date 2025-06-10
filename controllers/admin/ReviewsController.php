<?php

namespace controllers\admin;

use core\Controller;
use models\Review;
use models\ExhibitReview;
class ReviewsController extends Controller
{
    // Вивести всі відгуки до експоната
    public function actionIndex($params)
    {
        $exhibitId = is_array($params) ? $params[0] : $params;

        $comments = ExhibitReview::findByExhibitId($exhibitId);

        return $this->render('admin/reviews/index', [
            'comments' => $comments,
            'exhibitId' => $exhibitId
        ]);
    }
public function getUser(): ?User
{
    return User::findById($this->user_id);
}
    // Видалення відгуку
     public function actionDelete($params)
    {
        $reviewId = is_array($params) && isset($params[0]) ? (int)$params[0] : 0;
        if ($reviewId <= 0) {
            $this->Error(404);
        }

        ExhibitReview::deleteById($reviewId);

        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/admin/exhibits';
        header("Location: $redirectUrl");
        exit;
    }
}