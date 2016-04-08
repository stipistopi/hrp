<?php
/**
 * Returns the company data if the ID is defined.
 * @param int $id
 * @return mixed 1D associative array containing the raw table row, or FALSE if the company cannot be found.
 */
function db_getCompanyDataRaw($id = -1) {
    global $conn;
    $stmt = $conn->prepare("SELECT *
                            FROM ceg
                            WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}

/**
 * @return array 2D array containing the companies with the following keys: id, name.
 */
function db_getCompaniesOverview() {
    global $conn;
    $stmt = $conn->prepare("SELECT id AS id, vallalat_nev AS name
                            FROM ceg");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_BOTH);
}
