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
			if (ob_get_length() > 0) { ob_end_clean(); }
			return $includes;
		}

	function koblemeny($id){
		global $mysqli;
		mysqli_set_charset($mysqli, "UTF8");
		//Test ny substring sub id

		if(strpos($id, 'S') !== false) {

			$nymenyid = substr($id,1);
			$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold RIGHT JOIN vikerfjell.submeny ON innhold.idmeny = submeny.meny_idmeny WHERE submeny.idsubmeny = ?;");
			$stmt4->bind_param("i",$nymenyid);
			$stmt4->execute();
			$result4 = $stmt4->get_result();
			$row4 = $result4->fetch_assoc();
			if($row4) {
				$overskrift4 = $row4['side'];

				$sql = "UPDATE vikerfjell.submeny set sub_side = ? WHERE idsubmeny = $nymenyid";

				mysqli_set_charset($mysqli, "UTF8");
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('s', $overskrift4);
				$stmt->execute();

				$sideInsert = "../../".$overskrift4;
				$fh = fopen($sideInsert, 'w', 'w');
				$includes = lagSide();
				fwrite($fh, $includes);
			}

			
		} else {
			//Hvis det er hovedmeny kjører dette
			$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.meny WHERE idmeny = ?;");

			$stmt4->bind_param("i",$id);
			$stmt4->execute();
			$result4 = $stmt4->get_result();
			$row4 = $result4->fetch_assoc();
			if($row4) {
				
				$overskrift4 = $row4['side'];
				$stmt5 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
				mysqli_set_charset($mysqli, "UTF8");
				$stmt5->bind_param("s",$overskrift4);
				$stmt5->execute();

				$sideInsert = "../../".$overskrift4;
				$fh = fopen($sideInsert, 'w');
				$includes = lagSide();
				fwrite($fh, $includes);
			}
			

			
		}
	}


		function lagBestemtSide($idinnold){

			ob_start();
			include 'header.php';
			include 'meny.php';
			include 'lagbestemtinnhold.php';
			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $andreinclude;
			if (ob_get_length() > 0) { ob_end_clean(); }
			return $includes;

		}


?>
