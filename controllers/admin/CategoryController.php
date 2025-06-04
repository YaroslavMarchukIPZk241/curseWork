<?php

namespace controllers\admin;

use core\Controller;
use core\Core;
use models\Category;

class CategoryController extends Controller
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

        return $this->render('admin/category/index', [
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

            $this->redirect('/admin/category/index');
        }

        return $this->render('admin/category/create');
    }

    public function actionEdit($id)
    {
        $id = is_array($id) ? $id[0] : $id;
        $category = Category::findById((int)$id);

        if (!$category) {
            $this->redirect('/admin/category/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $name = is_array($name) ? $name[0] : trim($name);

            $category->name = $name;

            $category->save();

            $this->redirect('/admin/category/index');
        }

        return $this->render('admin/category/edit', [
            'category' => $category
        ]);
    }

    public function actionDelete($id)
    {
        $id = is_array($id) ? $id[0] : $id;
        Category::deleteById((int)$id);

        $this->redirect('/admin/category/index');
    }
}
?>