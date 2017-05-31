<?php
include 'include/mysqlcon.php';
$newPW = mysqli_real_escape_string($mysqli, $_POST['newpw']);
$confirm = mysqli_real_escape_string($mysqli, $_POST['confirmpw']);
$mailid = mysqli_real_escape_string($mysqli, $_POST['minid']);

$salt = 'IT2_2017';
$newPW = sha1($salt.$newPW);
$confirm = sha1($salt.$confirm);

// her må det brukes token og tids avbrudd for bedre sikkerhet. også eventuelt sende sms med pin for verifisering av hvem du er.


if($newPW != '' && $confirm != '' & $newPW == $confirm ) {
			$stmt = $mysqli->prepare("UPDATE bruker SET passord =? WHERE idbruker=?");
     		$stmt->bind_param("ss",$newPW,$mailid);
      		$stmt->execute();
      		header("location:form.php?msg=Passord endret");
			

}else{
	 header('location:EnderPassordframail.php?msg=passordene var ikke like&id=$_REQUEST["id"]');
}


?>