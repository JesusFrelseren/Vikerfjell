<?php
/*
Laget av Alex
Sist endret 01.06.2017
*/
include 'include/mysqlcon.php';
include 'Include/konstant.php';

// tar imot variabler fra inputfelt.
$newPW = mysqli_real_escape_string($mysqli, $_POST['newpw']);
$confirm = mysqli_real_escape_string($mysqli, $_POST['confirmpw']);
$mailid = mysqli_real_escape_string($mysqli, $_POST['minid']);

//salter og hasher passord
$newPW = sha1(constant("SALT").$newPW);
$confirm = sha1(constant("SALT").$confirm);



// her burde det brukes token og tids avbrudd for bedre sikkerhet. også eventuelt sende sms med pin for verifisering av hvem du er.

//sjekk om passord
if($newPW != '' && $confirm != '' & $newPW == $confirm ) {
    $stmt = $mysqli->prepare("UPDATE bruker SET passord =? WHERE idbruker=?");
    $stmt->bind_param("ss",$newPW,$mailid);
    $stmt->execute();
    header("location:form.php?msg=Passord endret");


}else{
    header('location:EnderPassordframail.php?msg=passordene var ikke like&id=$_REQUEST["id"]');
}


?>