<?php
/* Sindre 06.04.2017  */

<<<<<<< HEAD
function lagSide() {
			ob_start();
			include 'header.php';
			include 'meny.php';
      legg_til_oversikt($_POST['menylistephp']);
			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $andreinclude;
      $sideInsert = "../../".$menyoverskrift.".html";
  		$fh = fopen($sideInsert, 'w', 'w');
  		$includes = lagSide();
  		fwrite($fh, $includes);

      $overskrift4 = $menyoverskrift.".html";
      $id = $_POST['menylistephp'];

		  global $mysqli;
  		$stmt6 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
  		mysqli_set_charset($mysqli, "UTF8");
  		$stmt6->bind_param("s",$overskrift4);
  		$stmt6->execute();
		}

//Kaller en funksjon som får idmeny og menyoverskrift fra InnholdKontroll
function legg_til_oversikt($idmeny){
  //Spørring for å få ut navnet på menyelementet for å fylle ut overskrift på siden.
  $stmt2 = $mysqli->prepare("SELECT * FROM vikerfjell.meny WHERE idmeny = $idmeny");
  mysqli_set_charset($mysqli, "UTF8");
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  $row2 = $result2->fetch_assoc()
  $menyoverskrift = $row2['tekst'];

  echo ("<div class='content100Prosent'>
          <h1>$menyoverskrift</h1>");

  // Henter innhold fra den bestemte "idmeny"
  $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE idmeny = $idmeny ORDER BY rekke;");
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
=======
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
>>>>>>> parent of 46b7a2d... fyfaen
            </div>
          </div>
          ");
	}
  echo("</div>");
?>
