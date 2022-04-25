<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Manager\RoleManager;
use App\Model\Manager\UserManager;

class UserController extends AbstractController
{
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

            $error = [];
            $mail = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Send a message if the email address is not valid.
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $error[] = "L'adresse mail n'est pas valide";
            }

            // Returns an error if the username is not 2 characters
            if (!strlen($username) >= 2) {
                $error[] = "Le nom, ou pseudo, doit faire au moins 2 caractères";
            }

            // Returns an error if the password does not contain all the requested characters.
            if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password)) {
                $error[] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
            }

            // Passwords do not match
            if ($password !== $passwordR) {
                $error[] = "Les mots de passe ne correspondent pas";
            }

            //Count the mistakes
            if (count($error) > 0) {
                $_SESSION['errors'] = $error;
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
                        $_SESSION['errors'] = ["Impossible de vous enregistrer"];
                    }
                }
                else {
                    $_SESSION['errors'] = ["Cette adresse mail existe déjà !"];
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
                    $_SESSION['errors'][] = $errorMessage;
                    $this->render('home/index');
                    exit();
                }

                //Traces the user by his email to verify that he exists
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
            $successMessage = "Vous êtes connecté";
            $_SESSION['success'] = $successMessage;
            $this->render('home/index');
        }

}