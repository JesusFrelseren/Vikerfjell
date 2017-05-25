<?php
include('mysqlcon.php');


$søketekst = "";

//Hvis bruker søker med søkebaren
if (isset($_POST["søk_bilde_search_box"])) {
    $søketekst = $_POST['søk_bilde_search_box'];
    vis_alle_bilder($søketekst);

    //Hvis bruker klikke på knappen for å inkludere bilde i innhold
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

    //Hvis bruker klikket knappen for fjerne link til innhold
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

?>