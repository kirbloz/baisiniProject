    <?php
        @include('php/header.php');
        if(!checkActive())
            header('location:login.php?error=nosession'); //session
            //l'unico controllo viene fatto sulla sessione. perchè se la sessione è valida
            //vuol dire che è stato effettuato un login nei 59 minuti precedenti, e quindi
            //posso richiedere le informazioni dell'utente senza problemi
        @include('php/function.inc.php');
        $utente = generateUserOBJ(session_id());
    ?>	

    <div class="container wrapper user-area row">
        <br>

        <div class='color-lightb user-nav'>
            <ul>
                <li><a href="userShowcase.php">Visualizza le tue informazioni</a></li>
                <li><a href="assistenzaTicket.php">Richiedi assistenza</a></li>
            </ul>
        </div>

        <div class="user-data ">
            <?php
                echo "Benvenuto " . $utente->getUsername() . ".\r\nQuesta &egrave; la tua area utente.\r\nUsa i collegamenti a lato per accedere ai vari servizi"
            ?>
        </div>
        
    </div>
    
</body>
</html>