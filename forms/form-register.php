<?php

//We check that the fields exist
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-repeat'])) {

    //I remove useless spaces and HTML tags
    $username = trim(strip_tags($_POST['username']));
    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $passwordRepeat = trim(strip_tags($_POST['password-repeat']));

    //Verification that the two passwords are identical
    if($password === $passwordRepeat) {
        //the password must contain an uppercase letter, a lowercase letter and a number
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $lenPassword = strlen($password) >=6 && strlen($password) <=20;
        header('Location: index.php?success=1');

        if (!$uppercase || !$lowercase || !$number) {
            header('Location: success=-1');
        }
    }
    else {
        header('Location: index.php?success=0');
    }

    //email validation
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?success=0');
    }
}