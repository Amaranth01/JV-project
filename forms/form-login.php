<?php

//We check that the fields exist
if (isset($_POST['username']) && isset($_POST['password'])){

    //I remove useless spaces and HTML tags
    $username = trim(strip_tags($_POST['username']));
    $password = trim(strip_tags($_POST['password']));
}