<?php
include '../includes/config.php';

$elk_nev = $elk_email = $elk_lakhely = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $elk_nev = test_input($_POST["elk_nev"]);
    $elk_email = test_input($_POST["elk_email"]);
    $elk_lakhely = test_input($_POST["elk_lakhely"]);

    /* ************* HTML E-MAIL KÜLDÉSE ************* */
    $to = "makra.zsolt@egeszsegholding.hu";
    $subject = "HRP - Új érdeklődő (éléskamra program)";

    $message = "
        <html>
        <head>
        <title>HRP - Új érdeklődő (éléskamra program)</title>
        </head>
        <body>
        <h1 align=\"center\" style=\"background:#89c540;border-radius:16px;\">Új érdeklődő (éléskamra program)</h1>
        <fieldset style=\"width: 60%;margin: auto;\"><legend align=\"center\">Érdeklődő adatai</legend>
        <h3>Név: ". $elk_nev ."</h3><hr>
        <h3>E-mail: ". $elk_email ."</h3><hr>
        <h3>Lakhely: ". $elk_lakhely ."</h3>
        </fieldset>
        <p style=\"text-align:center;\"><img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></p>
        <h1 align=\"center\" style=\"background:#89c540;color:#89c540;border-radius:16px;\">hrp</h1>
        </body>
        </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //$headers .= 'From: <webmaster@example.com>' . "\r\n";
    //$headers .= 'Cc: myboss@example.com' . "\r\n";

    mail($to, $subject, $message, $headers);
    /* *********************************************** */

    echo "eleskamra_mail_sent";
}