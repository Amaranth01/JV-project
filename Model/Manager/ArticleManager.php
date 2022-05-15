<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Article;
use App\Model\Entity\Section;
use DateTime;

class ArticleManager
{
    public const PREFIXTABLE = 'jvp_';

    /**
     * Search all articles to display them
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function findAllArticle(int $limit = 0, int $offset = 0): array
    {
        $articles = [];

        if($limit === 0) {
            $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "article ORDER BY id DESC LIMIT 6 OFFSET $offset");
        }
        else {
            $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "article ORDER BY id DESC LIMIT 4");
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
        $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "article WHERE id = '$id'");
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

    /**
     * Count the article for pagination
     * @return mixed
     */
    public static function countArticle()
    {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM " . self::PREFIXTABLE . "article");
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * Count the article by platform for the pagination
     * @param $id
     * @return mixed
     */
    public static function countArticleByPlatform($id)
    {
        $stmt = DB::getPDO()->query("
            SELECT COUNT(*) FROM " . self::PREFIXTABLE . "platform_article WHERE " . self::PREFIXTABLE . "platform_id = $id"
        );
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * Count the article by section for the pagination
     * @param $id
     * @return mixed
     */
    public static function countArticleBySection($id)
    {
        $stmt = DB::getPDO()->query("SELECT COUNT(*) FROM " . self::PREFIXTABLE . "section WHERE id = $id");
        return $stmt->fetch()['COUNT(*)'];
    }

    /**
     * Add an article to the DB
     * @param Article $article
     * @return bool
     */
    public static function addArticle(Article $article): bool
    {
        $stmt= DB::getPDO()->prepare("
            INSERT INTO " . self::PREFIXTABLE . "article (title, content, resume, image, user_id, section_id, date) 
            VALUES (:title, :content, :resume, :image, :user_id, :section_id, :date )
        ");

        $stmt->bindValue(':title', $article->getTitle());
        $stmt->bindValue(':content', $article->getContent());
        $stmt->bindValue(':resume', $article->getResume());
        $stmt->bindValue(':image', $article->getImage());
        $stmt->bindValue(':user_id', $article->getUser()->getId());
        $stmt->bindValue(':section_id', $article->getSection()->getId());
        $stmt->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));

        $result = $stmt->execute();
        $article->setID(DB::getPDO()->lastInsertId());

        if($result) {
            //Get platforms for the sort
            $platformFromDb = PlatformManager::getAllPlatforms();
            foreach ($platformFromDb as $data) {
                //Get the prefix plat_ and get the id of the platform
                if (isset($_POST['plat_' . $data->getId()])) {
                    //Execute the result
                    $resultArticlePlatform = DB::getPDO()->exec("
                    INSERT INTO " . self::PREFIXTABLE . "platform_article (" . self::PREFIXTABLE . "article_id, 
                    " . self::PREFIXTABLE . "platform_id) VALUES (" . $article->getId() . "," . $data->getId() . ")
                    ");
                }
            }

            //Get category for the sort
            $categoryFromDb = CategoryManager::getAllCategories();
            foreach ($categoryFromDb as $data) {
                ////Get the prefix cat_ and get the id of the platform
                if (isset($_POST['cat_' . $data->getId()])) {
                    //Execute the result
                    $resultArticleCategory = DB::getPDO()->exec("
                    INSERT INTO " . self::PREFIXTABLE . "category_article (jvp_article_id, jvp_category_id) VALUES (" . $article->getId() . ", 
                    " . $data->getId() . ")
            ");
                }
            }
        }
        return $result && $resultArticlePlatform && $resultArticleCategory  ;
    }

    /**
     * Check if the article exist
     * @param $id
     * @return int|mixed
     */
    public static function articleExist($id)
    {
        $stmt = DB::getPDO()->query("SELECT count(*) FROM " . self::PREFIXTABLE . "article WHERE id = '$id'");
        return $stmt ? $stmt->fetch(): 0;
    }

    /**
     *
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getArticleBySectionId(int $id, int $limit = 0, int $offset = 0 ): array
    {
        $article = [];
        if ($limit === 6) {
            $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "article WHERE section_id = '$id' ORDER BY id DESC 
                    LIMIT 3 OFFSET $offset
            ");
        }
        $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "article WHERE section_id = '$id' ORDER BY id DESC ");

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
     * Search an article by their section ID
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getArticleByPlatformId(int $id, int $limit = 0, int $offset = 0): array
    {
        $article = [];
        //Shows only 6 article
        if ($limit === 6) {
            $stmt = DB::getPDO()->query("
            SELECT " . self::PREFIXTABLE . "article.id, " . self::PREFIXTABLE . "article.image, 
            " . self::PREFIXTABLE . "article.resume, " . self::PREFIXTABLE . "article.title FROM 
            " . self::PREFIXTABLE . "platform_article INNER JOIN " . self::PREFIXTABLE . "article ON 
            " . self::PREFIXTABLE . "platform_article." . self::PREFIXTABLE . "article_id = " . self::PREFIXTABLE . "article.id  
            WHERE " . self::PREFIXTABLE . "platform_article." . self::PREFIXTABLE . "platform_id = '$id' ORDER BY 
            " . self::PREFIXTABLE . "article.id DESC LIMIT 6 OFFSET $offset
         ");
        }
        else {
            //shows all articles
            $stmt = DB::getPDO()->query("
            SELECT " . self::PREFIXTABLE . "article.id, " . self::PREFIXTABLE . "article.image, 
            " . self::PREFIXTABLE . "article.resume, " . self::PREFIXTABLE . "article.title FROM 
            " . self::PREFIXTABLE . "platform_article INNER JOIN " . self::PREFIXTABLE . "article ON 
            " . self::PREFIXTABLE . "platform_article." . self::PREFIXTABLE . "article_id = " . self::PREFIXTABLE . "article.id  
            WHERE " . self::PREFIXTABLE . "platform_article." . self::PREFIXTABLE . "platform_id = '$id' 
            ORDER BY " . self::PREFIXTABLE . "article.id DESC
         ");
        }

        //Get the requested data in an array
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
     * update an article in DB
     * @param $newTitle
     * @param $newContent
     * @param $id
     */
    public static function updateArticle($newTitle, $newContent, $id)
    {
        $stmt = DB::getPDO()->prepare("UPDATE " . self::PREFIXTABLE . "article 
        SET content = :newContent, title = :newTitle WHERE id = :id");

        $stmt->bindParam(':newTitle', $newTitle);
        $stmt->bindParam(':newContent', $newContent);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * Delete an article from the DB
     * @param Article $article
     * @return false|int
     */
    public static function deleteArticle(Article $article): bool
    {
        //Check if the article exist
        if (self::articleExist($article->getId())) {
            return DB::getPDO()->exec(
                "DELETE FROM " . self::PREFIXTABLE . "article WHERE id = {$article->getId()}
            ");
        }
        return false;
    }

    /**
     * Search an article for the search tool
     * @param $contentSearch
     * @return array
     */
    public static function searchArticle($contentSearch): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare("
            SELECT DISTINCT " . self::PREFIXTABLE . "article.title, " . self::PREFIXTABLE . "article.image, 
            " . self::PREFIXTABLE . "article.resume, " . self::PREFIXTABLE . "article.id FROM " . self::PREFIXTABLE . "category_article
            INNER JOIN " . self::PREFIXTABLE . "article ON " . self::PREFIXTABLE . "category_article.jvp_article_id = 
            " . self::PREFIXTABLE . "article.id INNER JOIN " . self::PREFIXTABLE . "category ON 
            " . self::PREFIXTABLE . "category_article.jvp_category_id = " . self::PREFIXTABLE . "category.id WHERE 
            " . self::PREFIXTABLE . "article.title LIKE '%$contentSearch%' OR " . self::PREFIXTABLE . "category.category_name 
            LIKE '%$contentSearch%' ORDER BY id DESC 
        ");

        $stmt->execute();

        //Get the requested data in an array
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
     * Get article after the search
     * @param $search
     * @return array
     */
    public static function getArticleBySearch($search): array
    {
        $article = [];
        $stmt = DB::getPDO()->prepare(" 
            SELECT id, title FROM " . self::PREFIXTABLE . "article WHERE title LIKE '%$search%' ORDER BY id DESC LIMIT 3
        ");
        $stmt->execute();
        //Get the requested data in an array
        foreach ($stmt->fetchAll() as $data) {
            $article[] = [
                "id" => $data['id'],
                "title" => $data['title'],
            ];
        }
        return $article;
    }
}