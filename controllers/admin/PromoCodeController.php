<?php
namespace controllers\admin;

use core\Controller;
use models\PromoCode;
use models\PromoUser;
class PromoCodeController extends Controller
{
  public function actionIndex()
{
    $promoCodes = PromoCode::findAll();
    return $this->render('admin/promo/index', ['promoCodes' => $promoCodes]);
}

    public function actionCreate()
    {
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $limit_users = (int)($_POST['limit_users'] ?? 0);
            $expires_at = $_POST['expires_at'] ?? '';
            $discount_percentage = $_POST['discount_percentage'] ?? 0;
            if (!$name) {
                $errors[] = "Промокод не може бути порожнім";
            }
            if ($limit_users <= 0) {
                $errors[] = "Максимальна кількість учасників має бути більше 0";
            }
            if (!$expires_at || strtotime($expires_at) === false) {
                $errors[] = "Вкажіть правильну дату завершення";
            }
          if ($discount_percentage <= 0 || $discount_percentage > 100) {
                 $errors[] = "Відсоток знижки має бути від 1 до 100.";
            }

            if (empty($errors)) {
                $promo = new PromoCode();
                $promo->name = $name;
                $promo->limit_users = $limit_users;
                $promo->expires_at = $expires_at;
                $promo->discount_percentage = $discount_percentage;
                if ($promo->save()) {
                    $success = true;
                } else {
                    $errors[] = "Такий промокод вже існує";
                }
            }
        }

        return $this->render('admin/promo/create', [
            'errors' => $errors,
            'success' => $success,
            'post' => $_POST,
        ]);
    }
}
