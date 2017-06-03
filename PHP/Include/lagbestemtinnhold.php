<?php
/* Alex 07.04.2017 */

$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idinnhold = ?;");
$stmt->bind_param("i",$idinnold);
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$overskrift = $row['tittel'];
$text = $row['tekst'];
$id = $row['idinnhold'];


$stmt = $mysqli->prepare("SET @radnr = 0");
$stmt->execute();

$stmt = $mysqli->prepare("SELECT (@radnr:=@radnr + 1) AS rad, hvor FROM vikerfjell.bilderinnhold join bilder 
                            on _idbilder = idbilder where _idinnhold = $id ORDER BY rad");
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();
$img_ut = "";

//Hovedbilde
$hoved_rad = $result->fetch_assoc();
$bilde_hoved = "PHP/Bilder/".$hoved_rad['hvor'];
$hoved_img = "<img src=$bilde_hoved>";

//Småbilder
while($row = $result->fetch_assoc()) {
    $bilde = "PHP/Bilder/".$row['hvor'];
    $img_ut .= "<img src=$bilde>";
}


echo("<div class='staticinnhold'>
        $hoved_img
		<H1>$overskrift</h1>
		<p>$text</p>
		$img_ut
		</div>");


?>
