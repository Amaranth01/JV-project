<?php

namespace App\Controller;

use App\Model\Manager\CategoryManager;

class AdminController extends AbstractController
{
    public function index()
    {
        $this->render('writer/writer');
    }

    public function addArticle()
    {
        $this->render('writer/addArticle', [
            "categories"=>CategoryManager::getAllCategories()
        ]);
    }

    public function updateArticle($id)
    {
        $this->render('writer/updateArticle', $data=[$id]);
    }

    public function listArticle()
    {
        $this->render('writer/listArticle');
    }

    public function adminSpace()
    {
        $this->render('admin/adminSpace');
    }
}