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

    public function editArticle()
    {
        $this->render('writer/editArticle');
    }

    public function listArticle()
    {
        $this->render('writer/listArticle');
    }
}