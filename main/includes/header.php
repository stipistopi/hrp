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
    <?php if($active == 'results'): ?>
    <style>
        .graph-container li:nth-child(1) .bar-inner,
        .graph-container li:nth-child(1) .bar-inner:before { background-color: rgba(255, 0, 0, .3); }
        .graph-container li:nth-child(1) .bar-inner:after { background-color: rgba(255, 71, 71, .3); }

        .graph-container li:nth-child(2) .bar-inner,
        .graph-container li:nth-child(2) .bar-inner:before { background-color: rgba(5, 123, 5, .3); }
        .graph-container li:nth-child(2) .bar-inner:after { background-color: rgba(63, 122, 47, .4); }

        <?php
        if($_GET['test'] == "kf") {
            echo ".graph-container li:nth-child(3) .bar-inner,
                  .graph-container li:nth-child(3) .bar-inner:before { background-color: rgba(5, 62, 123, .6); }
                  .graph-container li:nth-child(3) .bar-inner:after { background-color: rgba(47, 83, 122, .7); }";
        } else {
            echo ".graph-container li:nth-child(3) .bar-inner,
                  .graph-container li:nth-child(3) .bar-inner:before { background-color: rgba(196, 109, 59, .6); }
                  .graph-container li:nth-child(3) .bar-inner:after { background-color: rgba(216, 143, 102, .7); }";
        }
        ?>
    </style>
    <?php endif ?>
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
                <li><a class="<?php if ($active == 'profile') echo 'active'; ?>" href="profile.php">Profilom</a></li>
                <li><a class="<?php if ($active == 'activity') echo 'active'; ?>" href="activity.php">Tevékenységnapló</a></li>
                <li><a class="<?php if ($active == 'results') echo 'active'; ?>" href="results.php">Eredményeim</a></li>
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