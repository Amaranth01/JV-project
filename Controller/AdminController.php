<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index()
    {
        $this->render('writer/writer');
    }

    public function addArticle()
    {
        $this->render('writer/addArticle');
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