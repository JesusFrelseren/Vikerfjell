
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Vikerfjell</title>
    <link type='text/css' href='CSS/frontend_header.css?v=12345' rel='stylesheet'>
    <link type='text/css' href='CSS/frontend_slider.css?v=12345' rel='stylesheet'>
    <link type='text/css' href='CSS/frontend_mediaquerys.css?v=12345' rel='stylesheet'>
    <link type='text/css' href='CSS/frontend_footer_new.css?v=12345' rel='stylesheet'>
    <link href="CSS/henvendelser.css" rel="stylesheet">
    <link type='text/css' href='CSS/menybar.css?v=12345' rel='stylesheet'>
    <script src='JavaScript/JS.js?v=12345' type='text/javascript' defer></script>
</head>
<body>

<header class='col-12 col-m-12'>
    <!--Header logo-->
    <a href='default.php'><img src='Bilder/logov2.png' class='headerbakgrunn'></img></a>

    <!--Header logo mobil
    <a href='default.php'><img src='Bilder/logo.png' class='headerbakgrunnmobil'></img></a>

    <div class='headerbakgrunnmobil'>
      <img src='Bilder/headerimgmobil.jpg'>
    </div>-->


    <div class='row'>
        <nav id='myTopnav' class='topnav'>
            <ul>
                <li><a href="../default.php">Tilbake </a></li>
                <li class='icon'>
                    <a href='javascript:void(0);' style='font-size:15px;' onclick='myFunction()'>☰</a>
                </li>

            </ul>
        </nav>
</header>
</div>
<div class='henWrap'>
    <form class="boxHenvendelser" action="Include/sendHenvendelse.php" method="post">
        <h3 class="overskrift"> Send henvendelse </h3>
        <p class="tekst">Emne: <input name="Name" type="text" id="Name" size="40"></p>
        <p class="tekst">Mail: <input name="Mail" type="text" id="Mail" size="40"></p>
        <p class="tekst">Kommentar:</p>
        <p class="tekst"><textarea class="input" name="Comment" cols="55" rows="5" id="Comment"></textarea></p>
        <p class="tekst"><input type="submit" name="Submit" value="Submit"></p>
        <h3 style="position: absolute; bottom: 10%; left:5.2%;">
            <?php $msg = isset($_GET['feilslett']) ? $_GET['feilslett'] : '';
            echo ($msg)
            ?></h3>
        <h3 style="position: absolute; bottom: 10%; left:5.2%;">
    </form>
</div>
<!--Footer-->
<footer class="fcol-12">
    <div class="rowfooter">
        <!--  <img src="Bilder/footerbilde.jpg"> -->
        <div class="fcol-2">
            <section class="nyhetsbrev_sosiale_medier">
                <form>
                    <h3>Signer for nyhetsbrev</h3>
                    <input type="text" id="fname" name="fname" placeholder="E-post adresse">
                    <button type="button">Registrer</button>
                </form>
                <a href="www.facebook.com"><img src="Bilder/face.png" width="30" height="30"></img></a>
                <a href="www.twitter.com"><img src="Bilder/twitter.png" width="30" height="30"></img></a><br  />
            </section>
        </div>
        <div class="fcol-3">
            <section class="kontaktinfo">
                <h3>Kontakt</h3>
                <ul>
                    <li>Elsrud gård</li>
                    <li>Vestre Ådal 922</li>
                    <li>3516 Hønefoss</li>
                    <li>post@vikerfjell.com</li>
                    <li>930 11 567</li>
                </ul>
            </section>
        </div>
        <div class="fcol-2">
            <p>
                Sponsorer
            </p>
        </div>
        <div class="fcol-3">
            <div class="naviger">
                <h3>Naviger</h3>

                <nav>
                    <a href="#">Kjøp fiskekort</a>
                    <a href="#">Sjekk snødybde</a>
                    <a href="#">Bestill ved</a>
                    <a href="#">Webkamera</a>
                </nav>

                <nav>
                    <a href="#">Serveringssted</a>
                    <a href="#">Bestill elektriker</a>
                    <a href="#">Bestill rørlegger</a></a>
                    <a href="#">Værvarsel</a>
                </nav>
            </div>
        </div>
    </div>
    <div class="rowfooter">
        <div class="sub_footer">
            <div class="fcol-2">
                <img src="Bilder/logofooter.png">
            </div>
            <div class="fcol-7">
                <div class="sub_footer_linker">
                    <a href="form.php">Ansatt login</a>
                    <a href="#">Cookies</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
            <div class="fcol-2">
                <p>Laget av gruppe 5</p>
            </div>
        </div>
    </div>
</footer>
</div>
</body>
</html>