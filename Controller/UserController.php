<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Manager\RoleManager;
use App\Model\Manager\UserManager;
use Exception;

class UserController extends AbstractController
{
    public function index()
    {
        $this->render('user/userSpace');
    }

    public function delete() {
        $this->render('user/delete');
    }

    public function register()
    {
        ////Cleans and return the security of elements
        if ($this->formSubmitted()) {
            $username = $this->clean($this->getFormField('username'));
            $email = $this->clean($this->getFormField('email'));
            $password = $this->getFormField('password');
            $passwordR = $this->getFormField('passwordR');

            $mail = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Send a message if the email address is not valid.
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errors'] = "L'adresse mail n'est pas valide";
            }

            // Returns an error if the username is not 2 characters
            if (!strlen($username) >= 2) {
                $_SESSION['errors'] = "Le nom, ou pseudo, doit faire au moins 2 caractères";
            }

            // Returns an error if the password does not contain all the requested characters.
            if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password)) {
                $_SESSION['errors'] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
            }

            // Passwords do not match
            if ($password !== $passwordR) {
                $_SESSION['errors'] = "Les mots de passe ne correspondent pas";
            }

            else {
                //If no error is detected the program goes to else and authorizes the recording
                $user = new User();
                $role = RoleManager::getRoleByName('user');
                $user
                    ->setUsername($username)
                    ->setEmail($mail)
                    ->setPassword(password_hash($password, PASSWORD_DEFAULT))
                    ->setRole($role)
                ;
                //If no email is found, we launch the addUser function

                if(0 == UserManager::getUserByMail($user->getEmail())) {

                    UserManager::addUser($user);
                    //If the ID is not null, we pass the user in the session
                    if (null!== $user->getId()) {
                        $_SESSION['success'] = "Félicitations votre compte a bien été créé, un mail vous sera envoyé
                         pour activer votre compte";
                        $user->setPassword('');
                        $_SESSION['user'] = $user;
                    }
                    else {
                        $_SESSION['errors'] = "Impossible de vous enregistrer";
                    }
                }
                else {
                    $_SESSION['errors'] = "Cette adresse mail existe déjà !";
                }
            }
        }
        $this->render('home/index');

        }

        public function connexion()
        {
            if($this->formSubmitted()) {
                $username = $this->clean($this->getFormField('username'));
                $password = $this->getFormField('password');

                //Check that the fields are not empty
                if (empty($password) && empty($username)) {
                    $errorMessage = "Veuillez remplir tous les champs";
                    $_SESSION['errors'] = $errorMessage;
                    $this->render('home/index');
                    exit();
                }

                //Traces the user by his username to verify that he exists
                $user = UserManager::getUserByName($username);
                if (null === $user) {
                    $errorMessage = "Pseudo inconnu";
                    $_SESSION['errors'] = $errorMessage;
                }
                else {
                    //Compare the password entered and written in the DB
                    if (password_verify($password, $user->getPassword())) {
                        $user->setPassword('');
                        $_SESSION['user'] = $user;
                    }
                    else {
                        $_SESSION['errors'] = "Le nom d'utilisateur, ou le mot de passe est incorrect";
                    }
                }
            }
            else {
                $successMessage = "Vous êtes connecté";
                $_SESSION['success'] = $successMessage;
            }
            $this->render('home/index');
        }

    /**
     * @param int $id
     */
    public function deleteUser(int $id)
    {
        //Verify that the user has admin status
        if(self::adminConnected()) {
            $errorMessage = "Seul un administrateur peut supprimer un utilisateur";
            $_SESSION['errors'] [] = $errorMessage;
            $this->render('home/index');
        }

        if(UserManager::getUser($id)) {
            $user = UserManager::getUser($id);
            $deleted = UserManager::deleteUser($user);
            $this->render('home/index');
        }
    }

    /**
     * @param $id
     */
    public function updateUsername($id)
    {
        if (!isset($_POST['newUsername'])) {
            $this->render('home/index');
            exit();
        }

        if (empty($_POST['newUsername'])) {
            $_SESSION['errors'] = "Le champs du pseudo doit être complété";
            $this->render('home/index');
            exit();
        }

        $newUsername = $this->clean($_POST['newUsername']);

        $user = new UserManager();
        $user->updateUsername($newUsername, $id);
        $_SESSION['success'] = "Votre pseudo a bien été mis à jour";
        $this->render('home/index');
    }

    public function updateEmail($id)
    {

        if (!isset($_POST['newEmail'])) {
            $this->render('home/index');
            exit();
        }

        if (empty($_POST['newEmail'])) {
            $_SESSION['errors'] = "Le champs de l'email doit être complété";
            $this->render('home/index');
            exit();
        }

        $newEmail = $this->clean($_POST['newEmail']);
        $user = new UserManager();
        $user->updateEmail($newEmail, $id);
        $_SESSION['success'] = "Votre mail a bien été mis à jour, un email vous sera envoyé pour confirmer votre nouvelle 
            adresse";
        $this->render('home/index');
    }

    public function updatePassword($id)
    {
        if (!isset($_POST['newPassword']) && !isset($_POST['newPasswordR'])) {
            $this->render('home/index');
            exit();
        }

        if (empty($_POST['newPassword'])) {
            $_SESSION['errors'] = "Le champs du pseudo doit être complété";
            $this->render('home/index');
            exit();
        }

        $newPassword = $this->getFormField('newPassword');
        $newPasswordR = $this->getFormField('newPasswordR');

        if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $newPassword)) {
            $error[] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
        }

        // Passwords do not match
        if ($newPassword !== $newPasswordR) {
            $error[] = "Les mots de passe ne correspondent pas";
        }
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $user = new UserManager();
        $user->updatePassword($newPassword, $id);
        $_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
        $this->render('home/index');
    }

    /**
     * @throws Exception
     */
    public function userImage($id)
    {
        if(!isset($_SESSION['user'])) {
            $_SESSION['errors'] = "Seul un utilisateur peut changer son image";
            $this->render('home/index');
        }

        $user = new UserManager();
        $newImage = $this->addImage();
        $user->userImage($newImage, $id);
        $this->render('user/userSpace');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function addImage(): string
    {
        $name = "";
        if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){

            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            if(in_array($_FILES['img']['type'], $allowedMimeTypes)) {

                $maxSize = 1024 * 1024;
                if ((int)$_FILES['img']['size']<=$maxSize) {
                    $tmp_name = $_FILES['img']['tmp_name'];
                    $name = $this->getRandomName($_FILES['img']['name']);

                    if(!is_dir('uploads')){
                        mkdir('uploads');
                    }
                    move_uploaded_file($tmp_name,'../public/assets/img/avatar/' . $name);
                }
                else {
                    $_SESSION['errors'] =  "Le poids est trop lourd, maximum autorisé : 1 Mo";
                }
            }
            else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats JPD, JPEG et PNG sont acceptés";
            }
        }
        else {
            $_SESSION['errors'] = "Une erreur s'est produite";
        }
        return $name;
    }

    /**
     * @param string $rName
     * @return string
     */
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

    /**
     * changing the role of a user
     */
    public function updateUserRole()
    {
        if(self::adminConnected()) {
            $errorMessage = "Seul un administrateur peut mettre à jour un utilisateur";
            $_SESSION['errors'] [] = $errorMessage;
            $this->render('home/index');
        }

        if (!isset($_POST['username'])) {
            $this->render('home/index');
            exit();
        }
        $username = $this->clean($this->getFormField('username'));
        $user = new UserManager();
        $newRole = $_POST['role'];

        if ($username !== UserManager::getUserByName($_POST['username'])->getUsername())  {
            $_SESSION['errors'] = "Le pseudo est incorrecte";
            $this->render('admin/adminSpace');
        }
        else {
            $user->updateRoleUser($newRole, $username);
        }
        $this->render('admin/adminSpace');
    }
}