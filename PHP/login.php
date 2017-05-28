<!--Sist endret av Alex Hall 06.02.2017-->
<!--Sett over av Erlen 06.02.2017-->


<?php
//http://www.intechgrity.com/create-login-admin-logout-page-in-php-w/#

include 'Include/mysqlcon.php';

$username = mysqli_real_escape_string($mysqli, $_POST["username"]);
$password = mysqli_real_escape_string($mysqli, $_POST["password"]);

$msg = '';

if(isset($username, $password)) {



// MÅ ÅPNES FØRST NÅR CREATE USER ER DONE!!!!
    $salt = "IT2_2017";
    $password = sha1($salt.$password);
    // MÅ ÅPNES FØRST NÅR CREATE USER ER DONE!!!!

    $stmt = $mysqli->prepare("SELECT * FROM bruker WHERE brukerNavn=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $row1 = $result1->fetch_assoc();
    $brukerid = $row1["idbruker"];
    $tid = $row1["feilLogginnSiste"];
    $teller = $row1["feilLogginnTeller"];
    $nowtime = time();
    $diff = $nowtime - strtotime($tid);


    if ($diff > 300) {
        $stmt = $mysqli->prepare("UPDATE bruker SET feilLogginnTeller = 0 WHERE idbruker=?");
        $stmt->bind_param("s",$brukerid);
        $stmt->execute();
        $teller = 0;
    }



    if ($row1) {



        if ($teller<=5) {


            $stmt = $mysqli->prepare("SELECT * FROM bruker WHERE brukerNavn=? and passord=?");
            $stmt->bind_param("ss",$username,$password);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row){
                include 'startSession.php';
                $_SESSION['LAST_ACTIVITY'] = time();
                $_SESSION['name']= $username;
                $_SESSION['userid']= $brukerid; //trengs om man vil vite hvem som har gjort ting på siden. f.eks legge til brukere. (lag dette som en fk på btukere i db. som viser til hvem som har opprettet brukeren.)
                header("location:admin.php");
                exit;

            }else {
                $stmt = $mysqli->prepare("UPDATE bruker SET feilLogginnTeller = feilLogginnTeller + 1 WHERE idbruker=?");
                $stmt->bind_param("s",$brukerid);
                $stmt->execute();
                $stmt = $mysqli->prepare("UPDATE bruker SET feilLogginnSiste = CURRENT_TIME() WHERE idbruker=?");
                $stmt->bind_param("s",$brukerid);
                $stmt->execute();
                header("location:form.php?msg=Feil brukernavn eller passord");

            }


        }else{



            header('location:form.php?msg=du har prøvd for mange ganger. prøv igjen om noen minutter!');

        }

    }else{
        header("location:form.php?msg=Feil brukernavn eller passord");
    }
}


?>