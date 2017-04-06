<?php
/* Sist endret av Alex 28.03.2017-->
<!--Sett over av Sindre 28.03.2017 */
include 'mysqlcon.php';



$sql = "SELECT * FROM vikerfjell.meny left join submeny on meny.idmeny = submeny.meny_idmeny ORDER BY rekke;";
$result = mysqli_query($mysqli, $sql);
$artnr = 0;
echo("<select class='plassering' id='listetest' name='menylistephp' onchange='changeMenyFuncBilder()'>");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $id = "";
    while($row = mysqli_fetch_assoc($result)) {
        if($row["idmeny"] == $id){
            if ($row["meny_idmeny"] != null) {

                echo "<option value=". "SUB".$row["idsubmeny"] .">
    Submeny - " . $row["tekst"].": ". $row["sub_tekst"]."
    </option><br>";
                $artnr ++;
            }
        }else{
            if ($row["meny_idmeny"] == null) {

                echo "<option value=". $row["idmeny"] .">
      Hovedmeny - " . $row["tekst"]."
      </option><br>";
            }else{
                echo "<option value=". "SUB".$row["idsubmeny"] .">
         Submeny - " . $row["tekst"].": ". $row["sub_tekst"]."
         </option><br>";
                $artnr ++;
            }
        }

        $id = $row["idmeny"];
    }
} else {
    echo "0 results";
}
echo("</select>");



mysqli_close($mysqli);

?>
