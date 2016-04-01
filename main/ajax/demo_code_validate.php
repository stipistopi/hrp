<?php
include '../includes/config.php';

$kod = $_POST["kod"];

/* ********** A MEGADOTT KÓD VALIDÁLÁSA ********** */
$stmt = $conn->prepare("SELECT * FROM erdeklodo WHERE gen_jelszo=?");
$stmt->execute(array($kod));
$row_count = $stmt->rowCount();
/* *********************************************** */

if($row_count != 0) {
    $_SESSION['erd_jelszo'] = $kod;
    echo "kod_ok";
} else {
    echo "kod_nem_ok";
}