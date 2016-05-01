<?php

/**
 * Returns TRUE if the user filled out the given test (that is in table 'kitolt') or FALSE otherwise.
 * @param int $userId
 * @param string $testName
 * @return string with username (first column in the matched row) on success or FALSE on failure.
 */
function db_checkIfTestFilledOut($userId = -1, $testName = "-1") {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret)) return FALSE;
    $username = $ret['felh_nev'];

    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM kitolt
                            WHERE (felhNev = :username AND tesztId = (SELECT id
                                                                      FROM teszt
                                                                      WHERE nev = :testName))");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':testName', $testName);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns TRUE if the user filled out the given 'lecke end' test (that is in table 'lzaro_kitolt') or FALSE otherwise.
 * @param int $userId
 * @param string $timeWindowName
 * @return int with serial number (first column in the matched row) on success or FALSE on failure.
 */
function db_checkIfLeckeEndTestFilledOut($userId = -1, $timeWindowName = "-1") {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret)) return FALSE;
    $username = $ret['felh_nev'];

    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM lzaro_kitolt
                            WHERE (felhNev = :username AND idoablakId = (SELECT id
                                                                         FROM idoablakok
                                                                         WHERE nev = :twn))");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':twn', $timeWindowName);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the lecke starting test name for the corresponding time window name.
 * @param string $timeWindowName
 * @return string containing the lecke starting test name, or FALSE if it cannot be found.
 */
function db_getLeckeStartTestName($timeWindowName = "-1") {
    $kezdo = "%kezdo";

    global $conn;
    $stmt = $conn->prepare("SELECT nev
                            FROM teszt
                            WHERE (idoablakId = (SELECT id
                                                 FROM idoablakok
                                                 WHERE nev = :timeWindowName) AND nev LIKE :kezdo)");
    $stmt->bindParam(':timeWindowName', $timeWindowName);
    $stmt->bindParam(':kezdo', $kezdo);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the 'lecke kerdezz' test name for the corresponding time window name.
 * @param string $timeWindowName
 * @return string containing the 'lecke kerdezz' test name, or FALSE if it cannot be found.
 */
function db_getLeckeKerdezzTestName($timeWindowName = "-1") {
    $kezdo = "%kf";

    global $conn;
    $stmt = $conn->prepare("SELECT nev
                            FROM teszt
                            WHERE (idoablakId = (SELECT id
                                                 FROM idoablakok
                                                 WHERE nev = :timeWindowName) AND nev LIKE :kezdo)");
    $stmt->bindParam(':timeWindowName', $timeWindowName);
    $stmt->bindParam(':kezdo', $kezdo);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the test id for the corresponding test name.
 * @param string $testName
 * @return integer containing the test id, or FALSE if it cannot be found.
 */
function db_getTestId($testName = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM teszt WHERE nev = :testName");
    $stmt->bindParam(':testName', $testName);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the first question id for the corresponding test.
 * @param int $testId
 * @return integer containing the first question id, or FALSE if it cannot be found.
 */
function db_getStartQuestionId($testId = -1) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM kerdes WHERE tesztId = :testId ORDER BY id ASC LIMIT 1;");
    $stmt->bindParam(':testId', $testId);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the question interval for the corresponding test.
 * @param int $testId
 * @return integer containing the question interval, or FALSE if the test cannot be found.
 */
function db_getQuestionInterval($testId = -1) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(id) FROM kerdes WHERE tesztId = :testId");
    $stmt->bindParam(':testId', $testId);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Adds a new record in table kitolt into the database.
 * @param $userId
 * @param $testName
 * @param $points
 * @param $time
 * @param $percentage
 * @return bool TRUE on success or FALSE on failure.
 */
function db_addNewRecordInTableKitolt($userId, $testName, $points, $time, $percentage) {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret)) return FALSE; else $userName = $ret['felh_nev'];

    $ret = db_getTestId($testName);
    if(empty($ret)) return FALSE; else $testId = $ret;

    global $conn;
    $stmt = $conn->prepare("INSERT INTO kitolt
                            VALUES (:uname, :tid, :point, :secs, NOW(), :percentage)");
    $stmt->bindParam(':uname', $userName);
    $stmt->bindParam(':tid', $testId);
    $stmt->bindParam(':point', $points);
    $stmt->bindParam(':secs', $time);
    $stmt->bindParam(':percentage', $percentage);
    return $stmt->execute();
}

/**
 * Adds a new record in table lzaro_kitolt into the database.
 * @param $userId
 * @param $timeWindowName
 * @param $testName
 * @param $time
 * @return integer containing the last inserted id, or FALSE on failure.
 */
function db_addNewRecordInTableLzaro_kitolt($userId, $timeWindowName, $testName, $time) {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if(empty($ret)) return FALSE; else $userName = $ret['felh_nev'];

    $tid = db_getTimeWindowIdFromName($timeWindowName);

    $ret = db_getTestId($testName);
    if(empty($ret)) return FALSE; else $testId = $ret;

    global $conn;
    $stmt = $conn->prepare("INSERT INTO lzaro_kitolt
                            VALUES (NULL, :uname, :tid, :testId, :secs, NOW())");
    $stmt->bindParam(':uname', $userName);
    $stmt->bindParam(':tid', $tid);
    $stmt->bindParam(':testId', $testId);
    $stmt->bindParam(':secs', $time);
    $stmt->execute();
    return $conn->lastInsertId();
}

/**
 * Adds a new record in table lzaro_kitolt into the database.
 * @param $kitoltId
 * @param $valaszId
 * @return bool TRUE on success or FALSE on failure.
 */
function db_addNewRecordInTableLzaro_valaszok($kitoltId, $valaszId) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO lzaro_valaszok
                            VALUES (NULL, :kitId, (SELECT kerdesId
                                                   FROM valasz
                                                   WHERE id = :valId), :valId)");
    $stmt->bindParam(':kitId', $kitoltId);
    $stmt->bindParam(':valId', $valaszId);
    return $stmt->execute();
}
