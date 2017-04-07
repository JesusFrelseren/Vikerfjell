<?php



		$stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt3->bind_param("i",$_POST['menylistephp']);
		$stmt3->execute();
		$result3 = $stmt3->get_result();
		$count = 0;
		while($row3 = $result3->fetch_assoc()){
		$count ++;
		}
		if ($count > 1){
			include("NyArtikkel.php");

		}else{
		include("createInnholdFile.php");
		koblemeny($_POST['menylistephp']);
		
		}



?>