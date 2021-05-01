<?php
@include_once('session.inc.php');
if(!function_exists(checkActive()))
	@include_once('php/session.inc.php');
if(!function_exists(checkActive()))
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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="/images/fav.ico"/>
</head>
<body>
	<div class="color-white bg-div">
		
		<div class="main-header color-lightb">
			<h1><a href="index.php">Easy LAN PORTAL</a></h1>
			<ul class="navlinks">
				<li><a href="#">Info</a></li>
				
					<?php
					if(!checkActive()){
						echo '<li><a id="login-button" href="login.php">Login</a></li>';
						echo '<li><a href="signup.php">Registrati</a></li>';
					}else{
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaUtente.php')
							echo '<li><a href="areaUtente.php">Area Utente</a></li>';
						echo '<li><a href="php/logout.inc.php">Logout</a></li>';
					}
					?>
				
			</ul>
		</div>