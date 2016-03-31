<?php
include '../includes/configHRP.php';

$msg_to = 0;
$subj = $msg = $staff = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $msg_to = test_input($_POST["msg_to"]);
    $subj = test_input($_POST["subj"]);
    $msg = test_input($_POST["msg"]);

    if($msg_to == 1) { $email = "info@egeszsegholding.hu"; $staff = "általános ügyfélszolgálat."; }
    if($msg_to == 2) { $email = "makra.zsolt@egeszsegholding.hu, arman.istvan@egeszsegholding.hu, istvanarman@gmail.com"; $staff = "vezetőség."; }
    if($msg_to == 3) { $email = "tisopeti@gmail.com, jaraidaniel@gmail.com"; $staff = "fejlesztők."; }

    /* ************* HTML E-MAIL KÜLDÉSE ************* */
    $to = $email;
    $subject = "HRP - Új felhasználói üzenet";

    $message = "
        <html>
        <head>
        <title>HRP - Új kapcsolatfelvételi üzenet</title>
        </head>
        <body>
        <h1 align=\"center\" style=\"background:#89c540;border-radius:16px;\">Új kapcsolatfelvételi üzenet</h1>
        <div style=\"width: 80%;margin: auto;\">
        <fieldset><legend align=\"center\">Adatok</legend>
        <h3>Címzett: ". $staff ."</h3><hr>
        <h3>Tárgy: ". $subj ."</h3>
        </fieldset>
        <div style=\"padding:10px 0;\"></div>
        <fieldset><legend align=\"center\">Üzenet szövege</legend><pre>". $msg ."</pre>
        </fieldset>
        </div>
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

    echo "contact_mail_sent";
}