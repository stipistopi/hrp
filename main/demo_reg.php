<?php

$dsn = 'mysql:dbname=hrp_interaktiv;host=localhost';
$username = 'hrp-interaktiv.h';
$password = base64_decode("WDdhV0k0TVQ");

$conn = new PDO($dsn, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error handling

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($_POST["feladat"] == "hozzaad") {
    $vez_nev = $_POST["vez_nev"];
    $k_nev = $_POST["k_nev"];
    $e_nev = $_POST["e_nev"];
    $email = $_POST["email"];
    $t_szam = $_POST["t_szam"];
    $vall_neve = $_POST["vall_neve"];

    /* ******* REGISZTRÁLT-E MÁR EZZEL A CÍMMEL ******* */
    $stmt = $conn->prepare("SELECT * FROM erdeklodo WHERE email=?");
    $stmt->execute(array($email));
    $row_count = $stmt->rowCount();
    /* ************************************************ */

    if($row_count == 0) {
        /* ** A GENERÁLT AZONOSÍTÓ SZEREPEL-E A DB-BEN ** */
        $stmt = $conn->prepare("SELECT * FROM erdeklodo WHERE gen_jelszo=?");
        do {
            $gen_jelszo = generateRandomString();
            $stmt->execute(array($gen_jelszo));
            $row_count = $stmt->rowCount();
        } while($row_count != 0);
        /* ********************************************** */

        /* ************* HTML E-MAIL KÜLDÉSE ************* */
        $to = $email;
        $subject = "Regisztrációs kódja elkészült a demó videóhoz";

        $message = "
        <html>
        <head>
        <title>Regisztrációs kód - HRP</title>
        </head>
        <body>
        <h2>Tisztelt " . " " . $e_nev . " " . $vez_nev . " " . $k_nev . "!</h2>
        <p>Ön sikeresen regisztrált érdeklődőként, hogy megtekinthesse bemutatkozó videónkat.</p>
        <h3>Ezt az alábbi, egyedi kód beírásával tudja megtenni: <span style=\"color: red;\">" . $gen_jelszo . "</span>.</h3>
        <p style=\"padding:20px;\">Köszönjük regisztrációját!</p>
        <span style=\"font-style: italic;\">Üdvözlettel:<br>Interaktív Program csapata</span><br>
        <img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\">
        </body>
        </html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //$headers .= 'From: <webmaster@example.com>' . "\r\n";
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to,$subject,$message,$headers);
        /* *********************************************** */

        /* ************** VÉGÜL DB-BE ÍRÁS ************** */
        $stmt = $conn->prepare("INSERT INTO erdeklodo VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute(array($gen_jelszo, $vez_nev, $k_nev, $e_nev, $email, $t_szam, $vall_neve));
        /* ********************************************** */

        echo "mail_ok";
    } else {
        echo "mail_error";
    }

} else if($_POST["feladat"] == "keres") {
    $kod = $_POST["kod"];

    /* ********** A MEGADOTT KÓD VALIDÁLÁSA ********** */
    $stmt = $conn->prepare("SELECT * FROM erdeklodo WHERE gen_jelszo=?");
    $stmt->execute(array($kod));
    $row_count = $stmt->rowCount();
    /* *********************************************** */

    if($row_count != 0) {
        echo "kod_ok";
    } else {
        echo "kod_nem_ok";
    }
}