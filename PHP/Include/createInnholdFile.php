<?php
/* Alex 07.04.2017  */
function lagSide() {
			ob_start();
			include 'header.php';
			include 'meny.php';
			include 'innholdinclude.php';
			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $andreinclude;

			return $includes;
		}

		function koblemeny($id){

		global $mysqli;
		$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?;");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt4->bind_param("i",$id);
		$stmt4->execute();
		$result4 = $stmt4->get_result();
		$row4 = $result4->fetch_assoc();

		$overskrift4 = $row4['tittel'].'.html';

		$stmt5 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt5->bind_param("s",$overskrift4);
		$stmt5->execute();


		$sideInsert = "../../".$overskrift4;
		$fh = fopen($sideInsert, 'w', 'w');
		$includes = lagSide();
		fwrite($fh, $includes);



		}



?>
