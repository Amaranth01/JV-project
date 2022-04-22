<?php

namespace App\Controller;

use App\Controller\AbstractController;

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

    public function nintendo()
    {
        $this->render('pages/game/nintendo');
    }

    public function pc()
    {
        $this->render('pages/game/pc');
    }

    public function playstation()
    {
        $this->render('pages/game/playstation');
    }

    public function tests()
    {
        $this->render('pages/game/tests');
    }

    public function xbox()
    {
        $this->render('pages/game/xbox');
    }
}