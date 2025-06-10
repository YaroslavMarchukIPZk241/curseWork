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
    public static $tableName = 'exhibit_reviews';

    // Властивості для об'єкта (якщо потрібні, можна оголосити явно)
    public int $id;
    public int $exhibit_id;
    public int $user_id;
    public int $rating;
    public string $comment;
    public string $created_at;

    // Конструктор для створення об'єкта з даних масиву
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            // Присвоюємо властивості, якщо вони існують
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Отримати всі відгуки для експонату у вигляді масиву об'єктів Review
     * @param int $exhibitId
     * @return Review[]
     */
    public static function getByExhibitId(int $exhibitId): array
    {
        $db = Core::get()->db;
        $sql = "SELECT * FROM " . self::$tableName . " WHERE exhibit_id = :exhibit_id ORDER BY created_at DESC";
        $stmt = $db->pdo->prepare($sql);
        $stmt->bindValue(':exhibit_id', $exhibitId, \PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $reviews = [];
        foreach ($rows as $row) {
            $reviews[] = new self($row);  // Створюємо об'єкт Review для кожного рядка
        }

        return $reviews;
    }

    // Отримати середній рейтинг (не змінюємо — це логічно залишити статичним)
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

    // Перевірка, чи користувач уже залишив оцінку
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

    // Додавання нового відгуку — теж можна зробити інстанс-методом (або залишити статичним)
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

    // Приклад інстанс-методу: відформатувати дату
    public function getFormattedDate(string $format = 'd.m.Y H:i'): string
    {
        $dt = new \DateTime($this->created_at);
        return $dt->format($format);
    }

    // Приклад інстанс-методу: короткий текст коментаря
    public function getShortComment(int $length = 50): string
    {
        return mb_strimwidth($this->comment, 0, $length, '...');
    }
}