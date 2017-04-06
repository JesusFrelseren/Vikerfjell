<!--
Sist endret av Sindre 17.03.2017
Sett på av Erik 03.03.2017
-->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vikerfjellss</title>
  <link type="text/css" href="PHP/CSS/frontend_header.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_slider.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_mediaquerys.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_footer_new.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/menybar.css?v=12345" rel="stylesheet">
  <script src="PHP/JavaScript/JS.js?v=12345" type="text/javascript" defer></script>
</head>
<body onload="carousel()">

  <?php
  include("PHP/Include/header.php");
  include("PHP/Include/meny.php");
  ?>

  <div id="sliderbox1" class="slidercontainer">
    <div class="wrapperOverskrift">
      <h1>Visit Vikerfjell</h1>
      <p>Oslos nærmeste høyfjell - gir fantastiske naturopplevelser hele året</p>
      <!--<div class="væretcontent">
          <script src="PHP/JavaScript/yr_stor.js"></script><noscript><a href="http://www.yr.no/place/Norway/Buskerud/Ringerike/Vikerfjell/">yr.no: Forecast for Vikerfjell</a></noscript>
      </div>-->
    </div>
    <div class="sliderbox">
        <img src="PHP/Bilder/slider/teste4.jpg">

        <!--<li><img class="mySlides" src="Bilder/slider/toppen.jpg"></li>-->
        <!--<li><img class="mySlides" src="Bilder/slider/vann_utsikt.jpg"></li>-->
    </div>

    <!--<ul class="portrait_slide">
    <li><img class="mySlides" src="Bilder/slider/portrett-test.jpg" height="332"></li>
  </ul>
-->
</div>


<!-- notasjon: lage mediaquery: 1480px-->
<div class="col-12 innholdswrapper">
  <section>
    <h2>Aktiviteter</h2>
    <p>Vinterstid har området  oppkjørte skiløyper i nydelig turterreng. Om sommeren er det muligheter for bade- og båtliv i Sperillen og flotte turer i skog og fjell. Ringerike Turistforening har et stort nettverk av merkede stier på Vikerfjell. Det er gode fiskevann i området som blir jevnlig kalket og området har et rikt dyreliv med lange jakttradisjoner.</p>
  </section>
  <section>
    <h2>Aktuelt</h2>
    <p>Se webkamera fra Vikerfjell. Webkamera på Vikerfjell er plassert på Brøttet på Elsrudåsen og sender bilder med jevne mellomrom. Dato, klokkeslett og temperaturvises nederst på bildene. Du kan bla igjennom tidligere bilder ved å trykk på  bildet. Her vises de siste 5 bildene, men du kan klikke her for å se tidligere bilder fra webkameraet</p>
  </section>
  <section>
    <img src="PHP/Bilder/logo-skisporet.png">
    <p>Se live oppdatering av skisporene på vikerfjell: <a href="https://skisporet.no/buskerud/vikerfjell">Skisporet.no</a></p>
  </section>
</div>




<div class="col-12 nyhetswrapper">
  <section class="colsection">
    <div class="colsectioncontent">
      <a href="#" alt="Bilde1">
        <img src="PHP/Bilder/img_kjope.jpg">
      </a>
      <h2 class="contentheaders">Hytter til salgs</h2>
      <p class="colsectioncontent"> Vil du bo på Vikerfjells sykeste hytter? Sjekk ut her da vel brusjanen skaosdkoakd</p>
    </div>
  </section>
  <section class="colsection">
    <div class="colsectioncontent">
      <a href="#" alt="Bilde2">
        <img src="PHP/Bilder/img_utleie.jpg">
      </a>
      <h2 class="contentheaders">Hytter til leie</h2>
      <p class="colsectioncontent"> Her kan du leie noen syke hytter, de er drit fete og ligger rett ved bakken!.</p>
    </div>
  </section>
  <section class="colsection">
    <div class="colsectioncontent">
      <a href="#" alt="Bilde3">
        <img src="PHP/Bilder/img_hyttetomt.jpg">
      </a>
      <h2 class="contentheaders">Hyttetomt til salgs</h2>
      <p class="colsectioncontent"> Her kan du kjøpe noen syke hyttetomter, de er drit fete sjekk dem ut om du gidder.</p>
    </div>
  </section>
  <section class="colsection">
    <div class="colsectioncontent">
      <a href="#" alt="Bilde3">
        <img src="PHP/Bilder/img_webcam.jpg">
      </a>
      <h2 class="contentheaders">Webkamera</h2>
      <p class="colsectioncontent"> Her kan du kjøpe noen syke hyttetomter, de er drit fete sjekk dem ut om du gidder.</p>
    </div>
  </section>

</div>

<!--Footer-->
<footer class="fcol-12">
  <div class="row">
    <!--  <img src="Bilder/footerbilde.jpg"> -->
    <div class="fcol-2">
      <section class="nyhetsbrev_sosiale_medier">
        <form>
          <h3>Signer for nyhetsbrev</h3>
          <input type="text" id="fname" name="fname" placeholder="E-post adresse">
          <button type="button">Registrer</button>
        </form>
        <a href="www.facebook.com"><img src="PHP/Bilder/face.png" width="30" height="30"></img></a>
        <a href="www.twitter.com"><img src="PHP/Bilder/twitter.png" width="30" height="30"></img></a><br  />
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
  <div class="row">
    <div class="sub_footer">
      <div class="fcol-2">
        <img src="PHP/Bilder/logofooter.png">
      </div>
      <div class="fcol-7">
        <div class="sub_footer_linker">
          <a href="PHP/form.php">Ansatt login</a>
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
