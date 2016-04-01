<?php
include_once 'includes/config_session.php';

if (!empty($_SESSION['auth_token'])) {
    deleteAuthToken($_SESSION['auth_token']);
    unset($_SESSION['auth_token']);
}

if (!empty($_COOKIE['remember'])) {
    setcookie(
        'remember', // name
        '', // value
        1, // expire
        '/' // path
    );
    unset($_COOKIE['remember']);
}

unset($_SESSION['is_auth']);

session_destroy();

header("location: ../index.html");

exit;
