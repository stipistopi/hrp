<?php
include_once 'includes/config.php';

if (isset($_SESSION["admin_is_auth"])) {
    unset($_SESSION["admin_is_auth"]);
    session_destroy();
    header('location: index.php');
    exit;
}
