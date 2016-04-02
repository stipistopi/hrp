<?php
include '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $kartyaId = test_input($_POST["kartyaId"]);
    $vez_nev = test_input($_POST["vez_nev"]);
    $ker_nev = test_input($_POST["ker_nev"]);
    $elonev = test_input($_POST["elonev"]);
    $email = test_input($_POST["email"]);
    $telefon = test_input($_POST["telefon"]);
    $lakhely_varos = test_input($_POST["lakhely_varos"]);
    $lakhely_varosresz = test_input($_POST["lakhely_varosresz"]);
    $felh_nev = test_input($_POST["felh_nev"]);
    $jelszo = test_input($_POST["jelszo"]);
    $thely = test_input($_POST["thely"]);

    $email_in_use = db_getUserId(null, $email, null);
    $username_in_use = db_getUserId($felh_nev, null, null);
    $card_in_use = db_getUserId(null, null, $kartyaId);

    if ($email_in_use === FALSE && $username_in_use === FALSE && $card_in_use === FALSE) {
        /* ************* HTML E-MAIL KÜLDÉSE ************* */
        $to = $email;
        $subject = "HRP Interaktív Program - Regisztráció";

        $message = "Szia!";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //$headers .= 'From: <webmaster@example.com>' . "\r\n";
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to, $subject, $message, $headers);
        /* *********************************************** */

        $hash = password_hash($jelszo, PASSWORD_BCRYPT, ['cost' => 10]);

        $ret1 = db_addUser($email, $felh_nev, $kartyaId, $hash, $vez_nev, $ker_nev, $elonev,
            $telefon, $lakhely_varos, $lakhely_varosresz);

        $stmt = $conn->prepare("UPDATE kartya SET vallalat_telephely=? WHERE kartya_id=?");
        $ret2 = $stmt->execute(array($thely, $kartyaId));

        if ($ret1 === TRUE && $ret2) {
            echo "registration_succeeded";
        } else {
            echo "registration_failed";
        }
    } else if ($username_in_use !== FALSE) {
        echo "username_in_use";
    } else if ($card_in_use !== FALSE) {
        echo "card_in_use";
    } else {
        echo "email_in_use";
    }
}