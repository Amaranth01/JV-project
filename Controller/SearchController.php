<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Manager\ArticleManager;

class SearchController extends AbstractController
{
    public function searching()
    {
        //Checks that the field exists and is not fast
        if (isset($_POST) && !empty($_POST['search'])) {
            //Clean the field
            $contentSearch = $this->clean($_POST['search']);
            //Invoke the SQL function for a search in DB
            $result = ArticleManager::searchArticle($contentSearch);
            if ($result === []) {
                //If the result is null redirect to the null search page
                $this->render('pages/SearchNull');
                exit();
            }
            //Otherwise, redirect to the search page
            $this->render('pages/search', $result);
        }
        else {
            $this->render('pages/SearchNull');
        }
    }
}