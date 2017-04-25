<!--
Sist endret av Erlend 01.04.2017
Sist sett på av Sindre 01.04.2017
-->

<?php
//todo: ta vare på scroll


include 'startSession.php';
include('Include/mysqlcon.php');
$id_innhold = -1;


if (isset($_POST['idbilder'])) {
    if($_POST['id_innhold'] == -1) {
        echo("Velg innhold");
    } else {
        global $mysqli;
        $idbilder = $_POST['idbilder'];
        $idinnhold = $_POST['id_innhold'];

        $stmt = $mysqli->prepare("INSERT INTO bilderinnhold(_idbilder, _idinnhold) VALUES(?, ?)");
        $stmt->bind_param('ii', $idbilder, $idinnhold);
        $stmt->execute();
    }
}
if(isset($_GET['id'])) {
    $id_innhold = $_GET['id'];
}

if(isset($_POST['slett_fra_innhold'])) {
    global $mysqli;
    $idbilder = $_POST['idbilder'];
    $idinnhold = $_POST['id_innhold'];
    $stmt = $mysqli->prepare("delete from bilderinnhold where _idbilder = ? AND _idinnhold = ?");
    $stmt->bind_param('ii', $idbilder, $idinnhold);
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
    <form>
        <?php include("Include/BilderVelgInnholdDropdown.php")?>

    </form>
    <?php
    if(isset($_POST['idbilder'])) {
        echo("Bildet ble inkludert!");
    }
    ?>
</section>

<?php
function hent_linkede_bilder() {
    global $mysqli;

    $id = $_GET['id'];
    $stmt = $mysqli->prepare(
        "select *
                  from bilder inner join bilderinnhold
                  on bilder.idbilder = $id");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_linked_result = $stmt->get_result();
    return $img_linked_result;

}

function hent_alle_bilder() {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, hvor, tekst, thumb, bredde, hoyde, _idbilder from vikerfjell.bilder 
                        left join vikerfjell.bilderinnhold ON bilder.idbilder = bilderinnhold.`_idbilder`");
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


while($row = $img_result->fetch_assoc()) {
    unset($_idbilder);
    $idbilder = $row['idbilder'];
    $hvor = $row['hvor'];
    $tekst = $row['tekst'];
    $dimension = $row['hoyde'] . 'x' . $row['bredde'];
    $thumb = $row['thumb'];
    $_idbilder = $row['_idbilder'];


    echo("
<section class='bildeinfo_container'>
<input type='hidden' value='$idbilder' name='id' id='id'>
<img src='$thumb'>
<p>$tekst</p>
<p style='margin-top: 0;'>$dimension</p>");


//if
    if (!(isset($_idbilder))) {
        echo('<br />');
        echo('<form method="post" action="AdministrerBilderLink.php">');

        echo("<input type='hidden' class='innhold_id' name='id_innhold' value='$id_innhold'>");
        echo("<input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>");
        echo('<input type="submit" value="Inkluder i innhold" class="søk_knapp">');
        echo('</form>');
        echo('</section>');
    } else {
        echo('<br />');
        echo('<form method="post" action="AdministrerBilderLink.php">');

        echo("<input type='hidden' class='innhold_id' name='id_innhold' value='$id_innhold'>");
        echo("<input type='hidden' name='idbilder' id='idbilder' value='$idbilder'>");
        echo("<input type='hidden' id='slett_fra_innhold' name='slett_fra_innhold'>");
        echo('<input type="submit" value="Fjern fra innhold" class="søk_knapp">');
        echo('</form>');
        echo('</section>');
    }


}



?>