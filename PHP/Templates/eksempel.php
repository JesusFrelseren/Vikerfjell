

  <?php
    require("./PHP/Include/mysqlcon.php");
    $stmt = $mysqli->prepare(
    "select innhold.tittel, innhold.tekst, dokumenter.hvor, dokumenter.tekst
    from innhold, dokumenter, dokumenterinnhold, meny
    where innhold.idinnhold = dokumenterinnhold._idinnhold
	   and dokumenter.iddokumenter = dokumenterinnhold._iddokumenter
     and meny.idmeny = innhold.idmeny");

    mysqli_set_charset($mysqli, "UTF8");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $h1 = $row['tittel'];
    $body_text = $row['tekst'];
    $link = $row['hvor'];

    echo
    ("
      <body>
          <section>
            <h1>$h1</h1>
            <article>
              <p>
                $body_text
              </p>

              </article>
          </section>
          <section>
            <h2>$h1</h2>
              <a href=$link>Link</a>
          </section>
      </body>


      ")

  ?>
