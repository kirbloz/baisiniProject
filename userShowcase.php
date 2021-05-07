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

    </div>
    <br><br>

    <div class="wrapper user-info">
        <?php
            if($utente->setCustomer() == false){
                echo "<h4>Username</h4> <p> " . $utente->getUsername() . "</p>";
                echo "<br>";
                echo "<h4>Email</h4> <p> " . $utente->getEmail() . "</p>";
                echo "<br>";
                echo "Sembra che tu non sia ancora registrato come cliente. <a href='signupCustomer.php'>Puoi farlo qui.<a/>";

            }else{
                echo "<h4>Nome</h4> <p> " . $utente->getFirstname(). "</p>";
                echo "<br>";
                echo "<h4>Cognome</h4> <p> " . $utente->getLastname(). "</p>";
                echo "<br>";
                echo "<h4>Data di nascita</h4> <p> " . $utente->getBirth(). "</p>";
                echo "<br>";
                if($utente->getGender() == "M")
                    $temp = "Uomo";
                else if ($utente->getGender() == "F")
                    $temp = "Donna";
                else
                    $temp = "Non specificato";
                echo "<h4>Genere</h4> <p> " . $temp . "</p>";
                echo "<br>";
                echo "<h4>Indirizzo</h4> <p> " . $utente->getAddress(). "</p>";
                echo "<br>";
                echo "<h4>Città</h4> <p> " . $utente->getCity(). "</p>";
                echo "<br>";
                echo "<h4>CAP</h4> <p> " . $utente->getPostalCode(). "</p>";

            }
        ?>
    </div>

</body>