<?php
include '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $kartyaId = test_input(ltrim($_POST["kartyaId"], "0"));
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

        $hash = password_hash($jelszo, PASSWORD_BCRYPT, ['cost' => 10]);

        $stmt = $conn->prepare("INSERT INTO felhasznalo (email, felh_nev, kartyaId, jelszo, vez_nev, ker_nev, elonev,
                              telefon, lakhely_varos, lakhely_varosresz)
                            VALUES (:email, :felh_nev, :kartyaId, :jelszo, :vez_nev, :ker_nev, :elonev,
                              :telefon, :lakhely_varos, :lakhely_varosresz)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':felh_nev', $felh_nev);
        $stmt->bindParam(':kartyaId', $kartyaId);
        $stmt->bindParam(':jelszo', $hash);
        $stmt->bindParam(':vez_nev', $vez_nev);
        $stmt->bindParam(':ker_nev', $ker_nev);
        $stmt->bindParam(':elonev', $elonev);
        $stmt->bindParam(':telefon', $telefon);
        $stmt->bindParam(':lakhely_varos', $lakhely_varos);
        $stmt->bindParam(':lakhely_varosresz', $lakhely_varosresz);
        $ret1 = $stmt->execute();

        $stmt = $conn->prepare("UPDATE kartya SET kezdo_nap=CURDATE(),vallalat_telephely=? WHERE kartya_id=?");
        $ret2 = $stmt->execute(array($thely, $kartyaId));

        if($ret1 && $ret2) {
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
}