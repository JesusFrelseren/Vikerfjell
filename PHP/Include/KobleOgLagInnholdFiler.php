<?php
	$idValue = $_POST['menylistephp'];
	if(strpos($idValue, "SUB") !== false) {
		$idValue = substr($idValue, 3);
		$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold join vikerfjell.submeny on innhold.idmeny = submeny.meny_idmeny where submeny.idsubmeny = ?");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt3->bind_param("i",$idValue);
		$stmt3->execute();
		$result3 = $stmt3->get_result();
		$count = 0;
		while($row3 = $result3->fetch_assoc()){
			$count ++;
			$navn = $row3['tittel'];
		}
		$idValue = "S".$idValue;


	} else {
		$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt3->bind_param("i",$idValue);
		$stmt3->execute();
		$result3 = $stmt3->get_result();
		$count = 0;
		while($row3 = $result3->fetch_assoc()){
			$count ++;
			$navn = $row3['tittel'];
		}

	}
	if ($count > 2){
		include("NyArtikkel.php");
		lagSide2($idValue);
		if(strpos($idValue, "S") !== false) {
			$idValue = substr($idValue, 1);
		}

		include("createInnholdFile.php");
		$sideInsert = "../../".$navn.'.html';
		$fh = fopen($sideInsert, 'w', 'w');
		$stringen = lagSide();
		fwrite($fh, $stringen);

		} elseif($count==2) {
			include("NyArtikkel.php");
			lagSide2($idValue);
			include("createInnholdFile.php");
			if(strpos($idValue, "S") !== false) {
				$idValue = substr($idValue, 1);
				$sql = "SELECT * FROM innhold LEFT JOIN submeny ON innhold.idmeny = submeny.meny_idmeny WHERE submeny.idsubmeny = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("i", $idValue);
				$stmt->execute();
				$result = $stmt->get_result();
			} else {
				$sql = "SELECT * FROM innhold WHERE idmeny = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("i", $idValue);
				$stmt->execute();
				$result = $stmt->get_result();
			}

			while($row = $result->fetch_assoc()) {
				$navn = $row['tittel'];
				$idInnhold = $row['idinnhold'];
				$sideInsert = "../../".$navn.'.html';
				$fh = fopen($sideInsert, 'w', 'w');
				$stringen = lagBestemtSide($idInnhold);
				fwrite($fh, $stringen);
			}

		}else{
			include("createInnholdFile.php");
			koblemeny($idValue);

	}
?>
