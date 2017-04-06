<!--Sist endret av Alex 16.02.2017-->
<!--Sett over av Erlend 16.02.2017-->
<?php
include 'startSession.php';
include 'Include/mysqlcon.php';

$oldPw = mysqli_real_escape_string($mysqli, $_POST['oldpw']);
$newPW = mysqli_real_escape_string($mysqli, $_POST['newpw']);
$confirm = mysqli_real_escape_string($mysqli, $_POST['confirmpw']);
$minID = $_SESSION['userid'];

	$stmt = $mysqli->prepare("SELECT * FROM bruker WHERE idbruker=?");
    $stmt->bind_param("s",$minID);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $salt = 'IT2_2017';


$PW = sha1($salt.$oldPw);
$newPW = sha1($salt.$newPW);
$confirm = sha1($salt.$confirm);

$dbOldPw = $row['passord'];

if($oldPw != '' && $newPW != '' && $confirm != '') {
	if ($PW == $dbOldPw) {
		if($newPW == $confirm){
			$stmt = $mysqli->prepare("UPDATE bruker SET passord =? WHERE idbruker=?");
     		$stmt->bind_param("ss",$newPW,$minID);
      		$stmt->execute();
      		header("location:Endre.php?msg=Passord endret!");

}else{//feilmelding ikke like passord ny og confirm
	  header("location:Endre.php?msg=Passordene stemmer ikke overens");

}

}else{
	//ikke riktig gammelt passord
	header("location:Endre.php?msg=Det gamle passordet er feil");

}
}else{//alle felter er ikke fyllt
header("location:Endre.php?msg=Venligst fyll alle felter");
}







?>
