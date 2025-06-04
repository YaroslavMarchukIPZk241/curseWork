<?php

namespace controllers\admin;

use core\Controller;

class PanelController extends Controller
{
    public function actionIndex()
    {
        return $this->render('admin/panel');
    }
}