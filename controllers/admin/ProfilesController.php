<?php
namespace controllers\admin;

use core\Controller;
use models\Users;

class ProfilesController extends Controller
{
    public function actionIndex()
    {
        $users = Users::findAll();
        return $this->render('admin/profiles/index', ['users' => $users]);
    }

    public function actionEdit($params)
{
    $id = is_array($params) ? (int)$params[0] : (int)$params;
    $user = Users::findById($id);
    if (!$user) return $this->redirect('/admin/profiles');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user->username = $_POST['username'] ?? $user->username;
        $user->email = $_POST['email'] ?? $user->email;
        $user->role = $_POST['role'] ?? $user->role;

        $fields = [
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role
        ];

        if (!empty($_POST['password'])) {
            $fields['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        Users::UpdateUser($user->id, $fields);
        return $this->redirect('/admin/profiles');
    }

    return $this->render('admin/profiles/edit', ['user' => $user]);
}

public function actionCreate()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'user';
        $password = $_POST['password'] ?? '';

        // Валідація — пароль обов'язковий
        if ($username && $email && $password) {
            Users::CreateUser([
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'password' => $password
            ]);
            return $this->redirect('/admin/profiles');
        } else {
            $error = "Всі поля, включно з паролем, обов'язкові!";
            return $this->render('admin/profiles/create', ['error' => $error]);
        }
    }

    return $this->render('admin/profiles/create');
}

public function actionDelete($params)
{
    $id = is_array($params) ? (int)$params[0] : (int)$params;
    $user = Users::findById($id);

    if ($user) {
        Users::DeleteUser($id);
    }

    return $this->redirect('/admin/profiles');
}
}

