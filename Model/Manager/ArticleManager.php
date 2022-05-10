<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Article;
use App\Model\Entity\Section;
use DateTime;

class ArticleManager
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function findAllArticle(int $limit = 0, int $offset = 0): array
    {
        $articles = [];

        if($limit === 0) {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_article ORDER BY id DESC LIMIT 3 OFFSET $offset");
        }
        else {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_article ORDER BY id DESC LIMIT 4");
        }

            $userManager = new UserManager();

            foreach ($stmt as $articleData) {
                $articles[] = (new Article())
                    ->setId($articleData['id'])
                    ->setTitle($articleData['title'])
                    ->setContent($articleData['content'])
                    ->setResume($articleData['resume'])
                    ->setImage($articleData['image'])
                    ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $articleData['date']))
                    ->setUser($userManager->getUser($articleData['user_id']))
                    ;
        }
        return $articles;
    }

    /**
     * Select an article by its id
     * @param int $id
     * @return Article
     */
    public static function getArticle(int $id): Article
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_article WHERE id = '$id'");
        $stmt = $stmt->fetch();

        return (new Article())
            ->setId($id)
            ->setContent($stmt ['content'])
            ->setTitle($stmt['title'])
            ->setImage($stmt['image'])
            ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $stmt['date']))
            ->setUser(UserManager::getUser($stmt['user_id']))
            ;
    }

    public static function countArticle()
    {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM jvp_article");
        return $stmt->fetch()['COUNT(*)'];
    }

    public static function countArticleByPlatform($id)
    {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM jvp_platform_article WHERE jvp_plateform_id = $id");
        return $stmt->fetch()['COUNT(*)'];
    }

    public static function countArticleBySection($id)
    {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM jvp_section WHERE id = $id");
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * @param Article $article
     * @return bool
     */
    public static function addArticle(Article $article): bool
    {
        $stmt= DB::getPDO()->prepare("
            INSERT INTO jvp_article (title, content, resume, image, user_id, section_id) 
            VALUES (:title, :content, :resume, :image, :user_id, :section_id )
        ");

        $stmt->bindValue('title', $article->getTitle());
        $stmt->bindValue('content', $article->getContent());
        $stmt->bindValue('resume', $article->getResume());
        $stmt->bindValue('image', $article->getImage());
        $stmt->bindValue('user_id', $article->getUser()->getId());
        $stmt->bindValue('section_id', $article->getSection()->getId());

        $result = $stmt->execute();
        $article->setID(DB::getPDO()->lastInsertId());

        if($result) {
            $platformFromDb = PlatformManager::getAllPlatforms();
            foreach ($platformFromDb as $data) {
                if (isset($_POST['plat_' . $data->getId()])) {
                    $resultArticlePlatform = DB::getPDO()->exec("
                    INSERT INTO jvp_platform_article (jvp_article_id, jvp_plateform_id) VALUES (" . $article->getId() . ",
                    " . $data->getId() . ")
                    ");
                }
            }

            $categoryFromDb = CategoryManager::getAllCategories();
            foreach ($categoryFromDb as $data) {
                if (isset($_POST['cat_' . $data->getId()])) {
                    $resultArticleCategory = DB::getPDO()->exec("
                    INSERT INTO jvp_category_article (jvp_article_id, jvp_category_id) VALUES (" . $article->getId() . ", 
                    " . $data->getId() . ")
            ");
                }
            }
        }
        return $result && $resultArticlePlatform && $resultArticleCategory  ;
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

    /**
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getArticleBySectionId(int $id, int $limit = 0, int $offset = 0 ): array
    {
        $article = [];
        if ($limit === 3) {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_article WHERE section_id = '$id' ORDER BY id DESC 
                    LIMIT 3 OFFSET $offset
            ");
        }
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_article WHERE section_id = '$id' ORDER BY id DESC ");

        if($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $article [] = (new Article())
                    ->setId($data['id'])
                    ->setTitle($data['title'])
                    ->setImage($data['image'])
                    ->setResume($data['resume'])
                ;
            }
        }
        return $article;
    }

    /**
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getArticleByPlatformId(int $id, int $limit = 0, int $offset = 0): array
    {
        $article = [];
        if ($limit === 3) {
            $stmt = DB::getPDO()->query("
            SELECT jvp_article.id, jvp_article.image, jvp_article.resume, jvp_article.title FROM jvp_platform_article
             INNER JOIN jvp_article ON jvp_platform_article.jvp_article_id = jvp_article.id  WHERE jvp_platform_article.jvp_plateform_id
            = '$id' ORDER BY jvp_article.id DESC LIMIT 3 OFFSET $offset
         ");
        }
        else {
            $stmt = DB::getPDO()->query("
            SELECT jvp_article.id, jvp_article.image, jvp_article.resume, jvp_article.title FROM jvp_platform_article
             INNER JOIN jvp_article ON jvp_platform_article.jvp_article_id = jvp_article.id  WHERE jvp_platform_article.jvp_plateform_id
            = '$id' ORDER BY jvp_article.id DESC
         ");
        }


        foreach ($stmt->fetchAll() as $data) {
            $article[] = (new Article())
                ->setId($data['id'])
                ->setTitle($data['title'])
                ->setImage($data['image'])
                ->setResume($data['resume'])
            ;
        }

        return $article;
    }

    /**
     * @param $newTitle
     * @param $newContent
     * @param $id
     */
    public static function updateArticle($newTitle, $newContent, $id)
    {
        $stmt = DB::getPDO()->prepare("UPDATE jvp_article 
        SET content = :newContent, title = :newTitle WHERE id = :id");

        $stmt->bindParam('newTitle', $newTitle);
        $stmt->bindParam('newContent', $newContent);
        $stmt->bindParam('id', $id);

        $stmt->execute();
    }

    /**
     * @param Article $article
     * @return false|int
     */
    public static function deleteArticle(Article $article): bool
    {
        if (self::articleExist($article->getId())) {
            return DB::getPDO()->exec(
                "DELETE FROM jvp_article WHERE id = {$article->getId()}
            ");
        }
        return false;
    }

    /**
     * @param $contentSearch
     * @return array
     */
    public static function searchArticle($contentSearch): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare("
            SELECT DISTINCT jvp_article.title, jvp_article.image, jvp_article.resume, jvp_article.id FROM jvp_category_article
                INNER JOIN jvp_article ON jvp_category_article.jvp_article_id = jvp_article.id INNER JOIN jvp_category 
                ON jvp_category_article.jvp_category_id = jvp_category.id WHERE jvp_article.title LIKE '%$contentSearch%'
                OR jvp_category.category_name LIKE '%$contentSearch%' ORDER BY id DESC 
        ");

        $stmt->execute();

        foreach ($stmt->fetchAll() as $data) {
            $article [] = (new Article())
                ->setTitle($data['title'])
                ->setResume($data['resume'])
                ->setImage($data['image'])
            ;
        }
        return $article;
    }

    /**
     * @param $search
     * @return array
     */
    public static function getArticleBySearch($search): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare(" 
            SELECT id, title FROM jvp_article WHERE title LIKE '%$search%' ORDER BY id DESC LIMIT 3
        ");
        $stmt->execute();

        foreach ($stmt->fetchAll() as $data) {
            $article[] = [
                "id" => $data['id'],
                "title" => $data['title'],
            ];
        }
        return $article;
    }
}