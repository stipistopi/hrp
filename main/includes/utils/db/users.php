<?php
/**
 * Returns the user data if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @param string $email
 * @param string $cardId
 * @return mixed 1D associative array containing the raw table row, or FALSE if the user cannot be found.
 */
function db_getUserDataRaw($id = -1, $username = "-1", $email = "-1", $cardId = "-1") {
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
 * Returns the user name if at least one parameter is defined. Undefined parameters must be set to null.
 * @param string $username
 * @param string $email
 * @param string $cardId
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
 * @param string $cardId
 * @return mixed string containing the password hash, or FALSE if the user cannot be found.
 */
function db_getUserHash($id, $username, $email, $cardId) {
    $ret = db_getUserDataRaw($id, $username, $email, $cardId);
    if (empty($ret))
        return FALSE;
    return $ret['jelszo'];
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
