<?php

namespace App\Controller;

class LogoutController extends AbstractController
{
    function logout()
    {
        //Destroy all sessions
        $_SESSION = array();

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 60000, $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);

        session_destroy();

        $this->render('home/index');
        $_SESSION['success'] = "Vous êtes déconnecté";
    }
}