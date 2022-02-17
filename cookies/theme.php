<?php
$chooseTheme = 'dark-mode';

$cookieName = 'theme';
$cookieValue = 'dark-mode';
$expire = time() + (86400 * 365); // this cookie should expire after 365 days

setcookie($cookieName, $cookieValue, $expire);

if(isset($_COOKIE['theme'])) {
    if($_COOKIE['theme'] == 'dark-mode') {
        echo 'You are using the dark theme.';
    } else {
        echo 'You are using the light theme.';
    }
} else {
    echo 'You are using the default theme.';
}