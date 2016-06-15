<?php
/**
 * Returns the company data if the ID is defined.
 * @param int $id
 * @param string $name
 * @return mixed 1D associative array containing the raw table row, or FALSE if the company cannot be found.
 */
function db_getCompanyData($id = -1, $name = "-1")
{
    global $conn;
    $stmt = $conn->prepare("SELECT id AS id, vallalat_nev AS name
                            FROM ceg
                            WHERE id = :id OR vallalat_nev = :cname");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':cname', $name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_BOTH);
}

/**
 * Returns the company locations if the ID is defined.
 * @param int $id
 * @return mixed 1D number indexed array containing the company locations, or FALSE if the company cannot be found.
 */
function db_getCompanyLocationData($id = -1)
{
    global $conn;
    $stmt = $conn->prepare("SELECT vallalat_telephely AS location
                            FROM telephely
                            WHERE cegId = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_NUM);
}

/**
 * Updates the company location data.
 * @param int $id
 * @param string $locations the new locations of the company
 * @return boolean TRUE if the operation succeeded, FALSE otherwise.
 */
function db_updateCompanyLocationData($id = -1, $locations = null)
{
    global $conn;

    if (empty($locations) || $id < 0) return FALSE;

    $stmt = $conn->prepare("DELETE FROM telephely
                            WHERE cegId = :id");
    $stmt->bindParam(':id', $id);
    if (!$stmt->execute()) return FALSE;

    $stmt = $conn->prepare("INSERT INTO telephely
                            VALUES(:id, :location)");
    $stmt->bindParam(':id', $id);
    foreach ($locations as $location) {
        $stmt->bindParam(':location', $location);
        if (!$stmt->execute()) return FALSE;
    }

    return TRUE;
}

/**
 * Updates the company name.
 * @param int $id
 * @param string $name the new name of the company
 * @return boolean TRUE if the operation succeeded, FALSE otherwise.
 */
function db_updateCompanyName($id = -1, $name = "")
{
    if (empty($name) || $id < 0) return FALSE;
    global $conn;
    $stmt = $conn->prepare("UPDATE ceg
                            SET vallalat_nev = :name 
                            WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    return $stmt->execute();
}

/**
 * Returns the ID and name of all companies in the database.
 * @return mixed 2D array containing the companies with the following keys: id, name, or FALSE if the operation failed.
 */
function db_getCompaniesOverview()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id AS id, vallalat_nev AS name
                            FROM ceg");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_BOTH);
}
