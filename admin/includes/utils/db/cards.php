<?php
function db_getAllCardIds()
{
    global $conn;
    $stmt = $conn->prepare("SELECT kartya_id AS id
                            FROM kartya
                            ORDER BY kartya_id ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function db_getCompanyCards($companyId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT kartya_id AS id, aktiv AS active
                            FROM kartya
                            WHERE cegId = :companyId AND (aktiv = 0 OR aktiv = 1)");
    $stmt->bindParam(':companyId', $companyId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function db_getCompanyCardsNum($companyId, $active)
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(kartya_id)
                            FROM kartya
                            WHERE cegId = :companyId AND aktiv = :active");
    $stmt->bindParam(':companyId', $companyId);
    $stmt->bindParam(':active', $active);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function db_setCardActive($number, $active)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE kartya
                            SET aktiv = :active
                            WHERE kartya_id = :number");
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':active', $active);
    return $stmt->execute();
}

function db_addCard($number, $companyId, $active)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO kartya (kartya_id, cegId, aktiv)
                            VALUES (:number, :companyId, :active)");
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':companyId', $companyId);
    $stmt->bindParam(':active', $active);
    return $stmt->execute();
}

function db_addCardRange($start, $end, $companyId, $active)
{
    // TODO add proper error handling
    for ($number = $start; $number <= $end; ++$number) {
        $ret = db_addCard($number, $companyId, $active);
        if (!$ret)
            return $ret;
    }

    return TRUE;
}

function db_getCardData($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT cegId AS company, aktiv AS active
                            FROM kartya
                            WHERE kartya_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}

// returns an array containing the range of free card IDs in the following form:
// array[range index]['start'] - array[range index]['stop']
// where 'start' is the first free ID, and stop is the last free ID.
function db_getFreeCardRanges() {
    $cardIds = db_getAllCardIds();
    $freeRanges = array();

    for ($i = 1; $i < count($cardIds); $i++) {
        $currVal = $cardIds[$i]['id'];
        $prevVal = $cardIds[$i - 1]['id'];
        if ($currVal - $prevVal > 1) {
            $j = count($freeRanges);
            $freeRanges[$j]['start'] = $prevVal + 1;
            $freeRanges[$j]['end'] = $currVal - 1;
        }
    }

    return $freeRanges;
}

function db_isCardRangeFree($start, $end) {
    $cardIds = db_getAllCardIds();

    foreach ($cardIds as $card) {
        $id = $card['id'];
        if ($id >= $start && $id <= $end)
            return FALSE;
    }

    return TRUE;
}