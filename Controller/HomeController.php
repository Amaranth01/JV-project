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

        $this->render('pages/news');
    }

    public function poll()
    {
        $this->render('pages/poll');
    }

    public function series()
    {
        $this->render('pages/series');
    }

    public function tchat()
    {
        $this->render('pages/tchat');
    }

    public function help()
    {
        $this->render('pages/game/help');
    }

    public function nextgame()
    {
        $this->render('pages/game/nextgame');
    }

    public function pc()
    {
        $data = [];
        $articles = ArticleManager::articlePlatform(1);
        foreach ($articles as $article) {
            $data [] = ['article' => $article];
        }
        $this->render('pages/game/pc', $data);
    }

    public function playstation()
    {
        $data = [];
        $articles = PlatformManager::getPlatformByName('playstation');
        foreach ($articles as $article) {
            $data [] = ['article' => $article];
        }
        $this->render('pages/game/playstation', $data);
    }

    public function xbox()
    {
        $data = [];
        $articles = ArticleManager::articlePlatform(3);
        foreach ($articles as $article) {
            $data [] = ['article' => $article];
        }
        $this->render('pages/game/xbox', $data);
    }

    public function nintendo()
    {
        $data = [];
        $articles = PlatformManager::getPlatformByName('nintendo');
        foreach ($articles as $article) {
            $data [] = ['article' => $article];
        }
        $this->render('pages/game/nintendo', $data);
    }

    public function tests()
    {
        $this->render('pages/game/tests');
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