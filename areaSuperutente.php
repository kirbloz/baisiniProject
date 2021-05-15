<?php
        @include('php/header.php');
        if(!checkActiveSuper())
            header('location:superlogin.php?error=nosession'); //session
            //l'unico controllo viene fatto sulla sessione. perchè se la sessione è valida
            //vuol dire che è stato effettuato un login nei 59 minuti precedenti, e quindi
            //posso richiedere le informazioni dell'utente senza problemi
        @include('php/function.inc.php');
        $utente = generateSuperuserOBJ(session_id());
?>	

    <div class="wrapper user-area">
        <br>

        <div class='color-lightb user-nav'>
            <ul>
                <li><a href="superuserShowcase.php?matricola=self">Visualizza le tue informazioni</a></li>
                <li><a href="superuserfetch.php?select=users">Gestione utenti</a></li>
                <li><a href="superuserfetch.php?select=techs">Gestione dipendenti</a></li>
                <li><a href="superuserfetch.php?select=components">Gestione componenti</a></li>
            </ul>
        </div>

        <div class="user-data">
            <?php
                echo "Benvenuto " . $utente->getLastname() . ".\r\nQuesta &egrave; la tua area superutente.\r\nUsa i collegamenti a lato per accedere ai vari servizi"
            ?>
        </div>
        
    </div>
    
</body>
</html>