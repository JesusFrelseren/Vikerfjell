<?php
/* Sindre 06.04.2017 */

  $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE idmeny = 43;");
  mysqli_set_charset($mysqli, "UTF8");
  $stmt->execute();
  $result = $stmt->get_result();
  while($row = $result->fetch_assoc()){
    $overskrift = $row['tittel'];
    $ingress    = $row['ingress'];
    $innhold    = explode(".", $row['text']);
    $innholdet  = $innhold[0].$innhold[1];
    $id         = $row['idinnhold'];
    $side       = $row['side'];

    echo("<!--.runde.-->");

    $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.bilderinnhold join bilder on _idbilder = idbilder where _idinnhold = $id;");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $result = $stmt->get_result();
    $row1    = $result->fetch_assoc();
    $bilde  = $row1['hvor'];

    echo ("
          <div class='contentArtikkel'>
            <div class='contentBilde'><img src='PHP/Bilder/$bilde'></div>
            <div class='contentTekst'>
              <h2>$overskrift</h2>
              <p>$ingress</p>
              <p>$innholdet</p><a href='$side'>Les mer..</a>
            </div>
          </div>
          ");
  }
?>
