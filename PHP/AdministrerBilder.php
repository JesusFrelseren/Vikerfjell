<?php
/*Utviklet av Erlend. Sist endret 07.05.2017*/


include 'startSession.php';
include("Include/mysqlcon.php");
include("BildeOpplasting.php");
include("Include/BilderKontroll.php");
var_dump($_POST);


//Sletting av bilde
if(isset($_POST['id']) && isset($_POST['slett'])) {

    global $mysqli;
    $idbilder = $_POST['id'];

    //Slett fra masselager
    $stmt = $mysqli->prepare("select hvor, thumb from bilder where idbilder = ?");
    $stmt->bind_param('i', $idbilder);
    $stmt->execute();
    $img = $stmt->get_result();
    $row = $img->fetch_assoc();

    $hvor = $row['hvor'];
    $thumb = $row['thumb'];
    unlink("Bilder/$hvor");
    unlink("Bilder/thumbs/$thumb");

    //Slett fra bilderinnhold
    $stmt = $mysqli->prepare("delete from bilderinnhold where _idbilder = ?");
    $stmt->bind_param('i', $idbilder);
    $stmt->execute();

    //Slett fra bilder
    $stmt = $mysqli->prepare("delete from bilder where idbilder = ?");
    $stmt->bind_param('i', $idbilder);
    $stmt->execute();


}
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
    <script defer src="JavaScript/JS.js">
    </script>
    <script defer src="JavaScript/bilde_modal.js"></script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>
<!--Rad 1: Overskift-header-->

<?php
include ("Include/backendmeny.php");
echo("</nav>");
include ('Include/mysqlcon.php');

?>


<!-- Søkeboks -->
<section id="søkewrapper">
    <form class="search_form" action="AdministrerBilder.php" method="post">
        <input type="text" name="søk_bilde_search_box" id="søk_bilde_search_box" size="40">
    <div id="btn_group">
        <input type="submit" class="søk_knapp" value="Søk">

    </form>
    <form class="search_form">
        <input type="submit" class="søk_knapp" value="Vis alle">
    </form>

    <!-- Vis opplastingsboks -->
    <input type="button" class="søk_knapp" value="Last opp.." onclick="toggleOpplastBoks()">

</section>

<!-- Opplastingsboks -->
<section id="#content">
<section class='bildeopplast_container' id="bildeopplast_container" style="display: none">
    <form method="post" enctype="multipart/form-data" action="AdministrerBilder.php">
        <section id="bildeopplast_section">
            <p>Støttede formater er png, jpg eller gif</p>
        <input type='file' id='upload' name='upload' value="Last opp">
    </section>
        <section id="bildebeskrivelse_section">
            <p style="margin-top: 30px; margin-bottom: 0">Gi bildet en beskrivelse</p>
            <label for="bildebeskrivelse"></label>
            <textarea maxlength="45" rows="7" cols="30"  name="bildebeskrivelse" id='bildebeskrivelse' placeholder="Maks 45 tegn"></textarea>
        </section>
        <section id="tooltip_section">
            <p>Gi bildet en tooltip (Valgfri)</p>
            <textarea rows="7" cols="30" maxlength="100" placeholder="Maks 100 tegn" name="tooltip" id="tooltip"></textarea>
        </section>
        <input type='hidden' name="action_last_opp" id="action_last_opp">
        <input type='submit' class="søk_knapp" value='Last opp'>
        <input type='submit' class="søk_knapp" value="Linkmodus" formaction="AdministrerBilderLink.php">
    </form>
</section>

<?php
$søketekst = "";
if (isset($_POST["søk_bilde_search_box"])) {
    $søketekst = $_POST["søk_bilde_search_box"];
    vis_alle_bilder($søketekst);
} else {
    vis_alle_bilder($søketekst);
}



function vis_alle_bilder($søketekst) {
    $img_result = hent_filterte_bilder($søketekst);
    $counter = 0;
    while ($row = $img_result->fetch_assoc()) {

        $idbilder = $row['idbilder'];
        $hvor = 'Bilder/' . $row['hvor'];
        $tekst = $row['tekst'];
        $dimension = $row['hoyde'] . 'x' . $row['bredde'];
        $thumb = 'Bilder/thumbs/' . $row['thumb'];
        $alt = $row['alt'];

        echo("
<section class='bildeinfo_container'>

<div id='bilde_container' style='height: 100px; overflow: hidden; width: auto' onclick='visModal($counter)'>
    <img id='id' src='$thumb' alt='Test'>
</div>

<!--Fra: https://www.w3schools.com/howto/howto_css_modals.asp -->
<div id='bilde_modal$counter' class='modal'>
    <span class='close' onclick='skjulModal($counter)'>&times;</span>
    <img src='$hvor' id='img01' class='modal-content' alt='$alt'>
</div>

<input type='text' value='$tekst' size='35' maxlength='45' style='margin: 5px'>
$dimension 
<form action='AdministrerBilder.php' method='post'>
    <input type='hidden' value='$idbilder' name='id' id='id'>
    <input type='hidden' id='slett' name='slett'>
    <input type='submit' class='søk_knapp' id='rediger' name='rediger' value='Endre' >
    <input type='submit' value='Slett' class='søk_knapp'>
</form></section>");
$counter++;

    }
echo("</section>");
}




?>



