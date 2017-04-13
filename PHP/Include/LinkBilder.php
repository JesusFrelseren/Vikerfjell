<?php
include('mysqlcon.php');

if (isset($_POST['idbilder']) && $_POST['idinnhold']) {
    $idbilder = $_POST['idbilder'];
    $idinnhold = $_POST['idinnhold'];

    $stmt = $mysqli->prepare("insert into bilderinnhold values(?, ?)");
    $stmt->bind_param('ii', $idbilder, $idinnhold);
    $stmt->execute();

}
