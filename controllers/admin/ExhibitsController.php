<?php

namespace controllers\admin;

use core\Controller;
use models\Exhibits;
use models\Category;
use models\Period;
use core\Core;

class ExhibitsController extends Controller
{
    public function actionIndex()
    {
        $exhibits = Exhibits::findAll();
        return $this->render('admin/exhibits/index', ['exhibits' => $exhibits]);
    }

    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exhibit = new Exhibits();
            $exhibit->title = $_POST['title'] ?? '';
            $exhibit->description = $_POST['description'] ?? '';
            $exhibit->location = $_POST['location'] ?? '';
            $exhibit->who_found = $_POST['who_found'] ?? '';
            $exhibit->category_id = (int) ($_POST['category_id'] ?? 0);
            $exhibit->period_id = (int) ($_POST['period_id'] ?? 0);
            $exhibit->is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $exhibit->created_at = date('Y-m-d H:i:s');

        
            if (!empty($_FILES['image']['name'])) {
                $targetDir = 'museumShowcase/static/uploads/Exponat/';
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $exhibit->image_path = $targetFile;
            }

            $exhibit->save();

            return $this->redirect('/admin/exhibits/index');
        }

        return $this->render('admin/exhibits/create', [
            'categories' => Category::findAll(),
            'periods' => Period::findAll()
        ]);
    }

    public function actionEdit($params)
    {   
        
        $id = is_array($params) ? $params[0] : $params;
        $exhibit = Exhibits::findById((int)$id);
        if (!$exhibit) {
            return $this->redirect('/admin/exhibits/index');
        }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exhibit->title = $_POST['title'] ?? '';
    $exhibit->description = $_POST['description'] ?? '';
    $exhibit->location = $_POST['location'] ?? '';
    $exhibit->who_found = $_POST['who_found'] ?? '';
    $exhibit->category_id = (int) ($_POST['category_id'] ?? 0);
    $exhibit->period_id = (int) ($_POST['period_id'] ?? 0);
    $exhibit->is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // якщо є нове зображення
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'museumShowcase/static/uploads/Exponat/';
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $exhibit->image_path = $targetFile;
        }
    }

    $exhibit->save();
    return $this->redirect('/admin/exhibits/index');
}

        return $this->render('admin/exhibits/edit', [
            'exhibit' => $exhibit,
            'categories' => Category::findAll(),
            'periods' => Period::findAll()
        ]);
    }

    public function actionDelete($params)
    { $id = is_array($params) ? $params[0] : $params;
        Exhibits::deleteById((int)$id);
        return $this->redirect('/admin/exhibits/index');
    }
}
