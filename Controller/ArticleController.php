<?php

namespace App\Controller;

use App\Config;
use App\Model\Entity\Article;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\PlatformManager;
use App\Model\Manager\SectionManager;
use Exception;

class ArticleController extends AbstractController
{

    public function index()
    {
        $this->render('writer/writer');
    }

    public function addArticle()
    {
        $title = $this->clean($this->getFormField('title'));
        $content = $this->clean($this->getFormField('content'), Config::ALLOWED_TAGS);
        $resume = $this->clean($this->getFormField('resume'));
//        $date = date("j,m,Y");

        $article = new Article();
        $user = self::getConnectedUser();
        $section = SectionManager::getSectionByName($_POST['section']);

        $article->setTitle($title);
        $article->setContent($content);
        $article->setResume($resume);
        $article->setImage($this->addImage());
//        $article->setDate($date);
        $article->setUser($user);
        $article->setSection($section);

        ArticleManager::addArticle($article);
        CategoryManager::getAllCategories();
        PlatformManager::getAllPlatforms();
        $this->render('writer/writer');
    }

    private function addImage(): string
    {
        $name = "";
        $error = [];
        if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){

            $allowedMimeTypes = ['jpg', 'jpeg', 'png'];
            if(in_array($_FILES['img']['type'], $allowedMimeTypes)) {

                $maxSize = 1024 * 1024;
                if ((int)$_FILES['img']['size']<=$maxSize) {
                    $tmp_name = $_FILES['img']['tmp_name'];
                    $name = $this->getRandomName($_FILES['img']['name']);

                    if(!is_dir('uploads')){
                        mkdir('uploads', '0755');
                    }
                    move_uploaded_file($tmp_name,'../public/asset/uploads/' . $name);
                }
                else {
                    $error[] =  "Le poids est trop lourd, maximum autorisé : 1 Mo";
                }
            }
            else {
                $error[] = "Mauvais type de fichier. Seul les formats JPD, JPEG et PNG sont acceptés";
            }
        }
        else {
            $error[] = "Une erreur s'est produite";
        }
        $_SESSION['error'] = $error;
        return $name;
    }

    private function getRandomName(string $rName): string
    {
        $infos = pathinfo($rName);
        try {
            $bytes = random_bytes(15);
        }
        catch (Exception $e) {
            $bytes = openssl_random_pseudo_bytes(15);
        }
        return bin2hex($bytes) . '.' . $infos['extension'];
    }

    public function editArticle($id)
    {
        self::userConnected();
        $_SESSION['errors'] = "Seul un rédacteur peut modifier un article";
        $this->render('home/index');

        if(!isset($_POST['title'])&& !isset($_POST['content'])) {
            $this->render('home/index');
            exit();
        }

        $newTitle = $this->clean($_POST['title']);
        $newContent = $this->clean($_POST['content'], Config::ALLOWED_TAGS);

        $article= new ArticleManager($newTitle, $newContent, $id);
        $article->updateArticle($newTitle, $newContent, $id);
        $this->render('writer/writer');
    }

    public function deleteArticle(int $id)
    {
        //Verify that the user has admin status
//        if(self::adminConnected()) {
//            $errorMessage = "Seul un administrateur peut supprimer un article";
//            $_SESSION['errors'] [] = $errorMessage;
//            $this->render('home/index');
//        }
        //Check that the article exists
        if(ArticleManager::articleExist($id)) {
            $article = ArticleManager::getArticle($id);
            $deleted = ArticleManager::deleteArticle($article);
            $this->render('writer/writer');
        }
    }

}