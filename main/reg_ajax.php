<?php
include 'includes/configHRP.php';

if($_POST["feladat"] == "hozzaad") {
    $kartyaId = ltrim($_POST["kartyaId"], "0");
    $vez_nev = $_POST["vez_nev"];
    $ker_nev = $_POST["ker_nev"];
    $elonev = $_POST["elonev"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $lakhely_varos = $_POST["lakhely_varos"];
    $lakhely_varosresz = $_POST["lakhely_varosresz"];
    $felh_nev = $_POST["felh_nev"];
    $jelszo = $_POST["jelszo"];

    // ******* REGISZTRÁLT-E MÁR EZZEL A CÍMMEL *******
    $stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE email=?");
    $stmt->execute(array($email));
    $row_count = $stmt->rowCount();
    // ************************************************

    // ******* VAN-E MÁR ILYEN FELHASZNÁLÓNÉV *******
    $stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE felh_nev=?");
    $stmt->execute(array($felh_nev));
    $row_count2 = $stmt->rowCount();
    // **********************************************

    // ******* REGISZTRÁLT-E MÁR EZZEL A KÁRTYÁVAL *******
    $stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE kartyaId=?");
    $stmt->execute(array($kartyaId));
    $row_count3 = $stmt->rowCount();
    // ***************************************************

    if($row_count == 0 && $row_count2 == 0 && $row_count3 == 0) {
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

        $stmt = $conn->prepare("INSERT INTO felhasznalo (email, felh_nev, kartyaId, jelszo, vez_nev, ker_nev, elonev,
                              telefon, lakhely_varos, lakhely_varosresz)
                            VALUES (:email, :felh_nev, :kartyaId, :jelszo, :vez_nev, :ker_nev, :elonev,
                              :telefon, :lakhely_varos, :lakhely_varosresz)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':felh_nev', $felh_nev);
        $stmt->bindParam(':kartyaId', $kartyaId);
        $stmt->bindParam(':jelszo', $jelszo);
        $stmt->bindParam(':vez_nev', $vez_nev);
        $stmt->bindParam(':ker_nev', $ker_nev);
        $stmt->bindParam(':elonev', $elonev);
        $stmt->bindParam(':telefon', $telefon);
        $stmt->bindParam(':lakhely_varos', $lakhely_varos);
        $stmt->bindParam(':lakhely_varosresz', $lakhely_varosresz);
        $ret = $stmt->execute();

        if($ret) {
            echo "registration_succeeded";
        } else {
            echo "registration_failed";
        }
    } else if($row_count2 != 0) {
        echo "username_in_use";
    } else if($row_count3 != 0) {
        echo "card_in_use";
    } else {
        echo "email_in_use";
    }

} else if($_POST["feladat"] == "keres") {
    $kartya = ltrim($_POST["kartya"], "0");

    /* ********** A MEGADOTT KÁRTYASZÁM VALIDÁLÁSA ********** */
    $stmt = $conn->prepare("SELECT * FROM kartya WHERE kartya_id=? AND aktiv=?");
    $stmt->execute(array($kartya, 1));
    $row_count = $stmt->rowCount();
    /* ****************************************************** */

    if($row_count != 0) {
        echo "kartya_ok";
    } else {
        echo "kartya_nem_ok";
    }
}