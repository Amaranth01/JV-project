<?php

namespace App\Controller;

class CommentController extends AbstractController
{
    public function allComment()
    {
        $this->render('comment/allComment');
    }
}