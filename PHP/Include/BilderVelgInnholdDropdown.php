<?php
include 'mysqlcon.php';
    $id = $_GET['id'];
    $stmt = $mysqli->prepare("
            SELECT *
            FROM meny
            ;
      ");

    //$stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $array = [];


echo("<select class='lenkerDropdown' id='lenkerdrop' name='lenkerdropdown' onchange='populatemenu()'");
echo("svar");
    // Utdata for hver rad
while($row = $result->fetch_assoc()) {
    $array[$row['idinnhold']] = $row['side'];
    echo "<option value=" . $row["idinnhold"] . ">
    Tittel: " . $row["tittel"] . "
    </option><br>";

}




echo("</select>");
mysqli_close($mysqli);

?>
