<?php
$to      = 'vikerfjell@vikerfjell.no';
$subject = $_POST["Name"];
$mail = $_POST["Mail"];
$message = $_POST["Comment"];


if(empty($subject) || empty($mail) || empty($message)){
    // header('Location: ../../henvendelser.html');
        echo('<p>Meldingen kunne ikke sendes. Venligst fyll inn alt og prøv på nytt. </p>');
    } else {
        mail($to, $subject, $message, "From: <" . $mail . ">" );
        //header('Location: ../../henvendelser.html');
        echo("<p> Meldingen sendt</p>");
              
    }
?>