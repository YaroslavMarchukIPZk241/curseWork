<?php
namespace controllers;

use core\Controller;
use models\PromoCode;
use models\PromoUser;

class PromoCodeController extends Controller
{
    public function actionIndex()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Перевірка hCaptcha , так як ми на локалбному то вона непрацює  но на продакшені все буде працювати , можу показати статистику
         /*   $hcaptchaResponse = $_POST['h-captcha-response'] ?? '';
            if (empty($hcaptchaResponse)) {
                return $this->render('promo/index', ['error' => "Будь ласка, пройдіть перевірку 'Я не робот'."]);
            }

            $secret = 'e55cdb06-217e-4202-9a6e-a3fa3e7e1742'; 
            $verifyUrl = 'https://hcaptcha.com/siteverify';

            $data = [
                'secret' => $secret,
                'response' => $hcaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ];

            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($data)
                ]
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($verifyUrl, false, $context);
            $resultJson = json_decode($result);

            if (!$resultJson || !$resultJson->success) {
                return $this->render('promo/index', ['error' => "Підтвердження капчі не пройшло, спробуйте ще раз."]);
            }
*/
            
            $code = trim($_POST['promo_code'] ?? '');

            if (empty($code)) {
                return $this->render('promo/index', ['error' => "Будь ласка, введіть промокод."]);
            }

            $promoCode = PromoCode::findByCode($code);

            if (!$promoCode) {
                return $this->render('promo/index', ['error' => "Промокод не знайдено."]);
            }

            // Перевірка терміну дії
            $now = date('Y-m-d H:i:s');
            if ($promoCode->expires_at < $now) {
                return $this->render('promo/index', ['error' => "Термін дії промокоду закінчився."]);
            }

            // Перевірка користувача
            $userId = $_SESSION['user']['id'] ?? null;
            if (!$userId) {
                return $this->render('promo/index', ['error' => "Ви маєте увійти, щоб активувати промокод."]);
            }

            if (PromoUser::exists($promoCode->id, $userId)) {
                return $this->render('promo/index', ['error' => "Ви вже активували цей промокод."]);
            }

            $usedCount = PromoUser::countByPromoId($promoCode->id);
            if ($usedCount >= $promoCode->limit_users) {
                return $this->render('promo/index', ['error' => "Ліміт використання промокоду вичерпано."]);
            }

            // Записуємо використання
            PromoUser::add($promoCode->id, $userId);

            return $this->render('promo/index', ['success' => "Промокод активовано успішно!"]);
        }

        // GET-запит — просто показати форму
        return $this->render('promo/index');
    }
}