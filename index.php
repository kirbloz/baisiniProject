<?php
include('php/header.php')
?>

<!-- stampa delle slide -->
<div id="carousel" class="carousel slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="d-block w-100" src="images/bg.jpg">
			<div class="carousel-caption d-none d-md-block">
				<h1 class="display-4">Easy LAN</h1>
				<h3>Il tuo fornitore di connettivit&agrave;</h3>
				<a href="signup.php"><button type="button" class="btn btn-outline-light btn-lg">Iniziamo</button></a>
			</div>
		</div>
		<div class="carousel-item">
			<img src="images/second.jpg" class="d-block w-100" alt="...">
			<div class="carousel-caption d-none d-md-block">
			</div>
		</div>
		<div class="carousel-item">
			<img src="images/third.jpg" class="d-block w-100" alt="...">
			<div class="carousel-caption d-none d-md-block">
			</div>
		</div>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
</div>

<!-- stampa del jumbotron -->
<div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">Un portale online per accedere ai diversi servizi legati al mercato della connettivit&agrave; offerti dall'azienda EasyLAN. Contattaci per maggiori informazioni.</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg">Leggi</button></a>
		</div>
	</div>
</div>
<!-- -->
<div class="container-fluid">

	<div class="row welcome text-center">
		<div class="col-12">
			<h3 class="display-4">Scopri di pi&ugrave;</h3>
		</div>
		<hr>
		<div class="col-12">
			<ul>
				<li><a href="images/CLIL.pptx" download>Cosa facciamo?</li>
				<li>Che cosa installiamo?</li>
				<li>Curiosit&agrave; e approfondimenti</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- stampa del footer-->
<footer>
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-4">
				<hr class="light">
				<b>EASYLAN</b>
				<hr class="light">
				<p>324-092-2939</p>
				<p>easylanproject@gmail.com</p>
				<p>Olivelli Putelli</p>
			</div>
			<div class="col-md-4">
				<hr class="light">
				<p>Orari</p>
				<hr class="light">
				<p>Settembre-Giugno</p>
				<p>08:00 - 14:00</p>
			</div>
			<div class="col-md-4">
				<hr class="light">
				<p>Le nostre sedi</p>
				<hr class="light">
				<p>Darfo</p>
				<p>Brescia</p>
			</div>
		</div>
	</div>
	<div id="privacy-link" class="col-12 text-center">
		<hr class="light-100">
		<a style="color:#fff;" href="https://www.iubenda.com/privacy-policy/27774228" rel="noreferrer nofollow" target="_blank"> &copy;Privacy Policy</a> - <a style="color:#fff;" href="#" role="button" class="iubenda-advertising-preferences-link">Personalizza tracciamento pubblicitario</a>
	</div>
</footer>

</body>

</html>