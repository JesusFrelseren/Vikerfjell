
<?php

include("NyesteInnhold.php");

$idinnhold = getIdinnhold();
/* Sist endret av Alex 06.02.2017-->
<!--Sett over av Erlend 06.02.2017 */
//Her lager vi backendmenyen
echo("

<div id='modalProgress'>
    <p style='color: #5ce638'>Jobber..</p>
</div>
<header>
		<a href='admin.php'><img class='headerbakgrunn' src='Bilder/logov2_admin.png'></a>
		

	</header>
	
	<!--Rad 2: Menybar-->
	<nav class='topnav' id='myTopnav'>
		<ul>
			<li>
				<a href='admin.php'>Hjem</a>
			</li>
			<li>
				<a href='innhold.php'>Administrer innhold</a>
			</li>
			<li>
				<a href='EndreMeny.php'>Endre meny</a>
			</li>
			<li>
				<a class='aktivlenke' href='brukere.php'>Brukere</a>
			</li>
			<li class='dropdown'>
			    <a href='AdministrerBilder.php' class='dropbtn'>Bilder</a>
                    <div class='dropdown-content'>
                        <a href='AdministrerBilder.php'>Opplasting</a>
                        <a href='AdministrerBilderLink.php?option_selected_index=0&id=$idinnhold'>Linking</a>
                    </div>
			</li>
			<li id='oppdaterAlt'>
	            <form action=\"Include/leggtilMeny.php\" method=\"post\" id='oppdaterAlt'>


                <input  name=\"menuname\" id=menuname\" type=\"hidden\" value=\"temp\">
            
                <input name=\"menurow\" id=\"menurow\" type=\"hidden\" value=\"10\">
            
                <input name=\"menyliste\" id=\"menyliste\" type=\"hidden\" value=\"dummy\">
            
                <a href='javascript:;' onclick='oppdaterSide(parentNode)' name='oppdaterAlt' id='oppdaterAlt'>Lagre endringer</a>
        
                </form>
             </li>
    
    
</form>
</li>
			<li id='logutid'>
				<a href='loggut.php'>Logg ut</a>
			</li>
			<li class='dropdown' id='brukerid'>
				<a class='dropbtn' href='#'>")
?>
<?php
echo($_SESSION['name'])
?>
<?php
echo("</a><div class='dropdown-content'>
            <a href='Endre.php'>Endre passord</a> <a href='#'>Innstillinger</a>
        </div>
    </li>
    <li class='icon'>
        <a href='javascript:void(0);' onclick='myFunction()' style='font-size:15px;'>☰</a>
    </li>
    </ul>");

?>
