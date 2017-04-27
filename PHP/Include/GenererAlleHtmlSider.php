<?php
include 'mysqlcon.php';
//LEGGE TIL GENERERING AV SUBMENYER
$stmt33 = $mysqli->prepare("SELECT * FROM meny LEFT JOIN submeny ON meny.idmeny = submeny.meny_idmeny ORDER BY idmeny;");
mysqli_set_charset($mysqli, "UTF8");
$stmt33->execute();
$result33 = $stmt33->get_result();
include ("createInnholdFile.php");
$menyid;
<<<<<<< HEAD

while ($row33 = $result33->fetch_assoc()){
	
=======
$array = [];
$int = 0;
while ($row33 = $result33->fetch_assoc()){
	$menyid = $row33['idmeny'];
>>>>>>> 30b251dd28367e48f4fcf5d7fa41ab82da9df585
	$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
	mysqli_set_charset($mysqli, "UTF8");
	$menyid = $row33['idmeny'];
	$stmt3->bind_param("i", $menyid);
	$stmt3->execute();
	$result3 = $stmt3->get_result();
	$count = 0;
	while ($row3 = $result3->fetch_assoc()){
<<<<<<< HEAD
		
			$idinnhol = $row3['idinnhold'];
			$sideInsert = "../../".$row3['side'];
			if(empty($idinnhol) == false){
				
				$fh = fopen($sideInsert, 'w', 'w');
				$stringen = lagBestemtSide($idinnhol);
				
				fwrite($fh, $stringen);
				
			}
			$count++;
			
			
=======
			$idinnhol = $row3['idinnhold'];
			$sideInsert = "../../".$row3['side'];
			$fh = fopen($sideInsert, 'w', 'w');
			$stringen = lagBestemtSide($idinnhol);
			$array[$int] = $stringen;
			$int++;
			fwrite($fh, $stringen);
			$count++;

>>>>>>> 30b251dd28367e48f4fcf5d7fa41ab82da9df585
		}
		if ($count = 1){			
			koblemeny($menyid);
		}
	// lager oversikt til innhold
	//	include("NyArtikkel.php");
	//	lagSide2($row3['idmeny']);

	}
	/*



die();
?>
