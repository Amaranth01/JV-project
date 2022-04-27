<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Comment;

class CommentManager
{

    public function addNewComment(Comment $comment): bool
    {
        $stmt = DB::getPDO()->prepare("
           INSERT INTO jvp_comment(content, user_id) VALUES (:content, :user_id) 
        ");

        $stmt->bindValue('content', $comment->getContent());
        $stmt->bindValue('user_id', $comment->getUser()->getId());

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
                ;
            }
        }
        return $comment;
    }
}