<?php

namespace App\Controller;

class ErrorController extends AbstractController
{

    /**
     * Redirecting to the error page
     * @param string|null $paramController
     */
    public function error404(?string $paramController)
    {
        $this->render('error/404');
    }
}