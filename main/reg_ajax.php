<?php
include 'includes/configHRP.php';

$kartyaId = $_POST["kartyaId"];
$vez_nev = $_POST["vez_nev"];
$ker_nev = $_POST["ker_nev"];
$elonev = $_POST["elonev"];
$email = $_POST["email"];
$telefon = $_POST["telefon"];
$lakhely_varos = $_POST["lakhely_varos"];
$lakhely_varosresz = $_POST["lakhely_varosresz"];
$felh_nev = $_POST["felh_nev"];
$jelszo = $_POST["jelszo"];

/* ******* REGISZTRÁLT-E MÁR EZZEL A CÍMMEL ******* */
$stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE email=?");
$stmt->execute(array($email));
$row_count = $stmt->rowCount();
/* ************************************************ */

if ($row_count == 0) {
    /* ************* HTML E-MAIL KÜLDÉSE ************* */
    $to = $email;
    $subject = "HRP Interaktív Program - Regisztráció";

    $message = "Szia!";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //$headers .= 'From: <webmaster@example.com>' . "\r\n";
    //$headers .= 'Cc: myboss@example.com' . "\r\n";

    mail($to,$subject,$message,$headers);
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

    if ($ret) {
        echo "registration_succeeded";
    } else {
        echo "registration_failed";
    }
} else {
    echo "email_in_use";
}
?>
