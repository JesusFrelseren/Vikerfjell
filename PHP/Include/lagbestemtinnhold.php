<?php
/* Alex 07.04.2017 */

$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idinnhold = ?;");
$stmt->bind_param("i",$idinnold);
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$overskrift = $row['tittel'];
$text = $row['tekst'];
$id = $row['idinnhold'];



$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$bilde = "PHP/Bilder/".$row['hvor'];


		echo("<div class='staticinnhold'>
		<H1>$overskrift</h1>
		<img src=$bilde width=100% height=auto>
		<p>$text</p>
		</div>");


?>
