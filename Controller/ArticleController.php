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
        //Redirecting to the writer's space
        $this->render('writer/writer');
    }

    public function addArticle()
    {
        //Retrieves and cleans form fields
        $title = $this->clean($this->getFormField('title'));
        $resume = $this->clean($this->getFormField('resume'));
        //Cleans the field and allows some tags
        $content = html_entity_decode(strip_tags($_POST['content'],'<div><p><img><h1><h2><h3><h4><h5><br><span><strong><a><em>'));

        //Checking if the writer is logged in
        $user = self::getConnectedWriter();

        //Get section data
        $section = SectionManager::getSectionByName($_POST['section']);

        //Creating a new article object
        $article = (new Article())
            ->setTitle($title)
            ->setContent($content)
            ->setResume($resume)
            ->setImage($this->addImage())
            ->setUser($user)
            ->setSection($section)
        ;

        //Add the article
        ArticleManager::addArticle($article);

        //Get categories and articles for sorting
        CategoryManager::getAllCategories();
        PlatformManager::getAllPlatforms();

        //Redirection to the writer's area
        $this->render('writer/writer');
    }

    /**
     * Add an image for an article
     * @return string
     */
    public function addImage(): string
    {
        $name = "";
        $error = [];
        //Checking the presence of the form field
        if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){

            //Defining allowed file types for the secured
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];

            if(in_array($_FILES['img']['type'], $allowedMimeTypes)) {
                //Setting the maximum size
                $maxSize = 1024 * 1024;
                if ((int)$_FILES['img']['size'] <= $maxSize) {
                    //Get the temporary file name
                    $tmp_name = $_FILES['img']['tmp_name'];
                    //Assignment of the final name
                    $name = $this->getRandomName($_FILES['img']['name']);

                    //Checks if the destination file exists, otherwise it is created
                    if(!is_dir('uploads')){
                        mkdir('uploads');
                    }
                    //File move
                    move_uploaded_file($tmp_name,'../public/uploads/' . $name);
                }
                else {
                    $_SESSION['errors'] =  "Le poids est trop lourd, maximum autorisé : 1 Mo";
                    $this->render('writer/writer');
                    exit();
                }
            }
            else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats JPG, JPEG et PNG sont acceptés";
                $this->render('writer/writer');
                exit();
            }
        }
        else {
            $_SESSION['errors'] = "Une erreur s'est produite";
            $this->render('writer/writer');
            exit();
        }
        $_SESSION['error'] = $error;
        return $name;
    }

    /**
     * Set a random name for the image
     * @param string $rName
     * @return string
     */
    private function getRandomName(string $rName): string
    {
        //Get file extension
        $infos = pathinfo($rName);
        try {
            //Generates a random string of 15 chars
            $bytes = random_bytes(15);
        }
        catch (Exception $e) {
            //Is used on failure
            $bytes = openssl_random_pseudo_bytes(15);
        }
        //Convert binary data to hexadecimal
        return bin2hex($bytes) . '.' . $infos['extension'];
    }

    /**
     * @param $id
     */
    public function editArticle($id)
    {
        //Checks if the writer is logged in
        if(!self::writerConnected()){
            $_SESSION['errors'] = "Seul un rédacteur peut modifier un article";
            $this->render('home/index');
        }

        //Checks if the title and content fields are present
        if(!isset($_POST['title'])&& !isset($_POST['content'])) {
            $this->render('home/index');
            exit();
        }
        //Cleans up data
        $newTitle = $this->clean($_POST['title']);
        $newContent = strip_tags($_POST['content'],
            '<div><p><img><h1><h2><h3><h4><h5><br><span><strong><a><em>');
        //Manager recovery
        $article= new ArticleManager($newTitle, $newContent, $id);
        $article->updateArticle($newTitle, $newContent, $id);
        //Redirects to the writers page
        $this->render('writer/writer');
    }

    /**
     * @param int $id
     */
    public function deleteArticle(int $id)
    {
        //Verify if a user is connected
        if(!isset($_SESSION['user'])) {
            $_SESSION['errors'] = "Seul un rédacteur peut supprimer un article";
            $this->render('home/index');
        }
        //verify who is connected
        if($_SESSION['user']->getRole()->getRoleName() === 'user') {
            $_SESSION['errors'] = "Seul un rédacteur peut supprimer un article";
            $this->render('home/index');
        }
        if (self::writerConnected()) {
            //Check that the article exists
            if(ArticleManager::articleExist($id)) {
                $article = ArticleManager::getArticle($id);
                $deleted = ArticleManager::deleteArticle($article);
                $this->render('writer/writer');
            }
        }
    }

}