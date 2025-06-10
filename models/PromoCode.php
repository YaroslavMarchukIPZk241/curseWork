<?php
namespace models;

use core\Core;

class PromoCode
{
    public $id;
    public $name;
    public $limit_users;
    public $expires_at;
    public $discount_percentage;

    public function save(): bool
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT COUNT(*) FROM promo_code WHERE name = ?");
        $stmt->execute([$this->name]);
        if ($stmt->fetchColumn() > 0) {
            return false; 
        }
        $stmt = $db->pdo->prepare("INSERT INTO promo_code (name, limit_users, expires_at, discount_percentage) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->name, $this->limit_users, $this->expires_at, $this->discount_percentage]);
    }

    public static function findByCode(string $code)
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT * FROM promo_code WHERE name = ? LIMIT 1");
        $stmt->execute([$code]);
        $data = $stmt->fetch();

        if (!$data) return null;

        $promo = new self();
        $promo->id = $data['id'];
        $promo->name = $data['name'];
        $promo->limit_users = $data['limit_users'];
        $promo->expires_at = $data['expires_at'];
        $promo->discount_percentage = $data['discount_percentage'];
        return $promo;
    }
public static function findById($id) 
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT * FROM promo_code WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();

        if (!$data) return null;

        $promo = new self();
        $promo->id = $data['id'];
        $promo->name = $data['name'];
        $promo->limit_users = $data['limit_users'];
        $promo->expires_at = $data['expires_at'];
        $promo->discount_percentage = $data['discount_percentage'];
        return $promo;
    }
  public function isActive(): bool
{
    $now = date('Y-m-d H:i:s');
    return $this->expires_at > $now;
}
public static function findAll()
{
    $db = Core::get()->db;
    $stmt = $db->pdo->query("SELECT * FROM promo_code ORDER BY id DESC");
    $promoCodes = [];
    
    while ($data = $stmt->fetch()) {
        $promo = new self();
        $promo->id = $data['id'];
        $promo->name = $data['name'];
        $promo->limit_users = $data['limit_users'];
        $promo->expires_at = $data['expires_at'];
        $promo->discount_percentage = $data['discount_percentage'];
        $promoCodes[] = $promo;
    }
    
    return $promoCodes;
}
}