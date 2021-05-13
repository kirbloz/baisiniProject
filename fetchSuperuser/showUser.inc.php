<?php 
/*
preparo questa pagina a sostituire userShowcase o superUserShowcase 
o almeno in parte perchè così faccio include e basta

forse
*/

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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
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
							echo '<li><a href="php/logout.inc.php?isUser=true">Logout</a></li>';
					}else if(checkActiveSuper()){
						if($_SERVER['REQUEST_URI'] != '/baisiniProject/areaSuperutente.php')
							echo '<li><a href="areaSuperutente.php">Area Utente</a></li>';
							echo '<li><a href="php/logout.inc.php?isUser=false">Logout</a></li>';
					}else{
						echo '<li><a id="login-button" href="login.php">Login</a></li>';
						echo '<li><a href="signup.php">Registrati</a></li>';
					}
					?>
				
			</ul>
		</div>
<?php
    if(!checkActiveSuper())
        header('location:../superlogin.php?error=nosession'); //session
    @include_once('../php/function.inc.php');
    $utente = generateSuperuserOBJ(session_id());
?>

    <div class="wrapper user-area">

        <div class='color-lightb user-nav'>
            <ul>
                <li><?php
                if(isset($_GET['matricola']))
                    echo "<a href='fetchTechs.inc.php'>Torna indietro</a>";
                else if(isset($_GET['idUser']))
                    echo "<a href='fetchTechs.inc.php'>Torna indietro</a>";
                else 
                    echo "<a href='../areaSuperutente.inc.php'>Qui non c'&egrave; niente.</a>";
                ?></li>
            </ul>
        </div>

<?php
    echo "<br><br>";
    echo "superuser loggato: " . $utente->getLastname();
    echo "<br><br>";

    var_dump($_GET);
    echo "<br><br>";

    if(isset($_GET['matricola'])){
        $query = "SELECT id_superuser, superuser.id_technician, password, email, firstname, lastname, gender, birth_date, id_supervisor, labor_hourly, id_office, power FROM superuser INNER JOIN technician USING(id_technician) WHERE superuser.id_technician = :matricola;";
        $values[':matricola'] = $_GET['matricola'];

        global $connection;
        $statement = $connection->prepare($query);
        
        try{
            $statement->execute($values);
            
        }catch(PDOException $e){
            //header('location:../superlogin.php?error=queryfailed');
            echo $e;
            //die();
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);
        else
            echo "error";
        var_dump($statement);

        /*
            aggiungere query per visualizzare i lavori del tecnico
            i suoi sottoposti
            il suo superiore
            la sua paga
            varie ed eventuali
        */
    }
    else if(isset($_GET['idUser'])){
        //preparo la query per la ricerca e l'array per i valori
        $query = "SELECT * FROM user LEFT JOIN customer USING(id_user) WHERE id_user = :iduser;";
        $values[':iduser'] = $_GET['idUser'];
        var_dump($values);

        global $connection;
        $statement = $connection->prepare($query);
        //se query multiple prepara prima e poi fai nel for con i rispetti values
        try{
            $statement->execute($values);
        }catch(PDOException $e){
            //header('location:../signup.php?error=queryfailed');
            //die();
            echo $e;
        }


        if($statement->rowCount() > 0)
            $statement=$statement->fetch(PDO::FETCH_ASSOC);  
        else
            echo "error";
        var_dump($statement);
        /*
            aggiungere query per visualizzare i lavori relativi alla persona
            i suoi ticket
            i suoi preventivi
            varie ed eventuali
        */
    }
    

    

    