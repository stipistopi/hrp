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
