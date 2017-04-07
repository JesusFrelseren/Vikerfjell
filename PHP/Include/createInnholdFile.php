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


		$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold ORDER BY idinnhold DESC LIMIT 1;");
		mysqli_set_charset($mysqli, "UTF8");
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$overskrift = $row['tittel'];



		$sideInsert = "../../".$overskrift.".php";
		$fh = fopen($sideInsert, 'w', 'w');
		$includes = lagSide();
		fwrite($fh, $includes);
?>