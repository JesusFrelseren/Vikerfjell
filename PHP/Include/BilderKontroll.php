<?php
//Utviklet av Erlend. Sist endret 07.05.2017


require("mysqlcon.php");

function hent_alle_bilder() {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, hvor, tekst, thumb, bredde, hoyde, _idbilder from vikerfjell.bilder 
                        left join bilderinnhold ON idbilder = _idbilder order by _idbilder DESC");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_result = $stmt->get_result();
    return $img_result;
}

function hent_linkede_bilder($søketekst, $idinnhold) {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, hvor, alt, bilder.tekst, thumb, bredde, hoyde, _idbilder, idinnhold
from innhold inner join(bilderinnhold inner join bilder ON _idbilder = idbilder) on `_idinnhold` = idinnhold 
WHERE bilder.tekst like '%$søketekst%' AND _idinnhold = $idinnhold");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_linked_result = $stmt->get_result();
    return $img_linked_result;

}

function hent_ulinkede_bilder($søketekst) {
    global $mysqli;
    $stmt = $mysqli->prepare(
"select idbilder, hvor, alt, tekst, thumb, bredde, hoyde, _idbilder, _idinnhold
from bilder left join bilderinnhold on idbilder = _idbilder
where tekst like '%$søketekst%'");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_result = $stmt->get_result();
    return $img_result;
}


function hent_filterte_bilder($søketekst) {
    global $mysqli;
    $stmt = $mysqli->prepare("select idbilder, alt, hvor, tekst, thumb, bredde, hoyde from vikerfjell.bilder where tekst like '%$søketekst%'");
    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $img_result = $stmt->get_result();
    return $img_result;
}
