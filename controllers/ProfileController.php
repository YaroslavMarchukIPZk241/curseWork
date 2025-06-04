<?php

namespace controllers;
use core\Template;
use core\Controller;
use core\Core;

use models\Users;

class ProfileController extends Controller
{
  public function actionIndex()
{
    if (!Users::isUserLogged())
        return $this->redirect('/profile/login');

    $user = Users::GetCurrentUser();

    if ($this->isPost) {
        $fields = [];

        if (!empty($this->post->username))
            $fields['username'] = $this->post->username;

        $fields['email'] = !empty($this->post->email) ? $this->post->email : null;

        Users::UpdateUser($user['id'], $fields);

        $updatedUser = Users::FindByLogin($this->post->username);
        Users::LoginUser($updatedUser);

        return $this->redirect('/profile');
    }

    return $this->render();
}
public function actionEdit()
{
    if (!Users::isUserLogged()) {
        return $this->redirect('profile/login');
    }

    $user = Users::FindById(Users::GetCurrentUser()['id']);
    $fields = [];

    if ($this->isPost) {
        // Ім’я
        
        $username = trim($this->post->username ?? '');
        if ($username !== '') {
            $fields['username'] = $username;
        }

        // Email
        $email = trim($this->post->email ?? '');
        if ($email !== '') {
            $fields['email'] = $email;
        }

        // Зміна паролю
        $currentPassword = trim($this->post->current_password ?? '');
        $newPassword = trim($this->post->new_password ?? '');
        $confirmPassword = trim($this->post->confirm_password ?? '');

        if ($currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '') {
            if ($newPassword !== $confirmPassword) {
                $this->addErrorMessage('Новий пароль та підтвердження не збігаються.');
                return $this->render('views/profile/edit.php', ['user' => $user]);
            }

            if (!password_verify($currentPassword, $user['password'])) {
                $this->addErrorMessage('Неправильний поточний пароль.');
                return $this->render('views/profile/edit.php', ['user' => $user]);
            }

            if (strlen($newPassword) < 6) {
                $this->addErrorMessage('Новий пароль повинен містити щонайменше 6 символів.');
                return $this->render('views/profile/edit.php', ['user' => $user]);
            }

            
            $fields['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if (count($fields) === 0) {
            $this->addErrorMessage('Немає змін для збереження.');
            return $this->render('views/profile/edit.php', ['user' => $user]);
        }

        $rowsUpdated = Users::UpdateUser($user['id'], $fields);

        if ($rowsUpdated > 0 && isset($fields['username'])) {
            $updatedUser = Users::FindByLogin($fields['username']);
            Users::LoginUser($updatedUser);
        }

        return $this->redirect('/profile');
    }

    return $this->render('views/profile/edit.php', ['user' => $user]);
}


    public function actionLogin()
    {
        if(Users::IsUserLogged())
            return $this->redirect('/');
        if($this->isPost)
        {
            $user = Users::FindByLoginAndPassword($this->post->username, $this->post->password);
            if(!empty($user))
            {
                Users::LoginUser($user);
                return $this->redirect('/');
            }
            else
            {
                $error_message = 'Неправильний логін та/або пароль';
                $this->addErrorMessage($error_message);
            }
        }
        
        return $this->render();
    }
  public function actionRegister()
{
    if (Users::IsUserLogged())
        return $this->redirect('/');

    if ($this->isPost) {
        $user = Users::FindByLogin($this->post->username);

        if (!empty($user)) {
            $this->addErrorMessage('Користувач із таким логіном вже існує!');
        }
        if (strlen($this->post->username) === 0)
            $this->addErrorMessage('Логін не вказано!');
        if (strlen($this->post->password) === 0)
            $this->addErrorMessage('Пароль не вказано!');
        if (strlen($this->post->password2) === 0)
            $this->addErrorMessage('Пароль (ще раз) не вказано!');
        if ($this->post->password != $this->post->password2)
            $this->addErrorMessage('Паролі не співпадають!');


        if (!empty($this->post->email) && !filter_var($this->post->email, FILTER_VALIDATE_EMAIL)) {
            $this->addErrorMessage('Невірний формат Email');
        }

        if (!$this->isErrorMessageExist()) {
            Users::RegisterUser(
                $this->post->username,
                $this->post->password,
                $this->post->email 
            );
            return $this->redirect('/profile/registered');
        }
    }

    return $this->render();
}


    public function actionRegistered()
    {
        if(Users::IsUserLogged())
            return $this->redirect('/');
        return $this->render();
    }
    public function actionLogout()
    {
        Users::LogoutUser();
        return $this->redirect('/profile/login');
    }
    public function actionView($params)
    {
        var_dump($params);
    }

    
}