<?php
@include('php/header.php');
if (!checkActiveSuper())
    header('location:superlogin.php?error=nosession'); //session
@include('php/function.inc.php');
$utente = generateSuperuserOBJ(session_id());
?>

<div class="wrapper user-area row">
    <br>

    <div class='color-lightb user-nav'>
        <ul>
            <li><a href="superuserShowcase.php?matricola=self">Visualizza le tue informazioni</a></li>
            <li><a href="superuserfetch.php?select=users">Gestione utenti</a></li>
            <li><a href="superuserfetch.php?select=techs">Gestione dipendenti</a></li>
            <li><a href="superuserfetch.php?select=components">Gestione componenti</a></li>
            <li><a href="superuserfetch.php?select=works">Gestione interventi</a></li>
            <li><a href="superuserfetch.php?select=tickets">Gestione ticket</a></li>
        </ul>
    </div>

    <div class="user-div">
        <?php
        echo "Benvenuto " . $utente->getLastname() . ".\r\nQuesta &egrave; la tua area superutente.\r\nUsa i collegamenti a lato per accedere ai vari servizi."
        ?>
    </div>

</div>

</body>

</html>