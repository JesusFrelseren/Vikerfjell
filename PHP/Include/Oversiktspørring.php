<?php
/* Sindre 06.04.2017 */

  $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE idmeny = 43;");
  mysqli_set_charset($mysqli, "UTF8");
  $stmt->execute();
  $result = $stmt->get_result();
  while($row = $result->fetch_assoc()){
    $overskrift = $row['tittel'];
    $ingress    = $row['ingress'];
    $innhold    = $row['text'];
    //$innholdet  = $innhold[0].$innhold[1];
    $id         = $row['idinnhold'];
    $side       = $row['side'];

    echo("<!--.runde.-->");

    $stmt1 = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1    = $result1->fetch_assoc();
    $bilde  = $row1['hvor'];

    echo ("
          <div class='contentArtikkel'>
            <div class='contentBilde'><img src='PHP/Bilder/$bilde'></div>
            <div class='contentTekst'>
              <h2>$overskrift</h2>
              <p>$ingress</p>
              <p>$innhold</p><a href='$side'>Les mer..</a>
            </div>
          </div>
          ");
    }
?>
