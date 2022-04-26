<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Article;

class ArticleManager
{
    /**
     * @param int $limit
     * @return array
     */
    public static function getArticleById(int $limit = 0): array
    {
        $articles = [];

        if($limit === 0) {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_article ORDER BY id DESC ");
        }
        else {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_article ORDER BY id DESC LIMIT" . $limit);
        }

            $userManager = new UserManager();
            $categoryManager = new CategoryManager();
            $platformManager = new PlatformManager();

            foreach ($stmt->fetchAll() as $articleData) {
                $articles[] = (new Article())
                    ->setId($articleData['id'])
                    ->setTitle($articleData['title'])
                    ->setContent($articleData['content'])
                    ->setImage($articleData['image'])
//                    ->setDate($articleData['date'])
                    ->setUser($userManager->getUserById($articleData['user_id']))
                    ->setCategory($categoryManager->getCategoryByName($articleData['category_id']))
                    ->setPlatform($platformManager->getPlatformByName($articleData['platform_id']))
                    ;
        }
        return $articles;
    }

    /**
     * @param Article $article
     * @return bool
     */
    public static function addArticle(Article $article): bool
    {
        $stmt= DB::getPDO()->prepare("
            INSERT INTO jvp_article (title, content, image, user_id, platform_id, category_id, section_id) 
            VALUES (:title, :content, :image, :user_id, :platform_id, :category_id, :section_id )
        ");

        $stmt->bindValue('title', $article->getTitle());
        $stmt->bindValue('content', $article->getContent());
        $stmt->bindValue('image', $article->getImage());
//        $stmt->bindValue('date', $article->getDate());
        $stmt->bindValue('user_id', $article->getUser()->getId());
        $stmt->bindValue('category_id', $article->getCategory()->getId());
        $stmt->bindValue('platform_id', $article->getPlatform()->getId());
        $stmt->bindValue('section_id', $article->getSection()->getId());

        return $stmt->execute();
    }

    /**
     * @param $id
     * @return int|mixed
     */
    public static function articleExist($id)
    {
        $stmt = DB::getPDO()->query("SELECT count(*) FROM jvp_article WHERE id = '$id'");
        return $stmt ? $stmt->fetch(): 0;
    }

    public static function articleCategory(int $id): array
    {
        $article = [];
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_article WHERE category_id = '$id' ORDER BY id DESC");

        foreach ($stmt->fetchAll() as $articleData) {
            $article[] = (new Article())
            ->setId($articleData['id'])
            ->setTitle($articleData['title'])
            ->setContent($articleData['content'])
            ->setImage($articleData['image'])
            ;
        }
        return $article;
    }

    public static function updateArticle()
    {

    }

    public static function deleteArticle()
    {

    }
}