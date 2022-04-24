<?php

namespace App\Controller;

class UserController extends AbstractController
{
    public function delete() {
        $this->render('user/delete');
    }
}