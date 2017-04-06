<?php
function lagSide() {
global $mysqli;
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


$test = "
		<div class='staticinnhold'>
		<H1>$overskrift</h1>
		<img src=$bilde width=100% height=auto>
		<p>$text</p>
		</div>
		";
			ob_start();
			include 'header.php';
			include 'meny.php';
			$førsteinclude = ob_get_clean();
			ob_end_clean();
			ob_start();
			
		

			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $førsteinclude.$test.$andreinclude;
			
			return $includes;
		}

		$sideInsert = "../../".$overskrift.".php";
		$fh = fopen($sideInsert, 'w', 'w');
		$includes = lagSide();
		fwrite($fh, $includes);
		
		
?>