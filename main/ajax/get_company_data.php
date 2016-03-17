<?php
include '../includes/configHRP.php';

$kartya = ltrim($_POST["kartya"], "0");

// CÉG ÉS TELEPHELYEINEK BETÖLTÉSE EGY TÖMBBE

$data = array();

$stmt = $conn->prepare("SELECT vallalat_nev FROM kartya,ceg WHERE kartya_id=? AND ceg.id=kartya.cegId");
$stmt->execute(array($kartya));
$data['vallalat_neve'] = $stmt->fetchColumn();

$stmt1 = $conn->prepare("SELECT vallalat_telephely
                        FROM telephely
                        WHERE cegId=(SELECT id FROM ceg,kartya WHERE kartya_id=? AND id=cegId)");
$stmt1->execute(array($kartya));
if ($stmt1->rowCount()) {
    $data['vallalat_telephelyei'] = $stmt1->fetchAll(PDO::FETCH_NUM);
}

echo json_encode($data);