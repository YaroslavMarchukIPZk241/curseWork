<?php

namespace controllers\admin;

use core\Controller;
use core\Core;
use models\Period;

class PeriodController extends Controller
{
    public function actionIndex()
    {
        $periods = Period::findAll();  // має повертати масив об'єктів або масиви з БД
        return $this->render('admin/period/index', ['periods' => $periods]);
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
            $period->save();
            $this->redirect('/admin/period/index');
        }
        return $this->render('admin/period/create');
    }

    public function actionEdit($id)
    {
        if (is_array($id)) {
            $id = $id[0];
        }

        $period = Period::findById($id); 

        if (!$period) {
            $this->redirect('/admin/period/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $period->name = $_POST['name'] ?? '';
            $period->image_path = $_POST['image_path'] ?? '';
            $period->DetailPeriod = $_POST['DetailPeriod'] ?? '';
            $period->TimePeriod = $_POST['TimePeriod'] ?? '';
            $period->Section = $_POST['Section'] ?? '';
            $period->save();
            $this->redirect('/admin/period/index');
        }

        return $this->render('admin/period/edit', ['period' => $period]);
    }

    public function actionDelete($id)
    {
        if (is_array($id)) {
            $id = $id[0];
        }

        Period::deleteById($id);
        $this->redirect('/admin/period/index');
    }
}