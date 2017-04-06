<!--
Sist endret av Erlend 01.04.2017
Sist sett på av Sindre 01.04.2017
-->

<?php include 'startSession.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vikerfjell Admin</title>

    <link href="CSS/menybar.css" rel="stylesheet">
    <link href="CSS/style_innhold.css" rel="stylesheet">
    <link href="CSS/bildeAdmin.css" rel="stylesheet">
    <link href="CSS/style_admin.css" rel="stylesheet">
    <script defer src="JavaScript/JS.js">
    </script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>
<!--Rad 1: Overskift-header-->

<?php
include ("Include/backendmeny.php");
include ('Include/mysqlcon.php');

?>

<?php
if (isset($_POST["søk_bilde_search_box"])) {
    $img_result = hent_filterte_bilder($_POST["søk_bilde_search_box"]);
} else {
    $img_result = hent_alle_bilder();
}
?>

<!-- Søkeboks -->
<section id="søkewrapper">
    <form class="search_form" action="bildeAdmin.php" method="post">
        <input type="text" name="søk_bilde_search_box" id="søk_bilde_search_box" size="40">
        <input type="submit" class="søk_knapp" value="Finn bilder">

    </form>
    <form class="search_form">
        <input type="submit" class="søk_knapp" value="Vis alle">
    </form>

</section>



<!-- Opplastingsboks -->
<section class='bildeopplast_container'>
    <p style="margin-top: 24px; margin-bottom: 0">Last opp nytt bilde</p>
    <form>
        <input type='file' id='bildeopplast' value="Last opp">

        <p style="margin-top: 30px; margin-bottom: 0">Gi bildet en beskrivelse</p>
        <label for="bildebeskrivelse"></label>
        <input type='text' id='bildebeskrivelse' size="30" placeholder="Maks 30 tegn" maxlength="30">
        <input type='submit' class="søk_knapp" value='Last opp'>
    </form>
    <p> Velg side for å inkludere bilder i<p>
    <div id="sidevalg">
        <?php
        include ("Include/BilderMenyInnhold.php");
        ?>
    </div>
</section>



<?php
function hent_linkede_bilder() {
    global $mysqli;
    $id = "";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $mysqli->prepare("select *
from bilder inner join bilderinnhold
    on bilder.idbilder = $id");
        mysqli_set_charset($mysqli, "UTF8");
        $stmt->execute();
        $img_linked_result = $stmt->get_result();
        return $img_linked_result;
    }
}

function hent_alle_bilder() {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, hvor, tekst, thumb, bredde, hoyde from vikerfjell.bilder");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_result = $stmt->get_result();
    return $img_result;
}

function hent_filterte_bilder($søketekst) {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, hvor, tekst, thumb, bredde, hoyde from vikerfjell.bilder where tekst like '%$søketekst%'");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_result = $stmt->get_result();
    return $img_result;
}

while($row = $img_result ->fetch_assoc()) {
    $id = $row['idbilder'];
    $hvor = $row['hvor'];
    $tekst = $row['tekst'];
    $dimension = $row['hoyde'] . 'x' . $row['bredde'];
    $thumb = $row['thumb'];


    echo("
<section class='bildeinfo_container'>
<input type='hidden' value='$id' name='id' id='id'>
<img src='$thumb'>
<p>$tekst</p>
<p style='margin-top: 0;'>$dimension</p>
Inkluder i innhold:<br />");

    include("Include/InnholdFiltrertBilder.php");

    echo("<br /><input type='submit' value='Link' class='søk_knapp' style='width: 50px'>
</section>");
}


?>



