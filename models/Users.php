<?php
namespace models;

use core\Model;
use core\Core;

/**
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string $password
 * @property string|null $bonus_code
 * @property string $role
 */
class Users extends Model
{
    public static $tableName = 'users';

   public static function FindByLoginAndPassword($username, $password)
{
    $rows = self::findByCondition(['username' => $username]);
    if (!empty($rows)) {
        $user = $rows[0];
        if (password_verify($password, $user->password)) {
            return $user;
        }
    }
    return null;
}

    public static function FindByLogin($username)
    {
        $rows = self::findByCondition(['username' => $username]);
        return !empty($rows) ? $rows[0] : null;
    }

    public static function isUserLogged()
    {
        return !empty(Core::get()->session->get('user'));
    }

  public static function LoginUser($user)
{
    $userArray = [
        'id' => $user->id,
        'username' => $user->username,
        'email' => $user->email,
        'role' => $user->role
    ];
    Core::get()->session->set('user', $userArray);
}

    public static function LogoutUser()
    {
        Core::get()->session->remove('user');
    }

    public static function RegisterUser($username, $password, $email = null)
    {
        $user = new Users();
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->email = $email;
        $user->role = 'user';
        $user->bonus_code = null;
        $user->save();
    }

    public static function GetCurrentUser()
    {
        return Core::get()->session->get('user');
    }
    public static function UpdateUser($id, $fields)
    {
         $db = Core::get()->db;
         return $db->update(self::$tableName, $fields, ['id' => $id]);
    }
    public static function isCurrentUserAdmin(): bool
    {
        $user = self::GetCurrentUser();
        return $user && isset($user['role']) && $user['role'] === 'admin';
    }
    public static function findAll(): array
{
    $db = Core::get()->db;
    $rows = $db->select(self::$tableName);
    return array_map(function($row) {
        $user = new self();
        foreach ($row as $key => $value) {
            $user->$key = $value;
        }
        return $user;
    }, $rows);
}
}
