<?php
namespace controllers\admin;

use core\Controller;
use models\Period;

class PeriodsController extends Controller
{
    public function actionIndex()
    {
        $periods = Period::findAll();
        return $this->render('admin/periods/index', ['periods' => $periods]);
    }

    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $period = new Period();
            $period->name = $_POST['name'] ?? '';
            $period->image_path = $_POST['image_path'] ?? '';
            $period->DetailPeriod = $_POST['DetailPeriod'] ?? '';
            $period->TimePeriod = $_POST['TimePeriod'] ?? '';
            $period->Section = $_POST['Section'] ?? '';

            if ($period->name && $period->DetailPeriod) {
                $period->save();
                return $this->redirect('/admin/periods');
            } else {
                $error = "Назва і опис обов'язкові.";
                return $this->render('admin/periods/create', ['error' => $error, 'period' => $period]);
            }
        }

        return $this->render('admin/periods/create');
    }

    public function actionEdit($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $period = Period::findById($id);
        if (!$period) return $this->redirect('/admin/periods');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $period->name = $_POST['name'] ?? $period->name;
            $period->image_path = $_POST['image_path'] ?? $period->image_path;
            $period->DetailPeriod = $_POST['DetailPeriod'] ?? $period->DetailPeriod;
            $period->TimePeriod = $_POST['TimePeriod'] ?? $period->TimePeriod;
            $period->Section = $_POST['Section'] ?? $period->Section;

            $period->save();
            return $this->redirect('/admin/periods');
        }

        return $this->render('admin/periods/edit', ['period' => $period]);
    }

    public function actionDelete($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $period = Period::findById($id);

        if ($period) {
            Period::deleteById($id);
        }

        return $this->redirect('/admin/periods');
    }
}