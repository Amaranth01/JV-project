<?php

namespace App\Controller;

use App\Model\Manager\ArticleManager;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\PlatformManager;

class AdminController extends AbstractController
{
    public function index()
    {
        $this->render('writer/writer');
    }

    public function addArticle()
    {
        $this->render('writer/addArticle', [
            "categories"=>CategoryManager::getAllCategories(),
            "platforms"=>PlatformManager::getAllPlatforms(),
        ]);
    }

    public function updateArticle($id)
    {
        $this->render('writer/updateArticle', $data=[$id]);
    }

    public function listArticle()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('writer/listArticle', $data = [
                    'article' => ArticleManager::findAllArticle(0),
                    'page' => ArticleManager::countArticle(),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('writer/listArticle', $data = [
                'article' => ArticleManager::findAllArticle(0, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticle() /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('writer/listArticle', $data = [
            'article' => ArticleManager::findAllArticle(0),
            'page' => ArticleManager::countArticle() /3,
        ]);
    }

    public function adminSpace()
    {
        $this->render('admin/adminSpace');
    }
}