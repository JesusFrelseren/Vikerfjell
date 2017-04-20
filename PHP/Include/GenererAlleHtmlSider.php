<?php
$stmt33 = $mysqli->prepare("SELECT * FROM vikerfjell.meny");
mysqli_set_charset($mysqli, "UTF8");
$stmt33->execute();
$result33 = $stmt33->get_result();
while ($row33 = $result33->fetch_assoc())
	{
	$menyid = $row33['idmeny'];
	$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt3->bind_param("i", $menyid);
	$stmt3->execute();
	$result3 = $stmt3->get_result();
	$count = 0;
	while ($row3 = $result3->fetch_assoc())
		{
		include ("createInnholdFile.php");
		$sideInsert = "../../" .$row3['tittel']. '.html';
		$fh = fopen($sideInsert, 'w', 'w');
		$stringen = lagBestemtSide($row3['idinnhold']);
		fwrite($fh, $stringen);
		$count++;
		}

	// lager oversikt til innhold
	//	include("NyArtikkel.php");
	//	lagSide2($row3['idmeny']);

	}

?>
