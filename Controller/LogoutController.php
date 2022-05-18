<?php

namespace App\Controller;

use App\Model\Manager\ArticleManager;

class LogoutController extends AbstractController
{
    function logout()
    {
        //Destroy all sessions data
        $_SESSION = array();

        //Destroy browser cookie sessions
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 60000, $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        //Destroy the session
        session_destroy();
        //Redirecting to home page
        $this->render('home/index', $data = [
            'article' => ArticleManager::findAllArticle(4),
            'sectionTwo' => ArticleManager::getArticleBySectionId(2),
            'sectionFive' => ArticleManager::getArticleBySectionId(5),
        ]);
        //Send a success message
        $_SESSION['success'] = "Vous êtes déconnecté";
    }
}