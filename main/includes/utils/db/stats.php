<?php
/**
 * Returns the number of days from start day for the corresponding user if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return int containing the days from start, or FALSE if the user cannot be found.
 */
function db_getNumberOfDaysFromStart($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    // get company's start day
    $ret = db_getCompanyDataRaw($id, $username, $email, $cardId);
    if (empty($ret)) return FALSE;
    $startDay = $ret['kezdo_nap'];

    // days between company's start day and now
    $now = time();
    $startDay = strtotime($startDay);
    $dateDiff = $now - $startDay;
    $days = floor($dateDiff / (60 * 60 * 24));

    return $days;
}

/**
 * Returns the number of days to the end of program for the corresponding user if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return int containing the days to the program end, or FALSE if the user cannot be found.
 */
function db_getNumberOfDaysToProgramEnd($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    // get company's start day
    $ret = db_getCompanyDataRaw($id, $username, $email, $cardId);
    if (empty($ret)) return FALSE;
    $startDay = $ret['kezdo_nap'];

    // days between company's start day and now
    $now = time();
    $startDay = strtotime($startDay);
    $dateDiff = $now - $startDay;
    $days = floor($dateDiff / (60 * 60 * 24));

    // get the full time window range in the program
    global $conn;
    $stmt = $conn->prepare("SELECT MAX(ertek) FROM idoablakok");
    $stmt->execute();
    $maxDays = $stmt->fetchColumn();
    $maxDaysOffset = $maxDays + 10;

    return $maxDaysOffset - $days;
}

/**
 * Returns the number of days to next time window for the corresponding user if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @param string $timeWindowName
 * @return int containing the days to the next time window, or FALSE if the user cannot be found.
 */
function db_getDaysToNextTimeWindow($id = -1, $username = "-1", $email = "-1", $cardId = -1, $timeWindowName = "-1") {
    // get company's start day
    $ret = db_getCompanyDataRaw($id, $username, $email, $cardId);
    if (empty($ret)) return FALSE;
    $startDay = $ret['kezdo_nap'];

    // days between company's start day and now
    $now = time();
    $startDay = strtotime($startDay);
    $dateDiff = $now - $startDay;
    $days = floor($dateDiff / (60 * 60 * 24));

    // get value of the next time window
    global $conn;
    $stmt = $conn->prepare("SELECT ertek
                            FROM idoablakok
                            WHERE nev = :tname");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    $timeWindowValue = $stmt->fetchColumn();

    return $timeWindowValue - $days;
}

/**
 * Returns the time window description from time window name.
 * @param string $timeWindowName
 * @return string containing the time window description, or FALSE if it cannot be found.
 */
function db_getTimeWindowDescription($timeWindowName = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT leiras
                            FROM idoablakok
                            WHERE nev = :tname");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the next time window description from time window name.
 * @param string $timeWindowName
 * @return string containing the next time window description, or FALSE if it cannot be found.
 */
function db_getNextTimeWindowDescription($timeWindowName = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT leiras
                            FROM idoablakok
                            WHERE id > (SELECT id
                                        FROM idoablakok
                                        WHERE nev = :tname)
                            ORDER BY id ASC
                            LIMIT 1");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    $row_count = $stmt->rowCount();

    if($row_count == 0) {
        return "Nincs következő ciklus";
    } else {
        return $stmt->fetchColumn();
    }
}

/**
 * Returns the number of filled out tests for the corresponding user.
 * @param int $userId
 * @return int containing the number of filled out tests, or FALSE if it cannot be found the user.
 */
function db_getHowManyTestsFilledOut($userId = -1) {
    $teszt = "%teszt%";

    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret))
        return FALSE;
    else
        $userName = $ret['felh_nev'];

    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM aktivitas, aktivitas_ertekek
                            WHERE aktivitas_ertekek.felhNev = :uname AND
                                  aktivitas_ertekek.aktivitasId = aktivitas.id AND
                                  aktivitas.leiras LIKE :test AND
                                  suly > 0");
    $stmt->bindParam(':uname', $userName);
    $stmt->bindParam(':test', $teszt);
    $stmt->execute();

    return $stmt->fetchColumn();
}

/**
 * Returns the number of how many tests are left for the corresponding user.
 * @param int $userId
 * @return int containing the number of tests that are not filled out yet, or FALSE if it cannot be found the user.
 */
function db_getHowManyTestsAreLeft($userId = -1) {
    $teszt = "%teszt%";

    $numberOfFilledOutTests = db_getHowManyTestsFilledOut($userId);

    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM aktivitas
                            WHERE leiras LIKE :test AND suly > 0");
    $stmt->bindParam(':test', $teszt);
    $stmt->execute();
    $maxTests = $stmt->fetchColumn();

    return $maxTests - $numberOfFilledOutTests;
}

/**
 * Returns the number of how many lecke are in the full program.
 * @return int containing the number of leckes, or FALSE if it founds none (it's failure).
 */
function db_getNumberOfAllLecke() {
    $pattern = "%lecke%";

    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM idoablakok
                            WHERE nev LIKE :pattern");
    $stmt->bindParam(':pattern', $pattern);
    $stmt->execute();

    return $stmt->fetchColumn();
}

/**
 * Adds a user's activity.
 * @param $timeWindowName
 * @param $actName
 * @param $userId
 * @param $userName
 * @param $email
 * @param $cardId
 * @return bool TRUE on success or FALSE on failure.
 */
