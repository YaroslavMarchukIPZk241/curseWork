<?php

namespace controllers;
use core\Template;
use core\Controller;
use core\Config;
use models\Exhibits; 
use models\ExhibitsController;
class HomeController extends Controller
{
     public function actionIndex()
    {
        $featuredExhibits = Exhibits::findFeatured();
        return $this->render('views/home/index.php', [
            'featuredExhibits' => $featuredExhibits
        ]);
    }
    public function actionAbout()
    {
        $config = Config::get();
        $this->template->setParams(
            [
            'admin' => $config->admin,
            'title' => $config->title
            ]);
    return $this->render();
    }
}
