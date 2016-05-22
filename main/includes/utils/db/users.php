<?php
/**
 * Returns the user data if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed 1D associative array containing the raw table row, or FALSE if the user cannot be found.
 */
function db_getUserDataRaw($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM felhasznalo
                            WHERE (id = :id OR felh_nev = :username OR email = :email OR kartyaId = :cardId)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cardId', $cardId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}

/**
 * Check if card is activated or not, if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return bool TRUE if activated or FALSE if not.
 */
function db_testCardValidation($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM kartya
                            WHERE kartya_id = (SELECT kartyaId
                                               FROM felhasznalo
                                               WHERE (id = :id OR felh_nev = :username OR email = :email OR kartyaId = :cardId))
                                  AND aktiv = 1");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cardId', $cardId);
    $stmt->execute();

    if($stmt->rowCount()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Returns the user name if at least one parameter is defined. Undefined parameters must be set to null.
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed string containing the username, or FALSE if the user cannot be found.
 */
function db_getUserId($username, $email, $cardId) {
    $ret = db_getUserDataRaw(null, $username, $email, $cardId);
    if (empty($ret))
        return FALSE;
    return $ret['id'];
}

/**
 * Returns the password hash of the specified user if at least one parameter is defined.
 * Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed string containing the password hash, or FALSE if the user cannot be found.
 */
function db_getUserHash($id, $username, $email, $cardId) {
    $ret = db_getUserDataRaw($id, $username, $email, $cardId);
    if (empty($ret))
        return FALSE;
    return $ret['jelszo'];
}

/**
 * Returns the user's first name if at least one parameter is defined. Undefined parameters must be set to null.
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed string containing the user's first name, or FALSE if the user cannot be found.
 */
function db_getUserFirstName($username, $email, $cardId) {
    $ret = db_getUserDataRaw(null, $username, $email, $cardId);
    if (empty($ret))
        return FALSE;
    return $ret['ker_nev'];
}

/**
 * Returns the user's last login date and time if at least one parameter is defined. Undefined parameters must be set to null.
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed string containing the user's last login date and time, or FALSE if the user cannot be found.
 */
function db_getUserLastLogin($username, $email, $cardId) {
    $ret = db_getUserDataRaw(null, $username, $email, $cardId);
    if (empty($ret))
        return FALSE;
    return $ret['ut_belepes'];
}

/**
 * Updates a user's last login value.
 * @param $id
 * @param $username
 * @param $email
 * @param $cardId
 * @return bool TRUE on success or FALSE on failure.
 */
function db_updateLastLogin($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    global $conn;
    $stmt = $conn->prepare("UPDATE felhasznalo
                            SET ut_belepes = NOW()
                            WHERE (id = :id OR felh_nev = :username OR email = :email OR kartyaId = :cardId)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cardId', $cardId);
    return $stmt->execute();
}

/**
 * Returns the user's time window name if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return string containing the user's time window name, or FALSE if the user cannot be found.
 */
function db_getUserTimeWindow($id = -1, $username = "-1", $email = "-1", $cardId = -1) {
    // get company's start day
    $ret = db_getCompanyDataRaw($id, $username, $email, $cardId);
    if (empty($ret)) return FALSE;
    $startDay = $ret['kezdo_nap'];

    // days between company's start day and now
    $now = time();
    $startDay = strtotime($startDay);
    $dateDiff = $now - $startDay;
    $days = floor($dateDiff / (60 * 60 * 24));
    $days_offset = $days + 10;

    // get and return with time window name
    global $conn;
    $stmt = $conn->prepare("SELECT nev FROM idoablakok
                            WHERE ertek BETWEEN :days AND :days_offset
                            ORDER BY ertek ASC
                            LIMIT 1;");
    /* azért kell ez, mert a 10. napon pl. mindkét
     * időablakot kidobja, az 1.-t meg a 2.-at is,
     * és így biztosan csak az időben előbb lévőt
     * fogja (aztán a 11. napon vált) */
    $stmt->bindParam(':days', $days);
    $stmt->bindParam(':days_offset', $days_offset);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Returns the time window id from time window name.
 * @param string $timeWindowName
 * @return int containing the time window id, or FALSE if it cannot be found.
 */
function db_getTimeWindowIdFromName($timeWindowName = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT id
                            FROM idoablakok
                            WHERE nev = :tname");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Check if the user's actual time window value greater than the first time window or not.
 * @param string $timeWindowName
 * @return bool TRUE if greater, or FALSE if not.
 */
function db_checkIfTimeWindowGreaterThanPkezdo($timeWindowName = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT ertek
                            FROM idoablakok
                            WHERE nev = :tname");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    $currTw = $stmt->fetchColumn();

    $timeWindowName = "pkezdo";

    $stmt = $conn->prepare("SELECT ertek
                            FROM idoablakok
                            WHERE nev = :tname");
    $stmt->bindParam(':tname', $timeWindowName);
    $stmt->execute();
    $pkezdoTw = $stmt->fetchColumn();
    $pkezdoTw++;

    if($pkezdoTw <= $currTw) {
        return true;
    } else {
        return false;
    }
}

/**
 * Adds a new user into the database.
 * @param $email
 * @param $username
 * @param $cardId
 * @param $password
 * @param $lastName
 * @param $firstName
 * @param $namePrefix
 * @param $telephoneNumber
 * @param $city
 * @param $city_district
 * @return bool TRUE on success or FALSE on failure.
 */
function db_addUser($email, $username, $cardId, $password, $lastName, $firstName, $namePrefix, $telephoneNumber,
                    $city, $city_district) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO felhasznalo (email, felh_nev, kartyaId, jelszo, vez_nev, ker_nev, elonev,
                              telefon, lakhely_varos, lakhely_varosresz)
                            VALUES (:email, :username, :cardId, :password, :lastName, :firstName, :namePrefix,
                              :telephoneNumber, :city, :city_district)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':cardId', $cardId);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':namePrefix', $namePrefix);
    $stmt->bindParam(':telephoneNumber', $telephoneNumber);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':city_district', $city_district);
    return $stmt->execute();
}

/**
 * Returns a percentage of user's status in full program.
 * @param $userId
 * @return int (percentage) on success or FALSE on failure.
 */
function db_getStatusInFullProgram($userId = -1) {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if (empty($ret)) return FALSE; else $userName = $ret['felh_nev'];

    global $conn;
    $stmt = $conn->prepare("SELECT SUM(suly) FROM aktivitas");
    $stmt->execute();
    $egesz = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT SUM(suly)
                            FROM aktivitas, aktivitas_ertekek
                            WHERE aktivitas.id = aktivitas_ertekek.aktivitasId AND felhNev = :usern");
    $stmt->bindParam(':usern', $userName);
    $stmt->execute();
    $resz = $stmt->fetchColumn();

    return round($resz * (100 / $egesz));
}

/**
 * Returns a percentage of user's status in the current lecke.
 * @param $userId
 * @param $timeWindowName
 * @return int (percentage) on success or FALSE on failure.
 */
function db_getStatusInLecke($userId = -1, $timeWindowName = "-1") {
    $ret = db_getUserDataRaw($userId, null, null, null);
    if (empty($ret)) return FALSE; else $userName = $ret['felh_nev'];

    $tid = db_getTimeWindowIdFromName($timeWindowName);

    global $conn;
    $stmt = $conn->prepare("SELECT SUM(suly)
                            FROM aktivitas
                            WHERE idoablakId = :twid");
    $stmt->bindParam(':twid', $tid);
    $stmt->execute();
    $egesz = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT SUM(suly)
                            FROM aktivitas, aktivitas_ertekek
                            WHERE aktivitas.id = aktivitas_ertekek.aktivitasId AND felhNev = :usern AND idoablakId = :twid");
    $stmt->bindParam(':usern', $userName);
    $stmt->bindParam(':twid', $tid);
    $stmt->execute();
    $resz = $stmt->fetchColumn();

    return round($resz * (100 / $egesz));
}
