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
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/news', $data = [
                    'article' => ArticleManager::findAllArticle(0),
                    'page' => ArticleManager::countArticle(),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/news', $data = [
                'article' => ArticleManager::findAllArticle(0, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticle() /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/news', $data = [
            'article' => ArticleManager::findAllArticle(0),
            'page' => ArticleManager::countArticle() /6,
        ]);
    }

    public function poll()
    {
        $this->render('pages/poll');
    }

    public function series()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/series', $data = [
                    'article' => ArticleManager::getArticleBySectionId(5, 6),
                    'page' => ArticleManager::countArticleBySection(5),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/series', $data = [
                'article' => ArticleManager::getArticleBySectionId(5, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleBySection(5) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/series', $data = [
            'article' => ArticleManager::getArticleBySectionId(5,6),
            'page' => ArticleManager::countArticleBySection(5) /6,
        ]);
    }

    public function tchat()
    {
        $this->render('pages/tchat');
    }

    public function help()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/help', $data = [
                    'article' => ArticleManager::getArticleBySectionId(3, 6),
                    'page' => ArticleManager::countArticleBySection(3),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/help', $data = [
                'article' => ArticleManager::getArticleBySectionId(3, 6, ($_GET['page'] -1) * 3),
                'page' => ArticleManager::countArticleBySection(3) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/help', $data = [
            'article' => ArticleManager::getArticleBySectionId(3,6),
            'page' => ArticleManager::countArticleBySection(3) /6,
        ]);
    }

    public function nextgame()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/nextgame', $data = [
                    'article' => ArticleManager::getArticleBySectionId(4, 6),
                    'page' => ArticleManager::countArticleBySection(4),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/nextgame', $data = [
                'article' => ArticleManager::getArticleBySectionId(4, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleBySection(4) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/nextgame', $data = [
            'article' => ArticleManager::getArticleBySectionId(4,6),
            'page' => ArticleManager::countArticleBySection(4) /6,
        ]);
    }

    public function pc()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/pc', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(1, 6),
                    'page' => ArticleManager::countArticleByPlatform(1),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/pc', $data = [
                'article' => ArticleManager::getArticleByPlatformId(1, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleByPlatform(1) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/pc', $data = [
            'article' => ArticleManager::getArticleByPlatformId(1,6),
            'page' => ArticleManager::countArticleByPlatform(1) /6,
        ]);
    }

    public function playstation()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/playstation', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(2, 6),
                    'page' => ArticleManager::countArticleByPlatform(2),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/playstation', $data = [
                'article' => ArticleManager::getArticleByPlatformId(2, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleByPlatform(2) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/playstation', $data = [
            'article' => ArticleManager::getArticleByPlatformId(2,6),
            'page' => ArticleManager::countArticleByPlatform(2) /6,
        ]);
    }

    public function xbox()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/xbox', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(3, 6),
                    'page' => ArticleManager::countArticleByPlatform(3),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/xbox', $data = [
                'article' => ArticleManager::getArticleByPlatformId(3, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleByPlatform(3) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/xbox', $data = [
            'article' => ArticleManager::getArticleByPlatformId(3,6),
            'page' => ArticleManager::countArticleByPlatform(3) /6,
        ]);
    }

    public function nintendo()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/nintendo', $data = [
                    'article' => ArticleManager::getArticleByPlatformId(4, 6),
                    'page' => ArticleManager::countArticleByPlatform(4),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/nintendo', $data = [
                'article' => ArticleManager::getArticleByPlatformId(4, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleByPlatform(4) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/nintendo', $data = [
            'article' => ArticleManager::getArticleByPlatformId(4,6),
            'page' => ArticleManager::countArticleByPlatform(4) /6,
        ]);
    }

    public function tests()
    {
        //Checks if the parameter is in the url
        if (isset($_GET['page'])) {
            //If page parameter is equal to 1 then displays the first results
            if ($_GET['page'] === 1) {
                $this->render('pages/game/tests', $data = [
                    'article' => ArticleManager::getArticleBySectionId(2, 6),
                    'page' => ArticleManager::countArticleBySection(2),
                ]);
                exit();
            }
            //If parameter present calculation of the number of articles per page
            $this->render('pages/game/tests', $data = [
                'article' => ArticleManager::getArticleBySectionId(2, 6, ($_GET['page'] -1) * 6),
                'page' => ArticleManager::countArticleBySection(2) /6 ,
            ]);
            exit();
        }
        //If page parameter is absent then displays the first results defined in SQL
        $this->render('pages/game/tests', $data = [
            'article' => ArticleManager::getArticleBySectionId(2,6),
            'page' => ArticleManager::countArticleBySection(2) /6,
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

    public function privacy()
    {
        $this->render('home/privacy');
    }

    public function legalNotice()
    {
        $this->render('home/legalNotice');
    }

}