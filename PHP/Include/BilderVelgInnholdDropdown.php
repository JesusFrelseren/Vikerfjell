<?php
include 'mysqlcon.php';

if (isset($_GET['id'])) {
    var_dump($_GET);
    $id = $_GET['id'];
    echo($id);
    $stmt = $mysqli->prepare("SELECT *
            FROM meny inner join innhold on meny.idmeny = innhold.idmeny
            WHERE meny.idmeny = $id");

    $result = $stmt->get_result();
    $array = [];
}

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
