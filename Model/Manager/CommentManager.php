<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Comment;

class CommentManager
{

    public function addNewComment(Comment $comment): bool
    {
        $stmt = DB::getPDO()->prepare("
           INSERT INTO jvp_comment(content, article_id ,user_id) VALUES (:content, :article_id ,:user_id) 
        ");

        $stmt->bindValue('content', $comment->getContent());
        $stmt->bindValue('user_id', $comment->getUser()->getId());
        $stmt->bindValue('article_id', $comment->getArticle()->getId());
        return $stmt->execute();
    }

    public static function findAllComment(int $limit = 0): array
    {
        $comment = [];
        //Add a limit to the number of visible comments
        if($limit === 0) {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_comment ");
        }
        else {
            $stmt = DB::getPDO()->query("SELECT * FROM jvp_comment ORDER BY id DESC LIMIT " . $limit);
        }

        if($stmt) {

            foreach ($stmt->fetchAll() as $data) {
                $comment[] = (new Comment())
                    ->setId($data['id'])
                    ->setContent($data['content'])
                    ->setUser(UserManager::getUser($data['user_id']))
                    ->setArticle(ArticleManager::getArticle($data['article_id']))
                ;
            }
        }
        return $comment;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getCommentByArticleId($id): array
    {
        $comment = [];
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_comment WHERE article_id = '$id'");

        if($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $comment[] = (new Comment())
                    ->setId($data['id'])
                    ->setContent($data['content'])
                    ->setUser(UserManager::getUser($data['user_id']))
                    ->setArticle(ArticleManager::getArticle($data['article_id']))
                ;
            }
        }
        return $comment;
    }
}