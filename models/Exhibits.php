<?php
namespace models;

use core\Model;
use core\Core;
/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image_path
 * @property int $category_id
 * @property int $period_id
 * @property int $is_featured
 * @property string $created_at
 * @property string $location
 * @property string $who_found
 */
class Exhibits extends Model
{
public static $tableName = 'exhibits';
public static function findFeatured(): array
{
    $db = Core::get()->db;

    $query = "SELECT * FROM " . static::$tableName . " WHERE is_featured = 1";
    $stmt = $db->pdo->prepare($query); 
    $stmt->execute();

    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $objects = [];
    foreach ($rows as $row) {
        $object = new static();
        foreach ($row as $key => $value) {
            $object->$key = $value;
        }
        $objects[] = $object;
    }

    return $objects;
}

public function actionRate($params)
{
    $exhibitId = $params[0] ?? null;
    $userId = $_SESSION['user']['id'] ?? null;

    if (!$exhibitId || !$userId) {
        http_response_code(400);
        echo 'Некоректний запит';
        return;
    }

    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';

    if (!$rating || $rating < 1 || $rating > 5) {
        http_response_code(422);
        echo 'Невірна оцінка';
        return;
    }

    if (!Review::hasUserRated($exhibitId, $userId)) {
        Review::addReview($exhibitId, $userId, $rating, $comment);
    }

    echo 'Оцінка додана';
}
 public static function getAverageRatingByExhibit($exhibitId)
    {
        $db = Core::get()->db;
        $sql = "SELECT AVG(rating) as avg_rating FROM exhibit_reviews WHERE exhibit_id = :id";
        $sth = $db->pdo->prepare($sql);
        $sth->execute(['id' => $exhibitId]);
        $row = $sth->fetch();
        return $row ? round($row['avg_rating'], 2) : null;
    }

public static function findAll(): array
{
    $db = Core::get()->db;
    $rows = $db->select(self::$tableName);

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

public static function findById($id): ?self
{
    $db = Core::get()->db;
    $rows = $db->select(self::$tableName, '*', ['id' => $id]);
    if (empty($rows)) return null;

    $obj = new self();
    foreach ($rows[0] as $key => $value) {
        $obj->$key = $value;
    }

    return $obj;
}

public function save(): bool
{
    $db = Core::get()->db;

    $data = [
        'title' => $this->title,
        'description' => $this->description,
        'image_path' => $this->image_path,
        'category_id' => $this->category_id,
        'period_id' => $this->period_id,
        'is_featured' => $this->is_featured,
        'created_at' => $this->created_at,
        'location' => $this->location,
        'who_found' => $this->who_found,
    ];

    if (!empty($this->id)) {
        return $db->update(self::$tableName, $data, ['id' => $this->id]);
    } else {
        $this->id = $db->insert(self::$tableName, $data);
        return true;
    }
}

public static function deleteById($id): bool
{
    $db = Core::get()->db;
    return $db->delete(self::$tableName, ['id' => $id]);
}

public function getCategoryName(): string
{
    $category = Category::findById($this->category_id);
    return $category ? $category->name : '—';
}

public function getPeriodName(): string
{
    $period = Period::findById($this->period_id);
    return $period ? $period->name : '—';
}


}