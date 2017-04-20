// Sist endret av Erlend 20.04.2017

<?php


include("mysqlcon.php");


if(!$row){
    legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navn.".html",$_POST['menylistephp']);

    include 'KobleOgLagInnholdFiler.php';

    header("location: ../innhold.php");
} else {
    $tall ="1";
    $side2 = $navn.$tall;
    sjekk_navn($side2);
}


// Kjører nytt innhold, med en sjekk på om sidenavn finnes.
if(isset($_POST['nyttInnhold'])) {
    $side = $_POST['overskrift'];
    Endre_Rekke($_POST['menylistephp'],$_POST['rekke']);
    sjekk_navn($side);
}

//Sletting av innhold
if(isset($_POST['slettInnhold'])) {
    Slett_Innhold($_POST['menylistephp']);
    header("location: ../innhold.php");
}

if(isset($_POST['endreInnhold'])) {
    Endre_Innhold($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$_POST['menylistephp'],$_POST['id']);
    header("location: ../innhold.php");
}



function skriv_bilder_til_base($POST, $FILES, $width_src, $height_src)  {
    global $mysqli;
    $tekst = $POST['bildebeskrivelse'];
    $thumb = "thumb_".pathinfo($FILES['upload']['name'], PATHINFO_BASENAME);
    $hvor = pathinfo($FILES['upload']['name'], PATHINFO_BASENAME);
    $bredde = $width_src;
    $høyde = $height_src;
    $tooltip = "Fuck tooltips";
    $alt = "Bildet ble ikke funnet :´(";

    $stmt = $mysqli->prepare("
      INSERT INTO vikerfjell.bilder(hvor, tekst, thumb, bredde, hoyde, tooltip, alt)
      VALUES(?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('sssiiss', $hvor, $tekst, $thumb, $bredde, $høyde, $tooltip, $alt);
    $stmt->execute();
    $mysqli->close();


}

function legg_til_side($tittel, $ingress, $tekst, $rekke, $side, $idmeny) {
    global $mysqli;
    $sql = "insert into innhold(tittel, ingress, text, rekke, side, idmeny)
              values(?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssisi', $tittel, $ingress, $tekst, $rekke, $side, $idmeny);
    $stmt->execute();
    $mysqli->close();
}

function rediger_side($tittel, $ingress, $tekst, $side, $idinnhold) {
    global $mysqli;
    $sql = "
UPDATE innhold
SET ingress = $ingress
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET tittel = $tittel
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET text = $tekst
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET side = $side
WHERE idinnhold = $idinnhold;";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssi', $tittel, $ingress, $tekst, $idinnhold);
    $stmt->execute();
    $mysqli->close();
}



function Endre_Rekke($idmeny, $rekke){
global $mysqli;
$sql = "SELECT * FROM vikerfjell.innhold WHERE idmeny = ? and rekke >= ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii',$idmeny,$rekke);
    $stmt->execute();
    $result = $stmt->get_result();


    while($row = $result->fetch_assoc()) {
      $sql = "UPDATE innhold set rekke = rekke +1 where idinnhold = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$row['idinnhold']);
    $stmt->execute();
    }
    $mysqli->close();
}

function Slett_Innhold($idinnhold){
  global $mysqli;
  $sql = "DELETE FROM innhold WHERE idinnhold = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $idinnhold);
  $stmt->execute();
    $mysqli->close();
}

// Sjekker om sidenavn finnes, hvis det gjør det blir det lagt til et tall og kjøres på nytt.
/*Endret av Alex 07.04.2017 */
/**
 * @param $navn
 */
function sjekk_navn($navn)
{
    global $mysqli;

    $hvasomhelst = $navn . ".html";

    $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE side=?");
    $stmt->bind_param("s", $hvasomhelst);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $mysqli->close();
}

function Endre_Innhold($tittel, $ingress, $text, $rekke, $idmeny, $idinnhold){
    global $mysqli;
    $sql = "UPDATE vikerfjell.innhold SET tittel=?,ingress=?,text=?,rekke=?,idmeny=? WHERE idinnhold =?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssss',$tittel,$ingress,$text,$rekke,$idmeny, $idinnhold);
    $stmt->execute();
    $mysqli->close();
}



function legg_til_link($url, $tekst, $idmeny, $idsubmeny) {
    global $mysqli;
    $stmt = $mysqli->prepare(
            "INSERT INTO link(url, link_tekst, idmeny, idsubmeny)
              VALUES(?, ?, ?, ?)");

    $stmt->bind_param('ii', $idmeny, $idsubmeny);
    $stmt->execute();
    $mysqli->close();

}
