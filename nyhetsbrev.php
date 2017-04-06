<!--
Sist endret av Erlend 26.02.2017
Sett på av Sindre 27.02.2017
-->
<?php
include 'PHP/Include/mysqlcon.php';

$mail = mysqli_real_escape_string($mysqli, $_POST["fname"]);

$stmt = $mysqli->prepare("INSERT INTO nyhetsbrev set Mail =?");
$stmt->bind_param("s",$mail);
$stmt->execute();

header("location:default.php");
?>
