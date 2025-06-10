<?php

namespace models;

use core\Core;

class PromoUser
{
    public static function exists(int $promoId, int $userId): bool
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT COUNT(*) FROM promo_users WHERE id_promo = :promo AND id_user = :user");
        $stmt->execute([':promo' => $promoId, ':user' => $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function countByPromoId(int $promoId): int
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT COUNT(*) FROM promo_users WHERE id_promo = :promo");
        $stmt->execute([':promo' => $promoId]);
        return (int)$stmt->fetchColumn();
    }

    public static function add(int $promoId, int $userId): bool
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("INSERT INTO promo_users (id_promo, id_user) VALUES (:promo, :user)");
        return $stmt->execute([':promo' => $promoId, ':user' => $userId]);
    }

    public static function getPromoCodeForUser(int $userId)
    {
        $db = Core::get()->db;
        $stmt = $db->pdo->prepare("SELECT id, id_promo, id_user FROM promo_users WHERE id_user = :user_id LIMIT 1");
        $stmt->execute([':user_id' => $userId]);
        $data = $stmt->fetch(\PDO::FETCH_OBJ); 

        if ($data) {

            $promoUserObject = new self(); 
            $promoUserObject->id = $data->id;
            $promoUserObject->id_promo = $data->id_promo;
            $promoUserObject->id_user = $data->id_user;
            return $promoUserObject;
        }
        return null; 
    }
    public static function getAllPromoCodesByUser(int $userId)
{
    $db = Core::get()->db;
    $stmt = $db->pdo->prepare("
        SELECT pu.*, pc.name, pc.discount_percentage, pc.expires_at 
        FROM promo_users pu
        JOIN promo_code pc ON pu.id_promo = pc.id
        WHERE pu.id_user = :user_id
        ORDER BY pu.id DESC
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}
}
 


?>