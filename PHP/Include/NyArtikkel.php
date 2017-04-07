<?php
/* Sindre 06.04.2017  */

echo ("<div class='content100Prosent'>
        <h1>Vei og føre</h1>");

// Henter innhold fra den bestemte "idmeny"
$stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE idmeny = 43 ORDER BY rekke;");
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();

// Kjører igjennom en while på alle innholdene den har fått fra spørringen
while ($row = $result->fetch_assoc())
	{
	$overskrift = $row['tittel'];
	$ingress = $row['ingress'];
  //Tar bort denne kommentaren når databasen er klar.
  //$innhold = explode(".", $row['text'], 3);
  //$innholdet = $innhold[0].".".$innhold[1].".";
	$id = $row['idinnhold'];
	$side = $row['side'];

	// Kjører en ny spørring hvor vi henter ut lokasjonen for forsidebildet til det bestemte innholdet.
	$stmt1 = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
	mysqli_set_charset($mysqli, "UTF8");
	$stmt1->execute();
	$result1 = $stmt1->get_result();
	$row1 = $result1->fetch_assoc();
	$bilde = $row1['hvor'];
  //NOTASJON: LEGG TIL $INNHOLDET i stedet for hei når databasen er klar.
  echo ("  <div class='contentArtikkel'>
            <div class='contentBilde'><img src='PHP/Bilder/$bilde'></div>
            <div class='contentTekst'>
              <h2>$overskrift</h2>
              <p>$ingress</p>
              <p>hei</p><a href='$side'>Les mer..</a>
            </div>
          </div>
          ");
	}
  echo("</div>");
?>
