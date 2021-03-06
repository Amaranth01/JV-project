<?php

namespace App\Controller;

use App\Config;
use App\Model\Entity\User;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\RoleManager;
use App\Model\Manager\UserManager;
use Exception;

class UserController extends AbstractController
{
    public function index()
    {
        $this->render('user/userSpace');
    }

    public function delete()
    {
        $this->render('user/delete');
    }

    public function activated()
    {
        $this->render('user/activated');
    }

    public function forgottenPassword($token)
    {
        $this->render('user/forgotPassword');
    }

    /**
     * Add user and secured the form
     */
    public function register()
    {
        if (!isset($_POST['submit'])) {
            $this->render('pages/register');
            exit();
        }

        if (empty(($_POST['email']) || empty($_POST['username']) || empty($_POST['password']))) {
            $_SESSION['errors'] = "Merci de remplir tous les champs";
            $this->render('pages/register');
        }

        //Cleans and return the security of elements
        if ($this->formSubmitted()) {
            $username = $this->clean($this->getFormField('username'));

            $email = $this->clean($this->getFormField('email'));
            $password = $this->getFormField('password');
            $passwordR = $this->getFormField('passwordR');

            $mail = filter_var($email, FILTER_SANITIZE_EMAIL);
            $mailR = filter_var($email, FILTER_SANITIZE_EMAIL);
            $userManager = new UserManager();

            if($userManager->usernameExist($username)) {
                $_SESSION['errors'] = "Ce nom d'utlisateur existe déjà";
                $this->render('pages/register');
            }

            if($userManager->userMailExist($mail)) {
                $_SESSION['errors'] = "Cette adresse mail existe déjà";
                $this->render('pages/register');
            }

            if ($mail !== $mailR) {
                $_SESSION['errors'] = "Les adresses mails ne correspondent pas";
                $this->render('pages/register');
            }

            // Returns an error if the username is not 2 characters
            if (!strlen($username) >= 6 && strlen($username) <= 50) {
                $_SESSION['errors'] = "Le nom, ou pseudo, doit faire au moins 6 caractères et 50 maximum";
                $this->render('pages/register');
            }

            // Returns an error if the password does not contain all the requested characters.
            if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password)) {
                $_SESSION['errors'] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
                $this->render('pages/register');
            }

