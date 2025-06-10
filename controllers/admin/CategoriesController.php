<?php

namespace controllers\admin;

use core\Controller;
use core\Core;
use models\Category;

class CategoriesController extends Controller
{
    public function actionIndex()
    {
         

        $categoriesData = Core::get()->db->select('categories');
        $categories = [];

        // Створюємо об’єкти категорій з масивів
        foreach ($categoriesData as $data) {
            $category = new Category();
            $category->id = (int)$data['id'];
            $category->name = $data['name'];
            $categories[] = $category;
        }

        return $this->render('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $name = is_array($name) ? $name[0] : trim($name);

            $category = new Category();
            $category->name = $name;
            
            $category->save();

            $this->redirect('/admin/categories/index');
        }

        return $this->render('admin/categories/create');
    }

    public function actionEdit($params)
    {
        $id = is_array($params) ? $params[0] : $params;
        $category = Category::findById((int)$id);

        if (!$category) {
            $this->redirect('/admin/categories/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $name = is_array($name) ? $name[0] : trim($name);

            $category->name = $name;

            $category->save();

            $this->redirect('/admin/categories/index');
        }

        return $this->render('admin/categories/edit', [
            'category' => $category
        ]);
    }

    public function actionDelete($params)
    {
        $id = is_array($params) ? $params[0] : $params;
        Category::deleteById((int)$id);

        $this->redirect('/admin/categories/index');
    }
}
