<?php
include 'mysqlcon.php';

    $stmt = $mysqli->prepare("
            SELECT *
            FROM innhold;");

    //$stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = [];


echo("<select class='lenkerDropdown' id='id' name='id' onchange='innholdReturnId()'>");
echo("svar");
    // Utdata for hver rad
echo("<option>Velg innhold</option>");
while($row = $result->fetch_assoc()) {
    $tittel = $row['tittel'];
    $array[$row['idinnhold']] = $row['side'];
    echo "<option value=" . $row["idinnhold"] . ">
    $tittel
    </option><br>";

}

echo("</select>");

?>
