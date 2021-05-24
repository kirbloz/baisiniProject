<?php
@include_once('session.inc.php');
@include_once('php/session.inc.php');
@include_once('../php/session.inc.php');
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>EasyLAN</title>
	<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/carousel/">
	<!-- bootstrap -->
	<link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="/images/favicon.ico" />
</head>

<body>
	<div class="color-white bg-div">

		<nav class="navbar navbar-expand-md navbar-light sticky-top" style="background-color:#97a6c2;">
			<div class="container-fluid flex" style="justify-content: space-between;">
				<a class="navbar-brand" style="color:#3f3f3f" href="index.php">
					<h2>Easy LAN PORTAL</h2>
				</a>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<?php
						if (checkActive()) {
							if ($_SERVER['REQUEST_URI'] != '/baisiniProject/areaUtente.php')
								echo '<li class="nav-item"><a class="nav-link" href="areaUtente.php">Area Utente</a></li>';
							echo '<li class="nav-item"><a class="nav-link" href="php/logout.inc.php">Logout</a></li>';
						} else if (checkActiveSuper()) {
							if ($_SERVER['REQUEST_URI'] != '/baisiniProject/areaSuperutente.php')
								echo '<li class="nav-item"><a class="nav-link" href="areaSuperutente.php">Area Utente</a></li>';
							echo '<li class="nav-item"><a class="nav-link" href="php/logout.inc.php">Logout</a></li>';
						} else {
							echo '<li class="nav-item"><a class="nav-link" id="login-button" href="login.php">Login</a></li>';
							echo '<li class="nav-item"><a class="nav-link" href="signup.php">Registrati</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
		</nav>