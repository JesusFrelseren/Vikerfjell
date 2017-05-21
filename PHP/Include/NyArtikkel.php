<?php
header('Content-type: text/plain; charset=utf-8');
/* Sindre 06.04.2017  */
function convertCharacterEncoding($content) {
// Convert encoding from charset X to utf8 if needed.
  $characterEncoding = mb_detect_encoding($content, 'UTF-8, UTF-16, ISO-8859-1, ISO-8859-15, Windows-1252, ASCII');
  
switch ($characterEncoding) {
  case "UTF-8":
    // Do nothing
    break;	
  case "ISO-8859-1":
    $content = utf8_encode($content);    
    break;
  default:
    $content = mb_convert_encoding($content,"UTF-8",$characterEncoding);
    break;
}

return $content;

}




function lagSide2($idmenyen) {
			ob_start();
			include 'header.php';
			include 'meny.php';
			$menyoverskrift = legg_til_oversikt($idmenyen);
			$menyoverskrift = convertCharacterEncoding($menyoverskrift);
			include 'footer.php';
			$andreinclude = ob_get_clean();
			$includes = $andreinclude;
      $sideInsert = "../../".$menyoverskrift.".html";
  		$fh = fopen($sideInsert, 'w', 'w');
  		fwrite($fh, $includes);
      if (ob_get_length() > 0) { ob_end_clean(); }
      $overskrift4 = $menyoverskrift.".html";

      if(strpos($idmenyen, "S") !== false) {
        $id = substr($idmenyen, 1);
        $sql = "UPDATE vikerfjell.submeny SET sub_side = ? WHERE idsubmeny = ?";
        mysqli_set_charset($mysqli, "UTF8");
        $stmt6 = $mysqli->prepare($sql);
        $stmt6->bind_param("si",$overskrift4, $id);
        $stmt6->execute();
      } else {
        $id = $idmenyen;
        global $mysqli;
        $stmt6 = $mysqli->prepare("UPDATE vikerfjell.meny set side =?  where idmeny = $id;");
        mysqli_set_charset($mysqli, "UTF8");
        $stmt6->bind_param("s",$overskrift4);
        $stmt6->execute();
      }
      
		}




		function lagSide3(){
      global $mysqli;
      $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.meny LEFT JOIN vikerfjell.submeny ON meny.idmeny = submeny.meny_idmeny ORDER BY idmeny;");
      mysqli_set_charset($mysqli, "UTF8");
      $stmt->execute();
      $result = $stmt->get_result();

		 while ($row = $result->fetch_assoc()){
      $nyid = $row['idmeny'];
      //Sjekker antall innhold
      $antall = sjekk_ant($nyid);
      $subid = $row['idsubmeny'];
      $sjekkSub = "S".$subid;
      $antallSub = sjekk_ant($sjekkSub);
      //Sjekk sub
      if($antall == 1 ||$antallSub == 1) {
        if($nyid != 1) {          
           //Fikse for hovedside
        } else {
          koblemeny($nyid);
        }
       
      } else {
        if($nyid == 1) {
          
            //Generere hovedside
        } elseif(empty($subid)==false) {
          $subid = "S".$subid;
          lagSide2($subid);
          $subid = "";
          
        } elseif (empty($subid) == true){
         
          lagSide2($nyid);
          $nyid = "";
      }
		}
     }
     

		}

//Kaller en funksjon som får idmeny og menyoverskrift fra InnholdKontroll
function legg_til_oversikt($idmeny){
  //Spørring for å få ut navnet på menyelementet for å fylle ut overskrift på siden.
  global $mysqli;
  if(strpos($idmeny, "S") !== false) {
    //submeny 
    $idmeny = substr($idmeny, 1);
    $sql = "SELECT * FROM vikerfjell.submeny WHERE idsubmeny = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$idmeny);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $menyoverskrift = $row['sub_tekst'];
    $link = $row['sub_side'];
    echo("<div class='content100Prosent'>
            <h1>$menyoverskrift</h1>");
    //Henter innhold fra bestemt idmeny
    $sqlInnhold = "SELECT * FROM vikerfjell.innhold RIGHT JOIN vikerfjell.submeny ON innhold.idmeny = submeny.meny_idmeny WHERE submeny.idsubmeny = ?;";
    
    $stmtInnhold = $mysqli->prepare($sqlInnhold);
 
    $stmtInnhold->bind_param("i",$idmeny);
    $stmtInnhold->execute();
    $resInnhold = $stmtInnhold->get_result();
    while($rowInnhold = $resInnhold->fetch_assoc()) {
      $idinnhold = $rowInnhold['idinnhold'];
      if(empty($idinnhold) == false) {
        $overskrift = $rowInnhold['tittel'];
        $ingress = $rowInnhold['ingress'];
        // IF test på innhold og text osv for at dritten ikke crasher
        //Tar bort denne kommentaren når databasen er klar.
        //$innhold = explode(".", $row['text'], 3);
        //$innholdet = $innhold[0].".".$innhold[1].".";
        $id = $rowInnhold['idinnhold'];
        $side = $rowInnhold['side'];
        
        // Kjører en ny spørring hvor vi henter ut lokasjonen for forsidebildet til det bestemte innholdet.
    if(empty($id) == false) {
        $stmt1 = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
        mysqli_set_charset($mysqli, "UTF8");
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row1 = $result1->fetch_assoc();
        $bilde = $row1['hvor'];
        //NOTASJON: LEGG TIL $INNHOLDET i stedet for hei når databasen er klar.
        echo ("<div class='contentArtikkel'>
            <div class='contentBilde'><img src='PHP/Bilder/$bilde'></div>
            <div class='contentTekst'>
              <h2>$overskrift</h2>
              <p>$ingress</p>
              <p>hei</p><a href='$side'>Les mer..</a>            
            </div>
          </div>
          ");
    }
      }
   
    }
  
	
    return $menyoverskrift;
  } else {
    //hovedmeny
  
  $stmt2 = $mysqli->prepare("SELECT * FROM vikerfjell.meny WHERE idmeny = $idmeny");
  mysqli_set_charset($mysqli, "UTF8");
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  $row2 = $result2->fetch_assoc();
  $menyoverskrift = $row2['tekst'];
  $linkside = $row2['side'];
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
    // IF test på innhold og text osv for at dritten ikke crasher
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
    return $menyoverskrift;
  }
}

function sjekk_ant($menyid){
  global $mysqli;
  $count = 0;
    if(strpos($menyid, "S") !== false) {
      $id = substr($menyid, 1);
      $sql9 = "SELECT * FROM vikerfjell.innhold WHERE idsubmeny = ?";
      $stmt9 = $mysqli->prepare($sql9);
      $stmt9->bind_param("s", $id);
      $stmt9->execute();
      $result9 = $stmt9->get_result();
    while ($row9 = $result9->fetch_assoc()){
      $count++;
    }
    return $count;
  } else {
    $sql9 = "SELECT * FROM vikerfjell.innhold WHERE idmeny = ?";
    $stmt9 = $mysqli->prepare($sql9);
    $stmt9->bind_param("s", $menyid);
    $stmt9->execute();
    $result9 = $stmt9->get_result();
    while ($row9 = $result9->fetch_assoc()){
      $count++;
    }
  return $count;
  }
  
}
?>