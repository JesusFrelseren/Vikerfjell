<!--Sist endret av Alex 16.02.2017-->
<!--Sett over av Erlend 16.02.2017-->
<?php
include 'startSession.php';
include 'Include/mysqlcon.php';
include 'Include/konstant.php';

$oldPw = mysqli_real_escape_string($mysqli, $_POST['oldpw']);
$newPW = mysqli_real_escape_string($mysqli, $_POST['newpw']);
$confirm = mysqli_real_escape_string($mysqli, $_POST['confirmpw']);
$minID = $_SESSION['userid'];

$stmt = $mysqli->prepare("SELECT * FROM bruker WHERE idbruker=?");
$stmt->bind_param("s",$minID);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();



$PW = sha1(constant("SALT").$oldPw);
$newPW = sha1(constant("SALT").$newPW);
$confirm = sha1(constant("SALT").$confirm);

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