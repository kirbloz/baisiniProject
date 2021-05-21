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
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="/images/fav.ico" />
</head>

<body>
	<div class="color-white bg-div">
		<nav class="navbar navbar-expand-md navbar-light sticky-top" style="background-color:#97a6c2;">
			<div class="container-fluid">
				<a class="navbar-brand" style="color:#3f3f3f" href="index.php">
					<h2>Easy LAN PORTAL</h2>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
					<?php
					if(checkActive()){
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaUtente.php')
							echo '<li><a class="nav-link" href="areaUtente.php">Area Utente</a></li>';
							echo '<li><a class="nav-link" href="php/logout.inc.php">Logout</a></li>';
					}else if(checkActiveSuper()){
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaSuperutente.php')
							echo '<li><a class="nav-link" href="areaSuperutente.php">Area Utente</a></li>';
							echo '<li><a class="nav-link" href="php/logout.inc.php">Logout</a></li>';
					}else{
						echo '<li><a class="nav-link" id="login-button" href="login.php">Login</a></li>';
						echo '<li><a class="nav-link" href="signup.php">Registrati</a></li>';
					}
					?>
					</ul>
				</div>
			</div>
		</nav>