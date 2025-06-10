<?php
namespace controllers\admin;

use core\Controller;
use core\Core;
use models\InformationPeriod;

class PeriodDetailsController extends Controller
{
    // Показуємо список подій (об’єкти InformationPeriod)
   public function actionIndex($params)
{
    $periodId = isset($params[0]) ? (int)$params[0] : null;

    if ($periodId) {
        $details = InformationPeriod::findByPeriodId($periodId);
        $showAddButton = true;  // Є конкретна епоха — показуємо кнопку
    } else {
        $details = InformationPeriod::findAll();
        $showAddButton = false; // Немає епохи — не показуємо кнопку
    }

    return $this->render('admin/perioddetails/index', [
        'details' => $details,
        'periodId' => $periodId,
        'showAddButton' => $showAddButton,
    ]);
}

    // Створення нової події
    public function actionCreate($params)
    {
        $periodId = (int)($params[0] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $periodDetail = new InformationPeriod();
            $periodDetail->name = $_POST['name'] ?? '';
            $periodDetail->link = $_POST['link'] ?? '';
            $periodDetail->information = $_POST['information'] ?? '';
            $periodDetail->Period_id = $periodId;

            // Зберігаємо у базу через модель
            $periodDetail->save();
    
            $this->redirect(\core\Config::get()->getBaseUrl() . "/admin/perioddetails/index/{$periodId}");

        }

        return $this->render('/admin/perioddetails/create', ['periodId' => $periodId]);
    }

    // Редагування події
    public function actionEdit($params)
{
    $id = (int)($params[0] ?? 0);

    $detail = InformationPeriod::findById($id);
    if (!$detail) {
        $this->redirect(\core\Config::get()->getBaseUrl() . "/admin/perioddetails/index");
        return;
    }

    $periodId = $detail->Period_id; // ← додано

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $detail->name = $_POST['name'] ?? $detail->name;
        $detail->link = $_POST['link'] ?? $detail->link;
        $detail->information = $_POST['information'] ?? $detail->information;

        $detail->save();

        $this->redirect(\core\Config::get()->getBaseUrl() . "/admin/perioddetails/index/{$periodId}");
    }

    return $this->render('/admin/perioddetails/edit', ['detail' => $detail]);
}

 public function actionError()
 {
    echo "<h2>історію не можна переписувати!!!!</h2>";
    undefined_function_call();
 }

}
