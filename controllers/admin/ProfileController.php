<?php
namespace controllers\admin;

use core\Controller;
use models\Users;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $users = Users::findAll();
        return $this->render('admin/profile/index', ['users' => $users]);
    }

    public function actionEdit($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $user = Users::findById($id);
        if (!$user) return $this->redirect('/admin/profile');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->username = $_POST['username'] ?? $user->username;
            $user->email = $_POST['email'] ?? $user->email;
            $user->role = $_POST['role'] ?? $user->role;
            Users::UpdateUser($user->id, [
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role
            ]);
            return $this->redirect('/admin/profile');
        }

        return $this->render('admin/profile/edit', ['user' => $user]);
    }
}

