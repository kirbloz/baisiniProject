<?php
        @include('php/header.php');
        if(!checkActive())
            header('location:login.php?error=nosession'); //session
        @include('php/function.inc.php');
        $utente = generateUserOBJ(session_id());  
        
?>	

    <div class="wrapper user-area">
        <br>

        <div class='color-lightb user-nav'>
            <ul>
                <li><a href="areaUtente.php">Torna indietro</a></li>
                <li><a href="assistenzaTicket.php">Richiedi assistenza</a></li>
                <li><a href="estimateGenerator.php">Richiedi un preventivo</a></li>
            </ul>
        </div>

        <div class="user-div">
            <?php
                echo "Benvenuto " . $utente->getUsername() . ".\r\nQueste sono le tue informazioni.\r\nUsa i collegamenti a lato per accedere ai vari servizi."
            ?>
        </div>
        <br><br>
        <div class="wrapper user-info">
        <?php
            if($utente->setCustomer() == false){
                echo "Username: " . $utente->getUsername();
                echo "<br>";
                echo "Email: " . $utente->getEmail();
                echo "<br>";
                echo "</div>";
                echo "Sembra che tu non sia ancora registrato come cliente. <a href='signupCustomer.php'>Puoi farlo qui.<a/>";
                
            }else{
                echo "Nome: " . $utente->getFirstname();
                echo "<br>";
                echo "Cognome: " . $utente->getLastname();
                echo "<br>";
                echo "Data di nascita: " . $utente->getBirth(); 
                echo "</div>";
            }
        ?>
    </div>
</body>