<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    function index()
    {
        $this->render('error/404');
    }
    /**
     * Redirecting to the error page
     */
    public function error404()
    {
        self::index();
    }


}