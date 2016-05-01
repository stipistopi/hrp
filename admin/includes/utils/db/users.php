<?php
/**
 * Returns the user data if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @return mixed 1D associative array containing the raw table row, or FALSE if the user cannot be found.
 */
function db_getUserDataRaw($id = -1, $username = "-1") {
    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM admin_users
                            WHERE (id = :id OR username = :username)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}

/**
 * Returns the user name if at least one parameter is defined. Undefined parameters must be set to null.
 * @param string $username
 * @return mixed string containing the username, or FALSE if the user cannot be found.
 */
function db_getUserId($username) {
    $ret = db_getUserDataRaw(null, $username);
    if (empty($ret))
        return FALSE;
    return $ret['id'];
}

/**
 * Returns the password hash of the specified user if at least one parameter is defined.
 * Undefined parameters must be set to null.
 * @param int $id
 * @param string $username
 * @return mixed string containing the password hash, or FALSE if the user cannot be found.
 */
function db_getUserHash($id, $username) {
    $ret = db_getUserDataRaw($id, $username);
    if (empty($ret))
        return FALSE;
    return $ret['password_hash'];
}

function db_setUserHash($id, $hash) {
    if ($id < 0) return FALSE;
    global $conn;
    $stmt = $conn->prepare("UPDATE admin_users
                            SET password_hash = :hash 
                            WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':hash', $hash);
    return $stmt->execute();
}

function db_getUserEmail($id, $username) {
    $ret = db_getUserDataRaw($id, $username);
    if (empty($ret))
        return FALSE;
    return $ret['email'];
}

function db_setUserEmail($id, $newEmail) {
    if ($id < 0) return FALSE;
    global $conn;
    $stmt = $conn->prepare("UPDATE admin_users
                            SET email = :email 
                            WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':email', $newEmail);
    return $stmt->execute();
}
