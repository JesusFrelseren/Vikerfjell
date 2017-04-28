<?php
include 'mysqlcon.php';

    $stmt = $mysqli->prepare("
            SELECT *
            FROM innhold;");

    //$stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = [];
    if(isset($_GET['option_selected_index'])) {
        $index = $_GET['option_selected_index'];
        $counter = 1;
    }

echo("<select class='lenkerDropdown' id='id' name='id' onchange='innholdReturnId()'>");
echo("svar");
    // Utdata for hver rad
echo("<option>Velg innhold</option>");
while($row = $result->fetch_assoc()) {
    $tittel = $row['tittel'];
    $array[$row['idinnhold']] = $row['side'];

    if($counter == $index) {
        echo "<option value=" . $row["idinnhold"] . " selected>
    $tittel
    </option><br>";
    } else {
        echo "<option value=" . $row["idinnhold"] . ">
    $tittel
    </option><br>";
    }
    $counter++;

}

echo("</select>");

?>
