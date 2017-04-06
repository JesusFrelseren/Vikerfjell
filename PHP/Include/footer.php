<?php
/* Sist endret av Erlend 30.03.2017-->
<!--Sett over av Erik 30.03.2017 */
//Her lager vi hele footeren
echo('
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
  <div class="rowfooter">
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
</html>');
?>
