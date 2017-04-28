<!--
Sist endret av Erlend 01.04.2017
Sist sett på av Sindre 01.04.2017
-->

<?php
var_dump($_POST);
echo("<br>");
var_dump($_GET);
//todo: ta vare på scroll position
include 'startSession.php';
include('Include/mysqlcon.php');
include("Include/BilderKontroll.php");
?>
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

<div id="scroll"></div>
<!-- Søkeboks -->
<section id="søkewrapper">
    <form>
    <input type="submit" class="søk_knapp" value="<- Til Opplasting" formaction="AdministrerBilder.php" style="float: left">
    </form>
    <form class="search_form" action="AdministrerBilderLink.php" method="post">
    <input type="text" name="søk_bilde_search_box" id="søk_bilde_search_box" size="40">
    <input type="submit" class="søk_knapp" value="Søk">

</form>
    <form class="search_form">
        <input type="submit" class="søk_knapp" value="Vis alle">
    </form>

</section>

<!-- Opplastingsboks -->
<section class='bildeopplast_container'>
    <p style="margin-top: 24px; margin-bottom: 0">Velg innhold</p>
    <form id="submit_select" action="AdministrerBilderLink.php" method="get">
        <input type="hidden" id="option_selected_index" name="option_selected_index" value="">
        <?php include("Include/BilderVelgInnholdDropdown.php")?>
    </form>
</section>
<?php

$søketekst = "";
//Vis søkeresultat
if (isset($_POST["søk_bilde_search_box"])) {
    $søketekst = $_POST['søk_bilde_search_box'];
    vis_alle_bilder($søketekst);

} elseif (isset($_POST['legg_til_innhold'])) {

    if($_POST['id_innhold'] == -1) {
        echo("<p style='font-weight: bolder'>Velg innhold</p>");
    } else {
        global $mysqli;
        $idbilder = $_POST['idbilder'];
        $idinnhold = $_POST['id_innhold'];

        $stmt = $mysqli->prepare("INSERT INTO bilderinnhold(_idbilder, _idinnhold) VALUES(?, ?)");
        $stmt->bind_param('ii', $idbilder, $idinnhold);
        $stmt->execute();
    }
    vis_alle_bilder($søketekst);
} elseif (isset($_POST['slett_fra_innhold'])) {
    global $mysqli;
    $idbilder = $_POST['idbilder'];
    $idinnhold = $_POST['id_innhold'];
    $stmt = $mysqli->prepare("delete from bilderinnhold where _idbilder = ? AND _idinnhold = ?");
    $stmt->bind_param('ii', $idbilder, $idinnhold);
    $stmt->execute();

    vis_alle_bilder($søketekst);

} else {
    vis_alle_bilder($søketekst);
}


if(isset($_GET['id'])) {
    $id_innhold = $_GET['id'];
    $img_result = hent_alle_bilder();
}


function vis_alle_bilder($søketekst) {

    if(isset($_GET['id'])) {
        $id_innhold = $_GET['id'];
    } else {
        $id_innhold = -1;
    }
    $img_result = hent_linkede_bilder($søketekst);
    while($row = $img_result->fetch_assoc()) {
        $hvor = $row['hvor'];
        $tekst = $row['tekst'];
        $dimension = $row['hoyde'] . 'x' . $row['bredde'];
        $thumb = 'Bilder/thumbs/' . $row['thumb'];
        $_idbilder = $row['_idbilder'];
        $idbilder = $row['idbilder'];
        $idinnhold = $row['idinnhold'];

//echo linkede bilder
        echo("
<section class='bildeinfo_container'>
<div id='bilde_container' style='height: 100px; overflow: hidden; width: auto'>
<input type='hidden' value='$idbilder' name='id' id='id'>
<img src='$thumb'>
</div>
<p>$tekst</p>
<p style='margin-top: 0;'>$dimension</p>");

        echo('<br />');
        if (isset($_GET['id'])) {
            echo('<form method="post" action="AdministrerBilderLink.php?id=' . $_GET['id'] . '">');
        } else {
            echo('<form method="post" action="AdministrerBilderLink.php">');
        }
        echo("<input type='hidden' class='innhold_id' name='id_innhold' value='$idinnhold'>");
        echo("<input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>");
        echo("<input type='hidden' id='slett_fra_innhold' name='slett_fra_innhold'>");
        echo('<input type="submit" value="Fjern fra innhold" class="søk_knapp" style="background-color: firebrick">');
        echo('</form>');
        echo('</section>');
    }

    $img_result = hent_ulinkede_bilder($søketekst);
    while($row = $img_result->fetch_assoc()) {
        $hvor = $row['hvor'];
        $tekst = $row['tekst'];
        $dimension = $row['hoyde'] . 'x' . $row['bredde'];
        $thumb = 'Bilder/thumbs/'.$row['thumb'];
        $_idbilder = $row['_idbilder'];
        $idbilder = $row['idbilder'];

        echo("
<section class='bildeinfo_container'>
<div id='bilde_container' style='height: 100px; overflow: hidden; width: auto'>
<input type='hidden' value='$idbilder' name='id' id='id'>
<img src='$thumb'>
</div>
<p>$tekst</p> 
<p style='margin-top: 0;'>$dimension</p>");

        echo('<br />');
        if(isset($_GET['id'])) {
            echo('<form method="post" action="AdministrerBilderLink.php?id='.$_GET['id'].'">');
        } else {
            echo('<form method="post" action="AdministrerBilderLink.php">');
        }
        echo("<input type='hidden' class='innhold_id' name='id_innhold' value='$id_innhold'>");
        echo("<input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>");
        echo("<input type='hidden' name='legg_til_innhold' id='legg_til_innhold' value=''>");
        echo('<input type="submit" value="Inkluder i innhold" class="søk_knapp">');
        echo('</form>');
        echo('</section>');

    }
}



?>