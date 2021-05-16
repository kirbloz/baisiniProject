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

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="/images/fav.ico"/>
</head>
<body>
	<div class="color-white bg-div">
		
		<div class="main-header color-lightb">
			<h1><a href="index.php">Easy LAN PORTAL</a></h1>
			<ul class="navlinks">
				<!--<li><a href="#">Info</a></li>-->
				
					<?php
					if(checkActive()){
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaUtente.php')
							echo '<li><a href="areaUtente.php">Area Utente</a></li>';
							echo '<li><a href="php/logout.inc.php">Logout</a></li>';
					}else if(checkActiveSuper()){
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaSuperutente.php')
							echo '<li><a href="areaSuperutente.php">Area Utente</a></li>';
							echo '<li><a href="php/logout.inc.php">Logout</a></li>';
					}else{
						echo '<li><a id="login-button" href="login.php">Login</a></li>';
						echo '<li><a href="signup.php">Registrati</a></li>';
					}
					?>
				
			</ul>
		</div>