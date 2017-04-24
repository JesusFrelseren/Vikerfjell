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

<<<<<<< HEAD
		function koblemeny($id){
			global $mysqli;
			mysqli_set_charset($mysqli, "UTF8");

=======
	function koblemeny($id, $teller){
		global $mysqli;
		mysqli_set_charset($mysqli, "UTF8");		
>>>>>>> origin/master
		//Test ny substring sub id
<<<<<<< HEAD

			if($teller == 1) {
				$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold RIGHT JOIN vikerfjell.submeny ON innhold.idmeny = submeny.meny_idmeny WHERE submeny.idsubmeny = ?;");
				$stmt4->bind_param("i",$id);
				$stmt4->execute();
				$result4 = $stmt4->get_result();
				$row4 = $result4->fetch_assoc();
				
				$overskrift4 = $row4['tittel'].'.html';
				
				$overkrift5 = substr($overskrift4, 2);
				
				$sql = "UPDATE vikerfjell.submeny set sub_side = ? WHERE idsubmeny = $id";
=======
		if($teller == 1) {
			$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold RIGHT JOIN vikerfjell.submeny ON innhold.idmeny = submeny.meny_idmeny WHERE submeny.idsubmeny = ?;");
			$stmt4->bind_param("i",$id);
			$stmt4->execute();
			$result4 = $stmt4->get_result();
			$row4 = $result4->fetch_assoc();

			$overskrift4 = $row4['tittel'].'.html';
			
			$overkrift5 = substr($overskrift4, 2);
			
			$sql = "UPDATE vikerfjell.submeny set sub_side = ? WHERE idsubmeny = $id";

<<<<<<< HEAD
			$sql = "UPDATE vikerfjell.submeny set sub_side = ? WHERE idsubmeny = $nymenyid";
			mysqli_set_charset($mysqli, "UTF8");
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $overskrift4);
=======
			mysqli_set_charset($mysqli, "UTF8");	
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $overskrift5);  
>>>>>>> origin/master
            $stmt->execute();
>>>>>>> f8246bda7d995337f68a79a2e33570fefb673e89

				mysqli_set_charset($mysqli, "UTF8");	
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('s', $overskrift5);  
				$stmt->execute();
				
		} else {

			//Hvis det er hovedmeny kjører dette
			$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?;");
			$stmt4->bind_param("i",$id);
			$stmt4->execute();
			$result4 = $stmt4->get_result();
			$row4 = $result4->fetch_assoc();
<<<<<<< HEAD
			if($row4) {
				$overskrift4 = $row4['tittel'].'.html';			
				$stmt5 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
				mysqli_set_charset($mysqli, "UTF8");
				$stmt5->bind_param("s",$overskrift4);
				$stmt5->execute();

				$sideInsert = "../../".$overskrift4;
				$fh = fopen($sideInsert, 'w', 'w');
				$includes = lagSide();
				fwrite($fh, $includes);
			} else {
				$stmt4 = $mysqli->prepare("SELECT * FROM vikerfjell.meny where idmeny = ?;");
				$stmt4->bind_param("i",$id);
				$stmt4->execute();
				$result4 = $stmt4->get_result();
				$row4 = $result4->fetch_assoc();
				
				$tittel = $row4['tekst'].'.html';
=======
			$overskrift4 = $row4['side'];
>>>>>>> f8246bda7d995337f68a79a2e33570fefb673e89

				$stmt5 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
				mysqli_set_charset($mysqli, "UTF8");
				$stmt5->bind_param("s",$tittel);
				$stmt5->execute();

				$tittel2 = $tittel.'.html';
				$sideInsert = "../../".$tittel2;
				$fh = fopen($sideInsert, 'w', 'w');
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

			return $includes;

		}
?>
