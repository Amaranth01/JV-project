<?php

namespace App\Controller;

class ErrorController extends AbstractController
{

    public function error404(?string $paramController)
    {
        $this->render('error/404');
    }
}