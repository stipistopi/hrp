<?php
include '../includes/config.php';

$userId = 0;
$timeWindow = $msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = test_input($_POST["userId"]);
    $timeWindow = test_input($_POST["timeWindow"]);
    $msg = test_input($_POST["msg"]);

    $user = db_getUserDataRaw($userId, null, null, null);
    $company = db_getCompanyDataRaw($userId, null, null, null);

    if(empty($user['telefon'])) $user['telefon'] = "n. a.";

    /* ************* HTML E-MAIL KÜLDÉSE ************* */
    $to = "info@egeszsegholding.hu";
    $subject = "HRP - Új segítségkérő üzenet";

    $message = "
        <html>
        <head>
        <title>HRP - Új segítségkérő üzenet</title>
        </head>
        <body>
        <h1 align=\"center\" style=\"background:lightcoral;border-radius:16px;\">Új segítségkérő üzenet</h1>
        <div style=\"width: 80%;margin: auto;\">
        <fieldset><legend align=\"center\">Adatok</legend>
        <table width=\"80%\" align=\"center\">
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-right:1px dashed black;\">Név</td><td width=\"60%\" style=\"padding:.5em 0;\" align=\"right\">". $user['vez_nev'] ." ". $user['ker_nev'] ."</td></tr>
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-top:1px dashed black;border-right:1px dashed black;\">Telefon</td><td width=\"60%\" style=\"padding:.5em 0;border-top:1px dashed black;\" align=\"right\">". $user['telefon'] ."</td></tr>
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-top:1px dashed black;border-right:1px dashed black;\">E-mail</td><td width=\"60%\" style=\"padding:.5em 0;border-top:1px dashed black;\" align=\"right\">". $user['email'] ."</td></tr>
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-top:1px dashed black;border-right:1px dashed black;\">Cégnév</td><td width=\"60%\" style=\"padding:.5em 0;border-top:1px dashed black;\" align=\"right\">". $company['vallalat_nev'] ."</td></tr>
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-top:1px dashed black;border-right:1px dashed black;\">Kártyaszám</td><td width=\"60%\" style=\"padding:.5em 0;border-top:1px dashed black;\" align=\"right\">IP". $user['kartyaId'] ."</td></tr>
        <tr><td width=\"40%\" style=\"padding:.5em 0;border-top:1px dashed black;border-right:1px dashed black;\">Időablak neve</td><td width=\"60%\" style=\"padding:.5em 0;border-top:1px dashed black;\" align=\"right\">". $timeWindow ."</td></tr>
        </table>
        </fieldset>
        <div style=\"padding:10px 0;\"></div>
        <fieldset><legend align=\"center\">Üzenet szövege</legend><pre>". $msg ."</pre>
        </fieldset>
        </div>
        <p style=\"text-align:center;\"><img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></p>
        <h1 align=\"center\" style=\"background:lightcoral;color:lightcoral;border-radius:16px;\">hrp</h1>
        </body>
        </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //$headers .= 'From: <webmaster@example.com>' . "\r\n";
    //$headers .= 'Cc: myboss@example.com' . "\r\n";

    mail($to, $subject, $message, $headers);
    /* *********************************************** */

    echo "help_mail_sent";
}