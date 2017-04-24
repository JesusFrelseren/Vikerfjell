<?php

/*
function lagFil($value) {
	global $mysqli;
	
	$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt3->bind_param("i",$idValue);
	$stmt3->execute();
	$result3 = $stmt3->get_result();
	$count = 0;
	while($row3 = $result3->fetch_assoc()){
		$count ++;
		$navn = $row3['tittel'];
		$array[0] = $count;
		$array[1] = $navn;
	}
	return $array;
}*/


		$idValue = $_POST['menylistephp'];
		if(strpos($idValue, "SUB") !== false) {
			$idValue = substr($idValue, 3);
			$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
			mysqli_set_charset($mysqli, "UTF8");
			$stmt3->bind_param("i",$idValue);
			$stmt3->execute();
			$result3 = $stmt3->get_result();
			$count = 0;
			while($row3 = $result3->fetch_assoc()){
				$count ++;
				$navn = $row3['tittel'];
				$array[0] = $count;
				$array[1] = $navn;
			}
			
			
			$teller = 1;
			
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
				$array[0] = $count;
				$array[1] = $navn;
			}
			$teller = 2;
		
		}

		if ($count > 1){
			include("NyArtikkel.php");

			lagSide2($idValue);
			include("createInnholdFile.php");
			$sideInsert = "../../".$navn.'.html';

			$fh = fopen($sideInsert, 'w', 'w');
			$stringen = lagSide();
			fwrite($fh, $stringen);
		}else{
			include("createInnholdFile.php");
			koblemeny($idValue, $teller);
		}
		

?>
