<?php
include("mysqlcon.php");
function getIdinnhold() {

    global $mysqli;
    $stmt = $mysqli->prepare("SELECT idinnhold FROM innhold LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $idinnhold = "";

    while($row = $result->fetch_assoc()) {
        $idinnhold = $row['idinnhold'];
    }

    $mysqli->close();
    return $idinnhold;
}