            // Passwords do not match
            if ($password !== $passwordR) {
                $_SESSION['errors'] = "Les mots de passe ne correspondent pas";
                $this->render('pages/register');
            } else {
                //If no error is detected the program goes to else and authorizes the recording
                $token = self::randomChars();
                $user = new User();
                $role = RoleManager::getRoleByName('none');
                $user
                    ->setUsername($username)
                    ->setEmail($mail)
                    ->setPassword(password_hash($password, PASSWORD_DEFAULT))
                    ->setToken($token)
                    ->setRole($role);

                UserManager::addUser($user);

                $id = UserManager::getUserByMail($mail)->getId();

                if (self::sendMailToken($username, $mail, $token, $id)) {

                    //If the ID is not null, we pass the user in the session
                    if (null !== $user->getId()) {
                        $_SESSION['success'] = "
                            Félicitations votre compte a bien été créé, un mail vous sera envoyé
                            pour activer votre compte. L'action peut prendre quelques minutes. Vérifiez votre boîte de spam.
                        ";
                        $user->setPassword('');
                        $_SESSION['activation-token'] = $token;
                    } else {
                        $_SESSION['errors'] = "Impossible de vous enregistrer";
                    }
                }
            }
        }
        $this->render('home/index', [
            'article' => ArticleManager::findAllArticle(4),
            'sectionTwo' => ArticleManager::getArticleBySectionId(2),
            'sectionFive' => ArticleManager::getArticleBySectionId(5),
        ]);
    }

    public function connexion()
    {
        if(isset($_SESSION['activation-token'])) {
            $_SESSION['errors'] = "Vous devez activer votre compte avant de vous connecter";
        }
        else {
            if ($this->formSubmitted()) {
                //Recovers and cleans data
                $username = $this->clean($this->getFormField('username'));
                $password = $this->getFormField('password');

                //Check that the fields are not empty
                if (empty($password) && empty($username)) {
                    $errorMessage = "Veuillez remplir tous les champs";
                    $_SESSION['errors'] = $errorMessage;
                    $this->render('pages/login');
                    exit();
                }

                //Traces the user by his username to verify that he exists
                $user = UserManager::getUserByName($username);
                if (null === $user) {
                    $errorMessage = "Pseudo inconnu";
                    $_SESSION['errors'] = $errorMessage;
                } else {

                    //Compare the password entered and written in the DB
                    if (password_verify($password, $user->getPassword())) {
                        $user->setPassword('');
                        $_SESSION['user'] = $user;
                    } else {
                        $_SESSION['errors'] = "Le nom d'utilisateur, ou le mot de passe est incorrect";
                    }
                }

            } else {
                $successMessage = "Vous êtes connecté";
                $_SESSION['success'] = $successMessage;
            }
        }
        $this->render('home/index', [
            'article' => ArticleManager::findAllArticle(4),
            'sectionTwo' => ArticleManager::getArticleBySectionId(2),
            'sectionFive' => ArticleManager::getArticleBySectionId(5),
        ]);
    }

    /**
     * @param int $id
     */
    public function deleteUser(int $id)
    {
        //Check if user is connected
        if (!isset($_SESSION['user'])) {
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
        }

        //Verify that the user has admin status and if the id is the same une URL and session user
        if (self::getConnectedUser() && self::adminConnected() && self::writerConnected() && $_SESSION['user']->getId() !== $_GET['id']) {
            $_SESSION['errors'] = "Il faut être connecté et propriétaire du compte pour le supprimer !";
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
        }
        // Compare the id in session
        if ($_SESSION['user']->getId() === $id) {
            $userManager = new UserManager();
            $delete = $userManager->deleteUser($id);
            //destroy the session after the delete action
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
            session_destroy();
        }
        $this->render('home/index', [
            'article' => ArticleManager::findAllArticle(4),
            'sectionTwo' => ArticleManager::getArticleBySectionId(2),
            'sectionFive' => ArticleManager::getArticleBySectionId(5),
        ]);
    }

    public function adminDeleteUser(int $id)
    {
        if (self::adminConnected()) {
            $userManager = new UserManager();
            $deleted = $userManager->deleteUser($id);
        }
        $this->render('admin/adminSpace');
    }

    /**
     * @param $id
     */
    public function updateUsername($id)
    {
        //check if the field is present
        if (!isset($_POST['newUsername'])) {
            $this->render('user/userSpace');
        }
        //check if the field is empty
        if (empty($_POST['newUsername'])) {
            $_SESSION['errors'] = "Le champs du pseudo doit être complété";
            $this->render('user/userSpace');
            exit();
        }
        //Clean the field
        $newUsername = $this->clean($_POST['newUsername']);

        $user = new UserManager();
        $user->updateUsername($newUsername, $id);
        $_SESSION['success'] = "Votre pseudo a bien été mis à jour";
        $this->render('user/userSpace');
    }

    /**
     * @param $id
     */
    public function updateEmail($id)
    {
        //check if the field is present
        if (!isset($_POST['newEmail'])) {
            $this->render('user/userSpace');
            exit();
        }
        //check if the field is empty
        if (empty($_POST['newEmail'])) {
            $_SESSION['errors'] = "Le champs de l'email doit être complété";
            $this->render('user/userSpace');
        }

        $newEmail = $this->clean($_POST['newEmail']);
        $user = new UserManager();
        $user->updateEmail($newEmail, $id);
        $_SESSION['success'] = "Votre mail a bien été mis à jour, un email vous sera envoyé pour confirmer votre nouvelle 
            adresse";
        $this->render('user/userSpace');
    }

    /**
     * @param $id
     */
    public function updatePassword($id)
    {
        //check if the fields are present
        if (!isset($_POST['newPassword']) && !isset($_POST['newPasswordR'])) {
            $this->render('user/userSpace');
            exit();
        }
        //check if the fields are empty
        if (empty($_POST['newPassword'])) {
            $_SESSION['errors'] = "Le champs du pseudo doit être complété";
            $this->render('user/userSpace');
        }

        $newPassword = $this->getFormField('newPassword');
        $newPasswordR = $this->getFormField('newPasswordR');

        if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $newPassword)) {
            $_SESSION['errors'] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
        }

        // Passwords do not match
        if ($newPassword !== $newPasswordR) {
            $_SESSION['errors'] = "Les mots de passe ne correspondent pas";
        }
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $user = new UserManager();
        $user->updatePassword($newPassword, $id);
        $_SESSION['success'] = "Votre mot de passe a bien été mis à jour";

        $this->render('user/userSpace');
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function userImage($id)
    {
        //Check if the user is connected
        if (!isset($_SESSION['user'])) {
            $_SESSION['errors'] = "Seul un utilisateur peut changer son image";
            $this->render('home/index', $data = [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
        }

        $user = new UserManager();
        //change the avatar
        $newImage = $this->addAvatar();
        $user->userImage($newImage, $id);
        $this->render('user/userSpace');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function addAvatar(): string
    {
        $name = "";
        //Checking the presence of the form field
        if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {

            //Defining allowed file types
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            if (in_array($_FILES['img']['type'], $allowedMimeTypes)) {
                //Setting the maximum size
                $maxSize = 1024 * 1024;
                if ((int)$_FILES['img']['size'] <= $maxSize) {
                    //Get the temporary file name
                    $tmp_name = $_FILES['img']['tmp_name'];
                    //Assignment of the final name
                    $name = $this->getRandomName($_FILES['img']['name']);
                    //Checks if the destination file exists, otherwise it is created
                    if (!is_dir('uploads')) {
                        mkdir('uploads');
                    }
                    //File move
                    move_uploaded_file($tmp_name, '../public/assets/img/avatar/' . $name);
                } else {
                    $_SESSION['errors'] = "Le poids est trop lourd, maximum autorisé : 1 Mo";
                }
            } else {
                $_SESSION['errors'] = "Mauvais type de fichier. Seul les formats JPD, JPEG et PNG sont acceptés";
            }
        } else {
            $_SESSION['errors'] = "Une erreur s'est produite";
        }
        return $name;
    }

    /**
     * @param string $rName
     * @return string
     * @throws Exception
     */
    private function getRandomName(string $rName): string
    {
        //Get file extension
        $infos = pathinfo($rName);
        try {
            //Generates a random string of 15 chars
            $bytes = random_bytes(15);
        } catch (Exception $e) {
            //Is used on failure
            $bytes = openssl_random_pseudo_bytes(15);
        }
        //Convert binary data to hexadecimal
        return bin2hex($bytes) . '.' . $infos['extension'];
    }

    /**
     * changing the role of a user
     */
    public function updateUserRole()
    {
        //check if the field is present
        if (!isset($_POST['username'])) {
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
            exit();
        }

        //check if the admin is connected
        if (RoleManager::getRoleByName('writer') == 'writer' && RoleManager::getRoleByName('user') == 'user') {
            $_SESSION['errors'] = "Seul un administrateur peut mettre à jour un utilisateur";
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
        }

        //clean the data
        $username = $this->clean($this->getFormField('username'));
        $user = new UserManager();
        $newRole = $_POST['role'];
        //Compare the username
        if ($username !== UserManager::getUserByName($_POST['username'])->getUsername()) {
            $_SESSION['errors'] = "Le pseudo est incorrecte";
            $this->render('admin/adminSpace');
        } else {
            $user->updateRoleUser($newRole, $username);
        }
        $this->render('admin/adminSpace');
    }

    /**
     * Send a Token when the user is register
     * @param $username
     * @param $mail
     * @param $token
     * @param $id
     * @return bool
     */
    private function sendMailToken($username, $mail, $token, $id): bool
    {
        //Configure the token link
        $url = Config::APP_URL . '/?c=user&a=activate-account&id=' . $id . '&token=' . $token;

        $message = "
            <html lang=fr >
                <head>
                    <title>Vérification de votre compte</title>
                </head>
                <body>
                    <span>Bonjour $username,</span>
                    <p>
                        Afin de finaliser votre inscription sur le site jv-project, 
                        <br>
                        merci de cliquer <a href=\"$url\">sur ce lien</a> pour confirmer votre adresse email. Si le lien ne 
                        s'affiche pas, collez l'adresse ci-dessous dans votre navigateur. 
                        <br>
                        https://jv-project.vanessa-amaranth.com/?c=user&a=activate-account&id=$id&token=$token
                    </p>
                </body>
            </html>
        ";

        $subject = "Vérification de votre adresse mail";
        $header = [
            'Reply-to' => "no-reply@email.com",
            'X-Mailer' => 'PHP/' . phpversion(),
            'Mime-version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8'
        ];

        return mail($mail, $subject, $message, $header, "-f no-reply@email.com");
    }

    /**
     * @param $mail
     * @param $token
     * @param $id
     * @return bool
     */
    private function mailResetPassword($mail,$id ,$token): bool
    {
        //Configure the token link
        $url = Config::APP_URL . '/?c=user&a=forgotten-password&id=' . $id . '&token=' . $token;

        $message = "
            <html lang=fr >
              <head>
                <title>Vérification de votre compte</title>
            </head>
            <body>
                <span>Bonjour</span>
                <p>
                    Afin de réinitialiser votre mot de passe, 
                    <br>
                    merci de cliquer <a href=\"$url\">sur ce lien</a> pour vous rendre sur la page de réinitialisation. Si le lien ne 
                    s'affiche pas, collez l'adresse ci-dessous dans votre navigateur. 
                    <br>
                    https://jv-project.vanessa-amaranth.com/?c=user&a=forgotten-password&id=$id&token=$token
                </p>
            </body>
        </html>
        ";

        $subject = "Réinitialisation de votre mot de passe";
        $header = [
            'Reply-to' => "no-reply@email.com",
            'X-Mailer' => 'PHP/' . phpversion(),
            'Mime-version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8'
        ];

        return mail($mail, $subject, $message, $header, "-f no-reply@email.com");
    }

    /**
     * Activates the account after accepting the token
     * @param int $id
     * @param string $token
     */
    public function activateAccount(int $id, string $token)
    {
        $userManager = new UserManager();
        $user = UserManager::getUser($id);
        //Compare role id if is not the same, users are redirecting to home page
        if ($user->getRole()->getId() !== RoleManager::getRoleByName('none')->getId()) {
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
            exit();
        }

        if ($user->getToken() === $token) {
            ////Change the role of the user
            $userManager->updateRoleToken(1, $id);
            $_SESSION['success'] = 'Votre comte a été activé';
            $this->render('home/index', [
                'article' => ArticleManager::findAllArticle(4),
                'sectionTwo' => ArticleManager::getArticleBySectionId(2),
                'sectionFive' => ArticleManager::getArticleBySectionId(5),
            ]);
        }
    }

    /**
     * Verify if the user mail is correct and send a mail for reset password
     */
    public function checkEmail()
    {
        $mail = $this->clean($this->getFormField('email'));
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
        $user = UserManager::getUserByMail($mail);

        //check if the mail exist or not in DB
        if(!$user) {
            $_SESSION['error'] = "Votre compte n'a pas pu être trouvé";
            exit;
        }
        //Get token
        $token = $user->getToken();

        //send the mail
        if (self::mailResetPassword($mail, $user->getId(), $token)) {
            $_SESSION['success'] = "
                Un mail vous sera envoyé pour la réinitialisation de votre mot de passe. 
                L'action peut prendre quelques minutes. Vérifiez votre boîte de spam.
            ";
        }

        $this->render('home/index', [
            'article' => ArticleManager::findAllArticle(4),
            'sectionTwo' => ArticleManager::getArticleBySectionId(2),
            'sectionFive' => ArticleManager::getArticleBySectionId(5),
        ]);
    }


    /**
     * Reset the password
     */
    public function forgotPassword()
    {
        //check if the field is empty
        if(empty($_POST['password'] )|| empty($_POST['passwordR'])) {
            $this->render('user/forgotPassword');
        }

        //Get the field
        $password = $this->getFormField('password');
        $passwordR = $this->getFormField('passwordR');
        //secured the form
        $userId = (int)$_POST['id'];
        $token = $this->clean($_POST['token']);
        $user = UserManager::getUser($userId);

        // Check if user exists.
        if(!$user) {
            $_SESSION['error'] = "Votre compte n'a pas été trouvé";
            $this->render('user/forgotPassword');
        }

        // Check if token is the right one.
        if($token !== $user->getToken()) {
            $_SESSION['error'] = "Le token fourni n'est pas valide, faites une nouvelle demande";
            $this->render('user/forgotPassword');
        }

        // Passwords do not match
        if ($password !== $passwordR) {
            $_SESSION['errors'] = "Les mots de passe ne correspondent pas";
            $this->render('user/forgotPassword');
        }

        //Verify if the special char and uppercase are presents
        if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password)) {
            $_SESSION['errors'] = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial";
            $this->render('user/forgotPassword');
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $userManager = new UserManager();
        $userManager->updatePassword($password, $userId);
        $_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
        $this->render('pages/login');
    }
}