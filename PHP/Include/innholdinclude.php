<?php
/* Alex 07.04.2017  */

	$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold ORDER BY idinnhold DESC LIMIT 1;");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$overskrift = $row['tittel'];
	$text = $row['text'];
	$id = $row['idinnhold'];

	$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$bilde = $row['hvor'];

function lagSide() {
	global $mysqli;
	$os = serialize($overskrift);
	$bilder = serialize($bilde);
	$txt = serialize($text);
$test = "
		<div class='staticinnhold'>
		<H1>$os</h1>
		<img src=$bilder width=100% height=auto>
		<p>$txt</p>
		</div>
		";
		
			ob_start();
			include 'header.php';
			include 'meny.php';
			$forsteinclude = ob_get_clean();
			ob_end_clean();
			ob_start();
			
		

			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $forsteinclude.$test.$andreinclude;
			
			return $includes;
		}

		$sideInsert = "../../".$overskrift.".php";
		$fh = fopen($sideInsert, 'w', 'w');
		$includes = lagSide();
		file_put_contents($sideInsert, $includes);
		
		
?>