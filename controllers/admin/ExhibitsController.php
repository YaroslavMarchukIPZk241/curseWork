<?php

namespace controllers\admin;

use core\Controller;
use models\Exhibits;
use models\Category;
use models\Period;

class ExhibitsController extends Controller
{
    public function actionIndex()
    {
        $exhibits = Exhibits::findAll();

        $periods = [];
        foreach (Period::findAll() as $period) {
            $periods[$period->id] = $period->name;
        }

        return $this->render('admin/exhibits/index', [
            'exhibits' => $exhibits,
            'periods' => $periods,
        ]);
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

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/MuseumShowcase/static/uploads/Exponat/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $originalName = basename($_FILES['image']['name']);
                $filePath = $uploadDir . $originalName;

                if (file_exists($filePath)) {
                    // Файл вже існує — використовуємо його ім'я
                    $exhibit->image_path = 'MuseumShowcase/static/uploads/Exponat/' . $originalName;
                } else {
                    // Файл не існує — завантажуємо з унікальним іменем
                    $uniqueName = uniqid() . '_' . $originalName;
                    $uniquePath = $uploadDir . $uniqueName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uniquePath)) {
                        $exhibit->image_path = 'MuseumShowcase/static/uploads/Exponat/' . $uniqueName;
                    }
                }
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

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/MuseumShowcase/static/uploads/Exponat/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalName = basename($_FILES['image']['name']);
                $filePath = $uploadDir . $originalName;

                if (file_exists($filePath)) {
                    // Файл вже існує — використовуємо його ім'я
                    $exhibit->image_path = 'MuseumShowcase/static/uploads/Exponat/' . $originalName;
                } else {
                    // Файл не існує — завантажуємо з унікальним іменем
                    $uniqueName = uniqid() . '_' . $originalName;
                    $uniquePath = $uploadDir . $uniqueName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uniquePath)) {
                        $exhibit->image_path = 'MuseumShowcase/static/uploads/Exponat/' . $uniqueName;
                    }
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
    {
        $id = is_array($params) ? $params[0] : $params;
        Exhibits::deleteById((int)$id);
        return $this->redirect('/admin/exhibits/index');
    }


    
}
