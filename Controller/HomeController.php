<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\PlatformManager;

class HomeController extends AbstractController
{
    public function index ()
    {
        $this->render('home/index');
    }

    public function login()
    {
        $this->render('pages/login');
    }

    public function register()
    {
        $this->render('pages/register');
    }

    public function news()
    {   //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/news', $data = [
                    'article' => ArticleManager::findAllArticle(0),
                    'page' => ArticleManager::countArticle(),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/news', $data = [
                'article' => ArticleManager::findAllArticle(0, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticle() /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/news', $data = [
            'article' => ArticleManager::findAllArticle(0),
            'page' => ArticleManager::countArticle() /3,
        ]);
    }

    public function poll()
    {
        $this->render('pages/poll');
    }

    public function series()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/series', $data = [
                    'article' => ArticleManager::getArticleBySectionId(5, 3),
                    'page' => ArticleManager::countArticleBySection(5),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/series', $data = [
                'article' => ArticleManager::getArticleByPlatformId(5, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleBySection(5) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/series', $data = [
            'article' => ArticleManager::getArticleByPlatformId(5,3),
            'page' => ArticleManager::countArticleBySection(5) /3,
        ]);
    }

    public function tchat()
    {
        $this->render('pages/tchat');
    }

    public function help()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/help', $data = [
                    'article' => ArticleManager::getArticleBySectionId(3, 3),
                    'page' => ArticleManager::countArticleBySection(3),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/help', $data = [
                'article' => ArticleManager::getArticleByPlatformId(3, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleBySection(3) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/help', $data = [
            'article' => ArticleManager::getArticleByPlatformId(3,3),
            'page' => ArticleManager::countArticleBySection(3) /3,
        ]);
    }

    public function nextgame()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/nextgame', $data = [
                    'article' => ArticleManager::getArticleBySectionId(4, 3),
                    'page' => ArticleManager::countArticleBySection(4),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/nextgame', $data = [
                'article' => ArticleManager::getArticleByPlatformId(4, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleBySection(4) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/nextgame', $data = [
            'article' => ArticleManager::getArticleByPlatformId(4,3),
            'page' => ArticleManager::countArticleBySection(4) /3,
        ]);
    }

    public function pc()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/pc', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(1, 3),
                    'page' => ArticleManager::countArticleByPlatform(1),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/pc', $data = [
                'article' => ArticleManager::getArticleByPlatformId(1, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleByPlatform(1) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/pc', $data = [
            'article' => ArticleManager::getArticleByPlatformId(1,3),
            'page' => ArticleManager::countArticleByPlatform(1) /3,
        ]);
    }

    public function playstation()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/playstation', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(2, 3),
                    'page' => ArticleManager::countArticleByPlatform(2),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/playstation', $data = [
                'article' => ArticleManager::getArticleByPlatformId(2, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleByPlatform(2) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/playstation', $data = [
            'article' => ArticleManager::getArticleByPlatformId(2,3),
            'page' => ArticleManager::countArticleByPlatform(2) /3,
        ]);
    }

    public function xbox()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/xbox', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(3, 3),
                    'page' => ArticleManager::countArticleByPlatform(3),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/xbox', $data = [
                'article' => ArticleManager::getArticleByPlatformId(3, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleByPlatform(3) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/xbox', $data = [
            'article' => ArticleManager::getArticleByPlatformId(3,3),
            'page' => ArticleManager::countArticleByPlatform(3) /3,
        ]);
    }

    public function nintendo()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/nintendo', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(4, 3),
                    'page' => ArticleManager::countArticleByPlatform(4),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/nintendo', $data = [
                'article' => ArticleManager::getArticleByPlatformId(4, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleByPlatform(4) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/nintendo', $data = [
            'article' => ArticleManager::getArticleByPlatformId(4,3),
            'page' => ArticleManager::countArticleByPlatform(4) /3,
        ]);
    }

    public function tests()
    {
        //vérifie si page est dans l'URL
        if (isset($_GET['page'])) {

            if ($_GET['page'] === 1) {
                $this->render('pages/game/tests', $data = [
                    'article' => ArticleManager::getArticleBySectionId(2, 3),
                    'page' => ArticleManager::countArticleBySection(2),
                ]);
                exit();
            }
            //calcul le nombre d'article par page
            $this->render('pages/game/tests', $data = [
                'article' => ArticleManager::getArticleByPlatformId(2, 3, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleBySection(2) /3 ,
            ]);
            exit();
        }
        //si page pas set
        $this->render('pages/game/tests', $data = [
            'article' => ArticleManager::getArticleByPlatformId(2,3),
            'page' => ArticleManager::countArticleBySection(2) /3,
        ]);
    }

    public function userSpace()
    {
        $this->render('user/userSpace');
    }

    public function viewArticle($id)
    {
        $this->render('pages/viewArticle', $data=[$id]);
    }
}