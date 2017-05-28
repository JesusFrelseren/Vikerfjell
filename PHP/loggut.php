<!--Sist endret av Alex Hall 14.02.2017-->
<!--Sett over av Sindre 14.02.2017-->


<?php
include 'startSession.php';

session_unset();

session_destroy();
//print_r($_SESSION);
header("location:../default.php");




