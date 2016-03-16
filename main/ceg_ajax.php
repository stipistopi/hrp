<?php
include 'includes/configHRP.php';

$kartya = ltrim($_POST["kartya"], "0");

// CÉG ÉS TELEPHELYEINEK BETÖLTÉSE EGY TÖMBBE

$stmt = $conn->prepare("SELECT vallalat_nev FROM kartya,ceg WHERE kartya_id=? AND ceg.id=kartya.cegId");
$stmt->execute(array($kartya));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$array = array($row['vallalat_nev']);

$stmt1 = $conn->prepare("SELECT vallalat_telephely FROM telephely WHERE cegId=(SELECT id FROM ceg,kartya WHERE kartya_id=? AND id=cegId)");
$stmt1->execute(array($kartya));

/*$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
for($i = 0; $i < sizeof($rows); $i++) {
    array_push($array,$rows[$i]);
}*/

//$rows = $stmt1->fetchAll(PDO::FETCH_ASSOC);

/*while($row = array_shift($rows)){
    $uj = $row['vallalat_telephely'];
    array_push($array, $uj);
}*/

/*foreach($rows as $row) {
    $uj = $row['vallalat_telephely'];
    array_push($array, $uj);
}*/

$row_count = $stmt1->rowCount();

$row = $stmt1->fetch(PDO::FETCH_ASSOC);
    $uj = $row['vallalat_telephely'];
    array_push($array, var_dump($row));

/*for($i=0; $i < $row_count; $i++) {
    if($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $uj = $row['vallalat_telephely'];
        array_push($array, $uj);
    }
}*/

    /*while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $uj = $row['vallalat_telephely'];
        array_push($array, $uj);
    }*/

echo json_encode($array);