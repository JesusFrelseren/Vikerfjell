<?php
/* Sist endret av Alex 06.02.2017-->
<!--Sett over av Erlend 06.02.2017-->
<!--kode tatt fra stackoverflow.com */

//Her lager vi session

session_start();

if ($_SESSION['name']==''){
header("location:form.php");
}

	
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
          // last request was more than 30 minutes ago
           session_unset();     // unset $_SESSION variable for the run-time 
          session_destroy();   // destroy session data in storage

          header("location:form.php?msg=Inaktiv for lenge!");
}else{
	$_SESSION['LAST_ACTIVITY'] = time();
}
