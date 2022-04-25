<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Article;

class ArticleManager
{
    public static function getArticleById()
    {
        $articles = [];
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_article");
        if($stmt) {
            $userManager = new UserManager();
            $categoryManager = new CategoryManager();
            $platformManager = new PlatformManager();

            foreach ($stmt->fetchAll() as $articleData) {
                $articles[] = (new Article())
                    ->setId($articleData['id'])
                    ->setTitle($articleData['title'])
                    ->setContent($articleData['content'])
                    ->setImage($articleData['image'])
                    ->setDate($articleData['date'])
                    ->setUser($userManager->getUserById($articleData['user_id']))
                    ->setCategory($categoryManager->getCategoryById($articleData['category_id']))
                    ->setPlatform($platformManager->getPlatformById($articleData['platform_id']))
                    ;
            }
        }
    }
}