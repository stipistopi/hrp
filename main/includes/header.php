<?php
include_once 'config.php';
if (!isset($active)) $active = '';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>HRP Interaktív Program</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/component.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
</head>
<body>
<div id="page-wrapper">
    <div id="top-menu-wrapper">
        <img alt="Logó" src="images/logo.png">
        <ul id="top-menu">
            <?php if (!isset($_SESSION["is_auth"])): ?>
                <li><a class="<?php if ($active == 'index') echo 'active'; ?>" href="../index.html">Főoldal</a></li>
                <li><a class="<?php if ($active == 'about') echo 'active'; ?>" href="about.php">Rólunk</a></li>
                <li><a class="<?php if ($active == 'services') echo 'active'; ?>" href="services.php">Szolgáltatásaink</a></li>
                <li><a class="<?php if ($active == 'contact') echo 'active'; ?>" href="contact.php">Kapcsolat</a></li>
                <li><a class="<?php if ($active == 'career') echo 'active'; ?>" href="career.php">Karrier</a></li>
            <?php else: ?>
                <li><a class="<?php if ($active == 'lecke') echo 'active'; ?>" href="lecke.php">Interaktív Program</a></li>
                <li><a class="<?php if ($active == 'profile') echo 'active'; ?>" href="#">Profilom</a></li>
                <li><a class="<?php if ($active == 'activity') echo 'active'; ?>" href="activity.php">Tevékenységnapló</a></li>
            <?php endif ?>
            <li style="float:right;">
                <ul style="list-style-type:none;">
                    <?php if (!isset($_SESSION["is_auth"])): ?>
                        <li><a class="<?php if ($active == 'reg') echo 'active'; ?>" href="reg.php">Regisztráció</a></li>
                        <li><a class="<?php if ($active == 'login') echo 'active'; ?>" href="login.php">Bejelentkezés</a></li>
                    <?php else: ?>
                        <li><a href="logout.php">Kijelentkezés</a></li>
                    <?php endif ?>
                </ul>
            </li>
        </ul>
    </div>
    <div id="content-wrapper">
        <div id="content">