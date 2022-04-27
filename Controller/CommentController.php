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

    public function addComment()
    {
        $content = $this->clean($this->getFormField('content'));

        //Checks if the user is logged in
        $user = self::getConnectedUser();
        $errorMessage = "Il faut être connecter pour pouvoir écrire un commentaire";
        $_SESSION['errors'] = $errorMessage;

        //Creating a new comment object
        $comment = (new Comment())
            ->setContent($content)
            ->setUser($user)
        ;

        //Check that the fields are free, otherwise we exit
        $errorMessage = "Le champ doit être rempli";
        if(empty($content)) {
            $_SESSION['errors'] = $errorMessage;
            $this->render('home/index');
            exit();
        }

        $commentManager = new CommentManager();
        $commentManager->addNewComment($comment);
        $this->render('home/index');
    }
}