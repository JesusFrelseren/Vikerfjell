<?php
$newPW = mysqli_real_escape_string($mysqli, $_POST['newpw']);
$confirm = mysqli_real_escape_string($mysqli, $_POST['confirmpw']);


$salt = 'IT2_2017';
$newPW = sha1($salt.$newPW);
$confirm = sha1($salt.$confirm);
$mailid = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
// her må det brukes token og tids avbrudd for bedre sikkerhet. også eventuelt sende sms med pin for verifisering av hvem du er.


if($newPW != '' && $confirm != '') {
		if($newPW == $confirm){
			$stmt = $mysqli->prepare("UPDATE bruker SET passord =? WHERE idbruker=?");
     		$stmt->bind_param("ss",$newPW,$mailid);
      		$stmt->execute();
      		header("location:form.php?msg=Passord endret");

}else{//feilmelding ikke like passord ny og confirm
	  header("location:EndrePassordframail.php?msg=Passordene stemmer ikke overens&id=$_REQUEST['id']");

}else{
	 header("location:EndrePassordframail.php?msg=Et av feltene var ikke fyllt&id=$_REQUEST['id']");
}

?>