<!--Sist endret av Erlend Hall 06.02.2017-->
<!--Sett over av Alex 06.02.2017-->

<?php
include 'startSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Vikerfjell Admin</title>
	<link href="CSS/style_admin.css" rel="stylesheet">
	<link href="CSS/menybar.css" rel="stylesheet">
	<link href="CSS/brukere.css" rel="stylesheet">
	<script defer src="JavaScript/JS.js">
	</script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
</head><!--Rad 1: Overskift-header-->
<body>
	<?php
		include 'Include/backendmeny.php';
	?>
	</nav><!-- Hovedinnhold-->
	<div class="containor">
		<div class="venstreside">
			<div class="bilde">
				<img src="Bilder/logov2.png" width=100% height=auto>
			</div>
			<div class="ingress">
				Du er nå inne i back-end delen av Visit Vikerfjell, her kan du gjøre endringer og oppdateringer på nettstedet.
			</div>
		</div>
        <form action="Include/leggtilMeny.php" method="post">
            <input type="submit" value="Oppdater">
        </form>
		<div class="hoyreside">
			<div class="oversikt">
				<h2 style="margin-left: 1%;">Snarveier</h2>
				<ul>
				  <li><a href="brukere.php">Lag en ny bruker</a></li>
				  <li><a href="innhold.php">Legg til nytt innhold</a></li>
				  <li><a href="EndreMeny.php">Legg nytt menyelement</a></li>
				</ul>
			</div>
		</div>
	</div>

	<!--<div class="row">
		<div class="col-12">
			<article>
				12 kolonner fullbredde
			</article>
		</div>
	</div>
	<div class="row">
		<div class="col-10">
			<article>
				10 kolonner article
				<div class="row">
					<div class="col-6">
						<section>
							6 kolonner section
						</section>
					</div>
					<div class="col-6">
						<section>
							6 kolonner section
						</section>
					</div>
					<div class="col-6">
						<section>
							6 kolonner section
						</section>
					</div>
					<div class="col-6">
						<section>
							6 kolonner section
						</section>
					</div>
				</div>
			</article>
		</div>
		<div class="col-2">
			<aside>
				2 kolonner aside
			</aside>
			<aside>
				2 kolonner aside
			</aside>
			<aside>
				2 kolonner aside
			</aside>
			<aside>
				2 kolonner aside
			</aside>
			<aside>
				2 kolonner aside
			</aside>
			<aside>
				2 kolonner aside
			</aside>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<article>
				6 kolonner
			</article>
		</div>
		<div class="col-6">
			<article>
				6 kolonner
			</article>
		</div>
	</div>
	-->
</body>
</html>
