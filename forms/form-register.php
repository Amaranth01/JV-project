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
        header('Location: index.php?success=1');
    }
    else {
        header('Location: index.php?success=0');
    }

    //email validation
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?success=0');
    }
}