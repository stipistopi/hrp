<?php

/**
 * Returns the company data if at least one parameter is defined. Undefined parameters must be set to null.
 * @param int $userId
 * @param string $username
 * @param string $email
 * @param int $cardId
 * @return mixed 1D associative array containing the raw table row, or FALSE if the user cannot be found.
 */
function db_getCompanyDataRaw($userId = -1, $username = "-1", $email = "-1", $cardId = -1) {
    if(empty($cardId) || $cardId == -1) {
        global $conn;
        $stmt = $conn->prepare("SELECT kartyaId
                            FROM felhasznalo
                            WHERE (id = :id OR felh_nev = :username OR email = :email)");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $cardId = $stmt->fetchColumn();
    }

    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM ceg
                            WHERE id = (SELECT cegId
                                        FROM kartya
                                        WHERE kartya_id = :cardId)");
    $stmt->bindParam(':cardId', $cardId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}