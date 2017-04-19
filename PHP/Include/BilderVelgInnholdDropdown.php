<?php
include 'mysqlcon.php';

    $stmt = $mysqli->prepare("
            SELECT *
            FROM innhold
            ;
      ");

    //$stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = [];


echo("<select class='lenkerDropdown' id='innhold_dropdown' name='innhold_dropdown' onchange='innholdReturnId()'>");
echo("svar");
    // Utdata for hver rad
while($row = $result->fetch_assoc()) {
    $tittel = $row['tittel'];
    $array[$row['idinnhold']] = $row['side'];
    echo "<option value=" . $row["idinnhold"] . ">
    $tittel
    </option><br>";

}




echo("</select>");
mysqli_close($mysqli);

?>