function db_addUserActivity($timeWindowName = "-1", $actName = "-1", $userId = -1, $userName = "-1", $email = "-1", $cardId = -1) {
    $tid = db_getTimeWindowIdFromName($timeWindowName);

    if($userName == "-1" || empty($userName)) {
        $ret = db_getUserDataRaw($userId, null, $email, $cardId);
        if(empty($ret)) return FALSE; else $userName = $ret['felh_nev'];
    }

    global $conn;
    $stmt = $conn->prepare("INSERT INTO aktivitas_ertekek
                            VALUES (NULL, (SELECT id
                                           FROM aktivitas
                                           WHERE idoablakId = :twid AND nev = :aname), :uname, NOW())");
    $stmt->bindParam(':twid', $tid);
    $stmt->bindParam(':aname', $actName);
    $stmt->bindParam(':uname', $userName);
    return $stmt->execute();
}

/**
 * Check if a user's activity is inserted or not.
 * @param $timeWindowName
 * @param $actName
 * @param $userId
 * @param $userName
 * @param $email
 * @param $cardId
 * @return bool TRUE on success or FALSE on failure.
 */
function db_checkUserActivity($timeWindowName = "-1", $actName = "-1", $userId = -1, $userName = "-1", $email = "-1", $cardId = -1) {
    $tid = db_getTimeWindowIdFromName($timeWindowName);

    if($userName == "-1" || empty($userName)) {
        $ret = db_getUserDataRaw($userId, null, $email, $cardId);
        if(empty($ret)) return false; else $userName = $ret['felh_nev'];
    }

    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM aktivitas_ertekek
                            WHERE aktivitasId = (SELECT id
                                                 FROM aktivitas
                                                 WHERE idoablakId = :twid AND nev = :aname) AND felhNev = :uname");
    $stmt->bindParam(':twid', $tid);
    $stmt->bindParam(':aname', $actName);
    $stmt->bindParam(':uname', $userName);
    $stmt->execute();

    if($stmt->rowCount()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Returns the three column data for the corresponding lecke (test type: lecke start test).
 * @param $userId
 * @param $numberOfLecke
 * @return array 1D associative array containing the graph dara, or FALSE if the user cannot be found.
 */
function db_getGraphDataForLeckeStartTest($userId = -1, $numberOfLecke = -1) {
    $graphData = array();

    $leckeName = "lecke" . $numberOfLecke . "kezdo";

    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret)) return FALSE; else $userName = $ret['felh_nev'];

    /* first column for the graph */
    global $conn;
    $stmt = $conn->prepare("SELECT szazalek
                            FROM kitolt
                            WHERE felhNev = :uname AND tesztId = (SELECT id
                                                                  FROM teszt
                                                                  WHERE nev = :lname)");
    $stmt->bindParam(':uname', $userName);
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    if($row_count == 0) {
        array_push($graphData, 0);
    } else {
        array_push($graphData, round($stmt->fetchColumn() * 100));
    }

    /* second column for the graph */
    array_push($graphData, round(0.25 * 100));

    /* third column for the graph */

    $ret = db_getUserDataRaw($userId, null, null, null);
    $cardId = $ret['kartyaId'];

    $stmt = $conn->prepare("SELECT cegId
                            FROM kartya
                            WHERE kartya_id = :kartya");
    $stmt->bindParam(':kartya', $cardId);
    $stmt->execute();
    $companyId = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT AVG(szazalek)
                            FROM kitolt
                            WHERE felhNev IN (SELECT felh_nev
                                              FROM felhasznalo
                                              WHERE kartyaId IN (SELECT kartya_id
                                                                 FROM kartya
                                                                 WHERE cegId = :compId)) AND tesztId = (SELECT id
                                                                                                        FROM teszt
                                                                                                        WHERE nev = :lname)");
    $stmt->bindParam(':compId', $companyId);
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    if($row_count == 0) {
        array_push($graphData, 0);
    } else {
        array_push($graphData, round($stmt->fetchColumn() * 100));
    }

    return $graphData;
}

/**
 * Returns the three column data for the corresponding lecke (test type: lecke kerdezz test).
 * @param $numberOfLecke
 * @return array 1D associative array containing the graph dara, or FALSE if the user cannot be found.
 */
function db_getGraphDataForLeckeKerdezzTest($numberOfLecke = -1) {
    $graphData = array();

    $leckeName = "lecke" . $numberOfLecke . "kf";

    /* összes kitöltő */
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM kitolt
                            WHERE tesztId = (SELECT id
                                             FROM teszt
                                             WHERE nev = :lname)");
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    $allFiller = $stmt->fetchColumn();

    /* first column for the graph */
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM kitolt
                            WHERE tesztId = (SELECT id
                                             FROM teszt
                                             WHERE nev = :lname) AND pontszam BETWEEN 0 AND 3");
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    if($row_count == 0 || $allFiller == 0) {
        array_push($graphData, 0);
    } else {
        array_push($graphData, round(($stmt->fetchColumn() / $allFiller) * 100));
    }

    /* second column for the graph */
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM kitolt
                            WHERE tesztId = (SELECT id
                                             FROM teszt
                                             WHERE nev = :lname) AND pontszam BETWEEN 4 AND 7");
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    if($row_count == 0 || $allFiller == 0) {
        array_push($graphData, 0);
    } else {
        array_push($graphData, round(($stmt->fetchColumn() / $allFiller) * 100));
    }

    /* third column for the graph */
    $stmt = $conn->prepare("SELECT COUNT(*)
                            FROM kitolt
                            WHERE tesztId = (SELECT id
                                             FROM teszt
                                             WHERE nev = :lname) AND pontszam BETWEEN 8 AND 10");
    $stmt->bindParam(':lname', $leckeName);
    $stmt->execute();
    $row_count = $stmt->rowCount();
    if($row_count == 0 || $allFiller == 0) {
        array_push($graphData, 0);
    } else {
        array_push($graphData, round(($stmt->fetchColumn() / $allFiller) * 100));
    }

    return $graphData;
}
