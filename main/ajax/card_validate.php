<?php
include '../includes/config.php';

$kartya = ltrim($_POST["kartya"], "0");

/* ********** A MEGADOTT KÁRTYASZÁM VALIDÁLÁSA ********** */
$stmt = $conn->prepare("SELECT * FROM kartya WHERE kartya_id=? AND aktiv=?");
$stmt->execute(array($kartya, 1));
$row_count = $stmt->rowCount();
/* ****************************************************** */

if ($row_count != 0) {
    echo "kartya_ok";
} else {
    echo "kartya_nem_ok";
}