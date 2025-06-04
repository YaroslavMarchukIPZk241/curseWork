<?php

namespace models;

use core\Core;
use core\Model;

/**
 * @property int $id
 * @property int $exhibit_id
 * @property int $user_id
 * @property int $rating
 * @property string $comment
 * @property string $created_at
 */
class Review extends Model
{
    public static string $tableName = 'exhibit_reviews';

    public static function getByExhibitId(int $exhibitId): array
    {
        $db = Core::get()->db;
        $sql = "SELECT * FROM " . self::$tableName . " WHERE exhibit_id = :exhibit_id ORDER BY created_at DESC";
        $stmt = $db->pdo->prepare($sql);
        $stmt->bindValue(':exhibit_id', $exhibitId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAverageRating(int $exhibitId): float
    {
        $db = Core::get()->db;
        $sql = "SELECT AVG(rating) as avg_rating FROM " . self::$tableName . " WHERE exhibit_id = :exhibit_id";
        $stmt = $db->pdo->prepare($sql);
        $stmt->bindValue(':exhibit_id', $exhibitId, \PDO::PARAM_INT);
        $stmt->execute();
        $avg = $stmt->fetchColumn();
        return $avg !== null ? round((float)$avg, 2) : 0.0;
    }

    public static function hasUserRated(int $exhibitId, int $userId): bool
    {
        $db = Core::get()->db;
        $sql = "SELECT COUNT(*) FROM " . self::$tableName . " WHERE exhibit_id = :exhibit_id AND user_id = :user_id";
        $stmt = $db->pdo->prepare($sql);
        $stmt->bindValue(':exhibit_id', $exhibitId, \PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function addReview(int $exhibitId, int $userId, int $rating, string $comment): bool
    {
        $db = Core::get()->db;
        return $db->insert(self::$tableName, [
            'exhibit_id' => $exhibitId,
            'user_id' => $userId,
            'rating' => $rating,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}