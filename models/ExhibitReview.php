<?php
namespace models;

use core\Model;
use core\Core;

/**
 * @property int $id
 * @property int $exhibit_id
 * @property int $user_id
 * @property int $rating
 * @property string $comment
 * @property string $created_at
 * @property string $username
 */
class ExhibitReview extends Model
{
    public static $tableName = 'exhibit_reviews';

    public static function findByExhibitId($exhibitId): array
    {
        $db = Core::get()->db;
        $sql = "SELECT r.*, u.username 
                FROM exhibit_reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.exhibit_id = :id 
                ORDER BY r.created_at DESC";

        $sth = $db->pdo->prepare($sql);
        $sth->execute(['id' => $exhibitId]);
        $rows = $sth->fetchAll();

        $objects = [];
        foreach ($rows as $row) {
            $obj = new self();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $objects[] = $obj;
        }
        return $objects;
    }

    public static function findByUserAndExhibit(int $userId, int $exhibitId): ?self
    {
        $results = Core::get()->db->select(self::$tableName, '*', [
            'user_id' => $userId,
            'exhibit_id' => $exhibitId
        ]);

        if (!empty($results)) {
            $review = new self();
            foreach ($results[0] as $key => $value) {
                $review->$key = $value;
            }
            return $review;
        }

        return null;
    }

    public static function addReview(int $userId, int $exhibitId, int $rating, ?string $comment): bool
    {
        $data = [
            'user_id' => $userId,
            'exhibit_id' => $exhibitId,
            'rating' => $rating,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return Core::get()->db->insert(self::$tableName, $data);
    }
}

