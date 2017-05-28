<?php
/* Alex 07.04.2017 */

$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold ORDER BY idinnhold DESC LIMIT 1;");
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($row) {
	$overskrift = $row['tittel'];
	$text = $row['tekst'];
	$id = $row['idinnhold'];


	$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$bilde = "PHP/Bilder/".$row['hvor'];

	echo("
		<div class='staticinnhold'>
	  <h1>$overskrift</h1>
	  <img src='$bilde'>
	  <p>$text</p>
		</div>
	");
}

?>
