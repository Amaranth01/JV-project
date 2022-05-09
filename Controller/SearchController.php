<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Manager\ArticleManager;

class SearchController extends AbstractController
{
    public function searching()
    {
        if (isset($_POST) && !empty($_POST['search'])) {
            $contentSearch = $this->clean($_POST['search']);
            $result = ArticleManager::searchArticle($contentSearch);
            if ($result === []) {
                $this->render('pages/searchNull');
                exit();
            }
            $this->render('pages/search', $result);
        }
        else {
            $this->render('pages/searchNull');
        }
    }
}