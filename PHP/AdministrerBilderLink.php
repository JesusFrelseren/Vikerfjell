<!--
Utviklet av Erlend
Sist endret: 07-05-2017
-->

<?php
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
    <link href="CSS/bilde_modal.css" rel="stylesheet">
    <link href="CSS/style_innhold.css" rel="stylesheet">
    <script defer src="JavaScript/JS.js"></script>
    <script defer src="JavaScript/bilde_modal.js"></script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>
<!--Rad 1: Overskift-header-->
<?php
include ("Include/backendmeny.php");

?>

<div id="scroll"></div>
<!-- Søkeboks -->
<?php

//Etter søk må GET tas vare på for at linking av bilde skal fungere
$get = "";
if (isset($_GET['option_selected_index'])) {
    $get = "option_selected_index=".$_GET['option_selected_index']."&id=".$_GET['id'];
}

?>

<section id="søkewrapper">

    <p style="margin: 0">Søk etter bilde</p>
    <?php echo("<form class='search_form' action='AdministrerBilderLink.php?$get' method='post'>");?>
        <input type="text" name="søk_bilde_search_box" id="søk_bilde_search_box" size="40">
        <div id="btn_group">

            <input type="submit" class="søk_knapp" value="Søk">

            <?php
            echo("<form class='search_form' action='AdministrerBilderLink.php?$get' 
                    method='post'>");
                ?>

                <input type="submit" class="søk_knapp" value="Vis alle">
            </form>
        </div>
    </form>

    <p style="margin-top: 24px; margin-bottom: 0">Velg innhold</p>
    <form id="submit_select" action="AdministrerBilderLink.php" method="get">
        <input type="hidden" id="option_selected_index" name="option_selected_index" value="">
        <?php include("Include/BilderVelgInnholdDropdown.php")?>
    </form>
</section>


<?php
include("Include/LinkBilder.php");


/**
 * $søketekst: Brukes i simpel where-betingelse
 *
 * Funksjonen henter et resultatset av alle linkede bilder, og genererer sections ut ifra de returnerte radene.
 * Deretter henter den de resterende radene som ikke er linket og gjør tilsvarende.
 */
function vis_alle_bilder($søketekst) {

    if(isset($_GET['id'])) {
        $id_innhold = $_GET['id'];
    } else {
        $id_innhold = -1;
    }
    $img_result = hent_linkede_bilder($søketekst, $id_innhold);
    $duplikater = array();
    $counter = 0;

    while($row = $img_result->fetch_assoc()) {
        $tekst = $row['tekst'];
        $hvor = $row['hvor'];
        $dimension = $row['hoyde'] . 'x' . $row['bredde'];
        $thumb = 'Bilder/thumbs/' . $row['thumb'];
        $idbilder = $row['idbilder'];
        $_idbilder = $row['_idbilder'];
        $idinnhold = $row['idinnhold'];
        $alt = $row['alt'];$get = "";
        if (isset($_GET['option_selected_index'])) {
            $get = "option_selected_index=".$_GET['option_selected_index']."&id=".$_GET['id'];
        }

//Vis bilder som kan fjernes fra innhold

        echo("
            <section class='bildeinfo_container'>
            <div id='bilde_container' style='height: 100px; overflow: hidden; width: auto' onclick='visModal($counter)'>
                <input type='hidden' value='$idbilder' name='id' id='id'>
                <img src='$thumb' id='id' alt='test'>
            </div>
            <div id='bilde_modal$counter' class='modal'>
                <span class='close' onclick='skjulModal($counter)'>&times;</span>
                <img src='$hvor' id='img01' class='modal-content' alt='$alt' onclick='visModal($counter)'>
            </div>
            <p>$tekst</p>
            <p style='margin-top: 0;'>$dimension</p>
            <br />
            ");

        if (isset($_GET['id']) && isset($_GET['option_selected_index'])) {
            echo('<form method="post" action="AdministrerBilderLink.php?'.$get.'">');
        } else {
            echo('<form method="post" action="AdministrerBilderLink.php">');
        }
        echo("
            <input type='hidden' class='innhold_id' name='id_innhold' value='$idinnhold'>
            <input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>
            <input type='hidden' id='slett_fra_innhold' name='slett_fra_innhold'>
            <input type='submit' value='Fjern fra innhold' class='søk_knapp' style='background-color: firebrick'>
            </form>
            </section>");
        $counter++;
        $duplikater[$counter] = $_idbilder;
    }
//Vis bilder som kan legges til i innhold

    $img_result = hent_ulinkede_bilder($søketekst);
    $forrige_idbilde = 0;
    while($row = $img_result->fetch_assoc()) {
        $tekst = $row['tekst'];
        $hvor = 'Bilder/' . $row['hvor'];
        $alt = $row['alt'];
        $dimension = $row['hoyde'] . 'x' . $row['bredde'];
        $thumb = 'Bilder/thumbs/'.$row['thumb'];
        $idbilder = $row['idbilder'];
        $get = "";
        if (isset($_GET['option_selected_index'])) {
            $get = "option_selected_index=".$_GET['option_selected_index']."&id=".$_GET['id'];
        }
        $duplikat = false;
        foreach($duplikater as $dupe) {
            if($dupe == $idbilder) {
                $duplikat = true;
            }
        }
        if($forrige_idbilde != $idbilder && $duplikat == false) {
            echo("
            <section class='bildeinfo_container'>
            <div id='bilde_container' style='height: 100px; overflow: hidden; width: auto' onclick='visModal($counter)'>
                <input type='hidden' value='$idbilder' name='id' id='id'>
                <img src='$thumb' id='id'>
            </div>
            <div id='bilde_modal$counter' class='modal' >
                <span class='close' onclick='skjulModal($counter)'>&times;</span>
                <img src='$hvor' id='img01' class='modal-content' alt='$alt'>
            </div>
            <p>$tekst</p> 
            <p style='margin-top: 0;'>$dimension</p>
            <br />"
            );

            if (isset($_GET['option_selected_index'])) {

                echo('<form method="post" action="AdministrerBilderLink.php?' . $get . '">');
            } else {
                echo('<form method="post" action="AdministrerBilderLink.php">');
            }

            echo("
            <input type='hidden' class='innhold_id' name='id_innhold' value='$id_innhold'>
            <input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>
            <input type='hidden' name='legg_til_innhold' id='legg_til_innhold' value=''>
            <input type='submit' value='Inkluder i innhold' class='søk_knapp'>
            </form>
            </section>"
            );
            $counter++;
        }
        $forrige_idbilde = $idbilder;
    }
    echo("</section>");
}



?>