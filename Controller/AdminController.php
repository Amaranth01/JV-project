<?php

namespace App\Controller;

use App\Model\Manager\ArticleManager;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\PlatformManager;

class AdminController extends AbstractController
{
    public function index()
    {
        //redirecting to writer's space
        $this->render('writer/writer');
    }

    public function addArticle()
    {   //Returns the add article view and retrieves the categories and platforms
        $this->render('writer/addArticle', [
            "categories"=>CategoryManager::getAllCategories(),
            "platforms"=>PlatformManager::getAllPlatforms(),
        ]);
    }

    /**
     * Display the view by its id
     * @param $id
     */
    public function updateArticle($id)
    {
        $this->render('writer/updateArticle', $data=[
            'article' => ArticleManager::getArticle($id),
        ]);
    }

    /**
     * View all articles with pagination
     */
    public function listArticle()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('writer/listArticle', $data = [
                    'article' => ArticleManager::findAllArticle(0),
                    'page' => ArticleManager::countArticle(),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('writer/listArticle', $data = [
                'article' => ArticleManager::findAllArticle(0, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticle() /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('writer/listArticle', $data = [
            'article' => ArticleManager::findAllArticle(0),
            'page' => ArticleManager::countArticle() /6,
        ]);
    }

    public function adminSpace()
    {
        //redirecting to admin's space
        $this->render('admin/adminSpace');
    }
}