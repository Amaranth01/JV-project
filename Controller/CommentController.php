<?php

namespace App\Controller;

use App\Model\Entity\Comment;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\CommentManager;
use App\Model\Manager\UserManager;

class CommentController extends AbstractController
{
    public function allComment()
    {
        $this->render('comment/allComment');
    }

    public function updateComment(int $id)
    {
        $this->render('comment/editComment', $data=[$id]);
    }

    /**
     * @param int $id
     */
    public function addComment(int $id)
    {
        $content = $this->clean($this->getFormField('content'));

        //Check that the fields are free, otherwise we exit
        $errorMessage = "Le champ doit être rempli";
        if(empty($content)) {
            $_SESSION['errors'] = $errorMessage;
            $this->render('home/index');
            echo "le champ doit être rempli";
            exit();
        }

        //Checks if the user is logged in
        $user = self::getConnectedUser();
        if($user === null) {
            $errorMessage = "Il faut être connecter pour pouvoir écrire un commentaire";
            $_SESSION['errors'] = $errorMessage;
            $this->render('home/index');
        }

        //checking that the article exists by its ID
        $article = ArticleManager::articleExist($id);
        if($article === false) {
            $this->render('home/index');
            exit();
        }
        //Creating a new comment object
        $comment = (new Comment())
            ->setContent($content)
            ->setUser($user)
            ->setArticle(ArticleManager::getArticle($id))
        ;

        $commentManager = new CommentManager();
        $commentManager->addNewComment($comment);
        $this->render('home/index');
    }

    public function editComment($id)
    {
//        self::userConnected();
        if(!isset($_POST['content'])) {
            $this->render('home/index');
            exit();
        }

        $newContent = $_POST['content'];

        $comment = new CommentManager($newContent, $id);
        $comment->editComment($newContent, $id);
        $this->render('pages/viewArticle');
    }

    public function deleteComment(int $id)
    {
        //        if(self::adminConnected()) {
//            $errorMessage = "Seul un administrateur peut supprimer un article";
//            $_SESSION['errors'] [] = $errorMessage;
//            $this->render('home/index');
//        }

        if(CommentManager::commentExist($id)) {
            $comment = CommentManager::getComment($id);
            $deleted = CommentManager::deleteComment($comment);
            $this->render('home/index');
        }
    }
}